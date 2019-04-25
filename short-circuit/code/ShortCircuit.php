<?php

class ShortCircuit extends DataExtension {

	public function SessionActive(){
		return Session::get('user');
	}

	public function Username(){
		return unserialize(Session::get('user'))->Name;
	}

	public function contentControllerInit()
	{
		/*  -- Stylesheets --*/
		Requirements::css('twitter/bootstrap/dist/css/bootstrap.min.css');
		Requirements::css('components/font-awesome/css/font-awesome.min.css');

		Requirements::css(SHORT_CIRCUIT_DIR .'/css/style.min.css');

		/*  -- Javascript --*/
		Requirements::javascript('components/jquery/jquery.min.js');
		Requirements::javascript('twitter/bootstrap/dist/js/bootstrap.min.js');

		Requirements::javascript(SHORT_CIRCUIT_DIR .'/js/main.min.js');

	}

}