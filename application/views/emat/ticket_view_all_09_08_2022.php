<style>
/*---------- MY CUSTOM CSS -----------*/
	.rounded {
	  -webkit-border-radius: 3px !important;
	  -moz-border-radius: 3px !important;
	  border-radius: 3px !important;
	}

	.mini-stat {
	  padding: 5px;
	  margin-bottom: 20px;
	}

	.mini-stat-icon {
	  width: 30px;
	  height: 30px;
	  display: inline-block;
	  line-height: 30px;
	  text-align: center;
	  font-size: 15px;
	  background: none repeat scroll 0% 0% #EEE;
	  border-radius: 100%;
	  float: left;
	  margin-right: 10px;
	  color: #FFF;
	}

	.mini-stat-info {
	  font-size: 12px;
	  padding-top: 2px;
	}

	span, p {
	  /*color: white;*/
	}

	.mini-stat-info span {
	  display: block;
	  font-size: 20px;
	  font-weight: 600;
	  margin-bottom: 5px;
	  margin-top: 7px;
	}

	/* ================ colors =====================*/
	.bg-facebook {
	  background-color: #3b5998 !important;
	  border: 1px solid #3b5998;
	  color: white;
	}

	.fg-facebook {
	  color: #3b5998 !important;
	}

	.bg-twitter {
	  background-color: #00a0d1 !important;
	  border: 1px solid #00a0d1;
	  color: white;
	}

	.fg-twitter {
	  color: #00a0d1 !important;
	}

	.bg-googleplus {
	  background-color: #db4a39 !important;
	  border: 1px solid #db4a39;
	  color: white;
	}

	.fg-googleplus {
	  color: #db4a39 !important;
	}

	.bg-bitbucket {
	  background-color: #205081 !important;
	  border: 1px solid #205081;
	  color: white;
	}

	.fg-bitbucket {
	  color: #205081 !important;
	}
	
		
	.highcharts-credits {
		display: none !important;
	}
	
	.MsoNormalTable{
		width:100%!important;
	}
	
</style>

<div class="wrap">
<section class="app-content">


