<?php
use Bitrix\Main\Localization\Loc;
use SmotrovaLilit\UFTypeForumGroup\General\CUserTypeForumGroup;

IncludeModuleLangFile(__FILE__);

require __DIR__ . '/../include.php';

if (class_exists('smotrovalilit_ufforumgroup')) {
    return;
}

class smotrovalilit_ufforumgroup extends CModule
{
    public $errors;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->MODULE_ID = 'smotrovalilit.ufforumgroup';

        $arModuleVersion = array();

        require __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('LS_INST_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('LS_INST_MODULE_DESC');
        $this->PARTNER_NAME = Loc::getMessage('LS_INST_MODULE_PARTNER');
    }


    /**
     * @return bool
     */
    public function InstallDB()
    {
        RegisterModule('smotrovalilit.ufforumgroup');
        RegisterModuleDependences('main', 'OnUserTypeBuildList', 'smotrovalilit.ufforumgroup',
            CUserTypeForumGroup::class, 'GetUserTypeDescription');

        return true;
    }

    /**
     * @return bool
     */
    public function UnInstallDB()
    {
        UnRegisterModuleDependences('main', 'OnUserTypeBuildList', 'smotrovalilit.ufforumgroup',
            CUserTypeForumGroup::class, 'GetUserTypeDescription');
        UnRegisterModule('smotrovalilit.ufforumgroup');

        return true;
    }

    /**
     * Установка модуля
     */
    public function DoInstall()
    {
        global $APPLICATION;
        if (!\CModule::IncludeModule('forum')) {
            $APPLICATION->ThrowException(Loc::getMessage('LS_FORUM_NOT_INSTALLED'));
        } else {
            $this->InstallDB();
        }

        $APPLICATION->IncludeAdminFile(Loc::getMessage('LS_INST_INST_TITLE'), __DIR__ . '/step.php');
    }

    /**
     * Удаление модуля
     */
    public function DoUninstall()
    {
        global $APPLICATION;
        $this->UnInstallDB();
        $APPLICATION->IncludeAdminFile(Loc::getMessage('LS_INST_UNINST_TITLE'), __DIR__ . '/unstep.php');
    }

}
