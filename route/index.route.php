Arquivo Index<br><br>
<?php
$route->get('/', function(){
	echo 'Hello Wolrld! #1';
});
$route->get('/outro', function(){
	echo 'Hello Wolrld! #2';
});
$route->get('/outro', function(){
	echo 'Hello Wolrld! #2';
});
$route->get('/b', function(){
	echo 'Hello Wolrld! #3';
}, ['opt'=>false]);
$route->get('/b', 'pagina@index');