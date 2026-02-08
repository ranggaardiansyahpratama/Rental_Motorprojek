<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Motor extends Model
{
    protected $fillable = [
        'owner_id',
        'brand',
        'type',
        'license_plate',
        'color',
        'year',
        'engine_capacity',
        'description',
        'photo',
        'documents',
        'rental_price',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'status',
        'admin_notes',
        'verified_at',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'documents' => 'array',
            'verified_at' => 'datetime',
            'rental_price' => 'decimal:2',
        ];
    }

    // Relationships
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    // Helper methods
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified' || $this->status === 'available';
    }

    public function currentRental()
    {
        return $this->rentals()->whereIn('status', ['confirmed', 'active'])->first();
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending_verification' => 'bg-yellow-100 text-yellow-800',
            'verified' => 'bg-green-100 text-green-800',
            'available' => 'bg-blue-100 text-blue-800',
            'rented' => 'bg-red-100 text-red-800',
            'maintenance' => 'bg-gray-100 text-gray-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}
