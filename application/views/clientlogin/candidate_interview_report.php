<?php 

/*---------------------------------------------------------------------------------------

Check The current URL and moniter the links,

If the session is on then a user can jump between the three dashboards irrespective of the 
session he is logged in. In order to stop that the below is written, which will check the change 
in URL and and search for admin, agent and coach keywords present in the url. Then based on the 
keywords will assign a 404 error page. 

----------------------------------------------------------------------------------------*/

is_valid_session_url();



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo APP_TITLE;?></title>
	
	<?php
	header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
	header( 'Cache-Control: post-check=0, pre-check=0', false ); 
	header( 'Pragma: no-cache' ); 
	?>

	<meta name="description" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css ../assets/css/app.min.css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.min.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui-timepicker.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/app.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/uploadfile.css"/>

<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:5px;
		font-size:11px;
		border: 1px solid #E2E2E2;
	}
		
</style>

<script src="<?php echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script>

</head>

	
<body>

	<div class="wrap">
				<section class="app-content">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title" align="center">INTERVIEW ASSESSMENT FORM</h4>
									
								<div style="float:right; margin-top:-25px; margin-right:20px">
									<form id='f1' method="post" action="<?php echo base_url();?>client/interview_pdf/<?php echo $c_id ;?>" target="_blank">
										<button type="submit" class="form-controll btn btn-info" >Dowload PDF</button>
									</form>
								</div>
							
								</header>
								<hr class="widget-separator">
								
								<div class="widget-body">
									<div class="row">
										<div class="col-md-6">
											<h6><b>NAME OF THE APPLICATNT :</b> <?php echo strtoupper($candidate_details[0]['name']) ; ?></h6>
										</div>
										<div class="col-md-6">
											<h6><b>POSITION APPLIED FOR :</b> <?php echo $candidate_details[0]['dept']; ?></h6>
										</div> 
									</div>
									<div class="row">
										<div class="col-md-6">
											<h6><b>INTERVIEWER'S NAME :</b> </h6>
										</div>
										<div class="col-md-6">
											<h6><b>DATE & VENUE  :</b> </h6>
										</div>
										
									</div>
								</div>
								
							</div>
						</div>	
					</div>
				</section>
	
				<section class="app-content">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title">Manage Requisition</h4>
								</header>
								<hr class="widget-separator">
								
								<div class="widget-body">
								
									<div class="table-responsive">
										<table id="default-datatable" style="display:table; width:100%;" data-plugin="DataTable" class="table table-striped " cellspacing="0">
										
									<?php 
									
										$Params = array('Parameter','Education Training','Job Knowledge','Work Experience','Analytical Skill','Technical 	skill','General Awerness','Personality/Body language','Comfortable With english','MTI','Enthusiasm','Leader ship skill','Importance to customer','Motivation for the Job','Result/Target Orientation', 'Logic/Convinencing Power','Initative','Assertiveness','Decision making','Over all Assesment','Remarks','Interviewer');
										
										$fldArray = array('parameter','educationtraining_param','jobknowledge_param','workexperience_param','analyticalskills_param','technicalskills_param','generalawareness_param','bodylanguage_param','englishcomfortable_param','mti_param','enthusiasm_param','leadershipskills_param','customerimportance_param','jobmotivation_param','resultoriented_param','logicpower_param','initiative_param','assertiveness_param','decisionmaking_param','overall_assessment','interview_remarks','interviewer');
																				
										foreach($fldArray as $i => $fild){
											
											echo "<tr>";
												if($i==0) echo "<td style='width:200px; background-color: #35b8e0; color: #fff;' >".$Params[$i]."</td>";
												else echo "<td style='width:200px; ' >".$Params[$i]."</td>";
												foreach($candidate_interview_details as $row){
													if($i==0) echo "<td style='display:table-cell; max-width:0px; text-align: center; background-color: #35b8e0; color: #fff;' >".$row[$fild]."</td>";
													else echo "<td style='display:table-cell; max-width:0px; text-align: center;'>".$row[$fild]."</td>";
												}									
											echo "</tr>"; 
										}
										
									?>
										
											
											
										</table>
									</div>
								</div>
								
							</div>
						</div>	
					</div>
				</section>
	
				<section class="app-content">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title" align="center">For HRD Purpose Only</h4>
								</header>
								<hr class="widget-separator">
								<div class="widget-body">
									<div class="table-responsive">
										<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
										
											<thead>	 
											</thead>
											<tbody>
												<tr>
													<td style="width:150px;">Site</td>
													<td style="background-color:white"></td>
													<td style="width:150px;">Reporting To</td>
													<td style="background-color:white"></td>
												<tr>
												<tr>
													<td style="width:150px;">Process</td>
													<td style="background-color:white"></td>
													<td style="width:150px;">D.O.J</td>
													<td style="background-color:white"></td>
												<tr>
												<tr>
													<td style="width:150px;">Designation</td>
													<td style="background-color:white"></td>
													<td style="width:150px;">Gross Salary Offered</td>
													<td style="background-color:white"></td>
												<tr>
											</tbody>
										</table>
									</div>
								
								</div>
							</div>	
						</div>
					</div>
				</section>
				
				<section class="app-content">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title" align="center">For HRD Purpose Only</h4>
								</header>
								<hr class="widget-separator">
								<div class="widget-body">
									<div class="table-responsive">
										<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
										
											<thead>	 
											</thead>
											<tbody>
												<tr>
													<td style="width:150px; height:150px">Remarks By Recuriter:</td>
													<td style="background-color:white"></td>
												<tr>
												<tr>
													<td style="width:150px;">Date:</td>
													<td style="background-color:white">Signature:</td>
												<tr>
											</tbody>
										</table>
									</div>
								
								</div>
							</div>	
						</div>
					</div>
				</section>
				
	</div>
 
 <!-- build:js ../assets/js/core.min.js -->
	
	<script src="<?php echo base_url() ?>libs/bower/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/superfish/dist/js/hoverIntent.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/superfish/dist/js/superfish.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/PACE/pace.min.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/select2.full.min.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.maskedinput.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-number-input.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap.validator.min.js"></script>
	
	<!-- endbuild -->

	<!-- build:js ../assets/js/app.min.js -->
	<script src="<?php echo base_url() ?>assets/js/library.js"></script>
	<script src="<?php echo base_url() ?>assets/js/plugins.js"></script>
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>
	<!-- endbuild -->
			
	<script src="<?php echo base_url() ?>libs/bower/moment/moment.js"></script>	
	<script src="<?php echo base_url() ?>assets/js/fullcalendar.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.uploadfile.js"></script>
	<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>
	
	<?php //include_once 'jscripts.php' ?>
	
	
</body>
</html>	
