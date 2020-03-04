<?php
class Config{

	//Paths
	static	protected $base = '/';
	static	protected $route = '/route';
	static	protected $control = '/control';
	static	protected $model = '/model';
	static	protected $view = '/view';
	static	protected $layout = '/layout';

	//DB
	static protected $host = 'localhost';
	static protected $login = 'root';
	static protected $senha = 'teste';
	static protected $banco = 'raquel';

	static function set($param, $value){
		if(isset(self::$$param)){
			self::$$param = $value;
		}
	}
	static function get($param){
		if(isset(self::$$param)){
			return self::$$param;
		}
	}
}