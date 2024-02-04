<div class="wrap">
<section class="app-content">

<section id="job-list" class="job-list">
<div class="widget-body clearfix">
		
	<?php $this->load->view('emat/nav_mail_box'); ?>
		
		
		
		
<div class="email-white1">
	<div class="tab-content">
		<div id="category1" class="tab-pane active">
			<h2 class="heading-title"><?php echo !empty($catInfo) ? $catInfo[0]['category_name'] : "All"; ?> Ticket List</h2>
			
			
			
			<div class="row">			
				
				
			<div class="col-sm-12">
					<br/>
					<div class="all-bg">
						<div class="body-widget">
							<div class="row">
								<div class="col-md-4">
									<h2 class="small-white-title"><i class="fa fa-ticket"></i> <?php echo $email_id; ?></h2>
								</div>
								
								<div class="col-md-8 dropdownCapture">								
									<select class="form-control pull-right" style="width:200px;height: 22px;margin-bottom: 1px;margin-top: -2px;" name="ticket_list_dropdown">
										    <option value="pending" <?php echo $page_type == 'ticket_unassigned' ? 'selected' : ''; ?> >Unassigned</option>
											<option value="assigned" <?php echo $page_type == 'ticket_pending' ? 'selected' : ''; ?>>Assigned</option>
											<option value="passed" <?php echo $page_type == 'ticket_passed' ? 'selected' : ''; ?>>Passed</option>
											<option value="completed" <?php echo $page_type == 'ticket_completed' ? 'selected' : ''; ?>>Completed</option>
											<option value="all" <?php echo $page_type == 'ticket_list' || empty($page_type) ? 'selected' : ''; ?>>All</option>
									</select>
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
							foreach($messageList as $token){ 
								$assignedDate = !empty($ticketAssigned[$token['ticket_no']]) ? $ticketAssigned[$token['ticket_no']]['date_assigned'] : "";
								$slaBreach = false;  $sla_class="text-success";
								if(!empty($assignedDate)){
									$ticketCategory = $token['ticket_category'];
									$slaTime = $ticketCategoryIndexed[$ticketCategory]['category_sla'];
									if(empty($slaTime)){ 
										$slaTime = $ticketMailsIndexed[$email_id]['ticket_sla'];
									}
									$slaTimeMax = strtotime('+' .$slaTime .' hour', strtotime($assignedDate));
									if(strtotime(CurrMySqlDate()) >= $slaTimeMax && $token['is_open'] == 1)
									{
										$slaBreach = true;
										$sla_class="red";
									}
								}
							?>
							
							  <div class="card-header ticketInfoDiv h<?php echo $token['ticket_no']; ?>" ticket="<?php echo $token['ticket_no']; ?>" style="cursor:pointer">
								<a class="card-link">
								  <div class="table-widget">
									<table class="table table-bordered table-striped">
										<tbody>
										  <tr>
											<td title="<?php echo $token['ticket_subject']; ?>" style="width:40%">
											<b><?php echo $token['ticket_no']; ?></b> : 
											<?php echo e_short_text($token['ticket_subject'], 30); ?>
											</td>
											<td  class="text-center" style="width:14%">AHT <?php if(!empty($token['total_time'])){ ?><span class="green"><?php echo $token['total_time']; ?></span><?php } else { ?><b>n/a</b><?php } ?></td>
											<td  style="width:22%"><i class="fa fa-clock-o"></i> <span class="red"><?php echo e_display_aging_time(e_aging_ticket($token['date_added'])); ?></span></td>
											<td style="width:20%" title="<?php echo !empty($ticketAssigned[$token['ticket_no']]) ? $ticketAssigned[$token['ticket_no']]['fullname'] : "Unassigned"; ?>"><i class="fa fa-user" aria-hidden="true"></i>
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