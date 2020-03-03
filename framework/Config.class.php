<?php
class Config{
	static	protected $base = '/';
	static	protected $route = '/route';
	static	protected $control = '/control';
	static	protected $model = '/model';
	static	protected $view = '/view';

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