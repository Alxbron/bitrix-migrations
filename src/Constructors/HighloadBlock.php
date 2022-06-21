<?php


namespace Arrilot\BitrixMigrations\Constructors;


use Arrilot\BitrixMigrations\Helpers;
use Arrilot\BitrixMigrations\Logger;
use Bitrix\Highloadblock\HighloadBlockLangTable;
use Bitrix\Highloadblock\HighloadBlockTable;

class HighloadBlock
{
    use FieldConstructor;

    public $lang;

    /**
     * Add HL
     * @throws \Exception
     */
    public function add()
    {
        $result = HighloadBlockTable::add($this->getFieldsWithDefault());

        if (!$result->isSuccess()) {
            throw new \Exception(join(', ', $result->getErrorMessages()));
        }

        foreach ($this->lang as $lid => $name) {
            HighloadBlockLangTable::add([
                "ID" => $result->getId(),
                "LID" => $lid,
                "NAME" => $name
            ]);
        }

        Logger::log("Added HL {$this->fields['NAME']}", Logger::COLOR_GREEN);

        return $result->getId();
    }

    /**
     * Update HL
     * @param $table_name
     * @throws \Exception
     */
    public function update($table_name)
    {
        $id = Helpers::getHlId($table_name);
        $result = HighloadBlockTable::update($id, $this->fields);

        if (!$result->isSuccess()) {
            throw new \Exception(join(', ', $result->getErrorMessages()));
        }

        Logger::log("Updated HL {$table_name}", Logger::COLOR_GREEN);
    }

    /**
     * Delete HL
     * @param $table_name
     * @throws \Exception
     */
    public static function delete($table_name)
    {
        $id = Helpers::getHlId($table_name);
        $result = HighloadBlockTable::delete($id);

        if (!$result->isSuccess()) {
            throw new \Exception(join(', ', $result->getErrorMessages()));
        }

        Logger::log("Deleted HL {$table_name}", Logger::COLOR_GREEN);
    }

    /**
     * set default settings for adding hl
     * @param string $name The name of the highload block
     * @param string $table_name Table name with highload block elements.
     * @return $this
     */
    public function constructDefault($name, $table_name)
    {
        return $this->setName($name)->setTableName($table_name);
    }

    /**
     * The name of the highload block.
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->fields['NAME'] = $name;

        return $this;
    }

    /**
     * Table name with highload block elements.
     * @param string $table_name
     * @return $this
     */
    public function setTableName($table_name)
    {
        $this->fields['TABLE_NAME'] = $table_name;

        return $this;
    }

    /**
     * Set localization
     * @param $lang
     * @param $text
     * @return HighloadBlock
     */
    public function setLang($lang, $text)
    {
        $this->lang[$lang] = $text;

        return $this;
    }
}