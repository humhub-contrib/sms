
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('SmsModule.base', 'SMS Module Configuration'); ?></div>
    <div class="panel-body">
        <p><?php echo Yii::t('SmsModule.base', 'This module is experimental and only supports the any-sms gateway! - You need an account there.'); ?></p>
        <p><?php echo Yii::t('SmsModule.base', 'Make sure the profile field "mobile" exists and holds only numbers in international format (0049....)'); ?></p>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'any-sms-configure-form',
            'enableAjaxValidation' => true,
        ));
        ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'provider'); ?><br/>
            <?php echo $form->dropdownList($model, 'provider', array('AnySms' => 'Any-SMS', 'Clickatell' => 'Clickatell'), array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'provider'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'username_anysms'); ?><br/>
            <?php echo $form->textField($model, 'username_anysms', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'username_anysms'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'password_anysms'); ?><br/>
            <?php echo $form->passwordField($model, 'password_anysms', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'password_anysms'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'gateway_anysms'); ?><br/>
            <?php echo $form->textField($model, 'gateway_anysms', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'gateway_anysms'); ?>
        </div>

        <?php echo CHtml::submitButton(Yii::t('SmsModule.base', 'Save & Test'), array('class' => 'btn btn-primary')); ?>

    </div>
    <?php $this->endWidget(); ?>

</div>