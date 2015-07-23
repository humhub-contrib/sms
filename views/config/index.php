<?php

use yii\helpers\Html;
use humhub\compat\CActiveForm;
?>

<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('SmsModule.base', 'SMS Module Configuration'); ?></div>
    <div class="panel-body">
        <p><?php echo Yii::t('SmsModule.base', 'Within this configuration you can choose between different sms-providers and configurate these. You need to edit your account information for the chosen provider properly to have the sms-functionality work properly.'); ?></p>
        <p><?php echo Yii::t('SmsModule.base', 'To be able to send a sms to a specific account, make sure the profile field "mobile" exists in the account information.'); ?></p>

        <?php $form = CActiveForm::begin(); ?>
        <?php foreach ($model->attributeNames() as $attributeName) { ?>
            <div class="form-group">
                <?php echo $form->labelEx($model, $attributeName); ?><br/>
                <?php echo $model->getActiveFormElement($form, $attributeName); ?>
                <?php echo $form->error($model, $attributeName); ?>        	        	
            </div>        	
        <?php } ?>
        <?php echo Html::submitButton(Yii::t('SmsModule.base', 'Save Configuration'), array('class' => 'btn btn-primary submit-button')); ?>
        <?php CActiveForm::end(); ?>        
    </div>
</div>
<script>
    // load the proper form if provider selection has changed.
    $('.provider-select').change(function () {
        $('.submit-button').click()
    });
</script>
