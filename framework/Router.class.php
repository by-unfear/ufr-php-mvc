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
	
	/**
	 * Metodos
	 */
	public function get($uri, $handler, $option = []){
		$this->addRoute('GET', $uri, $handler, $option);
	}


	/**
	 * Executar as rotas
	 */
	public function route(){
		$method= $this->getMethod();
		$uri= rtrim($this->getUri(), '/');

		//Verifica rotas conforme o metodo
		if(isset($this->routes[$method])){
			foreach($this->routes[$method] as $route){
				if ($route->match($uri)) {
					// echo var_export($route, true).'<hr>';
				}
			}
		}
	}


	/**
	 * Adicionar nova rota
	 */
	private function addRoute($method, $uri, $handler, $option= []){

		//Separa em partes rotas dinamicas ex: /pagina[/acao][/id] => /pagina, /pagina/acao, /pagina/acao/id
		if(preg_match_all('([-:\/_{}a-zA-Z]+(?!=\[[-:\/_{}a-zA-Z]+\]))', $uri, $parts)){
			$part = null;
			foreach ($parts[0] as $v) {
				$part .= $v;
				$this->routes[$method][]= new Route($part, $handler, $option);
			}
		}else{
			//Acho que nunca cai nessa condicao
			throw new Exception("[Router] Finalmente acessou aqui");

			//$this->routes[$method][]= new Route($part, $handler, $option);
		}
	}
	
}
