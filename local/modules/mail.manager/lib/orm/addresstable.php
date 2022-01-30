<?php

namespace Mail\Manager\Orm;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

/**
 * Class ProfilesTable
 * @package app\Orm
 */
class AddressTable extends Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     * @return string
     */
    public static function getTableName()
    {
        return 'y_addresses';
    }

    /**
     * Returns entity map definition.
     * @return array
     * @throws \Exception
     */
    public static function getMap()
    {
        return [
            new Entity\IntegerField('AddressId', [
                'primary' => true,
                'autocomplete' => true,
                'title' => 'AddressId',
            ]),
            new Entity\StringField('TITLE', [
                'validation' => [__CLASS__, 'validateName'],
                'title' => Loc::getMessage("YLAB_MAIL_MANAGER_PROFILE_TITLE_FIELD"),
            ]),
            new Entity\StringField('DESCRIPTION', [
                'validation' => [__CLASS__, 'validateName'],
                'title' => Loc::getMessage('YLAB_MAIL_MANAGER_PROFILE_DESCRIPTION_FIELD'),
            ]),
            new Entity\StringField('COUNTRY', [
                'validation' => [__CLASS__, 'validateName'],
                'title' => Loc::getMessage('YLAB_MAIL_MANAGER_PROFILE_COUNTRY_FIELD'),
            ]),
        ];
    }

    /**
     * Returns validators for NAME field.
     * @return array
     * @throws \Bitrix\Main\ArgumentTypeException
     */
    public static function validateName()
    {
        return [
            new Entity\Validator\Length(null, 255),
        ];
    }
}
