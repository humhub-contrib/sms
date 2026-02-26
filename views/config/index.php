<?php

use humhub\helpers\Html;
use humhub\modules\sms\forms\SmsProviderConfigureForm;
use humhub\widgets\bootstrap\Button;
use humhub\widgets\form\ActiveForm;

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

        <?php $form = ActiveForm::begin() ?>

        <?php foreach ($model->attributeNames() as $attributeName): ?>
            <?= $model->getActiveFormElement($form, $attributeName); ?>
        <?php endforeach; ?>

        <?= Button::save(Yii::t('SmsModule.base', 'Save Configuration'))->submit() ?>
        <?php ActiveForm::end() ?>
    </div>
</div>

<script <?= Html::nonce() ?>>
    // load the proper form if provider selection has changed.
    $('.provider-select').change(function () {
        $('.submit-button').click()
    });
</script>
