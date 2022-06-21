<?php


namespace Arrilot\BitrixMigrations\Constructors;


use Arrilot\BitrixMigrations\Logger;
use Bitrix\Main\Application;

class IBlockType
{
    use FieldConstructor;

    /**
     * Add iblock type
     * @throws \Exception
     */
    public function add()
    {
        $obj = new \CIBlockType();
        if (!$obj->Add($this->getFieldsWithDefault())) {
            throw new \Exception($obj->LAST_ERROR);
        }

        Logger::log("Added iblock type {$this->fields['ID']}", Logger::COLOR_GREEN);
    }

    /**
     * Update iblock type
     * @param $id
     * @throws \Exception
     */
    public function update($id)
    {
        $obj = new \CIBlockType();
        if (!$obj->Update($id, $this->fields)) {
            throw new \Exception($obj->LAST_ERROR);
        }

        Logger::log("Updated iblock type {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Delete iblock type
     * @param $id
     * @throws \Exception
     */
    public static function delete($id)
    {
        if (!\CIBlockType::Delete($id)) {
            throw new \Exception('Error when deleting iblock type');
        }

        Logger::log("Iblock type has been removed {$id}", Logger::COLOR_GREEN);
    }

    /**
     * ID of the type of iblocks. Unique.
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->fields['ID'] = $id;

        return $this;
    }

    /**
     * Are the elements of this type of block divided into sections.
     * @param bool $has
     * @return $this
     */
    public function setSections($has = true)
    {
        $this->fields['SECTIONS'] = $has ? 'Y' : 'N';

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
     * Export blocks of this type to RSS
     * @param bool $inRss
     * @return $this
     */
    public function setInRss($inRss = false)
    {
        $this->fields['IN_RSS'] = $inRss ? 'Y' : 'N';

        return $this;
    }

    /**
     * Sort order
     * @param int $sort
     * @return $this
     */
    public function setSort($sort = 500)
    {
        $this->fields['SORT'] = $sort;

        return $this;
    }

    /**
     * Specify language phrases
     * @param string $lang language key (ru)
     * @param string $name
     * @param string $sectionName
     * @param string $elementName
     * @return $this
     */
    public function setLang($lang, $name, $sectionName = null, $elementName = null)
    {
        $setting = ['NAME' => $name];

        if ($sectionName) {
            $setting['SECTION_NAME'] = $sectionName;
        }
        if ($elementName) {
            $setting['ELEMENT_NAME'] = $elementName;
        }

        $this->fields['LANG'][$lang] = $setting;

        return $this;
    }
}