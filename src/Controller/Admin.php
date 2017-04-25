<?php

namespace App\Controller;

use App\Model\User;

class Admin extends Base
{
    public function __construct($container)
    {
        parent::__construct($container);

        $menu = [
            User::ROLE_USER => [
                [
                    'url' => '/admin/personal',
                    'title' => '个人信息',
                ],
            ],
        ];
        $menu[User::ROLE_WRITER] = $menu[User::ROLE_USER];
        $menu[User::ROLE_WRITER][] = [
            'url' => '/admin/articles',
            'title' => '文章',
        ];
        $menu[User::ROLE_ADMIN] = $menu[User::ROLE_WRITER];
        $menu[User::ROLE_ADMIN][] = [
            'url' => '/admin/users',
            'title' => '用户',
        ];

        $this->data['menu'] = $menu[$this->user->role];
    }

    public function personal() {
        return $this->auth(function () {
            return $this->render('admin/personal.twig');
        });
    }

    public function updatePersonalInfo() {
        return $this->auth(function () {
            $this->user->nickname = $this->request->getParsedBody()['nickname'];
            $this->user->save();
            $this->alert('success', '修改成功', '/admin/personal');
        });
    }
}
