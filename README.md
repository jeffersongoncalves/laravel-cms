<div class="filament-hidden">

![Laravel CMS](https://raw.githubusercontent.com/jeffersongoncalves/laravel-cms/main/art/jeffersongoncalves-laravel-cms.png)

</div>

# Laravel CMS

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-cms.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-cms)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-cms/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-cms/actions?query=workflow%3Atests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-cms/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-cms/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-cms.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-cms)

Laravel CMS — pages, posts, categories, tags, comments, revisions, SEO metadata, media library and navigation menus.

Backend-only: Eloquent models, migrations, config and contracts. No routes/controllers/API — the admin UI is provided by the separate [`filament-cms`](https://github.com/jeffersongoncalves/filament-cms) package.

## Features

- 📄 Pages and posts with categories and tags
- 💬 Comments with moderation
- 🕓 Content revisions
- 🔍 SEO metadata per model
- 🖼️ Media library integration ([`spatie/laravel-medialibrary`](https://github.com/spatie/laravel-medialibrary))
- 🧭 Navigation menus and menu items
- 🗺️ Sitemap generation command
- 🌐 Translatable content ([`spatie/laravel-translatable`](https://github.com/spatie/laravel-translatable))
- 🧩 Swap any model via config, bound through contracts

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-cms
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="cms-migrations"
php artisan migrate
```

Optionally publish the config files:

```bash
php artisan vendor:publish --tag="cms-config"
```

This publishes `config/cms-core.php`, `config/cms-media.php` and `config/cms-menu.php`, where you can override the model bindings used by each contract (`PageContract`, `PostContract`, `CategoryContract`, `TagContract`, `CommentContract`, `RevisionContract`, `SeoContract`, `MenuContract`, `MenuItemContract`).

## Usage

```php
use JeffersonGoncalves\Cms\Models\Page;
use JeffersonGoncalves\Cms\Models\Post;

$page = Page::create([
    'title' => ['en' => 'About us'],
    'slug' => 'about-us',
    'content' => ['en' => '...'],
]);

$post = Post::create([
    'title' => ['en' => 'Hello world'],
    'slug' => 'hello-world',
    'content' => ['en' => '...'],
]);
```

### Sitemap

Generate the sitemap with the bundled Artisan command:

```bash
php artisan cms:generate-sitemap
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jèfferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
