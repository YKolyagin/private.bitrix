<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>
<div class="news-list">
    <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
        <p class="news-item" id="">
            Номер карты : <?= $arItem['PROPERTIES']['CARD_NUMBER']['VALUE'] ?><br>
            Владелец карты : <?= $arItem['PROPERTIES']['CARD_USER']['VALUE'] ?><br>
            Тип карты : <?= $arItem['PROPERTIES']['CARD_TYPE']['VALUE'] ?>
        </p>
    <?php } ?>
</div>
