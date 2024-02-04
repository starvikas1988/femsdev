<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 30px;
		font-weight: bold;
		background-color: #C0392B;
		color: white;
	}

	.eml {
		font-weight: bold;
		font-size: 18px;
		background-color: #85C1E9;
	}

	.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
		float: left;
		background: #900;
		display: none;
	}
</style>

<?php
// if ($audit_data['audit_status'] == 3 && $audit_data['agnt_fd_acpt'] == "" && $audit_data['audit_type'] == 'CQ Audit') {
if ($audit_data['agnt_fd_acpt'] == "" && $audit_data['audit_type'] == 'CQ Audit') {
} else if ($audit_data['agnt_fd_acpt'] != 'Not Accepted' && $audit_data['audit_type'] == 'CQ Audit' && $audit_data['audit_status'] == 0) { ?>
	<style>
		.form-control {
			pointer-events: none;
			background-color: #D5DBDB;
		}
	</style>
<?php } ?>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
					<form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">

						<div class="widget-body">
							<div class="table-responsive">
								<table class="table table-striped skt-table" width="100%">
									<tbody>
										<tr style="background-color:#AEB6BF">
											<td colspan="6" id="theader"><?php echo $audit_name ?></td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($ss_id == 0) {
											$auditorName = get_username();
											$auditDate = GetLocalMDYDate();
											$auditorCenter = $auditorLocation;
											$clDate_val = '';
										} else {
											if ($audit_data['entry_by'] != '') {
												$auditorName = $audit_data['auditor_name'];
											} else {
												$auditorName = $audit_data['client_name'];
											}
											$auditorCenter = $audit_data['auditor_center'];
											//$auditDate = mysql2mmddyy($audit_data['audit_date']);
											$auditDate = ConvServerToLocal($audit_data['entry_date']);
											$clDate_val = mysqlDt2mmddyy($audit_data['call_date_time']);
										}

										/////////////////////////////////////

										// if ($rand_ssid != 0) {
										// 	$xpoid = $rand_data['xpoid'];
										// 	$agent_id = $rand_data['user_id'];
										// 	$agent_name = $rand_data['fname'] . " " . $rand_data['lname'] . " - " . $rand_data['xpoid'];
										// 	$tl_id = $rand_data['tl_id'];
										// 	$tl_name = $rand_data['tl_name'];
										// 	$ticket_id = $rand_data['call_hit_referenceno'];
										// 	$tenure = $rand_data['tenure'];
										// 	$call_duration = $rand_data['duration'];
										// 	$phone = $rand_data['phone_no'];
										// 	$disposition = $rand_data['status'];
										// 	$campaign = $rand_data['campaign'];
										// 	$sub_disposition = $rand_data['sub_status'];
										// 	$clDate_val = mysqlDt2mmddyy($rand_data['call_time']);
										// } else {
											$xpoid = $audit_data['xpoid'];
											$agent_id = $audit_data['agent_id'];
											$agent_name = $audit_data['fname'] . " " . $audit_data['lname'] . " - " . $audit_data['xpoid'];
											$tl_id = $audit_data['tl_id'];
											$tl_name = $audit_data['tl_name'];
											$ticket_id = $audit_data['ticket_id'];
											$tenure = $audit_data['tenure'];
											// $call_duration = $audit_data['call_duration'];
											// $phone = $audit_data['phone'];
											// $disposition = $audit_data['disposition'];
											// $sub_disposition = $audit_data['sub_disposition'];
											if ($ss_id == 0) {
												$clDate_val = '';
											} else {
												$clDate_val = mysqlDt2mmddyy($audit_data['call_date_time']);
											}
										//}
										
										$process_id = $audit_data['process'];
										$process_name = $audit_data['process']!=''?getProcessName($audit_data['process']):'NA';
										
										
										$lob_id = $audit_data['lob'];
										$lob_name = $audit_data['lob']!=''?getLobName($audit_data['lob']):'NA';
										
										
										$campaign_id = $audit_data['campaign'];
										$campaign_name = $audit_data['lob']!=''?getLobName($audit_data['lob']):'NA';
										
										$curr_day = date("d");
										if ($audit_data['week'] == '') {
											if ($curr_day >= 1 && $curr_day <= 7) $week = "Week1";
											else if ($curr_day > 7 && $curr_day <= 14) $week = "Week2";
											else if ($curr_day > 14 && $curr_day <= 21) $week = "Week3";
											else if ($curr_day > 21 && $curr_day <= 31) $week = "Week4";
										} else {
											$week = $audit_data['week'];
										}
										$audit_type_val = $audit_data['audit_type'];
										$audit_type = $audit_data['audit_type'];
										$auditor_type_val = $audit_data['auditor_type'];
										$auditor_type = $audit_data['auditor_type'];
										// $vov_val = $audit_data['voc'];
										// $voc = $audit_data['voc'];
										// $voc_comment = $audit_data['voc_comment'];
										?>
										<?php foreach ($header_details as $key => $h_detail1) {?>
										<tr>
										<?php foreach ($h_detail1 as $key => $h_detail) {
											if($h_detail['is_disabled']==1){
												$disabled = ' disabled';
											}else{
												$disabled = '';
											}
											$field_val = $h_detail['value_variable'];
											if($h_detail['is_mandatory']==1){
											$field_value = $$field_val;
											}else{
												$field_value = $audit_data[$field_val];
											}
											if($h_detail['is_required_field']==1){
												$ast = '<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>';
												$required = ' required';
											}else{
												$ast = '';
												$required = '';
											}
											if($h_detail['id_string'] == 'auditor_type'){
												$td_class = 'class="auType"';
											}else{
												$td_class = '';
											}
											if($h_detail['input_type']=='hidden'){
												$td_visibility = 'style="display:none;"';
											}else{
												$td_visibility = 'style="width:230px"';
											}
											if($h_detail['field_type']=='datepicker'){
												$readonly = ' readonly';
											}else{
												$readonly = '';
											}
										?>
										<?php //if($h_detail['input_type']!='hidden'){ ?>
										<td <?php echo $td_class ?> <?php echo $td_visibility ?>><?php echo $h_detail['name'] ?><?php echo $ast ?> :</td>
										<?php //} ?>
										<?php if($h_detail['field_type']=='input' || $h_detail['field_type']=='datepicker'){ ?>
											<?php if($h_detail['is_create_header_column']!=0){ ?>
										<td <?php echo $td_visibility ?>><input type="<?php echo $h_detail['input_type'] ?>" class="form-control" id="<?php echo $h_detail['id_string'] ?>" name="data[<?php echo $h_detail['id_string'] ?>]" value="<?php echo $field_value; ?>" <?php echo $disabled ?><?php echo $required ?><?php echo $readonly ?>></td>
										<?php }else{ ?>
											<td <?php echo $td_visibility ?>><input type="<?php echo $h_detail['input_type'] ?>" class="form-control" id="<?php echo $h_detail['id_string'] ?>" value="<?php echo $field_value; ?>" <?php echo $disabled ?><?php echo $required ?>></td>
											<?php } ?>
										<?php }elseif($h_detail['field_type']=='dropdown'){ 
											if($h_detail['is_mandatory']==1){
											$dr_val = explode(',',$h_detail['value_variable']); 
											$dr_val1 = $dr_val[0];
											$field_dr1 = $$dr_val1;
											$dr_val2 = $dr_val[1];
											$field_dr2 = $$dr_val2;
											}else{
												$field_dr1 = $audit_data[$field_val];
												$field_dr2 = $audit_data[$field_val];
											}
											?>
											<td <?php echo $td_class ?>>
											<select class="form-control" id="<?php echo $h_detail['id_string'] ?>" name="data[<?php echo $h_detail['id_string'] ?>]" <?php echo $required ?>>
											<option value="<?php echo $field_dr1 ?>"><?php echo $field_dr2 ?></option>
											<?php if ($ss_id == 0) { ?>
												<option value="">-Select-</option>
												<?php
												if (strpos($h_detail['dropdown_values'], 'dynarr_') !== false) {
													$drdwn_arr_string = substr($h_detail['dropdown_values'],7);
												foreach ($$drdwn_arr_string as $row) {
													$sel = "";
													if ($ss_id != 0) {
														if ($row['id'] == $audit_data['agent_id']) $sel = "selected";
													}
												?>
													<option value="<?php echo $row['id']; ?>" <?php echo $sel; ?>><?php echo $row['name'] . " - " . $row['xpoid']; ?></option>
											<?php }}else{ 
												$drdwn_arr = explode(',',$h_detail['dropdown_values']);
												foreach($drdwn_arr as $valu){ ?>
											<option value="<?php echo $valu ?>"><?php echo $valu ?></option>
											<?php }}
											} ?>
											</select>
											</td>
										<?php } ?>
										<?php } ?>
										</tr>
											<?php } ?>
										
										<tr style="font-weight:bold">
											<td style="font-size:18px; text-align:right">Earn Score:</td>
											<td><input type="text" class="form-control" id="earnScore" name="data[earn_score]" value="<?php echo $audit_data['earn_score'] ?>" readonly></td>
											<td style="font-size:18px; text-align:right">Possible Score:</td>
											<td><input type="text" class="form-control" id="possibleScore" name="data[possible_score]" value="<?php echo $audit_data['possible_score'] ?>" readonly></td>
											<td style="font-size:18px; text-align:right">Total Score:</td>
											<td><input type="text" class="form-control adtFatal" id="overallScore" name="overall_score" value="<?php echo $audit_data['overall_score'] ?>" readonly></td>
										</tr>
										<tr style="font-weight:bold">
											<td><input type="hidden" class="form-control" id="adt_prefatal" name="data[pre_fatal_score]" value="<?php echo $audit_data['pre_fatal_score'] ?>"></td>
											<td><input type="hidden" class="form-control" id="adt_fatalcount" name="data[fatal_count]" value="<?php echo $audit_data['fatal_count'] ?>"></td>
										</tr>
										<!-- parameter section -->
										<tr style="height:25px; background-color:#114150; font-weight:bold">
											<td style="color:white">CALL AUDIT PARAMETERS</td>
											<td colspan=2 style="color:white">OBJECTIVES</td>
											<td style="color:white">STATUS</td>
											<td colspan=2 style="color:white">Remarks</td>
										</tr>
										<?php //$c = 0;
										$f = 1;
										foreach($parameter_details as $parameter){
											$param_arr[] = trim($parameter['parameter_name']);
										}
										$paramm = array_count_values($param_arr);
										
										foreach($parameter_details as $param_data){ 
											if($param_data['is_fatal']==1){
												$fatal_style = 'style="color:red"';
												$class = 'class="form-control audit_point adt_fatal" id="auditAF'.$f.'"';
												$f++;
												}else{
													$fatal_style = '';
													$class = 'class="form-control audit_point"';
												}
											?>
											<tr>
												<?php if (array_key_exists($param_data['parameter_name'], $paramm)){ ?>
											<td <?php echo $fatal_style ?> rowspan="<?php echo $paramm[$param_data['parameter_name']] ?>"><?php echo $param_data['parameter_name'] ?></td>
											<?php unset($paramm[$param_data['parameter_name']]);
										} ?>
										
											<td colspan=2 <?php echo $fatal_style ?>><?php echo $param_data['sub_parameter_name'] ?></td>
											<td>
												<select <?php echo $class ?> name="data[<?php echo $param_data['short_name'] ?>]" required>
													<option adt_val=<?php echo $param_data['weightage'] ?> <?php echo $audit_data[$param_data['short_name']] == 'Pass' ? "selected" : ""; ?> value="Pass">Pass</option>
													<option adt_val=<?php echo $param_data['weightage'] ?> <?php echo $audit_data[$param_data['short_name']] == 'Fail' ? "selected" : ""; ?> value="Fail">Fail</option>
													<option adt_val=<?php echo $param_data['weightage'] ?> <?php echo $audit_data[$param_data['short_name']] == 'N/A' ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<?php //$comm_var = 'comm_'.$c;
											$comm_var = str_replace('param','comm',$param_data['short_name']);
											//$c++; ?>
											<?php if($param_data['comment_type']==2){ ?>
											<td colspan=2><input type="text" class="form-control" name="data[<?php echo $comm_var ?>]" value="<?php echo $audit_data[$comm_var] ?>"></td>
											<?php }elseif($param_data['comment_type']==1){ 
												//$sen_name = $param_data['short_name'].'_scenario';
												$sen_arr = explode(',', $param_data['scenario_data']);
												?>
											<td colspan=2>
											<select class="form-control" name="data[<?php echo $comm_var ?>]" >
												<option value="<?php echo $audit_data[$comm_var] ?>"><?php echo $audit_data[$comm_var] ?></option>
												<option value="">Select</option>
												<?php foreach($sen_arr as $sen_data){ ?>
												<option value="<?php echo $sen_data ?>"><?php echo $sen_data ?></option>
												<?php } ?>
												<option value="N/A">N/A</option>
											</select>
										</td>
											<?php }else{ ?>
												<td colspan=2>--</td>
											<?php } ?>
										</tr>
											<?php } ?>
										
										
										<tr>
											<td>Call Summary<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]" required><?php echo $audit_data['call_summary'] ?></textarea></td>
											<td>Feedback<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]" required><?php echo $audit_data['feedback'] ?></textarea></td>
										</tr>

										<tr id="certificationAudit" style="background-color:#D4E6F1;display:none;">
											<td>Certification Attempt</td>
											<td>
												<select class="form-control1" style="background-color:#D4E6F1; width:200px; height:40px" id="certification_attempt" name="data[certification_attempt]">
													<option value="">-Select-</option>
													<option value="1">First Attempt</option>
													<option value="2">Second Attempt</option>
													<option value="3">Third Attempt</option>
												</select>
											</td>
											<td>Certification Status</td>
											<td colspan=3>
												<select class="form-control1" style="background-color:#D4E6F1; width:200px; height:40px" id="certification_status" name="data[certification_status]">
													<option value="">-Select-</option>
													<option value="certified">Certified</option>
													<option value="not_certified">Not Certified</option>
												</select>
											</td>
										</tr>

										<tr style="background-color:#F5B7B1">
											<td colspan="2">Upload Audio Files</td>
											<td colspan=2><input type="file" accept="audio/*" multiple class="form-control audioFile" id="attach_file" name="attach_file[]"></td>
											<td colspan=2>
												<?php echo '<a class="btn btn-warning" style="font-size:15px" href="' . base_url() . 'Qa_cashify/record_audio/' . $ss_id . '" target="a_blank" style="margin-left:5px; font-size:10px;">Record Audio Here</a>';  ?>
											</td>
										</tr>

										<tr style="background-color:#F5B7B1">
											<td colspan="2"></td>

											<?php
											if ($audit_data['attach_file'] != '') { ?>
												<td colspan="4">
													<?php $attach_file = explode(",", $audit_data['attach_file']);
													foreach ($attach_file as $mp) { ?>
														<audio controls='' style="background-color:#607F93">
															<source src="<?php echo base_url(); ?>qa_files/<?php echo $p_name;?>/<?php echo $mp; ?>" type="audio/ogg">
															<source src="<?php echo base_url(); ?>qa_files/<?php echo $p_name;?>/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													<?php } ?>
												</td>
											<?php } else {
												echo '<td colspan="4"><b>No Audio Files Uploaded</b></td>';
											}
											?>
										</tr>

										<?php if ($rand_ssid != 0) { ?>
											<tr style="background-color:#F5B7B1">
												<td colspan="2">Play Audio File</td>
												<td colspan=2><audio controls>
														<source src="<?php echo base_url(); ?>call_recording/<?php echo $rand_data['recording_file']; ?>" type="audio/mpeg">
													</audio></td>
												<input type="hidden" name="convox_audio" value="<?php echo $rand_data['recording_file']; ?>">
											</tr>
										<?php } ?>
										<tr style="background-color:#F5B7B1">
											<td colspan="2">Upload Screenshot Files</td>
											<?php if ($ss_id == 0) { ?>
												<td colspan=2><input type="file" accept="image/*" multiple class="form-control imageFile" name="attach_img_file[]"></td>
												<?php } else {
												if ($audit_data['attach_img_file'] != '') { ?>
													<td colspan="4">
														<?php $attach_img_file = explode(",", $audit_data['attach_img_file']);
														foreach ($attach_img_file as $mp) { ?>
															<button class="btn btn-info"><a href="<?php echo base_url(); ?>qa_files/<?php echo $p_name;?>/images/<?php echo $mp; ?></a></button>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan="4"><b>No Screenshot Files Uploaded</b></td>';
												}
											} ?>
										</tr>

										<tr>
											<td colspan="6" style="background-color:#C5C8C8"></td>
										</tr>

										<?php if ($ss_id != 0) { ?>

											<tr>
												<?php
												if ($audit_data['agnt_fd_call'] == 'Not Accepted') $agntStyle = 'style="color:red"';
												else $agntStyle = 'style="color:green"';
												?>
												<td style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td <?php echo $agntStyle ?>><?php echo $audit_data['agnt_fd_acpt'] ?></td>
												<td style="font-size:16px; font-weight:bold">Review Comment:</td>
												<td colspan=3><?php echo $audit_data['agent_rvw_note'] ?></td>
											</tr>
											<!------------------------>
											<?php if ((get_role_dir() == 'manager' || get_role_dir() == 'tl') && get_dept_folder() == 'qa') { ?>
												<tr style="background-color:#D7BDE2">
													<td style="font-size:16px; font-weight:bold">QA Rebuttal:</td>
													<td><?php echo $audit_data['qa_rebuttal'] ?></td>
													<td style="font-size:16px; font-weight:bold">Rebuttal By:</td>
													<td><?php echo $audit_data['qa_rebuttal_name'] ?></td>
													<td style="font-size:16px; font-weight:bold">Rebuttal Comment:</td>
													<td colspan=2><?php echo $audit_data['qa_rebuttal_comment'] ?></td>
												</tr>
												<tr style="background-color:#D7BDE2">
													<td style="font-size:16px; font-weight:bold">QA TL/Manager Rebuttal:</td>
													<td><?php echo $audit_data['qa_mgnt_rebuttal'] ?></td>
													<td style="font-size:16px; font-weight:bold">TL/Manager Rebuttal By:</td>
													<td><?php echo $audit_data['qa_mgnt_rebuttal_name'] ?></td>
													<td style="font-size:16px; font-weight:bold">TL/Manager Rebuttal Comment:</td>
													<td colspan=2><?php echo $audit_data['qa_mgnt_rebuttal_comment'] ?></td>
												</tr>
											<?php } else if (get_role_dir() == 'agent' && get_dept_folder() == 'qa') { ?>
												<tr style="background-color:#D7BDE2">
													<td style="font-size:16px; font-weight:bold">QA Rebuttal:</td>
													<td><?php echo $audit_data['qa_rebuttal'] ?></td>
													<td style="font-size:16px; font-weight:bold">Rebuttal By:</td>
													<td><?php echo $audit_data['qa_rebuttal_name'] ?></td>
													<td style="font-size:16px; font-weight:bold">Rebuttal Comment:</td>
													<td colspan=2><?php echo $audit_data['qa_rebuttal_comment'] ?></td>
												<?php } else { ?>
													<!--<tr>
												<td>TL/Manager Feedback Status</td>
												<td>
													<select class="form-control1" name="mgnt_welcome_fd" required>
														<option value="">-Select-</option>
														<option <?php echo $audit_data['mgnt_call_fd'] == 'Accepted' ? "selected" : ""; ?> value="Accepted">Accepted</option>
														<option <?php echo $audit_data['mgnt_call_fd'] == 'Not Accepted' ? "selected" : ""; ?> value="Not Accepted">Not Accepted</option>
													</select>
												</td>
												<td>TL/Manager Review</td>
												<td colspan=3><textarea class="form-control1" style="width:250px; height:40px" id="note" name="note" required><?php echo $audit_data['mgnt_rvw_note'] ?></textarea></td>
											</tr>-->
												<?php } ?>

												<tr>
													<td colspan="6" style="background-color:#C5C8C8"></td>
												</tr>

												<!-------------------- QA REBUTTAL ---------------------->
												<?php

												if ($audit_data['audit_type'] == 'CQ Audit' && $audit_data['agnt_fd_acpt'] == 'Not Accepted') {

													/*  if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){ 
												$rebuttal_name='qa_rebuttal';
												$rebuttal_cmt_name='qa_rebuttal_comment';
											}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
												$rebuttal_name='qa_mgnt_rebuttal';
												$rebuttal_cmt_name='qa_mgnt_rebuttal_comment';
											}   */
												?>
													<?php

													if (get_role_dir() == 'agent' && get_dept_folder() == 'qa') { ?>
														<tr style="background-color:#D4E6F1">
															<td>QA's Rebuttal</td>
															<td>
																<select class="form-control1" style="background-color:#D4E6F1; width:200px; height:40px" name="qa_rebuttal" required>
																	<option value="">-Select-</option>
																	<option value="Accepted">Accepted</option>
																	<option value="Not Accepted">Not Accepted</option>
																</select>
															</td>
															<td>Rebuttal Comment</td>
															<td colspan=3><textarea class="form-control1" style="background-color:#D4E6F1; width:500px; height:80px" name="qa_rebuttal_comment" required></textarea></td>
														</tr>
													<?php } else if ((get_role_dir() == 'manager' || get_role_dir() == 'tl') && get_dept_folder() == 'qa') { ?>
														<tr style="background-color:#D4E6F1">
															<td>QA's <?php echo get_role_dir() ?> Rebuttal</td>
															<td>
																<select class="form-control1" style="background-color:#D4E6F1; width:200px; height:40px" name="qa_mgnt_rebuttal" required>
																	<option value="">-Select-</option>
																	<option value="Accepted">Accepted</option>
																	<option value="Not Accepted">Not Accepted</option>
																</select>
															</td>
															<td>Rebuttal Comment</td>
															<td colspan=3><textarea class="form-control1" style="background-color:#D4E6F1; width:500px; height:80px" name="qa_mgnt_rebuttal_comment" required></textarea></td>
														</tr>
													<?php } ?>
													<!------------------------------------------------------->

											<?php }
											}
											?>

											<?php
											if ($ss_id == 0) {
												if (is_access_qa_module() == true || is_access_qa_operations_module() == true || is_quality_access_trainer() == true) { ?>
													<tr>
														<td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
													</tr>
											<?php
												}
											} else {
												if (is_access_qa_module() == true || is_access_qa_operations_module() == true || is_quality_access_trainer() == true) {
													if ($audit_data['agnt_fd_acpt'] == 'Not Accepted' && $audit_data['audit_type'] == 'CQ Audit') {
														if ((get_role_dir() == 'agent' && get_dept_folder() == 'qa') && $audit_data['qa_rebuttal'] == '') {
															echo '<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" name="btnSave" value="SAVE" style="width:500px">SUBMIT QA REBUTTAL</button></td></tr>';
														} else if (((get_role_dir() == 'manager' || get_role_dir() == 'tl') && get_dept_folder() == 'qa') && $audit_data['qa_mgnt_rebuttal'] == '') {
															echo '<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" name="btnSave" value="SAVE" style="width:500px">SUBMIT REBUTTAL</button></td></tr>';
														}
													} else if ($audit_data['audit_type'] != 'CQ Audit') {
														echo '<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" name="btnSave" value="SAVE" style="width:500px">SAVE</button></td></tr>';
													} else if ($audit_data['agnt_fd_acpt'] != 'Not Accepted' && $audit_data['agnt_fd_acpt'] != 'Accepted') {
														//else if($audit_data['audit_status']==3 && $audit_data['agnt_fd_acpt']=='')	{
														echo '<input type="hidden" name="audit_status" value="' . $audit_data['audit_status'] . '">';
														echo '<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" name="btnSave" value="SAVE" style="width:500px">SAVE</button></td></tr>';
													}
												}
											}
											?>

									</tbody>
								</table>
							</div>
						</div>

					</form>

				</div>
			</div>
		</div>

	</section>
</div>