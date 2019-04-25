<?php

class BankWord extends DataObject
{
	private static $db = array(
		'Phrase' => 'Varchar',
		'Style' => 'Varchar'
	);

	private static $has_one = array(
		'WordBankBlock' => 'SectionWordBankBlock'
	);

	private static $has_many = array();

	private static $summary_fields = array(
		'ID' => 'ID',
		'Phrase' => 'Phrase',
		'ClassName' => 'Class name'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$styles = array(
			'left-10' => 'left 10 degress',
			'left-20' => 'left 20 degress',
			'left-30' => 'left 30 degress',
			'left-40' => 'left 40 degress',
			'right-10' => 'right 10 degress',
			'right-20' => 'right 20 degress',
			'right-30' => 'right 30 degress',
			'right-40' => 'right 40 degress',
		);

		$fields->addFieldToTab('Root.Main', DropdownField::create('Style','Style', $styles));

		$fields->removeByName('WordBankBlockID');

		return $fields;
	}
}