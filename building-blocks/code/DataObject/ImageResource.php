<?php

class ImageResource extends DataObject
{
	static $db = array(
		'Title' => 'Varchar(100)',
		'Caption' => 'HTMLText',

	);

	static $has_one = array(
		'Image' => 'Image',
		'SectionGalleryBlock' => 'SectionGalleryBlock',
		'SectionLogoBlock' => 'SectionLogoBlock',
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fieldList = FieldList::create(
			TextField::create('Title', 'Title'),
			HtmlEditorField::create('Caption', 'Caption')->setRows(4)
		);

		$uploadField = UploadField::create('Image');
		$uploadField->setFolderName('SectionGalleryImages');
		$uploadField->getValidator()->setAllowedExtensions(array(
			'png', 'gif', 'jpeg', 'jpg'
		));

		$fields->addFieldsToTab("Root.Main", $fieldList);
		$fields->addFieldToTab("Root.Main", $uploadField);

		$fields->removeByName('SectionLogoBlockID');
		$fields->removeByName('SectionGalleryBlockID');

		return $fields;
	}
}