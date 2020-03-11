<?php
if (!function_exists('view')) {
    function view($path = null, $args = []) {
        if ($path !== null) {
            if (file_exists(str_replace('/', DS, Config::$view . DS . $path . '.view.php'))) {
                if (is_array($args) && count($args) > 0) {
                    foreach ($args as $c => $v) {
                        ${$c} = $v;
                    }
                }
                unset($args);
                unset($c);
                unset($v);
                require str_replace('/', DS, Config::$view . DS . $path . '.view.php');
            } else {
                Debug::get('View não encontrada [\\'.str_replace('/', DS, Config::$view . DS . $path . '.view.php').']');
            }
        }
    }
}
