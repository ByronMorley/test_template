<?php

class InputFrame extends DataObject
{
	private static $db = array(
		'Title' => 'Varchar',
		'SetupText'=>'HTMLText',
	);

	private static $has_one = array(
		'InputBlock' => 'Section',
	);

	private static $has_many = array();

	private static $belongs_to = array(
		'InputBlockAnswer' => 'InputBlockAnswer'
	);

	private static $summary_fields = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		return $fields;
	}

	public function Content()
	{

		$user = unserialize(Session::get('user'));
		if ($user) {
			$iba = InputBlockAnswer::get()->filter(array(
				'UserID' => $user->ID,
				'SectionID' => $this->InputBlock()->ID,
				'InputFrameID' => $this->ID
			))->first();

			if ($iba) {
				return $iba->WritingFrame;
			}
		}
	}

	public function TextAreaInputForm()
	{
		$arrayData = new ArrayData(array(
			'InputFrame' => $this,
			'InputBlock' => $this->InputBlock(),
			'Form' => Controller::curr()->TextAreaInputForm()
		));
		return $arrayData->renderWith('Forms/TextAreaInputForm');
	}
}