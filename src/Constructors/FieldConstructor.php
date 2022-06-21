<?php


namespace Arrilot\BitrixMigrations\Constructors;


trait FieldConstructor
{
    /** @var array */
    public $fields = [];

    public static $defaultFields = [];

    /**
     * Get the final field settings
     */
    public function getFieldsWithDefault()
    {
        return array_merge((array)static::$defaultFields[get_called_class()], $this->fields);
    }
}