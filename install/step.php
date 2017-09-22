<?php
if (!check_bitrix_sessid()) {
    return;
}

IncludeModuleLangFile(__FILE__);
if ($ex = $APPLICATION->GetException()) {
    echo CAdminMessage::ShowMessage(array(
        "TYPE" => "ERROR",
        "MESSAGE" => GetMessage("LS_MOD_INST_ERR"),
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ));
} else {
    echo CAdminMessage::ShowNote(GetMessage("LS_MOD_INST_OK"));
}
?>
<form action="<? echo $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<? echo LANG ?>">
    <input type="submit" name="" value="<? echo GetMessage("LS_MOD_BACK"); ?>">
    <form>