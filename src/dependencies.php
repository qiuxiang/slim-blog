<?php
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

$container = $app->getContainer();
$container['view'] = function ($container) {
    $view = new Twig('../templates/');
    $view->addExtension(new TwigExtension($container['router'], ''));
    return $view;
};
