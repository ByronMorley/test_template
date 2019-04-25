<?php

class InputBlockExtension extends DataExtension
{

	private static $db = array(
		'Content' => 'HTMLText'
	);

	private static $has_one = array();



	private static $belongs_to = array(
		'InputBlockAnswer' => 'SectionInputBlockAnswer'
	);

	private static $summary_fields = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}

	public function contentControllerInit()
	{

	}

	public function updateCMSFields(FieldList $fields)
	{
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Content'));





	}

	public function SessionLoginForm()
	{
		return Controller::curr()->SessionLoginForm();
	}

	public function SessionEndForm()
	{
		return Controller::curr()->SessionEndForm();
	}



}