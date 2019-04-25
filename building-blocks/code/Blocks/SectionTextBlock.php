<?php

class SectionTextBlock extends Section
{

	private static $db = array(
		'Content' => 'HTMLText'
	);

	public static $has_one = array(
		'SectionTabBlock' => 'SectionTabBlock'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fieldList = FieldList::create(
			HtmlEditorField::create('Content')
		);

		$fields->addFieldsToTab('Root.Main',
			$fieldList
		);

		return $fields;
	}
}