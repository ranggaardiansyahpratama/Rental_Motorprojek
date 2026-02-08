<?php

namespace App\Policies;

use App\Models\Motor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MotorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All users can view motors
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Motor $motor): bool
    {
        // Admin can view all, owners can view their own, renters can view available motors
        return $user->isAdmin() || 
               $motor->owner_id === $user->id || 
               ($user->isRenter() && $motor->isAvailable());
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isOwner();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Motor $motor): bool
    {
        // Only motor owner can update, and only if not currently rented
        return $user->id === $motor->owner_id && $motor->status !== 'rented';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Motor $motor): bool
    {
        // Only motor owner can delete, and only if not currently rented
        return $user->id === $motor->owner_id && $motor->status !== 'rented';
    }

    /**
     * Determine whether the user can verify the model.
     */
    public function verify(User $user, Motor $motor): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Motor $motor): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Motor $motor): bool
    {
        return $user->isAdmin();
    }
}
