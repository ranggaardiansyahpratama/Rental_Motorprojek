<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Redirect langsung ke login jika belum authenticated
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    // Jika sudah login, redirect ke dashboard sesuai role
    $user = auth()->user();
    if ($user->isOwner()) {
        return redirect()->route('owner.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('renter.dashboard');
    }
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isOwner()) {
        return redirect()->route('owner.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('renter.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// Owner routes
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $motors = $user->ownedMotors()->latest()->limit(5)->get();
        $totalMotors = $user->ownedMotors()->count();
        $activeRentals = $user->ownedMotors()->whereHas('rentals', function($q) {
            $q->where('status', 'active');
        })->count();
        $totalRevenue = $user->revenueShares()->where('status', 'paid')->sum('owner_share');
        
        return view('dashboards.owner', compact('motors', 'totalMotors', 'activeRentals', 'totalRevenue'));
    })->name('dashboard');

    // Owner Resources
    Route::resource('motors', App\Http\Controllers\MotorController::class);
    Route::resource('rentals', App\Http\Controllers\RentalController::class)->only(['index', 'show', 'update']);
    Route::resource('payments', App\Http\Controllers\PaymentController::class)->only(['index', 'show']);

    // Owner Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/rented-motors', [App\Http\Controllers\ReportController::class, 'ownerRentedMotors'])->name('rented-motors');
        Route::get('/revenue', [App\Http\Controllers\ReportController::class, 'ownerRevenue'])->name('revenue');
    });
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $pendingMotors = \App\Models\Motor::where('status', 'pending_verification')->count();
        $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
        $activeRentals = \App\Models\Rental::where('status', 'active')->count();
        
        // Data motor
        $totalMotors = \App\Models\Motor::count();
        $availableMotors = \App\Models\Motor::where('status', 'available')->count();
        $rentedMotors = \App\Models\Motor::where('status', 'rented')->count();
        
        // Revenue data
        $totalRevenue = \App\Models\RevenueShare::sum('platform_commission');
        $ownerRevenue = \App\Models\RevenueShare::sum('owner_share');
        $adminRevenue = $totalRevenue; // Platform commission is admin revenue
        
        return view('dashboards.admin', compact(
            'pendingMotors', 'pendingPayments', 'activeRentals', 'totalRevenue',
            'totalMotors', 'availableMotors', 'rentedMotors', 'ownerRevenue', 'adminRevenue'
        ));
    })->name('dashboard');
    
    // User Management CRUD
    Route::resource('users', App\Http\Controllers\UserController::class);

    // Admin Resources
    Route::resource('motors', App\Http\Controllers\MotorController::class);
    Route::post('/motors/{motor}/verify', [App\Http\Controllers\MotorController::class, 'verify'])->name('motors.verify');
    Route::get('/motors/export', [App\Http\Controllers\MotorController::class, 'export'])->name('motors.export');

    Route::resource('rentals', App\Http\Controllers\RentalController::class);
    Route::patch('/rentals/{rental}/complete', [App\Http\Controllers\RentalController::class, 'complete'])->name('rentals.complete');
    
    Route::resource('payments', App\Http\Controllers\PaymentController::class);
    Route::post('/payments/mark-revenue-paid', [App\Http\Controllers\PaymentController::class, 'markRevenuePaid'])->name('payments.mark-revenue-paid');
    
    // Reports
    Route::name('reports.')->group(function () {
        Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('index');
        Route::get('/reports/rental-history', [App\Http\Controllers\ReportController::class, 'rentalHistory'])->name('rental-history');
        Route::get('/reports/registered-motors', [App\Http\Controllers\ReportController::class, 'registeredMotors'])->name('registered-motors');
        Route::get('/reports/rented-motors', [App\Http\Controllers\ReportController::class, 'rentedMotors'])->name('rented-motors');
        Route::get('/reports/total-revenue', [App\Http\Controllers\ReportController::class, 'totalRevenue'])->name('total-revenue');
        Route::get('/reports/payment-report', [App\Http\Controllers\ReportController::class, 'paymentReport'])->name('payment-report');
        Route::get('/reports/revenue-sharing', [App\Http\Controllers\ReportController::class, 'revenueSharing'])->name('revenue-sharing');
        Route::get('/reports/rental-chart', [App\Http\Controllers\ReportController::class, 'rentalChart'])->name('rental-chart');
        Route::get('/reports/export/rental-history', [App\Http\Controllers\ReportController::class, 'exportRentalHistory'])->name('export.rental-history');
        Route::get('/reports/export/payment-report', [App\Http\Controllers\ReportController::class, 'exportPaymentReport'])->name('export.payment-report');
    });
});

