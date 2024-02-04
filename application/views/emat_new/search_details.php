<div class="main-content page-content">
	<div class="main-content-inner"> 

		<div class="common-top">
			<div class="middle-content">
				<div class="white-dash">
					<div class="filter-widget">
						<form  method="GET" action="" autocomplete="off">
							<div class="row">

							<div class="col-sm-3">
								<div class="form-group">
									<label>Start date</label>
									<input type="date" class="form-control" name="from_date" value="<?php echo ($from_date!='')?$from_date:'';?>" autocomplete="off" >
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>End date</label>
									<input type="date" class="form-control"  name="to_date" value="<?php echo ($to_date!='')?$to_date:'';?>" autocomplete="off" >
								</div>
							</div>
							<div class="col-sm-3">
									<div class="form-group">
										<label>Transaction Type</label>
										<select id="transaction_types" class="form-control" name="transaction_types" autocomplete="off" placeholder="Transaction Type" >
										<?php 
											echo "<option value=''>-- Select Transaction Type</option>";
							
											foreach($transaction_type as $token){
											$selection = "";
											if($transaction_types == $token['id']){ $selection = "selected"; }
										?>
										<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['trans_type_name']; ?></option>
										<?php } ?>	
										</select>
									</div>
								</div>
							<div class="col-sm-3">
								<div class="form-group">
									<button class="submit-btn" type="submit" name="search" value="View"><i class="fa fa-paper-plane" aria-hidden="true"></i>Search</button>
									<!-- <button type="submit" class="submit-btn">
										<i class="fa fa-paper-plane" aria-hidden="true"></i>
										Submit
									</button> -->
								</div>
							</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<div class="common-top">
			<div class="middle-content">
				<div class="white-dash">
					<div class="table-widget">
						<div class="table-white">
							<table id="example" class="table common-data table-striped table-bordered">
								<thead>
								  <tr>
								  	<th>SL.no</th>
									<th>Transaction ID</th>
									<th>Date</th>
									<th>Ticket ID</th>
									<th>Flight Id</th>
									<th>Date of Flight</th>
									<th>Type</th>
									<th>Transaction Type</th>
									<th>Agent Name</th>
									<th>Current Status</th>
									<th>Source</th>
									<th>Outbound Call</th>
									<th>AHT</th>
									<th>View Details</th>
								  </tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								foreach($crm_list as $token){ 								
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['trans_unique_id']; ?></td>
									<td><b><?php echo date('d M, Y', strtotime($token['trans_date'])); ?></b></td>
									<td><?php echo $token['trans_ticket_id']; ?></td>
									<td><?php echo $token['trans_flight_id']; ?></td>
									<td><b><?php echo date('d M, Y', strtotime($token['trans_flight_date'])); ?></b></td>
									<td><?php echo $token['transaction_type'] == '1' ? "Ticket" : "Email"; ?></td>
									<td><?php echo $token['transaction_type_name']; ?></td>
									<td><?php echo $token['added_by_name']; ?></td>
									<td><?php if ($token['is_resolved'] == 1) {
										echo "Closed";
										
									}elseif ($token['is_resolved'] == 2) {
										echo "Pending";
									}else{
										echo "No Action Required";
									}  ?></td>
									<td><?php echo $token['source'];  ?></td>
									<td><?php echo $token['outbound_call'] == '1' ? "Yes":"No"; ?></td>
									<td><?php echo $token['total_time']; ?></td>
									<td><?php  if ($token['is_resolved'] == 1) {?>
										<a href="<?php echo base_url('emat_new/view_transaction/'.$token['trans_unique_id']); ?>"  class="edit-btn"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
										
									<?php }else{?>
										<a href="<?php echo base_url('emat_new/update_transaction/'.$token['trans_unique_id']); ?>" class="edit-btn"><i class="fa fa-edit"></i></a></td>
									<?php }?>
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




<!--start Modal view -->
<div class="modal fade modal-design" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row" >
								<div class="col-sm-3">
									<div class="form-group">
										<label>Unique Id</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmid; ?>" name="crm_id" required readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date and Time</label>
										<input type="text" class="form-control" id="c_date" placeholder="" value="<?php echo date('m/d/Y', strtotime($currentDate)); ?>" name="c_date" readonly >
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Ticket ID</label>
										<input type="text" class="form-control" id="ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>" pattern="([^\s][A-z0-9À-ž\s]+)">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Flight Id</label>
										<input type="text" class="form-control" id="flight_id" name="flight_id" value="<?php echo $flight_id; ?>"  pattern="([^\s][A-z0-9À-ž\s]+)" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date of Flight</label>
										<input type="date" class="form-control" id="flight_date" name="flight_date" value="<?php echo $flight_date; ?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Type - Email or Ticket</label>
										<select class="form-control" name="type" value="" required>
											<option value="0">Email</option>
											<option value="1">Ticket</option>
											
										</select>
										
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Source</label>
										<select class="form-control" name="source" value="" >
											<option value="Zendesk">Zendesk</option>
											<option value="Flight">Flight APP</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Transaction Type</label>
										<select id="transaction_types" class="form-control" name="transaction_types" autocomplete="off" placeholder="Transaction Type" required>
										<?php 
											echo "<option value=''>-- Select Transaction Type</option>";
							
											foreach($transaction_type as $token){
											$selection = "";
											if($userSelected == $token['id']){ $selection = "selected"; }
										?>
										<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['trans_type_name']; ?></option>
										<?php } ?>	
										</select>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label>Agent Name</label>
				
										<input type="text" class="form-control"  value="<?php echo get_username(); ?>" name="agent_full_name" required readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Dispostion List for Resolved</label>
										<select class="form-control" name="is_resolved" autocomplete="off" placeholder="Dispostion List for Resolved" required>
											<option value="1">Closed</option>
											<option value="0">No Action Required</option>
											<option value="2">Pending</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Remarks</label>
										<input type="text" class="form-control" id="" name="remarks" required >
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Outbound Call</label>
										<select class="form-control" id="outbond_call" name="outbond_call" >
											<option value="2">No</option>
											<option value="1">Yes</option>
										</select>
									</div>
								</div>
								
								
								
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!--end Modal view -->