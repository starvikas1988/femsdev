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
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/applogin.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/responsive.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	<link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

	<style>
				
		body.simple-page{
			background-image:url(<?php echo base_url(); ?>assets/home_bgimages/back2.jpg);
		}
		
		.alert.alert-danger {
			font-size: 1.1rem;
			padding: 2px;
			margin-top: 10px;
			margin-bottom: 0px;
			display: inline-block;
			width: 100%;
			font-family: 'Raleway',sans-serif!important;
			line-height: 20px;
			background: transparent;
			border: 0;
		}
		
		.close {
			line-height: .6;
		}
		
		.form-group .control-label {
			position: absolute;
			top: -1rem;
		}
		
		input:disabled {
			background: #dddddd;
		}
		
	</style>
</head>

			<?php
				//echo " >> ". getCurrTimeDiffInMinute('2020-04-06 01:48:55');
			?>

<body class="simple-page">
	<div class="outer-slider">
	
		<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
			<div class="carousel-inner carousel-zoom carousel-fade">
				<div class="item active">
          			<img class="img-responsive" src="<?php echo base_url(); ?>assets/home_bgimages/back5.jpg" alt="">
				</div>
			   	<div class="item">
			   		<img class="img-responsive" src="<?php echo base_url(); ?>assets/home_bgimages/back4.jpg" alt="">
				</div>
				<div class="item">
					<img class="img-responsive" src="<?php echo base_url(); ?>assets/home_bgimages/back3.jpg" alt="">
				</div>
				<div class="item">
					<img class="img-responsive" src="<?php echo base_url(); ?>assets/home_bgimages/back2.jpg" alt="">
				</div>
			</div>
		</div>


	</div>
	<div class="login-section">
	
		<div class="main-box">
			<div class="slider-cont">  
				<div class="fusion-logo">
		    		<!--<img src="<?php echo base_url(); ?>assets/home_bgimages/fusion-original-transparent.png" alt="fusion-logo">-->
		    		<!--<img src="<?php echo base_url(); ?>assets/home_bgimages/omind_purity.png" alt="fusion-logo">-->
		    	</div>
				<!--<div class='client-login'>
					<a href="<?php echo base_url()?>clientlogin"><button class="btn btn-sm btn-info">Client Login &raquo;</button></a>
				</div>-->
			</div>
		  	<div class="form-cont" style="width:100%">  
							
					<div class="logo-image text-center" style="margin-top:12px">
						<img style="width:40%" src="<?php echo base_url(); ?>assets/home_bgimages/fusion-original-transparent.png" alt="fusion-logo">
					</div>
					
			    <div class="form form-signin" style="width:85%; margin:0 auto">
									
					<div class="form-header">					
					<h3>
					<?php
						$isdisabled="";
						$mobMsg="";

						if($this->agent->is_mobile()){
							
							$isdisabled="disabled";	
							$mobMsg="<strong>Info!</strong>  FEMS is not accessible through mobile";
						
							echo'<div class="alert alert-danger">';
							echo $mobMsg;
							echo '</div>';
							
						}
						
					?>
					</h3>
					
					<h3>
						<?php 
						echo APP_TITLE; ?>
					</h3>
					
					<?php if($this->session->flashdata('error')!=''): ?>
					<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
					<?php endif; ?>
						
		            </div>
				    
					
					<form method="post" action="<?php echo base_url()."forgot_password/verify_otp" ?>">
				    	<input type="hidden" name="otp_fid" id="otp_fid" value="<?php echo $email_id; ?>">
				    	<div class="row">
				    		<div class="col-md-12">
								<label>Enter OTP</label>
								<input class="form-control" type="text" name="otp" id="otp" value="" autocomplete="off" >
							</div>
							
							<div class="button-container">
							    <input type="submit" class="button" name="submit" value="Submit"></input>
							</div>
				    	</div>
	  				</form>
					

	  				<div class="footer-copyright">
				    	<span>&copy; <?php echo date("Y");?> Omind Technologies</span>
				    </div>
			    </div>
		  	</div>
		</div>
	</div>
</body>


<!-- <script src="<?php //echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script> -->
<script src="<?php echo base_url() ?>libs/jquery/jquery-3.5.1.js"></script>

<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/login.js"></script>


<script type="text/javascript">	

	$(document).on('submit','.chckFusion',function(e){
		e.preventDefault();
			$.ajax({
				   type: 'POST',    
				   url: baseURL+'forgot_password/change_password',
				   data:$('form.chckFusion').serialize(),
				   success: function(msg){
						var alrt = JSON.parse(msg);
						   if(alrt.status == true){
						   		
						   }

					}
			});


	});


function getUserLocalIP(onNewIP) { //  onNewIp - your listener function for new IPs

    //compatibility for firefox and chrome
    var myPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
    var pc = new myPeerConnection({
        iceServers: []
    }),
    noop = function() {},
    localIPs = {},
    ipRegex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/g,
    key;

    function iterateIP(ip) {
        if (!localIPs[ip]) onNewIP(ip);
        localIPs[ip] = true;
    }

     //create a bogus data channel
    pc.createDataChannel("");

    // create offer and set local description
    pc.createOffer(function(sdp) {
        sdp.sdp.split('\n').forEach(function(line) {
            if (line.indexOf('candidate') < 0) return;
            line.match(ipRegex).forEach(iterateIP);
        });
        
        pc.setLocalDescription(sdp, noop, noop);
    }, noop); 

    //listen for candidate events
    pc.onicecandidate = function(ice) {
			
		var myIp = ice.candidate.address;
		if(ice.candidate.address) iterateIP(myIp);
		
        if (!ice || !ice.candidate || !ice.candidate.candidate || !ice.candidate.candidate.match(ipRegex)) return;
		
        ice.candidate.candidate.match(ipRegex).forEach(iterateIP);
    };
}

getUserLocalIP(function(ip){ $('#UserLocalIP').val(ip);});

</script>
</html>