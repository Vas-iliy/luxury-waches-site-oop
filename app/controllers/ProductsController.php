<?php

namespace app\controllers;

use luxury\Cache;

class ProductsController extends AppController
{
    public function indexAction() {
        $brands = \R::find('brands', 'LIMIT 3');
        $hits = \R::find('products', "hit = '1' AND status = '1' LIMIT 8");
        $this->setMeta('Главная страница');
        $this->set(compact('brands', 'hits'));
    }

    public function productAction() {
        $alias = $this->route['alias'];
        $product = \R::findOne('products', "alias = ? AND status = ?", [$alias, '1']);
        if (!$product) {
            throw new \Exception('Страница не найдена', 404);
        }
        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product'));
    }
}