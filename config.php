<?php

use humhub\modules\user\widgets\ProfileMenu;

return [
    'id' => 'sms',
    'class' => 'humhub\modules\sms\Module',
    'namespace' => 'humhub\modules\sms',
    'events' => [
        array('class' => ProfileMenu::className(), 'event' => ProfileMenu::EVENT_INIT, 'callback' => array('humhub\modules\sms\Module', 'onProfileMenuInit')),
    ]
];
?>