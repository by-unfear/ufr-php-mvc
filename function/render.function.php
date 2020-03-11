<?php
if (!function_exists('render')) {
    function render($path = null, $args = []) {
        if ($path !== null) {
            if (file_exists(APPDIR.str_replace('/', DS, Config::$layout . DS . $path . '.php'))) {
                if (is_array($args) && count($args) > 0) {
                    foreach ($args as $c => $v) {
                        ${$c} = $v;
                    }
                }
                unset($args);
                unset($c);
                unset($v);
                require APPDIR.str_replace('/', DS, Config::$layout . DS . $path . '.php');
            } else {
                Debug::get('Render não encontrada ['.str_replace('/', DS, Config::$layout . DS . $path . '.php').']');
            }
        }
    }
}
