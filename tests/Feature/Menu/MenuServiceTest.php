<?php

namespace Tests\Feature\Menu;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class MenuServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_menu_service(): void
    {
        $carbon = new Carbon();
        $response = $this->get(route('menu'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Menu/Index')
                ->has('menu')
                ->has('menu.0', fn (Assert $item) => $item
                    ->where('date', $carbon->format('j.n.Y'))
                    ->where('dayName', $carbon->dayName)
                    ->has('menu', fn (Assert $item) => $item
                        ->has('soup', fn (Assert $item) => $item
                            ->has('name')
                            ->has('content')
                            ->has('price')
                        )
                        ->has('main', fn (Assert $item) => $item
                            ->has('name')
                            ->has('content')
                            ->has('price')
                        )
                    )
                    ->has('date')
                    ->has('dayName')
                )
            );

        $response->assertStatus(200);
    }
}
