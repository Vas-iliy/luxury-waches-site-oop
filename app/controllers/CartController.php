<?php


namespace app\controllers;


class CartController extends AppController
{
    public function addAction() {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
        $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;
        $mod = null;

        if ($id) {
            $product = \R::findOne('products', 'id=?', [$id]);
            if (!$product) {
                return false;
            }
            if ($mod_id) {
                $mod = \R::findOne('modifications', 'id=? AND id_product=?', [$mod_id, $id]);
            }
        }
        die();
    }
}