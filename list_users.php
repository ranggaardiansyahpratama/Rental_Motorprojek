<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "📋 Current Users in Database:\n\n";

// Get all users grouped by role
$admin = User::where('role', 'admin')->get();
$owners = User::where('role', 'owner')->get();
$renters = User::where('role', 'renter')->get();

echo "👑 ADMIN (" . $admin->count() . "):\n";
foreach ($admin as $user) {
    echo "  ✓ {$user->email} - {$user->name}\n";
}

echo "\n👤 OWNERS (" . $owners->count() . "):\n";
foreach ($owners as $user) {
    echo "  ✓ {$user->email} - {$user->name}\n";
}

echo "\n🏍️ RENTERS (" . $renters->count() . "):\n";
foreach ($renters as $user) {
    echo "  ✓ {$user->email} - {$user->name}\n";
}

echo "\n✅ Total users: " . User::count() . "\n";
echo "🔐 All passwords are set to: password\n";
