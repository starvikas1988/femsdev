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
		
	.form-control1{
		height: 40px!important;
		border-radius: 0px!important;
		transition: all 0.3s ease;
	}
	.form-control1:focus {
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
	
<div class="wrap">
	<section class="app-content">
		<!----------------- Audit Header Details ------------------->
		<div class="common-space">
			<div class="row">
				<div class="col-sm-12">
					<div class="card mb-4">
					  <div class="card-header"><span class="header"><i class="fa fa-shield fa-rotate-270" aria-hidden="true"></i>AppHelp Quality Audit Sheet</span></div>
						<div class="card-body">
							<?php
								if($auditData['entry_by']!=''){
									$auditorName = $auditData['auditor_name'];
								}else{
									$auditorName = $auditData['client_name'];
								}
								$auditDate = mysql2mmddyy($auditData['audit_date']);
								$clDate_val = mysql2mmddyy($auditData['call_date']);
							?>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Auditor:</label>
										<input type="text" class="form-control" value="<?php echo $auditorName ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Agent:</label>
										<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
											<option><?php echo $auditData['fname']." ".$auditData['lname']; ?></option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Employee MWP ID:</label>
										<input type="text" id="fusion_id" class="form-control" value="<?php echo $auditData['fusion_id']; ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">L1/TL Name:</label>
										<input type="hidden" id="tl_id" name="data[tl_id]" class="form-control" value="<?php echo $auditData['tl_id']; ?>">
										<input type="text" id="tl_name" class="form-control" value="<?php echo $auditData['tl_name']; ?>" disabled>
									</div>
								</div>
							</div>
							<div class="row">
								 <div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Audit Date(mm-dd-yyyy):</label>
										<input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Ticket Number:</label>
										 <input type="text" autocomplete="off" name="data[ticket_id]" class="form-control" value="<?php echo $auditData['ticket_id']; ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Call/Contact Date(mm-dd-yyyy):&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" id="call_date" name="call_date" onkeydown="return false;" class="form-control" value="<?php echo $clDate_val; ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Partner Name:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[partner_name]" disabled>
											<option value="">Select</option>
											<option <?php echo $auditData['partner_name']=='VirginMedia'?'selected':''; ?> value='VirginMedia'>VirginMedia</option>
											<option <?php echo $auditData['partner_name']=='Windstream'?'selected':''; ?> value='Windstream'>Windstream</option>
											<option <?php echo $auditData['partner_name']=='Eastlink'?'selected':''; ?> value='Eastlink'>Eastlink</option>
											<option <?php echo $auditData['partner_name']=='TELUS'?'selected':''; ?> value='TELUS'>TELUS</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								 <div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">External ID/Salesforce Acc #:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" name="data[salesforce_account]" class="form-control" onkeydown="return false;" value="<?php echo $auditData['salesforce_account']; ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Account Holder's Name:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										 <input type="text" autocomplete="off" name="data[account_holder_name]" class="form-control" value="<?php echo $auditData['account_holder_name']; ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">KPI - ACPT:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[acpt]" disabled>
											<option value="">Select</option>
											<option <?php echo $auditData['acpt']=="Agent"?"selected":"";?> value="Agent">Agent</option>
											<option <?php echo $auditData['acpt']=="Customer"?"selected":"";?> value="Customer">Customer</option>
											<option <?php echo $auditData['acpt']=="Process"?"selected":"";?> value="Process">Process</option>
											<option <?php echo $auditData['acpt']=="Technology"?"selected":"";?> value="Technology">Technology</option>
											<option <?php echo $auditData['acpt']=="N/A"?"selected":"";?> value="N/A">N/A</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Caller's Name:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" name="data[caller_name]" class="form-control" value="<?php echo $auditData['caller_name']; ?>" disabled>
									</div>
								</div>
							</div>
							<div class="row">
								 <div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">BPO Team:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[bpo_team]" disabled>
											<option value="">Select</option>
											<option <?php echo $auditData['bpo_team']=='FSMTL'?'selected':''; ?>  value='FSMTL'>FSMTL</option>
											<option <?php echo $auditData['bpo_team']=='FSQA'?'selected':''; ?>  value='FSQA'>FSQA</option>
											<option <?php echo $auditData['bpo_team']=='DIT'?'selected':''; ?>  value='DIT'>DIT</option>
											<option <?php echo $auditData['bpo_team']=='IO'?'selected':''; ?>  value='IO'>IO</option>
											<option <?php echo $auditData['bpo_team']=='AH'?'selected':''; ?>  value='AH'>AH</option>
											<option <?php echo $auditData['bpo_team']=='AHQA'?'selected':''; ?>  value='AHQA'>AHQA</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">LMI Session ID:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										 <input type="text" autocomplete="off" name="data[session_id]" class="form-control" value="<?php echo $auditData['session_id']; ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Five9 Disposition:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[five9_disposition]" disabled>
											<option value="">Select</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 LOYALTY NOT SAVED - Does not want to renew'?'selected':''; ?>  value='EL 01 LOYALTY NOT SAVED - Does not want to renew'>EL 01 LOYALTY NOT SAVED - Does not want to renew</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 LOYALTY NOT SAVED - Going with Competition'?'selected':''; ?>  value='EL 01 LOYALTY NOT SAVED - Going with Competition'>EL 01 LOYALTY NOT SAVED - Going with Competition</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 LOYALTY NOT SAVED - Issue not resolved'?'selected':''; ?>  value='EL 01 LOYALTY NOT SAVED - Issue not resolved'>EL 01 LOYALTY NOT SAVED - Issue not resolved</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 LOYALTY NOT SAVED - Not Satisfied with Service'?'selected':''; ?>  value='EL 01 LOYALTY NOT SAVED - Not Satisfied with Service'>EL 01 LOYALTY NOT SAVED - Not Satisfied with Service</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 LOYALTY NOT SAVED - Too Expensive'?'selected':''; ?>  value='EL 01 LOYALTY NOT SAVED - Too Expensive'>EL 01 LOYALTY NOT SAVED - Too Expensive</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 LOYALTY SAVED - Retained Customer'?'selected':''; ?>  value='EL 01 LOYALTY SAVED - Retained Customer'>EL 01 LOYALTY SAVED - Retained Customer</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 NO SALE MADE - Account not eligible for service'?'selected':''; ?>  value='EL 01 NO SALE MADE - Account not eligible for service'>EL 01 NO SALE MADE - Account not eligible for service</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 NO SALE MADE - Going with competition'?'selected':''; ?>  value='EL 01 NO SALE MADE - Going with competition'>EL 01 NO SALE MADE - Going with competition</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 NO SALE MADE - Inquiry about Service Offering'?'selected':''; ?>  value='EL 01 NO SALE MADE - Inquiry about Service Offering'>EL 01 NO SALE MADE - Inquiry about Service Offering</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 NO SALE MADE - Out of Scope or Unsupported equipment'?'selected':''; ?>  value='EL 01 NO SALE MADE - Out of Scope or Unsupported equipment'>EL 01 NO SALE MADE - Out of Scope or Unsupported equipment</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 NO SALE MADE - Refused to pay - Should be included in Service'?'selected':''; ?>  value='EL 01 NO SALE MADE - Refused to pay - Should be included in Service'>EL 01 NO SALE MADE - Refused to pay - Should be included in Service</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 NO SALE MADE - Too expensive'?'selected':''; ?>  value='EL 01 NO SALE MADE - Too expensive'>EL 01 NO SALE MADE - Too expensive</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 SALE MADE - Added Service - Connected to chat'?'selected':''; ?>  value='EL 01 SALE MADE - Added Service - Connected to chat'>EL 01 SALE MADE - Added Service - Connected to chat</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 SALE MADE - Added Service - Resolved Over Phone'?'selected':''; ?>  value='EL 01 SALE MADE - Added Service - Resolved Over Phone'>EL 01 SALE MADE - Added Service - Resolved Over Phone</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 SALE MADE - Added Service - Will call or chat back to continue'?'selected':''; ?>  value='EL 01 SALE MADE - Added Service - Will call or chat back to continue'>EL 01 SALE MADE - Added Service - Will call or chat back to continue</option>
											<option <?php echo $auditData['five9_disposition']=='EL 01 SALE MADE - Added Service -Transfer over phone'?'selected':''; ?>  value='EL 01 SALE MADE - Added Service -Transfer over phone'>EL 01 SALE MADE - Added Service -Transfer over phone</option>
											<option <?php echo $auditData['five9_disposition']=='EL 02 MISDIRECTED - Eastlink Partner Specific Outage'?'selected':''; ?>  value='EL 02 MISDIRECTED - Eastlink Partner Specific Outage'>EL 02 MISDIRECTED - Eastlink Partner Specific Outage</option>
											<option <?php echo $auditData['five9_disposition']=='EL 02 MISDIRECTED - Password Reset or Management'?'selected':''; ?>  value='EL 02 MISDIRECTED - Password Reset or Management'>EL 02 MISDIRECTED - Password Reset or Management</option>
											<option <?php echo $auditData['five9_disposition']=='EL 02 MISDIRECTED - Redirect to Billing'?'selected':''; ?>  value='EL 02 MISDIRECTED - Redirect to Billing'>EL 02 MISDIRECTED - Redirect to Billing</option>
											<option <?php echo $auditData['five9_disposition']=='EL 02 MISDIRECTED - Redirect to Broadband'?'selected':''; ?>  value='EL 02 MISDIRECTED - Redirect to Broadband'>EL 02 MISDIRECTED - Redirect to Broadband</option>
											<option <?php echo $auditData['five9_disposition']=='EL 02 MISDIRECTED - Redirect to PC Shop'?'selected':''; ?>  value='EL 02 MISDIRECTED - Redirect to PC Shop'>EL 02 MISDIRECTED - Redirect to PC Shop</option>
											<option <?php echo $auditData['five9_disposition']=='EL 03 MISC - Out of Scope'?'selected':''; ?>  value='EL 03 MISC - Out of Scope'>EL 03 MISC - Out of Scope</option>
											<option <?php echo $auditData['five9_disposition']=='EL 03 MISC - 3rd party outage'?'selected':''; ?>  value='EL 03 MISC - 3rd party outage'>EL 03 MISC - 3rd party outage</option>
											<option <?php echo $auditData['five9_disposition']=='EL 03 MISC - Call Disconnected or No One There'?'selected':''; ?>  value='EL 03 MISC - Call Disconnected or No One There'>EL 03 MISC - Call Disconnected or No One There</option>
											<option <?php echo $auditData['five9_disposition']=='EL 03 MISC - Consult or agent  inquiry about service'?'selected':''; ?>  value='EL 03 MISC - Consult or agent  inquiry about service'>EL 03 MISC - Consult or agent  inquiry about service</option>
											<option <?php echo $auditData['five9_disposition']=='EL 03 MISC - Internal Outage'?'selected':''; ?>  value='EL 03 MISC - Internal Outage'>EL 03 MISC - Internal Outage</option>
											<option <?php echo $auditData['five9_disposition']=='EL 03 MISC - Not Authorized User on Account'?'selected':''; ?>  value='EL 03 MISC - Not Authorized User on Account'>EL 03 MISC - Not Authorized User on Account</option>
											<option <?php echo $auditData['five9_disposition']=='EL 03 MISC - Request to Escalate to Supervisor'?'selected':''; ?>  value='EL 03 MISC - Request to Escalate to Supervisor'>EL 03 MISC - Request to Escalate to Supervisor</option>
											<option <?php echo $auditData['five9_disposition']=='EL 03 MISC - Test Call'?'selected':''; ?>  value='EL 03 MISC - Test Call'>EL 03 MISC - Test Call</option>
											<option <?php echo $auditData['five9_disposition']=='EL 04 SERVICE DELIVERY - Follow-up'?'selected':''; ?>  value='EL 04 SERVICE DELIVERY - Follow-up'>EL 04 SERVICE DELIVERY - Follow-up</option>
											<option <?php echo $auditData['five9_disposition']=='EL 04 SERVICE DELIVERY - New Issue - Connected to Chat'?'selected':''; ?>  value='EL 04 SERVICE DELIVERY - New Issue - Connected to Chat'>EL 04 SERVICE DELIVERY - New Issue - Connected to Chat</option>
											<option <?php echo $auditData['five9_disposition']=='EL 04 SERVICE DELIVERY - New Issue - Resolve Over Phone'?'selected':''; ?>  value='EL 04 SERVICE DELIVERY - New Issue - Resolve Over Phone'>EL 04 SERVICE DELIVERY - New Issue - Resolve Over Phone</option>
											<option <?php echo $auditData['five9_disposition']=='EL 04 SERVICE DELIVERY - Pending Callback'?'selected':''; ?>  value='EL 04 SERVICE DELIVERY - Pending Callback'>EL 04 SERVICE DELIVERY - Pending Callback</option>
											<option <?php echo $auditData['five9_disposition']=='EL 04 SERVICE DELIVERY - Unresolved Issue - Returning after 7 days'?'selected':''; ?>  value='EL 04 SERVICE DELIVERY - Unresolved Issue - Returning after 7 days'>EL 04 SERVICE DELIVERY - Unresolved Issue - Returning after 7 days</option>
											<option <?php echo $auditData['five9_disposition']=='EL 04 SERVICE DELIVERY - Unresolved Issue - Under Warranty'?'selected':''; ?>  value='EL 04 SERVICE DELIVERY - Unresolved Issue - Under Warranty'>EL 04 SERVICE DELIVERY - Unresolved Issue - Under Warranty</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Five9 Campaign:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[five9_campaign]" disabled>
											<option value="">Select</option>
											<option <?php echo $auditData['five9_campaign']=='888-525-4253 Eastlink Main'?'selected':''; ?>  value='888-525-4253 Eastlink Main'>888-525-4253 Eastlink Main</option>
											<option <?php echo $auditData['five9_campaign']=='902-701-8329 Eastlink Tier 2 Referral'?'selected':''; ?>  value='902-701-8329 Eastlink Tier 2 Referral'>902-701-8329 Eastlink Tier 2 Referral</option>
											<option <?php echo $auditData['five9_campaign']=='902-701-8334 Eastlink Wireless Referral'?'selected':''; ?>  value='902-701-8334 Eastlink Wireless Referral'>902-701-8334 Eastlink Wireless Referral</option>
											<option <?php echo $auditData['five9_campaign']=='902-701-8335 Eastlink Customer Service Referral'?'selected':''; ?>  value='902-701-8335 Eastlink Customer Service Referral'>902-701-8335 Eastlink Customer Service Referral</option>
											<option <?php echo $auditData['five9_campaign']=='902-702-1260 Eastlink Business Referral'?'selected':''; ?>  value='902-702-1260 Eastlink Business Referral'>902-702-1260 Eastlink Business Referral</option>
											<option <?php echo $auditData['five9_campaign']=='902-702-1264 Eastlink Advantage Referral'?'selected':''; ?>  value='902-702-1264 Eastlink Advantage Referral'>902-702-1264 Eastlink Advantage Referral</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">								
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">TW Ticket Status:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[tw_ticket_status]" disabled>
											<option value="">Select</option>
											<option <?php echo $auditData['tw_ticket_status']=='Open'?'selected':''; ?>  value='Open'>Open</option>
											<option <?php echo $auditData['tw_ticket_status']=='Open Pending'?'selected':''; ?>  value='Open Pending'>Open Pending</option>
											<option <?php echo $auditData['tw_ticket_status']=='Open Escalated'?'selected':''; ?>  value='Open Escalated'>Open Escalated</option>
											<option <?php echo $auditData['tw_ticket_status']=='Closed Resolved'?'selected':''; ?>  value='Closed Resolved'>Closed Resolved</option>
											<option <?php echo $auditData['tw_ticket_status']=='Closed No Service'?'selected':''; ?>  value='Closed No Service'>Closed No Service</option>
											<option <?php echo $auditData['tw_ticket_status']=='NA'?'selected':''; ?>  value='NA'>NA</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Call Driver:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[call_driver]" disabled>
											<option value="">Select</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - AV Install/Activation/Usage/Features'?'selected':''; ?>  value='No Ticket - AV Install/Activation/Usage/Features'>No Ticket - AV Install/Activation/Usage/Features</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Browsing/Browser Issue'?'selected':''; ?>  value='No Ticket - Browsing/Browser Issue'>No Ticket - Browsing/Browser Issue</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - CleanpUp/PC Check/Speed'?'selected':''; ?>  value='No Ticket - CleanpUp/PC Check/Speed'>No Ticket - CleanpUp/PC Check/Speed</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Email'?'selected':''; ?>  value='No Ticket - Email'>No Ticket - Email</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Internet Connectivity'?'selected':''; ?>  value='No Ticket - Internet Connectivity'>No Ticket - Internet Connectivity</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Malware'?'selected':''; ?>  value='No Ticket - Malware'>No Ticket - Malware</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Mobile Device'?'selected':''; ?>  value='No Ticket - Mobile Device'>No Ticket - Mobile Device</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - OS Issues'?'selected':''; ?>  value='No Ticket - OS Issues'>No Ticket - OS Issues</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Other Reason'?'selected':''; ?>  value='No Ticket - Other Reason'>No Ticket - Other Reason</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Out Of Scope'?'selected':''; ?>  value='No Ticket - Out Of Scope'>No Ticket - Out Of Scope</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Partner Specific Product Sale Only'?'selected':''; ?>  value='No Ticket - Partner Specific Product Sale Only'>No Ticket - Partner Specific Product Sale Only</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Printer or Peripheral'?'selected':''; ?>  value='No Ticket - Printer or Peripheral'>No Ticket - Printer or Peripheral</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Referred to ISP/Vendor/Local tech'?'selected':''; ?>  value='No Ticket - Referred to ISP/Vendor/Local tech'>No Ticket - Referred to ISP/Vendor/Local tech</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Service Delivered, No Ticket - Agent Error'?'selected':''; ?>  value='No Ticket - Service Delivered, No Ticket - Agent Error'>No Ticket - Service Delivered, No Ticket - Agent Error</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Slow Speeds'?'selected':''; ?>  value='No Ticket - Slow Speeds'>No Ticket - Slow Speeds</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Social Media'?'selected':''; ?>  value='No Ticket - Social Media'>No Ticket - Social Media</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Software Install/Repair issues'?'selected':''; ?>  value='No Ticket - Software Install/Repair issues'>No Ticket - Software Install/Repair issues</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Sub or Product Cancellation'?'selected':''; ?>  value='No Ticket - Sub or Product Cancellation'>No Ticket - Sub or Product Cancellation</option>
											<option <?php echo $auditData['call_driver']=='No Ticket - Wi-Fi Setup/troubleshooting'?'selected':''; ?>  value='No Ticket - Wi-Fi Setup/troubleshooting'>No Ticket - Wi-Fi Setup/troubleshooting</option>
											<option <?php echo $auditData['call_driver']=='NA'?'selected':''; ?>  value='NA'>NA</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Call ID:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" name="data[call_id]" class="form-control" value="<?php echo $auditData['call_id']; ?>" disabled>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Audit Type:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
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
											<option value="QA Supervisor Audit"  <?= ($auditData['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Predictive CSAT:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[voc]" disabled>
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
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!----------------- Audit Score Details ------------------->
		<div class="common-space">
			<div class="row">
				<!--<div class="col-sm-3">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
									<div class="form-group ">
	                                    <label for="full_form">Possible Score:</label>
	                                    <input type="text" id="possible_score" name="data[possible_score]" class="form-control" value="<?php //echo $auditData['possible_score']; ?>" readonly>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>-->
				<!--<div class="col-sm-3">
					<div class="card mb-3 margin-Right">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Earned Score:</label>
	                                    <input type="text" id="earned_score" name="data[earned_score]" class="form-control" value="<?php //echo $auditData['earned_score']; ?>" readonly>
	                                </div>
	                            </div>
							</div>
						</div>
					</div>
				</div>-->
				<div class="col-sm-3">
					<div class="card mb-3">
						<div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                 <div class="form-group ">
	                                    <label for="full_form">Overall Score:</label>
	                                    <input type="text" id="overall_score" name="data[overall_score]" class="form-control apphelpFatal" value="<?php echo $auditData['overall_score']; ?>" readonly>
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
									<th style="width:900px">Parameter</th>
									<th>Weightage</th>
									<th>Status</th>
									<th>Fail Reasons</th>
									<th>Remarks</th>
								</thead>
								<tbody>
									<tr>
										<th colspan=3 scope="row" class="scope">Soft Skill</th>
										<th class="scope">Causes</th>
										<th><input type="text" id="soft_skill_score" name="data[soft_skill_score]" class="form-control" value="<?php echo $auditData['soft_skill_score']; ?>" readonly></th>
									</tr>
									<tr>
										<td class="paddingTop">Warm Professional Greeting and First Impressions</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[warm_greeting]" disabled>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['warm_greeting']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' ss_score=0 <?php echo $auditData['warm_greeting']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['warm_greeting']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[warm_greeting_Fail_reason]" disabled>
											
											<option value="Sounded bored/tired or cold and unfriendly or rush through your greeting too quickly" <?= ($auditData["warm_greeting_Fail_reason"]=="Sounded bored/tired or cold and unfriendly or rush through your greeting too quickly")?"selected":"" ?> > Sounded bored/tired or cold and unfriendly or rush through your greeting too quickly </option>
											<option value="Chats: Greeting is delayed more than 3 minutes" <?= ($auditData["warm_greeting_Fail_reason"]=="Chats: Greeting is delayed more than 3 minutes")?"selected":"" ?> >Chats: Greeting is delayed more than 3 minutes</option>
											<option value="Did not brand, or used the wrong brand name" <?= ($auditData["warm_greeting_Fail_reason"]=="Did not brand, or used the wrong brand name")?"selected":"" ?> >Did not brand, or used the wrong brand name</option>
											<option value="Asked for the callers contact info before knowing who you are speaking to and why they are calling" <?= ($auditData["warm_greeting_Fail_reason"]=="Asked for the callers contact info before knowing who you are speaking to and why they are calling")?"selected":"" ?> >Asked for the caller"s contact info before knowing who you are speaking to and why they are calling</option>
											<option value="Calls: Greeting is delayed more than 7 seconds" <?= ($auditData["warm_greeting_Fail_reason"]=="Calls: Greeting is delayed more than 7 seconds")?"selected":"" ?> >Calls: Greeting is delayed more than 7 seconds</option>
											<option value="Failed to introduce yourself" <?= ($auditData["warm_greeting_Fail_reason"]=="Failed to introduce yourself")?"selected":"" ?> >Failed to introduce yourself</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt1]"><?php echo $auditData['cmt1']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Acknowledgement</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[acknowledge]" disabled>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['acknowledge']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' ss_score=0 <?php echo $auditData['acknowledge']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['acknowledge']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[acknowledge_Fail_reason]" disabled>
											<option value='Did not acknowledge at all' <?= ($auditData['acknowledge_Fail_reason']=='Did not acknowledge at all')?'selected':'' ?> >Did not acknowledge at all </option>
											<option value='Only acknowledged at the beginning of the call and missed additional applicable opportunities throughout the remainder of the call' <?= ($auditData['acknowledge_Fail_reason']=='Only acknowledged at the beginning of the call and missed additional applicable opportunities throughout the remainder of the call')?'selected':'' ?> >Only acknowledged at the beginning of the call and missed additional applicable opportunities throughout the remainder of the call</option>
											<option value='Did not acknowledge customers concern or question in beginning of the call' <?= ($auditData['acknowledge_Fail_reason']=='Did not acknowledge customers concern or question in beginning of the call')?'selected':'' ?> >Did not acknowledge customers concern or question in beginning of the call</option>
											<option value='Did not acknowledge any steps already taken by the customer' <?= ($auditData['acknowledge_Fail_reason']=='Did not acknowledge any steps already taken by the customer')?'selected':'' ?> >Did not acknowledge any steps already taken by the customer</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt2]"><?php echo $auditData['cmt2']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Active Listening and Paraphrasing</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[active_listening]" disabled>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['active_listening']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' ss_score=0 <?php echo $auditData['active_listening']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['active_listening']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[active_listening_Fail_reason]" disabled>
												<option value='Paraphrased incorrectly by not repeating key words and phrases' <?= ($auditData['active_listening_Fail_reason']=='Paraphrased incorrectly by not repeating key words and phrases')?'selected':'' ?>>Paraphrased incorrectly by not repeating key words and phrases</option>
												<option value='Incorrectly assumed that we have understood the question/concern rather than confirming with the customer that we have understood' <?= ($auditData['active_listening_Fail_reason']=='Incorrectly assumed that we have understood the question/concern rather than confirming with the customer that we have understood')?'selected':'' ?>>Incorrectly assumed that we have understood the question/concern rather than confirming with the customer that we have understood</option>
												<option value='Lack of active listening- made customer repeat himself' <?= ($auditData['active_listening_Fail_reason']=='Lack of active listening- made customer repeat himself')?'selected':'' ?>>Lack of active listening- made customer repeat himself</option>
												<option value='Lack of active listening- asked questions to customer while he already advised on the situation clearly' <?= ($auditData['active_listening_Fail_reason']=='Lack of active listening- asked questions to customer while he already advised on the situation clearly')?'selected':'' ?>>Lack of active listening- asked questions to customer while he already advised on the situation clearly</option>
												<option value='Lack of active listening- missed out on key elements and information provided by the customer while the customer was clear' <?= ($auditData['active_listening_Fail_reason']=='Lack of active listening- missed out on key elements and information provided by the customer while the customer was clear')?'selected':'' ?>>Lack of active listening- missed out on key elements and information provided by the customer while the customer was clear</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt3]"><?php echo $auditData['cmt3']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Assurance</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[assurance]" disabled>
												<option scr_val='3.58' scr_max='3.58' ss_score=11.12 <?php echo $auditData['assurance']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.58' ss_score=0 <?php echo $auditData['assurance']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.58' scr_max='3.58' ss_score=11.12 <?php echo $auditData['assurance']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[assurance_Fail_reason]" disabled>
												<option value='Did not provide any assurance statements at all' <?= ($auditData['assurance_Fail_reason']=='Did not provide any assurance statements at all')?'selected':'' ?>>Did not provide any assurance statements at all</option>
												<option value='Did not sound genuine while providing reassurance statement (assurance statements are generic and did not reflect the specific concerns of the customer)' <?= ($auditData['assurance_Fail_reason']=='Did not sound genuine while providing reassurance statement (assurance statements are generic and did not reflect the specific concerns of the customer)')?'selected':'' ?>>Did not sound genuine while providing reassurance statement (assurance statements are generic and did not reflect the specific concerns of the customer)</option>
												<option value='Did not sound confident- our actions did not inspire confidence that we are able to handle the customers concerns or resolve their issue' <?= ($auditData['assurance_Fail_reason']=='Did not sound confident- our actions did not inspire confidence that we are able to handle the customers concerns or resolve their issue')?'selected':'' ?>>Did not sound confident- our actions did not inspire confidence that we are able to handle the customer's concerns or resolve their issue</option>
												<option value='Missed some opportunities within the call to reassure the customer that we can help' <?= ($auditData['assurance_Fail_reason']=='Missed some opportunities within the call to reassure the customer that we can help')?'selected':'' ?>>Missed some opportunities within the call to reassure the customer that we can help</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt4]"><?php echo $auditData['cmt4']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Empathy</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[empathy]" disabled>
												<option scr_val='3.58' scr_max='3.58' ss_score=11.11 <?php echo $auditData['empathy']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.58' ss_score=0 <?php echo $auditData['empathy']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.58' scr_max='3.58' ss_score=11.11 <?php echo $auditData['empathy']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[empathy_Fail_reason]" disabled>
												<option value='Did not sound genuine- our demeanor does not match our customer' <?= ($auditData['empathy_Fail_reason']=='Did not sound genuine- our demeanor does not match our customer')?'selected':'' ?>>Did not sound genuine- our demeanor does not match our customer</option>
												<option value='Used generic words and phrases and phrases that do not convince the customer that we understand their specific situation' <?= ($auditData['empathy_Fail_reason']=='Used generic words and phrases and phrases that do not convince the customer that we understand their specific situation')?'selected':'' ?>>Used generic words and phrases and phrases that do not convince the customer that we understand their specific situation</option>
												<option value='Did not respect the urgency and seriousness about the issue and how the customer feels about it' <?= ($auditData['empathy_Fail_reason']=='Did not respect the urgency and seriousness about the issue and how the customer feels about it')?'selected':'' ?>>Did not respect the urgency and seriousness about the issue and how the customer feels about it</option>
												<option value='Apologized when is not needed- must use correct statement at the correct time' <?= ($auditData['empathy_Fail_reason']=='Apologized when is not needed- must use correct statement at the correct time')?'selected':'' ?>>Apologized when is not needed- must use correct statement at the correct time</option>
												<option value='Limited the display of empathy to a few words but didnot follow up or took the proper action throughout the call or interaction' <?= ($auditData['empathy_Fail_reason']=='Limited the display of empathy to a few words but didnot follow up or took the proper action throughout the call or interaction')?'selected':'' ?>>Limited the display of empathy to a few words but didn't follow up or took the proper action throughout the call or interaction</option>
												<option value='Missed opportunities to make personal connection' <?= ($auditData['empathy_Fail_reason']=='Missed opportunities to make personal connection')?'selected':'' ?>>Missed opportunities to make personal connection</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt5]"><?php echo $auditData['cmt5']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Vocal Impact</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[vocal_impact]" disabled>
												<option scr_val='3.58' scr_max='3.58' ss_score=11.11 <?php echo $auditData['vocal_impact']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.58' ss_score=0 <?php echo $auditData['vocal_impact']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.58' scr_max='3.58' ss_score=11.11 <?php echo $auditData['vocal_impact']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[vocal_impact_Fail_reason]" disabled>
												<option value='TONE: We were difficult to be understood- we mumbled- sounded bored or tired VOLUME: We sounded muffled or spoke too softly or were shouting' <?= ($auditData['vocal_impact_Fail_reason']=='TONE: We were difficult to be understood- we mumbled- sounded bored or tired VOLUME: We sounded muffled or spoke too softly or were shouting')?'selected':'' ?>>TONE: We were difficult to be understood- we mumbled- sounded bored or tired VOLUME: We sounded muffled or spoke too softly or were shouting</option>
												<option value='VOLUME: We ignored comments by the customer that he was having a hard time hearing us or didn’t attempt to make any adjustments to our audio setup' <?= ($auditData['vocal_impact_Fail_reason']=='VOLUME: We ignored comments by the customer that he was having a hard time hearing us or didn’t attempt to make any adjustments to our audio setup')?'selected':'' ?>>VOLUME: We ignored comments by the customer that he was having a hard time hearing us or didn’t attempt to make any adjustments to our audio setup</option>
												<option value='VOLUME: We insisted on continuing with the current call even though the customer was frustrated and did not offer a call back' <?= ($auditData['vocal_impact_Fail_reason']=='VOLUME: We insisted on continuing with the current call even though the customer was frustrated and did not offer a call back')?'selected':'' ?>>VOLUME: We insisted on continuing with the current call even though the customer was frustrated and did not offer a call back</option>
												<option value='ENERGY: We sounded disinterested or we didn’t care' <?= ($auditData['vocal_impact_Fail_reason']=='ENERGY: We sounded disinterested or we didn’t care')?'selected':'' ?>>ENERGY: We sounded disinterested or we didn’t care</option>
												<option value='PACE: Rate of speech was too fast or we moved from step to step too quickly or too slowly and the customer was waiting for us to catch up or for the next instruction' <?= ($auditData['vocal_impact_Fail_reason']=='PACE: Rate of speech was too fast or we moved from step to step too quickly or too slowly and the customer was waiting for us to catch up or for the next instruction')?'selected':'' ?>>PACE: Rate of speech was too fast or we moved from step to step too quickly or too slowly and the customer was waiting for us to catch up or for the next instruction</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt6]"><?php echo $auditData['cmt6']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Call or Chat Control</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[call_chat_control]" disabled>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['call_chat_control']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' ss_score=0 <?php echo $auditData['call_chat_control']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['call_chat_control']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[call_chat_control_Fail_reason]" disabled>
												<option value='Chat: The chat conversation skills are not consistent with the expectations established for voice conversations' <?= ($auditData['call_chat_control_Fail_reason']=='Chat: The chat conversation skills are not consistent with the expectations established for voice conversations')?'selected':'' ?>>Chat: The chat conversation skills are not consistent with the expectations established for voice conversations</option>
												<option value='Chat: Abandoned chats for long periods of time without explanation or without asking for assistance from a colleague or we gave the impression that our personal time (lunch/break/end of shift) is more of a priority than their issue' <?= ($auditData['call_chat_control_Fail_reason']=='Chat: Abandoned chats for long periods of time without explanation or without asking for assistance from a colleague or we gave the impression that our personal time (lunch/break/end of shift) is more of a priority than their issue')?'selected':'' ?>>Chat: Abandoned chats for long periods of time without explanation or without asking for assistance from a colleague or we gave the impression that our personal time (lunch/break/end of shift) is more of a priority than their issue</option>
												<option value='Chat: Failed to refresh customer within 4 min and there are long noticeable delays in your chat replies to the detriment of the customer experience' <?= ($auditData['call_chat_control_Fail_reason']=='Chat: Failed to refresh customer within 4 min and there are long noticeable delays in your chat replies to the detriment of the customer experience')?'selected':'' ?>>Chat: Failed to refresh customer within 4 min and there are long noticeable delays in your chat replies to the detriment of the customer experience</option>
												<option value='Calls: Tone and attitude are perceptibly negative' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Tone and attitude are perceptibly negative')?'selected':'' ?>>Calls: Tone and attitude are perceptibly negative</option>
												<option value='Calls: Allowed long periods of dead air without addressing or explaining them' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Allowed long periods of dead air without addressing or explaining them')?'selected':'' ?>>Calls: Allowed long periods of dead air without addressing or explaining them</option>
												<option value='Calls: Conversation went off on tangents and was not relevant to the issue the customer called about' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Conversation went off on tangents and was not relevant to the issue the customer called about')?'selected':'' ?>>Calls: Conversation went off on tangents and was not relevant to the issue the customer called about</option>
												<option value='Calls: Allowed the customer to be distracted and directed the conversation away from the issue at hand with no or poor attempts to refocus the customer' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Allowed the customer to be distracted and directed the conversation away from the issue at hand with no or poor attempts to refocus the customer')?'selected':'' ?>>Calls: Allowed the customer to be distracted and directed the conversation away from the issue at hand with no or poor attempts to refocus the customer</option>
												<option value='Calls: Questions or troubleshooting steps were random and did not follow a clear and logical path to a goal' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Questions or troubleshooting steps were random and did not follow a clear and logical path to a goal')?'selected':'' ?>>Calls: Questions or troubleshooting steps were random and did not follow a clear and logical path to a goal</option>
												<option value='Calls: Sounded distracted by our surroundings while on call' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Sounded distracted by our surroundings while on call')?'selected':'' ?>>Calls: Sounded distracted by our surroundings while on call</option>
												<option value='Calls: Instructions were unclear or difficult to follow and the customer was unable to keep up or needed to ask you to repeat yourself or slow down' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Instructions were unclear or difficult to follow and the customer was unable to keep up or needed to ask you to repeat yourself or slow down')?'selected':'' ?>>Calls: Instructions were unclear or difficult to follow and the customer was unable to keep up or needed to ask you to repeat yourself or slow down</option>
												<option value='Calls: Disrupted the flow of the conversation by repeatedly asking for the customers contact info or asking them to spell every detail or put them on unnecessary hold to look up their account or ticket or for no valid reason' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Disrupted the flow of the conversation by repeatedly asking for the customers contact info or asking them to spell every detail or put them on unnecessary hold to look up their account or ticket or for no valid reason')?'selected':'' ?>>Calls: Disrupted the flow of the conversation by repeatedly asking for the customer's contact info or asking them to spell every detail or put them on unnecessary hold to look up their account or ticket or for no valid reason</option>
												<option value='Calls: Failed to refresh customer within 2-3 minutes of hold time' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Failed to refresh customer within 2-3 minutes of hold time')?'selected':'' ?>>Calls: Failed to refresh customer within 2-3 minutes of hold time</option>
												<option value='Calls: Lack of ownership- unnecessary transfer as we did not take control of the situation but preferred transferring to another Team/Department' <?= ($auditData['call_chat_control_Fail_reason']=='Calls: Lack of ownership- unnecessary transfer as we did not take control of the situation but preferred transferring to another Team/Department')?'selected':'' ?>>Calls: Lack of ownership- unnecessary transfer as we did not take control of the situation but preferred transferring to another Team/Department</option>
												<option value='Calls: Lack of ownership- asked the customer to call back while we should have offered to call back the customer' <?= ($auditData['call_chat_control_Fail_reason']=='')?'selected':'' ?>>Calls: Lack of ownership- asked the customer to call back while we should have offered to call back the customer</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt7]"><?php echo $auditData['cmt7']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Professionalism</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[professionalism]" disabled>
												<option scr_val='3.58' scr_max='3.58' ss_score=11.11 <?php echo $auditData['professionalism']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.58' ss_score=0 <?php echo $auditData['professionalism']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.58' scr_max='3.58' ss_score=11.11 <?php echo $auditData['professionalism']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[professionalism_Fail_reason]" disabled>
												<option value='Calls: Being impatient and Interrupted customers multiple times or talked over the customer multiple times' <?= ($auditData['professionalism_Fail_reason']=='Calls: Being impatient and Interrupted customers multiple times or talked over the customer multiple times')?'selected':'' ?>>Calls: Being impatient and Interrupted customers multiple times or talked over the customer multiple times</option>
												<option value='Calls: Our tone was disrespectful- annoyed or condescending and we did not use common courtesies when applicable' <?= ($auditData['professionalism_Fail_reason']=='Calls: Our tone was disrespectful- annoyed or condescending and we did not use common courtesies when applicable')?'selected':'' ?>>Calls: Our tone was disrespectful- annoyed or condescending and we did not use common courtesies when applicable</option>
												<option value='Calls: We used negative terms instead of attempting to turn a negative situation into a positive one' <?= ($auditData['professionalism_Fail_reason']=='Calls: We used negative terms instead of attempting to turn a negative situation into a positive one')?'selected':'' ?>>Calls: We used negative terms instead of attempting to turn a negative situation into a positive one</option>
												<option value='Calls: We disparaged the company/ other departments or teams/ our partner(s)/ the program and/or the competition' <?= ($auditData['professionalism_Fail_reason']=='Calls: We disparaged the company/ other departments or teams/ our partner(s)/ the program and/or the competition')?'selected':'' ?>>Calls: We disparaged the company/ other departments or teams/ our partner(s)/ the program and/or the competition</option>
												<option value='Calls: Being impatient or overconfident rushing through the call' <?= ($auditData['professionalism_Fail_reason']=='Calls: Being impatient or overconfident rushing through the call')?'selected':'' ?>>Calls: Being impatient or overconfident rushing through the call</option>
												<option value='For White-Labeled Programs (where we use our partner’s branding): We directly or indirectly allowed the customer to know or feel that we are a separate entity and not a direct employee of the company the customer has purchased their service through' <?= ($auditData['professionalism_Fail_reason']=='For White-Labeled Programs (where we use our partner’s branding): We directly or indirectly allowed the customer to know or feel that we are a separate entity and not a direct employee of the company the customer has purchased their service through')?'selected':'' ?>>For White-Labeled Programs (where we use our partner’s branding): We directly or indirectly allowed the customer to know or feel that we are a separate entity and not a direct employee of the company the customer has purchased their service through</option>
												<option value='For White-Labeled Programs (where we use our partner’s branding): We used slang outdated or uncommon terminology to the detriment of the customer experience' <?= ($auditData['professionalism_Fail_reason']=='For White-Labeled Programs (where we use our partner’s branding): We used slang outdated or uncommon terminology to the detriment of the customer experience')?'selected':'' ?>>For White-Labeled Programs (where we use our partner’s branding): We used slang outdated or uncommon terminology to the detriment of the customer experience</option>
												<option value='For White-Labeled Programs (where we use our partner’s branding): We used overly technical terms and explanations for customers who are not technically savvy and/or we talked down to someone who was obviously technically literate or trained' <?= ($auditData['professionalism_Fail_reason']=='For White-Labeled Programs (where we use our partner’s branding): We used overly technical terms and explanations for customers who are not technically savvy and/or we talked down to someone who was obviously technically literate or trained')?'selected':'' ?>>For White-Labeled Programs (where we use our partner’s branding): We used overly technical terms and explanations for customers who are not technically savvy and/or we talked down to someone who was obviously technically literate or trained</option>
												<option value='Chat: The chat conversation did not maintain the same level of professionalism as is expected in a phone conversation' <?= ($auditData['professionalism_Fail_reason']=='Chat: The chat conversation did not maintain the same level of professionalism as is expected in a phone conversation')?'selected':'' ?>>Chat: The chat conversation did not maintain the same level of professionalism as is expected in a phone conversation</option>
												<option value='Chat: We used casual internet acronyms that are not appropriate for a business conversation' <?= ($auditData['professionalism_Fail_reason']=='Chat: We used casual internet acronyms that are not appropriate for a business conversation')?'selected':'' ?>>Chat: We used casual internet acronyms that are not appropriate for a business conversation</option>
												<option value='Chat: We didnt explain the acronyms we used especially industry-specific technical or generally uncommon ones' <?= ($auditData['professionalism_Fail_reason']=='Chat: We didnt explain the acronyms we used especially industry-specific technical or generally uncommon ones')?'selected':'' ?>>Chat: We didn't explain the acronyms we used especially industry-specific technical or generally uncommon ones</option>
												<option value='Chat: We made too many typos by consistently missing punctuation marks and capitalization and often used the wrong forms of (they are/there/their/its/its/a lot/allot/i.e./e.g. etc.)' <?= ($auditData['professionalism_Fail_reason']=='Chat: We made too many typos by consistently missing punctuation marks and capitalization and often used the wrong forms of (they are/there/their/its/its/a lot/allot/i.e./e.g. etc.)')?'selected':'' ?>>Chat: We made too many typos by consistently missing punctuation marks and capitalization and often used the wrong forms of (they're/there/their/it's/its/a lot/allot/i.e./e.g. etc.)</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt8]"><?php echo $auditData['cmt8']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Closing and Last impressions</td>
										<td>11.11</td>
										<td>
											<select class="form-control scorecalc softskill" name="data[closing_last_impression]" disabled>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['closing_last_impression']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' ss_score=0 <?php echo $auditData['closing_last_impression']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' ss_score=11.11 <?php echo $auditData['closing_last_impression']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[closing_last_impression_Fail_reason]" disabled>
												<option value='Calls/Chats: We did not set proper expectations or did not inform the customer that our work will end while they are away' <?= ($auditData['closing_last_impression_Fail_reason']=='Calls/Chats: We did not set proper expectations or did not inform the customer that our work will end while they are away')?'selected':'' ?>>Calls/Chats: We did not set proper expectations or did not inform the customer that our work will end while they are away</option>
												<option value='Calls/Chats: We rushed the customer to end the conversation' <?= ($auditData['closing_last_impression_Fail_reason']=='Calls/Chats: We rushed the customer to end the conversation')?'selected':'' ?>>Calls/Chats: We rushed the customer to end the conversation</option>
												<option value='Chats: We did not follow through on sending summary note and letting the customer know that we have completed' <?= ($auditData['closing_last_impression_Fail_reason']=='Chats: We did not follow through on sending summary note and letting the customer know that we have completed')?'selected':'' ?>>Chats: We did not follow through on sending summary note and letting the customer know that we have completed</option>
												<option value='Calls/Chats: We did not thank the caller and, or ended the conversation awkwardly, informally or unprofessionally or our tone was not friendly and energetic' <?= ($auditData['closing_last_impression_Fail_reason']=='Calls/Chats: We did not thank the caller and, or ended the conversation awkwardly, informally or unprofessionally or our tone was not friendly and energetic')?'selected':'' ?>>Calls/Chats: We did not thank the caller and, or ended the conversation awkwardly, informally or unprofessionally or our tone was not friendly and energetic</option>
												<option value='Chats: Failed to follow the 13 min threshold procedure for no response from the customer' <?= ($auditData['closing_last_impression_Fail_reason']=='Chats: Failed to follow the 13 min threshold procedure for no response from the customer')?'selected':'' ?>>Chats: Failed to follow the 13 min threshold procedure for no response from the customer</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt9]"><?php echo $auditData['cmt9']; ?></textarea></td>
									</tr>
									<tr>
										<th colspan=3 scope="row" class="scope">Sales Process</th>
										<th class="scope">Causes</th>
										<th><input type="text" id="sales_process_score" name="data[sales_skill_score]" class="form-control" value="<?php echo $auditData['sales_skill_score']; ?>" readonly></th>
									</tr>
									<tr>
										<td class="paddingTop">Understanding Needs & Buying Signals</td>
										<td>20</td>
										<td>
											<select class="form-control scorecalc salesprocess" name="data[buying_signal]" disabled>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['buying_signal']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' sp_score=0 <?php echo $auditData['buying_signal']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['buying_signal']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[buying_signal_Fail_reason]" disabled>
												<option value='Failed to gather Technology usage information' <?= ($auditData['buying_signal_Fail_reason']=='Failed to gather Technology usage information')?'selected':'' ?>>Failed to gather Technology usage information</option>
												<option value='Failed to ask SALES probing questions' <?= ($auditData['buying_signal_Fail_reason']=='Failed to ask SALES probing questions')?'selected':'' ?>>Failed to ask SALES probing questions</option>
												<option value='Failed to understand the current issue' <?= ($auditData['buying_signal_Fail_reason']=='Failed to understand the current issue')?'selected':'' ?>>Failed to understand the current issue</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt10]"><?php echo $auditData['cmt10']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Build Value</td>
										<td>20</td>
										<td>
											<select class="form-control scorecalc salesprocess" name="data[build_value]" disabled>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['build_value']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' sp_score=0 <?php echo $auditData['build_value']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['build_value']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[build_value_Fail_reason]" disabled>
												<option value='Gave out the price too early' <?= ($auditData['acpt']=='Gave out the price too early')?'selected':'' ?>>Gave out the price too early</option>
												<option value='Did not relate the benefits to the customers specific situation' <?= ($auditData['acpt']=='Did not relate the benefits to the customers specific situation')?'selected':'' ?>>Did not relate the benefits to the customer's specific situation</option>
												<option value='Discussed features only without the benefits' <?= ($auditData['acpt']=='Discussed features only without the benefits')?'selected':'' ?>>Discussed features only without the benefits</option>
												<option value='Built value only for todays issue and not for ongoing support' <?= ($auditData['acpt']=='Built value only for todays issue and not for ongoing support')?'selected':'' ?>>Built value only for today's issue and not for ongoing support</option>
												<option value='Failed to offer the right plan' <?= ($auditData['acpt']=='Failed to offer the right plan')?'selected':'' ?>>Failed to offer the right plan</option>
												<option value='Failed to follow the proper sales flow- we built the value prior understanding the customers needs' <?= ($auditData['acpt']=='Failed to follow the proper sales flow- we built the value prior understanding the customers needs')?'selected':'' ?>>Failed to follow the proper sales flow- we built the value prior understanding the customer's needs</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt11]"><?php echo $auditData['cmt11']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Overcoming Objections</td>
										<td>20</td>
										<td>
											<select class="form-control scorecalc salesprocess" name="data[overcoming_object]" disabled>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['overcoming_object']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' sp_score=0 <?php echo $auditData['overcoming_object']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['overcoming_object']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[overcoming_object_Fail_reason]" disabled>
												<option value='Did not offer any rebuttal' <?= ($auditData['overcoming_object_Fail_reason']=='Did not offer any rebuttal')?'selected':'' ?>>Did not offer any rebuttal</option>
												<option value='Offered a rebuttal that did not address the customers objection' <?= ($auditData['overcoming_object_Fail_reason']=='Offered a rebuttal that did not address the customers objection')?'selected':'' ?>>Offered a rebuttal that did not address the customer's objection</option>
												<option value='Did not ask any questions to clarify the objection' <?= ($auditData['overcoming_object_Fail_reason']=='Did not ask any questions to clarify the objection')?'selected':'' ?>>Did not ask any questions to clarify the objection</option>
												<option value='Did not try to rebuild the value of the service' <?= ($auditData['overcoming_object_Fail_reason']=='Did not try to rebuild the value of the service')?'selected':'' ?>>Did not try to rebuild the value of the service</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt12]"><?php echo $auditData['cmt12']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Sales Accuracy and Confirming sale</td>
										<td>20</td>
										<td>
											<select class="form-control scorecalc salesprocess" name="data[sales_accuracy]" disabled>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['sales_accuracy']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' sp_score=0 <?php echo $auditData['sales_accuracy']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['sales_accuracy']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[sales_accuracy_Fail_reason]" disabled>
												<option value='Did not confirm the product was added to the account' <?= ($auditData['sales_accuracy_Fail_reason']=='Did not confirm the product was added to the account')?'selected':'' ?>>Did not confirm the product was added to the account</option>
												<option value='Failed to ensure explicit consent from the customer before adding the sale' <?= ($auditData['sales_accuracy_Fail_reason']=='Failed to ensure explicit consent from the customer before adding the sale')?'selected':'' ?>>Failed to ensure explicit consent from the customer before adding the sale</option>
												<option value='Failed to explain all charges, fees and commitments' <?= ($auditData['sales_accuracy_Fail_reason']=='Failed to explain all charges, fees and commitments')?'selected':'' ?>>Failed to explain all charges, fees and commitments</option>
												<option value='Eastlink specific: Mentioned cancelling at any time proactively while customer did not ask as in a question form such as, Can I cancel anytime?, Am I on a commitment?, Can I cancel after a month?' <?= ($auditData['sales_accuracy_Fail_reason']=='Eastlink specific: Mentioned cancelling at any time proactively while customer did not ask as in a question form such as, Can I cancel anytime?, Am I on a commitment?, Can I cancel after a month?')?'selected':'' ?>>Eastlink specific: Mentioned cancelling at any time proactively while customer did not ask as in a question form such as, Can I cancel anytime?, Am I on a commitment?, Can I cancel after a month?</option>
												<option value='Failed to give a recap and summarize on the price prior getting the consent of the customer' <?= ($auditData['sales_accuracy_Fail_reason']=='Failed to give a recap and summarize on the price prior getting the consent of the customer')?'selected':'' ?>>Failed to give a recap and summarize on the price prior getting the consent of the customer</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt13]"><?php echo $auditData['cmt13']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Sales Retention</td>
										<td>20</td>
										<td>
											<select class="form-control scorecalc salesprocess" name="data[sales_retention]" disabled>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['sales_retention']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' sp_score=0 <?php echo $auditData['sales_retention']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' sp_score=20 <?php echo $auditData['sales_retention']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[sales_retention_Fail_reason]" disabled>
												<option value='Did not try to understand the reason for the cancellation request' <?= ($auditData['sales_retention_Fail_reason']=='Did not try to understand the reason for the cancellation request')?'selected':'' ?>>Did not try to understand the reason for the cancellation request</option>
												<option value='Did not offer to try one more time if the reason is an unresolved issue' <?= ($auditData['sales_retention_Fail_reason']=='Did not offer to try one more time if the reason is an unresolved issue')?'selected':'' ?>>Did not offer to try one more time if the reason is an unresolved issue</option>
												<option value='Did not offer a rebuttal to the reason for the cancellation' <?= ($auditData['sales_retention_Fail_reason']=='Did not offer a rebuttal to the reason for the cancellation')?'selected':'' ?>>Did not offer a rebuttal to the reason for the cancellation</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt14]"><?php echo $auditData['cmt14']; ?></textarea></td>
									</tr>
									<tr>
										<th colspan=3 scope="row" class="scope">Process and Procedure</th>
										<th class="scope">Causes</th>
										<th><input type="text" id="process_procedure_score" name="data[process_procedure_score]" class="form-control" value="<?php echo $auditData['process_procedure_score']; ?>" readonly></th>
									</tr>
									<tr>
										<td class="paddingTop">Account Verification</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[account_verification]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['account_verification']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['account_verification']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['account_verification']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[account_verification_Fail_reason]" disabled>
												<option value='Did not get the required identifying information according to the partners standards' <?= ($auditData['account_verification_Fail_reason']=='Did not get the required identifying information according to the partners standards')?'selected':'' ?>>Did not get the required identifying information according to the partners standards</option>
												<option value='Failed to create an account for customer' <?= ($auditData['account_verification_Fail_reason']=='Failed to create an account for customer')?'selected':'' ?>>Failed to create an account for customer</option>
												<option value='Offering account information rather than having the customer supply it(Ex: Is your phone number 123-456-7890? Instead of asking the customer for the number)' <?= ($auditData['account_verification_Fail_reason']=='Offering account information rather than having the customer supply it(Ex: Is your phone number 123-456-7890? Instead of asking the customer for the number)')?'selected':'' ?>>Offering account information rather than having the customer supply it(Ex: Is your phone number 123-456-7890? Instead of asking the customer for the number)</option>
												<option value='Making a sale before verifying the caller is authorized. Not asking the correct security questions' <?= ($auditData['account_verification_Fail_reason']=='Making a sale before verifying the caller is authorized. Not asking the correct security questions')?'selected':'' ?>>Making a sale before verifying the caller is authorized. Not asking the correct security questions</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt15]"><?php echo $auditData['cmt15']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">AFK Procedures and Set Proper Expectations</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[afk_procedure]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['afk_procedure']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['afk_procedure']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['afk_procedure']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[afk_procedure_Fail_reason]" disabled>
												<option value='Failed to confirm call back number in case of disconnection' <?= ($auditData['afk_procedure_Fail_reason']=='Failed to confirm call back number in case of disconnection')?'selected':'' ?>>Failed to confirm call back number in case of disconnection</option>
												<option value='AFK: Kept the customer on the phone or in front of their computer unnecessarily' <?= ($auditData['afk_procedure_Fail_reason']=='AFK: Kept the customer on the phone or in front of their computer unnecessarily')?'selected':'' ?>>AFK: Kept the customer on the phone or in front of their computer unnecessarily</option>
												<option value='AFK: No explanation provided on AFK process and why it is important adequately' <?= ($auditData['afk_procedure_Fail_reason']=='AFK: No explanation provided on AFK process and why it is important adequately')?'selected':'' ?>>AFK: No explanation provided on AFK process and why it is important adequately</option>
												<option value='AFK: Failed to address customers concerns accurately' <?= ($auditData['afk_procedure_Fail_reason']=='AFK: Failed to address customers concerns accurately')?'selected':'' ?>>AFK: Failed to address customer's concerns accurately</option>
												<option value='AFK: Customer was forced to AFK when he did not want to' <?= ($auditData['afk_procedure_Fail_reason']=='AFK: Customer was forced to AFK when he did not want to')?'selected':'' ?>>AFK: Customer was forced to AFK when he did not want to</option>
												<option value='AFK: Did not prompt user for PC password and explain why it was needed if asked' <?= ($auditData['afk_procedure_Fail_reason']=='AFK: Did not prompt user for PC password and explain why it was needed if asked')?'selected':'' ?>>AFK: Did not prompt user for PC password and explain why it was needed if asked</option>
												<option value='FOLLOW-UP (Call/Chat): Failed to follow-up with customer for any promised call back SET EXPECTATIONS: Time estimate was unrealistic and either too long or too short' <?= ($auditData['afk_procedure_Fail_reason']=='FOLLOW-UP (Call/Chat): Failed to follow-up with customer for any promised call back SET EXPECTATIONS: Time estimate was unrealistic and either too long or too short')?'selected':'' ?>>FOLLOW-UP (Call/Chat): Failed to follow-up with customer for any promised call back SET EXPECTATIONS: Time estimate was unrealistic and either too long or too short</option>
												<option value='SET EXPECTATIONS: Did not respect completion time promised to customer' <?= ($auditData['afk_procedure_Fail_reason']=='SET EXPECTATIONS: Did not respect completion time promised to customer')?'selected':'' ?>>SET EXPECTATIONS: Did not respect completion time promised to customer</option>
												<option value='SET EXPECTATIONS: Failed to provide any time estimates or unreasonable estimates for escalations/ transfers and follow-up calls' <?= ($auditData['afk_procedure_Fail_reason']=='SET EXPECTATIONS: Failed to provide any time estimates or unreasonable estimates for escalations/ transfers and follow-up calls')?'selected':'' ?>>SET EXPECTATIONS: Failed to provide any time estimates or unreasonable estimates for escalations/ transfers and follow-up calls</option>
												<option value='SET EXPECTATIONS: Failed to keep customer informed about the support/ escalation or transfer process or provide any way for customer to efficiently follow up with us' <?= ($auditData['afk_procedure_Fail_reason']=='SET EXPECTATIONS: Failed to keep customer informed about the support/ escalation or transfer process or provide any way for customer to efficiently follow up with us')?'selected':'' ?>>SET EXPECTATIONS: Failed to keep customer informed about the support/ escalation or transfer process or provide any way for customer to efficiently follow up with us</option>
												<option value='SET EXPECTATIONS: Made promises that cannot be kept or on behalf of someone else that we are not accountable for' <?= ($auditData['afk_procedure_Fail_reason']=='SET EXPECTATIONS: Made promises that cannot be kept or on behalf of someone else that we are not accountable for')?'selected':'' ?>>SET EXPECTATIONS: Made promises that cannot be kept or on behalf of someone else that we are not accountable for</option>
												<option value='TRANSFERS (Chat/calls): Failed to explain why a transfer is necessary or to whom or which team we are transferring the customer to' <?= ($auditData['afk_procedure_Fail_reason']=='TRANSFERS (Chat/calls): Failed to explain why a transfer is necessary or to whom or which team we are transferring the customer to')?'selected':'' ?>>TRANSFERS (Chat/calls): Failed to explain why a transfer is necessary or to whom or which team we are transferring the customer to</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt16]"><?php echo $auditData['cmt16']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Followed correct TechWeb procedure</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[follow_correct_techweb]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_techweb']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['follow_correct_techweb']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_techweb']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[follow_correct_techweb_Fail_reason]" disabled>
												<option value='Did not create a ticket for support' <?= ($auditData['follow_correct_techweb_Fail_reason']=='Did not create a ticket for support')?'selected':'' ?>>Did not create a ticket for support</option>
												<option value='Did not leave an interaction for all interactions' <?= ($auditData['follow_correct_techweb_Fail_reason']=='Did not leave an interaction for all interactions')?'selected':'' ?>>Did not leave an interaction for all interactions</option>
												<option value='Did not add the correct call driver' <?= ($auditData['follow_correct_techweb_Fail_reason']=='Did not add the correct call driver')?'selected':'' ?>>Did not add the correct call driver</option>
												<option value='Did not leave the ticket in the correct state' <?= ($auditData['follow_correct_techweb_Fail_reason']=='Did not leave the ticket in the correct state')?'selected':'' ?>>Did not leave the ticket in the correct state</option>
												<option value='Did not add the correct product on the account' <?= ($auditData['follow_correct_techweb_Fail_reason']=='Did not add the correct product on the account')?'selected':'' ?>>Did not add the correct product on the account</option>
												<option value='Failed to take ticket ownership to help a customer' <?= ($auditData['follow_correct_techweb_Fail_reason']=='Failed to take ticket ownership to help a customer')?'selected':'' ?>>Failed to take ticket ownership to help a customer</option>
												<option value='Did not leave a clear/enough documentation of the issue and what was done' <?= ($auditData['follow_correct_techweb_Fail_reason']=='Did not leave a clear/enough documentation of the issue and what was done')?'selected':'' ?>>Did not leave a clear/enough documentation of the issue and what was done</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt17]"><?php echo $auditData['cmt17']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Followed correct Five9 procedures</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[follow_correct_five9]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_five9']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['follow_correct_five9']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_five9']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[follow_correct_five9_Fail_reason]" disabled>
												<option value='Did not complete the worksheet (if applicable)' <?= ($auditData['follow_correct_five9_Fail_reason']=='Did not complete the worksheet (if applicable)')?'selected':'' ?>>Did not complete the worksheet (if applicable)</option>
												<option value='Prolonged use of the mute button when a Hold should have been used' <?= ($auditData['follow_correct_five9_Fail_reason']=='Prolonged use of the mute button when a Hold should have been used')?'selected':'' ?>>Prolonged use of the mute button when a Hold should have been used</option>
												<option value='Cold transferring when a warm transfer is required' <?= ($auditData['follow_correct_five9_Fail_reason']=='Cold transferring when a warm transfer is required')?'selected':'' ?>>Cold transferring when a warm transfer is required</option>
												<option value='Not pausing the recording when credit card information is being taken' <?= ($auditData['follow_correct_five9_Fail_reason']=='Not pausing the recording when credit card information is being taken')?'selected':'' ?>>Not pausing the recording when credit card information is being taken</option>
												<option value='Wrong Disposition' <?= ($auditData['follow_correct_five9_Fail_reason']=='Wrong Disposition')?'selected':'' ?>>Wrong Disposition</option>
												<option value='Wrong Primary Five9 Disposition' <?= ($auditData['follow_correct_five9_Fail_reason']=='Wrong Primary Five9 Disposition')?'selected':'' ?>>Wrong Primary Five9 Disposition</option>
												<option value='Wrong Secondary Five9 disposition' <?= ($auditData['follow_correct_five9_Fail_reason']=='Wrong Secondary Five9 disposition')?'selected':'' ?>>Wrong Secondary Five9 disposition</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt18]"><?php echo $auditData['cmt18']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Followed correct LMI and CASL procedures</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[follow_correct_lmi]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_lmi']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['follow_correct_lmi']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_lmi']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[follow_correct_lmi_Fail_reason]" disabled>
												<option value='CASL - Did not use the correct consent PDRs and procedures' <?= ($auditData['follow_correct_lmi_Fail_reason']=='CASL - Did not use the correct consent PDRs and procedures')?'selected':'' ?>>CASL - Did not use the correct consent PDRs and procedures</option>
												<option value='LMI - did not enter the correct ticket number at the end of the chat sessions' <?= ($auditData['follow_correct_lmi_Fail_reason']=='LMI - did not enter the correct ticket number at the end of the chat sessions')?'selected':'' ?>>LMI - did not enter the correct ticket number at the end of the chat sessions</option>
												<option value='LMI: Failed to deploy Leave behind image for Partner specific' <?= ($auditData['follow_correct_lmi_Fail_reason']=='LMI: Failed to deploy Leave behind image for Partner specific')?'selected':'' ?>>LMI: Failed to deploy Leave behind image for Partner specific</option>
												<option value='LMI - did not use the partner-branded remote connection page to connect but instead used the support.me or logmein123.com page' <?= ($auditData['follow_correct_lmi_Fail_reason']=='LMI - did not use the partner-branded remote connection page to connect but instead used the support.me or logmein123.com page')?'selected':'' ?>>LMI - did not use the partner-branded remote connection page to connect but instead used the support.me or logmein123.com page</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt19]"><?php echo $auditData['cmt19']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Installed/Explained SPD</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[explain_spd]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['explain_spd']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['explain_spd']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['explain_spd']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[explain_spd_Fail_reason]" disabled>
												<option value='Installed the application but did not explain what it was for (check chat logs)' <?= ($auditData['explain_spd_Fail_reason']=='Installed the application but did not explain what it was for (check chat logs)')?'selected':'' ?>>Installed the application but did not explain what it was for (check chat logs)</option>
												<option value='We did not mention the partner branded SPD (The BTS application, the Gadget Rescue dashboard, etc.) and did not install it' <?= ($auditData['explain_spd_Fail_reason']=='We did not mention the partner branded SPD (The BTS application, the Gadget Rescue dashboard, etc.) and did not install it')?'selected':'' ?>>We did not mention the partner branded SPD (The BTS application, the Gadget Rescue dashboard, etc.) and did not install it</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt20]"><?php echo $auditData['cmt20']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Followed correct Scam Call Handling Procedures</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[follow_correct_call_handling]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_call_handling']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['follow_correct_call_handling']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_call_handling']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[follow_correct_call_handling_Fail_reason]" disabled>
												<option value='Did not complete the Scam Log form' <?= ($auditData['follow_correct_call_handling_Fail_reason']=='Did not complete the Scam Log form')?'selected':'' ?>>Did not complete the 'Scam Log' form</option>
												<option value='Additional call drivers for other issues were needed but not used' <?= ($auditData['follow_correct_call_handling_Fail_reason']=='Additional call drivers for other issues were needed but not used')?'selected':'' ?>>Additional call drivers for other issues were needed but not used</option>
												<option value='The HANDLING SCAM CASES call driver was not used' <?= ($auditData['follow_correct_call_handling_Fail_reason']=='The HANDLING SCAM CASES call driver was not used')?'selected':'' ?>>The HANDLING SCAM CASES call driver was not used</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt21]"><?php echo $auditData['cmt21']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Followed Correct Eastlink/CSG procedures</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[follow_correct_eastlink]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_eastlink']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['follow_correct_eastlink']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_eastlink']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[follow_correct_eastlink_Fail_reason]" disabled>
												<option value='Did not look up the customer in CSG' <?= ($auditData['follow_correct_eastlink_Fail_reason']=='Did not look up the customer in CSG')?'selected':'' ?>>Did not look up the customer in CSG</option>
												<option value='Did not leave notes in CSG (auto-fail)' <?= ($auditData['follow_correct_eastlink_Fail_reason']=='Did not leave notes in CSG (auto-fail)')?'selected':'' ?>>Did not leave notes in CSG (auto-fail)</option>
												<option value='Did not use the Eastlink template in TechWeb documentation' <?= ($auditData['follow_correct_eastlink_Fail_reason']=='Did not use the Eastlink template in TechWeb documentation')?'selected':'' ?>>Did not use the Eastlink template in TechWeb documentation</option>
												<option value='Asked the transferring Eastlink agent questions that are already answered in CSG' <?= ($auditData['follow_correct_eastlink_Fail_reason']=='Asked the transferring Eastlink agent questions that are already answered in CSG')?'selected':'' ?>>Asked the transferring Eastlink agent questions that are already answered in CSG</option>
												<option value='Did not process the sale at all or incorrectly in CSG' <?= ($auditData['follow_correct_eastlink_Fail_reason']=='Did not process the sale at all or incorrectly in CSG')?'selected':'' ?>>Did not process the sale at all or incorrectly in CSG</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt22]"><?php echo $auditData['cmt22']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Followed Correct Virgin Media Processes</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[follow_correct_virgin_media]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_virgin_media']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['follow_correct_virgin_media']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['follow_correct_virgin_media']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[follow_correct_virgin_media_Fail_reason]" disabled>
												<option value='Did not look up a customer in Launchpad' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='Did not look up a customer in Launchpad')?'selected':'' ?>>Did not look up a customer in Launchpad</option>
												<option value='Asked DPA questions when DPA was already passed' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='Asked DPA questions when DPA was already passed')?'selected':'' ?>>Asked DPA questions when DPA was already passed</option>
												<option value='Did not use SCVe to troubleshoot network issues' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='Did not use SCVe to troubleshoot network issues')?'selected':'' ?>>Did not use SCVe to troubleshoot network issues</option>
												<option value='Transferred customer instead of using Launchpad to reset email password' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='Transferred customer instead of using Launchpad to reset email password')?'selected':'' ?>>Transferred customer instead of using Launchpad to reset email password</option>
												<option value='Did not leave notes in Launchpad for Misdirects' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='Did not leave notes in Launchpad for Misdirects')?'selected':'' ?>>Did not leave notes in Launchpad for Misdirects</option>
												<option value='Did not leave notes in Launchpad for any reason where the customer might/will need any further assistance' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='Did not leave notes in Launchpad for any reason where the customer might/will need any further assistance')?'selected':'' ?>>Did not leave notes in Launchpad for any reason where the customer might/will need any further assistance</option>
												<option value='Did not leave notes in Launchpad when transferring the customer back to broadband' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='Did not leave notes in Launchpad when transferring the customer back to broadband')?'selected':'' ?>>Did not leave notes in Launchpad when transferring the customer back to broadband</option>
												<option value='GDPR- Did not demonstrate a good understanding of GDPR when asked about it' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='GDPR- Did not demonstrate a good understanding of GDPR when asked about it')?'selected':'' ?>>GDPR- Did not demonstrate a good understanding of GDPR when asked about it</option>
												<option value='GDPR- Did not refer the caller to VMs Customer Services or misdirects them to a different team at VM' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='GDPR- Did not refer the caller to VMs Customer Services or misdirects them to a different team at VM')?'selected':'' ?>>GDPR- Did not refer the caller to VM's Customer Services or misdirects them to a different team at VM</option>
												<option value='GDPR- Did not gather the required information' <?= ($auditData['follow_correct_virgin_media_Fail_reason']=='GDPR- Did not gather the required information')?'selected':'' ?>>GDPR- Did not gather the required information</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt23]"><?php echo $auditData['cmt23']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Survey</td>
										<td>10</td>
										<td>
											<select class="form-control scorecalc processprocedure" name="data[survey]" disabled>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['survey']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' pp_score=0 <?php echo $auditData['survey']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' pp_score=10 <?php echo $auditData['survey']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[survey_Fail_reason]" disabled>
												<option value='Did not mention the survey at the end of the call and/or chat' <?= ($auditData['survey_Fail_reason']=='Did not mention the survey at the end of the call and/or chat')?'selected':'' ?>>Did not mention the survey at the end of the call and/or chat</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt24]"><?php echo $auditData['cmt24']; ?></textarea></td>
									</tr>
									<tr>
										<th colspan=3 scope="row" class="scope">Technical Troubleshooting</th>
										<th class="scope">Causes</th>
										<th><input type="text" id="technical_trouble_score" name="data[technical_troubleshooting_score]" class="form-control" value="<?php echo $auditData['technical_troubleshooting_score']; ?>" readonly></th>
									</tr>
									<tr>
										<td class="paddingTop">Technical Probing</td>
										<td>25</td>
										<td>
											<select class="form-control scorecalc techtrouble" name="data[technical_probing]" disabled>
												<option scr_val='3.57' scr_max='3.57' tt_score=25 <?php echo $auditData['technical_probing']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' tt_score=0 <?php echo $auditData['technical_probing']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' tt_score=25 <?php echo $auditData['technical_probing']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[technical_probing_Fail_reason]" disabled>
												<option value='Probing questions did not follow a logical sequence' <?= ($auditData['technical_probing_Fail_reason']=='Probing questions did not follow a logical sequence')?'selected':'' ?>>Probing questions did not follow a logical sequence</option>
												<option value='Making assumptions about issues or root causes that may take the agent down the wrong troubleshooting path' <?= ($auditData['technical_probing_Fail_reason']=='Making assumptions about issues or root causes that may take the agent down the wrong troubleshooting path')?'selected':'' ?>>Making assumptions about issues or root causes that may take the agent down the wrong troubleshooting path</option>
												<option value='Not asking the right questions or enough questions to understand what the problem is' <?= ($auditData['technical_probing_Fail_reason']=='Not asking the right questions or enough questions to understand what the problem is')?'selected':'' ?>>Not asking the right questions or enough questions to understand what the problem is</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt25]"><?php echo $auditData['cmt25']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Provided the most appropriate solution</td>
										<td>25</td>
										<td>
											<select class="form-control scorecalc techtrouble" name="data[provided_appropiate_solution]" disabled>
												<option scr_val='3.57' scr_max='3.57' tt_score=25 <?php echo $auditData['provided_appropiate_solution']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' tt_score=0 <?php echo $auditData['provided_appropiate_solution']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' tt_score=25 <?php echo $auditData['provided_appropiate_solution']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[provided_appropiate_solution_Fail_reason]" disabled>
												<option value='Did not apply the best solution to address the issue' <?= ($auditData['provided_appropiate_solution_Fail_reason']=='Did not apply the best solution to address the issue')?'selected':'' ?>>Did not apply the best solution to address the issue</option>
												<option value='Did not address all issues the caller raised' <?= ($auditData['provided_appropiate_solution_Fail_reason']=='Did not address all issues the caller raised')?'selected':'' ?>>Did not address all issues the caller raised</option>
												<option value='Did not accurately answer technical questions' <?= ($auditData['provided_appropiate_solution_Fail_reason']=='Did not accurately answer technical questions')?'selected':'' ?>>Did not accurately answer technical questions</option>
												<option value='Did not take adequate precautions to avoid data loss (email or data backup for example) when applicable' <?= ($auditData['provided_appropiate_solution_Fail_reason']=='Did not take adequate precautions to avoid data loss (email or data backup for example) when applicable')?'selected':'' ?>>Did not take adequate precautions to avoid data loss (email or data backup for example) when applicable</option>
												<option value='Used an untested or poorly explained or understood risky troubleshooting step- For example: deleting a registry key without understanding why or how it can affect a computer)' <?= ($auditData['provided_appropiate_solution_Fail_reason']=='Used an untested or poorly explained or understood risky troubleshooting step- For example: deleting a registry key without understanding why or how it can affect a computer)')?'selected':'' ?>>Used an untested or poorly explained or understood risky troubleshooting step- For example: deleting a registry key without understanding why or how it can affect a computer)</option>
												<option value='Did not use the right tools for the customers issue' <?= ($auditData['provided_appropiate_solution_Fail_reason']=='Did not use the right tools for the customers issue')?'selected':'' ?>>Did not use the right tools for the customer's issue</option>
												<option value='Did not ask for help if the agent was unable to find a resolution before offering a refund or referring to a 3rd party' <?= ($auditData['provided_appropiate_solution_Fail_reason']=='Did not ask for help if the agent was unable to find a resolution before offering a refund or referring to a 3rd party')?'selected':'' ?>>Did not ask for help if the agent was unable to find a resolution before offering a refund or referring to a 3rd party</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt26]"><?php echo $auditData['cmt26']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Provided relevant supporting documentation</td>
										<td>25</td>
										<td>
											<select class="form-control scorecalc techtrouble" name="data[provided_relevant_support]" disabled>
												<option scr_val='3.57' scr_max='3.57' tt_score=25 <?php echo $auditData['provided_relevant_support']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' tt_score=0 <?php echo $auditData['provided_relevant_support']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' tt_score=25 <?php echo $auditData['provided_relevant_support']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[provided_relevant_support_Fail_reason]" disabled>
											<option value='Required follow-up information was not provided to the customer at the end of the interaction' <?= ($auditData['provided_relevant_support_Fail_reason']=='Required follow-up information was not provided to the customer at the end of the interaction')?'selected':'' ?>>Required follow-up information was not provided to the customer at the end of the interaction</option>
											<option value='Incorrect advice or next steps were provided' <?= ($auditData['provided_relevant_support_Fail_reason']=='Incorrect advice or next steps were provided')?'selected':'' ?>>Incorrect advice or next steps were provided</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt27]"><?php echo $auditData['cmt27']; ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Confirmed satisfactory resolution</td>
										<td>25</td>
										<td>
											<select class="form-control scorecalc techtrouble" name="data[confirm_resolution]" disabled>
												<option scr_val='3.57' scr_max='3.57' tt_score=25 <?php echo $auditData['confirm_resolution']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='3.57' tt_score=0 <?php echo $auditData['confirm_resolution']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='3.57' scr_max='3.57' tt_score=25 <?php echo $auditData['confirm_resolution']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" name="data[confirm_resolutionconfirm_resolution]" disabled>
												<option value='Did not confirm with the customer (whenever possible) if the solution was satisfactory' <?= ($auditData['confirm_resolutionconfirm_resolution']=='Did not confirm with the customer (whenever possible) if the solution was satisfactory')?'selected':'' ?>>Did not confirm with the customer (whenever possible) if the solution was satisfactory</option>
												<option value='Did not address all the customers issues' <?= ($auditData['confirm_resolutionconfirm_resolution']=='Did not address all the customers issues')?'selected':'' ?>>Did not address all the customer's issues</option>
												<option value='Made no attempt to test the solution applied' <?= ($auditData['confirm_resolutionconfirm_resolution']=='Made no attempt to test the solution applied')?'selected':'' ?>>Made no attempt to test the solution applied</option>
												<option value='Failed to give a callback to confirm the solution it was promised ' <?= ($auditData['confirm_resolutionconfirm_resolution']=='Failed to give a callback to confirm the solution it was promised ')?'selected':'' ?>>Failed to give a callback to confirm the solution it was promised </option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt28]"><?php echo $auditData['cmt28']; ?></textarea></td>
									</tr>
									<tr>
										<th colspan=3 scope="row" class="scope">Auto-Fail</th>
										<th class="scope">Remarks</th>
									</tr>
									<tr>
										<td class="paddingTop" style="color:red">Auto Fails Behaviours include, but are not limited to:</br>
										- Hanging up on a customer</br>
										- Swearing/Profanity</br>
										- Purposefully or willfully aggravating or antagonizing a customer- Rude remarks</br>
										- Bullying or making fun of a customer</br>
										- Discrimination of any kind</br>
										- Call dumping or avoidance</td>
										<td>--</td>
										<td>
											<select class="form-control scorecalc" id="apphelpAF1" name="data[autofail]" disabled>
												<option scr_val='0' scr_max='0' <?php echo $auditData['autofail']=="No"?"selected":"No";?> value="No">No</option>
												<option scr_val='0' scr_max='0' <?php echo $auditData['autofail']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option scr_val='0' scr_max='0' <?php echo $auditData['autofail']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt29]"><?php echo $auditData['cmt29']; ?></textarea></td>
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
				<div class="col-sm-12">
					<div class="card mb-4">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Call Summary:</label>
										<textarea class="form-control" autocomplete="off" name="data[call_summary]" disabled><?php echo $auditData['call_summary'] ?></textarea>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Feedback:</label>
										<textarea class="form-control" autocomplete="off" name="data[feedback]" disabled><?php echo $auditData['feedback'] ?></textarea>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Management Review:</label>
										<textarea class="form-control" disabled><?php echo $auditData['mgnt_rvw_note'] ?></textarea>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Client Review:</label>
										<textarea class="form-control" disabled><?php echo $auditData['client_rvw_note'] ?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group ">
										<label for="full_form">Upload Audio File [m4a,mp4,mp3,wav]:</label>
									</div>
								</div>
								<div class="col-sm-10" style="">
									<div class="form-group">
										<?php if ($auditData['attach_file'] != ''){
										$attachfile = explode(",", $auditData['attach_file']);
										foreach ($attachfile as $mp){ ?>
											<audio controls controlsList="nodownload" oncontextmenu="return false;" style="background-color:#607F93">
												<source src="<?php echo base_url(); ?>qa_files/qa_apphelp/<?php echo $mp; ?>" type="audio/ogg">
												<source src="<?php echo base_url(); ?>qa_files/qa_apphelp/<?php echo $mp; ?>" type="audio/mpeg">
												<source src="<?php echo base_url(); ?>qa_files/qa_apphelp/<?php echo $mp; ?>" type="audio/x-m4a">
											</audio>
										<?php }
										}else{
											echo 'No Files Uploaded';
										} ?>
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
						<form id="form_agent_user" method="POST" action="">
							<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label for="full_form">Agent Feedback Status:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="agnt_fd_acpt" required>
											<option value="">--Select--</option>
											<option <?php echo $auditData['agnt_fd_acpt'] == 'Acceptance' ? "selected" : ""; ?> value="Acceptance">Acceptance</option>
											<option <?php echo $auditData['agnt_fd_acpt'] == 'Not Acceptance' ? "selected" : ""; ?> value="Not Acceptance">Not Acceptance</option>
										</select>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="form-group">
										<label for="full_form">Agent Feedback Review:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<textarea class="form-control" name="note" required><?php echo $auditData['agent_rvw_note'] ?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2">
								<?php if(is_access_qa_agent_module()==true){
									if(is_available_qa_feedback($auditData['entry_date'],72) == true){
										if($auditData['agnt_fd_acpt']==''){ ?>
											<button class="btn btn-success waves-effect" id='btnagentSave' name='btnSave' value="SAVE" style="width:200px"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;SAVE</button>
								<?php	}
									}
								} ?>
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
	</section>
</div>
