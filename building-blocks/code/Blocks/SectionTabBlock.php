<?php

class SectionTabBlock extends Section {

	private static $db = array(

	);

	private static $has_many = array(
		'Blocks' => 'SectionTextBlock'
	);

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		$saveWarning = LiteralField::create("Warning", "<p class='cms-warning-label'>Please Save changes before adding content</p>");

		$sectionconfig = GridFieldConfig_RelationEditor::create()
			->removeComponentsByType('GridFieldAddNewButton')
			->addComponents(
				new GridFieldDeleteAction()
			);

		if ($this->ID) {
			$sectionconfig->addComponents(
				new GridFieldOrderableRows('SortOrder'),
				new GridFieldAddNewButton()
			);
		} else {
			$fields->addFieldToTab('Root.Main', $saveWarning);
		}

		$sectiongridField = GridField::create('Blocks', "Content", $this->Blocks(), $sectionconfig);
		$fields->addFieldToTab("Root.Main", $sectiongridField);

		$this->removeEmptyTabs($fields);


		return $fields;
	}
}