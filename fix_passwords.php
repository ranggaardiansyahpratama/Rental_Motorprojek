<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

echo "🔧 Fixing user passwords...\n\n";

// Get all users
$users = User::all();

if ($users->count() === 0) {
    echo "❌ No users found in database.\n";
    echo "📝 Run: php artisan db:seed\n";
    exit(1);
}

echo "Found {$users->count()} users\n\n";

$fixed = 0;
$skipped = 0;

foreach ($users as $user) {
    // Check if password is already hashed (starts with $2y$ for bcrypt)
    if (str_starts_with($user->password, '$2y$') || str_starts_with($user->password, '$2a$')) {
        echo "✅ {$user->email} - already hashed\n";
        $skipped++;
        continue;
    }
    
    // Hash the password (assuming it's "password" or the plain text value)
    $newPassword = Hash::make('password');
    
    // Update directly in database to avoid model events
    DB::table('users')
        ->where('id', $user->id)
        ->update(['password' => $newPassword]);
    
    echo "🔨 {$user->email} - password fixed\n";
    $fixed++;
}

echo "\n✅ Done!\n";
echo "Fixed: $fixed users\n";
echo "Skipped: $skipped users (already hashed)\n";
echo "\nAll user passwords are now set to: password\n";
