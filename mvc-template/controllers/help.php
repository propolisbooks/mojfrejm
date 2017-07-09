<?php

class Help extends Controller{

	function __construct()
	{
		parent::__construct();
	}


	public function Index()
	{
		$this->view->render('help/index');
	}
	
}