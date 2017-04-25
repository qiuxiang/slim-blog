<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

require '../vendor/autoload.php';
require 'capsule.php';
$schema = Capsule::schema();
if (!$schema->hasTable('user')) {
    $schema->create('user', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name')->unique();
        $table->string('nickname')->default('');
        $table->string('password');
        $table->string('salt');
        $table->integer('admin')->default(0);
    });

    $salt = uniqid(rand(), true);
    Capsule::table('user')->insert([
        'name' => 'admin',
        'salt' => $salt,
        'password' => sha1($salt . 'admin'),
        'admin' => 2,
    ]);
}
