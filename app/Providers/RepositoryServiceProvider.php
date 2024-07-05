<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Eloquent\ReservationRepository;
use App\Repositories\ReservationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
