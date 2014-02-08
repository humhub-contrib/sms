<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo Yii::t('SmsModule.base', 'Send a SMS'); ?>
    </div>


    <div class="panel-body">


        <?php if ($status == 'OK') : ?>

        <p><?php echo Yii::t('SmsModule.base', 'SMS successfully sent!'); ?></p>
        
        <?php else: ?>
<pre>
Sending SMS to <?php echo $user->profile->mobile; ?>

From: <?php echo str_replace(" ", "_", Yii::app()->user->displayName); ?>

Network Status: <?php echo $status; ?>


(0 = Accepted, -1 Invalid API ID, -2 Invalid IP)
</pre>

        <?php endif; ?>

    </div>

</div>