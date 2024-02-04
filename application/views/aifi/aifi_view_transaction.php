<div class="main-content page-content">
	<div class="main-content-inner"> 

		<div class="common-top">
			<div class="middle-content">
				<div class="white-dash">
					<b>Transaction ID Details: <?php echo $crm_details['trans_unique_id']; ?> </b>
				</div>
			</div>
		</div>
		
		<div class="common-top">
			<div class="middle-content">
				<div class="white-dash">
					<!-- <div class="table-widget">
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
									
								  </tr>
								</thead>
								<tbody>
								
								<tr>
									
									<td><?php echo $crm_details['trans_unique_id']; ?></td>
									<td><b><?php echo date('d M, Y', strtotime($crm_details['trans_date'])); ?></b></td>
									<td><?php echo $crm_details['trans_ticket_id']; ?></td>
									<td><?php echo $crm_details['trans_flight_id']; ?></td>
									<td><b><?php echo date('d M, Y', strtotime($crm_details['trans_flight_date'])); ?></b></td>
									<td><?php echo $crm_details['transaction_type'] == '1' ? "Ticket" : "Email"; ?></td>
									<td><?php echo $crm_details['transaction_type_name']; ?></td>
									<td><?php echo $crm_details['added_by_name']; ?></td>
									<td><?php if ($crm_details['is_resolved'] == 1) {
										echo "Closed";
										
									}elseif ($crm_details['is_resolved'] == 2) {
										echo "Pending";
									}else{
										echo "No Action Required";
									}  ?></td>
									<td><?php echo $crm_details['source'];  ?></td>
									<td><?php echo $crm_details['outbound_call'] == '1' ? "Yes":"No"; ?></td>
									<td><?php echo $crm_details['total_time']; ?></td>
									
								</tr>
								
								</tbody>								
							</table>
						</div>
					</div> -->
					 <div class="row" >
								<div class="col-sm-3">
									<div class="form-group">
										<label>Unique Id</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['trans_unique_id']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date and Time</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo date('d M, Y', strtotime($crm_details['trans_date'])); ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Completed Cases</label>
										<input type="text" class="form-control" id="completed_cases" placeholder="" value="<?php echo $crm_details['completed_cases']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Reason For Leaving</label>
										<input type="text" class="form-control"  value="<?php echo $crm_details['reason_for_leaving']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Hat Link</label>
										<input type="text" class="form-control"  value="<?php echo $crm_details['hat_link']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Type - Email or Ticket</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php  echo $crm_details['transaction_type'] == '1' ? "Ticket" : "Email";?>"  readonly>
										
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Source</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['source']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Transaction Type</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['transaction_type_name']; ?>"  readonly>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label>Agent Name</label>
				
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['added_by_name']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Dispostion List for Resolved</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php if ($token['is_resolved'] == 1) {
										echo "Closed";
										
									}elseif ($token['is_resolved'] == 2) {
										echo "Pending";
									}else{
										echo "No Action Required";
									}  ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Outbound Call</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo  $crm_details['transaction_type'] == '1' ? "YES" : "NO"; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Call Time</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['c_call']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>No of Call Hold</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['c_hold']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Call Hold Time</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['c_hold_time']; ?>"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Total Call Time</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['total_time']; ?>"  readonly>
									</div>
								</div>
								
								
								
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
									<th>Completed Cases</th>
									<th>Reason For Leaving</th>
									<th>Hat Link</th>
									<th>Agent Name</th>
									<th>Current Status</th>
									<th>Notes</th>
									<th>Update Date</th>
									<th>logs</th>

									
								  </tr>
								</thead>
								<tbody>
								<?php 
								//print_r($log_details);die;
								$cn = 1;
								foreach($log_details as $token){ 								
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['new_transation_id']; ?></td>
									<td><?= $token['completed_cases'];?></td>
									<td><?= $token['reason_for_leaving'];?></td>
									<td><?= $token['hat_link'];?></td>
									<td><?php echo $token['added_by_name']; ?></td>
									<td><?php if ($token['ticket_status'] == 1) {
										echo "Closed";
										
									}elseif ($token['ticket_status'] == 2) {
										echo "Pending";
									}else{
										echo "No Action Required";
									}  ?>
										
									</td>
									<td><?php echo $token['notes']; ?></td>
									<td><?php echo $token['added_date']; ?></td>
									<td><?php echo $token['logs']; ?></td>
									
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

