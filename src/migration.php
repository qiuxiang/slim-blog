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
        $table->string('nickname')->default('');
        $table->string('password');
        $table->string('salt');
        $table->integer('admin')->default(0);
        $table->dateTime('updated_at');
        $table->dateTime('created_at');
    });

    $user = new User();
    $user->name = 'admin';
    $user->nickname = '管理员';
    $user->salt = User::salt();
    $user->password = User::hash('admin', $user->salt);
    $user->admin = User::ROLE_SUPER_ADMIN;
    $user->save();
}
