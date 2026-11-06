<?php

use humhub\helpers\Html;
use humhub\modules\sms\forms\SmsProviderConfigureForm;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * @var $model SmsProviderConfigureForm
 */

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('SmsModule.base', 'SMS Module Configuration'); ?>
    </div>
    <div class="panel-body">
        <p><?= Yii::t('SmsModule.base', 'Within this configuration you can choose between different sms-providers and configurate these. You need to edit your account information for the chosen provider properly to have the sms-functionality work properly.'); ?></p>
        <p><?= Yii::t('SmsModule.base', 'To be able to send a sms to a specific account, make sure the profile field "mobile" exists in the account information.'); ?></p>
        <div class="alert alert-info"><?= Yii::t('SmsModule.base', 'SMS can be sent only by administrators, user managers and users with the permission "Send SMS". This permission can be assigned to a group in <a href="{url}">Administration → Users → Groups</a> (action "Permissions" of the group).', ['url' => Url::to(['/admin/group'])]); ?></div>

        <div id="sms-config-form">
            <?= $this->render('_form', ['model' => $model]) ?>
        </div>
    </div>
</div>

<script <?= Html::nonce() ?>>
    // load the form of the selected provider without saving
    $('#sms-config-form').on('change', '.provider-select', function () {
        var $container = $('#sms-config-form');
        $.get(<?= Json::htmlEncode(Url::to(['/sms/config'])) ?>, {provider: this.value}).done(function (html) {
            $container.html(html);
        });
    });
</script>
