<div class="wrap">
<section class="app-content">

<section id="job-list" class="job-list">
<div class="widget-body clearfix">
	
	<?php $this->load->view('emat/nav_mail_box'); ?>
		
		
		
		
<div class="email-white1">
	<div class="tab-content">
		<div id="category1" class="tab-pane active">
			<h2 class="heading-title"><?php echo !empty($catInfo) ? $catInfo[0]['category_name'] : "All"; ?> Unassigned List</h2>
			<div class="job-main">
				<div class="row">
				
					<?php $this->load->view('emat/overview_mail_box'); ?>
					
				</div>
			</div>
			
			
			
			
			
			<div class="row">
			
			
				<div class="col-sm-3">							
					<div class="left-side2">
						<div class="all-bg">
							<div class="body-widget">
								<h2 class="small-white-title">Agent Overview</h2>
							</div>									
						</div>
						<div class="all-new box">
						
						<?php 
						foreach($agentAssignArray as $key=>$token){ 
							$agentInfo = $agentListData[$key];
							$agentEmailIDAr = explode(',', $agentInfo['my_email_ids']);
							
							$showAccess = false;
							if(in_array($email_id, $agentEmailIDAr)){ $showAccess = true; }
							
							if($showAccess == true){ 
						?>
							<div class="all-repeat">
							<a href="<?php echo base_url()?>emat/ticket_agents/<?php echo bin2hex($email_id); ?>/<?php echo $agentInfo['id']; ?>/all">
								<div class="all-main">									
									<div class="all-widget" style="width:40%;font-size:11px">
										<p style="font-size:11px" title="<?php echo $agentInfo['fname']." " . $agentInfo['lname']; ?>">
										<?php echo e_short_text($agentInfo['fname']." " . $agentInfo['lname'], 20); ?></p>
									</div>
									<div class="all-widget" style="width:30%;font-size:10px">
										<?php //echo $agentInfo['fusion_id']; ?>
									</div>									
									<div class="all-widget" style="width:20%">
										<div class="count-bg" <?php if($token > 0){ echo 'style="background: #10c469;"'; } ?>><?php echo $token; ?></div>
									</div>
								</div>
							</a>
							</div>
						<?php } } ?>
						</div>
					</div>
				</div>
				
				
				
				
				<div class="col-sm-9">
					<div class="all-bg">
							<div class="body-widget">
								<div class="row">
									<div class="col-md-4">
										<h2 class="small-white-title"><i class="fa fa-ticket"></i> <?php echo !empty($emat_page) ? $emat_page : "Ticket List"; ?></h2>
									</div>							
									<div class="col-md-8 dropdownCapture">								
										<select class="form-control pull-right" style="width:200px;height: 22px;margin-bottom: 1px;margin-top: -2px;" name="ticket_list_dropdown">
											<option value="pending" <?php echo $page_type == 'ticket_unassigned' ? 'selected' : ''; ?> >Unassigned</option>
											<option value="assigned" <?php echo $page_type == 'ticket_pending' ? 'selected' : ''; ?>>Assigned</option>
											<option value="passed" <?php echo $page_type == 'ticket_passed' ? 'selected' : ''; ?>>Passed</option>
											<option value="completed" <?php echo $page_type == 'ticket_completed' ? 'selected' : ''; ?>>Completed</option>
											<option value="all" <?php echo $page_type == 'ticket_list' || empty($page_type) ? 'selected' : ''; ?>>All</option>
										</select>
										<?php if(e_show_arrival($email_id)){ ?>
										<select class="form-control pull-right" style="width:100px;height: 22px;margin-bottom: 1px;margin-top: -2px;margin-right:5px" name="sort_list_dropdown">
											<option value="default" <?php echo e_sort_email_type($email_id) == 'default' ? 'selected' : ''; ?> >Ageing</option>
											<option value="arrival" <?php echo e_sort_email_type($email_id) == 'arrival' ? 'selected' : ''; ?>>Arrival</option>
										</select>
										<?php } ?>
									</div>
								</div>
							</div>									
						</div>
					<div class="email-white">
						
						<div class="body-widget">
						<div class="accordian-widget ticketListWidget">
							<div id="accordion">
							<div class="card ticketListDiv">

							<?php
							$_t1 = "40";
							$_t2 = "20";
							$_t3 = "10";
							$_t4 = "15";
							$_t5 = "15";
							
							if(e_show_arrival($email_id)){
								$_t1 = "35";
								$_t6 = "12";
								$_t2 = "13";
								$_t3 = "10";
								$_t4 = "15";
								$_t5 = "15";
							}
							?>
								
							<div class="card-header">
								<a class="card-link">
								  <div class="table-widget">
									<table class="table table-bordered table-striped">
										<tbody>
										  <tr>
										  	<th>
										  		All
										  		<input type="checkbox" name="check_all" id="check_all" class="text-center check_all"  onclick="check_all();"></th>
											<th class="text-centers" style="width:<?php echo $_t1; ?>%">Ticket ID</th>
											<?php if(!empty($email_id) && e_show_arrival($email_id)){ ?>
											<th class="text-center" style="width:<?php echo $_t6; ?>%">Arrival Dt</th>
											<?php } ?>
											<th class="text-center" style="width:<?php echo $_t2; ?>%">Category</th>
											<th class="text-center" style="width:<?php echo $_t3; ?>%">AHT</th>
											<th class="text-center" style="width:<?php echo $_t4; ?>%">Ageing</th>
											<th class="text-center" style="width:<?php echo $_t5; ?>%">Assigned</th>
										  </tr>
										</tbody>
									  </table>
									</div>
								</a>
							  </div>
							<form method="POST" action="<?php echo base_url('emat/ticket_assign_manual_multi'); ?>">		
							<?php 
							foreach($messageList as $token){ 
								$assignedDate = !empty($ticketAssigned[$token['ticket_no']]) ? $ticketAssigned[$token['ticket_no']]['date_assigned'] : "";
								$slaBreach = false;  $sla_class="text-success";
								
									$ticketCategory = $token['ticket_category'];
									$slaTime = $ticketCategoryIndexed[$ticketCategory]['category_sla'];
									$ticketCategoryName = $ticketCategoryIndexed[$ticketCategory]['category_name'];
								
									if(empty($slaTime)){ 
										$slaTime = $ticketMailsIndexed[$email_id]['ticket_sla'];
									}
								if(!empty($assignedDate)){
									$slaTimeMax = strtotime('+' .$slaTime .' hour', strtotime($assignedDate));
									if(strtotime(CurrMySqlDate()) >= $slaTimeMax && $token['is_open'] == 1)
									{
										$slaBreach = true;
										$sla_class="red";
									}
								}
							?>
							
							  <div class="card-header  h<?php echo $token['ticket_no']; ?>" ticket="<?php echo $token['ticket_no']; ?>" style="cursor:pointer">
								<a class="card-link">
								  <div class="table-widget">
									<table class="table table-bordered table-striped">
										<tbody>
										  <tr>
										  	<td><input type="checkbox" name="check_ticket_val[]" id="check_<?php echo $token['ticket_no'];?>" class="text-center check_ticket" value="<?php echo $token['ticket_no'].'#'.$ticketCategory.'#'.$messageList[0]['ticket_email'];?>" onclick="boxchk();"></td>
											<td title="<?php echo $token['ticket_subject']; ?>" style="width:<?php echo $_t1; ?>%;font-size:12px" class="ticketInfoDiv" ticket="<?php echo $token['ticket_no']; ?>">
											<b><?php echo $token['ticket_no'] .$assignedDate; ?></b> : 
											<?php echo $token['ticket_subject'];//e_short_text($token['ticket_subject'], 30); ?>
											</td>
											
											<?php if(e_show_arrival($email_id)){ ?>
											<td  class="text-center ticketInfoDiv" style="width:<?php echo $_t6; ?>%;font-size:11px" ticket="<?php echo $token['ticket_no']; ?>"><?php echo !empty($token['ticket_arrival_date']) ? $token['ticket_arrival_date'] : "-"; ?></td>
											<?php } ?>
											
											<td  class="text-center ticketInfoDiv" style="width:<?php echo $_t2; ?>%;font-size:11px" ticket="<?php echo $token['ticket_no']; ?>"><?php echo $ticketCategoryName; ?></td>
											<td  class="text-center ticketInfoDiv" style="width:<?php echo $_t3; ?>%;font-size:11px" ticket="<?php echo $token['ticket_no']; ?>"><?php if(!empty($token['total_time'])){ ?><span class="green"><?php echo $token['total_time']; ?></span><?php } else { ?><b>n/a</b><?php } ?></td>
											<td  style="width:<?php echo $_t4; ?>%;font-size:11px;padding-left:10px;"><span class="<?php echo $sla_class; ?> ticketInfoDiv" ticket="<?php echo $token['ticket_no']; ?>"><b>
												<?php echo (e_aging_ticket($token['date_added'])>86400)?$token['date_added']:e_display_aging_time(e_aging_ticket($token['date_added'])); ?>
											</b></span></td>
											<td style="width:<?php echo $_t5; ?>%;font-size:11px;padding-left:10px;" title="<?php echo !empty($ticketAssigned[$token['ticket_no']]) ? $ticketAssigned[$token['ticket_no']]['fullname'] : "Unassigned"; ?>" class="ticketInfoDiv" ticket="<?php echo $token['ticket_no']; ?>">
											<?php if(!empty($ticketAssigned[$token['ticket_no']])){ ?>
												<?php echo e_short_text($ticketAssigned[$token['ticket_no']]['fullname'], 15); ?>
											<?php } else { ?>
												<span class="text-warning"><b>Unassigned</b></span>
											<?php } ?>
											</td>
										  </tr>
										</tbody>
									  </table>
									</div>
								</a>
							  </div>
							  
							  
							  <div id="t<?php echo $token['ticket_no']; ?>" class="ticketInfoDetails">
							  </div> 
							  
							
							<?php } ?>					  
									  
							<div class="common-top div_ticketAssignUpdate" style="display: none;">
				<div class="select-main">
				
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
									<?php foreach($catlist as $key=>$token){ ?>
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
							<?php } ?>														
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
							</div>								
						</div>								
						</div>
					</div>
				</div>
			</div>
			
			<br/><br/><br/>
			
		</div>
		
		</div>
</div>
</div>
</section>



</section>
</div>