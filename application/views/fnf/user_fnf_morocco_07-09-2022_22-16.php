
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	
	#show{
		margin-top:5px;
	}
	input[type="checkbox"][readonly] {
	  pointer-events: none;
	}
	.imgView{
		display:block;
		margin-bottom:10px;
	}
</style>

<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
					<!--<form id="form_new_user" method="GET" action="<?php //echo base_url('dfr'); ?>">-->
						<?php echo form_open('',array('method' => 'get')) ?>
						
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Search By Location</label>
										<select class="form-control" name="office_id" id="foffice_id" >
											<?php
												//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if($loc['abbr']==$getOffice) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
																					
										</select>
									</div>
								</div>
									
								<div class="col-md-1" style="margin-top:25px">
									<div class="form-group">
										<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>fnf" type="submit" id='btnView' name='btnView' value="View">View</button>
									</div>
								</div>
							</div>
							
						</form>	
					</div>
				</div>
			</div>
		</div>
	
	<?php if(isAccessFNFHR_Morocco()==true){ ?>	
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">HR & Payroll FNF Checkpoint 
						<a href="<?php echo base_url('fnf'); ?>?office=<?php echo $getOffice; ?>&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a>		
						</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Name</th>
										<th>Fusion ID</th>
										<th>Office</th>
										<th>Resign/Term Date</th>
										<th>Release Date/LWD</th>
										<th>IT Checkpoint</th>
										<th>FNF Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 0; $confirmFNF = array();
								foreach($hr_checklist as $token){ 
									$cn++;		
									$isOpenFNFBtn=true;
									
									$fnfid=$token['id'];
									$user_id=$token['user_id'];
									
									// IT LOCAL
									$local_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>"; 
									if($token['it_local_status'] == 'C'){ $local_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Complete</span>"; }
									else $isOpenFNFBtn=false;
									
									$rnt_date=$token['resign_date'];
									if($rnt_date=="") $rnt_date=$token['terms_date'];
									
									$lwd_date=$token['dol'];
									if($lwd_date=="") $lwd_date=$token['accepted_released_date'];
									if($lwd_date=="") $lwd_date=$token['lwd'];
									
									$extrapar = $token['user_id'] ."#" .$token['resign_id'] ."#" .$token['id'] ."#" .$token['term_id'];
																											
								?>
								<tr>
									<td><?php echo $cn; ?></td>
									<td><?php echo $token['fullname']; ?></td>
									<td><?php echo $token['fusion_id']; ?></td>
									<td><?php echo $token['office_id']; ?></td>
									<td><?php echo $rnt_date; ?></td>
									<td><?php echo $lwd_date; ?></td>
									<td><?php echo $local_status; ?></td>
									<td><?php echo $token['fnf_status']; ?></td>
									<td>
										<?php if($isOpenFNFBtn==true){ 
												$confirmFNF[] = $fnfid;
										?>
											
											<button title='FNF Completion' fnfid="<?php echo $fnfid; ?>" type='button' extrapar="<?php echo $extrapar; ?>" ftype="1" class='complete_FNF_Morocco btn btn-danger btn-xs' style='font-size:10px'>Complete FNF</button>
																					
										<?php }else{ ?>
										
										<button title='Button will activate after FNF compilation' disabled fnfid="<?php echo $fnfid; ?>" type='button' class='complete_FNF_Morocco btn btn-danger btn-xs' style='font-size:10px'>Complete FNF</button>
										
										<?php } ?>									
														
									</td>
								</tr>
								<?php } ?>
								</tbody>
								
							</table>
							
							<input type="hidden" name="fnfAllHRCheck" value="<?php echo !empty($confirmFNF) ? implode(',', $confirmFNF) : ""; ?>">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<?php } ?>
		
		<?php if(isAccessFNFIT_Morocco()==true){ ?>	
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">IT Team Checkpoint
						<a href="<?php echo base_url('fnf/fnf_export_report_excel'); ?>?office=<?php echo $getOffice; ?>&type=1&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a></h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Name</th>
										<th>Fusion ID</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Office</th>
										<th>Resign/Term Date</th>
										<th>Release Date/ LWD</th>
										<th>FNF Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 0;
								foreach($it_list as $token){ 
										
									$cn++;
									$extrapar = $token['user_id'] ."#" .$token['resign_id'] ."#" .$token['id'] ."#" .$token['term_id'];
																		
									$ustatus = "<span class='text-danger font-weight-bold'>Pending</span>"; $classbtn = "danger"; 
									if($token['it_local_status'] == 'C'){ $ustatus = "<span class='text-success font-weight-bold'>Complete</span>"; $classbtn = "success"; }
									
									$rnt_date=$token['resign_date'];
									if($rnt_date=="") $rnt_date=$token['terms_date'];
									
									$lwd_date=$token['dol'];
									if($lwd_date=="") $lwd_date=$token['accepted_released_date'];
									if($lwd_date=="") $lwd_date=$token['lwd'];
									
									
								?>
								<tr>
									<td><?php echo $cn; ?></td>
									<td><?php echo $token['fullname']; ?></td>
									<td><?php echo $token['fusion_id']; ?></td>
									<td><?php echo $token['user_email']; ?></td>
									<td><?php echo $token['user_phone']; ?></td>
									<td><?php echo $token['office_id']; ?></td>
									<td><?php echo $rnt_date; ?></td>
									<td><?php echo $lwd_date; ?></td>
									<td><b><?php echo $ustatus; ?></b></td>
									<td>
									<button title='Submit FNF' type='button' extrapar="<?php echo $extrapar; ?>" ftype="1" class='btn btn-<?php echo $classbtn; ?> btn-xs editfnfITLocalTeamMorocco' style='font-size:12px'>
									<i class='fa fa-check-square'></i></button>									
									</td>
								</tr>
								<?php } ?>
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php } ?>
		
		
		
	
	</section>
</div>



<?php
//======================== LOCAL IT MODAL ===========================================//
?>
<div class="modal fade" id="fnfITLocalTeamMorocco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmITLocalTeamMorocco" id="frmITLocalTeamMorocco" onsubmit="return false" autocomplete="off" method='POST' enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">IT Team FNF Checkpoint</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" class="form-control" id="user_id" name="user_id">
			<input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
			<input type="hidden" class="form-control" id="resign_id" name="resign_id">
			<input type="hidden" class="form-control" id="f_type" name="f_type">
						
			<div class="row">
				<h4>Return Date of : </h4>
				<br/>
				
				<div class="col-md-12">
					<div class="form-group row">
					 <div class="col-md-12">
						<label>Portable PC</label>
                     </div>						
					</div>
					<div class="form-group row">
					<div class="col-md-3">
						<select class="form-control yesNoSelection" name="is_return_computer_date">
							<option value="">-- Select --</option>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
							<option value="N/A">Not Available</option>
						</select>
					</div>
					<div class="col-md-4">
						<input type="text" class="form-control datePicker" name="return_computer_date" placeholder="Enter Return Date">						
					</div>
					<div class="col-md-5">
					    <span class="imgView"></span>
						<input type="file" class="form-control" style="display:none" name="return_computer_date_file">					
					</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="form-group row">
					 <div class="col-md-12">
						<label>Headset</label>
                     </div>						
					</div>
					<div class="form-group row">
					<div class="col-md-3">
						<select class="form-control yesNoSelection" name="is_return_computer_headset">
							<option value="">-- Select --</option>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
							<option value="N/A">Not Available</option>
						</select>
					</div>
					<div class="col-md-4">
						<input type="text" class="form-control datePicker" name="return_computer_headset" placeholder="Enter Return Date">						
					</div>
					<div class="col-md-5">			
					</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="form-group row">
					 <div class="col-md-12">
						<label>Any Internet Box</label>
                     </div>						
					</div>
					<div class="form-group row">
					<div class="col-md-3">
						<select class="form-control yesNoSelection" name="is_return_computer_tools">
							<option value="">-- Select --</option>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
							<option value="N/A">Not Available</option>
						</select>
					</div>
					<div class="col-md-4">
						<input type="text" class="form-control datePicker" name="return_computer_tools" placeholder="Enter Return Date">						
					</div>
					<div class="col-md-5">					
					</div>
					</div>
				</div>
			</div>
			
			<hr/><br/>
			
			<div class="row">
				<h4>Disablement Date of : </h4>
				<br/>
				
				<div class="col-md-12">
					<div class="form-group row">
					 <div class="col-md-12">
						<label>Phone No/Fusion Email Address</label>
                     </div>						
					</div>
					<div class="form-group row">
					<div class="col-md-3">
						<select class="form-control yesNoSelection" name="is_disable_dialer_id">
							<option value="">-- Select --</option>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
							<option value="N/A">Not Available</option>
						</select>
					</div>
					<div class="col-md-4">
						<input type="text" class="form-control datePicker" name="disable_dialer_id" placeholder="Enter Disbalement Date">						
					</div>
					<div class="col-md-5">
					    <span class="imgView"></span>
						<input type="file" class="form-control"  style="display:none" name="disable_dialer_id_file">			
					</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="form-group row">
					 <div class="col-md-12">
						<label>Physical Access with Fingerprint</label>
                     </div>						
					</div>
					<div class="form-group row">
					<div class="col-md-3">
						<select class="form-control yesNoSelection" name="is_disable_crm_id">
							<option value="">-- Select --</option>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
							<option value="N/A">Not Available</option>
						</select>
					</div>
					<div class="col-md-4">
						<input type="text" class="form-control datePicker" name="disable_crm_id" placeholder="Enter Disbalement Date">						
					</div>
					<div class="col-md-5">
					    <span style="display:none" class="imgView"></span>
						<input type="file" class="form-control"  style="display:none" name="disable_crm_id_file">						
					</div>
					</div>
				</div>
			</div>			
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='fnfITLocalSaveMorocco' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>



<?php
//======================== HR PAYROLL TEAM ===========================================//
?>
<div class="modal fade" id="fnfPayrollTeamMorocco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmPayrollTeamMorocco" id="frmPayrollTeamMorocco" onsubmit="return false" method='POST' autocomplete="off" enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">HR & Payroll Team FNF</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" class="form-control" id="user_id" name="user_id">
			<input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
			<input type="hidden" class="form-control" id="resign_id" name="resign_id">
			<input type="hidden" class="form-control" id="f_type" name="f_type">
			
			<div class="row payrollTeamGrossMorocco">				
				<div class="col-md-12">
					<div class="form-group">										
						<label>Reason For Leaving</label>
						<textarea class="form-control" name="cas_reason_of_leaving" id="reason_of_leaving" required></textarea>
					</div>
				</div>				
				<div class="col-md-12">
					<div class="form-group">										
						<label>Resignation Notice</label>
						<textarea class="form-control" name="cas_resignation_notice" id="resignation_notice" required></textarea>
					</div>
				</div>				
				<hr/>				
				<div class="col-md-12">
					<div class="form-group">										
						<label>Current Mutual Insurance Reimbursements</label>
						<input class="form-control" name="cas_mutual_insurance" id="cas_mutual_insurance" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required>
					</div>
				</div>				
				<hr/>				
				<div class="col-md-6">
					<div class="form-group">										
						<label>Direct Debit of Salary</label>
						<input class="form-control" name="cas_salary_debit"  id="cas_salary_debit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required>
					</div>
				</div>				
				<div class="col-md-6">
					<div class="form-group">										
						<label>The Balance of all Accounts</label>
						<input class="form-control" name="cas_balance" id="cas_balance"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
					</div>
				</div>				
			</div>
			
			<hr/>
			
			<div class="row">
				<div class="col-md-12" >
					<div class="form-group">		
						<label for="name">HR File</label>					
						<input class="form-control" type="file" id="cas_hr_file" name="cas_hr_file">
						<span style="display:none" class="imgView"></span>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12" >
					<div class="form-group">		
						<label for="name">HR Final Comments</label>					
						<textarea class="form-control" row='6' id="cas_final_comments" name="cas_final_comments"></textarea>
					</div>
				</div>
			</div>
						
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='fnfPayrollTeamSaveMorocco' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>

