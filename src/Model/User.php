<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    public static function salt() {
        return uniqid(rand(), true);
    }

    public static function hash($password, $salt) {
        return sha1($salt . $password);
    }
}