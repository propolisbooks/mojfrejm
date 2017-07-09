<?php

class View extends Controller{

	function __construct(){
	   //echo "ovo j Pregled stranice<br>";
	}
	public function render($ime){
	   require "views/header.php";
       require "views/".$ime.".php";
       require "views/footer.php";
	}

	
}