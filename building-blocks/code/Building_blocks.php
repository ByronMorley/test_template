<?php

class Building_blocks extends DataExtension
{

	private static $db = array();

	private static $has_one = array(
		'SingleImage' => 'Image'
	);

	private static $has_many = array(
		'Sections' => 'Section'
	);

	public function contentControllerInit()
	{

		/*  -- Stylesheets --*/
		Requirements::css('twitter/bootstrap/dist/css/bootstrap.min.css');
		Requirements::css('components/font-awesome/css/font-awesome.min.css');

		Requirements::css(BUILDING_BLOCKS_DIR . '/css/style.min.css');
		Requirements::css(BUILDING_BLOCKS_DIR . '/css/print.css', 'print');


		/*  -- Javascript --*/
		Requirements::javascript('components/jquery/jquery.min.js');
		Requirements::javascript('twitter/bootstrap/dist/js/bootstrap.min.js');
		Requirements::javascript('twitter\twbs-pagination\jquery.twbsPagination.js');
		Requirements::javascript(BUILDING_BLOCKS_DIR . '/js/main.min.js');

	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}

	public function updateCMSFields(FieldList $fields)
	{
		/*********************************
		 *      COMPONENT BUILDER
		 ********************************/

		$dataColumns = new GridFieldDataColumns();
		$dataColumns->setDisplayFields(
			array(

				'ClassName' => 'Class Name'
			)
		);

		$multiClassConfig = new GridFieldAddNewMultiClass();
		$multiClassConfig->setClasses(
			array(
				'SectionImageBlock' => SectionImageBlock::get_section_type(),
				'SectionTextBlock' => SectionTextBlock::get_section_type(),
				'SectionGalleryBlock' => SectionGalleryBlock::get_section_type(),
				'SectionYouTubeVideoBlock' => SectionYouTubeVideoBlock::get_section_type(),
				'SectionLinkBlock' => SectionLinkBlock::get_section_type(),
				'SectionVideoBlock' => SectionVideoBlock::get_section_type(),
				'SectionActivityBlock' => SectionActivityBlock::get_section_type(),
				'SectionPoemBlock' => SectionPoemBlock::get_section_type(),
				'SectionLogoBlock' => SectionLogoBlock::get_section_type(),
				'SectionInputBlock' => SectionInputBlock::get_section_type(),
				'SectionWordBankBlock' => SectionWordBankBlock::get_section_type(),
				'SectionAudioBlock' => SectionAudioBlock::get_section_type(),
			)
		);

		$config = GridFieldConfig_RelationEditor::create()
			->removeComponentsByType('GridFieldAddNewButton')
			->addComponents(
				new GridFieldOrderableRows('SortOrder'),
				new GridFieldDeleteAction(),
				$multiClassConfig,
				$dataColumns
			);

		$gridField = GridField::create('Sections', "Sections", $this->owner->Sections(), $config);
		$fields->addFieldToTab("Root.Sections", $gridField);


		/*-- Background image --*/
		/*
				$uploadField = UploadField ::create('BackgroundImage');
				$uploadField->setFolderName('BackgroundImages');
				$uploadField->getValidator()->setAllowedExtensions(array(
					'png','gif','jpeg','jpg'
				));

				$fields->addFieldToTab("Root.Main", $uploadField);
				*/

		$fields->addFieldToTab(
			'Root.Images',
			$uploadField = new UploadField(
				$name = 'SingleImage',
				$title = 'Background Image'
			)
		);

	}

	public function sectionGroups()
	{
		$groups = array();

		foreach ($this->owner->Sections()->exclude('ClassName', array('SectionActivityBlock', 'SectionLinkBlock')) as $index => $section) {
			$sectionArray = new ArrayData(array(
				'Sections' => $section,
				'ID' => $section->ID,
				'Title' => $section->Title,
			));
			array_push($groups, $sectionArray);
		}

		array_push($groups, $this->generateSectionGroup('SectionActivityBlock'));
		array_push($groups, $this->generateSectionGroup('SectionLinkBlock'));

		return new ArrayList($groups);
	}

	private function generateSectionGroup($sectionType)
	{
		$sections = array();
		$ID = 0;
		$title = $sectionType;

		$sectionArray = new ArrayData(array());
		$sectionsFiltered = $this->owner->Sections()->filter('ClassName', $sectionType);

		if (count($sectionsFiltered) > 0) {
			foreach ($sectionsFiltered as $index => $section) {
				if ($index == 0) {
					$ID = $section->ID;
					$title = $section->Title;
				}
				array_push($sections, $section);
			}
			$sectionArray = new ArrayData(array(
				'Sections' => new ArrayList($sections),
				'ID' => $ID,
				'Title' => $title,
			));
		}
		return $sectionArray;
	}

	public function setBackgroundImage($id)
	{
		Session::set('BackgroundImage', $id);
	}

	public function getBackgroundImage()
	{
		if (Session::get('BackgroundImage') != null) {
			return Image::get()->byID(Session::get('BackgroundImage'));
		} else {
			return Image::get()->byID(56);
		}
	}

	public function printAll($data)
	{
		$resources = Page::get()->filter(array('ParentID' => $data['id'], 'ClassName' => 'BlockHolder'));
		$pages = Page::get()->filter(array('ParentID' => $resources->first()->ID, 'ClassName' => 'BlockPage'));

		$pageArrayData = new ArrayData(array(
			'Pages' => $pages
		));

		$this->createPDF($pageArrayData->renderWith('Print/Page'));
	}

	public function createPDF($data)
	{
		$file = '../' . BUILDING_BLOCKS_DIR . '/php/download.php';
		$handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);

		fwrite($handle, $data);
		fclose($handle);
	}
}