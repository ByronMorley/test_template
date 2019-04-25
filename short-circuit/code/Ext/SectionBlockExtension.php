<?php

class SectionBlockExtension extends DataExtension
{

	private static $has_many = array(
		'InputFrames'=>'InputFrame'
	);

	public function WritingFrameIcon()
	{
		$arrayData = new ArrayData(array(
			'InputFrames' => $this->owner->InputFrames(),
			'Block' => $this->owner,
		));

		return $arrayData->renderWith('ShortCircuit/WritingFrameIcon');
	}



	public function WritingFrameModal()
	{

		$arrayData = new ArrayData(array(
			'InputFrames' => $this->owner->InputFrames(),
			'Block' => $this->owner,
		));

		return $arrayData->renderWith('ShortCircuit/WritingFrameModal');
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}

	public function updateCMSFields(FieldList $fields)
	{
		/*-- Writing Frames --*/

		$saveWarning = LiteralField::create("Warning", "<p class='cms-warning-label'>Please Save changes before adding content</p>");

		$sectionconfig = GridFieldConfig_RelationEditor::create()
			->removeComponentsByType('GridFieldAddNewButton')
			->addComponents(
				new GridFieldDeleteAction()
			);

		if ($this->owner->ID) {
			$sectionconfig->addComponents(
				new GridFieldAddNewButton()
			);
		} else {
			$fields->addFieldToTab('Root.Input Frames', $saveWarning);
		}

		$sectiongridField = GridField::create('InputFrames', 'Frames', $this->owner->InputFrames(), $sectionconfig);
		$fields->addFieldsToTab("Root.Input Frames", $sectiongridField);
		$this->owner->removeEmptyTabs($fields);
	}

}