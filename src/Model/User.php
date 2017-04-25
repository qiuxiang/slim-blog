<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    const ROLE_SUPER_ADMIN = 2;

    protected $table = 'user';

    public static function salt() {
        return uniqid(rand(), true);
    }

    public static function hash($password, $salt) {
        return sha1($salt . $password);
    }
}