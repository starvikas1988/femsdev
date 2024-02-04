<?php //echo $_SERVER["HTTP_USER_AGENT"]; ?>
<!DOCTYPE html>
<html lang="en-US">
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
	
	<link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon">
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
			font-size: 1.2rem;
			font-weight:bold;
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
		
		.fusion-logo{
			width:180px;
		}
	
	
	#google_translate_element{
		display: none;
	}

	.goog-te-banner-frame.skiptranslate {
        display: none !important;
    } 
    body {
        top: 0px !important; 
    }
	/* start message area css here 11.10.2022*/
	.message_area {
		position:fixed;
		bottom:0;
		width:100%;
		padding:10px 0;
		background:rgba(0,103,184,0.2)
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
	}
	/* end message area css here 11.10.2022*/
	
	</style>
	
</head>

			
<?php
	//echo " >> ". getCurrTimeDiffInMinute('2020-04-06 01:48:55');
	$brand="0";
	if(isset($_COOKIE["brand"])) {
	  $brand = $_COOKIE["brand"];
	}
	if($brand=="3") $logoUrl = base_url()."assets/images/omind_logo.png?".time();
	else $logoUrl = base_url()."assets/home_bgimages/fusion-original-transparent.png?".time();
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
		<div>
			
		</div>
		
		<div class="main-box">
		
			<?php if($this->session->flashdata('error_dl')!=''): ?>
				
				<div class="alert alert-danger text-center card" style="font-size:1.3rem;padding: 5px;">
					<strong>
					<?php echo $this->session->flashdata('error_dl'); ?>
					</strong>
				</div>
			
			<?php endif; ?>
										
			<div class="slider-cont">  
				<div class="fusion-logo">
				
					<img id="logo_image" src="<?php echo $logoUrl; ?>" alt="fusion-logo">
			
		    	</div>
				<div class='client-login'>
					<a href="<?php echo base_url()?>clientlogin"><button class="btn btn-sm btn-info">Client Login &raquo;</button></a>
				</div>
			</div>
			
		  	<div class="form-cont"> 

				
					<div class="flag" style="disply:block;z-index:9999; margin-right:5px; margin-top:10px;">
						<a  style="margin-right:5px; float:right; cursor:pointer;" class="flag_link eng"  title="English" data-lang="en">
							<img class="img-fluid" width='40px;' src="<?php echo base_url(); ?>assets/flag_img/english_us.png" alt="English">
						</a>
						<a style="margin-right:5px; float:right; cursor:pointer;" class="flag_link frn" title="French" data-lang="fr">
							<img class="img-fluid" width='40px;' src="<?php echo base_url(); ?>assets/flag_img/french.jpg" alt="French">
						</a>
						
						 <div id="google_translate_element"></div>
					</div>
			
			    <div class="form form-signin">
					<div class="form-header">
					
					<h3>
					<?php
						$isdisabled="";
						$mobMsg="";

						if($this->agent->is_mobile()){
							
							$isdisabled="disabled";	
							$mobMsg="<strong>Info!</strong>  FEMS is not accessible through mobile";
						
						}								
						
					?>
					</h3>
					
					<h3>
						<?php 
						echo APP_TITLE; ?>
					</h3>
					
					<?php if($this->session->flashdata('error')!=''): ?>
					<?php echo $this->session->flashdata('error'); ?>
					<?php endif; ?>
						
				</div>
				    <?php 
						echo form_open(base_url()."login");
					?>
					
						
					    <div class="form-group">
						  <input type="hidden" class="form-control" id='UserLocalIP' name="UserLocalIP" value="" />
						  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token;?>"  />
						  <input id="sign-in-username" type="text"  name="omuid"  autocomplete="off" required <?php echo $isdisabled;?> />
					      <label for="input" class="control-label">Fusion ID / XPO ID</label><i class="bar"></i>
					    </div>
					    <div class="form-group">
						  <input id="password" type="password"  name="passwd"  autocomplete="off" required <?php echo $isdisabled;?>/>
					      
					      <label for="input" class="control-label">Password</label><i class="bar"></i>
					    </div>
					    <div class="checkbox form-group">
					      <label>
					        <input type="checkbox" id="keep_me_logged_in"/>
							<i class="helper"></i>keep me logged in
					      </label>
					    </div>
						
					    <div class="button-container">
						    <input type="submit" class="button" name="submit" value="Submit" <?php echo $isdisabled;?>></input>
						</div>
	  				</form>
					
						
						
	  				<div class="footer-copyright">
				    	<span>&copy; <?php echo date("Y");?> Omind Technologies</span>
				    </div>
			    </div>
		  	</div>
		</div>
	</div>
	<!--start message area html elements here 11.10.2022-->
	<div class="message_area">
		<div class="container">
			<div class="content">
				<marquee direction="left">
				<strong><i>Dear All, This is to keep you posted that MWP will be down from 13TH AUG 6:30PM IST TO 15TH AUG 10AM IST 13TH AUG 09:00AM EST TO 15TH AUG 12:30AM EST due to server migration. Your inconvenience is highly regretted. Regards, MWP Team</i></strong>
				</marquee>
			</div>
		</div>
	</div>
	<!--end message area html elements here 11.10.2022-->		
</body>


<!-- <script src="<?php //echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script> -->
<script src="<?php echo base_url() ?>libs/jquery/jquery-3.5.1.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
<script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>

<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/login.js"></script>



<script type="text/javascript">	
	function googleTranslateElementInit(){
		
		var tlang=$.cookie('tlang');
		if(tlang=="") tlang="en";
		var lang =tlang;
		
		new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,fr' }, 'google_translate_element');
		
		var languageSelect = document.querySelector("select.goog-te-combo");
		languageSelect.value = lang; 
		languageSelect.dispatchEvent(new Event("change"));
	}

	var flags = document.getElementsByClassName('flag_link'); 
		
	Array.prototype.forEach.call(flags, function(e){
	  e.addEventListener('click', function(){
		var lang = e.getAttribute('data-lang'); 
		$.cookie('tlang', lang, { expires: 365, path: '/' });
		var languageSelect = document.querySelector("select.goog-te-combo");
		languageSelect.value = lang; 
		languageSelect.dispatchEvent(new Event("change"));
		
		
		
	  }); 
	});
</script>
	
<script type="text/javascript">	
var brand="0";

var brand = localStorage.getItem("brand");

var logoUrl = "<?php echo base_url() ?>assets/home_bgimages/fusion-original-transparent.png?<?php echo time() ?>";
if(brand=="3") logoUrl = "<?php echo base_url() ?>assets/images/omind_logo.png?<?php echo time() ?>";
//$("#logo_image").attr("src",logoUrl);

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