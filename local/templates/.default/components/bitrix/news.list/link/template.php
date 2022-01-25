<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>
<div class="news-list">
    <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
        <p class="news-item" id="">
            Добро пожаловать в : <?= $arItem['NAME'] ?>
        </p>
    <?php } ?>
</div>
