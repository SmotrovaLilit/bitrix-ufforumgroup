<?php
IncludeModuleLangFile(__FILE__);


CModule::AddAutoloadClasses(
    'smotrovalilit.ufforumgroup',
    [
        'LS\UFTypeForumGroup\General\CUserTypeForumGroup' => 'classes/general/CUserTypeForumGroup.php',
        'LS\UFTypeForumGroup\General\CForumGroupEnum' => 'classes/general/CForumGroupEnum.php'
    ]
);

?>