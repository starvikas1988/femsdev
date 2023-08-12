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
										<td colspan="6" id="theader" style="font-size:30px">Agent Coaching Form</td>
									</tr>
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Client:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<select class="form-control" style="text-align:center" id="client_id" name="client" required>
												<option value="">-Select-</option>
												<?php foreach ($client as $key => $value){ ?>
												<option value="<?php echo $value['id'] ?>"><?php echo $value['fullname'] ?></option>
											<?php } ?>
											</select>
										</td>
										<td>Process:</td>
										<td>
											<select class="form-control" style="text-align:center" id="process_client" name="process_client" readonly>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" style="text-align:center" id="agent_id" name="agent_id" required>
												<option value="">-Select-</option>
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
											<!--<input type="text" class="form-control" id="tl_name" name="tl_name" readonly>-->
										</td>
										<td>Call Date and Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" required autocomplete="off" onkeydown="return false;"></td>
									</tr>
									<tr>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Site:</td>
										<td><input type="text" readonly class="form-control" id="site" name="site"></td>
										<td>Coaching Department:</td>
										<td><input type="text" readonly class="form-control" id="dept_id"></td>
									</tr>
									<tr>
										<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_id" name="call_id" required></td>
										<td>Coaching Reason:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="coaching_reason" name="coaching_reason[]" multiple required>
												<option value="">--Select--</option>
												<option value="Call Escalation">Call Escalation</option>
												<option value="Call Management">Call Management</option>
												<option value="Corrective Actions">Corrective Actions</option>
												<option value="Daily Specials">Daily Specials</option>
												<option value="Discovery Session">Discovery Session</option>
												<option value="Employee Recognition">Employee Recognition</option>
												<option value="Follow up">Follow up</option>
												<option value="General">General</option>
												<option value="Goals and Progress">Goals and Progress</option>
												<option value="Group Session">Group Session</option>
												<option value="Performance Review">Performance Review</option>
												<option value="Personal Challenges">Personal Challenges</option>
												<option value="Product Knowledge">Product Knowledge</option>
												<option value="Productivity">Productivity</option>
												<option value="Quality Assurance">Quality Assurance</option>
												<option value="Retention">Retention</option>
												<option value="Schedule Adherence">Schedule Adherence</option>
												<option value="Survey Follow up">Survey Follow up</option>
												<option value="QA Audit Review">QA Audit Review</option>
												<option value="TL Audit Review">TL Audit Review</option>
												<option value="Trainer Audit Review">Trainer Audit Review</option>
												<option value="ZTP">ZTP</option>
												<option value="Critical Error">Critical Error</option>
											</select>
										</td>
										<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="call_type" required></td>
									</tr>
									<tr>
										<td>Observation Method:</td>
										<td>
											<select class="form-control" name="observation_method">
												<option value="">--Select--</option>
												<option value="Displayed">Displayed</option>
												<option value="Remote">Remote</option>
												<option value="SBS">SBS</option>
												<option value="Call Recording">Call Recording</option>
											</select>
										</td>
										<td>For Follow Up?:</td>
										<td>
											<select class="form-control" name="for_follow_up">
												<option value="">--Select--</option>
												<option value="Displayed">Displayed</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
										<td>Coaching Documentation:</td>
										<td><textarea class="form-control" name="coaching_docu"></textarea></td>
									</tr>
									<tr class="rca_fields" style="display:none">
										<td colspan="6">Root Cause Analysis</td>
									</tr>
									<tr class="rca_fields" style="display:none">
										<td colspan="2">
											<label for="rca_level1">Level 1</label>
											<select id="rca_level1" name="rca_level1" class="form-control">
												<option value="">-- SELECT --</option>
												<option value="system">System</option>
												<option value="ability">Ability</option>
												<option value="will">Will</option>
												<option value="health">Health</option>
												<option value="cap_issue">Capacity Issue</option>
												<option value="environment">Environment</option>
											</select>
										</td>
										<td colspan="2">
											<label for="rca_level2">Level 2</label>
											<select id="rca_level2" name="rca_level2" class="form-control">
											</select>
										</td>
										<td colspan="2">
											<label for="rca_level3">Level 3</label>
											<select id="rca_level3" name="rca_level3" class="form-control">
											</select>
										</td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="nps_flip">NPS &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="nps_panel">
										<td colspan=2>Gathered homeowner name, gave our name and greeted the homeowner</td>
										<td>
											<select class="form-control" name="nps1">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt1"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Used homeowner name multiple times throughout the interaction</td>
										<td>
											<select class="form-control" name="nps2">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt2"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Effectively probed to understand the true concern of the homeowner</td>
										<td>
											<select class="form-control" name="nps3">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt3"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Assured homeowner we would assist them with their call</td>
										<td>
											<select class="form-control" name="nps4">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt4"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Owned issue within scope and through resolution</td>
										<td>
											<select class="form-control" name="nps5">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt5"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Utilized all available tools and resources to resolve the homeowners concern</td>
										<td>
											<select class="form-control" name="nps6">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt6"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Provided genuine empathy statements throughout the interaction</td>
										<td>
											<select class="form-control" name="nps7">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt7"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Expressed willingness to assist</td>
										<td>
											<select class="form-control" name="nps8">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt8"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Addressed any homeowner concern brought up in the call</td>
										<td>
											<select class="form-control" name="nps9">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt9"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Explained clearly and effectively</td>
										<td>
											<select class="form-control" name="nps10">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt10"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Introduced a valuable solution to the homeowner</td>
										<td>
											<select class="form-control" name="nps11">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt11"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Provided needed assurance statements</td>
										<td>
											<select class="form-control" name="nps12">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt12"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Remained professional with a positive and upbeat tone</td>
										<td>
											<select class="form-control" name="nps13">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt13"></td>
									</tr>
									<tr class="nps_panel">
										<td colspan=2>Made it EASY for the homeowner</td>
										<td>
											<select class="form-control" name="nps14">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="nps_cmt14"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="aht_flip">AHT &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="aht_panel">
										<td colspan=2>Effectively probed to understand true issue of the call</td>
										<td>
											<select class="form-control" name="aht1">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt1"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Gained agreement on the issue</td>
										<td>
											<select class="form-control" name="aht2">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt2"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Utilized all available tools and resources to resolve the homeowners concern</td>
										<td>
											<select class="form-control" name="aht3">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt3"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Properly positioned time consuming tasks and hold times</td>
										<td>
											<select class="form-control" name="aht4">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt4"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Controlled the call throughout the interaction</td>
										<td>
											<select class="form-control" name="aht5">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt5"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Actively listened to the homeowner</td>
										<td>
											<select class="form-control" name="aht6">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt6"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Efficiently explained the the details/ process to the customer</td>
										<td>
											<select class="form-control" name="aht7">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt7"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Adhered to ACW and Hold guidelines</td>
										<td>
											<select class="form-control" name="aht8">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt8"></td>
									</tr>
									<tr class="aht_panel">
										<td colspan=2>Properly followed the transfer procedure</td>
										<td>
											<select class="form-control" name="aht9">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="aht_cmt9"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="revenue_flip">REVENUE &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="revenue_panel">
										<td colspan=2>Effectively Positioned Offer (LFBB)</td>
										<td>
											<select class="form-control" name="revenue1">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt1"></td>
									</tr>
									<tr class="revenue_panel">
										<td colspan=2>Assumptively Asked for the Sale</td>
										<td>
											<select class="form-control" name="revenue2">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt2"></td>
									</tr>
									<tr class="revenue_panel">
										<td colspan=2>Identified unstated Needs</td>
										<td>
											<select class="form-control" name="revenue3">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt3"></td>
									</tr>
									<tr class="revenue_panel">
										<td colspan=2>Offered Relevant and Strategic Cross Sell</td>
										<td>
											<select class="form-control" name="revenue4">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt4"></td>
									</tr>
									<tr class="revenue_panel">
										<td colspan=2>Provided Effective and relevant Rebuttals</td>
										<td>
											<select class="form-control" name="revenue5">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="revenue_cmt5"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="compl_flip">COMPLIANCE &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="compl_panel">
										<td colspan=2>Stated that they were on a recorded line</td>
										<td>
											<select class="form-control" name="compliance1">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt1"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Confirmed and entered the correct zip code</td>
										<td>
											<select class="form-control" name="compliance2">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt2"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Submitted the project under correct CTT</td>
										<td>
											<select class="form-control" name="compliance3">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt3"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Detailed description was correct and professionally presented</td>
										<td>
											<select class="form-control" name="compliance4">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt4"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Correctly processed a DNC request (when applicable)</td>
										<td>
											<select class="form-control" name="compliance5">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt5"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Correctly dispositioned the call</td>
										<td>
											<select class="form-control" name="compliance6">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt6"></td>
									</tr>
									<tr class="compl_panel">
										<td colspan=2>Did not share sensitive customer identifiable information</td>
										<td>
											<select class="form-control" name="compliance7">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="compliance_cmt7"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="noncust_flip">Non-Customer Interactive &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="noncust_panel">
										<td colspan=2>Information Security and Cleandesk violations</td>
										<td>
											<select class="form-control" name="non_cust_interact1">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="non_cust_interact_cmt1"></td>
									</tr>
									<tr class="noncust_panel">
										<td colspan=2>Time Keeping Violation</td>
										<td>
											<select class="form-control" name="non_cust_interact2">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="non_cust_interact_cmt2"></td>
									</tr>
									<tr class="noncust_panel">
										<td colspan=2>Utilization - AUX Abuse</td>
										<td>
											<select class="form-control" name="non_cust_interact3">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="non_cust_interact_cmt3"></td>
									</tr>
									<tr class="noncust_panel">
										<td colspan=2>Utilization - Shift Adherence</td>
										<td>
											<select class="form-control" name="non_cust_interact4">
												<option value="">Select</option>
												<option value="Displayed">Displayed</option>
												<option value="Opportunity">Opportunity</option>
												<option value="Not Observed">Not Observed</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="non_cust_interact_cmt4"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr><td colspan="6" style="background-color:#CEF4EC; font-weight:bold" class="keyper_flip">Key Performance Results &nbsp; <i class="fa fa-arrow-up"></i> <i class="fa fa-arrow-down"></i></td></tr>
									<tr class="keyper_panel">
										<td colspan=2>NPS</td>
										<td colspan=4><input type="text" class="form-control" name="nps_result"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>AHT</td>
										<td colspan=4><input type="text" class="form-control" name="aht_result"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>Quality</td>
										<td colspan=4><input type="text" class="form-control" name="quality_result"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>Conversion</td>
										<td colspan=4><input type="text" class="form-control" name="conversion_result"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>Cross-sell</td>
										<td colspan=4><input type="text" class="form-control" name="crosssell_result"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>Adherence</td>
										<td colspan=4><input type="text" class="form-control" name="adherence_result"></td>
									</tr>
									<tr class="keyper_panel">
										<td colspan=2>BEHAVIORAL IMPROVEMENT LEVEL (if flagged for follow-up)</td>
										<td colspan=2>
											<select class="form-control" name="behavioral_improvement">
												<option value="">Select</option>
												<option value="Good Improvement">Good Improvement</option>
												<option value="Some Improvement">Some Improvement</option>
												<option value="No Improvement">No Improvement</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="behavioral_improvement_cmt"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									<tr>
										<td colspan="2">Upload Audio Files [m4a,mp4,mp3,wav]:</td>
										<td colspan="4"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>

									</tr>
									<tr>
										<td colspan="2">Comments:</td>
										<td colspan="4"><textarea class="form-control" id="coaching_comment" name="coaching_comment" required></textarea></td>
									</tr>



									<tr>
										<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px;">SAVE</button></td>

									</tr>

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

<?php include ("qa_coaching_js.php"); ?>

<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'coaching_comment' );
</script>
