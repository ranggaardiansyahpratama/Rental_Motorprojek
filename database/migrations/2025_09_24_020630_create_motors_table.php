<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('motors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('brand'); // Merk
            $table->string('type'); // Jenis
            $table->string('license_plate')->unique(); // Nomor Polisi
            $table->string('color');
            $table->year('year');
            $table->text('description')->nullable();
            $table->string('photo')->nullable(); // Path foto motor
            $table->json('documents')->nullable(); // Array dokumen (STNK, dll)
            $table->decimal('rental_price', 10, 2)->nullable(); // Default price (daily rate)
            $table->decimal('daily_rate', 10, 2)->nullable(); // Harga sewa per hari
            $table->decimal('weekly_rate', 10, 2)->nullable(); // Harga sewa per minggu
            $table->decimal('monthly_rate', 10, 2)->nullable(); // Harga sewa per bulan
            $table->enum('status', ['pending_verification', 'verified', 'available', 'rented', 'maintenance', 'rejected'])->default('pending_verification');
            $table->text('admin_notes')->nullable(); // Catatan admin untuk verifikasi
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users'); // Admin yang verifikasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
