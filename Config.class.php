<?php
class Config{

	//Paths
	static	protected $base = '/';
	static	protected $layout = '/layout';

	//MVC
	static	protected $route = '/mvc/router';
	static	protected $control = '/mvc/controller';
	static	protected $model = '/mvc/model';
	static	protected $view = '/mvc/view';

	//DB
	static protected $host = 'localhost';
	static protected $login = 'root';
	static protected $senha = 'teste';
	static protected $banco = 'banco';

	
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