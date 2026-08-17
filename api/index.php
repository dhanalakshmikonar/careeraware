<?php

error_log("=== VERCEL LARAVEL START ===");

try {

    error_log("PHP VERSION: " . PHP_VERSION);
    error_log("VERCEL: " . (getenv('VERCEL') ?: 'not set'));

    if (getenv('VERCEL')) {

        $storagePath = sys_get_temp_dir() . '/laravel-storage';

        foreach ([
            $storagePath . '/app',
            $storagePath . '/framework/cache/data',
            $storagePath . '/framework/sessions',
            $storagePath . '/framework/views',
            $storagePath . '/logs',
        ] as $directory) {

            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
        }

        $_ENV['LARAVEL_STORAGE_PATH'] = $storagePath;
        $_SERVER['LARAVEL_STORAGE_PATH'] = $storagePath;

        putenv('LOG_CHANNEL=stderr');
        $_ENV['LOG_CHANNEL'] = 'stderr';
        $_SERVER['LOG_CHANNEL'] = 'stderr';

        error_log("Storage path: " . $storagePath);
    }

    error_log("Loading Laravel public/index.php...");

    require __DIR__ . '/../public/index.php';

    error_log("=== LARAVEL FINISHED ===");

} catch (\Throwable $e) {

    error_log("=== LARAVEL ERROR ===");
    error_log("MESSAGE: " . $e->getMessage());
    error_log("FILE: " . $e->getFile());
    error_log("LINE: " . $e->getLine());
    error_log("TRACE: " . $e->getTraceAsString());

    http_response_code(500);

    echo "<h1>Laravel Error</h1>";
    echo "<pre>";
    echo htmlspecialchars($e->getMessage());
    echo "\n\n";
    echo htmlspecialchars($e->getFile());
    echo ":";
    echo $e->getLine();
    echo "</pre>";
}