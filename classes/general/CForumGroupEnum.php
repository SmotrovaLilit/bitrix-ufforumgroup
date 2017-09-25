<?php

namespace SmotrovaLilit\UFTypeForumGroup\General;

use CDBResult;
use CForumGroup;
use CModule;

/**
 * Class CForumGroupEnum
 */
class CForumGroupEnum extends CDBResult
{
    /**
     * Получить список значений списка
     * @return bool|CDBResult|CForumGroupEnum
     */
    public function GetList()
    {
        if (!CModule::IncludeModule('forum')) {
            return false;
        }

        $rs = CForumGroup::GetListEx([], ['LID' => LANGUAGE_ID]);
        if (!$rs) {
            return false;
        }

        return new self($rs);
    }

    /**
     * Получить следующий элемент в списке
     * @param bool $bTextHtmlAuto
     * @param bool $use_tilda
     * @return array|false
     */
    public function GetNext($bTextHtmlAuto = true, $use_tilda = true)
    {
        $r = parent::GetNext($bTextHtmlAuto, $use_tilda);
        if (!$r) {
            return false;
        }

        $r['VALUE'] = $r['NAME'];

        return $r;
    }
}