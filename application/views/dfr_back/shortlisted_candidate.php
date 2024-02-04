<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
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
	
	.skt-table td{
       padding: 2px;
	}
	
	.skt-table th{
       padding: 2px;
	}
	.autosch:hover {
    background: #188ae2;
    color: #fff;
}
.autosch {
    background: #fbfbfb;
    padding: 10px;
    cursor: pointer;
    transition: all 0.5s ease-in-out 0s;
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
					
						<?php echo form_open('',array('method' => 'get')) ?>
						
							<input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>' >
							
							<div class="filter-widget">								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start Date</label>
											<input type="text" class="form-control" id="from_date" name="from_date" value="<?php echo $from_date;?>" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End Date</label>
											<input type="text" class="form-control" id="to_date" name="to_date" value="<?php echo $to_date;?>" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Brand</label>
											<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>
												
												<?php foreach ($company_list as $key => $value) { 
												$bss="";
												if(in_array($value['id'],$brand))$bss="selected";	
												?>	
														<option value="<?php echo $value['id']; ?>"<?php echo $bss;?>><?php echo $value['name']; ?></option>
												<?php  }?> 
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Location</label>
											<select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>
												
												<?php
												//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if(in_array($loc['abbr'],$oValue)) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Department</label>
											<select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
											<?php
												foreach($department_list as $k=>$dep){
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
									
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Client</label>
											<select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="Select Client" multiple>	
											<?php foreach($client_list as $client): 
												$cScc='';
												if(in_array($client->id,$client_id)) $cScc='Selected';
											?>
											<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?> ><?php echo $client->shname; ?></option>
											<?php endforeach; ?>	
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Process</label>
											<select id="fprocess_id"  name="process_id" autocomplete="off" placeholder="Select Process" class="select-box" >
											<option value="">-- Select Process--</option>	
											<?php foreach($process_list as $process): 
												$cScc='';
												if($process->id==$process_id) $cScc='Selected';
											?>
											<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?> ><?php echo $process->name; ?></option>
											<?php endforeach; ?>	
											</select>
										</div>
									</div>
									<div class="col-sm-3" id="requisation_div" style="display:none;">
										<div class="form-group">
											<label>Requisition</label>
											<select  autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="Select Requisition" class="select-box">
											<option="">ALL</option>	
											<?php /*foreach($get_requisition as $gr): ?>
											<?php
												$sRss="";
												if($gr['requisition_id']==$requisition_id) $sRss="selected";
											?>
												<option value="<?php echo $gr['requisition_id']; ?>" <?php echo $sRss; ?>><?php echo $gr['requisition_id']; ?></option>
											<?php endforeach;*/ ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="search" id="search" value="Search" class="submit-btn">
												<i class="fa fa-search" aria-hidden="true"></i>
												Search
											</button>
										</div>
									</div>
								</div>
								
							</div>
							
						</form>					
					</div>			
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
		
		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="widget">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requision Code</th>
										<th>Last Qualification</th>
										<th>Onboarding Type</th>
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
								// print_r($candidate_shortlisted);
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
								<td><?php echo $cd['onboarding_type']; ?></td>
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
                                                            if ((isIndiaLocation($cd['location']) == true) and ($cd['org_role'] == 13) and ($department_id == 6) and ($cd['location'] != 'CHA')) {
                                                                echo '<a class="btn btn-default btn-xs letter_of_intent" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Letter of intent" style="font-size:12px" >LOI</a>';
                                                                echo "&nbsp;";
                                                            }
											//if(get_dept_folder()=="hr" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="super" || get_global_access()==1){
											if($cd['location']=='CHA'){
											echo '&nbsp;<a class="btn btn-success btn-xs viewOfferLetter" href="'.base_url().'dfr/candidate_offer_pdf/'.$c_id.'/Y" target="_blank"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to View Offer Letter " style="font-size:12px;background-color:#800080;"><i class="fa fa-file-pdf-o"></i></a>';
													
													echo '&nbsp;';
												}
											if($cd['requisition_status']!='CL'){
												
											if($req_no_position > $filled_no_position){
											
											// CHECK OFFICE ACCESS
											$pay_lock = 1;
											if(isDisablePayrollInfo($cd['location'])==false){ $pay_lock = 0; }
											
											
											echo '<a class="btn btn-success btn-xs candidateApproval" p_access="'.$pay_lock.'" r_id="'.$r_id.'" c_id="'.$c_id.'" req_id="'.$requisition_id.'" c_status="'.$c_status.'" org_role="'.$cd['org_role'].'" gender="'.$cd['gender'].'"  location_id="'.$cd['location'].'" brand_id="'.$cd['company'].'" title="Approval to Final Selection" style="font-size:12px"><i class="fa fa-check-square"></i></a>';
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

										/***********************/
											if($cd['location']=='CHA'){
														if($cd['joining_kit']==''){
														echo '<a class="btn btn-success btn-xs " href="'.base_url().'dfr/download_joining_kit?c_id='.$c_id.'&r_id='.$r_id.'" title="Click to Download Joining Kit" style="font-size:12px;background-color:yellow;"><i class="fa fa-download"></i></a>';
											
													   echo '&nbsp;';
													   // href="'.base_url().'dfr/upload_joining_kit?c_id='.$c_id.'&r_id='.$r_id.'"
													   echo '<a class="btn btn-success btn-xs upload_joining"  c_id="'.$c_id.'" r_id="'.$r_id.'" title="Click to Upload Joining Kit" style="font-size:12px;background-color:orange;"><i class="fa fa-upload"></i></a>';
											
													   echo '&nbsp;';
													 }
													 else
													 {
													 	echo '<a class="btn btn-success btn-xs " href="'.base_url().'uploads/joining_kit/'.$cd['joining_kit'].'" title="Click to Download Joining Kit" style="font-size:12px;" target="_blank"><i class="fa fa-download"></i></a>';
													 }

													}
										/*************************/
										
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
				</div>
			</div>
		</div>
		
	</section>
	
</div><!-- .wrap -->
<!---------------------------------Letter of Intent---------------------------------->

<div class="modal fade" id="letter_of_intent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">

			<form class="frmLetterOfIntent" action="<?php echo base_url(); ?>dfr/loi_send" onsubmit="return finalselection()" method='POST'>

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Letter of Intent</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="r_id" name="r_id">
					<input type="hidden" id="c_id" name="c_id">		
					
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <select id="onboarding_typ" name="onboarding_typ" class="form-control">
                                    <option value="">-- Select type --</option>
                                    <option value="Regular">Regular</option>
                                    <option value="NAPS">NAPS</option>
                                    <option value="Stipend">Stipend</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name</label>                                
                                <input type="text" name="lname" id="lname" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>                                
                                <input type="text" name="email" id="email" class="form-control" value="" readonly>
                            </div>
                        </div> -->
                    </div>

                    <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>First Name</label>								
								<input type="text" name="fname" id="fname" class="form-control" value="" readonly>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Last Name</label>								
								<input type="text" name="lname" id="lname" class="form-control" value="" readonly>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Email</label>								
								<input type="text" name="email" id="email" class="form-control" value="" readonly>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Training Start Date</label>
								<input type="text" name="training_start_date" id="training_start_date" class="form-control" readonly>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Stipend Amount</label>
									<input type="text" name="stipend_amount" id="stipend_amount" class="form-control number-only-no-minus-also">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>CTC Amount</label>
									<input type="text" name="ctc_amount" id="ctc_amount" class="form-control number-only-no-minus-also">
								</div>
							</div>
						</div>

					</div>


					<div class="modal-footer">
                        <span style="float: left;">
                            <label>Candidate History: </label>
                            <span id="user_history">
                            
                            </span>
                        </span>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<input type="submit" name="submit" id='send_loi_button' class="btn btn-primary" value="Save & Send">
					</div>

			</form>

		</div>
	</div>
</div>
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
			<input type="hidden" id="requisition_id" name="requisition_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="location_id" name="location_id" value="">
			<input type="hidden" id="c_status" name="c_status" value="">
			<input type="hidden" id="org_role" name="org_role" value="">
			<input type="hidden" id="gender" name="gender" value="">
			<input type="hidden" id="brand_id" name="brand_id" value="">

			<div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
				<div class="col-md-12" style="border:1px solid; border-color:#a94442;" id="prevUserInfoContent">
						
				</div>
			</div>
			<!-- <hr> -->


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
				
				<div class="col-md-4 indlocation">
					<div class="form-group">
						<label>Variable Pay</label>
						<input type="number" min="0" step="0.01" id="variable_pay" name="variable_pay" class="form-control" autocomplete="off" value='0' >
					</div>
				</div>
			<div class="col-md-4 indlocation"></div>
			<div class="col-md-4 indlocation"></div>
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


<!-------------------------------Candidate Final Approval For Phillipines Start---------->


<div class="modal fade" id="approvalFinalSelectModelPhp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmApprovalFinalSelectPhp" id="candidateSelectionFormPhp" action="<?php echo base_url(); ?>dfr/candidate_final_approval_php" data-toggle="validator" method='POST'>
		
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Final Candidate Approval</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="requisition_id" name="requisition_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="location_id" name="location_id" value="">
			<input type="hidden" id="c_status" name="c_status" value="">
			<input type="hidden" id="org_role" name="org_role" value="">
			<input type="hidden" id="gender" name="gender" value="">
			<input type="hidden" id="brand_id" name="brand_id" value="">

			<div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
				<div class="col-md-12" style="border:1px solid; border-color:#a94442;" id="prevUserInfoContent">
						
				</div>
			</div>
			


			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php 
							if(isIndiaLocation(get_user_office_id())==true )
							{
								echo '<label>Date of Joining (dd/mm/yyyy) &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
							}else{
								  echo '<label>Date of Joining (mm/dd/yyyy) &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
							  }
						?>
						<input type="date" id="doj" name="doj" class="form-control" autocomplete="off" required>
					</div>	
				</div>
				
			<!--	<div class="col-md-12">
					<div class="form-group">
						<label>Approval Comment</label>
						<textarea class="form-control" id="approved_comment" name="approved_comment" required></textarea>
					</div>
				</div>-->
				
			</div>	
			
			<div class="row" id=""> 	
				
								<div class="col-md-6">
					<div class="form-group">
						<label>Job Level &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="job_level" name="job_level" class="form-control" autocomplete="off" required  >
					</div>	
				</div>

				<div class="col-md-6">
					<div class="form-group" >
						<label>Division  &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="division" name="division" class="form-control" autocomplete="off" required  >
					</div>	
				</div>

				<div class="col-md-6">
					<div class="form-group" >
						<label>Immediate Supervisor &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="immediate_supervisor" name="immediate_supervisor" class="form-control" autocomplete="off" required  >
					</div>	
				</div>

				<div class="col-md-6">
					<div class="form-group" >
						<label>Coordinate with &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="coordinate_with" name="coordinate_with" class="form-control" autocomplete="off" required  >
					</div>	
				</div>

				<div class="col-md-6">
					<div class="form-group" >
						<label>Overseas &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="text" id="overseas" name="overseas" class="form-control" autocomplete="off" required  >
					</div>	
				</div>

			<div class="col-md-6">
					<div class="form-group">
						<label>Currency &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<select class="form-control" id="pay_currency" name="pay_currency" disabled>
						<option value="SL">Philippine Peso (PHP)</option>
						
						</select>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>Deminimis &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="number" min="0" step=".01" id="deminimis" name="deminimis" onblur="calculate_total();" class="form-control" autocomplete="off" value='0' >
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>Standard Incentive &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="number" min="0" step=".01" id="standard_incentive" name="standard_incentive" onblur="calculate_total();" class="form-control" autocomplete="off" value='0' >
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>Account Premium &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="number" min="0" step=".01" id="account_premium" name="account_premium" onblur="calculate_total();" class="form-control" autocomplete="off" value='0' >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Night Differential &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="number" min="0" step=".01" id="night_differential" name="night_differential" onblur="calculate_total();" class="form-control" autocomplete="off" value='0' >
					</div>
				</div>
				
				
				
				<div class="col-md-4">
					<div class="form-group" id="">
						<label>Monthly Basic Salary &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="number" min="0" step=".01" id="basic_salary" name="basic_salary" class="form-control" onblur="calculate_total();" onkeyup="checkDec(this);" autocomplete="off" value='0' required  >
					</div>	
				</div>
			
				<div class="col-md-4">
					<div class="form-group" id="">
						<label>Total &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<input type="number" min="0" step=".01" id="total_amount" name="total_amount" class="form-control"  autocomplete="off" value='0' readonly  >
					</div>	
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label>Qualification &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<textarea class="form-control" id="qualification" name="qualification" class="form-control" autocomplete="off" required  ></textarea>
					</div>	
				</div>

			<div class="col-md-12">
					<div class="form-group">
						<label>Job Summary &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
						<textarea class="form-control" id="job_summary" name="job_summary" class="form-control" autocomplete="off" required  ></textarea>
					</div>	
				</div>
			
			<div class="row" id="" style="display:none;">	
				<input name="pay_type" value="0" type="hidden">
				<input name="pay_currency" value="" type="hidden">
				<input name="gross_amount" value="0" type="hidden">
			</div>
			
			
      </div>
	  
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		<input type="button" name="finalcheckphp" id='finalcheckphp' class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>



<div class="modal fade" id="modalfinalchecknowphp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelFinal">Final Confirmation</h4>
      </div>
      <div id="modalfinalchecknowbodyphp" class="modal-body">
	 		</div>
	  	<div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" id="finalcheckedsubmitphp" class="btn btn-success">Submit</button>
      </div>
		</div>
  </div>
</div>


<!-------------------------------Candidate Final Approval For Phillipines end------------>


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
			<input type="hidden" name="req_id" id="req_id" value="">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>List of Requisition</label>
						<!--<select class="form-control" id="req_id" name="req_id">
							<option value="">-Select-</option>
							<option value="0">Pool</option>
							<?php foreach($getrequisition as $row){ ?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['req_desc']; ?></option>
							<?php } ?>
						</select>-->
						<input type="text" name="search_req" id="search_req" class="form-control" placeholder="Type Requisition Number">
						<div id="searchList"></div>
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
<!---------------Joining kit upload-------------------->
<div class="modal fade" id="upload_joining_kit_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
/*$(function() {  
 $('#multiselect').multiselect();

 $('#edurequisition_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#fdoffice_ids').multiselect({
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
/*$(function() {  
 $('#multiselect').multiselect();

 $('#fprocess_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
$(function() {  
        $("#training_start_date").datepicker();
 $('#multiselect').multiselect();

 $('#select-department').multiselect({
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
  function calculate_total(){
		 var v_doj = $('.frmApprovalFinalSelectPhp #doj').val();
		var v_deminimis = $('#deminimis').val();
		var v_standard_incentive = $('#standard_incentive').val();
		var v_account_premium = $('#account_premium').val();
		var v_night_differential = $('#night_differential').val();
		var v_basicsalary = $('#basic_salary').val();
		if(v_deminimis==''){
			$('#deminimis').val(0);
			v_deminimis=0;
		}
		if(v_standard_incentive==''){
			$('#standard_incentive').val(0);
			v_standard_incentive=0;
		}
		if(v_account_premium==''){
			$('#account_premium').val(0);
			v_account_premium=0;
		}
		if(v_night_differential==''){
			$('#night_differential').val(0);
			v_night_differential=0;
		}
		if(v_basicsalary==''){
			$('#basic_salary').val(0);
			v_basicsalary=0;
		}
		
		//console.log(v_basicsalary)
		var v_totalamount = parseFloat(v_deminimis) + parseFloat(v_standard_incentive) + parseFloat(v_account_premium) + parseFloat(v_night_differential) + parseFloat(v_basicsalary);
		console.log('v_total'+ v_totalamount);
		tot=v_totalamount.toFixed(2);
		console.log('tot'+ tot);
		$('#total_amount').val(v_totalamount.toFixed(2));
	}
</script>


<!--summer note editor-->
<script>
	$(document).ready(function() {
  $('#qualification').summernote();
});
$(document).ready(function() {
  $('#job_summary').summernote();
});
</script>
<script>
    $(".candidateApproval").click(function(e){
        $('#sktPleaseWait').modal('show');
        var location=$(this).attr('location_id');
        $.post("<?=base_url()?>dfr/get_indlocation/"+location).done(function(dat){
            $('#sktPleaseWait').modal('hide');
            if(dat==true){
                $(".indlocation").css("display",'block');
        }else{
            $(".indlocation").css("display",'none');
        }
    });       
  
    });
    
</script> 
