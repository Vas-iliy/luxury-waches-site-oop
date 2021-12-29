<?php


namespace app\models;


use luxury\App;

class Cart extends AppModel
{
    public function addToCart($product, $qty = 1, $mod = null) {
        if ($mod) {
            $id = "{$product->id}-{$mod->id}";
            $title = "{$product->title} ({$mod->title})";
            $price = $mod->price;
        }
        else {
            $id = $product->id;
            $title = $product->title;
            $price = $product->price;
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $qty;
        }
        else {
            $_SESSION['cart'][$id] = [
                'qty' => $qty,
                'title' => $title,
                'alias' => $product->alias,
                'price' => $price*App::$app->getProperty('currency')['value'],
                'img' => $product->img
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty']+$qty
            : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum']+$qty*App::$app->getProperty('currency')['value']*$price
            : $qty*App::$app->getProperty('currency')['value']*$price;;
    }
}