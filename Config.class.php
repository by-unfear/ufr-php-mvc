<?php
class Config {

    //Paths
    public static $base = '/';
    public static $layout = '/layout';

    //MVC
    public static $route = '/route';
    public static $control = '/mvc/controller';
    public static $model = '/mvc/model';
    public static $view = '/mvc/view';

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

    public static function setPath($base = null, $layout = null) {
        if (null != $base) {
			self::$base = $base;
		}
        if (null != $layout) {
			self::$layout = $layout;
		}
    }

    public static function setMVC($route = null, $control = null, $model = null, $view = null) {
		if (null != $route) {
			self::$route = str_replace('/', DS, trim($route, '/'));
		}
		if (null != $control) {
			self::$control = str_replace('/', DS, trim($control, '/'));
		}
		if (null != $model) {
			self::$model = str_replace('/', DS, trim($model, '/'));
		}
		if (null != $view) {
			self::$view = str_replace('/', DS, trim($view, '/'));
		}
    }

}
