<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\User;

class Home extends Base
{
    protected $container;

    public function __construct($container)
    {
        parent::__construct($container);
    }

    public function index()
    {
        $page = $this->request->getQueryParam('page');
        $search = $this->request->getQueryParam('search');
        $query = Article::query();
        if ($search) {
            $query->where([['title', 'like', "%$search%"]])
                ->orWhere([['summary', 'like', "%$search%"]])
                ->orWhere([['content', 'like', "%$search%"]]);
        }
        $articles = $query->paginate(10, ['*'], 'page', $page);
        return $this->render('home/index.twig', ['articles' => $articles, 'search' => $search]);
    }

    public function logout() {
        $_SESSION['user'] = null;
        return $this->redirect('/login');
    }

    public function login()
    {
        return $this->render('home/login.twig');
    }

    public function handleLogin()
    {
        $data = $this->request->getParsedBody();
        $user = User::query()->where('name', $data['username'])->first();
        if (!$user) {
            return $this->alert('danger', '用户“' . $data['username'] . '”不存在');
        }
        if ($user->password == User::hash($data['password'], $user->salt)) {
            $_SESSION['user'] = $user;
            return $this->redirect('/admin');
        } else {
            return $this->alert('danger', '密码错误');
        }
    }

    public function register()
    {
        return $this->render('home/register.twig');
    }

    public function handleRegister()
    {
        $data = $this->request->getParsedBody();
        if ($data['password'] != $data['password-again']) {
            return $this->alert('danger', '两次输入的密码不一致');
        }
        if (User::query()->where('name', $data['username'])->count()) {
            return $this->alert('danger', '用户名已存在');
        }
        if (User::query()->where('nickname', $data['nickname'])->count()) {
            return $this->alert('danger', '昵称已存在');
        }
        $user = new User();
        $user->name = $data['username'];
        $user->nickname = $data['nickname'];
        $user->salt = User::salt();
        $user->password = User::hash($data['password'], $user->salt);
        $user->save();
        return $this->alert('success', '注册成功', '/login');
    }
}
