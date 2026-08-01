<?php

use JeffersonGoncalves\Cms\Enums\PostStatus;
use JeffersonGoncalves\Cms\Models\Category;
use JeffersonGoncalves\Cms\Models\Post;
use JeffersonGoncalves\Cms\Models\Tag;

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
