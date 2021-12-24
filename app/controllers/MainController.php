<?php

namespace app\controllers;

use luxury\Cache;

class MainController extends App
{
    public function indexAction() {
        $posts = \R::findAll('test');
        $this->setMeta('Главная страница', 'fdfdfd', 'lalala');

    }
}