<?php

namespace YLab\Components;

use Bitrix\Iblock\IblockTable;
use \Bitrix\Main\ArgumentException;
use \Bitrix\Main\Grid\Options as GridOptions;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use \Bitrix\Main\UI\PageNavigation;
use \CBitrixComponent;
use \CIBlockElement;
use \Exception;
use \Bitrix\Main\UI\Filter\Options;

/**
 * Class CardsListComponent
 * @package YLab\Components
 * Компонент отображения списка элементов нашего ИБ
 */
class CardsListComponent extends CBitrixComponent
{
    /** @var int $idIBlock ID информационного блока */
    private $idIBlock;

    /** @var string $templateName Имя шаблона компонента */
    private $templateName;

    /**
     * @param $arParams
     * @return array
     * @throws \Bitrix\Main\LoaderException
     */
    public function onPrepareComponentParams($arParams)
    {
        Loader::includeModule('iblock');

        $this->templateName = $this->GetTemplateName();

        return $arParams;
    }

    /**
     * Метод executeComponent
     *
     * @return mixed|void
     * @throws Exception
     */
    public function executeComponent()
    {
        $this->idIBlock = self::getIBlockIdByCode($this->arParams['IBLOCK_CODE']);

        if ($this->templateName == 'grid') {
            $this->showByGrid();
        } else {
            $this->arResult['ITEMS'] = $this->getElements();
        }


        $this->includeComponentTemplate();
    }

    /**
     * Получим элементы ИБ
     * @return array
     */
    public function getElements(): array
    {
        $result = [];

        $arFilter = $this->getGridFilterValues();

        $grid_options = new GridOptions($this->getGridId());
        $sort = $grid_options->GetSorting([]);
        $elements = CIBlockElement::GetList(
            $sort['sort'],
            $arFilter,
            false,
            [
                "nPageSize" => $this->getGridNav()->getLimit(),
                "iNumPage" => $this->getGridNav()->getCurrentPage()
            ],
            [
                'ID',
                'IBLOCK_ID',
                'PROPERTY_CARD_NUMBER',
                'PROPERTY_CARD_USER',
                'PROPERTY_CARD_TYPE',
                'PROPERTY_CARD_PRICE',
                'PROPERTY_CARD_TIME_LIMIT',
                'PROPERTY_CARD_DATE',
            ],
        );
        $this->getGridNav()->setRecordCount($elements->SelectedRowsCount());


        while ($element = $elements->GetNext()) {
            $cardSecret = md5($element['PROPERTY_CARD_NUMBER_VALUE']);
            $cardPrice = $element['PROPERTY_CARD_PRICE_VALUE'];
            $cardTimeLimit = $element['PROPERTY_CARD_TIME_LIMIT_VALUE'];

            $result[] = [
                'ID' => $element['ID'],
                'CARD_NUMBER' => $element['PROPERTY_CARD_NUMBER_VALUE'],
                'CARD_USER' => $element['PROPERTY_CARD_USER_VALUE'],
                'CARD_TYPE' => $element['PROPERTY_CARD_TYPE_VALUE'],
                'CARD_PRICE' => $cardPrice,
                'CARD_TIME_LIMIT' => $cardTimeLimit,
                'CARD_DATE' => $element['PROPERTY_CARD_DATE_VALUE'],
                'CARD_TOTAL' => $cardPrice * $cardTimeLimit,
                'CARD_SECRET' => $cardSecret,
            ];
        }

        return $result;
    }

    /**
     * Отображение через грид
     */
    public function showByGrid()
    {
        $this->arResult['GRID_ID'] = $this->getGridId();

        $this->arResult['GRID_BODY'] = $this->getGridBody();
        $this->arResult['GRID_HEAD'] = $this->getGridHead();

        $this->arResult['GRID_NAV'] = $this->getGridNav();
        $this->arResult['GRID_FILTER'] = $this->getGridFilterParams();

        $this->arResult['BUTTONS']['ADD']['NAME'] = Loc::getMessage('YLAB.CARD.LIST.CLASS.ADD');
    }

