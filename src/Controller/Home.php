<?php
namespace App\Controller;

class Home extends Base
{
   protected $container;

   public function __construct($container) {
       parent::__construct($container);
   }

   public function index() {
        return $this->render('home/index.twig');
   }

   public function login() {
       return $this->render('home/login.twig');
   }

    public function register() {
        return $this->render('home/register.twig');
    }
}
