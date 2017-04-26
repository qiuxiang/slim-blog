<?php
use App\Controller\Admin;
use App\Controller\Home;

$app->get('/', Home::class . ':index');
$app->get('/article/{id}', Home::class . ':article');
$app->post('/comment', Home::class . ':comment');
$app->get('/login', Home::class . ':login');
$app->post('/login', Home::class . ':handleLogin');
$app->get('/register', Home::class . ':register');
$app->post('/register', Home::class . ':handleRegister');
$app->get('/logout', Home::class . ':logout');

$app->get('/admin', Admin::class . ':index');
$app->get('/admin/personal', Admin::class . ':personal');
$app->post('/admin/personal', Admin::class . ':updatePersonalInfo');
$app->get('/admin/users', Admin::class . ':users');
$app->post('/admin/user/{id}/toggle_role', Admin::class . ':toggleUserRole');
$app->get('/admin/articles', Admin::class . ':articles');
$app->get('/admin/article', Admin::class . ':article');
$app->post('/admin/article', Admin::class . ':saveArticle');
$app->get('/admin/article/{id}', Admin::class . ':article');
$app->delete('/admin/article/{id}', Admin::class . ':deleteArticle');
