<?php

class CookieAdmin extends DataExtension {

	private static $db = array(
		'CookieTitle'=>'Varchar',
		'CookieButtonText'=>'Varchar',
		'CookieText'=>'HTMLText',
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}

	public function updateCMSFields(FieldList $fields)
	{
		$fields->addFieldsToTab(
			"Root.Cookies",
			array(
				TextField::create('CookieTitle', 'Title'),
				TextField::create('CookieButtonText', 'Button Text'),
				HtmlEditorField::create('CookieText', 'Content'),
			)
		);
	}
}