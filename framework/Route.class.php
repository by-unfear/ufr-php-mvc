<?php
class Route {

    private $uri;
    private $handler;
	private $option;
	private $patterns= [
		'+(:int)'=>'[0-9]+',
		'+(:slug)'=>'[a-z-0-9\-]+',
		'+(:name)'=>'[a-z-A-Z]+',
		'+(:any)'=>'\w+'
	];

    public function __construct($uri, $handler, $option) {
        $this->uri = $uri;
        $this->handler = $handler;
        $this->option = $option;
	}
	
	//Verifica se a uri e a rota doa match
	public function match($uri){
		
		echo "{$this->uri} == {$uri}<br>";

		//rota simples sem parametros
		if($this->uri == $uri){
			return true;
		}

		echo $this->regex($this->uri).'<hr>';

		//Rotas com parametros
		if(preg_match($this->regex($this->uri), $uri, $args)){
			echo "## {$uri} ".var_export($args).'<br>';
			return true;
		}
		return false;


	}

	//Tranforma a uri da rota com parametros em um regex 
	private function regex($uri){
		if (!preg_match('/[^-:\/_{}a-zA-Z\d]/', $uri)){
			//Parametros especificos
			foreach ($this->patterns as $c => $v) {
				$uri = preg_replace('/{(\w+)'.$c.'}/','(?<$1>'.$v.')',$uri);
			}
			//Parametros qualquer
			$uri = preg_replace('/{(\w+)}/','(?<$1>[a-zA-Z0-9\_\-]+)',$uri);
			return "@^" . $uri . "/?$@D";
		}
		return false;
	}

	public function uri(){
		return $this->uri;
	}

	public function handler(){
		return $this->handler;
	}

	public function option(){
		return $this->option;
	}
}
