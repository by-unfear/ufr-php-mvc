<?php
class Route {

    private $uri;
    private $handler;
    private $args;
    private $option;
    private $patterns = [
        '+(:int)' => '[0-9]+',
        '+(:slug)' => '[a-z-0-9\-]+',
        '+(:name)' => '[a-z-A-Z]+',
        '+(:any)' => '\w+',
    ];

    public function __construct($uri, $handler, $option) {
        $this->uri = $uri;
        $this->handler = $handler;
        $this->option = $option;
    }

    //Verifica se a uri e a rota doa match
    public function match($uri) {
		//rota simples sem parametros
        if ($this->uri == $uri) {
			return true;
		}
		//Rotas com parametros
		//echo "{$this->regex($this->uri)}, {$uri}";
        if (preg_match($this->regex($this->uri), $uri, $args)) {
			
			//Salvar valor dos argumentos
			$this->args = array_intersect_key($args, array_flip(array_filter(array_keys($args), 'is_string')));
			
			//Caso o argumento interaja com a string do controle ex: $route->get(pagina/{metodo}, 'control/pagina@{metodo}');
			if(is_string($this->handler) && preg_match_all('({\w+})', $this->handler, $tmp)){
				foreach ($tmp[0] as $v) {
					$c= str_replace(['{','}'], '', $v);
					if(isset($this->args[$c])){
						$this->handler= str_replace($v, $this->args[$c], $this->handler);
						unset($this->args[$c]);
					}
				}
			}


            return true;
        }
        return false;
    }
	
    //Tranforma a uri da rota com parametros em um regex
    private function regex($uri) {
		//Apenas caracteres validos
        if (!preg_match('/[^-:\/_{}a-zA-Z\d]/', $uri)) {
			//Parametros especificos ex: /pagina/{id:slug}
            foreach ($this->patterns as $c => $v) {
				$uri = preg_replace('/{(\w+)' . $c . '}/', '(?<$1>' . $v . ')', $uri);
            }
            //Parametros qualquer ex: /pagina/{id}
			$uri = preg_replace('/{(\w+)}/', '(?<$1>[a-zA-Z0-9\_\-]+)', $uri);
            return "@^" . $uri . "/?$@D";
        }
        return false;
    }

    public function uri() {
        return $this->uri;
    }

    public function handler() {
        return $this->handler;
    }

    public function args() {
        return $this->args;
    }

    public function option() {
        return $this->option;
    }
}
