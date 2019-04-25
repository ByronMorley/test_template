<?php

class SessionLoginForm extends Form
{

	public function __construct(Controller $controller, $name)
	{
		if (Session::get('ConfirmNewUser')) {
			$fields = FieldList::create(
				HeaderField::create('header', 'User not found'),
				LiteralField::create('Text', 'The user information you entered is not recognised. Click confirm to create a new profile or try again to re-enter your login information.')
			);
			$actions = FieldList::create(
				FormAction::create('Confirm', 'Confirm'),
				FormAction::create('TryAgain', 'Try Again')
			);
		} else {
			$fields = FieldList::create(
				TextField::create('Name'),
				PasswordField::create('Password')
			);
			$actions = FieldList::create(
				FormAction::create('AttemptLogin', 'Login')
			);
		}

		$validator = new RequiredFields();

		parent::__construct($controller, $name, $fields, $actions, $validator);
	}

	public function Confirm($data)
	{
		$newUserData = Session::get('ConfirmNewUser');
		Session::clear('ConfirmNewUser');
		$name = $newUserData['Name'];
		$user_input = $newUserData['token'];
		$user = $this->newUser($name, password_hash($user_input, PASSWORD_DEFAULT));
		$user->startSession();
		Controller::curr()->redirectBack();
	}

	public function TryAgain($data)
	{
		Session::clear('ConfirmNewUser');
		Controller::curr()->redirectBack();
	}


	public function AttemptLogin($data)
	{

		$name = $data['Name'];
		$user_input = $name . $data['Password'];
		$user = $this->getUserIfExists($user_input);

		if (!$user) {
			Session::set('ConfirmNewUser', array('Name' => $name, 'token' => $user_input));
		} else {
			$user->startSession();
		}
		Controller::curr()->redirectBack();
	}


	public function SessionLogin($data)
	{
		$name = $data['Name'];
		$user_input = $name . $data['Password'];

		$user = $this->getUserIfExists($user_input);

		if (!$user) {
			$user = $this->newUser($name, password_hash($user_input, PASSWORD_DEFAULT));
		}

		$user->startSession();

		Controller::curr()->redirectBack();
	}

	public function getUserIfExists($user_input)
	{

		$users = SessionUser::get();

		foreach ($users as $user) {
			if (password_verify($user_input, $user->Token)) {
				return $user;
			}
		}
		return false;
	}

	public function newUser($name, $token)
	{

		$user = SessionUser::create();
		$user->Name = $name;
		$user->Token = $token;
		$user->write();
		return $user;
	}
}