<?php
require '../vendor/autoload.php';
session_start();
$app = new Slim\App();
require '../src/capsule.php';
require '../src/dependencies.php';
require '../src/routes.php';
$app->run();

