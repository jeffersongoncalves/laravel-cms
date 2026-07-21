<?php

use JeffersonGoncalves\Cms\Core\Enums\PostStatus;
use JeffersonGoncalves\Cms\Core\Models\Category;
use JeffersonGoncalves\Cms\Core\Models\Post;
use JeffersonGoncalves\Cms\Core\Models\Tag;

it('scopes published posts', function () {
    Post::factory()->create(['status' => PostStatus::Draft]);
    Post::factory()->published()->create();

    expect(Post::published()->count())->toBe(1);
});

it('attaches categories and tags', function () {
    $post = Post::factory()->create();
    $category = Category::factory()->create();
    $tag = Tag::factory()->create();

    $post->categories()->attach($category);
    $post->tags()->attach($tag);

    expect($post->categories()->count())->toBe(1)
        ->and($post->tags()->count())->toBe(1);
});
