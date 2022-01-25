<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("cards");
?><?php $APPLICATION->IncludeComponent("bitrix:news.list", "cardslist", [
    "IBLOCK_TYPE" => "cards",
    "IBLOCK_ID" => "8",
    "NEWS_COUNT" => "5",
    "PROPERTY_CODE" => [
        'CARD_NUMBER',
        'CARD_USER',
        'CARD_TYPE'
    ],

],
    false
); ?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>