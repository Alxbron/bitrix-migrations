<?php


namespace Arrilot\BitrixMigrations\Constructors;


use Arrilot\BitrixMigrations\Logger;
use Bitrix\Main\Application;

class IBlock
{
    use FieldConstructor;

    /**
     * Add iblock
     * @throws \Exception
     */
    public function add()
    {
        $obj = new \CIBlock();

        $iblockId = $obj->Add($this->getFieldsWithDefault());
        if (!$iblockId) {
            throw new \Exception($obj->LAST_ERROR);
        }

        Logger::log("Added iblock {$this->fields['CODE']}", Logger::COLOR_GREEN);

        return $iblockId;
    }

    /**
     * Update iblock
     * @param $id
     * @throws \Exception
     */
    public function update($id)
    {
        $obj = new \CIBlock();
        if (!$obj->Update($id, $this->fields)) {
            throw new \Exception($obj->LAST_ERROR);
        }

        Logger::log("Updated iblock {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Delete iblock
     * @param $id
     * @throws \Exception
     */
    public static function delete($id)
    {
        if (!\CIBlock::Delete($id)) {
            throw new \Exception('Error when deleting an iblock');
        }

        Logger::log("Deleted iblock {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Set the settings for adding the default iblock
     * @param $name
     * @param $code
     * @param $iblock_type_id
     * @return $this
     */
    public function constructDefault($name, $code, $iblock_type_id)
    {
        return $this->setName($name)->setCode($code)->setIblockTypeId($iblock_type_id);
    }

    /**
     * Site ID.
     * @param string $siteId
     * @return $this
     */
    public function setSiteId($siteId)
    {
        $this->fields['SITE_ID'] = $siteId;

        return $this;
    }

    /**
     * Symbolic identifier.
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->fields['CODE'] = $code;

        return $this;
    }

    /**
     * External code.
     * @param string $xml_id
     * @return $this
     */
    public function setXmlId($xml_id)
    {
        $this->fields['XML_ID'] = $xml_id;

        return $this;
    }

    /**
     * Iblock type code
     * @param string $iblockTypeId
     * @return $this
     */
    public function setIblockTypeId($iblockTypeId)
    {
        $this->fields['IBLOCK_TYPE_ID'] = $iblockTypeId;

        return $this;
    }

    /**
     * Name.
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->fields['NAME'] = $name;

        return $this;
    }

    /**
     * Activity flag
     * @param bool $active
     * @return $this
     */
    public function setActive($active = true)
    {
        $this->fields['ACTIVE'] = $active ? 'Y' : 'N';

        return $this;
    }

    /**
     * Sorting index.
     * @param int $sort
     * @return $this
     */
    public function setSort($sort = 500)
    {
        $this->fields['SORT'] = $sort;

        return $this;
    }

    /**
     * Template URL to the page for public viewing of the list of elements of iblock.
     * @param string $listPageUrl
     * @return $this
     */
    public function setListPageUrl($listPageUrl)
    {
        $this->fields['LIST_PAGE_URL'] = $listPageUrl;

        return $this;
    }

    /**
     * Template URL to the page to view the section.
     * @param string $sectionPageUrl
     * @return $this
     */
    public function setSectionPageUrl($sectionPageUrl)
    {
        $this->fields['SECTION_PAGE_URL'] = $sectionPageUrl;

        return $this;
    }

    /**
     * Canonical URL of the element.
     * @param string $canonicalPageUrl
     * @return $this
     */
    public function setCanonicalPageUrl($canonicalPageUrl)
    {
        $this->fields['CANONICAL_PAGE_URL'] = $canonicalPageUrl;

        return $this;
    }

    /**
     * URL of the element's detail page.
     *
     * @param string $detailPageUrl
     *
     * @return $this
     */
    public function setDetailPageUrl($detailPageUrl)
    {
        $this->fields['DETAIL_PAGE_URL'] = $detailPageUrl;

        return $this;
    }

    /**
     * Sets default values for iblock pages, section, and element details
     * (as when created via the administrative interface or with a friendly url).
     *
     * To use a friendly url, it is recommended to make
     * the character code of the elements and sections of iblock mandatory.
     *
     * @param bool sef Whether to use a friendly url (you will need to add a rule to urlrewrite)
     *
     * @return IBlock
     */
    public function setDefaultUrls($sef = false)
    {
        if ($sef === true) {
            $prefix = "#SITE_DIR#/#IBLOCK_TYPE_ID#/#IBLOCK_CODE#/";
            $this
                ->setListPageUrl($prefix)
                ->setSectionPageUrl("$prefix#SECTION_CODE_PATH#/")
                ->setDetailPageUrl("$prefix#SECTION_CODE_PATH#/#ELEMENT_CODE#/");
        } else {
            $prefix = "#SITE_DIR#/#IBLOCK_TYPE_ID#";
            $this
                ->setListPageUrl("$prefix/index.php?ID=#IBLOCK_ID#")
                ->setSectionPageUrl("$prefix/list.php?SECTION_ID=#SECTION_ID#")
                ->setDetailPageUrl("$prefix/detail.php?ID=#ELEMENT_ID#");
        }

        return $this;
    }

    /**
     * Image code in the file table.
     * @param array $picture
     * @return $this
     */
    public function setPicture($picture)
    {
        $this->fields['PICTURE'] = $picture;

        return $this;
    }

    /**
     * Description.
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->fields['DESCRIPTION'] = $description;

        return $this;
    }

    /**
     * Description type (text/html)
     * @param string $descriptionType
     * @return $this
     */
    public function setDescriptionType($descriptionType = 'text')
    {
        $this->fields['DESCRIPTION_TYPE'] = $descriptionType;

        return $this;
    }

    /**
     * Allowed to export to RSS dynamically
     * @param bool $rssActive
     * @return $this
     */
    public function setRssActive($rssActive = true)
    {
        $this->fields['RSS_ACTIVE'] = $rssActive ? 'Y' : 'N';

        return $this;
    }

    /**
     * RSS lifetime and the interval between RSS file generation (with RSS_FILE_ACTIVE or RSS_YANDEX_ACTIVE enabled) (hours).
     * @param int $rssTtl
     * @return $this
     */
    public function setRssTtl($rssTtl = 24)
    {
        $this->fields['RSS_TTL'] = $rssTtl;

        return $this;
    }

    /**
     * Regenerate the upload to a file.
     * @param bool $rssFileActive
     * @return $this
     */
    public function setRssFileActive($rssFileActive = false)
    {
        $this->fields['RSS_FILE_ACTIVE'] = $rssFileActive ? 'Y' : 'N';

        return $this;
    }

    /**
     * The number of elements exported to the RSS file (with RSS_FILE_ACTIVE enabled)
     * @param int $rssFileLimit
     * @return $this
     */
    public function setRssFileLimit($rssFileLimit)
    {
        $this->fields['RSS_FILE_LIMIT'] = $rssFileLimit;

        return $this;
    }

    /**
     * For how many recent days to export to an RSS file. (with RSS_FILE_ACTIVE enabled). -1 without a day limit.
     * @param int $rssFileDays
     * @return $this
     */
    public function setRssFileDays($rssFileDays)
    {
        $this->fields['RSS_FILE_DAYS'] = $rssFileDays;

        return $this;
    }

    /**
     * Export to RSS file in yandex format
     * @param bool $rssYandexActive
     * @return $this
     */
    public function setRssYandexActive($rssYandexActive = false)
    {
        $this->fields['RSS_YANDEX_ACTIVE'] = $rssYandexActive ? 'Y' : 'N';

        return $this;
    }

    /**
     * Index the elements of iblock for search.
     * @param bool $indexElement
     * @return $this
     */
    public function setIndexElement($indexElement = true)
    {
        $this->fields['INDEX_ELEMENT'] = $indexElement ? 'Y' : 'N';

        return $this;
    }

    /**
     * Index the sections of iblock for search.
     * @param bool $indexSection
     * @return $this
     */
    public function setIndexSection($indexSection = false)
    {
        $this->fields['INDEX_SECTION'] = $indexSection ? 'Y' : 'N';

        return $this;
    }

    /**
     * Display mode of the list of items in the administrative section (S|C).
     * @param string $listMode
     * @return $this
     */
    public function setListMode($listMode)
    {
        $this->fields['LIST_MODE'] = $listMode;

        return $this;
    }

    /**
     * Access rights verification mode (S|E).
     * @param string $rightsMode
     * @return $this
     */
    public function setRightsMode($rightsMode = 'S')
    {
        $this->fields['RIGHTS_MODE'] = $rightsMode;

        return $this;
    }

    /**
     * Whether there is a binding of properties to sections (Y|N).
     * @param string $sectionProperty
     * @return $this
     */
    public function setSectionProperty($sectionProperty)
    {
        $this->fields['SECTION_PROPERTY'] = $sectionProperty;

        return $this;
    }

    /**
     * Whether there is a faceted index (N|Y|I).
     * @param string $propertyIndex
     * @return $this
     */
    public function setPropertyIndex($propertyIndex)
    {
        $this->fields['PROPERTY_INDEX'] = $propertyIndex;

        return $this;
    }

    /**
     * A service field for the procedure of converting the storage location of the values of the properties of iblock.
     * @param int $lastConvElement
     * @return $this
     */
    public function setLastConvElement($lastConvElement)
    {
        $this->fields['LAST_CONV_ELEMENT'] = $lastConvElement;

        return $this;
    }

    /**
     * Service field for setting permissions for different groups to access iblock.
     * @param array $groupId Array of correspondences of access rights group codes
     * @return $this
     */
    public function setGroupId($groupId)
    {
        $this->fields['GROUP_ID'] = $groupId;

        return $this;
    }

    /**
     * Service field for linking to a social network group.
     * @param int $socnetGroupId
     * @return $this
     */
    public function setSocnetGroupId($socnetGroupId)
    {
        $this->fields['SOCNET_GROUP_ID'] = $socnetGroupId;

        return $this;
    }

    /**
     * Is iblock involved in the document flow (Y|N).
     * @param bool $workflow
     * @return $this
     */
    public function setWorkflow($workflow = true)
    {
        $this->fields['WORKFLOW'] = $workflow ? 'Y' : 'N';

        return $this;
    }

    /**
     * Is iblock involved in business processes (Y|N).
     * @param bool $bizproc
     * @return $this
     */
    public function setBizProc($bizproc = false)
    {
        $this->fields['BIZPROC'] = $bizproc ? 'Y' : 'N';

        return $this;
    }

    /**
     * Flag for selecting the interface for displaying the element binding to sections (D|L|P).
     * @param string $sectionChooser
     * @return $this
     */
    public function setSectionChooser($sectionChooser)
    {
        $this->fields['SECTION_CHOOSER'] = $sectionChooser;

        return $this;
    }

    /**
     * Flag for storing the values of the properties of the data block elements (1 - in the general table | 2 - in a separate one).
     * @param int $version
     * @return $this
     */
    public function setVersion($version = 1)
    {
        $this->fields['VERSION'] = $version;

        return $this;
    }

    /**
     * The full path to the handler file of the array of element fields before saving on the element editing page.
     * @param string $editFileBefore
     * @return $this
     */
    public function setEditFileBefore($editFileBefore)
    {
        $this->fields['EDIT_FILE_BEFORE'] = $editFileBefore;

        return $this;
    }

    /**
     * The full path to the output handler file of the element editing interface.
     * @param string $editFileAfter
     * @return $this
     */
    public function setEditFileAfter($editFileAfter)
    {
        $this->fields['EDIT_FILE_AFTER'] = $editFileAfter;

        return $this;
    }

    /**
     * The name of the element in the singular
     * @param string $message
     * @return $this
     */
    public function setMessElementName($message = 'Element')
    {
        $this->fields['ELEMENT_NAME'] = $message;

        return $this;
    }

    /**
     * The name of the element in the plural
     * @param string $message
     * @return $this
     */
    public function setMessElementsName($message = 'Elements')
    {
        $this->fields['ELEMENTS_NAME'] = $message;

        return $this;
    }

    /**
     * Action to add an element
     * @param string $message
     * @return $this
     */
    public function setMessElementAdd($message = 'Add element')
    {
        $this->fields['ELEMENT_ADD'] = $message;

        return $this;
    }

    /**
     * Action to edit/change an element
     * @param string $message
     * @return $this
     */
    public function setMessElementEdit($message = 'Edit element')
    {
        $this->fields['ELEMENT_EDIT'] = $message;

        return $this;
    }

    /**
     * Action to delete an element
     * @param string $message
     * @return $this
     */
    public function setMessElementDelete($message = 'Delete element')
    {
        $this->fields['ELEMENT_DELETE'] = $message;

        return $this;
    }

    /**
     * The name of the section in the singular
     * @param string $message
     * @return $this
     */
    public function setMessSectionName($message = 'Section')
    {
        $this->fields['SECTION_NAME'] = $message;

        return $this;
    }

    /**
     * The name of the section in the plural
     * @param string $message
     * @return $this
     */
    public function setMessSectionsName($message = 'Sections')
    {
        $this->fields['SECTIONS_NAME'] = $message;

        return $this;
    }

    /**
     * Action to add a section
     * @param string $message
     * @return $this
     */
    public function setMessSectionAdd($message = 'Add section')
    {
        $this->fields['SECTION_ADD'] = $message;

        return $this;
    }

    /**
     * Action to edit/change a section
     * @param string $message
     * @return $this
     */
    public function setMessSectionEdit($message = 'Edit section')
    {
        $this->fields['SECTION_EDIT'] = $message;

        return $this;
    }

    /**
     * Action to delete a section
     * @param string $message
     * @return $this
     */
    public function setMessSectionDelete($message = 'Delete section')
    {
        $this->fields['SECTION_DELETE'] = $message;

        return $this;
    }


}
