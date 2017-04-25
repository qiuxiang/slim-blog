<?php

namespace App\Controller;

use App\Model\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * 基础控制器，主要实现公共方法，身份认证
 */
class Base
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Twig
     */
    protected $view;

    /**
     * View data, will be passed in template
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var User
     */
    protected $user;

    public function __construct($container)
    {
        $this->view = $container->view;
        $this->request = $container->request;
        $this->response = $container->response;
        $this->user = $_SESSION['user'];
        if ($this->user) {
            $this->data['user'] = $this->user;
        }
    }

    public function alert($type, $message, $redirect='')
    {
        return $this->render('home/alert.twig', [
            'type' => $type,
            'message' => $message,
            'redirect' => $redirect,
        ]);
    }

    public function render($template, $data = [])
    {
        return $this->view->render(
            $this->response, $template, array_merge($this->data, $data));
    }

    public function redirect($url)
    {
        return $this->response->withStatus(302)->withHeader('Location', $url);
    }

    protected function auth($action)
    {
        if ($this->user) {
            return $action();
        } else {
            return $this->redirect('/login');
        }
    }
}
