<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $mbConfig): void {
    $mbConfig->packageDirectories([__DIR__.'/packages']);

    // Keep dev tooling versions aligned across every package.
    $mbConfig->dataToAppend([
        'require-dev' => [
            'larastan/larastan' => '^2.9|^3.0',
            'laravel/pint' => '^1.0',
            'orchestra/testbench' => '^9.0|^10.0|^11.0',
            'pestphp/pest' => '^3.0|^4.0',
        ],
    ]);
};
