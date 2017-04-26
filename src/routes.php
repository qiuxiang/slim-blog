<?php
use App\Controller\Home as HomeController;
use App\Controller\Admin as AdminController;

$app->get('/', HomeController::class . ':index');
$app->get('/login', HomeController::class . ':login');
$app->post('/login', HomeController::class . ':handleLogin');
$app->get('/register', HomeController::class . ':register');
$app->post('/register', HomeController::class . ':handleRegister');
$app->get('/logout', HomeController::class . ':logout');

$app->get('/admin', AdminController::class . ':index');
$app->get('/admin/personal', AdminController::class . ':personal');
$app->post('/admin/personal', AdminController::class . ':updatePersonalInfo');
$app->get('/admin/articles', AdminController::class . ':articles');
$app->get('/admin/article', AdminController::class . ':article');
$app->get('/admin/article/{id}', AdminController::class . ':article');
$app->post('/admin/article', AdminController::class . ':saveArticle');
