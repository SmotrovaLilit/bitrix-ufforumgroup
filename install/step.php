<?php
if (!check_bitrix_sessid()) {
    return;
}

IncludeModuleLangFile(__FILE__);
if ($ex = $APPLICATION->GetException()) {
    CAdminMessage::ShowMessage(array(
        'TYPE' => 'ERROR',
        'MESSAGE' => GetMessage('LS_MOD_INST_ERR'),
        'DETAILS' => $ex->GetString(),
        'HTML' => true,
    ));
} else {
    CAdminMessage::ShowNote(GetMessage('LS_MOD_INST_OK'));
}
?>
<form action="<?= $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="submit" name="" value="<?= GetMessage('LS_MOD_BACK'); ?>">
    <form>