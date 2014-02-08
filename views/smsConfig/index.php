
<h1><?php echo Yii::t('SmsModule.base', 'SMS Module Configuration'); ?></h1>
<p><?php echo Yii::t('SmsModule.base', 'This module is experimental and only supports the any-sms gateway! - You need an account there.'); ?></p>
<p><?php echo Yii::t('SmsModule.base', 'Make sure the profile field "mobile" exists and holds only numbers in international format (0049....)'); ?></p>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'notes-configure-form',
    'enableAjaxValidation' => true,
        ));
?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'provider'); ?><br/>
    <?php echo $form->dropdownList($model, 'provider', array('anysms' => 'Any-SMS.info'), array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'provider'); ?>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'username'); ?><br/>
    <?php echo $form->textField($model, 'username', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'username'); ?>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'password'); ?><br/>
    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'password'); ?>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'gateway'); ?><br/>
    <?php echo $form->textField($model, 'gateway', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'gateway'); ?>
</div>

<?php echo CHtml::submitButton(Yii::t('SmsModule.base', 'Save & Test'), array('class' => 'btn btn-primary')); ?>


</div>
<?php $this->endWidget(); ?>
