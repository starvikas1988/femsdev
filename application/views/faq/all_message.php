<style>
	.card-header {

    border: 1px solid #d5d5d5;
    border-radius: 2px;

}
.card {

    margin-bottom: 5px;

}
.card-body {

    border: 1px solid #cf50504d;
    padding: 5px 10px;
    border-radius: 0px 0px 2px 2px;

}
</style>
<div class="widget">
	<header class="widget-header">
		<h4 class="widget-title">My Messages</h4>
	</header><!-- .widget-header -->
	<hr class="widget-separator">
	<div class="widget-body">
		<div id="accordion">
		<?php
			foreach($messages as $key=>$value)
			{
		?>
			<div class="card" data-message_id="<?php echo $value->message_id; ?>">
			<div class="card-header" id="<?php echo $value->message_id; ?>">
			  <h5 class="mb-0">
				<button class="btn btn-link" data-toggle="collapse" data-target="#<?php echo 'collapse'.$value->message_id;  ?>" aria-expanded="true" aria-controls="<?php echo 'collapse'.$value->message_id;  ?>">
					<?php echo $value->subject; ?>
				</button>
			  </h5>
			</div>

			<div id="<?php echo 'collapse'.$value->message_id;  ?>" class="collapse" aria-labelledby="<?php echo $value->message_id; ?>" data-parent="#accordion">
			  <div class="card-body">
				<?php echo $value->message_body; ?>
			  </div>
			</div>
		  </div>
		<?php
			}
		?>
		</div>
	</div>
</div>
