<?php


namespace Arrilot\BitrixMigrations\Constructors;


use Arrilot\BitrixMigrations\Logger;
use Bitrix\Main\Application;

class IBlockProperty
{
    use FieldConstructor;

    /**
     * Add iblock property
     * @throws \Exception
     */
    public function add()
    {
        $obj = new \CIBlockProperty();

        $property_id = $obj->Add($this->getFieldsWithDefault());

        if (!$property_id) {
            throw new \Exception($obj->LAST_ERROR);
        }

        Logger::log("Added iblock property {$this->fields['CODE']}", Logger::COLOR_GREEN);

        return $property_id;
    }

    /**
     * Update iblock property
     * @param $id
     * @throws \Exception
     */
    public function update($id)
    {
        $obj = new \CIBlockProperty();
        if (!$obj->Update($id, $this->fields)) {
            throw new \Exception($obj->LAST_ERROR);
        }

        Logger::log("Updated iblock property {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Delete iblock property
     * @param $id
     * @throws \Exception
     */
    public static function delete($id)
    {
        if (!\CIBlockProperty::Delete($id)) {
            throw new \Exception('Error when deleting iblock property');
        }

        Logger::log("Iblock property removed {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Set settings for adding a default iblock property
     * @param string $code
     * @param string $name
     * @param int $iblockId
     * @return IBlockProperty
     */
    public function constructDefault($code, $name, $iblockId)
    {
        return $this->setPropertyType('S')->setCode($code)->setName($name)->setIblockId($iblockId);
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
     * Iblock id.
     * @param string $iblock_id
     * @return $this
     */
    public function setIblockId($iblock_id)
    {
        $this->fields['IBLOCK_ID'] = $iblock_id;

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
     * Required (Y|N).
     * @param bool $isRequired
     * @return $this
     */
    public function setIsRequired($isRequired = true)
    {
        $this->fields['IS_REQUIRED'] = $isRequired ? 'Y' : 'N';

        return $this;
    }

    /**
     * Sort index.
     * @param int $sort
     * @return $this
     */
    public function setSort($sort = 500)
    {
        $this->fields['SORT'] = $sort;

        return $this;
    }

    /**
     * Property type. Possible values: S - string, N - number, F - file, L - list, E - binding to elements, G - binding to groups.
     * @param string $propertyType
     * @return $this
     */
    public function setPropertyType($propertyType = 'S')
    {
        $this->fields['PROPERTY_TYPE'] = $propertyType;

        return $this;
    }

    /**
     * Set the "List" property type
     * @param array $values array of available values (can be collected using class IBlockPropertyEnum)
     * @param string $listType Type, can be "L" - dropdown list or "C" - checkboxes.
     * @param int $multipleCnt Number of rows in the drop-down list
     * @return $this
     */
    public function setPropertyTypeList($values, $listType = null, $multipleCnt = null)
    {
        $this->setPropertyType('L');
        $this->fields['VALUES'] = $values;

        if (!is_null($listType)) {
            $this->setListType($listType);
        }

        if (!is_null($multipleCnt)) {
            $this->setMultipleCnt($multipleCnt);
        }

        return $this;
    }

    /**
     * Set property type to "File"
     * @param string $fileType A list of valid extensions (separated by commas).
     * @return $this
     */
    public function setPropertyTypeFile($fileType = null)
    {
        $this->setPropertyType('F');

        if (!is_null($fileType)) {
            $this->setFileType($fileType);
        }

        return $this;
    }

    /**
     * Set the property type "binding to elements" or "binding to groups"
     * @param string $property_type Property type. Possible values: E - binding to elements, G - binding to groups.
     * @param string $linkIblockId the code of iblock with the elements / groups of which the value will be associated.
     * @return $this
     */
    public function setPropertyTypeIblock($property_type, $linkIblockId)
    {
        $this->setPropertyType($property_type)->setLinkIblockId($linkIblockId);

        return $this;
    }

    /**
     * Set the "directory" property type
     * @param string $table_name HL table for relation
     * @return $this
     */
    public function setPropertyTypeHl($table_name)
    {
        $this->setPropertyType('S')->setUserType('directory')->setUserTypeSettings([
            'TABLE_NAME' => $table_name
        ]);

        return $this;
    }

    /**
     * Multiple (Y|N).
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = false)
    {
        $this->fields['MULTIPLE'] = $multiple ? 'Y' : 'N';

        return $this;
    }

    /**
     * Number of rows in dropdown list for type properties "list".
     * @param int $multipleCnt
     * @return $this
     */
    public function setMultipleCnt($multipleCnt)
    {
        $this->fields['MULTIPLE_CNT'] = $multipleCnt;

        return $this;
    }

    /**
     * Default property value (except list L type property).
     * @param string $defaultValue
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {
        $this->fields['DEFAULT_VALUE'] = $defaultValue;

        return $this;
    }

    /**
     * The number of lines in the property value entry cell.
     * @param int $rowCount
     * @return $this
     */
    public function setRowCount($rowCount)
    {
        $this->fields['ROW_COUNT'] = $rowCount;

        return $this;
    }

    /**
     * The number of columns in the property value entry cell.
     * @param int $colCount
     * @return $this
     */
    public function setColCount($colCount)
    {
        $this->fields['COL_COUNT'] = $colCount;

        return $this;
    }

    /**
     * The type for the property is list (L). It can be "L" - a drop-down list or "C" - checkboxes.
     * @param string $listType
     * @return $this
     */
    public function setListType($listType = 'L')
    {
        $this->fields['LIST_TYPE'] = $listType;

        return $this;
    }

    /**
     * A list of valid extensions for the file "F" properties (separated by commas).
     * @param string $fileType
     * @return $this
     */
    public function setFileType($fileType)
    {
        $this->fields['FILE_TYPE'] = $fileType;

        return $this;
    }

    /**
     * Index the values of this property.
     * @param bool $searchable
     * @return $this
     */
    public function setSearchable($searchable = false)
    {
        $this->fields['SEARCHABLE'] = $searchable ? 'Y' : 'N';

        return $this;
    }

    /**
     * Output fields for filtering by this property on the list of items page in the administrative section.
     * @param bool $filtrable
     * @return $this
     */
    public function setFiltrable($filtrable = false)
    {
        $this->fields['FILTRABLE'] = $filtrable ? 'Y' : 'N';

        return $this;
    }

    /**
     * For properties of the binding type to elements and groups, sets the code of iblock with the elements/groups of which the value will be associated.
     * @param int $linkIblockId
     * @return $this
     */
    public function setLinkIblockId($linkIblockId)
    {
        $this->fields['LINK_IBLOCK_ID'] = $linkIblockId;

        return $this;
    }

    /**
     * Indicates whether the property value has an additional description field. Only for types S - string, N - number and F - file (Y|N).
     * @param bool $withDescription
     * @return $this
     */
    public function setWithDescription($withDescription)
    {
        $this->fields['WITH_DESCRIPTION'] = $withDescription ? 'Y' : 'N';

        return $this;
    }

    /**
     * ID of the user property type.
     * @param string $user_type
     * @return $this
     */
    public function setUserType($user_type)
    {
        $this->fields['USER_TYPE'] = $user_type;

        return $this;
    }

    /**
     * ID of the user property type.
     * @param array $user_type_settings
     * @return $this
     */
    public function setUserTypeSettings($user_type_settings)
    {
        $this->fields['USER_TYPE_SETTINGS'] = array_merge((array)$this->fields['USER_TYPE_SETTINGS'], $user_type_settings);

        return $this;
    }

    /**
     * Hint
     * @param string $hint
     * @return $this
     */
    public function setHint($hint)
    {
        $this->fields['HINT'] = $hint;

        return $this;
    }
}