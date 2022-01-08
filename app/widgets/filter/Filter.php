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
            $this->attrs = $this->getAttrs();
            $cache->set('filter_attrs', $this->attrs);
        }
        echo $this->getHtml();
    }

    protected function getHtml() {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

    protected function getGroups() {
        return \R::getAssoc('SELECT id, title From attribute_group');
    }

    protected function getAttrs() {
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
}