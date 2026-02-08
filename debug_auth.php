<?php
// Debug login process
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "🔐 Testing authentication process...\n\n";

// Test user credentials
$testCredentials = [
    ['email' => 'admin@rentmotor.com', 'password' => 'password'],
    ['email' => 'renter@rentmotor.com', 'password' => 'password'],
];

foreach ($testCredentials as $cred) {
    echo "Testing {$cred['email']}:\n";
    
    $user = User::where('email', $cred['email'])->first();
    
    if ($user) {
        echo "  ✅ User found: {$user->name} (Role: {$user->role})\n";
        
        // Test password
        if (Hash::check($cred['password'], $user->password)) {
            echo "  ✅ Password correct\n";
            
            // Test role-based redirect
            switch ($user->role) {
                case 'admin':
                    echo "  ➡️  Should redirect to: /admin/dashboard\n";
                    break;
                case 'owner':
                    echo "  ➡️  Should redirect to: /owner/dashboard\n";
                    break;
                case 'renter':
                    echo "  ➡️  Should redirect to: /renter/dashboard\n";
                    break;
                default:
                    echo "  ❌ Unknown role: {$user->role}\n";
            }
        } else {
            echo "  ❌ Password incorrect\n";
        }
    } else {
        echo "  ❌ User not found\n";
    }
    
    echo "\n";
}

echo "🌐 Laravel should be accessible at: http://localhost:8000\n";
echo "📧 Login page: http://localhost:8000/login\n";
echo "📝 Register page: http://localhost:8000/register\n";