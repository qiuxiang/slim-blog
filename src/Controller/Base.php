<?php

namespace App\Controller;

class Base
{
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

    public function auth($action)
    {
        return $action();
    }
}
