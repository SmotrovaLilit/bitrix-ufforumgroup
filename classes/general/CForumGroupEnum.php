<?php

namespace SmotrovaLilit\UFTypeForumGroup\General;

/**
 * Class CForumGroupEnum
 */
class CForumGroupEnum extends \CDBResult
{
    /**
     * Получить список значений списка
     * @return bool|\CDBResult|CForumGroupEnum
     */
    public function GetList()
    {
        $rs = false;
        if (\CModule::IncludeModule('forum')) {
            $rs = \CForumGroup::GetListEx([], [
                'LID' => LANGUAGE_ID
            ]);

            if ($rs) {
                $rs = new CForumGroupEnum($rs);
            }
        }
        return $rs;
    }

    /**
     * Получить следующий элемент в списке
     * @param bool $bTextHtmlAuto
     * @param bool $use_tilda
     * @return array
     */
    public function GetNext($bTextHtmlAuto = true, $use_tilda = true)
    {
        $r = parent::GetNext($bTextHtmlAuto, $use_tilda);

        if ($r) {
            $r["VALUE"] = $r["NAME"];
        }

        return $r;
    }


}