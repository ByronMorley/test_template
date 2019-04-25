<?php

class SectionYouTubeVideoBlock extends Section
{

	private static $db = array(
		'src' => 'VarChar(100)',
		'embedCode' => 'Varchar(20)',
		'caption' => 'VarChar(400)',
		'width' => 'VarChar(30)',
		'border' => 'Boolean',
		'TextAbove' => 'HTMLText',
		'TextBelow' => 'HTMLText',
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$widths = array(
			'full-width' => 'Full width',
			'large' => 'Large',
			'medium' => 'Medium',
			'small' => 'Small'
		);

		$alignment = array(
			'center' => 'Center',
			'left' => 'Left',
			'right' => 'Right'
		);

		$fieldList = array(
			TextField::create('embedCode', 'Embedding code'),
			TextField::create('caption', 'Caption'),
			DropdownField::create('width', 'Width', $widths),
			DropdownField::create('align', 'Align', $alignment),
			CheckboxField::create('border', 'Border')
		);

		$fields->removeByName('link');


		$textFields = array(
			HtmlEditorField::create('TextAbove', 'TextAbove'),
			HtmlEditorField::create('TextBelow', 'TextBelow')
		);

		$fields->addFieldsToTab('Root.Text', $textFields);



		$fields->addFieldsToTab("Root.Main", $fieldList);

		return $fields;
	}

	public function populateDefaults()
	{
		$this->width = "full-width";
		$this->align = "center";
		parent::populateDefaults();
	}
}
