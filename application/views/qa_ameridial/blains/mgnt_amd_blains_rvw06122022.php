
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

</style>

<?php if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
		}
	</style>
<?php } ?>

<div class="wrap">
	<section class="app-content">


		<div class="row">
		<form id="form_mgnt_user" method="POST" action="">

			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">Mgnt <?php echo ucfirst($page) ?> Rvw<!-- <img src="<?php echo base_url(); ?>main_img/hra.png"> --></td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
										
									<tr>
										<td colspan="1">QA Name:<span style="font-size:24px;color:red">*</span></td>
										<?php 
										$dataDetails=$page."_new";
										if($$dataDetails['entry_by']!=''){
												$auditorName = $$dataDetails['auditor_name'];
											}else{
												$auditorName = $$dataDetails['client_name'];
										} ?>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan="1">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($$dataDetails['audit_date']); ?>" disabled></td>
										<td colspan="1">Phone:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="phone" name="data[phone]" value="<?php echo $$dataDetails['phone'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Agent:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $$dataDetails['agent_id'] ?>"><?php echo $$dataDetails['fname']." ".$$dataDetails['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $$dataDetails['fusion_id'] ?>"></td>
										<td colspan="1">L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]"  disabled>
												<option value="<?php echo $$dataDetails['tl_id'] ?>"><?php echo $$dataDetails['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="1">File No:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control"  name="data[file_no]" value="<?php echo $$dataDetails['file_no'] ?>"  disabled></td>
										<td colspan="1">Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $$dataDetails['call_date'] ?>" disabled></td>
										<td colspan="1">Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $$dataDetails['call_duration'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]">
												<option value="<?php echo $$dataDetails['audit_type'] ?>"><?php echo $$dataDetails['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType_epi" colspan="1">Auditor Type</td>
										<td class="auType_epi" colspan="2">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $$dataDetails['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $$dataDetails['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]"  disabled>
												<option value="<?php echo $$dataDetails['voc'] ?>"><?php echo $$dataDetails['voc'] ?></option>
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
										<td colspan="2"><input type="text" class="form-control"  name="data[site]" value="<?php echo $$dataDetails['site'] ?>"  disabled></td>
										<td colspan="1">Filler 2:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="filler" name="data[filler]" value="<?php echo $$dataDetails['filler'] ?>"  disabled></td>
										<td colspan="1">Area Code:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="area_code" name="data[area_code]" value="<?php echo $$dataDetails['area_code'] ?>"  disabled></td>
									</tr>
									<tr>										
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="conduent_earn_score" name="data[earned_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="conduent_possible_score" name="data[possible_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control blains_fatal" id="conduent_overall_score" name="data[overall_score]" value="<?php echo $$dataDetails['overall_score'] ?>" readonly></td>
									</tr>
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=4>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=4>Remarks</td>
									</tr>
									<tr>
										<td rowspan=2 class="eml1">Introduction and Call Path Procedure</td>
										<td class="eml" colspan=4>Call opening with Brand Name (5 secs)
										</td>
										<td>
											<select class="form-control conduent_points" name="data[brand_name]" required>
												<option acm_val=5 value="Yes" <?php echo $$dataDetails['brand_name']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=5 value="No" <?php echo $$dataDetails['brand_name']=="No"?"selected":""; ?> >No</option>
												<option acm_val=5 value="N/A" <?php echo $$dataDetails['brand_name']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt1'] ?>" name="data[cmt1]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Personalize the call (Address the customer by their name at least once during the call)</td>
										
										<td>
											<select class="form-control conduent_points"  name="data[least_once]" required>
												<option acm_val=5 value="Yes" <?php echo $$dataDetails['least_once']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=5 value="No" <?php echo $$dataDetails['least_once']=="No"?"selected":""; ?> >No</option>
												<option acm_val=5 value="N/A" <?php echo $$dataDetails['least_once']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt2'] ?>" name="data[cmt2]"></td>
									</tr>
									<tr>
										<td rowspan=5 class="eml1">Script and FAQ's</td>
										<td class="eml" colspan=4>Verified the customer's name,address,email and phone number</td>
										<td>
											<select class="form-control conduent_points"  name="data[phone_number]" required>
												<option acm_val=5 value="Yes" <?php echo $$dataDetails['phone_number']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=5 value="No" <?php echo $$dataDetails['phone_number']=="No"?"selected":""; ?> >No</option>
												<option acm_val=5 value="N/A" <?php echo $$dataDetails['phone_number']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt3'] ?>" name="data[cmt3]"></td></tr>
									<tr>
										<td class="eml" colspan=4>Correct use of Flagging & Notating</td>
										<td>
											<select class="form-control conduent_points"  name="data[flagging_notating]" required>
												<option acm_val=10 value="Yes" <?php echo $$dataDetails['flagging_notating']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=10 value="No" <?php echo $$dataDetails['flagging_notating']=="No"?"selected":""; ?> >No</option>
												<option acm_val=10 value="N/A" <?php echo $$dataDetails['flagging_notating']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt4'] ?>" name="data[cmt4]"></td></tr>
									<tr>
										<td class="eml" colspan=4>Transfer to store if required</td>
										<td>
											<select class="form-control conduent_points"  name="data[if_required]" required>
												<option acm_val=5 value="Yes" <?php echo $$dataDetails['if_required']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=5 value="No" <?php echo $$dataDetails['if_required']=="No"?"selected":""; ?> >No</option>
												<option acm_val=5 value="N/A" <?php echo $$dataDetails['if_required']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt5'] ?>" name="data[cmt5]"></td></tr>
									<tr>
										<td class="eml" colspan=4>Did the agent follow training docs along with ACP and Blains Website</td>
										<td>
											<select class="form-control conduent_points"  name="data[blains_website]" required>
												<option acm_val=10 value="Yes" <?php echo $$dataDetails['blains_website']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=10 value="No" <?php echo $$dataDetails['blains_website']=="No"?"selected":""; ?> >No</option>
												<option acm_val=10 value="N/A" <?php echo $$dataDetails['blains_website']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt6'] ?>" name="data[cmt6]"></td></tr>
									<tr>
										<td class="eml" colspan=4>Integrity, Accountability, Teamwork, and Results.</td>
										<td>
											<select class="form-control conduent_points"  name="data[and_results]" required>
												<option acm_val=5 value="Yes" <?php echo $$dataDetails['and_results']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=5 value="No" <?php echo $$dataDetails['and_results']=="No"?"selected":""; ?> >No</option>
												<option acm_val=5 value="N/A" <?php echo $$dataDetails['and_results']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt7'] ?>" name="data[cmt7]"></td></tr>
									<tr>
										<td rowspan=5 class="eml1">Tone and Professionalism</td>
										<td class="eml" colspan=4>Demonstrates an attitude with every customer encounter through words and actions to show the customer respect and recgnition. </td>
										<td>
											<select class="form-control conduent_points"  name="data[and_recgnition]" required>
												<option acm_val=10 value="Yes" <?php echo $$dataDetails['and_recgnition']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=10 value="No" <?php echo $$dataDetails['and_recgnition']=="No"?"selected":""; ?> >No</option>
												<option acm_val=10 value="N/A" <?php echo $$dataDetails['and_recgnition']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt8'] ?>" name="data[cmt8]"></td></tr>
									<tr>
										<td class="eml" colspan=4>Did the agent avoid dead air, did the agent control the call, did the agent avoid unnecessary hold?</td>
										<td>
											<select class="form-control conduent_points"  name="data[dead_air]" required>
												<option acm_val=6 value="Yes" <?php echo $$dataDetails['dead_air']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=6 value="No" <?php echo $$dataDetails['dead_air']=="No"?"selected":""; ?> >No</option>
												<option acm_val=6 value="N/A" <?php echo $$dataDetails['dead_air']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt9'] ?>" name="data[cmt9]"></td></tr>
									<tr>
										<td class="eml" colspan=4>Tone, Over talking and pacing</td>
										<td>
											<select class="form-control conduent_points"  name="data[and_pacing]" required>
												<option acm_val=5 value="Yes" <?php echo $$dataDetails['and_pacing']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=5 value="No" <?php echo $$dataDetails['and_pacing']=="No"?"selected":""; ?> >No</option>
												<option acm_val=5 value="N/A" <?php echo $$dataDetails['and_pacing']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt10'] ?>" name="data[cmt10]"></td></tr>

									<tr>
										<td class="eml" colspan=4>Active Listening to the words a customer is speaking and understanding the request and avoid the customer repeating him/herself.</td>
										<td>
											<select class="form-control conduent_points"  name="data[the_request]" required>
												<option acm_val=6 value="Yes" <?php echo $$dataDetails['the_request']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=6 value="No" <?php echo $$dataDetails['the_request']=="No"?"selected":""; ?> >No</option>
												<option acm_val=6 value="N/A" <?php echo $$dataDetails['the_request']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt11'] ?>" name="data[cmt11]"></td></tr>

									<tr>
										<td class="eml" colspan=4>Empathized with customer</td>
										<td>
											<select class="form-control conduent_points"  name="data[with_customer]" required>
												<option acm_val=5 value="Yes" <?php echo $$dataDetails['with_customer']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=5 value="No" <?php echo $$dataDetails['with_customer']=="No"?"selected":""; ?> >No</option>
												<option acm_val=5 value="N/A" <?php echo $$dataDetails['with_customer']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt12'] ?>" name="data[cmt12]"></td></tr>

									<tr>
										<td rowspan=1 class="eml1">E-Alerts and Upselling</td>
										<td class="eml" colspan=4>Offering more items to the customer when an order is placed, or signing up for newsletter when the time is right.</td>
										<td>
											<select class="form-control conduent_points"  name="data[time_is_right]" required>
												<option acm_val=10 value="Yes" <?php echo $$dataDetails['time_is_right']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=10 value="No" <?php echo $$dataDetails['time_is_right']=="No"?"selected":""; ?> >No</option>
												<option acm_val=10 value="N/A" <?php echo $$dataDetails['time_is_right']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt13'] ?>" name="data[cmt13]"></td></tr>

									<tr>
										<td rowspan=1 class="eml1">Closing Script</td>
										<td class="eml" colspan=4>Did the agent close the call properly (with Branding Blains Farms and Fleet)</td>
										<td>
											<select class="form-control conduent_points"  name="data[call_properly]" required>
												<option acm_val=6 value="Yes" <?php echo $$dataDetails['call_properly']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=6 value="No" <?php echo $$dataDetails['call_properly']=="No"?"selected":""; ?> >No</option>
												<option acm_val=6 value="N/A" <?php echo $$dataDetails['call_properly']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt14'] ?>" name="data[cmt14]"></td></tr>

									<tr>
										<td rowspan=1 class="eml1">Disposition</td>
										<td class="eml" colspan=4>Did the agent dispose the call properly?</td>
										<td>
											<select class="form-control conduent_points"  name="data[call_properly]" required>
												<option acm_val=5 value="Yes" <?php echo $$dataDetails['call_dispose']=="Yes"?"selected":""; ?> >Yes</option>
												<option acm_val=5 value="No" <?php echo $$dataDetails['call_dispose']=="No"?"selected":""; ?> >No</option>
												<option acm_val=5 value="N/A" <?php echo $$dataDetails['call_dispose']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt15'] ?>" name="data[cmt15]"></td>
									</tr>
									<tr>
										<td rowspan=2 class="eml1" style="color:red">Other (Any score here =ZERO fatal for call)</td>
										<td class="eml" colspan=4>Rude remarks</td>
										<td>
											<select class="form-control conduent_points"  name="data[rude_remarks]" required>
												<option acm_val=1 value="Pass" <?php echo $$dataDetails['rude_remarks']=="Pass"?"selected":""; ?> >Yes</option>
												<option acm_val=0 value="Fail" <?php echo $$dataDetails['rude_remarks']=="Fail"?"selected":""; ?> >No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt16'] ?>" name="data[cmt16]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Call Avoidance</td>
										<td>
											<select class="form-control conduent_points"  name="data[call_avoidance]" required>
												<option acm_val=1 value="Pass" <?php echo $$dataDetails['call_avoidance']=="Pass"?"selected":""; ?> >Yes</option>
												<option acm_val=0 value="Fail" <?php echo $$dataDetails['call_avoidance']=="Fail"?"selected":""; ?> >No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt17'] ?>" name="data[cmt17]"></td>
									</tr>	
									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=4>Business Score</td><td colspan=4>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td colspan="">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockEarned1" name="custlockEarned" value="<?php echo $$dataDetails['custlockEarned'] ?>">
										</td>
										<td>Earned:</td>
										<td colspan="3">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockEarned1" name="busilockEarned" value="<?php echo $$dataDetails['busilockEarned'] ?>">
										</td>
										<td>Earned:</td>
										<td colspan="3">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockEarned1" name="compllockEarned" value="<?php echo $$dataDetails['compllockEarned'] ?>">
										</td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td>
										<td colspan="">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockPossible1" name="custlockPossible" value="<?php echo $$dataDetails['custlockPossible'] ?>">	
										</td>
										<td>Possible:</td>
										<td colspan="3">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockPossible1" name="busilockPossible" value="<?php echo $$dataDetails['busilockPossible'] ?>">	
										</td>
										<td>Possible:</td>
										<td colspan="3">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockPossible1" name="compllockPossible" value="<?php echo $$dataDetails['compllockPossible'] ?>">	
										</td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td colspan=""><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockScore" name="customer_score" value="<?php echo $$dataDetails['customer_score'] ?>"></td>
										<td>Percentage:</td><td colspan="3"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockScore" name="business_score" value="<?php echo $$dataDetails['business_score'] ?>"></td>
										<td>Percentage:</td><td colspan="3"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockScore" name="compliance_score" value="<?php echo $$dataDetails['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td colspan="3">Call Summary:</td>
										<td colspan="6"><textarea class="form-control" id="call_summary" name="data[call_summary]"><?php echo $$dataDetails['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="3">Feedback:</td>
										<td colspan="6"><textarea class="form-control" id="feedback" name="data[feedback]"><?php echo $$dataDetails['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($$dataDetails['attach_file']!=''){ ?>
									<tr>
										<td colspan="3">Audio Files (mp3|avi|mp4|wmv|wav)</td>
										<td colspan="6">
											<?php $attach_file = explode(",",$$dataDetails['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio controls='' style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/<?php echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/<?php echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Agent Feedback Acceptance:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['agnt_fd_acpt']; ?></td></tr>
									<tr><td style="font-size:16px">Agent Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['agent_rvw_note']; ?></td></tr>
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan="3"  style="font-size:16px">Client/Manager Reviews<span style="font-size:24px;color:red">*</span></td>
										<td colspan="6"><textarea class="form-control1" style="width:100%" name="note" placeholder="Please Write Reviews Here..." required></textarea></td>
									</tr>
									
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
									if(is_available_qa_feedback($$dataDetails['entry_date'],72) == true){ ?>
										<tr>
											<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:300px">SAVE</button> &nbsp; <a class="btn btn-warning" href="<?php echo base_url(); ?>Qa_ameridial/<?php echo $page; ?>">Back</a></td>
										</tr>
									<?php } 
									} ?>
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