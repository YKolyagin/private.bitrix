<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>
<?php $APPLICATION->includeComponent(
    'bitrix:main.ui.filter',
    '',
    [
        'FILTER_ID' => $arResult['GRID_ID'],
        'GRID_ID' => $arResult['GRID_ID'],
        'FILTER' => $arResult['GRID_FILTER'],
        'VALUE_REQUIRED_MODE' => true,
        'ENABLE_LIVE_SEARCH' => true,
        'ENABLE_LABEL' => true
    ],
    $component
); ?>

<div class="transport-action-bar">
    <a href="" class="ui-btn ui-btn-primary ui-btn-icon-add"
       title="<?= $arResult['BUTTONS']['ADD']['NAME'] ?>">
        <?= $arResult['BUTTONS']['ADD']['NAME'] ?>
    </a>
</div>

<div class="">
    <?php
    $APPLICATION->IncludeComponent(
        'bitrix:main.ui.grid',
        '',
        [
            'GRID_ID' => $arResult['GRID_ID'],
            'COLUMNS' => $arResult['GRID_HEAD'],
            'ROWS' => $arResult['GRID_BODY'],
            'SHOW_ROW_CHECKBOXES' => false,
            'NAV_OBJECT' => $arResult['GRID_NAV'],
            'AJAX_MODE' => 'Y',
            'AJAX_ID' => CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
            'PAGE_SIZES' => [
                ['NAME' => '5', 'VALUE' => '5'],
                ['NAME' => '10', 'VALUE' => '10'],
                ['NAME' => '20', 'VALUE' => '20'],
                ['NAME' => '50', 'VALUE' => '50'],
                ['NAME' => '100', 'VALUE' => '100']
            ],
            'AJAX_OPTION_JUMP' => 'N',
            'SHOW_CHECK_ALL_CHECKBOXES' => false,
            'SHOW_ROW_ACTIONS_MENU' => $arResult['SHOW_ROW_ACTIONS_MENU'],
            'SHOW_GRID_SETTINGS_MENU' => true,
            'SHOW_NAVIGATION_PANEL' => true,
            'SHOW_PAGINATION' => true,
            'SHOW_SELECTED_COUNTER' => false,
            'SHOW_TOTAL_COUNTER' => false,
            'SHOW_PAGESIZE' => true,
            'SHOW_ACTION_PANEL' => true,
            'ALLOW_COLUMNS_SORT' => true,
            'ALLOW_COLUMNS_RESIZE' => true,
            'ALLOW_HORIZONTAL_SCROLL' => true,
            'ALLOW_SORT' => true,
            'ALLOW_PIN_HEADER' => true,
            'AJAX_OPTION_HISTORY' => 'N'
        ]
    ); ?>
</div>
