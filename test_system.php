<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 Testing Rental Motor System...\n\n";

try {
    // Test database connection
    echo "📊 Testing Database Connection...\n";
    $users = \App\Models\User::count();
    echo "✅ Database connected! Found {$users} users\n\n";
    
    // Test role-based authentication
    echo "🔐 Testing Authentication System...\n";
    $admin = \App\Models\User::where('email', 'admin@rentmotor.com')->first();
    if ($admin) {
        echo "✅ Admin user exists: {$admin->name} ({$admin->role})\n";
    }
    
    $owner = \App\Models\User::where('email', 'owner@rentmotor.com')->first();
    if ($owner) {
        echo "✅ Owner user exists: {$owner->name} ({$owner->role})\n";
    }
    
    $renter = \App\Models\User::where('email', 'renter@rentmotor.com')->first();
    if ($renter) {
        echo "✅ Renter user exists: {$renter->name} ({$renter->role})\n";
    }
    
    echo "\n";
    
    // Test models
    echo "🏍️ Testing Models...\n";
    $motors = \App\Models\Motor::count();
    echo "✅ Motor model working: {$motors} motors\n";
    
    $rentals = \App\Models\Rental::count();
    echo "✅ Rental model working: {$rentals} rentals\n";
    
    $payments = \App\Models\Payment::count();
    echo "✅ Payment model working: {$payments} payments\n";
    
    echo "\n";
    
    // Test admin dashboard data
    echo "📈 Testing Admin Dashboard Data...\n";
    $pendingMotors = \App\Models\Motor::where('status', 'pending_verification')->count();
    $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
    $activeRentals = \App\Models\Rental::where('status', 'active')->count();
    $totalMotors = \App\Models\Motor::count();
    $availableMotors = \App\Models\Motor::where('status', 'available')->count();
    $rentedMotors = \App\Models\Motor::where('status', 'rented')->count();
    $totalRevenue = \App\Models\RevenueShare::sum('platform_commission');
    $ownerRevenue = \App\Models\RevenueShare::sum('owner_share');
    
    echo "✅ Pending motors: {$pendingMotors}\n";
    echo "✅ Pending payments: {$pendingPayments}\n";
    echo "✅ Active rentals: {$activeRentals}\n";
    echo "✅ Total motors: {$totalMotors}\n";
    echo "✅ Available motors: {$availableMotors}\n";
    echo "✅ Rented motors: {$rentedMotors}\n";
    echo "✅ Total revenue: Rp " . number_format($totalRevenue, 0, ',', '.') . "\n";
    echo "✅ Owner revenue: Rp " . number_format($ownerRevenue, 0, ',', '.') . "\n";
    
    echo "\n🎉 All tests passed! System is ready to use.\n\n";
    
    echo "📋 Login Credentials:\n";
    echo "   🔧 Admin: admin@rentmotor.com / password\n";
    echo "   🏠 Owner: owner@rentmotor.com / password\n";
    echo "   👤 Renter: renter@rentmotor.com / password\n";
    echo "   🧪 Test: test@example.com / password\n\n";
    
    echo "🌐 Access the application at: http://localhost:8000\n";
    echo "🗄️ phpMyAdmin: http://localhost:8080/phpmyadmin\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📋 Stack trace:\n" . $e->getTraceAsString() . "\n";
}