<?php
class Router extends Request{

    private $methods = [
        'GET'=>[], 
		'POST'=>[], 
		'PUT'=>[], 
		'DELETE'=>[], 
		'ANY'=>[],
		'HEAD'=>[],
		'OPTIONS'=>[],
		'PATCH'=>[]
    ];

    protected $routes = [];
	
	public function __construct() {
		parent::__construct();
	}
	


	public function get($uri, $handler, $option = []){
		$this->addRoute('GET', $uri, $handler, $option);
	}

	public function route(){
		$method= $this->getMethod();
		$uri= rtrim($this->getUri(), '/').'/';

		if(isset($this->routes[$method])){
			foreach($this->routes[$method] as $route){
				echo var_export($route, true).'<hr>';
			}
		}
	}


	private function addRoute($method, $uri, $handler, $option= []){

		if(preg_match_all('([-:\/_{}a-zA-Z]+(?!=\[[-:\/_{}a-zA-Z]+\]))', $uri, $parts)){
			$part = null;
			foreach ($parts[0] as $v) {
				$part .= $v;
				
				echo $v.'<br>';
				$this->routes[$method][]= new Route($part, $handler, $option);
			}
		}else{
			throw new Exception("[Router] Finalmente acessou aqui");

			//$this->routes[$method][]= new Route($part, $handler, $option);
		}
	}
	
}
