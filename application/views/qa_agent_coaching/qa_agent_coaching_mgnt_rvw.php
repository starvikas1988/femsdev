<script src="<?php echo base_url() ?>application/third_party/ckeditor/ckeditor.js"></script>
<style>
input{

	text-align:center;
}

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
	background-color:#D4EFDF;
}

select {
  text-align: center;
  text-align-last: center;
  /* webkit*/
}
option {
  text-align: left;
  /* reset to left*/
}

textarea{
	text-align: center;
  text-align-last: center;
}

</style>

<style> 
	.nps_panel, .nps_flip, .aht_panel, .aht_flip, .revenue_panel, .revenue_flip, .compl_panel, .compl_flip, .noncust_panel, .noncust_flip, .keyper_panel, .keyper_flip {
	  padding: 5px;
	  text-align: center;
	  background-color: #e5eecc;
	  border: solid 1px #c3c3c3;
	}

	.nps_panel, .aht_panel, .revenue_panel, .compl_panel, .noncust_panel, .keyper_panel {
	  padding: 50px;
	  display: none;
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
										<td colspan="6" id="theader" style="font-size:30px">Management Coaching Review</td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $Qa_agent_coaching['auditor_name']; ?>" disabled></td>
										<td>Client:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<select class="form-control" style="text-align:center" id="client_id" name="client" disabled>
												<option value="<?php echo $Qa_agent_coaching['client_id'] ?>"><?php echo $Qa_agent_coaching['client_name'] ?></option>
												<option value="">-Select-</option>
												<?php foreach ($client as $key => $value){ ?>
												<option value="<?php echo $value['id'] ?>"><?php echo $value['fullname'] ?></option>
											<?php } ?>
											</select>
										</td>
										<td>Process:</td>
										<td>
											<select class="form-control" style="text-align:center" id="process_client" name="process_client" disabled>
												<option value="<?php echo $Qa_agent_coaching['process_id']; ?>"><?php echo $Qa_agent_coaching['process_name']; ?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" style="text-align:center" id="agent_id" name="agent_id" disabled>
												<option value="<?php echo $Qa_agent_coaching['agent_id']; ?>"><?php echo $Qa_agent_coaching['agent_name']."-(".$Qa_agent_coaching['fusion_id'].")"; ?></option>
												<option value="">-Select-</option>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" disabled>
												<option value="<?php echo $Qa_agent_coaching['assigned_to']; ?>"><?php echo $Qa_agent_coaching['tl_name']; ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
											<!--<input type="text" class="form-control" id="tl_name" name="tl_name" readonly>-->
										</td>
										<td>Call Date and Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" autocomplete="off" onkeydown="return false;" value="<?php echo $Qa_agent_coaching['call_date']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($Qa_agent_coaching['audit_date']); ?>" disabled></td>
										<td>Site:</td>
										<td><input type="text" readonly class="form-control" id="site" name="site" value="<?php echo $Qa_agent_coaching['location']; ?>"></td>
										<td>Coaching Department:</td>
										<td><input type="text" readonly class="form-control" id="dept_id" value="<?php echo $Qa_agent_coaching['department_name']; ?>"></td>
									</tr>
									<tr>
										<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_id" name="call_id" value="<?php echo $Qa_agent_coaching['call_id']; ?>" disabled></td>
										<td>Coaching Reason:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $Qa_agent_coaching['coaching_reason']; ?>" disabled></td>
										<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="call_type" value="<?php echo $Qa_agent_coaching['call_type']; ?>" disabled></td>
									</tr>
									
									<?php if ($Qa_agent_coaching['client_id']==42 ||
									$Qa_agent_coaching['client_id']==257 ||
									$Qa_agent_coaching['client_id']==124 ||
									$Qa_agent_coaching['client_id']==211 ||
									$Qa_agent_coaching['client_id']==40) {?>
										<tr class="rca_fields">
											<td colspan="6">Root Cause Analysis</td>
										</tr>
										<tr class="rca_fields">
											<td colspan="2">
												<label for="rca_level1">Level 1</label>
												<select id="rca_level1" name="rca_level1" class="form-control" disabled>
													<option value="<?php echo $Qa_agent_coaching['rca_level1']?>"><?php echo $rca_level1[$Qa_agent_coaching['rca_level1']]?></option>
												</select>
											</td>
											<td colspan="2">
												<label for="rca_level2">Level 2</label>
												<select id="rca_level2" name="rca_level2" class="form-control" disabled>
													<option value="<?php echo $Qa_agent_coaching['rca_level2']?>"><?php echo $rca_level2[$Qa_agent_coaching['rca_level2']]?></option>
												</select>
											</td>
											<td colspan="2">
												<label for="rca_level3">Level 3</label>
												<select id="rca_level3" name="rca_level3" class="form-control" disabled>
													<option value="<?php echo$Qa_agent_coaching['rca_level3']?>"><?php echo $rca_level3[$Qa_agent_coaching['rca_level3']]?></option>
												</select>
											</td>
										</tr>
									<?php } ?>
									<tr>
										<td>Observation Method:</td>
										<td>
											<select class="form-control" name="observation_method" disabled>
												<option value="<?php echo $Qa_agent_coaching['observation_method'] ?>"><?php echo $Qa_agent_coaching['observation_method'] ?></option>
												<option value="">--Select--</option>
												<option value="Displayed">Displayed</option>
												<option value="Remote">Remote</option>
												<option value="SBS">SBS</option>
												<option value="Call Recording">Call Recording</option>
											</select>
										</td>
										<td>For Follow Up?:</td>
										<td>
											<select class="form-control" name="for_follow_up" disabled>
												<option value="<?php echo $Qa_agent_coaching['for_follow_up'] ?>"><?php echo $Qa_agent_coaching['for_follow_up'] ?></option>
												<option value="">--Select--</option>
												<option value="Displayed">Displayed</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
										<td>Coaching Documentation:</td>
										<td><textarea class="form-control" name="coaching_docu" disabled><?php echo $Qa_agent_coaching['coaching_docu'] ?></textarea></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="nps_flip">NPS &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="nps_panel">
										<td colspan=2>Gathered homeowner name, gave our name and greeted the homeowner</td>
										<td>
											<select class="form-control" name="nps1" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps1'] ?>"><?php echo $Qa_agent_coaching['nps1'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt1" readonly value="<?php echo $Qa_agent_coaching['nps_cmt1'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Used homeowner name multiple times throughout the interaction</td>
										<td>
											<select class="form-control" name="nps2" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps2'] ?>"><?php echo $Qa_agent_coaching['nps2'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt2" readonly value="<?php echo $Qa_agent_coaching['nps_cmt2'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Effectively probed to understand the true concern of the homeowner</td>
										<td>
											<select class="form-control" name="nps3" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps3'] ?>"><?php echo $Qa_agent_coaching['nps3'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt3" readonly value="<?php echo $Qa_agent_coaching['nps_cmt3'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Assured homeowner we would assist them with their call</td>
										<td>
											<select class="form-control" name="nps4" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps4'] ?>"><?php echo $Qa_agent_coaching['nps4'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt4" readonly value="<?php echo $Qa_agent_coaching['nps_cmt4'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Owned issue within scope and through resolution</td>
										<td>
											<select class="form-control" name="nps5" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps5'] ?>"><?php echo $Qa_agent_coaching['nps5'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt5" readonly value="<?php echo $Qa_agent_coaching['nps_cmt5'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Utilized all available tools and resources to resolve the homeowners concern</td>
										<td>
											<select class="form-control" name="nps6" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps6'] ?>"><?php echo $Qa_agent_coaching['nps6'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt6" readonly value="<?php echo $Qa_agent_coaching['nps_cmt6'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Provided genuine empathy statements throughout the interaction</td>
										<td>
											<select class="form-control" name="nps7" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps7'] ?>"><?php echo $Qa_agent_coaching['nps7'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt7" readonly value="<?php echo $Qa_agent_coaching['nps_cmt7'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Expressed willingness to assist</td>
										<td>
											<select class="form-control" name="nps8" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps8'] ?>"><?php echo $Qa_agent_coaching['nps8'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt8" readonly value="<?php echo $Qa_agent_coaching['nps_cmt8'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Addressed any homeowner concern brought up in the call</td>
										<td>
											<select class="form-control" name="nps9" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps9'] ?>"><?php echo $Qa_agent_coaching['nps9'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt9" readonly value="<?php echo $Qa_agent_coaching['nps_cmt9'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Explained clearly and effectively</td>
										<td>
											<select class="form-control" name="nps10" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps10'] ?>"><?php echo $Qa_agent_coaching['nps10'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt10" readonly value="<?php echo $Qa_agent_coaching['nps_cmt10'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Introduced a valuable solution to the homeowner</td>
										<td>
											<select class="form-control" name="nps11" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps11'] ?>"><?php echo $Qa_agent_coaching['nps11'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt11" readonly value="<?php echo $Qa_agent_coaching['nps_cmt11'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Provided needed assurance statements</td>
										<td>
											<select class="form-control" name="nps12" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps12'] ?>"><?php echo $Qa_agent_coaching['nps12'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt12" readonly value="<?php echo $Qa_agent_coaching['nps_cmt12'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Remained professional with a positive and upbeat tone</td>
										<td>
											<select class="form-control" name="nps13" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps13'] ?>"><?php echo $Qa_agent_coaching['nps13'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt13" readonly value="<?php echo $Qa_agent_coaching['nps_cmt13'] ?>"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Made it EASY for the homeowner</td>
										<td>
											<select class="form-control" name="nps14" disabled>
												<option value="<?php echo $Qa_agent_coaching['nps14'] ?>"><?php echo $Qa_agent_coaching['nps14'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt14" readonly value="<?php echo $Qa_agent_coaching['nps_cmt14'] ?>"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="aht_flip">AHT &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="aht_panel">
										<td colspan=2>Effectively probed to understand true issue of the call</td>
										<td>
											<select class="form-control" name="aht1" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht1'] ?>"><?php echo $Qa_agent_coaching['aht1'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt1" readonly value="<?php echo $Qa_agent_coaching['aht_cmt1'] ?>"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Gained agreement on the issue</td>
										<td>
											<select class="form-control" name="aht2" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht2'] ?>"><?php echo $Qa_agent_coaching['aht2'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt2" readonly value="<?php echo $Qa_agent_coaching['aht_cmt2'] ?>"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Utilized all available tools and resources to resolve the homeowners concern</td>
										<td>
											<select class="form-control" name="aht3" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht3'] ?>"><?php echo $Qa_agent_coaching['aht3'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt3" readonly value="<?php echo $Qa_agent_coaching['aht_cmt3'] ?>"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Properly positioned time consuming tasks and hold times</td>
										<td>
											<select class="form-control" name="aht4" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht4'] ?>"><?php echo $Qa_agent_coaching['aht4'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt4" readonly value="<?php echo $Qa_agent_coaching['aht_cmt4'] ?>"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Controlled the call throughout the interaction</td>
										<td>
											<select class="form-control" name="aht5" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht5'] ?>"><?php echo $Qa_agent_coaching['aht5'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt5" readonly value="<?php echo $Qa_agent_coaching['aht_cmt5'] ?>"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Actively listened to the homeowner</td>
										<td>
											<select class="form-control" name="aht6" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht6'] ?>"><?php echo $Qa_agent_coaching['aht6'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt6" readonly value="<?php echo $Qa_agent_coaching['aht_cmt6'] ?>"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Efficiently explained the the details/ process to the customer</td>
										<td>
											<select class="form-control" name="aht7" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht7'] ?>"><?php echo $Qa_agent_coaching['aht7'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt7" readonly value="<?php echo $Qa_agent_coaching['aht_cmt7'] ?>"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Adhered to ACW and Hold guidelines</td>
										<td>
											<select class="form-control" name="aht8" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht8'] ?>"><?php echo $Qa_agent_coaching['aht8'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt8" readonly value="<?php echo $Qa_agent_coaching['aht_cmt8'] ?>"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Properly followed the transfer procedure</td>
										<td>
											<select class="form-control" name="aht9" disabled>
												<option value="<?php echo $Qa_agent_coaching['aht9'] ?>"><?php echo $Qa_agent_coaching['aht9'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt9" readonly value="<?php echo $Qa_agent_coaching['aht_cmt9'] ?>"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="revenue_flip">REVENUE &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="revenue_panel">
										<td colspan=2>Effectively Positioned Offer (LFBB)</td>
										<td>
											<select class="form-control" name="revenue1" disabled>
												<option value="<?php echo $Qa_agent_coaching['revenue1'] ?>"><?php echo $Qa_agent_coaching['revenue1'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt1" readonly value="<?php echo $Qa_agent_coaching['revenue_cmt1'] ?>"></td>
									</tr>
									<tr class="revenue_panel">
										<td colspan=2>Assumptively Asked for the Sale</td>
										<td>
											<select class="form-control" name="revenue2" disabled>
												<option value="<?php echo $Qa_agent_coaching['revenue2'] ?>"><?php echo $Qa_agent_coaching['revenue2'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt2" readonly value="<?php echo $Qa_agent_coaching['revenue_cmt2'] ?>"></td>
									</tr>
									<tr class="revenue_panel">
										<td colspan=2>Identified unstated Needs</td>
										<td>
											<select class="form-control" name="revenue3" disabled>
												<option value="<?php echo $Qa_agent_coaching['revenue3'] ?>"><?php echo $Qa_agent_coaching['revenue3'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt3" readonly value="<?php echo $Qa_agent_coaching['revenue_cmt3'] ?>"></td>
									</tr>
									<tr class="revenue_panel">
										<td colspan=2>Offered Relevant and Strategic Cross Sell</td>
										<td>
											<select class="form-control" name="revenue4" disabled>
												<option value="<?php echo $Qa_agent_coaching['revenue4'] ?>"><?php echo $Qa_agent_coaching['revenue4'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt4" readonly value="<?php echo $Qa_agent_coaching['revenue_cmt4'] ?>"></td>
									</tr>
									<tr class="revenue_panel">
										<td colspan=2>Provided Effective and relevant Rebuttals</td>
										<td>
											<select class="form-control" name="revenue5" disabled>
												<option value="<?php echo $Qa_agent_coaching['revenue5'] ?>"><?php echo $Qa_agent_coaching['revenue5'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt5" readonly value="<?php echo $Qa_agent_coaching['revenue_cmt5'] ?>"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="compl_flip">COMPLIANCE &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="compl_panel">
										<td colspan=2>Stated that they were on a recorded line</td>
										<td>
											<select class="form-control" name="compliance1" disabled>
												<option value="<?php echo $Qa_agent_coaching['compliance1'] ?>"><?php echo $Qa_agent_coaching['compliance1'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt1" readonly value="<?php echo $Qa_agent_coaching['compliance_cmt1'] ?>"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Confirmed and entered the correct zip code</td>
										<td>
											<select class="form-control" name="compliance2" disabled>
												<option value="<?php echo $Qa_agent_coaching['compliance2'] ?>"><?php echo $Qa_agent_coaching['compliance2'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt2" readonly value="<?php echo $Qa_agent_coaching['compliance_cmt2'] ?>"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Submitted the project under correct CTT</td>
										<td>
											<select class="form-control" name="compliance3" disabled>
												<option value="<?php echo $Qa_agent_coaching['compliance3'] ?>"><?php echo $Qa_agent_coaching['compliance3'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt3" readonly value="<?php echo $Qa_agent_coaching['compliance_cmt3'] ?>"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Detailed description was correct and professionally presented</td>
										<td>
											<select class="form-control" name="compliance4" disabled>
												<option value="<?php echo $Qa_agent_coaching['compliance4'] ?>"><?php echo $Qa_agent_coaching['compliance4'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt4" readonly value="<?php echo $Qa_agent_coaching['compliance_cmt4'] ?>"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Correctly processed a DNC request (when applicable)</td>
										<td>
											<select class="form-control" name="compliance5" disabled>
												<option value="<?php echo $Qa_agent_coaching['compliance5'] ?>"><?php echo $Qa_agent_coaching['compliance5'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt5" readonly value="<?php echo $Qa_agent_coaching['compliance_cmt5'] ?>"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Correctly dispositioned the call</td>
										<td>
											<select class="form-control" name="compliance6" disabled>
												<option value="<?php echo $Qa_agent_coaching['compliance6'] ?>"><?php echo $Qa_agent_coaching['compliance6'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt6" readonly value="<?php echo $Qa_agent_coaching['compliance_cmt6'] ?>"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Did not share sensitive customer identifiable information</td>
										<td>
											<select class="form-control" name="compliance7" disabled>
												<option value="<?php echo $Qa_agent_coaching['compliance7'] ?>"><?php echo $Qa_agent_coaching['compliance7'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt7" readonly value="<?php echo $Qa_agent_coaching['compliance_cmt7'] ?>"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="noncust_flip">Non-Customer Interactive &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="noncust_panel">
										<td colspan=2>Information Security and Cleandesk violations</td>
										<td>
											<select class="form-control" name="non_cust_interact1" disabled>
												<option value="<?php echo $Qa_agent_coaching['non_cust_interact1'] ?>"><?php echo $Qa_agent_coaching['non_cust_interact1'] ?></option>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="non_cust_interact_cmt1" readonly value="<?php echo $Qa_agent_coaching['non_cust_interact_cmt1'] ?>"></td>
									</tr>
									<tr class="noncust_panel">
										<td colspan=2>Time Keeping Violation</td>
										<td>
											<select class="form-control" name="non_cust_interact2" disabled>
												<option value="<?php echo $Qa_agent_coaching['non_cust_interact2'] ?>"><?php echo $Qa_agent_coaching['non_cust_interact2'] ?>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="non_cust_interact_cmt2" readonly value="<?php echo $Qa_agent_coaching['non_cust_interact_cmt2'] ?>"></td>
									</tr>
									<tr class="noncust_panel">
										<td colspan=2>Utilization - AUX Abuse</td>
										<td>
											<select class="form-control" name="non_cust_interact3" disabled>
												<option value="<?php echo $Qa_agent_coaching['non_cust_interact3'] ?>"><?php echo $Qa_agent_coaching['non_cust_interact3'] ?>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="non_cust_interact_cmt3" readonly value="<?php echo $Qa_agent_coaching['non_cust_interact_cmt3'] ?>"></td>
									</tr>
									<tr class="noncust_panel">
										<td colspan=2>Utilization - Shift Adherence</td>
										<td>
											<select class="form-control" name="non_cust_interact4" disabled>
												<option value="<?php echo $Qa_agent_coaching['non_cust_interact4'] ?>"><?php echo $Qa_agent_coaching['non_cust_interact4'] ?>
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="non_cust_interact_cmt4" readonly value="<?php echo $Qa_agent_coaching['non_cust_interact_cmt4'] ?>"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="keyper_flip">Key Performance Results &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="keyper_panel">
										<td colspan=2>NPS</td>
										<td colspan=4><input type="text" class="form-control" name="nps_result" readonly value="<?php echo $Qa_agent_coaching['nps_result'] ?>"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>AHT</td>
										<td colspan=4><input type="text" class="form-control" name="aht_result" readonly value="<?php echo $Qa_agent_coaching['aht_result'] ?>"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>Quality</td>
										<td colspan=4><input type="text" class="form-control" name="quality_result" readonly value="<?php echo $Qa_agent_coaching['quality_result'] ?>"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>Conversion</td>
										<td colspan=4><input type="text" class="form-control" name="conversion_result" readonly value="<?php echo $Qa_agent_coaching['conversion_result'] ?>"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>Cross-sell</td>
										<td colspan=4><input type="text" class="form-control" name="crosssell_result" readonly value="<?php echo $Qa_agent_coaching['crosssell_result'] ?>"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>Adherence</td>
										<td colspan=4><input type="text" class="form-control" name="adherence_result" readonly value="<?php echo $Qa_agent_coaching['adherence_result'] ?>"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>BEHAVIORAL IMPROVEMENT LEVEL (if flagged for follow-up)</td>
										<td colspan=2>
											<select class="form-control" name="behavioral_improvement" disabled>
												<option value="<?php echo $Qa_agent_coaching['behavioral_improvement'] ?>"><?php echo $Qa_agent_coaching['behavioral_improvement'] ?>
												<option value="">Select</option>
												<option value="Good Improvement">Good Improvement</option>
												<option value="Some Improvement">Some Improvement</option>
												<option value="No Improvement">No Improvement</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="behavioral_improvement_cmt" readonly value="<?php echo $Qa_agent_coaching['behavioral_improvement_cmt'] ?>"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<?php if($Qa_agent_coaching['attach_file']!=''){ ?>
									<tr>
										<td colspan="3">Audio Files</td>
										<td colspan="3">
											<?php $attach_file = explode(",",$Qa_agent_coaching['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93">
												  <source src="<?php echo base_url(); ?>qa_files/qa_agent_coaching/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_agent_coaching/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<?php if(!empty($row1)){ ?>
										<?php if($row1['id']==''){ ?>
											<tr>
												<td colspan="6" style="font-size:16px; font-weight:bold">Agent Review Not found</td>
											</tr>
										<?php }else{ ?>
											<tr>
												<td colspan="2"  style="font-size:16px; font-weight:bold;width:70px">Agent Review</td>
												<td colspan="4">
													<i><textarea class="form-control" style="font-weight:bold" name="note" disabled><?php echo strip_tags($row1['comment']); ?></textarea></i>
												</td>
											</tr>
										<?php } ?>
									<?php } ?>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>

									<?php
									$z=0;
									foreach ($row2 as $key => $mgnt_val) {
									if($mgnt_val['id']==''){ ?>
									<tr>
										<td colspan="2"  style="font-size:16px; font-weight:bold;width:70px">Manager Review</td>
										<td colspan="4">
											<input type="hidden" id="action" name="action" class="form-control" value="">
											<textarea class="form-control" style="font-weight:bold" id="note" name="note" required></textarea>
										</td>
									</tr>
								<?php }else{
									$z++;
									?>

										<tr>
										<td colspan="2"  style="font-size:16px; font-weight:bold;width:70px"><i><?php echo $mgnt_val['role_name']; ?>: <?php echo $mgnt_val['mgnt_name']; ?></i></td>
										<td colspan="4">
											<input type="hidden" id="action" name="action" class="form-control" value="<?php echo $mgnt_val['id']; ?>">
											<i><textarea class="form-control" style="font-weight:bold" name="note" disabled><?php echo strip_tags($mgnt_val['comment']); ?></textarea></i>
										</td>
									</tr>
								<?php }
							}
							if($z!=0){
							?>
									<tr>
										<td colspan="2"  style="font-size:16px; font-weight:bold;width:70px">Manager Review</td>
										<td colspan="4">
											<input type="hidden" id="action" name="action" class="form-control" value="">
											<textarea class="form-control" style="font-weight:bold;overflow:auto;resize:none" rows="5" cols="20" minlength="10" id="note" name="note" required></textarea>
										</td>
									</tr>
							<?php } ?>

									<tr>
										<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
									</tr>

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
<script>
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	//CKEDITOR.replace( 'note' );
	
	$(document).ready(function(){
	///////////////// Flip Panel ///////////////////////
		$(".nps_flip").click(function(){
			$(".nps_panel").slideToggle("slow");
		});
		$(".aht_flip").click(function(){
			$(".aht_panel").slideToggle("slow");
		});
		$(".revenue_flip").click(function(){
			$(".revenue_panel").slideToggle("slow");
		});
		$(".compl_flip").click(function(){
			$(".compl_panel").slideToggle("slow");
		});
		$(".noncust_flip").click(function(){
			$(".noncust_panel").slideToggle("slow");
		});
		$(".keyper_flip").click(function(){
			$(".keyper_panel").slideToggle("slow");
		});
		
	});
	
</script>
