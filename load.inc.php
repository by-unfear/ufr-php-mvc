<?php
define('APPDIR', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

function loadFramework($name) {
    $file = APPDIR . DS . 'framework' . DS . $name . '.class.php';
    // echo '<br>Try: '.$file;
    if (file_exists($file)) {
        require_once $file;
    }else{
        $file = APPDIR . DS . str_replace('/', DS, Config::$global . DS . $name . '.php');
        if (file_exists($file)) {
            require_once $file;
        }
    }
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

function sistemaLogErros($code = null, $msg = null, $file = null, $line = null, $trace = null) {
    Debug::error($code, $msg, $file, $line, $trace);
}

//function sistemaTratamentoEssecoes(Exception $e, $trace= false){ // php < 7
function sistemaTratamentoEssecoes(Throwable $e, $trace = false) { // php 7
    Debug::Exception($e);
    exit();
}

set_error_handler('sistemaLogErros');
set_exception_handler('sistemaTratamentoEssecoes');

spl_autoload_register("loadFramework");
