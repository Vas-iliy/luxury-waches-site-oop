<?php

use luxury\Router;

Router::add('^product/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Products', 'action' => 'product']);
Router::add('^category/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Category', 'action' => 'category']);



//default routes
Router::add('^admin$', ['controller' => 'Main', 'action' => 'index',
    'prefix' => 'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$',
    ['prefix' => 'admin']);

Router::add('^$', ['controller' => 'Products', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');