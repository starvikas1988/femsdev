<style>
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
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Shortlisted Candidate List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
					
						<!--<form id="form_new_user" method="GET" action="<?php //echo base_url('dfr'); ?>">-->
						<?php echo form_open('',array('method' => 'get')) ?>
						
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Location</label>
										<select class="form-control" name="office_id" id="foffice_id" >
											<?php
												if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if($loc['abbr']==$oValue) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
																					
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Requisition</label>
										<select class="form-control" name="requisition_id" id="requisition_id">
											<option value="">ALL</option>
											<?php foreach($get_requisition as $gr): ?>
											<?php
												$sRss="";
												if($gr['requisition_id']==$requisition_id) $sRss="selected";
											?>
												<option value="<?php echo $gr['requisition_id']; ?>" <?php echo $sRss; ?>><?php echo $gr['requisition_id']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
									
								<div class="col-md-1" style="margin-top:25px">
									<div class="form-group">
										<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>dfr" type="submit" id='btnView' name='btnView' value="View">View</button>
									</div>
								</div>
							</div>
							
						</form>	
					
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requision Code</th>
										<th>Last Qualification</th>
										<th>Candidate Name</th>
										<th>Gender</th>
										<th>Mobile</th>
										<th>Skill Set</th>
										<th>Total Exp.</th>
										<th>Attachment</th>
										<th>Status</th>
										<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
											<th>Action</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php
								$k=1;
								$m=1;
								foreach($candidate_shortlisted as $cd): 
								
								$r_id=$cd['r_id'];
								$c_id=$cd['can_id'];
								$c_status = $cd['candidate_status'];
								
								if($c_status=='P')	$cstatus="Pending";
								else if($c_status=='IP')	$cstatus="In Progress";
								else if($c_status=='SL')	$cstatus="Shortlisted";
								else if($c_status=='CS')	$cstatus="Selected";
								else if( $c_status=='E') $cstatus="Selected as Employee";
								else if($c_status=='R') $cstatus="Rejected";
								
								if($cd['requisition_status']=='CL'){
									$bold="style='font-weight:bold; color:red'";
								}else{
									$bold="";
								}
								
								if($cd['attachment']!='') $viewResume='View Resume';
								else $viewResume='';
							?>
							<tr>
								
								<td><?php echo $k++; ?></td>
								
								<td <?=$bold;?>><?php echo $cd['requisition_id']; ?></td>
								<td><?php echo $cd['last_qualification']; ?></td>
								<td><?php echo $cd['fname']." ".$cd['lname']; ?></td>
								<td><?php echo $cd['gender']; ?></td>
								<td><?php echo $cd['phone']; ?></td>
								<td><?php echo $cd['skill_set']; ?></td>
								<td><?php echo $cd['total_work_exp']; ?></td>
								<td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>"><?php echo $viewResume; ?></a></td>
								<td width="70px"><?php echo $cstatus; ?></td>
								
								<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
								<td width="210px">
									<?php	
										$sch_id=$cd['sch_id'];
										$interview_type=$cd['interview_type'];	
										$interview_site=$cd['location'];	//echo $interview_site;
										$requisition_id=$cd['requisition_id'];
										$filled_no_position=$cd['filled_no_position'];
										$req_no_position=$cd['req_no_position'];
										$department_id=$cd['department_id'];
										$role_id=$cd['role_id'];
										$sh_status=$cd['sh_status'];
										
										if($cd['department_id']==6){
											$req_no_position = ceil($req_no_position + (($req_no_position * 15)/100));
										}else{
											$req_no_position = $req_no_position;
										}
										
										$params=$cd['requisition_id']."#".$cd['fname']."#".$cd['lname']."#".$cd['hiring_source']."#".$cd['d_o_b']."#".$cd['email']."#".$cd['phone']."#".$cd['last_qualification']."#".$cd['skill_set']."#".$cd['total_work_exp']."#".$cd['country']."#".$cd['state']."#".$cd['city']."#".$cd['postcode']."#".$cd['address']."#".$cd['summary']."#".$cd['attachment']."#".$cd['gender'];
										
										$cparams=$cd['fname']."#".$cd['lname']."#".$cd['hiring_source']."#".$cd['d_o_b']."#".$cd['email']."#".$cd['phone']."#".$cd['department_id']."#".$cd['role_id']."#".$cd['d_o_j']."#".$cd['gender']."#".$cd['location']."#".$cd['requisition_id']."#".$cd['address']."#".$cd['country']."#".$cd['state']."#".$cd['city']."#".$cd['postcode'];
									
									if($c_id!=""){
										
										echo '<a class="btn btn-success btn-xs viewCandidate" href="'.base_url().'dfr/view_candidate_details/'.$c_id.'" target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Details" style="font-size:12px"><i class="fa fa-eye"></i></a>';
										
											echo '&nbsp &nbsp';
										
										//if($cd['requisition_status']!='CL'){
										
										if($c_status=='SL'){
											
											//if(get_dept_folder()=="hr" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="super" || get_global_access()==1){
												
											if($cd['requisition_status']!='CL'){
												
											if($req_no_position > $filled_no_position){
											
											// CHECK OFFICE ACCESS
											$pay_lock = 1;
											if(isDisablePayrollInfo($cd['location'])==false){ $pay_lock = 0; }
											
											
											echo '<a class="btn btn-success btn-xs candidateApproval" p_access="'.$pay_lock.'" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" org_role="'.$cd['org_role'].'" location_id="'.$cd['location'].'" title="Approval to Final Selection" style="font-size:12px"><i class="fa fa-check-square"></i></a>';
												echo '&nbsp';
											echo '<a class="btn btn-danger btn-xs candidateDecline" r_id="'.$r_id.'"  c_id="'.$c_id.'" c_status="'.$c_status.'" title="Cancel Shortlisted" style="font-size:12px"><i class="fa fa-close"></i></a>';	
											
											}else{
												echo "<span class='label label-info' style='font-size:12px; display:inline-block;'>Filled Position</span>";
												
												/* echo "&nbsp &nbsp";
										
												echo '<a class="btn btn-danger btn-xs shorlistedCandidateTransfer" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Transfer Candidate" style="font-size:12px" ><i class="fa fa-exchange"></i></a>'; */
											}
											
											}
											
											//}
										
										}
										
										//}else{
										
											/* echo "&nbsp &nbsp";
										
											echo '<a class="btn btn-danger btn-xs shorlistedCandidateTransfer" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Transfer Candidate" style="font-size:12px" ><i class="fa fa-exchange"></i></a>'; */
										
										//}
										
										echo "&nbsp &nbsp";
										
										if($c_status!='P'){
										
											echo '<a class="btn btn-xs candidateInterviewReport" href="'.base_url().'dfr/view_candidate_interview/'.$c_id.'"  target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Interview Report" style="font-size:12px; background-color:#EE8CE4;"><i class="fa fa-desktop"></i></a>';
										
										}
										
										echo "&nbsp &nbsp";
										
										echo '<a class="btn btn-danger btn-xs shorlistedCandidateTransfer" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Transfer Candidate" style="font-size:12px" ><i class="fa fa-exchange"></i></a>';
										
									}
									?>
								</td>
								<?php } ?>
							</tr>
							
							<?php endforeach; ?>
								</tbody>
								
							</table>
							
						</div>
					</div>
			
			
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>
	
