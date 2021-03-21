<?php

return [
    'drivers' => [
        'mysql' => [
            'localhost' => getenv('DB_HOST') ?: 'localhost',
            'username' => getenv('DB_USERNAME') ?: 'root',
            'password' => getenv('DB_PASSWORD') ?: '',
            'database' => getenv('DB_DATABASE') ?: 'tutorials'
        ]
    ]
];