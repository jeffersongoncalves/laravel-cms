<?php

use JeffersonGoncalves\Cms\Models\Post;

it('fills and reads seo metadata through the polymorphic relation', function () {
    $post = Post::factory()->create();

    $post->fillSeo([
        'meta_title' => ['en' => 'Custom title'],
        'meta_description' => ['en' => 'Custom description'],
        'canonical_url' => 'https://example.com/post',
    ]);

    expect($post->seo->meta_title)->toBe('Custom title')
        ->and($post->seo->canonical_url)->toBe('https://example.com/post');
});
