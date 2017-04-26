<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function getUserName()
    {
        if ($this->user) {
            return $this->user->nickname;
        } else {
            return "游客（{$this->ip}）";
        }
    }
}