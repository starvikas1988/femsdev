<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>Login - <?php echo APP_TITLE;?></title>
	<meta name="description" content="Login" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="<?php echo base_url()?>libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/app.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

	<style>	
		.simple-page {
		    background-image: url("<?php echo base_url(); ?>assets/images/emp111.jpg");
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>
	
</head>
<body class="simple-page">
	<div id="back-to-home">
		<!--<img src="assets/images/fusion.png" border="0" alt="Fusion BPO" width="138" height="85">-->
	</div>
	</br> </br>
		<div class="simple-page-logo animated swing">
			<a href="#">
				
				<span style="color:black; font-size:30px"><b><?php echo APP_TITLE;?></b></span>
			</a>
		</div><!-- logo -->
		
	<div class="simple-page-wrap" style="width:700px;">
		
		
		<div>
		<br>
		<br>
		<br>
		<div role="tabpanel" class="tab-pane  in active fade" id="layouts">
					
					<div class="row">
					
						<div class="col-md-6">
							<div class="panel panel-inverse">
								<div class="panel-heading">
									<h4 class="panel-title"><strong>Fusion Employee</strong></h4>
								</div>
								
								<div class="panel-footer">
									<a href="<?php echo base_url()?>login"><button class="btn btn-sm btn-primary">Login &raquo;</button></a>
								</div>
							</div>
						</div><!-- END column -->
						
						<div class="col-md-6">
							<div class="panel panel-inverse">
								<div class="panel-heading">
									<h4 class="panel-title"><strong>Client</strong></h4>
								</div>
								
								<div class="panel-footer">
									<a href="<?php echo base_url()?>client"><button class="btn btn-sm btn-info">Login &raquo;</button></a>
								</div>
								
							</div>
						</div><!-- END column -->
						
						
					</div><!-- .row -->
				</div><!-- .tab-pane -->
		
		
		
		</div>
		<br>
		<br>
		<div class="simple-page-footer">
			<p>
				<small style="color:black"><b>&copy; <?php echo date("Y");?> Fusion BPO Services</b></small>
			</p>
		</div><!-- .simple-page-footer -->


	</div><!-- .simple-page-wrap -->
</body>

</html>