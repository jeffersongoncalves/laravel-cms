<?php

namespace JeffersonGoncalves\Cms\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JeffersonGoncalves\Cms\Core\Models\Tag;

/** @extends Factory<Tag> */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name' => ['en' => $name],
            'slug' => ['en' => Str::slug($name)],
        ];
    }
}
