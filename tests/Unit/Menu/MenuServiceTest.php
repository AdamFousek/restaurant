<?php

namespace Tests\Unit\Menu;

use App\Services\MenuService;
use Tests\TestCase;

class MenuServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $menuService = new MenuService();

        $menuData = $menuService->provideForWeek();

        $this->assertIsArray($menuData);
        $this->assertCount(7, $menuData);

        $day = array_pop($menuData);
        $this->assertArrayHasKey('menu', $day);
        $this->assertArrayHasKey('date', $day);
        $this->assertArrayHasKey('dayName', $day);
    }
}
