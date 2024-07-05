<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use App\Transformers\InertiaRequest\UserTransformer;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{

    public function __construct(
        private readonly UserTransformer $userTransformer,
    ) {
    }
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        if (!$user instanceof User) {
            $user = null;
        }

        return [
            ...parent::share($request),
            'auth' => [
                'isAuth' => $user !== null,
                'user' => $this->userTransformer->transform($user),
            ],
            'flash' => [
                'alert' => $request->session()->get('alert'),
            ],
        ];
    }
}
