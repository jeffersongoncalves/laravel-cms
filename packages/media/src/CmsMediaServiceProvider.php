<?php

namespace JeffersonGoncalves\Cms\Media;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CmsMediaServiceProvider extends PackageServiceProvider
{
    public static string $name = 'cms-media';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile();
    }
}
