<?php

namespace app\controllers;

class MainController extends App
{
    public function indexAction() {
        debug($this->route);
        debug($this->controller);
    }
}