<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const ROLE_USER = 0;
    const ROLE_WRITER = 1;
    const ROLE_ADMIN = 2;

    protected $table = 'user';

    public static function salt()
    {
        return uniqid(rand(), true);
    }

    public static function hash($password, $salt)
    {
        return sha1($salt . $password);
    }

    public function isAdmin() {
        return $this->role == self::ROLE_ADMIN;
    }

    public function isWriter() {
        return $this->role == self::ROLE_WRITER;
    }
}