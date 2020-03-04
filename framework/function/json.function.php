<?php
	if(!function_exists('json')){
		function json($array = []){
			header('Content-Type:' . "application/json");
			if(isset($array) && count($array)>0) {
				echo json_encode($array, JSON_PRETTY_PRINT);
			}else{
				echo json_encode([], JSON_PRETTY_PRINT);
			}
		}
	}