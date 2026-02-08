<?php
// Check motors and their photos

require_once 'vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Motor;

echo "🔍 Checking Motors and Photos...\n\n";

$motors = Motor::all();
echo "Total Motors: " . $motors->count() . "\n\n";

foreach ($motors as $motor) {
    echo "Motor ID: {$motor->id}\n";
    echo "Brand: {$motor->brand}\n";
    echo "Type: {$motor->type}\n";
    echo "Photo: " . ($motor->photo ?? 'NO PHOTO') . "\n";
    echo "Status: {$motor->status}\n";
    echo "Owner ID: {$motor->owner_id}\n";
    echo "---\n";
}

// Check storage directories
$photoDir = storage_path('app/public/motors/photos');
$docDir = storage_path('app/public/motors/documents');

echo "\nStorage Directories:\n";
echo "Photos: " . ($photoDir) . " - Exists: " . (is_dir($photoDir) ? 'YES' : 'NO') . "\n";
echo "Docs: " . ($docDir) . " - Exists: " . (is_dir($docDir) ? 'YES' : 'NO') . "\n";

// Check public storage link
$publicStorage = public_path('storage');
echo "Public Storage Link: " . $publicStorage . " - Exists: " . (file_exists($publicStorage) ? 'YES' : 'NO') . "\n";

if (is_dir($photoDir)) {
    $files = scandir($photoDir);
    echo "\nFiles in photos directory: " . count($files) - 2 . " files\n"; // -2 for . and ..
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "- $file\n";
        }
    }
}