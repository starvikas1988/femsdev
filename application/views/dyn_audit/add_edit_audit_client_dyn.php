<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:30px;
	font-weight:bold;
	background-color:#C0392B;
	color:white;
}

.eml{
	font-weight:bold;
	font-size:18px;
	background-color:#85C1E9;
}
</style>

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
										<input type="hidden" name="ss_id" value="<?php echo $ss_id; ?>">
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										<input type="hidden" class="form-control" name="auditor_id" value="<?php echo $audit_data['entry_by']; ?>">
									</tr>
									<?php
									if($process_id!=''){
										$process_id = $audit_data['process'];
										$process_name = getProcessName($audit_data['process']);
										}
										if($lob_id!=''){
										$lob_id = $audit_data['lob'];
										$lob_name = getLobName($audit_data['lob']);
										}
										if($campaign_id!=''){
										$campaign_id = $audit_data['campaign'];
										$campaign_name = getLobName($audit_data['campaign']);
										}
										$curr_day = date("d");
										if ($audit_data['week'] == '') {
											if ($curr_day >= 1 && $curr_day <= 7) $week = "Week1";
											else if ($curr_day > 7 && $curr_day <= 14) $week = "Week2";
											else if ($curr_day > 14 && $curr_day <= 21) $week = "Week3";
											else if ($curr_day > 21 && $curr_day <= 31) $week = "Week4";
										} else {
											$week = $audit_data['week'];
										}
										$auditorName = $audit_data['auditor_name'];
										$auditDate = $audit_data['audit_date'];
										$ticket_id = $audit_data['ticket_id'];
										$agent_id = $audit_data['agent_id'];
										$agent_name = $audit_data['fname']." ".$audit_data['lname'];
										$xpoid = $audit_data['xpoid'];
										$tl_name = $audit_data['tl_name'];
										$tl_id = $audit_data['tl_id'];
										$tenure = $audit_data['tenure'];
										$phone = $audit_data['phone'];
										$clDate_val = $audit_data['call_date_time'];
										$call_duration = $audit_data['call_duration'];
										$process_id = $audit_data['process'];
										$process_name = $audit_data['process']!=''?getProcessName($audit_data['process']):'NA';
										
										
										$lob_id = $audit_data['lob'];
										$lob_name = $audit_data['lob']!=''?getLobName($audit_data['lob']):'NA';
										
										
										$campaign_id = $audit_data['campaign'];
										$campaign_name = $audit_data['lob']!=''?getLobName($audit_data['lob']):'NA';

										$audit_type_val = $audit_data['audit_type'];
										$audit_type = $audit_data['audit_type'];
										$auditor_type_val = $audit_data['auditor_type'];
										$auditor_type = $audit_data['auditor_type'];
										$vov_val = $audit_data['voc'];
										$voc = $audit_data['voc'];
										$voc_comment = $audit_data['voc_comment'];
										?>
										<?php foreach ($header_details as $key => $h_detail1) {?>
										<tr>
										<?php foreach ($h_detail1 as $key => $h_detail) {
											if($h_detail['is_disabled']==1){
												$disabled = 'readonly';
											}else{
												$disabled = '';
											}
											$field_val = $h_detail['value_variable'];
											if($h_detail['is_required_field']==1){
												$ast = '<span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span>';
												$required = 'required';
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
										?>
										<?php //if($h_detail['input_type']!='hidden'){ ?>
										<td <?php echo $td_class ?> <?php echo $td_visibility ?>><?php echo $h_detail['name'] ?><?php echo $ast ?> :</td>
										<?php //} ?>
										<?php if($h_detail['field_type']=='input'){ ?>
											<?php if($h_detail['is_create_header_column']!=0){ ?>
										<td <?php echo $td_visibility ?>><input type="<?php echo $h_detail['input_type'] ?>" class="form-control" id="<?php echo $h_detail['id_string'] ?>" name="data[<?php echo $h_detail['id_string'] ?>]" value="<?php echo $$field_val; ?>" <?php echo $disabled ?><?php echo $required ?>></td>
										<?php }else{ ?>
											<td <?php echo $td_visibility ?>><input type="<?php echo $h_detail['input_type'] ?>" class="form-control" id="<?php echo $h_detail['id_string'] ?>" value="<?php echo $$field_val; ?>" <?php echo $disabled ?><?php echo $required ?>></td>
											<?php } ?>
										<?php }elseif($h_detail['field_type']=='dropdown'){ 
											$dr_val = explode(',',$h_detail['value_variable']);
											$dr_val1 = $dr_val[0];
											$dr_val2 = $dr_val[1]; ?>
											<td <?php echo $td_class ?>>
											<select class="form-control" id="<?php echo $h_detail['id_string'] ?>" name="data[<?php echo $h_detail['id_string'] ?>]" <?php echo $required ?>>
											<option value="<?php echo $$dr_val1 ?>"><?php echo $$dr_val2 ?></option>
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
											$param_arr[] = $parameter['parameter_name'];
										}
										$paramm = array_count_values((array)$param_arr);
										
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
											<?php $comm_var = str_replace('param','comm',$param_data['short_name']);
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
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]" required><?php echo $audit_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
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
									<?php if($ata_edit!=0){ ?>
										<tr><td colspan=2  style="font-size:16px">Audit By</td><td colspan=4><?php echo $audit_data['ata_auditor_name']; ?></td></tr>
										<tr><td colspan=2  style="font-size:16px">Edit By</td><td colspan=4><?php echo $audit_data['update_name'];; ?></td></tr>
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control" name="note" required><?php echo $audit_data['update_note'] ?></textarea></td></tr>
									<?php } ?>
									
									<?php 
										if($ata_edit==0){
											if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
												<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
										<?php 
											} 
										}else{ 
											if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){
												//if(is_available_qa_feedback($audit_data['entry_date'],72) == true){ ?>
													<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
										<?php 	
												//}
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
