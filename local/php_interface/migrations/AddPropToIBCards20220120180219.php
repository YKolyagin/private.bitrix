<?php

namespace Sprint\Migration;


class AddPropToIBCards20220120180219 extends Version
{
    /** @var string $description */
    protected $description = "Добавим свойства для ИБ Карты";

    /** @var string $moduleVersion */
    protected $moduleVersion = "4.0.3";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists('credit_card', 'cards');

        $helper->Iblock()->addPropertyIfNotExists($iblockId, [
            'NAME' => 'Номер карты',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'CARD_NUMBER',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'N',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => null,
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '2',
            'USER_TYPE' => null,
            'USER_TYPE_SETTINGS' => null,
            'HINT' => '',
        ]);

        $helper->Iblock()->addPropertyIfNotExists($iblockId, [
            'NAME' => 'ФИО Владельца',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'CARD_USER',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => null,
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '2',
            'USER_TYPE' => null,
            'USER_TYPE_SETTINGS' => null,
            'HINT' => '',
        ]);

        $helper->Iblock()->addPropertyIfNotExists($iblockId, [
            'NAME' => 'Тип карты',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'CARD_TYPE',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'L',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => null,
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '2',
            'USER_TYPE' => null,
            'USER_TYPE_SETTINGS' => null,
            'HINT' => '',
            'VALUES' =>
                [
                    0 =>
                        [
                            'VALUE' => 'Личная',
                            'DEF' => 'N',
                            'SORT' => '500',
                            'XML_ID' => 'single',
                        ],
                    1 =>
                        [
                            'VALUE' => 'Корпоративная',
                            'DEF' => 'N',
                            'SORT' => '500',
                            'XML_ID' => 'corporate',
                        ],
                ],
        ]);

    }

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function down()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists('credit_card', 'cards');

        $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_NUMBER');
        $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_USER');
        $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_TYPE');
    }
}
