<?php
spl_autoload_register('autoload');

function autoload($ClassName)
{
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if (strpos($url, 'includes') !== false) {
        $path = "../classes/";
    } else {
        $path = "classes/";
    }

    $extension = ".class.php";
    $full_path = $path . $ClassName . $extension;

    include_once $full_path;
}