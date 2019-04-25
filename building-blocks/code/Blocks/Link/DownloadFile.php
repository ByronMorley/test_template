<?php

class DownloadFile extends LinkElement
{

	private static $db = array();

	private static $has_one = array(
		'File' => 'File'
	);

	private static $has_many = array();

	private static $summary_fields = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();


		return $fields;
	}
}
