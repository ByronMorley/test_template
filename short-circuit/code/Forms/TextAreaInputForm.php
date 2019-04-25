<?php

class TextAreaInputForm extends Form
{

	public function __construct(Controller $controller, $name)
	{
		$textarea = HTMLEditorField::create('Textarea');

		$fields = FieldList::create(
			$textarea
		);

		$actions = FieldList::create(
			FormAction::create('SaveandClose', 'Save and Close')
		);

		$validator = new RequiredFields();

		parent::__construct($controller, $name, $fields, $actions, $validator);
	}

	public function SaveAndClose($data)
	{
		SS_Log::log(serialize($data['BlockID']), SS_Log::NOTICE);
		SS_Log::log(serialize($data['FrameID']), SS_Log::NOTICE);

		$blockID = $data['BlockID'];
		$frameID = $data['FrameID'];
		$user = unserialize(Session::get('user'));
		$text = $data['Textarea'];

		$iba = InputBlockAnswer::get()->filter(array(
			'UserID' => $user->ID,
			'SectionID' => $blockID,
			'InputFrameID' => $frameID
		))->first();

		if (!$iba) {
			$iba = InputBlockAnswer::create();
		}

		$iba->UserID = $user->ID;
		$iba->SectionID = $blockID;
		$iba->InputFrameID = $frameID;
		$iba->WritingFrame = $text;
		$iba->write();

		Controller::curr()->redirectBack();
	}
}