<?php
class Config{
	static	protected $base = '/';
	static	protected $route = '/route';
	static	protected $view = '/view';
	static	protected $model = '/model';

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