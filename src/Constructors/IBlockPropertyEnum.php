<?php


namespace Arrilot\BitrixMigrations\Constructors;


use Arrilot\BitrixMigrations\Logger;
use Bitrix\Main\Application;

class IBlockPropertyEnum
{
    use FieldConstructor;

    /**
     * Add a list value
     * @throws \Exception
     */
    public function add()
    {
        $obj = new \CIBlockPropertyEnum();

        $property_enum_id = $obj->Add($this->getFieldsWithDefault());

        if (!$property_enum_id) {
            throw new \Exception("Error adding enum value");
        }

        Logger::log("Added enum list value {$this->fields['VALUE']}", Logger::COLOR_GREEN);

        return $property_enum_id;
    }

    /**
     * Update iblock property
     * @param $id
     * @throws \Exception
     */
    public function update($id)
    {
        $obj = new \CIBlockPropertyEnum();
        if (!$obj->Update($id, $this->fields)) {
            throw new \Exception("Error updating the enum value");
        }

        Logger::log("Updated the value of the enum list {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Delete iblock property
     * @param $id
     * @throws \Exception
     */
    public static function delete($id)
    {
        if (!\CIBlockPropertyEnum::Delete($id)) {
            throw new \Exception('Error deleting enum value');
        }

        Logger::log("Removed enum list value {$id}", Logger::COLOR_GREEN);
    }

    /**
     * Set the settings for adding the default enum value of iblock
     * @param string $xml_id
     * @param string $value
     * @param int $propertyId
     * @return $this
     */
    public function constructDefault($xml_id, $value, $propertyId = null)
    {
         $this->setXmlId($xml_id)->setValue($value);

         if ($propertyId) {
             $this->setPropertyId($propertyId);
         }

         return $this;
    }

    /**
     * The property code.
     * @param string $propertyId
     * @return $this
     */
    public function setPropertyId($propertyId)
    {
        $this->fields['PROPERTY_ID'] = $propertyId;

        return $this;
    }

    /**
     * Outer code.
     * @param string $xml_id
     * @return $this
     */
    public function setXmlId($xml_id)
    {
        $this->fields['XML_ID'] = $xml_id;

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
     * Value of the property variant.
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->fields['VALUE'] = $value;

        return $this;
    }

    /**
     * Value of the property variant.
     * @param bool $def
     * @return $this
     */
    public function setDef($def)
    {
        $this->fields['DEF'] = $def ? 'Y' : 'N';

        return $this;
    }
}