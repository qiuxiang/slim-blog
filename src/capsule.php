<?php
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/../db.sqlite',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
return $capsule;
