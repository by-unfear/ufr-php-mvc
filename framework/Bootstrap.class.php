<?php
class Bootstrap {

    private $methods = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'ANY' => [],
    ];

    protected $routes = [];
	
	public function __construct() {

	}
	
	function init(){
		echo 'Hello World!';
	}
}
