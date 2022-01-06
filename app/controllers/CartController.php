<?php


namespace app\controllers;


use app\models\Cart;

class CartController extends AppController
{
    public function addAction() {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
        $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;
        $size_id = !empty($_GET['size']) ? (int)$_GET['size'] : null;
        $mod = null;
        $size = null;

        if ($id) {
            $product = \R::findOne('products', 'id=?', [$id]);
            if (!$product) {
                return false;
            }
            if ($mod_id) {
                $mod = \R::findOne('modifications', 'id=? AND id_product=?', [$mod_id, $id]);
            }
            if ($size_id) {
                $size = \R::findOne('size', 'id=?', [$size_id]);
            }
        }
        $cart = new Cart();
        $cart->addToCart($product, $qty, $mod, $size);
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function showAction() {
        $this->loadView('cart_modal');
    }

    public function deleteAction() {
        $id = !empty($_GET['id']) ? $_GET['id'] : null;
        if (isset($_SESSION['cart'][$id])) {
            $cart = new Cart();
            $cart->deleteItem($id);
        }
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function clearAction() {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }
}