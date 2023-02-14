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

<?php if($sales_data!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">Ideal Living [SALES]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($sales_data==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($sales_data['entry_by']!=''){
												$auditorName = $sales_data['auditor_name'];
											}else{
												$auditorName = $sales_data['client_name'];
											}
											$auditDate = mysql2mmddyy($sales_data['audit_date']);
											$clDate_val=mysql2mmddyy($sales_data['call_date']);
										}
									?>
									<tr>
										<td>Name of Auditor:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Date of Audit:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td style="width:250px">
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $sales_data['agent_id'] ?>"><?php echo $sales_data['fname']." ".$sales_data['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $sales_data['fusion_id']; ?>" required></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $sales_data['tl_id'] ?>"><?php echo $sales_data['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Product:</td>
										<td>
											<select class="form-control" id="" name="product" required>
												<option value="">-Select-</option>
												<option <?php echo $sales_data['product']=='Better Bladder'?"selected":""; ?> value="Better Bladder">Better Bladder</option>
												<option <?php echo $sales_data['product']=='Paint Zoom'?"selected":""; ?> value="Paint Zoom">Paint Zoom</option>
												<option <?php echo $sales_data['product']=='Paint Zoom Spanish'?"selected":""; ?> value="Paint Zoom Spanish">Paint Zoom Spanish</option>
												<option <?php echo $sales_data['product']=='Profemin'?"selected":""; ?> value="Profemin">Profemin</option>
												<option <?php echo $sales_data['product']=='Prosvent'?"selected":""; ?> value="Prosvent">Prosvent</option>
												<option <?php echo $sales_data['product']=='Rotorazer'?"selected":""; ?> value="Rotorazer">Rotorazer</option>
												<option <?php echo $sales_data['product']=='Rotorazer Spanish LF'?"selected":""; ?> value="Rotorazer Spanish LF">Rotorazer Spanish LF</option>
												<option <?php echo $sales_data['product']=='Rotorazer SpanishSF'?"selected":""; ?> value="Rotorazer SpanishSF">Rotorazer SpanishSF</option>
												<option <?php echo $sales_data['product']=='Walkfit'?"selected":""; ?> value="Walkfit">Walkfit</option>
												<option <?php echo $sales_data['product']=='Superthotics'?"selected":""; ?> value="Superthotics">Superthotics</option>
												<option <?php echo $sales_data['product']=='Prosvent Spanish'?"selected":""; ?> value="Prosvent Spanish">Prosvent Spanish</option>
											</select>
										</td>
										<td>Call Type:</td>
										<td>
											<select class="form-control" id="" name="call_type" required>
												<option value="">-Select-</option>
												<option <?php echo $sales_data['call_type']=='Orders'?"selected":""; ?> value="Orders">Orders</option>
												<option <?php echo $sales_data['call_type']=='Possible Sales'?"selected":""; ?> value="Possible Sales">Possible Sales</option>
												<option <?php echo $sales_data['call_type']=='Non Sales'?"selected":""; ?> value="Non Sales">Non Sales</option>
											</select>
										</td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $sales_data['call_duration']; ?>" required></td>
									</tr>
									<tr>
										<td>QA Type:</td>
										<td>
											<select class="form-control" id="" name="qa_type" required>
												<option value="">-Select-</option>
												<option <?php echo $sales_data['qa_type']=='Regular audits'?"selected":""; ?> value="Regular audits">Regular audits</option>
												<option <?php echo $sales_data['qa_type']=='Verificaction'?"selected":""; ?> value="Verificaction">Verificaction</option>
											</select>
										</td>
										<td>Disposition:</td>
										<td>
											<select class="form-control" id="" name="disposition" required>
												<option value="">-Select-</option>
												<option <?php echo $sales_data['disposition']=='Customer Service'?"selected":""; ?> value="Customer Service">Customer Service</option>
												<option <?php echo $sales_data['disposition']=='Dead Air'?"selected":""; ?> value="Dead Air">Dead Air</option>
												<option <?php echo $sales_data['disposition']=='Dial tone'?"selected":""; ?> value="Dial tone">Dial tone</option>
												<option <?php echo $sales_data['disposition']=='Disconnected Greater 60 Sec'?"selected":""; ?> value="Disconnected Greater 60 Sec">Disconnected Greater 60 Sec</option>
												<option <?php echo $sales_data['disposition']=='Disconnected less 60 Sec'?"selected":""; ?> value="Disconnected less 60 Sec">Disconnected less 60 Sec</option>
												<option <?php echo $sales_data['disposition']=='Does not have check/CC ready'?"selected":""; ?> value="Does not have check/CC ready">Does not have check/CC ready</option>
												<option <?php echo $sales_data['disposition']=='Fax machine'?"selected":""; ?> value="Fax machine">Fax machine</option>
												<option <?php echo $sales_data['disposition']=='Hung Up Mid-Script'?"selected":""; ?> value="Hung Up Mid-Script">Hung Up Mid-Script</option>
												<option <?php echo $sales_data['disposition']=='Language barrier'?"selected":""; ?> value="Language barrier">Language barrier</option>
												<option <?php echo $sales_data['disposition']=='Issue tracking'?"selected":""; ?> value="Issue tracking">Issue tracking</option>
												<option <?php echo $sales_data['disposition']=='Misunderstood offer'?"selected":""; ?> value="Misunderstood offer">Misunderstood offer</option>
												<option <?php echo $sales_data['disposition']=='No Credit Card'?"selected":""; ?> value="No Credit Card">No Credit Card</option>
												<option <?php echo $sales_data['disposition']=='Order'?"selected":""; ?> value="Order">Order</option>
												<option <?php echo $sales_data['disposition']=='Order total too high'?"selected":""; ?> value="Order total too high">Order total too high</option>
												<option <?php echo $sales_data['disposition']=='Prank caller'?"selected":""; ?> value="Prank caller">Prank caller</option>
												<option <?php echo $sales_data['disposition']=='Pre authorization failed'?"selected":""; ?> value="Pre authorization failed">Pre authorization failed</option>
												<option <?php echo $sales_data['disposition']=='Test call OC'?"selected":""; ?> value="Test call OC">Test call OC</option>
												<option <?php echo $sales_data['disposition']=='Unable to Deliver To Requested Country'?"selected":""; ?> value="Unable to Deliver To Requested Country">Unable to Deliver To Requested Country</option>
												<option <?php echo $sales_data['disposition']=='Unable to process Mastercard'?"selected":""; ?> value="Unable to process Mastercard">Unable to process Mastercard</option>
												<option <?php echo $sales_data['disposition']=='Unable to process order Washington DC'?"selected":""; ?> value="Unable to process order Washington DC">Unable to process order Washington DC</option>
												<option <?php echo $sales_data['disposition']=='Wanted More Info'?"selected":""; ?> value="Wanted More Info">Wanted More Info</option>
												<option <?php echo $sales_data['disposition']=='Wrong Number'?"selected":""; ?> value="Wrong Number">Wrong Number</option>
											</select>
										</td>
										<td>Recording ID:</td>
										<td><input type="text" class="form-control" id="" name="recording_id" value="<?php echo $sales_data['recording_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option <?php echo $sales_data['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $sales_data['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $sales_data['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $sales_data['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $sales_data['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
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
												<option <?php echo $sales_data['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $sales_data['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $sales_data['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $sales_data['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $sales_data['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
									<td>Correct Disposition:</td>
										<td>
											<select class="form-control" id="" name="correct_disposition" required>
												<option value="">-Select-</option>
												<option <?php echo $sales_data['correct_disposition']=='Customer Service'?"selected":""; ?> value="Customer Service">Customer Service</option>
												<option <?php echo $sales_data['correct_disposition']=='Dead Air'?"selected":""; ?> value="Dead Air">Dead Air</option>
												<option <?php echo $sales_data['correct_disposition']=='Dial tone'?"selected":""; ?> value="Dial tone">Dial tone</option>
												<option <?php echo $sales_data['correct_disposition']=='Disconnected Greater 60 Sec'?"selected":""; ?> value="Disconnected Greater 60 Sec">Disconnected Greater 60 Sec</option>
												<option <?php echo $sales_data['correct_disposition']=='Disconnected less 60 Sec'?"selected":""; ?> value="Disconnected less 60 Sec">Disconnected less 60 Sec</option>
												<option <?php echo $sales_data['correct_disposition']=='Does not have check/CC ready'?"selected":""; ?> value="Does not have check/CC ready">Does not have check/CC ready</option>
												<option <?php echo $sales_data['correct_disposition']=='Fax machine'?"selected":""; ?> value="Fax machine">Fax machine</option>
												<option <?php echo $sales_data['correct_disposition']=='Hung Up Mid-Script'?"selected":""; ?> value="Hung Up Mid-Script">Hung Up Mid-Script</option>
												<option <?php echo $sales_data['correct_disposition']=='Language barrier'?"selected":""; ?> value="Language barrier">Language barrier</option>
												<option <?php echo $sales_data['correct_disposition']=='Issue tracking'?"selected":""; ?> value="Issue tracking">Issue tracking</option>
												<option <?php echo $sales_data['correct_disposition']=='Misunderstood offer'?"selected":""; ?> value="Misunderstood offer">Misunderstood offer</option>
												<option <?php echo $sales_data['correct_disposition']=='No Credit Card'?"selected":""; ?> value="No Credit Card">No Credit Card</option>
												<option <?php echo $sales_data['correct_disposition']=='Order'?"selected":""; ?> value="Order">Order</option>
												<option <?php echo $sales_data['correct_disposition']=='Order total too high'?"selected":""; ?> value="Order total too high">Order total too high</option>
												<option <?php echo $sales_data['correct_disposition']=='Prank caller'?"selected":""; ?> value="Prank caller">Prank caller</option>
												<option <?php echo $sales_data['correct_disposition']=='Pre authorization failed'?"selected":""; ?> value="Pre authorization failed">Pre authorization failed</option>
												<option <?php echo $sales_data['correct_disposition']=='Test call OC'?"selected":""; ?> value="Test call OC">Test call OC</option>
												<option <?php echo $sales_data['correct_disposition']=='Unable to Deliver To Requested Country'?"selected":""; ?> value="Unable to Deliver To Requested Country">Unable to Deliver To Requested Country</option>
												<option <?php echo $sales_data['correct_disposition']=='Unable to process Mastercard'?"selected":""; ?> value="Unable to process Mastercard">Unable to process Mastercard</option>
												<option <?php echo $sales_data['correct_disposition']=='Unable to process order Washington DC'?"selected":""; ?> value="Unable to process order Washington DC">Unable to process order Washington DC</option>
												<option <?php echo $sales_data['correct_disposition']=='Wanted More Info'?"selected":""; ?> value="Wanted More Info">Wanted More Info</option>
												<option <?php echo $sales_data['correct_disposition']=='Wrong Number'?"selected":""; ?> value="Wrong Number">Wrong Number</option>
											</select>
										</td>
										<td>Can be Automated:</td>
										<td>
											<select class="form-control" id="" name="can_automated" required>
												<option value="">-Select-</option>
												<option <?php echo $sales_data['can_automated']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $sales_data['can_automated']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td style="font-weight:bold">Auto Fail:</td>
										<td>
											<select class="form-control il_point" id="ilsales_AF" name="auto_fail" required>
												<option value="">-Select-</option>
												<option il_val=0 <?php echo $sales_data['auto_fail']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option il_val=0 <?php echo $sales_data['auto_fail']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<tr>
									<td style="text-align:right">Overall Score</td>
										<td><input type="text" readonly class="form-control ilsales_fatal" id="ilSalesScore" name="overall_score" value="<?php echo $sales_data['overall_score']; ?>"></td>
									</tr>
									<tr style="background-color:#AED6F1; font-size:15px; font-weight:bold">
										<td colspan=2>Parameters</td>
										<td colspan=3>Description</td>
										<td>Score</td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#F6DDCC">Sales Skills</td>
										<td>Greeting</td>
										<td colspan=3>Agent greets caller with a happy and friendly voice and tone. Mentions caller's name, the campaign name and lets caller know the call will be recorded</td>
										<td>
											<select class="form-control il_point" id="" name="greeting" required>
												<option il_val=3 <?php echo $sales_data['greeting']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['greeting']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['greeting']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['greeting']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['greeting']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Probing Question</td>
										<td colspan=3>Agent must ask the required probing questions to know the needs and reasons why the caller called to us, we have to let the caller express their needs, so we can  present the offer and highlight the benefits of the product  in a presonalized way in order to adapt the product to customer needs and concerns.</td>
										<td>
											<select class="form-control il_point" id="" name="probing_question" required>
												<option il_val=3 <?php echo $sales_data['probing_question']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['probing_question']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['probing_question']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['probing_question']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['probing_question']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Product Benefit</td>
										<td colspan=3>The agent connects the product benefits to the solutions for the caller based on their needs. Builds the product value beyond price</td>
										<td>
											<select class="form-control il_point" id="" name="product_benefit" required>
												<option il_val=3 <?php echo $sales_data['product_benefit']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['product_benefit']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['product_benefit']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['product_benefit']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['product_benefit']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Closing the Sales</td>
										<td colspan=3>Agent recognizes the signals of purchase and makes closings, these must be with confidence and after mentioning main offer, rebuttals and answer questions</td>
										<td>
											<select class="form-control il_point" id="" name="close_the_sale" required>
												<option il_val=3 <?php echo $sales_data['close_the_sale']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['close_the_sale']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['close_the_sale']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['close_the_sale']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['close_the_sale']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Rebuttals</td>
										<td colspan=3>Agent handles and reads ALL rebuttals and provides a solution, removes obstacles in the way to guide a purchase decision at that time. rebuttals should be based on the needs of the caller</td>
										<td>
											<select class="form-control il_point" id="" name="rebuttals" required>
												<option il_val=3 <?php echo $sales_data['rebuttals']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['rebuttals']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['rebuttals']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['rebuttals']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['rebuttals']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#BFC9CA">Soft Skills</td>
										<td>Rapport / Empathy</td>
										<td colspan=3>Agent builds a personal relationship with the caller like talking to a friend, creates interest and trust. And provides and emotional connection by letting the caller know they understand the caller's feelings</td>
										<td>
											<select class="form-control il_point" id="" name="rapport" required>
												<option il_val=3 <?php echo $sales_data['rapport']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['rapport']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['rapport']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['rapport']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['rapport']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Product Knowledge</td>
										<td colspan=3>The agent is an expert with the product knowledge and FAQ. Answers all questions accurately and educates the caller on the product benefits</td>
										<td>
											<select class="form-control il_point" id="" name="product_knowledge" required>
												<option il_val=3 <?php echo $sales_data['product_knowledge']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['product_knowledge']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['product_knowledge']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['product_knowledge']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['product_knowledge']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Speed / Clarity</td>
										<td colspan=3>The agent speaks with a strong steady speed or pace. Not to Fast and Not to Slow, The agent voice is clear and can be understood throughout the call</td>
										<td>
											<select class="form-control il_point" id="" name="speed_clarity" required>
												<option il_val=3 <?php echo $sales_data['speed_clarity']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['speed_clarity']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['speed_clarity']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['speed_clarity']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['speed_clarity']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Professional ethics / Emotional Intelligence</td>
										<td colspan=3>The agent always respects and listens to the caller, does not interrupt the caller. The agent is honest and ethical. Controls their emotions and is not rude to the caller</td>
										<td>
											<select class="form-control il_point" id="" name="professional_ethics" required>
												<option il_val=3 <?php echo $sales_data['professional_ethics']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['professional_ethics']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['professional_ethics']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['professional_ethics']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['professional_ethics']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Enthusiasm / Passion About Selling</td>
										<td colspan=3>The agent sounds happy, excited and has energy when speaking to the caller. It is easy to see they love their job and selling the product</td>
										<td>
											<select class="form-control il_point" id="" name="passion_selling" required>
												<option il_val=3 <?php echo $sales_data['passion_selling']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['passion_selling']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['passion_selling']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['passion_selling']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['passion_selling']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#A9DFBF">Script Adherence</td>
										<td>Main Offers Compliance</td>
										<td colspan=3>Agent sticks to the script, mentions main offer details and prices and continuities correctly</td>
										<td>
											<select class="form-control il_point" id="" name="main_offers" required>
												<option il_val=3 <?php echo $sales_data['main_offers']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['main_offers']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['main_offers']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['main_offers']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['main_offers']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Upsells Compliance</td>
										<td colspan=3>Agent sticks to the script, mentions upsell details and prices and continuities correctly</td>
										<td>
											<select class="form-control il_point" id="" name="upsell_compliance" required>
												<option il_val=3 <?php echo $sales_data['upsell_compliance']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['upsell_compliance']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['upsell_compliance']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['upsell_compliance']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['upsell_compliance']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Prepays Compliance</td>
										<td colspan=3>Agent reads prepay as scripted, speaks clearly with good pace-not too fast, and gets valid confirmation (Yes, Agree, Ok, etc…)</td>
										<!-- <td>E-Mail Compliance</td>
										<td colspan=3>"Agent ask for E-Mail information and takes this with accuracy</td> -->
										<td>
											<select class="form-control il_point" id="" name="prepays_compliance" required>
												<option il_val=3 <?php echo $sales_data['prepays_compliance']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['prepays_compliance']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['prepays_compliance']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['prepays_compliance']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['prepays_compliance']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Legal Terms / Confirmation Compliance</td>
										<td colspan=3>Agent confirms with  the caller what  they ordered, future charges, legal terms and took data correctly (this must be clear and with good pace)</td>
										<td>
											<select class="form-control il_point" id="" name="legal_terms" required>
												<option il_val=3 <?php echo $sales_data['legal_terms']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['legal_terms']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['legal_terms']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['legal_terms']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['legal_terms']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Third party separation Compliance</td>
										<td colspan=3>Agent correctly separates the sale of the clubs "now completely/totally apart from your order ....follows the script</td>
										<td>
											<select class="form-control il_point" id="" name="third_party_separation" required>
												<option il_val=3 <?php echo $sales_data['third_party_separation']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['third_party_separation']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['third_party_separation']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['third_party_separation']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['third_party_separation']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
								<!-- 	<tr>
										<td rowspan=3 style="background-color:#F9E79F">ABC Process</td>
										<td>Acknowledge</td>
										<td colspan=3>Show the customer that they’re being listened to and that you want to keep talking to them</td>
										<td>
											<select class="form-control il_point" id="" name="acknowledge" required>
												<option il_val=3 <?php echo $sales_data['acknowledge']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['acknowledge']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['acknowledge']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['acknowledge']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['acknowledge']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Build Value</td>
										<td colspan=3>Explain the customer how the product will fulfill their needs and give them a real value of the product</td>
										<td>
											<select class="form-control il_point" id="" name="build_value" required>
												<option il_val=3 <?php echo $sales_data['build_value']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['build_value']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['build_value']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['build_value']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['build_value']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Close the Sale</td>
										<td colspan=3>Always close try to close the sales after answer a customer questions</td>
										<td>
											<select class="form-control il_point" id="" name="sale_close" required>
												<option il_val=3 <?php echo $sales_data['sale_close']=='Awesome'?"selected":""; ?> value="Awesome">Awesome</option>
												<option il_val=2 <?php echo $sales_data['sale_close']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option il_val=1 <?php echo $sales_data['sale_close']=='Action needed'?"selected":""; ?> value="Action needed">Action needed</option>
												<option il_val=0 <?php echo $sales_data['sale_close']=='Absent'?"selected":""; ?> value="Absent">Absent</option>
												<option il_val=0 <?php echo $sales_data['sale_close']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr> -->
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="" name="call_summary"><?php echo $sales_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="" name="feedback"><?php echo $sales_data['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files</td>
										<?php if($sales_data==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($sales_data['attach_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_file = explode(",",$sales_data['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_ideal_living/sales/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ideal_living/sales/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($sales_data!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $sales_data['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $sales_data['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $sales_data['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $sales_data['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($sales_data==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($sales_data['entry_date'],72) == true){ ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
