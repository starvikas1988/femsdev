 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?php echo base_url();?>assets/gamification/css/jQuery-plugin-progressbar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
    
    <!-- icons
    ================================================== -->
    <!--<link rel="stylesheet" href="<?php echo base_url();?>assets/gamification/css/icons.css">-->

    <!-- CSS 
    ================================================== --> 
    <!--<link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.css">-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/gamification/css/uikit.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/gamification/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/gamification/css/style2.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/gamification/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/gamification/css/OverlayScrollbars.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/gamification/css/os-theme-round-dark.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head> 
<body>
  <?php
  //echo'<pre>';print_r($kpi_col_new);die();
  ?>     

    <div id="wrapper">

        <!-- Header -->
        <header>
            <div class="nav-new" id="desktop-menu"> 
  <div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="body-widget">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/gamification/images/logo.png" class="logo-img" alt=""></a>
                <span class="search-main" >
                    <div class="form-group has-feedback has-search">
                        <i class="fa fa-search form-control-feedback" aria-hidden="true"></i>
                        <input type="text" id="serch_keywrd" name="serch_keywrd" class="form-control" placeholder="Search">
                        <input type="hidden" name="process_id" id="process_id" value="<?php echo $pValue;?>">
                    </div>
                    <div class="container" id="serch_main" style="display: none;">
                    <div class="saq_div" style="min-height:3rem; margin-left: -18px; position:fixed; z-index:100000; width:16rem;background: whitesmoke;">
                    <div class="box" id="saq_box" style="box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);">
                        <div id='saq_data_show'></div>
                
                    <div id="showData_saq" style="height: 250px;overflow-y: scroll;">
                        
                    </div>
                    </div>
                    </div>
                </div>
                </span>
                
            </div>
        </div>
        <div class="col-sm-8">
            <div class="menu-right">
                <div class="body-widget">
                    <ul class="menu-new">
                        <li class="active-new">
                            <a href="<?php echo base_url();?>gamify/dashboard">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>qa_graph" target="_blank">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                QA
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>pmetrix_v2" target="_blank">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                Perfomance
                            </a>                            
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>process_update" target="_blank">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                Update
                            </a>                            
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                                More
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url();?>payslip" target="_blank">Payslip</a></li>
                                <li><a href="<?php echo base_url();?>leave" target="_blank">Leave</a></li>
                                <li><a href="<?php echo base_url();?>faq" target="_blank">Faq</a></li>
                            </ul>
                        </li>
                        <li class="left-border">
                            <a href="#">
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                Me
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url();?>profile" target="_blank">Profile</a></li>
                                 <li><a href="<?php echo base_url();?>agent/changePasswd">Change<br>Password</a></li>
                                <li><a href="<?php echo base_url();?>/logout">Log Out</a></li>
                            </ul>
                        </li>                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
        </header>

        <!-- sidebar -->
        <div class="sidebar">
            <div class="sidebar_header"> 
                <img src="<?php echo base_url();?>assets/gamification/images/logo.png" alt="">
                <img src="<?php echo base_url();?>assets/gamification/images/logo-icon.html" class="logo-icon" alt="">

                <span class="btn-mobile" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></span>

            </div>
        
            <div class="sidebar_inner" data-simplebar>
        
                <ul>
                    <li><a href="<?php echo base_url();?>/gamify/dashboard"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-600"> 
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span> Timeline </span> </a> 
                    </li>
                    
                    <li id="more-veiw" hidden><a href="https://fems.fusionbposervices.com/femschat/userview/im"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                       <span>MWP Chat</span> </a> 
                    </li>
                    <li><a href="<?php echo base_url();?>album" target="_blank"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg><span> Photo Gallery </span></a> 
                    </li>
                    <li><a href="<?php echo base_url();?>/course" target="_blank"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-yellow-500">
                          <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                        </svg> 
                        <span> Courses </span> </a> 
                    </li>
                    <li><a href="<?php echo base_url();?>/ld_programs/course_list/all" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-500">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z" clip-rule="evenodd" />
                        </svg>
                        <span> L&D </span></a> 
                    </li> 
                    <li><a href="<?php echo base_url();?>employee_feedback" target="_blank"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg><span> Survey </span></a> 
                    </li>
                    <li><a href="<?php echo base_url();?>payslip" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-green-500">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        <span> Payslip</span></a> 
                    </li>
                    <li><a href="<?php echo base_url();?>progression" target="_blank"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-pink-500">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg> <span> Progression</span> </a> 
                    </li> 
                    
                    <li id="more-veiw" hidden><a  data-toggle="modal" data-target="#leadership" target="_blank"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-yellow-500">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                          </svg><span>  Leaderboard </span></a> 
                    </li> 
                    <li id="more-veiw" hidden><a href="<?php echo base_url();?>/faq" target="_blank"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>  <span>  FAQs </span></a> 
                    </li>
                    <li id="more-veiw" hidden><a href="<?php echo base_url();?>mindfaq_affinity"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-500">
                            <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
                        </svg>  <span>  MindFAQ </span></a> 
                    </li>
                    <li id="more-veiw" hidden><a href="#"> 
                        <img src="<?php echo base_url();?>assets/gamification/images/ticket.svg" class="small-svg" alt="">
                       <span> MyTicket</span> </a> 
                    </li>
                    <li id="more-veiw" hidden><a > 
                        <img src="<?php echo base_url();?>assets/gamification/images/attendance.svg" class="small-svg" alt="">
                       <span id="attendance"> Attendance</span> </a> 
                    </li>
                    <li id="more-veiw" hidden><a href="<?php echo base_url();?>leave/" target="_blank"> 
                        <img src="<?php echo base_url();?>assets/gamification/images/exit.svg" class="small-svg" alt="">
                       <span> Leave</span> </a> 
                    </li>
                    <li id="more-veiw" hidden><a href="<?php echo base_url();?>pip" target="_blank"
                        .> 
                        <img src="<?php echo base_url();?>assets/gamification/images/pipe.svg" class="small-svg" alt="">
                       <span> PIP</span> </a> 
                    </li>
                    <li id="more-veiw" hidden><a href="<?php echo base_url();?>kat" target="_blank"> 
                        <img src="<?php echo base_url();?>assets/gamification/images/thought.svg" class="small-svg" alt="">
                       <span> PKT (knowledge Test)</span> </a> 
                    </li>
                </ul>

                <a href="#" class="see-mover h-10 flex my-1 pl-2 rounded-xl text-gray-600" uk-toggle="target: #more-veiw; animation: uk-animation-fade"> 
                    <span class="w-full flex items-center" id="more-veiw">
                        <svg class="  bg-gray-100 mr-2 p-0.5 rounded-full text-lg w-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        See More  
                    </span>
                    <span class="w-full flex items-center" id="more-veiw" hidden>
                        <svg  class="bg-gray-100 mr-2 p-0.5 rounded-full text-lg w-7"  fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg> 
                        See Less 
                    </span>
                </a> 

                <hr>

                
                <!--<h3 class="text-lg mt-3 font-semibold ml-2 is-title"> Ted Talks </h3>

                <div class="contact-list my-2 ml-1">
                
                    <a href="#">
                        <div class="contact-avatar">
                            <img src="<?php echo base_url();?>assets/gamification/images/avatars/avatar-1.jpg" alt="">
                            <span class="user_status status_online"></span>
                        </div>
                        <div class="contact-username"> Prasun Das</div>
                    </a>
                    <a href="#">
                        <div class="contact-avatar">
                            <img src="<?php echo $prof_pic_url;?>" alt="">
                            <span class="user_status"></span>
                        </div>
                        <div class="contact-username"> Manash Kundu</div>
                    </a>
                    <a href="#">
                        <div class="contact-avatar">
                            <img src="<?php echo base_url();?>assets/gamification/images/avatars/avatar-7.jpg" alt="">
                        </div>
                        <div class="contact-username">Kunal Bose</div>
                    </a>
                    <a href="#">
                        <div class="contact-avatar">
                            <img src="<?php echo base_url();?>assets/gamification/images/avatars/avatar-4.jpg" alt="">
                        </div>
                        <div class="contact-username"> Vikash Kumar</div>
                    </a>
    
                </div> --> 
                <hr>
                <div class="footer-links">
                    <a href="<?php echo base_url();?>gamify/dashboard">Home</a>
                    <a href="<?php echo base_url();?>qa_graph" target="_blank">QA </a>
                    <a href="<?php echo base_url();?>pmetrix_v2" target="_blank">Perfomance</a>
                    <a href="<?php echo base_url();?>process_update" target="_blank">Update</a>                    
                </div>

                
 
            </div>
        
        </div> 

        <!-- Main Contents -->
        <div class="main_content">
            <div class="mcontainer">

                <div class="profile user-profile">
  
                    <div class="profiles_banner">
                        <img src="<?php echo base_url();?>assets/gamification/images/avatars/profile-cover.jpg" alt="">
                        <div class="chart-content1">
                            <div id="demo" class="carousel slide" data-ride="carousel">
                                <!-- The slideshow -->
                              <div class="carousel-inner">
                                <div class="carousel-item active">
                                  <div class="row align-items-center">
                                        <div class="col-sm-3">
                                            <div class="chart-content">
                                                <div class="body-widget text-center first-chart">
                                                    <h2 class="heading-title-white">
                                                        My Average Day
                                                    </h2>
                                                    <div id="piechart"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">              
                                            <div class="body-widget text-center second-chart">
                                                <h2 class="heading-title-white">
                                                    Absent
                                                    <?php  $abp= number_format(floatval(($header_data['absent']/$header_data['total'])*100), 2, '.', '');?>
                                                </h2>
                                                <div class="circle-main">    
                                                    <div id="circle4"
                                                         class="circle-default-style" data-percent="<?php echo ($abp!='nan')?$abp:'0';?>" data-no-percentage-sign="true" data-animation="false" data-stroke-linecap="round">
                                                    </div>
                                                </div>
                                            </div>              
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="body-widget text-center third-chart">
                                                <h2 class="heading-title-white">
                                                    Adherence %
                                                </h2>                   
                                                <div class="circle-main left-side">    
                                                    <div id="circle5"
                                                         class="circle-default-style" data-percent="<?php echo $header_data['adherence'];?>" data-no-percentage-sign="true" data-animation="false" data-stroke-linecap="round">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="body-widget text-center four-chart">
                                                <h2 class="heading-title-white1">
                                                    Shirinkage %
                                                </h2>                   
                                                <div class="circle-main">    
                                                    <div id="circle6"
                                                         class="circle-default-style" data-percent="<?php echo $header_data['shrinkage'];?>" data-no-percentage-sign="true" data-animation="false" data-stroke-linecap="round">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row align-items-center">
                                        <div class="col-sm-3">
                                            <div class="body-widget text-center first-chart1">
                                                <h2 class="heading-title-white">
                                                    Quality
                                                </h2>
                                                <div class="circle-main">    
                                                    <div id="circle7"
                                                         class="circle-default-style" data-percent="60" data-no-percentage-sign="true" data-animation="false" data-stroke-linecap="round">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="body-widget text-center second-chart1">
                                                <h2 class="heading-title-white">
                                                    Perfomance
                                                </h2>
                                                <div class="circle-main">    
                                                    <div id="circle8"
                                                         class="circle-default-style" data-percent="60" data-no-percentage-sign="true" data-animation="false" data-stroke-linecap="round">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="body-widget text-center third-chart1">
                                                <h2 class="heading-title-white">
                                                   Present %
                                                </h2>
                                                <?php  $present= number_format(floatval(($header_data['present']/$header_data['total'])*100), 2, '.', '');?>
                                                <div class="circle-main">    
                                                    <div id="circle9"
                                                         class="circle-default-style" data-percent="<?php echo ($present!='nan')?$present:'0';?>" data-no-percentage-sign="true" data-animation="false" data-stroke-linecap="round">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="body-widget text-center">
                                                <h2 class="heading-title-white1">
                                                    Leave %
                                                </h2>
                                                <div class="circle-main">    
                                                    <div id="circle10"
                                                         class="circle-default-style" data-percent="<?php echo $header_data_leave;?>" data-no-percentage-sign="true" data-animation="false" data-stroke-linecap="round">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                              </div>
                              
                              <!-- Left and right controls -->
                              <a class="carousel-control-prev left-arrow" href="#demo" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                              </a>
                              <a class="carousel-control-next left-arrow" href="#demo" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                              </a>
                            </div>
                        </div>
                    </div>
					
					<div class="profiles_content">
                        <div class="profile_avatar">
                            <div class="profile_avatar_holder"> 
                                <img src="<?php echo $prof_pic_url;?>" style="margin:auto;display:block;" alt="">
                            </div>
                            <div class="user_status status_online"></div>
                            <div class="icon_change_photo" hidden> <ion-icon name="camera" class="text-xl"></ion-icon> </div>
                        </div>						
                    </div>
					
                   <div class="profile-widget">
                        <div class="row align-items-center">
                            <div class="col-sm-5">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="white-widget1">
                                    <div class="lunch-left">
                                        <div class="lunch-main">
                                            <div class="body-widget">
                                                <h3 class="lunch-title">Lunch (Off)</h3>
                                            </div>
                                            <div class="body-widget">
                                                <label class="switch">
                                                  <input type="checkbox">
                                                  <span class="slider-toggle round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="minute-widget1 text-center">
                                        <a href="#" class="minute-btn">
                                            <h3 class="minute-title">45</h3>
                                            <h4 class="minute-sub-title">
                                                Min
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="white-widget1 left-one">
                                            <div class="lunch-left">
                                                <div class="lunch-main">
                                                    <div class="body-widget">
                                                        <h3 class="lunch-title">Otherbreak</h3>
                                                    </div>
                                                    <div class="body-widget">
                                                        <label class="switch">
                                                          <input type="checkbox">
                                                          <span class="slider-toggle round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="minute-widget1 text-center">
                                                <h3 class="minute-title">15</h3>
                                                <h4 class="minute-sub-title">
                                                    Min
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="profile-main">
                                    <div class="body-widget text-center">
                                        <h1 class="profile-title">
                                            <?php echo $main_info['fname'].' '.$main_info['lname'];?>
                                        </h1>
                                        <p><?php echo $main_info['org_name'];?>, <?php echo $main_info['dept_name'];?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="right-area">
                                    <div class="white-widget1 left-one">
                                        <div class="lunch-left">
                                            <div class="lunch-main">
                                                <div class="body-widget">
                                                    <h3 class="lunch-title"><a data-toggle="modal" data-target="#schedule" style="cursor:pointer;">schedule <br> available</a></h3>
                                                </div>      
                                            </div>
                                        </div>
                                        <a href="#" class="minute-btn">
                                            <div class="minute-widget text-center right-btn">
                                            </div>
                                        </a>
                                    </div>      
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-widget">
                    <div class="flex justify-between lg:border-t flex-col-reverse lg:flex-row">
                        <nav class="responsive-nav pl-2 is_ligh -mb-0.5 border-transparent">
                            <ul  uk-switcher="connect: #timeline-tab; animation: uk-animation-fade">
                                <li><a href="#"> Timeline</a></li>
                                <li><a href="#">Performance</a></li>
                                <li><a href="#">Quality </a></li>
                                <li><a href="#">KAT</a></li> 
                                <!-- <li><a href="#">Updates</a></li>  -->
                                <li><a href="#">Announcements</a></li> 
                                <!-- <li><a href="#">Interests</a></li> 
                                <li><a href="#">Media</a></li> --> 
                                <li><a href="#">News</a></li> 
                            </ul>
                        </nav>
                        
                    </div>
                    </div>
                </div>

                
                <div class="uk-switcher" id="timeline-tab">
 

                    <!-- Timeline -->
                    <div class="md:flex md:space-x-6 lg:mx-16">
                        <div class="space-y-5 flex-shrink-0 md:w-7/12">
      
                           <!-- Timeline  -->
                           
                           <div class="card lg:mx-0 p-3" uk-toggle="target: #create-post-modal">
                               <div class="flex space-x-3">
                                   <img src="<?php echo $prof_pic_url;?>" class="w-10 h-10 rounded-full">
                                   <input placeholder="What's Your Mind ? Hamse!" class="bg-gray-100 hover:bg-gray-200 flex-1 h-10 px-6 rounded-full"> 
                               </div>
                               <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 font-semibold text-sm">
                                   <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                     <svg class="bg-blue-100 h-9 mr-2 p-1.5 rounded-full text-blue-600 w-9 -my-0.5 hidden lg:block" data-tippy-placement="top" title="Tooltip" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                     Photo/Video 
                                   </div>
                                   <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                      <svg class="bg-green-100 h-9 mr-2 p-1.5 rounded-full text-green-600 w-9 -my-0.5 hidden lg:block" uk-tooltip="title: Messages ; pos: bottom ;offset:7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" title="" aria-expanded="false"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                      Tag Friend 
                                   </div>
                                   <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                   <svg class="bg-red-100 h-9 mr-2 p-1.5 rounded-full text-red-600 w-9 -my-0.5 hidden lg:block" uk-tooltip="title: Messages ; pos: bottom ;offset:7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" title="" aria-expanded="false"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                   Fealing /Activity 
                                   </div>
                               </div> 
                           </div>
                           <?php if(sizeof($pmatrex['content']!=0)){ ?>
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime($pmatrex['post_date']));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>
                   
                               <div class="w-full h-full">
                                <div class="table-widget1">
                                    <table class="table table-bordered">
                                        <thead>
                                          <tr>      
                                            <th colspan="2">D2D Battle</th>
                                            <th>Score</th>
                                            <th>View</th>
                                            <th>Point</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                         <?php 
                                                foreach($pmatrex["content"] as $w=>$v):
                                         ?> 
                                            
                                                    <tr>
                                                        <td colspan="2"><strong><?php print $v["kpi_name"]; ?></strong></td>
                                                        <td>
                                                            <?php print $v["mtd_value"]; ?>
                                                            <?php
                                                                $target=str_replace(':','',str_replace('%','',$v["target"]));
                                                                $mtd=str_replace(':','',str_replace('%','',$v["mtd_value"]));
                                                                if($mtd>$target){
                                                            ?>
                                                            <span class="green-arrow">
                                                                <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="red-arrow">
                                                                <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                                                            </span>
                                                          <?php } ?>  
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo base_url();?>Pmetrix_v2" class="edit-link">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                           <?php  
                                                                $point = ($mtd>$target)?'5':'0'; echo $point.'Pts';
                                                                $_process_id=end(explode(',',$pValue));
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <div class="view-link">
                                                                <?php 
                                                                    if($point>0){
                                                                        $chk=check_point_collect_status($prof_uid,$pmatrex_date,$w);
                                                                ?>
                                                                <a id="<?php echo $prof_uid.$w.'collect';?>" onclick="add_pmatrex_point('<?php echo $prof_uid.','.$_process_id.','.$w.','.$point.','.$pmatrex_date;?>');" style="cursor: pointer;display:<?php echo ($chk==1)?'none':'';?>">
                                                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                                    Collect
                                                                </a>
                                                                <a id="<?php echo $prof_uid.$w.'already';?>" style="cursor: pointer;display: <?php echo ($chk==1)?'':'none';?>;">
                                                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                                    Already Collect
                                                                </a>
                                                            <?php }
                                                                elseif($point<=0){ 
                                                            $chk=check_point_collect_status($prof_uid,$pmatrex_date,$w);  
                                                            ?>      
                                                            <span class="<?php echo ($chk==1)?'alreadycollected':'atocollect';?>" atcol="<?php echo $prof_uid.','.$_process_id.','.$w.','.$point.','.$pmatrex_date;?>">                               
                                                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                                    Auto Collect
                                                             </span> 
                                                             <?php } ?>      
                                                            </div>
                                                        </td>
                                                  </tr>
                                        <?php endforeach; ?> 
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $pmatrex['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $pmatrex['id'];?>"><?php echo total_likes_data($pmatrex['id'],$prof_uid);?></span></a>
                                       </a>
                                       
                                   </div>
                   
                               </div>
                   
                           </div>
                            <?php }?>
                           <?php 
                           if(sizeof($qmatrex['content'])!=0){
                            ?>
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime($qmatrex['post_date']));?>
                                           </div>
                                       </div>
                                   </div>

                                <!------------------edit update option---------------->
                               </div>
                   
                               <div class="w-full h-full">
                                <div class="table-widget1">
                                    <table class="table table-bordered">
                                        <thead>
                                          <tr>      
                                            <th colspan="2">QA D2D Battle<!--KPI/Events--></th>
                                            <th>Score</th>
                                            <th>View</th>
                                            <th>Point</th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($qmatrex['content'] as $w=>$v):?> 
                                        
                                          <tr>
                                            <td colspan="2"><strong><?php print $v["kpi_name"]; ?></strong></td>
                                            <td>
                                                <?php print $v["mtd_value"]; ?>
                                                    <?php
                                                        $target=str_replace(':','',str_replace('%','',$v["target"]));
                                                        $mtd=str_replace(':','',str_replace('%','',$v["mtd_value"]));
                                                        if($mtd>$target){
                                                    ?>
                                                    <span class="green-arrow">
                                                        <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="red-arrow">
                                                        <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                                                    </span>
                                                  <?php } ?> 
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#qaModal" class="edit-link">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td>
                                               <?php
                                                     $point = ($mtd>$target)?'5':'0'; echo $point.'Pts';
                                                     $_process_id=end(explode(',',$pValue));
                                                ?>     
                                            </td>
                                            <td>
                                                <div class="view-link">
                                                    <?php 
                                                        if($point>0){
                                                            $chk=check_point_collect_status($prof_uid,$pmatrex_date,$w);
                                                        ?>
                                                        <a id="<?php echo $prof_uid.$w.'collect';?>" onclick="add_pmatrex_point('<?php echo $prof_uid.','.$_process_id.','.$w.','.$point.','.$pmatrex_date;?>');" style="cursor: pointer;display:<?php echo ($chk==1)?'none':'';?>">
                                                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                            Collect
                                                        </a>
                                                        <a id="<?php echo $prof_uid.$w.'already';?>" style="cursor: pointer;display: <?php echo ($chk==1)?'':'none';?>;">
                                                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                            Already Collect
                                                        </a>
                                                    <?php }
                                                            elseif($point<=0){ 
                                                                 $chk=check_point_collect_status($prof_uid,$pmatrex_date,$w);
                                                    ?>      
                                                    <span class="<?php echo ($chk==1)?'alreadycollected':'atocollect';?>" atcol="<?php echo $prof_uid.','.$_process_id.','.$w.','.$point.','.$pmatrex_date;?>">                               
                                                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                            Auto Collect
                                                     </span>       
                                                    <?php } ?>
                                                </div>
                                            </td>
                                          </tr> 
                                          <?php endforeach; ?> 
                                          
                                        </tbody>
                                      </table>
                              </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $qmatrex['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $qmatrex['id'];?>"><?php echo total_likes_data($qmatrex['id'],$prof_uid);?></span></a>
                                       </a>
                                   </div>
                               </div>
                   
                           </div>
                           <?php } ?>
                           <?php 
                            //echo sizeof($training_score['content']);
                           if(sizeof($training_score['content'])!=0){ 
                                foreach($training_score['content'] as $ky=>$rows){
                            ?>
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime(GetLocalTime()));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>
                   
                               <div class="w-full h-full">
                                    <div class="frame-widget">
                                        <svg id="svg"></svg>
                                        <div class="score-widget">
                                            <?php echo $rows['score'];?>%
                                        </div>
                                    </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $training_score['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $training_score['id'];?>"><?php echo total_likes_data($training_score['id'],$prof_uid);?></span></a>
                                       </a>
                                       
                                   </div>
                                                     
                               </div>
                   
                           </div>
                           <?php }} ?>
                           <!----- kat card --->
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime(GetLocalTime()));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>                   
                               <div>
                                <div class="graph-widget">
                                       <div class="row">
                                            <div class="col-sm-6">
                                                <div class="graph-main">
                                                    <div class="first-widget">
                                                        <div class="rainbow">
                                                            <?php echo intval($kat['wk1']);?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="graph-main">
                                                    <div class="second-widget">
                                                        <div class="rainbow">
                                                            <?php echo intval($kat['wk2']);?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="graph-main">
                                                    <div class="third-widget">
                                                        <div class="rainbow">
                                                            <?php echo intval($kat['wk3']);?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="graph-main">
                                                    <div class="four-widget">
                                                        <div class="rainbow">
                                                            <?php echo intval($kat['wk4']);?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="main-cirlce">
                                            <div class="main-cirlce1">
                                            </div>
                                            <div class="main-cirlce2"></div>
                                            <div class="middle-content">
                                                50%
                                            </div>
                                            <div class="circle-top">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="wickt-widget">
                                                            <div class="first-left">
                                                                <h2 class="wicket1">
                                                                  KAT  WK 1
                                                                </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="wickt-widget">
                                                            <div class="second-left">
                                                            <h2 class="wicket1">
                                                              KAT  WK 2
                                                            </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="wickt-widget">
                                                            <div class="first-left">
                                                            <h2 class="wicket1">
                                                              KAT  WK 3
                                                            </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="wickt-widget">
                                                            <div class="second-left">
                                                            <h2 class="wicket1">
                                                              KAT  WK 4
                                                            </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $kat['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $kat['id'];?>"><?php echo total_likes_data($kat['id'],$prof_uid);?></span></a>
                                       </a>
                                   </div>
                               </div>
                   
                           </div>
                           <!-----end kat card --->
                           <!----- QA card --->
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime(GetLocalTime()));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>                   
                               <div>
                                <div class="graph-widget">
                                       <div class="row">
                                            <div class="col-sm-6">
                                                <div class="graph-main">
                                                    <div class="first-widget">
                                                        <div class="rainbow">
                                                            <?php echo intval($qa['wq1']);?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="graph-main">
                                                    <div class="second-widget">
                                                        <div class="rainbow">
                                                            <?php echo intval($qa['wq2']);?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="graph-main">
                                                    <div class="third-widget">
                                                        <div class="rainbow">
                                                           <?php echo intval($qa['wq3']);?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="graph-main">
                                                    <div class="four-widget">
                                                        <div class="rainbow">
                                                            <?php echo intval($qa['wq4']);?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="main-cirlce">
                                            <div class="main-cirlce1">
                                            </div>
                                            <div class="main-cirlce2"></div>
                                            <div class="middle-content">
                                                50%
                                            </div>
                                            <div class="circle-top">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="wickt-widget">
                                                            <div class="first-left">
                                                                <h2 class="wicket1">
                                                                  QA  WK 1
                                                                </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="wickt-widget">
                                                            <div class="second-left">
                                                            <h2 class="wicket1">
                                                               QA WK 2
                                                            </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="wickt-widget">
                                                            <div class="first-left">
                                                            <h2 class="wicket1">
                                                              QA  WK 3
                                                            </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="wickt-widget">
                                                            <div class="second-left">
                                                            <h2 class="wicket1">
                                                              QA  WK 4
                                                            </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $qa['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $qa['id'];?>"><?php echo total_likes_data($qa['id'],$prof_uid);?></span></a>
                                       </a>
                                   </div>
                               </div>
                   
                           </div>
                           <!-----QA card --->
                            <?php 
                            foreach($Announcement as $key=>$rows){
                                if(sizeof($rows['content'])>0){  

                            ?>
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <!--<div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>-->
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime($rows['content']['added_date']));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>
                   
                   
                               <div class="p-3 border-b dark:border-gray-700">
                                <div class="annoucement-widget">
                                    <img src="<?php echo base_url();?>assets/gamification/images/post/announcement.jpg" alt="">
                                    <div class="annoucemen-content">
                                        <h2 class="heading-title2">
                                        <?php echo substr(strip_tags( $rows['content']['description']),0,50) . "..."; ?>
                                        </h2>
                                        <span id="mycontent_<?php echo $rows['content']['id'];?>" style="display:none;"><?php echo strip_tags( $rows['content']['description']);?></span>
                                        <div class="continue-link">
                                            <a onclick="show_announcement('<?php echo $rows['content']['id'];?>');" style="cursor: pointer;">
                                                Read More 
                                            </a>
                                        </div>
                                    </div>
                                </div>  
                               </div>
                               
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600 ">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                            <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $Announcement['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $Announcement['id'];?>"><?php echo total_likes_data($Announcement['id'],$prof_uid);?></span></a>
                                       </a>
                                       </a>
                                   </div>
                               </div>
                   
                           </div>
                           <?php
                                }
                            } 
                           ?>  
                           <?php if(sizeof($policy['content_text']['policy_list'])>0){ ?>
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime(GetLocalTime()));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>
                   
                               <div class="w-full h-full">
                                  <div class="row align-items-center">
                                    <div class="col-sm-4">
                                        <div class="body-widget">
                                            <img src="<?php echo base_url();?>assets/gamification/images/post/hr-update.jpg" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="body-widget">
                                            <?php foreach($policy['content_text']['policy_list'] as $key=>$rows){ ?>
                                                <?php foreach($policy['content_text']['all_policy_attach'][$rows['id']] as $ky=>$rw){ ?>
                                            <div class="policy-repeat">
                                                <div class="policy-bg">
                                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                    <h2 class="heading-title-white1">
                                                        <?php echo $rows['title'];?>
                                                    </h2>
                                                    <div class="policy-link">
                                                        <a href="<?php echo base_url();?>/uploads/policy/<?php echo $rows['id'].'-'.$rw['file_name'].$rw['ext'];?>">
                                                            Read & Accept
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                  </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $Announcement['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $Announcement['id'];?>"><?php echo total_likes_data($Announcement['id'],$prof_uid);?></span></a>
                                       </a>
                                   </div>
                               </div>
                   
                           </div>
                           <?php } ?>
                           <?php 
                           if(sizeof($org_new)>0){
                                foreach($org_new as $ky=>$rws){
                            ?>        
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime($rws['content']['publishDate']));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>
                   
                               <div class="w-full h-full">
                                  <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="body-widget">
                                            <img src="<?php echo base_url();?>assets/gamification/images/post/fusion-logo.png" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="body-widget">
                                            <div id="box"></div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="body-widget text-center">
                                    <h2 class="heading-title-black">
                                        <?php echo (strlen($rws['content']['title'])<10)?$rws['content']['title']:substr($rws['content']['title'], 0,25).'...';?>
                                    </h2>
                                    <span id="mypresscontent_<?php echo $rws['content']['id'];?>" style="display:none;"><?php echo strip_tags( $rws['content']['title']);?>@@@<?php echo strip_tags( $rws['content']['description']);?></span>
                                        <div class="continue-link">
                                            <a onclick="show_press('<?php echo $rws['content']['id'];?>');" style="cursor: pointer;">
                                                Read More.. 
                                            </a>
                                        </div>
                                  </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $org_new['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $org_new['id'];?>"><?php echo total_likes_data($org_new['id'],$prof_uid);?></span></a>
                                       </a>
                                       </a>
                                   </div>
                               </div>
                           </div>
                           <?php 
                                }
                            }
                           ?>
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?> </a>
                                           <div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime(GetLocalTime()));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>
                   
                               <div class="w-full h-full">
                                  <div class="schedule-widget">
                                    <img src="<?php echo base_url();?>assets/gamification/images/post/computer.png" class="img-fluid" alt="">
                                    <div class="schedule-content">
                                        <div class="location-widget">
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">
                                                    <table class="table table-striped">
                                                        <thead>
                                                          <tr>
                                                            <th>Location</th>
                                                            <th>Date</th>        
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <tr>
                                                            <td>Kolkata</td>
                                                            <td>28.05.2021</td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                </div>
                                            </div>
                                            <div class="clock-bg">
                                                <img src="<?php echo base_url();?>assets/gamification/images/post/clock-bg.png" class="clock-img" alt="">
                                            </div>
                                            <div class="time-widget-new">
                                                <canvas id="canvas" width="100" height="100"></canvas>
                                            </div>              
                                        </div>      
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="schedule-bg">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="schedule-bg">
                                                    Reason
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="schedule-bg">
                                                    Impact or Concern Area
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="schedule-bg">
                                                    Resolution
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="schedule-bg">
                                                    Down Time hours
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="schedule-bg">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-main">
                                            <h2 class="author-title">
                                                IT
                                            </h2>
                                        </div>
                                        <div class="right-setting">
                                            <div class="body-widget">
                                                <img src="<?php echo base_url();?>assets/gamification/images/post/setting-right.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <div> Like</div>
                                       </a>
                                   </div>
                               </div>
                           </div>
                           
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"><?php echo $main_info['fname'].' '.$main_info['lname'];?></a>
                                           <!--<div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>-->
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime(GetLocalTime()));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>
                   
                               <div class="w-full h-full">
                                    <div class="late-widget">
                                        <img src="<?php echo base_url();?>assets/gamification/images/post/office-late.jpg" class="img-fluid" alt="">
                                        <div class="late-content">
                                            <div class="late-center">
                                                <h3 class="absent-title">
                                                    Absent
                                                </h3>
                                                <div class="count-bg">
                                                    <?php echo sizeof($absent['content']);?>  
                                                </div>
                                                <div class="leave-link">
                                                    <a href="<?php echo base_url();?>/leave/">
                                                        Apply for Leave
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $absent['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $absent['id'];?>"><?php echo total_likes_data($absent['id'],$prof_uid);?></span></a>
                                       </a>
                                       </a>
                                   </div>
                               </div>
                           </div>
                           
                           <?php if(sizeof($late['content'])>0){ ?>
                           <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               <!-- post header-->
                               <div class="flex justify-between items-center lg:p-4 p-2.5">
                                   <div class="flex flex-1 items-center space-x-4">
                                       <a href="#">
                                           <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       </a>
                                       <div class="flex-1 font-semibold capitalize">
                                           <a href="#" class="text-black dark:text-gray-100"> <?php echo $main_info['fname'].' '.$main_info['lname'];?></a>
                                           <!--<div class="text-gray-700 flex items-center space-x-2 updated"> Updated 5 <span> hrs </span> <ion-icon name="people"></ion-icon></div>-->
                                           <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime(GetLocalTime()));?>
                                           </div>
                                       </div>
                                   </div>
                                 <div>
                                   <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                                   <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                                   uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                 
                                       <ul class="space-y-1">
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-share-alt mr-1"></i> Share
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                             </a> 
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-comment-slash mr-1"></i>   Disable comments
                                             </a> 
                                         </li> 
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                              <i class="uil-favorite mr-1"></i>  Add favorites 
                                             </a> 
                                         </li>
                                         <li>
                                           <hr class="-mx-2 my-2 dark:border-gray-800">
                                         </li>
                                         <li> 
                                             <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                              <i class="uil-trash-alt mr-1"></i>  Delete
                                             </a> 
                                         </li>
                                       </ul>
                                   
                                   </div>
                                 </div>
                               </div>
                   
                               <div class="w-full h-full">
                                    <div class="late-widget">
                                        <img src="<?php echo base_url();?>assets/gamification/images/post/late.jpg" class="img-fluid" alt="">
                                        <div class="little-late-content">
                                            <div class="late-circle">
                                                <div class="late-count">
                                                    <h2 class="late-meter">
                                                        late'0 Meter
                                                    </h2>
                                                    <div class="late-bg">
                                                        <?php echo $late['content']['lateTime'];?> Min
                                                    </div>
                                                    <h3 class="shift-time">
                                                        <?php echo $late['content']['in_time'];?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $late['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $late['id'];?>"><?php echo total_likes_data($late['id'],$prof_uid);?></span></a>
                                       </a>
                                       </a>
                                   </div>
                               </div>
                           </div>
                           
                           <?php } ?>
                           <div id="content_data"></div>
                   
                           <div class="flex justify-center mt-6">
                               <a href="#" class="bg-white font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                   Load more ..</a>
                           </div>
                       
      
                        </div>

                        <!-- Sidebar -->
                        <div class="w-full space-y-6">
                        
                            <div class="widget card p-3">
                                <div class="top-winner">
                            <div class="body-widget text-center">
                                <img id="mypic" src="<?php echo $prof_pic_url;?>" class="circle-img2" alt="">
                                <h2 class="heading-green">
                                    <i class="fa fa-trophy" aria-hidden="true"></i>
                                    <span id="mypoint"><?php echo $mypoint;?></span> Pts
                                </h2>
                            </div>
                            <div class="winner-widget">
                                <div class="count-bg">
                                    1
                                </div>
                            </div>
                        </div>
                        <div class="bottom-widget">
                            <div class="row">
                                <?php foreach($compit as $k=>$rows){ ?>
                                <div class="col-md-4">
                                    <div class="top-winner">
                                        <div class="body-widget text-center">
                                            <img id="mypic<?php echo ($k+1);?>" src="<?php echo $rows['pic'];?>" class="circle-img2" alt="">
                                            <h2 class="heading-green">
                                                <i class="fa fa-trophy" aria-hidden="true"></i>
                                                <?php
                                                 $ids='firstpoint';
                                                 if($k==0)$ids='firstpoint';
                                                 if($k==1)$ids='secondpoint';
                                                 if($k==2)$ids='thirdpoint';
                                                ?>
                                                <span id="<?php echo $ids;?>"><?php echo $rows['score'];?></span> Pts
                                            </h2>
                                        </div>
                                        <div class="winner-widget">
                                            <div class="count-bg">
                                                <?php echo ($k+1);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                            </div>
                            
                            <div class="widget card p-3">
                                <h4 class="text-lg font-semibold"> Notification </h4>
                                <div class="notification-widget">
                                    <div class="notification-main box">
                                     <?php 
                                     
                                     foreach($pending_policy as $key=>$rw){?>
                                     <div class="note-repeat">
                                            <div class="note-left">
                                                <span>Policy</span> 
                                                <small></small>
                                            </div>
                                            <p>
                                                <?php echo $rw['title'];?><button title="" titleJS="" adpid='<?php echo $rw['id'] ?>' type='button' class='acptPolicy float-right btn btn-warning btn-xs' data-toggle='modal'style="margin-top: -21px;height: 37px;">Accept Policy</button>
                                            </p>
                                            <!-- <div class="arrow-link ">
                                                
                                            </div> -->
                                       </div>
                                     <?php } ?>          
                                    <?php foreach($org_new as $ky=>$row1){ ?>
                                        <div class="note-repeat">
                                            <div class="note-left">
                                                <span>Advertisment</span> 
                                                <small><?php echo date('d/m/Y',strtotime($row1['content']['publish_date']));?></small>
                                            </div>
                                            <p>
                                                <?php echo $row1['content']['title'];?>
                                            </p>
                                            <div class="arrow-link">
                                                <a href="#">
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                            <!--<img src="<?php echo base_url();?>assets/gamification/images/post/img-1.jpg" class="note-img" alt="">-->       
                                        </div>
                                        
                                        <?php } ?>
                                    </div>
                                    
                                </div>
                            </div>
                        
                            <div class="widget card p-3 border-t">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold"> Friends </h4>
                                        <p class="text-sm"> <?php echo (sizeof($friendlist)+$friendcont1[0]['fcount']);?> Friends</p>
                                    </div>
                                    <a onclick="display_friendlist();" class="text-blue-600 ">See all</a>
                                    <input type="hidden" name="dpfriend" id="dpfriend" value="0">
                                </div>
                                <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                                 <?php
                                    $i=1; 
                                    foreach($friendlist as $k=>$rws){ 
                                    ?> 
                                    <span id="disf_<?php echo $i;?>" class="flist" style="display:<?php echo ($i>6)?'none':'';?>">  
                                    <a href="#">  
                                        <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                            <?php  $path =base_url().'pimgs/'.$rws['fusion_id'].'/'.$rws['fusion_id'].'.'.$rws['pic_ext'];?>
                                            <img src="<?php echo base_url();?><?php echo (file_exists($path))?'pimgs/'.$rws['fusion_id'].'/'.$rws['fusion_id'].'.'.$rws['pic_ext']:'assets/gamification/images/noimage.png';?>" alt="" class="w-full h-full object-cover absolute">
                                        </div>
                                        <div class="text-sm truncate"> <?php echo ucwords($rws['fname']);?> <?php echo ucwords($rws['lname']);?></div>
                                    </a>
                                </span>
                                  <?php 
                                        $i++;
                                     } 
                                    
                                    foreach($friendlist1 as $k=>$rws){ 
                                    ?> 
                                    <span id="disf_<?php echo $i;?>" class="flist" style="display:none">  
                                    <a href="#">  
                                        <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                            <?php  $path =base_url().'pimgs/'.$rws['fusion_id'].'/'.$rws['fusion_id'].'.'.$rws['pic_ext'];?>
                                            <img src="<?php echo base_url();?><?php echo (file_exists($path))?'pimgs/'.$rws['fusion_id'].'/'.$rws['fusion_id'].'.'.$rws['pic_ext']:'assets/gamification/images/noimage.png';?>" alt="" class="w-full h-full object-cover absolute">
                                        </div>
                                        <div class="text-sm truncate"> <?php echo ucwords($rws['fname']);?> <?php echo ucwords($rws['lname']);?></div>
                                    </a>
                                </span>
                                  <?php 
                                        $i++;
                                     } 
                                  ?>    
                                    
                                </div>
                              <a onclick="display_friendlist();" class="button gray mt-3 w-full">  See all </a>
                            </div>
                            
                            
                            
      
                            <div class="widget card p-3 border-t">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h4 class="text-lg font-semibold"> Who to Follow </h4>
                                    </div>
                                    <a onclick="showfollow();" class="text-blue-600 " style="cursor:pointer;"> See all</a>
                                    <input type="hidden" name="opfollow" id="opfollow" value="0">
                                </div>
                                <div>
                                <?php 
                                    $i=1;
                                    foreach($follow_list as $ky=>$rows){ 
                                      $path =base_url().'pimgs/'.$rows['fusion_id'].'/'.$rows['fusion_id'].'.'.$rows['pic_ext'];  
                                ?>
                                  <div id="fell_<?php echo $i;?>" style="display: <?php echo($i>4)?'none':'';?>" class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50 fellclass">
                                      <a href="#" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                          <img src="<?php echo base_url();?><?php echo(file_exists($path))?'pimgs/'.$rows['fusion_id'].'/'.$rows['fusion_id'].'.'.$rows['pic_ext']:'assets/gamification/images/noimage.png';?>" class="absolute w-full h-full inset-0 " alt="">
                                      </a>
                                      <div class="flex-1">
                                          <a href="#" class="text-base font-semibold capitalize">
                                            <?php echo $rows['fname'];?>  <?php echo $rows['lname'];?> </a>
                                          <div class="text-sm text-gray-500 mt-0.5"> <?php echo $rows['count_follows'];?>  Following</div>
                                      </div>
                                      <a onclick="add_follower('<?php echo $rows['id'];?>');"  class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white" style="cursor: pointer;">
                                          Follow
                                      </a>
                                  </div>
                                 <?php 
                                    $i++;
                                    }
                                 ?>                         
                                </div>
                            </div>
                            
                            <div class="race-widget make-me-sticky">
                            <div class="road">
<div>
    <div>
    <div class="slices">
        <div style="height: 272px; bottom: 0px; --skew: 1; --turn1: 5px; --turn2: 14px;">
            <div></div>     
        </div>

        <div style="height: 256px; bottom: 272px; --skew: 2; --turn1: 16px; --turn2: 46px;">
            <div></div>
        </div>
        
        <div style="height: 240px; bottom: 528px; --skew: 3; --turn1: 31px; --turn2: 85px;">
            <div></div>
        </div>
    
        <div style="height: 225px; bottom: 768px; --skew: 4; --turn1: 49px; --turn2: 130px;">
            <div></div>
        </div>
    
        <div style="height: 210px; bottom: 993px; --skew: 5; --turn1: 70px; --turn2: 180px;">
            <div></div>
        </div>
    
        <div style="height: 196px; bottom: 1203px; --skew: 6; --turn1: 93px; --turn2: 234px;">
            <div></div>
        </div>
    
        <div style="height: 182px; bottom: 1399px; --skew: 7; --turn1: 118px; --turn2: 292px;">
            <div></div>
        </div>
        
        <div style="height: 169px; bottom: 1581px; --skew: 8; --turn1: 144px; --turn2: 352px;">
            <div></div>
        </div>
    
        <div style="height: 156px; bottom: 1750px; --skew: 9; --turn1: 171px; --turn2: 414px;">
            <div></div>
        </div>
    
        <div style="height: 144px; bottom: 1906px; --skew: 10; --turn1: 199px; --turn2: 478px;">
            <div></div>
        </div>
    
        <div style="height: 132px; bottom: 2050px; --skew: 11; --turn1: 227px; --turn2: 542px;">
            <div></div>
        </div>
    
        <div style="height: 121px; bottom: 2182px; --skew: 12; --turn1: 255px; --turn2: 606px;">
            <div></div>
        </div>
    
        <div style="height: 110px; bottom: 2303px; --skew: 13; --turn1: 283px; --turn2: 670px;">
            <div></div>
        </div>
    
        <div style="height: 100px; bottom: 2413px; --skew: 14; --turn1: 310px; --turn2: 733px;">
            <div></div>
        </div>
    
        <div style="height: 90px; bottom: 2513px; --skew: 15; --turn1: 336px; --turn2: 795px;">
            <div></div>
        </div>
    
        <div style="height: 81px; bottom: 2603px; --skew: 16; --turn1: 361px; --turn2: 855px;">
            <div></div>
        </div>
    
        <div style="height: 72px; bottom: 2684px; --skew: 17; --turn1: 385px; --turn2: 913px;">
            <div></div>
        </div>
    
        <div style="height: 64px; bottom: 2756px; --skew: 18; --turn1: 408px; --turn2: 968px;">
            <div></div>
        </div>
    
        <div style="height: 56px; bottom: 2820px; --skew: 19; --turn1: 429px; --turn2: 1020px;">
            <div></div>
        </div>
    
        <div style="height: 49px; bottom: 2876px; --skew: 20; --turn1: 449px; --turn2: 1069px;">
            <div></div>
        </div>
    
        <div style="height: 42px; bottom: 2925px; --skew: 21; --turn1: 467px; --turn2: 1114px;">
            <div></div>
        </div>
    
        <div style="height: 36px; bottom: 2967px; --skew: 22; --turn1: 483px; --turn2: 1156px;">
            <div></div>
        </div>
    
        <div style="height: 30px; bottom: 3003px; --skew: 23; --turn1: 497px; --turn2: 1194px;">
            <div></div>
        </div>
    
        <div style="height: 25px; bottom: 3033px; --skew: 24; --turn1: 510px; --turn2: 1228px;">
            <div></div>
        </div>
    
        <div style="height: 20px; bottom: 3058px; --skew: 25; --turn1: 521px; --turn2: 1258px;">
            <div></div>
        </div>
    
        <div style="height: 16px; bottom: 3078px; --skew: 26; --turn1: 530px; --turn2: 1284px;">
            <div></div>
        </div>
    
        <div style="height: 12px; bottom: 3094px; --skew: 27; --turn1: 537px; --turn2: 1305px;">
            <div></div>
        </div>
    
        <div style="height: 9px; bottom: 3106px; --skew: 28; --turn1: 543px; --turn2: 1322px;">
            <div></div>
        </div>
    
        <div style="height: 6px; bottom: 3115px; --skew: 29; --turn1: 547px; --turn2: 1335px;">
            <div></div>
        </div>
    
        <div style="height: 4px; bottom: 3121px; --skew: 30; --turn1: 550px; --turn2: 1345px;">
            <div></div>
        </div>
        
        <div style="height: 2px; bottom: 3125px; --skew: 31; --turn1: 552px; --turn2: 1351px;">
            <div></div>
        </div>
        
        <div style="height: 1px; bottom: 3127px; --skew: 32; --turn1: 553px; --turn2: 1354px;">
            <div></div>
        </div>
                
    </div>
    </div>
    <div class="sky"></div>
</div>
</div>
    <div class="profile-content">
        <div class="profile-pic1">
            <img src="<?php echo base_url();?>assets/gamification/images/post/profile1.jpg" data-toggle="tooltip" title="Kunal Bose" class="profile-img" alt="">
            
            <img src="<?php echo base_url();?>assets/gamification/images/post/profile1.jpg" data-toggle="tooltip" title="Manash Kundu" class="profile-img1" alt="">
            
            <img src="<?php echo base_url();?>assets/gamification/images/post/profile1.jpg" data-toggle="tooltip" title="Prasun Das" class="profile-img2" alt="">
        </div>      
    </div>
</div>
      
                        </div>
                    </div>
                          
                    <!-- Friends  -->
                    <div class="card md:p-6 p-2 max-w-3xl mx-auto">

                        <h2 class="text-xl font-semibold"> Performance</h2>

                    <div class="grid md:grid-cols-1 grid-cols-1  gap-x-2 gap-y-4 mt-6">  
                         

                           
                                         <?php 
                                         // echo "<pre>";print_r($performance);
                                                foreach($performance as $key=>$v2): if($key < 4){?>
                                                     <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td colspan="5" style="background: antiquewhite;"><?php echo date('d/m/Y',strtotime($v2['post_date']));  ?></td>
                                            </tr>
                                          <tr>      
                                            <th colspan="2">D2D Battle</th>
                                            <th>Score</th>
                                            <th>View</th>
                                            <th>Point</th>
                                            <!-- <th>Action</th> -->
                                          </tr>
                                        </thead>
                                        <tbody>
                                                   <?php foreach ($v2['content'] as $w => $v) {
                                                    // 
                                         ?> 
                                            
                                                    <tr>
                                                        <td colspan="2"><strong><?php print $v["kpi_name"]; ?></strong></td>
                                                        <td>
                                                            <?php print $v["mtd_value"]; ?>
                                                            <?php
                                                                $target=str_replace(':','',str_replace('%','',$v["target"]));
                                                                $mtd=str_replace(':','',str_replace('%','',$v["mtd_value"]));
                                                                if($mtd>$target){
                                                            ?>
                                                            <span class="green-arrow">
                                                                <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="red-arrow">
                                                                <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                                                            </span>
                                                          <?php } ?>  
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo base_url();?>Pmetrix_v2" class="edit-link">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                           <?php  
                                                                $point = ($mtd>$target)?'5':'0'; echo $point.'Pts';
                                                                $_process_id=end(explode(',',$pValue));
                                                            ?>
                                                        </td>
                                                  </tr>
                                        <?php } } endforeach; ?> 
                                        </tbody>
                                    </table> 
                                    <?php if(count($performance)> 5){ ?>
                                        <div id="content">

                                        </div>

                                        <div class="flex justify-center mt-6">
                                            <a href="#" id="load_pmatrex" lim="5" class="bg-white dark:bg-gray-900 font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                                Load more ..</a>
                                        </div>
                                    <?php } ?>
                        </div>    

                    </div>

                    <!-- Photos  -->
                    <div class="card md:p-6 p-2 max-w-3xl mx-auto">

                                <h2 class="text-2xl font-semibold"> Quality </h2>
                                

                                
                                <div class="grid md:grid-cols-1 grid-cols-1  gap-x-2 gap-y-4 mt-6">  
                           
                                         <?php 
                                         // echo "<pre>";print_r($performance);
                                                foreach($quality as $key=>$v2): if($key < 4){?>
                                                     <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td colspan="5" style="background: antiquewhite;"><?php echo date('d/m/Y',strtotime($v2['post_date']));  ?></td>
                                            </tr> 
                                          <tr>   

                                            <th colspan="2">QA D2D Battle<!--KPI/Events--></th>
                                            <th>Score</th>
                                            <th>View</th>
                                            <th>Point</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                                   <?php foreach ($v2['content'] as $w => $v) {
                                                    // 
                                         ?> 
                                            
                                                    <tr>
                                            <td colspan="2"><strong><?php print $v["kpi_name"]; ?></strong></td>
                                            <td>
                                                <?php print $v["mtd_value"]; ?>
                                                    <?php
                                                        $target=str_replace(':','',str_replace('%','',$v["target"]));
                                                        $mtd=str_replace(':','',str_replace('%','',$v["mtd_value"]));
                                                        if($mtd>$target){
                                                    ?>
                                                    <span class="green-arrow">
                                                        <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="red-arrow">
                                                        <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                                                    </span>
                                                  <?php } ?> 
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#qaModal" class="edit-link">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td>
                                               <?php
                                                     $point = ($mtd>$target)?'5':'0'; echo $point.'Pts';
                                                     $_process_id=end(explode(',',$pValue));
                                                ?>     
                                            </td>
                                            
                                          </tr>
                                        <?php } } endforeach; ?> 
                                        </tbody>
                                    </table> 
                                    <?php if(count($quality)> 5){ ?>
                                        <div id="content">

                                        </div>

                                        <div class="flex justify-center mt-6">
                                            <a href="#" id="load_pmatrex" lim="5" class="bg-white dark:bg-gray-900 font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                                Load more ..</a>
                                        </div>
                                    <?php } ?>
                        </div> 

                        </div>

                    <!-- Pages  -->
                    <div class="card md:p-6 p-2 max-w-3xl mx-auto">
                        <h2 class="text-2xl font-semibold"> KAT </h2>
                        <div class="grid gap-4 mt-5">
                            <?php 
                            // echo "<pre>";print_r($kat_history);
                            foreach ($training_score_history as $key => $value) { ?>
                                <div class="flex flex-1 items-center space-x-4">
                                       <img src="<?php echo $prof_pic_url;?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                       <div class="flex-1 font-semibold capitalize">
                                            <div class="date">
                                            Date : <?php echo  date('d.m.Y',strtotime($value['post_date']));?>
                                           </div>
                                       </div>
                                   </div>
                                <div class="card lg:mx-0 uk-animation-slide-bottom-small">
                   
                               
                   
                               <div class="w-full h-full">
                                    <div class="frame-widget">
                                        <svg id="svg"></svg>
                                        <div class="score-widget">
                                            <?php echo $value['content']['score'];?>%
                                        </div>
                                    </div>
                               </div>
                   
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                           <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $training_score['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $training_score['id'];?>"><?php echo total_likes_data($training_score['id'],$prof_uid);?></span></a>
                                       </a>
                                       
                                   </div>
                                                     
                               </div>
                   
                           </div>
                                
                           <?php }
                             ?>
                            

                        </div>
                        
                    </div>

                    <!-- Groups  -->
                    <!-- <div class="card md:p-6 p-2 max-w-3xl mx-auto">

                        <div class="flex justify-between items-start relative md:mb-4 mb-3">
                            <div class="flex-1">
                                <h2 class="text-2xl font-semibold"> Groups </h2>
                                <nav class="responsive-nav style-2 md:m-0 -mx-4">
                                    <ul>
                                        <li class="active"><a href="#"> Joined <span> 230</span> </a></li>
                                        <li><a href="#"> My Groups </a></li>
                                        <li><a href="#"> Discover </a></li> 
                                    </ul>
                                </nav>
                            </div>
                            <a href="#" data-tippy-placement="left" data-tippy="" data-original-title="Create New Album" class="bg-blue-100 font-semibold py-2 px-6 rounded-md text-sm md:mt-0 mt-3 text-blue-600">
                                Create       
                            </a>
                        </div>

                        <div class="grid md:grid-cols-2  grid-cols-2 gap-x-2 gap-y-4 mt-3"> 
                             
                            <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                <a href="#" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                    <img src="<?php echo base_url();?>assets/gamification/images/group/group-3.jpg" class="absolute w-full h-full inset-0 " alt="">
                                </a>
                                <div class="flex-1">
                                    <a href="#" class="text-base font-semibold capitalize">Graphic Design </a>
                                    <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                </div>
                                <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                    Following
                                </button>
                            </div>
                            <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                <a href="#" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                    <img src="<?php echo base_url();?>assets/gamification/images/group/group-4.jpg" class="absolute w-full h-full inset-0 " alt="">
                                </a>
                                <div class="flex-1">
                                    <a href="#" class="text-base font-semibold capitalize"> Mountain Riders  </a>
                                    <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                </div>
                                <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                    Following
                                </button>
                            </div>
                            <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                <a href="#" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                    <img src="<?php echo base_url();?>assets/gamification/images/group/group-2.jpg" class="absolute w-full h-full inset-0 " alt="">
                                </a>
                                <div class="flex-1">
                                    <a href="#" class="text-base font-semibold capitalize">  Coffee Addicts  </a>
                                    <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                </div>
                                <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                    Following
                                </button>
                            </div>
                            <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                <a href="#" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                    <img src="<?php echo base_url();?>assets/gamification/images/group/group-5.jpg" class="absolute w-full h-full inset-0 " alt="">
                                </a>
                                <div class="flex-1">
                                    <a href="#" class="text-base font-semibold capitalize">  Property Rent  </a>
                                    <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                </div>
                                <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                    Following
                                </button>
                            </div>
                            <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                <a href="#" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                    <img src="<?php echo base_url();?>assets/gamification/images/group/group-1.jpg" class="absolute w-full h-full inset-0 " alt="">
                                </a>
                                <div class="flex-1">
                                    <a href="#" class="text-base font-semibold capitalize"> Architecture </a>
                                    <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                </div>
                                <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                    Following
                                </button>
                            </div>
                            <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                <a href="#" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                    <img src="<?php echo base_url();?>assets/gamification/images/group/group-3.jpg" class="absolute w-full h-full inset-0 " alt="">
                                </a>
                                <div class="flex-1">
                                    <a href="#" class="text-base font-semibold capitalize">Graphic Design </a>
                                    <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                </div>
                                <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                    Following
                                </button>
                            </div>
                            <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                <a href="#" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                    <img src="<?php echo base_url();?>assets/gamification/images/group/group-4.jpg" class="absolute w-full h-full inset-0 " alt="">
                                </a>
                                <div class="flex-1">
                                    <a href="#" class="text-base font-semibold capitalize"> Mountain Riders  </a>
                                    <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                </div>
                                <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                    Following
                                </button>
                            </div>
                            <div class="flex items-center flex-col md:flex-row justify-center p-4 rounded-md shadow hover:shadow-md md:space-x-4">
                                <a href="#" iv="" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                    <img src="<?php echo base_url();?>assets/gamification/images/group/group-2.jpg" class="absolute w-full h-full inset-0 " alt="">
                                </a>
                                <div class="flex-1">
                                    <a href="#" class="text-base font-semibold capitalize">  Coffee Addicts  </a>
                                    <div class="text-sm text-gray-500"> 54 mutual friends </div>
                                </div>
                                <button class="bg-gray-100 font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                    Following
                                </button>
                            </div>
                            
                        </div>

                        <div class="flex justify-center mt-6">
                            <a href="#" class="bg-white dark:bg-gray-900 font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                Load more ..</a>
                        </div>

                    </div> -->

                     <!-- Videos -->
                    <div class="card md:p-6 p-2 max-w-3xl mx-auto">  
                        
                        <h2 class="text-xl font-semibold"> Announcement</h2>
                        

                        <div class="grid md:grid-cols-1 grid-cols-1  gap-x-2 gap-y-4 mt-6">  
                            <?php 
                            // echo'<pre>';print_r($Announcement);
                                if(sizeof($Announcement)>0){ 
                                    foreach($Announcement as $key=>$rows){
                            ?>
                            <div class="p-3 border-b dark:border-gray-700">
                                <div class="annoucement-widget">
                                    <img src="<?php echo base_url();?>assets/gamification/images/post/announcement.jpg" alt="">
                                    <div class="annoucemen-content">
                                        <h2 class="heading-title2">
                                        <?php echo substr(strip_tags( $rows['content']['description']),0,50) . "..."; ?>
                                        </h2>
                                        <span id="mycontent_<?php echo $rows['id'];?>" style="display:none;"><?php echo strip_tags( $rows['content']['description']);?></span>
                                        <div class="continue-link">
                                            <a onclick="show_announcement('<?php echo $rows['id'];?>');" style="cursor: pointer;">
                                                Read More 
                                            </a>
                                        </div>
                                    </div>
                                </div>  
                               </div>


                                <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600 ">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                            <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $rows['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $rows['id'];?>"><?php echo total_likes_data($Announcement['id'],$prof_uid);?></span></a>
                                       </a>
                                       </a>
                                   </div>
                               </div>


                                <?php } }?>          
                        </div>

                        
                    </div>




                   <!--  <div class="card md:p-6 p-2 max-w-3xl mx-auto">  
                        
                        <h2 class="text-xl font-semibold"> Interests</h2>
                        

                        <div class="grid md:grid-cols-1 grid-cols-1  gap-x-2 gap-y-4 mt-6">  
                                   
                        </div>

                        
                    </div>




                    <div class="card md:p-6 p-2 max-w-3xl mx-auto">  
                        
                        <h2 class="text-xl font-semibold"> Media</h2>
                        

                        <div class="grid md:grid-cols-1 grid-cols-1  gap-x-2 gap-y-4 mt-6">  
                                     
                        </div>
                        
                    </div> -->




                    <div class="card md:p-6 p-2 max-w-3xl mx-auto">  
                        
                        <h2 class="text-xl font-semibold"> News</h2>
                        

                        <div class="grid md:grid-cols-1 grid-cols-1  gap-x-2 gap-y-4 mt-6">  
                            <?php 
                            // echo'<pre>';print_r($org_new);
                                if(sizeof($org_new)>0){ 
                                    foreach($org_new as $key=>$row1){
                            ?>


                            <div class="note-repeat">
                                <div class="note-left">
                                    <span><?php echo $row1['content']['title'];?></span> 
                                    <small><?php echo date('d/m/Y',strtotime($row1['content']['publish_date']));?></small>
                                </div>
                                <p>
                                    <?php echo $row1['content']['description'];?>
                                </p>
                               <div class="p-4 space-y-3"> 
                                  
                                   <div class="flex space-x-4 lg:font-bold">
                                       <a href="#" class="flex items-center space-x-2">
                                           <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600 ">
                                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                                   <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                               </svg>
                                           </div>
                                            <a  onclick="add_like('<?php echo $prof_uid;?>','<?php echo $rows['id'];?>');">
                                            <div>Like</div> &nbsp;<span id="total_like_<?php echo $rows['id'];?>"><?php echo total_likes_data($Announcement['id'],$prof_uid);?></span></a>
                                       </a>
                                   </div>
                               </div>       
                            </div>


                            <!-- <div class="p-3 border-b dark:border-gray-700">
                                <div class="annoucement-widget">
                                    <img src="<?php echo base_url();?>assets/gamification/images/post/announcement.jpg" alt="">
                                    <div class="annoucemen-content">
                                        <h2 class="heading-title2">
                                        <?php echo substr(strip_tags( $rows['content']['description']),0,50) . "..."; ?>
                                        </h2>
                                        <span id="mycontent_<?php echo $rows['id'];?>" style="display:none;"><?php echo strip_tags( $rows['content']['description']);?></span>
                                        <div class="continue-link">
                                            <a onclick="show_announcement('<?php echo $rows['id'];?>');" style="cursor: pointer;">
                                                Read More 
                                            </a>
                                        </div>
                                    </div>
                                </div>  
                               </div> -->


                               <!--   -->


                                <?php } }?>          
                        </div>
                        
                    </div>


 

                </div>


            </div>
        </div>
        
    </div>



    <!-- open chat box -->
   <!-- <div class="start-chat">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
        </svg>
    </div>-->
    
    <!-- Craete post modal -->
    <div id="create-post-modal" class="create-post" uk-modal>
        <div
            class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
    
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> Create Post </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            <div class="flex flex-1 items-start space-x-4 p-5">
                <img src="<?php echo $prof_pic_url;?>"
                    class="bg-gray-200 border border-white rounded-full w-11 h-11">
                <div class="flex-1 pt-2">
                    <textarea class="uk-textare text-black shadow-none focus:shadow-none text-xl font-medium resize-none" rows="5"
                        placeholder="What's Your Mind ? Stella!"></textarea>
                </div>
    
            </div>
            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-3 shadow-sm items-center">
                    <div class="lg:block hidden"> Add to your post </div>
                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">
                    
                        <svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <svg class="text-red-600 h-9 p-1.5 rounded-full bg-red-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"> </path></svg>
                        <svg class="text-green-600 h-9 p-1.5 rounded-full bg-green-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"> </path></svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"> </path></svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <svg class="text-purple-600 h-9 p-1.5 rounded-full bg-purple-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path> </svg>
                       
                        <!-- view more -->
                        <svg class="hover:bg-gray-200 h-9 p-1.5 rounded-full w-9 cursor-pointer" id="veiw-more" uk-toggle="target: #veiw-more; animation: uk-animation-fade" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"> </path></svg>
                    
                    </div>
                </div>
            </div>
            <div class="flex items-center w-full justify-between p-3 border-t">
    
                <select class="selectpicker mt-2 col-4 story">
                    <option>Only me</option>
                    <option>Every one</option>
                    <option>People I Join </option>
                    <optionion>People Join Me</optionion>
                </select>
    
                <div class="flex space-x-2">
                    <a href="#" class="bg-red-100 flex font-medium h-9 items-center justify-center px-5 rounded-md text-red-600 text-sm">
                        <svg class="h-5 pr-1 rounded-full text-red-500 w-6 fill-current" id="veiw-more" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false" style=""> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Live </a>
                    <a href="#" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium">
                      Share </a>    
                </div>

                <a href="#" hidden
                    class="bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-12 font-semibold">
                    Share </a>
            </div>
        </div>
    </div>
    
    <!-- Create new album -->

    <div id="offcanvas-create" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar lg:w-4/12 w-full dark:bg-gray-700 dark:text-gray-300 p-0 bg-white flex flex-col justify-center">
    
            <button class="uk-offcanvas-close absolute" type="button" uk-close></button>

            <!-- notivication header -->
            <div class="-mb-1 border-b font-semibold px-5 py-5 text-lg">
                <h4> Create album </h4>
            </div>

            <div class="p-6 space-y-3 flex-1">
                <div>
                    <label> Album Name  </label>
                    <input type="text" class="with-border" placeholder="">
                </div>
                <div>
                    <label> Visibilty   </label>
                    <select id="" name=""  class="shadow-none selectpicker with-border">
                        <option data-icon="uil-bullseye"> Private </option>
                        <option data-icon="uil-chat-bubble-user">My Following</option>
                        <option data-icon="uil-layer-group-slash">Unlisted</option>
                        <option data-icon="uil-globe" selected>Puplic</option>
                    </select>
                </div>
                <div uk-form-custom class="w-full py-3">
                        <div class="bg-gray-100 border-2 border-dashed flex flex-col h-32 items-center justify-center relative w-full rounded-lg dark:bg-gray-800 dark:border-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-12">
                                <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" />
                                <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                            </svg>
                        </div>
                    <input type="file">
                </div>
               
            </div>
            <div class="p-5">
                <button type="button"  class="button w-full">
                    Create Now
                </button>
            </div>

            
        </div>
    </div>

    <!-------------------------Schedule--------------------------->
        <div id="schedule" class="modal fade">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">      
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style='margin-bottom:0px;'>
                                    <thead>
                                        <tr class='bg-info'>
                                        
                                            
                                            <th>Date</th>
                                            <th>Day</th>
                                            <th>In Time</th>
                                            <th>Break 1</th>
                                            <th>Lunch</th>
                                            <th>Break 2</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                        foreach($curr_schedule as $user){
                                                            
                                                            $shr_status = "Ok";
                                                            if($user['is_accept'] == '2'){ $shr_status = "In Review"; }
                                                            if($user['is_accept'] == '1'){ $shr_status = "Reviewed"; }                                              
                                                            if($user['is_accept'] == '1' && $user['agent_status'] != 'C'){ $shr_status = "Accepted"; }
                                                            if($user['is_accept'] == '1' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && empty($user['wfm_status']))
                                                            { 
                                                                $shr_status = "Reviewed by WFM"; 
                                                            }
                                                            if($user['is_accept'] == '1' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && $user['wfm_status'] == 'C')
                                                            { 
                                                                $shr_status = "Updated by WFM"; 
                                                            }
                                                            if($user['is_accept'] == '3'){ $shr_status = "Rejected"; }
                                                            
                                                            $shr_remarks = "Accepted by Agent";
                                                            if($user['is_accept'] == '2' && $user['agent_status'] == 'R'){ 
                                                                $shr_remarks =  "Pending Review by Operations"; 
                                                            }
                                                            if($user['is_accept'] == '2' && $user['agent_status'] == 'C' && $user['ops_status'] == 'R'){ 
                                                                $shr_remarks =  "To be Reviewed by WFM"; 
                                                            }
                                                            if($user['is_accept'] == '1' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && $user['wfm_status'] != 'C'){ 
                                                                $shr_remarks =  $user['ops_review']; 
                                                            }
                                                            if($user['is_accept'] == '1' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && $user['wfm_status'] == 'C'){ 
                                                                $shr_remarks =  $user['wfm_review']; 
                                                            }
                                                            if($user['is_accept'] == '3' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && $user['wfm_status'] == 'X'){ 
                                                                $shr_remarks =  $user['wfm_review']; 
                                                            }
                                                    ?>
                                                    
                                                    <tr>
                                                        <td><?php echo $user['shdate']; ?></td>
                                                        <td><?php echo $user['shday']; ?></td>
                                                        <td><?php echo $user['in_time']; ?></td>
                                                        <td><?php echo $user['break1']; ?></td>
                                                        <td><?php echo $user['lunch']; ?></td>
                                                        <td><?php echo $user['break2']; ?></td>
                                                        <td><?php echo $user['out_time']; ?></td>
                                                        <td><?php echo $shr_status; ?></td>
                                                        <td><?php echo $shr_remarks; ?></td>
                                                    </tr>
                                                    <?php 
                                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>

    <!----------------------End Schedule--------------------------->
    
    <!--start modal -->
    <div class="modal fade model-new" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
          </p>
          <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
          </p>
        </div>
        
      </div>
    </div>
  </div>
    <!--end modal -->
    <!------------------------------leadrship----------------------------->

    <!-- Modal -->
<div id="leadership" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">      
      <div class="modal-body">
      
      
            <div class="row">
                        
                        <div class="col-md-12">
                            
                            <div class="widget">                    
                                <header class="widget-header">
                                    <h4 class="widget-title"> Fusion Management Team </h4>
                                </header> 
                                <hr class="widget-separator">
                                
                                <div class="widget-body clearfix">
                                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/pankaj.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Pankaj Dhanuka</span></h4>
                                                    <span style="font-size:12px">Co-Founder & Director</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/kishore.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Kishore Saraogi</span></h4>
                                                    <span style="font-size:12px">Co-Founder & Director</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/prashant.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Prashant Khandelwal</span></h4>
                                                    <span style="font-size:12px">Chief Finance Officer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/partho.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Partho Choudhury</span></h4>
                                                    <span style="font-size:12px">President - Ameridial Inc.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                            
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/matt.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Matt McGeorge</span></h4>
                                                    <span style="font-size:12px">Executive Vice President - Ameridial Inc.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/ritesh.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Ritesh Chakraborty</span></h4>
                                                    <span style="font-size:12px">Vice President - Operations</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/eric.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Eric Pittman</span></h4>
                                                    <span style="font-size:12px">President, Vital Solutions, Inc.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/rajesh.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Rajesh Ramdas</span></h4>
                                                    <span style="font-size:12px">Senior Vice President</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/lalita.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Lalita Sinha</span></h4>
                                                    <span style="font-size:12px">Director - Human Resources</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/nagarajan.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Nagarajan Anandaraman</span></h4>
                                                    <span style="font-size:12px">Country Manager - Philippines</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/ganesh.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Ganesh Marve</span></h4>
                                                    <span style="font-size:12px">Vice President - Global Marketing</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/suresh.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Suresh Sampath</span></h4>
                                                    <span style="font-size:12px">Director Quality Assurance and Business Excellence</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/prasun.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Prasun Das</span></h4>
                                                    <span style="font-size:12px">Head - Workforce Management</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                                
                    </div>  
                </div>
            </div>
            
            <div class="row">
                        
                        <div class="col-md-12">
                            
                            <div class="widget">                    
                                <header class="widget-header">
                                    <h4 class="widget-title"> Executive Team </h4>
                                </header> 
                                <hr class="widget-separator">
                                
                                <div class="widget-body clearfix">
                                                
                                
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/rajan.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Rajan Singh</span></h4>
                                                    <span style="font-size:12px">CTO</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/neha.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Neha Kallani</span></h4>
                                                    <span style="font-size:12px">Finance Controller</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/rahul.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Rahul Singh</span></h4>
                                                    <span style="font-size:12px">Site Head - El Salvador</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/barbara.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Barbara Atillo-Alovera</span></h4>
                                                    <span style="font-size:12px">Director of Client Services - Philippines</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/topaz.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Topaz Tolloti</span></h4>
                                                    <span style="font-size:12px">Vice President - Client Services - Ameridial Inc.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-4">
                                    <a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
                                        <div class="widget widget-person">
                                            <div class="widget-body clearfix" style="padding:1px;">
                                                <div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/terri.jpg" style="height: 70px; margin-right:15px"/></div>
                                                <div class="" style="padding:1rem;">
                                                    <h4 class="widget-title text-primary"><span class="counter">Terri Peterman</span></h4>
                                                    <span style="font-size:12px">Vice President - Service Delivery - Ameridial Inc.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            
                                    
                            </div>
                                
                            </div>  
                        </div>
                    </div>
                    
      
      
      
      
      </div>
    </div>

  </div>
</div>

    <!------------------------------end leader ship------------------------->
    <!-------------------------User Attendance------------------ --------->
<div id="attendance_model" class="modal fade" style="font-size:12px;height: 550px;">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    
        <div class="modal-body">
        
            <div class="row">
        
        <!-- DataTable -->
        <div class="col-md-12">
                <div class="widget">
                    <header class="widget-header">
                        <h4 class="widget-title">Your Attendance Report</h4>
                    </header><!-- .widget-header -->
                    <hr class="widget-separator">
                        
                    <div class="widget-body">
                        <div id='currAttendanceTable' class="table-responsive" >
                        
                        
                            
                            
                        </div>
                    </div><!-- .widget-body -->
                    
                </div><!-- .widget -->
            </div>
            
            
        </div><!-- .row -->
         
            
        </div>
    </div>
    </div>
</div>

 <!--Announcement  modal -->
    <div class="modal fade model-new" id="announcement_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Announcement</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <p id="announcement_content">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
          </p>
         
        </div>
        
      </div>
    </div>
  </div>
    <!--end modal -->
     <!--press  modal -->
    <div class="modal fade model-new" id="press_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="press_head">Announcement</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <p id="press_content">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
          </p>
         
        </div>
        
      </div>
    </div>
  </div>
    <!--end modal -->
 <!--start modals view-->
    <div class="modal fade model-new" id="qaModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">         
            <div class="modal-header">
              <h4 class="modal-title">QA Report</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
              <div class="weekly-widget">
                 <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Met</th>
                        <th>Not Met</th>
                        <th>Comments</th>                       
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>10</td>
                        <td>-</td>
                        <td>No Negative points (Should be 85%<=)</td>
                      </tr>
                      <tr>
                        <td>15</td>
                        <td>-</td>
                        <td>No Negative points (Should be 3%>=)</td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>-5</td>
                        <td>
                            No Negative points. If the Dip check score is less than 80% then it will be negative mark
                        </td>
                      </tr>
                      <tr>
                        <td>10</td>
                        <td>-</td>
                        <td>
                            If found any ZTP, the score will become zero.
                        </td>
                      </tr>
                      <tr>
                        <td>0</td>
                        <td>15</td>
                        <td>
                            If found any WL/PIP all score will be 0 for that Month/weeks
                        </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>-</td>
                        <td>
                            It's Bonus point which is add on to enhance RANK (No Negative Point)
                        </td>
                      </tr>
                      <tr>
                        <td>15</td>
                        <td>-</td>
                        <td>
                            No Negative points (Should be 2%>=)
                        </td>
                      </tr>
                      <tr>
                        <td>0</td>
                        <td>15</td>
                        <td>
                            If fall under BQM category, the score will become zero.
                        </td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
            
          </div>
        </div>
  </div>
    <!-- Modal Start here-->
<div class="modal fade bs-example-modal-sm11" id="sktPleaseWait" tabindex="-2" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-refresh fa-spin" style="font-size:16px"></i>&nbsp;&nbsp;Please Wait. Processing...
                 </h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-info
                    progress-bar-striped active"
                    style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <!--end modals view-->   



<!--- Pending Policy Acceptance --->
<!-- <div class="modal fade" id="myPolicyModal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <form class="frmPolicyAccept" method='POST' action="<?php echo base_url('') ?>gamify_test/pending_process_policy" data-toggle="validator">  
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Policy Acceptance</h4>
        </div>
        
        <div class="modal-body">
            <input type="hidden" id="adpid" name="adpid" value="<?php echo $policyID; ?>">
            
            <div class="row">
                <div class="col-md-12">
                    <input type="checkbox" id="p_status" name="p_status" required>
                    Check here to indicate that you have read & agree to the terms of this policy
                </div>
            </div>
            
        </div>
        
        <div class="modal-footer">
            <button type="submit" id='btnPolicyAccept' class="btn btn-primary">I Agree</button>
        </div>
        
        </form>
      </div>
      
    </div>
  </div> -->





 <div class="modal fade model-new" id="myPolicyModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form class="frmPolicyAccept" method='POST' action="<?php echo base_url('') ?>gamify_test/pending_process_policy" data-toggle="validator">
        <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Policy Acceptance</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" id="adpid" name="adpid" value="<?php echo $policyID; ?>">
                
                        <input type="checkbox" id="p_status" name="p_status" required style="width: 15%;">
                        Check here to indicate that you have read & agree to the terms of this policy
               
            </div>

            <div class="modal-footer">
                <button type="submit" id='btnPolicyAccept' class="btn btn-primary">I Agree</button>
            </div>
        
      </div>
    </div>
  </div>



    <style>

.adherence>li{
padding-right: 10px;
}
.widget-person{
    height : 80px;
    width  : 103%;
}
</style>

    <!-- Javascript
    ================================================== -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/gamification//js/tippy.all.min.js"></script>
    <script src="<?php echo base_url();?>assets/gamification//js/uikit.js"></script>
    <script src="<?php echo base_url();?>assets/gamification//js/simplebar.js"></script>
    <script src="<?php echo base_url();?>assets/gamification//js/custom.js"></script>
    <script src="<?php echo base_url();?>assets/gamification//js/custom2.js"></script>
    <script src="<?php echo base_url();?>assets/gamification//js/clock.js"></script>
    <script src="<?php echo base_url();?>assets/gamification//js/bootstrap-select.min.js"></script>
    <!--<script src="../../unpkg.com/ionicons%405.2.3/dist/ionicons.js"></script>-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="<?php echo base_url();?>assets/gamification//js/jQuery-plugin-progressbar.js"></script>
    
    <script>
        // Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['', 'Hours per Day'],
  ['', 8],
  ['', 2],

]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'', 'width':350, 'height':210, backgroundColor: 'transparent'};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
    </script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/gamification/js/circliful.js"></script>
<script>
    (function () {       
        circliful.newCircleWithDataSet('circle4', 'simple');
        circliful.newCircleWithDataSet('circle5', 'simple');
        circliful.newCircleWithDataSet('circle6', 'simple');
        circliful.newCircleWithDataSet('circle7', 'simple');
        circliful.newCircleWithDataSet('circle8', 'simple');
        circliful.newCircleWithDataSet('circle9', 'simple');
        circliful.newCircleWithDataSet('circle10', 'simple');
    })();
</script><!---->
    
    <script>
        var animateButton = function(e) {

  e.preventDefault;
  //reset animation
  e.target.classList.remove('animate');
  
  e.target.classList.add('animate');
  setTimeout(function(){
    e.target.classList.remove('animate');
  },700);
};

var bubblyButtons = document.getElementsByClassName("bubbly-button");

for (var i = 0; i < bubblyButtons.length; i++) {
  bubblyButtons[i].addEventListener('click', animateButton, false);
}
    </script>
    
    
    <script>
        $(".progress-bar").loading();       
    </script>
    
    
    <script src='<?php echo base_url();?>assets/gamification/js/snap.svg-min.js'></script> 
<script>
var programmingSkills = [ 
    {
        value: 20,
        label: 'Poor 30%',
        color: '#f00'
    },
    {
        value: 23,
        label: 'Fair 50%',
        color: '#f4b183'
    },
    {
        value: 17,
        label: 'Good 70%',
        color: '#ffd966'
    },
    {
        value: 22,
        label: 'Great 85%',
        color: '#a9d18e'
    },
    {
        value: 18,
        label: 'Excellent 95%',
        color: '#70ad47'
    },
];
</script> 
<script src="<?php echo base_url();?>assets/gamification/js/svg-donut-chart-framework.js"></script>
<script src="<?php echo base_url();?>assets/gamification/js/jquery.overlayScrollbars.js"></script>
<script src='<?php echo base_url();?>assets/gamification/js/gamification.js'></script>
<script>
$('.box').overlayScrollbars({className       : "os-theme-round-dark",resize          : "both",
    sizeAutoCapable : true,
    paddingAbsolute : true}); 
</script>


<script>
    $(document).ready(function() {
  var totalVotes = 20;
  var data = {
    p1: 0,
    p2: 2,
    p3: 3,
    p4: 5,
    p5: 10
  };
  
  updateDisplay(totalVotes, data);
    
});

var updateDisplay = function(voteCount, data) {
    for (var key in data) {
    var sel = 'span.' + key;
    $(sel).width(data[key] / voteCount * 100 + '%');
    data[key] > 0 ? $(sel).html((data[key] / voteCount * 100).toFixed(0) + '%') : $(sel).html('0%');
      
    $('#vote-count').html(voteCount + ' votes');
  }
};
function show_announcement(cnt){
        cont=$('#mycontent_'+cnt).html();
        //alert(cont);
        $('#announcement_content').html(cont);
        $('#announcement_modal').modal('show');
    }
    function show_press(cnt){
        cont =$('#mypresscontent_'+cnt).html();
        d = cont.split("@@@");
        hd=d[0];
        bd=d[1];
       $('#press_head').html(hd);
       $('#press_content').html(bd);
       $('#press_modal').modal('show');
    }
</script>


<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();


    $("#serch_keywrd").keyup(function(){
        baseURL = '<?php echo base_url() ?>';
        var kywrd = $(this).val();
            $("#serch_main").removeAttr("style");
            $.ajax({
               type: 'POST',    
               url:baseURL+'gamify_test/get_app_link',
               data:'kywrd='+kywrd,
               success: function(msg){
                $('#showData_saq').empty();
                var alrt = JSON.parse(msg);
                if(alrt.length == 0){
                    htm = '<div class="flex-grow-1 ml-3 fnamesaq" style = "text-align: center;margin-top: 100px;">'
                            +'<span class="username">No Results Found</span>';
                            $('#showData_saq').append(htm);
                }else{
                      $.each(alrt, function(i,v){
                        
                       if(v.app_name == "My Time"){
                             htm = '<div class="list-group-item list-group-item-action border-0" id="my_time">';
                            
                       }else if(v.app_name == "Leadership"){
                                htm = '<div class="list-group-item list-group-item-action border-0" id="ldrship">';
                       }else{
                                 htm = '<div><a href="'+baseURL+v.app_link+'" class="list-group-item list-group-item-action border-0" target="_blank">';
                               
                       }

                                  // +'<div class="badge bg-success float-right">5</div>'
                                // +'<div class="d-flex align-items-start">'
                                // +'<img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">'
                               htm +='<div class="flex-grow-1 ml-3 fnamesaq">';
                               htm +='<span class="username">'+v.app_name+'</span>';
                                // +'<div class="small"> '+v.app_link+'</div>'
                            htm +='</div>'
                                // +'</div>'
                               htm +='</a></div>';
                               

                        $('#showData_saq').append(htm);
                        
                      });
                    }
                }
            });

    });

$(document).on('click','#my_time',function(){
    $('#sktPleaseWait').modal('show');
                            
    var rURL=baseURL+'home/getCurrentAttendance';
    
    $.ajax({
       type: 'POST',    
       url:rURL,
       success: function(tbDtata){
           
           $('#sktPleaseWait').modal('hide');
           $('#attendance_model').modal('show');    
           $('#currAttendanceTable').html(tbDtata);
           processAttendanc = "Y";
           
        },
        error: function(){  
            alert('Fail!');
            $('#sktPleaseWait').modal('hide');
        }
      });
});

    
$(document).on('click','#ldrship',function(){
    $('#leadership').modal('show');
});

     



$(document).mouseup(function(e) 
{
    var container = $(".search-main");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        $("#serch_main").hide();
    }
});


$(".acptPolicy").click(function(){
            var adpid=$(this).attr("adpid");    
            $('#adpid').val(adpid);
            $("#myPolicyModal").modal('show');       
 });


$('.frmPolicyAccept').submit(function(){
            if($('#p_status').prop("checked") == true){
                $("#myPolicyModal").modal('hide');
            }else{
                alert("Please select the CheckBox.");
            }
    });

$("#load_pmatrex").click(function(){
        alert(hi);      
 });


});        
</script>
</body>
</html>