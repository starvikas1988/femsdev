<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="<?php echo base_url()?>assets_home_v3/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="<?php echo base_url()?>assets_home_v3/css/login.css" rel="stylesheet">
</head>
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
<body>
    <section id="login_area" class="login_area">
        <div class="container">
            <div class="login_white">
                <div class="row no-gutters--">
                    <div class="col-md-5 lg_form_left">
                        <div class="login_bg p-4 text-center">
                            <div class="login_logo">
                                <img src="<?php echo base_url()?>assets_home_v3/brand_logo/fusion_logo.svg" class="" alt="">
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-7 lg_form_right">
                        <div class="p-4 p_right">
                            <h2 class="heading_title">Client Forgot Password</h2>
                            <div class="lgn_form_area mt-5">
                            <?php  
                             if ($this->session->flashdata('error_updt_psw') !="") {
                                
                                     echo '<div class="alert alert-danger p-2 mt-2">' . $this->session->flashdata('error_updt_psw') . '</div>';
                            }
                            
                            ?>
                                <form  method="post" action="<?php echo base_url()."forgot_password/check_fusion_id" ?>" class="needs-validation" novalidate>
                                    <div class="mb-4">
                                        <label class="form-label">Enter Your Email id</label>
                                        <div class="position-relative">

                                        <input type="hidden" class="form-control" id='UserLocalIP' name="UserLocalIP" value="" />
						                 <input type="hidden" name="csrf_token" value="<?php echo $csrf_token;?>"  />
                                            <input type="email" class="form-control effect-9" id="sign-in-username"
                                                placeholder="Enter Email id" name="email_id" autocomplete="off" required >


                                            
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                        </div>
                                        <div id="email-match-error" style="color: red;" class='P-2'></div>
                                    </div>
                                    
                                    
                                    <div class="mb-4">
                                        <!-- <button type="submit" class="btn btn-primary btn_full">Submit</button> -->
                                        <input type="submit" class="btn btn-primary btn_full" class="button" id="btnAprv" name="submit" value="Submit" <?php echo $isdisabled;?>></input>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            
                                            <div class="col-sm-12 text-center">
                                                <a href="<?php echo base_url();?>clientlogin"  class="forgot_link">Back to Sign in</a>
                                            </div>
                                        </div>
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
    <script>


        function validate(emailaddress) {

var emailaddress = $('#sign-in-username').val();
            function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
            }
        if( !validateEmail(emailaddress))
         { 
            $('#email-match-error').html("Enter Valid Email");
         }
         else
         {
            $('#email-match-error').html("");
         }
     
    }
    </script>
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

<script>
       $(function(){
    $("#sign-in-username").focus();
  });
    </script>


        
</body>

</html>