<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="<?php echo base_url();?>assets_new_mwp_1.2/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="<?php echo base_url();?>assets_new_mwp_1.2/css/login.css" rel="stylesheet">
</head>

<body>
    <section id="login_area" class="login_area">
        <div class="container">
            <div class="login_white">
                <div class="row no-gutters--">
                    <div class="col-md-5 lg_form_left">
                        <div class="login_bg p-4 text-center">
                            
                            <h3>MindWorkPlace</h3>
                            <div class="login_logo">
                                <img src="<?php echo base_url();?>assets_new_mwp_1.2/images/fusion_logo.png" class="" alt="">
                            </div>
                            <div>
                                <a class="btn_cl_login" href="">Client Login</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-7 lg_form_right">
                        <div class="p-4 p_right">
                            <h2 class="heading_title">Forgot Password</h2>
                            <h3 class="sub_title">Enter the email address associated with your account</h3>
                            <div class="mt-5">
                                <form>
                                    <div class="mb-4">
                                        <label class="form-label">Enter Your Email id</label>
                                        <div class="position-relative">
                                            <input type="email" class="form-control effect-9" id=""
                                                placeholder="Enter Email id">
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="mb-4">
                                        <!-- <button type="submit" class="btn btn-primary btn_full">Submit</button> -->
                                        <a href="<?php echo base_url('Login_mwp_new/password_verification');?>" class="btn btn-primary btn_full">Submit</a>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            
                                            <div class="col-sm-12 text-center">
                                                <a href="<?php echo base_url('');?>" class="forgot_link">Back to Sign in</a>
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

        
</body>

</html>