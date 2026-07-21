<?php

namespace JeffersonGoncalves\Cms\Core;

use JeffersonGoncalves\Cms\Core\Console\Commands\GenerateSitemapCommand;
use JeffersonGoncalves\Cms\Core\Models\Contracts\CategoryContract;
use JeffersonGoncalves\Cms\Core\Models\Contracts\CommentContract;
use JeffersonGoncalves\Cms\Core\Models\Contracts\PageContract;
use JeffersonGoncalves\Cms\Core\Models\Contracts\PostContract;
use JeffersonGoncalves\Cms\Core\Models\Contracts\RevisionContract;
use JeffersonGoncalves\Cms\Core\Models\Contracts\SeoContract;
use JeffersonGoncalves\Cms\Core\Models\Contracts\TagContract;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CmsCoreServiceProvider extends PackageServiceProvider
{
    public static string $name = 'cms-core';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
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
            PageContract::class => 'page',
            PostContract::class => 'post',
            CategoryContract::class => 'category',
            TagContract::class => 'tag',
            CommentContract::class => 'comment',
            RevisionContract::class => 'revision',
            SeoContract::class => 'seo',
        ];

        foreach ($bindings as $contract => $configKey) {
            $this->app->bind($contract, config("cms-core.models.{$configKey}"));
        }
    }
}
