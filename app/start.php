<?php

use \Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use Noodlehaus\Config;

use LearningPhp\User\User;

session_cache_limiter(false);
session_start();

ini_set('display_errors', 'On');

define('INC_ROOT', dirname(__DIR__));

require INC_ROOT . '/vendor/autoload.php';

$app = new \Slim\App([
    'mode' => trim(file_get_contents(INC_ROOT . '/mode.php')),
    'view' => new Twig(),
    'templates.path' => INC_ROOT . '/app/views'
]);

// $app->configureMode($app->config('mode'), function() use ($app) {
// $app->config = Config::load(INC_ROOT . "/app/config/{$app->mode}.php");
// });

// var_dump($app->config); // Line 23;
require 'database.php';
require 'routes.php';

$app->container->set('user', function() {
    return new User;
});

$app->get('/', function() use ($app) {
    $app->render('home.php');
});

$view = $app->view();

$view->parserOptions = [
    'debug' => $app->config->get('twig.debug')
];

$view->parserExtenions = [
        new TwigExtension
];
