<div class="wrap">
<section class="app-content">

<section id="job-list" class="job-list">
<div class="widget-body clearfix">
	
	<?php $this->load->view('emat/nav_mail_box'); ?>
		
		
		
		
<div class="email-white1">
	<div class="tab-content">
		<div id="category1" class="tab-pane active">
			<h2 class="heading-title"><?php echo !empty($catInfo) ? $catInfo[0]['category_name'] : "All"; ?> Assigned List</h2>
			
			<div class="job-main">
				<div class="row">
				
					<?php $this->load->view('emat/overview_mail_box'); ?>
					
					
					<div class="col-sm-6">
						<div class="job-detail">
							<div class="body-widget">
								<h2 class="small-title">Agent</h2>
							</div>
							<div class="table-widget">
								<table class="table table-bordered table-striped">
									<tbody>
									  <tr>
										<td>Assigned</td>
										<td>-</td>
										<td>Unassigned</td>
										<td>-</td>
									  </tr>
									  <tr>
										<td>Processed</td>
										<td>-</td>
										<td>Total</td>
										<td>-</td>
									  </tr>
									  <tr>
										<td>Within SLA</td>
										<td>-</td>
										<td>SLA Breached</td>
										<td>-</td>
									  </tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
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
						<?php } ?>
						</div>
					</div>
				</div>
				
				
				
				
				<div class="col-sm-9">
					<div class="all-bg">
							<div class="body-widget">
								<div class="row">
									<div class="col-md-4">
										<h2 class="small-white-title"><i class="fa fa-user"></i> <?php echo !empty($agentListData[$currentAgent]) ? $agentListData[$currentAgent]['fname'] ." " .$agentListData[$currentAgent]['lname'] : " Assigned List"; ?></h2>
									</div>
									
									<div class="col-md-8">								
									<a class="btn btn-danger btn-sm btn-mini pull-right" href="<?php echo base_url()?>emat/ticket_pending/<?php echo bin2hex($email_id); ?>/all">
									<i class="fa fa-ticket"></i> View All
									</a>
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
											<th class="text-centers" style="width:<?php echo $_t1; ?>%">Ticket ID</th>
											<?php if(!empty($email_id) && e_show_arrival($email_id)){ ?>
											<th class="text-center" style="width:<?php echo $_t6; ?>%">Arrival Dt</th>
											<?php } ?>
											<th class="text-center" style="width:<?php echo $_t2; ?>%">Category</th>
											<th class="text-center" style="width:<?php echo $_t3; ?>%">AHT</th>
											<th class="text-center" style="width:<?php echo $_t4; ?>%">Aging</th>
											<th class="text-center" style="width:<?php echo $_t5; ?>%">Assigned</th>
										  </tr>
										</tbody>
									  </table>
									</div>
								</a>
							  </div>
									
							<?php 
							foreach($messageList as $token){ 
									
									$assignedDate = !empty($ticketAssigned[$token['ticket_no']]) ? $ticketAssigned[$token['ticket_no']]['date_assigned'] : "";
									$slaBreach = false;  $sla_class="text-success";
									
									$ticketCategory = $token['ticket_category'];
									$ticketCategoryName = $ticketCategoryIndexed[$ticketCategory]['category_name'];
									
									if(!empty($assignedDate)){
										
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
										  
											<td title="<?php echo $token['ticket_subject']; ?>" style="width:<?php echo $_t1; ?>%;font-size:12px">
											<b><?php echo $token['ticket_no']; ?></b> : 
											<?php echo $token['ticket_subject'];//e_short_text($token['ticket_subject'], 30); ?>
											</td>
											
											<?php if(e_show_arrival($email_id)){ ?>
											<td  class="text-center" style="width:<?php echo $_t6; ?>%;font-size:11px"><?php echo !empty($token['ticket_arrival_date']) ? $token['ticket_arrival_date'] : "-"; ?></td>
											<?php } ?>
											
											<td  class="text-center" style="width:<?php echo $_t2; ?>%;font-size:11px"><?php echo $ticketCategoryName; ?></td>
											
											<td  class="text-center" style="width:<?php echo $_t3; ?>%;font-size:12px"><?php if(!empty($token['total_time'])){ ?><span class="green"><?php echo $token['total_time']; ?></span><?php } else { ?><b>n/a</b><?php } ?></td>
											
											<td  style="width:<?php echo $_t4; ?>%;font-size:12px"><span class="red"><?php echo e_display_aging_time(e_aging_ticket($token['date_added'])); ?></span></td>
											
											<td style="width:<?php echo $_t5; ?>%;font-size:12px" title="<?php echo !empty($ticketAssigned[$token['ticket_no']]) ? $ticketAssigned[$token['ticket_no']]['fullname'] : "Unassigned"; ?>">
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