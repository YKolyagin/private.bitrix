<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?><?php $APPLICATION->IncludeComponent("ylab:cards.list", "grid", [
    "IBLOCK_ID" => "8",

],
    false
); ?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>