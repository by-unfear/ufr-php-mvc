# Framework simples em PHP



## Router primário

Os arquivos de 'roteamento' estão na pasta `/mvc/router`, sua extensão deve ser `.router.php` e será utilizado o primeiro nó da uri para tentar buscar o router, case não encontre, ele tentará carregar o arquivo `index.router.php`.

``` php
	//index.router.php
	//uri: /
	$route->get('/', function(){
		echo 'Index';
	});
	//uri: /contato
	$route->get('/contato', function(){
		echo 'Index -> contato';
	});

	//produto.router.php
	//uri: /produto
	$route->get('/', function(){
		echo 'Produto';
	});
	//uri: /produto/detalhe
	$route->get('/detalhe', function(){
		echo 'Produto -> detalhe';
	});
 ```

 ## Router secundário

 Ocorre dentro dos arquivos `.router.php`, neste momento pode ser estabelecido os métodos, rotas e controles.

``` php
	$route->metodo(rota, controle);
```
Seus métodos podem ser `get`, `post`, `put`, `delete`, `any` 
``` php
	$route->get('/', function(){});
	$route->post('/', function(){});
	$route->put('/', function(){});
	$route->delete('/', function(){});
	$route->any('/', function(){});
```
E nas rotas é possivel filtrar alguns parametros passando uma string entre chaves `{param}`, também é possível determinar seus tipos entre, `int`, `slug`, `name` e `any` 
``` php
	$route->delete('/prod/excluir/{id}', function($id = null){});

	$route->delete('/detalhe/{id:int}', function($id = null){});

	$route->delete('/cat/{cat:name}/{id:slug}', function($cat = null, $id = null){});
```
Também é possivel definir rotas parciais utilizando `[`/url`]`
``` php
	$route->delete('/produto[/{id}]', function($id = null){});

	$route->delete('/cat[/{cat:name}][/{id:slug}]', function($cat = null, $id = null){});
```
E nos controle é possível adicionar o controle diretamente ou indicar o caminho do objeto e até o seu método, inclusive pode também utilizar um parametro para alterar o caminho.
``` php
	$route->delete('/prod/excluir/{id}', function($id = null){
		//Código do controle
	});
	//controle em produto/produto(objeto)->index(id);
	$route->delete('/detalhe/{id:int}', 'produto/detalhe');

	//controle em produto(objeto)->categoria(cat, id);
	$route->delete('/cat/{cat:name}/{id:slug}', 'produto@categoria');

	//controle em perfil(objeto)->{acao}(id);
	$route->delete('/perfil/{acao:name}/{id:slug}', 'perfil@{acao}');
```
