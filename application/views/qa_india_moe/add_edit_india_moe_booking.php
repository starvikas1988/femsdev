<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:12px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#95A5A6;
}

.eml{
	font-weight:bold;
	background-color:#F4D03F;
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
										<td colspan="7" id="theader" style="font-size:30px">India Moe</td>
										<?php
										if($india_moe_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($india_moe['entry_by']!=''){
												$auditorName = $india_moe['auditor_name'];
											}else{
												$auditorName = $india_moe['client_name'];
											}
											$auditDate = mysql2mmddyy($india_moe['audit_date']);
											$clDate_val = mysql2mmddyy($india_moe['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="2">QA Name:</td>
										<td style="width: 250px"><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td style="width:126px;">Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>

									<tr>
										<td colspan="2">Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $india_moe['agent_id'] ?>"><?php echo $india_moe['fname']." ".$india_moe['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $india_moe['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $india_moe['tl_id'] ?>"><?php echo $india_moe['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2">Revenue:</td>
										<td><input type="text" class="form-control" name="data[revenue]" value="<?php echo $india_moe['revenue'] ?>" required></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $india_moe['call_duration'] ?>" required></td>
										<td>Phone Number:</td>
										<td><input type="number" class="form-control" name="data[contact_number]" value="<?php echo $india_moe['contact_number'] ?>" required></td>
									</tr>
									
									<tr>
										<td colspan="2">Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $india_moe['audit_type'] ?>"><?php echo $india_moe['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<?php if(get_login_type()!="client"){ ?>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $india_moe['auditor_type'] ?>"><?php echo $india_moe['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $india_moe['voc'] ?>"><?php echo $india_moe['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:16px; text-align:center;">Overall Score:</td>
										<td><input type="text" readonly id="pre_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php if($india_moe['overall_score']){ echo $india_moe['overall_score']; } else { echo '0.00'; } ?>"></td>
									</tr>
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td colspan=2>Parameter</td><td>Error</td><td>Count</td><td>Score</td><td colspan=2>Remark</td></tr>
									<tr>
										<td colspan=2>Tagging Error Count</td>
										<td>
											<select class="form-control india_moe_point" id="tag_error" name="data[tagging_error]" required>
												<option value="" selected>SELECT</option>
												<option <?php echo $india_moe['tagging_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $india_moe['tagging_error']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>
											<select class="form-control standard india_moe_point_cnt" id="tag_error_count" name="data[tagging_error_cnt]" disabled required>
												<option value="0">SELECT</option>
												<option india_moe_val=15 <?php echo $india_moe['tagging_error_cnt']=='15'?"selected":""; ?> value="15">1</option>
												<option india_moe_val=10 <?php echo $india_moe['tagging_error_cnt']=='10'?"selected":""; ?> value="10">2</option>
												<option india_moe_val=5 <?php echo $india_moe['tagging_error_cnt']=='5'?"selected":""; ?> value="5">3</option>
												<option india_moe_val=0 <?php echo $india_moe['tagging_error_cnt']=='0'?"selected":""; ?> value="0">>=4</option>
											</select>
										</td>
										<td><input type="text" readonly id="tag_error_score" class="form-control error_score" name="data[tag_error_score]" value="<?php echo $india_moe['tag_error_score'] ?>" /></td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $india_moe['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Probing Error Count</td>
										<td>
											<select class="form-control india_moe_point" id="probe_error" name="data[probing_error]" required>
												<option value="" selected>SELECT</option>
												<option  <?php echo $india_moe['probing_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $india_moe['probing_error']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>
											<select class="form-control standard india_moe_point_cnt" id="probing_error_cnt"  name="data[probing_error_cnt]" disabled required>
												<option value='0'>SELECT</option>
												<option india_moe_val=15 <?php echo $india_moe['probing_error_cnt']=='15'?"selected":""; ?> value="15">1</option>
												<option india_moe_val=10 <?php echo $india_moe['probing_error_cnt']=='10'?"selected":""; ?> value="10">2</option>
												<option india_moe_val=5 <?php echo $india_moe['tagginprobing_error_cntg_error_cnt']=='5'?"selected":""; ?> value="5">3</option>
												<option india_moe_val=0 <?php echo $india_moe['probing_error_cnt']=='0'?"selected":""; ?> value="0">>=4</option>
											</select>
										</td>
										<td><input type="text" readonly id="probe_error_score" class="form-control error_score" name="data[probe_error_score]" value="<?php echo $india_moe['probe_error_score'] ?>"></td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $india_moe['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Any other error Count</td>
										<td>
											<select class="form-control india_moe_point" id="other_error" name="data[any_other_error]" required>
												<option value="0" selected>SELECT</option>
												<option <?php echo $india_moe['any_other_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $india_moe['any_other_error']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>
											<select class="form-control standard india_moe_point_cnt" id="any_other_error_cnt"  name="data[any_other_error_cnt]" disabled required>
												<option value='0'>SELECT</option>
												<option india_moe_val=20 <?php echo $india_moe['any_other_error_cnt']=='20'?"selected":""; ?> value="20">1</option>
												<option india_moe_val=15<?php echo $india_moe['any_other_error_cnt']=='15'?"selected":""; ?> value="15">2</option>
												<option india_moe_val=10<?php echo $india_moe['any_other_error_cnt']=='10'?"selected":""; ?> value="10">3</option>
												<option india_moe_val=0 <?php echo $india_moe['any_other_error_cnt']=='0'?"selected":""; ?> value="0">4</option>
											</select>
										</td>
										<td><input type="text" class="form-control error_score"  readonly id="any_other_error_score"  name="data[any_other_error_score]" value="<?php echo $india_moe['any_other_error_score'] ?>"></td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $india_moe['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Fallout</td>
										<td>
											<select class="form-control india_moe_point_cnt all_fatal" id="fallout_error" name="data[fallout_error]" required>
												<option value='---' selected>SELECT</option>
												<option <?php echo $india_moe['fallout_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $india_moe['fallout_error']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2></td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $india_moe['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td>FT Reason:</td>
										<td colspan=3>
											<select class="form-control standard" id="standardization1" name="data[ft_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $india_moe['ft_reason']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option <?php echo $india_moe['ft_reason']=='OLP'?"selected":""; ?> value="OLP">OLP</option>
												<option <?php echo $india_moe['ft_reason']=='CONSENT STATEMENT'?"selected":""; ?> value="CONSENT STATEMENT">CONSENT STATEMENT</option>
												<option <?php echo $india_moe['ft_reason']=='OPT'?"selected":""; ?> value="OPT">OPT</option>
												<option <?php echo $india_moe['ft_reason']=='CLP'?"selected":""; ?> value="CLP">CLP</option>
												<option <?php echo $india_moe['ft_reason']=='NC'?"selected":""; ?> value="NC">NC</option>
												<option <?php echo $india_moe['ft_reason']=='AD'?"selected":""; ?> value="AD">AD</option>
												<option <?php echo $india_moe['ft_reason']=='AGE'?"selected":""; ?> value="AGE">AGE</option>
												<option <?php echo $india_moe['ft_reason']=='MISLEADING STATEMENT'?"selected":""; ?> value="MISLEADING STATEMENT">MISLEADING STATEMENT</option>
												<option <?php echo $india_moe['ft_reason']=='INHABIT'?"selected":""; ?> value="INHABIT">INHABIT</option>
												<option <?php echo $india_moe['ft_reason']=='LESS VOX SIZE'?"selected":""; ?> value="LESS VOX SIZE">LESS VOX SIZE</option>
												<option <?php echo $india_moe['ft_reason']=='ZTP'?"selected":""; ?> value="ZTP">ZTP</option>
												<option <?php echo $india_moe['ft_reason']=='RECORDING ISSUE'?"selected":""; ?> value="RECORDING ISSUE">RECORDING ISSUE</option>
												<option <?php echo $india_moe['ft_reason']=='9*'?"selected":""; ?> value="9*">9*</option>
												<option <?php echo $india_moe['ft_reason']=='7*'?"selected":""; ?> value="7*">7*</option>
												<option <?php echo $india_moe['ft_reason']=='UNPROFESSIONAL CALL'?"selected":""; ?> value="UNPROFESSIONAL CALL">UNPROFESSIONAL CALL</option>
												<option <?php echo $india_moe['ft_reason']=='OTHERS'?"selected":""; ?> value="OTHERS">OTHERS</option>
												<option <?php echo $india_moe['ft_reason']=='VOX NOT FOUND'?"selected":""; ?> value="VOX NOT FOUND">VOX NOT FOUND</option>
											</select>
										</td>
										<td>ZIP:</td>
										<td colspan=3>
											<select class="form-control standard" id="standardization1" name="data[zip_error]" required>
												<option value='---'>Select</option>
												<option <?php echo $india_moe['zip_error']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option <?php echo $india_moe['zip_error']=='Survey done for TPS Customer'?"selected":""; ?> value="Survey done for TPS Customer">Survey done for TPS Customer</option>
												<option <?php echo $india_moe['zip_error']=='Fake App'?"selected":""; ?> value="Fake App">Fake App</option>
												<option <?php echo $india_moe['zip_error']=='Rude/Misbehaviour'?"selected":""; ?> value="Rude/Misbehaviour">Rude/Misbehaviour</option>
												<option <?php echo $india_moe['zip_error']=='Unprofessional Call'?"selected":""; ?> value="Unprofessional Call">Unprofessional Call</option>
												<option <?php echo $india_moe['zip_error']=='Survey done below 18yrs'?"selected":""; ?> value="Survey done below 18yrs">Survey done below 18yrs</option>
												<option <?php echo $india_moe['zip_error']=='Agent hangs up while cust still on line'?"selected":""; ?> value="Agent hangs up while cust still on line">Agent hangs up while cust still on line</option>
											</select>
										</textarea></td>
									</tr>
									<tr>
										<td>Call Status:</td>
										<td colspan=3>
											<select class="form-control standard" id="standardization1" name="data[call_status]" required>
											<option value='---'>Select</option>
											<option <?php echo $india_moe['call_status']=='Approved'?"selected":""; ?> value="Approved">Approved</option>
											<option <?php echo $india_moe['call_status']=='Approved with FYI'?"selected":""; ?> value="Approved with FYI">Approved with FYI</option>
											<option <?php echo $india_moe['call_status']=='Approved with Error'?"selected":""; ?> value="Approved with Error">Approved with Error</option>
											<option <?php echo $india_moe['call_status']=='Fallout'?"selected":""; ?> value="Fallout">Fallout</option>
											</select>
										</td>
										<td>QA Comments:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $india_moe['feedback'] ?></textarea></td>
									</tr>

									<?php if($india_moe_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files</td>
										<td colspan=5><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files</td>
										<?php if($india_moe['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$india_moe['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/india_moe/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/india_moe/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									<?php if($india_moe_id!=0){ ?>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $india_moe['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $india_moe['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $india_moe['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:12px">Your Review</td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $india_moe['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>
									
									
									<?php 
									if($india_moe_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=7 style="font-size:12px; font-weight:bold"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($india_moe['agent_rvw_note']=="") { ?>
												<tr><td colspan="7" style="font-size:12px; font-weight:bold"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
									<?php 	
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
