<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>Login - <?php echo APP_TITLE;?></title>
	<meta name="description" content="Login" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="<?php echo base_url()?>libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/app.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

	<style>
		.simple-page {
		  /*  background-image: url("<?php echo base_url(); ?>assets/images/emp111.jpg"); */
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
		
	<div class="simple-page-wrap">
		
		
		<?php if($this->session->flashdata('error')!=''): ?>
		<?php echo $this->session->flashdata('error'); ?>
		<?php endif; ?>
		
		<div class="simple-page-form animated flipInY" id="login-form">
			<h4 class="form-title m-b-xl text-center">Sign In with your Official Fusion ID/XPOID</h4>
			<?php echo form_open(base_url()."login") ?>
				
				
				
				
				<div class="form-group">
					<input id="sign-in-username" type="text" class="form-control" placeholder="Fusion ID/XPOID" name="omuid"/>
				</div>

				<div class="form-group">
					<input id="password" type="password" class="form-control" placeholder="Password" name="passwd"/>
					<input type="hidden" class="form-control" id='UserLocalIP' name="UserLocalIP" value="" />
				</div>
				
				<div class="form-group m-b-xl">
					<div class="checkbox checkbox-primary">
						<input type="checkbox" id="keep_me_logged_in"/>
						<label for="keep_me_logged_in">Keep me signed in</label>
					</div>
				</div>
				<input type="submit" class="btn btn-success" value="SIGN IN" name="submit">
			</form>
		</div><!-- #login-form -->

		<div class="simple-page-footer">
			<p>
				<small style="color:black"><b>&copy; <?php echo date("Y");?> Fusion BPO Services</b></small>
			</p>
		</div><!-- .simple-page-footer -->


	</div><!-- .simple-page-wrap -->
</body>

<!-- <script src="<?php //echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script> -->
	<script src="<?php echo base_url() ?>libs/jquery/jquery-3.5.1.js"></script>

<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>

<script type="text/javascript">	

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