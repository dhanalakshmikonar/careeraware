<?php

// Vercel functions provide /tmp as their only writable filesystem location.
// Laravel needs writable storage for compiled views, caches, and logs.
if (getenv('VERCEL')) {
    $storagePath = sys_get_temp_dir().'/laravel-storage';

    foreach ([
        $storagePath.'/app',
        $storagePath.'/framework/cache/data',
        $storagePath.'/framework/sessions',
        $storagePath.'/framework/views',
        $storagePath.'/logs',
    ] as $directory) {
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    $_ENV['LARAVEL_STORAGE_PATH'] = $storagePath;
    $_SERVER['LARAVEL_STORAGE_PATH'] = $storagePath;
    putenv('LOG_CHANNEL=stderr');
    $_ENV['LOG_CHANNEL'] = 'stderr';
    $_SERVER['LOG_CHANNEL'] = 'stderr';
}

require __DIR__.'/../public/index.php';
