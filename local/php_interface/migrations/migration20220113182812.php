<?php

namespace Sprint\Migration;

/**
 * Наша первая миграция ИБ
 */
class migration20220113182812 extends Version
{
    /**
     * @var string $description
     */
    protected $description = "";

    /** @var string $moduleVersion */
    protected $moduleVersion = "4.0.3";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $helper->Iblock()->saveIblockType([
            'ID' => 'cards',
            'SECTIONS' => 'N',
            'EDIT_FILE_BEFORE' => null,
            'EDIT_FILE_AFTER' => null,
            'IN_RSS' => 'Y',
            'SORT' => '50',
            'LANG' =>
                [
                    'ru' =>
                        [
                            'NAME' => 'Карты',
                            'SECTION_NAME' => '',
                            'ELEMENT_NAME' => 'Карты',
                        ],
                    'en' =>
                        [
                            'NAME' => 'News',
                            'SECTION_NAME' => '',
                            'ELEMENT_NAME' => 'News',
                        ],
                ],
        ]);
        $iblockId = $helper->Iblock()->saveIblock([
            'IBLOCK_TYPE_ID' => 'cards',
            'LID' =>
                [
                    0 => 's1',
                ],
            'CODE' => 'credit_card',
            'API_CODE' => null,
            'REST_ON' => 'N',
            'NAME' => 'Кредитные карты',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'LIST_PAGE_URL' => '#SITE_DIR#/news/index.php?ID=#IBLOCK_ID#',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/news/detail.php?ID=#ELEMENT_ID#',
            'SECTION_PAGE_URL' => null,
            'CANONICAL_PAGE_URL' => '',
            'PICTURE' => null,
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
            'RSS_TTL' => '24',
            'RSS_ACTIVE' => 'N',
            'RSS_FILE_ACTIVE' => 'N',
            'RSS_FILE_LIMIT' => '10',
            'RSS_FILE_DAYS' => '7',
            'RSS_YANDEX_ACTIVE' => 'N',
            'XML_ID' => null,
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'N',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'SECTION_CHOOSER' => 'L',
            'LIST_MODE' => '',
            'RIGHTS_MODE' => 'S',
            'SECTION_PROPERTY' => 'N',
            'PROPERTY_INDEX' => 'N',
            'VERSION' => '2',
            'LAST_CONV_ELEMENT' => '0',
            'SOCNET_GROUP_ID' => null,
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'SECTIONS_NAME' => 'Разделы',
            'SECTION_NAME' => 'Раздел',
            'ELEMENTS_NAME' => 'Элементы',
            'ELEMENT_NAME' => 'Элемент',
            'EXTERNAL_ID' => null,
            'LANG_DIR' => '/',
            'SERVER_NAME' => null,
            'IPROPERTY_TEMPLATES' =>
                [],
            'ELEMENT_ADD' => 'Добавить элемент',
            'ELEMENT_EDIT' => 'Изменить элемент',
            'ELEMENT_DELETE' => 'Удалить элемент',
            'SECTION_ADD' => 'Добавить раздел',
            'SECTION_EDIT' => 'Изменить раздел',
            'SECTION_DELETE' => 'Удалить раздел',
        ]);

    }

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function down()
    {
        $helper = $this->getHelperManager();

        $helper->Iblock()->deleteIblockIfExists('credit_card');
        $helper->Iblock()->deleteIblockTypeIfExists('cards');
    }
}
