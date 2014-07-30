<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo Yii::t('SmsModule.base', 'Send a SMS'); ?>
    </div>
    <div class="panel-body">
<pre style="background-color:<?php echo $response['error'] == false ? '#CEF6CE' : '#F6CECE' ?>">
From:           <?php echo $response['sender']; ?>

To:             <?php echo $response['receiver']; ?>

Status Message: <?php echo $response['statusMsg'] ?>

</pre>
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