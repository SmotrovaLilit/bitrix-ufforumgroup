<?php
use Bitrix\Main\Localization\Loc;

IncludeModuleLangFile(__FILE__);

include __DIR__ . '/../include.php';

if(class_exists("smotrovalilit_ufforumgroup")) return;

class smotrovalilit_ufforumgroup extends CModule
{
	var $MODULE_ID = "smotrovalilit.ufforumgroup";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	var $errors;

    /**
     * constructor.
     */
	public function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

		$this->MODULE_NAME = Loc::getMessage("LS_INST_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("LS_INST_MODULE_DESC");
		$this->PARTNER_NAME = Loc::getMessage("LS_INST_MODULE_PARTNER");
	}


    /**
     * @return bool
     */
	public function InstallDB()
	{
		RegisterModule("smotrovalilit.ufforumgroup");
		RegisterModuleDependences("main", "OnUserTypeBuildList", "smotrovalilit.ufforumgroup", \LS\UFTypeForumGroup\General\CUserTypeForumGroup::className(), "GetUserTypeDescription");

		return true;
	}

    /**
     * @return bool
     */
	public function UnInstallDB()
	{
		UnRegisterModuleDependences("main", "OnUserTypeBuildList", "smotrovalilit.ufforumgroup", \LS\UFTypeForumGroup\General\CUserTypeForumGroup::className(), "GetUserTypeDescription");
		UnRegisterModule("smotrovalilit.ufforumgroup");

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

		$APPLICATION->IncludeAdminFile(Loc::getMessage("LS_INST_INST_TITLE"), __DIR__ . "/step.php");
	}

    /**
     * Удаление модуля
     */
	public function DoUninstall()
	{
		global $APPLICATION;
		$this->UnInstallDB();
		$APPLICATION->IncludeAdminFile(Loc::getMessage("LS_INST_UNINST_TITLE"), __DIR__ . "/unstep.php");
	}

}
?>