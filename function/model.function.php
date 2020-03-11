<?php
if (!function_exists('model')) {
    function model($path = null, $args = []) {
        if ($path !== null) {
            $file = str_replace('/', DS, Config::$model . DS . $path . '.model.php');
            if (file_exists($file)) {
                require_once $file;
                $model = array_reverse(explode('/', $path))[0];
                $model = str_replace(['-', '_'], '', $model) . 'Model';
                return new $model($args);
            } else {
                Debug::get('View não encontrada [\\'.str_replace('/', DS, Config::$model . DS . $path . '.model.php').']');
            }
        }
    }
}
