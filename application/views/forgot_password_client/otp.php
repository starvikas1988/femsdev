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
        
    }?>
<body>
    <section id="client_password_verification" class="login_area">
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
                            <h2 class="heading_title">Client Verification</h2>
                            <div class="lgn_form_area mt-4">
                            <?php  
                             if ($this->session->flashdata('error_otp') !="") {
                                     echo '<div class="alert alert-danger p-2 mt-2">' . $this->session->flashdata('error_otp') . '</div>';
                            }elseif ($this->session->flashdata('success') !=" ") {
                                echo '<div class="alert alert-success p-2 mt-2">' . $this->session->flashdata('success') . '</div>';
                            }?>
                          
                                <form method="post"   action="<?php echo base_url()."forgot_password/verify_otp" ?>" >
                                <input type="hidden" name="otp_fid" id="otp_fid" value="<?php echo $email_id; ?>">
                                
                                    <div class="mb-4">
                                        <label class="form-label">Enter Verification code</label>
                                        <div class="position-relative">
                                        

                                                <input type="text" class="form-control effect-9"
                                                placeholder="XXX-XXX"  name="otp" id="otp" value="" autocomplete="off" inputmode="numeric" pattern="[0-9]*" maxlength="6" required >

                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="mb-4">
                                        <!-- <button type="submit" class="btn btn-primary btn_full">Submit</button> -->
                                        <!-- <a href="client-set-new-password.html" class="btn btn-primary btn_full">Submit</a> -->
                                        <input type="submit" class="btn btn-primary btn_full" name="submit" value="Submit"></input>
                                    </div>
                       
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="otp_timer">
                                                    <p>Time Remaining: <span id="countdown"></span></p>
                                                </div>
                                            </div>
                                            <div class="col-5 resend_code text-end" id="resend_link_inactive">
                                                <a href="javascript:void(0);"  class="resend_code_lnk">Resend Code</a>
                                            </div>
                                            <div class="col-5 resend_code text-end" style="display:none;" id="resend_link_active">
                                                <a href="<?php echo base_url()."Forgot_password/resend_otp" ?>" class="resend_code_active">Resend Code</a>
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
<script>

            // show the timer for 2 minutes after the OTP is sent
        var otp_timestamp = <?php echo $this->session->userdata('otp_timestamp'); ?>;
        
        var countdown_timer = setInterval(function() {
        var remaining_time = Math.max(0, (otp_timestamp + 120) - Math.floor(Date.now() / 1000));
            if (remaining_time > 0) {
                 $('#timer').show();
                $('#countdown').text(remaining_time);
                $('#resend_link_active').hide();
                $('#resend_link_inactive').show();

          
            } else {
             clearInterval(countdown_timer);
            $('#timer').hide();
            $('#resend_link_active').show();
            $('#resend_link_inactive').hide();
          }
            }, 1000);

        </script>
<script>
       $(function(){
    $("#otp").focus();
  });
    </script>

</body>

</html>