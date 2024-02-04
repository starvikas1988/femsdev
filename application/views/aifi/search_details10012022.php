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
									<input type="date" class="form-control" name="from_date" value="<?php echo @$from_date;?>" autocomplete="off" >
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>End date</label>
									<input type="date" class="form-control"  name="to_date" value="<?php echo @$to_date;?>" autocomplete="off" >
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
									<button class="submit-btn" type="submit" value="View"><i class="fa fa-paper-plane" aria-hidden="true"></i>Search</button>
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
									<th>Resolved</th>
									<th>AHT</th>
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

									<td><?php echo $token['is_resolved'] == '1' ? "Yes":"No"; ?></td>
									<td><?php echo $token['total_time']; ?></td>
									
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




