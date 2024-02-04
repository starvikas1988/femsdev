<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>2FA - <?php echo APP_TITLE;?></ </title>
    <!-- Input:Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700" rel="stylesheet">
    <!-- Input:CSS -->
	<link rel="stylesheet" href="<?php echo base_url()?>libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/2fa_style.css">
	
	<style>
	.navbar{
		position: relative;
		min-height: 80px;
		margin-bottom: 0px;
		border: 1px solid transparent;
	}
	
	.navbar-brand {
		float: left;
		padding: 10px 15px;
		font-size: 18px;
		line-height: 20px;
		height: 72px;
	}
	
	.footer-section{
		position: fixed;
		bottom:0px;
		width:100%;
	}
	
	.d-block {
		display: block !important;
	}
	img {
		vertical-align: middle;
		border-style: none;
	}
	
	
.form__pincode > input {
    width: 13.2%;
}

	</style>
	
    <!-- EndInput -->
</head>
    <body id="page_top" class="body-grass">      
        <!-- HEADER START -->
        <header class="header-section clearfix">
            <!-- Start Navigation -->
            <nav id="mainNav" class="navbar navbar-expand-lg fixed-top hornbill-navbar bg-grass">
                <div class="container">
                    <a class="navbar-brand js-scroll-trigger" href="#page_top">
                        <img src="<?php echo base_url()?>assets/images/logo.png" alt="Fusion-logo">
                    </a>
					
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto hornbill-nav">
                            <li class="nav-item">
                               <!--  <a href="#" class="js-scroll-trigger btn btn-lg btn-circle bg-white hover-glass mr-3">help</a> -->
                            </li>
                        </ul>
                    </div>
					
                </div>
            </nav>
            <!-- End of Navigation -->
        </header>
        <!-- END HEADER -->
			
					
        <!-- MAIN SECTION START -->
        <main class="main-section">
            <!-- Banner Section Start -->
            <section class="banner-section banner-five bg-deep-sky-two  p-top-40 p-bot-90 p-sm-top-100 p-sm-bot-80">
                <div class="container">
					<div class="text-center">
					<?php if($this->session->flashdata('error')!=''): ?>
					<?php echo $this->session->flashdata('error'); ?>
					<?php endif; ?>
					</div>
					
                    <div class="row p-top-30">

                        <!-- End of Banner Right -->
                        <div class="col-lg-8">
                            <div class="banner-left">
                                <h2 class="banner-heading big text-capitalize m-bot-30 fadeInLeft">FEMS Two-Factor </br><span>Authentication</span></h2>
                                <p class="mini-heading m-bot-50 mr-lg-5 fadeInLeft">Please check your inbox. If it is not there, please check your spam mail folder and if it is in the spam mail folder, remember to mark the email as 'not spam'. </p>  
                            </div>
                        </div>
                        <!-- End of banner-left -->
                        <div class="col-lg-4 m-sm-top-0 m-sm-bot-0 fadeIn">
                            <div class="two-factor-authentication-form">
							
                                <form id="2faform" method="post" data-toggle="validator">
								  						  
                                    <h4 class="text-center">Two-Factor Authentication</h4>
                                    <p class="text-center mb-2">Enter 6-digit code sent to your email(s)</p>
									
                                   	<b class="text-center d-block"></</b>
									<b class="text-center d-block"><?php echo $email_id_per;?> <br> <?php echo $email_id_off;?></b>
									
                                    <img class="text-center d-block" src="<?php echo base_url()?>assets/images/open-envelope-icon.png" alt="Open-Envelope-Icon">
                                    <div class="form__group form__pincode">
									
                                        <input type="text" name="vcode[]" maxlength="1" pattern="[\d]*" tabindex="1" placeholder="·" autocomplete="off" required>
                                        <input type="text" name="vcode[]" maxlength="1" pattern="[\d]*" tabindex="2" placeholder="·" autocomplete="off" required>
                                        <input type="text" name="vcode[]" maxlength="1" pattern="[\d]*" tabindex="3" placeholder="·" autocomplete="off" required>
                                        <input type="text" name="vcode[]" maxlength="1" pattern="[\d]*" tabindex="4" placeholder="·" autocomplete="off" required>
                                        <input type="text" name="vcode[]" maxlength="1" pattern="[\d]*" tabindex="5" placeholder="·" autocomplete="off" required>
                                        <input type="text" name="vcode[]" maxlength="1" pattern="[\d]*" tabindex="6" placeholder="·" autocomplete="off" required>
									                                       
                                    </div>
									
                                    <div class="form__buttons">
										<button type="submit" name='submit' value='submit' class="btn btn-primary">Continue</button>
                                    </div>
                                </form>
								
								 <div class="d-block pt-3 text-center">
									<button type="button" class="btn btn-link ResendCode">Resend code</button>
								</div>
							
                            </div>
							 
                        </div>
                    </div>
                </div>
            </section>
            <!-- END of Banner Section -->
        </main>
        <!-- END MAIN SECTION -->

            
        <!-- FOOTER START -->
        <footer class="footer-section bg-lighter">
           
            <div class="row">
			<h6 class="text-center">
				&copy; 2020 Fusion BPO Services || All rights reserved.
			</h6>
                        
            
           </div>
				
            <!-- End of footer bottom -->
        </footer>
        <!-- END FOOTER -->

        <!-- EndInput -->
		<!-- <script src="<?php //echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script> -->
		<script src="<?php echo base_url() ?>libs/jquery/jquery-3.5.1.js"></script>
		
		<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>
		<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/bootstrap.validator.min.js"></script>
		
	<script type="text/javascript">
		$(function () {
			
			// main form
			  var $form = $('#2faform');
			  
			  // pincode group
			  var $group = $form.find('.form__pincode');
				// all input fields
			  var $inputs = $group.find(':input');
			  
			   $inputs .on('keydown', function(event) {
					var code = event.keyCode || event.which;
					if(code == 8){
						var index = $inputs.index(this)
					  , prev = index - 1
					  , next = index + 1;
					  
						$inputs.eq(index).val('');
						if (prev >= 0) {
							$inputs.eq(prev).focus();
		  
						}
					}
				
			   });
			   
			 $inputs .on('keyup', function(event) {
				var code = event.keyCode || event.which;				
				if((code >= 48 && code <= 57) || (code >= 96 && code <= 105) ) { //0-9 only
				  var index = $inputs.index(this)
				  , prev = index - 1
				  , next = index + 1;
        
				// focus to next field
				if (prev < 8) {
				  $inputs.eq(next).focus();
				}
		
				}
				
			;})
						
			$(".ResendCode").click(function(){
			  $.post("<?php echo base_url() ?>resend2facode", function(data, status){
				if(data==1) alert("Successfully sent. Please check your inbox.");
				else alert("Fail to sent email. Try again");
				
			  });
			});
	
		});
		
	</script>
    </body>
</html>
