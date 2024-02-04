<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />

<style>
	td {
		font-size: 10px;
	}

	#default-datatable th {
		font-size: 11px;
	}

	#default-datatable th {
		font-size: 11px;
	}

	.table>thead>tr>th,
	.table>thead>tr>td,
	.table>tbody>tr>th,
	.table>tbody>tr>td,
	.table>tfoot>tr>th,
	.table>tfoot>tr>td {
		padding: 3px;
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
		width: 100%;
		max-width: 380px;
		min-height: 40px;
	}

	.new-width {
		max-width: 480px !important;
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
/*	.dataTables_paginate{

		  position: absolute;
  bottom: -35px;
  left: -15px;
}*/
.table-responsive{
	min-height: 0!important;
	overflow-y: hidden!important;
	
}
.dtr-details{
	width: 100%;
}
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">

			<!-- DataTable -->
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Pending Interview List</h4>

						<?php //if($sh_status=="1") { 
						?>
						<div class="form-group" style='float:right; padding-right:10px;margin-top:-10px;'>
							<a href='javascript:void(0);'  data-val="0" class="button_search_option"> <span style="padding:10px;" class="label label-warning blue-bg">Pending Candidate</span></a>
						</div>
						<?php //}else{ 
						?>
						<div class="form-group" style='float:right; padding-right:10px;margin-top:-10px;'>
							<a href='javascript:void(0);'  data-val="1" class="button_search_option"> <span style="padding:10px;" class="label label-primary blue-bg">All Candidate</span></a>
						</div>
						<?php //} 
						?>

					</header><!-- .widget-header -->
					<hr class="widget-separator">

					<div class="widget-body">

						<!--<form id="form_new_user" method="GET" action="<?php //echo base_url('dfr'); 
																			?>">-->
						<?php echo form_open('', array('method' => 'get','id' => 'dynamic_search_form')) ?>

						<input type="hidden" id="sh_status" name="sh_status" value='<?php //echo $sh_status; 
																					?>'>

						<div class="filter-widget">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Start date</label>
										<input type="text" class="form-control" id="from_date" name="from_date" value="<?php ?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>End date</label>
										<input type="text" class="form-control" id="to_date" name="to_date" value="<?php ?>" autocomplete="off">
									</div>
								</div>

								

								<div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>
                                            <?php foreach ($location_list as $loc) { ?>    
                                                <option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

								<div class="col-sm-3">
									<div class="form-group">
										<label>Requisition</label>
										<select id="requisition" name="requisition[]" class="select-box" placeholder="Select Requisition" multiple>
											<?php foreach ($get_requisition as  $value) {
												echo "<option value='" . $value['requisition_id'] . "'>" . $value['requisition_id'] . "</option>";
											}
											?>

										</select>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group">
										<label>Brand</label>
										<!--<select id="brand" class="select-box">-->
										<select id="brand" name="brand[]" class="select-box" autocomplete="off" placeholder="Select Brand" multiple>
											<?php foreach ($company_list as $key => $value) {
											?>
												<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php  } ?>

										</select>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group">
										<label>Select Client</label>
										<select id="select-client" class="select-box" name="client_id[]" autocomplete="off" placeholder="Select Client" multiple>
											<?php foreach ($client_list as $client) :
											?>
												<option value="<?php echo $client->id; ?>" ><?php echo $client->shname; ?></option>
											<?php endforeach; ?>
										</select>

									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group">
										<label>Select Process</label>
										<select id="select-process" name="process_id" autocomplete="off" placeholder="Select Process" class="select-box">
											<option value="">-- Select Process--</option>
											<?php foreach ($process_list as $process) :
											?>
												<option value="<?php echo $process->id; ?>" ><?php echo $process->name; ?></option>
											<?php endforeach; ?>
										</select>

									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group">
										<label>Select Department</label>
										<select id="select-department" class="select-box" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
											<?php
											foreach ($department_list as $k => $dep) {	
											?>
												<option value="<?php echo $dep['id']; ?>" ><?php echo $dep['shname']; ?></option>
											<?php
											}
											?>
										</select>

									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<button type="button" class="submit-btn" id="search">
											<i class="fa fa-search" aria-hidden="true"></i>
											Search
										</button>
									</div>
								</div>
							</div>
						</div>


						<!--start old backup php code-->
						<?php /*<div class="row" style="display:none;">
							<div class="col-md-2">
								<div class="form-group">
									<label>Location</label>
									<select class="form-control" name="office_id" id="foffice_id">
										<?php
										if (get_global_access() == 1 || get_role_dir() == "super") echo "<option value='ALL'>ALL</option>";
										?>
										<?php foreach ($location_list as $loc) : ?>
											<?php
											$sCss = "";
											//if($loc['abbr']==$oValue) $sCss="selected";
											?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

										<?php endforeach; ?>

									</select>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Requisition</label>
									<select class="form-control" name="requisition_id" id="requisition_id">
										<option value="">ALL</option>
										<?php foreach ($get_requisition as $gr) : ?>
											<?php
											$sRss = "";
											//if($gr['requisition_id']==$requisition_id) $sRss="selected";
											?>
											<option value="<?php echo $gr['requisition_id']; ?>" <?php echo $sRss; ?>><?php echo $gr['requisition_id']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="col-md-1" style="margin-top:25px">
								<div class="form-group">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url() ?>dfr/assigned_interviewer" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
						</div> */ ?>
						<!--end old backup php code-->

						</form>
					</div>
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->
		</div><!-- .row -->
										
		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="widget widget-body">
					<input type="hidden" name="search_click" id="search_click" value="0">
					<input type="hidden" name="button_search_value" id="button_search_value" value="0">
					<input type="hidden" name="data_url" id="data_url" value="<?php echo base_url('dfr_new/getAssignedInterviewerAjaxResponse'); ?>">
						<div class="tbl-container1">
                            <div id="bg_table" class="table-responsive1 new-table tbl-fixed1">
                                <table id="dynamic-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
									<thead>
										<tr class='bg-info'>
											<!-- <th></th> -->
											<th data-priority="1">SL</th>
											<th data-priority="1">Requisition Code</th>
											<th data-priority="1">Last Qualification</th>
											<th data-priority="1">Candidate Name</th>
											<th data-priority="1">Gender</th>
											<th data-priority="1">Mobile</th>
											<th data-priority="1">Skill Set</th>
											<th data-priority="1">Total Exp.</th>
											<th data-priority="1">Attachment</th>
											<th data-priority="1">Status</th>
											<th data-priority="1">Action</th>
											<th>&nbsp;</th>
										</tr>
									</thead>								
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div><!-- .wrap -->

<!-- Default bootstrap-->

<!---------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------->


<!--------------------------------------Cancel Interview Scheduled----------------------------------------------->
<div class="modal fade" id="cancelScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmCancelScheduleCandidate" action="<?php echo base_url(); ?>dfr/cancel_interviewSchedule" data-toggle="validator" method='POST'>

				<div class="modal-header bg-primary">
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
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
									$sCss = "";
									foreach ($user_tlmanager as $tm) :
										if ($tm['id'] == get_user_id()) {
											$sCss = "selected";  ?>
											<option value="<?php echo $tm['id']; ?>" <?php echo $sCss; ?>><?php echo $tm['name']; ?></option>
										<?php } else { ?>
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
										<select class="form-control notranslate" id="educationtraining_param" name="educationtraining_param">
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
										<select class="form-control notranslate" id="jobknowledge_param" name="jobknowledge_param">
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
										<select class="form-control notranslate" id="workexperience_param" name="workexperience_param">
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
										<select class="form-control notranslate" id="analyticalskills_param" name="analyticalskills_param">
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
										<select class="form-control notranslate" id="technicalskills_param" name="technicalskills_param">
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
										<select class="form-control notranslate" id="generalawareness_param" name="generalawareness_param">
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
										<select class="form-control notranslate" id="bodylanguage_param" name="bodylanguage_param">
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
										<select class="form-control notranslate" id="englishcomfortable_param" name="englishcomfortable_param">
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
										<select class="form-control notranslate" id="mti_param" name="mti_param">
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
										<select class="form-control notranslate" id="enthusiasm_param" name="enthusiasm_param">
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
										<select class="form-control notranslate" id="leadershipskills_param" name="leadershipskills_param">
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
										<select class="form-control notranslate" id="customerimportance_param" name="customerimportance_param">
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
										<select class="form-control notranslate" id="jobmotivation_param" name="jobmotivation_param">
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
										<select class="form-control notranslate" id="resultoriented_param" name="resultoriented_param">
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
										<select class="form-control notranslate" id="logicpower_param" name="logicpower_param">
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
										<select class="form-control notranslate" id="initiative_param" name="initiative_param">
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
										<select class="form-control notranslate" id="assertiveness_param" name="assertiveness_param">
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
										<select class="form-control notranslate" id="decisionmaking_param" name="decisionmaking_param">
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
								<select class="form-control notranslate" id="listen_skill" name="listen_skill">
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
								<select class="form-control notranslate" id="result" name="result" required>
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
								<select id="interview_status notranslate" name="interview_status" class="form-control" required>
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
									<?php foreach ($user_tlmanager as $tm) : ?>
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
								<div class="col-md-4">
									<div class="form-group">
										<label style="float:right">Decision Making:</label>
									</div>
								</div>
								<div class="col-md-4">
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
								<textarea class="form-control new-width" id="edoverall_assessment" name="overall_assessment" required> </textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Interview Remarks</label>
								<textarea class="form-control new-width" id="edinterview_remarks" name="interview_remarks"></textarea>
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

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<script>
	$(document).ready(function() {
		$('.select-box').selectize({
			sortField: 'text'
		});
	});
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
	/*$(function() {
		$('#multiselect').multiselect();

		$('.multiselectwithsearch').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});

		var dataTable = $('#default-datatable').DataTable({
			"pageLength": '20',
			 'scrollY': '85vh',
			 'lengthMenu': [
            [20, 50, 100,150,200, -1],
            [20, 50, 100,150,200,'All'],
        ],
        "columnDefs": [
            { "searchable": false, "targets": [0] },  // Disable search on first 
            { "orderable": false, "targets": [0] }    // Disable orderby on first
            ],
        'scrollCollapse': true,
            'processing': true,
            'serverSide': true,
			'responsive': true,
            'serverMethod': 'post',
            'searching': false, // Remove default Search Control
            'ajax': {
                complete: function(data) {
					
                },
                'url': '<?php echo base_url('dfr_new/getAssignedInterviewerAjaxResponse');?>',
                'data': function(data) {
                    // Read values
                    var from_date 		= $('#from_date').val();
                    var to_date 		= $('#to_date').val();
					var office_loc 		= $('#office_loc').val();
					//var office_id 		= $('#office_id').val();
                    var requisition 	= $('#requisition').val();
                    var brand 			= $('#brand').val();
                    var select_client 	= $('#select-client').val();
                    var select_process 	= $('#select-process').val();
                    var select_department = $('#select-department').val();
					var search_click 	= $('#search_click').val();
                    var req_status 		= $('#button_search_value').val();

					data.from_date = from_date;
                    data.to_date = to_date;
					data.office_loc = office_loc;
                    data.requisition_id = requisition;
                    data.brand = brand;
                    data.client_id = select_client;
                    data.process_id = select_process;
					data.department_id = select_department;
                    data.searchClick = search_click;
                    data.sh_status = req_status;
                }
            },
            'columns': [
						//{ data: 'more_button' }, 
                        { data: 'sl' }, 
                        { data: 'requisition_id' },
                        { data: 'last_qualification' },
                        { data: 'candidate_name' },
                        { data: 'gender' },
                        { data: 'phone' },
                        { data: 'skill_set' },
                        { data: 'total_work_exp' },
                        { data: 'attachment' },
                        { data: 'status' },
                        { data: 'action' },
						{ data: 'more_button' },                 
            ]
        });

        $('#search').click(function(e) {
            e.preventDefault();
            $('#search_click').val(1);
            dataTable.draw();
        });

		$('.button_search_option').click(function(){
            var req_status = $(this).data('val');
            $('#button_search_value').val(req_status);
            $('#search_click').val(1);              
            dataTable.draw();
        });		
	});*/

	function candidateAddInterview(){
            var r_id = $(this).attr("r_id");
            var c_id = $(this).attr("c_id");
            var sch_id = $(this).attr("sch_id");
            var sch_date = $(this).attr("sch_date");
            var sh_status = $(this).attr("sh_status");
            var schType = $(this).attr("schType");
            var schSite = $(this).attr("schSite");
            var schAssin = $(this).attr("schAssin");
            $('.frmaddCandidateInterview #r_id').val(r_id);
            $('.frmaddCandidateInterview #c_id').val(c_id);
            $('.frmaddCandidateInterview #sch_id').val(sch_id);
            $('.frmaddCandidateInterview #sh_status').val(sh_status);
            $('.frmaddCandidateInterview #scheduled_date').val(sch_date);
            getInterviewerDropdown(schType, schSite, schAssin, ".frmaddCandidateInterview #interviewer_id", "#addCandidateInterview");
    }

	function getInterviewerDropdown(schType, schSite, schAssin, selObj, model) {
		//alert(schType + " > " + schSite + " > " + schAssin + " > " + model  );
		var URL = '<?php echo base_url(); ?>dfr/getuserclientlist';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url: URL,
			data: 'pid=' + schType + '&interview_site=' + schSite,
			success: function(pList) {
				//alert(pList);
				var json_obj = $.parseJSON(pList); //parse JSON dept_name

				$(selObj).empty();
				$(selObj).append($('<option></option>').val('').html('-- Select --'));
				for (var i in json_obj)
					$(selObj).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name + '-' + json_obj[i].office_id + '-' + json_obj[i].dept_name));
				$('#sktPleaseWait').modal('hide');
				$(selObj).val(schAssin);
				$(model).modal('show');
			},
			error: function() {
				alert('Fail!');
			}

		});
	}

	function editInterview(bttn_var){
		var params2 = bttn_var.getAttribute("params2");               
		var r_id = bttn_var.getAttribute("r_id");
		var c_id = bttn_var.getAttribute("c_id");
		var sch_id = bttn_var.getAttribute("sch_id");
		var interview_date = bttn_var.getAttribute("interview_date");
		var schType = bttn_var.getAttribute("schType");
		var schSite = bttn_var.getAttribute("schSite");
		var schAssin = bttn_var.getAttribute("schAssin");
		var c_status = bttn_var.getAttribute("c_status");
		var arrPrams2 = params2.split("#");
		$('.frmeditCandidateInterview #r_id').val(r_id);
		$('.frmeditCandidateInterview #c_id').val(c_id);
		$('.frmeditCandidateInterview #sch_id').val(sch_id);
		$('.frmeditCandidateInterview #interview_date').val(interview_date);
		$('.frmeditCandidateInterview #interviewer_id').val(arrPrams2[0]);
		$('.frmeditCandidateInterview #result').val(arrPrams2[1]);
		$('.frmeditCandidateInterview #ededucationtraining_param').val(arrPrams2[2]);
		$('.frmeditCandidateInterview #edjobknowledge_param').val(arrPrams2[3]);
		$('.frmeditCandidateInterview #edworkexperience_param').val(arrPrams2[4]);
		$('.frmeditCandidateInterview #edanalyticalskills_param').val(arrPrams2[5]);
		$('.frmeditCandidateInterview #edtechnicalskills_param').val(arrPrams2[6]);
		$('.frmeditCandidateInterview #edgeneralawareness_param').val(arrPrams2[7]);
		$('.frmeditCandidateInterview #edbodylanguage_param').val(arrPrams2[8]);
		$('.frmeditCandidateInterview #edenglishcomfortable_param').val(arrPrams2[9]);
		$('.frmeditCandidateInterview #edmti_param').val(arrPrams2[10]);
		$('.frmeditCandidateInterview #edenthusiasm_param').val(arrPrams2[11]);
		$('.frmeditCandidateInterview #edleadershipskills_param').val(arrPrams2[12]);
		$('.frmeditCandidateInterview #edcustomerimportance_param').val(arrPrams2[13]);
		$('.frmeditCandidateInterview #edjobmotivation_param').val(arrPrams2[14]);
		$('.frmeditCandidateInterview #edresultoriented_param').val(arrPrams2[15]);
		$('.frmeditCandidateInterview #edlogicpower_param').val(arrPrams2[16]);
		$('.frmeditCandidateInterview #edinitiative_param').val(arrPrams2[17]);
		$('.frmeditCandidateInterview #edassertiveness_param').val(arrPrams2[18]);
		$('.frmeditCandidateInterview #eddecisionmaking_param').val(arrPrams2[19]);
		$('.frmeditCandidateInterview #edoverall_assessment').val(arrPrams2[20]);
		$('.frmeditCandidateInterview #edinterview_remarks').val(arrPrams2[21]);
		$('.frmeditCandidateInterview #edinterview_status').val(arrPrams2[22]);
		$('.frmeditCandidateInterview #edlisten_skill').val(arrPrams2[23]);
		getInterviewerDropdown(schType, schSite, schAssin, ".frmeditCandidateInterview #interviewer_id", "#editCandidateInterview");
		if (c_status == "E" || c_status == "CS") {
			$('.frmeditCandidateInterview #addCandidateInterview').hide();
			$('.frmeditCandidateInterview #addCandidateInterview').prop("disabled", true);
			$('.frmeditCandidateInterview textarea').prop("disabled", true);
			$('.frmeditCandidateInterview select').prop("disabled", true);
		} else {
			$('.frmeditCandidateInterview #addCandidateInterview').show();
			$('.frmeditCandidateInterview #addCandidateInterview').prop("disabled", false);
			$('.frmeditCandidateInterview textarea').prop("disabled", false);
			$('.frmeditCandidateInterview select').prop("disabled", false);
		}
	}

	function cancelSchedule(){		
            var id = $(this).attr("id");
            var dis_id = $(this).attr("schedule_id");
            var r_id = $(this).attr("r_id");
            var c_id = $(this).attr("c_id");
            var sch_id = $(this).attr("sch_id");
            $('.frmCancelScheduleCandidate #id').val(id);
            $('.frmCancelScheduleCandidate #r_id').val(r_id);
            $('.frmCancelScheduleCandidate #c_id').val(c_id);
            $('.frmCancelScheduleCandidate #sch_id').val(sch_id);
            $('.frmCancelScheduleCandidate #dis_id').val(dis_id);
            $("#cancelScheduleCandidate").modal('show');       
	}

</script>