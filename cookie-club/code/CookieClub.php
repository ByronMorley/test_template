<?php

class CookieClub extends DataExtension {

	public function contentControllerInit()
	{
		Requirements::css('twitter/bootstrap/dist/css/bootstrap.min.css');
		Requirements::css(COOKIE_CLUB_DIR . '/css/style.min.css');


		Requirements::javascript('components/jquery/jquery.min.js');
		Requirements::javascript('twitter/bootstrap/dist/js/bootstrap.min.js');
		Requirements::javascript(COOKIE_CLUB_DIR . '/js/main.js');
	}

	public function ModuleDir() {
		return COOKIE_CLUB_DIR;
	}
}