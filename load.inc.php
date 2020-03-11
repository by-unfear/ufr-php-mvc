<?php
define('APPDIR', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

function loadFramework($name) {
    $file = APPDIR . DS . 'framework' . DS . $name . '.class.php';
    if (file_exists($file)) {
        require_once $file;
	}
	// TODO: (roberson) repensar isso aqui
    // $file = APPDIR . DS . 'mvc' . DS . 'global' . DS . $name . '.class.php';
    // if (file_exists($file)) {
    //     require_once $file;
    // }
}

function loadFunction() {
    $path = APPDIR . DS . 'framework' . DS . 'function';
    foreach (scandir($path) as $v) {
        if (preg_match('/^[a-zA-Z0-9]+\.(function.php)$/', $v)) {
            require_once $path . DS . $v;
        }
    }
}
loadFunction();

spl_autoload_register("loadFramework");
