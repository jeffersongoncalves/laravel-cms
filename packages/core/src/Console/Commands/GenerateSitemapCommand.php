<?php

namespace JeffersonGoncalves\Cms\Core\Console\Commands;

use Illuminate\Console\Command;
use JeffersonGoncalves\Cms\Core\Sitemap\SitemapGenerator;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'cms:generate-sitemap {--path= : Absolute output path, defaults to config(cms-core.sitemap.path)}';

    protected $description = 'Generate sitemap.xml from published pages and posts';

    public function handle(SitemapGenerator $generator): int
    {
        $path = $this->option('path');

        $generator->generate($path);

        $this->info('Sitemap generated at '.($path ?? config('cms-core.sitemap.path')));

        return self::SUCCESS;
    }
}
