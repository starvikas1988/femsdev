
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

.eml1{
	font-size:24px;
	font-weight:bold;
	background-color:#A3E4D7;
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
										<td colspan="6" id="theader" style="font-size:30px">HCCO Audit Sheet</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td style="width:150px">QA Name:</td>
										<td><input type="text" class="form-control" id="auditor_name" name="auditor_name" value="<?php echo get_username(); ?>" readonly></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Time of Call:</td>
										<td><input type="text" class="form-control" id="call_time" name="call_time" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="">--Select--</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']." - ".$row['office_id']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Location:</td>
										<td><input type="text" readonly class="form-control" id="office_id" name="office_id"></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" required></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" required></td>
									</tr>
									<tr>
										<td>Consumer1:</td>
										<td><input type="text" class="form-control" id="consumer1" name="consumer1" onkeyup="checkDec(this);" required></td>
										<td>Consumer2(if applicable):</td>
										<td><input type="text" class="form-control" id="consumer2" name="consumer2" onkeyup="checkDec(this);" ></td>
										<td>Consumer3(if applicable):</td>
										<td><input type="text" class="form-control" id="consumer3" name="consumer3" onkeyup="checkDec(this);" ></td>
									</tr>
									<tr>
										<td>Original SR ID:</td>
										<td><input type="text" class="form-control" id="original_sr_id" name="original_sr_id" required></td>
										<td>New SR ID(if applicable):</td>
										<td><input type="text" class="form-control" id="new_sr_id1" name="new_sr_id1" ></td>
										<td>New SR ID(if applicable):</td>
										<td><input type="text" class="form-control" id="new_sr_id2" name="new_sr_id2" ></td>
									</tr>
									<tr>
										<td>EXT Number:</td>
										<td><input type="text" class="form-control" id="ext_no" name="ext_no" required></td>
										<td>Call Pass/Fail:</td>
										<td><input type="text" readonly class="form-control" id="hcco_call_pass_fail" name="call_pass_fail" ></td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td><input type="text" class="form-control" id="call_type_2words" name="call_type" onkeyup="word_length_limit()" required></td>
										<td>Can be Automated:</td>
										<td>
											<select class="form-control" id="" name="can_automated" required>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
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
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
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
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr>
										<td style="font-size:18px; font-weight:bold; text-align:right">Earned Score</td>
										<td style="font-size:18px; font-weight:bold"><input type="text" readonly class="form-control" id="earned_hcco"></td>
										<td style="font-size:18px; font-weight:bold; text-align:right">Possible Score</td>
										<td style="font-size:18px; font-weight:bold"><input type="text" readonly class="form-control" id="possible_hcco"></td>
										<td style="font-size:18px; font-weight:bold; text-align:right">Total Score</td>
										<td style="font-size:18px; font-weight:bold"><input type="text" readonly class="form-control hccoFatal" id="hcco_score_percentage" name="overall_score"></td>
									</tr>
									<?php $i=1; ?>
									<tr>
										<td class="eml1"></td>
										<td class="eml1" colspan=3>QA SCORECARD FORM</td>
										<td class="eml1">
										</td>
										<td class="eml1"></td>
									</tr>
									<tr>
										<td class="eml1">Introduction</td>
										<td class="eml" colspan=2>- Your Name/Verify who you are speaking with HA/Angi Branding and stated 'recorded line'</td>
										<td class="eml">
											<select class="form-control hcco_point business" id="Introduction" name="Introduction" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="Compliance"></td> -->
										<td style="">10</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1">Advisor expectations</td>
										<td class="eml" colspan=2>-The business needs were met</td>
										<td class="eml">
											<select class="form-control hcco_point compliance" id="Business_expectations" name="Business_expectations" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="business"></td> -->
										<td style="">10</td>
										<td colspan="">Compliance Critical</td>
									</tr>
									<tr>
										<td class="eml1">Solution</td>
										<td class="eml" colspan=2>-The correct solution was provided</td>
										<td class="eml">
											<select class="form-control hcco_point business" id="Solution" name="Solution" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="business"></td> -->
										<td style="">10</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1">Location & Email</td>
										<td class="eml" colspan=2>-Verify Address if possible (Address required on IB Appts), Zip code & Email</td>
										<td class="eml">
											<select class="form-control hcco_point compliance" id="Location_email" name="Location_email" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="business"></td> -->
										<td style="">10</td>
										<td colspan="">Compliance Critical</td>
									</tr>
									<tr>
										<td class="eml1">Proper Presentation</td>
										<td class="eml" colspan=2>-Properly presented pros and asked the consumer how many options they want </td>
										<td class="eml">
											<select class="form-control hcco_point business" id="Proper_presentation" name="Proper_presentation" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="business"></td> -->
										<td style="">10</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1">Customer Expectations</td>
										<td class="eml" colspan=2>-Make sure the Consumer knows what to expect after the call and Do what you said you would do. </td>
										<td class="eml">
											<select class="form-control hcco_point customer" id="Customer_expectations" name="Customer_expectations" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="compliance"> </td> -->
										<td style="">10</td>
										<td colspan="">Customer Critical</td>
									</tr>
									<tr>
										<td class="eml1">Cross Sell</td>
										<td class="eml" colspan=2>-The advisor asked for a cross sell</td>
										<td class="eml">
											<select class="form-control hcco_point business" id="Cross_sell" name="Cross_sell" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="business"></td> -->
										<td style="">10</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1">Correct CTT</td>
										<td class="eml" colspan=2>-Correct CTT was submitted and included a detailed description of the project</td>
										<td class="eml">
											<select class="form-control hcco_point business" id="Correct_CTT" name="Correct_CTT" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="business"></td> -->
										<td style="">10</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1">Branding</td>
										<td class="eml" colspan=2>-Brand Angi/HA somewhere other than the Intro</td>
										<td class="eml">
											<select class="form-control hcco_point business" id="Branding" name="Branding" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="business"></td> -->
										<td style="">10</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1">Transfer</td>
										<td class="eml" colspan=2>-Offer to transfer the Consumer to the Service Professional</td>
										<td class="eml">
											<select class="form-control hcco_point compliance" id="Transfer" name="Transfer" required>
												<option hcco_val=10 value="Yes">Yes</option>
												<option hcco_val=10 value="No">No</option>
												<option hcco_val=10 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>" value="business"></td> -->
										<td style="">10</td>
										<td colspan="">Compliance Critical</td>
									</tr>
									<tr>
										<td class="eml1"></td>
										<td class="eml1" colspan=3>COACHING</td>
										<td class="eml1">
										</td>
										<td class="eml1"></td>
									</tr>
									<tr>
										<td class="eml1">Probe</td>
										<td class="eml" colspan=2>-The advisor asked questions about the project and related projects & included detailed descriptions</td>
										<td class="eml">
											<select class="form-control hcco_point business" id="prob" name="prob" required>
												<option hcco_val=0 value="Yes">Yes</option>
												<option hcco_val=0 value="No">No</option>
												<option hcco_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>"></td> -->
										<td style="">0</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1">Educate</td>
										<td class="eml" colspan=2>-Informed the consumer of features and benefits of Angi/HA</td>
										<td class="eml">
											<select class="form-control hcco_point customer" id="educate" name="educate" required>
												<option hcco_val=0 value="Yes">Yes</option>
												<option hcco_val=0 value="No">No</option>
												<option hcco_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>"></td> -->
										<td style="">0</td>
										<td colspan="">Customer Critical</td>
									</tr>
									<tr>
										<td class="eml1">Professionalism</td>
										<td class="eml" colspan=2>-Maintain proper tone, word choice and rate of speech. Avoid interrupting in a non-collaborative conversation</td>
										<td class="eml">
											<select class="form-control hcco_point customer" id="professionalism" name="professionalism" required>
												<option hcco_val=0 value="Yes">Yes</option>
												<option hcco_val=0 value="No">No</option>
												<option hcco_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>"></td> -->
										<td style="">0</td>
										<td colspan="">Customer Critical</td>
									</tr>
									<tr>
										<td class="eml1">Account Accuracy</td>										
										<td class="eml" colspan=2>-The advisor accurately updated and noted all SRs</td>
										<td class="eml">
											<select class="form-control hcco_point business" id="account_accuracy" name="account_accuracy" required>
												<option hcco_val=0 value="Yes">Yes</option>
												<option hcco_val=0 value="No">No</option>
												<option hcco_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>"></td> -->
										<td style="">0</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1"></td>
										<td class="eml1" colspan=3>AUTOFAILS</td>
										<td class="eml1">
										</td>
										<td class="eml1"></td>
									</tr>
									<tr>
										<td class="eml1">Recorded Line</td>
										<td class="eml" colspan=2>-Recorded line must be stated in the introduction of the call</td>
										<td class="eml">
											<select class="form-control hcco_point business" id="hccoAF1" name="recorded_line" required>
												<option hcco_val=0 value="Pass">Pass</option>
												<option hcco_val=0 value="Fail">Fail</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>"></td> -->
										<td style="">0</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1">Acknowledgement</td>
										<td class="eml" colspan=2>-All SRs were submitted with the homeowners knowledge and approval </td>
										<td class="eml">
											<select class="form-control hcco_point business" id="hccoAF2" name="acknowledgement" required>
												<option hcco_val=0 value="Pass">Pass</option>
												<option hcco_val=0 value="Fail">Fail</option>
											</select>
										</td>
										<!-- <td class="eml"><input type="text" class="form-control" name="cmt<?=$i++?>"></td> -->
										<td style="">0</td>
										<td colspan="">Business Critical</td>
									</tr>
									<tr>
										<td class="eml1"></td>
										<td class="eml1" colspan=3>STELLA SURVEY *FOR PA ADVISORS ONLY*</td>
										<td class="eml1">
										</td>
										<td class="eml1"></td>
									</tr>
									<tr>
										<td class="eml1">Stella Survey</td>
										<td class="eml" colspan=2>-5 Star Rating      ** If yes, QA score will increase by 5 percent (manager must review and notify QA of 5 star Stella rating).</td>
										<td class="eml">
											<select class="form-control stella_survey" id="" name="stella_survey">
												
												<option hcco_val=0 value=""></option>
												<option hcco_val=0 value="Yes">Yes</option>
												
											</select>
										</td>
										<td class="eml"><input type="text" class="form-control" colspan="2" name="cmt<?=$i++?>"></td>
									</tr>	
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan=2>Compliance</td>
										<td colspan=2>Customer</td>
										<td colspan=2>Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td><input type="text" readonly class="form-control" id="compliancescore2" name="compliancescore"></td>
										<td>Earned Point:</td><td><input type="text" readonly class="form-control" id="customerscore2" name="customerscore"></td>
										<td>Earned Point:</td><td><input type="text" readonly class="form-control" id="businessscore2" name="businessscore"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td><input type="text" readonly class="form-control" id="compliancescoreable2" name="compliancescoreable"></td>
										<td>Possible Point:</td><td><input type="text" readonly class="form-control" id="customerscoreable2" name="customerscoreable"></td>
										<td>Possible Point:</td><td><input type="text" readonly class="form-control" id="businessscoreable2" name="businessscoreable"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td><input type="text" readonly class="form-control" id="compliance_score_percent2" name="compliance_score_percent"></td>
										<td>Overall Percentage:</td><td><input type="text" readonly class="form-control" id="customer_score_percent2" name="customer_score_percent"></td>
										<td>Overall Percentage:</td><td><input type="text" readonly class="form-control" id="business_score_percent2" name="business_score_percent"></td>
									</tr>								
									<tr>
										<td colspan="2" style="font-weight:bold">Call Summary:</td>
										<td colspan="4"><textarea class="form-control" id="call_summary" name="call_summary"></textarea></td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold">Feedback:</td>
										<td colspan="4"><textarea class="form-control" id="feedback" name="feedback"></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files</td>
										<td colspan="4"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php if(is_access_qa_module()==true){ ?>
									<tr>
										<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
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

<script type="text/javascript">
	function word_length_limit(){
		var word = $("#call_type_2words").val();
		var wordcnt = word.split(" ");
		var wordcnt_length = wordcnt.length;
		if(wordcnt_length>2){
			alert("Maximun of 2 words");
			$("#call_type_2words").val("");
		}
	}
</script>
