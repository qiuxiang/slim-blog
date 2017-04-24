<?php
use App\Controller\News as NewsController;

$container = $app->getContainer();
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../templates/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], ''));
    return $view;
};
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};
$container[NewsController::class] = function($container) {
    return new NewsController($container);
};
