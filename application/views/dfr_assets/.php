<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<style>
	td{
		font-size:11px;
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
	
	.table {
		margin-bottom:8px;
	}	
	
	.skt-table td{
       padding: 2px;
	}
	
	.skt-table th{
       padding: 2px;
	}
	.body-widget {
		width:100%;
		float:left;
	}
	/*start custom design css here*/
	.small-icon {
		width: 20px;
		height: 20px;
		border-radius: 50%;
		padding: 0;
		margin:0 2px 0 2px;
		line-height: 19px;
	}
	.red-btn {
		width: 100px;
		padding: 10px;
		background: #f00;
		color: #fff;
		font-size: 13px;
		letter-spacing: 0.5px;
		transition: all 0.5s ease-in-out 0s;
		border: none;
		border-radius: 5px;
	}
	.red-btn:hover {
		background: #af0606;
		color: #fff;
	}
	.candidate-area {
		width:100%;
	}
	.candidate-area label {
		margin:10px 0 0 0;
	}
	.cloumns-bg {
		background: #eee;
		padding: 10px;
	}
	.cloumns-bg1 {
		background:#f5f5f5;
		padding: 10px;
	}
	.candt-btn {
		margin:0 10px 0 0;
	}
	/*end custom design css here*/
</style>

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">View Requisition <?php //echo $filled_pos; ?> <!-- dynamic filled position count --> </h4>
					</header>
					
						<div style="float:right; margin-top:-35px; margin-right:20px">
							<?php  $url = htmlspecialchars(@$_SERVER['HTTP_REFERER']); ?>
							<a class="btn btn-warning" href="<?php echo $url; ?>" title="" style=''>Back</a>
						</div>
					
					<hr class="widget-separator">
										
					<div class="widget-body">
					<?php 
					$requisition_id ="";
					$dfr_location="";
					foreach($view_reuisition as $row): 
					?>
					
						<?php
							$r_id=$row['id'];
							$requisition_id = $row['requisition_id'];
							$r_status=$row['requisition_status'];
							$deptid=$row['department_id'];
							$role_folder= $row['role_folder'];
							$company_brand=$row['company_brand'];
							$offc_location = $row['off_location'];
							$required_pos=$row['req_no_position'];
							//$filled_pos=$row['filled_no_position'];
							
							if($row['department_id']==6 && $role_folder=="agent"){
								$required_pos = ceil($required_pos + (($required_pos * 15)/100));
								$deptType="Buffer";
							}else{
								$required_pos = $required_pos;
								$deptType="";
							}
							
							//echo $required_pos;
						?>
					
						<?php
							if($row['employee_status']==1) $emp_status="Part Time";
							else $emp_status="Full Time";
						?>
						
						<?php
							$dfr_location=$row['location'];
							$site_id = '';
							if(!empty($row['site_id'])){
								$site_id = $row['site_id'];
							}
							$params=$row['location']."#".$row['dueDate']."#".$row['department_id']."#".$row['role_id']."#".$row['client_id']."#".$row['process_id']."#".$row['employee_status']."#".$row['req_qualification']."#".$row['req_exp_range']."#".$row['req_no_position']."#".$row['job_title']."#".$row['job_desc']."#".$row['req_skill']."#".$row['additional_info']."#".$row['req_type']."#".$row['proposed_date']."#".$row['company_brand']."#".$row['raised_name']."#".$row['raised_date']."#".$row['requisition_status']."#".$row['site_id'];
							
														
							
							//."#".$row['filled_no_position']
						?>
					
						<div class="table-responive table-bg">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<tr>
									<td class='bg-info'>Location</td>
									<td id="office_location"><?php echo $row['off_location']; ?></td>
									<td class='bg-info'>Company Brand</td>
									<td><?php echo $row['company_brand_name']; ?></td>
									<?php
										if(!empty($row['site_name'])){ ?>
											<td class='bg-info'>Site Name</td>
											<td><?php echo $row['site_name']; ?></td>
									<?php } ?>
								</tr>
								<tr>
									<td class='bg-info'>Requision Code</td>
									<td id="req_cod"><?php echo $row['requisition_id']; ?></td>
									<td class='bg-info'>Due Date</td>
									<td><?php echo $row['due_date']; ?></td>
									<td class='bg-info'>Raised By</td>
									<td><?php echo $row['raised_name']; ?></td>
									<td class='bg-info'>Raised Date</td>
									<td><?php echo date($row['raised_date']); ?></td>
								</tr>
								<tr>
									<td class='bg-info'>Department</td>
									<td><?php echo $row['department_name']; ?></td>
									<td class='bg-info'>Position</td>
									<td><?php echo $row['role_name']; ?></td>
									<td class='bg-info'>Client</td>
									<td><?php echo $row['client_name']; ?></td>
									<td class='bg-info'>Employee Status</td>
									<td><?php echo $emp_status; ?></td>
								</tr>
								<tr>
									<td class='bg-info'>Req. Qualification</td>
									<td><?php echo $row['req_qualification']; ?></td>
									<td class='bg-info'>Req Exp Range</td>
									<td><?php echo $row['req_exp_range']; ?></td>
									<td class='bg-info'>Req no of Position</td>
									<td><?php echo $row['req_no_position']; ?></td>
									<td class='bg-info'>Filled no of Position</td>
									<td><?php echo $filled_pos; ?></td>
								</tr>
								<tr>
									<td class='bg-info'>Batch No</td>
									<td colspan=''><?php echo $row['job_title']; ?></td>
									<td class='bg-info'>Type</td>
									<td colspan=''><?php echo $row['req_type']; ?></td>
									<td class='bg-info'>Status</td>
									<td colspan=''><?php echo $row['requisition_status']; ?></td>
								</tr>
								<tr>
									<td class='bg-info'>Job Desciption</td>
									<td colspan='7'><?php echo $row['job_desc']; ?></td>
								</tr>
								<tr>
									<td class='bg-info'>Req Skill</td>
									<td colspan='7'><?php echo $row['req_skill']; ?></td>
								</tr>
								<tr>
									<td class='bg-info'>Additional Info</td>
									<td colspan='7'><?php echo $row['additional_info']; ?></td>
								</tr>
							</table>
						</div>
						
						
						<?php $comp = $row['company_brand_name'];
						if(is_approve_requisition()==true || get_user_id() == 1){ 

							

							?>

								<div class="row">
								<?php if($r_status=='P'){ ?>
								
									<div class="col-md-6">
										<button title='' type='button' class='btn btn-primary approvalWfm' r_id='<?php echo $r_id;?>' deptid='<?php echo $deptid;?>' raisedby='<?php echo $row['raised_by'];?>' style='font-size:10px'>Approval Requisition</button>
										<button title='' type='button' class='btn btn-danger declineWfm' r_id='<?php echo $r_id;?>'  style='font-size:10px'>Decline Requisition</button>
									</div>
								<?php } 
									if(count($get_candidate_details)<=0){
								
								?>	
									<div class="col-md-6">
										<button title='' type='button' class='btn btn-success editRequisition' r_id='<?php echo $r_id;?>' params="<?php echo $params; ?>" requisition_id='<?php echo $requisition_id; ?>' style='font-size:10px'>Edit Requisition</button>
									</div>
								<?php } ?>	
									
								</div>
								
							<?php 
								 
							}elseif ($comp == "CSPL") { if(get_user_fusion_id() == "FCHA000263" || get_user_fusion_id() == "FCHA002093") { ?>

								<div class="row">
								<?php if($r_status=='P'){ ?>
								
									<div class="col-md-6">
										<button title='' type='button' class='btn btn-primary approvalWfm' r_id='<?php echo $r_id;?>' deptid='<?php echo $deptid;?>' raisedby='<?php echo $row['raised_by'];?>' style='font-size:10px'>Approval Requisition</button>
										<button title='' type='button' class='btn btn-danger declineWfm' r_id='<?php echo $r_id;?>'  style='font-size:10px'>Decline Requisition</button>
									</div>
								<?php } 
									if(count($get_candidate_details)<=0){
								
								?>	
									<div class="col-md-6">
										<button title='' type='button' class='btn btn-success editRequisition' r_id='<?php echo $r_id;?>' params="<?php echo $params; ?>" requisition_id='<?php echo $requisition_id; ?>' style='font-size:10px'>Edit Requisition</button>
									</div>
								<?php } ?>	
									
								</div>

							<?php }	}			
							$r_status=$row['requisition_status'];
							
							?>	

								
													
						
					<?php endforeach; ?>	
					</div>
					
				</div>
			</div>	
		</div>
		
	


<div class="common-top">
<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Candidate List</h4>
			</header>
			<hr class="widget-separator">
			
			<div class="row" style="float:right; margin-top:-34px; margin-right:20px">
				<div >
				<?php
				if($r_status=='A'){
					
					if( is_access_dfr_module()==1 || get_dept_folder()=="hr" || $is_global_access==1){
						
						if($required_pos > $filled_pos){
							
							if(is_block_add_candidate_requisition($requisition_id)==false){
								
								echo "<button title='' type='button' class='btn btn-primary candt-btn sendBasicLink' offc_location='$offc_location' r_id='$r_id' requisition_id='$requisition_id' company_brand='$company_brand'  style=''>Send Link to Candidate </button>";
								
								echo "<button title='' type='button' class='btn btn-primary addCandidate' r_id='$r_id' requisition_id='$requisition_id' company_brand='$company_brand' style=''>Add Candidate</button>";
								
								
							}else{
								
								echo "<button type='button' class='btn btn-default ' title='Disabled as per WFM request. For enable please contact WFM' style='font-size:10px'>Send Link to Candidate</button>";
								
								echo "<button type='button' class='btn btn-default ' title='Disabled as per WFM request. For enable please contact WFM' style='font-size:10px'>Add Candidate</button>";
								
							}
							
						}
					}
					
					
				}
				?>
				</div>
			</div>
			
			<div class="widget-body">
				<div class="table-responsive table-bg table-small">
					<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
						<thead>
							<tr class='bg-info'>
								<th></th>
								<th>SL</th>
								<!-- <th>Requision Code</th> -->
								<th>Candidate Name</th>
								<th>Last Qualification</th>
								<th>Gender</th>
								<th>Mobile</th>
								<th>Skill Set</th>
								<th>Total Exp.</th>
								<th>Attachment</th>
								<th>Rehire</th>
								<th>Comments</th>
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
								foreach($get_candidate_details as $cd): 
								
								$r_id=$cd['r_id'];
								$c_id=$cd['can_id'];
								$c_status = $cd['candidate_status'];
								$gross_pay = $cd['gross_pay'];
								
								if($c_status=='P')	$cstatus="Pending";
								else if($c_status=='IP')	$cstatus="In Progress";
								else if($c_status=='SL')	$cstatus="Shortlisted";
								else if($c_status=='CS')	$cstatus="Selected";
								else if( $c_status=='E') $cstatus="Selected as Employee";
								else if($c_status=='R') $cstatus="Rejected";
								else if($c_status=='D') $cstatus="Dropped";
								
								if($cd['attachment']!='') $viewResume='View Resume';
								else $viewResume='';
								
								if($c_status=='CS'){
									$bold="style='font-weight:bold; color:#041ad3'";
								}else if($c_status=='E'){
									$bold="style='font-weight:bold; color:#013220'";
								}else if($c_status=='R'){
									$bold="style='font-weight:bold; color:red'";
								}else{
									$bold="";
								}
								
								
								if($r_status=='CL'){
									$bold="style='font-weight:bold; color:red'";
								}else{
									$bold="";
								}
								
								
							?>
							<tr>
								
								<td>
								<?php //if($cid!=""){ 
									$interview_evalution_form=$cd['interview_evalution_form'];
									?>
									<button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#<?php echo $c_id; ?>" title="" onclick="get_user_data('<?php echo $c_id; ?>','<?php echo $dfr_location;?>','<?php echo $r_status;?>','<?php echo $c_status;?>','<?php echo $required_pos;?>','<?php echo $filled_pos;?>','<?php echo $r_id;?>','<?php echo $interview_evalution_form;?>')"><i class="fa fa-plus"></i></button>
								<?php //} ?>	 
								</td>
								
								<td><?php echo $k++; ?></td>
								
								<!-- <td <?=$bold;?>><?php echo $cd['requisition_id']; ?></td> -->
								<td <?=$bold;?>><?php echo $cd['fname']." ".$cd['lname']; ?></td>
								<td><?php echo $cd['last_qualification']; ?></td>
								<td><?php echo $cd['gender']; ?></td>
								<td><?php echo $cd['phone']; ?></td>
								<td><?php echo $cd['skill_set']; ?></td>
								<td><?php echo $cd['total_work_exp']; ?></td>
								<td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>"><?php echo $viewResume; ?></a></td>
								<td><?php echo $cd['rehire']=='Y' ? 'Yes':''; ?></td>
								<td><?php echo $cd['rehire']=='Y' ? $cd['comments']:''; ?></td>
								<td width="100px" <?=$bold;?> ><?php echo $cstatus; ?></td>
								
								<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
								<td width="310px">
								<?php	
								
									//$sch_id=$cd['sch_id'];
									//$interview_type=$cd['interview_type'];	
									//$requisition_id=$cd['requisition_id'];
									//$filled_no_position=$cd['filled_no_position'];
									
									$interview_site=$cd['location'];	//echo $interview_site;
									$req_no_position=$cd['req_no_position'];
									$department_id=$cd['department_id'];
									$role_id=$cd['role_id'];
									//$sh_status=$cd['sh_status']; 
									
									if(isIndiaLocation($cd['location'])==true )
									{
										$dob =	date('d/m/Y',strtotime($cd['dob']));
										$doj =  date('d/m/Y',strtotime($cd['doj']));
										$married_date =  date('d/m/Y',strtotime($cd['married_date']));
									}
									else
									{
										$dob =	date('m/d/Y',strtotime($cd['dob']));
										$doj =  date('m/d/Y',strtotime($cd['doj']));
										$married_date =  date('m/d/Y',strtotime($cd['married_date']));
									}
									
									if( strtoupper($cd['married'])=='YES') $married="Married";
									else $married="UnMarried";


									$site_id = '';
									if(!empty($cd['site_id'])){
										$site_id = $cd['site_id'];
									}							
									$params=$cd['requisition_id']."#".$cd['fname']."#".$cd['lname']."#".$cd['hiring_source']."#".$dob."#".$cd['email']."#".$cd['phone']."#".$cd['last_qualification']."#".$cd['skill_set']."#".$cd['total_work_exp']."#".$cd['country']."#".$cd['state']."#".$cd['city']."#".$cd['postcode']."#".$cd['address']."#".$cd['summary']."#".$cd['attachment']."#".$cd['gender']."#".$cd['ref_name']."#".$cd['guardian_name']."#".$cd['onboarding_type']."#".$cd['company']."#".$cd['relation_guardian']."#".$cd['location'].'#'.$site_id;
									
									
									// $cparams=$cd['fname']."(#)".$cd['lname']."(#)".$cd['hiring_source']."(#)".$dob."(#)".$cd['email']."(#)".$cd['phone']."(#)".$cd['department_id']."(#)".$cd['role_id']."(#)".$doj."(#)".$cd['gender']."(#)".$cd['location']."(#)".$cd['job_title']."(#)".$cd['address']."(#)".$cd['country']."(#)".$cd['state']."(#)".$cd['city']."(#)".$cd['postcode']."(#)".$cd['client_id']."(#)".$cd['process_id']."(#)".$cd['org_role']."(#)".$cd['gross_pay']."(#)".$cd['pay_type']."(#)".$cd['currency']."(#)".$cd['l1_supervisor']."(#)".$cd['adhar']."(#)".$cd['pan']."(#)".$cd['guardian_name']."(#)".$cd['relation_guardian']."(#)".$cd['caste']."(#)".$married."(#)".$married_date;
									$cparams=$cd['fname']."(#)".$cd['lname']."(#)".$cd['hiring_source']."(#)".$dob."(#)".$cd['email']."(#)".$cd['phone']."(#)".$cd['department_id']."(#)".$cd['role_id']."(#)".$doj."(#)".$cd['gender']."(#)".$cd['location']."(#)".$cd['job_title']."(#)".str_replace('"','',str_replace('\\', '', $cd['address']))."(#)".$cd['country']."(#)".$cd['state']."(#)".$cd['city']."(#)".$cd['postcode']."(#)".$cd['client_id']."(#)".$cd['process_id']."(#)".$cd['org_role']."(#)".$cd['gross_pay']."(#)".$cd['pay_type']."(#)".$cd['currency']."(#)".$cd['l1_supervisor']."(#)".$cd['adhar']."(#)".$cd['pan']."(#)".$cd['guardian_name']."(#)".$cd['relation_guardian']."(#)".$cd['caste']."(#)".$married."(#)".$married_date."(#)".$cd['attachment_bank']."(#)".$cd['bank_name']."(#)".$cd['branch_name']."(#)".$cd['bank_acc_no']."(#)".$cd['ifsc_code']."(#)".$cd['acc_type'];
									// print_r($cd);
									// exit;
									
									
									//adhar, pan, guardian_name, relation_guardian , married, married_date
									
									$doc_verify_name = $cd['doc_verify_name'];
									$doc_verify_on = $cd['doc_verify_on'];
									$is_verify_doc = $cd['is_verify_doc'];
												
								///////////
									if($c_id!=""){
										
										echo '<a class="btn btn-success btn-xs small-icon viewCandidate" href="'.base_url().'dfr/view_candidate_details/'.$c_id.'" target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Details" style="font-size:12px"><i class="fa fa-eye"></i></a>';
											
										echo '';
										
										if(is_block_add_candidate_requisition($requisition_id)==false){
											if($c_status!='E' && $r_status=='A'){
												echo "<a class='btn btn-info small-icon btn-xs ' href='".base_url().'dfr/resend_basic_link?r_id='.$r_id.'&c_id='.$c_id. "' title='Click to resend apply link'><i class='fa fa-envelope' aria-hidden='true'></i></a>";
												echo '';
											}
										}
										
										if($r_status=='A' && $c_status!='E'){ ////Approve Requisition & not Fusion Employee
											
											
											if($c_status!='R' && $c_status!='CS'){
											
											//if(is_access_dfr_module()==1){
											
												if($required_pos > $filled_pos){
													
												if($c_status!='E'){
												
												echo '<a class="btn btn-warning small-icon btn-xs editCandidate" c_id="'.$c_id.'" r_id="'.$r_id.'" params="'.$params.'" title="Click to Edit Candidate" style="font-size:12px"><i class="fa fa-pencil-square-o"></i></a>';
													echo '';
												
												
												
												echo '<a class="btn btn-primary small-icon btn-xs addExperience" title="Add Candidate Experience"  r_id="'.$r_id.'"  c_id="'.$c_id.'"  style="font-size:12px" ><i class="fa fa-industry"></i></a>';
													echo '';
												echo '<a class="btn btn-primary small-icon btn-xs addQualification" title="Add Candidate Qualification"  r_id="'.$r_id.'"  c_id="'.$c_id.'" style="font-size:12px" ><i class="fa fa-graduation-cap"></i></a>';
													echo '';
												
												}
											
												}
											
											//}		
											
											}

											if($c_status=='P' || $c_status=='IP'){
												
												if($required_pos > $filled_pos){
												
													//if(is_access_dfr_module()==1){	
												
													echo '<a class="btn btn-success small-icon btn-xs scheduleCandidate" title="Schedule Interview"  r_id="'.$r_id.'"  c_id="'.$c_id.'" hiring_department="'.$department_id.'" interview_site="'.$interview_site.'"  style="font-size:12px" ><i class="fa fa-calendar-check-o"></i></a>';
													echo '';
																										
													if($c_status!='P'){
														if(candidate_total_schedule($c_id) > 0 && candidate_has_pending_sch($c_id)=="0"){
														
															echo '<a class="btn btn-xs small-icon candidateSelectInterview" style="background-color:#EB952D" title="Candidate Final Status"  r_id="'.$r_id.'"  c_id="'.$c_id.'" style="font-size:12px" ><i class="fa fa-user-secret"></i></a>';
															
														}else{
															if(candidate_has_pending_sch($c_id)=="0"){
																echo '<a class="btn btn-danger small-icon btn-xs candidateNotSelectInterview" r_id="'.$r_id.'"  c_id="'.$c_id.'" title="Reject Candidate" style="font-size:12px"><i class="fa fa-close"></i></a>';
															}
														}
													}
												
													
												
												
												}
																						
											}else if($c_status=='SL'){
												
												//if(is_access_dfr_module()==1){  /* $is_role_dir=="manager" */
													
												if($required_pos > $filled_pos){	
																								
												// CHECK OFFICE ACCESS
												$pay_lock = 1;
												if(isDisablePayrollInfo($cd['location'])==false){ $pay_lock = 0; }
												
													
											echo '<a class="btn btn-success btn-xs small-icon candidateApproval" p_access="'.$pay_lock.'" r_id="'.$r_id.'" c_id="'.$c_id.'" req_id="'.$requisition_id.'"  c_status="'.$c_status.'" org_role="'.$cd['org_role'].'" gender="'.$cd['gender'].'" location_id="'.$cd['location'].'" brand_id="'.$cd['company'].'" title="Approval to Final Selection" style="font-size:12px"><i class="fa fa-check-square"></i></a>';
													echo '';
												echo '<a class="btn btn-danger small-icon btn-xs candidateDecline" r_id="'.$r_id.'"  c_id="'.$c_id.'" c_status="'.$c_status.'" title="Decline Approval" style="font-size:12px"><i class="fa fa-close"></i></a>';
											
												}
												
												//}
											
													echo '';
												if($cd['location']=='CHA'){
													
													
													if($cd['joining_kit']==''){
														echo '<a class="btn btn-success small-icon btn-xs " href="'.base_url().'dfr/download_joining_kit?c_id='.$c_id.'&r_id='.$r_id.'" title="Click to Download Joining Kit" style="font-size:12px;background-color:yellow;"><i class="fa fa-download"></i></a>';
											
													   echo '';
													   // href="'.base_url().'dfr/upload_joining_kit?c_id='.$c_id.'&r_id='.$r_id.'"
													   echo '<a class="btn btn-success small-icon btn-xs upload_joining"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to Upload Joining Kit" style="font-size:12px;background-color:orange;"><i class="fa fa-upload"></i></a>';
											
													   echo '';
													 }
													 else
													 {
													 	echo '<a class="btn btn-success small-icon btn-xs " href="'.base_url().'uploads/joining_kit/'.$cd['joining_kit'].'" title="Click to Download Joining Kit" style="font-size:12px;" target="_blank"><i class="fa fa-download"></i></a>';
													 }


												}
											
											}else if($c_status=='CS'){
																									
												if(get_dept_folder()=="hr" || get_global_access()== 1 ){
													
													echo '<a class="btn btn-success btn-xs small-icon viewOfferLetter" href="'.base_url().'dfr/candidate_offer_pdf/'.$c_id.'/Y" target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Offer Letter " style="font-size:12px";background-color:#800080;"><i class="fa fa-file-pdf-o"></i></a>';
													
													echo '';
													
													echo '<a class="btn btn-success small-icon btn-xs " href="'.base_url().'dfr/resend_offer_letter?c_id='.$c_id.'&r_id='.$r_id.'" title="Click to Resend Offer Letter " style="font-size:12px"><i class="fa fa-envelope"></i></a>';
													
													echo '';
													echo '<a class="btn btn-primary small-icon btn-xs " href="'.base_url().'dfr/resend_doc_link?c_id='.$c_id.'&requisition_id='.$requisition_id.'&r_id='.$r_id.'" title="Click to Resend Document Upload Link" style="font-size:12px"><i class="fa fa-envelope"></i></a>';
													
													echo '';
													if($cd['location']=='CHA'){
														if($cd['loi']==''){
															echo '<a class="btn small-icon btn-primary btn-xs " href="'.base_url().'dfr/download_loi?c_id='.$c_id.'&requisition_id='.$requisition_id.'&r_id='.$r_id.'" title="Click to Download LOI" style="font-size:12px;background-color:#FFFF00;"><i class="fa fa-download"></i></a>';
															
															echo '';
															echo '<a class="btn btn-primary btn-xs upload_loi" r_id="'.$r_id.'"  c_id="'.$c_id.'" title="Click to  Upload LOI" style="font-size:12px;background-color:#eea236;"><i class="fa fa-upload"></i></a>';
															
															echo '';
														}
														else
														{
															echo '<a class="btn btn-primary small-icon btn-xs " href="'.base_url().'uploads/loifrom/'.$cd['loi'].'" title="Click to Download LOI" target="_blank" style="font-size:12px"><i class="fa fa-download"></i></a>';
														}	

													}
												}
												
												
												
												if ($cd['attachment_adhar'] !="" ) {
												
													if($is_verify_doc==0){
														echo '<a class="btn btn-success small-icon btn-xs VerifyDocuments" rel="'.base_url().'dfr/view_uploaded_docs?c_id='.$c_id.'&requisition_id='.$requisition_id.'" target="_blank"  is_verify="'.$is_verify_doc.'" c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Documents & Verify" style="font-size:12px"><i class="fa fa-info"></i></a>';
														echo '';
													}else{
														
														echo '<a class="btn btn-default small-icon btn-xs VerifyDocuments" rel="'.base_url().'dfr/view_uploaded_docs?c_id='.$c_id.'&requisition_id='.$requisition_id.'" target="_blank"  is_verify="'.$is_verify_doc.'" c_id="'.$c_id.'" r_id="'.$r_id.'" title="Already Documents Verified by ' . $doc_verify_name .' on '. $doc_verify_on .'" style="font-size:12px"><i class="fa fa-info"></i></a>';
														
														echo '';
														
													}
												}
												
												
												
													
												if($required_pos > $filled_pos){
													
													$pay_lock = 1;
													if(isDisablePayrollInfo($cd['location'])==false){ $pay_lock = 0; }
													
													if(!empty($cd['l1_supervisor'])){
														
														//echo '<a class="btn btn-primary btn-xs finalSelection" p_access="'.$pay_lock.'" r_id="'.$r_id.'" c_id="'.$c_id.'" cparams="'.$cparams.'" title="" style="font-size:12px" >Add as Employee</a>';
														//echo "&nbsp &nbsp";
																												
														if(isIndiaLocation($dfr_location)==true ){
																														
															if ($cd['attachment_adhar'] !="" && $cd['is_verify_doc']==1 ) {
																echo '<a class="btn btn-primary btn-xs finalSelection" p_access="'.$pay_lock.'" r_id="'.$r_id.'" c_id="'.$c_id.'" cparams="'.$cparams.'" title="" style="font-size:12px" >Add as Employee</a>';
														
																echo '';
															}
															else{
																echo '<a class="btn btn-default btn-xs " p_access="'.$pay_lock.'" r_id="'.$r_id.'" c_id="'.$c_id.'" cparams="'.$cparams.'" title="Document Not Upload OR Verified"  style="font-size:12px" >Add as Employee</a>';
															
																echo '';
															}
															
																
														}else{
															
															echo '<a class="btn btn-primary small-icon btn-xs finalSelection" p_access="'.$pay_lock.'" r_id="'.$r_id.'" c_id="'.$c_id.'" cparams="'.$cparams.'" title="" style="font-size:12px" >Add as Employee</a>';
															echo '';
															
														}
														
													} else {
														
														echo '<a class="btn btn-xs" onclick="alert(\'L1 Supervisor Not Assigned!\')" style="background-color:#ccc;color:#fff" title="Disabled" style="font-size:12px" >Add as Employee</a>';
														echo "";
														
													}
													
													//echo '<a class="btn btn-danger btn-xs candidateDecline" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Decline Adding Employee" style="font-size:12px" ><i class="fa fa-user-times"></i></a>';
													
												}
													
												
												
												
											}else{
												echo '<span class="label label-danger" style="font-size:12px"><b>Rejected</b></span>';
													echo "&nbsp &nbsp";
												
												//echo '<a class="btn btn-warning btn-xs rescheduleCandidate" r_id="'.$r_id.'"  c_id="'.$c_id.'" c_status="'.$c_status.'" title="Re-Schedule Candidate" style="font-size:12px"><i class="fa fa-street-view"></i></a>';
											}
											
											echo "";
											
											if($c_status!='P'){
											
												echo '<a class="btn small-icon btn-xs candidateInterviewReport" href="'.base_url().'dfr/view_candidate_interview/'.$c_id.'"  target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Interview Report" style="font-size:12px; background-color:#EE8CE4;"><i class="fa fa-desktop"></i></a>';
											
											}
											
											
									
									/////////Approve Requisition & Fusion Employee/////	
									}else {
										
										if($c_status=='E'){
											
											echo "<span class='label label-info' style='font-size:12px; display:inline-block;'>Empolyee</span>";

											echo '<a class="btn btn-success small-icon btn-xs employee_assets" target="_blank" c_id="'.$c_id.'" title="Empolyee Assets" style="font-size:12px"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
											
											if(get_dept_folder()=="hr" || get_global_access()== 1 ){
																								
												
												if($gross_pay>0 ){
													echo '<a class="btn btn-success btn-xs small-icon viewOfferLetter" href="'.base_url().'dfr/candidate_offer_pdf/'.$c_id.'/Y" target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Offer Letter " style="font-size:12px";background-color:#800080;"><i class="fa fa-file-pdf-o"></i></a>';
													
													echo '';
													
													echo '<a class="btn btn-primary small-icon btn-xs " href="'.base_url().'dfr/resend_offer_letter?c_id='.$c_id.'&r_id='.$r_id.'" title="Click to Resend Offer Letter" style="font-size:12px"><i class="fa fa-envelope"></i></a>';
											
													echo '';
													
												}
												
												
												echo '<a class="btn btn-default small-icon btn-xs VerifyDocuments" rel="'.base_url().'dfr/view_uploaded_docs?c_id='.$c_id.'&requisition_id='.$requisition_id.'" target="_blank"  is_verify="'.$is_verify_doc.'" c_id="'.$c_id.'" r_id="'.$r_id.'" title="Already Documents Verified by ' . $doc_verify_name .' on '. $doc_verify_on .'" style="font-size:12px"><i class="fa fa-info"></i></a>';
														
												echo '';
														
												
												//echo '<a class="btn btn-success btn-xs " href="'.base_url().'dfr/resend_doc_link?c_id='.$c_id.'&requisition_id='.$requisition_id.'&r_id='.$r_id.'" title="Click to Resend Document Upload Link" style="font-size:12px"><i class="fa fa-envelope"></i></a>';
										
											}
											
										}
									
									}
									
									if(($filled_pos>=$required_pos) && $c_status!='E'){
										echo "";
										
										echo '<a class="btn btn-danger btn-xs small-icon selectedCandidateTransfer" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Transfer Candidate" style="font-size:12px" ><i class="fa fa-exchange"></i></a>';
									}
									
								}
									
								
									
									
									?>

								</td>
						<?php } ?>
								
							</tr>
							
							<tr id="<?php echo $c_id; ?>" class="collapse">
								<td colspan="20" style="background-color:#EEE;text-align: center;">	  <div style="text-align:center;font-size:18px;color:#000;">
									Wait for Data
								   </div>	
								</td>
							</tr>
							<!---end of code---->
							
							<?php endforeach; ?>
						</tbody>
						
					</table>
					
				</div>
			</div>
			
		</div>
	</div>	
