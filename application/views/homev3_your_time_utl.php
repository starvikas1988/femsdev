<?php
include_once('header.php');
?>
<!--start help element-->
<div class="offcanvas offcanvas-end small_width" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Help & Support</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body less_top">
        <div class="mb-2">
            <a href="#" class="btn btn-success full_btn">MWP Tutorial</a>
        </div>
        <div class="mb-2">
            <img src="<?php echo base_url() ?>assets_home_v3/images/ind_employee_connect_text.jpg" class="img-fluid" alt="">
        </div>
        <div class="mb-2">
            <img src="<?php echo base_url() ?>assets_home_v3/images/support-helpdesk1.jpg" class="img-fluid" alt="">
        </div>
        <div class="mb-2">
            <img src="<?php echo base_url() ?>assets_home_v3/images/hr-employee-support1.jpg" class="img-fluid" alt="">
        </div>
    </div>
</div>
<!--end help element-->

<?php 

////////////////////////////////////////////
//Your Availability & Your Time Utilization/
////////////////////////////////////////////

$current_data_set = $schedule_monthly[round($selected_month)]['counters']; 

?>

<section id="middle_area" class="middle_area">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-sm-3">
                <div class="mb-2">
                    <div class="card p-3">
                        <div class="avail_widget_br">
                            <h2 class="avail_title_heading">Your Availability</h2>
                            <div class="month_widget">
                                <h3 class="small_title_green"><?=$schedule_monthly[round($selected_month)]['month']?></h3>
                            </div>
                        </div>
                        <div class="row mt-2 g-3">
                            <div class="col-sm-6">
                                <div class="mb-0">
                                    <div class="avail_widget">
                                        <img src="<?php echo base_url() ?>assets_home_v3/images/present.png" class="avail_icon" alt="">
                                        <h3 class="avail_title">Present</h3>
                                        <h4 class="avail_title_black"><?=round($current_data_set['present'])?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-0">
                                    <div class="avail_widget">
                                        <img src="<?php echo base_url() ?>assets_home_v3/images/absent.png" class="avail_icon" alt="">
                                        <h3 class="avail_title">Absent</h3>
                                        <h4 class="avail_title_black"><?=round($current_data_set['absent'])?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-0">
                                    <div class="avail_widget">
                                        <img src="<?php echo base_url() ?>assets_home_v3/images/adherence.png" class="avail_icon" alt="">
                                        <h3 class="avail_title">Adherence (%)</h3>
                                        <h4 class="avail_title_black"><?=round($current_data_set['adherence'])?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-0">
                                    <div class="avail_widget">
                                        <img src="<?php echo base_url() ?>assets_home_v3/images/shrinkage.png" class="avail_icon" alt="">
                                        <h3 class="avail_title">Shrinkage (%)</h3>
                                        <h4 class="avail_title_black"><?=round($current_data_set['shrinkage'])?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="javascript:void(0);" class="add_btn" data-bs-toggle="modal" data-bs-target="#add_referral">Add Referral</a>
                    </div>
                    <div class="mt-3">
                        <div class="referral_bg">Your Referral - 1</div>
                    </div>
                </div>
            </div>




