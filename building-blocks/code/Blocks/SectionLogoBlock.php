<?php

class SectionLogoBlock extends Section
{

	public static $db = array(
		'Alignment' => 'varchar',
		'MaxHeight' => 'Int'
	);

	public static $has_many = array(
		'Logos' => 'ImageResource'
	);

	public static $has_one = array();

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$alignment = DropdownField::create('Alignment', 'Alignment', array(
				'center' => 'center',
				'left' => 'left',
				'right' => 'right',
			)
		);

		$height = NumericField::create('MaxHeight');


		$saveWarning = LiteralField::create("Warning", "<p class='cms-warning-label'>Please Save changes before adding content</p>");

		$sectionconfig = GridFieldConfig_RelationEditor::create()
			->removeComponentsByType('GridFieldAddNewButton')
			->addComponents(
				new GridFieldDeleteAction()
			);

		if ($this->ID) {
			$sectionconfig->addComponents(
				new GridFieldAddNewButton()
			);
		} else {
			$fields->addFieldToTab('Root.Main', $saveWarning);
		}

		$sectiongridField = GridField::create('Logos', 'Logo', $this->Logos(), $sectionconfig);
		$fields->addFieldsToTab("Root.Main", array($sectiongridField, $alignment));

		$this->removeEmptyTabs($fields);

		return $fields;
	}
	public function MaxHeight(){
		return $this->MaxHeight . "px";
	}
}