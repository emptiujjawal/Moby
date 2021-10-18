<?php
if ($opr->error_list) 
{
	foreach ($opr->error_list as $error) {
	?>
		<div class="row well red">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Error!</strong> <?php echo $error;?>
		</div>
	<?php
	}
}
if ($opr->message_list) 
	{
	foreach ($opr->message_list as $message) {
		?>
		<div class="row well green">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>SUCCESS!</strong> <?php echo $message;?>
		</div>
		<?php
	}
}
?>