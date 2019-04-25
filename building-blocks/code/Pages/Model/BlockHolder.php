<?php

class BlockHolder extends Page
{

	private static $db = array(
		'Pagination' => 'boolean'
	);

	private static $has_one = array();

	private static $has_many = array();

	private static $summary_fields = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeByName('Content');
		$fields->addFieldToTab('Root.Navigation', CheckboxField::create('Pagination', 'Add Pagination')->setValue(true));

		return $fields;
	}

	public function populateDefaults() {
		parent::populateDefaults();
		$this->Pagination = true;
	}

}