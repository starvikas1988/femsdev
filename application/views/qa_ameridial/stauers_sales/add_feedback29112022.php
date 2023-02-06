
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
										<td colspan="6" id="theader" style="font-size:30px">AMERIDIAL [Stauers sales Scorecard]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
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
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name=""></td>
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
										<td>Site/Location:</td>
										<td><input type="text" readonly class="form-control" id="office_id"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" required></td>
										<td>File No.:</td>
										<td><input type="text" class="form-control" id="file_no" name="file_no" required></td>
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
										<td style="font-weight:bold; font-size:16px">Earned Score</td>
										<td><input type="text" readonly id="conduent_earn_score" name="earned_score" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px">Possible Score</td>
										<td><input type="text" readonly id="conduent_possible_score" name="possible_score" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td><input type="text" readonly id="conduent_overall_score" name="overall_score" class="form-control" style="font-weight:bold"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D4AC0D">
										<td colspan="5">PARAMETER</td>
										<td>STATUS</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Was the call answered within 5 seconds?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text1" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent verify the customer's name and address on the account?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text2" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent capture the correct offer code?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text3" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent verify the phone number with the customer?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text4" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent verify the customer's email address?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text5" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent compliment the caller's purchase choice?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text6" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent recap the item and ask if the customer would be interested in any other product(s)?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text7" required>
												<option value="">-Select-</option>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent cover at least one upsell?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text8" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent cover the replacement guarantee pitch?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text9" required>
												<option value="">-Select-</option>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent use an appropriate rebuttal if the replacement guarantee was declined?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text10" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent cover the membership pitch?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text11" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent use an appropriate rebuttal if the membership pitch was declined?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text12" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent offer the membership accurately?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text13" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent cover the auto-renew offer correctly?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text14" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Was the shipping address verified?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text15" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent quote the correct delivery time?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text16" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent give a total product quote appropriately?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text17" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent quote shipping & taxes correctly?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text18" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent give the total to be charged and verify the credit card to be charged correctly?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text19" required>
												<option value="">-Select-</option>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent provide the order number correctly?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text20" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent close the call with the brand correctly?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text21" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Was the customer satisfied with his/her experience?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text22" required>
												<option value="">-Select-</option>
												<option acm_val=5 value="Yes">Yes</option>
												<option acm_val=5 value="No">No</option>
												<option acm_val=5 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Was the customer dissatisfied with the agent's professionalism and/or tone?</td>
										<td>
											<select class="form-control conduent_points" id="" name="text23" required>
												<option value="">-Select-</option>
												<option acm_val=10 value="Yes">Yes</option>
												<option acm_val=10 value="No">No</option>
												<option acm_val=10 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" id="call_summary" name="call_summary"></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" id="feedback" name="feedback"></textarea></td>
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
