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
	font-size:18px;
	background-color:#85C1E9;
}
</style>

<?php if($wallet_recharge_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px"> OYO WALLET RECHARGE</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr><td colspan=6 style="background-color:#BB9A66; font-size:14px; font-weight:bold">CALL DETAILS</td></tr>
									<?php
										if($wallet_recharge_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($wallet_recharge['entry_by']!=''){
												$auditorName = $wallet_recharge['auditor_name'];
											}else{
												$auditorName = $wallet_recharge['client_name'];
											}
											$auditDate = mysql2mmddyy($wallet_recharge['audit_date']);
											$clDate_val = mysqlDt2mmddyy($wallet_recharge['call_date']);
										}
										echo $clDate_val;
									?>
									<tr>
										<td>Name of Auditor:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Date of Audit:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Recording Date and Time:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $wallet_recharge['agent_id'] ?>"><?php echo $wallet_recharge['fname']." ".$wallet_recharge['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $wallet_recharge['tl_id'] ?>"><?php echo $wallet_recharge['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
										<td>Phone Number:</td>
										<td><input type="text" class="form-control" id="" name="phone" onkeyup="checkDec(this);" value="<?php echo $wallet_recharge['phone']; ?>" required></td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $wallet_recharge['call_duration']; ?>" required></td>
										
										<td>Product:</td>
										<td>
											<select class="form-control" id="" name="product" required>
												<option value="">-Select-</option>
												<option <?php echo $wallet_recharge['product']=='OYO Secure Wallet'?"selected":""; ?> value="OYO Secure Wallet">OYO Secure Wallet</option>
											</select>
										</td>
										<td>Campaign:</td>
										<td>
											<select class="form-control" id="" name="campaign" required>
												<option value="">-Select-</option>
												<option <?php echo $wallet_recharge['campaign']=='OYO Secure Wallet'?"selected":""; ?> value="OYO Secure Wallet">OYO Secure Wallet</option>
											</select>
										</td>
									</tr>
									<tr>
									<td>Customer VOC:</td>
										<td>
											<select class="form-control" id="cust_voc" name="customer_voc" required>
												<option value="<?php echo $wallet_recharge['customer_voc'] ?>"><?php echo $wallet_recharge['customer_voc'] ?></option>
												<option value="">-Select-</option>
												<option  value="Auto check in issue">Auto check in issue</option>
												<option  value="DA charges">DA charges</option>
												<option  value="Extra Amount deduction from secure wallet">Extra Amount deduction from secure wallet</option>
												<option  value="Bookings not received from OYO">Bookings not received from OYO</option>
												<option  value="Other issues">Other issues</option>
												<option  value="Low tariff/Booking issues">Low tariff/Booking issues</option>
												<option  value="Reconciliation issues">Reconciliation issues</option>
												<option  value="N/A">N/A</option>
												<option  value="Other">Other</option>
											</select>
										</td>
										<td>Customer Sub VOC:</td>
										<td>
											<select class="form-control" id="cust_sub_voc" name="customer_sub_voc" required>
												<option value="<?php echo $wallet_recharge['customer_sub_voc'] ?>"><?php echo $wallet_recharge['customer_sub_voc'] ?></option>
											</select>
										</td>
										<td>Objection:</td>
										<td>
											<select class="form-control" id="" name="objection" required>
												<option value="">-Select-</option>
												<option <?php echo $wallet_recharge['objection']=='Auto check in issue'?"selected":""; ?> value="Auto check in issue">Auto check in issue</option>
												<option <?php echo $wallet_recharge['objection']=='Bookings not received from OYO'?"selected":""; ?> value="Bookings not received from OYO">Bookings not received from OYO</option>
												<option <?php echo $wallet_recharge['objection']=='Extra Amount deduction from secure wallet'?"selected":""; ?> value="Extra Amount deduction from secure wallet">Extra Amount deduction from secure wallet</option>
												<option <?php echo $wallet_recharge['objection']=='Fund issue'?"selected":""; ?> value="Fund issue">Fund issue</option>
												<option <?php echo $wallet_recharge['objection']=='Low tariff/Booking Price'?"selected":""; ?> value="Low tariff/Booking Price">Low tariff/Booking Price</option>
												<option <?php echo $wallet_recharge['objection']=='Not getting corporate bookings'?"selected":""; ?> value="Not getting corporate bookings">Not getting corporate bookings</option>
												<option <?php echo $wallet_recharge['objection']=='Owner was out of town'?"selected":""; ?> value="Owner was out of town">Owner was out of town</option>
												<option <?php echo $wallet_recharge['objection']=='Quit from OYO'?"selected":""; ?> value="Quit from OYO">Quit from OYO</option>
												<option <?php echo $wallet_recharge['objection']=='Recharge amount not credit in wallet'?"selected":""; ?> value="Recharge amount not credit in wallet">Recharge amount not credit in wallet</option>
												<option <?php echo $wallet_recharge['objection']=='Reconciliation issues'?"selected":""; ?> value="Reconciliation issues">Reconciliation issues</option>
												<option <?php echo $wallet_recharge['objection']=='Ground team not responded'?"selected":""; ?> value="Ground team not responded">Ground team not responded</option>
												<option <?php echo $wallet_recharge['objection']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Property Code:</td>
										<td><input type="text" class="form-control" name="property_code" value="<?php echo $wallet_recharge['property_code'] ?>" required></td>
										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="agent_disposition" value="<?php echo $wallet_recharge['agent_disposition'] ?>" required></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="qa_disposition" value="<?php echo $wallet_recharge['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option <?php echo $wallet_recharge['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $wallet_recharge['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $wallet_recharge['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $wallet_recharge['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $wallet_recharge['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
											<option value="<?php echo $wallet_recharge['auditor_type'] ?>"><?php echo $wallet_recharge['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>

									
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option <?php echo $wallet_recharge['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $wallet_recharge['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $wallet_recharge['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $wallet_recharge['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $wallet_recharge['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="walletrecharge_possibleScore" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $wallet_recharge['possible_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="walletrecharge_earnedScore" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $wallet_recharge['earned_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="walletrecharge_overallScore" name="overall_score" class="form-control" style="font-weight:bold" value="<?php echo $wallet_recharge['overall_score'] ?>"></td>
									</tr>
									</tbody>
									</table>
									<table class="table table-striped skt-table" style="width:100%">
									<tbody>
									<tr style="background-color:#5DADE2; font-weight:bold; color:white; align-center">
										<th colspan=4>Parameters</th>
										<th colspan=4>Sub-Parameters</th>
										<th style="width:130px"> Score</th>
										<th>Legend</th>
										<th colspan=4>Remarks</th>
									</tr>
									<!-- <tr><td colspan=4 style="background-color:#BB9A66; font-size:14px; font-weight:bold">Critical</td></tr> -->
									<tr>
										<td colspan=4 rowspan=1>Greeting</td>
										<td colspan=4 rowspan=1 >Call Opening </td>
										<td>
											<select name="call_opening" class="form-control walletrecharge_points" id="walletrec1" required>
												<option value="">Select</option>
												<option walletrecharge_val=30 <?= ($wallet_recharge['call_opening']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option walletrecharge_val=30 <?= ($wallet_recharge['call_opening']=="No")?"selected":""?> value='No'>No</option>
												<option walletrecharge_val=30 <?= ($wallet_recharge['call_opening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												<option walletrecharge_val=0 <?= ($wallet_recharge['call_opening']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
											</select> 
										</td>
										<td>
											<p> 
												<strong>Yes:</strong>Owner name Confirmation,OYO ID/Hotel name confirmation,Owner/Financial Decision Maker.
												<br/><strong>No:</strong>If any of these components are missing than the same will be marked as not followed. Late Opening more than 5 secs,language confirmation not done in case of south hub will be marked down in this parameter.
												<br/><span style="color:red;"><strong>Fatal:</strong>Owner name Confirmation is not done by associates,incorrect/incomplete OYO ID/Hotel name confirmation,Owner/financial Decision Maker not confirmed.</span>
											</p>
										</td>
										<td colspan=4 rowspan=1><input type="text" value="<?= $wallet_recharge['call_opening_cmnt']?>" name="call_opening_cmnt" class="form-control"></td>
									</tr>
									<tr>
										<td colspan=4 rowspan=1>Financials and System checks</td>
										<td colspan=4 rowspan=1 >Account details and recharge amount </td>
										<td>
											<select name="financials_system" class="form-control walletrecharge_points" id="walletrec2" required>
												<option value="">Select</option>
												<option walletrecharge_val=30 <?= ($wallet_recharge['financials_system']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option walletrecharge_val=30 <?= ($wallet_recharge['financials_system']=="No")?"selected":""?> value='No'>No</option>
												<option walletrecharge_val=30 <?= ($wallet_recharge['call_opening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												<option walletrecharge_val=0 <?= ($wallet_recharge['financials_system']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
											</select> 
										</td>
										<td>
											<p> 
												<strong>Yes:</strong>before calling on property sold reason need to be checked by associates from cerebrum
														Pre check done by associates matching current balance from CRS
														correct minimum recharge amount share to maintain 7 days runway
														correct information shared to owner from calling sheet about daily revenue loss and bookings available 
														Shared basic details from Reconciliation issues
														correct information shared to owner on recharge amount and recon recharge  
														Correct minimum recharge amount shared.
												<br/><strong>No:</strong>negative CB balance not informed.
												<br/><span style="color:red;"><strong>Fatal:</strong>Prechecks from CRS not done incorrect current balance shared to owner incorrect minimum recharge amount shared to owner completely skipped reconciliation issues Recon recharge considered as recharge done by owner.</span>
											</p>
										</td>
										<td colspan=4 rowspan=1><input type="text" value="<?= $wallet_recharge['financials_system_cmnt']?>" name="financials_system_cmnt" class="form-control"></td>
									</tr>
									
									<tr>
										<td colspan=4 rowspan=1>VOC</td>
										<td colspan=4 rowspan=1 >Disposition </td>
										<td>
											<select name="disposition" class="form-control walletrecharge_points" id="walletrec3" required>
												<option value="">Select</option>
												<option walletrecharge_val=20 <?= ($wallet_recharge['disposition']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option walletrecharge_val=20 <?= ($wallet_recharge['disposition']=="No")?"selected":""?> value='No'>No</option>
												<option walletrecharge_val=20 <?= ($wallet_recharge['call_opening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												<option walletrecharge_val=0 <?= ($wallet_recharge['disposition']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
											</select> 
										</td>
										<td>
											<p> 
												<strong>Yes:</strong>Correct disposition code selected by associate according to customer commitment Complete/correct remarks captured by associate in Google form For Ex.-owner quoted that he would require Rs.1000 bookings price so, agent need to mention the same in remarks Deducted amount from secure wallet for which owner disputed need to capture Reconciliation issues-Disputed amount and month captured by associate in remark.
												<br/><strong>No:</strong>incorrect/incomplete remarks captured.
												<br/><span style="color:red;"><strong>Fatal:</strong>Incorrect disposition code selected by associate.</span>
											</p>
										</td>
										<td colspan=4 rowspan=1><input type="text" value="<?= $wallet_recharge['disposition_cmnt']?>" name="disposition_cmnt" class="form-control"></td>
									</tr>
									<tr>
										<td colspan=4 rowspan=1>Urgency</td>
										<td colspan=4 rowspan=1 >Urgency Creation </td>
										<td>
											<select name="urgency_creation" class="form-control walletrecharge_points"  required>
												<option value="">Select</option>
												<option walletrecharge_val=10 <?= ($wallet_recharge['urgency_creation']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option walletrecharge_val=10 <?= ($wallet_recharge['urgency_creation']=="No")?"selected":""?> value='No'>No</option>
												<option walletrecharge_val=10 <?= ($wallet_recharge['call_opening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												
											</select> 
										</td>
										<td>
											<p> 
												<strong>Yes:</strong>agent did not made soft urgency to convince owner for recharging today E.g.-Rebuttal need to share by sharing average revenue loss can be avoided and bookings can avail if recharge done and property remain.
												<br/><strong>No:</strong>Agent did not create urgency for convincing owner for recharging today.
											</p>
										</td>
										<td colspan=4 rowspan=1><input type="text" value="<?= $wallet_recharge['urgency_creation_cmnt']?>" name="urgency_creation_cmnt" class="form-control"></td>
									</tr>
									<tr>
										<td colspan=4 rowspan=1>Self help Option</td>
										<td colspan=4 rowspan=1 >App benefits</td>
										<td>
											<select name="app_benefits" class="form-control walletrecharge_points" required>
												<option value="">Select</option>
												<option walletrecharge_val=10 <?= ($wallet_recharge['app_benefits']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option walletrecharge_val=10 <?= ($wallet_recharge['app_benefits']=="No")?"selected":""?> value='No'>No</option>
												<option walletrecharge_val=10 <?= ($wallet_recharge['call_opening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											
											</select> 
										</td>
										<td>
											<p> 
												<strong>Yes:</strong>CO OYO app suggested to recharge in order to instantly make property live ticket raise option suggested for the resolution of issues such as reconciliation and low bookings price etc..
												<br/><strong>No:</strong>CO OYO app not suggested for recharge as well as for resolution of issues such as reconciliation and low bookings price etc.
											</p>
										</td>
										<td colspan=4 rowspan=1><input type="text" value="<?= $wallet_recharge['app_benefits_cmnt']?>" name="app_benefits_cmnt" class="form-control"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=6><textarea class="form-control" id="" name="call_summary"><?php echo $wallet_recharge['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=6><textarea class="form-control" id="" name="feedback"><?php echo $wallet_recharge['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="6">Upload Files</td>
										<?php if($wallet_recharge_id==0){ ?>
											<td colspan=6><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($wallet_recharge['attach_file']!=''){ ?>
											<td colspan="8">
												<?php $attach_file = explode(",",$wallet_recharge['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_inter/oyo_uk_us/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_inter/oyo_uk_us/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($wallet_recharge_id!=0){ ?>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=8><?php echo $wallet_recharge['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=8><?php echo $wallet_recharge['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=8><?php echo $wallet_recharge['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=4  style="font-size:16px">Your Review</td><td colspan=8><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($wallet_recharge_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
											<tr><td colspan=12><button class="btn btn-success waves-effect" type="submit" value="SAVE" name="btnSave" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_quality_access_trainer()==true){
											if(is_available_qa_feedback($wallet_recharge['entry_date'],72) == true){ ?>
												<tr><td colspan="12"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
