# Laravel CMS Menu

Navigation menus and menu items — hierarchical, translatable labels, optionally linked to any polymorphic model. Backend-only: models, migrations, config.

## Installation

```bash
composer require jeffersongoncalves/laravel-cms-menu
php artisan vendor:publish --tag="cms-menu-config"
php artisan migrate
```

## Usage

```php
$menu = Menu::create(['name' => 'Header', 'slug' => 'header', 'location' => 'header']);

$menu->items()->create([
    'label' => ['en' => 'Blog'],
    'linkable_type' => Post::class,
    'linkable_id' => $post->id,
    'order' => 0,
]);

$menu->rootItems; // top-level items, ordered, each with ->children
```

`url` is a plain fallback; `linkable` is a polymorphic relation to any model (e.g. a CMS `Page` or `Post`) — the host application resolves the final link.
