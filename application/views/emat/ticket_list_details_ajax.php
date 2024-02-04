		<div class="card-body">
		  <div class="email-new2 box">		  
		    <?php 
			if(!empty($messageList)){
			$sl=0;
			foreach($messageList as $token){
				$sl++;
				if($sl > 1){ continue; }
			?>
			  <div class="email-repeat">
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
									<br/><br/><br/>
								</p>
							</div>
						</div>
					</div>
				  </div>
			  </div>
			  <?php } ?>
			  <?php } ?>
			  
			</div>
			
			
			<?php //if($messageList[0]['ticket_no'] == "TP00000008"){ echo '"'; } ?>
			<div class="common-top div_ticketAssignUpdate">
				<div class="select-main">
				<form method="POST" action="<?php echo base_url('emat/ticket_assign_manual'); ?>">
					<div class="row">
						<div class="col-sm-3">
							<div class="select-widget">
								<div class="body-widget">
									<input type="hidden" name="ticket_email_old" value="<?php echo $messageList[0]['ticket_email']; ?>">
									<select class="form-control" name="ticket_email" <?php if($messageList[0]['ticket_status'] == 'C'){ echo "disabled"; } ?> required>
										<option value="">-- Select --</option>
									<?php 
									foreach($ticketMails as $token){ 
										if($messageList[0]['ticket_email'] == $token['email_id']){
									?>
										<option value="<?php echo $token['email_id']; ?>" <?php echo $messageList[0]['ticket_email'] == $token['email_id'] ? "selected" : ""; ?>><?php echo $token['email_name']; ?></option>
									<?php } } ?>
									</select>
								</div>
							</div>
						</div>						
						<div class="col-sm-3">
							<div class="select-widget">
								<div class="body-widget">
									<input type="hidden" name="ticket_category_old" value="<?php echo $messageList[0]['ticket_category']; ?>">
									<select class="form-control" name="ticket_category" <?php if($messageList[0]['ticket_status'] == 'C'){ echo "disabled"; } ?> required>
										<option value="">-- Select --</option>
									<?php foreach($catList as $token){ ?>
										<option value="<?php echo $token['category_code']; ?>" <?php echo $messageList[0]['ticket_category'] == $token['category_code'] ? "selected" : ""; ?>><?php echo $token['category_name']; ?></option>
									<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="select-widget">
								<div class="body-widget">
									<input type="hidden" name="ticket_no" value="<?php echo $ticket_no; ?>">
									<input type="hidden" name="ticket_user_old" value="<?php echo $assigned_user; ?>">
									<select class="form-control" name="ticket_user" <?php if($messageList[0]['ticket_status'] == 'C'){ echo "disabled"; } ?> required>
										<option value="">-- Select --</option>
									<?php foreach($agentList as $token){ ?>
										<option value="<?php echo $token['id']; ?>" <?php echo $assigned_user == $token['id'] ? "selected" : ""; ?>><?php echo $token['fname']." " .$token['lname'] ." (" .$token['fusion_id'].")"; ?></option>
									<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="menu-link">
							<?php if(get_login_type() != "client"){ ?>
							<?php if($messageList[0]['ticket_status'] != 'C'){ ?>
								<button type="submit" name="assignSubmit">Assign</button>
							<?php } ?>
								<a href="<?php echo base_url('emat/ticket_view/'.$ticket_no); ?>" target="_blank" class="bg-green pull-right" style="margin-left:4px"><i class="fa fa-external-link"></i> Work</a>
							<?php } ?>														
							</div>
						</div>
						
						<div class="col-sm-12">
						<div class="select-widget">
						<div class="body-widget">
						<div class="row" style="padding: 15px 0px;">
							<div class="col-sm-3">
								<a class="btn btn-success arrivalDIVInfoTrigger" style="margin-left:4px"><i class="fa fa-calendar"></i> Set Arrival Date</a>
							</div>
							<div class="col-sm-9">
							<div class="row arrivalDIVInfo" style="display:none">
							<div class="col-sm-3">
								<div class="from-group">
								    <input type="hidden" name="arrival_ticket_no" value="<?php echo $ticket_no; ?>">
									<input type="text" class="form-control" name="arrival_date" id="arrival_date" value="<?php echo !empty($messageList[0]['ticket_arrival_date']) ? date('m/d/Y', strtotime($messageList[0]['ticket_arrival_date'])) : ""; ?>">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="from-group">
									<a class="btn btn-primary arrivalDIVInfoUpdater" style="margin-left:4px">Update</a>
								</div>
							</div>
							</div>
							</div>
						</div>					
						</div>
						</div>
						</div>
						
						
						<div class="col-sm-12">
						<div class="select-widget">
						<div class="body-widget">							
							<?php if(!empty($totalGuestTickets) && count($totalGuestTickets) > 0){ ?>
							<br/>
							<a href="<?php echo base_url('emat/ticket_auto_close_duplicate/'.$ticket_no); ?>" onclick="return confirm('Are you sure you want to mark it as duplicate ?');" class="btn btn-warning" style="margin-left:4px"><i class="fa fa-arrow-circle-left"></i> Mark as Duplicate</a>	
							<br/><br/>
							<a style="border-radius: 0px;padding: 0px;background: none;color: #000;" href="<?php echo base_url('emat/ticket_guest/') .'/'.bin2hex($messageList[0]['ticket_email_from']); ?>" target="_blank">
							<span style="font-weight:600;margin-top:10px;"><u>Probable Duplicate : <b><?php echo count($totalGuestTickets); ?> Tickets Found</b></u></span></a>
							<?php } ?>
							<br/>
							
							
							
						<div class="card ticketListDivDuplicate" style="padding: 5px 25px;">				
									
							<?php 
							foreach($totalGuestTickets as $token){ 
								//$assignedDate = !empty($ticketAssigned[$token['ticket_no']]) ? $ticketAssigned[$token['ticket_no']]['date_assigned'] : "";
								$slaBreach = false;  $sla_class="text-success";
								if(!empty($assignedDate)){
									$ticketCategory = $token['ticket_category'];
									$slaTime = $ticketCategoryIndexed[$ticketCategory]['category_sla'];
									if(empty($slaTime)){ 
										$slaTime = $ticketMailsIndexed[$email_id]['ticket_sla'];
									}
									//$slaTimeMax = strtotime('+' .$slaTime .' hour', strtotime($assignedDate));
									//if(strtotime(CurrMySqlDate()) >= $slaTimeMax && $token['is_open'] == 1)
									//{
										//$slaBreach = true;
										//$sla_class="red";
									//}
								}
							?>
							
							  <div class="card-header ticketInfoDivDuplicate h<?php echo $token['ticket_no']; ?>" dticket="<?php echo $ticket_no; ?>" ticket="<?php echo $token['ticket_no']; ?>" style="cursor:pointer">
								<a class="card-link">
								  <div class="table-widget">
									<table class="table table-bordered table-striped">
										<tbody>
										  <tr>
											<td title="<?php echo $token['ticket_subject']; ?>" style="width:12%">
											<b><?php echo $token['ticket_no']; ?></b></td>
											<td style="width:70%">
											<?php echo e_short_text($token['ticket_subject'], 30); ?>
											</td>
											<td>
											<?php echo e_ticket_status_show($token['ticket_status'], 2); ?>
											</td>
										  </tr>
										</tbody>
									  </table>
									</div>
								</a>
							  </div>
							  
							  
							  <div id="dt_<?php echo $ticket_no; ?>_<?php echo $token['ticket_no']; ?>" class="ticketInfoDetailsDuplicate">
							  </div> 
							  
							
							<?php } ?>			
						</div>	
							
							
							
						</div>
						</div>
						</div>

					</div>
				</form>
				</div>
			</div>
			
			
		</div>
									 