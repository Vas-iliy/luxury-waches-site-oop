<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Products;
use luxury\App;

class ProductsController extends AppController
{
    public function indexAction() {
        $brands = \R::find('brands', 'LIMIT 3');
        $hits = \R::find('products', "hit = '1' AND status = '1' LIMIT 8");
        $curr = App::$app->getProperty('currency');
        $this->setMeta('Главная страница');
        $this->set(compact('brands', 'hits', 'curr'));
    }

    public function productAction() {
        $alias = $this->route['alias'];
        $product = \R::findOne('products', "alias = ? AND status = ?", [$alias, '1']);
        if (!$product) {
            throw new \Exception('Страница не найдена', 404);
        }
        $breadcrumbs = Products::getBreadcrumbs($product->id_category, $product->title);
        $gallery = \R::findAll('gallery', 'id_product = ?', [$product->id]);
        $mods = \R::findAll('modifications', 'id_product = ?', [$product->id]);
        $curr = App::$app->getProperty('currency');
        $category = App::$app->getProperty('categories');
        $related = \R::getAll("SELECT * FROM related_products JOIN products ON products.id = related_products.id_related WHERE related_products.id_product = ? LIMIT 3", [$product->id]);

        $p_model = new Products();
        $p_model->setRecentlyViewed($product->id);
        $viewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if ($viewed) {
            $recentlyViewed = \R::find('products', 'id IN (' . \R::genSlots($viewed) .') LIMIT 3', $viewed);
        }

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product','breadcrumbs','gallery','mods','curr','category', 'related','recentlyViewed'));
    }
}