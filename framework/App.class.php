<?php
class App extends Router{
	
    function __construct(){
		parent::__construct();
	}

	function run(){
		$this->route();
	}

}