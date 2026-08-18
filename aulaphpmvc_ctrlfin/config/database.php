<?php

declare(strict_types=1);

return [
    'driver'   => 'mysql',
    'host'     => getenv('DB_HOST') ?: 'aula_mariadb',
    'port'     => (int)(getenv('DB_PORT') ?: 3306),
    'dbname'   => getenv('DB_NAME') ?: 'controle_financeiro',
    'username' => getenv('DB_USER') ?: 'aula_user',
    'password' => getenv('DB_PASS') ?: 'aula_pass',
    'charset'  => 'utf8mb4',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ],
];
