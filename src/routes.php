<?php
use App\Controller\News as NewsController;
use App\Controller\Admin as AdminController;
$app->get('/', NewsController::class . ':index');
$app->get('/admin', AdminController::class . ':index');

