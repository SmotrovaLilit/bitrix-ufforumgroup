<?php
IncludeModuleLangFile(__FILE__);

CModule::AddAutoloadClasses(
    'smotrovalilit.ufforumgroup',
    [
        'SmotrovaLilit\UFTypeForumGroup\General\CUserTypeForumGroup' => 'classes/general/CUserTypeForumGroup.php',
        'SmotrovaLilit\UFTypeForumGroup\General\CForumGroupEnum' => 'classes/general/CForumGroupEnum.php'
    ]
);
