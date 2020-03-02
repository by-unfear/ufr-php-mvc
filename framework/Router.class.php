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
	
	function get(){
		echo 'Hello World!';
	}
}
