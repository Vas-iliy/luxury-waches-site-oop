<?php


namespace app\models;


use luxury\App;

class Breadcrumbs
{
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