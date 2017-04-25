<?php
use App\Controller\Home as HomeController;
use App\Controller\Admin as AdminController;

$app->get('/', HomeController::class . ':index');
$app->get('/login', HomeController::class . ':login');
$app->get('/register', HomeController::class . ':register');
$app->get('/admin', AdminController::class . ':index');
