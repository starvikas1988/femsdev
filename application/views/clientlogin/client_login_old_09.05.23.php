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
		/* start message area css here 11.10.2022
		body.simple-page {
			padding-top:0;
		}
		.message_area {
			position:fixed;
			bottom:0;
			width:100%;
			padding:10px 0;
			background:rgba(0,0,0,0.2)
		}
		.message_area .container {
			width:900px;
			margin:0 auto;
			max-width:100%;
		}
		.content {
			font-size:16px;
			padding:0;
			margin:0;
			color:#fff;
			height: 30px;
			display: flex;
			align-items: center;
		}end message area css here 11.10.2022*/

		/* start message area css here 12.08.2022*/
	body.simple-page {
		padding-top:0;
	}
	body {
		overflow-x:hidden;
	}
	.msg_box {
		width: 100%;
		height: auto;
		margin: 1em auto;
		overflow: hidden;
		background: white;
		position: relative;
		box-sizing: border-box;
		text-align: justify;
	}
	.marquee {
		/* top: 6em; */
		position: relative;
		box-sizing: border-box;
		animation: marquee 15s linear infinite;
	}
	.marquee:hover {
		animation-play-state: paused;
	}
	/* @keyframes marquee {
		0%   { top:   8em }
		100% { top: -11em }
	} */
	.microsoft .marquee {
		margin: 0;
		padding:0;
		line-height: 1.5em;		
		letter-spacing:1px;
	}

	.microsoft:before, .microsoft::before,
	.microsoft:after,  .microsoft::after {
		left: 0;
		z-index: 1;
		content: '';
		position: absolute;
		pointer-events: none;
		width: 100%; height: 2em;
		background-image: linear-gradient(180deg, #FFF, rgba(255,255,255,0));
	}

	.microsoft:after, .microsoft::after {
		bottom: 0;
		transform: rotate(180deg);
	}

	.microsoft:before, .microsoft::before {
		top: 0;
	}
	.msg_box p {
		color:#000!important;
		font-size:14px;
		padding:0 0 10px 0;
		margin:0;
	}
	.msg_box p span {
		color:#000;
		background:yellow;
		font-weight:bold;
	}
	.no_padding {
		padding:10px;
		margin: -15px 0 10px 0;
	}
	/* end message area css here 12.08.2022*/

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

		<!--start message area html elements here 12.08.2022-->
		<!--<div class="simple-page-form animated flipInY no_padding">
			<div class="msg_box">
				<div class="marquee">
					<p><strong>Dear All,</strong></p>
					<p>This is to keep you posted that MWP will be down from <span><br /><strong>
28TH AUGUST 2022, 6AM IST [27TH AUGUST 2022, 08:30PM EST]</strong><br />TO<br /><strong>
29TH AUGUST 2022, 10AM IST [29TH AUGUST 2022, 00:30PM EST]</strong></span><br /> due to server migration.Your inconvenience is highly regretted.</p>
					
					<p><strong>Regards,<br>MWP Team</strong></p>	
				</div>					
			</div>
		</div>-->
		<!--end message area html elements here 12.08.2022-->

		<div class="simple-page-footer">
			<p>
				<small style="color:black"><b>&copy; <?php echo date("Y");?> Omind Technologies Private Limited</b></small>
			</p>
		</div><!-- .simple-page-footer -->


	</div><!-- .simple-page-wrap -->

	<!--start message area html elements here 11.10.2022-->
	<!-- <div class="message_area">
		<div class="container">
			<div class="content">
				<marquee direction="left">
				<strong><i>Dear All, This is to keep you posted that MWP will be down from 13TH AUG 6:30PM IST TO 15TH AUG 10AM IST 13TH AUG 09:00AM EST TO 15TH AUG 12:30AM EST due to server migration. Your inconvenience is highly regretted. Regards, MWP Team</i></strong>
				</marquee>
			</div>
		</div>
	</div> -->
	<!--end message area html elements here 11.10.2022-->
</body>

</html>