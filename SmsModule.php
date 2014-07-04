<?php

/**
 * SmsModule is the WebModule for the sms message system.
 *
 * This class is also used to process events catched by the autostart.php listeners.
 *
 * @package humhub.modules.sms
 * @since 0.5
 * @author Luke
 */
class SmsModule extends HWebModule
{

    /**
     * Inits the Module
     */
    public function init()
    {

        $this->setImport(array(
            'sms.models.*',
            'sms.behaviors.*',
        ));
    }

    public function behaviors()
    {

        return array(
            'UserModuleBehavior' => array(
                'class' => 'application.modules_core.user.behaviors.UserModuleBehavior',
            ),
        );
    }

    public function getConfigUrl()
    {
        return Yii::app()->createUrl('//sms/smsConfig');
    }

    
    
    /**
     * On AccountNavigationWidget init, this callback will be called
     * to add some extra navigation items.
     *
     * (The event is catched in example/autostart.php)
     *
     * @param type $event
     */
    public static function onProfileMenuInit($event)
    {
        // Reckon the current controller is a valid profile controller
        // (Needs to implement the ProfileControllerBehavior)

        $user = Yii::app()->getController()->getUser();

        if ($user->isModuleEnabled('sms')) {

#            if ($user->profile->mobile) {
                $userGuid = $user->guid;
                $event->sender->addItem(array(
                    'label' => Yii::t('SmsModule.base', 'Send SMS'),
                    'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'sms' && Yii::app()->controller->id == 'smsSend' && Yii::app()->controller->action->id == 'index'),
                    'url' => Yii::app()->createUrl('//sms/smsSend/index', array('uguid' => $userGuid))
                ));
 #           }
        }
    }

}
