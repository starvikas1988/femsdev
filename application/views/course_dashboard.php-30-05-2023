<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta content='width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;'>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
<title>Course Page</title>
<link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon">
<!--google font-->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400&display=swap" rel="stylesheet">
<!--common style-->
<link href="<?php echo base_url(); ?>libs/course_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>libs/course_assets/vendor/lobicard/css/lobicard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>libs/course_assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>libs/course_assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>libs/course_assets/vendor/themify-icons/css/themify-icons.css" rel="stylesheet">

<!--custom css-->
<link href="<?php echo base_url(); ?>libs/course_assets/css/main.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>libs/course_assets/css/custom-style.css" rel="stylesheet">


<link href="<?php echo base_url(); ?>libs/course_asset_2/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>libs/course_asset_2/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>libs/course_asset_2/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>libs/course_asset_2/plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>libs/course_asset_2/styles/courses.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>libs/course_asset_2/styles/courses_responsive.css">
 
 
</head>
<body oncontextmenu="return false;" class="app header-fixed left-sidebar-light right-sidebar-fixed right-sidebar-overlay right-sidebar-hidden">

    <!--===========header start===========-->
    <header class="app-header navbar top-bar fixed"> 
        <div class="navbar-brand">
            <a class="main-logo img-fluid" href="<?php echo base_url();?>home">
                <!--<img class="img-responsive img-fluid" src="<?php echo base_url();?>assets/images/fusion-bpo.png" alt="">-->
                <?=get_logo()?>
            </a>
        </div>
        <ul class="nav navbar-nav mr-auto">
            <li class="nav-item d-lg-none">
                <button class="navbar-toggler mobile-leftside-toggler" type="button"><i class="ti-align-right"></i></button>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item d-md-down-none-">
                <div id="redBecomesBlue" class="red small" title="Your Progress"></div> 
            </li>
            <li class="nav-item dropdown dropdown-slide d-md-down-none">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="ti-bell"></i>
                    <span class="badge badge-danger notification-alarm"> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right mCustomScrollbar notification-dropdown">
                    <div class="card-body p-0 position-relative">
                        <div class="card-title clearfix pt-2 pb-2 pl-3 pr-3 m-0" id="panel-sticky">
                            <p class="text-capitalize blockquote-footer m-0 float-left">Your Notifications</p>
                        </div>
                        <div class="celebration-section ">
                            <ul class="list-group">
                                <li class="list-group-item border-left-0 border-right-0 border-top-0 pl-2 pr-2 pt-1 pb-1">
                                    <div class="media media-list">
                                        <img class="align-self-center mr-3 rounded-circle" src="assets/img/user1.png" alt=" ">
                                        <div class="media-body">
                                            <p class="mb-0"><strong class=""></strong></p>
                                            <small class="blockquote-footer"></small>
                                        </div>
                                        <div class="btn-group float-right task-list-action">
                                            <i class="fa fa-alert text-warning fa-1" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
           
            <li class="nav-item dropdown dropdown-slide">
                <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $prof_pic_url; ?>" alt="<?php echo get_username();  ?>">
					 <?php  //$profileURL; ?>
		</a>
					
					
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-accout">
                    <div class="dropdown-header pl-3 pr-3">
                        <div class="media d-user">
                            <img class="align-self-center mr-2" src="<?php echo $prof_pic_url; ?>" alt="<?php echo get_username(); ?>">
                            <div class="media-body">
                                <h5 class="mt-0 mb-0">
									<?php echo get_username(); ?>
								</h5>
                                <small class="blockquote-footer"><?php if(get_deptname()!="") echo " (". get_role().", ".get_deptshname().")"; ?></small>
                          
                            </div>
                        </div>
                    </div>
                   <!-- <a class="dropdown-item time-count-s2 avater-break-counter clearfix pl-2 pr-2" href="#">
                        <div class="float-left">
                            <form>
                                <div class="form-group row  m-0 float-left">
                                    <div class="pr-2">
                                        <input class="tgl tgl-light" id="cb1" type="checkbox">
                                        <label class="tgl-btn m-0" for="cb1"></label>
                                    </div>
                                    <label class=" p-0 col-form-label col-form-label-sm text-center">Lunch/Dinner break</label>
                                </div>
                            </form>
                        </div>
                        <div class="float-right">
                            <div id="timer">
                                <!-- <div id="days" class="round-back"></div>
                                <div id="hours" class="round-back"></div> -->
                               <!-- <div id="minutes" class="round-back"></div>
                                <div id="seconds" class="round-back"></div>
                            </div>
                        </div>
                    </a>-->
                    <!--<a class="dropdown-item time-count-s2 avater-break-counter clearfix pl-2 pr-2" href="#">
                        
                        <div class="float-right">
                            <div id="timer">
                                <!-- <div id="days" class="round-back"></div>
                                <div id="hours" class="round-back"></div> -->
                               <!-- <div id="minutes" class="round-back"></div>
                                <div id="seconds" class="round-back"></div>
                            </div>
                        </div>
                    </a>-->
                    
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url();?>fusion/logout"><i class=" ti-unlock"></i> Logout</a>
                </div>
            </li>
            <li class="nav-item d-lg-none">
                <button class="navbar-toggler mobile-rightside-toggler" type="button"><i class="icon-options-vertical"></i></button>
            </li>
            <li class="nav-item d-md-down-none">
                <a class="nav-link navbar-toggler right-sidebar-toggler" href="#"><i class="icon-options-vertical"></i></a>
            </li>
        </ul>
    </header>
    <!--===========header end===========-->
    <!-- ========== NAV ================-->
    <nav class="navbar navbar-light navbar-expand-lg mainmenu">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            	<!-- <li><a href="#">Link</a></li> -->
                 
            </ul>
        </div>
    </nav>
    <!-- ========== NAV ================-->
    <!--------------- OFF Canvus Nav 
    <div class="slide-nav">
      <button class="netflix-nav-btn netflix-open-btn">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <div class="netflix-nav netflix-nav-black">
        <div class="netflix-nav netflix-nav-red">
          <div class="netflix-nav netflix-nav-white mCustomScrollbar" data-mcs-theme="minimal-dark">
            <!-- <button class="netflix-nav-btn netflix-close-btn"><i class="fas fa-times"></i></button>
            <a href="index3.html" class="brand-link">
              <img class="img-responsive img-fluid icon-img-4" src="assets/img/logo.png" alt="Fusion Logo">
            </a>
            <div class="left-sidebar w-100">
	            <nav class="sidebar-menu w-100">
	                <ul id="nav-accordion">
	                    <li class="nav-title">
	                        <h5 class="text-uppercase">Quality & Assurance</h5>
	                    </li>
	                    <li>
	                        <a href="qa-calibration.html">
	                            <i class="fa fa-dot-circle-o text-muted"></i>
	                            <span>Calibration</span>
	                        </a>
	                    </li>
	                    <li>
	                        <a href="qa-lead-summary-dashboard.html">
	                            <i class="fa fa-dot-circle-o text-muted"></i>
	                            <span>Lead Summary Dashboard</span>
	                        </a>
	                    </li>
	                    <li class="sub-menu">
	                        <a href="dip-check.html">
	                            <i class="fa fa-dashboard" aria-hidden="true"></i>
	                            <span>Dip Check</span>
	                        </a>
	                        <ul class="sub">
	                            <li><a  href="dip-check-exam.html">Dip Check Exam</a></li>
	                        </ul>
	                    </li>
	                    <li>
	                        <a href="audit-view.html">
	                            <i class="fa fa-dot-circle-o text-muted"></i>
	                            <span>Audit View</span>
	                        </a>
	                    </li>
	                    <li>
	                        <a href="your-audit-view.html">
	                            <i class="fa fa-dot-circle-o text-muted"></i>
	                            <span>Your Audit View</span>
	                        </a>
	                    </li>
	                    <li>
	                        <a href="personal-audit-view.html">
	                            <i class="fa fa-dot-circle-o text-muted"></i>
	                            <span>Personal Audit View</span>
	                        </a>
	                    </li>
	                    <li class="nav-title">
	                        <h5 class="text-uppercase">Dashboard</h5>
	                    </li>
	                    <li>
	                        <a href="associate-dashboard.html">
	                            <i class="fa fa-dot-circle-o text-muted"></i>
	                            <span>Associate Dashboard</span>
	                        </a>
	                    </li>
	                    <li>
	                        <a href="productivity-dashboard.html">
	                            <i class="fa fa-dot-circle-o text-muted"></i>
	                            <span>Productivity Dashboard</span>
	                        </a>
	                    </li>
	                    <li>
	                        <a href="summary-dashboard.html">
	                            <i class="fa fa-dot-circle-o text-muted"></i>
	                            <span>Summary Dashboard</span>
	                        </a>
	                    </li>
	                    <li class="sub-menu">
	                        <a href="#">
	                            <i class="fa fa-dashboard" aria-hidden="true"></i>
	                            <span>Graphical Dashboard</span>
	                        </a>
	                        <ul class="sub">
	                            <li><a href="#">Create/Manager</a></li>
	                            <li><a href="#">Report Menu</a></li>
	                        </ul>
	                    </li>
	                </ul>
	            </nav>
        	</div>
          </div>
        </div>
    </div>
   OFF Canvus Nav  --------------->
    <!--===========app body start===========-->
    <div class="app-body">
        <!--main contents start-->
        <main class="main-content m-5">
				
				<?php include_once $content_template; ?>
				
        </main>
        <!--main contents end-->
 
    </div>
    <!--===========app body end===========-->
    <!--===========footer start===========-->
		<footer class="footer"> 
		 
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="copyright_content d-flex flex-md-row flex-column align-items-md-center align-items-start justify-content-start">
							<div class="cr">
							Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
							</div>
					
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
    <!--===========footer end===========-->



