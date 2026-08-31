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
        $app['config']->set('database.connections.testing', $this->testing_connection());

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

    /**
     * Defaults to an in-memory SQLite connection for local development; CI
     * (tests.yml) sets CMS_TEST_DB_* to run the same suite against real
     * MySQL and PostgreSQL instances too. Deliberately not the plain DB_*
     * names: Orchestra Testbench itself sets DB_CONNECTION=testing by
     * convention, which would collide with (and always win over) a driver
     * value read from the same variable here.
     *
     * @return array<string, mixed>
     */
    protected function testing_connection(): array
    {
        $driver = env('CMS_TEST_DB_DRIVER', 'sqlite');

        if ($driver === 'sqlite') {
            return ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''];
        }

        return [
            'driver' => $driver,
            'host' => env('CMS_TEST_DB_HOST', '127.0.0.1'),
            'port' => env('CMS_TEST_DB_PORT'),
            'database' => env('CMS_TEST_DB_DATABASE', 'testing'),
            'username' => env('CMS_TEST_DB_USERNAME', 'root'),
            'password' => env('CMS_TEST_DB_PASSWORD', ''),
            'charset' => $driver === 'pgsql' ? 'utf8' : 'utf8mb4',
            'prefix' => '',
        ];
    }

    /**
     * Same order as CmsServiceProvider::hasMigrations(). SQLite doesn't
     * enforce foreign keys at CREATE TABLE time, but MySQL/Postgres do, and
     * alphabetical order breaks it here: e.g. "categorizables" sorts before
     * "categories" it references ('_' < 's' in ASCII).
     */
    private const MIGRATION_ORDER = [
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
    ];

    protected function defineDatabaseMigrations(): void
    {
        $stubsPath = __DIR__.'/../database/migrations';
        $tempPath = sys_get_temp_dir().'/laravel-cms-migrations';

        if (! is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        foreach (self::MIGRATION_ORDER as $index => $name) {
            copy($stubsPath.'/'.$name.'.php.stub', $tempPath.'/'.sprintf('%03d_%s.php', $index, $name));
        }

        $mediaStub = __DIR__.'/../vendor/spatie/laravel-medialibrary/database/migrations/create_media_table.php.stub';
        $mediaTarget = $tempPath.'/999_create_media_table.php';
        if (file_exists($mediaStub) && ! file_exists($mediaTarget)) {
            copy($mediaStub, $mediaTarget);
        }

        $this->loadMigrationsFrom($tempPath);

        Article::createTable();
    }
}
