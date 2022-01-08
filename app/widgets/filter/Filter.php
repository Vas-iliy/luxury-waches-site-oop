<?php

namespace app\widgets\filter;

use luxury\Cache;

class Filter
{
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
        echo $this->getHtml();
    }

    protected function getHtml() {
        ob_start();
        $filter = self::getFilter();
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
            $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
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
}