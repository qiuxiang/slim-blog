<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Model\User;

require '../vendor/autoload.php';
require 'capsule.php';
$schema = Capsule::schema();
if (!$schema->hasTable('user')) {
    $schema->create('user', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name')->unique();
        $table->string('nickname');
        $table->string('password');
        $table->string('salt');
        $table->integer('role')->default(User::ROLE_USER);
        $table->timestamps();
    });

    $user = new User();
    $user->name = 'admin';
    $user->nickname = '管理员';
    $user->salt = User::salt();
    $user->password = User::hash('admin', $user->salt);
    $user->role = User::ROLE_ADMIN;
    $user->save();
}

if (!$schema->hasTable('article')) {
    $schema->create('article', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->string('summary');
        $table->string('content');
        $table->integer('user_id');
        $table->timestamps();
    });
}
