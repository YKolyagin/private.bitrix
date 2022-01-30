<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<form method="GET" action="index.php">
    <p>
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="back" value="<?= $_SERVER['HTTP_REFERER']?>">
        <input name="name" placeholder="Новое имя">
        <input name="email" placeholder="Новая почта">
        <input name="title" placeholder="новый адрес">
        <input name="description" placeholder="новое описание">
        <input name="country" placeholder="новая страна">
        <input type="submit">
    </p>
</form>