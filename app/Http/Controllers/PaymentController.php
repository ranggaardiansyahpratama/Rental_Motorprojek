<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\RevenueShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Payment::with(['rental.motor', 'rental.renter']);
        
        // Filter berdasarkan role
        if ($user->isAdmin()) {
            // Admin bisa lihat semua pembayaran
        } elseif ($user->isOwner()) {
            // Owner bisa lihat pembayaran motor miliknya
            $query->whereHas('rental.motor', function($q) use ($user) {
                $q->where('owner_id', $user->id);
            });
        } else {
            // Renter hanya bisa lihat pembayaran sendiri
            $query->whereHas('rental', function($q) use ($user) {
                $q->where('renter_id', $user->id);
            });
        }

        // Filter berdasarkan status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $payments = $query->latest()->paginate(10);
        
        // Statistics untuk admin
        $stats = null;
        if ($user->isAdmin()) {
            $stats = [
                'total_payments' => Payment::sum('amount'),
                'confirmed_payments' => Payment::where('status', 'confirmed')->sum('amount'),
                'pending_payments' => Payment::where('status', 'pending')->count(),
                'rejected_payments' => Payment::where('status', 'rejected')->count(),
            ];
        }

        return view('payments.index', compact('payments', 'stats'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['rental.motor', 'rental.renter', 'confirmedBy']);
        
        // Check authorization
        $user = auth()->user();
        if (!$user->isAdmin() && $payment->rental->renter_id !== $user->id) {
            abort(403);
        }

        return view('payments.show', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        // Only renter can update their own payment (upload proof)
        if ($payment->rental->renter_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'payment_method' => 'required|in:cash,transfer,e_wallet',
        ]);

        // Upload payment proof
        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($payment->payment_proof) {
                Storage::disk('public')->delete($payment->payment_proof);
            }
            
            $validated['payment_proof'] = $request->file('payment_proof')->store('payments/proofs', 'public');
        }

        $payment->update([
            'payment_proof' => $validated['payment_proof'],
            'payment_method' => $validated['payment_method'],
            'paid_at' => now(),
            'status' => 'pending', // Menunggu konfirmasi admin
        ]);

        // Update rental status
        $payment->rental->update(['status' => 'paid']);

        return redirect()->route('renter.payments.show', $payment)
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }

    public function confirm(Request $request, Payment $payment)
    {
        // Only admin can confirm payments
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'action' => 'required|in:confirm,reject',
            'admin_notes' => 'nullable|string',
        ]);

        if ($validated['action'] === 'confirm') {
            $payment->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => auth()->id(),
                'admin_notes' => $validated['admin_notes'],
            ]);

            // Update rental status to confirmed
            $payment->rental->update(['status' => 'confirmed']);
            
            // Create revenue share record automatically upon payment confirmation
            $this->createRevenueShare($payment);

            $message = 'Pembayaran berhasil dikonfirmasi.';
        } else {
            $payment->update([
                'status' => 'rejected',
                'admin_notes' => $validated['admin_notes'],
            ]);

            // Update rental status back to pending payment
            $payment->rental->update(['status' => 'pending_payment']);

            $message = 'Pembayaran ditolak. Penyewa perlu upload ulang bukti pembayaran.';
        }

        return redirect()->back()->with('success', $message);
    }

    // Create new payment entry (for admin)
    public function create(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admin can create payment entries');
        }

        // Get unpaid rentals that are either confirmed or pending payment
        $unpaidRentals = Rental::with(['motor', 'renter'])
            ->whereIn('status', ['confirmed', 'pending_payment'])
            ->whereDoesntHave('payments', function($q) {
                $q->where('status', 'confirmed');
            })
            ->get();

        return view('payments.create', compact('unpaidRentals'));
    }

    // Store new payment entry
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admin can create payment entries');
        }

        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|in:cash',  // Only cash allowed
            'transaction_id' => 'nullable|string|max:100',
            'payment_notes' => 'nullable|string|max:500',
            'status' => 'required|in:pending,confirmed',
            'owner_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $rental = Rental::findOrFail($validated['rental_id']);

        // Generate transaction ID if not provided
        $transactionId = $validated['transaction_id'] ?: 'CASH-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Create payment record
        $payment = Payment::create([
            'rental_id' => $validated['rental_id'],
            'amount' => $validated['amount'],
            'payment_method' => 'cash',  // Force cash payment
            'transaction_id' => $transactionId,
            'paid_at' => now(),
            'status' => $validated['status'],
            'payment_notes' => $validated['payment_notes'],
            'confirmed_by' => auth()->id(),
            'confirmed_at' => $validated['status'] === 'confirmed' ? now() : null,
        ]);

        // If payment is confirmed, create revenue sharing with custom percentage
        if ($validated['status'] === 'confirmed') {
            $this->createCustomRevenueShare($payment, $validated['owner_percentage']);
            
            // Update rental status
            $rental->update(['status' => 'active']);
        }

        // Check if user wants to see receipt
        if ($request->action === 'save_and_receipt') {
            return redirect()->route('admin.payments.receipt', $payment)
                ->with('success', 'Pembayaran tunai berhasil diproses! Struk telah disiapkan.');
        }

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Entri pembayaran tunai berhasil dibuat.');
    }

    // Edit payment entry (admin only)
    public function edit(Payment $payment)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admin can edit payments');
        }

        $payment->load(['rental.motor', 'rental.renter']);
        return view('payments.edit', compact('payment'));
    }

    // Update payment entry
    public function updatePayment(Request $request, Payment $payment)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admin can update payments');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,e_wallet,other',
            'payment_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:pending,confirmed,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $payment->status;
        
        $payment->update([
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'paid_at' => $validated['payment_date'],
            'status' => $validated['status'],
            'description' => $validated['description'],
            'admin_notes' => $validated['admin_notes'],
            'confirmed_by' => $validated['status'] === 'confirmed' ? auth()->id() : $payment->confirmed_by,
            'confirmed_at' => $validated['status'] === 'confirmed' ? now() : ($oldStatus === 'confirmed' ? $payment->confirmed_at : null),
        ]);

        // Handle revenue sharing
        if ($oldStatus !== 'confirmed' && $validated['status'] === 'confirmed') {
            $this->createRevenueShare($payment);
            $payment->rental->update(['status' => 'active']);
        } elseif ($oldStatus === 'confirmed' && $validated['status'] !== 'confirmed') {
            // Remove revenue share if payment no longer confirmed
            RevenueShare::where('rental_id', $payment->rental_id)->delete();
            $payment->rental->update(['status' => 'pending_payment']);
        }

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Pembayaran berhasil diupdate.');
    }

    // Delete payment entry (admin only)
    public function destroy(Payment $payment)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admin can delete payments');
        }

        // Remove associated revenue share
        RevenueShare::where('rental_id', $payment->rental_id)->delete();

        // Delete payment proof file if exists
        if ($payment->payment_proof) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Entri pembayaran berhasil dihapus.');
    }

    // Private method to create revenue sharing
    private function createRevenueShare(Payment $payment)
    {
        $rental = $payment->rental;
        $motor = $rental->motor;
        
        $shareData = RevenueShare::calculateShare($payment->amount);

        RevenueShare::updateOrCreate(
            ['rental_id' => $rental->id],
            array_merge([
                'owner_id' => $motor->owner_id,
                'status' => 'pending',
                'created_at' => now(),
            ], $shareData)
        );
    }

    // Private method to create custom revenue sharing
    private function createCustomRevenueShare(Payment $payment, $ownerPercentage)
    {
        $rental = $payment->rental;
        $motor = $rental->motor;
        
        $totalAmount = $payment->amount;
        $ownerPercentage = floatval($ownerPercentage);
        $platformPercentage = 100 - $ownerPercentage;
        
        $ownerShare = $totalAmount * ($ownerPercentage / 100);
        $platformCommission = $totalAmount * ($platformPercentage / 100);

        RevenueShare::updateOrCreate(
            ['rental_id' => $rental->id],
            [
                'owner_id' => $motor->owner_id,
                'total_amount' => $totalAmount,
                'owner_percentage' => $ownerPercentage,
                'platform_percentage' => $platformPercentage,
                'owner_amount' => $ownerShare,
                'platform_amount' => $platformCommission,
                'status' => 'pending', // Need to be paid to owner
                'created_at' => now(),
            ]
        );
    }

    // Show payment receipt
    public function receipt(Payment $payment)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admin can view receipts');
        }

        $payment->load(['rental.motor.owner', 'rental.renter']);
        
        // Get revenue share if exists
        $revenueShare = RevenueShare::where('rental_id', $payment->rental_id)->first();

        return view('payments.receipt', compact('payment', 'revenueShare'));
    }

    // Mark revenue as paid to owner
    public function markRevenuePaid(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admin can mark revenue as paid');
        }

        $validated = $request->validate([
            'revenue_share_ids' => 'required|array',
            'revenue_share_ids.*' => 'exists:revenue_shares,id',
        ]);

        RevenueShare::whereIn('id', $validated['revenue_share_ids'])
            ->update([
                'status' => 'paid',
                'paid_at' => now(),
                'paid_by' => auth()->id(),
            ]);

        return redirect()->back()
            ->with('success', 'Bagi hasil berhasil ditandai sebagai telah dibayar.');
    }
}
