<?php

use yii\helpers\Html;
use humhub\compat\CActiveForm;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php
        echo Yii::t('SmsModule.base', 'Send a SMS to ');
        echo Html::encode($user->displayName);
        ?>
    </div>

    <div class="panel-body">
        <?php $form = CActiveForm::begin(); ?>

        <?php //echo $form->errorSummary($model);    ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'message'); ?><br/>
            <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'id'=>'sms')); ?>
            <?php echo $form->error($model, 'message'); ?>
            <p class="help-block"><?php echo Yii::t('SmsModule.base', 'Characters left:'); ?><span id="charactersLeft">0</span></p>
        </div>


        <?php echo Html::submitButton(Yii::t('SmsModule.base', 'Send'), array('class' => 'btn btn-primary')); ?>

        <?php CActiveForm::end(); ?>

        <script>
            // update limiter/ crop limiter text -> Stolen at: http://www.scriptiny.com/2012/09/jquery-input-textarea-limiter/
            (function ($) {
                $.fn.extend({
                    limiter: function (limit, elem) {
                        $(this).on("keyup focus", function () {
                            setCount(this, elem);
                        });
                        function setCount(src, elem) {
                            var chars = src.value.length;
                            if (chars > limit) {
                                src.value = src.value.substr(0, limit);
                                chars = limit;
                            }
                            elem.html(limit - chars);
                        }
                        setCount($(this)[0], elem);
                    }
                });
            })(jQuery);
            var elem = $("#charactersLeft");
            $("#sms").limiter(160, elem);
        </script>
    </div>
</div>