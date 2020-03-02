<?php
class Route {

    private $uri;
    private $handler;
    private $option;

    public function __construct($uri, $handler, $option) {
        $this->uri = $uri;
        $this->handler = $handler;
        $this->option = $option;
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
