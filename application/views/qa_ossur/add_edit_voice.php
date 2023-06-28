<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
	.container{
		margin-top: 20px;
		font-family: 'Roboto', sans-serif;
	}
	.card {
	  position: relative;
	  display: flex;
	  flex-direction: column;
	  min-width: 0;
	  word-wrap: break-word;
	  background-color: #fff;
	  background-clip: border-box;
	  border: 1px solid rgba(0, 0, 0, 0.125);
	  border-radius: 0.25rem;
	  box-shadow: 0 2px 6px 0 rgba(32,33,37,.1);
	}
	.card-header {
	  padding: 0.5rem 1rem;
	  margin-bottom: 0;
	  background-color: rgba(0, 0, 0, 0.03);
	  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
	  padding: 15px;
		background-color: #3b5998;
		color: #fff;
	}
	.header{
		font-family: 'Roboto', sans-serif;
		font-weight: 900;
		font-size: 16px;
		text-transform: capitalize;
		letter-spacing: 1px;
	}
	.card-body {
	  flex: 1 1 auto;
	  padding: 1rem 1rem;
	}
	.form-control{
		height: 40px!important;
		border-radius: 0px!important;
		transition: all 0.3s ease;
	}
	.form-control:focus {
		border-color: #3b5998;
		box-shadow: none!important;
	}
		
		
	
	.common-space{
	  margin-bottom: 10px;
	}
	textarea
	{
		width: 100%;
		max-width: 100%;
	}
	.table tbody th.scope {
	  background: #e8ebf8;
	  border-bottom: 1px solid #e0e5f6;
	}

	/*background: #eef2f5;*/
	.btn-save
	{
		width: 150px;
		border-radius: 1px;
		background: #3b5998;
		color: #fff;
		transition: all 0.3s ease;

	}
	.btn.focus, .btn:focus, .btn:hover {
	  color: #fff;
	  text-decoration: none;
	  background: #2a5cc4;
	  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .25), 0 3px 10px 5px rgba(0, 0, 0, 0.05) !important;

	}
	.table > thead > tr > th {
	  vertical-align: bottom;
	  border-bottom: 1px solid #ddd;
	  background: #3b5998;
	  color: #fff;
	  padding: 15px;
	}
	.table tbody th.scope {
	  background: #3b5998;
	  border-bottom: 1px solid #e0e5f6;
	  color: #fff;
	  text-align: center;
	  padding: 15px;
	}
	.table th,td{
		text-align: center;
		padding-top: 15px;
	}
	.margin-Right
	{
		margin-right: -20px;
	}
	.paddingTop
	{
		padding-top: 15px!important;
	}
	.fa-shield
	{
		margin-right: 5px;
		font-size: 18px;
	}
</style>

