<?php

use JeffersonGoncalves\Cms\Models\Category;
use JeffersonGoncalves\Cms\Models\Tag;

it('builds a category hierarchy', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create(['parent_id' => $parent->id]);

    expect($parent->children)->toHaveCount(1)
        ->and($child->parent->id)->toBe($parent->id);
});

it('stores translatable tag names', function () {
    $tag = Tag::factory()->create([
        'name' => ['en' => 'Laravel', 'pt' => 'Laravel'],
        'slug' => ['en' => 'laravel', 'pt' => 'laravel'],
    ]);

    expect($tag->fresh()->getTranslation('name', 'en'))->toBe('Laravel');
});
