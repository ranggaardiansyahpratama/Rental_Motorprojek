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
        Schema::create('revenue_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained()->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_revenue', 10, 2); // Total pendapatan dari rental
            $table->decimal('platform_commission_rate', 5, 2)->default(10.00); // Persentase komisi platform (default 10%)
            $table->decimal('platform_commission', 10, 2); // Nominal komisi platform
            $table->decimal('owner_share', 10, 2); // Bagian untuk pemilik motor
            $table->enum('status', ['pending', 'paid', 'disputed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_shares');
    }
};