</div><!-- .wrap -->

<!----------------------------------Candidate Final Approval------------------------------->

<div class="modal fade" id="approvalFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmApprovalFinalSelect" id="candidateSelectionForm" action="<?php echo base_url(); ?>dfr/candidate_final_approval" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Final Candidate Approval</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="location_id" name="location_id" value="">
			<input type="hidden" id="c_status" name="c_status" value="">
			<input type="hidden" id="org_role" name="org_role" value="">
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php 
							if(isIndiaLocation(get_user_office_id())==true )
							{
								echo '<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Date of Joining (dd/mm/yyyy)</label>';
							}else{
								  echo '<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Date of Joining (mm/dd/yyyy)</label>';
							  }
						?>
						<input type="text" id="doj" name="doj" class="form-control" autocomplete="off" required>
					</div>	
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label>Approval Comment</label>
						<textarea class="form-control" id="approved_comment" name="approved_comment" required></textarea>
					</div>
				</div>
			</div>	
				
				
				
			<div class="row" id="check_payroll"> 	
				<div class="col-md-6">
					<div class="form-group">
						<label>Pay Type</label>
						<select class="form-control" id="pay_type" name="pay_type" required>
						<option value="">-Select-</option>
						<?php foreach($paytype as $tokenpay){ ?>
							<option value="<?php echo $tokenpay['id']; ?>"><?php echo $tokenpay['name']; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group">
						<label>Currency</label>
						<select class="form-control" id="pay_currency" name="pay_currency" required>
						<option value="">-Select-</option>
						<?php foreach($mastercurrency as $mcr){
							
						$getcr = "";	
						$abbr_currency = $mcr['abbr'];
						if(in_array($myoffice_id, $setcurrency[$abbr_currency])){ $getcr = "selected"; }
						
						?>
							<option value="<?php echo $mcr['abbr']; ?>" <?php echo $getcr; ?>><?php echo $mcr['description']; ?> (<?php echo $mcr['abbr']; ?>)</option>
						<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="form-group" id="grossid">
						<label>Monthly Total Earning</label>
						<input type="text" id="gross_amount" name="gross_amount" class="form-control" onkeyup="checkDec(this);" autocomplete="off" required  >
					</div>	
				</div>
			</div>
			
			<div class="row" id="stop_payroll" style="display:none;">	
				<input name="pay_type" value="0" type="hidden">
				<input name="pay_currency" value="" type="hidden">
				<input name="gross_amount" value="0" type="hidden">
			</div>
			
			
			<div id='calcKOL' style="display:none">
			
			<table cellpadding='2' cellspacing="0" border='1' style='font-size:12px; text-align:center; width:100%'>
				<tr bgcolor="#A9A9A9">
					<th><strong>Salary Components</strong></th>
					<th><strong>Monthly</strong></th>
					<th><strong>Yearly</strong></th>		
				</tr>
				<tr>
					<td>Basic</td>
					<td><input type="text" id="basic" name="basic" class="form-control" readonly  >
					<td><input type="text" id="basicyr" name="basicyr" class="form-control" readonly  ></td>				
				</tr>
				<tr>
					<td>HRA</td>
					<td><input type="text" id="hra" name="hra" class="form-control" readonly  >
					<td><input type="text" id="hrayr" name="hrayr" class="form-control" readonly  ></td>				
				</tr>
				<tr>
					<td>Conveyance</td>
					<td><input type="text" id="conveyance" name="conveyance" class="form-control" readonly  >
					<td><input type="text" id="conveyanceyr" name="conveyanceyr" class="form-control" readonly  ></td>			
				</tr>
				<tr>
					<td>Other Allowance</td>
					<td><input type="text" id="allowance" name="allowance" class="form-control" readonly  >
					<td><input type="text" id="allowanceyr" name="allowanceyr" class="form-control" readonly  ></td>				
				</tr>
				<tr bgcolor="#D3D3D3">
					<td>TOTAL EARNING</td>
					<td><input type="text" id="tot_earning" name="tot_earning" class="form-control" readonly  >
					<td><input type="text" id="tot_earningyr" name="tot_earningyr" class="form-control" readonly  ></td>				
				</tr>
				<tr>
					<td>PF (Employer's)</td>
					<td><input type="text" id="pf_employers" name="pf_employers" class="form-control" readonly  >
					<td><input type="text" id="pf_employersyr" name="pf_employersyr" class="form-control" readonly  ></td>				
				</tr>
				<tr>
					<td>ESIC (Employer's)</td>
					<td><input type="text" id="esi_employers" name="esi_employers" class="form-control" readonly  >
					<td><input type="text" id="esi_employersyr" name="esi_employersyr" class="form-control" readonly  ></td>				
				</tr>
				<tr bgcolor="#D3D3D3">
					<td>CTC</td>
					<td><input type="text" id="ctc" name="ctc" class="form-control" readonly  >
					<input type="hidden" id="ctcchecker" name="ctcchecker" class="form-control" readonly>
					<input type="hidden" id="grosschecker" name="grosschecker" class="form-control" readonly  >					
					</td>
					<td><input type="text" id="ctcyr" name="ctcyr" class="form-control" readonly  ></td>				
				</tr>
				<tr>
					<td>P.Tax</td>
					<td><input type="text" id="ptax" name="ptax" class="form-control" readonly  >
					<td><input type="text" id="ptaxyr" name="ptaxyr" class="form-control" readonly  ></td>		
				</tr>
				<tr>
					<td>ESIC (Employee's)</td>
					<td><input type="text" id="esi_employees" name="esi_employees" class="form-control" readonly  >
					<td><input type="text" id="esi_employeesyr" name="esi_employeesyr" class="form-control" readonly  ></td>		
				</tr>
				<tr>
					<td>PF (Employee's)</td>
					<td><input type="text" id="pf_employees" name="pf_employees" class="form-control" readonly  >
					<input type="hidden" id="pf_employees2" name="pf_employees2" ></td>
					<td><input type="text" id="pf_employeesyr" name="pf_employeesyr" class="form-control" readonly  ></td>				
				</tr>
				<tr bgcolor="#D3D3D3">
					<td>Take Home</td>
					<td><input type="text" id="tk_home" name="tk_home" class="form-control" readonly  ></td>
					<td><input type="text" id="tk_homeyr" name="tk_homeyr" class="form-control" readonly  ></td>				
				</tr>
			</table>
		</div>
			
			
      </div>
	  
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="button" name="finalcheck" id='finalcheck' class="btn btn-primary" value="Save">
		<!--<input type="submit" name="submit" id='finalApproval' class="btn btn-primary" value="Save">-->
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>








<div class="modal fade" id="modalfinalchecknow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelFinal">Final Confirmation</h4>
      </div>
      <div id="modalfinalchecknowbody" class="modal-body">
	  </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="finalcheckedsubmit" class="btn btn-success">Submit</button>
      </div>
	</div>
   </div>
</div>





<!----------------------------------Decline Approval------------------------------->

<div class="modal fade" id="declineFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmDeclineFinalSelect" action="<?php echo base_url(); ?>dfr/candidate_final_decline" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancel Shortlisted Candidate</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="c_status" name="c_status" value="">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Cancel Comment</label>
						<textarea class="form-control" id="approved_comment" name="approved_comment" required></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" name="submit" id='declineApproval' class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!---------------Candidate Transfer-------------------->
<div class="modal fade" id="transferShortlistedCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmTransferShortlistedCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Candidate Transfer</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" class="form-control">
			<input type="hidden" id="c_id" name="c_id" class="form-control">
			<input type="hidden" id="c_status" name="c_status" class="form-control">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>List of Requisition</label>
						<select class="form-control" id="req_id" name="req_id">
							<option value="">-Select-</option>
							<option value="0">Pool</option>
							<?php foreach($getrequisition as $row){ ?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['req_desc']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row" style="margin-left:8px" id="req_details">
				
			</div>
			
			</br></br>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Transfer Comment</label>
						<textarea class="form-control" id="transfer_comment" name="transfer_comment"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" name="submit" class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>
