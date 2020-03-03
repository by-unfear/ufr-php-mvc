<?php
class App extends Bootstrap{
	
    function __construct(){
		parent::__construct();
	}

	//Roda a aplicacao
	function run(){
		$this->boot();
	}

}