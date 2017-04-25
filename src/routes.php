<?php
use App\Controller\Home as HomeController;
use App\Controller\Admin as AdminController;

$app->get('/', HomeController::class . ':index');
$app->get('/login', HomeController::class . ':login');
$app->post('/login', HomeController::class . ':handleLogin');
$app->get('/register', HomeController::class . ':register');
$app->post('/register', HomeController::class . ':handleRegister');
$app->get('/logout', HomeController::class . ':logout');
$app->get('/admin', AdminController::class . ':personal');
$app->get('/admin/personal', AdminController::class . ':personal');
