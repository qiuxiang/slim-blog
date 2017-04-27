<?php
require '../vendor/autoload.php';
date_default_timezone_set('Asia/Shanghai');
session_start();
$app = new Slim\App();
require '../src/capsule.php';
require '../src/dependencies.php';
require '../src/routes.php';
$app->run();

