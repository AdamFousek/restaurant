<?php

declare(strict_types=1);


namespace Tests\Traits;

use App\Models\User;

trait CreateUserTrait
{
    public function createUser(): User
    {
        return User::factory(1)->create()->first();
    }
}
