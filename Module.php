<?php

namespace humhub\modules\sms;

use Yii;
use yii\helpers\Url;

/**
 * SmsModule is the WebModule for the sms message system.
 *
 * This class is also used to process events catched by the autostart.php listeners.
 *
 * @package humhub.modules.sms
 * @since 0.5
 * @author Luke
 */
class Module extends \humhub\components\Module
{

    public function behaviors()
    {
        return [
            \humhub\modules\user\behaviors\UserModule::className(),
        ];
    }

    public function getConfigUrl()
    {
        return Url::to(['/sms/config']);
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
        $user = $event->sender->user;
        if ($user->isModuleEnabled('sms')) {
            $event->sender->addItem(array(
                'label' => Yii::t('SmsModule.base', 'Send SMS'),
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'sms' && Yii::$app->controller->id == 'send' && Yii::$app->controller->action->id == 'index'),
                'url' => $user->createUrl('//sms/send')
            ));
        }
    }

}
