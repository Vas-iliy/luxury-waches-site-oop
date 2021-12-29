<?php


namespace app\models;


use luxury\App;

class Products extends AppModel
{
    public function setRecentlyViewed($id) {
        $recentlyViewed = $this->getAllRecentlyViewed();
        if (!$recentlyViewed) {
            setcookie('recentlyViewed', $id, time() + 3600*24, PATH);
        }
        else {
            $recentlyViewed = explode('.', $recentlyViewed);
            if (!in_array($id, $recentlyViewed)) {
                $recentlyViewed[] = $id;
                $recentlyViewed = implode('.', $recentlyViewed);
                setcookie('recentlyViewed', $recentlyViewed, time() + 3600*24, PATH);
            }
        }
    }

    public function getRecentlyViewed() {
        if (!empty($_COOKIE['recentlyViewed'])) {
            $recentlyViewed = $this->getAllRecentlyViewed();
            $recentlyViewed = explode('.', $recentlyViewed);
            return array_slice($recentlyViewed, -3);
        }
        return false;
    }

    public function getAllRecentlyViewed() {
        if (!empty($_COOKIE['recentlyViewed'])) {
            return $_COOKIE['recentlyViewed'];
        }
        return false;
    }

    public static function getBreadcrumbs($id_cat, $name = '') {
        $cats = App::$app->getProperty('categories');
        $breadcrumbs_array = self::getParts($cats, $id_cat);
        $breadcrumbs = "<li><a href='" . PATH . "'>Home</a></li>";
        if ($breadcrumbs_array) {
            foreach ($breadcrumbs_array as $alias => $title) {
                $breadcrumbs .= "<li><a href='" . PATH . "/category/{$alias}'>{$title}</a></li>";
            }
        }
        if ($name) {
            $breadcrumbs .= "<li>{$name}</li>";
        }
        return $breadcrumbs;
    }

    public static function getParts($cats, $id_cat) {
        if (!$id_cat) return false;
        $breadcrumbs = [];
        foreach ($cats as $k => $v) {
            if (isset($cats[$id_cat])) {
                $breadcrumbs[$cats[$id_cat]['alias']] = $cats[$id_cat]['title'];
                $id_cat = $cats[$id_cat]['id_parent'];
            }
            else break;
        }
        return  array_reverse($breadcrumbs, true);
    }

}