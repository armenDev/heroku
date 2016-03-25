<?php

    $url = $_SERVER['REQUEST_URI'];
    $uri = substr($url, 1);
    $uri = preg_replace('/\?.*/', '', $uri);

    function __autoload($class_name){
        $class_name = str_replace("_","/",$class_name);
        include $class_name.'.php';
    }

    new System_routes($uri);

?>

