<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<style>
	td {
		font-size: 11px;
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
		max-width: 100%;
		min-height: 40px;
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
</style>
<?php 

// echo '<pre>';
// print_r($_SESSION); 
// echo '</pre>';
?>
<div class="wrap">
	<section class="app-content">
		<div class="row">

			<!-- DataTable -->
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Selected Candidate List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">

					<div class="widget-body">

						<?php echo form_open('', array('method' => 'get')) ?>

						<input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>'>

						<div class="filter-widget">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Start Date</label>
										<input type="text" class="form-control" id="from_date" name="from_date" value="<?php echo $from_date; ?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>End Date</label>
										<input type="text" class="form-control" id="to_date" name="to_date" value="<?php echo $to_date; ?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Brand</label>
										<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>

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
									<div class="form-group">
										<label>Location</label>
										<select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>

											<?php
											//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
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
							</div>

							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Select Department</label>
										<select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
											<?php
											foreach ($department_list as $k => $dep) {
												$sCss = "";
												if (in_array($dep['id'], $o_department_id)) $sCss = "selected";
											?>
												<option value="<?php echo $dep['id']; ?>" <?php echo $sCss; ?>><?php echo $dep['shname']; ?></option>
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
									<div class="form-group">
										<label>Select Process</label>
										<select id="fprocess_id" name="process_id" autocomplete="off" placeholder="Select Process" class="select-box">
											<option value="">-- Select Process--</option>
											<?php foreach ($process_list as $process) :
												$cScc = '';
												if ($process->id == $process_id) $cScc = 'Selected';
											?>
												<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?>><?php echo $process->name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3" id="requisation_div" style="display:none;">
									<div class="form-group">
										<label>Requisition</label>
										<select autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="Select Requisition" class="select-box">
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
										<?php if (is_access_dfr_module() == 1) { 	////ACCESS PART 
										?>
											<th>Action</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$k = 1;
									$m = 1;
									// print_r($candidate_selected); exit();
									foreach ($candidate_selected as $cd) :

										$r_id = $cd['r_id'];
										$c_id = $cd['can_id'];
										$bgv_verify_by_name = $cd['bgv_verify_by_name'];
										$bgv_date = $cd['bgv_date'] != '' && $cd['bgv_date'] != '0000-00-00' ? date_format(date_create($cd['bgv_date']), 'd-m-Y') : '';
										$c_status = $cd['candidate_status'];
										$gross_pay = $cd['gross_pay'];

										if ($c_status == 'P')	$cstatus = "Pending";
										else if ($c_status == 'IP')	$cstatus = "In Progress";
										else if ($c_status == 'SL')	$cstatus = "Shortlisted";
										else if ($c_status == 'CS')	$cstatus = "Selected";
										else if ($c_status == 'E') $cstatus = "Selected as Employee";
										else if ($c_status == 'R') $cstatus = "Rejected";

										if ($cd['requisition_status'] == 'CL') {
											$bold = "style='font-weight:bold; color:red'";
										} else {
											$bold = "";
										}

										if ($cd['attachment'] != '') $viewResume = 'View Resume';
										else $viewResume = '';
									?>
										<tr>

											<td><?php echo $k++; ?></td>

											<td <?= $bold; ?>>
												<a href="<?php echo base_url(); ?>dfr/view_requisition/<?php echo $r_id; ?>" target="_blank" <?= $bold; ?>><?php echo $cd['requisition_id']; ?></a>
											</td>

											<td><?php echo $cd['last_qualification']; ?></td>
											<td><?php echo $cd['onboarding_type']; ?></td>
											<td><?php echo $cd['fname'] . " " . $cd['lname']; ?></td>
											<td><?php echo $cd['gender']; ?></td>
											<td><?php echo $cd['phone']; ?></td>
											<td><?php echo $cd['skill_set']; ?></td>
											<td><?php echo $cd['total_work_exp']; ?></td>
											<td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>"><?php echo $viewResume; ?></a></td>
											<td width="70px"><?php echo $cstatus; ?></td>

											<?php if (is_access_dfr_module() == 1) {	////ACCESS PART 
											?>
												<td width="265px">
													<?php

													$sch_id = $cd['sch_id'];
													$interview_type = $cd['interview_type'];
													$interview_site = $cd['location'];	//echo $interview_site;
													$requisition_id = $cd['requisition_id'];
													$filled_no_position = $cd['filled_no_position'];
													$req_no_position = $cd['req_no_position'];
													$department_id = $cd['department_id'];
													$role_id = $cd['role_id'];
													$sh_status = $cd['sh_status'];

													/////buffer//////	
													if ($cd['department_id'] == 6) {
														$req_no_position = ceil($req_no_position + (($req_no_position * 15) / 100));
													} else {
														$req_no_position = $req_no_position;
													}
													////////////

													if (isIndiaLocation($cd['location']) == true) {
														$dob =	date('d/m/Y', strtotime($cd['dob']));
														$doj =  date('d/m/Y', strtotime($cd['doj']));
														$married_date =  date('d/m/Y', strtotime($cd['married_date']));
													} else {
														$dob	=	date('m/d/Y', strtotime($cd['dob']));
														$doj =  date('m/d/Y', strtotime($cd['doj']));
														$married_date =  date('m/d/Y', strtotime($cd['married_date']));
													}

													if (strtoupper($cd['married']) == 'YES') $married = "Married";
													else $married = "UnMarried";


													$params = $cd['requisition_id'] . "#" . $cd['fname'] . "#" . $cd['lname'] . "#" . $cd['hiring_source'] . "#" . $cd['d_o_b'] . "#" . $cd['email'] . "#" . $cd['phone'] . "#" . $cd['last_qualification'] . "#" . $cd['skill_set'] . "#" . $cd['total_work_exp'] . "#" . $cd['country'] . "#" . $cd['state'] . "#" . $cd['city'] . "#" . $cd['postcode'] . "#" . $cd['address'] . "#" . $cd['summary'] . "#" . $cd['attachment'] . "#" . $cd['gender'] . "#" . $cd['org_role'];

													$cparams = $cd['fname'] . "(#)" . $cd['lname'] . "(#)" . $cd['hiring_source'] . "(#)" . $dob . "(#)" . $cd['email'] . "(#)" . $cd['phone'] . "(#)" . $cd['department_id'] . "(#)" . $cd['role_id'] . "(#)" . $doj . "(#)" . $cd['gender'] . "(#)" . $cd['location'] . "(#)" . $cd['job_title'] . "(#)" . str_replace('"', '', str_replace('\\', '', $cd['address'])) . "(#)" . $cd['country'] . "(#)" . $cd['state'] . "(#)" . $cd['city'] . "(#)" . $cd['postcode'] . "(#)" . $cd['client_id'] . "(#)" . $cd['process_id'] . "(#)" . $cd['org_role'] . "(#)" . $cd['gross_pay'] . "(#)" . $cd['pay_type'] . "(#)" . $cd['currency'] . "(#)" . $cd['l1_supervisor'] . "(#)" . $cd['adhar'] . "(#)" . $cd['pan'] . "(#)" . $cd['guardian_name'] . "(#)" . $cd['relation_guardian'] . "(#)" . $cd['caste'] . "(#)" . $married . "(#)" . $married_date . "(#)" . $cd['attachment_bank'] . "(#)" . $cd['bank_name'] . "(#)" . $cd['branch_name'] . "(#)" . $cd['bank_acc_no'] . "(#)" . $cd['ifsc_code'] . "(#)" . $cd['acc_type'];

													if ($c_id != "") {

														echo '<a class="btn btn-success btn-xs viewCandidate" href="' . base_url() . 'dfr/view_candidate_details/' . $c_id . '" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Details" style="font-size:12px"><i class="fa fa-eye"></i></a>';
														echo '&nbsp;';

														if (get_dept_folder() == "hr" || get_global_access() == 1) {

															echo "&nbsp;<a class='btn btn-info btn-xs ' href='" . base_url() . 'dfr/resend_basic_link?r_id=' . $r_id . '&c_id=' . $c_id . "' title='Click to resend apply link'><i class='fa fa-envelope' aria-hidden='true'></i></a>";
															echo '&nbsp;';


															echo '<a class="btn btn-primary btn-xs " href="' . base_url() . 'dfr/resend_doc_link?c_id=' . $c_id . '&requisition_id=' . $requisition_id . '&r_id=' . $r_id . '" title="Click to Resend Document Upload Link" style="font-size:12px"><i class="fa fa-envelope"></i></a>';

															echo '&nbsp;';
														}

														$doc_verify_name = $cd['doc_verify_name'];
														$doc_verify_on = $cd['doc_verify_on'];

														$is_verify_doc = $cd['is_verify_doc'];

														if ($cd['attachment_adhar'] != "") {

															if ($is_verify_doc == 0) {
																echo '<a class="btn btn-success btn-xs VerifyDocuments" rel="' . base_url() . 'dfr/view_uploaded_docs?c_id=' . $c_id . '&requisition_id=' . $requisition_id . '" target="_blank"  is_verify="' . $is_verify_doc . '" c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Documents & Verify" style="font-size:12px"><i class="fa fa-info"></i></a>';
																echo '&nbsp;';
															} else {

																echo '<a class="btn btn-default btn-xs VerifyDocuments" rel="' . base_url() . 'dfr/view_uploaded_docs?c_id=' . $c_id . '&requisition_id=' . $requisition_id . '" target="_blank"  is_verify="' . $is_verify_doc . '" c_id="' . $c_id . '" r_id="' . $r_id . '" title="Already Documents Verified by ' . $doc_verify_name . ' on ' . $doc_verify_on . '" style="font-size:12px"><i class="fa fa-info"></i></a>';

																echo '&nbsp;';
															}
														}


														if ($c_status == 'CS' || $c_status == 'E') {

															//if(get_dept_folder()=="hr" || $is_role_dir=="admin" || $is_role_dir=="super" || get_global_access()==1){

															if ($c_status != 'E') {

																if ($cd['requisition_status'] != 'CL') {

																	if ($req_no_position > $filled_no_position) {

																		// CHECK OFFICE ACCESS
																		$pay_lock = 1;
																		if (isDisablePayrollInfo($cd['location']) == false) {
																			$pay_lock = 0;
																		}

																		if (!empty($cd['l1_supervisor'])) {


																			if (isIndiaLocation($cd['location']) == true) {

																				if ($cd['attachment_adhar'] != "" && $cd['is_verify_doc'] == 1) {
																					echo '<a class="btn btn-primary btn-xs finalSelection" p_access="' . $pay_lock . '" r_id="' . $r_id . '" c_id="' . $c_id . '" cparams="' . $cparams . '" title="" style="font-size:12px" >Add as Employee</a>';

																					echo '&nbsp;';
																				} else {
																					echo '<a class="btn btn-default btn-xs " p_access="' . $pay_lock . '" r_id="' . $r_id . '" c_id="' . $c_id . '" cparams="' . $cparams . '" title="Document Not Upload OR Verified"  style="font-size:12px" >Add as Employee</a>';

																					echo '&nbsp;';
																				}
																			} else {

																				echo '<a class="btn btn-primary btn-xs finalSelection" p_access="' . $pay_lock . '" r_id="' . $r_id . '" c_id="' . $c_id . '" cparams="' . $cparams . '" title="" style="font-size:12px" >Add as Employee</a>';
																				echo '&nbsp;';
																			}
																		} else {

																			echo '<a class="btn btn-xs" onclick="alert(\'L1 Supervisor Not Assigned!\')" style="background-color:#ccc;color:#fff" title="Disabled for L1 Supervisor Not Assigned!" style="font-size:12px" >Add as Employee</a>';
																			echo '&nbsp;';
																		}
																	} else {
																		echo "<span class='label label-info' style='font-size:12px; display:inline-block;'>Filled Position</span>";
																	}
																}
															} else {
																echo "<span class='label label-info' style='font-size:12px; display:inline-block;'>Empolyee</span>";
															}

															//}

															if (get_dept_folder() == "hr" || get_global_access() == 1) {

																//
																echo '&nbsp;<a class="btn btn-success btn-xs viewOfferLetter" href="' . base_url() . 'dfr/candidate_offer_pdf/' . $c_id . '/Y" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Offer Letter " style="font-size:12px"><i class="fa fa-file-pdf-o"></i></a>';

																echo '&nbsp;';

																if ($gross_pay > 0) {

																	echo '<a class="btn btn-success btn-xs " href="' . base_url() . 'dfr/resend_offer_letter?c_id=' . $c_id . '&r_id=' . $r_id . '" title="Click to Resend Offer Letter" style="font-size:12px"><i class="fa fa-envelope"></i></a>';

																	echo '&nbsp;';

//																	if ((isIndiaLocation($cd['location']) == true) and ($cd['org_role'] == 13)) {
//																		echo '<a class="btn btn-default btn-xs letter_of_intent" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Letter of intent" style="font-size:12px" >LOI</a>';
//																		echo "&nbsp;";
//																	}
																}
															}
														}
														echo "&nbsp;";

														if ($c_status != 'P') {

															echo '<a class="btn btn-xs candidateInterviewReport" href="' . base_url() . 'dfr/view_candidate_interview/' . $c_id . '"  target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Interview Report" style="font-size:12px; background-color:#EE8CE4;"><i class="fa fa-desktop"></i></a>';
														}


														echo "&nbsp;";

														echo '<a class="btn btn-danger btn-xs selectedCandidateTransfer" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Transfer Candidate" style="font-size:12px" ><i class="fa fa-exchange"></i></a>';

														echo "&nbsp;";
														echo '<a class="btn btn-warning btn-xs dropCandidateBtn" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Drop Candidate" style="font-size:12px" ><i class="fa fa-trash"></i></a>';
														echo "&nbsp;";
														echo '&nbsp;<a class="btn btn-success btn-xs viewbgv" href="#" bgv="' . $cd['is_bgv_verify'] . '" bgv_by="' . $bgv_verify_by_name . '" bgv_date="' . $bgv_date . '" c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to Update BGV " style="background: #fd8000;color: white;display: inline-block;text-align: center;">B</a>';
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

<!---------------------------------Select candidate as employee---------------------------------->

<div class="modal fade" id="finalSelectionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">

			<form class="frmfinalSelection" action="<?php echo base_url(); ?>dfr/candidate_select_employee" onsubmit="return finalselection()" method='POST'>

				<div class="modal-header bg-primary">
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
								<input type="text" readonly class="form-control" id="location" name="office_id">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Department</label>
								<select class="form-control" id="department_id" name="dept_id" required>
									<option>--select--</option>
									<?php foreach ($get_department_data as $dept) : ?>
										<option value="<?php echo $dept['id']; ?>"><?php echo $dept['shname']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Sub Department</label>
								<select class="form-control" id="sub_dept_id" name="sub_dept_id">
									<option value="">--select--</option>
									<?php foreach ($sub_department_list as $sub_dept) : ?>
										<option value="<?php echo $sub_dept['id']; ?>"><?php echo $sub_dept['name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Emp ID/XPO ID</label>
								<input type="text" id="xpoid" name="xpoid" class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">

								<?php

								if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<label>Joining Date (dd/mm/yyyy)</label>";
								} else {
									echo "<label>Joining Date (mm/dd/yyyy)</label>";
								}

								?>

								<input type="text" id="d_o_j" name="doj" class="form-control" required>
							</div>
						</div>
						<div class="col-md-4">

							<div class="form-group">
								<?php

								if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<label>Date of Birth (dd/mm/yyyy)</label>";
								} else {
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
								<input type="text" id="lname" name="lname" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Gender</label>
								<select id="gender" name="sex" class="form-control" required>
									<option value="">--Select--</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Transgender">Transgender</option>
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
						<div class="col-md-2">
							<div class="form-group">
								<label>Father's/Husband's Name</label>
								<?php

								if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<input type='text' class='form-control' minlength='3' id='father_husband_name' name='father_husband_name' required>";
								} else if (get_user_office_id() == 'ELS') {
									echo "<input type='text' class='form-control' id='father_husband_name' name='father_husband_name'>";
								} else {
									echo "<input type='text' class='form-control' id='father_husband_name' name='father_husband_name'>";
								}
								?>
							</div>
						</div>




						<div class="col-md-2">
							<div class="form-group">
								<label>Relation</label>
								<?php
								if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<select id='relation' name='relation' class='form-control' required>";
								} else if (get_user_office_id() == 'ELS') {
									echo "<select id='relation' name='relation' class='form-control'>";
								} else {
									echo "<select id='relation' name='relation' class='form-control' >";
								}
								?>
								<option value="">--Select--</option>
								<option value="Father">Father</option>
								<option value="Husband">Husband</option>
								<option value="Mother">Mother</option>
								<option value="Wife">Wife</option>
								</select>
							</div>
						</div>

						<div class="col-md-2" id="mother_name_div" style="display:none;">
							<div class="form-group">
								<label>Mother name:</label>
								<input type="text" id="mother_name" name="mother_name" class="form-control character-only" value="" placeholder="Enter your mother name">
								<span id="mother_name_status" style="color:red;font-size:10px;"></span>
							</div>
						</div>




						<div class="col-md-2">
							<div class="form-group">
								<label>Marital Status</label>
								<?php
								if (get_user_office_id() == 'ELS') {
									echo "<select id='marital_status' name='marital_status' class='form-control'>";
								} else {
									echo "<select id='marital_status' name='marital_status' class='form-control' required>";
								}
								?>
								<option value="">--Select--</option>
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
									<?php foreach ($get_countries as $country) : ?>
										<option value="<?php echo $country['name']; ?>"><?php echo $country['name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-2" id="caste_main">
							<div class="form-group">
								<label for="caste">Caste : </label>
								<select class="form-control" id="caste" name="caste">
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
									<?php foreach ($role_list as $role) : ?>
										<option value="<?php echo $role->id ?>" param="<?php echo $role->org_role;  ?>"><?php echo $role->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Select Role Organization</label>
								<select id="org_role_id" name="org_role_id" class="form-control">
									<option>--Select--</option>
									<?php foreach ($organization_role as $org_role) : ?>
										<option value="<?php echo $org_role->id ?>"><?php echo $org_role->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Assign Level-1 Supervisor</label>
								<select id="assigned_to" name="assigned_to" class="form-control" required>
									<option value="">--Select--</option>
									<?php foreach ($tl_list as $tl) : ?>
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
								<select class="form-control" name="payroll_type" id="payroll_type">
									<option value=''>-- Select Payroll Type --</option>
									<?php foreach ($payroll_type_list as $payroll_type) : ?>
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
									<?php foreach ($payroll_status_list as $payroll_status) : ?>
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
								<input type="text" class="form-control" id="currency" placeholder="Currency" name="currency" readonly>
							</div>
						</div>

					</div>

					<div class="row" id="stop_payroll" style="display:none;">
						<input name="payroll_type" value="0" type="hidden">
						<input name="payroll_status" value="0" type="hidden">
						<input name="currency" value="" type="hidden">
						<input name="grosspay" value="0" type="hidden">
					</div>



					<div class="row">
						<div class="col-md-6">
							<div class="form-group" id="client_div">
								<label for="client_id">Select Client(s)</label>
								<select class="form-control" style="width:100%; height:100px" name="client_id[]" id="client_id" multiple="multiple">
									<?php foreach ($client_list as $client) : ?>
										<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" id="process_div">
								<label for="process_id">Select Process(s)</label>
								<select class="form-control" style="width:100%; height:100px" name="process_id[]" id="process_id" multiple="multiple">
									<?php foreach ($process_list as $process) : ?>
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

						if ((get_user_office_id() == 'CEB') && (get_user_office_id() == 'MAN')) {
							$phone_patern = "9,10"; // for 10 11 digits
						}
						if (get_user_office_id() == 'ALB') {
							$phone_patern = "8";  // for 8 digits
						}
						if (get_user_office_id() == 'UKL') {
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

					<div class="row">
						<?php if ((get_user_office_id() != 'ALB') && (get_user_office_id() != 'UKL')) { ?>
							<div class="col-md-3">
								<div class="form-group">
									<?php
									if (isIndiaLocation(get_user_office_id()) == true) $reqCss = "required";
									else $reqCss = "";

									if (get_user_office_id() == 'ELS') {
										echo "<label for='pan_no'>DUI</label>";
									} else if (get_user_office_id() == 'JAM') {
										echo "<label >TRN No.</label>";
									} else {
										echo "<label for='pan_no'>TAX/PAN Number</label>";
									}
									?>
									<input type="text" class="form-control" id="pan_no" name="pan_no" <?php echo $reqCss; ?>>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<?php
									if (get_user_office_id() == 'ELS') {
										echo "<label for='uan_no'>NIT</label>";
										// }else if(get_user_office_id() == 'JAM'){
									} else if (get_user_office_id() == 'JAM') {
										echo "<label for='uan_no'>NIT</label>";
									} else {
										echo "<label for='uan_no'>UAN(EPF) Number</label>";
									}
									?>
									<input type="text" class="form-control" id="uan_no" name="uan_no">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<?php
									if (get_user_office_id() == 'ELS') {
										echo "<label>ISSS</label>";
									} else if (get_user_office_id() == 'JAM') {
										// }else if(get_user_office_id() == 'JAM'){
										echo "<label>NIS</label>";
									} else {
										echo "<label>Existing ESI No</label>";
									}
									?>
									<input type="text" class="form-control" id="esi_no" name="esi_no">
								</div>
							</div>
						<?php } ?>


						<div class="col-md-3">
							<div class="form-group">
								<?php
								if (get_user_office_id() == 'ELS') {
									echo "<label  style='font-size:12px'>AFP</label>";
									$required = '';
									$length = '';
								} else if (get_user_office_id() == 'JAM') {
									echo "<label  style='font-size:12px'>National ID</label>";
									$required = '';
									$length = '';
								} else if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<label  style='font-size:12px'>Social Security No / Aadhaar No</label>";
									$required = 'required';
									$length = 'minlength="12"';
								} else if (get_user_office_id() == 'UKL') {
									echo "<label  style='font-size:12px'>National Insurance Number</label>";
									$required = 'required';
									$length = '';
								} else {
									echo "<label  style='font-size:12px'>Social Security No / Aadhaar No</label>";
									$required = 'required';
									$length = '';
								}

								?>
								<input type="text" class="form-control" id="social_security_no" name="social_security_no" <?php echo $required . " " . $length ?>>
							</div>
						</div>
					</div>
					<!-- bank -->
					<?php if (isIndiaLocation(get_user_office_id()) == true) {

					?>

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
									<!-- <input type="text" readonly class="form-control" id="bank_ifsc" placeholder="IFSC CODE" name="bank_ifsc"> -->
									<select class="form-control" id="acc_type" name="acc_type">
										<option value="Savings">Savings</option>
										<option value="Checking">Checking</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="bank_acc_no">Account Number</label>
									<input type="text" class="form-control" id="bank_acc_no" placeholder="Account No" name="bank_acc_no">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="ifsc_code">IFSC Code</label>
									<input type="text" class="form-control" id="ifsc_code" placeholder="IFSC CODE" name="ifsc_code" pattern="^[A-Z]{4}[0][A-Z0-9]{6}$">
								</div>
							</div>

						</div>
					<?php } ?>
				</div>


				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" id='candidateFinalSelection' class="btn btn-primary" value="Save">
				</div>

			</form>

		</div>
	</div>
</div>


<!---------------Candidate Transfer-------------------->
<div class="modal fade" id="transferSelectedCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmTransferSelectedCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>

				<div class="modal-header bg-primary">
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
							<?php foreach ($getrequisition as $row) { ?>
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
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" class="btn btn-primary" value="Save">
				</div>

			</form>

		</div>
	</div>
</div>



<!--------------- DROP CANDIDATE -------------------->
<div class="modal fade" id="dropCandidateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmdropCandidate" action="<?php echo base_url(); ?>dfr/CandidateDrop" data-toggle="validator" method='POST'>

				<div class="modal-header bg-primary">
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
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" class="btn btn-primary" value="Save">
				</div>

			</form>

		</div>
	</div>
</div>

<!--------------------Update BGV--------------------------------->
<div class="modal fade" id="updateCandidateBGVModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmBGVCandidate" action="<?php echo base_url(); ?>dfr/updateBGV" data-toggle="validator" method='POST' enctype="mulipart/form-data">

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Candidate BGV</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="r_id" name="r_id" class="form-control" required>
					<input type="hidden" id="c_id" name="c_id" class="form-control" required>

					<div class="row" id="bgvdat">
						<div class="col-md-6">
							<div class="form-group">
								<label>Is BGV?</label>
								<select class="form-control" id="is_bgv_verify" name="is_bgv_verify">
									<option value="">-Select-</option>
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
							</div>
						</div>
						<!--<div class="col-md-6">
					<div class="form-group">
						<label>Upload Document</label>
                                                <input type="file" class="form-control" id="bgv_document" name="bgv_document" >
					</div>
				</div>-->
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" class="btn btn-primary frmSaveButton" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>

<!--------------- Verify  CANDIDATE Documents-------------------->
<div class="modal fade" id="VerifyDocumentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form class="frmVerifyDocuments" action="<?php echo base_url(); ?>dfr/verifyDocuments" data-toggle="validator" method='POST'>

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Verify Document</h4>
				</div>
				<div class="modal-body">

					<div class="row">
						<div id='VerifyDocumentsContent' class="col-md-12">



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
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input id="verify_submit_btn" type="submit" name="submit" class="btn btn-primary" value="Save">
				</div>

			</form>

		</div>
	</div>
</div>


<script type="text/javascript">
	document.querySelector("#req_no_position").addEventListener("keypress", function(evt) {
		if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
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
		$('#mother_name').keydown(function(e) {
			$("#mother_name_status").html("");
			if (e.shiftKey && (e.which == 48 || e.which == 49 || e.which == 50 || e.which == 51 || e.which == 52 || e.which == 53 || e.which == 54 || e.which == 55 || e.which == 56 || e.which == 57)) {
				e.preventDefault();
			} else {
				var key = e.keyCode;
				if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
					$("#mother_name_status").html("only Alphabate and space allowed");

					e.preventDefault();
				}
			}
		});
	});

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
	$(document).ready(function() {
		$('.select-box').selectize({
			sortField: 'text'
		});
		$("#training_start_date").datepicker();		
	});
	
</script>