    /**
     * Возвращает содержимое (тело) таблицы.
     *
     * @return array
     */
    private function getGridBody(): array
    {
        $arBody = [];

        $arItems = $this->getElements();

        foreach ($arItems as $arItem) {
            $arGridElement = [];

            $arGridElement['data'] = [
                'ID' => $arItem['ID'],
                'CARD_NUMBER' => $arItem['CARD_NUMBER'],
                'CARD_USER' => $arItem['CARD_USER'],
                'CARD_TYPE' => $arItem['CARD_TYPE'],
                'CARD_SECRET' => $arItem['CARD_SECRET'],
                'CARD_PRICE' => $arItem['CARD_PRICE'],
                'CARD_TIME_LIMIT' => $arItem['CARD_TIME_LIMIT'],
                'CARD_DATE' => $arItem['CARD_DATE'],
                'CARD_TOTAL' => $arItem['CARD_TOTAL'],
            ];

            $arGridElement['actions'] = [ //Действия над ними
                [
                    'text'    => 'Редактировать',
                    'onclick' => ''
                ],
                [
                    'text'    => 'Удалить',
                    'onclick' => ''
                ]

            ];
            $arBody[] = $arGridElement;
        }

        return $arBody;
    }

    /**
     * Возвращает идентификатор грида.
     *
     * @return string
     */
    private function getGridId(): string
    {
        return 'ylab_cards_list_' . $this->idIBlock;
    }

    /**
     * Возращает заголовки таблицы.
     *
     * @return array
     */
    private function getGridHead(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'default' => true,
                'sort' => 'ID',
            ],
            [
                'id' => 'CARD_NUMBER',
                'name' => Loc::getMessage('YLAB.CARD.LIST.CLASS.NUMBER'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_NUMBER',
            ],
            [
                'id' => 'CARD_USER',
                'name' => Loc::getMessage('YLAB.CARD.LIST.CLASS.USER'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_USER',
            ],
            [
                'id' => 'CARD_TYPE',
                'name' => Loc::getMessage('YLAB.CARD.LIST.CLASS.TYPE'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_TYPE',
            ],
            [
                'id' => 'CARD_SECRET',
                'name' => Loc::getMessage('YLAB.CARD.LIST.CLASS.SECRET'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_SECRET',
            ],
            [
                'id' => 'CARD_PRICE',
                'name' => Loc::getMessage('YLAB.CARD.LIST.CLASS.PRICE'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_PRICE',
            ],
            [
                'id' => 'CARD_TIME_LIMIT',
                'name' => Loc::getMessage('YLAB.CARD.LIST.CLASS.TIME_LIMIT'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_TIME_LIMIT',
            ],
            [
                'id' => 'CARD_DATE',
                'name' => Loc::getMessage('YLAB.CARD.LIST.CLASS.DATE'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_DATE',
            ],
            [
                'id' => 'CARD_TOTAL',
                'name' => Loc::getMessage('YLAB.CARD.LIST.CLASS.TOTAL'),
                'default' => true,
            ],
        ];
    }

    /**
     * Метод возвращает ID инфоблока по символьному коду
     *
     * @param $code
     *
     * @return int|void
     * @throws Exception
     */
    public static function getIBlockIdByCode($code)
    {
        $IB = IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => $code],
            'limit' => '1',
            'cache' => ['ttl' => 3600],
        ]);
        $return = $IB->fetch();
        if (!$return) {
            throw new Exception('IBlock with code"' . $code . '" not found');
        }

        return $return['ID'];
    }

    /**
     * Возвращает настройки отображения грид фильтра.
     *
     * @return array
     */
    private function getGridFilterParams(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'type' => 'number'
            ],
            [
                'id' => 'CARD_NUMBER',
                'name' => 'Номер карты',
                'type' => 'number'
            ],
            [
                'id' => 'CARD_USER',
                'name' => 'Владелец карты',
                'type' => 'string'
            ],
            [
                'id' => 'CARD_TYPE',
                'name' => 'Тип карты',
                'type' => 'string'
            ],
            [
                'id' => 'CARD_PRICE',
                'name' => 'Стоимость карты',
                'type' => 'number'
            ],
            [
                'id' => 'CARD_TIME_LIMIT',
                'name' => 'Срок действия карты',
                'type' => 'number'
            ],
            [
                'id' => 'CARD_DATE',
                'name' => 'Дата окончания карты',
                'type' => 'date'
            ],
        ];
    }

