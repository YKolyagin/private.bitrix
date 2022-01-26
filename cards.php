<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); ?>

<?php $APPLICATION->IncludeComponent(
    "ylab:cards.list",
    "grid",
    [
        'IBLOCK_CODE' => 'credit_card'
    ]
); ?>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>