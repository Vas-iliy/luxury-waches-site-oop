<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use luxury\App;
use luxury\libs\Pagination;

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

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = App::$app->getProperty('pagination');

        if ($this->isAjax()) {
            debug($_GET);
            die();
        }

        $total = \R::count('products', "id_category IN ($ids)");
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $products = \R::find('products', "id_category IN ($ids) LIMIT $start, $perpage");
        $curr = App::$app->getProperty('currency');

        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'curr', 'pagination'));

    }
}