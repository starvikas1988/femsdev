
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
	background-color:#F5CBA7;
}

.eml1{
	font-weight:bold;
	background-color:#E5E8E8;
}

</style>


<div class="wrap">
	<section class="app-content">


		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">SENSIO</td></tr>
									
									<tr>
										<td>QA Name:</td>
										<?php if($sensio['entry_by']!=''){
												$auditorName = $sensio['auditor_name'];
											}else{
												$auditorName = $sensio['client_name'];
										} ?>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($sensio['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo mysql2mmddyy($sensio['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" disabled>
												<option value="<?php echo $sensio['agent_id'] ?>"><?php echo $sensio['fname']." ".$sensio['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $sensio['fusion_id']; ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" disabled>
												<option value="<?php echo $sensio['tl_id'] ?>"><?php echo $sensio['tl_name'] ?></option>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" disabled>
												<option value="<?php echo $sensio['audit_type'] ?>"><?php echo $sensio['audit_type'] ?></option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" disabled>
												<option value="<?php echo $sensio['voc'] ?>"><?php echo $sensio['voc'] ?></option>
											</select>
										</td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $sensio['call_duration']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td><input type="text" class="form-control" value="<?php echo $sensio['call_type']; ?>" disabled></td>
										<td>Can be Automated:</td>
										<td>
											<select class="form-control" id="" name="can_automated" disabled>
												<option value="">-Select-</option>
												<option <?php echo $sensio['can_automated']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $sensio['can_automated']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $sensio['call_id']; ?>" disabled></td>
										<td colspan=3 style="font-weight:bold; text-align:right">Overall Score:</td>
										<td><input type="text" id="" name="" class="form-control" style="font-weight:bold" value="<?php echo $sensio['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="font-weight:bold; background-color:#3498DB; color:white"><td colspan=6>SOFT SKILLS</td></tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>OPENING</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td><b>Scripted Opening</b></td>
										<td colspan=2>Thank you for calling Sensio my name is _______ how can I help you today?</td>
										<td>
											<select class="form-control sensioVal business" id="" name="script_openning" disabled>
												<option value="">Select</option>
												<option sen_val=5 <?php echo $sensio['script_openning']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['script_openning']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['script_openning']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt1" value="<?php echo $sensio['cmt1'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Answered Call within 20 Seconds</b></td>
										<td colspan=2></td>
										<td>
											<select class="form-control sensioVal business" id="" name="call_answer_20sec" disabled>
												<option value="">Select</option>
												<option sen_val=5 <?php echo $sensio['call_answer_20sec']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['call_answer_20sec']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['call_answer_20sec']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt2" value="<?php echo $sensio['cmt2'] ?>" disabled></td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>LISTENING SKILLS</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td><b>Active Listening</b></td>
										<td colspan=2>Agent displayed active listening all throughout the call, only needed to ask once to repeat information. Agent is able to verify information back correctly</td>
										<td>
											<select class="form-control sensioVal business" id="" name="active_listening" disabled>
												<option value="">Select</option>
												<option sen_val=10 <?php echo $sensio['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=10 <?php echo $sensio['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=10 <?php echo $sensio['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt3" value="<?php echo $sensio['cmt3'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Acknowledgement</b></td>
										<td colspan=2>Agent was able to acknowledge the customer's concern and responds to the customer's questions on a timely manner</td>
										<td>
											<select class="form-control sensioVal business" id="" name="acknowledgement" disabled>
												<option value="">Select</option>
												<option sen_val=10 <?php echo $sensio['acknowledgement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=10 <?php echo $sensio['acknowledgement']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=10 <?php echo $sensio['acknowledgement']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt4" value="<?php echo $sensio['cmt4'] ?>" disabled></td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>COMMUNICATION SKILLS</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td><b>Grammar and Pronounciation</b></td>
										<td colspan=2>Excellent command of the English Language. Agent does not mispronounce a word (common or product-related words)</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="grammar_pronounciation" disabled>
												<option value="">Select</option>
												<option sen_val=5 <?php echo $sensio['grammar_pronounciation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['grammar_pronounciation']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['grammar_pronounciation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt5" value="<?php echo $sensio['cmt5'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Appropriate Speech</b></td>
										<td colspan=2>Agent uses please and thank you, Speaks professionaly and uses complete sentences or questions</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="appropiate_speech" disabled>
												<option value="">Select</option>
												<option sen_val=5 <?php echo $sensio['appropiate_speech']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['appropiate_speech']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['appropiate_speech']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt6" value="<?php echo $sensio['cmt6'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Easy to Understand</b></td>
										<td colspan=2>Agent enunciates his/her words correctly. Speech does not sound mumbled. Agent's rate of speech is in accordance with the caller's pace</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="easy_to_understand" disabled>
												<option value="">Select</option>
												<option sen_val=5 <?php echo $sensio['easy_to_understand']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['easy_to_understand']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['easy_to_understand']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt7" value="<?php echo $sensio['cmt7'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Correct Use of Phonetics</b></td>
										<td colspan=2>Agent uses the correct phonetics when spelling or giving information. Uses phonetics only when necessary</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="correct_use_phonetics" disabled>
												<option value="">Select</option>
												<option sen_val=5 <?php echo $sensio['correct_use_phonetics']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['correct_use_phonetics']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['correct_use_phonetics']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt8" value="<?php echo $sensio['cmt8'] ?>" disabled></td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>EDUCATION</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td><b>Did the Agent Properly Educate the Customer?</b></td>
										<td colspan=2>Agent provides the customer with the complete information needed in the call</td>
										<td>
											<select class="form-control sensioVal compliance" id="" name="properly_educate_customer" disabled>
												<option value="">Select</option>
												<option sen_val=10 <?php echo $sensio['properly_educate_customer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=10 <?php echo $sensio['properly_educate_customer']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=10 <?php echo $sensio['properly_educate_customer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt9" value="<?php echo $sensio['cmt9'] ?>" disabled></td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>CUSTOMER SERVICE</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td><b>Ownership</b></td>
										<td colspan=2>Agent is taking the lead on the call</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="ownership" disabled>
												<option value="">Select</option>
												<option sen_val=7.5 <?php echo $sensio['ownership']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=7.5 <?php echo $sensio['ownership']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=7.5 <?php echo $sensio['ownership']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt10" value="<?php echo $sensio['cmt10'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Polite</b></td>
										<td colspan=2>Agent's speech and delivery sound professional and friendly all throughout call</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="polite" disabled>
												<option value="">Select</option>
												<option sen_val=7.5 <?php echo $sensio['polite']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=7.5 <?php echo $sensio['polite']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=7.5 <?php echo $sensio['polite']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt11" value="<?php echo $sensio['cmt11'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Empathy/Assurance</b></td>
										<td colspan=2>Uses appropriate statements timely and accordingly</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="empathy_assurance" disabled>
												<option value="">Select</option>
												<option sen_val=7.5 <?php echo $sensio['empathy_assurance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=7.5 <?php echo $sensio['empathy_assurance']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=7.5 <?php echo $sensio['empathy_assurance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt12" value="<?php echo $sensio['cmt12'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Hold</b></td>
										<td colspan=2>Agent has no instance of exceeding hold of 2min without an update to the customer</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="hold" disabled>
												<option value="">Select</option>
												<option sen_val=7.5 <?php echo $sensio['hold']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=7.5 <?php echo $sensio['hold']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=7.5 <?php echo $sensio['hold']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt13" value="<?php echo $sensio['cmt13'] ?>" disabled></td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>CLOSING</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td><b>Offer of Additional Assistance</b></td>
										<td colspan=2>"Anything else I can assist you with?"</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="additional_assistance" disabled>
												<option value="">Select</option>
												<option sen_val=5 <?php echo $sensio['additional_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['additional_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['additional_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt14" value="<?php echo $sensio['cmt14'] ?>" disabled></td>
									</tr>
									<tr>
										<td><b>Scripted Close</b></td>
										<td colspan=2>"Thank you for calling Sensio, have a nice day"</td>
										<td>
											<select class="form-control sensioVal customer" id="" name="script_close" disabled>
												<option value="">Select</option>
												<option sen_val=5 <?php echo $sensio['script_close']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sen_val=5 <?php echo $sensio['script_close']=='No'?"selected":""; ?> value="No">No</option>
												<option sen_val=5 <?php echo $sensio['script_close']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt15" value="<?php echo $sensio['cmt15'] ?>" disabled></td>
									</tr>

									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" class="form-control" value="<?php echo $sensio['customer_score'] ?>" disabled></td>
										<td>Percentage:</td><td><input type="text" class="form-control" value="<?php echo $sensio['business_score'] ?>" disabled></td>
										<td>Percentage:</td><td><input type="text" class="form-control" value="<?php echo $sensio['compliance_score'] ?>" disabled></td>
									</tr>

									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="call_summary" name="call_summary" disabled><?php echo $sensio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="feedback" name="feedback" disabled><?php echo $sensio['feedback'] ?></textarea></td>
									</tr>
									<tr oncontextmenu="return false;">
										<td colspan=2>Upload Files</td>
										<?php if($sensio['attach_file']!=''){ ?>
										<td colspan=4>
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
										?>
									</tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan=5 style="text-align:left"><?php echo $sensio['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan=5 style="text-align:left"><?php echo $sensio['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan=6 style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td style="font-size:16px">Review
												<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
											</td>
											<td colspan=5><textarea class="form-control" name="note" required><?php echo $sensio['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($sensio['entry_date'],72) == true){ ?>
											<tr>
												<?php if($sensio['agent_rvw_note']==''){ ?>
													<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</div>

		</form>	
		</div>

	</section>
</div>
