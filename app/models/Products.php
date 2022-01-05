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
}