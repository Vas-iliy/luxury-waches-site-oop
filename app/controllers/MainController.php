<?php

namespace app\controllers;

use luxury\Cache;

class MainController extends App
{
    public function indexAction() {
        $brands = \R::find('brands', 'LIMIT 3');
        $hits = \R::find('products', "hit = '1' AND status = '1' LIMIT 8");
        $this->setMeta('Главная страница');
        $this->set(compact('brands', 'hits'));

    }
}