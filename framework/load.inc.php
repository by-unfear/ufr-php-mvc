<?php
define('APPDIR', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

function loadFramework($name) {
    $file = APPDIR . DS . 'framework' . DS . $name . '.class.php';
    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register("loadFramework");