// Renter routes
Route::middleware(['auth', 'role:renter'])->prefix('renter')->name('renter.')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $availableMotors = \App\Models\Motor::where('status', 'available')->latest()->limit(6)->get();
        $myRentals = $user->rentals()->with(['motor', 'payments'])->latest()->limit(5)->get();
        $activeRentals = $user->rentals()->where('status', 'active')->count();
        
        // Laporan untuk penyewa
        $totalRentals = $user->rentals()->count();
        $completedRentals = $user->rentals()->where('status', 'completed')->count();
        $totalSpent = $user->rentals()->whereIn('status', ['completed', 'active'])->sum('total_amount');
        $pendingPayments = $user->rentals()->whereHas('payments', function($q) {
            $q->where('status', 'pending');
        })->count();
        
        // Statistik bulanan
        $currentMonth = now()->month;
        $monthlyRentals = $user->rentals()->whereMonth('created_at', $currentMonth)->count();
        $monthlySpent = $user->rentals()->whereMonth('created_at', $currentMonth)
            ->whereIn('status', ['completed', 'active'])->sum('total_amount');
        
        return view('dashboards.renter', compact(
            'availableMotors', 'myRentals', 'activeRentals', 'totalRentals', 
            'completedRentals', 'totalSpent', 'pendingPayments', 'monthlyRentals', 'monthlySpent'
        ));
    })->name('dashboard');

    // Renter Resources
    Route::get('/motors', [App\Http\Controllers\MotorController::class, 'index'])->name('motors.index');
    Route::get('/motors/{motor}', [App\Http\Controllers\MotorController::class, 'show'])->name('motors.show');
    
    // Rental Process
    Route::get('/motors/{motor}/rent', [App\Http\Controllers\RentalController::class, 'create'])->name('rentals.create');
    Route::post('/motors/{motor}/rent', [App\Http\Controllers\RentalController::class, 'store'])->name('rentals.store');
    
    Route::resource('rentals', App\Http\Controllers\RentalController::class)->only(['index', 'show']);
    Route::post('/rentals/{rental}/cancel', [App\Http\Controllers\RentalController::class, 'cancel'])->name('rentals.cancel');
    Route::post('/rentals/{rental}/return', [App\Http\Controllers\RentalController::class, 'returnMotor'])->name('rentals.return');
    
    Route::resource('payments', App\Http\Controllers\PaymentController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::put('/payments/{payment}/update-payment', [App\Http\Controllers\PaymentController::class, 'updatePayment'])->name('payments.update-payment');
    Route::get('/payments/{payment}/receipt', [App\Http\Controllers\PaymentController::class, 'receipt'])->name('payments.receipt');

    // Renter Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/history', [App\Http\Controllers\ReportController::class, 'renterHistory'])->name('history');
    });
});

// Shared routes helper for redirects
Route::middleware('auth')->group(function() {
    // These might be needed if form actions use non-prefixed routes, but we should update views to use named routes
    // For now, we rely on named routes being strictly separated
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // Standard login route (defaults to renter or redirected if needed)
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    // Separated login routes
    Route::get('login/admin', [AuthenticatedSessionController::class, 'createAdmin'])
                ->name('login.admin');
    Route::get('login/owner', [AuthenticatedSessionController::class, 'createOwner'])
                ->name('login.owner');
    Route::get('login/renter', [AuthenticatedSessionController::class, 'createRenter'])
                ->name('login.renter');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Credentials info page - accessible by anyone
Route::get('credentials', function () {
    return view('credentials');
})->name('credentials');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
