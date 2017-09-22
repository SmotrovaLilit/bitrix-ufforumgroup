<?php
if (!check_bitrix_sessid()) {
    return;
}

if ($ex = $APPLICATION->GetException()) {
    echo CAdminMessage::ShowMessage(array(
        "TYPE" => "ERROR",
        "MESSAGE" => GetMessage("MOD_UNINST_ERR"),
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ));
} else {
    echo CAdminMessage::ShowNote(GetMessage("LS_MOD_UNINST_OK"));
}
?>
<form action="<? echo $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<? echo LANG ?>">
    <input type="submit" name="" value="<? echo GetMessage("LS_MOD_UNINST_BACK"); ?>">
    <form>
