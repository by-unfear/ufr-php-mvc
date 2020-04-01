<?php
class F {
    public static function __callStatic($f, $args) {
        if (function_exists($f) !== true) {
            if (!file_exists(APPDIR . DS . 'framework' . DS . 'function' . DS . $f . '.function.php')) {
                return false;
            }
            require APPDIR . DS . 'framework' . DS . 'function' . DS . $f . '.function.php';
        }
        return call_user_func_array($f, $args);
    }
}
