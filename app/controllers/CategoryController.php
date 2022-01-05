<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use luxury\App;

class CategoryController extends AppController
{
    public function categoryAction() {
        $alias = $this->route['alias'];
        $category = \R::findOne('categories', 'alias = ?', [$alias]);
        if (!$category) {
            throw new \Exception('Страница не найдена', 404);
        }

        $breadcrumbs= Breadcrumbs::getBreadcrumbs($category->id);
        $cat_model = new Category();
        $ids = $cat_model->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;

        $products = \R::find('products', "id_category IN ($ids)");
        $curr = App::$app->getProperty('currency');

        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'curr'));

    }
}