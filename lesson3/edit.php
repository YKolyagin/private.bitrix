<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>

<?php
$APPLICATION->IncludeComponent(
    'ylab:email.manager',
    'edit',
    []
);
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; ?>