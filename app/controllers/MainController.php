<?php

namespace app\controllers;

class MainController extends App
{
    public function indexAction() {
        $this->setMeta('Главная страница', 'fdfdfd', 'lalala');

        $this->set(['name' => 'Vasiliy', 'age' => 22]);
    }
}