Arquivo Index<br><br>
<?php


$route->get('/', function(){
	$model = model('index', ['a'=>'teste']);
	$model->teste();

});

$route->get('/a', function(){
	echo 'Hello Wolrld! #2'.'<br>';
});


$route->get('/b[/{teste:int}]', function($teste = 'nada'){
	echo 'Hello Wolrld! #3: '.var_export($teste, true).'<br>';
});

$route->get('/b/{teste}', function($teste = 'nada'){
	echo 'Hello Wolrld! #3: '.var_export($teste, true).'<br>';
});


$route->get('/c/1', 'pagina');

$route->get('/c/{teste}', 'pagina@index');

$route->get('/c/c', 'pagina@teste');

$route->get('/p/{metodo}', 'pagina@{metodo}');