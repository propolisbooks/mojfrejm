<?php

class Error extends Controller{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->view->poruka =  "Ova stranica ne postoji!<br>";
		$this->view->render("error/index");
	}
}

