
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
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">HCCO Audit Sheet</td></tr>
									
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" id="auditor_name" name="auditor_name" value="<?php echo $hcco_feedback['auditor_name']; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" id="audit_date" name="audit_date" value="<?php echo mysql2mmddyy($hcco_feedback['audit_date']); ?>" disabled></td>
										<td>Time of Call:</td>
										<td><input type="text" class="form-control" id="call_time" name="call_time" value="<?php echo $hcco_feedback['call_time']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" disabled>
												<option value=""><?php echo $hcco_feedback['fname']." ".$hcco_feedback['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $hcco_feedback['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" disabled>
												<option value=""><?php echo $hcco_feedback['tl_name'] ?></option>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Location:</td>
										<td><input type="text" class="form-control" id="office_id" name="office_id" value="<?php echo $hcco_feedback['office_id']; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($hcco_feedback['call_date']); ?>" disabled></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $hcco_feedback['call_duration']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Consumer1:</td>
										<td><input type="text" class="form-control" id="consumer1" name="consumer1" value="<?php echo $hcco_feedback['consumer1']; ?>" onkeyup="checkDec(this);" disabled></td>
										<td>Consumer2(if applicable):</td>
										<td><input type="text" class="form-control" id="consumer2" name="consumer2" value="<?php echo $hcco_feedback['consumer2']; ?>" onkeyup="checkDec(this);" disabled></td>
										<td>Consumer3(if applicable):</td>
										<td><input type="text" class="form-control" id="consumer3" name="consumer3" value="<?php echo $hcco_feedback['consumer3']; ?>" onkeyup="checkDec(this);" disabled></td>
									</tr>
									<tr>
										<td>Original SR ID:</td>
										<td><input type="text" class="form-control" id="original_sr_id" name="original_sr_id" value="<?php echo $hcco_feedback['original_sr_id']; ?>" disabled></td>
										<td>New SR ID(if applicable):</td>
										<td><input type="text" class="form-control" id="new_sr_id1" name="new_sr_id1" value="<?php echo $hcco_feedback['new_sr_id1']; ?>" disabled></td>
										<td>New SR ID(if applicable):</td>
										<td><input type="text" class="form-control" id="new_sr_id2" name="new_sr_id2" value="<?php echo $hcco_feedback['new_sr_id2']; ?>" disabled></td>
									</tr>
									<tr>
										<td>EXT Number:</td>
										<td><input type="text" class="form-control" id="ext_no" name="ext_no" value="<?php echo $hcco_feedback['ext_no']; ?>" disabled></td>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" disabled>
												<option value="">-Select-</option>
												<?php $sel='';
												if($hcco_feedback['audit_type']=='CQ Audit') $sel='Selected' ?>
												<option value="CQ Audit" <?php echo $sel; ?>>CQ Audit</option>
												<?php $sel='';
												if($hcco_feedback['audit_type']=='BQ Audit') $sel='Selected' ?>
												<option value="BQ Audit" <?php echo $sel; ?>>BQ Audit</option>
												<?php $sel='';
												if($hcco_feedback['audit_type']=='Calibration') $sel='Selected' ?>
												<option value="Calibration" <?php echo $sel; ?>>Calibration</option>
												<?php $sel='';
												if($hcco_feedback['audit_type']=='Client Request Audit') $sel='Selected' ?>
												<option value="Client Request Audit" <?php echo $sel; ?>>Client Request Audit</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" disabled>
												<option value="">-Select-</option>
												<?php $sel='';
												if($hcco_feedback['voc']=='1') $sel='Selected' ?>
												<option value="1" <?php echo $sel; ?>>1</option>
												<?php $sel='';
												if($hcco_feedback['voc']=='2') $sel='Selected' ?>
												<option value="2" <?php echo $sel; ?>>2</option>
												<?php $sel='';
												if($hcco_feedback['voc']=='3') $sel='Selected' ?>
												<option value="3" <?php echo $sel; ?>>3</option>
												<?php $sel='';
												if($hcco_feedback['voc']=='4') $sel='Selected' ?>
												<option value="4" <?php echo $sel; ?>>4</option>
												<?php $sel='';
												if($hcco_feedback['voc']=='5') $sel='Selected' ?>
												<option value="5" <?php echo $sel; ?>>5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Pass/Fail:</td>
										<td>
											<?php 
												if($hcco_feedback['call_pass_fail']=='Pass') $auto_style='color:green';
												else $auto_style='color:red';
											?>
											<input type="text" class="form-control" id="hcco_call_pass_fail" name="call_pass_fail" value="<?php echo $hcco_feedback['call_pass_fail']; ?>" style="<?php echo $auto_style; ?>" disabled>
										</td>
									</tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan="4"></td>
										<td style="font-size:18px; font-weight:bold">Total Score %</td>
										<td style="font-size:18px; font-weight:bold"><input type="text" class="form-control" value="<?php echo $hcco_feedback['overall_score']; ?>" disabled></td>
									</tr>
									<?php $i=$j=1; ?>
									<tr>
										<td class="eml1">Introduction</td>
										<td class="eml" colspan=3> Your Name/Verify who you are speaking with HA/Angi Branding and stated 'recorded line'</td>
											<select class="form-control hcco_point" id="Introduction" name="Introduction" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Introduction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Introduction']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Introduction']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Business Expectations</td>
										<td class="eml" colspan=3>The business needs were met</td>
										<td class="eml">
											<select class="form-control hcco_point" id="Business_expectations" name="Business_expectations" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Business_expectations']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Business_expectations']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Business_expectations']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Solution</td>
										<td class="eml" colspan=3>The correct solution was provided</td>
										<td class="eml">
											<select class="form-control hcco_point" id="Solution" name="Solution" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Solution']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Solution']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Solution']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Location & Email</td>
										<td class="eml" colspan=3>Verify Address if possible (Address required on IB Appts), Zip code & Email</td>
										<td class="eml">
											<select class="form-control hcco_point" id="Location_email" name="Location_email" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Location_email']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Location_email']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Location_email']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Proper Presentation</td>
										<td class="eml" colspan=3>Properly presented pros and asked the consumer how many options they want </td>
										<td class="eml">
											<select class="form-control hcco_point" id="Proper_presentation" name="Proper_presentation" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Proper_presentation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Proper_presentation']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Proper_presentation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Customer Expectations</td>
										<td class="eml" colspan=3>Make sure the Consumer knows what to expect after the call and Do what you said you would do. </td>
										<td class="eml">
											<select class="form-control hcco_point" id="Customer_expectations" name="Customer_expectations" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Customer_expectations']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Customer_expectations']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Customer_expectations']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Cross Sell</td>
										<td class="eml" colspan=3>The advisor asked for a cross sell</td>
										<td class="eml">
											<select class="form-control hcco_point" id="Cross_sell" name="Cross_sell" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Cross_sell']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Cross_sell']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Cross_sell']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Correct CTT</td>
										<td class="eml" colspan=3>Correct CTT was submitted and included a detailed description of the project</td>
										<td class="eml">
											<select class="form-control hcco_point" id="Correct_CTT" name="Correct_CTT" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Correct_CTT']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Correct_CTT']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Correct_CTT']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Branding</td>
										<td class="eml" colspan=3>Brand Angi/HA somewhere other than the Intro</td>
										<td class="eml">
											<select class="form-control hcco_point" id="Branding" name="Branding" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Branding']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Branding']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Branding']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
										</tr>
									<tr>
										<td class="eml1">Transfer</td>
										<td class="eml" colspan=3>Offer to transfer the Consumer to the Service Professional</td>
										<td class="eml">
											<select class="form-control hcco_point" id="Transfer" name="Transfer" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['Transfer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Transfer']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['Transfer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
										</tr>
									<tr>
										<td class="eml1">Probe</td>
										<td class="eml" colspan=3>The advisor asked questions about the project and related projects & included detailed descriptions</td>
										<td class="eml">
											<select class="form-control hcco_point" id="prob" name="prob" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['prob']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['prob']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['prob']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
										</tr>
									<tr>
										<td class="eml1">Educate</td>
										<td class="eml" colspan=3>Informed the consumer of features and benefits of Angi/HA</td>
										<td class="eml">
											<select class="form-control hcco_point" id="educate" name="educate" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['educate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['educate']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['educate']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
										</tr>
									<tr>
										<td class="eml1">Professionalism</td>
										<td class="eml" colspan=3>Maintain proper tone, word choice and rate of speech. Avoid interrupting in a non-collaborative conversation</td>
										<td class="eml">
											<select class="form-control hcco_point" id="professionalism" name="professionalism" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['professionalism']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['professionalism']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['professionalism']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									<tr>
										<td class="eml1">Account Accuracy</td>										
										<td class="eml" colspan=3>The advisor accurately updated and noted all SRs</td>
										<td class="eml">
											<select class="form-control hcco_point" id="account_accuracy" name="account_accuracy" disabled>
												<option hcco_val=10 <?php echo $hcco_feedback['account_accuracy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option hcco_val=10 <?php echo $hcco_feedback['account_accuracy']=='No'?"selected":""; ?> value="No">No</option>
												<option hcco_val=10 <?php echo $hcco_feedback['account_accuracy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>

										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
										</tr>
									<tr>
										<td class="eml1">Recorded Line</td>
										<td class="eml" colspan=3 style="color:red">Recorded line must be stated in the introduction of the call</td>
										<td class="eml">
											<select class="form-control auto_fails" id="recorded_line" name="recorded_line" disabled>
												<?php $sel='';
												if($hcco_feedback['recorded_line']=='Pass') $sel='Selected' ?>
												<option hcco_val=10 value="Pass" <?php echo $sel; ?>>Pass</option>
												<?php $sel='';
												if($hcco_feedback['recorded_line']=='Fail') $sel='Selected' ?>
												<option hcco_val=10 value="Fail" <?php echo $sel; ?>>Fail</option>
											</select>
										</td>

										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>	
									</tr>
									<tr>
										<td class="eml1">Acknowledgement</td>
										<td class="eml" colspan=3 style="color:red">All SRs were submitted with the homeowners knowledge and approval </td>
										<td class="eml">
											<select class="form-control auto_fails" id="acknowledgement" name="acknowledgement" disabled>
												<?php $sel='';
												if($hcco_feedback['acknowledgement']=='Pass') $sel='Selected' ?>
												<option hcco_val=10 value="Pass" <?php echo $sel; ?>>Pass</option>
												<?php $sel='';
												if($hcco_feedback['acknowledgement']=='Fail') $sel='Selected' ?>
												<option hcco_val=10 value="Fail" <?php echo $sel; ?>>Fail</option>
											</select>
										</td>

									<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>									
								    </tr>
									<tr>
										<td class="eml1">Stella Survey</td>
										<td class="eml" colspan=3>5 Star Rating      ** If yes, QA score will increase by 5 percent (manager must review and notify QA of 5 star Stella rating).</td>
										<td class="eml">
											<select class="form-control" id="" name="stella_survey" disabled>
												<?php $sel='';
												if($hcco_feedback['stella_survey']=='Yes') $sel='Selected' ?>
												<option hcco_val=5 value="Yes" <?php echo $sel; ?>>Yes</option>
												<?php $sel='';
												if($hcco_feedback['stella_survey']=='No') $sel='Selected' ?>
												<option hcco_val=5 value="No" <?php echo $sel; ?>>No</option>
											    <?php $sel='';
												if($hcco_feedback['stella_survey']=='N/A') $sel='Selected' ?>
												<option hcco_val=5 value="N/A" <?php echo $sel; ?>>N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt<?=$i++?>]" value="<?=$$dataDetails['cmt'.$j++]?>"></td>
									</tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" id="call_summary" name="call_summary" disabled><?php echo $hcco_feedback['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" id="feedback" name="feedback" disabled><?php echo $hcco_feedback['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($hcco_feedback['attach_file']!=''){ ?>
									<tr>
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$hcco_feedback['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_files/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_files/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<?php if($row2['id']==''){ ?>
										<tr>
											<td colspan="6" style="font-size:16px; font-weight:bold">Manager Review Not found</td>
										</tr>
									<?php }else{ ?>
										<tr>
											<td colspan="2"  style="font-size:16px">Manager Review</td>
											<td colspan="4">
												<textarea class="form-control" id="note" name="note" disabled><?php echo $row2['note']; ?></textarea>
											</td>
										</tr>
									<?php } ?>	
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td colspan="6">
												<input type="hidden" id="hcco_id" name="hcco_id" class="form-control" value="<?php echo $hcco_id; ?>">
												<input type="hidden" id="action" name="action" class="form-control" value="<?php echo $row1['id']; ?>">
											</td>
										</tr>
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $row1['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $row1['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4>
												<textarea class="form-control" id="note" name="note" required><?php echo $row1['note'] ?></textarea>
											</td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($hcco_feedback['entry_date'],72) == true){ ?>
											<tr>
												<?php if($row1['id']==''){ ?>
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
