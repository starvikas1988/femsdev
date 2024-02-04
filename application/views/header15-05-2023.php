<?php
is_valid_session_url();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_TITLE; ?></title>
    <link href="<?php echo base_url() ?>assets_home_v3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="<?php echo base_url() ?>assets_home_v3/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets_home_v3/css/responsive.css" rel="stylesheet">
    <?php if (get_user_company_id() == 3) { ?>
        <link rel="icon" href="<?php echo base_url() ?>assets_home_v3/images/favicon_omind.ico" type="image/x-icon">
    <?php } else { ?>
        <link rel="icon" href="<?php echo base_url() ?>assets_home_v3/images/favicon.ico" type="image/x-icon">
    <?php } ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<?php
$profileURL = "";
if ($content_template == "home/change_passwd.php" || $content_template == "home/pending_process_policy.php") {
    $profileURL = "";
} else {
    $profileURL = base_url() . "profile";
}

if (get_login_type() == "client")
    $profileURL = base_url() . "#";
?>

<body>
    <!--Start Loader element-->
    <div class="loading_main" id="page_loader">
        <img src="<?php echo base_url() ?>assets_home_v3/images/logo.svg" class="" alt="">
        <div class="loading_bar mt-3">
            <div class="progress-fill"></div>
        </div>
    </div>
    <!--End Loader element-->
    <!--start header-->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0)"><img src="<?php echo base_url() ?>assets_home_v3/images/logo.svg" class="logo" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto d-flex align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="javascript:void(0)"><img src="<?php echo base_url() ?>assets_home_v3/images/all_apps.svg" class="all_apps" alt=""> All Apps <img src="<?php echo base_url() ?>assets_home_v3/images/down_arrow.svg" alt=""> </a>
                        <?php include_once('homev3/all_apps.php'); ?>
                    </li>
                    <!-- <li class="nav-item">
                        <div class="search">
                            <i class="fa fa-search"></i>
                            <input type="text" class="form-control" id="autosuggest_input" placeholder="Search App...">
                            <?php //include_once('homev3/search.php'); ?>
                        </div>
                    </li> -->
                </ul>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle transparent_background" data-bs-toggle="dropdown">
                            <img src="<?php echo base_url() ?>assets_home_v3/images/language.svg" alt=""> English
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item eng" data-lang="en">English</a></li>
                            <li><a class="dropdown-item frn" data-lang="fr">French</a></li>
                        </ul>
                        <div id="google_translate_element"></div>
                    </div>
                    <a href="<?php echo base_url() ?>femschat" target="_blank">
                        <img src="<?php echo base_url() ?>assets_home_v3/images/chat_message.svg" class="help_icon" alt="">
                    </a>
                    <div class="dropdown log_out">
                        <img src="<?php echo $prof_pic_url; ?>" class="profile_img" alt="">
                        <button type="button" class="btn btn-primary dropdown-toggle transparent_background" data-bs-toggle="dropdown">
                            <?php echo get_username(); ?><br>
                            <small><?php echo " (" . get_role() . ", " . get_deptshname() . ")" ?></small>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= $profileURL ?>"><img src="<?php echo base_url() ?>assets_home_v3/images/my_profile.svg" class="menu_icon_log" alt=""> Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url() . get_role_dir(); ?>/changePasswd"><img src="<?php echo base_url() ?>assets_home_v3/images/change_password.svg" class="menu_icon_log" alt=""> Changes Password</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0);" id="btnLogoutModel"><img src="<?php echo base_url() ?>assets_home_v3/images/log_out.svg" class="menu_icon_log1" alt=""> Log Out</a></li>
                        </ul>
                    </div>
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <img src="<?php echo base_url() ?>assets_home_v3/images/help.png" class="help_icon" alt="">
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!--end header-->