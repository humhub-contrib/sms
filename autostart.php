<?php

Yii::app()->moduleManager->register(array(
    'id' => 'sms',
    'class' => 'application.modules.sms.SmsModule',
    // Imports
    'import' => array(
        'application.modules.sms.models.*',
        'application.modules.sms.behaviors.*',
        'application.modules.sms.*',
    ),
    // Events to Catch 
    'events' => array(
        array('class' => 'ProfileMenuWidget', 'event' => 'onInit', 'callback' => array('SmsModule', 'onProfileMenuInit')),
    )
));

?>