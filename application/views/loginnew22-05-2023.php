<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edg/e">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="<?php echo base_url();?>assets_home_v3/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="<?php echo base_url();?>assets_home_v3/css/login.css" rel="stylesheet">
</head>

<?php
	//echo " >> ". getCurrTimeDiffInMinute('2020-04-06 01:48:55');
	$brand="0";
	if(isset($_COOKIE["brand"])) {
	  $brand = $_COOKIE["brand"];
	}
	if($brand=="3") $logoUrl = base_url()."assets/images/omind_logo.png?".time();
	else $logoUrl = base_url()."assets_home_v3/images/fusion_logo.svg?".time();
	
	
?>
<?php
    $isdisabled="";
    $mobMsg="";
    if($this->agent->is_mobile()){  
        $isdisabled="disabled";	
        $mobMsg="<strong>Info!</strong>  FEMS is not accessible through mobile";
    }?>
					

<body>
    <section id="login_area" class="login_area">
        <div class="container">
            <div class="login_white">
                <div class="row no-gutters--">
                    <div class="col-md-5 lg_form_left">
                        <div class="login_bg p-4 text-center">
                            
                            <h3>MindWorkPlace</h3>
                            <div class="login_logo">
                                <img src="<?php echo $logoUrl?>" class="" alt="">
                            </div>
                            <div>
                                <a class="btn_cl_login" href="<?php echo base_url();?>clientlogin">Client Login</a>
                            </div>
                            
                        </div>
                    </div>
                   
                    <div class="col-md-7 lg_form_right">
                        <div class="p-4 p_right">
                            <h2 class="heading_title">Login</h2>
                            <!-- <h3 class="sub_title">Access to our dashboard</h3> -->
                            <?php if($this->session->flashdata('error_dl')!=''): ?>
                                <div class="alert alert-danger text-center card">
                                    <strong>
                                    <?php echo $this->session->flashdata('error_dl'); ?>
                                    </strong>
                                </div>
                            <?php endif; ?>
                             <?php if($this->session->flashdata('error')!=''): ?>
                    <div class="error-msg"><?php echo $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                            <div class="mt-3">
							<form action="<?php echo base_url();?>login" method="post" accept-charset="utf-8"  class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label class="form-label">Employee ID</label>
                                        <div class="position-relative">

                                        <input type="hidden" class="form-control" id='UserLocalIP' name="UserLocalIP" value="" />
						                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token;?>"  />
                                            <input type="text" class="form-control effect-9" id="sign-in-username" name="omuid" placeholder="Example. FKOL019028"   maxlength="10"   oninput="restrictSpecialCharacters(this)" required>
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="position-relative">
                                            <input id="password-field" type="password" class="form-control effect-9" name="passwd" value="" autocomplete="off" required 
                                            minlength="8"  >
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                            <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                            <!-- <input type="password" class="form-control effect-9" id=""
                                                placeholder="Enter your Password">
                                            <span class="focus-border">
                                                <i></i>
                                            </span> -->
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="form-check "- style="display: none;">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Keep Me Logged In
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-5 forgot_pass_div">
                                                <a href="<?php echo base_url('ForgotPassworduser');?>" class="forgot_link">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
										 <input type="submit" class="btn btn-primary btn_full" name="submit" value="Submit" ></input>
                                    </div>
                                </form>
								
								
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets_home_v3/js/custom.js"></script>
        <script type="text/javascript">
            $(".toggle-password").click(function() {

              $(this).toggleClass("fa-eye fa-eye-slash");
              var input = $($(this).attr("toggle"));
              if (input.attr("type") == "password") {
                input.attr("type", "text");
              } else {
                input.attr("type", "password");
              }
            });
        </script>


<script type="text/javascript">	
var brand="0";
var brand = localStorage.getItem("brand");
var logoUrl = "<?php echo base_url() ?>assets_home_v3/images/fusion_logo.svg?<?php echo time() ?>";
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
 <script>
  // Wait for the page to load
  window.onload = function() {
    // Focus on the email_id input field
    document.getElementById("sign-in-username").focus();
  };
</script>
<script>
    function restrictSpecialCharacters(input) {
        input.value = input.value.replace(/[^\w]/g, '');
    }
</script>
</body>

</html>