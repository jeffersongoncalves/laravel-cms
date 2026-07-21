# Laravel CMS Monorepo

Development monorepo (source-of-truth, not published) for the Laravel CMS ecosystem.

Backend-only: models, migrations, config, contracts. No routes/controllers/API — admin UI is provided by the separate `filament-cms` package.

## Packages

| Package | Split repo | Description |
|---|---|---|
| `packages/core` | `jeffersongoncalves/laravel-cms-core` | Pages, Posts, Categories, Tags, Comments, Revisions, SEO metadata, i18n, sitemap generation |
| `packages/media` | `jeffersongoncalves/laravel-cms-media` | Media library integration (wraps `spatie/laravel-medialibrary`) |
| `packages/menu` | `jeffersongoncalves/laravel-cms-menu` | Navigation menus and menu items |
| `packages/suite` | `jeffersongoncalves/laravel-cms-suite` (package `jeffersongoncalves/laravel-cms`) | Umbrella bundling core + media + menu |

## Development

```bash
composer install
vendor/bin/pest
vendor/bin/phpstan analyse
vendor/bin/pint
```

Each package is split read-only into its own repository on push to `main` via `.github/workflows/split.yml`.