</div>
</div>


</section>	
	
</div>	



<!---------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------>

<!-------------------- Edit Requisition model ----------------------------->
<div class="modal fade modal-design" id="editRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	  
	<form class="frmEditRequisition" action="<?php echo base_url(); ?>dfr/edit_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Requisition</h4>
      </div>
      <div class="modal-body">
	  
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="requisition_id" name="requisition_id" value="">
			
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Location</label>
							<select class="form-control" id="location" name="location" required>
								<option value="">--Select--</option>
								<?php foreach($location_data as $row): ?>
								<option value="<?php echo $row['abbr']; ?>"><?php echo $row['location']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Department</label>
							<select class="form-control" id="department_id" name="department_id" required>
								<option value="">--Select--</option>
								<?php foreach($get_department_data as $department): ?>
								<option value="<?php echo $department['id']; ?>"><?php echo $department['shname']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Requisition Type</label>
							<select class="form-control" id="req_type" name="req_type" required>
								<option value="">--Select--</option>
								<option value="Growth">Growth</option>
								<option value="Attrition">Attrition</option>
							</select>
						</div>	
					</div>
					
				</div>
				
				<div class="row">
			
				
				<?php if(get_dept_folder()=="wfm"){ ?>
						<div class="col-md-4">
							<div class="form-group">
								<label>Due Date</label>
								<input type="text" class="form-control" id="due_date1" name="due_date" required autocomplete="off">
							</div>	
						</div>
					<?php }else{ ?>
						<div class="col-md-4">
							<div class="form-group">
								<label>Due Date</label>
								<input type="text" class="form-control" id="due_date_edit" name="due_date" value="" readonly>
							</div>	
						</div>
					<?php } ?>
				
					<div class="col-md-4" id='proposed_date_edit_col'>
						<div class="form-group">
							<label>Proposed New Date</label>
							<input type="date"  id="proposed_date_edit" name="proposed_date_edit" class="form-control" readonly >
						</div>	
						</div>
				
					<div class="col-md-4">
						<div class="form-group">
							<label>Company Brand</label>
							<select id="company_brand" name="company_brand" class="form-control" required>
								<option value="">-- Select Brand --</option>
								<?php foreach ($company_list as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
			</div>
			
				<div class="row">
				
										
					<div class="col-md-4">
						<div class="form-group">
							<label>Position</label>
							<select class="form-control" id="role_id" name="role_id" required>
								<option value="">--Select--</option>
								<?php foreach($role_data as $role): ?>
								<option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>	
					</div>
					<div class="col-md-4">
					<div class="form-group">
						<label>Client</label>
						<select class="form-control" id="fedclient_id" name="client_id" required>
							<option value="">--Select--</option>
							<?php foreach($client_list as $client): ?>
							<option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Process</label>
						<select class="form-control" id="fedprocess_id" name="process_id" required>
							<option value="">--Select--</option>
							<?php foreach($process_list as $process): ?>
							<option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Employee Status</label>
							<select class="form-control" id="employee_status" name="employee_status" >
								<option>--Select--</option>
								<option value="1">Part Time</option>
								<option value="2">Full Time</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Required Qualification</label>
							<input type="text" class="form-control" id="req_qualification" name="req_qualification" value="" required>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Required Experience Range</label>
							<input type="text" class="form-control" id="req_exp_range" name="req_exp_range" value="" required>
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Required no of Position</label>
							<input type="number" class="form-control" id="req_no_position" name="req_no_position" value="" required>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Required Skill</label>
							<input type="text" class="form-control" id="req_skill" name="req_skill" value="" required>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Batch No</label>
							<input type="text" class="form-control" id="job_title" name="job_title" value="" required>
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Job Desciption</label>
							<textarea class="form-control" id="job_desc" name="job_desc"></textarea>
						</div>	
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Additional Information</label>
							<textarea class="form-control" id="additional_info" name="additional_info"></textarea>
						</div>	
					</div>
				</div>
				<div class="site_cspl" style="display: none">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Site</label>
								<select name="site" class="form-control site">
									<?php foreach($site_list as $site): ?>
									<option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>					
					</div>
			    </div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='editRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!---------------WFM Approval part-------------------->
<div class="modal fade modal-design" id="approvalWfmModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmApprovalWfm" action="<?php echo base_url(); ?>dfr/approved_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Approved Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="deptid" name="deptid" value="">
			<input type="hidden" id="raisedby" name="raisedby" value="">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Approval Remarks</label>
						<textarea class="form-control" id="approved_comment" name="approved_comment" placeholder="Remarks Here...." required></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" name="submit" id='wfmApproval' class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!--------------WFM Decline part------------------>
<div class="modal fade modal-design" id="declineWfmModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmDeclineWfm" action="<?php echo base_url(); ?>dfr/decline_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Decline Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
	  
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Decline Remarks</label>
						<textarea class="form-control" id="approved_comment" name="approved_comment" placeholder="Remarks Here...." required></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='wfmDecline' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!------------------------------------------------------------------------------>



<div class="modal fade modal-design" id="SendBasicLinkModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
	  
	<form class="frmSendBasicLink" action="<?php echo base_url(); ?>dfr/send_basic_link" data-toggle="validator" method='POST' enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Candidate to Send Link</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="link_rid" name="rid" value="" required>
			<input type="hidden" id="link_role_id" name="role_id" value="">
			<input type="hidden" id="pool_location" name="pool_location" value="">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Requisition Code</label>
						<input type="text" readonly id="link_requisition_id" name="requisition_id" class="form-control" value="" required>
					</div>
				</div>
								
				<div class="col-md-6">
					<div class="form-group">
						<label>First Name <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="link_fname" name="fname" class="form-control" value="" placeholder="Enter First name"  required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>  Last Name</label>
						<input type="text" id="link_lname" name="lname" class="form-control" value="" placeholder="Enter Last name" >
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Email <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<!-- <input type="text" id="link_email" name="email" class="form-control" value="" placeholder="Enter Email" required > -->
						<input type="email" id="first_email" name="email" class="form-control" value="" placeholder="Enter Email" onfocusout="checkemail('first');" required>
						<span id="first_email_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Phone <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<?php
						if($dfr_location == 'ALB'){
							$phone_length = '8';
						}else{
							$phone_length = '10';
						}
						// echo $dfr_location;
						?>
						<input type="text" id="first_phone" name="phone" class="form-control checkNumber" value="" placeholder="Enter phone" onfocusout="checkphone(<?php echo $phone_length; ?>,'first')">
						<span id="first_phone_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
			</div>
			
			
			<?php if(isIndiaLocation($dfr_location)==true )
				{
					$disCss="";	
					//$reqCss="";	
					$reqCss="required";	
				}else{
					$disCss="display:none;";
					
				}
				?>
				<div class="row" style="<?php echo $disCss;?>">
					<div class="col-md-6">
					<div class="form-group">
						<label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select id="onboarding_typ" name="onboarding_typ" class="form-control" "<?php echo $reqCss;?>" >
							<option value="">-- Select type --</option>
							<option value="Regular">Regular</option>
							<option value="NAPS">NAPS</option>
							<option value="Stipend">Stipend</option>
						</select>
					</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>Company <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
							<select id="company" name="company" class="form-control" "<?php echo $reqCss;?>">
								<option value="">-- Select company --</option>
								<?php foreach ($company_list as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
										
				</div>
				<?php if($offc_location =='Chandigarh'){ ?>
				
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Site</label>
							<select name="site" class="form-control site" >
								<?php foreach($site_list as $site): ?>
								<option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>					
				</div>
			   
			   <?php } ?>
			
				
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='btnSendBasicLink' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!------------------ Candidate Adding -------------------------->

<div class="modal fade modal-design" id="addCandidateModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	  
	<form class="frmAddCandidate" action="<?php echo base_url(); ?>dfr/add_candidate" data-toggle="validator" method='POST' enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Candidate Details</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="office_loc" name="office_loc" value="<?php echo $dfr_location;?>">
	  
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Requisition Code</label>
						<input type="text" readonly id="requisition_id" name="requisition_id" class="form-control" value="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>First Name <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="fname" name="fname" class="form-control" value="" placeholder="Enter First name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" required>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" id="lname" name="lname" class="form-control" value="" placeholder="Enter Last name" onkeypress="return /[a-z]/i.test(event.key)" >
					</div>
				</div>
			</div>
			<?php if($dfr_location=='CHA'){?>
				<div class="row">
                    <div class="col-sm-6">
                    <div class="form-group">
                      <label>
                        <strong>Guardian's Name(Father/Mother/Husband) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></strong>
                      </label>
                      <input type="text" name="guardian_name" class="form-control" required placeholder="Guardian's Name">
                    </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label>
            
                                <strong>Relation With Guardian</strong> <i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                        </label>
                        <select name="relation_guardian" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Husband">Husband</option>
                        <option value="Wife">Wife</option>
                        </select>
                        </div>    
                    </div>
                </div>
			<?php }?>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="exampleInputEmail1">
						<span id="dis_cont_other">	
							Do you know anyone in Fusion / Are you applying through any Fusion / Xplore-Tech Employee?
						</span>
						<span id="dis_cont_cha" style="display: none;">
							Do you know anyone in CSPL / Are you applying through any  CSPL Employee?
						</span>
					   </label>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-check form-check-inline">
						<input type="checkbox" class="form-check-input" id="referal" name="hiring_source" value="Existing Employee" required>
						<label class="form-check-label" for="referal">Check Me If Yes</label>
					</div>
				</div>
			</div>
			<div class="row" id="non_existing_employee">
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">How you come to know about the vacancy: </label>
						<div style="display:inline-block">
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_portal" value="Job Portal" >
							<label class="form-check-label" for="job_source_portal">Job Portal</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_consult" value="Consultancy" >
							<label class="form-check-label" for="job_source_consult">Consultancy</label>
						</div>
						<div <?php if(isIndiaLocation($dfr_location)){?>style="display:none"<?php } else { ?>style="display:inline-block"<?php } ?>>
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_callHR" value="Call From HR" >
							<label class="form-check-label" for="job_source_callHR">Call From HR</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_newspaper" value="Newspaper" >
							<label class="form-check-label" for="job_source_newspaper">Newspaper</label>
						</div>
						<div <?php if(isIndiaLocation($dfr_location)){?>style="display:none"<?php } else { ?>style="display:inline-block"<?php } ?>>
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_walkin" value="Walkin" >
							<label class="form-check-label" for="job_source_walkin">Walk In</label>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row" id="not_friend_referal">
				<div class="col-md-12">
					<div class="form-group">
						<label id="lebel_ref"></label>
						<!--<input type="text" class="form-control" name="ref_name" id="ref_name" style="width:100%" value="" >-->
						<select class="form-control" name="ref_name" id="ref_name" style="width:100%">
							<option></option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="row" id="existing_employee">
				<div class="col-md-4">
					<div class="form-group">
					  <select class="form-control select-box existing_employee" id="ref_name1" name="ref_name">
							<option value="">--Select--</option>
							<?php foreach($user_list_ref as $ur){ ?>
								<option value="<?php echo $ur['fusion_id']; ?>"><?php echo $ur['fname']." ".$ur['lname']." (" . $ur['fusion_id']. ", ".$ur['xpoid'].")"; ?></option>
							<?php } ?>
					  </select>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
					  <input type="text" readonly class="form-control existing_employee" id="refferer" name="ref_id" placeholder="Employee Name" value="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					  <input type="text" readonly class="form-control existing_employee" id="refferer_dept" name="ref_dept" placeholder="Employee Department" value="">
					</div>
				</div>
				
			</div>
			<span id="hiring_source_status" style="color:red;padding-bottom:10px;display:inline-block"></span>
			<div class="row">
				<?php if(isUSLocation($dfr_location)!=true) { ?>	
				<div class="col-md-3">
					<div class="form-group">
						<?php 							
							if(isIndiaLocation($dfr_location)==true )
							{
								echo '<label>Date of Birth (dd/mm/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
							}else{
								  echo '<label>Date of Birth (mm/dd/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
							  }
						?>
						
						<!-- <input type="text" id="dob" name="dob" class="form-control dobdatepicker" value="" placeholder="Enter DOB" autocomplete="off" readonly required> -->
						<input type="text" id="dob" name="dob" class="form-control dobdatepicker" value="" placeholder="Enter DOB" autocomplete="off" required>
					</div>
				</div>

			<?php } ?>
				<div class="col-md-3">
					<div class="form-group">
						<label>Email ID <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="email" id="add_email" name="email" class="form-control" value="" placeholder="Enter Email" onfocusout="checkemail('add');" required>
						<span id="add_email_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Gender <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select class="form-control" id="gender" name="gender" required>
							<option value="">--Select--</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Transgender">Transgender</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Last Qualification <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select class="form-control" id="last_qualification" name="last_qualification" required>
							<option value="">--Select Last Qualification--</option>
							<?php
								foreach($qualification_list as $key=>$value)
								{
									echo '<option value="'.$value->qualification.'">'.$value->qualification.'</option>';
								}
							?>
							
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Phone <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<?php
						if($dfr_location == 'ALB'){
							$phone_length = '8';
						}else{
							$phone_length = '10';
						}
						
						?>
						<input type="text" id="add_phone" name="phone" class="form-control checkNumber" value="" placeholder="Enter Phone no" onfocusout="checkphone(<?php echo $phone_length; ?>,'add')" required>
						<span id="add_phone_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Alternate Phone</label>
						<?php
						if($dfr_location == 'ALB'){
							$phone_length = '8';
						}else{
							$phone_length = '10';
						}
						?>
						<input type="text" id="alter_phone" name="alter_phone" class="form-control checkNumber" value="" placeholder="Enter Alternate Phone no" onfocusout="checkphone(<?php echo $phone_length; ?>,'alter')">
						<span id="alter_phone_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Skill Set</label>
						<input type="text" id="skill_set" name="skill_set" class="form-control" value="" placeholder="Enter Skill Set">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6" style="margin-bottom:4px;">
					<div class="form-group">
						<label>Experience Level: <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label><br/>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="experience" id="experience_fresh" value="Fresher" checked="checked">
							<label class="form-check-label" for="experience_fresh">Fresher</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="experience" id="experience_exp" value="Experienced">
							<label class="form-check-label" for="experience_exp">Experienced</label>
						</div>
					</div>
				</div>
				<div class="col-md-6" id="total_experience" style="display:none">
					<div class="form-group">
						<label>Total Work Exp.(In Year) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="total_work_exp" name="total_work_exp" class="form-control" value="0" placeholder="Enter Total Work Exp." onkeyup="checkDec(this);">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>
							Field of Interest:
							<?php if($dfr_location!='CHA'){?>
								<i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
							<?php }?>	
						</label><br/>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="interest" id="interest_voice" value="Voice" checked="checked">
							<label class="form-check-label" for="interest_voice">Voice</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="interest" id="interest_back" value="Back Office">
							<label class="form-check-label" for="interest_back">Back Office</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="interest" id="interest_other" value="Other">
							<label class="form-check-label" for="interest_other">Other</label>
						</div>
					</div>
				</div>
				<div class="col-md-6" id="interest_type" style="display:none">
					<div class="form-group">
						<input type="text" class="form-control" id="interest_desc" name="interest_desc" placeholder="Describe">
					</div>
				</div>
			</div>
			
			<span id="experience_field_of_interest" style="color:red;margin-bottom:4px;display:inline-block"></span>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>
							Country <?php if($dfr_location!='CHA'){?>
							<i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
							<?php }?>  </label>
						
						<select name="country" id="country" class="form-control" <?php echo ($dfr_location!='CHA')?'required':'';?>>
							<option value="">--select--</option>
							<?php
							foreach($get_countries as $country)
							{
							?>
								<option cid="<?php echo $country['id'];?>" value="<?php echo $country['name'];?>" > <?php echo $country['name'];?> </option>
							<?php
							}
							?>
						</select>
											
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>State <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select class="form-control" id="state" name="state" required></select>
						
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>City <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select class="form-control" id="city" name="city" required ></select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="city_other">City other:</label>
						<input type="text" class="form-control" id="city_other" name="city_other" value="" disabled >
					</div>
				</div>
			</div>
			<div class="row">
				<?php if($dfr_location == 'ELS' || $dfr_location == 'JAM') { } else{ ?>
					<div class="col-md-2">
					<div class="form-group">
						<label>
							Post Code <?php if($dfr_location!='CHA'){?>
							<i class="fa fa-asterisk" style="font-size:6px; color:red"></i> 
						<?php } ?></label>
						<?php 
						// echo $dfr_location; 
						if($dfr_location == 'MAN'|| $dfr_location == 'CEB' ) {
							$post_code_length = '4';
						}else{
							$post_code_length = '6';
						} ?>
						<input type="text" id="postcode" name="postcode" class="form-control checkNumber" value="" placeholder="Enter Postcode" <?php echo ($dfr_location!='CHA')?'required':'';?> onblur="checkPostCode(<?php echo $post_code_length; ?>)">
						<span id="post_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
				<?php } ?>
				<div class="col-md-5">
					<div class="form-group">
						<label>
							Address <?php if($dfr_location!='CHA'){?>
							<i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
							<?php } ?></label>
						<textarea class="form-control" id="address" name="address" placeholder="Enter Address details" <?php echo ($dfr_location!='CHA')?'required':'';?>></textarea>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label>Summary</label>
						<textarea class="form-control" id="summary" name="summary" placeholder="Enter Summary details"></textarea>
					</div>
				</div>
			</div>

			<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select id="onboarding_type" name="onboarding_type" class="form-control" required="required">
							<option value="">-- Select type --</option>
							<option value="Regular">Regular</option>
							<option value="NAPS">NAPS</option>
							<option value="Stipend">Stipend</option>
						</select>
					</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Company <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
							<select id="company" name="company" class="form-control" required="required">
								<option value="">-- Select company --</option>
								<?php foreach ($company_list as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			
			
			<div class="row">
			
				<!--<div class="col-md-6">
					<div class="form-group">
						<label>Assign Level-1 Supervisor</label>
						<select id="assigned_to" name="assigned_to" class="form-control" style="width:100%">
							<option value="">--Select--</option>
							<?php foreach($tl_list as $tl): ?>
								<option value="<?php echo $tl->id ?>"><?php echo $tl->tl_name ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>-->
				
				<div class="col-md-6">
				
					<div class="input-group">
					  <div class="input-group-prepend">
						<span class="input-group-text">Upload Resume</span>
					  </div>
					  <div class="custom-file">
						<input type="file" name="attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" >
					  </div>
					</div>
				
					
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='addCandidateDetails' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!-------------------------------view Candidate------------------------------------>

<div class="modal fade modal-design" id="viewCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	  
	<form class="frmViewCandidate" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">View Candidate Details</h4>
      </div>
      <div class="modal-body">
	  
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="r_id" name="r_id" value="">
		
		<?php //foreach($get_candidate_details as $row): ?>
		
			<div class="table-responive">
				<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
					<tr>
						<td class='bg-info'>Requision Code</td>
						<td id="c_d_requisition_id"></td>
						<td class='bg-info'>Candidate Name</td>
						<td id="c_d_fullname"></td>
						<td class='bg-info'>Hiring Source</td>
						<td id="c_d_hiring_source"></td>
						<td class='bg-info'>Date of Birth</td>
						<td id="c_d_dob"></td>
					</tr>
					<tr>
						<td class='bg-info'>Email ID</td>
						<td id="c_d_email"></td>
						<td class='bg-info'>Mobile</td>
						<td id="c_d_phone"></td>
						<td class='bg-info'>Last Qualification</td>
						<td id="c_d_last_qualification"></td>
						<td class='bg-info'>Skill Set</td>
						<td id="c_d_skill_set"></td>
					</tr>
					<tr>
						<td class='bg-info'>Total Work Exp.</td>
						<td id="c_d_total_work_exp"></td>
						<td class='bg-info'>Country</td>
						<td id="c_d_country"></td>
						<td class='bg-info'>State</td>
						<td id="c_d_state"></td>
						<td class='bg-info'>City</td>
						<td id="c_d_city"></td>
					</tr>
					<tr>
						<td class='bg-info'>Post Code</td>
						<td id="c_d_postcode"></td>
						<td class='bg-info'>Gender</td>
						<td id="c_d_gender"></td>
						<td class='bg-info'>Address</td>
						<td colspan='4' id="c_d_address"></td>
					</tr>
					<tr>
						<td class='bg-info'>Attachment</td>
						<td colspan='2' id="c_d_attachment"></td>
						<td class='bg-info'>Summary</td>
						<td colspan='4' id="c_d_summary"></td>
					</tr>
				</table>
			</div>
			
		<?php //endforeach; ?>	
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!---------------------------------------Edit Candidate details------------------------------------------------->

<div class="modal fade modal-design" id="editCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	  
	<form class="frmEditCandidate" action="<?php echo base_url(); ?>dfr/edit_candidate" data-toggle="validator" method='POST' enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Candidate</h4>
      </div>
	  
	 
	  
      <div class="modal-body">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="r_id" name="r_id" value="">
	  
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Requisition Code</label>
						<input type="text" readonly id="requisition_id" name="requisition_id" class="form-control" value="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Location</label>
						<input type="text" id="office_location_edit" name="location" class="form-control" value=""  readonly>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<?php 
							if(isIndiaLocation($dfr_location)==true )
							{
								echo '<label>Date of Birth (dd/mm/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
							}else{
								  echo '<label>Date of Birth (mm/dd/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
							  }
						?>
						<input type="text" id="dob1" name="dob" class="form-control dobdatepicker" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>First Name <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="fname" name="fname" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" id="lname" name="lname" class="form-control" value="" >
					</div>
				</div>
			</div>
			<?php if($dfr_location=='CHA'){?>
				<div class="row">
                    <div class="col-sm-6">
                    <div class="form-group">
                      <label>
                        <strong>Guardian's Name(Father/Mother/Husband)</strong>
                      </label>
                      <input type="text" name="guardian_name" id="guardian_name" class="form-control"  placeholder="Guardian's Name">
                    </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label>
                        	<strong>Relation With Guardian</strong>
                        </label>
                        <select name="relation_guardian" id="relation_guardian" class="form-control" >
                        <option value="">--Select--</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Husband">Husband</option>
                        <option value="Wife">Wife</option>
                        </select>
                        </div>    
                    </div>
                </div>
			<?php }?>
			
			
			<?php if(get_user_fusion_id()=="FKOL000003"){ ?> 
				<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Hiring Source <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select id="hiring_source" name="hiring_source" class="form-control" required>
							<option value="Existing Emplyee">Existing Emplyee</option>
							<option value="Job Portal">Job Portal</option>
							<option value="Consultancy">Consultancy</option>
							<option value="Call From HR">Call From HR</option>
							<option value="Newspaper">Newspaper</option>
							<option value="Walkin">Walkin</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Source Details <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="ref_name" name="ref_name" class="form-control" required>
					</div>
				</div>
			   </div>
			<?php }else{ ?>
			<div class="row">
				<div class="col-md-3" id="hir">
					<div class="form-group">
						<label>Hiring Source</label>
						<input readonly type="text" id="hiring_source" name="hiring_source" class="form-control">
						<!-- <select id="hiring_source" name="hiring_source" class="form-control">
							<option value="Existing Emplyee">Existing Emplyee</option>
							<option value="Job Portal">Job Portal</option>
							<option value="Consultancy">Consultancy</option>
							<option value="Call From HR">Call From HR</option>
							<option value="Newspaper">Newspaper</option>
							<option value="Walkin">Walkin</option>
						</select> -->
					</div>
				</div>
				<div class="col-md-3" id="sorce">
					<div class="form-group">
						<label>Source Details</label>
						<input readonly type="text" id="ref_name" name="ref_name" class="form-control">
					</div>
				</div>
				<div class="col-md-3 existing" id="existing_employee" style="display: none;">
					<div class="form-group">
						<label>Employee Name</label>
					  <select class="existing_employee form-control" id="ref_name1" name="ref_name">

							<option value="">--Select--</option>
							<?php foreach($user_list_ref as $ur){ ?>
								<option value="<?php echo $ur['fusion_id']; ?>"><?php echo $ur['fname']." ".$ur['lname']." (" . $ur['fusion_id']. ", ".$ur['xpoid'].")"; ?></option>
							<?php } ?>
					  </select>
					</div>
				</div>

				<div class="col-md-3 not_friend_referal" id="not_friend_referal" style="display: none;">
					<div class="form-group">
						<label id="lebel_reff"></label>
						<!--<input type="text" class="form-control" name="ref_name" id="ref_name" style="width:100%" value="" >-->
						<select class="form-control" name="ref_name" id="reff_name" style="width:100%">
							<option></option>
						</select>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Email ID <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<!-- <input type="email" id="email" name="email" class="form-control" value="" required> -->
						<input type="email" id="edit_email" name="email" class="form-control" value="" placeholder="Enter Email" onfocusout="checkemail('edit');" required>
						<span id="edit_email_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Gender <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select class="form-control" id="gender" name="gender" required>
							<option value="">--Select--</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>Phone <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<?php
						if($dfr_location == 'ALB'){
							$phone_length = '8';
						}else{
							$phone_length = '10';
						}
						// echo $dfr_location;
						?>
						<input type="text" id="edit_phone" name="phone" class="form-control checkNumber" placeholder="Enter Phone" value="" onfocusout="checkphone(<?php echo $phone_length; ?>,'edit')" required>
						<span id="edit_phone_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Last Qualification <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select class="form-control" id="last_qualification" name="last_qualification" required>
							<option value="">--Select Last Qualification--</option>
							<?php
								foreach($qualification_list as $key=>$value)
								{
									echo '<option value="'.$value->qualification.'">'.$value->qualification.'</option>';
								}
							?>
							
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Skill Set <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="skill_set" name="skill_set" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Total Work Exp. (In Year) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="total_work_exp" name="total_work_exp" class="form-control" value="" onkeyup="checkDec(this);" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Country <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="country" name="country" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>State <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="state" name="state" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>City <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="city" name="city" class="form-control" value=""required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Post Code <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="postcode" name="postcode" class="form-control" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Address <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<textarea class="form-control" id="address" name="address" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Summary</label>
						<textarea class="form-control" id="summary" name="summary"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select id="onboarding_type" name="onboarding_type" class="form-control" required="required">
							<option value="">-- Select type --</option>
							<option value="Regular">Regular</option>
							<option value="NAPS">NAPS</option>
							<option value="Stipend">Stipend</option>
						</select>
					</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Company <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
							<select id="company" name="company" class="form-control" required="required">
								<option value="">-- Select company --</option>
								<?php foreach ($company_list as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			<div class="site_cspl" style="display: none">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Site</label>
							<select name="site" class="form-control site" >
								<option>--Select Site--</option>
								<?php foreach($site_list as $site): ?>
								<option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>					
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Edit Upload Resume</label>
						<input type="file" name="attachment" class="form-control" value="">
						<input type="text" id="attachment" readonly class="form-control" value="">
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='edit_candidate' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!-------------------------------------------Candidate Experience------------------------------------------------------->

<!---------------------------------Add Experience---------------------------------->

<div class="modal fade modal-design" id="addCandidateExpModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmaddCandidateExp" action="<?php echo base_url(); ?>dfr/add_candidate_exp" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Experience</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
	  
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Company Name</label>
						<input type="text" id="company_name" name="company_name" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Designation</label>
						<input type="text" id="designation" name="designation" class="form-control" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>From Date</label>
						<input type="text" id="from_date" name="from_date" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>To Date</label>
						<input type="text" id="to_date" name="to_date" class="form-control" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Contact</label>
						<input type="text" id="contact" name="contact" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Work Experience (In Year)</label>
						<input type="text" id="work_exp" name="work_exp" class="form-control" onkeyup="checkDec(this);" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Job Description</label>
						<textarea class="form-control" id="job_desc" name="job_desc" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Company Address</label>
						<textarea class="form-control" id="address" name="address" required></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='addCandidateExperience' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!---------------------------------Edit Experience---------------------------------->

<div class="modal fade modal-design" id="editCandidateExpModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmEditCandidateExp" action="<?php echo base_url(); ?>dfr/edit_candidate_exp" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Experience</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="c_exp_id" name="c_exp_id" value="">
	  
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Company Name</label>
						<input type="text" id="company_name" name="company_name" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Designation</label>
						<input type="text" id="designation" name="designation" class="form-control" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>From Date</label>
						<input type="text" id="fromdate" name="from_date" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>To Date</label>
						<input type="text" id="todate" name="to_date" class="form-control" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Contact</label>
						<input type="text" id="contact" name="contact" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Work Experience (In Year)</label>
						<input type="text" id="work_exp" name="work_exp" class="form-control" onkeyup="checkDec(this);" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Job Description</label>
						<textarea class="form-control" id="job_desc" name="job_desc" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" id="address" name="address" required></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='editCandidateExperience' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!-------------------------------------------Candidate Qualification------------------------------------------------------->
<!---------------------------------Add Qualification---------------------------------->

<div class="modal fade modal-design" id="addCandidateQualModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmaddCandidateQual" action="<?php echo base_url(); ?>dfr/add_candidate_qual" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Qualification</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="r_id" name="r_id" value="">
	  
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Exam</label>
						<!--<input type="text" id="exam" name="exam" class="form-control" required>-->
						<select name="exam" id="exam" class="form-control" required>
						<option value="">--select Exam--</option>	
						<?php
						foreach($qualification_list as $ql){
						?>
						<option value="<?php echo $ql->qualification;?>"><?php echo $ql->qualification;?></option>
					<?php }?>
					</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Passing Year</label>
						<input type="number" id="passing_year" name="passing_year" class="form-control" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Board/UV</label>
						<input type="text" id="board_uv" name="board_uv" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Grade/CGPA</label>
						<input type="text" id="grade_cgpa" name="grade_cgpa" class="form-control" onkeyup="checkDec(this);" required>
					</div>
				</div>
			</div>
			<div class="row" id="div_parcent" style="display:none;">
				<div class="col-md-6">
					<div class="form-group">
						<label>10th Eng%</label>
						<input type="number" id="10eng" name="10eng" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>10th Math%</label>
						<input type="number" id="10math" name="10math" class="form-control"  required>
					</div>
				</div>
			</div>
			<div class="row" id="div_parcent1" style="display:none;">
				<div class="col-md-6">
					<div class="form-group">
						<label>12th Eng%</label>
						<input type="number" id="12eng" name="12eng" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>12th Math%</label>
						<input type="number" id="12math" name="12math" class="form-control"  required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Specialization</label>
						<textarea class="form-control" id="specialization" name="specialization" required></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='addCandidateQualification' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!---------------------------------Edit Qualification---------------------------------->

<div class="modal fade modal-design" id="editCandidateQualModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmeditCandidateQual" action="<?php echo base_url(); ?>dfr/edit_candidate_qual" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Qualification</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_qual_id" name="c_qual_id" value="">
	  
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Exam</label>
						<input type="text" id="exam" name="exam" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Passing Year</label>
						<input type="number" id="passing_year" name="passing_year" class="form-control" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Board/UV</label>
						<input type="text" id="board_uv" name="board_uv" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Grade/CGPA</label>
						<input type="text" id="grade_cgpa" name="grade_cgpa" class="form-control" onkeyup="checkDec(this);" required>
					</div>
				</div>
			</div>
			<div class="row" id="div_parcent_edit" style="display:none;">
				<div class="col-md-6">
					<div class="form-group">
						<label>10th Eng%</label>
						<input type="number" id="10eng_edit" name="10eng" class="form-control" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>10th Math%</label>
						<input type="number" id="10math_edit" name="10math" class="form-control">
					</div>
				</div>
			</div>
			<div class="row" id="div_parcent1_edit" style="display:none;">
				<div class="col-md-6">
					<div class="form-group">
						<label>12th Eng%</label>
						<input type="number" id="12eng_edit" name="12eng" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>12th Math%</label>
						<input type="number" id="12math_edit" name="12math" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Specialization</label>
						<textarea class="form-control" id="specialization" name="specialization" required></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='editCandidateQualification' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!--------------------------------------------------------------------------------------------------------------->

<!-------------------------------------------Schedule Candidate & Interview------------------------------------------------------>

<!----------------------Candidate add Scheduled rounds-------------------------------->
<div class="modal fade modal-design" id="addScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmaddScheduleCandidate" action="<?php echo base_url(); ?>dfr/candidate_schedule" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Schedule Interview</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="dept_id" name="dept_id" value="">
	  
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Schedule Date/Time</label>
						<input type="text" id="scheduled_on" name="scheduled_on" class="form-control" autocomplete="off" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Site</label>
						<input type="text" readonly class="form-control" id="interview_site" name="interview_site" >
						<!--<select class="form-control" id="interview_site" name="interview_site" disabled>
							<option>--Select--</option>
							<?php //foreach($get_site_location as $sl): ?>
								<option value="<?php //echo $sl['abbr']; ?>"><?php //echo $sl['location']; ?></option>
							<?php //endforeach; ?>	
						</select>-->
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Type</label>
						<select class="form-control" id="interview_type" name="interview_type" required>
							
							<option>--Select--</option>
							<?php foreach($dfr_interview_type_mas as $invType): ?>
								<option value="<?php echo $invType['id']; ?>"><?php echo $invType['name']; ?></option>
							<?php endforeach; ?>	
							
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interviewer</label>
						<select class="form-control" id="assign_interviewer" name="assign_interviewer" style="width:100%" required>
							<option>--Select--</option>
							<!--<?php //foreach($user_tlmanager as $row){ ?>
								<option value="<?php //echo $row['id']; ?>"><?php //echo $row['name']; ?></option>
							<?php //} ?>-->
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Remarks</label>
						<input type="text" id="remarks" name="remarks" class="form-control">
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='addCandidateSchedule' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!--------------------------------------Candidate edit Scheduled----------------------------------------------->
<div class="modal fade modal-design" id="editScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmeditScheduleCandidate" action="<?php echo base_url(); ?>dfr/edit_candidate_schedule" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit Schedule</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="sch_id" name="sch_id" value="">
	  
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Schedule Date/Time</label>
						<input type="text" id="scheduled_on1" name="scheduled_on" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Site</label>
						<input type="text" readonly class="form-control" id="edinterview_site" name="interview_site" >
						<!--<select class="form-control" readonly id="interview_site" name="interview_site">
							<option>--Select--</option>
							<?php //foreach($get_site_location as $sl): ?>
								<option value="<?php //echo $sl['abbr']; ?>"><?php //echo $sl['location']; ?></option>
							<?php //endforeach; ?>	
						</select>-->
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Type</label>
						<select class="form-control" id="edinterview_type" name="interview_type" required>
							<option>--Select--</option>
							<?php foreach($dfr_interview_type_mas as $invType): ?>
								<option value="<?php echo $invType['id']; ?>"><?php echo $invType['name']; ?></option>
							<?php endforeach; ?>	
							
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interviewer</label>
						<select class="form-control" id="edassign_interviewer" name="assign_interviewer" style="width:100%" required>
							<option>--Select--</option>
							<?php //foreach($user_tlmanager as $row){ ?>
								<!--<option value="<?php //echo $row['id']; ?>"><?php //echo $row['name']; ?></option>-->
							<?php //} ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Remarks</label>
						<input type="text" id="remarks" name="remarks" class="form-control">
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='edCandidateSchedule' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!--------------------------------------Cancel Interview Scheduled----------------------------------------------->
<div class="modal fade modal-design" id="cancelScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmCancelScheduleCandidate" action="<?php echo base_url(); ?>dfr/cancel_interviewSchedule" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Cancel Schedule Candidate</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="sch_id" name="sch_id" value="">
	  
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Reason</label>
						<textarea id="cancel_reason" name="cancel_reason" class="form-control" required></textarea>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Remarks</label>
						<textarea id="remarks" name="remarks" class="form-control"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='cancelCandidateSchedule' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>



<!--------------------------------------Candidate Add Interview Round's---------------------------------------------->
<div class="modal fade modal-design" id="addCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
	  
	<form class="frmaddCandidateInterview" action="<?php echo base_url(); ?>dfr/add_candidate_interview" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Candidate Interview</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="sch_id" name="sch_id" value="">
			<input type="hidden" id="sh_status" name="sh_status" value="">
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Interviewer Name</label>
						<select class="form-control" id="interviewer_id" name="interviewer_id" required>
							<option>--Select--</option>
							<?php 
								$sCss="";
								foreach($user_tlmanager as $tm): 
								if($tm['id']==get_user_id()){  $sCss="selected";  ?>
									<option value="<?php echo $tm['id']; ?>" <?php echo $sCss; ?>><?php echo $tm['name']; ?></option>
								<?php }else{?>
									<option value="<?php echo $tm['id']; ?>"><?php echo $tm['name']; ?></option>
								<?php } ?>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Date</label>
						<input type="text" id="scheduled_date" name="interview_date" class="form-control" required>
					</div>
				</div>	
			</div>
			
			</br>
			
			<div class="row">
				<!-- -->
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Education/Training:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="educationtraining_param" name="educationtraining_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Job Knowledge:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="jobknowledge_param" name="jobknowledge_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Work Experience:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="workexperience_param" name="workexperience_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Analytical Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="analyticalskills_param" name="analyticalskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Technical Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="technicalskills_param" name="technicalskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">General Awareness:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="generalawareness_param" name="generalawareness_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Body Language:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="bodylanguage_param" name="bodylanguage_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">English Comfortable:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="englishcomfortable_param" name="englishcomfortable_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">MTI:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="mti_param" name="mti_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Enthusiasm:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="enthusiasm_param" name="enthusiasm_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Leadership Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="leadershipskills_param" name="leadershipskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Customer Importance:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="customerimportance_param" name="customerimportance_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Job Motivation:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="jobmotivation_param" name="jobmotivation_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Target Oriented:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="resultoriented_param" name="resultoriented_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Convincing Power:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="logicpower_param" name="logicpower_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Initiative:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="initiative_param" name="initiative_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Assertiveness:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="assertiveness_param" name="assertiveness_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Decision Making:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="decisionmaking_param" name="decisionmaking_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<!-- -->
			</div>
			
			</br>
			
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Listening Skill:</label>
						<select class="form-control" id="listen_skill" name="listen_skill">
							<option value="">-Select-</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
						</select>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label>Overall Interview Result</label>
						<select class="form-control" id="result" name="result" required>
							<option value="">-Select-</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Interview Status</label>
						<select id="interview_status" name="interview_status" class="form-control" required>
							<option value="">--select--</option>
							<option value="C">Cleared Interview</option>
							<option value="N">Not Cleared Interview</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Overall Assessment (Minimum 20 characters)</label>
						<textarea class="form-control" id="overall_assessment" name="overall_assessment" minlength="20" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Remarks</label>
						<textarea class="form-control" id="interview_remarks" name="interview_remarks"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='addCandidateInterview' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!---------------------------------Edit Interview part---------------------------------->
<div class="modal fade modal-design" id="editCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px">
    <div class="modal-content">
	  
	<form class="frmeditCandidateInterview" action="<?php echo base_url(); ?>dfr/edit_interview" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Candidate Edit Interview</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="sch_id" name="sch_id" value="">
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Interviewer Name</label>
						<select class="form-control" id="interviewer_id" name="interviewer_id" required>
							<option>--Select--</option>
							<?php foreach($user_tlmanager as $tm): ?>
								<option value="<?php echo $tm['id']; ?>"><?php echo $tm['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Date</label>
						<input type="text" readonly id="interview_date" name="" class="form-control" required>
					</div>
				</div>
			</div>
			
			</br>
			
			<div class="row">
				<!-- -->
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Education/Training:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="ededucationtraining_param" name="educationtraining_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Job Knowledge:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edjobknowledge_param" name="jobknowledge_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Work Experience:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edworkexperience_param" name="workexperience_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Analytical Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edanalyticalskills_param" name="analyticalskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Technical Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edtechnicalskills_param" name="technicalskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">General Awareness:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edgeneralawareness_param" name="generalawareness_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Body Language:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edbodylanguage_param" name="bodylanguage_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">English Comfortable:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edenglishcomfortable_param" name="englishcomfortable_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">MTI:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edmti_param" name="mti_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Enthusiasm:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edenthusiasm_param" name="enthusiasm_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Leadership Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edleadershipskills_param" name="leadershipskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Customer Importance:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edcustomerimportance_param" name="customerimportance_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Job Motivation:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edjobmotivation_param" name="jobmotivation_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Target Oriented:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edresultoriented_param" name="resultoriented_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Convincing Power:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edlogicpower_param" name="logicpower_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Initiative:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edinitiative_param" name="initiative_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Assertiveness:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edassertiveness_param" name="assertiveness_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Decision Making:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="eddecisionmaking_param" name="decisionmaking_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<!-- -->
			</div>
			
			</br>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Listening Skill:</label>
						<select class="form-control" id="edlisten_skill" name="listen_skill">
							<option value="">-Select-</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Overall Interview Result</label>
						<select class="form-control" id="result" name="result" required>
							<option value="">-Select-</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
						</select>
					</div>
				</div>	
				<div class="col-md-4">
					<div class="form-group">
						<label>Interview Status</label>
						<select class="form-control" id="edinterview_status" name="interview_status" required>
							<option value="">--select--</option>
							<option value="C">Cleared Interview</option>
							<option value="N">Not Cleared Interview</option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Overall Assessment (Minimum 20 characters)</label>
						<textarea class="form-control" id="overall_assessment" name="overall_assessment" minlength="20" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Remarks</label>
						<textarea class="form-control" id="edinterview_remarks" name="interview_remarks"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" id='addCandidateInterview' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!----------------------------------------------Candidate Final Selection----------------------------------------------->

<div class="modal fade modal-design" id="candidateSelectInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmCandidateSelectInterview" action="<?php echo base_url(); ?>dfr/candidate_final_interviewStatus" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Candidate Final Status</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select id="candidate_status" name="candidate_status" class="form-control" required>
							<option value="">--select--</option>
							
							<option value="SL">Shortlisted</option>
							<option value="R">Reject</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Reason/Remarks</label>
						<textarea class="form-control" id="final_status_remarks" name="final_status_remarks"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='selectInterviewCandidate' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<div class="modal fade modal-design" id="candidateNotSelectInterviewModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmCandidateSelectInterviewModel" action="<?php echo base_url(); ?>dfr/candidate_final_interviewStatus" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Candidate Final Status</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="" name="candidate_status" value="R">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Reason/Remarks</label>
						<textarea class="form-control" id="final_status_remarks" name="final_status_remarks"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='selectInterviewCandidate' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!---------------------------------------------------------------------------------------------------------->
<!----------------------------------Candidate Final Approval------------------------------->

<div class="modal fade modal-design" id="approvalFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmApprovalFinalSelect" id="candidateSelectionForm" action="<?php echo base_url(); ?>dfr/candidate_final_approval" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Final Candidate Approval</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="requisition_id" name="requisition_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="location_id" name="location_id" value="">
			<input type="hidden" id="org_role" name="org_role" value="">
			<input type="hidden" id="gender" name="gender" value="">
			<input type="hidden" id="c_status" name="c_status" value="">
			<input type="hidden" id="brand_id" name="brand_id" value="">

			<div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
				<div class="col-md-12" style="border-color: #a94442;" id="prevUserInfoContent">
						
				</div>
			</div>
			

			<div class="row">
				<div class="col-md-6">

					<div class="form-group">
						<?php 
							if(isIndiaLocation($dfr_location)==true )
							{
								echo '<label>Date of Joining (dd/mm/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
							}else{
								  echo '<label>Date of Joining (mm/dd/yyyy) <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
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
								
				<div class="col-md-4">
					<div class="form-group">
						<label>Incentive Period</label>
						<select class="form-control" id="incentive_period" name="incentive_period" >
							<option value="">-Select-</option>
							<option value="Monthly">Monthly</option>
							<option value="Yearly">Yearly</option>
						</select>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label>Incentive Amount</label>
				<input type="number" min="0" id="incentive_amt" name="incentive_amt" class="form-control" autocomplete="off" value='0' >
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>Joining Bonus</label>
						<input type="number" min="0" id="joining_bonus" name="joining_bonus" class="form-control" autocomplete="off" value='0' >
					</div>
				</div>
				
				<div class="col-md-6" class='cspl' style="display:none;">
					<div class="form-group">
						<label>Skill Set for Bonus</label>
						<select class="form-control" id="skill_set_slab" name="skill_set_slab" >
							<option value="0">-Select-</option>
							<?php foreach($skillset_list as $skillse){ ?>
								<option value="<?php echo $skillse['amount']; ?>"><?php echo $skillse['skill_name']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="col-md-6" class='cspl' style="display:none;">
					<div class="form-group">
						<label>Training Fees (per day)</label>
						<input type="text" id="training_fees" name="training_fees" class="form-control" onkeyup="checkDec(this);" autocomplete="off" value='0' >
					</div>
				</div>
								
				<div class="col-md-12">
					<div class="form-group" id="grossid">
						<label>Monthly Total Earning (Gross Pay)</label>
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
				
				<tr class='ind_oth'>
					<td>Other Allowance</td>
					<td><input type="text" id="allowance" name="allowance" class="form-control" readonly  >
					<td><input type="text" id="allowanceyr" name="allowanceyr" class="form-control" readonly  ></td>				
				</tr>
				
				<tr class='cspl'>
					<td>Medical Allowance</td>
					<td><input type="text" id="medical_amt" name="medical_amt" class="form-control" readonly  >
					<td><input type="text" id="medical_amtyr" name="medical_amtyr" class="form-control" readonly  ></td>			
				</tr>
				
				<tr class='cspl'>
					<td>Statutory Bonus</td>
					<td><input type="text" id="bonus_amt" name="bonus_amt" class="form-control" readonly  >
					<td><input type="text" id="bonus_amtyr" name="bonus_amtyr" class="form-control" readonly  ></td>			
				</tr>
								
				<tr bgcolor="#D3D3D3">
					<td>TOTAL EARNING (Groos Pay)</td>
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
				
				<tr class='cspl'>
					<td>Gratuity</td>
					<td><input type="text" id="gratuity_employers" name="gratuity_employers" class="form-control" readonly  >
					<td><input type="text" id="gratuity_employersyr" name="gratuity_employersyr" class="form-control" readonly  ></td>				
				</tr>
				<tr class='cspl'>
					<td>Employer Labour Welfare Fund</td>
					<td><input type="text" id="lwf_employers" name="lwf_employers" class="form-control" readonly  >
					<td><input type="text" id="lwf_employersyr" name="lwf_employersyr" class="form-control" readonly  ></td>				
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
				
				<tr class='cspl'>
					<td>Employee- LWF</td>
					<td><input type="text" id="lwf_employees" name="lwf_employees" class="form-control" readonly  >
					<td><input type="text" id="lwf_employeesyr" name="lwf_employeesyr" class="form-control" readonly  ></td>				
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





<div class="modal fade modal-design" id="modalfinalchecknow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div class="modal fade modal-design" id="declineFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmDeclineFinalSelect" action="<?php echo base_url(); ?>dfr/candidate_final_decline" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Decline Final Selection</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="c_status" name="c_status" value="">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Decline Comment</label>
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


<!------------------------------------------------------------------------------------------------------------------->
<!---------------------------------Select candidate as employee---------------------------------->

<div class="modal fade modal-design" id="finalSelectionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
		
	<form class="frmfinalSelection" action="<?php echo base_url(); ?>dfr/candidate_select_employee" onsubmit="return finalselection()" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Candidate as Employee</h4>
      </div>
      <div class="modal-body">
	  
			<input type="hidden" id="r_id" name="r_id">
			<input type="hidden" id="c_id" name="c_id">
			<input type="hidden" id="hiring_source" name="hiring_source">
			<input type="hidden" id="address" name="address">
			<input type="hidden" id="country" name="country">
			<input type="hidden" id="state" name="state">
			<input type="hidden" id="city" name="city">
			<input type="hidden" id="postcode" name="postcode">
	
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Location</label>
						<!--<select class="form-control" id="location" name="office_id">
							<option>--select--</option>
							<?php //foreach($get_site_location as $sl): ?>
								<option value="<?php //echo $sl['abbr']; ?>"><?php //echo $sl['location']; ?></option>
							<?php //endforeach; ?>
						</select>-->
						<input type="text" readonly class="form-control" id="location" name="office_id">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Department</label>
						<select class="form-control" id="department_id" name="dept_id" required>
							<option value="">--Select--</option>
							<?php foreach($get_department_data as $dept): ?>
								<option value="<?php echo $dept['id']; ?>"><?php echo $dept['shname']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Sub Department</label>
						<select class="form-control" id="sub_dept_id" name="sub_dept_id" required>
							<option value="">--Select--</option>
							<?php foreach($sub_department_list as $sub_dept): ?>
								<option value="<?php echo $sub_dept['id'];?>"><?php echo $sub_dept['name'];?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<!--<div class="col-md-3">
					<div class="form-group">
						<label>Password</label>
						<input type="text" readonly id="passwd" name="passwd" class="form-control" value='fusion@123'>
					</div>	
				</div>-->
				<div class="col-md-4">
					<div class="form-group">
						<label>Emp ID/XPO ID</label>
						<input type="text" id="xpoid" name="xpoid" class="form-control" >
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						
						<?php
							
							if(isIndiaLocation($dfr_location)==true )
							{
								echo "<label>Joining Date (dd/mm/yyyy)</label>";
							}else{
								echo "<label>Joining Date (mm/dd/yyyy)</label>";
							}
							
						?>
						
						<input type="text" id="d_o_j" name="doj" class="form-control" required>
					</div>	
				</div>
				<div class="col-md-4">
					
					
					<div class="form-group">
						<?php
							
							if(isIndiaLocation($dfr_location)==true )
							{
								echo "<label>Date of Birth (dd/mm/yyyy)</label>";
							}else{
								echo "<label>Date of Birth (mm/dd/yyyy)</label>";
							}
							
						?>
						<input type="text" id="d_o_b" name="dob" class="form-control" required>
						
					</div>	
					
					
				</div>
			</div>	
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>First Name</label>
						<input type="text" id="fname" name="fname" class="form-control" required>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" id="lname" name="lname" class="form-control" >
					</div>	
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Gender</label>
						<select id="gender" name="sex" class="form-control" required>
							<option value="">--Select--</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
						</select>
					</div>	
				</div>
				<div class="col-md-2">
				
					<div class="form-group">
						<label>Class/Batch Code</label>
						<input type="text" id="batch_code" name="batch_code" class="form-control">
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Father's/Husband's Name</label>
						<?php
							
							if(isIndiaLocation($dfr_location)==true ){
								echo "<input type='text' class='form-control' minlength='3' id='father_husband_name' name='father_husband_name' required>";
								
							}else if($dfr_location == 'ELS'){
								echo "<input type='text' class='form-control' id='father_husband_name' name='father_husband_name'>";
							}else{
								echo "<input type='text' class='form-control' id='father_husband_name' name='father_husband_name'>";
							}
						?>
					</div>	
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Relation</label>
						
						<?php
							if(isIndiaLocation($dfr_location)==true ){
								
								echo "<select id='relation' name='relation' class='form-control' required>";
								
							}else if($dfr_location == 'ELS'){
								echo "<select id='relation' name='relation' class='form-control'>";
							}else{
								echo "<select id='relation' name='relation' class='form-control' >";
							}
						?>
							<option>--Select--</option>	
							<option value="Father">Father</option>
							<option value="Husband">Husband</option>
							<option value="Mother">Mother</option>
							<option value="Wife">Wife</option>
						</select>
					</div>	
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Marital Status</label>
						
						<?php
							if($dfr_location == 'ELS'){
								echo "<select id='marital_status' name='marital_status' class='form-control'>";
							}else{
								echo "<select id='marital_status' name='marital_status' class='form-control' required>";
							}
						?>
							<option>--Select--</option>	
							<option value="Married">Married</option>
							<option value="UnMarried">Un-Married</option>
							<option value="Widow">Widow</option>
							<option value="Widower">Widower</option>
							<option value="Divorcee">Divorcee</option>
							
						</select>
						
					</div>	
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Nationality</label>
						<select id="nationality" name="nationality" class="form-control" required>
							<option value="">--Select--</option>
							<?php foreach($get_countries as $country): ?>
								<option value="<?php echo $country['name']; ?>"><?php echo $country['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
				
				<div class="col-md-2" id="caste_main">
					<div class="form-group">
						<label for="caste">Caste : </label>
						<select class="form-control" id="caste" name="caste" >
							<option value="">--select--</option>
							<option value="General">General</option>
							<option value="SC">SC</option>
							<option value="ST">ST</option>
							<option value="OBC">OBC</option>
						</select>
					
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Select a Designation</label>
						<select id="role_id" name="role_id" class="form-control" required>
							<option>--Select--</option>
							<?php foreach($role_list as $role): ?>
								<option value="<?php echo $role->id?>" param="<?php echo $role->org_role;  ?>"><?php echo $role->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Select Role Organization</label>
						<select id="org_role_id" name="org_role_id" class="form-control" >
							<option>--Select--</option>	
							<?php foreach($organization_role as $org_role): ?>
								<option value="<?php echo $org_role->id ?>"><?php echo $org_role->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Assign Level-1 Supervisor</label>
						<select id="assigned_to" name="assigned_to" style="width:100%" class="form-control" required>
							<option value="">--Select--</option>
							<?php foreach($tl_list as $tl): ?>
								<option value="<?php echo $tl->id ?>"><?php echo $tl->tl_name ?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>
			</div>
			
			<div class="row" id="check_payroll">
				<div class="col-md-4">
					<div class="form-group">
					<label for="client">Select Payroll Type</label>
						<select class="form-control" name="payroll_type" id="payroll_type" required>
							<option value=''>-- Select Payroll Type --</option>
							<?php foreach($payroll_type_list as $payroll_type): ?>
								<option value="<?php echo $payroll_type['id'] ?>"><?php echo $payroll_type['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					<label for="client">Select Payroll Status</label>
						<select class="form-control" name="payroll_status" id="payroll_status">
							<option value=''>-- Select Payroll Status --</option>
							<?php foreach($payroll_status_list as $payroll_status): ?>
								<option value="<?php echo $payroll_status['id'] ?>"><?php echo $payroll_status['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="grosspay">Gross Pay</label>
						<input type="text" class="form-control" id="grosspay" placeholder="Gross Pay" name="grosspay" readonly>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="currency">Currency</label>
						<input type="text" class="form-control" id="currency" placeholder="Currency" name="currency"  readonly>
					</div>
				</div>
				
			</div>
			
			
			<div class="row" id="stop_payroll" style="display:none;">
				<input name="payroll_type" value="0" type="hidden">
				<input name="payroll_status" value="0" type="hidden">
				<input name="grosspay" value="0" type="hidden">
				<input name="currency" value="" type="hidden">
			</div>
			
			
			<div class="row">			
				<div class="col-md-6">
					<div class="form-group" id="client_div">
						<label for="client_id">Select Client(s)</label>
						<select class="form-control"  style="width:100%; height:100px" name="client_id[]" id="client_id" multiple="multiple">
							<?php foreach($client_list as $client): ?>
								<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
							<?php endforeach; ?>							
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group" id="process_div">
						<label for="process_id">Select Process(s)</label>
						<select class="form-control"  style="width:100%; height:100px" name="process_id[]" id="process_id" multiple="multiple">
							<?php foreach($process_list as $process): ?>
								<option value="<?php echo $process->id ?>"><?php echo $process->name ?></option>
							<?php endforeach; ?>							
						</select>
					</div>
				</div>	
			</div>
			<div class="row">				
				<div class="col-md-3">
					<div class="form-group">
						<label for="name">Email ID (Personal)</label>
						<input type="email" pattern="[A-z0-9._%+-]+@[A-z0-9.-]+\.[A-z]{2,}$" data-error="Invalid email address" class="form-control email" id="email" placeholder="Email ID Personal" name="email_id_per" required> 
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="name">Email ID (Office)</label>
						<input type="email" data-error="Invalid email address" class="form-control" id="email_id_off" placeholder="Email ID Office" name="email_id_off" pattern="[A-z0-9._%+-]+@[A-z0-9.-]+\.[A-z]{2,}$">
					</div>
				</div>
				
				
				<?php
				// GET PHONE PATTERNS
				
				$phone_patern = "9,10";
				
				if(($dfr_location == 'CEB') && ($dfr_location == 'MAN')){
					$phone_patern = "9,10"; // for 10 11 digits
				}
				if($dfr_location == 'ALB'){
					$phone_patern = "8";  // for 8 digits
				}
				if($dfr_location == 'UKL'){
					$phone_patern = "9,10";  // for 10 11 digits
				}
				
				?>
				
				
				<div class="col-md-3">
					<div class="form-group">
						<label for="phone">Phone No</label>
						<input type="text" pattern="[0-9]{1}[0-9]{<?php echo $phone_patern; ?>}" class="form-control" id="phone" placeholder="Phone No" name="phone" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="phone_emar">Phone No (Emergency)</label>
						<input type="text" pattern="[0-9]{1}[0-9]{<?php echo $phone_patern; ?>}" class="form-control" id="phone_emar" placeholder="Phone No" name="phone_emar">
					</div>
				</div>
			</div>
			
			<div class="row" >
			<?php if(($dfr_location != 'ALB') && ($dfr_location != 'UKL')){ ?>
				<div class="col-md-3">
					<div class="form-group">
						<!--DUI -->
						<?php
							if(isIndiaLocation($dfr_location)==true) $reqCss="required";	
							else $reqCss="";
							
							if($dfr_location == 'ELS'){
								echo "<label for='pan_no'>NIT</label>";
							}else if($dfr_location == 'JAM'){
								echo "<label >TRN No.</label>";
							}else{
								echo "<label for='pan_no'>TAX/PAN Number</label>";
							}
						?>
						<input type="text" class="form-control" id="pan_no" name="pan_no" <?php echo $reqCss; ?> onfocusout="checkpan();">
						<span id="pan_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						
						<?php
							if($dfr_location == 'ELS'){
								echo "<label for='uan_no'>AFP</label>";
							}else if($dfr_location == 'JAM'){
								echo "<label for='uan_no'>NIT</label>";
							}else{
								echo "<label for='uan_no'>UAN(EPF) Number</label>";
							}
						?>
						<input type="text" class="form-control" id="uan_no" name="uan_no" onfocusout="checkuan();">
						<span id="uan_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						
						<?php
							if($dfr_location == 'ELS'){
								echo "<label>ISSS</label>";
							}else if($dfr_location == 'JAM'){
								echo "<label>NIS</label>";
							}else{
								echo "<label>Existing ESI No</label>";
							}
						?>
						
						<input type="text" class="form-control" id="esi_no" name="esi_no" >
					</div>
				</div>
			<?php } ?>
			
				<div class="col-md-3">
					<div class="form-group">
						<?php
							if($dfr_location == 'ELS'){
								echo "<label  style='font-size:12px'>National ID</label>";
								$required='';
								$length='';
							}else if($dfr_location == 'JAM'){
								echo "<label  style='font-size:12px'></label>";
								$required='';
								$length='';
							}else if(isIndiaLocation($dfr_location)==true )
							{
								echo "<label  style='font-size:12px'>Social Security No / Aadhaar No</label>";
								$required='required';
								$length='minlength="12"';
							}else if(get_user_office_id()=='UKL'){
								echo "<label  style='font-size:12px'>National Insurance Number</label>";
								$required='required';
								$length='';
							}else{
								echo "<label  style='font-size:12px'>Social Security No / Aadhaar No</label>";
								$required='required';
								$length='';
							}
							
						?>
						<input type="text" class="form-control" id="social_security_no" name="social_security_no" <?php echo $required." ".$length ?> onfocusout="checksecurity();">
					    <span id="social_security_no_status" style="color:red;font-size:10px;"></span>
					</div>
				</div>
			<?php if(isIndiaLocation()==true ): ?>
			<div class="body-widget">
				<div class="row">				
					<div class="col-md-4">
						<div class="form-group">
							<label for="bank_name">Bank Name</label>
							<input type="text" class="form-control email" id="bank_name" placeholder="Bank Name" name="bank_name"> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="branch_name">Branch</label>
							<input type="text" class="form-control" id="branch_name" placeholder="Branch Name" name="branch_name">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="acc_type">Account Type</label>
							<!-- <input type="text" class="form-control" id="bank_ifsc" placeholder="IFSC CODE" name="bank_ifsc"> -->
							<select  class="form-control" id="acc_type" name="acc_type">
								<option value="Savings">Savings</option>
								<option value="Checking">Checking</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="bank_acc_no">Account Number</label>
							<input type="text" class="form-control" id="bank_acc_no" placeholder="Account No" name="bank_acc_no" onfocusout="checkaccount();">
							<span id="bank_acc_no_status" style="color:red;font-size:10px;"></span>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label for="ifsc_code">IFSC Code</label>
							<input type="text" class="form-control" id="ifsc_code" placeholder="IFSC CODE" name="ifsc_code">
						</div>
					</div>
					
				</div>
			</div>
		<?php endif; ?>

			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" name="submit" id='candidateFinalSelection' class="btn btn-primary" value="Save">
      </div>
	 
	 </form>
	 
    </div>
  </div>
</div>


<!------------------------------ Re-Scheduled Candidate---------------------------------------->

<div class="modal fade modal-design" id="rescheduleCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmrescheduleCandidate" action="<?php echo base_url(); ?>dfr/reschedule_candidate" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Re-Scheduled Candidate</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="c_status" name="c_status" value="">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
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


<!-------------------------------------------------------------------------------------------------------------------------->

<div class="modal fade modal-design" id="transferSelectedCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmTransferSelectedCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Candidate Transfer</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" class="form-control">
			<input type="hidden" id="c_id" name="c_id" class="form-control">
			<input type="hidden" id="c_status" name="c_status" class="form-control">
			<div class="filter-widget">
			    <div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label>Select Location</label>
							<select id="transfer_location" class="select-box" name="office_id" autocomplete="off" placeholder="Select Location" width="100%">
								
								<?php
								//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
							?>
							<?php foreach($location_data as $loc): ?>
								<?php
								$sCss="";
								if(in_array($loc['abbr'],$oValue)) $sCss="selected";
								?>
							<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
								
							<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Select Site</label>
							<select id="select_site" class="trans_candidate" name="site_id" autocomplete="off" placeholder="Select site" width="100%">
								<option>--Select Site--</option>
							
							</select>
						</div>
					</div>	
					<div class="col-sm-4">
						<div class="form-group">
							<label>Select Department</label>
							<select id="select_department" class="trans_candidate" name="department_id" autocomplete="off" placeholder="Select Department" width="100%">
							<?php
								foreach($department_data as $k=>$dep){
								$sCss="";
								if(in_array($dep['id'],$o_department_id))$sCss="selected";	
							?>
							<option value="<?php echo $dep['id']; ?>"<?php echo $sCss;?>><?php echo $dep['shname']; ?></option>
							<?php		
								}
							?>	
							</select>
						</div>
					</div>	
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>List of Requisition</label>
							<select class="trans_candidate" id="req_id" name="req_id">
								<!-- <option value="">-Select-</option>
								<option value="0">Pool</option>
								<?php foreach($getrequisition as $row){ ?>
									<option value="<?php echo $row['id']; ?>"><?php echo $row['req_desc']; ?></option>
								<?php } ?> -->
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div id="req_details"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Transfer Comment</label>
							<textarea class="form-control" id="transfer_comment" name="transfer_comment"></textarea>
						</div>
					</div>
				</div>
			</div>
      </div>
	  <div class="modal-footer">
		<button type="button" class="pop-danger-btn" data-dismiss="modal">Close</button>
		<!--<input type="submit" name="submit" class="submit-btn1" value="Save">-->
		<button type="submit" name="submit" class="submit-btn">Save</button>
	</div>
	  
 
	  
	 </form>
	 
    </div>
  </div>
</div>


<!--------------- DROP CANDIDATE -------------------->
<div class="modal fade modal-design" id="dropCandidateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmdropCandidate" action="<?php echo base_url(); ?>dfr/CandidateDrop" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Drop Candidate</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" class="form-control" required>
			<input type="hidden" id="c_id" name="c_id" class="form-control" required>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Are you sure you want to drop this candidate ?</label>
						<select class="form-control" id="is_drop" name="is_drop" required>
							<option value="">-Select-</option>
							<option value="Y">Yes</option>
						</select>
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

<!--------------- From Upload -------------------->
<div class="modal fade modal-design" id="InterviewEvalutionFrom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frminterviewformupload" id="frminterviewformupload" action="<?php echo base_url(); ?>dfr/uploadInterviewFrom" data-toggle="validator" method='POST' enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"Upload Form</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" class="form-control" required>
			<input type="hidden" id="c_id" name="c_id" class="form-control" required>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<input type="file" name="interview_form" id="interview_form" class="form-control" required  accept=".pdf">
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
<!--------------- Fro loi Upload -------------------->
<div class="modal fade modal-design" id="loi_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmloi" id="frmloi" action="<?php echo base_url(); ?>dfr/upload_loi" data-toggle="validator" method='POST' enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"Upload Form</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" class="form-control" required>
			<input type="hidden" id="c_id" name="c_id" class="form-control" required>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<input type="file" name="loi_form" id="loi_form" class="form-control" required accept=".pdf">
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
<!--------------- Verify  CANDIDATE Documents-------------------->
<div class="modal fade modal-design" id="VerifyDocumentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
	  
	<form class="frmVerifyDocuments" action="<?php echo base_url(); ?>dfr/verifyDocuments" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Verify Document</h4>
      </div>
      <div class="modal-body" >
	  
			<div class="row">
				<div  id='VerifyDocumentsContent'class="col-md-12">
				
					
					
				</div>
			</div>
			<div id="certify_documents_div" class="row">
				<div class="col-md-12" style="color:darkgreen;font-weight:bold;">
					<input type="hidden" id="r_id" name="r_id" class="form-control" required>
					<input type="hidden" id="c_id" name="c_id" class="form-control" required>
					
					<input type="checkbox" id="is_verify_doc" name="is_verify_doc" value='1' required>
						I certify that the documents uploaded by candidate are valid and verified by me. .
				</div>
											
			</div>
			
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input  id="verify_submit_btn" type="submit" name="submit" class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!--------------- Verify  CANDIDATE Documents-------------------->
<div class="modal fade modal-design" id="employee_assets_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
	  
	<form class="section_employee_assets_form_submit" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Assets Details</h4>
      </div>
      <div class="modal-body" >
      	<div class="row section_employee_assets_form" style="display: none;">
      		<input type="text" name="c_id" id="c_id" value="" hidden>
			<div class="col-md-4">
				<div class="form-group">
					<label for="client">Email ID Required <span style="color: red">*</span></label>
						<select class="form-control" name="email_id" required>
							<option selected>--Select Option--</option>
							<option value='1'>Yes</option>
							<option value='0'>No</option>
						</select>
					</div>
				</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="client">Domain ID Required <span style="color: red">*</span></label>
						<select class="form-control" name="domain_id" required>
							<option selected>--Select Option--</option>
							<option value='1'>Yes</option>
							<option value='0'>No</option>
						</select>
					</div>
				</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="client">Assests <span style="color: red">*</span></label>
						<select class="form-control" name="assests" required>
							<option selected>--Select Option--</option>
							<option value='Not Required'>Not Required</option>
							<option value='Laptop'>Laptop</option>
							<option value='Desktop'>Desktop</option>
						</select>
					</div>
				</div>									
			<div class="col-md-4">
				<div class="form-group">
					<label>Remarks</label>
					<textarea class="form-control" name="hr_comment"></textarea>
				</div>
			</div>
		</div>		
		<div class="row section_employee_assets_status" style="display: none;">
			<h4>Email ID Required: <span style="color: green">Yes</span>/<span style="color: red">No</span> | Status: <span style="color: red">Not Provided</span>/<span style="color: green">Provided</span></h4>

			<h4>Domain ID Required: <span style="color: green">Yes</span>/<span style="color: red">No</span> | Status: <span style="color: red">Not Provided</span>/<span style="color: green">Provided</span></h4>

			<h4>Assests: Laptop/Desktop/<span style="color: red">Not Required</span> | Status: <span style="color: red">Not Provided</span>/<span style="color: green">Provided</span></h4>
			<hr>
			<p>Hr Remarks: </p>
			<p>IT Team Remarks: </p>							
		</div>
			
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input  id="verify_submit_btn" type="submit" name="submit" class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!---------------Joining kit upload-------------------->
<div class="modal fade modal-design" id="upload_joining_kit_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmjoiningkit" id="frmjoiningkit" action="<?php echo base_url(); ?>base_url().'dfr/upload_joining_kit?" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Joining Kit Upload</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" class="form-control">
			<input type="hidden" id="c_id" name="c_id" class="form-control">
			<input type="hidden" id="c_status" name="c_status" class="form-control">
			
			
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Upload Joining Kit</label>
					<input type="file" name="joining_kit_pdf" id="joining_kit_pdf" class="form-control" accept=".pdf" required="required">
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
<script type="text/javascript">
	document.querySelector("#req_no_position").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
});
</script>

<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#select-brand').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>

<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#fclient_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>

<script>
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
  });
  function get_user_data(cid,dfr_location,r_status,c_status,required_pos,filled_pos,r_id,interview_evalution_form){
 	$.ajax({
 		Type:'POST',
 		url:'<?php echo base_url();?>/dfr/get_user_info',
 		data:'cid='+cid+'&dfr_location='+dfr_location+'&r_status='+r_status+'&c_status='+c_status+'&required_pos='+required_pos+'&filled_pos='+filled_pos+'&r_id='+r_id+'&interview_evalution_form='+interview_evalution_form,
 		success:function(result){
 			$('#'+cid).html(result);
 		}
 	});
 }
</script>



