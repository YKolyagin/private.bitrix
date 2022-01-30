<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Filter\Options;
use Bitrix\Main\UI\PageNavigation;
use Mail\Manager\Profile;
use Bitrix\Main\Loader;


/**
 * Class ProfileManager
 */
class EmailManagerComponent extends CBitrixComponent
{
    /** @var string $templateName Имя шаблона компонента */
    private $templateName;

    /** @var object $profile Экземпляр ОРМ */
    private $profile;

    /**
     * @return mixed|void
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function executeComponent()
    {
        Loader::includeModule('mail.manager');

        $this->templateName = $this->GetTemplateName();

        $this->profile = new Profile();

        if ($this->templateName == 'grid') {
            $this->showByGrid();
        }

        if(isset($_GET["action"]) && $_GET["action"] == 'add')
        {
            $this->profile->addProfile([
                "name" => $_GET["name"],
                "title" => $_GET["title"],
                "description" => $_GET["description"],
                "country" => $_GET["country"],
                "email" => $_GET["email"]]);
        }

        if(isset($_GET["action"]) && $_GET["action"] == 'del')
        {
            $this->profile->deleteProfile($_GET['id'], $_GET['attr']);
        }

        if(isset($_GET["action"]) && $_GET["action"] == 'update')
        {
            $this->profile->updateProfile($_GET['id'],[
                'email' => $_GET['email'],
                'name' => $_GET['name'],
                'title' => $_GET['title'],
                'id_address' => $_GET['id_address'],
                'description' => $_GET['description'],
                'country' => $_GET['country']
            ]);
        }

        $this->includeComponentTemplate();
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

        $this->arResult['BUTTONS']['ADD']['NAME'] = Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.ADD');
    }

    /**
     * Возвращает идентификатор грида.
     *
     * @return string
     */
    private function getGridId(): string
    {
        return 'ylab_email_manager';
    }

    /**
     * Возвращает содержимое (тело) таблицы.
     *
     * @return array
     */
    private function getGridBody(): array
    {
        $arBody = [];
        $arParams = ['count_total' => true,];
        $grid_options = new GridOptions($this->getGridId());
        $arParams['order'] = $grid_options->GetSorting([])['sort'];
        $arParams['filter'] = $this->getGridFilterValues();
        $arParams['limit'] = $this->getGridNav()->getLimit();
        $arParams['offset'] = $this->getGridNav()->getOffset();
        $arItems = $this->profile->getProfiles($arParams);
        $this->getGridNav()->setRecordCount($arItems['COUNT']);
        foreach ($arItems["PROFILES"] as $arItem) {
            $arGridElement = [];

            $arGridElement['data'] = [
                'ID' => $arItem['ID'],
                'NAME' => $arItem['NAME'],
                'EMAIL' => $arItem['EMAIL'],
                'TITLE' => $arItem["MAIL_MANAGER_ORM_EMAILS_ADDRESS_INNER_TITLE"],
                'DESCRIPTION' => $arItem["MAIL_MANAGER_ORM_EMAILS_ADDRESS_INNER_DESCRIPTION"],
                'COUNTRY' => $arItem["MAIL_MANAGER_ORM_EMAILS_ADDRESS_INNER_COUNTRY"]
            ];

            $arGridElement['actions'] = [ //Действия над ними
                [
                    'text' => Loc::getMessage("YLAB.EMAIL.MANAGER.CLASS.EDIT"),
                    'onclick' => 'document.location.href="edit.php?id=' . $arItem['ID'] . '&name=' . $arItem['NAME'] . '&email=' . $arItem['EMAIL'] . '&title=' . $arItem['MAIL_MANAGER_ORM_EMAILS_ADDRESS_INNER_TITLE'] . '&description=' . $arItem['MAIL_MANAGER_ORM_EMAILS_ADDRESS_INNER_DESCRIPTION'] . '&country=' . $arItem['MAIL_MANAGER_ORM_EMAILS_ADDRESS_INNER_COUNTRY'] . '&AddressId=' . $arItem['MAIL_MANAGER_ORM_EMAILS_ADDRESS_INNER_AddressId'] . '"',
                ],
                [
                    'text' => Loc::getMessage("YLAB.EMAIL.MANAGER.CLASS.DEL"),
                    'onclick' => 'document.location.href="?action=del&id=' . $arItem['ID'] . '&attr=' . $arItem['MAIL_MANAGER_ORM_EMAILS_ADDRESS_INNER_AddressId'] . '"',
                ]

            ];
            $arGridElement["editable"] = true;
            $arBody[] = $arGridElement;
        }

        return $arBody;
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
                'id' => 'NAME',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.NAME'),
                'default' => true,
                'sort' => 'NAME',
            ],
            [
                'id' => 'EMAIL',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.EMAIL'),
                'default' => true,
                'sort' => 'EMAIL',
            ],
            [
                'id' => 'TITLE',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.TITLE'),
                'default' => true,
                'sort' => 'TITLE',
            ],
            [
                'id' => 'DESCRIPTION',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.DESCRIPTION'),
                'default' => true,
                'sort' => 'DESCRIPTION',
            ],
            [
                'id' => 'COUNTRY',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.COUNTRY'),
                'default' => true,
                'sort' => 'COUNTRY',
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
                'id' => 'NAME',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.NAME'),
                'type' => 'string'
            ],
            [
                'id' => 'EMAIL',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.EMAIL'),
                'type' => 'string'
            ],
            [
                'id' => 'TITLE',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.TITLE'),
                'type' => 'string'
            ],
            [
                'id' => 'DESCRIPTION',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.DESCRIPTION'),
                'type' => 'string'
            ],
            [
                'id' => 'COUNTRY',
                'name' => Loc::getMessage('YLAB.EMAIL.MANAGER.CLASS.COUNTRY'),
                'type' => 'string'
            ],
        ];
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
        $arFilter = [];

        if (!empty($arFilterData['ID_from'])) {
            $arFilter['>=ID'] = (int)$arFilterData['ID_from'];
        }
        if (!empty($arFilterData['ID_to'])) {
            $arFilter['<=ID'] = (int)$arFilterData['ID_to'];
        }
        if (!empty($arFilterData['NAME'])) {
            $arFilter['NAME'] = "%" . $arFilterData['NAME'] . "%";
        }
        if (!empty($arFilterData['EMAIL'])) {
            $arFilter['EMAIL'] = "%" . $arFilterData['EMAIL'] . "%";
        }
        return $arFilter;
    }
}