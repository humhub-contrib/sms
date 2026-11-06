<?php

use humhub\helpers\Html;
use humhub\widgets\bootstrap\Alert;
use humhub\widgets\bootstrap\Button;
use yii\helpers\Json;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('SmsModule.base', 'Send a SMS'); ?>
    </div>
    <div class="panel-body">
        <?php Alert::beginInstance($response['error'] == false ? 'success' : 'danger')->closeButton(false) ?>
            <strong>From:</strong>           <?= Html::encode($response['sender']) ?><br>
            <strong>To:</strong>             <?= Html::encode($response['receiver']) ?><br>
            <strong>Status Message:</strong> <?= Html::encode($response['statusMsg']) ?>
        <?php Alert::end() ?>

        <?= Button::primary(Yii::t('SmsModule.base', 'Back'))
                ->link($user->createUrl('/sms/send')); ?>
    </div>
</div>
<?php
if ($debug && array_key_exists('furtherInfo', $response)) {
    ?>
    <script <?= Html::nonce() ?>>
        console.log('Further Information:', <?= Json::htmlEncode($response['furtherInfo']) ?>);
    </script>
<?php } ?>
