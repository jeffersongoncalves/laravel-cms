<?php

namespace JeffersonGoncalves\Cms;

use JeffersonGoncalves\Cms\Console\Commands\GenerateSitemapCommand;
use JeffersonGoncalves\Cms\Models\Contracts\CategoryContract;
use JeffersonGoncalves\Cms\Models\Contracts\CommentContract;
use JeffersonGoncalves\Cms\Models\Contracts\MenuContract;
use JeffersonGoncalves\Cms\Models\Contracts\MenuItemContract;
use JeffersonGoncalves\Cms\Models\Contracts\PageContract;
use JeffersonGoncalves\Cms\Models\Contracts\PostContract;
use JeffersonGoncalves\Cms\Models\Contracts\RevisionContract;
use JeffersonGoncalves\Cms\Models\Contracts\SeoContract;
use JeffersonGoncalves\Cms\Models\Contracts\TagContract;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CmsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'cms';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile(['cms-core', 'cms-media', 'cms-menu'])
            ->hasMigrations([
                'create_cms_pages_table',
                'create_cms_posts_table',
                'create_cms_categories_table',
                'create_cms_tags_table',
                'create_cms_categorizables_table',
                'create_cms_taggables_table',
                'create_cms_comments_table',
                'create_cms_revisions_table',
                'create_cms_seo_metas_table',
                'create_cms_menus_table',
                'create_cms_menu_items_table',
            ])
            ->hasCommand(GenerateSitemapCommand::class);
    }

    public function packageBooted(): void
    {
        $this->registerModelBindings();
    }

    protected function registerModelBindings(): void
    {
        $bindings = [
            PageContract::class => ['cms-core', 'page'],
            PostContract::class => ['cms-core', 'post'],
            CategoryContract::class => ['cms-core', 'category'],
            TagContract::class => ['cms-core', 'tag'],
            CommentContract::class => ['cms-core', 'comment'],
            RevisionContract::class => ['cms-core', 'revision'],
            SeoContract::class => ['cms-core', 'seo'],
            MenuContract::class => ['cms-menu', 'menu'],
            MenuItemContract::class => ['cms-menu', 'menu_item'],
        ];

        foreach ($bindings as $contract => [$config, $configKey]) {
            $this->app->bind($contract, config("{$config}.models.{$configKey}"));
        }
    }
}
