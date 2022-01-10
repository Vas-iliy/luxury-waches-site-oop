<?php

function debug($arr) {
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function redirect($http = false) {
    if ($http) {
        $redirect = $http;
    }
    else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    header('Location:' . $redirect);
    die();
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

function checkUri(string $uri) : bool {
    return !!preg_match('/\/{2,}/',$uri);
}

function trimUri(string $uri) : string {
    $arr = explode('/', $uri);
    $num = count($arr);

    if ($arr[$num-1] === '' && $num > 3) {
        unset($arr[$num-1]);
        $uri = implode('/', $arr);
    }

    return $uri;
}
