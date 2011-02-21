<?php
$messages = Notification::get($username, $page);
?>

<div id="messages">
<?php foreach ($messages as $key => $message): ?>
	<?php if ($message->value->persistent && $session['uid'] == $user_id): ?>
		<div class="message <?php echo $message->value->format ?>" id="<?php echo $message->value->_id ?>">
			<div class="close">
				<a href="#" class="close">
					<img src="/images/close.png"/>
				</a>
			</div>
			<div class="wrap">
				<?php if ($message->value->file): ?>
					<?php include $message->value->file; ?>
				<?php else: ?>	
					<?php if ($message->value->title): ?>
						<h6 class="title">
							<?php echo $message->value->title; ?>
						</h6>				
					<?php endif ?>
					<div class="body">
						<?php echo $message->value->body ?>
					</div>
				<?php endif ?>
			</div>
		</div>	
	<?php endif ?>
<?php endforeach ?>
</div>