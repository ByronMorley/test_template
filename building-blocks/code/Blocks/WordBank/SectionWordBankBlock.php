<?php

class SectionWordBankBlock extends Section
{
	private static $db = array(
		'Content' => 'HTMLText'
	);

	public static $has_one = array();

	public static $has_many = array(
		'Phrases' => 'BankWord'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

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
			$fields->addFieldToTab('Root.Phrases', $saveWarning);
		}

		$sectiongridField = GridField::create('Phrases', 'Phrases', $this->Phrases(), $sectionconfig);
		$fields->addFieldsToTab("Root.Phrases", $sectiongridField);


		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Content', 'Content'));

		return $fields;
	}
}