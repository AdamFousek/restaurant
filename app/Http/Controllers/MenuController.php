<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\MenuService;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function __construct(
        private readonly MenuService $menuService,
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(): Response
    {
        $menu = $this->menuService->provideForWeek();

        return Inertia::render('Menu/Index', [
            'menu' => $menu,
        ]);
    }
}
