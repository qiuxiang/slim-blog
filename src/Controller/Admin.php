<?php

namespace App\Controller;

class Admin extends Base
{
    public function __construct($container)
    {
        parent::__construct($container);

        $this->data['menu'] = [
            [
                'url' => '/admin/user',
                'title' => '用户',
            ],
            [
                'url' => '/admin/article',
                'title' => '文章',
            ],
        ];
    }

    public function index()
    {
        return $this->auth(function () {
            return $this->render('admin/index.twig');
        });
    }
}
