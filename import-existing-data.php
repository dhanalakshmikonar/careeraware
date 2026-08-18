<?php

use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Starting SQLite → MySQL import...\n\n";

/*
|--------------------------------------------------------------------------
| Source SQLite connection
|--------------------------------------------------------------------------
*/

config([
    'database.connections.sqlite_import' => [
        'driver' => 'sqlite',
        'database' => database_path('database.sqlite'),
        'prefix' => '',
        'foreign_key_constraints' => true,
    ],
]);

DB::purge('sqlite_import');

$source = DB::connection('sqlite_import');
$target = DB::connection('mysql');

/*
|--------------------------------------------------------------------------
| Test both connections
|--------------------------------------------------------------------------
*/

$source->getPdo();
$target->getPdo();

echo "SQLite connection: OK\n";
echo "MySQL connection: OK\n\n";

/*
|--------------------------------------------------------------------------
| Tables
|--------------------------------------------------------------------------
|
| Parent tables first, then child tables.
|
*/

$tables = [
    'users',
    'career_paths',
    'awareness_sessions',
    'questions',
    'question_options',
    'student_sessions',
    'assessment_responses',
    'assessment_results',
];

/*
|--------------------------------------------------------------------------
| Disable foreign key checks temporarily
|--------------------------------------------------------------------------
*/

$target->statement('SET FOREIGN_KEY_CHECKS=0');

foreach ($tables as $table) {

    echo "Importing: {$table}\n";

    $rows = $source->table($table)->get();

    if ($rows->isEmpty()) {
        echo "  No records found.\n\n";
        continue;
    }

    $records = $rows->map(function ($row) {
        return (array) $row;
    })->all();

    foreach (array_chunk($records, 100) as $chunk) {
        $target->table($table)->insert($chunk);
    }

    echo "  Imported " . count($records) . " records.\n\n";
}

$target->statement('SET FOREIGN_KEY_CHECKS=1');

echo "========================================\n";
echo "IMPORT COMPLETED SUCCESSFULLY\n";
echo "========================================\n";