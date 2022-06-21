<?php


namespace Arrilot\BitrixMigrations\Constructors;


use Arrilot\BitrixMigrations\Helpers;
use Arrilot\BitrixMigrations\Logger;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Application;

class UserField
{
    use FieldConstructor;

    /**
     * Add UF
     * @throws \Exception
     */
    public function add()
    {
        $uf = new \CUserTypeEntity();
        $result = $uf->Add($this->getFieldsWithDefault());

        if (!$result) {
            global $APPLICATION;
            throw new \Exception($APPLICATION->GetException());
        }

        Logger::log("Added UF {$this->fields['FIELD_NAME']} for {$this->fields['ENTITY_ID']}", Logger::COLOR_GREEN);

        return $result;
    }

    /**
     * Update UF
     * @param $id
     * @throws \Exception
     */
    public function update($id)
    {
        $uf = new \CUserTypeEntity();
        $result = $uf->Update($id, $this->fields);

        if (!$result) {
            global $APPLICATION;
            throw new \Exception($APPLICATION->GetException());
        }

        Logger::log("Updated UF {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Delete UF
     * @param $id
     * @throws \Exception
     */
    public static function delete($id)
    {
        $result = (new \CUserTypeEntity())->Delete($id);

        if (!$result) {
            global $APPLICATION;
            throw new \Exception($APPLICATION->GetException());
        }

        Logger::log("Deleted UF {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Set the settings to add the default UF
     * @param string $entityId Entity ID
     * @param string $fieldName Field code.
     * @return $this
     */
    public function constructDefault($entityId, $fieldName)
    {
        return $this->setEntityId($entityId)->setFieldName($fieldName)->setUserType('string');
    }

    /**
     * ID of the entity to which the property will be bound.
     * @param string $entityId
     * @return $this
     */
    public function setEntityId($entityId)
    {
        $this->fields['ENTITY_ID'] = $entityId;

        return $this;
    }

    /**
     * Field code. Should always start with UF_
     * @param string $fieldName
     * @return $this
     */
    public function setFieldName($fieldName)
    {
        $this->fields['FIELD_NAME'] = static::prepareUf($fieldName);

        return $this;
    }

    /**
     * type of user field
     * @param string $userType
     * @return $this
     */
    public function setUserType($userType)
    {
        $this->fields['USER_TYPE_ID'] = $userType;

        return $this;
    }

    /**
     * type of the new user field HL
     * @param string $table_name
     * @param string $showField
     * @return $this
     */
    public function setUserTypeHL($table_name, $showField)
    {
        $linkId = Helpers::getHlId($table_name);
        $this->setUserType('hlblock')->setSettings([
            'HLBLOCK_ID' => Helpers::getHlId($table_name),
            'HLFIELD_ID' => Helpers::getFieldId(Constructor::objHLBlock($linkId), static::prepareUf($showField)),
        ]);

        return $this;
    }

    /**
     * type of the new user property "connection with the IB section"
     * @param string $iblockId
     * @return $this
     */
    public function setUserTypeIblockSection($iblockId)
    {
        $this->setUserType('iblock_section')->setSettings([
            'IBLOCK_ID' => $iblockId,
        ]);

        return $this;
    }

    /**
     * type of the new user property "connection to the IB element"
     * @param string $iblockId
     * @return $this
     */
    public function setUserTypeIblockElement($iblockId)
    {
        $this->setUserType('iblock_element')->setSettings([
            'IBLOCK_ID' => $iblockId,
        ]);

        return $this;
    }

    /**
     * XML_ID of the user property. Used when uploading as a field name
     * @param string $xmlId
     * @return $this
     */
    public function setXmlId($xmlId)
    {
        $this->fields['XML_ID'] = $xmlId;

        return $this;
    }

    /**
     * Sorting
     * @param int $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->fields['SORT'] = $sort;

        return $this;
    }

    /**
     * Is the field multiple or not
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple)
    {
        $this->fields['MULTIPLE'] = $multiple ? 'Y' : 'N';

        return $this;
    }

    /**
     * Is the property required or not
     * @param bool $mandatory
     * @return $this
     */
    public function setMandatory($mandatory)
    {
        $this->fields['MANDATORY'] = $mandatory ? 'Y' : 'N';

        return $this;
    }

    /**
     * Show in the list filter. Possible values: do not show = N, exact match = I, mask search = E, substring search = S
     * @param string $showInFilter
     * @return $this
     */
    public function setShowFilter($showInFilter)
    {
        $this->fields['SHOW_FILTER'] = $showInFilter;

        return $this;
    }

    /**
     * Do not show in the list. If you pass any value, it will be assumed that the flag is set.
     * @param bool $showInList
     * @return $this
     */
    public function setShowInList($showInList)
    {
        $this->fields['SHOW_IN_LIST'] = $showInList ? 'Y' : '';

        return $this;
    }

    /**
     * An empty line allows editing. If you pass any value, it will be assumed that the flag is set.
     * @param bool $editInList
     * @return $this
     */
    public function setEditInList($editInList)
    {
        $this->fields['EDIT_IN_LIST'] = $editInList ? 'Y' : '';

        return $this;
    }

    /**
     * The values of the field are involved in the search
     * @param bool $isSearchable
     * @return $this
     */
    public function setIsSearchable($isSearchable = false)
    {
        $this->fields['IS_SEARCHABLE'] = $isSearchable ? 'Y' : 'N';

        return $this;
    }

    /**
     * Additional field settings (depending on the type). In our case, for the string type
     * @param array $settings
     * @return $this
     */
    public function setSettings($settings)
    {
        $this->fields['SETTINGS'] = array_merge((array)$this->fields['SETTINGS'], $settings);

        return $this;
    }

    /**
     * Language phrases
     * @param string $lang
     * @param string $text
     * @return $this
     */
    public function setLangDefault($lang, $text)
    {
        $this->setLangForm($lang, $text);
        $this->setLangColumn($lang, $text);
        $this->setLangFilter($lang, $text);

        return $this;
    }

    /**
     * Text "Title in the list"
     * @param string $lang
     * @param string $text
     * @return $this
     */
    public function setLangForm($lang, $text)
    {
        $this->fields['EDIT_FORM_LABEL'][$lang] = $text;

        return $this;
    }

    /**
     * Text "Title in the list"
     * @param string $lang
     * @param string $text
     * @return $this
     */
    public function setLangColumn($lang, $text)
    {
        $this->fields['LIST_COLUMN_LABEL'][$lang] = $text;

        return $this;
    }

    /**
     * Text "Filter signature in the list"
     * @param string $lang
     * @param string $text
     * @return $this
     */
    public function setLangFilter($lang, $text)
    {
        $this->fields['LIST_FILTER_LABEL'][$lang] = $text;

        return $this;
    }

    /**
     * Text "Help"
     * @param string $lang
     * @param string $text
     * @return $this
     */
    public function setLangHelp($lang, $text)
    {
        $this->fields['HELP_MESSAGE'][$lang] = $text;

        return $this;
    }

    /**
     * Text "Error message (optional)"
     * @param string $lang
     * @param string $text
     * @return $this
     */
    public function setLangError($lang, $text)
    {
        $this->fields['ERROR_MESSAGE'][$lang] = $text;

        return $this;
    }

    protected static function prepareUf($name)
    {
        if (substr($name, 0, 3) != 'UF_') {
            $name = "UF_{$name}";
        }

        return $name;
    }
}
