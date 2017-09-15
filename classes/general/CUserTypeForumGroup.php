<?php

namespace LS\UFTypeForumGroup\General;

IncludeModuleLangFile(__FILE__);


use Bitrix\Main\Localization\Loc;

/**
 * Class CUserTypeForumGroup
 */
class CUserTypeForumGroup extends \CUserTypeEnum
{
    /**
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * Описание пользовательского свойства
     * @return array
     */
    public function GetUserTypeDescription()
    {
        return [
            "USER_TYPE_ID" => "forum_group",
            "CLASS_NAME" => \LS\UFTypeForumGroup\General\CUserTypeForumGroup::className(),
            "DESCRIPTION" => Loc::getMessage("LS_USER_TYPE_FG_DESCRIPTION"),
            "BASE_TYPE" => "int",
        ];
    }

    /**
     * Подготовка параметров
     * @param $arUserField
     * @return array
     */
    public function PrepareSettings($arUserField)
    {
        $height = intval($arUserField["SETTINGS"]["LIST_HEIGHT"]);
        $disp = $arUserField["SETTINGS"]["DISPLAY"];
        if ($disp != "CHECKBOX" && $disp != "LIST")
            $disp = "LIST";

        $groupId = intval($arUserField["SETTINGS"]["DEFAULT_VALUE"]);
        if ($groupId <= 0)
            $groupId = "";

        return array(
            "DISPLAY" => $disp,
            "LIST_HEIGHT" => ($height < 1 ? 1 : $height),
            "DEFAULT_VALUE" => $groupId,
        );
    }

    /**
     * Показывает настройки поля
     * @param bool $userFieldData
     * @param $htmlControlData
     * @param $bVarsFromForm
     * @return string
     */
    public function GetSettingsHTML($userFieldData = false, $htmlControlData, $bVarsFromForm)
    {
        $result = '';

        if ($bVarsFromForm)
            $value = $GLOBALS[$htmlControlData["NAME"]]["DEFAULT_VALUE"];
        elseif (is_array($userFieldData))
            $value = $userFieldData["SETTINGS"]["DEFAULT_VALUE"];
        else
            $value = "";

        if (\CModule::IncludeModule('forum')) {
            $result .= '
			<tr>
				<td>' . Loc::getMessage("LS_USER_TYPE_FG_DEFAULT_VALUE") . ':</td>
				<td>
					<select name="' . $htmlControlData["NAME"] . '[DEFAULT_VALUE]" size="5">
						<option value="">' . Loc::getMessage("LS_FG_VALUE_ANY") . '</option>
			';

            $rs = \CForumGroup::GetListEx([], [
                'LID' => LANGUAGE_ID
            ]);

            while ($ar = $rs->Fetch()) {
                $result .= '<option value="' . $ar["ID"] . '"' . ($ar["ID"] == $value ? " selected" : "") . '>' . $ar["NAME"] . '</option>';
            }

            $result .= '</select>';
        }

        if ($bVarsFromForm)
            $value = $GLOBALS[$htmlControlData["NAME"]]["DISPLAY"];
        elseif (is_array($userFieldData))
            $value = $userFieldData["SETTINGS"]["DISPLAY"];
        else
            $value = "LIST";
        $result .= '
		<tr>
			<td class="adm-detail-valign-top">' . Loc::getMessage("LS_USER_TYPE_FG_ENUM_DISPLAY") . ':</td>
			<td>
				<label><input type="radio" name="' . $htmlControlData["NAME"] . '[DISPLAY]" value="LIST" ' . ("LIST" == $value ? 'checked="checked"' : '') . '>' . Loc::getMessage("LS_USER_TYPE_FG_LIST") . '</label><br>
				<label><input type="radio" name="' . $htmlControlData["NAME"] . '[DISPLAY]" value="CHECKBOX" ' . ("CHECKBOX" == $value ? 'checked="checked"' : '') . '>' . Loc::getMessage("LS_USER_TYPE_FG_CHECKBOX") . '</label><br>
			</td>
		</tr>
		';

        if ($bVarsFromForm)
            $value = intval($GLOBALS[$htmlControlData["NAME"]]["LIST_HEIGHT"]);
        elseif (is_array($userFieldData))
            $value = intval($userFieldData["SETTINGS"]["LIST_HEIGHT"]);
        else
            $value = 5;
        $result .= '
		<tr>
			<td>' . Loc::getMessage("LS_USER_TYPE_FG_LIST_HEIGHT") . ':</td>
			<td>
				<input type="text" name="' . $htmlControlData["NAME"] . '[LIST_HEIGHT]" size="10" value="' . $value . '">
			</td>
		</tr>
		';

        return $result;
    }

    /**
     * Сформировать список значений списка
     * @param $arUserField
     * @return \CDBResult|bool
     */
    public function GetList($arUserField)
    {
        $result = false;
        if (\CModule::IncludeModule('forum')) {
            $forumGroupEnum = new CForumGroupEnum();
            $result = $forumGroupEnum->GetList();
        }

        return $result;
    }

    /**
     * При индексации
     * @param $userFieldData
     * @return string
     */
    public function OnSearchIndex($userFieldData)
    {
        $res = '';

        if (is_array($userFieldData["VALUE"]))
            $val = $userFieldData["VALUE"];
        else
            $val = [$userFieldData["VALUE"]];

        $val = array_filter($val, "strlen");

        if (count($val) && \CModule::IncludeModule('forum')) {

            $rs = \CForumGroup::GetListEx([], [
                'LID' => LANGUAGE_ID
            ]);

            while ($ar = $rs->Fetch())
                $res .= $ar["NAME"] . "\r\n";
        }

        return $res;
    }

}