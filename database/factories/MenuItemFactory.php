<?php

namespace JeffersonGoncalves\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JeffersonGoncalves\Cms\Models\Menu;
use JeffersonGoncalves\Cms\Models\MenuItem;

/** @extends Factory<MenuItem> */
class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'menu_id' => Menu::factory(),
            'parent_id' => null,
            'label' => ['en' => fake()->unique()->words(2, true)],
            'url' => fake()->url(),
            'target' => '_self',
            'order' => 0,
        ];
    }
}
