<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo Yii::t('SmsModule.base', 'Send a SMS'); ?>
    </div>
    <div class="panel-body">

		<?php if ($response['error'] == false) { ?>		
        <p><?php echo $response['statusMsg']; ?></p>
		<?php } else { ?>
<pre>
Sending SMS to <?php echo $user->profile->mobile; ?>

From: <?php echo str_replace(" ", "_", Yii::app()->user->displayName); ?>

Error message: <?php echo $response['statusMsg']; ?>
</pre>
        <?php } ?>
    </div>
</div>
<?php if($debug && array_key_exists('furtherInfo', $response)) {
	$infoString = 'Further Information: { \n';
	foreach ($response['furtherInfo'] as $key => $line) {
		$infoString .= '\t'.$key.': '.$line.'\n';
	}
	$infoString .= '}';
?>
<script>
   	<?php echo 'console.log("'.$infoString.'");'; ?>
</script>
<?php } ?>