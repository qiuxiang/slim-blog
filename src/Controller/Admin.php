<?php

namespace App\Controller;

use App\Model\Article;
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
                    'title' => '个人',
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

    public function index() {
        return $this->redirect('/admin/personal');
    }

    public function personal() {
        return $this->auth(function () {
            $this->active('personal');
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

    public function articles() {
        return $this->auth(function () {
            $this->active('article');
            $page = $this->request->getQueryParam('page');
            $articles = Article::query()->paginate(10, ['*'], 'page', $page);
            $articles->withPath('/admin/articles');
            return $this->render('admin/articles.twig', ['articles' => $articles]);
        });
    }

    public function article($req, $res, $args) {
        return $this->auth(function () use($args) {
            $this->active('article');
            $article = Article::query()->find($args['id']);
            return $this->render('admin/article.twig', ['article' => $article]);
        });
    }

    public function saveArticle() {
        return $this->auth(function () {
            $data = $this->request->getParsedBody();
            if ($data['id']) {
                $article = Article::query()->find($data['id']);
            } else {
                $article = new Article();
                $article->user_id = $this->user->id;
            }
            $article->title = $data['title'];
            $article->summary = $data['summary'];
            $article->content = $data['content'];
            $article->save();
            $this->alert('success', '保存文章成功', '/admin/articles');
        });
    }

    public function active($menuItem) {
        foreach ($this->data['menu'] as &$item) {
            if (strpos($item['url'], $menuItem)) {
                $item['active'] = true;
            }
        }
    }
}
