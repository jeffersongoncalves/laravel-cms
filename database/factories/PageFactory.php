<?php

namespace JeffersonGoncalves\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JeffersonGoncalves\Cms\Enums\PageStatus;
use JeffersonGoncalves\Cms\Models\Page;

/** @extends Factory<Page> */
class PageFactory extends Factory
{
    protected $model = Page::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'parent_id' => null,
            'title' => ['en' => $title],
            'slug' => ['en' => Str::slug($title)],
            'body' => ['en' => fake()->paragraphs(3, true)],
            'status' => PageStatus::Draft,
            'order' => 0,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => PageStatus::Published,
            'published_at' => now(),
        ]);
    }
}
