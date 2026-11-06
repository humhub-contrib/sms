<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sms\permissions;

use humhub\modules\admin\components\BaseAdminPermission;
use humhub\modules\admin\permissions\ManageUsers;
use Yii;

/**
 * SendSms permission allows to send SMS to the mobile number of other users.
 * It is always allowed for the administrators.
 */
class SendSms extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $moduleId = 'sms';

    /**
     * @inheritdoc
     */
    protected $id = 'send_sms';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = Yii::t('SmsModule.base', 'Send SMS');
        $this->description = Yii::t('SmsModule.base', 'Can send SMS to the mobile number of other users.');
    }

    /**
     * Checks if the current user is allowed to send SMS:
     * as an administrator, with this permission or as a user manager.
     */
    public static function isAllowed(): bool
    {
        return Yii::$app->user->can([self::class, ManageUsers::class]);
    }
}
