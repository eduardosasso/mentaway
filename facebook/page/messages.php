<?php
$messages = Notification::get($username, $page);
?>

<div id="messages">
<?php foreach ($messages as $key => $message): ?>
	<div class="message <?php echo $message->value->format ?>">
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
<?php endforeach ?>
</div>