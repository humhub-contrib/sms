<?php

namespace humhub\modules\sms;

use Yii;
use yii\helpers\Url;
use humhub\modules\user\models\User;
use humhub\modules\ui\icon\widgets\Icon;

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
    /**
     * @inheritdoc
     */
    public function getContentContainerTypes()
    {
        return [
            User::class,
        ];
    }

    /**
     * @inheritdoc
     */
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

        if (Yii::$app->hasModule('sms')) {
            $event->sender->addItem([
                'label' => Yii::t('SmsModule.base', 'Send SMS'),
                'icon' => Icon::get('mobile'),
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'sms' && Yii::$app->controller->id == 'send' && Yii::$app->controller->action->id == 'index'),
                'url' => $user->createUrl('//sms/send'),
            ]);
        }
    }

}
