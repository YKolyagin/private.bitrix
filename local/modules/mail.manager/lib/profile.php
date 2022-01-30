<?php

namespace Mail\Manager;

use Mail\Manager\Orm\AddressTable;
use Mail\Manager\Orm\EmailsTable;
use Bitrix\Main\Localization\Loc;


/**
 * Class Profile
 * @package YLab\Mail
 */
class Profile
{
    /**
     * Список профилей
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getProfiles($arParams)
    {
        $result = [];

        $result['HEADER']['ID'] = Loc::getMessage('YLAB_MAIL_MANAGER_PROFILE_HEAD_ID');
        $result['HEADER']['NAME'] = Loc::getMessage('YLAB_MAIL_MANAGER_PROFILE_HEAD_NAME');
        $result['HEADER']['EMAIL'] = Loc::getMessage('YLAB_MAIL_MANAGER_PROFILE_HEAD_EMAIL');

        $arParams['select'] = ['*', 'ADDRESS_INNER'];

        $oProfiles = EmailsTable::getList($arParams);
        $result['COUNT'] = $oProfiles->getCount();
        if ($oProfiles->getSelectedRowsCount()) {
            while ($arProfile = $oProfiles->fetch()) {
                $result['PROFILES'][] = $arProfile;
            }
        }
        return $result;
    }

    /**
     * Получаем данные выбранного профиля
     * @param $iProfileID
     * @return bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getProfile($iProfileID)
    {
        $arProfile = EmailsTable::getById($iProfileID)->fetchAll();

        if (isset($arProfile[0]['ID']) && is_numeric($arProfile[0]['ID'])) {
            return $arProfile[0];
        }

        return false;
    }

    /**
     * Добавляем профиль
     */
    public function addProfile($arFields)
    {
        $id = AddressTable::add(
            [
                'TITLE' => $arFields['title'],
                'DESCRIPTION' => $arFields['description'],
                'COUNTRY' => $arFields['country'],
            ]
        );
        $result = EmailsTable::add(
            [
                'NAME' => $arFields['name'],
                'EMAIL' => $arFields['email'],
                'ADDRESS' => $id->getId()
            ]
        );
        if ($result->isSuccess())
        {
            header("Location: {$_GET['back']}");
        }
    }

    /**
     * Обновляем профиль
     */
    public function updateProfile($iProfileID, $arFields)
    {
        $id = AddressTable::update($arFields['id_address'],
            [
                'TITLE' => $arFields['title'],
                'DESCRIPTION' => $arFields['description'],
                'COUNTRY' => $arFields['country'],
            ]
        );
        $result = EmailsTable::update($iProfileID,
            [
                'NAME' => $arFields['name'],
                'EMAIL' => $arFields['email']
            ]
        );
        if ($result->isSuccess())
        {
            header("Location: {$_GET['back']}");
        }
    }

    /**
     * Удаляем профиль
     */
    public function deleteProfile($iProfileID, $attr)
    {

        $result = EmailsTable::delete($iProfileID);

        if ($result->isSuccess())
        {
            AddressTable::delete($attr);
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }
}