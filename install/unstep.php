<?php
if (!check_bitrix_sessid()) {
    return;
}

if ($ex = $APPLICATION->GetException()) {
    CAdminMessage::ShowMessage(array(
        'TYPE' => 'ERROR',
        'MESSAGE' => GetMessage('MOD_UNINST_ERR'),
        'DETAILS' => $ex->GetString(),
        'HTML' => true,
    ));
} else {
    CAdminMessage::ShowNote(GetMessage('LS_MOD_UNINST_OK'));
}
?>
<form action="<?= $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="submit" name="" value="<?= GetMessage('LS_MOD_UNINST_BACK'); ?>">
    <form>
