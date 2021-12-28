<?php

namespace app\controllers;

use app\widgets\currency\Currency;
use luxury\App;
use luxury\base\Controller;
use app\models\AppModel;
use luxury\Cache;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        App::$app->setProperty('currencies', Currency::getCurrencies());
        App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));
        App::$app->setProperty('categories', self::cacheCategory());
    }

    public static function cacheCategory() {
        $cache = Cache::instance();
        $categories = $cache->get('categories');
        if (!$categories) {
            $categories = \R::getAssoc('SELECT * FROM categories');
            $cache->set('categories', $categories);
        }
        return $categories;
    }
}