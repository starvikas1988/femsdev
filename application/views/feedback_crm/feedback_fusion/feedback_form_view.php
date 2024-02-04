<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo fdcrm_title(); ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/feedback_survey/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/feedback_survey/css/custom.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>


<?php
$client_name = "Fusion";
$header_name = "Fusion BPO Services - Client Feedback";
$header_img = base_url('assets/feedback_survey/images/fusion-bpo.png');
if($crm_details['c_client'] == "FUSION"){
	$header_name = "Fusion BPO Services - Client Feedback";
	$header_img = base_url('assets/feedback_survey/images/fusion-bpo.png');
	$client_name = "Fusion";
}
if($crm_details['c_client'] == "OMIND"){
	$header_name = "Omind Technologies - Client Feedback";
	$header_img = base_url('assets/feedback_survey/images/omind-logo.png');
	$client_name = "Omind";
}
if($crm_details['c_client'] == "AD"){
	$header_name = "Ameridial - Client Feedback";
	$header_img = base_url('assets/feedback_survey/images/ameridial-logo.png');
	$client_name = "Ameridial";
}

$header_image = '<img style="width:150px" src="'.$header_img.'"><br/><br/>';


$brand_name = "Fusion";
if(!empty($crm_details['c_brand'])){ 
	$brand_name = $crm_details['c_brand'];
}
?>

