<?php
namespace App\Controller;

class News extends Base
{
   protected $container;

   public function __construct($container) {
       parent::__construct($container);
   }

   public function index() {
        return $this->render('news/index.twig');
   }
}
