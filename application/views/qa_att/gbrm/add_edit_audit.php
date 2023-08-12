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

<?php if($att_id!=0){
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
					  <div class="card-header"><span class="header"><i class="fa fa-shield fa-rotate-270" aria-hidden="true"></i>AT&T Collection GBRM</span></div>
						<div class="card-body">
							<?php
								if($att_id==0){
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
												if($row['id']==$auditData['agent_id']) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Employee MWP ID:</label>
										<input type="text" id="fusion_id" class="form-control" value="<?php echo $auditData['fusion_id']; ?>" readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">L1/TL Name:</label>
										<input type="hidden" id="tl_id" name="data[tl_id]" class="form-control" value="<?php echo $auditData['tl_id']; ?>">
										<input type="text" id="tl_name" class="form-control" value="<?php echo $auditData['tl_name']; ?>" readonly>
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
										<label for="full_form">Coral Usage:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										 <select class="form-control" name="data[coral_usage]" required>
											<option value="">Select</option>
											<option <?php echo $auditData['coral_usage']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											<option <?php echo $auditData['coral_usage']=="No"?"selected":"";?> value="No">No</option>
											<option <?php echo $auditData['coral_usage']=="N/A"?"selected":"";?> value="N/A">N/A</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								 <div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Violation:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[violation]" required>
											<option value="">Select</option>
											<option <?php echo $auditData['violation']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											<option <?php echo $auditData['violation']=="No"?"selected":"";?> value="No">No</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group ">
										<label for="full_form">Type of Violation:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[violation_type]" required>
											<option value="">Select</option>
											<option value="Authentication" <?php echo $auditData['violation_type']=='Authentication'?"selected":""; ?>>Authentication</option>
											<option value="Call Recording Disclaimer" <?php echo $auditData['violation_type']=='Call Recording Disclaimer'?"selected":""; ?>>Call Recording Disclaimer</option>
											<option value="CPNI" <?php echo $auditData['violation_type']=='CPNI'?"selected":""; ?>>CPNI</option>
											<option value="CBR Disclaimer" <?php echo $auditData['violation_type']=='CBR Disclaimer'?"selected":""; ?>>CBR Disclaimer</option>
											<option value="Required disclosures" <?php echo $auditData['violation_type']=='Required disclosures'?"selected":""; ?>>Required disclosures</option>
											<option value="Documentation" <?php echo $auditData['violation_type']=='Documentation'?"selected":""; ?>>Documentation</option>
											<option value="Added to CX account without permission" <?php echo $auditData['violation_type']=='Added to CX account without permission'?"selected":""; ?>>Added to CX account without permission</option>
											<option value="Vulgar Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call" <?php echo $auditData['violation_type']=='Vulgar Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call'?"selected":""; ?>>Vulgar Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call</option>
											<option value="Derogatory references" <?php echo $auditData['violation_type']=='Derogatory references'?"selected":""; ?>>Derogatory references</option>
											<option value="Rude abusive or discourteous" <?php echo $auditData['violation_type']=='Rude abusive or discourteous'?"selected":""; ?>>Rude abusive or discourteous</option>
											<option value="Flirting or making social engagements" <?php echo $auditData['violation_type']=='Flirting or making social engagements'?"selected":""; ?>>Flirting or making social engagements</option>
											<option value="Hung up" <?php echo $auditData['violation_type']=='Hung up'?"selected":""; ?>>Hung up</option>
											<option value="Blind transferred" <?php echo $auditData['violation_type']=='Blind transferred'?"selected":""; ?>>Blind transferred</option>
											<option value="Intentionally transfer/reassign/redirect the call" <?php echo $auditData['violation_type']=='Intentionally transfer/reassign/redirect the call'?"selected":""; ?>>Intentionally transfer/reassign/redirect the call</option>
											<option value="Intentional disseminating of inaccurate information or troubleshooting steps to release the call" <?php echo $auditData['violation_type']=='Intentional disseminating of inaccurate information or troubleshooting steps to release the call'?"selected":""; ?>>Intentional disseminating of inaccurate information or troubleshooting steps to release the call</option>
											<option value="intentionally ignoring cx from the queue" <?php echo $auditData['violation_type']=='intentionally ignoring cx from the queue'?"selected":""; ?>>intentionally ignoring cx from the queue</option>
											<option value="Camping" <?php echo $auditData['violation_type']=='Camping'?"selected":""; ?>>Camping</option>
											<option value="Hold >4 minutes" <?php echo $auditData['violation_type']=='Hold >4 minutes'?"selected":""; ?>>Hold >4 minutes</option>
											<option value="Was the agent seen retaining collecting accessing and/or using CX information" <?php echo $auditData['violation_type']=='Was the agent seen retaining collecting accessing and/or using CX information'?"selected":""; ?>>Was the agent seen retaining collecting accessing and/or using CX information</option>
											<option value="Falsify AT&T or Cx records" <?php echo $auditData['violation_type']=='Falsify AT&T or Cx records'?"selected":""; ?>>Falsify AT&T or Cx records</option>
											<option value="Misrepresent or misleading" <?php echo $auditData['violation_type']=='Misrepresent or misleading'?"selected":""; ?>>Misrepresent or misleading</option>
											<option value="No Violation" <?php echo $auditData['violation_type']=='No Violation'?"selected":""; ?>>No Violation</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Transfer:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[transfer]" required>
											<option value="">-Select-</option>
											<option value="Valid" <?php echo $auditData['transfer']=='Valid'?"selected":""; ?>>Valid</option>
											<option value="Invalid" <?php echo $auditData['transfer']=='Invalid'?"selected":""; ?>>Invalid</option>
											<option value="N/A" <?php echo $auditData['transfer']=='N/A'?"selected":""; ?>>N/A</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Transfer Department:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[transfer_department]" required>
											<option value="">Select</option>
											<option value="No transfer" <?php echo $auditData['transfer_department']=='No transfer'?"selected":""; ?>>No transfer</option>
											<option value="No Information" <?php echo $auditData['transfer_department']=='No Information'?"selected":""; ?>>No Information</option>
											<option value="DEST_DETAIL_DESC" <?php echo $auditData['transfer_department']=='DEST_DETAIL_DESC'?"selected":""; ?>>DEST_DETAIL_DESC</option>
											<option value="Mobility Business Technical Support" <?php echo $auditData['transfer_department']=='Mobility Business Technical Support'?"selected":""; ?>>Mobility Business Technical Support</option>
											<option value="Business Broadband/Fiber 800-321-2000" <?php echo $auditData['transfer_department']=='Business Broadband/Fiber 800-321-2000'?"selected":""; ?>>Business Broadband/Fiber 800-321-2000</option>
											<option value="Business Care 800-331-0500" <?php echo $auditData['transfer_department']=='Business Care 800-331-0500'?"selected":""; ?>>Business Care 800-331-0500</option>
											<option value="Collections Business" <?php echo $auditData['transfer_department']=='Collections Business'?"selected":""; ?>>Collections Business</option>
											<option value="Language Line" <?php echo $auditData['transfer_department']=='Language Line'?"selected":""; ?>>Language Line</option>
											<option value="Wireline Consumer 800-288-2020" <?php echo $auditData['transfer_department']=='Wireline Consumer 800-288-2020'?"selected":""; ?>>Wireline Consumer 800-288-2020</option>
											<option value="Loyalty Wireline" <?php echo $auditData['transfer_department']=='Loyalty Wireline'?"selected":""; ?>>Loyalty Wireline</option>
											<option value="FirstNet Care 800-574-7000" <?php echo $auditData['transfer_department']=='FirstNet Care 800-574-7000'?"selected":""; ?>>FirstNet Care 800-574-7000</option>
											<option value="Business Wireline POTS Repair 800-247-2020" <?php echo $auditData['transfer_department']=='Business Wireline POTS Repair 800-247-2020'?"selected":""; ?>>Business Wireline POTS Repair 800-247-2020</option>
											<option value="DIRECTV Business Sales 888-200-4388" <?php echo $auditData['transfer_department']=='DIRECTV Business Sales 888-200-4388'?"selected":""; ?>>DIRECTV Business Sales 888-200-4388</option>
											<option value="Tech 360 877-888-7360" <?php echo $auditData['transfer_department']=='Tech 360 877-888-7360'?"selected":""; ?>>Tech 360 877-888-7360</option>
											<option value="MyATT Digital Assistance Center (DAC)" <?php echo $auditData['transfer_department']=='MyATT Digital Assistance Center (DAC)'?"selected":""; ?>>MyATT Digital Assistance Center (DAC)</option>
											<option value="Global Fraud GFMO" <?php echo $auditData['transfer_department']=='Global Fraud GFMO'?"selected":""; ?>>Global Fraud GFMO</option>
											<option value="Loyalty Wireline Spanish" <?php echo $auditData['transfer_department']=='Loyalty Wireline Spanish'?"selected":""; ?>>Loyalty Wireline Spanish</option>
											<option value="Collections Mobility" <?php echo $auditData['transfer_department']=='Collections Mobility'?"selected":""; ?>>Collections Mobility</option>
											<option value="Complex Service" <?php echo $auditData['transfer_department']=='Complex Service'?"selected":""; ?>>Complex Service</option>
											<option value="DIRECTV Consumer Sales 800-347-3288" <?php echo $auditData['transfer_department']=='DIRECTV Consumer Sales 800-347-3288'?"selected":""; ?>>DIRECTV Consumer Sales 800-347-3288</option>
											<option value="Contract Acceptance/Activation Line (Port) 866-895-1099" <?php echo $auditData['transfer_department']=='Contract Acceptance/Activation Line (Port) 866-895-1099'?"selected":""; ?>>Contract Acceptance/Activation Line (Port) 866-895-1099</option>
											<option value="Spanish Business Broadband/Fiber 800-321-2000" <?php echo $auditData['transfer_department']=='Spanish Business Broadband/Fiber 800-321-2000'?"selected":""; ?>>Spanish Business Broadband/Fiber 800-321-2000</option>
											<option value="ATT LD / 800 Direct Bill" <?php echo $auditData['transfer_department']=='ATT LD / 800 Direct Bill'?"selected":""; ?>>ATT LD / 800 Direct Bill</option>
											<option value="Web Solutions: 888-932-4678 ORD/BLG/SUPP/E-FAX" <?php echo $auditData['transfer_department']=='Web Solutions: 888-932-4678 ORD/BLG/SUPP/E-FAX'?"selected":""; ?>>Web Solutions: 888-932-4678 ORD/BLG/SUPP/E-FAX</option>
											<option value="AT&T Wi-Fi Services 888-888-7520" <?php echo $auditData['transfer_department']=='AT&T Wi-Fi Services 888-888-7520'?"selected":""; ?>>AT&T Wi-Fi Services 888-888-7520</option>
											<option value="Payment IVR Business" <?php echo $auditData['transfer_department']=='Payment IVR Business'?"selected":""; ?>>Payment IVR Business</option>
											<option value="IP Flex Repair 877-288-8362" <?php echo $auditData['transfer_department']=='IP Flex Repair 877-288-8362'?"selected":""; ?>>IP Flex Repair 877-288-8362</option>
											<option value="Complex Sales" <?php echo $auditData['transfer_department']=='Complex Sales'?"selected":""; ?>>Complex Sales</option>
											<option value="Convergent Bill" <?php echo $auditData['transfer_department']=='Convergent Bill'?"selected":""; ?>>Convergent Bill</option>
											<option value="Buried Wire Center" <?php echo $auditData['transfer_department']=='Buried Wire Center'?"selected":""; ?>>Buried Wire Center</option>
											<option value="DIRECTV Sales Help Batphone No Customers" <?php echo $auditData['transfer_department']=='DIRECTV Sales Help Batphone No Customers'?"selected":""; ?>>DIRECTV Sales Help Batphone No Customers</option>
											<option value="PayQuick POTS (RETIRED)" <?php echo $auditData['transfer_department']=='PayQuick POTS (RETIRED)'?"selected":""; ?>>PayQuick POTS (RETIRED)</option>
											<option value="Reward Center 866-706-1108" <?php echo $auditData['transfer_department']=='Reward Center 866-706-1108'?"selected":""; ?>>Reward Center 866-706-1108</option>
											<option value="Business Direct 800-221-0000" <?php echo $auditData['transfer_department']=='Business Direct 800-221-0000'?"selected":""; ?>>Business Direct 800-221-0000</option>
											<option value="Spanish Business POTS Repair 800-247-2020" <?php echo $auditData['transfer_department']=='Spanish Business POTS Repair 800-247-2020'?"selected":""; ?>>Spanish Business POTS Repair 800-247-2020</option>
											<option value="Conn Community - Bcomp" <?php echo $auditData['transfer_department']=='Conn Community - Bcomp'?"selected":""; ?>>Conn Community - Bcomp</option>
											<option value="Toll Free Reserv/Order Status" <?php echo $auditData['transfer_department']=='Toll Free Reserv/Order Status'?"selected":""; ?>>Toll Free Reserv/Order Status</option>
											<option value="Collections Spanish" <?php echo $auditData['transfer_department']=='Collections Spanish'?"selected":""; ?>>Collections Spanish</option>
											<option value="ACC Business 800-456-6000" <?php echo $auditData['transfer_department']=='ACC Business 800-456-6000'?"selected":""; ?>>ACC Business 800-456-6000</option>
											<option value="VOIP Port Activation" <?php echo $auditData['transfer_department']=='VOIP Port Activation'?"selected":""; ?>>VOIP Port Activation</option>
											<option value="Survey - English" <?php echo $auditData['transfer_department']=='Survey - English'?"selected":""; ?>>Survey - English</option>
											<option value="Spanish" <?php echo $auditData['transfer_department']=='Spanish'?"selected":""; ?>>Spanish</option>
											<option value="EMERGENCY: 911 Agency Reporting Outage" <?php echo $auditData['transfer_department']=='EMERGENCY: 911 Agency Reporting Outage'?"selected":""; ?>>EMERGENCY: 911 Agency Reporting Outage</option>
											<option value="English" <?php echo $auditData['transfer_department']=='English'?"selected":""; ?>>English</option>
											<option value="CABS Support / Care" <?php echo $auditData['transfer_department']=='CABS Support / Care'?"selected":""; ?>>CABS Support / Care</option>
											<option value="Listing Support Nationwide" <?php echo $auditData['transfer_department']=='Listing Support Nationwide'?"selected":""; ?>>Listing Support Nationwide</option>
											<option value="Unified Messaging Cust Svc 888-300-6500 (Voice Mail)" <?php echo $auditData['transfer_department']=='Unified Messaging Cust Svc 888-300-6500 (Voice Mail)'?"selected":""; ?>>Unified Messaging Cust Svc 888-300-6500 (Voice Mail)</option>
											<option value="Dispatch" <?php echo $auditData['transfer_department']=='Dispatch'?"selected":""; ?>>Dispatch</option>
											<option value="Service Management & LNP" <?php echo $auditData['transfer_department']=='Service Management & LNP'?"selected":""; ?>>Service Management & LNP</option>
											<option value="Cust Work Center/Engineering" <?php echo $auditData['transfer_department']=='Cust Work Center/Engineering'?"selected":""; ?>>Cust Work Center/Engineering</option>
											<option value="Directory Book Orders Nationwide 844-339-6334" <?php echo $auditData['transfer_department']=='Directory Book Orders Nationwide 844-339-6334'?"selected":""; ?>>Directory Book Orders Nationwide 844-339-6334</option>
											<option value="WCC: Credit Verify - All Regions (was NCVC)" <?php echo $auditData['transfer_department']=='WCC: Credit Verify - All Regions (was NCVC)'?"selected":""; ?>>WCC: Credit Verify - All Regions (was NCVC)</option>
											<option value="SPORT SWBT Out of Territory 888-289-7921" <?php echo $auditData['transfer_department']=='SPORT SWBT Out of Territory 888-289-7921'?"selected":""; ?>>SPORT SWBT Out of Territory 888-289-7921</option>
											<option value="Survey - Spanish" <?php echo $auditData['transfer_department']=='Survey - Spanish'?"selected":""; ?>>Survey - Spanish</option>
											<option value="Puerto Rico Wireline BUS ONLY" <?php echo $auditData['transfer_department']=='Puerto Rico Wireline BUS ONLY'?"selected":""; ?>>Puerto Rico Wireline BUS ONLY</option>
											<option value="Collections CABS" <?php echo $auditData['transfer_department']=='Collections CABS'?"selected":""; ?>>Collections CABS</option>
											<option value="Conn Community - Non Bcomp" <?php echo $auditData['transfer_department']=='Conn Community - Non Bcomp'?"selected":""; ?>>Conn Community - Non Bcomp</option>
											<option value="Network Translation Center- DMS 5ESS" <?php echo $auditData['transfer_department']=='Network Translation Center- DMS 5ESS'?"selected":""; ?>>Network Translation Center- DMS 5ESS</option>
											<option value="eRate" <?php echo $auditData['transfer_department']=='eRate'?"selected":""; ?>>eRate</option>
											<option value="Survey - Mandarin" <?php echo $auditData['transfer_department']=='Survey - Mandarin'?"selected":""; ?>>Survey - Mandarin</option>
											<option value="Survey - Cantonese" <?php echo $auditData['transfer_department']=='Survey - Cantonese'?"selected":""; ?>>Survey - Cantonese</option>
											<option value="Survey - Korean" <?php echo $auditData['transfer_department']=='Survey - Korean'?"selected":""; ?>>Survey - Korean</option>
											<option value="Survey - Vietnamese" <?php echo $auditData['transfer_department']=='Survey - Vietnamese'?"selected":""; ?>>Survey - Vietnamese</option>
											<option value="Unified Messaging CVM (for employee VM access)" <?php echo $auditData['transfer_department']=='Unified Messaging CVM (for employee VM access)'?"selected":""; ?>>Unified Messaging CVM (for employee VM access)</option>
											<option value="Business Loyalty" <?php echo $auditData['transfer_department']=='Business Loyalty'?"selected":""; ?>>Business Loyalty</option>
											<option value="Business Wireline Center 800-321-2000" <?php echo $auditData['transfer_department']=='Business Wireline Center 800-321-2000'?"selected":""; ?>>Business Wireline Center 800-321-2000</option>
											<option value="SIM Swap Business" <?php echo $auditData['transfer_department']=='SIM Swap Business'?"selected":""; ?>>SIM Swap Business</option>
											<option value="Port Activation Center (PAC)" <?php echo $auditData['transfer_department']=='Port Activation Center (PAC)'?"selected":""; ?>>Port Activation Center (PAC)</option>
											<option value="FirstNet Technical Support" <?php echo $auditData['transfer_department']=='FirstNet Technical Support'?"selected":""; ?>>FirstNet Technical Support</option>
											<option value="Device Insurance" <?php echo $auditData['transfer_department']=='Device Insurance'?"selected":""; ?>>Device Insurance</option>
											<option value="MyATT Digital Assistance Center (DAC)" <?php echo $auditData['transfer_department']=='MyATT Digital Assistance Center (DAC)'?"selected":""; ?>>MyATT Digital Assistance Center (DAC)</option>
											
											<option value="FirstNet Collections" <?php echo $auditData['transfer_department']=='FirstNet Collections'?"selected":""; ?>>FirstNet Collections</option>
											<option value="Cell Booster Pro/MetroCell Support" <?php echo $auditData['transfer_department']=='Cell Booster Pro/MetroCell Support'?"selected":""; ?>>Cell Booster Pro/MetroCell Support</option>
											<option value="Consumer Spanish" <?php echo $auditData['transfer_department']=='Consumer Spanish'?"selected":""; ?>>Consumer Spanish</option>
											<option value="Consumer Technical Support" <?php echo $auditData['transfer_department']=='Consumer Technical Support'?"selected":""; ?>>Consumer Technical Support</option>
											<option value="Enhanced Care" <?php echo $auditData['transfer_department']=='Enhanced Care'?"selected":""; ?>>Enhanced Care</option>
											<option value="BMTS - Business Mobility Technical Support Spanish" <?php echo $auditData['transfer_department']=='BMTS - Business Mobility Technical Support Spanish'?"selected":""; ?>>BMTS - Business Mobility Technical Support Spanish</option>
											<option value="Apple Support (Apple Company Advisors)" <?php echo $auditData['transfer_department']=='Apple Support (Apple Company Advisors)'?"selected":""; ?>>Apple Support (Apple Company Advisors)</option>
											<option value="Safeguard" <?php echo $auditData['transfer_department']=='Safeguard'?"selected":""; ?>>Safeguard</option>
											<option value="FirstNet Customer Service Spanish" <?php echo $auditData['transfer_department']=='FirstNet Customer Service Spanish'?"selected":""; ?>>FirstNet Customer Service Spanish</option>
											<option value="SIM Swap FirstNet" <?php echo $auditData['transfer_department']=='SIM Swap FirstNet'?"selected":""; ?>>SIM Swap FirstNet</option>
											<option value="BM IoT" <?php echo $auditData['transfer_department']=='BM IoT'?"selected":""; ?>>BM IoT</option>
											<option value="Analyst Review (Credit and Activations)" <?php echo $auditData['transfer_department']=='Analyst Review (Credit and Activations)'?"selected":""; ?>>Analyst Review (Credit and Activations)</option>
											<option value="Payment IVR" <?php echo $auditData['transfer_department']=='Payment IVR'?"selected":""; ?>>Payment IVR</option>
											<option value="Connected Car Support Group" <?php echo $auditData['transfer_department']=='Connected Car Support Group'?"selected":""; ?>>Connected Car Support Group</option>
											<option value="FirstNet Technical Support Sub Paid" <?php echo $auditData['transfer_department']=='FirstNet Technical Support Sub Paid'?"selected":""; ?>>FirstNet Technical Support Sub Paid</option>
											<option value="Retail & Internal Sales Support (*AID)" <?php echo $auditData['transfer_department']=='Retail & Internal Sales Support (*AID)'?"selected":""; ?>>Retail & Internal Sales Support (*AID)</option>
											<option value="FirstNet Enhanced Care Spanish" <?php echo $auditData['transfer_department']=='FirstNet Enhanced Care Spanish'?"selected":""; ?>>FirstNet Enhanced Care Spanish</option>
											<option value="Connected Car BMW Only" <?php echo $auditData['transfer_department']=='Connected Car BMW Only'?"selected":""; ?>>Connected Car BMW Only</option>
											<option value="Connected Car Land Rover Only" <?php echo $auditData['transfer_department']=='Connected Car Land Rover Only'?"selected":""; ?>>Connected Car Land Rover Only</option>
											<option value="Connected Car Jaguar Only" <?php echo $auditData['transfer_department']=='Connected Car Jaguar Only'?"selected":""; ?>>Connected Car Jaguar Only</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">ATTUID:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" autocomplete="off" name="data[attuid]" class="form-control" value="<?php echo $auditData['attuid']; ?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="full_form">Call Duration:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $auditData['call_duration'] ?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">LOB:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[lob]" required>
											<option value="">-Select-</option>
											<option <?php echo $auditData['lob']=='GRBM Boca'?"selected":""; ?> value="GRBM Boca">GRBM Boca</option>
											<option <?php echo $auditData['lob']=='GRBM Jamaiaca'?"selected":""; ?> value="GRBM Jamaiaca">GRBM Jamaiaca</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group search-select">
										<label for="full_form">Audit Category:&nbsp;<span style="font-size:15px;color:red">*</span></label>
										<select class="form-control" name="data[audit_category]" required>
											<option value="">-Select-</option>
											<option value="Quality" <?php echo $auditData['audit_category']=='Quality'?"selected":""; ?>>Quality</option>
											<option value="Compliance" <?php echo $auditData['audit_category']=='Compliance'?"selected":""; ?>>Compliance</option>
											<option value="VID" <?php echo $auditData['audit_category']=='VID'?"selected":""; ?>>VID</option>
											<option value="Short Calls" <?php echo $auditData['audit_category']=='Short Calls'?"selected":""; ?>>Short Calls</option>
											<option value="Transfers" <?php echo $auditData['audit_category']=='Transfers'?"selected":""; ?>>Transfers</option>
											<option value="Customer Abuse" <?php echo $auditData['audit_category']=='Customer Abuse'?"selected":""; ?>>Customer Abuse</option>
											<option value="CXI" <?php echo $auditData['audit_category']=='CXI'?"selected":""; ?>>CXI</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
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
								if($att_id!=0){
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
										<label for="full_form">Predictive CSAT:&nbsp;<span style="font-size:15px;color:red">*</span></label>
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
									<th></th>
									<th>QA Parameter</th>
									<th>Points</th>
									<th>Rating</th>
									<th>Remarks</th>
								</thead>
								<tbody>
									<tr>
										<th scope="row" class="scope" rowspan=17>STANDARD/ REQUIRED QUALITY</th>
										<td class="paddingTop">Greeting</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc" name="data[greeting]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['greeting']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['greeting']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['greeting']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt1]"><?php echo $auditData['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Make it Personal</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc" name="data[make_it_personal]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['make_it_personal']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['make_it_personal']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['make_it_personal']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt2]"><?php echo $auditData['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Acknowledge</td>
										<td>6</td>
										<td>
											<select class="form-control scorecalc" name="data[acknowledge]" required>
												<option scr_val='6' scr_max='6' <?php echo $auditData['acknowledge']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='6' <?php echo $auditData['acknowledge']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['acknowledge']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt3]"><?php echo $auditData['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Empathy</td>
										<td>6</td>
										<td>
											<select class="form-control scorecalc" name="data[empathy]" required>
												<option scr_val='6' scr_max='6' <?php echo $auditData['empathy']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='6' <?php echo $auditData['empathy']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['empathy']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt4]"><?php echo $auditData['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Reassurance</td>
										<td>6</td>
										<td>
											<select class="form-control scorecalc" name="data[reassurance]" required>
												<option scr_val='6' scr_max='6' <?php echo $auditData['reassurance']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='6' <?php echo $auditData['reassurance']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['reassurance']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt5]"><?php echo $auditData['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">CPNI</td>
										<td>7</td>
										<td>
											<select class="form-control scorecalc" name="data[cpni]" required>
												<option scr_val='7' scr_max='7' <?php echo $auditData['cpni']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['cpni']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['cpni']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt6]"><?php echo $auditData['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Positive Scripting/Positive Positioning</td>
										<td>7</td>
										<td>
											<select class="form-control scorecalc" name="data[positive_scripting]" required>
												<option scr_val='7' scr_max='7' <?php echo $auditData['positive_scripting']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['positive_scripting']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['positive_scripting']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt7]"><?php echo $auditData['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Hold & Dead Air</td>
										<td>7</td>
										<td>
											<select class="form-control scorecalc" name="data[hold_dead_air]" required>
												<option scr_val='7' scr_max='7' <?php echo $auditData['hold_dead_air']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['hold_dead_air']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['hold_dead_air']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt8]"><?php echo $auditData['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Transfer Procedures</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc" name="data[transfer_procedure]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['transfer_procedure']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['transfer_procedure']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['transfer_procedure']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt9]"><?php echo $auditData['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Escalation Prevention</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc" name="data[escalation_prevention]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['escalation_prevention']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['escalation_prevention']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['escalation_prevention']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt10]"><?php echo $auditData['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Ownership</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc" name="data[ownership]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['ownership']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['ownership']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['ownership']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt11]"><?php echo $auditData['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Resolution Steps</td>
										<td>7</td>
										<td>
											<select class="form-control scorecalc" name="data[resolution_steps]" required>
												<option scr_val='7' scr_max='7' <?php echo $auditData['resolution_steps']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['resolution_steps']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['resolution_steps']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt12]"><?php echo $auditData['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Resource Utilization</td>
										<td>7</td>
										<td>
											<select class="form-control scorecalc" name="data[resource_utilization]" required>
												<option scr_val='7' scr_max='7' <?php echo $auditData['resource_utilization']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['resource_utilization']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['resource_utilization']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt13]"><?php echo $auditData['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Fully Resolve</td>
										<td>7</td>
										<td>
											<select class="form-control scorecalc" name="data[fully_resolve]" required>
												<option scr_val='7' scr_max='7' <?php echo $auditData['fully_resolve']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['fully_resolve']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['fully_resolve']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt14]"><?php echo $auditData['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Recap</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc" name="data[recap]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['recap']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['recap']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['recap']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt15]"><?php echo $auditData['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Additional Assistance</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc" name="data[aditional_assistance]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['aditional_assistance']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['aditional_assistance']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['aditional_assistance']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt16]"><?php echo $auditData['cmt16'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Proper Closing</td>
										<td>5</td>
										<td>
											<select class="form-control scorecalc" name="data[proper_closing]" required>
												<option scr_val='5' scr_max='5' <?php echo $auditData['proper_closing']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['proper_closing']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['proper_closing']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt17]"><?php echo $auditData['cmt17'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=4 style="background-color:#46D5E9; font-weight:bold">Compliance Score</td>
										<td style="background-color:#46D5E9; font-weight:bold"><input type="text" style="background-color:#46D5E9; font-weight:bold" id="att_compliance_score" name="data[att_compliance_score]" class="form-control" value="<?php echo $auditData['att_compliance_score']; ?>" readonly></td>
									</tr>
									<tr>
										<th scope="row" class="scope" rowspan=21>STANDARD/ REQUIRED COMPLIANCE</th>
										<td class="paddingTop">Authentication</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF1" name="data[authentication]" required>
												<option <?php echo $auditData['authentication']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['authentication']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_1]"><?php echo $auditData['cmt_1'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Call Recording Disclaimer</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF2" name="data[call_recording_disclamer]" required>
												<option <?php echo $auditData['call_recording_disclamer']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['call_recording_disclamer']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_2]"><?php echo $auditData['cmt_2'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">CPNI</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF3" name="data[compliance_cpni]" required>
												<option <?php echo $auditData['compliance_cpni']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['compliance_cpni']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_3]"><?php echo $auditData['cmt_3'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Was the agent seen retaining, collecting, accessing, and/or using CX information</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF4" name="data[agent_seen_retaining]" required>
												<option <?php echo $auditData['agent_seen_retaining']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['agent_seen_retaining']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_4]"><?php echo $auditData['cmt_4'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Required disclosures</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF5" name="data[required_disclosures]" required>
												<option <?php echo $auditData['required_disclosures']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['required_disclosures']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_5]"><?php echo $auditData['cmt_5'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">CBR Disclaimer</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF6" name="data[cbr_disclaimer]" required>
												<option <?php echo $auditData['cbr_disclaimer']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['cbr_disclaimer']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_6]"><?php echo $auditData['cmt_6'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Hold >4 minutes</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF7" name="data[hold_4_min]" required>
												<option <?php echo $auditData['hold_4_min']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['hold_4_min']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_7]"><?php echo $auditData['cmt_7'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Documentation</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF8" name="data[documentation]" required>
												<option <?php echo $auditData['documentation']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['documentation']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_8]"><?php echo $auditData['cmt_8'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Added to CX account without permission</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF9" name="data[added_cx_acount]" required>
												<option <?php echo $auditData['added_cx_acount']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['added_cx_acount']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_9]"><?php echo $auditData['cmt_9'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Vulgar, Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF10" name="data[offensive_language]" required>
												<option <?php echo $auditData['offensive_language']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['offensive_language']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_10]"><?php echo $auditData['cmt_10'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Derogatory references</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF11" name="data[derogatory_reference]" required>
												<option <?php echo $auditData['derogatory_reference']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['derogatory_reference']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_11]"><?php echo $auditData['cmt_11'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Rude, abusive,  or discourteous</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF12" name="data[rude_abusive]" required>
												<option <?php echo $auditData['rude_abusive']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['rude_abusive']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_12]"><?php echo $auditData['cmt_12'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Flirting or making social engagements</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF13" name="data[making_social_engagement]" required>
												<option <?php echo $auditData['making_social_engagement']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['making_social_engagement']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_13]"><?php echo $auditData['cmt_13'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Hung up</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF14" name="data[hung_up]" required>
												<option <?php echo $auditData['hung_up']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['hung_up']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_14]"><?php echo $auditData['cmt_14'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Blind transferred</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF15" name="data[blind_transfer]" required>
												<option <?php echo $auditData['blind_transfer']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['blind_transfer']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_15]"><?php echo $auditData['cmt_15'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Intentionally transfer/reassign/redirect the call</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF16" name="data[intentionally_transfer]" required>
												<option <?php echo $auditData['intentionally_transfer']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['intentionally_transfer']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_16]"><?php echo $auditData['cmt_16'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Intentional disseminating of inaccurate information or troubleshooting steps to release the call</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF17" name="data[intentionally_disseminating]" required>
												<option <?php echo $auditData['intentionally_disseminating']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['intentionally_disseminating']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_17]"><?php echo $auditData['cmt_17'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">intentionally ignoring cx from the queue</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF18" name="data[intentionally_ignoring]" required>
												<option <?php echo $auditData['intentionally_ignoring']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['intentionally_ignoring']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_18]"><?php echo $auditData['cmt_18'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Camping</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF19" name="data[camping]" required>
												<option <?php echo $auditData['camping']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['camping']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_19]"><?php echo $auditData['cmt_19'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Falsify AT&T’s or Cx records</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF20" name="data[falsify_att]" required>
												<option <?php echo $auditData['falsify_att']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['falsify_att']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_20]"><?php echo $auditData['cmt_20'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Misrepresent or misleading</td>
										<td>--</td>
										<td>
											<select class="form-control comp_scorecalc" id="compAF21" name="data[misrepresent]" required>
												<option <?php echo $auditData['misrepresent']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['misrepresent']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt_21]"><?php echo $auditData['cmt_21'] ?></textarea></td>
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
							<?php if($att_id != 0){ ?>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<?php if ($auditData['attach_file'] != ''){
											$auditDataachfile = explode(",", $auditData['attach_file']);
											foreach ($auditDataachfile as $mp){ ?>
												<audio controls='' style="background-color:#607F93">
													<source src="<?php echo base_url(); ?>qa_files/qa_att/gbrm/<?php echo $mp; ?>" type="audio/ogg">
													<source src="<?php echo base_url(); ?>qa_files/qa_att/gbrm/<?php echo $mp; ?>" type="audio/mpeg">
													<source src="<?php echo base_url(); ?>qa_files/qa_att/gbrm/<?php echo $mp; ?>" type="audio/x-m4a">
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
		
		<?php if($att_id!=0){ ?>
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
					<?php if($att_id == 0) {
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
