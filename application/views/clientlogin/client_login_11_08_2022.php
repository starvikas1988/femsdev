<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	?>
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
		    /*background-image: url("<?php echo base_url(); ?>assets/images/emp111.jpg");*/
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>
	
</head>
<body class="simple-page">
	<div id="back-to-home">
		<!--<img src="assets/images/fusion.png" border="0" alt="Fusion BPO" width="138" height="85">-->
	</div>
	</br>
		<div class="simple-page-logo animated swing">
			<a href="#">
				
				<span style="color:black; font-size:30px"><b>CLIENT LOGIN</b></span>
			</a>
		</div><!-- logo -->
		
	<div class="simple-page-wrap">
		
		
		<?php if($this->session->flashdata('error')!=''): ?>
		<?php echo $this->session->flashdata('error'); ?>
		<?php endif; ?>
		
		
		
		<div class="simple-page-form animated flipInY" id="login-form">
			<h4 class="form-title m-b-xl text-center">Sign In with your Email ID & Password</h4>
			<?php echo form_open(base_url()."clientlogin/clientAuth") ?>
			
				<div class="form-group">
				 <input type="hidden" name="csrf_token" value="<?php echo $csrf_token;?>"  />
					<input id="" type="text" class="form-control" placeholder="Enter Your Email ID" name="omuid" autocomplete="off" >
				</div>

				<div class="form-group">
					<input id="sign-in-password" type="password" class="form-control" placeholder="Password" name="passwd" autocomplete="off">
				</div>
				
				<div class="form-group m-b-xl">
					<div class="checkbox checkbox-primary">
						<input type="checkbox" id="keep_me_logged_in"/>
						<label for="keep_me_logged_in">Keep me signed in</label>
						<div style="text-align: right;"><a style="padding-left:20px;color: #92ccce;font-family: tahoma;" href="<?php echo base_url('forgot_password'); ?>">Forgot Password</a></div>
					</div>
				</div>
				<input type="submit" class="btn btn-success" value="SIGN IN" name="submit">
		
			</form>
		</div><!-- #login-form -->

		<div class="simple-page-footer">
			<p>
				<small style="color:black"><b>&copy; <?php echo date("Y");?> Omind Technologies Private Limited</b></small>
			</p>
		</div><!-- .simple-page-footer -->


	</div><!-- .simple-page-wrap -->
</body>

</html>