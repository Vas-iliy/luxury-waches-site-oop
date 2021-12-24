<?php

namespace app\controllers;

class MainController extends App
{
    public function indexAction() {
        $posts = \R::findAll('test');
        $this->setMeta('Главная страница', 'fdfdfd', 'lalala');

        $this->set(compact('posts'));
    }
}