<?php

class BlockPage extends Page
{

	private static $db = array(
		'Tabbed' => 'boolean'
	);

	private static $has_one = array();

	private static $has_many = array();

	private static $summary_fields = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', CheckboxField::create('Tabbed'));

		$fields->removeByName('Content');

		return $fields;
	}
}