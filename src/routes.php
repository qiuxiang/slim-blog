<?php
use App\Controller\Home as HomeController;
use App\Controller\Admin as AdminController;

$app->get('/', HomeController::class . ':index');
$app->get('/article/{id}', HomeController::class . ':article');
$app->post('/comment', HomeController::class . ':comment');
$app->get('/login', HomeController::class . ':login');
$app->post('/login', HomeController::class . ':handleLogin');
$app->get('/register', HomeController::class . ':register');
$app->post('/register', HomeController::class . ':handleRegister');
$app->get('/logout', HomeController::class . ':logout');

$app->get('/admin', AdminController::class . ':index');
$app->get('/admin/personal', AdminController::class . ':personal');
$app->post('/admin/personal', AdminController::class . ':updatePersonalInfo');
$app->get('/admin/users', AdminController::class . ':users');
$app->post('/admin/user/{id}/toggle_role', AdminController::class . ':toggleUserRole');
$app->get('/admin/articles', AdminController::class . ':articles');
$app->get('/admin/article', AdminController::class . ':article');
$app->post('/admin/article', AdminController::class . ':saveArticle');
$app->get('/admin/article/{id}', AdminController::class . ':article');
$app->delete('/admin/article/{id}', AdminController::class . ':deleteArticle');
