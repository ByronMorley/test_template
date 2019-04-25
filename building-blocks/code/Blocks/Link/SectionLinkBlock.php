<?php


class SectionLinkBlock extends Section
{

	private static $db = array(
		'Content'=>'HTMLText'
	);

	private static $has_many = array(
		'LinkElements' => 'LinkElement'
	);

    public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		/*********************************
		 *      Link Element Builder
		 ********************************/

		$sectiondataColumns = new GridFieldDataColumns();
		$sectiondataColumns->setDisplayFields(
			array(
				'ID' => 'ID',
				'Title' => 'Title',
				'ClassName' => 'Class Name'
			)
		);

		$sectionmultiClassConfig = new GridFieldAddNewMultiClass();
		$sectionmultiClassConfig->setClasses(
			array(
				'ExternalLink' => ExternalLink::get_link_type(),
				'InternalLink' => InternalLink::get_link_type(),
				'DownloadFile' => DownloadFile::get_link_type(),
			)
		);
		$saveWarning = LiteralField::create("Warning", "<p class='cms-warning-label'>To Add Content please save changes</p>");

		$sectionconfig = GridFieldConfig_RelationEditor::create()
			->removeComponentsByType('GridFieldAddNewButton')
			->addComponents(
				new GridFieldDeleteAction(),
				$sectionmultiClassConfig,
				$sectiondataColumns
			);

		if ($this->ID) {
			$sectionconfig->addComponent(new GridFieldOrderableRows('SortOrder'));
		} else {
			$fields->addFieldToTab('Root.Links', $saveWarning);
		}

		$sectiongridField = GridField::create('LinkElements', "Link Elements", $this->LinkElements(), $sectionconfig);
		$fields->addFieldToTab("Root.Links", $sectiongridField);

		$this->removeEmptyTabs($fields);

		return $fields;
	}
}
