<?php

namespace app\controllers;

use app\models\User;
use app\widgets\currency\Currency;
use luxury\App;
use luxury\base\Controller;
use app\models\AppModel;
use luxury\Cache;

class AppController extends Controller
{
    public $user;
    public $uri;
    public function __construct($route)
    {
        parent::__construct($route);
        $this->uri = $_SERVER['REQUEST_URI'];
        new AppModel();
        if (checkUri($this->uri) || $this->uri !== trimUri($this->uri)) {
            throw new \Exception('Страница не найдена', 404);
        }
        App::$app->setProperty('currencies', Currency::getCurrencies());
        App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));
        App::$app->setProperty('categories', self::cacheCategory());
        $this->user = User::getUser();
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