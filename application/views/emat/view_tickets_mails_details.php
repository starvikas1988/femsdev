	<?php 
	if(!empty($messageList)){
	foreach($messageList as $token){
	?>	
	
	<div class="row">	
	<div class="col-md-12">
	<h2 style="background-color:#eee;color:#000;font-size:16px;padding:10px 15px;font-weight:600;margin:10px 0px"><i class="fa fa-envelope"></i> From : <?php echo $token['email_from']; ?> | Sub : <?php echo $token['email_subject']; ?></h2>
	</div>		
	</div>
	
	<div class="row">	
	<div class="col-md-12">
	<?php echo $token['e_body_html']; ?>
	</div>		
	</div>
	
	<?php if(!empty($messageListAttachment[$token['email_piping_id']])){ ?>
	<hr/>
	<div class="row">
	<div class="col-md-12">
	<?php 
	$sn=0;	
	foreach($messageListAttachment[$token['email_piping_id']] as $atoken){ 
	?>
		<span class="text-primary">Attachment <?php echo ++$sn; ?>. 
		<a class="btn btn-primary btn-xs" style="margin-bottom:2px" onclick="window.open('<?php echo base_url()."emat/attachment_view?filedir=".base64_encode($atoken['at_content_dir']); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no, status=yes');"><?php echo $atoken['at_name']; ?></a>
		</span><br/>
	<?php } ?>
	</div>		
	</div>	
	<?php } ?>
	
	
	<hr/>
	
	<?php } } else { ?>	
	<span class="text-danger">-- No Info Available --</span>
	<?php } ?>

	<hr/>
	<br/><br/><br/>