# Laravel CMS

![Laravel CMS](https://raw.githubusercontent.com/jeffersongoncalves/laravel-cms/main/art/jeffersongoncalves-laravel-cms.png)

Umbrella meta-package bundling the full Laravel CMS ecosystem: `laravel-cms-core`, `laravel-cms-media`, `laravel-cms-menu`.

```bash
composer require jeffersongoncalves/laravel-cms
php artisan vendor:publish --tag="cms-core-config"
php artisan vendor:publish --tag="cms-media-config"
php artisan vendor:publish --tag="cms-menu-config"
php artisan migrate
```

See each component package's README for details. Admin UI is provided separately by `filament-cms`.
