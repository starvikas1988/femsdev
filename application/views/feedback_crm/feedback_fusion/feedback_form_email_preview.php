<html>
<head></head>
<body>
<div class="survey-main" style="width: 100%;margin: 0 auto;">
			
<?php
$client_name = "Fusion";
$header_name = "Fusion BPO Services - Client Feedback";
if($crm_details['c_client'] == "FUSION"){
	$header_name = "Fusion BPO Services - Client Feedback";
	$client_name = "Fusion";
}
if($crm_details['c_client'] == "OMIND"){
	$header_name = "Omind Technologies - Client Feedback";
	$client_name = "Omind Technologies";
}
if($crm_details['c_client'] == "AD"){
	$header_name = "Ameridial - Client Feedback";
	$client_name = "Ameridial";
}

$brand_name = "Fusion";
if(!empty($crm_details['c_brand'])){ 
	$brand_name = $crm_details['c_brand'];
}
?>			

		    <div class="common-repeat">
				<div class="white-main">
					<div class="survey-content">
						<div class="body-widget">
							
<b>Dear <?php echo $crm_details['c_fname'] ." " .$crm_details['c_lname']; ?>,</b><br/>
<br/><?php echo $client_name; ?> is passionate and committed to improve as your business partner. We very much appreciate if you would take some time to answer the Client Satisfaction Survey found on the link below:
<br/><br/>
Complete the survey now  <b><a href="<?php echo fdcrm_url('feedback/'.$urlForm); ?>"><span>Take the Survey</span></a></b>

<br/><br/>
Would love to hear your feedback/recommendations.<br/>
As always, thank you for the trust and your business.
<br/><br/>						
							
							
						</div>
					</div>
				</div>
			</div>
			
</div>
</body>
</html>