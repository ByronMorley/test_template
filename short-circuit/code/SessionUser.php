<?php

class SessionUser extends DataObject
{

	private static $db = array(
		'Name' => 'Varchar',
		'Token' => 'Varchar(255)',
	);

	private static $has_one = array();

	private static $has_many = array();

	private static $belongs_to = array(
		'InputBlockAnswer' => 'SectionInputBlockAnswer'
	);


	private static $summary_fields = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		return $fields;
	}

	public function startSession()
	{
		Session::set('user', serialize($this));
		Session::set_timeout(600);
	}

	public function endSession()
	{
		Session::clear('user');
	}
}