<section id="survey-area" class="survey-area">
	<div class="container">
		<div class="survey-main">
			
			<div class="common-repeat">
				<div class="white-main">
					<div class="blue-bg" style="text-align:center">
						<?php echo $header_image; ?>
						<h2 class="heading-title">
							<?php echo $header_name; ?>
						</h2>
					</div>
					<div class="survey-content">
						<div class="body-widget">
							  <h1 style="text-align:center">&#9786;</h1>
							  <h4 style="text-align:center">Thank you for your valuable feedback!</h4>
							  <h6 style="text-align:center">We appreciate your valuable response & participation!</h6>
							  <p style="text-align:center" ><br/><button ssonclick="javascript:window.close()" class="button-survey" type="button"><i class="fa fa-user"></i> <?php echo $crmDetails['c_email']; ?></button></p>
							  <br/>
						</div>
					</div>
				</div>
			</div>
			
			<?php
			$values = array(
				"customer_training" => "Training Team",
				"customer_quality" => "Quality / Process Team",
				"customer_operations" => "Operations Managers",
				"customer_itteam" => "IT Team",
				"customer_workforce" => "Workforce Management",
			);
			$valuesService = array(
				"solve_training" => "Training Team",
				"solve_quality" => "Quality / Process Team",
				"solve_operations" => "Operations Managers",
				"solve_itteam" => "IT Team",
				"solve_workforce" => "Workforce Management",
			);			
			$options = array(
				"1" => "Strongly Disagree",
				"2" => "Disagree",
				"3" => "Neutral",
				"4" => "Agree",
				"5" => "Strongly Agree",
			);
			$optionsF = array(
				"1" => "Strongly Disagree",
				"2" => "Disagree",
				"3" => "Neutral",
				"4" => "Agree",
				"5" => "Strongly Agree",
				"6" => "N/A",
			);
			?>
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								There is strong collaboration / communication between the following <?php echo $client_name; ?> departments: 
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									  <tr>
										<th></th>
										<th>Strongly Disagree</th>
										<th>Disagree</th>
										<th>Neutral</th>
										<th>Agree</th>
										<th>Strongly Agree</th>
									  </tr>
									</thead>
									<tbody>
									<?php foreach($values as $key=>$token){ ?>
									  <tr>
										<td>
											<?php echo $token; ?>
										</td>
										<?php 
										foreach($optionsF as $keyop=>$tokenOP){
											$checker = "";
											if($crmDetails[$key] == $keyop){ $checker = "checked"; }
										?>
										<td>
											<label class="radio-inline"><input type="radio" value="<?php echo $keyop; ?>" name="<?php echo $key; ?>" <?php echo $checker; ?> disabled><?php //echo $tokenOP; ?></label>
										</td>
										<?php } ?>
									  </tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								The ability of following departments to solve problems, escalations and/or incidents: 
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									  <tr>
										<th></th>
										<th>Strongly Disagree</th>
										<th>Disagree</th>
										<th>Neutral</th>
										<th>Agree</th>
										<th>Strongly Agree</th>
									  </tr>
									</thead>
									<tbody>
									<?php foreach($valuesService as $key=>$token){ ?>
									  <tr>
										<td>
											<?php echo $token; ?>
										</td>
										<?php 
										foreach($optionsF as $keyop=>$tokenOP){
											$checker = "";
											if($crmDetails[$key] == $keyop){ $checker = "checked"; }
										?>
										<td>
											<label class="radio-inline"><input type="radio" value="<?php echo $keyop; ?>" name="<?php echo $key; ?>" <?php echo $checker; ?> disabled><?php //echo $tokenOP; ?></label>
										</td>
										<?php } ?>
									  </tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								Customer Care Associates are well trained.
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									  <tr>
										<th></th>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
										<th></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td>Strongly disagree</td>
										<?php
										$key = "fusion_associate";
										foreach($options as $keyop=>$tokenOP){ 
											$checker = "";
											if($crmDetails[$key] == $keyop){ $checker = "checked"; }
										?>
										<td>
											<label class="radio-inline"><input type="radio" value="<?php echo $keyop; ?>" name="<?php echo $key; ?>" <?php echo $checker; ?> disabled><?php //echo $tokenOP; ?></label>
										</td>
										<?php } ?>
										<td>Strongly Agree</td>
									  </tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								I am very satisfied with <?php echo $client_name; ?> responsiveness to Service Level commitments / staffing requests.
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									  <tr>
										<th></th>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
										<th></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td>Strongly disagree</td>
										<?php
										$key = "fusion_responsiveness";
										foreach($options as $keyop=>$tokenOP){ 
											$checker = "";
											if($crmDetails[$key] == $keyop){ $checker = "checked"; }
										?>
										<td>
											<label class="radio-inline"><input type="radio" value="<?php echo $keyop; ?>" name="<?php echo $key; ?>" <?php echo $checker; ?> disabled><?php //echo $tokenOP; ?></label>
										</td>
										<?php } ?>
										<td>Strongly Agree</td>
									  </tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								I am very statisfied with <?php echo $client_name; ?> contingency plans, responsiveness, and business continuity implementation.
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									  <tr>
										<th></th>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
										<th></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td>Strongly disagree</td>
										<?php
										$key = "fusion_contingency";
										foreach($options as $keyop=>$tokenOP){ 
											$checker = "";
											if($crmDetails[$key] == $keyop){ $checker = "checked"; }
										?>
										<td>
											<label class="radio-inline"><input type="radio" value="<?php echo $keyop; ?>" name="<?php echo $key; ?>" <?php echo $checker; ?> disabled><?php //echo $tokenOP; ?></label>
										</td>
										<?php } ?>
										<td>Strongly Agree</td>
									  </tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								Overall, I am very satisfied with the way <?php echo $client_name; ?> is performing based on <?php echo $brand_name; ?>  targets and goals.
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									   <tr>
										<th></th>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
										<th></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td>Strongly disagree</td>
										<?php
										$key = "fusion_performance";
										foreach($options as $keyop=>$tokenOP){ 
											$checker = "";
											if($crmDetails[$key] == $keyop){ $checker = "checked"; }
										?>
										<td>
											<label class="radio-inline"><input type="radio" value="<?php echo $keyop; ?>" name="<?php echo $key; ?>" <?php echo $checker; ?> disabled><?php //echo $tokenOP; ?></label>
										</td>
										<?php } ?>
										<td>Strongly Agree</td>
									  </tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								How do you feel about the services rendered by <?php echo $client_name; ?> 
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="radio">
								<label>
									<input type="radio" name="optradio" value="1" name="fusion_services" <?php echo $crmDetails['fusion_services'] == 1 ? "checked" : ""; ?> disabled>
									An exceptional value, worth more than we expected
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="optradio" value="2" name="fusion_services" <?php echo $crmDetails['fusion_services'] == 2 ? "checked" : ""; ?> disabled>
									A good value, worth about what we expected
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="optradio" value="3" name="fusion_services" <?php echo $crmDetails['fusion_services'] == 3 ? "checked" : ""; ?> disabled>
									A poor value, worth less than what we expected
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="optradio" value="4" name="fusion_services" <?php echo $crmDetails['fusion_services'] == 4 ? "checked" : ""; ?> disabled>
									Undecided
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								Considering <?php echo $client_name; ?> services and other capabilities, how likely are you to consider us for additional business?
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									  <tr>
										<th></th>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
										<th></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td>Highly Unlikely</td>
										<?php
										$key = "fusion_capabilities";
										foreach($options as $keyop=>$tokenOP){ 
											$checker = "";
											if($crmDetails[$key] == $keyop){ $checker = "checked"; }
										?>
										<td>
											<label class="radio-inline"><input type="radio" value="<?php echo $keyop; ?>" name="<?php echo $key; ?>" <?php echo $checker; ?> disabled><?php //echo $tokenOP; ?></label>
										</td>
										<?php } ?>
										<td>Very Likely</td>
									  </tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="common-repeat">
				<div class="white-main">					
					<div class="survey-content">
						<div class="body-widget">
							<p>
								Comments / Recommendations.
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<textarea class="form-control" id="customer_comments" name="customer_comments" readonly><?php echo !empty($crmDetails['customer_comments']) ? $crmDetails['customer_comments'] : ""; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
</section>


<script src="<?php echo base_url(); ?>assets/feedback_survey/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/feedback_survey/js/bootstrap.min.js"></script>
</body>
</html>
