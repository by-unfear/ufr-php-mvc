<?php
	class IndexModel extends Model{

		function __construct($args = []){
			parent::__construct();
		}
	
		public function teste(){
			echo 'MODEL';
		}
	}