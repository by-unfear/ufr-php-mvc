<?php
class Router extends Request {

    private $methods = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'ANY' => [],
];
	private $raiz = '';

    protected $routes = [];

    public function __construct($raiz = '') {
		parent::__construct();
		if($raiz != null){
			$this->raiz = '/'.$raiz;
		}
    }

    /**
     * Metodos
     */
    public function get($uri, $handler, $option = []) {
        $this->addRoute('GET', $uri, $handler, $option);
    }

    public function post($uri, $handler = null, $option = []) {
        $this->addRoute('POST', $uri, $handler, $option);
    }

    public function put($uri, $handler = null, $option = []) {
        $this->addRoute('PUT', $uri, $handler, $option);
    }

    public function delete($uri, $handler = null, $option = []) {
        $this->addRoute('DELETE', $uri, $handler, $option);
    }

    public function any($uri, $handler = null, $option = []) {
        $this->addRoute('ANY', $uri, $handler, $option);
    }

    /**
     * Executar as rotas
     */
    public function route() {
        $method = $this->getMethod();
		$uri = rtrim($this->getUri(), '/') . '/';
		
        //Verifica rotas conforme o metodo
        if (isset($this->routes[$method])) {
			foreach ($this->routes[$method] as $route) {
				if ($route->match($uri)) {
                    $this->getController($route);
                }
            }
        }
        //Caso seja qualquer um
        if (isset($this->routes['ANY'])) {
            foreach ($this->routes['ANY'] as $route) {
                if ($route->match($uri)) {
                    $this->getController($route);
                }
            }
        }
    }

    /**
     * Adicionar nova rota
     */
    private function addRoute($method, $uri, $handler, $option = []) {

		$uri = $this->raiz.$uri;

		//Separa em partes rotas dinamicas ex: /pagina[/acao][/id] => /pagina, /pagina/acao, /pagina/acao/id
        if (preg_match_all('([-:\/_{}a-zA-Z\d]+(?!=\[[-:\/_{}a-zA-Z\d]+\]))', $uri, $parts)) {
            $part = null;
            foreach ($parts[0] as $v) {
                $part .= $v;
                $this->routes[$method][] = new Route($part, $handler, $option);
            }
        } else {
            //Acho que nunca cai nessa condicao
            throw new Exception("[Router] Finalmente acessou aqui");

            //$this->routes[$method][]= new Route($part, $handler, $option);
        }
    }

    /**
     * Obter controle seja funcao ou objeto
     */
    private function getController($route) {

        //Dados da rota
        $handler = $route->handler();
		$args = $route->args();
		
		$args = is_array($args)?$args:[];
		
        //Funcao
        if (is_callable($handler)) {
            return call_user_func_array($handler, $args);
        }

        //Endereco do objeto do controle
        if (is_string($handler)) {

            //Caso tenha arroba para indicar o metodo controle@metodo
            if (strpos($handler, '@')) {
                list($controller, $method) = explode('@', $handler);
            } else {
                //Senao chama o medoto index do controle
                $controller = $handler;
                $method = 'index';
            }

            //Verifica se arquivo existe
            $file = str_replace('/', DS, ltrim(Config::get('control'), '/') . DS . $controller . '.controller.php');
            if (file_exists($file)) {
                require_once $file;

				//Criar objeto
				$controller= str_replace(['-','_'],'',$controller).'Controller';
				$method= str_replace(['-','_'],'',$method);
				
				
				//Criar objeto
				$controller = array_reverse(explode('/', $controller))[0];
				$controller= new $controller();


				//Carregar metodo ou metodo index
                if (method_exists($controller, $method)) {
                    return call_user_func_array([$controller, $method], $args);
                } else if (method_exists($controller, 'index')) {
                    return call_user_func_array([$controller, 'index'], $args);
                }
            }
        }
    }

}
