<?php

class ExternalLink extends LinkElement
{

	private static $db = array(
		'Href' => 'varchar',
		'Name'=> 'varchar',
	);

	private static $has_one = array(

	);

	private static $has_many = array();

	private static $summary_fields = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		return $fields;
	}
}
