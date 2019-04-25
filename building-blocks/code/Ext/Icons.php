<?php

class Icons extends DataExtension
{
	private static $db = array(
		'Icon' => 'Varchar(50)'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}


	public function updateCMSFields(FieldList $fields)
	{
		$icons = array(
			'fa-users' => 'group',
			'fa-gamepad'=>'gamepad',
			'fa-leaf'=>'leaf',
			'fa-home'=>'house',
			'fa-cogs'=>'settings',
			'fa-handshake-o'=>'handshake',
			'fa-heart-o'=>'heart',
			'fa-futbol-o'=>'football',
			'fa-exchange'=>'exchange',
			'dragon'=>'dragon',
		);

		$icon = Select2Field::create(
			'Icon',
			'Icons',
			$icons
		)->setEmptyString('(Select Icon)');
		$fields->addFieldToTab('Root.Config', $icon);
	}
}