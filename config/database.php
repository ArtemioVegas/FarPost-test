<?php

return [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'demo_test',
    'port' => 3306,
    'user' => 'web_user',
    'password' => '12345678',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ],
];