<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        // do not update reservation in same day
        if (!$reservation->reservation_datetime->diffInDays(new Carbon())) {
            return false;
        }

        return $reservation->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        return $reservation->user_id === $user->id;
    }
}