<!-- Placed js at the end of the page so the pages load faster -->
<!--<script src="<?php //echo base_url(); ?>libs/course_assets/vendor/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.1.0/jquery-migrate.min.js"></script> -->

<script src="<?php echo base_url() ?>libs/jquery/jquery-3.5.1.js"></script>

<script src="<?php echo base_url(); ?>libs/course_assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script src="<?php //echo base_url(); ?>libs/course_assets/vendor/popper.min.js"></script>
<script src="<?php echo base_url(); ?>libs/course_assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php //echo base_url(); ?>libs/course_assets/vendor/jquery.scrollTo.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script> -->

<!-- Custom-Jquery -->
<script src="<?php echo base_url(); ?>libs/course_assets/js/custom-jquery.js"></script>

<script src="<?php echo base_url(); ?>libs/course_asset_2/styles/bootstrap4/popper.js"></script>
<script src="<?php echo base_url(); ?>libs/course_asset_2/styles/bootstrap4/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>libs/course_asset_2/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>libs/course_asset_2/plugins/easing/easing.js"></script>
<script src="<?php echo base_url(); ?>libs/course_asset_2/js/courses.js"></script>
 
<script>
 
	
$(window).on('keydown',function(event){
    if(event.keyCode==123){
        return false;
    }else if(event.ctrlKey && event.shiftKey && event.keyCode==73){
        alert('Entered ctrl+shift+i')
        return false;  //Prevent from ctrl+shift+i
    }else if(event.ctrlKey && event.keyCode==73){
      
        return false;  //Prevent from ctrl+shift+i
    }
});
	$(document).on("contextmenu",function(e){
		e.preventDefault();
	});
	
</script> 

	<?php
		if(isset($content_js) && !empty($content_js))
		{
			if(is_array($content_js))
			{
		
				foreach($content_js as $key=>$script_url)
				{
					if(preg_match("/.php/", $script_url))
					{
						if(preg_match("/\Ahttp/", $script_url))
						{
							echo '<script src="'.$script_url.'"></script>';
						}
						else
						{
							echo '<script src="'. base_url('application/views/jscripts/'.$script_url).'"></script>';
						}
					}
					else
					{
						include_once 'application/views/jscripts/'.$script_url;
					}
				}
			}
			else
			{
				if(!preg_match("/.php/", $content_js))
				{
					if(preg_match("/\Ahttp/", $content_js))
					{
						echo '<script src="'.$content_js.'"></script>';
					}
					else
					{
						echo '<script src="'. base_url('application/views/jscripts/'.$content_js).'"></script>';
					}
				}
				else
				{
					include_once 'application/views/jscripts/'.$content_js;
				}
			}
		}
	?>

</body>
</html>
