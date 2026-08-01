<?php

namespace JeffersonGoncalves\Cms\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JeffersonGoncalves\Cms\CmsServiceProvider;
use JeffersonGoncalves\Cms\Tests\Fixtures\Article;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'JeffersonGoncalves\\Cms\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            CmsServiceProvider::class,
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

        foreach (['cms-core', 'cms-media', 'cms-menu'] as $config) {
            $configPath = __DIR__."/../config/{$config}.php";
            if (file_exists($configPath)) {
                $app['config']->set($config, require $configPath);
            }
        }
    }

    protected function defineDatabaseMigrations(): void
    {
        $stubsPath = __DIR__.'/../database/migrations';
        $tempPath = sys_get_temp_dir().'/laravel-cms-migrations';

        if (! is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        foreach (glob($stubsPath.'/*.php.stub') as $stub) {
            $filename = basename(str_replace('.php.stub', '.php', $stub));
            $target = $tempPath.'/'.$filename;

            if (! file_exists($target)) {
                copy($stub, $target);
            }
        }

        $mediaStub = __DIR__.'/../vendor/spatie/laravel-medialibrary/database/migrations/create_media_table.php.stub';
        $mediaTarget = $tempPath.'/create_media_table.php';
        if (file_exists($mediaStub) && ! file_exists($mediaTarget)) {
            copy($mediaStub, $mediaTarget);
        }

        $this->loadMigrationsFrom($tempPath);

        Article::createTable();
    }
}