<?php
    $ldcdHide = "";
    $cbHide = "";
    $cdHide = "";
    $diasable = "";
    $ob_active = "";
    $ldDiasable = "";
    $ld_checked = "";
    $ld_active = "";
    $cbDiasable = "";
    $cb_checked = "";
    $cb_active = "";
    $sdHide = "";
    $sdDiasable = "";
    $sd_checked = "";
    $sd_active = "";

    if ($break_on_ld == true) {
        $ldDiasable = "checked";
        $diasable = "disabled";
        $cbDiasable = "disabled";
        $sdDiasable = "disabled";
        $ld_active = "time_active";
    }


    if ($break_on == true) {
        $diasable = "checked";
        $ldDiasable = "disabled";
        $cbDiasable = "disabled";
        $sdDiasable = "disabled";
        $ob_active = "time_active";
    }

    if ($break_on_cb == true) {
        $cbDiasable = "checked";
        $ldDiasable = "disabled";
        $diasable = "disabled";
        $sdDiasable = "disabled";
        $cb_active = "time_active";
    }

    if ($break_on_sd == true) {
        $sdDiasable = "checked";
        $ldDiasable = "disabled";
        $diasable = "disabled";
        $cbDiasable = "disabled";
        $sd_active = "time_active";
    }
    ?>



            <div class="col-sm-3">
                <div class="mb-2">
                    <div class="card p-3">
                        <div class="avail_widget_br">
                            <h2 class="avail_title_heading">Your Time Utilization</h2>
                            <div class="month_widget">
                                <h3 class="small_title_green"><?= date('m-d-Y',strtotime(GetLocalTime())); ?></h3>
                            </div>
                        </div>
                        <div class="row mt-2 g-2">
                            <div class="col-sm-4">
                                <div class="mb-0">
                                    <div class="count_widget text-center">
                                        <small>Last Logged</small>
                                        <h3 class="count_blue"><?php echo ($dialer_logged_in_time != '' ? date('H:i:s', strtotime(ConvServerToLocal($dialer_logged_in_time))) : '') ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-0">
                                    <div class="count_widget text-center">
                                        <small>EST Time</small>
                                        <h3 class="count_blue" id="txt"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-0">
                                    <div class="count_widget text-center">
                                        <small>Local Time</small>
                                        <h3 class="count_blue" id="txt1"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (get_role_dir() == "agent" || get_role_dir() == "tl" || is_access_break_identifier() === true || get_global_access() == '1') { ?>

                            <div class="mt-4">
                                <div class="time_uti_box">
                                    <!--start loop here-->
                                    <div class="time_break_repeat <?php echo $ld_active; ?>">
                                        <div class="time_break_name">
                                            <span class="time_break_icon">
                                                <img src="<?php echo base_url() ?>assets_home_v3/images/lunch.png" alt="">
                                            </span> Lunch/Dinner break
                                        </div>
                                        <div class="time_break_switch">
                                            <div class="form-check form-switch">
                                                <div class="check-box">
                                                    <span id='lunch_timer' class="timer_time">00:00:00</span>
                                                    <input id="break_check_button_ld" type="checkbox" typ='lunch' <?php echo $ldDiasable; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end loop here-->
                                    <div class="time_break_repeat <?php echo $cb_active; ?>">
                                        <div class="time_break_name">
                                            <span class="time_break_icon">
                                                <img src="<?php echo base_url() ?>assets_home_v3/images/coaching.png" alt="">
                                            </span> Coaching break
                                        </div>
                                        <div class="time_break_switch">
                                            <div class="form-check form-switch">
                                                <div class="check-box">
                                                    <span id='coaching_timer' class="timer_time">00:00:00</span>
                                                    <input id="break_check_button_cb" type="checkbox" typ='coaching' <?php echo $cbDiasable; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time_break_repeat <?php echo $ob_active; ?>">
                                        <div class="time_break_name">
                                            <span class="time_break_icon">
                                                <img src="<?php echo base_url() ?>assets_home_v3/images/other.png" alt="">
                                            </span> Others break
                                        </div>
                                        <div class="time_break_switch">
                                            <div class="form-check form-switch">
                                                <div class="check-box">
                                                    <span id='others_timer' class="timer_time">00:00:00</span>
                                                    <input type="checkbox" id="break_check_button" typ='others' <?php echo $diasable; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time_break_repeat <?php echo $sd_active; ?>">
                                        <div class="time_break_name">
                                            <span class="time_break_icon">
                                                <img src="<?php echo base_url() ?>assets_home_v3/images/downtime.png" alt="">
                                            </span> Downtime break
                                        </div>
                                        <div class="time_break_switch">
                                            <div class="form-check form-switch">
                                                <div class="check-box">
                                                    <span id='downtime_timer' class="timer_time">00:00:00</span>
                                                    <input type="checkbox" id="break_check_button_sd" typ='downtime' <?php echo $sdDiasable; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="mb-2">
                    <div class="card p-3">
                        <div class="avail_widget_br">
                            <h2 class="avail_title_heading">Your Adherence</h2>
                            <div class="month_widget month_widget_week">
                                <h3 class="small_title_green">September
                                    <select name="" id="" class="common_inline">
                                        <option value="">W</option>
                                        <option value="">M</option>
                                    </select>
                                </h3>

                            </div>
                        </div>

                        <div class="mt-0">
                            <div class="chart-content">
                                <div id="adherence_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-2 mt-3">
                    <a href="javascript:void(0)" class="btn btn-success full_btn common_shadow" data-bs-toggle="modal" data-bs-target="#weekly_explore">Explore your weekly schedule</a>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="mb-3">
                    <div class="card p-2">
                        <div class="notice_widget">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="pill" href="#important">Important
                                        Links</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="pill" href="#menu1">Notice <i class="fa fa-circle" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div id="important" class="tab-pane active">
                                <div class="p-1 common_height">
                                    <div class="important_widget common_widget">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <img src="<?php echo base_url() ?>assets_home_v3/images/holiday_calendar.svg" class="important_img" alt="">
                                                    Holiday List 2023
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/payroll_calendar.svg" class="important_img" alt=""> Payroll Calendar 2023</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/learning_development.svg" class="important_img" alt=""> Learning & Development
                                                    calendar 2023</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/it_awarness.svg" class="important_img" alt=""> IT Awareness</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/email_id_creation.svg" class="important_img" alt=""> Email ID Creation & Deletion
                                                    Procedure</a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?php echo base_url() ?>assets_home_v3/images/fusion_global.svg" class="important_img" alt="">
                                                    Fusion Global IT Escalation Process
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/fusion_onsite.svg" class="important_img" alt=""> Fusion Onsite IT Escalation
                                                    Matrix</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/jitbit_creation.svg" class="important_img" alt=""> Jitbit Ticket Creation SOP</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/download_efficency.svg" class="important_img" alt=""> Download EfficiencyX
                                                    (1.0.1.6)</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/effiency_x.svg" class="important_img" alt=""> EfficiencyX Instllation and User Guide</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/download_efficency.svg" class="important_img" alt=""> Download .Net Framework
                                                    4.6.1</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/email_phising.svg" class="important_img" alt=""> Email Phishing - Stay
                                                    Protected</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/isms.svg" class="important_img" alt="">
                                                    ISMS Policy Acceptance</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/group_annoucement.svg" class="important_img" alt=""> Group Announcement
                                                    Proveera</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/group_annoucement.svg" class="important_img" alt=""> Group Announcement Cashify</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?php echo base_url() ?>assets_home_v3/images/fusion_it_remote.svg" class="important_img" alt=""> Fusion IT - Remote Support</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="important_widget">
                                    <div id="demo" class="carousel slide mt-3" data-bs-ride="carousel">

                                        <!-- Indicators/dots -->
                                        <div class="carousel-indicators">
                                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                                        </div>

                                        <!-- The slideshow/carousel -->
                                        <div class="carousel-inner">
                                            <div class="carousel-item px-2 active">
                                                <p>
                                                    Now refer to get Money!!! 2000 rs 1000 each month from DOJ till
                                                    2 months. To refer click on add referral section in Homepage To
                                                    refer click on add referral section in Homepage
                                                </p>
                                            </div>
                                            <div class="carousel-item px-2">
                                                <p>
                                                    Now refer to get Money!!! 2000 rs 1000 each month from DOJ till
                                                    2 months. To refer click on add referral section in Homepage To
                                                    refer click on add referral section in Homepage
                                                </p>
                                            </div>
                                            <div class="carousel-item px-2">
                                                <p>
                                                    Now refer to get Money!!! 2000 rs 1000 each month from DOJ till
                                                    2 months. To refer click on add referral section in Homepage To
                                                    refer click on add referral section in Homepage
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="blue_bg p-2 border_radius">
                        <div class="light_blue border_radius">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="pill" href="#attendance">Attention!</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="pill" href="#leave">Leave <i class="fa fa-circle" aria-hidden="true"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="pill" href="#birth">Birthday</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="pill" href="#anniversary">Anniversary</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div id="attendance" class="tab-pane active">
                                <div class="mt-3 common_height">
                                    <div class="important_widget update_widget">
                                        <div class="d-flex mb-2 justify-content-between">
                                            <div class="bd-highlight">
                                                <ul>
                                                    <li>
                                                        Update your Documents
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="bd-highlight">
                                                <a href="#" class="view_btn">View</a>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2 justify-content-between">
                                            <div class="bd-highlight">
                                                <ul>
                                                    <li>
                                                        Update your Documents
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="bd-highlight">
                                                <a href="#" class="view_btn">View</a>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2 justify-content-between">
                                            <div class="bd-highlight">
                                                <ul>
                                                    <li>
                                                        Update your Documents
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="bd-highlight">
                                                <a href="#" class="view_btn">View</a>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2 justify-content-between">
                                            <div class="bd-highlight">
                                                <ul>
                                                    <li>
                                                        Update your Documents
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="bd-highlight">
                                                <a href="#" class="view_btn">View</a>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2 justify-content-between">
                                            <div class="bd-highlight">
                                                <ul>
                                                    <li>
                                                        Update your Documents
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="bd-highlight">
                                                <a href="#" class="view_btn">View</a>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2 justify-content-between">
                                            <div class="bd-highlight">
                                                <ul>
                                                    <li>
                                                        Update your Documents
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="bd-highlight">
                                                <a href="#" class="view_btn">View</a>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2 justify-content-between">
                                            <div class="bd-highlight">
                                                <ul>
                                                    <li>
                                                        Update your Documents
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="bd-highlight">
                                                <a href="#" class="view_btn">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="leave" class="tab-pane fade">
                                <div class="mt-3 common_height">
                                    <div class="important_widget">
                                        <div class="row g-3 mb-3 update_widget">
                                            <div class="col-sm-4">
                                                01-05-2023
                                            </div>
                                            <div class="col-sm-5">
                                                Absent
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="#" class="view_btn">Apply</a>
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 update_widget">
                                            <div class="col-sm-4">
                                                02-05-2023
                                            </div>
                                            <div class="col-sm-6">
                                                H Holiday
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="<?php echo base_url() ?>assets_home_v3/images/holiday_icons.png" class="leave_img" alt="">
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 update_widget">
                                            <div class="col-sm-4">
                                                03-05-2023
                                            </div>
                                            <div class="col-sm-6">
                                                H Holiday Approved
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="<?php echo base_url() ?>assets_home_v3/images/approved.png" class="leave_img" alt="">
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 update_widget">
                                            <div class="col-sm-4">
                                                04-05-2023
                                            </div>
                                            <div class="col-sm-6">
                                                H Holiday Rejected
                                            </div>
                                            <div class="col-sm-2">
                                                <img src="<?php echo base_url() ?>assets_home_v3/images/rejected.png" class="leave_img" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="birth" class="tab-pane fade">
                                <div class="mt-2 common_height p-2">
                                    <div class="d-flex mb-2 justify-content-between update_widget">
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/birthday1.png" class="birthday_img" alt=""> Employee
                                            Full Name
                                        </div>
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/cake.png" class="small_img" alt="">
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2 justify-content-between update_widget">
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/birthday1.png" class="birthday_img" alt=""> Employee
                                            Full Name
                                        </div>
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/cake.png" class="small_img" alt="">
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2 justify-content-between update_widget">
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/birthday1.png" class="birthday_img" alt=""> Employee
                                            Full Name
                                        </div>
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/cake.png" class="small_img" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="anniversary" class="tab-pane fade">
                                <div class="mt-2 common_height p-2">
                                    <div class="d-flex mb-2 justify-content-between update_widget">
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/birthday1.png" class="birthday_img" alt=""> Employee
                                            Full Name
                                        </div>
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/cake.png" class="small_img" alt="">
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2 justify-content-between update_widget">
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/birthday1.png" class="birthday_img" alt=""> Employee
                                            Full Name
                                        </div>
                                        <div class="bd-highlight">
                                            <img src="<?php echo base_url() ?>assets_home_v3/images/cake.png" class="small_img" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php 
    include_once('footer.php');
?>