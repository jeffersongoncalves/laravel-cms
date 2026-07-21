<?php

namespace JeffersonGoncalves\Cms\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JeffersonGoncalves\Cms\Core\Enums\PostStatus;
use JeffersonGoncalves\Cms\Core\Models\Post;

/** @extends Factory<Post> */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'author_id' => null,
            'title' => ['en' => $title],
            'slug' => ['en' => Str::slug($title)],
            'excerpt' => ['en' => fake()->sentence()],
            'body' => ['en' => fake()->paragraphs(5, true)],
            'status' => PostStatus::Draft,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => PostStatus::Published,
            'published_at' => now(),
        ]);
    }
}
