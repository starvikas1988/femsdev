
<style>
	.table {
		margin-bottom:8px;
	}	
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding: 4px;
	}
	
</style>

<div class="wrap">
	<section class="app-content">
		
<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Candidate List of Pool</h4>
			</header>
			<hr class="widget-separator">
			
			<div class="row" style="float:right; margin-top:-40px; margin-right:20px">
				
				<?php
					if(is_access_dfr_module()==1){  ////ACCESS PART
					
						echo "<button title='' type='button' class='btn btn-primary sendBasicLink' r_id='pool' requisition_id='pool' style='font-size:10px'>Send Link to Candidate </button>&nbsp;";
					
						echo "<button title='' type='button' class='btn btn-primary addCandidate' r_id='' requisition_id='' style='font-size:10px'>Add Candidate</button>";
						
						
					}	
				?>
				
			</div>
			
			<div class="widget-body">
			
				<?php echo form_open('',array('method' => 'get')) ?>
						
					<div class="row">
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Location</label>
								<select class="form-control" name="office_id" id="poffice_id" >
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
						<div class="col-md-3">
							<div class="form-group">
								<?php
								//  var_dump($cStatus);
								$sel = "selected = 'selected'";
								switch($cStatus){
									case "PIP" : $a = $sel;
									break;
									case "SLCS" : $b = $sel;
									break;
									case "RD" : $c = $sel;
									break;
								}
								?>
								<label>Candidate Status</label>
								<select class="form-control" name="candidate_status" id="pcandidate_status" >
									<option value='PIP' <?php if(isset($a)){echo $a;}?> >Pending & In-Progress</option>
									<option value="SLCS" <?php if(isset($b)){echo $b;}?> >Shortlisted  & Selected</option>
									<option value="RD" <?php if(isset($c)){echo $c;}?> >Rejected & Dropped</option>											
								</select>
							</div>
						</div>

						
				
							
						<div class="col-md-1" style="margin-top:25px">
							<div class="form-group">
								<button class="btn btn-success waves-effect" a href="<?php echo base_url();?>dfr/pool_requisition" type="submit" id='btnView' name='btnView' value="View">View</button>
							</div>
						</div>
						
					</div>
					
				</form>	
			
				<div class="table-responsive">
					<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
						<thead>
							<tr class='bg-info'>
								<th></th>
								<th>SL</th>
								<th>Last Qualification</th>
								<th>Location</th>
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
								foreach($get_candidate_details as $cd): 
								
								$r_id=$cd['r_id'];
								$c_id=$cd['can_id'];
								$c_status = $cd['candidate_status'];
								
								if($c_status=='P')	$cstatus="Pending";
								else if($c_status=='IP')	$cstatus="In Progress";
								else if($c_status=='SL')	$cstatus="Shortlisted";
								else if($c_status=='CS')	$cstatus="Selected";
								else if( $c_status=='E') $cstatus="Selected as Employee";
								else if($c_status=='R') $cstatus="Rejected";
								else if($c_status=='D') $cstatus="Dropped";
							?>
							<tr>
								
								<td>
								<?php //if($cid!=""){ ?>
									<button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#<?php echo $c_id; ?>" title=""><i class="fa fa-plus"></i></button>
								<?php //} ?>	
								</td>
								
								<td><?php echo $k++; ?></td>
								
								<td><?php echo $cd['last_qualification']; ?></td>
								<td><?php echo $cd['pool_location']; ?></td>
								<td><?php echo $cd['fname']." ".$cd['lname']; ?></td>
								<td><?php echo $cd['gender']; ?></td>
								<td><?php echo $cd['phone']; ?></td>
								<td><?php echo $cd['skill_set']; ?></td>
								<td><?php echo $cd['total_work_exp']; ?></td>
								<td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>">View Resume</a></td>
								<td width="70px"><?php echo $cstatus; ?></td>
								
								<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
								<td width="260px">
									<?php	
										//$sch_id=$cd['sch_id'];
										//$interview_type=$cd['interview_type'];	
										$interview_site=$cd['pool_location'];
										//$sh_status=$cd['sh_status']; 
										
										//$params=$cd['fname']."#".$cd['lname']."#".$cd['hiring_source']."#".$cd['d_o_b']."#".$cd['email']."#".$cd['phone']."#".$cd['last_qualification']."#".$cd['skill_set']."#".$cd['total_work_exp']."#".$cd['country']."#".$cd['state']."#".$cd['city']."#".$cd['postcode']."#".$cd['address']."#".$cd['summary']."#".$cd['attachment']."#".$cd['gender']."#".$cd['ref_name'];
										
										$params="#".$cd['fname']."#".$cd['lname']."#".$cd['hiring_source']."#".$cd['d_o_b']."#".$cd['email']."#".$cd['phone']."#".$cd['last_qualification']."#".$cd['skill_set']."#".$cd['total_work_exp']."#".$cd['country']."#".$cd['state']."#".$cd['city']."#".$cd['postcode']."#".$cd['address']."#".$cd['summary']."#".$cd['attachment']."#".$cd['gender']."#".$cd['ref_name']."#".$interview_site."#".$cd['onboarding_type']."#".$cd['company'];
										
										//$cparams=$cd['fname']."#".$cd['lname']."#".$cd['hiring_source']."#".$cd['d_o_b']."#".$cd['email']."#".$cd['phone']."#".$cd['department_id']."#".$cd['role_id']."#".$cd['d_o_j']."#".$cd['gender']."#".$cd['location']."#".$cd['job_title']."#".$cd['address']."#".$cd['country']."#".$cd['state']."#".$cd['city']."#".$cd['postcode'];
										
										$cparams=$cd['fname']."#".$cd['lname']."#".$cd['hiring_source']."#".$cd['d_o_b']."#".$cd['email']."#".$cd['phone']."#"."#"."#".$cd['d_o_j']."#".$cd['gender']."#".$interview_site."#"."#".$cd['address']."#".$cd['country']."#".$cd['state']."#".$cd['city']."#".$cd['postcode']."#"."#"."#";
										
										//$cparams=$cd['fname']."#".$cd['lname']."#".$cd['hiring_source']."#".$cd['d_o_b']."#".$cd['email']."#".$cd['phone']."#"."#"."#".$cd['d_o_j']."#".$cd['gender']."#".$interview_site."#"."#".$cd['address']."#".$cd['country']."#".$cd['state']."#".$cd['city']."#".$cd['postcode'];
										
									
									if($c_id!=""){
										
										echo '<a class="btn btn-success btn-xs viewCandidate" href="'.base_url().'dfr/view_candidate_details/'.$c_id.'" target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Details" style="font-size:12px"><i class="fa fa-eye"></i></a>';
										
											echo '&nbsp';
										
										
										
										if($c_status!='R' && $c_status!='CS'){
										
										//if(get_dept_folder()=="hr" || $is_role_dir=="admin" || $is_role_dir=="super" || $is_global_access==1){
										
											echo '<a class="btn btn-warning btn-xs editCandidate" c_id="'.$c_id.'" r_id="'.$r_id.'" params="'.$params.'" title="Click to Edit Candidate" style="font-size:12px"><i class="fa fa-pencil-square-o"></i></a>';
												echo '&nbsp &nbsp';
											
											if($c_status!='E'){
											
											echo '<a class="btn btn-primary btn-xs addExperience" title="Add Candidate Experience"  r_id="'.$r_id.'"  c_id="'.$c_id.'"  style="font-size:12px" ><i class="fa fa-industry"></i></a>';
												echo '&nbsp';
											echo '<a class="btn btn-primary btn-xs addQualification" title="Add Candidate Qualification"  r_id="'.$r_id.'"  c_id="'.$c_id.'" style="font-size:12px" ><i class="fa fa-graduation-cap"></i></a>';
												echo '&nbsp &nbsp';
											
											}
										
											
										
										//}		
										
										}

										
										
										if($c_status=='P' || $c_status=='IP'){
											
											
											
											//if(get_dept_folder()=="hr" || $is_role_dir=="admin" || $is_role_dir=="super" || $is_global_access==1){
											
											echo '<a class="btn btn-success btn-xs scheduleCandidate" title="Schedule Interview"  r_id="'.$r_id.'"  c_id="'.$c_id.'" interview_site="'.$interview_site.'"  style="font-size:12px" ><i class="fa fa-calendar-check-o"></i></a>';
												echo '&nbsp';
												
												
											//echo $candidate_total_schedule($cd['can_id'])['sch_value'];
												/* foreach (candidate_total_schedule($cd['can_id']) as $row){
													$sch_value=$row['sch_value'];
													$candidateid=$row['c_id']; */
													
													if($c_status!='P'){
														
														if(candidate_total_schedule($c_id) > 0 && candidate_has_pending_sch($c_id)=="0"){
														
															echo '<a class="btn btn-xs candidateSelectInterview" style="background-color:#EB952D" title="Candidate Final Status"  r_id="'.$r_id.'"  c_id="'.$c_id.'" style="font-size:12px" ><i class="fa fa-user-secret"></i></a>';
															
														}else{
															if(candidate_has_pending_sch($c_id)=="0"){
																echo '<a class="btn btn-danger btn-xs candidateNotSelectInterview" r_id="'.$r_id.'"  c_id="'.$c_id.'" title="Reject Candidate" style="font-size:12px"><i class="fa fa-close"></i></a>';
															}
														}
													}
												
												
												//}
											
												//}
											
											
																					
										}else if($c_status=='SL'){
											
											//if(get_dept_folder()=="hr" || $is_role_dir=="admin" || $is_role_dir=="manager" || $is_role_dir=="super" || $is_global_access==1){
												
											//if($required_pos!=$filled_pos){
											
											echo '<a class="btn btn-success btn-xs candidateApproval" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'"  title="Approval to Final Selection (Joining Date)" style="font-size:12px"><i class="fa fa-check-square"></i></a>'; /* requisition_id="'.$requisition_id.'" */
											echo '&nbsp';
											
											echo '<a class="btn btn-danger btn-xs candidateDecline" r_id="'.$r_id.'"  c_id="'.$c_id.'" c_status="'.$c_status.'" title="Cancel Shortlisted" style="font-size:12px"><i class="fa fa-close"></i></a>';
										
											//}
											
											//}
										
												echo '&nbsp &nbsp';
										
										}else if($c_status=='CS' || $c_status=='E'){
											
											//if(get_dept_folder()=="hr" || $is_role_dir=="super" || $is_global_access==1){
											
											if($c_status!='E'){
												
												//if($required_pos!=$filled_pos){
												
												/*echo '<a class="btn btn-primary btn-xs finalSelection" r_id="'.$r_id.'" c_id="'.$c_id.'" cparams="'.$cparams.'" title="" style="font-size:12px" >Add as Employee</a>';
													echo "&nbsp &nbsp";*/
												//echo '<a class="btn btn-danger btn-xs candidateDecline" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Decline Adding Employee" style="font-size:12px" ><i class="fa fa-user-times"></i></a>';
												
												//}
												
											}else{	
												echo "<span class='label label-info' style='font-size:12px; display:inline-block;'>Empolyee</span>";
											}
											
											//}
											
										}else{
											echo '<span class="label label-danger" style="font-size:12px"><b>Rejected</b></span>';
												echo "&nbsp &nbsp";
											
											//echo '<a class="btn btn-warning btn-xs rescheduleCandidate" r_id="'.$r_id.'"  c_id="'.$c_id.'" c_status="'.$c_status.'" title="Re-Schedule Candidate" style="font-size:12px"><i class="fa fa-street-view"></i></a>';
										}
										
										echo "&nbsp";
										
										if($c_status!='P'){
										
											echo '<a class="btn btn-xs candidateInterviewReport" href="'.base_url().'dfr/view_candidate_interview_pool/'.$c_id.'"  target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Candidate Interview Report" style="font-size:12px; background-color:#EE8CE4;"><i class="fa fa-desktop"></i></a>';
										
										}
										
										if($c_status!='E'){
											echo "&nbsp";
											
											echo '<a class="btn btn-danger btn-xs selectedCandidateTransfer" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Transfer Candidate" style="font-size:12px" ><i class="fa fa-exchange"></i></a>';
										}
										
									}
									?>
								</td>
								<?php } ?>
							</tr>
							
							<tr id="<?php echo $c_id; ?>" class="collapse">
								<td colspan="12" style="background-color:#EEE">
								<table class="table" style="background-color:#FFFFFF;margin-bottom:0px;border:0px !important">
								<tr>
								<td align="center"></br><strong>Experience Details</strong></td>
								<td style="background-color:#EEE">
									<table  class="table skt-table" cellspacing="0" width="100%" style="background-color:#FFF;margin-bottom:0px;">
									<thead>
										<tr class="">
											<th width="60px">SL.No</th>
											<th>Company Name</th>
											<th>Designation</th>
											<th>From Date</th>
											<th>To Date</th>
											<th>Contact</th>
											<th>Work Exp</th>
											<th>Job Desc</th>
											<th>Address</th>
											<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
												<th width="50px" class="text-center">Action</th>
											<?php } ?>	
										</tr>
									</thead>
									<tbody>
										<?php 
											$e=1;
											foreach (candidate_exp_details($cd['can_id']) as $row):  	
										?>
											<tr>
											<td><?php echo $e++; ?></td>
											<td><?php echo $row['company_name'] ?></td>
											<td><?php echo $row['designation'] ?></td>
											<td><?php echo $row['from_date'] ?></td>
											<td><?php echo $row['to_date'] ?></td>
											<td><?php echo $row['contact'] ?></td>
											<td><?php echo $row['work_exp'] ?></td>
											<td><?php echo $row['job_desc'] ?></td>
											<td><?php echo $row['address'] ?></td>
											
											<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
											<td class="text-center">
												<?php
													$c_exp_id = $row['id'];		//echo $c_exp_id;
									
													$params=$row['company_name']."#".$row['designation']."#".$row['from_date']."#".$row['to_date']."#".$row['contact']."#".$row['work_exp']."#".$row['job_desc']."#".$row['address'];
													
													if($c_exp_id!=""){	
														if($c_status!='R' && $c_status!='CS'){

														//if(get_dept_folder()=="hr" || $is_role_dir=="admin" || $is_role_dir=="super" || $is_global_access==1){

															echo '<a class="btn btn-warning btn-xs editCandidateExp" c_exp_id="'.$c_exp_id.'" r_id="'.$r_id.'" c_id="'.$c_id.'"  params="'.$params.'" title="Click to Edit Candidate Experience" style="font-size:12px"><i class="fa fa-pencil-square-o"></i></a>'; 
														
														//}
														
														}
													}
												?>
											</td>
											<?php } ?>
										</tr>
									<?php endforeach; ?>
									</tbody>
									</table>
								</td>
								</tr>
								<tr>
								<td align="center"></br><strong>Qualification Details</strong></td>
								<td style="background-color:#EEE">	
									<table  class="table skt-table" cellspacing="0" width="100%" style="background-color:#FFF;margin-bottom:0px;">
										<thead>
											<tr class="">
												<th width="60px">SL.No</th>
												<th>Examination</th>
												<th>Passing Year</th>
												<th>Board/UV</th>
												<th>Specialization</th>
												<th>Grade/CGPA</th>
												<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
													<th width="50px" class="text-center">Action</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
											<?php 
												$q=1;
												foreach (candidate_qual_details($cd['can_id']) as $row):  
											?>
											<tr>
												<td><?php echo $q++; ?></td>
												<td><?php echo $row['exam'] ?></td>
												<td><?php echo $row['passing_year'] ?></td>
												<td><?php echo $row['board_uv'] ?></td>
												<td><?php echo $row['specialization'] ?></td>
												<td><?php echo $row['grade_cgpa'] ?></td>
												
												<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
												<td class="text-center">
													<?php
														$c_qual_id=$row['id'];
														$params=$row['exam']."#".$row['passing_year']."#".$row['board_uv']."#".$row['specialization']."#".$row['grade_cgpa'];
														
														if($c_qual_id!=""){
															if($c_status!='R' && $c_status!='CS'){
																
															//if(get_dept_folder()=="hr" || $is_role_dir=="admin" || $is_role_dir=="super" || $is_global_access==1){
																
																echo '<a class="btn btn-warning btn-xs editCandidateQual" c_qual_id="'.$c_qual_id.'" r_id="'.$r_id.'" c_id="'.$c_id.'"  params="'.$params.'" title="Click to Edit Candidate Qualification" style="font-size:12px"><i class="fa fa-pencil-square-o"></i></a>'; 
															
															//}
															
															}	
														}
													?>
												</td>
												<?php } ?>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</td>
								</tr>
								
								<tr>
								<td align="center"></br><strong>Schedule & Interview </br> Details</strong></td>
								<td style="background-color:#EEE">
									<table  class="table skt-table" cellspacing="0" width="100%" style="background-color:#FFF;margin-bottom:0px;">
										<thead>
											<tr class="">
												<th width="60px">SL.No</th>
												<th>Scheduled On</th>
												<th>Location</th>
												<th>Interview Type</th>
												<th>Assign Interviewer</th>
												<th>Status</th>
												<th>Interviewer</th>
												<th>Result</th>
												<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
													<th>Action</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
											<?php 
												$q = 1;
												foreach (candidate_schedule_details($cd['can_id']) as $row1): 
											?>
											<?php
												$sh_status=$row1['sh_status'];
												
												if($sh_status=='P') $schstatus="Pending";
												else if($sh_status=='N') $schstatus="Not Cleared";
												else if($sh_status=='C')	$schstatus="Cleared";
												else $schstatus="Cancel";
											?>
											<tr>
												<td><?php echo $q++; ?></td>
												<td><?php echo $row1['scheduled_on']; ?></td>
												<td><?php echo $row1['interview_loc']; ?></td>
												<td><?php echo $row1['interview_type_name']; ?></td>
												<td><?php echo $row1['assign_interviewer_name']; ?></td>
												<td><?php echo $schstatus; ?></td>
												<td><?php echo $row1['interviewer_name']; ?></td>
												<td><?php echo $row1['result']; ?></td>
												
												<?php if(is_access_dfr_module()==1){	////ACCESS PART ?>
												<td class="text-center" width="100px">
													<?php 
														$sch_id=$row1['id'];
														$scheduled_on=$row1['scheduled_on'];	//echo $scheduled_on;
														$sch_date=$row1['sch_date'];
														$interview_date=$row1['interview_date'];
														$currDate=date('Y-m-d H:i:s');	//echo $currDate;
														
														
														$params1=$row1['sch_date']."#".$row1['interview_type']."#".$row1['interview_site']."#".$row1['sh_status']."#".$row1['remarks'];
														
														$params2=$row1['interviewer_id']."#".$row1['result']."#".$row1['educationtraining_param']."#".$row1['jobknowledge_param']."#".$row1['workexperience_param']."#".$row1['analyticalskills_param']."#".$row1['technicalskills_param']."#".$row1['generalawareness_param']."#".$row1['bodylanguage_param']."#".$row1['englishcomfortable_param']."#".$row1['mti_param']."#".$row1['enthusiasm_param']."#".$row1['leadershipskills_param']."#".$row1['customerimportance_param']."#".$row1['jobmotivation_param']."#".$row1['resultoriented_param']."#".$row1['logicpower_param']."#".$row1['initiative_param']."#".$row1['assertiveness_param']."#".$row1['decisionmaking_param']."#".$row1['overall_assessment']."#".$row1['interview_remarks']."#".$row1['interview_status']."#".$row1['listen_skill'];
													
													if($c_status!='R' && $c_status!='CS'){
														
													//if(get_dept_folder()=="hr" || get_role_dir()=="admin" || get_role_dir()=="super" || get_global_access()==1){
																
																
															$interview_type = $row1['interview_type'];
															$interview_site = $row1['interview_site'];
															$assign_interviewer = $row1['assign_interviewer'];
															
															//if($required_pos!=$filled_pos){
															
															if($sh_status=="P"){
																
																//if($currDate >= $scheduled_on){
																	echo '<a class="btn btn-success btn-xs candidateAddInterview" title="Add Interview" r_id="'.$r_id.'" c_id="'.$c_id.'" sch_id="'.$sch_id.'" schType="'.$interview_type.'" schSite="'.$interview_site.'" schAssin="'.$assign_interviewer.'" sh_status="'.$sh_status.'" sch_date="'.$sch_date.'" style="font-size:12px"><i class="fa fa-plus"></i></a>';
																/* }else{
																	echo '<a class="btn btn-success btn-xs" disabled="true" title="Button will be active on '.$sch_date.' " style="font-size:12px"><i class="fa fa-plus"></i></a>';
																} */
																
																echo "&nbsp &nbsp";
																
																echo '<a class="btn btn-danger btn-xs cancelSchedule" r_id="'.$r_id.'" c_id="'.$c_id.'" sch_id="'.$sch_id.'" params1="'.$params1.'" title="Cancel Interview Schedule" style="font-size:12px"><i class="fa fa-close"></i></a>';
															
															}else if($sh_status=="C" || $sh_status=="N"){
																echo '<a class="btn btn-primary btn-xs editInterview" r_id="'.$r_id.'" c_id="'.$c_id.'" sch_id="'.$sch_id.'" schType="'.$interview_type.'" schSite="'.$interview_site.'" schAssin="'.$assign_interviewer.'"  params2="'.$params2.'" interview_date="'.$interview_date.'" title="Edit Interview" style="font-size:12px"><i class="fa fa-pencil-square-o"></i></a>';
															
															}
															
															
															//}
														
															
														//}	
														
													}
													?>
												</td>
												<?php } ?>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
									
								</td>	
								</tr>
																
								</table>
								</td>
							</tr>
							
							
							<?php endforeach; ?>
						</tbody>
						
					</table>
					
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
<div class="modal fade" id="editRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
							<label>Due Date</label>
							<input type="text" class="form-control" id="due_date1" name="due_date" value="" required>
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
<div class="modal fade" id="approvalWfmModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmApprovalWfm" action="<?php echo base_url(); ?>dfr/approved_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Approved Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			
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
<div class="modal fade" id="declineWfmModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<!------------------ Candidate Adding -------------------------->

