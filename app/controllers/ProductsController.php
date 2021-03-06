<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Products;
use luxury\App;
use luxury\Curr;

class ProductsController extends AppController
{
    use Curr;

    public function indexAction() {
        $brands = \R::find('brands', 'LIMIT 3');
        $hits = \R::find('products', "hit = '1' AND status = '1' LIMIT 8");
        $curr = self::Curr();
        $canonical = PATH;
        $this->setMeta('Главная страница');
        $this->set(compact('brands', 'hits', 'curr', 'canonical', 'user'));
    }

    public function productAction() {
        $alias = $this->route['alias'];
        $product = \R::findOne('products', "alias = ? AND status = '1'", [$alias]);
        if (!$product) {
            throw new \Exception('Страница не найдена', 404);
        }
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->id_category, $product->title);
        $gallery = \R::findAll('gallery', 'id_product = ?', [$product->id]);
        $mods = \R::findAll('modifications', 'id_product = ?', [$product->id]);
        $size = \R::getAll("SELECT size.* FROM size JOIN size_product ON size.id=size_product.id_size 
JOIN products ON size_product.id_product=products.id WHERE products.id = $product->id");
        $curr = self::Curr();
        $category = App::$app->getProperty('categories');
        $descriptions = \R::getRow('SELECT description, `additional information` FROM description WHERE id_product = ?', [$product->id]);
        $reviews = \R::getAll('SELECT review, rating, dt_add, login, users.img FROM reviews JOIN users ON (id_user = users.id) 
JOIN products ON (id_product = products.id) WHERE id_product = ?', [$product->id]);
        $related = \R::getAll("SELECT * FROM related_products JOIN products ON products.id = related_products.id_related WHERE related_products.id_product = ? LIMIT 3", [$product->id]);

        $p_model = new Products();
        $p_model->setRecentlyViewed($product->id);
        $viewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if ($viewed) {
            $recentlyViewed = \R::find('products', 'id IN (' . \R::genSlots($viewed) .') LIMIT 3', $viewed);
        }

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product','breadcrumbs','gallery','mods', 'size','curr','category', 'descriptions', 'reviews', 'related','recentlyViewed'));
    }
}