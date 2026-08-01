<?php

namespace JeffersonGoncalves\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JeffersonGoncalves\Cms\Models\Menu;

/** @extends Factory<Menu> */
class MenuFactory extends Factory
{
    protected $model = Menu::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'location' => fake()->randomElement(['header', 'footer', 'sidebar']),
        ];
    }
}
