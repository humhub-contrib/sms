<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\sms\forms\SmsProviderConfigureForm;
use humhub\widgets\bootstrap\Button;
use humhub\widgets\form\ActiveForm;

/* @var $model SmsProviderConfigureForm */
?>
<?php $form = ActiveForm::begin() ?>

<?php foreach ($model->attributeNames() as $attributeName): ?>
    <?= $model->getActiveFormElement($form, $attributeName); ?>
<?php endforeach; ?>

<?= Button::save(Yii::t('SmsModule.base', 'Save Configuration'))->submit() ?>

<?php ActiveForm::end() ?>
