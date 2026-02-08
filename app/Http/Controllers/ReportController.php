<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\RevenueShare;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Dashboard Analytics
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isOwner()) {
            return $this->ownerDashboard();
        } else {
            return $this->renterDashboard();
        }
    }

    private function adminDashboard()
    {
        // Grafik penyewaan per periode (bulanan)
        $rentalChart = Rental::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Total statistics
        $totalMotors = Motor::count();
        $totalRentals = Rental::count();
        $totalRevenue = Payment::where('status', 'confirmed')->sum('amount');
        $activeRentals = Rental::where('status', 'active')->count();

        // Monthly data
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = [
                'rentals' => $rentalChart->where('month', $i)->first()->count ?? 0,
                'revenue' => Payment::whereMonth('created_at', $i)
                    ->whereYear('created_at', date('Y'))
                    ->where('status', 'confirmed')
                    ->sum('amount') ?? 0
            ];
        }

        return view('reports.admin', compact(
            'totalMotors', 'totalRentals', 'totalRevenue', 'activeRentals', 'monthlyData'
        ));
    }

    private function ownerDashboard()
    {
        $ownerId = auth()->id();
        
        $totalMotors = Motor::where('owner_id', $ownerId)->count();
        $totalRevenue = RevenueShare::where('owner_id', $ownerId)
            ->where('status', 'paid')
            ->sum('owner_share');
        $activeRentals = Rental::whereHas('motor', function($q) use ($ownerId) {
            $q->where('owner_id', $ownerId);
        })->where('status', 'active')->count();

        return view('reports.owner', compact('totalMotors', 'totalRevenue', 'activeRentals'));
    }

    private function renterDashboard()
    {
        $renterId = auth()->id();
        
        $totalRentals = Rental::where('renter_id', $renterId)->count();
        $totalSpent = Payment::whereHas('rental', function($q) use ($renterId) {
            $q->where('renter_id', $renterId);
        })->where('status', 'confirmed')->sum('amount');
        $activeRentals = Rental::where('renter_id', $renterId)->where('status', 'active')->count();

        return view('reports.renter', compact('totalRentals', 'totalSpent', 'activeRentals'));
    }

    // Generate Riwayat Penyewaan
    public function rentalHistory(Request $request)
    {
        $query = Rental::with(['motor', 'renter', 'payments']);
        
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $rentals = $query->latest()->paginate(20);
        
        return view('reports.rental-history', compact('rentals'));
    }

    // Generate Daftar Motor Terdaftar
    public function registeredMotors(Request $request)
    {
        $query = Motor::with('owner');
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->owner_id) {
            $query->where('owner_id', $request->owner_id);
        }

        $motors = $query->latest()->paginate(20);
        $owners = User::where('role', 'owner')->get();
        
        return view('reports.registered-motors', compact('motors', 'owners'));
    }

    // Generate Daftar Motor Disewa
    public function rentedMotors(Request $request)
    {
        $query = Motor::whereHas('rentals', function($q) {
            $q->where('status', 'active');
        })->with(['owner', 'rentals' => function($q) {
            $q->where('status', 'active')->with('renter');
        }]);

        $motors = $query->latest()->paginate(20);
        
        return view('reports.rented-motors', compact('motors'));
    }

    // Generate Total Pendapatan
    public function totalRevenue(Request $request)
    {
        $query = Payment::where('status', 'confirmed');
        
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        $payments = $query->with(['rental.motor', 'rental.renter'])->latest()->paginate(20);
        
        $totalRevenue = $payments->sum('amount');
        $platformCommission = $totalRevenue * 0.1; // 10% commission
        $ownerShare = $totalRevenue - $platformCommission;
        
        return view('reports.total-revenue', compact('payments', 'totalRevenue', 'platformCommission', 'ownerShare'));
    }

    // Generate Laporan Pembayaran
    public function paymentReport(Request $request)
    {
        $query = Payment::with(['rental.motor', 'rental.renter']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $payments = $query->latest()->paginate(20);
        
        $stats = [
            'total_payments' => $query->sum('amount'),
            'confirmed_payments' => Payment::where('status', 'confirmed')->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->sum('amount'),
        ];
        
        return view('reports.payment-report', compact('payments', 'stats'));
    }

    // Lihat Histori Bagi Hasil
    public function revenueSharing(Request $request)
    {
        $query = RevenueShare::with(['owner', 'rental.motor']);
        
        if ($request->owner_id) {
            $query->where('owner_id', $request->owner_id);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $revenueShares = $query->latest()->paginate(20);
        $owners = User::where('role', 'owner')->get();
        
        return view('reports.revenue-sharing', compact('revenueShares', 'owners'));
    }

    // Grafik Penyewaan Per Periode
    public function rentalChart(Request $request)
    {
        $period = $request->get('period', 'monthly'); // daily, monthly, yearly
        $year = $request->get('year', date('Y'));
        
        if ($period === 'monthly') {
            $data = Rental::selectRaw('MONTH(created_at) as period, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        } elseif ($period === 'daily') {
            $month = $request->get('month', date('n'));
            $data = Rental::selectRaw('DAY(created_at) as period, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        } else {
            $data = Rental::selectRaw('YEAR(created_at) as period, COUNT(*) as count')
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        }
        
        return view('reports.rental-chart', compact('data', 'period', 'year'));
    }

    // Export functions
    public function exportRentalHistory(Request $request)
    {
        // Implementation for exporting rental history to Excel/PDF
        // This would use libraries like PhpSpreadsheet or DomPDF
        return response()->json(['message' => 'Export functionality coming soon']);
    }

    public function exportPaymentReport(Request $request)
    {
        // Implementation for exporting payment report
        return response()->json(['message' => 'Export functionality coming soon']);
    }

    // OWNER REPORTS -----------------------------------------

    public function ownerRentedMotors(Request $request)
    {
        $ownerId = auth()->id();
        $query = Motor::where('owner_id', $ownerId)
            ->whereHas('rentals', function($q) {
                $q->where('status', 'active');
            })->with(['rentals' => function($q) {
                $q->where('status', 'active')->with('renter');
            }]);

        $motors = $query->latest()->paginate(20);
        return view('owner.reports.rented-motors', compact('motors'));
    }

    public function ownerRevenue(Request $request)
    {
        $ownerId = auth()->id();
        $query = RevenueShare::where('owner_id', $ownerId)
            ->with(['rental.motor'])
            ->latest();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        $revenueShares = $query->paginate(20);
        $totalRevenue = $revenueShares->sum('owner_share');

        return view('owner.reports.revenue', compact('revenueShares', 'totalRevenue'));
    }

    // RENTER REPORTS ----------------------------------------

    public function renterHistory(Request $request)
    {
        $renterId = auth()->id();
        $query = Rental::where('renter_id', $renterId)
            ->with(['motor.owner', 'payments'])
            ->latest();
        
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $rentals = $query->paginate(20);
        return view('renter.reports.history', compact('rentals'));
    }
}
