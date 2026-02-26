<?php

namespace humhub\modules\sms;

use humhub\modules\user\models\User;
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
}
