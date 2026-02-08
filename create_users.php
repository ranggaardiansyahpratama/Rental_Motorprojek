<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Create admin user
User::create([
    'name' => 'Admin RentMotor',
    'email' => 'admin@rentmotor.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'phone' => '081234567890',
    'address' => 'Kantor Pusat RentMotor',
]);

// Create sample owner
User::create([
    'name' => 'Budi Pemilik Motor',
    'email' => 'budi@example.com',
    'password' => Hash::make('password'),
    'role' => 'owner',
    'phone' => '081234567891',
    'address' => 'Jl. Contoh No. 123, Jakarta',
]);

// Create sample renter
User::create([
    'name' => 'Sari Penyewa',
    'email' => 'sari@example.com',
    'password' => Hash::make('password'),
    'role' => 'renter',
    'phone' => '081234567892',
    'address' => 'Jl. Contoh No. 456, Jakarta',
]);

echo "Sample users created successfully!\n";
echo "Admin: admin@rentmotor.com / password\n";
echo "Owner: budi@example.com / password\n";
echo "Renter: sari@example.com / password\n";