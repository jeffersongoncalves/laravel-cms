<?php

namespace JeffersonGoncalves\Cms\Menu;

use JeffersonGoncalves\Cms\Menu\Models\Contracts\MenuContract;
use JeffersonGoncalves\Cms\Menu\Models\Contracts\MenuItemContract;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CmsMenuServiceProvider extends PackageServiceProvider
{
    public static string $name = 'cms-menu';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasMigrations([
                'create_cms_menus_table',
                'create_cms_menu_items_table',
            ]);
    }

    public function packageBooted(): void
    {
        $this->registerModelBindings();
    }

    protected function registerModelBindings(): void
    {
        $bindings = [
            MenuContract::class => 'menu',
            MenuItemContract::class => 'menu_item',
        ];

        foreach ($bindings as $contract => $configKey) {
            $this->app->bind($contract, config("cms-menu.models.{$configKey}"));
        }
    }
}
