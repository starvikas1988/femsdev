<link rel="stylesheet" href="https://10.100.10.153/femsdev/assets/aifi/css/bootstrap-multiselect.css">
<script src="https://10.100.10.153/femsdev/assets/aifi/js/bootstrap-multiselect.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/jquery.dataTables.min.js"></script>



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
									<label>Transaction Start date :<span style="color:red;">*</span></label>
									<input type="date" class="form-control start_date"  onchange="date_validation(this.value,'S')" name="from_date" max="<?php echo $date ; ?>"  value="<?php echo ($from_date!='')?$from_date:'';?>" autocomplete="off" required >
									<span class="start_date_error" style="color:red";></span>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Transaction End date :<span style="color:red;">*</span></label> 
									<input type="date"  class="form-control end_date" onchange="date_validation(this.value,'E')"  name="to_date" max="<?php echo $date ; ?>"  value="<?php echo ($to_date!='')?$to_date:'';?>" autocomplete="off" required >
									<span class="end_date_error" style="color:red";></span>
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
										<select id="transaction_types" class="multi_select" name="transaction_types[]" autocomplete="off" placeholder="Transaction Type"  multiple>
										<?php
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
										<span class="transaction_type_error" style="color:red";></span>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Stores Name</label>
										<select class="multi_select" id="source" name="source[]" autocomplete="off" placeholder="Select Location"  multiple>
										<?php 
										foreach($stores_details as $token=>$s_type){
											$selection = "";
											if(in_array($s_type['id'],$source))	
											{ 
												$selection = "selected"; 
											}
											
										?>
										<option value="<?php echo $s_type['id']; ?>" <?php echo $selection; ?>><?php echo $s_type['stores_name']; ?></option>
										<?php } ?>	
										</select> 
										<span class="stores_type_error" style="color:red";></span>


									


									</div>
								</div>
								<div class="col-sm-2" >
									<div class="form-group">
										<label>Numbers</label>
										<select class="multi_select" id="s_number" name="s_number[]" autocomplete="off" placeholder="Select Number" required multiple>
										<?php 
										foreach($stores_number as $token=>$s_type){
											$selection = "";
											if(in_array($s_type['store_number'],$s_number))	
											{  
												$selection = "selected"; 
											}
											
										?>
										<option value="<?php echo $s_type['store_number']; ?>" <?php echo $selection; ?>><?php echo $s_type['store_number']; ?></option>
										<?php } ?>	
										</select> 
										<span class="stores_number_error" style="color:red";></span>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label>Resolved</label>
										<select class="resolved" name="is_resolved" autocomplete="off" placeholder="Dispostion List for Resolved">
											<option value="all" <?= ($resolved=="all")?"selected":""?>>Select All</option>
											<option value="1" <?= ($resolved=="1")?"selected":""?>>Closed</option>
											<option value="0" <?= ($resolved=="0")?"selected":""?>>No Action Required</option>
											<option value="2" <?= ($resolved=="2")?"selected":""?>>Pending</option>
										</select>
										<span class="resolved_error" style="color:red";></span>
									</div>
								</div>
								
								<div class="col-sm-2">
									<div class="form-group">
										<label>Fusion Id</label>
										<input type="text" class="form-control fusion_class" id="fusion_id" name="fusion_id" value="<?php echo $fusion_id; ?>">
										<span id="lblError" style="color:red";></span>
									</div>
								</div>
							<div class="col-sm-3">
								<div class="form-group">
									<button class="submit-btn search_btn" type="submit" id="search_condition_validate" name="view_report" value="View"><i class="fa fa-paper-plane" aria-hidden="true"></i>Search</button>
									
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<a class="btn btn-warning" style="margin: 22px;width: 183px;"  href="<?php echo base_url('aifi')?>/report"  ><i class="fa fa-paper-plane" aria-hidden="true"></i>Reset</a>
								</div>
							</div>
							</div>
						</form>
						<?php //if($search_time !=''){   ?>
						<!-- <center><span style="color:green;" class="search_value" > Search Date Time: <?php  //echo $search_time;   ?> </span></center> -->
						<?php  //} ?>
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
							<table id="example" class="table table-striped table-bordered">
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
									<th>Store</th>
									<th>Store Number</th>
									<th>Outbound Call</th>
									<th>Completed Cases</th>
									<th>Reason For Leaving</th>
									<th>Hat Link</th>
									<th>Search date with time</th>
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
									<td><?= $token['stores_name']?></td>
									<td><?= $token['store_number']?></td>
									<td><?php echo $token['outbound_call'] == '1' ? "Yes":"No"; ?></td>
									<td><?= $token['completed_cases']?></td>
									<td><?= $token['reason_for_leaving']?></td>
									<td><?= $token['hat_link']?></td>
									<td><?php echo date('Y-m-d H:i:s'); ?></td>

									
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
	// $(document).ready(function() {
	// 	$('#default-datatable').DataTable();
	// } );
</script>
