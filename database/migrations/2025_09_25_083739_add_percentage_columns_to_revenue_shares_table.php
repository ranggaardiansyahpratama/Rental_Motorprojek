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
        Schema::table('revenue_shares', function (Blueprint $table) {
            // Add columns for custom percentage split
            $table->decimal('owner_percentage', 5, 2)->default(70.00)->after('owner_id');
            $table->decimal('platform_percentage', 5, 2)->default(30.00)->after('owner_percentage');
            
            // Rename columns to match controller expectations
            $table->renameColumn('total_revenue', 'total_amount');
            $table->renameColumn('platform_commission', 'platform_amount');  
            $table->renameColumn('owner_share', 'owner_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revenue_shares', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn(['owner_percentage', 'platform_percentage']);
            
            // Rename columns back
            $table->renameColumn('total_amount', 'total_revenue');
            $table->renameColumn('platform_amount', 'platform_commission');
            $table->renameColumn('owner_amount', 'owner_share');
        });
    }
};
