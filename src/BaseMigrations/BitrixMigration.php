<?php

namespace Arrilot\BitrixMigrations\BaseMigrations;

use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Arrilot\BitrixMigrations\Interfaces\MigrationInterface;
use Bitrix\Main\Application;
use Bitrix\Main\DB\Connection;
use CIBlock;
use CIBlockProperty;
use CUserTypeEntity;

class BitrixMigration implements MigrationInterface
{
    /**
     * DB connection.
     *
     * @var Connection
     */
    protected $db;

    /**
     * @var bool
     */
    public $use_transaction = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = Application::getConnection();
    }

    /**
     * Run the migration.
     *
     * @return mixed
     */
    public function up()
    {
        //
    }

    /**
     * Reverse the migration.
     *
     * @return mixed
     */
    public function down()
    {
        //
    }

    /**
     * Does migration use transaction
     * @param bool $default
     * @return bool
     */
    public function useTransaction($default = false)
    {
        if (!is_null($this->use_transaction)) {
            return $this->use_transaction;
        }

        return $default;
    }

    /**
     * Find iblock id by its code.
     *
     * @param string $code
     * @param null|string $iBlockType
     *
     * @throws MigrationException
     *
     * @return int
     */
    protected function getIblockIdByCode($code, $iBlockType = null)
    {
        if (!$code) {
            throw new MigrationException('Iblock code not set');
        }

        $filter = [
            'CODE'              => $code,
            'CHECK_PERMISSIONS' => 'N',
        ];

        if ($iBlockType !== null) {
            $filter['TYPE'] = $iBlockType;
        }

        $iblock = (new CIBlock())->GetList([], $filter)->fetch();

        if (!$iblock['ID']) {
            throw new MigrationException("Failed to find iblock with code '{$code}'");
        }

        return $iblock['ID'];
    }

    /**
     * Delete iblock by its code.
     *
     * @param string $code
     *
     * @throws MigrationException
     *
     * @return void
     */
    protected function deleteIblockByCode($code)
    {
        $id = $this->getIblockIdByCode($code);

        $this->db->startTransaction();
        if (!CIBlock::Delete($id)) {
            $this->db->rollbackTransaction();
            throw new MigrationException('Error while deleting iblock');
        }

        $this->db->commitTransaction();
    }

    /**
     * Add iblock element property.
     *
     * @param array $fields
     *
     * @throws MigrationException
     *
     * @return int
     */
    public function addIblockElementProperty($fields)
    {
        $ibp = new CIBlockProperty();
        $propId = $ibp->add($fields);

        if (!$propId) {
            throw new MigrationException('Error when adding iblock property '.$ibp->LAST_ERROR);
        }

        return $propId;
    }

    /**
     * Delete iblock element property.
     *
     * @param string     $code
     * @param string|int $iblockId
     *
     * @throws MigrationException
     */
    public function deleteIblockElementPropertyByCode($iblockId, $code)
    {
        if (!$iblockId) {
            throw new MigrationException('Iblock ID not set');
        }

        if (!$code) {
            throw new MigrationException('Property code not set');
        }

        $id = $this->getIblockPropIdByCode($code, $iblockId);

        CIBlockProperty::Delete($id);
    }

    /**
     * Add User Field.
     *
     * @param $fields
     *
     * @throws MigrationException
     *
     * @return int
     */
    public function addUF($fields)
    {
        if (!$fields['FIELD_NAME']) {
            throw new MigrationException('FIELD_NAME not filled');
        }

        if (!$fields['ENTITY_ID']) {
            throw new MigrationException('ENTITY_ID code not filled');
        }

        $oUserTypeEntity = new CUserTypeEntity();

        $fieldId = $oUserTypeEntity->Add($fields);

        if (!$fieldId) {
            throw new MigrationException("Failed to create user field with FIELD_NAME = {$fields['FIELD_NAME']} and ENTITY_ID = {$fields['ENTITY_ID']}");
        }

        return $fieldId;
    }

    /**
     * Get UF by its code.
     *
     * @param string $entity
     * @param string $code
     *
     * @throws MigrationException
     */
    public function getUFIdByCode($entity, $code)
    {
        if (!$entity) {
            throw new MigrationException('Property entity not set');
        }

        if (!$code) {
            throw new MigrationException('Property code not set');
        }

        $filter = [
            'ENTITY_ID'  => $entity,
            'FIELD_NAME' => $code,
        ];

        $arField = CUserTypeEntity::GetList(['ID' => 'ASC'], $filter)->fetch();
        if (!$arField || !$arField['ID']) {
            throw new MigrationException("Property not found with FIELD_NAME = {$filter['FIELD_NAME']} and ENTITY_ID = {$filter['ENTITY_ID']}");
        }

        return $arField['ID'];
    }

    /**
     * @param $code
     * @param $iblockId
     *
     * @throws MigrationException
     *
     * @return array
     */
    protected function getIblockPropIdByCode($code, $iblockId)
    {
        $filter = [
            'CODE'      => $code,
            'IBLOCK_ID' => $iblockId,
        ];

        $prop = CIBlockProperty::getList(['sort' => 'asc', 'name' => 'asc'], $filter)->getNext();
        if (!$prop || !$prop['ID']) {
            throw new MigrationException("Could not find property with code '{$code}'");
        }

        return $prop['ID'];
    }
}
