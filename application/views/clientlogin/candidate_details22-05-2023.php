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
		font-size:13px;
		text-align:center; 
	}
	
</style>

<script src="<?php echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script>

</head>

	
<body>

<div class="wrap">
	<section class="app-content">
		
		<?php foreach($candidate_details as $row): ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						
						<div style="float:right; margin-top:-7px">
							<form id='f1' method="post" action="<?php echo base_url();?>client/candidate_details_pdf/<?php echo $c_id ;?>" target="_blank">
								<button type="submit" class="form-controll btn btn-info" >Dowload PDF</button>
							</form>
						</div>
					</header>
					
					
					
					<div class="widget-body clearfix">
						
						<div class="row">
							<div class="col-md-2">
								<label class='bold'>Full Name:</label>
							</div>
							<div class="col-md-7" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['fname']." ".$row['lname']; ?>
							</div>
							<div class="col-md-1">
								<label class='bold'>DOB:</label>
							</div>
							<div class="col-md-2" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['dob']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-4">
								<label class='bold'>How you came to khow about the vacancy:</label>
							</div>
							
							<?php if($row['hiring_source']!="Existing Emplyee"){ ?>
								<div class="col-md-4" style="float:left; border-bottom:1px solid; min-height:20px">
									<?php echo $row['hiring_source']." (".$row['ref_name'].")"; ?>
								</div>
							<?php }else{ ?>
								<div class="col-md-4" style="float:left; border-bottom:1px solid; min-height:20px">
									<?php echo $row['hiring_source']; ?>
								</div>
							<?php } ?>
						</div></br>
						
						<?php if($row['hiring_source']=="Existing Emplyee"){ ?>
							<div class="row">
								<div class="col-md-2">
									<label class="bold">Ref. Name</label>
								</div>
								<div class="col-md-2" style="float:left; border:1px solid black; min-height:25px">
									<?php echo $row['ref_name']; ?>
								</div>
								<div class="col-md-2">
									<label class="bold">Ref. Department</label>
								</div>
								<div class="col-md-2" style="float:left; border:1px solid black; min-height:25px">
									<?php echo $row['ref_dept']; ?>
								</div>
								<div class="col-md-2">
									<label class="bold">Ref. ID</label>
								</div>
								<div class="col-md-2" style="float:left; border:1px solid black; min-height:25px">
									<?php echo $row['ref_id']; ?>
								</div>
							</div>
						<?php } ?>	</br>
						
						<div class="row">
							<div class="col-md-2">
								<label class='bold'>Parmanent Address:</label>
							</div>
							<div class="col-md-6" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['address']; ?>
							</div>
							<div class="col-md-1">
								<label class='bold'>Email:</label>
							</div>
							<div class="col-md-3" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['email']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-3">
								<label class='bold'>Address for Correspondence:</label>
							</div>
							<div class="col-md-9" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['correspondence_address']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-6">
								<label class='bold'>Contact Nos. (Min. 2 mandetory):</label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class='bold'>Mobile Number(1)</label>
							</div>
							<div class="col-md-2" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['phone']; ?>
							</div>
							<div class="col-md-2">
								<label class='bold'>Alternate Number(2)</label>
							</div>
							<div class="col-md-2" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['alter_phone']; ?>
							</div>
							<div class="col-md-1">
								<label class='bold'>(3)</label>
							</div>
							<div class="col-md-2" style="float:left; border-bottom:1px solid; min-height:20px">
								
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-3">
								<label class='bold'>Member Staying along:</label>
							</div>
							<div class="col-md-3" style="float:left; border-bottom:1px solid; min-height:20px">
								
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class='bold'>Own Conveyance:</label>
							</div>
							<div class="col-md-4" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['conveyance']; ?>
							</div>
							<div class="col-md-2">
								<label class='bold'>Driving Licence:</label>
							</div>
							<div class="col-md-4" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['d_licence']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-3">
								<label class='bold'>Position Applied For:</label>
							</div>
							<div class="col-md-3" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['position_name']; ?>
							</div>
							<div class="col-md-3">
								<label class='bold'>Fresher/Experience:</label>
							</div>
							<div class="col-md-3" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['experience']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-2">
								<label class='bold'>Field of Interest:</label>
							</div>
							<div class="col-md-2" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['interest']; ?>
							</div>
							<div class="col-md-2">
								<label class='bold'>Interest Description:</label>
							</div>
							<div class="col-md-6" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['interest_desc']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-8">
								<label class='bold'>Have you worked with Xplore-Tech / Fusion BPO before? if yes please specify L.W.D & Dept.</label>
							</div>
							<div class="col-md-4" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['past_employee']; ?>
							</div>
						</div></br>
						
						<!--<div class="row">
							<div class="col-md-8">
								<label class='bold'>Do you know anyone in Xplore-Tech / Are you applying through any Xplore-Tech Employee?</label>
							</div>
							<?php 
								/* if($row['ref_name']!="") $anyoneknow="Yes"; 
								else $anyoneknow="No"; */
							?>
							<div class="col-md-1"style="float:left; border-bottom:1px solid; min-height:20px">
								<?php //echo $anyoneknow; ?>
							</div>
						</div>-->
						
						<div class="row">
							<div class="col-md-6">
								<label class='bold'>Have you appeared for interview before? If yes, please specify when?</label>
							</div>
							<div class="col-md-2" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['past_inter_date']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-5">
								<label class='bold'>Are you willing to work in 24x7 service standard?</label>
							</div>
							<div class="col-md-1" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['24_7_service']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-2">
								<label class='bold'>Skill Set Areas:</label>
							</div>
							<div class="col-md-10" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['skill_set']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-12">
								<label class='bold' style="font-size:16px">Educational Details:</label>
								<div class="table-responsive">
									<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
										<thead>
											<tr class='bg-info'>
												<th></th>
												<th>Course Name</th>
												<th>Board / University</th>
												<th>School / University</th>
												<th>Passing Year</th>
												<th>%</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($can_education_details as $ced){ ?>
											<tr>
												<td><?php echo $ced['exam']; ?></td>
												<td><?php echo $ced['specialization']; ?></td>
												<td><?php echo $ced['board_uv']; ?></td>
												<td><?php echo $ced['school_name']; ?></td>
												<td><?php echo $ced['passing_year']; ?></td>
												<td><?php echo $ced['grade_cgpa']; ?></td>
											</tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-2">
								<label class='bold' style="font-size:16px">Family Details:</label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class='bold'>Married:</label>
							</div>
							<div class="col-md-2" style="float:left; border:1px solid black; min-height:25px">
								<?php echo $row['married']; ?>
							</div>
							<div class="col-md-2">
							
							</div>
							<div class="col-md-2">
								<label class='bold'>Home Town:</label>
							</div>
							<div class="col-md-4" style="float:left; border:1px solid black; min-height:25px">
								<?php echo $row['home_town']; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
										<thead>
											<tr class='bg-info'>
												<th></th>
												<th>Name</th>
												<th>Occupation</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($can_family_details as $cfd){ ?>
											<tr>
												<td><?php echo $cfd['relation_type']; ?></td>
												<td><?php echo $cfd['name']; ?></td>
												<td><?php echo $cfd['occupation']; ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>		
						</div></br>
						
						<div class="row">
							<div class="col-md-2">
								<label class='bold'>Total Experience:</label>
							</div>
							<div class="col-md-2" style="float:left; border:1px solid black; min-height:25px">
								<?php echo $row['total_work_exp']; ?>
							</div>
							<div class="col-md-2">
							
							</div>
							<div class="col-md-3">
								<label class='bold'>Notice Period for Joining:</label>
							</div>
							<div class="col-md-3" style="float:left; border:1px solid black; min-height:25px">
								<?php echo $row['notice_period']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-12">
								<label class='bold' style="font-size:16px">Last 3 Organization:</label>
								<div class="table-responsive">
									<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
										<thead>
											<tr class='bg-info'>
												<th>Name</th>
												<th>Designation</th>
												<th>Tenure of Work</th>
												<th>References from Each Organization</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($can_experience_details as $cxd){ ?>
											<tr>
												<td><?php echo $cxd['company_name']; ?></td>
												<td><?php echo $cxd['designation']; ?></td>
												<td><?php echo $cxd['work_exp']; ?></td>
												<td><?php echo $cxd['job_desc']; ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>		
						</div></br>
						
						<div class="row">
							<div class="col-md-4">
								<label class='bold'>Reason for Leaving Job (present/last):</label>
							</div>
							<div class="col-md-4" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['job_leav_reason']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
										<thead>
											<tr class='bg-info'>
												<th>Present Gross</th>
												<th>Present Take Home</th>
												<th>Expected Take Home</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?php echo $row['gross']; ?></td>
												<td><?php echo $row['take_home']; ?></td>
												<td><?php echo $row['expected']; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>		
						</div></br>
						
						<div class="row">
							<div class="col-md-12">
								<label class="bold">References:</label>
								<div class="table-responsive">
									<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
										<thead>
											<tr class='bg-info'>
												<th>(1) Name & Relationship Address & Phone No</th>
												<th>(2) Name & Relationship Address & Phone No</th>
												<th>(3) Name & Relationship Address & Phone No</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?php echo $row['reference_1']; ?></td>
												<td><?php echo $row['reference_2']; ?></td>
												<td><?php echo $row['reference_3']; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>		
						</div></br>
						
						<div class="row">
							<div class="col-md-3">
								<label class='bold'>Any known medical illness:</label>
							</div>
							<div class="col-md-1" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['illness']; ?>
							</div>
							<div class="col-md-3">
								<label class='bold'>Any accidents in past:</label>
							</div>
							<div class="col-md-1" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['accidents']; ?>
							</div>
						</div></br>
						
						<div class="row">
							<div class="col-md-6">
								<label class='bold'>CONFIRMATION REGARDING LEGAL ASSOCIATION:</label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-7">
								<label class='bold'>Any judicial proceeding against you in the court of law? If yes, please give details:</label>
							</div>
							<div class="col-md-5" style="float:left; border-bottom:1px solid; min-height:20px">
								<?php echo $row['legal']; ?>
							</div>
						</div>
						
						
					</div>
				</div>
			</div>
		</div>
									
		<?php endforeach; ?>
		
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