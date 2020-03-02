<?php
class Router {

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
	
	function route(){
		echo 'Hello World!';
	}
}
