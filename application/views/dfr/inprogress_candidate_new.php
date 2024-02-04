<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" />
<style>
	.table {
		margin-bottom:8px;
	}	
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding: 4px;
	}
	.modal .close {
  color: #fff;
  text-shadow: none;
  opacity: 1;
  position: absolute;
  top: -15px;
  right: -14px;
  width: 35px;
  height: 35px;
  background: #0c6bb5;
  border-radius: 50%;
  transition: all 0.5s ease-in-out 0s;
}
.modal textarea {
  width: 100%!important;
  max-width: 100%;
  min-height: 40px;
}
.new-width1{
max-width: 480px!important;
}
.modal-footer .btn {
width: 100px;
padding: 10px;
font-size: 13px;
letter-spacing: 0.5px;
transition: all 0.5s ease-in-out 0s;
border: none;
border-radius: 5px;
}

.dataTables_wrapper .dataTables_paginate{
		float: right;!important;
		margin: 0 100px 0 0;

	}
</style>

<div class="wrap">
	<section class="app-content">
	
		<div class="row">
		
				<div class="col-md-12">
					<div class="widget">
						<header class="widget-header">
							<h4 class="widget-title">In-Progress Candidate Lists</h4>
						</header>
						<hr class="widget-separator">
						
						<div class="widget-body">
						
						<?php echo form_open('',array('method' => 'get','id' => 'dynamic_search_form')) ?>
						
							<input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>' >
							
							<div class="filter-widget">								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start Date</label>
											<input type="text" class="form-control" id="from_date" name="from_date" value="" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End Date</label>
											<input type="text" class="form-control" id="to_date" name="to_date" value="" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Brand</label>
											<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>
												
												<?php foreach ($company_list as $key => $value) { 
												$bss="";
												//if(in_array($value['id'],$brand))$bss="selected";	
												?>	
														<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
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
												//if(in_array($loc['abbr'],$oValue)) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
												
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
												//if(in_array($dep['id'],$o_department_id))$sCss="selected";	
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
												//if(in_array($client->id,$client_id)) $cScc='Selected';
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
												//if($process->id==$process_id) $cScc='Selected';
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
						
					</div>
					
					
					
				</div>	
			</div>
			<input type="hidden" name="search_click" id="search_click" value="0">
        	<input type="hidden" name="button_search_value" id="button_search_value" value="0">	
			<input type="hidden" name="data_url" id="data_url" value="<?php echo base_url('dfr_new_shilpa/getInProgressCandidateAjaxResponse'); ?>">
			<div class="common-top">
				<div class="row">
					<div class="col-sm-12">
						<div class="widget widget-body">
							<div class="table-responsive">
							<table id="dynamic-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										
										<th data-priority="1">SL</th>
										<th data-priority="1">Requision Code</th>
										<th data-priority="1">Last Qualification</th>
										<th data-priority="1">Onboarding Type</th>
										<th data-priority="1">Candidate Name</th>
										<th data-priority="1">Gender</th>
										<th data-priority="1">Mobile</th>
										<th data-priority="1">Skill Set</th>
										<th data-priority="1">Total Exp.</th>
										<th data-priority="1">Attachment</th>
										<th data-priority="1">Status</th>
										
										<?php if(is_access_dfr_module()==1){ 	////ACCESS PART ?>
											<th data-priority="1">Action</th>
										<?php } ?>
										<th>&nbsp;</th>
									</tr>
								</thead>																
							</table>
									
						</div>
						</div>
					</div>
				</div>
			</div>
	
	</section>
</div>	


<!----------------------------------------------------------------------------------------------->

<!---------------------------------------Edit Candidate details------------------------------------------------->

<div class="modal fade" id="editCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<!-------------------------------------------Candidate Experience------------------------------------------------------->

<!---------------------------------Add Experience---------------------------------->

<div class="modal fade" id="addCandidateExpModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<!---------------------------------Edit Experience---------------------------------->

<div class="modal fade" id="editCandidateExpModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<!-------------------------------------------Candidate Qualification------------------------------------------------------->
<!---------------------------------Add Qualification---------------------------------->

<div class="modal fade" id="addCandidateQualModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<!---------------------------------Edit Qualification---------------------------------->

<div class="modal fade" id="editCandidateQualModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<!--------------------------------------------------------------------------------------------------------------->

<!-------------------------------------------Schedule Candidate & Interview------------------------------------------------------>

<!----------------------Candidate add Scheduled rounds-------------------------------->
<div class="modal fade" id="addScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<!--------------------------------------Candidate edit Scheduled----------------------------------------------->
<div class="modal fade" id="editScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>


<!--------------------------------------Cancel Interview Scheduled----------------------------------------------->
<div class="modal fade" id="cancelScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>



<!--------------------------------------Candidate Add Interview Round's---------------------------------------------->
<div class="modal fade" id="addCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
	  
	<form class="frmaddCandidateInterview" action="<?php echo base_url(); ?>dfr/add_candidate_interview" data-toggle="validator" method='POST'>
		
      <div class="modal-header bg-primary">
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
								<select class="form-control" id="educationtraining_param" name="educationtraining_param" required>
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
								<select class="form-control" id="jobknowledge_param" name="jobknowledge_param" required>
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
								<select class="form-control" id="workexperience_param" name="workexperience_param" required>
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
								<select class="form-control" id="analyticalskills_param" name="analyticalskills_param" required>
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
								<select class="form-control" id="technicalskills_param" name="technicalskills_param" required>
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
								<select class="form-control" id="generalawareness_param" name="generalawareness_param" required>
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
								<select class="form-control" id="bodylanguage_param" name="bodylanguage_param" required>
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
								<select class="form-control" id="englishcomfortable_param" name="englishcomfortable_param" required>
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
								<select class="form-control" id="mti_param" name="mti_param" required>
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
								<select class="form-control" id="enthusiasm_param" name="enthusiasm_param" required>
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
								<select class="form-control" id="leadershipskills_param" name="leadershipskills_param" required>
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
								<select class="form-control" id="customerimportance_param" name="customerimportance_param" required>
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
								<select class="form-control" id="jobmotivation_param" name="jobmotivation_param" required>
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
								<select class="form-control" id="resultoriented_param" name="resultoriented_param" required>
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
								<select class="form-control" id="logicpower_param" name="logicpower_param" required>
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
								<select class="form-control" id="initiative_param" name="initiative_param" required>
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
								<select class="form-control" id="assertiveness_param" name="assertiveness_param" required>
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
								<select class="form-control" id="decisionmaking_param" name="decisionmaking_param" required>
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
						<select class="form-control" id="listen_skill" name="listen_skill" required>
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
						<textarea class="form-control new-width" id="overall_assessment" name="overall_assessment" minlength="20" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Remarks</label>
						<textarea class="form-control new-width" id="interview_remarks" name="interview_remarks"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
		
      <div class="modal-header bg-primary">
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
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="submit" id='addCandidateInterview' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!----------------------------------------------Candidate Final Selection----------------------------------------------->

<div class="modal fade" id="candidateSelectInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>


<div class="modal fade" id="candidateNotSelectInterviewModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<!---------------Candidate Transfer-------------------->
<div class="modal fade" id="transferRejectCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
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
  
</script>
