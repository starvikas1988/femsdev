<link rel="stylesheet" href="https://10.100.10.153/femsdev/assets/aifi/css/bootstrap-multiselect.css">
<script src="https://10.100.10.153/femsdev/assets/aifi/js/bootstrap-multiselect.js"></script>-



<?php  $date=date('Y-m-d');
//echo $date;die; ?>

<style type="text/css">
	div.dataTables_wrapper div.dataTables_paginate {
	    display: none!important;
	}
	div.dataTables_wrapper div.dataTables_info {
		display: none!important;
	}
</style>



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
									<input type="date" class="form-control" name="from_date" max="<?php echo $date ; ?>"  value="<?php echo ($from_date!='')?$from_date:'';?>" autocomplete="off" required >
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Transaction End date</label>
									<input type="date" class="form-control"  name="to_date" max="<?php echo $date ; ?>"  value="<?php echo ($to_date!='')?$to_date:'';?>" autocomplete="off" required >
								</div>
							</div>
							<!-- <div class="col-sm-3">
								<div class="form-group">
									<label>Flight Start Date</label>
									<input type="date" class="form-control" name="flight_from_date" value="<?php //echo ($flight_from_date!='')?$flight_from_date:'';?>" autocomplete="off" >
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Flight End Date</label>
									<input type="date" class="form-control"  name="flight_to_date" value="<?php //echo ($flight_to_date!='')?$flight_to_date:'';?>" autocomplete="off" >
								</div>
							</div> -->
							<div class="col-sm-3">
									<div class="form-group">
										<label>Transaction Type</label>
										<select id="transaction_types" class="multi_select" name="transaction_types[]" autocomplete="off" placeholder="Transaction Type" required multiple>
										<?php
											// echo "<option value=''>-- Select Transaction Type</option>";
											// if($transaction_types == 'all')
											// {
											// echo "<option value='all' selected> Select All</option>";
											// }
											// else{
											// echo "<option value='all'> Select All</option>";

											// }


											foreach($transaction_type as $token=>$t_type){
											$selection = "";
											// if($transaction_types == $token['id'] )
											if(in_array($t_type['id'],$transaction_types))	
											{ 
												$selection = "selected"; 
											}




										
										?>
										<option value="<?php echo $t_type['id']; ?>" <?php echo $selection; ?>><?php echo $t_type['trans_type_name']; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Source Name</label>
										<select class="multi_select" id="source" name="source[]" autocomplete="off" placeholder="Select Location" required multiple>
										<?php 
											// echo "<option value=''>-- Select Source</option>";
											// if($source == 'all')
											// {
											// echo "<option value='all' selected> Select All</option>";
											// }
											// else{
											// echo "<option value='all'> Select All</option>";

											// }

											$fixed_string="Vanila_Nano_00";
											for($i=1;$i<10;$i++){
												$selection = "";
												 if($source== $fixed_string.$i )
												 { $selection = "selected"; }
												?>
												<option value="<?php echo $fixed_string.$i; ?>"<?php echo $selection; ?> ><?php echo $fixed_string.$i; ?></option>
												<?php	
											}  
											
										?>
										</select> 


									


									</div>
								</div>
								<!-- <div class="col-sm-3">
									<div class="form-group">
										<label>Type - Email or Ticket</label>
										<select class="form-control" name="ticket_type">
											<option value="">-- SELECT --</option>
										</select>
									</div>
								</div> -->
								<div class="col-sm-3">
									<div class="form-group">
										<label>Resolved</label>
										<select class="multi_select" name="is_resolved[]" autocomplete="off" placeholder="Dispostion List for Resolved" required multiple>
											<option value="">-- SELECT --</option>
											<?php 
											// if($resolved == 'all')
											// {
											// echo "<option value='all' selected> Select All</option>";
											// }
											// else{
											// echo "<option value='all'> Select All</option>";

											// }
											?>
											<option value="1" <?= ($resolved=="1")?"selected":""?>>Closed</option>
											<option value="0" <?= ($resolved=="0")?"selected":""?>>No Action Required</option>
											<option value="2" <?= ($resolved=="2")?"selected":""?>>Pending</option>
										</select>
									</div>
								</div>
								<!-- <div class="col-sm-3">
									<div class="form-group">
										<label>Ticket ID</label>
										<input type="text" class="form-control" id="ticket_id" name="ticket_id" value="<?php //echo $ticket_id; ?>">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Flight Id</label>
										<input type="text" class="form-control" id="flight_id" name="flight_id" value="<?php //echo $flight_id; ?>">
									</div>
								</div> -->
								<div class="col-sm-3">
									<div class="form-group">
										<label>Fusion Id</label>
										<input type="text" class="form-control fusion_class" id="fusion_id" name="fusion_id" value="<?php echo $fusion_id; ?>">
										<span id="lblError" style="color:red";></span>
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
				<?php if(!empty($crm_list)){ ?>
					<a class="btn btn-success" href="<?php echo str_replace('report?', 'download_report?', $_SERVER['REQUEST_URI']); ?>">Download Report</a>
				<?php } ?>
				<div class="white-dash" style="height:600px;overflow:scroll;">
					<div class="table-widget">
						<div class="table-white">
							<table id="default-datatable" data-plugin="DataTable" class="datatables-table table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
								  <tr>
								 	<th>SL</th>
								  	<!-- <th>Type</th> -->
									<th>Transaction ID</th>
									<th>Date</th>
									<!-- <th>Ticket ID</th>
									<th>Flight Id</th>
									<th>Flight Date</th> -->
									<th>Transaction Type</th>
									<th>Agent Name</th>
									<th>Agent ID</th>
									<th>Status</th>
									<th>Hold Count</th>
									<th>TTT</th>
									<th>AHT</th>
									<th>Source</th>
									<th>Outbound Call</th>
									<th>Completed Cases</th>
									<th>Reason For Leaving</th>
									<th>Hat Link</th>
								  </tr>
								</thead>
								<tbody>
								<?php
								$cn = 1;
								foreach($crm_list as $token){
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<!-- <td><?php //echo $token['transaction_type'] == '1' ? "Ticket" : "Email"; ?></td> -->
									<td><?php echo $token['trans_unique_id']; ?></td>
									<td><b><?php echo date('d - m -Y -H:i:s', strtotime($token['trans_date'])); ?></b></td>
									<!-- <td><?php //echo $token['trans_ticket_id']; ?></td>
									<td><?php //echo $token['trans_flight_id']; ?></td>
									<td><b><?php //echo date('d -m- Y', strtotime($token['trans_flight_date'])); ?></b></td> -->
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
									<td><?= $token['completed_cases']?></td>
									<td><?= $token['reason_for_leaving']?></td>
									<td><?= $token['hat_link']?></td>

									
								</tr>
								<?php } ?>
								</tbody>
							</table>

							<?php if(!empty($crm_list)){ ?>
								<p><a href="<?php echo str_replace('/femsdev/aifi/', '', $_SERVER['REQUEST_URI']."&page=0"); ?>">1</a>
									<?php $i = 2; foreach ($links as $key => $value) {
										if($page == 1) $arra = array($page+1,$page+2,$page+3,$page+4);
										elseif($page == 0) $arra = array($page+2,$page+3,$page+4,$page+5);
										else $arra = array($page,$page+1,$page+2,$page+3);
										if(count($links) > 5 && in_array($i, $arra)){
											echo "<a href='$value'>$i</a>&nbsp";
										}elseif(count($links) < 5){
											echo "<a href='$value'>$i</a>&nbsp";
										}
									$i++;	
								}  ?></p>
							<?php } ?>

						</div>
					</div>
				</div>
			</div>
		</div>
</div>


<script>
$(document).ready(function() {
        $('.multi_select').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: true
        });
    }); 
</script>

<script>
	$(document).ready(function() {
		$('#default-datatable').DataTable();
	} );
</script>
