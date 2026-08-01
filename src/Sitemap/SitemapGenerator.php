<?php

namespace JeffersonGoncalves\Cms\Sitemap;

use JeffersonGoncalves\Cms\Models\Page;
use JeffersonGoncalves\Cms\Models\Post;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerator
{
    public function generate(?string $path = null): Sitemap
    {
        $sitemap = Sitemap::create();

        $resolvers = config('cms-core.sitemap.resolvers', []);

        if ($resolver = $resolvers['page'] ?? null) {
            $this->addUrls($sitemap, config('cms-core.models.page', Page::class), $resolver);
        }

        if ($resolver = $resolvers['post'] ?? null) {
            $this->addUrls($sitemap, config('cms-core.models.post', Post::class), $resolver);
        }

        $sitemap->writeToFile($path ?? config('cms-core.sitemap.path'));

        return $sitemap;
    }

    protected function addUrls(Sitemap $sitemap, string $modelClass, callable $resolver): void
    {
        $modelClass::query()->published()->each(function ($model) use ($sitemap, $resolver): void {
            $sitemap->add(
                Url::create($resolver($model))
                    ->setLastModificationDate($model->updated_at ?? now())
            );
        });
    }
}
