<?php

namespace app\controllers;

use luxury\App;

class SearchController extends AppController
{
    public function indexAction() {
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;
        if ($query) {
            $products = \R::find('products', "title LIKE ?", ["%$query%"]);
        }
        $curr = App::$app->getProperty('currency');


        $this->setMeta('Поиск по: ' . h($query));
        $this->set(compact('products', 'query', 'curr'));
    }

    public function searchAction() {
        if ($this->isAjax()) {
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;
            if ($query) {
                $products = \R::getAll('SELECT id, title FROM products WHERE title LIKE ? LIMIT 11', ["%{$query}%"]);
                echo json_encode($products);
            }
        }
        die();
    }
}