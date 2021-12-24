<?php

namespace app\controllers;

use luxury\base\Controller;
use app\models\AppModel;

class App extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
    }
}