<?php if($adt_id!=0){
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
	<form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
		<!----------------- Audit Header Details ------------------->
		<div class="common-space">
			<div class="row">
				<div class="col-sm-12">
					<div class="card mb-4">
					  <div class="card-header"><span class="header"><i class="fa fa-shield fa-rotate-270" aria-hidden="true"></i>OSSUR Voice Quality Audit Sheet</span></div>
						<div class="card-body">
							<?php
								if($adt_id==0){
									$auditorName = get_username();
									$auditDate = date("m-d-Y",time());
									$clDate_val='';
								}else{
									if($auditData['entry_by']!=''){
										$auditorName = $auditData['auditor_name'];
									}else{
										$auditorName = $auditData['client_name'];
									}
									$auditDate = mysql2mmddyy($auditData['audit_date']);
									$clDate_val = mysql2mmddyy($auditData['call_date']);
								}
								if ($rand_id != 0) {
									$agent_id = $rand_data['sid'];
									$fusion_id = $rand_data['fusion_id'];
									$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
									$tl_id = $rand_data['assigned_to'];
									$tl_name = $rand_data['tl_name'];
									$call_duration = $rand_data['call_duration'];
									
								} else {
									$agent_id = $auditData['agent_id'];
									$fusion_id = $auditData['fusion_id'];
									$agent_name = $auditData['fname'] . " " . $auditData['lname'] ;
									$tl_id = $auditData['tl_id'];
									$tl_name = $auditData['tl_name'];
									$call_duration = $auditData['call_duration'];
								}
							?>
							<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Auditor:</label>
										<input type="text" class="form-control" value="<?php echo $auditorName ?>" readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Agent:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" id="agent_id" name="data[agent_id]" required>
											<option value="">-Select-</option>
											<?php foreach($agentName as $row){
												$sCss='';
												if($row['id']==$agent_id) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Employee MWP ID:</label>
										<input type="text" id="fusion_id" class="form-control" value="<?php echo $fusion_id; ?>" readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">L1/TL Name:</label>
										<input type="hidden" id="tl_id" name="data[tl_id]" class="form-control" value="<?php echo $tl_id; ?>">
										<input type="text" id="tl_name" class="form-control" value="<?php echo $tl_name; ?>" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								 <div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Audit Date(mm-dd-yyyy):</label>
										<input type="text" class="form-control" value="<?php echo $auditDate; ?>" readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Ticket/File/Call ID:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										 <input type="text" autocomplete="off" name="data[ticket_id]" class="form-control" value="<?php echo $auditData['ticket_id']; ?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Call Date(mm-dd-yyyy):&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" id="call_date" name="call_date" onkeydown="return false;" class="form-control" value="<?php echo $clDate_val; ?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Call Duration(h:m:s):&nbsp;<span style="font-size:15px;color:red">*</span></label>
										 <input type="text" autocomplete="off" onkeydown="return false;" id="call_duration" name="data[call_duration]" class="form-control" value="<?php echo $call_duration; ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								 <div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Phone Number:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" name="data[phone]" class="form-control" onkeyup="phone_noFunction(phone_no)" id="phone_no" onblur="phone_no_keyup(phone_no)" value="<?php echo $auditData['phone']; ?>" required>
										<span id="msg-phone_no"></span>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Site/Location:</label>
										 <input type="text" autocomplete="off" id="office_id" class="form-control" value="<?php echo $auditData['office_id']; ?>" readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">ACPT:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[acpt]" required>
											<option value="">Select</option>
											<option <?php echo $auditData['acpt']=="Agent"?"selected":"";?> value="Agent">Agent</option>
											<option <?php echo $auditData['acpt']=="Customer"?"selected":"";?> value="Customer">Customer</option>
											<option <?php echo $auditData['acpt']=="Process"?"selected":"";?> value="Process">Process</option>
											<option <?php echo $auditData['acpt']=="Technology"?"selected":"";?> value="Technology">Technology</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Reason of the Call:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" name="data[call_reason]" class="form-control" value="<?php echo $auditData['call_reason']; ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Type of Violation:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" name="data[violation_type]" class="form-control" value="<?php echo $auditData['violation_type']; ?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Audit Type:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" id="audit_type" name="data[audit_type]" required>
											<option value="">Select</option>
											<option <?php echo $auditData['audit_type']=="CQ Audit"?"selected":"";?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $auditData['audit_type']=="BQ Audit"?"selected":"";?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $auditData['audit_type']=="Calibration"?"selected":"";?> value="Calibration">Calibration</option>
											<option <?php echo $auditData['audit_type']=="Pre-Certificate Mock Call"?"selected":"";?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $auditData['audit_type']=="Certification Audit"?"selected":"";?> value="Certification Audit">Certification Audit</option>
											<option <?php echo $auditData['audit_type']=="Operation Audit"?"selected":"";?> value="Operation Audit">Operation Audit</option>
											<option <?php echo $auditData['audit_type']=="Trainer Audit"?"selected":"";?> value="Trainer Audit">Trainer Audit</option>
											<option <?php echo $auditData['audit_type']=="Hygiene Audit"?"selected":"";?> value="Hygiene Audit">Hygiene Audit</option>
											<option <?php echo $auditData['audit_type']=="WOW Call"?"selected":"";?> value="WOW Call">WOW Call</option>
											<option <?php echo $auditData['audit_type']=="QA Supervisor Audit"?"selected":"";?> value="QA Supervisor Audit">QA Supervisor Audit</option>
										</select>
									</div>
								</div>
								<?php $auType='';
								if($adt_id!=0){
									if($auditData['audit_type']=="Calibration"){
										$auType='';
									}else{
										$auType='auType';
									} 
								}else{
									$auType='auType';
								} ?>
								<div class="col-sm-3 <?php echo $auType ?>">
									<div class="form-group search-select">
										<label for="full_form">Auditor Type:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" id="auditor_type" name="data[auditor_type]">
											<option value="">Select</option>
											<option <?php echo $auditData['auditor_type']=="Master"?"selected":"";?> value="Master">Master</option>
											<option <?php echo $auditData['auditor_type']=="Regular"?"selected":"";?> value="Regular">Regular</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Predictive CSAT/VOC:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[voc]" required>
											<option value="">Select</option>
											<option <?php echo $auditData['voc']=="1"?"selected":"";?> value="1">1</option>
											<option <?php echo $auditData['voc']=="2"?"selected":"";?> value="2">2</option>
											<option <?php echo $auditData['voc']=="3"?"selected":"";?> value="3">3</option>
											<option <?php echo $auditData['voc']=="4"?"selected":"";?> value="4">4</option>
											<option <?php echo $auditData['voc']=="5"?"selected":"";?> value="5">5</option>
											<option <?php echo $auditData['voc']=="6"?"selected":"";?> value="6">6</option>
											<option <?php echo $auditData['voc']=="7"?"selected":"";?> value="7">7</option>
											<option <?php echo $auditData['voc']=="8"?"selected":"";?> value="8">8</option>
											<option <?php echo $auditData['voc']=="9"?"selected":"";?> value="9">9</option>
											<option <?php echo $auditData['voc']=="10"?"selected":"";?> value="10">10</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Call Type:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[call_type]" required>
											<option value="">Select</option>
											<option <?php echo $auditData['call_type']=="Inbound"?"selected":"";?> value="Inbound">Inbound</option>
											<option <?php echo $auditData['call_type']=="Outbound"?"selected":"";?> value="Outbound">Outbound</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!----------------- Audit Score Details ------------------->
		<div class="common-space">
			<div class="row">
				<div class="col-sm-4">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
									<div class="form-group ">
	                                    <label for="full_form">Possible Score:</label>
	                                    <input type="text" id="possible_score" name="data[possible_score]" class="form-control" value="<?php echo $auditData['possible_score']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Earned Score:</label>
	                                    <input type="text" id="earned_score" name="data[earned_score]" class="form-control" value="<?php echo $auditData['earned_score']; ?>" readonly>
	                                </div>
	                            </div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card mb-3">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Overall Score:</label>
	                                    <input type="text" id="overall_score" name="data[overall_score]" class="form-control" value="<?php echo $auditData['overall_score']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="common-space">
			<div class="row">
				<div class="col-sm-12">
					<div class="card mb-4">
						<div class="card-body">
							<table class="table table-striped ">
								<thead>
									<th style="width:900px">Parameter & Sub Parameter</th>
									<th>Score</th>
									<th>Rating</th>
									<th>Comments</th>
									<th>Critical Category</th>
								</thead>
								<tbody>
									<tr><th colspan=5 scope="row" class="scope">Greeting</th></tr>
									<tr>
										<td class="paddingTop">Did rep appropriately greet the caller?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc business" name="data[greet_caller_appropiately]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['greet_caller_appropiately']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['greet_caller_appropiately']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['greet_caller_appropiately']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt1]"><?php echo $auditData['cmt1'] ?></textarea></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the rep understand and demonstrate willingness to assist?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc business" name="data[demonstrate_willingness]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['demonstrate_willingness']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['demonstrate_willingness']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['demonstrate_willingness']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt2]"><?php echo $auditData['cmt2'] ?></textarea></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the agent offer Empathy/Apology?  (if applicable)</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc business" name="data[empathy_apology]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['empathy_apology']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['empathy_apology']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['empathy_apology']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt3]"><?php echo $auditData['cmt3'] ?></textarea></td>
										<td>Business Critical</td>
									</tr>
									<tr><th colspan=5 scope="row" class="scope">Policies & Procedures</th></tr>
									<tr>
										<td class="paddingTop">Did the rep pull the correct account?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc compliance" name="data[pull_correct_account]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['pull_correct_account']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['pull_correct_account']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['pull_correct_account']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt4]"><?php echo $auditData['cmt4'] ?></textarea></td>
										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the rep ask for caller's name, PO number and enter the correct information?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc compliance" name="data[ask_caller_name]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['ask_caller_name']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['ask_caller_name']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['ask_caller_name']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt5]"><?php echo $auditData['cmt5'] ?></textarea></td>
										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Was the shipping address correct?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc compliance" name="data[shipping_address]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['shipping_address']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['shipping_address']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['shipping_address']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt6]"><?php echo $auditData['cmt6'] ?></textarea></td>
										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the agent select the correct product names and quantities?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[select_correct_product]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['select_correct_product']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['select_correct_product']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['select_correct_product']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt7]"><?php echo $auditData['cmt7'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">If caller called to cancel an order, did the agent cancel the correct sales order number?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[caller_cancel_order]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['caller_cancel_order']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['caller_cancel_order']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['caller_cancel_order']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt8]"><?php echo $auditData['cmt8'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Was the agent able to correctly process return authorization or return label?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[correctly_process_return]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['correctly_process_return']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['correctly_process_return']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['correctly_process_return']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt9]"><?php echo $auditData['cmt9'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Was the agent able to provide the correct general information or tracking information? (if required)</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[provide_correct_info]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['provide_correct_info']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['provide_correct_info']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['provide_correct_info']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt10]"><?php echo $auditData['cmt10'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the rep apply free shipping? (if applicable)</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[apply_free_shipping]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['apply_free_shipping']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['apply_free_shipping']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['apply_free_shipping']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt11]"><?php echo $auditData['cmt11'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr><th colspan=5 scope="row" class="scope">Transfer & Hold procedures</th></tr>
									<tr>
										<td class="paddingTop">Did the rep call the correct dept. and transfer appropriately? (If applicable)</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[call_correct_dept]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['call_correct_dept']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['call_correct_dept']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['call_correct_dept']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt12]"><?php echo $auditData['cmt12'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the rep refresh caller every 20 seconds to avoid long periods of silence through out the call?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc business" name="data[refresh_caller_20sec]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['refresh_caller_20sec']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['refresh_caller_20sec']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['refresh_caller_20sec']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt13]"><?php echo $auditData['cmt13'] ?></textarea></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the rep abuse hold/put customer on hold for more than 4 minutes?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc business" name="data[put_customer_hold]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['put_customer_hold']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['put_customer_hold']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['put_customer_hold']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt14]"><?php echo $auditData['cmt14'] ?></textarea></td>
										<td>Business Critical</td>
									</tr>
									<tr><th colspan=5 scope="row" class="scope">Soft Skills</th></tr>
									<tr>
										<td class="paddingTop">Did the agent speak clearly, concisely and at an appropriate pace and avoid interruption?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[agent_speak_clearly]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['agent_speak_clearly']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['agent_speak_clearly']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['agent_speak_clearly']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt15]"><?php echo $auditData['cmt15'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the agent use thank you, you're welcome, I'm sorry, etc. throughout the call?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[agent_use_thankyou]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['agent_use_thankyou']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['agent_use_thankyou']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['agent_use_thankyou']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt16]"><?php echo $auditData['cmt16'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Was the agent courteous and professional during the call?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[professional_during_call]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['professional_during_call']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['professional_during_call']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['professional_during_call']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt17]"><?php echo $auditData['cmt17'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr><th colspan=5 scope="row" class="scope">Closing</th></tr>
									<tr>
										<td class="paddingTop">Was the correct sales order number provided?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[correct_sales_order]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['correct_sales_order']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['correct_sales_order']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['correct_sales_order']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt18]"><?php echo $auditData['cmt18'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the agent provide ETA for the order?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc customer" name="data[provide_order_eta]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['provide_order_eta']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['provide_order_eta']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['provide_order_eta']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt19]"><?php echo $auditData['cmt19'] ?></textarea></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="paddingTop">Did the agent thank the customer for calling?</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc business" name="data[thank_customer_calling]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['thank_customer_calling']=="Correctly"?"selected":"";?> value="Correctly">Correctly</option>
												<option scr_val='3' scr_max='5' <?php echo $auditData['thank_customer_calling']=="Partially"?"selected":"";?> value="Partially">Partially</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['thank_customer_calling']=="Missed"?"selected":"";?> value="Missed">Missed</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt20]"><?php echo $auditData['cmt20'] ?></textarea></td>
										<td>Business Critical</td>
									</tr>
								</tbody>
								<tfoot></tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="common-space">
			<div class="row">
				<div class="col-sm-2">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
									<div class="form-group ">
	                                    <label for="full_form">Customer Possible:</label>
	                                    <input type="text" id="customer_scoreable" name="data[customer_scoreable]" class="form-control" value="<?php echo $auditData['customer_scoreable']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Customer Earned:</label>
	                                    <input type="text" id="customer_score" name="data[customer_score]" class="form-control" value="<?php echo $auditData['customer_score']; ?>" readonly>
	                                </div>
	                            </div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="card mb-3">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Customer Total Score:</label>
	                                    <input type="text" id="customer_total" name="data[customer_percentage]" class="form-control" value="<?php echo $auditData['customer_percentage']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
									<div class="form-group ">
	                                    <label for="full_form">Business Possible:</label>
	                                    <input type="text" id="business_scoreable" name="data[business_scoreable]" class="form-control" value="<?php echo $auditData['business_scoreable']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Business Earned:</label>
	                                    <input type="text" id="business_score" name="data[business_score]" class="form-control" value="<?php echo $auditData['business_score']; ?>" readonly>
	                                </div>
	                            </div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="card mb-3">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Business Total Score:</label>
	                                    <input type="text" id="business_total" name="data[business_percentage]" class="form-control" value="<?php echo $auditData['business_percentage']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
									<div class="form-group ">
	                                    <label for="full_form">Compliance Possible:</label>
	                                    <input type="text" id="compliance_scoreable" name="data[compliance_scoreable]" class="form-control" value="<?php echo $auditData['compliance_scoreable']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Compliance Earned:</label>
	                                    <input type="text" id="compliance_score" name="data[compliance_score]" class="form-control" value="<?php echo $auditData['compliance_score']; ?>" readonly>
	                                </div>
	                            </div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="card mb-3">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Compliance Total Score:</label>
	                                    <input type="text" id="compliance_total" name="data[compliance_percentage]" class="form-control" value="<?php echo $auditData['compliance_percentage']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="common-space">
			<div class="row">
				<div class="col-sm-12">
					<div class="card mb-4">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group ">
										<label for="full_form">Call Summary:</label>
										<textarea class="form-control" autocomplete="off" name="data[call_summary]"><?php echo $auditData['call_summary'] ?></textarea>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group ">
										<label for="full_form">Feedback:</label>
										<textarea class="form-control" autocomplete="off" name="data[feedback]"><?php echo $auditData['feedback'] ?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group ">
										<label for="full_form">Upload Audio File [mp3|mp4|wav|m4a]:</label>
										<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]">
									</div>
								</div>
							</div>
							<?php if($adt_id != 0){ ?>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<?php if ($auditData['attach_file'] != ''){
											$attachfile = explode(",", $auditData['attach_file']);
											foreach ($attachfile as $mp){ ?>
												<audio controls='' style="background-color:#607F93">
													<source src="<?php echo base_url(); ?>qa_files/qa_ossur/voice/<?php echo $mp; ?>" type="audio/ogg">
													<source src="<?php echo base_url(); ?>qa_files/qa_ossur/voice/<?php echo $mp; ?>" type="audio/mpeg">
													<source src="<?php echo base_url(); ?>qa_files/qa_ossur/voice/<?php echo $mp; ?>" type="audio/x-m4a">
												</audio>
											<?php }
											}else{
												echo 'No Files Uploaded';
											} ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php if($adt_id!=0){ ?>
			<div class="common-space">
				<div class="row">
					<div class="col-sm-12">
						<div class="card mb-4">
							<div class="card-body">
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group ">
											<label for="full_form">Agent Feedback Status:</label>
											<textarea class="form-control" readonly><?php echo $auditData['agnt_fd_acpt'] ?></textarea>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group ">
											<label for="full_form">Agent Feedback Review:</label>
											<textarea class="form-control" readonly><?php echo $auditData['agent_rvw_note'] ?></textarea>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group ">
											<label for="full_form">Management Review:</label>
											<textarea class="form-control" readonly><?php echo $auditData['mgnt_rvw_note'] ?></textarea>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group ">
											<label for="full_form">Client Review:</label>
											<textarea class="form-control" readonly><?php echo $auditData['client_rvw_note'] ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-8">
										<div class="form-group ">
											<label for="full_form">Your Review:<span style="font-size:15px;color:red">*</span></label>
											<textarea class="form-control1" id="note" name="note" required></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		
		<div class="common-space">
			<div class="row">
				<div class="col-sm-4">
					<?php if($adt_id == 0) {
						if(is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
						<button class="btn btn-primary waves-effect" type="submit" id="qaformsubmit" name='btnSave' style="width:200px"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;SAVE</button>
					<?php
						}
					}else{
						if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
							if (is_available_qa_feedback($auditData['entry_date'], 72) == true) { ?>
								<button class="btn btn-primary waves-effect" type="submit" id="qaformsubmit" name='btnSave' style="width:200px"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;SAVE</button>
					<?php	}
						}
					}
					?>
				</div>
			</div>
		</div>
		
	</form>
	</section>
</div>

</br>
</br>