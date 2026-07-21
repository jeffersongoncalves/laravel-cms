<?php

declare(strict_types=1);

/*
 * Monorepo root Pest configuration.
 *
 * Each package ships its own tests/Pest.php which binds its TestCase to its own
 * Unit/Feature directories (via absolute __DIR__ paths, so it resolves the same
 * on every OS and in each standalone split repository) and defines its helper
 * functions. We load them all here — a single binding per package, no duplicates.
 */

$packages = ['core', 'media', 'menu', 'suite'];

foreach ($packages as $dir) {
    $pest = __DIR__.'/../packages/'.$dir.'/tests/Pest.php';

    if (file_exists($pest)) {
        require $pest;
    }
}
