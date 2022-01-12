<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use app\widgets\filter\Filter;
use luxury\App;
use luxury\Curr;
use luxury\libs\Pagination;

class CategoryController extends AppController
{
    use Curr;

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

        $curr = self::Curr();

        $sql_price = Filter::refactorProductsWithFilters($curr['value'])[0];
        $sql_part = Filter::refactorProductsWithFilters()[1];

        $_SESSION['filter_active'] = Filter::getFiltersWithProducts(\R::find('products', "id_category IN ($ids) $sql_part"));

        $total = \R::count('products', "id_category IN ($ids) $sql_price $sql_part");
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $products = \R::find('products', "id_category IN ($ids) $sql_price $sql_part LIMIT $start, $perpage");

        ob_start();
        $this->loadView('products', compact('products', 'curr', 'pagination'), false);
        $productsView = ob_get_clean();

        $uri = Filter::getUri();
        Filter::deleteFilterPrice();
        if($this->isAjax()){
            $this->loadView('filter', compact('productsView', 'uri'));
        }

        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('breadcrumbs', 'productsView'));
    }
}