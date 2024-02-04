<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
        
    }?>
<body>
    <section id="login_area" class="login_area">
        <div class="container">
            <div class="login_white">
                <div class="row no-gutters--">
                    <div class="col-md-5 lg_form_left">
                        <div class="login_bg p-4 text-center">
                            <div class="login_logo">
                                <img src="<?php echo base_url()?>assets_home_v3/images/fusion_logo.svg" class="" alt="">
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-7 lg_form_right">
                        <div class="p-4 p_right">
                            <h2 class="heading_title">Set New Password</h2>
                            <div class="lgn_form_area mt-4">
                            <?php  
                             if ($this->session->flashdata('error_updt_psw') !="") {
                                
                                     echo '<div class="alert alert-danger p-2 mt-2">' . $this->session->flashdata('error_updt_psw') . '</div>';
                            }elseif ($this->session->flashdata('psw-success') !=" ") {
                                
                                echo '<div class="alert alert-success p-2 mt-2">' . $this->session->flashdata('psw-success') . '</div>';
                            }?>
                             <form method="post" action="<?php echo base_url()."forgot_password/change_password" ?>" class="needs-validation" novalidate>
                                    <div class="mb-2">
                                        <label class="form-label">Password</label>
                                        <div class="position-relative">
                                        <input type="hidden" name="fid" value="<?php echo $email_id; ?>">  
                                            <input id="password-field" type="password" class="form-control effect-9" placeholder="******" name="password" value="" required onblur="validatePassword()" maxlength="20" data-minlength="8" >
                                            
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                            <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                            
                                        </div>
                                        <div id="password-error" style="color:red" class='p-2'></div>
                                        <div>
                                            <p class="pass_hint">Your Password may contain: Between 8 & 20 characters (1 or more Upper case, Lower case, Numbers & special character) </p>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="position-relative">
                                            <input id="password-field2" type="password" class="form-control effect-9" placeholder="******" name="repassword" value="" required onblur="validatePassword()"  onkeyup="validatePasswordMatch()">
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                            <span toggle="#password-field2" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>

                                        </div>
                                        <div id="password-match-error" style="color: red;"></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <!-- <button type="submit" class="btn btn-primary btn_full">Submit</button> -->
                                        <!-- <a href="client-password-changed.html" class="btn btn-primary btn_full">Submit</a> -->
                                        <button type="submit" id ="ChangePasswdbtn" class="btn btn-primary btn_full" name="submit" value='ChangePasswd' disabled>Change Password</button> 
                                        
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
        function validatePassword() {
            
            var password = document.getElementById("password-field").value;
            var cnpassword = document.getElementById("password-field2").value;
             
            var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_=+~])(?=.*[^\w\d\s:])([^\s]){8,20}$/;
            if (password.match(pattern)) {
                document.getElementById("password-error").innerHTML = "";
            } else {
                document.getElementById("password-error").innerHTML = "Password Formate Invalid.";
            }

            
           
        }

        function validatePasswordMatch() {
            var password = document.getElementById("password-field").value;
            var confirmPassword = document.getElementById("password-field2").value;

            if (password === confirmPassword) {
                document.getElementById("password-match-error").innerHTML = "";
                $('#ChangePasswdbtn').removeAttr('disabled');
            } else {
                document.getElementById("password-match-error").innerHTML = "Passwords do not match.";
                $('#ChangePasswdbtn').attr('disabled', 'disabled');
            }
        }
    </script>


<script>
       $(function(){
    $("#password-field").focus();
  });
    </script>





</body>

</html>