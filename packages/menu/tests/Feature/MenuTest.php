<?php

use JeffersonGoncalves\Cms\Menu\Models\Menu;

it('orders root items and nests children', function () {
    $menu = Menu::factory()->create();

    $second = $menu->items()->create([
        'label' => ['en' => 'Second'],
        'url' => '/second',
        'order' => 2,
    ]);
    $first = $menu->items()->create([
        'label' => ['en' => 'First'],
        'url' => '/first',
        'order' => 1,
    ]);
    $child = $menu->items()->create([
        'label' => ['en' => 'Child'],
        'url' => '/first/child',
        'parent_id' => $first->id,
        'order' => 1,
    ]);

    expect($menu->rootItems()->pluck('id')->all())->toBe([$first->id, $second->id])
        ->and($first->children()->pluck('id')->all())->toBe([$child->id]);
});

it('links a menu item to any polymorphic model', function () {
    $menu = Menu::factory()->create();

    $item = $menu->items()->create([
        'label' => ['en' => 'Linked'],
        'linkable_type' => Menu::class,
        'linkable_id' => $menu->id,
        'order' => 0,
    ]);

    expect($item->linkable->is($menu))->toBeTrue();
});
