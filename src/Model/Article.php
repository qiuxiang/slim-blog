<?php

namespace App\Model;

use DOMDocument;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Model\Comment');
    }

    /**
     * 从正文提取第一张图片作为封面
     *
     * @return string
     */
    public function getImage()
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($this->content);
        $img = $dom->getElementsByTagName('img')->item(0);
        if ($img) {
            return $dom->saveHTML($img);
        } else {
            return '';
        }
    }
}