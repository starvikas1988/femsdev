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
									<label>Transaction Start date</label>
									<input type="date" class="form-control" name="from_date" value="<?php echo ($from_date!='')?$from_date:'';?>" autocomplete="off" >
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Transaction End date</label>
									<input type="date" class="form-control"  name="to_date" value="<?php echo ($to_date!='')?$to_date:'';?>" autocomplete="off" >
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Flight Start Date</label>
									<input type="date" class="form-control" name="flight_from_date" value="<?php echo ($flight_from_date!='')?$flight_from_date:'';?>" autocomplete="off" >
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Flight End Date</label>
									<input type="date" class="form-control"  name="flight_to_date" value="<?php echo ($flight_to_date!='')?$flight_to_date:'';?>" autocomplete="off" >
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
										<label>Type - Email or Ticket</label>
										<select class="form-control" name="ticket_type">
											<option value="">-- SELECT --</option>
											<option value="n" <?= ($type=="n")?"selected":""?>>Email</option>
											<option value="1" <?= ($type=="1")?"selected":""?>>Ticket</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Resolved</label>
										<select class="form-control" name="is_resolved" autocomplete="off" placeholder="Dispostion List for Resolved">
											<option value="">-- SELECT --</option>
											<option value="1" <?= ($resolved=="1")?"selected":""?>>Closed</option>
											<option value="n" <?= ($resolved=="n")?"selected":""?>>No Action Required</option>
											<option value="2" <?= ($resolved=="2")?"selected":""?>>Pending</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Ticket ID</label>
										<input type="text" class="form-control" id="ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Flight Id</label>
										<input type="text" class="form-control" id="flight_id" name="flight_id" value="<?php echo $flight_id; ?>">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Fusion Id</label>
										<input type="text" class="form-control" id="fusion_id" name="fusion_id" value="<?php echo $fusion_id; ?>">
									</div>
								</div>
							<div class="col-sm-3">
								<div class="form-group">
									<button class="submit-btn" type="submit" name="view_report" value="View"><i class="fa fa-paper-plane" aria-hidden="true"></i>Search</button>
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
				<div class="white-dash" style="height:600px;overflow:scroll;">
					<div class="table-widget">
						<div class="table-white">
							<table id="example" class="table common-data table-striped table-bordered">
								<thead>
								  <tr>
								 	<th>SL</th>
								  	<th>Type</th>
									<th>Transaction ID</th>
									<th>Date</th>
									<th>Ticket ID</th>
									<th>Flight Id</th>
									<th>Flight Date</th>
									<th>Transaction Type</th>
									<th>Agent Name</th>
									<th>Agent ID</th>
									<th>Status</th>
									<th>Hold Count</th>
									<th>TTT</th>
									<th>AHT</th>
									<th>Source</th>
									<th>Outbound Call</th>
									<!-- <th>Update Count</th> -->
									<th>Remarks</th>
								  </tr>
								</thead>
								<tbody>
								<?php
								$cn = 1;
								foreach($crm_list as $token){
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['transaction_type'] == '1' ? "Ticket" : "Email"; ?></td>
									<td><?php echo $token['trans_unique_id']; ?></td>
									<td><b><?php echo date('d - m -Y -H:i:s', strtotime($token['trans_date'])); ?></b></td>
									<td><?php echo $token['trans_ticket_id']; ?></td>
									<td><?php echo $token['trans_flight_id']; ?></td>
									<td><b><?php echo date('d -m- Y', strtotime($token['trans_flight_date'])); ?></b></td>
									<td><?php echo $token['transaction_type_name']; ?></td>
									<td><?php echo $token['added_by_name']; ?></td>
									<td><?php echo $token['added_id']; ?></td>
									<td><?php if ($token['is_resolved'] == 1) {
										echo "Closed";
										
									}elseif ($token['is_resolved'] == 2) {
										echo "Pending";
									}else{
										echo "No Action Required";
									}  ?></td>
									<td><?= ($token['c_hold']==0)?"-":$token['c_hold']?></td>
									<td><?= ($token['c_hold']==0)?"-":$token['c_hold_time']?></td>
									<td><?php echo $token['total_time']; ?></td>
									<td><?= $token['source']?></td>
									<td><?php echo $token['outbound_call'] == '1' ? "Yes":"No"; ?></td>
									<!-- <td><?= $token['total_count']?></td> -->
									<td><?= $token['remarks']?></td>
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
