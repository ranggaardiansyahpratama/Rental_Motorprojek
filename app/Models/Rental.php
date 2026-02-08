<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Model
{
    protected $fillable = [
        'motor_id',
        'renter_id',
        'start_date',
        'end_date',
        'duration_days',
        'daily_price',
        'total_amount',
        'security_deposit',
        'status',
        'notes',
        'confirmed_at',
        'confirmed_by',
        'returned_at',
        'returned_confirmed_by',
        'return_notes',
        'penalty_amount',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'confirmed_at' => 'datetime',
            'returned_at' => 'datetime',
            'daily_price' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'security_deposit' => 'decimal:2',
            'penalty_amount' => 'decimal:2',
        ];
    }

    // Relationships
    public function motor(): BelongsTo
    {
        return $this->belongsTo(Motor::class);
    }

    public function renter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function returnConfirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_confirmed_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function revenueShare(): HasOne
    {
        return $this->hasOne(RevenueShare::class);
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending_payment' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-blue-100 text-blue-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'active' => 'bg-indigo-100 text-indigo-800',
            'completed' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getDaysRemainingAttribute(): int
    {
        if (!$this->isActive()) {
            return 0;
        }
        
        return max(0, $this->end_date->diffInDays(now(), false));
    }

    public function calculateTotalWithPenalty(): float
    {
        return $this->total_amount + $this->penalty_amount;
    }
}
