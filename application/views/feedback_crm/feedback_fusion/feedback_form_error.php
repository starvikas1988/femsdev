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
	<form method="POST" action="<?php echo fdcrm_url('feedback_submit'); ?>">
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
							  <h4 style="text-align:center">Something Went Wrong!</h4>
							  <h6 style="text-align:center">Please recheck the link you received.</h6>
							  <p style="text-align:center" ><br/><button onclick="javascript:window.close()" class="button-survey" type="button">The Link is Invalid!</button></p>
							  <br/><br/>
						</div>
					</div>
				</div>
			</div>
		 
			
		</div>
	
	</form>
	</div>
</section>


<script src="<?php echo base_url(); ?>assets/feedback_survey/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/feedback_survey/js/bootstrap.min.js"></script>
</body>
</html>
