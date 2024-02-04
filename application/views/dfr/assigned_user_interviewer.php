<div class="wrap">
	<section class="app-content">
		<div class="row">
			<!-- DataTable -->
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<div class="row d_flex">
						<div class="col-sm-6">
							<div class="avail_widget_br">
								<h2 class="avail_title_heading">Pending Interview List</h2>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="right_side">
								<?php if ($sh_status == "1") { ?>
									<a href='?sh_status=0' class="btn btn_padding filter_btn blue-bg">Pending Candidate</a>
								<?php } else { ?>
									<a href='?sh_status=1' class="btn btn_padding filter_btn blue-bg">All Candidate</a>
								<?php } ?>
							</div>
						</div>
					</div>
					<hr class="sepration_border">
					<div class="widget-body no_padding">
						<!--<form id="form_new_user" method="GET" action="<?php //echo base_url('dfr'); 
																			?>">-->
						<?php echo form_open('', array('method' => 'get')) ?>
						<input type="hidden" id="sh_status" name="sh_status" value='<?php echo $sh_status; ?>'>
						<div class="body_widget">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Start date</label>
										<input type="text" class="form-control due_date-cal" id="from_date" name="from_date" value="<?php echo $from_date; ?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>End date</label>
										<input type="text" class="form-control due_date-cal" id="to_date" name="to_date" value="<?php echo $to_date; ?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Location</label>
										<select id="multiselectwithsearch" name="office_loc[]" multiple="multiple">
											<?php foreach ($location_list as $loc) : ?>
												<?php
												$sCss = "";
												if (in_array($loc['abbr'], $oValue)) $sCss = "selected";
												?>
												<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

											<?php endforeach; ?>

										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Requisition</label>
										<select id="multiselectwithsearch" name="requisition[]" class="select-box" placeholder="--Select--" multiple>
											<?php foreach ($get_requisition as  $value) {
												echo "<option value='" . $value['id'] . "'>" . $value['requisition_id'] . "</option>";
											}
											?>

										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Brand</label>
										<!--<select id="brand" class="select-box">-->
										<select id="brand" name="brand[]" class="select-box" autocomplete="off" placeholder="--Select--" multiple>
											<?php foreach ($company_list as $key => $value) {
												$bss = "";
												if (in_array($value['id'], $brand)) $bss = "selected";
											?>
												<option value="<?php echo $value['id']; ?>" <?php echo $bss; ?>><?php echo $value['name']; ?></option>
											<?php  } ?>

										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Client</label>
										<select id="select-client" class="select-box" name="client_id[]" autocomplete="off" placeholder="--Select--" multiple>
											<?php foreach ($client_list as $client) :
												$cScc = '';
												if (in_array($client->id, $client_id)) $cScc = 'Selected';
											?>
												<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?>><?php echo $client->shname; ?></option>
											<?php endforeach; ?>
										</select>

									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Process</label>
										<select id="select-process" name="process_id" autocomplete="off" placeholder="--Select--" class="select-box">
											<option value="">--Select--</option>
											<?php foreach ($process_list as $process) :
												$cScc = '';
												if ($process->id == $process_id) $cScc = 'Selected';
											?>
												<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?>><?php echo $process->name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Department</label>
										<select id="select-department" class="select-box" name="department_id[]" autocomplete="off" placeholder="--Select--" multiple>
											<?php
											foreach ($department_list as $k => $dep) {
												$sCss = "";
												if (in_array($dep['id'], $department_id)) $sCss = "selected";
											?>
												<option value="<?php echo $dep['id']; ?>" <?php echo $sCss; ?>><?php echo $dep['shname']; ?></option>
											<?php
											}
											?>
										</select>

									</div>
								</div>
								<div class="col-sm-12">
									<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Search</button>
								</div>
							</div>
						</div>


						<!--start old backup php code-->
						<div class="row" style="display:none;">

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
											if ($loc['abbr'] == $oValue) $sCss = "selected";
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
											if ($gr['requisition_id'] == $requisition_id) $sRss = "selected";
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
						</div>
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
					<div class="white_widget padding_3">
						<div class="row">
							<div class="col-sm-8"></div>
							<div class="col-sm-4">
								<div class="right_side">
									<div class="smart_search">
										<div class="form-group">
											<div class="row d_flex">
												<span class="col-md-3 control-label">Search:</span>
												<div class="col-md-9">
													<input type="text" class="form-control col-sm-9" id="smart_search">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="common_table_widget report_hirarchy_new leave_table table_export">
							<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table">
								<thead>
									<tr>
										<th></th>
										<th>SL. No.</th>
										<th>Requisition Code</th>
										<th>Last Qualification</th>
										<th>Candidate Name</th>
										<th>Gender</th>
										<th>Mobile</th>
										<th>Skill Set</th>
										<th>Total Exp.</th>
										<th>Attachment</th>
										<th>Status</th>
										<th class="leave_columns_fixed leave_columns_fixed_small">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$k = 1;
									$m = 1;
									foreach ($get_assigned_user_interview as $cd) :

										$r_id = $cd['r_id'];
										$c_id = $cd['id'];
										$c_status = $cd['candidate_status'];

										if ($c_status == 'P')	$cstatus = "Pending";
										else if ($c_status == 'IP')	$cstatus = "In Progress";
										else if ($c_status == 'SL')	$cstatus = "Shortlisted";
										else if ($c_status == 'CS')	$cstatus = "Selected";
										else if ($c_status == 'E') $cstatus = "Selected as Employee";
										else if ($c_status == 'R') $cstatus = "Rejected";

										if ($cd['attachment'] != '') $viewResume = 'View Resume';
										else $viewResume = '';
									?>

										<?php
										//if($cd['requisition_id']!=''){
										?>

										<tr class="smart_search_tr">

											<td>
												<?php //if($cid!=""){ 
												?>
												<button type="button" class="btn btn_padding filter_btn plus_icon btn-xs" data-toggle="collapse" data-target="#<?php echo $c_id; ?>" title=""><i class="fa fa-plus"></i></button>
												<?php //} 
												?>
											</td>

											<td><?php echo $k++; ?></td>
											<?php
											if ($cd['requisition_id'] != '') {
												echo '<td>' . $cd['requisition_id'] . '</td>';
											} else {
												echo '<td>Pool</td>';
											}
											?>
											<td><?php echo $cd['last_qualification']; ?></td>
											<td><?php echo $cd['fname'] . " " . $cd['lname']; ?></td>
											<td><?php echo $cd['gender']; ?></td>
											<td><?php echo $cd['phone']; ?></td>
											<td><?php echo $cd['skill_set']; ?></td>
											<td><?php echo $cd['total_work_exp']; ?></td>
											<td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>"><?php echo $viewResume; ?></a></td>
											<td width="80px"><?php echo $cstatus; ?></td>
											<td class="leave_columns_fixed action_column_right leave_columns_fixed_small">
												<?php
												/* $sch_id=$cd['sch_id'];
												$interview_type=$cd['interview_type'];	
												$interview_site=$cd['location'];	//echo $interview_site;
												$requisition_id=$cd['requisition_id'];
												$filled_no_position=$cd['filled_no_position'];
												$req_no_position=$cd['req_no_position'];
												$department_id=$cd['department_id'];
												$role_id=$cd['role_id'];
												$sh_status=$cd['sh_status']; */

												echo '<a class="btn btn-xs action_btn_hover1 viewCandidate" href="' . base_url() . 'dfr/view_candidate_details/' . $c_id . '" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Details"><img src="' . base_url() . 'assets_home_v3/images/edit_icon.svg" alt=""></a>';

												?>
											</td>
										</tr>

										<?php //} 
										?>

										<tr id="<?php echo $c_id; ?>" class="collapse">
											<td colspan="12">
												<table class="table">

													<tr>
														<td align="center"></br><strong>Schedule & Interview </br> Details</strong></td>
														<td>
															<table class="table table-bordered table-striped skt-table" cellspacing="0" width="100%">
																<thead>
																	<tr>
																		<th>SL. No.</th>
																		<th>Scheduled On</th>
																		<th>Location</th>
																		<th>Interview Type</th>
																		<th>Assign Interviewer</th>
																		<th>Status</th>
																		<th>Interviewer</th>
																		<th>Result</th>
																		<th>Action</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$q = 1;
																	foreach (candidate_schedule_details($cd['can_id']) as $row1) :
																	?>
																		<?php
																		$sh_status = $row1['sh_status'];


																		if ($sh_status == 'P') $schstatus = "Pending";
																		else if ($sh_status == 'N') $schstatus = "Not Cleared";
																		else if ($sh_status == 'C')	$schstatus = "Cleared";
																		else $schstatus = "Cancel";
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
																			<td width="100px">
																				<?php
																				$sch_id = $row1['id'];
																				$scheduled_on = $row1['scheduled_on'];	//echo $scheduled_on;
																				$sch_date = $row1['sch_date'];
																				$interview_date = $row1['interview_date'];
																				$currDate = date('Y-m-d H:i:s');	//echo $currDate;

																				$params1 = $row1['sch_date'] . "#" . $row1['interview_type'] . "#" . $row1['interview_site'] . "#" . $row1['sh_status'] . "#" . $row1['remarks'];

																				$params2 = $row1['interviewer_id'] . "#" . $row1['result'] . "#" . $row1['educationtraining_param'] . "#" . $row1['jobknowledge_param'] . "#" . $row1['workexperience_param'] . "#" . $row1['analyticalskills_param'] . "#" . $row1['technicalskills_param'] . "#" . $row1['generalawareness_param'] . "#" . $row1['bodylanguage_param'] . "#" . $row1['englishcomfortable_param'] . "#" . $row1['mti_param'] . "#" . $row1['enthusiasm_param'] . "#" . $row1['leadershipskills_param'] . "#" . $row1['customerimportance_param'] . "#" . $row1['jobmotivation_param'] . "#" . $row1['resultoriented_param'] . "#" . $row1['logicpower_param'] . "#" . $row1['initiative_param'] . "#" . $row1['assertiveness_param'] . "#" . $row1['decisionmaking_param'] . "#" . $row1['overall_assessment'] . "#" . $row1['interview_remarks'] . "#" . $row1['interview_status'] . "#" . $row1['listen_skill'];

																				if ($c_status != 'R' && $c_status != 'CS') {

																					//if(get_dept_folder()=="hr" || get_role_dir()=="admin" || get_role_dir()=="super" || get_global_access()==1){


																					$interview_type = $row1['interview_type'];
																					$interview_site = $row1['interview_site'];
																					$assign_interviewer = $row1['assign_interviewer'];

																					//if($required_pos!=$filled_pos){

																					if ($sh_status == "P") {

																						//if($currDate >= $scheduled_on){
																						echo '<a class="btn btn_left action_btn_hover no_padding btn-xs candidateAddInterview" title="Add Interview" r_id="' . $r_id . '" c_id="' . $c_id . '" sch_id="' . $sch_id . '" schType="' . $interview_type . '" schSite="' . $interview_site . '" schAssin="' . $assign_interviewer . '" sh_status="' . $sh_status . '" sch_date="' . $sch_date . '"><img src="' . base_url() . 'assets_home_v3/images/add.svg" alt=""></a>';
																						/* }else{
																		echo '<a class="btn btn-success btn-xs" disabled="true" title="Button will be active on '.$sch_date.' " style="font-size:12px"><i class="fa fa-plus"></i></a>';
																	} */



																						echo '<a class="btn btn_left action_btn_hover no_padding btn-xs cancelSchedule" r_id="' . $r_id . '" c_id="' . $c_id . '" sch_id="' . $sch_id . '" params1="' . $params1 . '" title="Cancel Interview Schedule"><img src="' . base_url() . 'assets_home_v3/images/cancel.svg" alt=""></a>';
																					} else if ($sh_status == "C" || $sh_status == "N") {
																						echo '<a class="btn btn_left action_btn_hover1 btn-xs editInterview" r_id="' . $r_id . '" c_id="' . $c_id . '" sch_id="' . $sch_id . '" schType="' . $interview_type . '" schSite="' . $interview_site . '" schAssin="' . $assign_interviewer . '"  params2="' . $params2 . '" interview_date="' . $interview_date . '" title="Edit Interview"><img src="' . base_url() . 'assets_home_v3/images/edit_icon.svg" alt=""></a>';
																					}


																					//}


																					//}	

																				}
																				?>
																			</td>
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

</div><!-- .wrap -->

<!-- Default bootstrap-->

<!---------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------->


<!--------------------------------------Cancel Interview Scheduled----------------------------------------------->
<div class="modal fade" id="cancelScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmCancelScheduleCandidate" action="<?php echo base_url(); ?>dfr/cancel_interviewSchedule" data-toggle="validator" method='POST'>

				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
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
					<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
					<button type="submit" id='cancelCandidateSchedule' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
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
					<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
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
								<input type="text" id="scheduled_date" name="interview_date" class="form-control due_date-cal" required>
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
					<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
					<button type="submit" id='addCandidateInterview' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
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
					<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
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
								<input type="text" readonly id="interview_date" name="" class="form-control due_date-cal" required>
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
					<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
					<button type="submit" id='addCandidateInterview' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
				</div>

			</form>

		</div>
	</div>
</div>

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

		$('#multiselectwithsearch').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});
	});

	$(document).ready(function() {
		$('.plus_icon').click(function() {
			$('.plus_icon').removeClass("add_plus");
			$(this).addClass("add_plus");
		});
	});
</script>

<!--start smart search of table-->
<script>
	$(document).ready(function() {
		$("#smart_search").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#default-datatable .smart_search_tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
</script>
<!--end smart search of table-->