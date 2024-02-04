
	<?php if(!empty($emailDetails['subject'])){ ?>
	
	
	<div class="row">	
	<div class="col-md-12">
	<h2 style="background-color:#eee;color:#000;font-size:16px;padding:10px 15px;font-weight:600;margin:10px 0px"><i class="fa fa-envelope"></i> From : <?php echo $emailDetails['from']['name']; ?> | <?php echo $emailDetails['from']['email']; ?></h2>
	</div>		
	</div>
	
	<div class="row">	
	<div class="col-md-12">
	<span><b>To : </b> <?php echo implode(',',array_column($emailDetails['to'], 'email')); ?></span><br/>
	<span><b>CC :</b> <?php echo implode(',',array_column($emailDetails['cc'], 'email')); ?></span><br/>
	<span><b>BCC : <?php echo implode(',',array_column($emailDetails['bcc'], 'email')); ?></span><br/>
	<span><b>Reply To : <?php echo implode(',',array_column($emailDetails['reply_to'], 'email')); ?></span><br/>
	<span><b>Message ID : <?php echo $emailDetails['message_id']; ?></span><br/><br/>
	</div>		
	</div>
	
	<div class="row">	
	<div class="col-md-12">
	<h2 style="background-color:#eee;color:#000;font-size:16px;padding:10px 15px;font-weight:600;margin:10px 0px;"><i class="fa fa-envelope"></i> <?php echo $emailDetails['subject']; ?> | #REF<?php echo $emailDetails['uid']; ?></h2>
	</div>		
	</div>
	
	<div class="row">	
	<div class="col-md-12">
	<span><b>From : </b><?php echo $emailDetails['from']['email']; ?></span><br/>
	<span><b>Subject :</b> <?php echo $emailDetails['subject']; ?></span><br/>
	<span><b>Date : <?php echo $emailDetails['date']; ?></span><br/>
	<span><b>UDate : <?php echo date('Y-m-d h:i:s',$emailDetails['udate']); ?></span><br/>
	<span><b>Read : <?php echo $emailDetails['read']; ?></span><br/>
	<span><b>Answered : <?php echo $emailDetails['answered']; ?></span><br/>
	<span><b>Flagged : <?php echo $emailDetails['flagged']; ?></span><br/>
	<span><b>Deleted : <?php echo $emailDetails['deleted']; ?></span><br/>
	<span><b>Draft : <?php echo $emailDetails['draft']; ?></span><br/><br/>
	</div>		
	</div>
	
	<hr/>
	
	<div class="row">	
	<div class="col-md-12">
	<h2 style="background-color:#eee;color:#000;font-size:16px;padding:10px 15px;font-weight:600;margin:10px 0px;"><i class="fa fa-envelope"></i> Message</h2>
	</div>		
	</div>
	
	<div class="row">	
	<div class="col-md-12">
	<?php echo $emailDetails['body']['html']; ?>
	</div>		
	</div>
	
	
	<?php } else { ?>	
	<span class="text-danger">-- No Info Available --</span>
	<?php } ?>

	<hr/>
	<br/><br/><br/>