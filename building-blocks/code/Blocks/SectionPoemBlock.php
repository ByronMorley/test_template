<?php

class SectionPoemBlock extends Section {

	private static $db = array(
		'Title' => 'Varchar',
		'Content' => 'HTMLText',
		'Author' => 'Varchar',

	);

	private static $has_one = array(
		'Audio' => 'File'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		/*----------- AUDIO FILE -------------*/

		$uploadField = UploadField ::create('Audio');
		$uploadField->setFolderName('SectionAudioBlock/audio');
		$uploadField->getValidator()->setAllowedExtensions(array(
			'mp3'
		));

		$fields->addFieldToTab("Root.Main", $uploadField);


		return $fields;
	}

	public function populateDefaults()
	{

	}
}
