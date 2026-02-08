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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motor_id')->constrained()->onDelete('cascade');
            $table->foreignId('renter_id')->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_days');
            $table->decimal('daily_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->enum('status', ['pending_payment', 'paid', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending_payment');
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users'); // Admin yang konfirmasi
            $table->timestamp('returned_at')->nullable();
            $table->foreignId('returned_confirmed_by')->nullable()->constrained('users'); // Admin yang konfirmasi pengembalian
            $table->text('return_notes')->nullable(); // Kondisi motor saat dikembalikan
            $table->decimal('penalty_amount', 10, 2)->default(0); // Denda jika ada kerusakan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
