<?php
class Bootstrap extends Request{

	public function __construct() {
		parent::__construct();
	}
	
	public function boot(){
		$file = explode('/', ltrim($this->getUri(), '/'))[0];
		if($this->route($file)){
		}else if($this->route('index')){
		}else{
			echo 'Sem rota index.route<br>';
		}
	}

	private function route($file){
		if(file_exists(str_replace('/', DS, ltrim(Config::get('route'), '/').'/'.$file.'.route.php'))){
			$route = new Router($file);
			require_once(str_replace('/', DS, ltrim(Config::get('route'), '/').'/'.$file.'.route.php'));
			$route->route();
			return true;
		}
		return false;
	}

}
