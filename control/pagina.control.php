<?php
class Control{

	public function index($teste = []){
		echo 'Hello Wolrld! #4 -> index: '.var_export($teste, true).'<br>';
	}


	public function teste($teste = []){
		echo 'Hello Wolrld! #4 -> teste: '.var_export($teste, true).'<br>';
	}

}
