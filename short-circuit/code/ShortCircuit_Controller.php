<?php

class ShortCircuit_Controller extends DataExtension {

	public static $allowed_actions = array(
		'SessionLoginForm',
		'TextAreaInputForm',
		'SessionEndForm'
	);

	public function SessionLoginForm(){
		return SessionLoginForm::create(Controller::curr(), 'SessionLoginForm');
	}

	public function SessionEndForm(){
		return SessionEndForm::create(Controller::curr(), 'SessionEndForm');
	}

	public function TextAreaInputForm(){
		return TextAreaInputForm::create(Controller::curr(), 'TextAreaInputForm');
	}

	public function EditorToolbar() {
		return HtmlEditorField_Toolbar::create($this, "EditorToolbar");
	}

}