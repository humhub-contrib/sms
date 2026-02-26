<?php

use humhub\helpers\Html;
use humhub\widgets\bootstrap\Button;
use humhub\widgets\form\ActiveForm;

/**
 * @var $model \humhub\modules\sms\forms\SmsSendForm
 * @var $user \humhub\modules\user\models\User
 */

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('SmsModule.base', 'Send a SMS to ') . Html::encode($user->displayName); ?>
    </div>

    <div class="panel-body">
        <?php $form = ActiveForm::begin() ?>

        <div class="mb-3">
            <?= $form->field($model, 'message')->textarea(['id' => 'sms']); ?>

            <p class="form-text">
                <?= Yii::t('SmsModule.base', 'Characters left:'); ?>
                <span id="charactersLeft">0</span>
            </p>
        </div>

        <?= Button::save(Yii::t('SmsModule.base', 'Send'))->submit() ?>

        <?php ActiveForm::end() ?>

        <script <?= Html::nonce() ?>>
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
