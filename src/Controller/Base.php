<?php

namespace App\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/**
 * 基础控制器，主要实现公共方法，身份认证
 */
class Base
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Twig
     */
    protected $view;

    public function __construct($container)
    {
        $this->view = $container->view;
        $this->response = $container->response;
        $this->data = [];
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

    public function auth($action)
    {
        if ($_SESSION['user']) {
            return $action();
        } else {
            return $this->redirect('/login');
        }
    }
}
