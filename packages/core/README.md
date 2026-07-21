# Laravel CMS Core

Pages, posts, categories, tags, comments, revisions, SEO metadata, i18n and sitemap generation. Backend-only: models, migrations, config — no routes, controllers or API.

## Installation

```bash
composer require jeffersongoncalves/laravel-cms-core
php artisan vendor:publish --tag="cms-core-config"
php artisan migrate
```

## Content models

- `Page` — hierarchical (`parent_id`), translatable `title`/`slug`/`body`, `draft`/`published` status.
- `Post` — translatable `title`/`slug`/`excerpt`/`body`, `draft`/`published`/`scheduled` status, optional `author_id`.

Both use `Categorizable`, `Taggable`, `HasComments`, `HasRevisions` and `HasSeo` concerns.

## Taxonomy

`Category` (hierarchical) and `Tag` attach to any model via the `Categorizable` / `Taggable` traits (polymorphic pivot tables).

## Comments

`Comment` is polymorphic (`commentable`) and threaded (`parent_id`), with `pending`/`approved`/`spam` status.

## Revisions

`HasRevisions` snapshots the previous state of `revisionable()` fields (defaults to `$fillable`) before every update. Restore with:

```php
$post->restoreRevision($revisionId);
```

## SEO

`HasSeo` exposes a polymorphic `seo` relation (`Seo` model: translatable `meta_title`/`meta_description`, `meta_image`, `canonical_url`):

```php
$post->fillSeo(['meta_title' => ['en' => 'Custom title']]);
```

## i18n

Translatable fields are powered by `spatie/laravel-translatable`. Configure available locales in `config/cms-core.php`.

## Sitemap

```bash
php artisan cms:generate-sitemap
```

Writes `sitemap.xml` from published pages/posts, using the URL resolvers configured in `config('cms-core.sitemap.resolvers')` — override these from the host application once routes exist.
