<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}