<?php

namespace app\controllers;

use app\widgets\currency\Currency;
use luxury\base\Controller;
use app\models\AppModel;

class App extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        \luxury\App::$app->setProperty('currencies', Currency::getCurrencies());
        \luxury\App::$app->setProperty('currency', Currency::getCurrency(
            \luxury\App::$app->getProperty('currencies')));
    }
}