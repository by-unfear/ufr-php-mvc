Arquivo Teste<br><br>
<?php
// echo var_export(get_defined_vars(), true);

$route->get('/', function(){
	echo 'Hello Wolrld! #1'.'<br>';
	echo var_export(get_defined_vars(), true);

});

$route->get('/bah', function(){
	echo 'Hello Wolrld! #2'.'<br>';
});