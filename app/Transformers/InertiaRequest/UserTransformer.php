<?php

declare(strict_types=1);


namespace App\Transformers\InertiaRequest;

use App\Models\User;

class UserTransformer
{
    /**
     * @param User|null $user
     * @return array|array{email: string, firstName: string, id: int, lastName: string, phoneNumber: string}
     */
    public function transform(?User $user): array
    {
        if (!$user) {
            return [];
        }

        return [
            'id' => $user->id,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'phoneNumber' => $user->phone_number,
        ];
    }
}
