<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="css/login.css" rel="stylesheet">
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
                                <img src="images/fusion_logo.png" class="" alt="">
                            </div>
                            <div>
                                <a class="btn_cl_login" href="">Client Login</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-7 lg_form_right">
                        <div class="p-4 p_right">
                            <h2 class="heading_title">Set New Password</h2>
                            <h3 class="sub_title">In order to keep your account safe you need to <br>  create a strong password</h3>
                            <div class="mt-3">
                                <form>
                                    <!-- <div class="mb-3">
                                        <label class="form-label">Employee ID/Email ID</label>
                                        <div class="position-relative">
                                            <input type="email" class="form-control effect-9" id=""
                                                placeholder="Example. FKOL019028">
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div> -->
                                    <div class="mb-2">
                                        <label class="form-label">Password</label>
                                        <div class="position-relative">
                                            <input id="password-field" type="password" class="form-control effect-9" name="password" value="secret">
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            
                                        </div>
                                        <div>
                                            <p class="pass_hint">Your Password may contain: Between 8 & 20 characters (1 or more Upper case, Lower case, Numbers & special character) </p>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <div class="position-relative">
                                            <input id="password-field2" type="password" class="form-control effect-9" name="password" value="secret">
                                            <span class="focus-border">
                                                <i></i>
                                            </span>
                                            <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <!-- <button type="submit" class="btn btn-primary btn_full">Submit</button> -->
                                        <a href="password-changed.html" class="btn btn-primary btn_full">Submit</a>
                                        
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
</body>

</html>