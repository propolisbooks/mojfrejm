<?php

class Index extends Controller{

	function __construct(){
		parent::__construct();
	}

	public function Index()
	{
		$this->view->render("index/index");
	}
	public function proba($param = false){
		echo  "ovo je proba metotda <br>";
		if ($param != false) {
			echo "vrednost parametra je :".$param;
		}
	}
}