<div class="modal fade" id="addCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	  
	<form class="frmAddCandidate" action="<?php echo base_url(); ?>dfr/add_pool_candidate" data-toggle="validator" method='POST' enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Candidate Details</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
	  
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
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; First Name</label>
						<input type="text" id="fname" name="fname" class="form-control" value="" placeholder="Enter First name" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Last Name</label>
						<input type="text" id="lname" name="lname" class="form-control" value="" placeholder="Enter Last name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
					</div>
				</div>
			</div>
			<div class="row" id="relationid" style="display: none;">
                    <div class="col-sm-6">
                    <div class="form-group">
                      <label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                        <strong>Guardian's Name(Father/Mother/Husband)</strong>
                      </label>
                      <input type="text" name="guardian_name" id="guardian_name" class="form-control" placeholder="Guardian's Name">
                    </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label>
                        	<i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                                <strong>Relation With Guardian</strong>
                        </label>
                        <select name="relation_guardian" id="relation_guardian" class="form-control">
                        <option value="">--Select--</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Husband">Husband</option>
                        <option value="Wife">Wife</option>
                        </select>
                        </div>    
                    </div>
                </div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="exampleInputEmail1">
						<span id="dis_cont_other">	
						  Do you know anyone in Fusion / Are you applying through any Fusion / Xplore-Tech Employee?
						</span>
						<span id="dis_cont_cha" style="display: none;">	
						  Do you know anyone in Fusion / Are you applying through any Fusion / CSPL Employee?
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
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_portal" value="Job Portal" required>
							<label class="form-check-label" for="job_source_portal">Job Portal</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_consult" value="Consultancy" required>
							<label class="form-check-label" for="job_source_consult">Consultancy</label>
						</div>
						<div <?php if(isIndiaLocation()){?>style="display:none"<?php } else { ?>style="display:inline-block"<?php } ?>>
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_callHR" value="Call From HR" required>
							<label class="form-check-label" for="job_source_callHR">Call From HR</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_newspaper" value="Newspaper" required>
							<label class="form-check-label" for="job_source_newspaper">Newspaper</label>
						</div>
						<div <?php if(isIndiaLocation()){?>style="display:none"<?php } else { ?>style="display:inline-block"<?php } ?>>
							<input class="form-check-input_v" type="radio" name="hiring_source" id="job_source_walkin" value="Walkin" required>
							<label class="form-check-label" for="job_source_walkin">Walk In</label>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="not_friend_referal">
				<div class="col-md-6">
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
					  <select class="form-control existing_employee" id="ref_name1" name="ref_name">
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
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Date of Birth</label>
						<input type="text" id="dob" name="dob" class="form-control dobdatepicker" value="" placeholder="Enter DOB" autocomplete="off" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Email ID</label>
						<input type="email" id="email" name="email" class="form-control" value="" placeholder="Enter Email" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Gender</label>
						<select class="form-control" id="gender" name="gender">
							<option value="">--Select--</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Last Qualification</label>
						<input type="text" id="last_qualification" name="last_qualification" class="form-control" value="" placeholder="Enter Last Qualification" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Phone</label>
						<input type="number" id="phone" name="phone" class="form-control" value="" placeholder="Enter Phone no" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Alternate Phone</label>
						<input type="text" id="" name="alter_phone" class="form-control" value="" placeholder="Enter Alternate Phone no">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Skill Set</label>
						<input type="text" id="skill_set" name="skill_set" class="form-control" value="" placeholder="Enter Skill Set">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Total Work Exp.(In Year)</label>
						<input type="text" id="total_work_exp" name="total_work_exp" class="form-control" value="" placeholder="Enter Total Work Exp." onkeyup="checkDec(this);" required>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Experience Level:</label>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="experience" id="experience_fresh" value="Fresher" required>
							<label class="form-check-label" for="experience_fresh">Fresher</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="experience" id="experience_exp" value="Experienced" required>
							<label class="form-check-label" for="experience_exp">Experienced</label>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<label><i class="fa fa-asterisk" id="field_of_interest" style="font-size:6px; color:red"></i> &nbsp; Field of Interest:</label>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="interest" id="interest_voice" value="Voice" required>
							<label class="form-check-label" for="interest_voice">Voice</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="interest" id="interest_back" value="Back Office" required>
							<label class="form-check-label" for="interest_back">Back Office</label>
						</div>
						<div style="display:inline-block">
							<input class="form-check-input_r" type="radio" name="interest" id="interest_other" value="Other" required>
							<label class="form-check-label" for="interest_other">Other</label>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<input type="text" class="form-control" id="interest_desc" name="interest_desc" placeholder="Describe">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label><i class="fa fa-asterisk" id="country_req" style="font-size:6px; color:red"></i> &nbsp; Country</label>
						<input type="text" id="country" name="country" class="form-control" value="" placeholder="Enter Country name" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; State</label>
						<input type="text" id="state" name="state" class="form-control" value="" placeholder="Enter State name" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; City</label>
						<input type="text" id="city" name="city" class="form-control" value="" placeholder="Enter City name" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Post Code</label>
						<input type="text" maxlength="6" id="postcode" name="postcode" class="form-control" value="" placeholder="Enter Postcode" onkeypress="return ValidNumeric()">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label><i class="fa fa-asterisk" id="address_req" style="font-size:6px; color:red"></i> &nbsp; Address</label>
						<textarea class="form-control" id="address" name="address" placeholder="Enter Address details" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Summary</label>
						<textarea class="form-control" id="summary" name="summary" placeholder="Enter Summary details"></textarea>
					</div>
				</div>
			</div>

			<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<label>Onboarding Type</label>
						<select id="onboarding_type" name="onboarding_type" class="form-control">
							<option value="">-- Select type --</option>
							<option value="Regular">Regular</option>
							<option value="NAPS">NAPS</option>
						</select>
					</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Company</label>
							<select id="company" name="company" class="form-control">
								<option value="">-- Select company --</option>
								<?php foreach ($company_list as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

			<div class="row">
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

<div class="modal fade" id="viewCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	  
	<form class="frmAddCandidate" onsubmit="return false" method='POST'>
		
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

<div class="modal fade" id="editCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<div class="col-md-3">
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
				<div class="col-md-3">
					<div class="form-group">
						<label>Date of Birth</label>
						<input type="text" id="dob1" name="dob" class="form-control dobdatepicker" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>First Name</label>
						<input type="text" id="fname" name="fname" class="form-control" value="" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" id="lname" name="lname" class="form-control" value="" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
					</div>
				</div>
			</div>
			<?php 
				if(get_user_fusion_id()!="FKOL000003"){
					$readOnly="readonly";
				}else{
					$readOnly="";
				}
			?> 
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Hiring Source</label>
						<input type="text" <?=$readOnly;?> id="hiring_source" name="hiring_source" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Source Details</label>
						<input type="text" <?=$readOnly;?>  id="ref_name" name="ref_name" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Email ID</label>
						<input type="email" id="email" name="email" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Gender</label>
						<select class="form-control" id="gender" name="gender" required>
							<option value="">--Select--</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Phone</label>
						<input type="number" id="phone" name="phone" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Last Qualification</label>
						<input type="text" id="last_qualification" name="last_qualification" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Skill Set</label>
						<input type="text" id="skill_set" name="skill_set" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Total Work Exp. (In Year)</label>
						<input type="text" id="total_work_exp" name="total_work_exp" class="form-control" value="" onkeyup="checkDec(this);" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Country</label>
						<input type="text" id="country" name="country" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>State</label>
						<input type="text" id="state" name="state" class="form-control" value="" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>City</label>
						<input type="text" id="city" name="city" class="form-control" value=""required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Post Code</label>
						<input type="text" id="postcode" name="postcode" class="form-control" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Address</label>
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
					<label>Onboarding Type</label>
					<select id="onboarding_type" name="onboarding_type" class="form-control">
						<option value="">-- Select type --</option>
						<option value="Regular">Regular</option>
						<option value="NAPS">NAPS</option>
					</select>
				</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Company</label>
						<select id="company" name="company" class="form-control">
							<option value="">-- Select company --</option>
							<?php foreach ($company_list as $key => $value) { ?>
								<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
							<?php } ?>
						</select>
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

<div class="modal fade" id="addCandidateExpModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<input type="text" id="designation" name="designation" class="form-control" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
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
						<input type="text" maxlength="10" minlength="9" id="contact" name="contact" class="form-control" required onkeypress="return ValidNumeric()">
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

<div class="modal fade" id="editCandidateExpModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div class="modal fade" id="addCandidateQualModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<input type="text" id="exam" name="exam" class="form-control" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
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
						<input type="text" id="board_uv" name="board_uv" class="form-control" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Grade/CGPA</label>
						<input type="text" id="grade_cgpa" name="grade_cgpa" class="form-control" onkeyup="checkDec(this);" required>
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

<div class="modal fade" id="editCandidateQualModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<div class="modal fade" id="addScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<div class="modal fade" id="editScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<div class="modal fade" id="cancelScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<div class="modal fade" id="addCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<label>Overall Assessment</label>
						<textarea class="form-control" id="overall_assessment" name="overall_assessment" required></textarea>
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
<div class="modal fade" id="editCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<label>Overall Assessment</label>
						<textarea class="form-control" id="edoverall_assessment" name="overall_assessment" required></textarea>
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

<div class="modal fade" id="candidateSelectInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<!---------------------------------------------------------------------------------------------------------->
<!----------------------------------Candidate Final Approval------------------------------->

<div class="modal fade" id="approvalFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmApprovalFinalSelect" action="<?php echo base_url(); ?>dfr/candidate_final_approval" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Final Candidate Approval(Job Offer)</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="requisition_id" name="requisition_id" value="">
			<input type="hidden" id="c_status" name="c_status" value="">
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Date of Joining</label>
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
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" name="submit" id='finalApproval' class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>


<!----------------------------------Cancel Shortlisted------------------------------->

<div class="modal fade" id="declineFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmDeclineFinalSelect" action="<?php echo base_url(); ?>dfr/candidate_final_decline" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancel Shortlisted</h4>
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

<div class="modal fade" id="finalSelectionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
		
		<form class="frmfinalSelection" action="<?php echo base_url(); ?>dfr/candidate_select_employee" data-toggle="validator" method='POST'>
		
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
						<label>Joining Date</label>
						<input type="text" id="d_o_j" name="doj" class="form-control" required>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Class/Batch Code</label>
						<input type="text" id="batch_code" name="batch_code" class="form-control">
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
						<input type="text" id="lname" name="lname" class="form-control" required>
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
						<label>Date of Birth</label>
						<input type="text" id="d_o_b" name="dob" class="form-control" required>
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
			<div class="row">
				<div class="col-md-6">
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
				<div class="col-md-6">
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
				<div class="col-md-3">
					<div class="form-group">
						<label for="phone">Phone No</label>
						<input type="text" pattern="[1-9]{1}[0-9]{9}" class="form-control" id="phone" placeholder="Phone No" name="phone" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="phone_emar">Phone No (Emergency)</label>
						<input type="text" pattern="[1-9]{1}[0-9]{9}" class="form-control" id="phone_emar" placeholder="Phone No" name="phone_emar">
					</div>
				</div>
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

<div class="modal fade" id="rescheduleCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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




<div class="modal fade" id="candidateNotSelectInterviewModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmCandidateSelectInterviewModel" action="<?php echo base_url(); ?>dfr/candidate_final_interviewStatus" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Reject Candidate</h4>
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

<!-------------------------------------------------------------------------------------------------------------------------->

<div class="modal fade" id="transferSelectedCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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



<div class="modal fade" id="SendBasicLinkModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
	  
	<form class="frmSendBasicLink" action="<?php echo base_url(); ?>dfr/send_basic_link" data-toggle="validator" method='POST' enctype="multipart/form-data">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Candidate to Send Link</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="link_rid" name="rid" value="pool" required>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Requisition Code</label>
						<input type="text" readonly id="link_requisition_id" name="requisition_id" class="form-control" value="pool" required>
					</div>
				</div>
			</div>
			
			<div class="row">
			<div class="col-md-12">
					<div class="form-group">
						<label>Location</label>
						<select class="form-control" id="pool_location" name="pool_location" required>
							<option value="">--Select--</option>
							<?php foreach($location_data as $row): ?>
							<option value="<?php echo $row['abbr']; ?>"><?php echo $row['location']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; First Name</label>
						<input type="text" id="link_fname" name="fname" class="form-control" value="" placeholder="Enter First name" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label> &nbsp; Last Name</label>
						<input type="text" id="link_lname" name="lname" class="form-control" value="" placeholder="Enter Last name" >
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Email</label>
						<input type="text" id="link_email" name="email" class="form-control" value="" placeholder="Enter Email" required >
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>&nbsp; Phone</label>
						<input type="text" id="link_phone" name="phone" class="form-control" value="" placeholder="Enter phone" >
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
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
					
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
					<label>Onboarding Type</label>
						<select id="onboarding_typ" name="onboarding_typ" class="form-control" >
							<option value="">-- Select type --</option>
							<option value="Regular">Regular</option>
							<option value="NAPS">NAPS</option>
						</select>
					</div>
				</div>					
			</div>
			<div class="row">
			<div class="col-md-12">
							<div class="form-group">
								<label>Company</label>
								<select id="company" name="company" class="form-control" >
									<option value="">-- Select company --</option>
									<?php foreach ($company_list as $key => $value) { ?>
										<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>					
			</div>
			
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='btnSendBasicLink' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>



<script type="text/javascript">
	
	function ValidNumeric() {    
    
    var charCode = (event.which) ? event.which : event.keyCode;    
    if (charCode >= 48 && charCode <= 57)    
    { return true; }    
    else    
    { return false; }    
} 
</script>