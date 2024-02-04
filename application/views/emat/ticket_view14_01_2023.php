<style tye="text/css">
.MsoNormalTable{
	width:100%!important;
}
</style>

<div class="wrap">
<section class="app-content">


<section id="job-list" class="job-list">
	<div class="widget-body clearfix">
		<div class="row">
			<div class="col-sm-8">
				<div class="all-bg">
					<div class="body-widget">
						<div class="row">
						<div class="col-md-8">
							<h2 class="small-white-title"><i class="fa fa-ticket"></i> Ticket : <?php echo $ticket_no; ?></h2>
						</div>
						<div class="col-md-4">
						<div class="pull-right text-white">
						<?php if(!empty($messageList[0]['ticket_status'] != 'C')){ ?>
						<?php if((e_tl_access()==1)||(get_user_id()==$token['assigned_to'])){ ?>	
						<button type="button" class="btn btn-warning" id="holdCallModalButton" data-toggle="modal" data-target="#holdCallModal"><i class="fa fa-pause"></i> Hold</button>
						
		                <button type="button" style="display:none" class="btn btn-primary" id="unholdCallModalButton" data-toggle="modal" data-target="#unholdCallModal"><i class="fa fa-play"></i> Unhold</button>
						<i class="fa fa-clock-o"></i> <span style="font-size:14px" id="timeWatchNew"></span> <span style="font-size:14px;display:none" id="timeWatch"></span>
						<?php } } ?>
					    </div>
						</div>						
						</div>
					</div>									
				</div>
				<div class="email-white">
					<div class="tab-content">
					
						<div id="job1" class="tab-pane active">
							<div class="body-widget">
							
							<div class="row">							  
							  <div class="col-md-6">
							  <h2 class="heading-title" style="font-size:14px">Sub : <?php echo $messageList[0]['email_subject']; ?></h2>
							  </div>
							  <div class="col-md-6">
								<!--<select style="width:70%;display:inline-block" class="form-control cannedMaster" name="ticket_canned">
									<option value="">-- Select Message --</option>
									<?php foreach($canned_list as $token){ ?>
									<option value="<?php echo $token['id']; ?>"><?php echo $token['canned_name']; ?></option>
									<?php } ?>
								</select>-->
								<a onclick="javascript:window.close()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left"></i> Go Back</a>
								<?php if(!empty($messageList[0]['category_info']) || !empty($messageList[0]['category_files'])){ ?>
								<a eid="<?php echo $messageList[0]['ticket_category']; ?>" class="btn btn-primary pull-right catInfoCheck" style="margin-right:5px"><i class="fa fa-info-circle"></i> Category Info</a>
								<?php } ?>
							  </div>
							</div>
							
							
							  <div class="top-table">
									<table class="table table-bordered table-striped">
										<tbody>
										  <tr>
											<td style="width:30%">
												<strong>Ticket ID</strong> : <?php echo $ticket_no; ?>
											</td>
											<td style="width:40%">
												<?php $assignedDate = !empty($assigned_info['date_assigned']) ? $assigned_info['date_assigned'] : $messageList[0]['date_added']; ?>
												Aging <span class="red"><?php echo e_display_aging_time(e_aging_ticket($assignedDate)); ?></span>
											</td>
											<td>
												AHT <span class="green"><?php if(!empty($total_time)){ ?><span class="green"><?php echo $total_time; ?></span><?php } else { ?><b>n/a</b><?php } ?></span>
											</td>		
										  </tr>
										</tbody>
									</table>
							  </div>						  
							  
							  <form method="POST" action="<?php echo base_url('emat/ticket_close_reply'); ?>" enctype="multipart/form-data">
							  <div class="row ticketFormReply">
							  
							  <div class="col-md-6">
								 <label>To</label>
								 
								  <input class="form-control" id="mailing_to" name="mailing_to" value="<?php echo $messageList[0]['ticket_email_from']; ?>">
							  </div>
							  
							  <div class="col-md-6">
							  <label>From</label>
							  <?php if($catprex!='LR'){ ?>
							  <input class="form-control" id="mailing_from" name="mailing_from" value="<?php echo $messageList[0]['ticket_email']; ?>"  readonly>
							  <?php } else{ 
									//$mail_list=array('Souvik1.mondal@omindtech.com','test@outlook.com','test1@outlook.com');

									$mail_list=$email_list;
									if(!in_array( $messageList[0]['ticket_email'],$mail_list)){
										$mail_list[]=$messageList[0]['ticket_email'];

									}
								?>
								<select class="form-control" id="mailing_from" name="mailing_from">
								<?php foreach($mail_list as $key=>$rw){ ?>
								<option value="<?php echo $rw;?>" <?php echo ($messageList[0]['ticket_email']==$rw)?'selected="selected"':'';?>><?php echo $rw;?></option>
								<?php } ?>	
								</select>	
								<?php } ?>
							  </div>
							  
							  <div class="col-md-6">
							  <br/>
							  <label>CC (Comma Separated)</label>
							  <input class="form-control" id="mailing_cc" name="mailing_cc" value="">
							  </div>
							  
							  <div class="col-md-12">
							  <br/>
							  <label>Subject</label>
							  <input class="form-control" id="mailing_subject" name="mailing_subject" value="<?php echo $messageList[0]['email_subject']; ?>">
							  </div>
							  
							  
							  <div class="col-md-12">
							  <br/>
							  <div class="editor-full">
								  <input type="hidden" name="ticket_no" value="<?php echo $ticket_no; ?>">
								  <input type="hidden" name="time_interval" id="time_interval">
								  <input type="hidden" name="hold_interval" id="hold_interval" value="00:00:00">
								  <input type="hidden" name="hold_reason_count" id="hold_reason_count" value="0">
								  <input type="hidden" name="hold_reason" id="hold_reason" value="">
								  <?php if(!empty($messageList[0]['ticket_status'] != 'C')){ ?>
								  <textarea class="form-control" id="moreInfoEditor" name="message_body" required></textarea>
								  <br/>
								  <label>Last Message</label>
								  <textarea class="form-control" id="moreInfoEditor2" name="message_body_trail"><?php echo $ticketFinalQuote; ?></textarea>
								  <?php } ?>
							  </div>
							  </div>
							  
							  <?php if(!empty($messageList[0]['ticket_status'] != 'C')){ ?>
							  <?php if((e_tl_access()==1)||(get_user_id()==$token['assigned_to'])||(get_global_access() == '1')){ ?>	
							  <div class="col-md-12">
								  <br/>
								  <?php
								  $_current_email_config = $ticketMailsIndexed[$messageList[0]['ticket_email']];
								  ?>
								  
								  <div class="row align-items-center">
								  <?php if(!empty($_current_email_config['is_show_send'])){ ?>
									<div class="col-sm-2">
										<div class="body-widget">											
											<button type="button" style="border-radius: 2px;" class="replySubmission bg-green update-btn">
												<i class="fa fa-paper-plane"></i> Send
											</button>
										</div>
									</div>
								  <?php } ?>
								  <?php if(!empty($_current_email_config['is_show_autocomplete'])){ ?>									
									<div class="col-sm-4">
										<div class="body-widget">											
											<button type="button" style="border-radius: 2px;" class="replySubmissionMove bg-primary update-btn">
												<i class="fa fa-bullseye"></i> Move to Complete
											</button>
										</div>
									</div>
								  <?php } ?>
								  <?php if(!empty($_current_email_config['is_show_outlook'])){ ?>			
									<div class="col-sm-4">
										<div class="body-widget">
											<button type="button" style="border-radius: 2px;" class="replySubmissionOutlook bg-red update-btn pull-right">
												<i class="fa fa-clock-o"></i> Closed On Outlook
											</button>
										</div>
									</div>
								   <?php } ?>
								   <?php if(!empty($_current_email_config['is_show_forward'])){ ?>			
									<div class="col-sm-4">
										<div class="body-widget">
											<button type="button" style="border-radius: 2px;margin-top:5px" class="forwardSubmission bg-warning update-btn pull-right">
												<i class="fa fa-envelope"></i> Forward Mail
											</button>
										</div>
									</div>
								   <?php } ?>
								  </div>
							  </div>
							  
							  <?php }} ?>
							  
							  <br/><br/>
							  </div>
							  </form>
							  
							  
							  <hr/>							  
							  
							  <div class="email-new1 ticketInfoDetails box">
							  
							    <?php 
								if(!empty($messageList)){
								$sl = 0;
								$allMessages = array_reverse($messageList, true);
								foreach($allMessages as $token){
									$sl++;
								?>	
								
							  
								  <div class="email-repeat">
									   <div class="all-bg bg-scope">
											<div class="body-widget">
												<h2 class="small-white-title"><?php echo $sl; ?>. <?php echo date('d M, Y h:i A', strtotime($token['email_date_added'])); ?>
												<?php if(!empty($token['is_sent'])){ ?>
												<span class="text-success pull-right"><i class="fa fa-check"></i></span>
												<?php } else { ?>
												<span class="text-warning pull-right"><i class="fa fa-warning"></i></span>
												<?php } ?>
												</h2>
											</div>									
										</div>
									  <div class="email-widget">
										<div class="row">
											<div class="col-sm-8">
												<div class="email-main">
													<h2 class="email-title">
														From : <?php echo $token['email_from']; ?>
													</h2><br>
													<h3 class="email-sub-title">
														Subject : <?php echo $token['email_subject']; ?>
													</h3>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="body-widget">
													<div class="attachment-left">
														<p><strong>Attachment</strong></p>
													</div>
													<div class="attachment-right">
														<div class="attachment-widget">
															<?php if(!empty($messageListAttachment[$token['email_piping_id']])){ ?>
																<div class="attachment-link">
																	<?php 
																	$sn=0;	
																	foreach($messageListAttachment[$token['email_piping_id']] as $atoken){ 
																	?>
																	<a title="<?php echo $atoken['at_name']; ?>" style="cursor:pointer" onclick="window.open('<?php echo base_url()."emat/attachment_view?filedir=".base64_encode($atoken['at_content_dir']); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no, status=yes');"><b><i class="fa fa-download"></i> <?php echo e_short_text($atoken['at_name'], 25); ?></b></a><br/>
																	<?php } ?>
																</div>
															<?php } else { ?>
																<div class="attachment-link">
																	<a href="#">N/A</a>
																</div>
															<?php } ?>
															</div>					
														</div>
													</div>
												</div>										
											<div class="col-sm-12">
												<div class="email-content">
													<p>
														<?php 
									
														$body_html = $token['e_body_html'];
														$body_plain = $token['e_body_plain'];
														echo str_replace('<p></p>', '', e_show_mail_body($body_html, $body_plain));
														?>
														<br/><br/>
													</p>
												</div>
											</div>
										</div>
									  </div>
								 </div>
								  
								  <?php } ?>
								  <?php } ?>
								  
								   </div>
								  
							  </div>
							</div>
						</div>
						
						
						
					</div>
				</div>
			
			
			
			
			
			
			
			
			<div class="col-sm-4">
				<div class="all-bg">
					<div class="body-widget">
						<h2 class="small-white-title"><i class="fa fa-users"></i> Status : <?php echo e_ticket_status_show($messageList[0]['ticket_status'], 2); ?></h2>
					</div>									
				</div>
				<div class="right-side1">
					<div class="reply-widget">
						<!--<div class="menu-link1">
							<a href="#">Complete</a>
							<a href="<?php echo base_url('emat/ticket_pass_manual/'.$ticket_no); ?>" onclick="return confirm('Are you sure you want to pass this ticket to queue ?');">Pass</a>							
						</div>-->
						<form method="POST" action="<?php echo base_url('emat/ticket_assign_manual'); ?>">
						<div class="select-widget">
							<div class="form-group">
							  <label>Mail Box</label>
							   <input type="hidden" name="ticket_email_old" value="<?php echo $messageList[0]['ticket_email']; ?>">
							   <select class="form-control" name="ticket_email" required>
									<option value="">-- Select --</option>
								<?php 
								foreach($ticketMails as $token){ 
									if($messageList[0]['ticket_email'] == $token['email_id']){
								?>
										<option value="<?php echo $token['email_id']; ?>" <?php echo $messageList[0]['ticket_email'] == $token['email_id'] ? "selected" : ""; ?>><?php echo $token['email_name']; ?></option>
								<?php } } ?>
								</select>
							</div>
							<div class="form-group">
							  <label>Category</label>
							   <input type="hidden" name="ticket_no" value="<?php echo $ticket_no; ?>">
							   <input type="hidden" name="ticket_category_old" value="<?php echo $messageList[0]['ticket_category']; ?>">
							   <select class="form-control" name="ticket_category" required>
									<option value="">-- Select --</option>
								<?php foreach($catList as $token){ ?>
									<option value="<?php echo $token['category_code']; ?>" <?php echo $messageList[0]['ticket_category'] == $token['category_code'] ? "selected" : ""; ?>><?php echo $token['category_name']; ?></option>
								<?php } ?>
								</select>
							</div>
							<div class="form-group">
							  <label>Assigned User</label>
							   <input type="hidden" name="ticket_user_old" value="<?php echo $assigned_user; ?>">
							   <select class="form-control" name="ticket_user" required>
									<option value="">-- Select --</option>
								<?php foreach($agentList as $token){ ?>
									<option value="<?php echo $token['id']; ?>" <?php echo $assigned_user == $token['id'] ? "selected" : ""; ?>><?php echo $token['fname']." " .$token['lname'] ." (" .$token['fusion_id'].")"; ?></option>
								<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<button type="submit" class="update-btn">Update</button>
							</div>
						</div>
						</form>
					</div>
				</div>
				
				<br/>
				
				<div class="all-bg">
					<div class="body-widget">
						<h2 class="small-white-title"><i class="fa fa-calendar"></i> Notes</h2>
					</div>									
				</div>
				<div class="right-side1 notesBlock">
					<div class="reply-widget">
					<form method="POST" action="<?php echo base_url('emat/ticket_add_notes'); ?>">
						<div class="select-widget">
							<div class="form-group">
							  <label>Enter Notes</label>
							   <input type="hidden" name="ticket_no" value="<?php echo $ticket_no; ?>">
							   <input type="hidden" name="time_interval_notes" id="time_interval_notes">
							   <input type="hidden" name="hold_interval_notes" id="hold_interval_notes" value="00:00:00">
							   <input type="hidden" name="hold_reason_count_notes" id="hold_reason_count_notes" value="0">
							   <input type="hidden" name="hold_reason_notes" id="hold_reason_notes" value="">
							   <textarea class="form-control" name="ticket_notes" required></textarea>
							</div>
							<div class="form-group">
								<button type="button" class="update-btn notesSubmission">Submit</button>
							</div>
						</div>
					</form>
					<hr style="margin-top:15px;margin-bottom:5px" />
					<div class="notesSectionShow">
					<?php foreach($resultLog as $token){ if($token['log_type'] == 'notes'){ ?>
					<?php echo $token['date_added']; ?> - <?php echo e_short_text($token['fullname'],20); ?><br/><?php echo $token['notes']; ?><hr style="margin-top:5px;margin-bottom:5px" />
					<?php } } ?>
					</div>
					</div>
				</div>
				
				<br/>
				
				<div class="all-bg">
					<div class="body-widget">
						<h2 class="small-white-title"><i class="fa fa-calendar"></i> Logs</h2>
					</div>									
				</div>
				<div class="right-side1">
					<div class="reply-widget">
					<?php echo $messageList[0]['date_added']; ?><br/>Ticket Created<hr style="margin-top:5px;margin-bottom:5px" />
					<?php foreach($resultLog as $token){ ?>
					<?php echo $token['date_added']; ?><br/>Update <?php echo ucwords($token['log_type']); ?> - <?php echo $token['fullname']; ?><hr style="margin-top:5px;margin-bottom:5px" />
					<?php } ?>
					
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
</section>


</section>
</div>



<div class="modal fade" id="modalForwardEmail" tabindex="-1" role="dialog" aria-labelledby="modalForwardEmail" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">				
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Forward Mail</h4>
		</div>		
		<div class="modal-body">	
			<div class="row">				
				<div class="col-md-12">
					<div class="form-group">
					  <label>Email ID</label>
					  <?php if($catprex!='LR'){ ?>
					   <input type="text" class="form-control" name="forward_email_id" required>
					   <?php }else{ 

					   	$mail_list=$email_list;
							if(!in_array( $messageList[0]['ticket_email'],$mail_list)){
								$mail_list[]=$messageList[0]['ticket_email'];

							}
						?>
						<select class="form-control" id="forward_email_id" name="forward_email_id">
						<?php foreach($mail_list as $key=>$rw){ ?>
						<option value="<?php echo $rw;?>" <?php echo ($messageList[0]['ticket_email']==$rw)?'selected="selected"':'';?>><?php echo $rw;?></option>
						<?php } ?>	
						</select>	
					   <?php } ?>
					</div>
				</div>
			</div>					
		</div>		
	   <div class="modal-footer">
        <button type="button" class="btn btn-warning mailForwardSubmission">Submit</button>	   
		<button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default">Close</button>		
	  </div>		
	</div>
  </div>
</div>


<div class="modal fade" id="holdCallModal" tabindex="-1" role="dialog" aria-labelledby="holdCallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="holdCallModalLabel"><i class="fa fa-pause"></i> Hold Call</h4>
      </div>
      <div class="modal-body">
		<p class="text-warning"><b>Do you want to hold this call ?</b></p>		
		<div class="form-group">
		  <label for="case">Reason for Hold **</label>
		  <textarea class="form-control" name="modal_hold_reason" id="modal_hold_reason" required></textarea>
		</div>
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="hold" onclick="callActionButton(this)" class="btn btn-warning">Yes, Hold</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="unholdCallModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="unholdCallModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h4 class="modal-title" id="unholdCallModalLabel"><i class="fa fa-pause"></i> Hold Call</h4>
      </div>
      <div class="modal-body">
		<p class="text-danger"><b>Your Call is Put on HOLD <i class="fa fa-clock-o"></i> <input style="border: 0px;color:green" type="text" name="timer_hold" id="timer_hold" value=""> <input type="hidden" name="timer_hold_status" id="timer_hold_status" value="H"></b></p>
		<p class="text-warning"><b>Do you want to unhold this call ?</b></p>
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="unhold" onclick="callActionButton(this)" class="btn btn-danger">UNHOLD NOW</button>
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>-->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalEmailDetailsCat" tabindex="-1" role="dialog" aria-labelledby="modalEmailDetailsCat" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">				
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">EMAT Info</h4>
		</div>		
		<div class="modal-body">														
		</div>		
	  <div class="modal-footer">			
		<button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default">Close</button>		
	  </div>		
	</div>
</div>
</div>