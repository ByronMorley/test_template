<?php

class LinkElement extends DataObject
{

	private static $db = array(
		'SortOrder' => 'Int',
		'Prompt' => 'Varchar',
		'LeftIcon' => 'Varchar',
		'RightIcon' => 'Varchar'
	);
	private static $default_sort = 'SortOrder ASC';

	private static $has_many = array();

	private static $summary_fields = array();

	static $plural_name = "LinkElements";
	static $singular_name = "LinkElement";

	private static $has_one = array(
		'Group' => 'SectionLinkBlock'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$icons = array(
			'fa fa-link' => 'link 1',
			'glyphicon glyphicon-link' => 'link 2',
			'fa fa-file-pdf-o' => 'PDF',
			'fa fa-file-powerpoint-o' => 'PowerPoint',
			'fa fa-file-word-o' => 'Word Document',
			'fa fa-file-image-o' => 'Image file',
			'fa fa-download' => 'Download'
		);

		$leftIcon = Select2Field::create(
			'LeftIcon',
			'Left Icon',
			$icons
		)->setEmptyString('(Select Icon)');

		$rightIcon = Select2Field::create(
			'RightIcon',
			'Right Icon',
			$icons
		)->setEmptyString('(Select Icon)');

		$prompts = array(
			'Word (.docx)' => 'docx',
			'Word (.doc)' => 'doc',
			'PDF (.pdf)' => 'pdf',
			'Powerpoint (.pptx)' => 'powerpoint',
		);

		$prompt = Select2Field::create(
			'Prompt',
			'Prompt',
			$prompts
		)->setEmptyString('(Select Prompt)');

		$fields->addFieldToTab('Root.Main', HeaderField::create($this->ClassName), 'Prompt');
		$fields->addFieldsToTab('Root.Main', array($prompt, $leftIcon, $rightIcon));
		$fields->removeFieldFromTab('Root.Main', 'SortOrder');
		$fields->removeFieldFromTab('Root.Main', 'GroupID');

		return $fields;
	}

	public static function get_link_type()
	{
		return trim(preg_replace('/([A-Z])/', ' $1', str_ireplace('', '', get_called_class())));;
	}

	public function populateDefaults() {

		$this->Prompt = 'Word (.docx)';
		$this->LeftIcon = 'fa fa-file-word-o';
		$this->RightIcon = 'fa fa-download';

		parent::populateDefaults();
	}

}
