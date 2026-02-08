<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RevenueShare extends Model
{
    protected $fillable = [
        'rental_id',
        'owner_id',
        'total_amount',
        'owner_percentage',
        'platform_percentage', 
        'platform_commission_rate',
        'platform_amount',
        'owner_amount',
        'status',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'owner_percentage' => 'decimal:2',
            'platform_percentage' => 'decimal:2',
            'platform_commission_rate' => 'decimal:2',
            'platform_amount' => 'decimal:2',
            'owner_amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    // Relationships
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Helper methods
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'disputed' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    // Static method untuk menghitung revenue share
    public static function calculateShare(float $totalRevenue, float $platformRate = 30.0, float $ownerRate = 70.0): array
    {
        $platformAmount = ($totalRevenue * $platformRate) / 100;
        $ownerAmount = ($totalRevenue * $ownerRate) / 100;

        return [
            'total_amount' => $totalRevenue,
            'platform_commission_rate' => $platformRate,
            'platform_percentage' => $platformRate,
            'owner_percentage' => $ownerRate,
            'platform_amount' => $platformAmount,
            'owner_amount' => $ownerAmount,
        ];
    }
}
