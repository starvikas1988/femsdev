<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
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
.table .select2-selection.select2-selection--single{
	height: 40px!important;
}

input[type='checkbox'] { 
margin-left:5px;
 }
 .astrk:after {
    content:" *";
    color: red;
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
							<table class="table table-striped skt-table" style="width:100%;">
								<tbody>
									<tr>
										<td colspan="10" id="theader" style="font-size:30px">OFFICE DEPOT: NPS ACPT FORM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($od_nps_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$clreview_date='';
										}else{
											if($od_nps['entry_by']!=''){
												$auditorName = $od_nps['auditor_name'];
											}else{
												$auditorName = $od_nps['client_name'];
											}
											$auditDate = mysql2mmddyy($od_nps['audit_date']);
											$clDate_val = mysql2mmddyy($od_nps['call_date']);
											$clreview_date = mysql2mmddyy($od_nps['review_date']);
										}
									?>
									<tr>
										<td style="width:150px">Auditor Name:</td>
										<td style="width:400px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td >Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td class="astrk" style="width:150px">Call Date:</td>
										<td colspan="3"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
										</tr>
									<tr>
										<td class="astrk" style="width:150px">Call Duration:</td>
										<td style="width:400px"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $od_nps['call_duration'] ?>" disabled ></td>
										
									
										<td class="astrk">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
												<option value="<?php echo $od_nps['agent_id'] ?>"><?php echo $od_nps['fname']." ".$od_nps['lname'] ?></option>
												
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td colspan="3"><input type="text" class="form-control" id="fusion_id" value="<?php echo $od_nps['fusion_id'] ?>" readonly ></td>
										</tr>
									<tr>
										<td>L1 Supervisor:</td>
										<td >
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $od_nps['tl_id'] ?>"><?php echo $od_nps['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
										<td class="astrk">Survey Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="review_date" name="review_date" value="<?php echo $clreview_date; ?>" disabled></td>
										<td class="astrk">Number of contacts:</td>
										<td colspan="2"><input type="text" class="form-control" id="contacts" name="data[contacts]" value="<?php echo $od_nps['contacts'] ?>" disabled></td>
									</tr>
									<tr>
										
										<td class="astrk">Session ID:</td>
										<td >
											<input type="text" class="form-control" name="data[session_id]" value="<?php echo $od_nps['session_id'] ?>" disabled > 
										</td>
											
										<td class="astrk">NPS Rating:</td>
									<td colspan="2">
											<select class="form-control" id="lob" name="data[nps_rating]" disabled>
												<option value="<?php echo $od_nps['nps_rating'] ?>"><?php echo $od_nps['nps_rating'] ?></option>
												<option value="0">0</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</td>
										<td class="astrk" colspan="2">NPS Type:</td>
										<td >
											<select class="form-control" id="nps_type" name="data[nps_type]" disabled>
												<option value="<?php echo $od_nps['nps_type'] ?>"><?php echo $od_nps['nps_type'] ?></option>
												<option value="Promoter">Promoter</option>
												<option value="Detractor">Detractor</option>
												<option value="Passive">Passive</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="astrk">Connect:</td>
										<td colspan=""><input type="text" class="form-control" id="connect" name="data[connect]" value="<?php echo $od_nps['connect']  ?>" disabled></td>
										<td class="astrk">Resolve:</td>
										<td colspan="2"><input type="text" class="form-control" id="resolve" name="data[resolve]" value="<?php echo $od_nps['resolve']  ?>" disabled></td>
									
										<td class="astrk">Make Easy:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[make_easy]" value="<?php echo $od_nps['make_easy'] ?>" disabled ></td>
									</tr>
									<tr>
										<td class="astrk">Disposition Category:</td>
										<td colspan=""><input type="text" class="form-control" name="data[disposition_cate]" value="<?php echo $od_nps['disposition_cate'] ?>" disabled ></td>

										<td class="astrk">Sub Category:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[sub_cate]" value="<?php echo $od_nps['sub_cate'] ?>" disabled ></td>
									<!-- </tr>
									<tr> -->
										<td class="astrk">Audit Type:</td>
										<td colspan="3">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $od_nps['audit_type'] ?>"><?php echo $od_nps['audit_type'] ?></option>
												
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Wow Call Nomination">Wow Call Nomination</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										
									</tr>
									
									<tr>
										
										<td class="astrk">VOC:</td>
											<td colspan="">
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option value="<?php echo $od_nps['voc'] ?>"><?php echo $od_nps['voc'] ?></option>
													
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
												</select>
											</td>
											
									
									</tr>
									
									
									<tr>
										<td class="astrk">Customer Survey Comment:</td>
										<td colspan="8"><textarea class="form-control"   name="data[customer_survey]" disabled><?php echo $od_nps['customer_survey'] ?></textarea></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td colspan="3">PARAMETER</td>
										<td colspan="2">DATA</td>
										<td colspan="3">COMMENTS</td>
									</tr>
								
									<tr>
										<td class="eml1" colspan="10" style="background-color:#3f5691; color: white;text-align: left;">Connect with the Customer</td>
										
									</tr>
									<tr>
										<td class="eml1" colspan="3">Customer pain point is at what phase in the Customer Journey?</td>
								

										<td rowspan="" colspan="2">
										
										<select class="form-control  " name="data[customer_journey]" id="customer_journey" disabled>
												<option value="">Select</option>
												<option <?php echo $od_nps['customer_journey'] == "Browse / Search"?"selected":"";?> value="Browse / Search">Browse / Search</option>
												<option <?php echo $od_nps['customer_journey'] == "Purchase and Pay"?"selected":"";?> value="Purchase and Pay">Purchase and Pay</option>
												<option <?php echo $od_nps['customer_journey'] == "Wait / Delivery"?"selected":"";?> value="Wait / Delivery">WiWait / Deliveryll</option>
												<option <?php echo $od_nps['customer_journey'] == "Receive"?"selected":"";?> value="Receive">Receive</option>
												<option <?php echo $od_nps['customer_journey'] == "Post Purchase"?"selected":"";?> value="Post Purchase">Post Purchase</option>
												<option <?php echo $od_nps['customer_journey'] == "Vague / Ambiguous"?"selected":"";?> value="Vague / Ambiguous">Vague / Ambiguous</option>
											</select>
										</td>
										
										<td rowspan="" colspan="3"><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $od_nps['cmt1'] ?>" disabled></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan="3">Is it Controllable by Fusion?</td>
								

										<td rowspan="" colspan="2">
										
										<select class="form-control  " name="data[controllable]" id="controllable" disabled>
												<option value="">Select</option>
												<option <?php echo $od_nps['controllable'] == "Controllable"?"selected":"";?> value="Controllable">Controllable</option>
												<option <?php echo $od_nps['controllable'] == "Uncontrollable"?"selected":"";?> value="Uncontrollable">Uncontrollable</option>
										</select>
										</td>
										
										<td rowspan="" colspan="3"><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $od_nps['cmt2'] ?>" disabled></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan="10" style="background-color:#3f5691; color: white;text-align: left;">Service Recovery</td>
										
									</tr>
									<tr>
										<td class="eml1" colspan="3">Can the survey be turned to Promoter easily if someone calls back?</td>
								

										<td rowspan=""colspan="2">
										
										<select class="form-control  " name="data[call_servey]" id="call_servey" disabled>
												<option value="">Select</option>
												<option <?php echo $od_nps['call_servey'] == "Yes - Needs a quick call back"?"selected":"";?> value="Yes - Needs a quick call back">Yes - Needs a quick call back</option>
												<option <?php echo $od_nps['call_servey'] == "Not Really"?"selected":"";?> value="Not Really">Not Really</option>
										</select>
										</td>
										
										<td rowspan="" colspan="3"><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $od_nps['cmt3'] ?>" disabled></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan="10" style="background-color:#3f5691; color: white;text-align: left;">ACPT Categories</td>
										
									</tr>
									<tr>
										<td class="eml1" colspan="3">Level 1</td>
								

										<td rowspan="" colspan="2">
										
										<select class="form-control  " name="data[level1]" id="level1" disabled>
												<option value="">Select</option>
												<option <?php echo $od_nps['level1'] == "Agent Related"?"selected":"";?> value="Agent Related">Agent Related</option>
												<option <?php echo $od_nps['level1'] == "Process Related"?"selected":"";?> value="Process Related">Process Related</option>
												<option <?php echo $od_nps['level1'] == "System Related"?"selected":"";?> value="System Related">System Related</option>
												<option <?php echo $od_nps['level1'] == "Others"?"selected":"";?> value="Others">Others</option>
										</select>
										</td>
										
										<td rowspan="" colspan="3"><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $od_nps['cmt4'] ?>" disabled></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan="3">Level 2</td>
								

										<td rowspan="" colspan="2">
										
										<select class="form-control  " name="data[level2]" id="level2" disabled>
												<option value="">Select</option>
												<option <?php echo $od_nps['level2'] == "Poor Soft Skills"?"selected":"";?> value="Poor Soft Skills">Poor Soft Skills</option>
												<option <?php echo $od_nps['level2'] == "Poor Resolution"?"selected":"";?> value="Poor Resolution">Poor Resolution</option>
												<option <?php echo $od_nps['level2'] == "Previous / Other agent"?"selected":"";?> value="Previous / Other agent">Previous / Other agent</option>
												<option <?php echo $od_nps['level2'] == "OD rules / protocols"?"selected":"";?> value="OD rules / protocols">OD rules / protocols</option>
												<option <?php echo $od_nps['level2'] == "Website"?"selected":"";?> value="Website">Website</option>
												<option <?php echo $od_nps['level2'] == "Internal Tools / System"?"selected":"";?> value="Internal Tools / System">Internal Tools / System</option>
												<option <?php echo $od_nps['level2'] == "Store / Store Employee"?"selected":"";?> value="Store / Store Employee">Store / Store Employee</option>
										</select>
										</td>
										
										<td rowspan="" colspan="3"><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $od_nps['cmt5'] ?>" disabled></td>
										
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="3"><textarea class="form-control"   name="data[call_summary]" disabled><?php echo $od_nps['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control"   name="data[feedback]" disabled><?php echo $od_nps['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($od_nps_id==0){ ?>
											<td colspan=8><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($od_nps['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$od_nps['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($od_nps_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=8><?php echo $od_nps['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=8><?php echo $od_nps['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=8><?php echo $od_nps['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=8><?php echo $od_nps['client_rvw_note'] ?></td></tr>
									<?php } ?>

									<form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="od_nps_id" class="form-control" value="<?php echo $od_nps_id; ?>">
										
										<tr>
											<td colspan="2" style="font-size:16px">Feedback Acceptance</td>
											<td colspan="8">
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $od_nps['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $od_nps['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2"  style="font-size:16px">Review</td>
											<td colspan="8"><textarea class="form-control" name="note" required=""><?php echo $od_nps['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($od_nps['entry_date'],72) == true){ ?>
											<tr>
												<?php if($od_nps['agent_rvw_note']==''){ ?>
													<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									  </form>
									
									<?php 
									if($od_nps_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=10><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($od_nps['entry_date'],72) == true){ ?>
												<tr><td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
									<?php 	
											}
										}
									} 
									?>
									
								</tbody>
							</table>
							<h6 align="center" > <span style="color:blue;"><b>Disclaimer:</b></span >The feedback or analysis on this form is based on the customer's Verbatim ONLY!</h6>
						</div>
					</div>
					
				  </form>
					
				</div>
			</div>
		</div>

	</section>
</div>
