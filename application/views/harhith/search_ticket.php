<div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">
								<?php echo !empty($page_title) ? $page_title : "Today Ticket"; ?>
							</h5>                           
                        </div>                        
                    </div>
                </div>
            </div>
			
			<div class="top-filter">
				<div class="card">
					<div class="card-body searchBodyDiv">
					<form id="searchTicketForm" method="GET" autocomplete="off" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
								  <label>From date (mm/dd/yy)</label>
								  <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($search_start)); ?>" name="search_start">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label>To date (mm/dd/yy)</label>
								  <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($search_end)); ?>"name="search_end">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label>Call Type</label>
								  <select class="form-control" name="search_call">
									<?php echo hth_dropdown_3d_options($call_type, 'id', 'name', $search_call); ?>	
								  </select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label>District</label>
								  <select class="form-control" name="search_district">
									<?php echo hth_dropdown_options_val($district_list, $search_district); ?>	
								  </select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label>Phone No</label>
								  <input type="text" minlen="5" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control numberCheckPhone" value="<?php echo $search_phone; ?>"name="search_phone">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label>Ticket No</label>
								  <input type="text" minlen="5" class="form-control" value="<?php echo $search_ticket; ?>"name="search_ticket">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<button type="button"  style="margin-top:30px" class="search-btn searchTicketButton">Search</button>
								</div>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
            
            
			<div class="common-top">
				<div class="middle-content">
					<div class="row align-items-center">
						<br/>
					</div>
					
					<div class="card padderCard">
						<div class="card-body">							
							<div class="table-widget">
								<div class="table-white">
									<table id="datatable-check" class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th>#</th>
											<th>Date</th>
											<th>Ticket No</th>
											<th>Phone</th>
											<th>Call Type</th>
											<th>District</th>
											<th>City</th>
											<th>Contact Reason</th>
											<th>Status</th>											
											<th>Age</th>
											<th>Raised By</th>
											<th>Actions</th>
											<th style="display:none">Comments</th>
										  </tr>
										</thead>
										<tbody>
										<?php 
										$sn=0;
										foreach($tickets_list as $token_list){ 
											$sn++;
											$_t_date = $token_list['date_added'];
											if(!empty($token_list['ticket_closed_date'])){
												$_t_date = $token_list['ticket_closed_date'];
											}
											$agingSeconds = hth_aging_ticket($_t_date);
											$aginTimeView = hth_display_aging_time($agingSeconds);
											
											$colorVal = "";
											if(!empty($viewType) && $viewType == "aged"){
												$noofDays = ($agingSeconds/3600)/24;
												if($noofDays <= 10){ $colorVal = "bg-primary text-white"; }
												if($noofDays > 10 && $noofDays <= 20){ $colorVal = "bg-warning text-white"; }
												if($noofDays > 20){ $colorVal = "bg-danger text-white"; }
											}
										?>
										  <tr class="<?php echo $colorVal; ?>">
											<td><?php echo $sn; ?></td>
											<td><?php echo date('d.m.Y', strtotime($token_list['ticket_date'])); ?></td>
											<td><a style="cursor:pointer;text-decoration:underline;color:#410c0c" class="viewTicketInfo" tid="<?php echo $token_list['ticket_no']; ?>"><?php echo $token_list['ticket_no']; ?></a></td>
											<td><?php echo $token_list['customer_phone']; ?><?php echo !empty($token_list['customer_phone_alt']) ? "<br/>" .$token_list['customer_phone_alt'] : ""; ?></td>
											<td><?php echo $token_list['call_type_name']; ?></td>
											<td><?php echo $token_list['call_district']; ?></td>
											<td><?php echo $token_list['call_city']; ?></td>
											<td><?php echo $token_list['reason_name']; ?>, <br/><?php echo $token_list['sub_reason_name']; ?></td>
											<td><span class="font-weight-bold text-<?php echo hth_ticket_status_color($token_list['ticket_status']); ?>"><?php echo hth_ticket_status($token_list['ticket_status']); ?></span></td>
											<td><?php echo $aginTimeView; ?></td>
											<td>
											<?php echo $token_list['agent_name']; if($token_list['added_type'] == "public"){ echo "External"; } ?><br/>
											<a style="cursor:pointer;text-decoration:underline;color:#410c0c" class="viewTicketLogs" tid="<?php echo $token_list['ticket_no']; ?>"><i class="fa fa-comments"></i> Comments</a>
											</td>
											<td>
											<?php if($token_list['ticket_status'] == "A"){ echo "<i class='fa fa-user'></i> Assigned : <br/>".$token_list['assigned_name'].", <br/>".$token_list['ticket_assigned_date']; } ?>
											<?php if($token_list['ticket_status'] == "C"){ echo "<i class='fa fa-user'></i> Closed : <br/>".$token_list['completed_name'] .", <br/>".$token_list['ticket_closed_date']; } ?>
																						
											<?php if((get_role() == "moderator" || get_role() == "md") && $token_list['ticket_status'] == "P"){ ?>
												<div class="edit-btn">
													<a href="javascript:void(0);" tid="<?php echo $token_list['ticket_no']; ?>" class="assignTicket btn btn-danger text-white edit-link" data-toggle="tooltip" data-placement="top" title="Assign Ticket">
														<i class="fa fa-users" aria-hidden="true"></i> Assign
													</a>
												</div>
											<?php } ?>
											
											<?php if((get_role() == "stakeholder" || get_role() == "md") && ($token_list['ticket_status'] == "A" || $token_list['ticket_status'] == "F")){ ?>
												<div class="edit-btn">
													<a href="javascript:void(0);" tid="<?php echo $token_list['ticket_no']; ?>" class="replyTicket btn btn-danger text-white edit-link" data-toggle="tooltip" data-placement="top" title="Reply Ticket">
														<i class="fa fa-users" aria-hidden="true"></i> Reply
													</a>
												</div>
											<?php } ?>
											</td>
											<td style="display:none"><?php echo $token_list['all_comments']; ?></td>
										   </tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			

<div class="modal fade" id="assignTicketsModal" tabindex="-1" role="dialog" aria-labelledby="assignTicketsModal" aria-hidden="true">
  <div class="modal-dialog" style="width:100%">
  <form method="POST" action="<?php echo hth_url('assign_ticket'); ?>" autocomplete="off" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Assign Ticket</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Department Type</label>
					  <select class="form-control" name="select_department_sub">
						<?php 
						$dropdownOptions = hth_dropdown_department_sub();
						echo hth_dropdown_options($dropdownOptions); 
						?>	
					  </select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Department</label>
					  <select class="form-control" name="select_department">
						<option>-- Select Department --</option>
						<?php //echo hth_dropdown_3d_options($department_list,'id','name'); ?>	
					  </select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Users</label>
					  <select class="form-control" name="select_user">
						<option>-Select User</option>
					  </select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<input type="hidden" name="ticket_no" value="" required>
					</div>
				</div>
			</div>		
      </div>	  
      <div class="modal-footer">
	     <button type="submit" class="btn search-btn">Assign</button>		 
         <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>
 </form>
  </div>
</div>




<div class="modal fade" id="replyTicketsModal" tabindex="-1" role="dialog" aria-labelledby="replyTicketsModal" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="width:100%">
  <form method="POST" action="<?php echo hth_url('reply_ticket'); ?>" autocomplete="off" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Reply Ticket</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Status</label>
					  <select class="form-control" name="select_status">						
						<option value="C">Close</option>
						<option value="F">In Progress</option>
					  </select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Remarks</label>
					  <textarea class="form-control" name="select_remarks"></textarea>
					</div>
				</div>				
				<div class="col-sm-12">
					<div class="form-group">
						<input type="hidden" name="ticket_no" value="" required>
					</div>
				</div>
			</div>		
      </div>	  
      <div class="modal-footer">
	     <button type="submit" class="btn search-btn">Reply Ticket</button>		 
         <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>
 </form>
  </div>
</div>
			
			
<div class="modal fade" id="viewTicketsModal" tabindex="-1" role="dialog" aria-labelledby="viewTicketsModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Ticket Details</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  
	  </div>	  
      <div class="modal-footer">	 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>