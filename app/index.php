<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Prepare writable directories in /tmp for Vercel Serverless environment
$storagePath = sys_get_temp_dir() . '/laravel-storage';

$directories = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/testing',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    '/tmp/bootstrap/cache',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        @mkdir($directory, 0777, true);
    }
}

// Configure environment overrides for Vercel serverless environment
putenv('LARAVEL_STORAGE_PATH=' . $storagePath);
$_ENV['LARAVEL_STORAGE_PATH'] = $storagePath;
$_SERVER['LARAVEL_STORAGE_PATH'] = $storagePath;

putenv('VIEW_COMPILED_PATH=' . $storagePath . '/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = $storagePath . '/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = $storagePath . '/framework/views';

if (!getenv('LOG_CHANNEL')) {
    putenv('LOG_CHANNEL=stderr');
    $_ENV['LOG_CHANNEL'] = 'stderr';
    $_SERVER['LOG_CHANNEL'] = 'stderr';
}

putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php');

// Handle SQLite writable database in /tmp if SQLite is used
$dbConnection = getenv('DB_CONNECTION') ?: ($_ENV['DB_CONNECTION'] ?? 'sqlite');
if ($dbConnection === 'sqlite' && empty(getenv('DB_DATABASE'))) {
    $tmpDb = '/tmp/database.sqlite';
    $projectDb = __DIR__ . '/../database/database.sqlite';

    if (!file_exists($tmpDb)) {
        if (file_exists($projectDb)) {
            @copy($projectDb, $tmpDb);
        } else {
            @touch($tmpDb);
        }
    }

    putenv('DB_DATABASE=' . $tmpDb);
    $_ENV['DB_DATABASE'] = $tmpDb;
    $_SERVER['DB_DATABASE'] = $tmpDb;
}

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

if (method_exists($app, 'useStoragePath')) {
    $app->useStoragePath($storagePath);
}

$app->handleRequest(Request::capture());
