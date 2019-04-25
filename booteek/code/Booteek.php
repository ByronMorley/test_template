<?php

class Booteek extends DataExtension {

	public static $allowed_actions = array();

	private static $db = array();

	private static $has_one = array();

	private static $has_many = array(
	);

	public function contentControllerInit()
	{
		Requirements::css(BOOTEEK_DIR . '/css/style.min.css');;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}

	public function updateCMSFields(FieldList $fields)
	{



	}
}