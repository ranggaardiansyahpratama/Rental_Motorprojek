<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'rental_id',
        'amount',
        'payment_method',
        'status',
        'payment_proof',
        'admin_notes',
        'paid_at',
        'confirmed_at',
        'confirmed_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    // Relationships
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    // Helper methods
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPaymentMethodTextAttribute(): string
    {
        $methods = [
            'cash' => 'Tunai',
            'transfer' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }
}
