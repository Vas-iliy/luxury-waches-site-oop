<?php

namespace app\controllers;

class SearchController extends AppController
{
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