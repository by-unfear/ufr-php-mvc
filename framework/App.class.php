<?php
class App extends Bootstrap{
	
    function __construct(){
		parent::__construct();
	}

	function run(){
		$this->boot();
	}

}