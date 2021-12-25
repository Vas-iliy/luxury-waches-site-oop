<?php

namespace app\controllers;

class CurrencyController extends App
{
    public function changeAction() {
        $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;
        if ($currency) {
            $curr = \R::findOne('currency', 'code = ?', [$currency]);
            if (!empty($curr)) {
                $_SESSION['currency'] = $currency;
            }
        }
        redirect();
    }

}