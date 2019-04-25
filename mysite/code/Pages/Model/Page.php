<?php

class Page extends SiteTree
{

	public static $allowed_actions = array();

	private static $db = array();

	private static $has_one = array();

	private static $has_many = array(
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeByName('Content');

		return $fields;
	}

	private function findThemeClass($ID)
	{
		if ($ID > 0) {
			$Page = Page::get()->filter('ID', $ID)->first();

			if ($Page->ParentID == 0) return;
			if ($Page->ClassName == "Theme") {
				return $Page->ColorScheme;
			} else {
				return $this->findThemeClass($Page->ParentID);
			}
		}
	}

	public function pageClass()
	{
		return $this->findThemeClass($this->ID);
	}

    public function getLocaleLink($url, $lang)
    {
        try {

            $SQL_url = Convert::raw2sql($url);
            $SQL_lang = Convert::raw2sql($lang);

            $page = Translatable::get_one_by_lang('SiteTree', $SQL_lang, "URLSegment = '$SQL_url'");
            if ($page != null) {
                if ($page->Locale != Translatable::get_current_locale()) {

                    // Fallback to English
                    if ($page->hasTranslation(Translatable::get_current_locale())) {
                        $page = $page->getTranslation(Translatable::get_current_locale());
                    } else {
                        $page = $page->getTranslation('uk_UA');
                    }
                }
                return $page->Link();
            }
        } catch (Exception $e) {
            SS_Log::log(serialize($e->getMessage()), SS_Log::ERR);
        }
    }

    public function IsEnglish()
    {
        return (Translatable::get_current_locale() == "en_GB");
    }
}
