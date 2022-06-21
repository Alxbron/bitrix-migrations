<?php

namespace Arrilot\BitrixMigrations\Autocreate\Handlers;

use Arrilot\BitrixMigrations\Exceptions\SkipHandlerException;

class OnBeforeIBlockUpdate extends BaseHandler implements HandlerInterface
{
    /**
     * Constructor.
     *
     * @param array $params
     * @throws SkipHandlerException
     */
    public function __construct($params)
    {
        $this->fields = $params[0];

        // If there is no code, then the migration will be created broken.
        // It also allows you to solve the problem that an extra migration is created for the trade catalog
        // when iblock associated with it is updated.
        if (!$this->fields['CODE']) {
            throw new SkipHandlerException();
        }
    }

    /**
     * Get migration name.
     *
     * @return string
     */
    public function getName()
    {
        return "auto_update_iblock_{$this->fields['CODE']}";
    }

    /**
     * Get template name.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'auto_update_iblock';
    }

    /**
     * Get array of placeholders to replace.
     *
     * @return array
     */
    public function getReplace()
    {
        return [
            'fields' => var_export($this->fields, true),
            'code'   => "'".$this->fields['CODE']."'",
        ];
    }
}
