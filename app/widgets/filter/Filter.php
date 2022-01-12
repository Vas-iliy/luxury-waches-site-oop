<?php

namespace app\widgets\filter;

use luxury\Cache;
use luxury\Curr;

class Filter
{
    use Curr;
    public $groups;
    public $attrs;
    public $tpl;
    public function __construct()
    {
       $this->tpl = __DIR__ . '/filter_tpl/filter.php';
       $this->run();
    }

    public function run() {
        $cache = Cache::instance();
        $this->groups = $cache->get('filter_group');
        if (!$this->groups) {
            $this->groups = $this->getGroups();
            $cache->set('filter_group', $this->groups);
        }
        $this->attrs = $cache->get('filter_attrs');
        if (!$this->attrs) {
            $this->attrs = self::getAttrs();
            $cache->set('filter_attrs', $this->attrs);
        }
        $this->setAttrs($_SESSION['filter_active']);
        echo $this->getHtml();
    }

    protected function getHtml() {
        ob_start();
        $curr = self::Curr();
        $filter = self::getFilter();
        $price = self::getPrice();
        if (!empty($filter)) {
            $filter = explode(',', $filter);
        }
        require $this->tpl;
        return ob_get_clean();
    }

    protected function getGroups() {
        return \R::getAssoc('SELECT id, title From attribute_group');
    }

    protected static function getAttrs() {
        $data = \R::getAssoc('SELECT * FROM attribute_value');
        $attrs = [];
        foreach ($data as $k => $v) {
            $attrs[$v['id_group']][$k] = $v['value'];
        }
        return $attrs;
    }

    public static function getFilter() {
        $filter = null;
        if (!empty($_GET['filter'])) {
            $filter = preg_replace("#[^\d,]+#", '', preg_replace('/price.*/', '', $_GET['filter']));
            $filter = rtrim($filter, ',');
        }
        return $filter;
    }

    public static function getCountGroups($filter) {
        $filters = explode(',', $filter);
        $cache = Cache::instance();
        $attrs = $cache->get('filter_attrs');
        if (!$attrs) {
            $attrs = self::getAttrs();
        }
        $data = [];
        foreach ($attrs as $k => $v) {
            foreach ($v as $key => $item) {
                if (in_array($key, $filters)) {
                    $data[] = $k;
                    break;
                }
            }
        }
        return count($data);
    }



    public static function getFiltersWithProducts($products) {
        if (!empty($products)) {
            $idProducts = '';
            foreach ($products as $product) {
                $idProducts .= $product['id'] . ',';
            }
            $idProducts = rtrim($idProducts, ',');
            $filterId = \R::getAssoc("SELECT id_attr FROM attribute_product WHERE id_product IN ($idProducts)");
            $filterId = array_unique(array_merge($filterId, Filter::getNewAttr()));
            return $filterId;
        }

        return null;
    }

    public static function getNewAttr() {
        $filterId = self::getFilter();
        if (!empty($filterId)) {
            $filterId = explode(',', $filterId);
            $cache = Cache::instance();
            $attrs = $cache->get('filter_attrs');
            $newAttrs = [];
            $res = false; $count = 0;

            foreach ($attrs as $key => $attr) {
                if ($count < 1) {
                    foreach ($attr as $k => $v) {
                        if (!$res) {
                            foreach ($filterId as $filter) {
                                if ($filter == $k) {
                                    $res = true;
                                    break;
                                }
                            }
                        }
                    }
                    if ($res) {
                        foreach ($attr as $k => $v) {
                            $newAttrs[] = $k;
                        }
                        $res = false;
                        $count++;
                    }
                }
                else {
                    break;
                }
            }
            return $newAttrs;
        }
        return [];
    }

    public function setAttrs($filters) {
        if (!empty($filters)) {
            foreach ($this->attrs as $key => $item) {
                foreach ($item as $id_attrs => $title) {
                    foreach ($filters as $k => $v) {
                        if ($id_attrs == $v) {
                            $this->attrs[$key][$id_attrs] = [$title, ''];
                            break;
                        }
                    }
                }
            }
        }
        foreach ($this->attrs as $key => $item) {
            foreach ($item as $id_attrs => $title) {
                if (!is_array($title)) {
                    $this->attrs[$key][$id_attrs] = [$title, 'disabled'];
                }
            }
        }
    }

    public static function getPrice() {
        $price = [];
        if (!empty($_GET['filter']) && preg_match('/price:.*/', $_GET['filter'])) {
            $price = preg_replace('/.*price:/', '', $_GET['filter']);
            $price = explode(',', $price);
        }
        return $price;
    }

    public static function getUri() {
        $filter = self::getFilter();
        $price = self::getPrice();
        if (!empty($filter) || !empty($price)) {
            $url = preg_replace('/filter(.+?)(&|$)/', '', $_SERVER['REQUEST_URI']);
            $newUrl = $url . (preg_match('/\?/', $url) ? '&' : '?') . "filter=" . $_GET['filter'];
        }
        else {
            $newUrl = $_SERVER['REQUEST_URI'];
        }
        $newUrl = str_replace('&&', '&', $newUrl);
        $newUrl = str_replace('?&', '?', $newUrl);
        return $newUrl;
    }

    public static function deleteFilterPrice() {
        if (!empty($_SESSION['price'])) {
            $url = self::getUri();
            $get = preg_replace('/^.+\?/', '', $url);
            if ($get && preg_match('/\?/', $url)) {
                $get = explode('&', $get);
                $newGet = '';
                foreach ($get as $item) {
                    if (preg_match('/filter.*/', $item)) {
                        $item = rtrim(preg_replace('/price.*$/', '', $item), ',');
                    }
                    $newGet .= $item . '&';
                }
                $newGet = preg_replace('/\?.*$/', '', $url) . '?' . rtrim($newGet, '&');
            }
            else {
                $newGet = $url;
            }
            unset($_SESSION['price']);
            redirect($newGet);
        }
    }

    public static function refactorProductsWithFilters($curr = 1) {
        $sql_price = ''; $sql_part = '';
        if (!empty(Filter::getPrice())) {
            $price = Filter::getPrice();
            if ($price[1]) {
                if (!$price[0]) $price[0] = 0;
                $sql_price = "AND products.price > $price[0]/$curr AND products.price <= $price[1]/$curr";
            }
            else {
                $sql_price = "AND products.price >= $price[0]/$curr";
            }
        }
        if (!empty(Filter::getFilter())) {
            $filter = Filter::getFilter();
            if ($filter) {
                $cnt = Filter::getCountGroups($filter);
                $group = "GROUP BY id_product HAVING COUNT(id_product) = $cnt";
                $sql_part = "AND id IN (SELECT id_product FROM attribute_product WHERE id_attr IN ($filter) $group)";
            }
        }
        return [$sql_price, $sql_part];
    }
}