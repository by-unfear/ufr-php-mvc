## Framework simples em PHP

### Objetivo #1

Duas camadas de roteador, primera camada pega a primeira parte da url e direciona para um arquivo caso ele exista.

E na segunda camada é um roteamento padrão com request.

Tipo um Bootstrap seguido com um Router.

Ex:
/produtos/editar/12

Primeira camada, verificar se o arquivo route/produto.route.php existe.

Segunda camada tem o roteamento dos request para os controles.

``` 
<?php
	$route = new Route;

	$route->get('/', function(){

	});
	
	$route->any('/{acao:slug}/{id:int}', 'site/produto@{acao}');
 ```