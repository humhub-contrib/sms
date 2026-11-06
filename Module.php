<?php

namespace humhub\modules\sms;

use humhub\modules\sms\permissions\SendSms;
use humhub\modules\user\models\ProfileField;
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
    public function getPermissions($contentContainer = null)
    {
        return $contentContainer === null ? [new SendSms()] : [];
    }

    /**
     * The module is switched off, as long as no SMS provider is selected in the configuration.
     */
    public function isConfigured(): bool
    {
        return !empty($this->settings->get('provider'));
    }

    /**
     * Returns the mobile number of the given user, if the profile field exists and is visible.
     */
    public function getUserMobile(User $user): ?string
    {
        $profileField = ProfileField::findOne(['internal_name' => 'mobile']);
        if ($profileField === null || !$profileField->visible) {
            return null;
        }

        $mobile = trim((string) $user->profile->mobile);

        return $mobile === '' ? null : $mobile;
    }

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/sms/config']);
    }
}
