
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	font-weight:bold;
	background-color:#CCD1D1;
}

.eml2{
	font-size:24px;
	font-weight:bold;
	background-color:#008B8B;
	color:white;
}

.eml1{
	font-size:20px;
	font-weight:bold;
	background-color:#AED6F1;
}

.emp2{
	font-size:16px; 
	font-weight:bold;
}

.seml{
	font-size:15px;
	font-weight:bold;
	background-color:#CCD1D1;
}
.new-table .select2-selection--single,.new-table  .select2-selection__arrow  {
	height: 40px!important;
}

.select2-selection.select2-selection--single .select2-selection__rendered {
    line-height: 40px !important;
}
 .new-table .select2-container{
 	width: 100%!important;
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
							<table class="table table-striped skt-table new-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="11" id="theader" style="font-size:30px"><?php echo ucfirst($page); ?> QA Form</td></tr>
									<input type="hidden" name="data[audit_start_time]" value="<?php echo $stratAuditTime; ?>">
									<tr>
										<td colspan="1">QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td ><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td colspan="1">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="text" name="data[audit_date]" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled>
										</td>
										<td colspan="1">Phone:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="number" class="form-control" id="phone" name="data[phone]" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td colspan="1">Agent:<span style="font-size:24px;color:red">*</span></td>
										<td  >
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="text" class="form-control" id="fusion_id" disabled></td> 
										<td colspan="1">L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td  colspan="3">
											<select class="form-control" id="tl_id" name="data[tl_id]" required>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									
									<tr>
										<td style="font-weight:bold" colspan="1">File No:</td>
										<td ><input type="text" class="form-control"  name="data[file_no]" required></td>
										<td colspan="1">Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="text" class="form-control" onkeydown="return false;" id="call_date" name="call_date" required></td>
										<td colspan="1">Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" required></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td >
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType_epi" colspan="1">Auditor Type</td>
										<td class="auType_epi" colspan="3">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3">
											<select class="form-control" id="voc" name="data[voc]" required>
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
										<td style="font-weight:bold" colspan="1">Campaign Code:<span style="font-size:24px;color:red">*</span></td>
										<td ><input type="text" class="form-control"  name="data[site]" required></td>
										<td colspan="1">Filler 2:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="text" class="form-control" id="filler" name="data[filler]" required></td>
										<td colspan="1">Area Code:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="text" class="form-control" id="area_code" name="data[area_code]" required></td>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="conduent_earn_score" name="data[earned_score]" value=""></td><td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="conduent_possible_score" name="data[possible_score]" value=""></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="3"><input type="text" readonly class="form-control conduentFatal" id="conduent_overall_score" name="data[overall_score]" value=""></td>
									</tr>
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=4>Sub Category</td>
										<td class="eml2">Score</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=2>Remarks</td>
										<td class="eml2">Critical Error</td>
										</tr>
									<tr>
										<td rowspan=2 class="eml1">Introduction and Call Path Procedure</td>
										<td class="eml" colspan=4>Call opening with Brand Name (5 secs)
										</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points business" name="data[brand_name]" required>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Personalize the call (Address the customer by their name at least once during the call)</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points business"  name="data[least_once]" required>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td rowspan=5 class="eml1">Script and FAQ's</td>
										<td class="eml" colspan=4>Verified the customer's name,address,email and phone number</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points compliance_round"  name="data[phone_number]" required>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt3]"></td>
									<td>Compliance Critical</td>
								</tr>
									
									<tr>
										<td class="eml" colspan=4>Correct use of Flagging & Notating</td>
										<td>10</td>
										<td>
											<select class="form-control conduent_points business"  name="data[flagging_notating]" required>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt4]"></td>
									<td>Business Critical</td>
								</tr>
									
									<tr>
										<td class="eml" colspan=4>Transfer to store if required</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points business"  name="data[if_required]" required>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt5]"></td>
									<td>Business Critical</td>
								</tr>
									
									<tr>
										<td class="eml" colspan=4>Did the agent follow training docs along with ACP and Blains Website</td>
										<td>10</td>
										<td>
											<select class="form-control conduent_points business"  name="data[blains_website]" required>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt6]"></td>
									<td>Business Critical</td>
								</tr>
									
									<tr>
										<td class="eml" colspan=4>Integrity, Accountability, Teamwork, and Results.</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points business"  name="data[and_results]" required>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt7]"></td>
									<td>Business Critical</td>
								</tr>
									
									<tr>
										<td rowspan=5 class="eml1">Tone and Professionalism</td>
										<td class="eml" colspan=4>Demonstrates an attitude with every customer encounter through words and actions to show the customer respect and recgnition. </td>
										<td>10</td>
										<td>
											<select class="form-control conduent_points customer"  name="data[and_recgnition]" required>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt8]"></td>
									<td>Customer Critical</td>
								</tr>
									
									<tr>
										<td class="eml" colspan=4>Did the agent avoid dead air, did the agent control the call, did the agent avoid unnecessary hold?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points customer"  name="data[dead_air]" required>
												<option acm_val=6 value="Yes">Yes</option>
												<option acm_val=6 value="No">No</option>
												<option acm_val=6 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt9]"></td>
									<td>Customer Critical</td>
								</tr>
									
									<tr>
										<td class="eml" colspan=4>Tone, Over talking and pacing</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points customer"  name="data[and_pacing]" required>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt10]"></td>
									<td>Customer Critical</td>
								</tr>
									

									<tr>
										<td class="eml" colspan=4>Active Listening to the words a customer is speaking and understanding the request and avoid the customer repeating him/herself.</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points customer" name="data[the_request]" required>
												<option acm_val=6 value="Yes">Yes</option>
												<option acm_val=6 value="No">No</option>
												<option acm_val=6 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt11]"></td>
									<td>Customer Critical</td>
								</tr>
									

									<tr>
										<td class="eml" colspan=4>Empathized with customer</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points customer" name="data[with_customer]" required>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt12]"></td>
									<td>Customer Critical</td>
								</tr>
									

									<tr>
										<td rowspan=1 class="eml1">E-Alerts and Upselling</td>
										<td class="eml" colspan=4>Offering more items to the customer when an order is placed, or signing up for newsletter when the time is right.</td>
										<td>10</td>
										<td>
											<select class="form-control conduent_points business"  name="data[time_is_right]" required>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt13]"></td>
									<td>Business Critical</td>
								</tr>
									
								<tr>
									<td rowspan=1 class="eml1">Closing Script</td>
										<td class="eml" colspan=4>Did the agent close the call properly (with Branding Blains Farms and Fleet)</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points business"  name="data[call_properly]" required>
												<option acm_val=6 value="Yes">Yes</option>
												<option acm_val=6 value="No">No</option>
												<option acm_val=6 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt14]"></td>
									<td>Business Critical</td>
								</tr>
								<tr>
									<td rowspan=1 class="eml1">Disposition</td>
										<td class="eml" colspan=4>Did the agent dispose the call properly?</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points business"  name="data[call_dispose]" required>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt15]"></td>
									<td>Business Critical</td>
								</tr>
								<tr>
									<td rowspan=2 class="eml1" style="color:red">Other (Any score here =ZERO fatal for call)</td>
										<td class="eml" colspan=4 style="color:red">Rude remarks</td>
										<td>1</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="hovBR1"  name="data[rude_remarks]" required>
												<option acm_val=1 value="Pass">Pass</option>
												<option acm_val=1 value="Fail">Fail</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt16]"></td>
									<td>Compliance Critical</td>
								</tr>
								<tr>
									<td class="eml" colspan=4 style="color:red">Call Avoidance</td>
										<td>1</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="hovBR2" name="data[call_avoidance]" required>
												<option acm_val=1 value="Pass">Pass</option>
												<option acm_val=1 value="Fail">Fail</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="data[cmt17]"></td>
									<td>Compliance Critical</td>
								</tr>
									
								<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=4>Business Score</td><td colspan=4>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td colspan="">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockEarned" name="data[custlockEarned]" value="">
										</td>
										<td>Earned:</td>
										<td colspan="3">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockEarned" name="data[busilockEarned]" value="">
										</td>
										<td>Earned:</td>
										<td colspan="3">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockEarned" name="data[compllockEarned]" value="">
										</td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td>
										<td colspan="">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockPossible" name="data[custlockPossible]" value="">	
										</td>
										<td>Possible:</td>
										<td colspan="3">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockPossible" name="data[busilockPossible]" value="">	
										</td>
										<td>Possible:</td>
										<td colspan="3">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockPossible" name="data[compllockPossible]" value="">	
										</td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td colspan=""><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockScore" name="data[customer_score]" value=""></td>
										<td>Percentage:</td><td colspan="3"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockScore" name="data[business_score]" value=""></td>
										<td>Percentage:</td><td colspan="3"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockScore" name="data[compliance_score]" value=""></td>
									</tr>	
									<tr>
										<td colspan=3>Call Summary:</td>
										<td colspan=8><textarea class="form-control" name="data[call_summary]"></textarea></td>
									</tr>
									<tr>
										<td colspan=3>Feedback:</td>
										<td colspan=8><textarea class="form-control" name="data[feedback]"></textarea></td>
									</tr>
									<tr>
										<td colspan=3>Upload Files (mp3|avi|mp4|wmv|wav)</td>
										<td colspan=8><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php if(is_access_qa_module()==true){ ?>
									<tr>
										<td colspan=11><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
									</tr>
									<?php } ?>
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