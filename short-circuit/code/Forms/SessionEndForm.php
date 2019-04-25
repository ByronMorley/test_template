<?php

class SessionEndForm extends Form
{

	public function __construct(Controller $controller, $name)
	{
		$fields = FieldList::create();

		$actions = FieldList::create(
			FormAction::create('SessionLogout', 'Logout')
		);

		$validator = new RequiredFields();

		parent::__construct($controller, $name, $fields, $actions, $validator);
	}

	public function SessionLogout($data)
	{
		$user = unserialize(Session::get('user'));
		$user->endSession();

		Controller::curr()->redirectBack();
	}
}