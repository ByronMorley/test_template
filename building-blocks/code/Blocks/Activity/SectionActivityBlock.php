<?php

class SectionActivityBlock extends Section
{

    private static $db = array();

    private static $has_one = array(
        'ActivityGroup' => 'ActivityGroup',
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab("Root.Main", DropdownField::create(
            'ActivityGroupID',
            'Add Activity Group',
            ActivityGroup::get()->map('ID', 'Name'))
            ->setEmptyString('(Select Activity Group)')
        );

        return $fields;
    }

}