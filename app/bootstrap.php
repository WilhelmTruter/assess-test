<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Fail fast if any required variable is missing or empty
$dotenv->required([
    'API_BASE_URL',
])->notEmpty();