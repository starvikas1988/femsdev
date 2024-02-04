
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	
	#show{
		margin-top:5px;
	}
	
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
	.modal-dialog{
		width:800px;
	}
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Employee</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="" autocomplete="off">
							<div class="row">
								<div class="col-md-4"> 
									<div class="form-group">
										<label>Fusion Id</label>
										
										<input class="form-control" type="text" value="<?php if(isset($fusion_id)) { echo $fusion_id; } ?>" name="fusion_id" id="fusion_id" placeholder="Enter Fusion ID">
									</div>
								</div>
								
								<div class="col-md-12" style="margin-top:20px">
									<input name="search" class="btn btn-success waves-effect" type="submit" value="Search">
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
		<?php if(isset($searched)) { if(!empty($details['present'])){ ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Employee Details</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">


							<table style="margin-top: 10px;" id="" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>Name</th>
										<th>Fusion ID</th>
										<th>Designation</th>	
										<th>Department</th>
										<th>Process</th>
										<th>L1 Supervisor</th>
										<th>Current Gross Pay</th>
										<th>Last Payroll Update</th>
										<th>Last Appraisal Gross</th>
										<th>Last Appraisal</th>
										<th>Download</th>
									</tr>
								</thead>
								<tbody>
								<?php 

								// print_r($details);
								foreach($details['present'] as $token){ 	
								$user_id =$token['user_id'];							
								?>
								<tr>

									<td><?php echo $token['fullname']; ?></td>
									<td><?php echo $token['fusion_id']; ?></td>	
									<td><?php echo $token['role']; ?></td>							
									<td><?php echo $token['department']; ?></td>	
									<td><?php echo $token['process_name']; ?></td>	
									<td><?php echo $token['l1_super']; ?></td>
									<td><?php echo $token['gross_pay']; ?></td>
									<td><?php if($token['affected_from'] != "")echo date('d/m/Y', strtotime($token['affected_from'])); else echo "NA"; ?></td>
									<td><?php echo @$details['history'][0]['gross_pay']; ?></td>
									<td><?php if(@$details['history'][0]['affected_from'] != "")echo date('d/m/Y', strtotime(@$details['history'][0]['affected_from'])); else echo "NA"; ?></td>
									<td>
										<?php if(!empty($details['history'][0]['gross_pay'])){
											$appl_id = $details['history'][0]['id'];
											?>
											<a href='<?php echo base_url()."appraisal_employee/send_mail/Y/$appl_id" ?>' title='Download Appraisal Letter' class='btn btn-primary btn-xs'><i class='fa fa-download' aria-hidden='true'></i>
											</a>
										<?php }else echo "NA"; ?>
									</td>
								</tr>
								<?php } 
								
								/*
								if(!empty($details['history'][0]['gross_pay'])){
								foreach($details['history'] as $token){
								$user_id =$token['id'];
								?>	
								<tr>

									<td><?php echo $token['fullname']; ?></td>
									<td><?php echo $token['fusion_id']; ?></td>	
									<td><?php echo $token['role']; ?></td>							
									<td><?php echo $token['department']; ?></td>	
									<td><?php echo $token['process_name']; ?></td>	
									<td><?php echo $token['l1_super']; ?></td>
									<td><?php echo $token['gross_pay']; ?></td>
									<td><?php if($token['affected_from'] != "")echo date('d/m/Y', strtotime($token['affected_from'])); else echo "NA"; ?></td>
									<td>
										
									</td>
								</tr>
								<?php } }
									*/
								?>


								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<tr class='bg-info'>
										<th>Name</th>
										<th>Fusion ID</th>
										<th>Designation</th>	
										<th>Department</th>
										<th>Process</th>
										<th>L1 Supervisor</th>	
										<th>Current Gross Pay</th>
										<th>Last Payroll Update</th>
										<th>Last Appraisal Gross</th>
										<th>Last Appraisal</th>
										<th>Download</th>			
									</tr>
									</tr>
								</tfoot>
							</table>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Send Appraisal/Revision Mail</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form class="form_appr" autocomplete="off">
							<input type="hidden" name="user_id" id="user_id" value="<?php echo $details['present'][0]['id'] ?>">
							<div class="row">

								<div class="col-md-3"> 
									<div class="form-group">
										<label>Affected From</label>
										
										<input class="form-control" type="text" name="issu_date" id="issu_date" required="" value="<?php echo date('d/m/Y', strtotime(date(GetLocalDate()))); ?>">
									</div>
								</div>

								<div class="col-md-3"> 
									<div class="form-group">
										<label>Appraisal/Promotion/Revision</label>
										
										<select class="form-control" name="aprsl_type" id="aprsl_type" required="">
											<option value="">-- Select --</option>
											<option value="1">Promotion</option>
											<option value="3">Promotion with same CTC</option>
											<option value="2">Revision</option>
										</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label>Incentive Period</label>
										<select class="form-control" id="incentive_period" name="incentive_period" >
											<option value="">--Select--</option>
											<option <?php if($details['present'][0]['incentive_period'] == "Monthly") echo "selected"; ?> value="Monthly">Monthly</option>
											<!--<option <?php if($details['present'][0]['incentive_period'] == "Yearly") echo "selected"; ?> value="Yearly">Yearly</option>-->
										</select>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Incentive Amount</label>
										<input type="number" min="0" id="incentive_amt" name="incentive_amt" class="form-control" autocomplete="off" value="<?php echo $details['present'][0]['incentive_amt']; ?>">
									</div>
								</div>

								</div>
								<div class="row">
									
								<div class="col-md-4 prom" style="display: none;">
									<label for="role">Select a Designation</label>
									<select class="form-control" name="role_id" id="role_id" required style="width:100%;">
										<option value=''>-- Select a Designation --</option>
										<?php  foreach($role_list as $role):
												if($role->id == $details['present'][0]['role_id'])
													echo "<option value='".$role->id."' selected param='$role->org_role' >".$role->name."</option>";
												else
													echo "<option value='".$role->id."' param='$role->org_role' >".$role->name."</option>";
											endforeach;  ?>	
									</select>
								</div>
								<div class="col-md-4 prom" style="display: none;">
										<label for="assigned_to">Assign Level-1 Supervisor</label>
											<select class="form-control" name="assigned_to" id="assigned_to" style="width:100%;">
												<option value=''>-- Select Level-1 Supervisor --</option>
												<?php 
												// print_r($tl_list);
												 foreach($tl_list as $tl):
														 ?>

														<option <?php if($tl['id'] == $details['present'][0]['assigned_to']) echo "selected"; ?> value="<?php echo $tl['id'] ?>"><?php echo $tl['fullname'].' - '.$tl['fusion_id'].', '.$tl['dept_name']; ?></option>
													<?php endforeach;  ?>											
											</select>
									</div>
								<div class="col-md-4 prom" style="display: none;">	
									<div class="form-group">
										<label for="dept_id">Select  Employees' Department</label>
											<select class="form-control" name="dept_id" id="dept_id" required style="width:100%;">
												<option value=''>-- Select a Department --</option>
												<?php  foreach($department_list as $dept):
													if($dept['id'] == $details['present'][0]['dept_id'])
														echo "<option value='".$dept['id']."' selected>".$dept['description']."</option>";
													else
														echo "<option value='".$dept['id']."'>".$dept['description']."</option>";
												endforeach; ?>											
											</select>
									</div>
								</div>
							</div>
								<div class="row">
									<div class="row" id="check_payroll"> 	
										<div class="col-md-4">
											<div class="form-group">
												<label>Pay Type</label>
												<select class="form-control" id="pay_type" name="pay_type" required>
												<option value="">-Select-</option>
												<?php foreach($paytype as $tokenpay){ ?>
													<option <?php if($tokenpay['id'] == $details['present'][0]['payroll_type']) echo "selected"; ?> value="<?php echo $tokenpay['id']; ?>"><?php echo $tokenpay['name']; ?></option>
												<?php } ?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label>Currency</label>
												<select class="form-control" id="pay_currency" name="pay_currency" required>
												<option value="">-Select-</option>
												<?php foreach($mastercurrency as $mcr){
													
												$getcr = "";	
												$abbr_currency = $mcr['abbr'];
												if(in_array($myoffice_id, $setcurrency[$abbr_currency])){ $getcr = "selected"; }
												
												?>
													<option <?php if($mcr['abbr'] == $details['present'][0]['currency']) echo "selected"; ?> value="<?php echo $mcr['abbr']; ?>" <?php echo $getcr; ?>><?php echo $mcr['description']; ?> (<?php echo $mcr['abbr']; ?>)</option>
												<?php } ?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group" id="grossid">
												<label>Monthly Total Earning</label>
												<input type="text" id="gross_amount" name="gross_amount" class="form-control" onkeyup="checkDec(this);" autocomplete="off" required  value="<?php echo $details['present'][0]['gross_pay']; ?>">
											</div>	
										</div>
									</div>
								
								
								
								<div class="col-md-12" style="margin-top:20px">
									<input name="send" class="btn btn-success waves-effect" type="submit" value="Send">
								</div>

								</div>
							
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>



		



<?php  }else{ ?>
							<div class="col-md-12 text-center">
								<br><br>
								<h4 class="heading-white-title"><span class="text-danger">No Data Found</span></h4>
							<br>
							</div>
						<?php } } ?>
		
	</section>
</div>

