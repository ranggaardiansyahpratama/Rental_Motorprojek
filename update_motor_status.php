<?php
// Update motor status to available for testing

require_once 'vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Motor;

echo "🔄 Updating Motor Status for Testing...\n\n";

// Update all motors to available
$motors = Motor::where('status', 'pending_verification')->get();
foreach ($motors as $motor) {
    $motor->status = 'available';
    $motor->save();
    
    echo "✅ Updated Motor ID {$motor->id} ({$motor->brand} {$motor->type}) to 'available' status\n";
    echo "Photo: {$motor->photo}\n";
}

if ($motors->count() == 0) {
    echo "❌ No motors with pending_verification status found\n";
}