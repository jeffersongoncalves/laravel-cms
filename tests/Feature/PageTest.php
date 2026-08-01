<?php

use JeffersonGoncalves\Cms\Enums\PageStatus;
use JeffersonGoncalves\Cms\Models\Page;

it('stores translatable fields', function () {
    $page = Page::factory()->create([
        'title' => ['en' => 'Home', 'pt' => 'Início'],
        'slug' => ['en' => 'home', 'pt' => 'inicio'],
    ]);

    app()->setLocale('pt');

    expect($page->fresh()->title)->toBe('Início');
});

it('builds a parent/child hierarchy', function () {
    $parent = Page::factory()->create();
    $child = Page::factory()->create(['parent_id' => $parent->id]);

    expect($parent->children)->toHaveCount(1)
        ->and($child->parent->id)->toBe($parent->id);
});

it('scopes published pages', function () {
    Page::factory()->create(['status' => PageStatus::Draft]);
    Page::factory()->published()->create();

    expect(Page::published()->count())->toBe(1);
});
