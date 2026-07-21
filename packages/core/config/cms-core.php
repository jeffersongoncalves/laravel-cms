<?php

use JeffersonGoncalves\Cms\Core\Models\Category;
use JeffersonGoncalves\Cms\Core\Models\Comment;
use JeffersonGoncalves\Cms\Core\Models\Page;
use JeffersonGoncalves\Cms\Core\Models\Post;
use JeffersonGoncalves\Cms\Core\Models\Revision;
use JeffersonGoncalves\Cms\Core\Models\Seo;
use JeffersonGoncalves\Cms\Core\Models\Tag;

return [
    /*
    |--------------------------------------------------------------------------
    | Table Prefix
    |--------------------------------------------------------------------------
    |
    | Prefix applied to all tables created by the package to avoid
    | collision with existing application tables.
    | Set to null to use table names without a prefix.
    |
    */
    'table_prefix' => 'cms_',

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Models used by the package. Can be overridden to extend the default
    | behavior. Custom models must implement the corresponding contract
    | interface (see src/Models/Contracts/).
    |
    */
    'models' => [
        'page' => Page::class,
        'post' => Post::class,
        'category' => Category::class,
        'tag' => Tag::class,
        'comment' => Comment::class,
        'revision' => Revision::class,
        'seo' => Seo::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | Locales available for translatable content fields (title, body, excerpt,
    | slug, seo meta). The first locale is used as the fallback when a
    | translation is missing.
    |
    */
    'locales' => ['en'],

    /*
    |--------------------------------------------------------------------------
    | Sitemap
    |--------------------------------------------------------------------------
    |
    | Output path for the generated sitemap.xml and, per model key, a
    | resolver that turns a model into its public absolute URL. Override
    | the resolvers from the host application once routes exist.
    |
    */
    'sitemap' => [
        'path' => public_path('sitemap.xml'),
        'resolvers' => [
            'page' => fn (Page $page) => url('/'.ltrim($page->slug, '/')),
            'post' => fn (Post $post) => url('/blog/'.ltrim($post->slug, '/')),
        ],
    ],
];
