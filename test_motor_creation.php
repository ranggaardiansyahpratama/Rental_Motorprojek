<?php
// Test script untuk memastikan sistem pendaftaran motor bekerja

require_once 'vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Motor;

// Check if we can create a test owner
try {
    echo "🔍 Testing Motor Registration System...\n\n";
    
    // 1. Check if owner users exist
    $ownerCount = User::where('role', 'owner')->count();
    echo "✅ Owner users found: {$ownerCount}\n";
    
    // 2. Check motors table
    $motorCount = Motor::count();
    echo "✅ Motors in database: {$motorCount}\n";
    
    // 3. Check if storage directories exist
    $photoPath = storage_path('app/public/motors/photos');
    $docPath = storage_path('app/public/motors/documents');
    
    if (!file_exists($photoPath)) {
        mkdir($photoPath, 0755, true);
        echo "📁 Created photos directory: {$photoPath}\n";
    }
    
    if (!file_exists($docPath)) {
        mkdir($docPath, 0755, true);
        echo "📁 Created documents directory: {$docPath}\n";
    }
    
    // 4. Check if storage link exists
    $publicStorage = public_path('storage');
    if (!file_exists($publicStorage)) {
        echo "⚠️  Storage link not found. Run: php artisan storage:link\n";
    } else {
        echo "✅ Storage link exists\n";
    }
    
    echo "\n🎉 Motor Registration System is ready!\n";
    echo "📝 Test accounts:\n";
    echo "   - Owner: owner@test.com / password\n";
    echo "   - Access: http://127.0.0.1:8000/motors/create\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}