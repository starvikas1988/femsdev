
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
	background-color:#FAD7A0;
}

.eml1{
	font-weight:bold;
}
.input-file input[type="file"]{
	padding-top:10px;
}
.save-btn {
  width: 200px!important;
  padding: 10px;
  border-radius: 1px;
}
.new-qa .form-control{
border-radius: 1px!important;
}
.select2-selection.select2-selection--single{
	height: 40px!important;
	border-radius: 1px!important;
}
.select2-selection .select2-selection__arrow{
	height: 40px!important;
}
.select2-selection.select2-selection--single .select2-selection__rendered {
  line-height: 40px !important;
}
.select2-container{
	width: 100%!important;
}
</style>


<div class="wrap">
	<section class="app-content new-qa">
	
		<div class="row">
			<div class="col-12">
				<div class="widget">

				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">AMERIDIAL [Stauers sales Scorecard]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="text" class="form-control" onkeydown="return false;" id="call_date" name="call_date" required></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" readonly class="form-control" id="fusion_id" name=""></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3">
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Site/Location:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" readonly class="form-control" id="office_id"></td>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="call_duration" required></td>
										<td>File No.:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="3"><input type="text" class="form-control" id="file_no" name="file_no" required></td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType" colspan="2">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="voc" name="voc" required>
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
										<td style="font-weight:bold; font-size:16px">Earned Score</td>
										<td><input type="text" readonly id="conduent_earn_score" name="earned_score" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px">Possible Score</td>
										<td colspan="2"><input type="text" readonly id="conduent_possible_score" name="possible_score" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td colspan="3"><input type="text" readonly id="conduent_overall_score" name="overall_score" class="form-control conduentFatal" style="font-weight:bold"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D4AC0D">
										<td colspan="4">PARAMETER</td>
										<td class="eml2">Score</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=2>Remarks</td>
										<td class="eml2">Critical Error</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Was the call answered within 5 seconds?</td>
										<td>4</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text1" required>
												<option value="">-Select-</option>
												<option acm_val=4 value="Yes">Yes</option>
												<option acm_val=4 value="No">No</option>
												<option acm_val=4 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt1"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent verify the customer's name and address on the account?</td>
										<td>8</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="" name="text2" required>
												<option value="">-Select-</option>
												<option acm_val=8 value="Yes">Yes</option>
												<option acm_val=8 value="No">No</option>
												<option acm_val=8 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt2"></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent capture the correct offer code?</td>
										<td>4</td>
										<td>
											<select class="form-control conduent_points business" id="" name="text3" required>
												<option value="">-Select-</option>
												<option acm_val=4 value="Yes">Yes</option>
												<option acm_val=4 value="No">No</option>
												<option acm_val=4 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt3"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent verify the phone number with the customer?</td>
										<td>7</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="" name="text4" required>
												<option value="">-Select-</option>
												<option acm_val=7 value="Yes">Yes</option>
												<option acm_val=7 value="No">No</option>
												<option acm_val=7 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt4"></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent verify the customer's email address?</td>
										<td>7</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="" name="text5" required>
												<option value="">-Select-</option>
												<option acm_val=7 value="Yes">Yes</option>
												<option acm_val=7 value="No">No</option>
												<option acm_val=7 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt5"></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent compliment the caller's purchase choice?</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="" name="text6" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt6"></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent recap the item?</td>
										<td>7</td>
										<td>
											<select class="form-control conduent_points business" id="" name="text24" required>
												<option value="">-Select-</option>
												<option acm_val=7 value="Yes">Yes</option>
												<option acm_val=7 value="No">No</option>
												<option acm_val=7 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt7"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent cover atleast one upsell ( ask if the customer would be interested in any other products)?</td>
										<td>10</td>
										<td>
											<select class="form-control conduent_points business" id="" name="text25" required>
												<option value="">-Select-</option>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt8"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Was the shipping address verified?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text15" required>
												<option value="">-Select-</option>
												<option acm_val=6 value="Yes">Yes</option>
												<option acm_val=6 value="No">No</option>
												<option acm_val=6 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt9"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent quote the correct delivery time?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text16" required>
												<option value="">-Select-</option>
												<option acm_val=6 value="Yes">Yes</option>
												<option acm_val=6 value="No">No</option>
												<option acm_val=6 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt10"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent give a total product quote appropriately?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text17" required>
												<option value="">-Select-</option>
												<option acm_val=6 value="Yes">Yes</option>
												<option acm_val=6 value="No">No</option>
												<option acm_val=6 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt11"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent quote shipping & taxes correctly?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text18" required>
												<option value="">-Select-</option>
												<option acm_val=6 value="Yes">Yes</option>
												<option acm_val=6 value="No">No</option>
												<option acm_val=6 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt12"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent provide the order number correctly?</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text20" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt13"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent close the call with the brand correctly?</td>
										<td>2</td>
										<td>
											<select class="form-control conduent_points business" id="" name="text21" required>
												<option value="">-Select-</option>
												<option acm_val=2 value="Yes">Yes</option>
												<option acm_val=2 value="No">No</option>
												<option acm_val=2 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt14"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent disposition the call correctly?</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points business" id="" name="text26" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt15"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent maintain call control? No dead air for more than 15 secs?</td>
										<td>4</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text27" required>
												<option value="">-Select-</option>
												<option acm_val=4 value="Yes">Yes</option>
												<option acm_val=4 value="No">No</option>
												<option acm_val=4 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt16"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Was the customer satisfied with his/her experience?</td>
										<td>3</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text22" required>
												<option value="">-Select-</option>
												<option acm_val=3 value="Yes">Yes</option>
												<option acm_val=3 value="No">No</option>
												<option acm_val=3 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt17"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Was the customer dissatisfied with the agent's professionalism and/or tone?</td>
										<td>2</td>
										<td>
											<select class="form-control conduent_points customer" id="" name="text23" required>
												<option value="">-Select-</option>
												<option acm_val=2 value="Yes">Yes</option>
												<option acm_val=2 value="No">No</option>
												<option acm_val=2 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt18"></td>
										<td>Customer</td>
									</tr>
								<tr>
									<td colspan=9 class="eml1" style="color:red">Other (Any score here =ZERO fatal for call)</td>
								</tr>
								<tr>
										<td class="eml" colspan=4 style="color:red">Did the agent give the total to be charged and verify the credit card to be charged correctly?</td>
										<td>1</td>
										<td>
											<select class="form-control conduent_points business" id="hovBR1"  name="text19" required>
												<option value="">-Select-</option>
												<option acm_val=1 value="Pass">Pass</option>
												<option acm_val=0 value="Fail">Fail</option>
												<option acm_val=1 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="cmt19"></td>
									<td>Business</td>
								</tr>
								<tr>
									<td class="eml" colspan=4 style="color:red">Rude Remarks</td>
										<td>1</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="hovBR2" name="rude_remarks" required>
												<option value="">-Select-</option>
												<option acm_val=1 value="Pass">Pass</option>
												<option acm_val=0 value="Fail">Fail</option>
												<option acm_val=1 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="cmt20"></td>
									<td>Compliance</td>
								</tr>
								<tr>
									<td class="eml" colspan=4 style="color:red">Call Avoidance</td>
										<td>1</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="hovBR2" name="call_avoidance" required>
												<option value="">-Select-</option>
												<option acm_val=1 value="Pass">Pass</option>
												<option acm_val=0 value="Fail">Fail</option>
												<option acm_val=1 value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" name="cmt21"></td>
									<td>Compliance</td>
								</tr>
								<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=4>Business Score</td><td colspan=4>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td colspan="">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockEarned" name="custlockEarned" value="">
										</td>
										<td>Earned:</td>
										<td colspan="3">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockEarned" name="busilockEarned" value="">
										</td>
										<td>Earned:</td>
										<td colspan="3">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockEarned" name="compllockEarned" value="">
										</td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td>
										<td colspan="">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockPossible" name="custlockPossible" value="">	
										</td>
										<td>Possible:</td>
										<td colspan="3">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockPossible" name="busilockPossible" value="">	
										</td>
										<td>Possible:</td>
										<td colspan="3">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockPossible" name="compllockPossible" value="">	
										</td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td colspan=""><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockScore" name="customer_score" value=""></td>
										<td>Percentage:</td><td colspan="3"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockScore" name="business_score" value=""></td>
										<td>Percentage:</td><td colspan="3"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockScore" name="compliance_score" value=""></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" id="call_summary" name="call_summary"></textarea></td>
										<td>Feedback:</td>
										<td colspan="5"><textarea class="form-control" id="feedback" name="feedback"></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files (mp3|avi|mp4|wmv|wav)</td>
										<td colspan="7" class="input-file"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									
									<?php if(is_access_qa_module()==true){ ?>
									<tr>
										<td colspan="9"><button class="btn btn-success waves-effect save-btn" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
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
