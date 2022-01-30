<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<form method="GET" action="index.php">
    <p>
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="back" value="<?= $_SERVER['HTTP_REFERER']?>">
        <input type="hidden" name="id" value="<?= $_GET['id']?>">
        <input type="hidden" name="id_address" value="<?= $_GET['AddressId']?>">
        <input name="name" placeholder="Новое имя" value="<?= $_GET['name']?>">
        <input name="email" placeholder="Новая почта" value="<?= $_GET['email']?>">
        <input name="title" placeholder="новый адрес" value="<?= $_GET['title']?>">
        <input name="description" placeholder="новое описание" value="<?= $_GET['description']?>">
        <input name="country" placeholder="новая страна" value="<?= $_GET['country']?>">
        <input type="submit">
    </p>
</form>