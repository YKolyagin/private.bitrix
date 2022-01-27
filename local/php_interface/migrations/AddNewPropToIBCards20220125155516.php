<?php

namespace Sprint\Migration;


class AddNewPropToIBCards20220125155516 extends Version
{
    /** @var string $description */
    protected $description = "Добавим новые 3 свойства для ИБ Карты";

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
            'NAME' => 'Стоимость обслуживания',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'CARD_PRICE',
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
            'NAME' => 'Срок действия',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'CARD_TIME_LIMIT',
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
            'NAME' => 'Дата окончания',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'CARD_DATE',
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
            'USER_TYPE' => 'DateTime',
            'USER_TYPE_SETTINGS' => null,
            'HINT' => '',
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

        $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_PRICE');
        $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_TIME_LIMIT');
        $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_DATE');
    }
}
