<?php
// Check existing users
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "🔍 Checking existing users:\n\n";

$users = User::all(['email', 'role', 'name']);

if ($users->count() > 0) {
    foreach ($users as $user) {
        echo "📧 {$user->email} | {$user->name} | Role: {$user->role}\n";
    }
    
    echo "\n✅ Found " . $users->count() . " users in database\n";
    echo "\n🔐 Test login credentials:\n";
    echo "   Admin: admin@rentmotor.com / password\n";
    echo "   Owner: owner@rentmotor.com / password\n";
    echo "   Renter: renter@rentmotor.com / password\n";
} else {
    echo "❌ No users found in database!\n";
}