
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
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
										<td colspan="6" id="theader" style="font-size:30px">KABBAGE [Evaluation Scoring Sheet]</td>
									</tr>
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<?php if(get_login_type()=="client"){ ?>
											<td><input type="text" class="form-control" name="audit_type" value="Client Audit" readonly></td>
										<?php }else{ ?>
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
										<?php } ?>
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
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Event:</td>
										<td><input type="text" class="form-control" id="" name="event" required></td>
										<td>Call Type:</td>
										<td>
											<select class="form-control" id="" name="call_type" required>
												<option value="">-Select-</option>
												<option value="PPP-Docs">PPP-Docs</option>
												<option value="PPP-Status">PPP-Status</option>
												<option value="PPP-Edit">PPP-Edit</option>
												<option value="PPP-Withdrawals">PPP-Withdrawals</option>
												<option value="PPP-General">PPP-General</option>
												<option value="PPP-Internal Bank Add">PPP-Internal Bank Add</option>
												<option value="PPP-CRB">PPP-CRB</option>
												<option value="PPP-OG Rep">PPP-OG Rep</option>
												<option value="Forgiveness Inquiry">Forgiveness Inquiry</option>
											</select>
										</td>
										<td>KUSERID:</td>
										<td><input type="text" class="form-control" id="" name="kuserid" required></td>
									</tr>
									</tr>
										<td>Ticket ID:</td>
										<td><input type="text" class="form-control" id="" name="ticket_id" required></td>
										<td style="color:red">Auto Fail:</td>
										<td>
											<select class="form-control procedural" id="kabbageAF" name="auto_fail" required>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="kabbage_overall_score" name="overall_score" class="form-control" style="font-weight:bold"></td>
									</tr>
									
									<tr style="height:25px; font-weight:bold; background-color:#5DADE2">
										<td rowspan=2 style="width:10px">#</td>
										<td rowspan=2 style="text-align:left">Procedural</td>
										<td>Earned Score</td>
										<td>Possible Score</td>
										<td>Score</td>
										<td rowspan=2>Comment</td>
									</tr>
									<tr style="background-color:#5DADE2; font-weight:bold">
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="procedural_earned" name="procedural_earned" readonly></td>
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="procedural_possible" name="procedural_possible" readonly></td>
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="procedural_score" name="procedural_score" readonly></td>
									</tr>
									<tr>
										<td>1</td>
										<td colspan=2>Did the agent answer the call with their name and the name of the product?</td>
										<td>
											<select class="form-control procedural" id="" name="agentanswerthecall" required>
												<option value="">-Select-</option>
												<option procedural_val=20 value="True">True</option>
												<option procedural_val=20 value="False">False</option>
												<option procedural_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt1"></td>
									</tr>
									<tr>
										<td>2</td>
										<td colspan=2>Did the agent request all appropriate documents from the caller</td>
										<td>
											<select class="form-control procedural" id="" name="agentrequestdocuments" required>
												<option value="">-Select-</option>
												<option procedural_val=45 value="True">True</option>
												<option procedural_val=45 value="False">False</option>
												<option procedural_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt2"></td>
									</tr>
									<tr>
										<td>3</td>
										<td colspan=2>Did the agent document all systems appropriately?  Salesforce?  CoreCard?</td>
										<td>
											<select class="form-control procedural" id="" name="documentallsystem" required>
												<option value="">-Select-</option>
												<option procedural_val=45 value="True">True</option>
												<option procedural_val=45 value="False">False</option>
												<option procedural_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt3"></td>
									</tr>
									<tr>
										<td>4</td>
										<td colspan=2>Did the agent ask how they could help the customer?</td>
										<td>
											<select class="form-control procedural" id="" name="agentasktohelpcustomer" required>
												<option value="">-Select-</option>
												<option procedural_val=20 value="True">True</option>
												<option procedural_val=20 value="False">False</option>
												<option procedural_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt4"></td>
									</tr>
									<tr>
										<td>5</td>
										<td colspan=2>Did the agent verify all information is good?  Phone number(s)?  Address(es)?</td>
										<td>
											<select class="form-control procedural" id="" name="agentverifyallinformation" required>
												<option value="">-Select-</option>
												<option procedural_val=40 value="True">True</option>
												<option procedural_val=40 value="False">False</option>
												<option procedural_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt5"></td>
									</tr>
									
									<tr style="height:25px; font-weight:bold; background-color:#5DADE2">
										<td rowspan=2>#</td>
										<td rowspan=2 style="text-align:left">Compliance</td>
										<td>Earned Score</td>
										<td>Possible Score</td>
										<td>Score</td>
										<td rowspan=2>Comment</td>
									</tr>
									<tr style="background-color:#5DADE2; font-weight:bold">
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="compliance_earned" name="compliance_earned" readonly></td>
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="compliance_possible" name="compliance_possible" readonly></td>
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="compliance_score" name="compliance_score" readonly></td>
									</tr>
									<tr>
										<td>6</td>
										<td colspan=2>Did the agent ask the caller for their Kabbage User Name?</td>
										<td>
											<select class="form-control compliance" id="" name="agentaskkabbagename" required>
												<option value="">-Select-</option>
												<option compliance_val=30 value="True">True</option>
												<option compliance_val=30 value="False">False</option>
												<option compliance_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt6"></td>
									</tr>
									<tr>
										<td>7</td>
										<td colspan=2>Did the agent ask the caller for the last four (4) digits of their Social Security Number?</td>
										<td>
											<select class="form-control compliance" id="" name="agentaskcallerforSSnumber" required>
												<option value="">-Select-</option>
												<option compliance_val=30 value="True">True</option>
												<option compliance_val=30 value="False">False</option>
												<option compliance_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt7"></td>
									</tr>
									<tr>
										<td>8</td>
										<td colspan=2>Did the agent refrain from disclosing account specific information until the verification process was completed?</td>
										<td>
											<select class="form-control compliance" id="" name="agentrefraindisclosingAccount" required>
												<option value="">-Select-</option>
												<option compliance_val=30 value="True">True</option>
												<option compliance_val=30 value="False">False</option>
												<option compliance_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt8"></td>
									</tr>
									<tr>
										<td>9</td>
										<td colspan=2>Did the agent abide by all legal and regulatory requirements?</td>
										<td>
											<select class="form-control compliance" id="" name="agentabideallrequirement" required>
												<option value="">-Select-</option>
												<option compliance_val=30 value="True">True</option>
												<option compliance_val=30 value="False">False</option>
												<option compliance_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt9"></td>
									</tr>
									
									<tr style="height:25px; font-weight:bold; background-color:#5DADE2">
										<td rowspan=2>#</td>
										<td rowspan=2 style="text-align:left">Customer Experience </td>
										<td>Earned Score</td>
										<td>Possible Score</td>
										<td>Score</td>
										<td rowspan=2>Comment</td>
									</tr>
									<tr style="background-color:#5DADE2; font-weight:bold">
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="customerexp_earned" name="customerexp_earned" readonly></td>
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="customerexp_possible" name="customerexp_possible" readonly></td>
										<td><input type="text" class="form-control" style="background-color:#5DADE2; text-align:center" id="customerexp_score" name="customerexp_score" readonly></td>
									</tr>
									<tr>
										<td>10</td>
										<td colspan=2>Did the agent provide the caller with accurate information</td>
										<td>
											<select class="form-control customerexp" id="" name="agentprovideaccurateinformation" required>
												<option value="">-Select-</option>
												<option customerexp_val=40 value="True">True</option>
												<option customerexp_val=40 value="False">False</option>
												<option customerexp_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt10"></td>
									</tr>
									<tr>
										<td>11</td>
										<td colspan=2>Did  the agent do everything necessary and reasonable to create a single contact or one-touch resolution?</td>
										<td>
											<select class="form-control customerexp" id="" name="agentcreatesinglecontact" required>
												<option value="">-Select-</option>
												<option customerexp_val=40 value="True">True</option>
												<option customerexp_val=40 value="False">False</option>
												<option customerexp_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt11"></td>
									</tr>
									<tr>
										<td>12</td>
										<td colspan=2>Was the agent engaged in the call with the caller in an effort to resolve the caller's issue?  Did the agent's tone and attitude indicate engagement with the caller?</td>
										<td>
											<select class="form-control customerexp" id="" name="agentengagedincall" required>
												<option value="">-Select-</option>
												<option customerexp_val=10 value="True">True</option>
												<option customerexp_val=10 value="False">False</option>
												<option customerexp_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt12"></td>
									</tr>
									<tr>
										<td>13</td>
										<td colspan=2>Did the agent maintain a friendly, professional tone?</td>
										<td>
											<select class="form-control customerexp" id="" name="agentmaintainfriendlytone" required>
												<option value="">-Select-</option>
												<option customerexp_val=10 value="True">True</option>
												<option customerexp_val=10 value="False">False</option>
												<option customerexp_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt13"></td>
									</tr>
									<tr>
										<td>14</td>
										<td colspan=2>Did the agent keep holds and distractions to a minimum?</td>
										<td>
											<select class="form-control customerexp" id="" name="agentkeepdistractions" required>
												<option value="">-Select-</option>
												<option customerexp_val=10 value="True">True</option>
												<option customerexp_val=10 value="False">False</option>
												<option customerexp_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt14"></td>
									</tr>
									<tr>
										<td>15</td>
										<td colspan=2>Did the agent ask the caller if all their issues were resolved prior to ending the call?</td>
										<td>
											<select class="form-control customerexp" id="" name="agentasktoendcall" required>
												<option value="">-Select-</option>
												<option customerexp_val=5 value="True">True</option>
												<option customerexp_val=5 value="False">False</option>
												<option customerexp_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt15"></td>
									</tr>
									<tr>
										<td>16</td>
										<td colspan=2>Did the agent thank the caller for choosing Kabbage?</td>
										<td>
											<select class="form-control customerexp" id="" name="agentthankthecaller" required>
												<option value="">-Select-</option>
												<option customerexp_val=5 value="True">True</option>
												<option customerexp_val=5 value="False">False</option>
												<option customerexp_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt16"></td>
									</tr>
									<!--<tr>
										<td>17</td>
										<td colspan=2>Did the agent encourage the customer to take more cash or complete an application, if appropriate?</td>
										<td>
											<select class="form-control customerexp" id="" name="agentencouragetotalecash" required>
												<option value="">-Select-</option>
												<option customerexp_val=10 value="True">True</option>
												<option customerexp_val=10 value="False">False</option>
												<option customerexp_val=0 value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt17"></td>
									</tr>-->
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="call_summary" name="call_summary"></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="feedback" name="feedback"></textarea></td>
									</tr>
									<tr><td colspan=2>Upload Files</td><td colspan=4><input type="file" multiple class="form-control" id="fileuploadbasic" name="attach_file[]" ></td>
									</tr>
									<?php if(is_access_qa_module()==true || get_login_type()=="client"){ ?>
									<tr>
										<td colspan="6"><button class="btn btn-success waves-effect addKbgFd" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
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
