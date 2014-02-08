<?php

Yii::app()->moduleManager->register(array(
    'id' => 'sms',
    'class' => 'application.modules.sms.SmsModule',
    // Information for Administrators
    'title' => Yii::t('SmsModule.base', 'SMS Gateway'),
    'description' => Yii::t('SmsModule.base', 'Allows sms sending on user profiles.'),
    'author' => '',
    'version' => '',
    'configRoute' => '//sms/smsConfig',
    // Imports
    'import' => array(
        'application.modules.sms.models.*',
        'application.modules.sms.behaviors.*',
        'application.modules.sms.*',
    ),
    // Events to Catch 
    'events' => array(
        array('class' => 'ProfileMenuWidget', 'event' => 'onInit', 'callback' => array('SmsModule', 'onProfileMenuInit')),
    ),
    // Provided User Modules
    'userModules' => array(
        // Informations for the User 
        'sms_profile_receiver' => array(
            'id' => 'sms_profile_receiver',
            'title' => Yii::t('SmsModule.base','SMS Receiver'),
            'image' => '',
            'description' => Yii::t('SmsModule.base', 'Receive SMS on your user profile'),
        ),
    ),
));

?>