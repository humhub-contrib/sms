<?php

use humhub\helpers\Html;
use humhub\widgets\bootstrap\Alert;
use humhub\widgets\bootstrap\Button;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('SmsModule.base', 'Send a SMS'); ?>
    </div>
    <div class="panel-body">
        <?php Alert::beginInstance($response['error'] == false ? 'success' : 'danger')->closeButton(false) ?>
            <strong>From:</strong>           <?= $response['sender'] ?><br>
            <strong>To:</strong>             <?= $response['receiver'] ?><br>
            <strong>Status Message:</strong> <?= $response['statusMsg'] ?>
        <?php Alert::end() ?>

        <?= Button::primary(Yii::t('SmsModule.base', 'Back'))
                ->link($user->createUrl('/sms/send')); ?>
    </div>
</div>
<?php
if ($debug && array_key_exists('furtherInfo', $response)) {
    $infoString = 'Further Information: { \n';
    foreach ($response['furtherInfo'] as $key => $line) {
        $infoString .= '\t' . $key . ': ' . $line . '\n';
    }
    $infoString .= '}';
    ?>
    <script <?= Html::nonce() ?>>
        console.log("<?= $infoString ?>");
    </script>
<?php } ?>
