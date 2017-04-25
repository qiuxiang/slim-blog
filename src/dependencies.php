<?php
use App\Controller\News as NewsController;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

$container = $app->getContainer();
$container['view'] = function ($container) {
    $view = new Twig(__DIR__ . '/../templates/');
    $view->addExtension(new TwigExtension($container['router'], ''));
    return $view;
};
$container[NewsController::class] = function ($container) {
    return new NewsController($container);
};
