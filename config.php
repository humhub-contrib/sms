<?php

use humhub\modules\sms\Events;
use humhub\modules\user\widgets\ProfileMenu;

return [
    'id' => 'sms',
    'class' => 'humhub\modules\sms\Module',
    'namespace' => 'humhub\modules\sms',
    'events' => [
        ['class' => ProfileMenu::class, 'event' => ProfileMenu::EVENT_INIT, 'callback' => [Events::class, 'onProfileMenuInit']],
    ],
];