<section id="job-list" class="job-list">
	<div class="widget-body clearfix">
	
	<div class="row">
	<?php $this->load->view('emat/nav_mail_box'); ?>
	</div>
	
	<br/><br/>
	
	
		<div class="row">
		
			<!--<div class="col-sm-2">
				<div class="all-bg">
					<div class="body-widget">
						<h2 class="small-white-title">Ticket List</h2>
					</div>									
				</div>						
				<div class="left-side1 box" style="height:400px">
					<div class="tabs-widget">
						<div class="body-widget">
							<ul class="nav nav-pills">
							<?php 
							$foundCat = empty($currentCat) ? "all" : $currentCat;
							foreach($messageListAll as $token){ 
								$selected = "";
								if($token['ticket_no'] == $ticket_no){ $selected = "active"; }
							?>
								<li class="nav-item">
								  <a class="nav-link nav-link-ticket <?php echo $selected; ?>" href="<?php echo base_url() .'emat/ticket_assigned/' .bin2hex($email_id)."/".$foundCat ."/" .$token['ticket_no']; ?>">
									<?php echo $token['ticket_no']; ?>
								  </a>
								</li>
							<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>-->
			
			
			<div class="col-sm-2">							
				<div class="left-side2">
					<div class="all-bg">
						<div class="body-widget dropdownCapture">
							<h2 class="small-white-title">Ticket List</h2>
							<?php if(e_show_arrival($email_id)){ ?>
							<select class="form-control pull-right" style="width:60px;height: 22px;margin-bottom: 1px;margin-top: -20px;margin-right:5px;font-size:9px;padding: 0px 0px 0px 2px;" name="sort_list_dropdown">
								<option value="default" <?php echo e_sort_email_type($email_id) == 'default' ? 'selected' : ''; ?> >Aging</option>
								<option value="arrival" <?php echo e_sort_email_type($email_id) == 'arrival' ? 'selected' : ''; ?>>Arrival</option>
							</select>
							<?php } ?>
						</div>									
					</div>
					<div class="all-new box">
					
					<?php 
					$foundCat = empty($currentCat) ? "all" : $currentCat;
					foreach($messageListAll as $token){ 
						$selected = "";
						if($token['ticket_no'] == $ticket_no){ $selected = "active"; }
						$assignedDate = !empty($ticketAssigned[$token['ticket_no']]) ? $ticketAssigned[$token['ticket_no']]['date_assigned'] : "";
						$slaBreach = false;  $sla_class="text-success";
						if(!empty($assignedDate)){
							$ticketCategoryCheck = $token['ticket_category'];
							$slaTime = $ticketCategoryIndexed[$ticketCategoryCheck]['category_sla'];
							if(empty($slaTime)){ 
								$slaTime = $ticketMailsIndexed[$email_id]['ticket_sla'];
							}
							$slaTimeMax = strtotime('+' .$slaTime .' hour', strtotime($assignedDate));
							if(strtotime(CurrMySqlDate()) >= $slaTimeMax && $token['is_open'] == 1)
							{
								$slaBreach = true;
								$sla_class="text-danger";
							}
						}
						
						$_current_url = $_SERVER['REQUEST_URI'];
						//print_r(parse_url($_current_url));
						parse_str(parse_url($_current_url)['query'], $gotPrameters);
						$extraAddUrlParamFound = "";
						if(!empty($gotPrameters)){
							foreach($gotPrameters as $keyPram => $tokenPram){ $extraAddUrlParam[]= $keyPram ."=" .$tokenPram; }
							$extraAddUrlParamFound = "?".implode('&',$extraAddUrlParam); 
						}
						
						$starterTime = $token['date_added'];
						if(!empty($token['assigned_date'])){ $starterTime = $token['assigned_date']; }
						$agingTime = e_display_aging_time(e_aging_ticket($token['date_added']));
						if($token['is_open'] == 0){ $agingTime = e_display_aging_time(e_aging_ticket_closure($starterTime, 12, $token['closed_date'])); }
					?>
						<div class="all-repeat">
						<a class="nav-link nav-link-ticket <?php echo $selected; ?>" href="<?php echo base_url() .'emat/ticket_assigned/' .bin2hex($email_id)."/".$foundCat ."/" .$token['ticket_no'] .$extraAddUrlParamFound; ?>">
							<div class="all-main">									
								<div class="all-widget" style="width:37%;font-size:11px">
									<p style="font-size:10px;" title="<?php echo $token['ticket_subject']; ?>">
									<b><?php echo $token['ticket_no']; ?></b></p>
								</div>
								<div class="all-widget <?php echo $sla_class; ?>"  title="<?php echo $token['ticket_subject']; ?>" style="width:60%;font-size:10px">
								<?php if(e_show_arrival($email_id) && e_sort_email_type($email_id) == "arrival"){ ?>
									<b><?php echo !empty($token['ticket_arrival_date']) ? $token['ticket_arrival_date'] : "-"; ?></b>
								<?php } else { ?>
									<b><?php echo $agingTime; ?></b>
								<?php } ?>
								</div>
							</div>
						</a>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
			
		
			<?php if(!empty($ticket_no)){ ?>
		
			<div class="col-sm-7">
				<div class="all-bg">
					<div class="body-widget">
					<div class="row">
					<div class="col-md-8">
						<h2 class="small-white-title"><i class="fa fa-ticket"></i> Reply Ticket : <?php echo $ticket_no; ?></h2>
					</div>
					<div class="col-md-4">
					<div class="pull-right text-white">
					<?php if(!empty($messageList[0]['ticket_status'] != 'C')){ ?>
						<button type="button" class="btn btn-warning" id="holdCallModalButton" data-toggle="modal" data-target="#holdCallModal"><i class="fa fa-pause"></i> Hold</button>
					
		                <button type="button" style="display:none" class="btn btn-primary" id="unholdCallModalButton" data-toggle="modal" data-target="#unholdCallModal"><i class="fa fa-play"></i> Unhold</button>
						<i class="fa fa-clock-o"></i> <span style="font-size:14px" id="timeWatchNew"></span> <span style="font-size:14px;display:none" id="timeWatch"></span>
					<?php } ?>
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
							   <?php if(e_show_arrival($email_id)){ ?>
							  <h2 class="heading-title" style="font-size:14px;margin-bottom:10px">Arrival Dt : <?php echo !empty($messageList[0]['ticket_arrival_date']) ? $messageList[0]['ticket_arrival_date'] : "-"; ?></h2>
							  <?php } ?>
							  <h2 class="heading-title" style="font-size:14px">Sub : <?php echo $messageList[0]['email_subject']; ?></h2>							 
							  </div>
							  <div class="col-md-6">
							  
								<!--<select style="width:70%;display:inline-block" class="form-control cannedMaster" name="ticket_canned">
									<option value="">-- Select Message --</option>
									<?php foreach($canned_list as $token){ ?>
									<option value="<?php echo $token['id']; ?>"><?php echo $token['canned_name']; ?></option>
									<?php } ?>
								</select>-->
								
								<?php if(!empty($agent_details['is_pass'])){ ?>
							    <a href="<?php echo base_url('emat/ticket_pass_manual/'.$ticket_no); ?>" onclick="return confirm('Are you sure you want to pass this ticket to queue ?');" class="btn btn-danger pull-right"><i class="fa fa-repeat"></i> Pass</a>
								<?php } ?>
								
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
											   <?php $assignedDate = !empty($ticketAssigned[$ticket_no]) ? $ticketAssigned[$ticket_no]['date_assigned'] : $messageList[0]['date_added']; ?>
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
							  <input class="form-control" id="mailing_from" name="mailing_from" value="<?php echo $messageList[0]['ticket_email']; ?>"  readonly>
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
							  <div class="col-md-12">
								  <br/>
								  <div class="row align-items-center">
								  <?php
								  $_current_email_config = $ticketMailsIndexed[$messageList[0]['ticket_email']];
								  ?>
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
							  <?php } ?>
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
			
			
			<div class="col-sm-3">
				<div class="all-bg">
					<div class="body-widget">
						<h2 class="small-white-title"><i class="fa fa-users"></i> Status : <?php echo e_ticket_status_show($messageList[0]['ticket_status'], 2); ?></h2>
					</div>									
				</div>
				<div class="right-side1">
					<div class="reply-widget">
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
							   <input type="hidden" name="time_interval_update" id="time_interval_update">
							   <input type="hidden" name="ticket_category_old" value="<?php echo $messageList[0]['ticket_category']; ?>">
							   <select class="form-control" name="ticket_category" required>
									<option value="">-- Select --</option>
								<?php foreach($ticketCategory as $token){ ?>
									<option value="<?php echo $token['category_code']; ?>" <?php echo $messageList[0]['ticket_category'] == $token['category_code'] ? "selected" : ""; ?>><?php echo $token['category_name']; ?></option>
								<?php } ?>
								</select>
							</div>
							<div class="form-group">
							  <label>Assigned User</label>
							   <input type="hidden" name="ticket_user_old" value="<?php echo $assigned_user; ?>">
							   <select class="form-control" name="ticket_user" disabled required>
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
							   <input type="hidden" name="hold_interval_notes" id="hold_interval_notes" value="00:00:00">
							   <input type="hidden" name="hold_reason_count_notes" id="hold_reason_count_notes" value="0">
							   <input type="hidden" name="hold_reason_notes" id="hold_reason_notes" value="">
							   <input type="hidden" name="time_interval_notes" id="time_interval_notes">
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
				
				
				<?php if(e_show_arrival($email_id)){ ?>
				<br/>				
				<div class="all-bg">
					<div class="body-widget">
						<h2 class="small-white-title"><i class="fa fa-calendar"></i> Arrival Date</h2>
					</div>									
				</div>
				<div class="right-side1 arrivalBlock">
					<div class="reply-widget">
					<div class="row arrivalDIVInfo">
					<div class="col-sm-8">
						<div class="from-group">
							<input type="hidden" name="arrival_ticket_no" value="<?php echo $ticket_no; ?>">
							<input type="text" class="form-control newDatePick" name="arrival_date" id="arrival_date" value="<?php echo !empty($messageList[0]['ticket_arrival_date']) ? date('m/d/Y', strtotime($messageList[0]['ticket_arrival_date'])) : ""; ?>">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="from-group">
							<a class="btn btn-primary arrivalDIVInfoUpdater" style="margin-left:4px">Update</a>
						</div>
					</div>
					</div>
					</div>
				</div>
				<?php } ?>
				
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
			
			
			
			
			
			<?php } else { ?>
			
			
			<div class="col-sm-9">
				<div class="all-bg">
					<div class="body-widget">
						<h2 class="small-white-title"><i class="fa fa-user"></i> Current User : <?php echo $agent_details['fname']. " " .$agent_details['lname']; ?> (<?php echo $agent_details['fusion_id']; ?>)</h2>
					</div>									
				</div>
				
				<div class="email-white" style="height: 400px;">
					<div class="tab-content">
					
						<div id="job1" class="tab-pane active">
							<div class="body-widget">
							
																		
							<i class="fa fa-clock-o"></i> <b><?php echo date('d M Y, h:i A', strtotime(CurrMySqlDate())); ?></b>									
								
									
							<div class="row">
							<div class="col-md-12">
							<div class="row pull-right">
							<form id="form_new_user"  method="GET" action="" autocomplete="off">
								<div class="col-md-5">
									<div class="form-group">
										<input type="text" placeholder="Search Subject" id="search_keyword" name="search_keyword" value="<?php  echo !empty($search_keyword) ? $search_keyword : ''; ?>" class="form-control">
									</div>
								</div>										
								<div class="col-md-3">
									<div class="form-group">
										<input type="text" id="search_from_date" name="search_start" value="<?php  echo !empty($search_start) ? date('m/d/Y', strtotime($search_start)) : date('m/d/Y', CurrMySqlDate()); ?>" class="form-control oldDatePick" required>
									</div>
								</div>
								<div class="col-md-3"> 
									<div class="form-group">
										<input type="text" id="search_to_date" name="search_end" value="<?php  echo !empty($search_end) ? date('m/d/Y', strtotime($search_end)) : date('m/d/Y', CurrMySqlDate()); ?>" class="form-control oldDatePick" required>
									</div> 
								</div>							
								<div class="col-md-1">
									<button class="btn btn-success waves-effect" type="submit" value="View"><i class="fa fa-search"></i></button>
								</div>		
							</form>
							</div>
							</div>
							</div>
								
								<hr/>
								
								<?php if(!empty($agent_details['is_pick'])){ ?>
								 <a href="<?php echo base_url('emat/ticket_pull_agent'); ?>" onclick="return confirm('Are you sure you want to pull new ticket for assignment ?');" class="btn btn-danger pull-right"><i class="fa fa-repeat"></i> Pull Ticket</a>
								<?php } ?>
								
									
									
								   <div class="row">		
									<div class="col-md-3 col-sm-6 col-xs-12">
										<div class="mini-stat clearfix  bg-googleplus rounded">
											<span class="mini-stat-icon"><i class="fa fa-bar-chart fg-googleplus"></i></span>
											<div class="mini-stat-info">
												<span><?php echo !empty($messageListAll) ? count($messageListAll) : '0'; ?></span>
												Tickets Pending
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6 col-xs-12">
										<div class="mini-stat clearfix  bg-twitter rounded">
											<span class="mini-stat-icon"><i class="fa fa-bar-chart fg-twitter"></i></span>
											<div class="mini-stat-info">
												<span><?php echo !empty($messageListAllPassed) ? count($messageListAllPassed) : '0'; ?></span>
												Tickets Passed
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6 col-xs-12">
										<div class="mini-stat clearfix  bg-success rounded">
											<span class="mini-stat-icon"><i class="fa fa-bar-chart text-success"></i></span>
											<div class="mini-stat-info">
												<span><?php echo !empty($messageListAllComplete) ? count($messageListAllComplete) : '0'; ?></span>
												Tickets Completed
											</div>
										</div>
									</div>
									</div>
							
							</div>
						</div>
					</div>
				</div>
			</div>		
			
			
			<?php } ?>
			
			
			
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
					   <input type="text" class="form-control" name="forward_email_id" required>
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