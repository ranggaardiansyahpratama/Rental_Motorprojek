<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@rentmotor.com'],
            [
                'name' => 'Admin RentMotor',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Kantor Pusat RentMotor',
            ]
        );

        // Create multiple owners for realistic distribution
        $owners = [
            [
                'email' => 'budi.motor@gmail.com',
                'name' => 'Budi Pratama',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 123, Jakarta Selatan',
            ],
            [
                'email' => 'andi.rental@gmail.com',
                'name' => 'Andi Setiawan',
                'phone' => '081345678901',
                'address' => 'Jl. Gatot Subroto No. 45, Jakarta Pusat',
            ],
            [
                'email' => 'siska.motor@gmail.com',
                'name' => 'Siska Wulandari',
                'phone' => '081456789012',
                'address' => 'Jl. HR Rasuna Said No. 78, Jakarta Selatan',
            ],
            [
                'email' => 'dedi.garage@gmail.com',
                'name' => 'Dedi Kurniawan',
                'phone' => '081567890123',
                'address' => 'Jl. Kuningan No. 90, Jakarta Selatan',
            ],
            [
                'email' => 'maya.rental@gmail.com',
                'name' => 'Maya Indah Sari',
                'phone' => '081678901234',
                'address' => 'Jl. Casablanca No. 12, Jakarta Selatan',
            ],
        ];

        foreach ($owners as $owner) {
            User::updateOrCreate(
                ['email' => $owner['email']],
                [
                    'name' => $owner['name'],
                    'password' => Hash::make('password'),
                    'role' => 'owner',
                    'phone' => $owner['phone'],
                    'address' => $owner['address'],
                ]
            );
        }

        // Create multiple renters
        $renters = [
            [
                'email' => 'sari.mahasiswa@gmail.com',
                'name' => 'Sari Dewi',
                'phone' => '081234567892',
                'address' => 'Jl. Pemuda No. 456, Jakarta Timur',
            ],
            [
                'email' => 'riko.karyawan@gmail.com',
                'name' => 'Riko Prasetyo',
                'phone' => '081345678902',
                'address' => 'Jl. Pahlawan No. 67, Jakarta Barat',
            ],
            [
                'email' => 'lina.freelance@gmail.com',
                'name' => 'Lina Kartika',
                'phone' => '081456789013',
                'address' => 'Jl. Merdeka No. 89, Jakarta Utara',
            ],
        ];

        foreach ($renters as $renter) {
            User::updateOrCreate(
                ['email' => $renter['email']],
                [
                    'name' => $renter['name'],
                    'password' => Hash::make('password'),
                    'role' => 'renter',
                    'phone' => $renter['phone'],
                    'address' => $renter['address'],
                ]
            );
        }

        echo "✅ Sample users created successfully!\n";
    }
}
