<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="<?php echo base_url();?>assets_home_v3/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="<?php echo base_url();?>assets_home_v3/css/login.css" rel="stylesheet">
</head>

<body>
    <section id="login_area" class="login_area">
        <div class="container">
            <div class="login_white">
                <div class="row no-gutters--">
                    <div class="col-md-5 lg_form_left">
                        <div class="login_bg p-4 text-center">
                            
                            
                            <div class="login_logo">
                                <img src="<?php echo base_url();?>assets_home_v3/brand_logo/fusion_logo.svg" class="" alt="">
                            </div>
                            
                            
                        </div>
                    </div>
                   
                    <div class="col-md-7 lg_form_right">
                        <div class="p-4 p_right">
                            <h2 class="heading_title">Client Login</h2>
                            <div class="lgn_form_area mt-3">
                            <?php  
                             if ($this->session->flashdata('client-error') !="") {
                                
                                     echo '<div class="alert alert-danger p-2 mt-2">' . $this->session->flashdata('client-error') . '</div>';
                            }?>

                            <form action="<?php echo base_url();?>clientlogin/clientAuth" method="post" accept-charset="utf-8"  class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label class="form-label">Enter Email ID</label>
                                        <div class="position-relative">
                                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token;?>"  />
                                            <input type="email" class="form-control effect-9" id="omuid" name ='omuid'
                                                placeholder="name@domin.com" required >
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                        </div>
                                        <div id="email-error" style="color:red" class='small_text'></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="position-relative">
                                            <input id="password-field" type="password" class="form-control effect-9" placeholder="Enter your Password" name="passwd" value="" required maxlength="20">
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
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="keep_me_logged_in">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Keep Me Logged In
                                                    </label>
                                                  </div> -->
                                            </div>
                                            <div class="col-sm-5 forgot_pass_div">
                                                <a href="<?php echo base_url('forgot_password'); ?>" class="forgot_link">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <!-- <button type="submit" class="btn btn-primary btn_full">Submit</button> -->
                                        <input type="submit" class="btn btn-primary btn_full" value="Submit" name="submit">
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
$(function(){
    $("#omuid").focus();
});
</script>
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


<script>
        function validateemail() {
            function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
    if (!ValidateEmail($("#omuid").val())) {
        document.getElementById("email-error").innerHTML = "Invalid Email ID";
        document.getElementById("omuid").value  = "";
        }
        else {
            document.getElementById("email-error").innerHTML = "";
        }
        }
    </script>





</script>
</body>

</html>