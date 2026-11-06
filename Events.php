<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sms;

use humhub\helpers\ControllerHelper;
use humhub\modules\sms\permissions\SendSms;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\user\widgets\ProfileMenu;
use Yii;

class Events
{
    public static function onProfileMenuInit($event)
    {
        /* @var ProfileMenu $menu */
        $menu = $event->sender;

        /* @var Module|null $module */
        $module = Yii::$app->getModule('sms');

        if ($module !== null && $module->isConfigured() && SendSms::isAllowed() && $module->getUserMobile($menu->user) !== null) {
            $menu->addEntry(new MenuLink([
                'label' => Yii::t('SmsModule.base', 'Send SMS'),
                'icon' => 'mobile',
                'isActive' => ControllerHelper::isActivePath('sms', 'send', 'index'),
                'url' => $menu->user->createUrl('/sms/send'),
            ]));
        }
    }
}
