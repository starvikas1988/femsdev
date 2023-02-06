
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

input[type='checkbox']{
	width: 20px;
}
</style>

<?php if($sensio_id!=0){
if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
		}
	</style>
<?php } 
} ?>


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
										<td colspan="8" id="theader" style="font-size:30px">SENSIO</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
										if($sensio_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($sensio['entry_by']!=''){
												$auditorName = $sensio['auditor_name'];
											}else{
												$auditorName = $sensio['client_name'];
											}
											$auditDate = mysql2mmddyy($sensio['audit_date']);
											$clDate_val=mysql2mmddyy($sensio['call_date']);
										}
									?>
										<td>QA Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $sensio['agent_id'] ?>"><?php echo $sensio['fname']." ".$sensio['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $sensio['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:</td>
										<td style="width:250px">
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $sensio['tl_id'] ?>"><?php echo $sensio['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td><input type="text" class="form-control" id="call_type_2words" name="call_type" onkeyup="word_length_limit()" value="<?php echo $sensio['call_type']; ?>" required></td>
										<td>Can be Automated:</td>
										<td>
											<select class="form-control" id="" name="can_automated" required>
												<option value="">-Select-</option>
												<option <?php echo $sensio['can_automated']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $sensio['can_automated']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
											<option value="">-Select-</option>
											<option <?php echo $sensio['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $sensio['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $sensio['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $sensio['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $sensio['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option <?php echo $sensio['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $sensio['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $sensio['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $sensio['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $sensio['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" id="" name="call_id" value="<?php echo $sensio['call_id']; ?>" required></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $sensio['call_duration']; ?>" required></td>
									</td>
									<tr>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="sensioPossibleScore" name="" class="form-control" style="font-weight:bold" ></td>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="sensioEarnedScore" name="" class="form-control" style="font-weight:bold" ></td>
										<td style="font-weight:bold">Overall Score:</td>
										<td><input type="text" readonly id="sensioOverallScore" name="overall_score" class="form-control" style="font-weight:bold" value="<?php echo $sensio['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#3498DB; color:white"><td colspan=8>SOFT SKILLS</td></tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>OPENING</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Scripted Opening</b></td>
										<td colspan=2>Thank you for calling Sensio my name is _______ how can I help you today?</td>
										<td>4</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="script_openning" required>
												<option sen_val=4 <?php echo $sensio['script_openning']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=4 <?php echo $sensio['script_openning']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=4 <?php echo $sensio['script_openning']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt1" value="<?php echo $sensio['cmt1'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Answered Call within 20 Seconds</b></td>
										<td colspan=2></td>
										<td>4</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="call_answer_20sec" required>
												<option sen_val=4 <?php echo $sensio['call_answer_20sec']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=4 <?php echo $sensio['call_answer_20sec']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=4 <?php echo $sensio['call_answer_20sec']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt2" value="<?php echo $sensio['cmt2'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>LISTENING SKILLS</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Active Listening</b></td>
										<td colspan=2>Agent displayed active listening all throughout the call, only needed to ask once to repeat information. Agent is able to verify information back correctly</td>
										<td>10</td>
										<td>
											<select class="form-control sensioVal business" id="" name="active_listening" required>
												<option sen_val=10 <?php echo $sensio['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=10 <?php echo $sensio['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=10 <?php echo $sensio['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt3" value="<?php echo $sensio['cmt3'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Acknowledgement</b></td>
										<td colspan=2>Agent was able to acknowledge the customer's concern and responds to the customer's questions on a timely manner</td>
										<td>10</td>
										<td>
											<select class="form-control sensioVal business" id="" name="acknowledgement" required>
												<option sen_val=10 <?php echo $sensio['acknowledgement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=10 <?php echo $sensio['acknowledgement']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=10 <?php echo $sensio['acknowledgement']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt4" value="<?php echo $sensio['cmt4'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>COMMUNICATION SKILLS</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Grammar and Pronounciation</b></td>
										<td colspan=2>Excellent command of the English Language. Agent does not mispronounce a word (common or product-related words)</td>
										<td>5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="grammar_pronounciation" required>
												<option sen_val=5 <?php echo $sensio['grammar_pronounciation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['grammar_pronounciation']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['grammar_pronounciation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt5" value="<?php echo $sensio['cmt5'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Appropriate Speech</b></td>
										<td colspan=2>Agent uses please and thank you, Speaks professionaly and uses complete sentences or questions</td>
										<td>5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="appropiate_speech" required>
												<option sen_val=5 <?php echo $sensio['appropiate_speech']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['appropiate_speech']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['appropiate_speech']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt6" value="<?php echo $sensio['cmt6'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Easy to Understand</b></td>
										<td colspan=2>Agent enunciates his/her words correctly. Speech does not sound mumbled. Agent's rate of speech is in accordance with the caller's pace</td>
										<td>5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="easy_to_understand" required>
												<option sen_val=5 <?php echo $sensio['easy_to_understand']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['easy_to_understand']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['easy_to_understand']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt7" value="<?php echo $sensio['cmt7'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Correct Use of Phonetics</b></td>
										<td colspan=2>Agent uses the correct phonetics when spelling or giving information. Uses phonetics only when necessary</td>
										<td>5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="correct_use_phonetics" required>
												<option sen_val=5 <?php echo $sensio['correct_use_phonetics']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['correct_use_phonetics']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['correct_use_phonetics']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt8" value="<?php echo $sensio['cmt8'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>EDUCATION</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Did the Agent Properly Educate the Customer?</b></td>
										<td colspan=2>Agent provides the customer with the complete information needed in the call</td>
										<td>10</td>
										<td>
											<select class="form-control sensioVal compliance" id="" name="properly_educate_customer" required>
												<option sen_val=10 <?php echo $sensio['properly_educate_customer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=10 <?php echo $sensio['properly_educate_customer']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=10 <?php echo $sensio['properly_educate_customer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt9" value="<?php echo $sensio['cmt9'] ?>" ></td>
										<td>Compliance</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>CUSTOMER SERVICE</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Ownership</b></td>
										<td colspan=2>Agent is taking the lead on the call</td>
										<td>7.5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="ownership" required>
												<option sen_val=7.5 <?php echo $sensio['ownership']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=7.5 <?php echo $sensio['ownership']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=7.5 <?php echo $sensio['ownership']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt10" value="<?php echo $sensio['cmt10'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Polite</b></td>
										<td colspan=2>Agent's speech and delivery sound professional and friendly all throughout call</td>
										<td>7.5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="polite" required>
												<option sen_val=7.50 <?php echo $sensio['polite']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=7.50 <?php echo $sensio['polite']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=7.50 <?php echo $sensio['polite']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt11" value="<?php echo $sensio['cmt11'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Empathy/Assurance</b></td>
										<td colspan=2>Uses appropriate statements timely and accordingly</td>
										<td>7.5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="empathy_assurance" required>
												<option sen_val=7.50 <?php echo $sensio['empathy_assurance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=7.50 <?php echo $sensio['empathy_assurance']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=7.50 <?php echo $sensio['empathy_assurance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt12" value="<?php echo $sensio['cmt12'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Hold</b></td>
										<td colspan=2>Agent has no instance of exceeding hold of 2min without an update to the customer</td>
										<td>7.5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="hold" required>
												<option sen_val=7.50 <?php echo $sensio['hold']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=7.50 <?php echo $sensio['hold']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=7.50 <?php echo $sensio['hold']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt13" value="<?php echo $sensio['cmt13'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>CLOSING</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Offer of Additional Assistance</b></td>
										<td colspan=2>"Anything else I can assist you with?"</td>
										<td>5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="additional_assistance" required>
												<option sen_val=5 <?php echo $sensio['additional_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['additional_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['additional_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt14" value="<?php echo $sensio['cmt14'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Scripted Close</b></td>
										<td colspan=2>"Thank you for calling Sensio, have a nice day"</td>
										<td>5</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="script_close" required>
												<option sen_val=5 <?php echo $sensio['script_close']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['script_close']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['script_close']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt15" value="<?php echo $sensio['cmt15'] ?>" ></td>
										<td>Customer</td>
									</tr>

									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>Other (Any score here = Zero total for the call)</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Rude Remarks</b></td>
										<td colspan=2>Rude/Impolite behavior, Inappropriate tone or language, being sarcastic.</td>
										<td>1</td>
										<td>
											<select class="form-control sensioVal customer" id="sensio_AF1" name="rude_behaviour" required>
												<option sen_val=1 <?php echo $sensio['rude_behaviour']=='Yes'?"selected":""; ?> value="Yes">No</option>
												<option sen_val=1 <?php echo $sensio['rude_behaviour']=='No'?"selected":""; ?> value="No">Yes</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt16" value="<?php echo $sensio['cmt16'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Call Avoidance</b></td>
										<td colspan=2>Agent disconnecting call while the customer was there (Invalid call disconnection)</td>
										<td>1</td>
										<td>
											<select class="form-control sensioVal customer" id="sensio_AF2" name="call_avoidance" required>
												<option sen_val=1 <?php echo $sensio['call_avoidance']=='Yes'?"selected":""; ?> value="Yes">No</option>
												<option sen_val=1 <?php echo $sensio['call_avoidance']=='No'?"selected":""; ?> value="No">Yes</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt17" value="<?php echo $sensio['cmt17'] ?>" ></td>
										<td>Customer</td>
									</tr>

									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custSenEarned"></td><td>Earned:</td><td id="busiSenEarned"></td><td>Earned:</td><td id="complSenEarned"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custSenPossible"></td><td>Possible:</td><td id="busiSenPossible"></td><td>Possible:</td><td id="complSenPossible"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custSenScore" name="data[customer_score]" value="<?php echo $sensio['customer_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiSenScore" name="data[business_score]" value="<?php echo $sensio['business_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complSenScore" name="data[compliance_score]" value="<?php echo $sensio['compliance_score'] ?>"></td>
									</tr>


									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="" name="call_summary"><?php echo $sensio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="" name="feedback"><?php echo $sensio['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files</td>
										<?php if($sensio_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($sensio['attach_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_file = explode(",",$sensio['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_sensio/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_sensio/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
										
									<?php if($sensio_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $sensio['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $sensio['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $sensio['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
										
									<?php 
									if($sensio_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($sensio['entry_date'],72) == true){ ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
