<?php
class Config {

    //Paths
    public static $base = '/';
    public static $layout = 'layout';
    public static $upload = 'upload';

    //MVC
    public static $route = 'mvc';
    public static $controller = 'mvc/controller';
    public static $model = 'mvc/model';
    public static $view = 'mvc/view';
    public static $global = 'mvc/global';

    //DB
    public static $host = 'localhost';
    public static $user = 'root';
    public static $pass = 'teste';
    public static $db = 'banco';

    public static function setDB($host, $user, $pass, $db) {
        self::$host = $host;
        self::$user = $user;
        self::$pass = $pass;
        self::$db = $db;
    }

    public static function setPath($array = []) {
        if (isset($array['base'])) {
            self::$base = '/'.trim($array['base'], '/').'/';
        }
        if (isset($array['layout'])) {
            self::$layout = str_replace('/', DS, trim($array['layout'], '/'));
        }
        if (isset($array['upload'])) {
            self::$layout = str_replace('/', DS, trim($array['upload'], '/'));
        }
    }

    public static function setMVC($array = []) {
        if (isset($array['route'])) {
            self::$route = str_replace('/', DS, trim($array['route'], '/'));
        }
        if (isset($array['model'])) {
            self::$model = str_replace('/', DS, trim($array['model'], '/'));
        }
        if (isset($array['view'])) {
            self::$view = str_replace('/', DS, trim($array['view'], '/'));
        }
        if (isset($array['controller'])) {
            self::$controller = str_replace('/', DS, trim($array['controller'], '/'));
        }
        if (isset($array['global'])) {
            self::$control = str_replace('/', DS, trim($array['global'], '/'));
        }
    }

}
