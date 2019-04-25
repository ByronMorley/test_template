<?php

class InputBlockAnswer extends DataObject
{
	private static $db = array(
		'WritingFrame' => 'HTMLText'
	);

	private static $has_one = array(
		'User' => 'SessionUser',
		'Section' => 'SectionInputBlock',
		'InputFrame'=>'InputFrame'
	);

	private static $has_many = array();

	private static $summary_fields = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		return $fields;
	}
}