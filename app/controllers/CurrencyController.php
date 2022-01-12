<?php

namespace app\controllers;

use app\models\Cart;

class CurrencyController extends AppController
{
    public function changeAction() {
        $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;
        if ($currency) {
            $curr = \R::findOne('currency', 'code=?', [$currency]);
            if (!empty($curr)) {
                $_SESSION['currency'] = $currency;
                Cart::recalc($curr);
                $_SESSION['price'] = 'delete';
            }
        }
        redirect();
    }

}