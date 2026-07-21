<?php

namespace JeffersonGoncalves\Cms\Media\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JeffersonGoncalves\Cms\Media\CmsMediaServiceProvider;
use JeffersonGoncalves\Cms\Media\Tests\Fixtures\Article;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [
            CmsMediaServiceProvider::class,
            MediaLibraryServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('filesystems.disks.media', [
            'driver' => 'local',
            'root' => storage_path('media'),
        ]);
        $app['config']->set('media-library.disk_name', 'media');

        $configPath = __DIR__.'/../config/cms-media.php';
        if (file_exists($configPath)) {
            $app['config']->set('cms-media', require $configPath);
        }
    }

    protected function defineDatabaseMigrations(): void
    {
        $stub = __DIR__.'/../../../vendor/spatie/laravel-medialibrary/database/migrations/create_media_table.php.stub';
        $tempPath = sys_get_temp_dir().'/laravel-cms-media-migrations';

        if (! is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $target = $tempPath.'/create_media_table.php';
        if (! file_exists($target)) {
            copy($stub, $target);
        }

        $this->loadMigrationsFrom($tempPath);

        Article::createTable();
    }
}
