<?php

require_once __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../vendor/autoload.php';

$container = new \Slim\Container;
$container['settings']['displayErrorDetails'] = true; // you would want this false in production
$app = new \Slim\App($container);
// $app = new \Slim\App([
//     'settings' => [
//         'displayErrorDetails' => true, // you would want this false in production
//     ],
// ]);

require __DIR__ . '/../src/dependencies.php';
require __DIR__ . '/../src/routes.php';

$app->run();