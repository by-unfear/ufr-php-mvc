Arquivo Index<br><br>
<?php
$route->get('/', function(){
	echo 'Hello Wolrld! #1';
});
$route->get('/pro', function(){
	echo 'Hello Wolrld! #2';
});
$route->get('/outro[/{teste:int}]', function(){
	echo 'Hello Wolrld! #2';
});
$route->get('/{a}', function(){
	echo 'Hello Wolrld! #3';
}, ['opt'=>false]);
$route->get('/b', 'pagina@index');