<?php

namespace app\controllers;

class CurrencyController extends AppController
{
    public function changeAction() {
        $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;
        if ($currency) {
            $curr = \luxury\App::$app->getProperty('currency');

            if (!empty($curr)) {
                $_SESSION['currency'] = $currency;
            }
        }
        redirect();
    }

}