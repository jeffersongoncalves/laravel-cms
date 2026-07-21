# Laravel CMS Media

Media library integration for the Laravel CMS ecosystem — thin wrapper around `spatie/laravel-medialibrary` with config-driven collections and conversions.

## Installation

```bash
composer require jeffersongoncalves/laravel-cms-media
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
php artisan vendor:publish --tag="cms-media-config"
php artisan migrate
```

## Usage

```php
use JeffersonGoncalves\Cms\Media\Concerns\HasCmsMedia;
use Spatie\MediaLibrary\HasMedia;

class Post extends Model implements HasMedia
{
    use HasCmsMedia;
}

$post->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
```

Collections and their `thumb` conversion are configured in `config/cms-media.php` — `featured_image` (single file) and `gallery` (multiple) ship by default.
