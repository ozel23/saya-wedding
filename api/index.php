<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require __DIR__.'/../bootstrap/app.php';

$app->useStoragePath(sys_get_temp_dir().'/saya-wedding');

foreach (['framework/views', 'framework/sessions', 'framework/cache/data', 'logs'] as $directory) {
    $path = $app->storagePath($directory);

    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

$app->handleRequest(Request::capture());
