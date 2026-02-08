<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\RevenueShare;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $rentals = Rental::with(['motor', 'renter', 'payments'])->latest()->paginate(10);
        } elseif ($user->isOwner()) {
            $rentals = Rental::whereHas('motor', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['motor', 'renter', 'payments'])->latest()->paginate(10);
        } else {
            $rentals = Rental::where('renter_id', $user->id)->with(['motor', 'payments'])->latest()->paginate(10);
        }

        return view('rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load(['motor.owner', 'renter', 'payments', 'confirmedBy', 'returnConfirmedBy']);
        
        // Check authorization
        $user = auth()->user();
        if (!$user->isAdmin() && $rental->renter_id !== $user->id && $rental->motor->owner_id !== $user->id) {
            abort(403);
        }

        return view('rentals.show', compact('rental'));
    }

    public function create(Motor $motor)
    {
        if (!$motor->isAvailable()) {
            return redirect()->back()->with('error', 'Motor tidak tersedia untuk disewa.');
        }

        return view('rentals.create', compact('motor'));
    }

    public function store(Request $request, Motor $motor)
    {
        if (!$motor->isAvailable()) {
            return redirect()->back()->with('error', 'Motor tidak tersedia untuk disewa.');
        }

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'duration_days' => 'required|integer|min:1|max:365',
            'notes' => 'nullable|string',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addDays($validated['duration_days'] - 1);
        
        // Calculate total amount based on packages
        $days = $validated['duration_days'];
        $dailyPrice = $motor->daily_rate ?? $motor->rental_price;
        
        if ($days >= 30) {
            $totalAmount = $motor->monthly_rate ?? ($dailyPrice * $days);
        } elseif ($days >= 7) {
            $totalAmount = $motor->weekly_rate ?? ($dailyPrice * $days);
        } else {
            $totalAmount = $dailyPrice * $days;
        }

        $securityDeposit = $dailyPrice * 0.5; // 50% dari harga harian sebagai jaminan

        $rental = Rental::create([
            'motor_id' => $motor->id,
            'renter_id' => auth()->id(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $days,
            'daily_price' => $dailyPrice,
            'total_amount' => $totalAmount,
            'security_deposit' => $securityDeposit,
            'notes' => $validated['notes'],
        ]);

        // Create payment record
        Payment::create([
            'rental_id' => $rental->id,
            'amount' => $totalAmount + $securityDeposit,
            'payment_method' => 'transfer',
        ]);

        return redirect()->route('renter.rentals.show', $rental)
            ->with('success', 'Pemesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function confirm(Request $request, Rental $rental)
    {
        $this->authorize('confirm', $rental);
        
        $validated = $request->validate([
            'action' => 'required|in:confirm,reject',
            'notes' => 'nullable|string',
        ]);

        if ($validated['action'] === 'confirm') {
            $rental->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => auth()->id(),
                'notes' => $validated['notes'],
            ]);

            // Update motor status to rented
            $rental->motor->update(['status' => 'rented']);

            // Update rental status to active if start date is today
            if ($rental->start_date->isToday()) {
                $rental->update(['status' => 'active']);
            }

            $message = 'Penyewaan berhasil dikonfirmasi.';
        } else {
            $rental->update([
                'status' => 'cancelled',
                'notes' => $validated['notes'],
            ]);
            $message = 'Penyewaan ditolak.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function returnMotor(Request $request, Rental $rental)
    {
        $this->authorize('return', $rental);
        
        $validated = $request->validate([
            'return_notes' => 'nullable|string',
            'penalty_amount' => 'nullable|numeric|min:0',
        ]);

        $rental->update([
            'status' => 'completed',
            'returned_at' => now(),
            'returned_confirmed_by' => auth()->id(),
            'return_notes' => $validated['return_notes'],
            'penalty_amount' => $validated['penalty_amount'] ?? 0,
        ]);

        // Update motor status back to available
        $rental->motor->update(['status' => 'available']);

        // Create or update revenue share record
        $totalRevenue = $rental->total_amount + ($validated['penalty_amount'] ?? 0);
        $shareData = RevenueShare::calculateShare($totalRevenue);
        
        RevenueShare::updateOrCreate(
            ['rental_id' => $rental->id],
            array_merge([
                'owner_id' => $rental->motor->owner_id,
            ], $shareData)
        );

        return redirect()->back()
            ->with('success', 'Motor berhasil dikembalikan dan pendapatan telah dicatat.');
    }

    public function cancel(Rental $rental)
    {
        // Only renter can cancel before payment confirmation
        if ($rental->renter_id !== auth()->id() || $rental->status !== 'pending_payment') {
            abort(403);
        }

        $rental->update(['status' => 'cancelled']);
        
        return redirect()->route('renter.rentals.index')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    public function complete(Rental $rental)
    {
        $user = auth()->user();
        
        // Only admin or motor owner can complete rental
        if (!$user->isAdmin() && $rental->motor->owner_id !== $user->id) {
            abort(403, 'Unauthorized to complete this rental.');
        }

        // Can only complete active rentals
        if ($rental->status !== 'active') {
            return redirect()->back()
                ->with('error', 'Hanya penyewaan yang sedang aktif yang bisa diselesaikan.');
        }

        $rental->update([
            'status' => 'completed',
            'return_confirmed_at' => now(),
            'return_confirmed_by' => $user->id,
        ]);

        // Update motor status back to available
        $rental->motor->update(['status' => 'available']);

        return redirect()->route($user->role . '.rentals.index')
            ->with('success', 'Penyewaan berhasil diselesaikan. Motor kembali tersedia untuk disewakan.');
    }
}
