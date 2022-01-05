<?php

namespace app\models;

use luxury\App;

class Category extends AppModel
{
    public function getIds($id) {
        $categories = App::$app->getProperty('categories');
        $ids = null;
        foreach ($categories as $k => $v) {
            if ($v['id_parent'] == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }
}