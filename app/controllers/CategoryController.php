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


        $sql_price = '';
        if (!empty(Filter::getPrice())) {
            $price = Filter::getPrice();
            if ($price[1]) {
                if (!$price[0]) $price[0] = 0;
                $sql_price = "AND products.price > $price[0] AND products.price <= $price[1]";
            }
            else {
                $sql_price = "AND products.price >= $price[0]";
            }
        }
        $sql_part = '';
        if (!empty(Filter::getFilter())) {
            $filter = Filter::getFilter();
            if ($filter) {
                $cnt = Filter::getCountGroups($filter);
                $group = "GROUP BY id_product HAVING COUNT(id_product) = $cnt";
                $sql_part = "AND id IN (SELECT id_product FROM attribute_product WHERE id_attr IN ($filter) $group)";
            }
        }

        $_SESSION['filter_active'] = Filter::getFiltersWithProducts(\R::find('products', "id_category IN ($ids) $sql_part"));

        $total = \R::count('products', "id_category IN ($ids) $sql_part");
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $products = \R::find('products', "id_category IN ($ids) $sql_price $sql_part LIMIT $start, $perpage");
        $curr = self::Curr();

        ob_start();
        $this->loadView('products', compact('products', 'curr', 'pagination'), false);
        $productsView = ob_get_clean();

        $uri = Filter::getUri();
        if($this->isAjax()){
            $this->loadView('filter', compact('productsView', 'uri'));
        }

        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('breadcrumbs', 'productsView'));
    }
}