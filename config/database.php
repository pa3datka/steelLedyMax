<?php

use Pa3datka\Env;

return [
    'db' => [
        'db_name' => Env::env('DB_NAME', 'main'),
        'db_host' => Env::env('DB_HOST', '127.0.0.1'),
        'db_port' => Env::env('DB_PORT', '3306'),
        'db_user' => Env::env('DB_USER', 'root'),
        'db_password' => Env::env('DB_PASSWORD', 'root'),
        'charset' => 'utf8mb4'
    ],
    'example' => [
        'db_name' => Env::env('EXDB_NAME', 'main'),
        'db_host' => Env::env('EXDB_NAME', '127.0.0.1'),
        'db_port' => Env::env('EXDB_NAME', '3306'),
        'db_user' => Env::env('EXDB_NAME', 'root'),
        'db_password' => Env::env('EXDB_NAME', 'root'),
        'charset' => 'utf8mb4'
    ]
];