    /**
     * Возвращает единственный экземпляр настроек грида.
     *
     * @return GridOptions
     */
    private function getObGridParams(): GridOptions
    {
        return $this->gridOption ?? $this->gridOption = new GridOptions($this->getGridId());
    }

    /**
     * Параметры навигации грида
     *
     * @return PageNavigation
     */
    private function getGridNav(): PageNavigation
    {
        if ($this->gridNav === null) {
            $this->gridNav = new PageNavigation($this->getGridId());
            $this->gridNav->allowAllRecords(true)->setPageSize($this->getObGridParams()->GetNavParams()['nPageSize'])
                ->initFromUri();
        }
        return $this->gridNav;
    }

    /**
     * Возвращает значения грид фильтра.
     *
     * @return array
     */
    public function getGridFilterValues(): array
    {
        $obFilterOption = new Options($this->getGridId());
        $arFilterData = $obFilterOption->getFilter([]);
        $baseFilter = array_intersect_key($arFilterData, array_flip($obFilterOption->getUsedFields()));
        $formatedFilter = $this->prepareFilter($arFilterData, $baseFilter);

        return array_merge(
            $baseFilter,
            $formatedFilter
        );
    }

    /**
     * Подготавливает параметры фильтра
     * @param array $arFilterData
     * @param array $baseFilter
     * @return array
     */
    public function prepareFilter(array $arFilterData, &$baseFilter = []): array
    {
        $arFilter = [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $this->idIBlock,
        ];

        if (!empty($arFilterData['ID_from'])) {
            $arFilter['>=ID'] = (int)$arFilterData['ID_from'];
        }
        if (!empty($arFilterData['ID_to'])) {
            $arFilter['<=ID'] = (int)$arFilterData['ID_to'];
        }

        if (!empty($arFilterData['CARD_PRICE_from'])) {
            $arFilter['>=PROPERTY_CARD_PRICE'] = (int)$arFilterData['CARD_PRICE_from'];
        }
        if (!empty($arFilterData['CARD_PRICE_to'])) {
            $arFilter['<=PROPERTY_CARD_PRICE'] = (int)$arFilterData['CARD_PRICE_to'];
        }

        if (!empty($arFilterData['CARD_NUMBER_from'])) {
            $arFilter['>=PROPERTY_CARD_NUMBER'] = (int)$arFilterData['CARD_NUMBER_from'];
        }
        if (!empty($arFilterData['CARD_NUMBER_to'])) {
            $arFilter['<=PROPERTY_CARD_NUMBER'] = (int)$arFilterData['CARD_NUMBER_to'];
        }

        if (!empty($arFilterData['CARD_USER'])) {
            $arFilter['PROPERTY_CARD_USER'] = "%" . $arFilterData['CARD_USER'] . "%";
        }

        if (!empty($arFilterData['CARD_TYPE'])) {
            $arFilter['PROPERTY_CARD_TYPE_VALUE'] = "%" . $arFilterData['CARD_TYPE'] . "%";
        }

        if (!empty($arFilterData['CARD_TIME_LIMIT_from'])) {
            $arFilter['>=PROPERTY_CARD_NUMBER'] = (int)$arFilterData['CARD_TIME_LIMIT_from'];
        }
        if (!empty($arFilterData['CARD_TIME_LIMIT_to'])) {
            $arFilter['<=PROPERTY_CARD_TIME_LIMIT'] = (int)$arFilterData['CARD_TIME_LIMIT_to'];
        }

        if (!empty($arFilterData['CARD_DATE_from'])) {
            $arFilter['>=PROPERTY_CARD_DATE'] = FormatDateFromDB($arFilterData['CARD_DATE_from'], 'YYYY-MM-DD');
        }
        if (!empty($arFilterData['CARD_DATE_to'])) {
            $arFilter['<=PROPERTY_CARD_DATE'] = FormatDateFromDB($arFilterData['CARD_DATE_to'], 'YYYY-MM-DD');
        }
        return $arFilter;
    }

}
