<?php

class ActivityGroup extends DataObject
{

    private static $db = array(
        'Title' => 'Varchar',
        'Name' => 'Varchar',
        'Content' => 'HTMLText',
    );

	private static $summary_fields = array(
		'ID'=> 'ID',
		'Name'=>'Name',
		'Title'=>'Title',
		'ClassName'=>'Class Name'
	);

    private static $has_one = array();

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', TextField::create('Title')->setCustomValidationMessage('This Field is Required'), 'Content');
        $fields->addFieldToTab('Root.Main', TextField::create('Name')->setCustomValidationMessage('This Field is Required'), 'Content');
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Content', 'Content')->setRows(3));

        return $fields;
    }

}