<?php

use JeffersonGoncalves\Cms\Menu\Models\Menu;
use JeffersonGoncalves\Cms\Menu\Models\MenuItem;

return [
    /*
    |--------------------------------------------------------------------------
    | Table Prefix
    |--------------------------------------------------------------------------
    */
    'table_prefix' => 'cms_',

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    */
    'models' => [
        'menu' => Menu::class,
        'menu_item' => MenuItem::class,
    ],
];
