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
                    'url' => '/',
                    'title' => '首页',
                ],
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

    public function index()
    {
        return $this->redirect('/admin/personal');
    }

    public function personal()
    {
        return $this->auth(function () {
            $this->active('personal');
            return $this->render('admin/personal.twig');
        });
    }

    public function updatePersonalInfo()
    {
        return $this->auth(function () {
            $this->user->nickname = $this->request->getParsedBody()['nickname'];
            $this->user->save();
            $this->alert('success', '修改成功', '/admin/personal');
        });
    }

    public function articles()
    {
        return $this->auth(function () {
            $this->active('article');
            $page = $this->request->getQueryParam('page');
            $query = Article::query();
            if (!$this->user->isAdmin()) {
                $query->where('user_id', $this->user->id);
            }
            $articles = $query
                ->orderBy('created_at', 'desc')
                ->paginate(20, ['*'], 'page', $page);
            $articles->withPath('/admin/articles');
            return $this->render('admin/articles.twig', ['articles' => $articles]);
        });
    }

    public function article($req, $res, $args)
    {
        return $this->auth(function () use ($args) {
            $this->active('article');
            $article = Article::query()->find($args['id']);
            return $this->render('admin/article.twig', ['article' => $article]);
        });
    }

    public function deleteArticle($req, $res, $args)
    {
        return $this->auth(function () use ($args) {
            $article = Article::query()->find($args['id']);
            $article->delete();
            return $this->response->write(true);
        });
    }

    public function saveArticle()
    {
        return $this->auth(function () {
            $data = $this->request->getParsedBody();
            if ($data['id']) {
                $article = Article::query()->find($data['id']);
                // 只有超级管理员，或文章的作者可以修改
                if (!$this->user->isAdmin() && $article->user->id != $this->user->id) {
                    return $this->alert('danger', '权限错误', '/admin/articles');
                }
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

    public function users()
    {
        return $this->auth(function () {
            $this->active('user');
            $page = $this->request->getQueryParam('page');
            $users = User::query()->paginate(20, ['*'], 'page', $page);
            $users->withPath('/admin/users');
            return $this->render('admin/users.twig', [
                'users' => $users,
                'role_map' => [
                    User::ROLE_USER => '用户',
                    User::ROLE_WRITER => '作者',
                    User::ROLE_ADMIN => '管理员',
                ],
            ]);
        });
    }

    public function toggleUserRole($req, $res, $args)
    {
        return $this->auth(function () use ($args) {
            $user = User::query()->find($args['id']);
            if ($user->isWriter()) {
                $user->role = User::ROLE_USER;
            } else {
                $user->role = User::ROLE_WRITER;
            }
            $user->save();
            return $this->response->getBody()->write(true);
        });
    }

    public function active($menuItem)
    {
        foreach ($this->data['menu'] as &$item) {
            if (strpos($item['url'], $menuItem)) {
                $item['active'] = true;
            }
        }
    }
}
