<?php
is_valid_session_url();
?>

<!doctype html>
<html lang="en">
<head>      
	<meta charset="utf-8" />
	<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	?>
	<title><?php echo APP_TITLE; ?></title>
		
	<meta name="description" content="MWP-<?php echo get_role(); ?> Home" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php if(get_user_company_id()==3){ ?>
		<link rel="icon" href="<?php echo base_url() ?>assets/images/favicon_omind.ico" type="image/x-icon">
	<?php }else{ ?>
		<link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon">
	<?php } ?>
	<meta content="mindwork place" name="mindwork.place" />		
	<link href="<?php echo base_url() ?>assets_home_v2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />		
	<link href="<?php echo base_url() ?>assets_home_v2/css/app.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets_home_v2/css/custom.css" rel="stylesheet" type="text/css" />	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets_home_v2/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets_home_v2/slick/slick.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets_home_v2/slick/slick-theme.css">
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home_user_survey/css/model_custom.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/ipl/css/ipl_contest2.css?<?php echo time(); ?>">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/uploadfile.css"/>
	
		
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui-timepicker.css">
	
	
	<?php if(is_access_neo_chatbot()==true){ ?>
		
		<!--SKT Added custom chat design library here 09.03.2022-->	
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/mwp-chatbot/css/custom.css?yy">
		<link href="<?php echo base_url() ?>assets/mwp-chatbot/css/botchat.css?yy" rel="stylesheet" />		
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
		<!--End chat design library -->	
	
	<?php } ?>
	
	<script src="<?php echo base_url() ?>assets_home_v2/js/jquery.min.js"></script>
	<script src="<?php echo base_url('assets/ipl/js/jquery.countdown.min.js'); ?>"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker.js"></script>
	
	<!--start tabs collapse-->		
	<script src="<?php echo base_url() ?>assets_home_v2/js/bootstrap-nav-paginator.min.js"></script>	
	<!--end tabs collapse-->	
	
<style>
	
	.box {
       z-index: 999;
	}
	
	.box1 {
       z-index: 999;
	}

	.read-more-link {
	  width: 70px;
	  padding: 5px;
	  background: #5156be;
	  color: #fff;
	  display: inline-block;
	  text-align: center;
	  border-radius: 5px;
	  transition: all 0.5s ease-in-out 0s;
	}

	/*start video css*/
	.modal {
		z-index:9999;
	}
	
	.video-popup .close {
		border:none;
		line-height: 34px;
	}
	/*end video css*/

	.topnav{
		z-index:99;
	}
	
	.legend-widget {
		height: 65px;
	}

	a{
		cursor:pointer;
	}
	
	.mb-3 {
		margin-bottom: .2rem !important;
	}

	.swal-title {
	  font-size: 16px;
	  
	}
	
	.swal-icon {
		width:  50px;
		height: 50px;
		margin: 5px auto;
	}
	
	.swal-icon--warning__body {
		height: 22px;
	}
	
	.block_link {
	  border-radius: 3px;
	  cursor:pointer;
	  background: aliceblue;
	  padding: 5px 5px;
	  display: block;
	  border: 1px solid #eee;
	  font-weight: bold;
	  color: #000;
	  text-align: center;
	  color: darkblue;
	  font-size: 16px;
	  text-align: center;
	  transition: all 0.5s ease-in-out 0s;
	}
	

	.carousel-indicators [data-bs-target]{
		background-color: #1e0de9;
	}
	
	.row > * {
	  padding-right: calc(var(--bs-gutter-x) * .3);
	  padding-left: calc(var(--bs-gutter-x) * .3);
	}

	.card {
	  margin-bottom: 10px;
	}

	.fusion-logo {
		margin: 15px 0 0 15px;
	}
	
	.table>thead>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>th,
    .table>tbody>tr>td,
    .table>tfoot>tr>th,
    .table>tfoot>tr>td {
        padding-left: 8px;
        vertical-align: middle;
    }
	
	.widget-header, .widget-body, .widget-footer {
		padding: .4rem .6rem;
	}

	#google_translate_element{
		display: none;
	}

	.goog-te-banner-frame.skiptranslate {
        display: none !important;
    } 
	
		
    body {
        top: 0px !important; 
    }
	body.modal-open {
		padding-right: 0px !important;
	}
	body:not(.modal-open){
	  padding-right: 0px !important;
	}
	/*start custom chatbot design css here*/
	.chat-bottom {
		position:fixed;
		width:400px;
		/*height:570px;*/
		bottom:0;
		right:0;
		background-color:transparent;
	}
	.chat-bottom iframe {
		width:100%;
		height:100%;
		border:none;
		padding:10px;
		background-color:transparent;
	}
	.isvisible{
		z-index:90;
	}
	/*end custom chatbot design css here*/
	
	/*start video popup css here 22.03.2022*/
	.video-btn {
		width: 35px;
		height: 35px;
		display: inline-block;
		background: #103978;
		color: #fff!important;
		padding: 0;
		text-align: center;
		margin: 15px 10px 0 0;
		border-radius: 40px;
		transition: all 0.5s ease-in-out 0s;
		border: none;
		cursor: pointer;
		position: absolute;
		top: -10px;
		right: 40px;
		line-height: 35px;
	}
	.video-btn:hover {
		background: #0a2b5e;
	}
	.video-btn:focus {
		background: #0a2b5e;
		outline:none;
	}
	.video-btn i {
		font-size: 23px;
		line-height: 33px;
	}
	.video-popup iframe {
		width:100%;
		height: 400px;
		margin:0 0 -5px 0;
	}
	.video-popup .modal-header {
		background:#366cc1;
		color:#fff;
	}
	.video-popup .close {
		width:35px;
		height:35px;
		line-height:35px;
		background:#4787eb;
		color:#fff;
		border-radius:50%;
		position:absolute;
		top: -12px;
		right: -12px;
		opacity: 1;
	}
	.video-popup .modal-body {
		padding:5px;
	}
	.video-popup .modal-title {
		font-weight:bold;
	}
	/*end video popup css here 22.03.2022*/
	
	/*start new icon widget for chatbot 25.03.2022*/
	.icon-small-new {
		height:90px;
		cursor:pointer;
	}
	.close-area {
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		line-height:90px;
		width:90px;
		height:90px;
		display:none;
		justify-content: center;
		align-items: center;
		background:#2c5da9;
		border-radius:50%;
		text-align:center;
		color:#fff;
		font-size:25px;
		cursor: pointer;
	}
	.omind-widget1 {
		width:auto;
		height:auto;
	}
	/*end new icon widget for chatbot 25.03.2022*/
	/*start new feedback button chatbot 31.03.2022*/
	.video-btn1 {
		width: auto;
		height: auto;
		display: inline-block;
		background: #103978;
		color: #fff!important;
		padding: 0 10px;
		text-align: center;
		margin: 15px 10px 0 0;
		border-radius: 5px;
		transition: all 0.5s ease-in-out 0s;
		border: none;
		cursor: pointer;
		position: absolute;
		top: -7px;
		right: 80px;
		line-height: 30px;
		font-size: 12px;
	}
	.video-btn1:hover {
		background: #0a2b5e;
		text-decoration:none;
	}
	.video-btn1:focus {
		background: #0a2b5e;
		outline:none;
	}
	/*end new feedback button chatbot 31.03.2022*/
	
	/*start Add video element on 13.04.2022*/
	.video-widget {
		width:100%;
	}
	.video-widget video {
		width:100%;		
	}
	/*end Add video element on 13.04.2022*/
	.news_feeds {
        height: 200px;
        overflow: hidden;
        font-size: 15px;
        margin-top: -5px;
        background-color: aliceblue;
        padding-left: 5px;
        padding-top: 5px;
    }

    .news_data {
        /*height: 200px;*/
        background-color: aliceblue;
        padding-top: 1px;
        padding-left: 15px;
    }

    .news_feeds .row {
        overflow-y: scroll;
        height: 100%;
        /*margin-right: -12%;
        padding-right: 12%;*/
        overflow: hidden;
    }
     /*news-feed*/
    .news-feed ul, ol {
        list-style-type: square;
        padding: 5px 5px 0px 25px;
        margin: 0px;
    }
    .news-feed .scrl{
        padding: 0.4rem 0.5rem;
        overflow:auto;
        height: 200px;
        background: #e8ebee4f;
    }
    .notification_bg {
        width: 16px;
        height: 16px;
        background: #f00;
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        top: 10px;
        right: 13px;
        text-align: center;
        line-height: 15px;
        color: #fff;
        font-size: 9px;
    }

	.asset-btn{
		background: #5156be;
		color: #fff;
		box-shadow: none!important;
		transition: all 0.5s ease-in-out 0s;
	}
	.asset-btn:hover{
	  background: #333895!important;
	  color: #fff!important;
	  box-shadow: none!important;
	}

	.btn-sm-new {
	    padding: 5px 11px;
	    margin: 0 5px 0 0;
	    font-size: 13px;
	}
    
    /********** Date : 16-11-2022 For top header alignment issue *********/
    
    .navbar-brand-box {
        width: auto;
        vertical-align: middle;
        display: flex;
        align-items: center;
    }
    .position-relative p {
        margin: 0;
        width: 720px;
    }

</style>


<?php 

	//$disable_ameyo_chat = true;
	if(get_login_type() != "client" && is_disable_module()==false && empty($disable_ameyo_chat) && (is_ppbl_check()!='1')){
	
	?>
	
	
	<script type="text/javascript" language="javascript" src="https://wfh.ameyoengage.com:8443/ameyochatjs/ameyo-emerge-chat.js" async defer></script>
	<?php
	$_ameyo_noFlowID = '5';
	$_ameyo_officeid = get_user_office_id();
	if(!empty($_ameyo_officeid) && $_ameyo_officeid == 'ALT'){ $_ameyo_noFlowID = '20'; }
	if(!empty($_ameyo_officeid) && isIndiaLocation($_ameyo_officeid)){ $_ameyo_noFlowID = '53'; }
	?>
	<script type="text/javascript"> 
	var campaignId = '11';
	var nodeflowId = '<?php echo $_ameyo_noFlowID; ?>';
	var ameyoUrl = 'https://wfh.ameyoengage.com:8443'
	var phoneNoRegex = "^[+]{0,1}[0-9]{9,16}$";

	var ameyo_script = document.createElement('script');
	ameyo_script.onload = function() {
			try {
				initializeChat(campaignId, nodeflowId,ameyoUrl,null,null,null,null,null, phoneNoRegex);
			} catch (err) {
				console.error( err);
			}
		};
	ameyo_script.src = ameyoUrl+"/ameyochatjs/ameyo-emerge-chat.js";
	document.getElementsByTagName('head')[0].appendChild(ameyo_script);
	</script>
	
	<?php } ?>
	
</head>

<?php 
	$profileURL="";
	if($content_template=="home/change_passwd.php" || $content_template=="home/pending_process_policy.php" ){
		$profileURL="";
	}else{
		$profileURL = base_url()."profile";
	}
	
	if(get_login_type()=="client") $profileURL=base_url()."#";
	
?>


<?php
	$ldcdHide = "";
	$cbHide = "";
	$cdHide = "";
	$diasable = "";
	$ldDiasable = "";
	$cbDiasable = "";
	$sdHide = "";
	$sdDiasable = "";

	if ($break_on_ld == true){
		$diasable = "disabled";
		$cbDiasable = "disabled";
		$sdDiasable = "disabled";
	}	
	
	
	if ($break_on == true){
		$ldDiasable = "disabled";
		$cbDiasable = "disabled";
		$sdDiasable = "disabled";
	}
	
	if ($break_on_cb == true){
		$ldDiasable = "disabled";
		$diasable = "disabled";
		$sdDiasable = "disabled";
	}
	
	if ($break_on_sd == true){
		$ldDiasable = "disabled";
		$diasable = "disabled";
		$cbDiasable = "disabled";
	}
	
		
?>

<body>
	
	<!--start loader elements-->
	<div class="overlay">
	<div class="overlayDoor"></div>
	<div class="overlayContent">
		<div class="loader">
			<div class="inner"></div>
		</div>		
	</div>
</div>
	<!--end loader elements-->

        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="#" class="logo logo-dark">
                                <span class="logo-sm">
									<?php if(get_user_company_id()==3){ ?>
										<img src="<?php echo base_url(); ?>assets/images/omind_logo.png?<?php echo time(); ?>" width='90px' class="Omind-Logo" alt="">
									<?php 
										}else{
									?>	
										<img src="<?php echo base_url() ?>assets_home_v2/images/logo.png" class="fusion-logo" alt="">
									<?php  } ?>
                                </span>                                
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                               <strong>
							   <?php echo get_username(); ?>
							   </strong> <?php echo " (". get_role().", ".get_deptshname().")" ?>
							   <!-- thought of the week -->
							   <?php               
                				if (count($weekly_thought) > 0) {
                    			?>
							   	<p><strong style="font-size:14px;">Thought Of The Week: </strong><?php echo substr(strip_tags($weekly_thought[0]['thought']),0,150); ?></p> 
							   <?php } ?>
                            </div>
                        </form>
                    </div>

		
                    <div class="d-flex">
					<?php if(is_ppbl_check()!='1'){?>
                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="search" class="icon-lg"></i>
							</button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">        
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="dropdown d-none d-sm-inline-block right-divider">
                            <a href="javascript:void(0)" class="slide-notification">
                                <img src="assets_home_v2/images/notification.png" alt="" class="birthday-img msg-img1">
                                <span class="notification_bg">2</span>
                            </a>
                        </div>
						
						<div class="dropdown d-none d-sm-inline-block right-divider">
                            <a href="<?php echo base_url();?>femschat" target="_blank" >
                                <img src="assets_home_v2/images/mwp_chat.png" alt="" class="birthday-img msg-img vert-move">
                            </a>
                        </div>
						
						<?php if (count($user_today_dob) > 0) { ?>
						 
						 <div class="dropdown d-none d-sm-inline-block right-divider" style='padding-left:15px;'>
                            <a href="javascript:void(0);" class="slide-toggle">
                                <img src="assets_home_v2/images/birthday-cake.png" height='20px;' alt="" class="birthday-img vert-move">
                            </a>
                        </div>
						<?php } }?>
						
                        <div class="dropdown d-none d-sm-inline-block" style='padding-left:15px;'>
						
							<a  style="cursor:pointer;" class="flag_link eng"  title="English" data-lang="en">
								<img  style="margin-top:22px; margin-right:5px;" width='35px;' src="<?php echo base_url(); ?>assets/flag_img/english_us.png" alt="English">
							</a>
							<a style="cursor:pointer;" class="flag_link frn" title="French" data-lang="fr">
								<img  style="margin-top:22px; margin-right:10px;" width='35px;' src="<?php echo base_url(); ?>assets/flag_img/french.jpg" alt="French">
							</a>
						
							<div id="google_translate_element"></div>
							
                            
                        </div>
													
                        <div class="dropdown d-inline-block" style='padding-left:5px;' >
                            <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?php echo $prof_pic_url; ?>" alt="">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="<?= $profileURL ?>">									
									<i class="fa fa-user font-size-16 align-middle me-1" aria-hidden="true"></i>
									Profile
								</a>
								
                                <div class="dropdown-divider"></div>
								
								<a class="dropdown-item" href="<?php echo base_url().get_role_dir(); ?>/changePasswd">
									<i class="fa fa-user font-size-16 align-middle me-1" aria-hidden="true"></i>
									Change Password
								</a>
								
								<div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="btnLogoutModel" >									
									<i class="fa fa-sign-out font-size-16 align-middle me-1" aria-hidden="true"></i>
									Logout
								</a>
                            </div>
                        </div>
            
                    </div>
                </div>
            </header>
    
            <div class="topnav">
                <div class="container-fluid">
                    <div class="row align-items-center">
                    	<div class="col-sm-2">
                    		<nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                           <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
								<li class="nav-item dropdown right-divider">
                                    
				    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button">
                                        <i data-feather="grid"></i>
                                        <i class="fa fa-tachometer" aria-hidden="true"></i>All Apps</span> 
                                        <div class="arrow-down"></div>
                                    </a>
									<?php if(is_access_qa_boomsourcing()==False){
										if(is_ppbl_check()!='1'){
									?>
                                    <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-uielement">
                                        <div class="ps-2 p-lg-0">
											<div class="search-widget">
												<div class="input-group mb-3">
													  <input type="text" class="form-control" id="appSearchInput" placeholder="Search Menu" autocomplete="off" aria-label="Search Menu" aria-describedby="basic-addon2">
													  <div class="input-group-append">
														<button class="btn btn-primary" type="button">
															<i class="fa fa-search" aria-hidden="true"></i>
														</button>
													  </div>
												</div>
											</div>
											
											<div class="mega-widget">
												<ul class="sub-menu topul">
												  <li class="menu-item"><a href="<?php echo base_url() ?>profile">My Profile</a></li>
												  
												<?php
														if (get_role_dir() != "agent" || get_site_admin() == '1' || get_global_access() == '1' || get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_dept_folder() == "rta") {
														if (get_global_access() == '1')
															$team_url = base_url() . "super/dashboard";
														else if (get_dept_folder() == "hr")
															$team_url = base_url() . 'hr/dashboard';
														else if (get_dept_folder() == "wfm" || get_dept_folder() == "rta")
															$team_url = base_url() . 'wfm/dashboard';
														else if (get_site_admin() == "1")
															$team_url = base_url() . 'admin/dashboard';
														else
															$team_url = base_url() . get_role_dir() . "/dashboard";
												?>
										
														<li class="menu-item"><a href="<?php echo $team_url ?>">My Team </a></li>
														
												 <?php } ?>
												 
												 <?php
													if (get_global_access() == '1' || get_site_admin() == '1' || get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_dept_folder() == "rta" || get_user_fusion_id() == "FELS004207") {
													$linkurl = base_url() . "search_candidate";
												?>								
													
													<li class="menu-item"><a href="<?php echo $linkurl; ?>">Search Employee</a></li>
													
												<?php }  ?>
												
												  <li class="menu-item"><a href="<?php echo base_url() ?>policy">Policies</a></li>
												  
												  
											<?php
												if ((isAssignInterview() > 0 || is_access_dfr_module() == true) && is_disable_module() == false) {

												$ac_class = "";
												$linkurl = base_url() . "dfr";
											?>
												<li class="menu-item"><a href="<?php echo $linkurl; ?>">Recruitment</a></li>
											<?php }  ?>
											  
											<?php		
												$linkurl = base_url() . "dfr_it_assets";
												if (it_assets_access()==true)
												{
											?>		
												<li class="menu-item"><a href="<?php echo $linkurl; ?>">IT Assets v1</a></li>
											<?php } ?>

																
											<?php
												if (isIndiaLocation(get_user_office_id()) == true && isAccessNaps() == true) {
											?>
													<li class="menu-item"><a href="<?php echo base_url() . "naps"; ?>">NAPS</a></li>
											<?php } ?>
												
											 <?php
												if (is_disable_module() == false) {
											 ?>
													<li class="menu-item"><a href="<?php echo base_url(); ?>progression">Progression</a></li>
											<?php } ?>
													
													<li class="menu-item"><a href="<?php echo base_url(); ?>uc">Movement</a></li>
													
													<li class="menu-item"><a href="<?php echo base_url() . "user_resign"; ?>">Separation</a></li>

											<?php
												if (isAccessFNF() == true || isAccessFNFHr() == true || isAccessFNFITSecurity() == true || isAccessFNFITHelpdesk() == true || isAccessFNFPayroll() == true || isAccessFNFAccounts() == true || isAccessFNFIT_Morocco() == true || isAccessFNFHR_Morocco() == true) {
											?>
												<li class="menu-item"><a href="<?php echo base_url() . "fnf"; ?>"> F&F </a></li>
												
											<?php } ?>
											
											<?php
												if (isIndiaLocation(get_user_office_id()) == true) {
											?>
												<li class="menu-item"><a href="<?php echo base_url() . "employee_id_card/card"; ?>"> ID-Card </a></li>
											<?php } ?>	
												
											<?php
											if (isIndiaLocation(get_user_office_id()) == true) {
													if (get_role_dir() != "agent") {
											?>			
														<li class="menu-item"><a href="<?php echo base_url() . "letter/confirmation_list"; ?>"> Confirmation </a></li>
												<?php } ?>
													
													<li class="menu-item"><a href="<?php echo base_url() . "Warning_mail_employee/your_warning_letter"; ?>"> Warning </a></li>
													
													<li class="menu-item"><a href="<?php echo base_url() . "appraisal_employee/your_appraisal_letter"; ?>"> Appraisal / Revision </a></li>
											<?php } ?>
											
											<?php
												if (is_access_resend_payslip() == true) {
											?>
													<li class="menu-item"><a href="<?php echo base_url() . "resend_payslip"; ?>"> Resend payslip </a></li>
													
											<?php } ?>
											
											<?php if (isAccessAssetManagement() == true) { ?>
													
													<li class="menu-item"><a href="<?php echo base_url() . "asset"; ?>"> Manage Assets </a></li>
													
											<?php } ?>
											
													<li class="menu-item"><a href="<?php echo base_url() . "egaze"; ?>"> EfficiencyX </a></li>
											
											<?php
												if (get_role_dir() != "agent" || is_access_schedule_update() == true || is_access_schedule_upload() == true || get_dept_folder() == "wfm" || get_dept_folder() == "rta" || get_user_fusion_id() == "FELS004207" || get_user_fusion_id() == "FALB000079") {

											?>
												<li class="menu-item"><a href="<?php echo base_url() . "schedule"; ?>"> Schedule </a></li>
												
											<?php } ?>	
											
											<?php if (get_user_office_id() != "ALT" && get_user_office_id() != "DRA") { ?>
													<li class="menu-item"><a id='viewModalAttendance' > My Time </a></li>
											 <?php } ?>
											
											<?php
												$ac_class = "";
												if (in_array(get_user_office_id(), ["ALT", "JAM", "CEB", "MAN", "CAS", "ALB","KOS"]) || isIndiaLocation(get_user_office_id()) == true || get_global_access() == '1' || get_user_fusion_id() == 'FHIG000314') 
													$linkurl = base_url() . "leave/";
												else if(get_user_fusion_id() == 'FALT002231') $linkurl=base_url()."leave/leave_approval";
												else
													$linkurl = base_url() . "uc/";
											?>	
												
												<li class="menu-item"><a href="<?php echo $linkurl; ?>"> Leave </a></li>
											
											
											 
											 <?php if (get_global_access() == '1' || get_site_admin() == '1' || get_dept_folder() == "hr" || get_role_dir() == "super" || get_role_dir() == "admin" || get_role_dir() == "manager" || get_role_dir() == "tl" || get_dept_folder() == "wfm" || get_dept_folder() == "rta" || get_user_fusion_id() == "FALB000079") { ?>
												
												<li class="menu-item"><a href="<?php echo base_url() . "break_monitor"; ?>"> Break Monitor </a></li>
													
											 <?php } ?>
											 
											 
											<?php
												if (is_access_qa_agent_module() == true || is_access_qa_module() == true || is_access_qa_operations_module() == true || is_quality_access_trainer() == true) {
													$linkurl = base_url() . "quality";
													$sr_linkurl = base_url() . "qa_servicerequest";
											?>
													
												<li class="menu-item"><a href="<?php echo $linkurl; ?>"> Audit </a></li>
													
												<li class="menu-item"><a href="<?php echo $sr_linkurl; ?>"> QA Service Request </a></li>
												
											<?php } ?>
											
											<?php
												if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN") {
												$ac_class = "";
												$linkurl = base_url() . "qa_coaching";
												
                                            ?>
												<li class="menu-item"><a href="<?php echo $linkurl; ?>"> Quality Coaching </a></li>
												
											<?php } ?>
											
											<?php
												if (get_role_dir() != "agent" || isAccessReports() == true)
													{
													$ac_class = "";
													$linkurl = base_url() . "reports_qa/dipcheck";
											?>
												<li class="menu-item"><a href="<?php echo $linkurl; ?>"> Quality Report </a></li>
												
											<?php 	} ?>
											
											<?php if (isAccessAssetWFH() == true) { ?>
												   <li class="menu-item"><a href="<?php echo base_url() . "wfh_assets"; ?>">Assets</a></li>
											<?php } ?>
											
											<?php if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN" || get_global_access() == '1') { ?>
												  <li class="menu-item"><a href="<?php echo base_url(); ?>covid19_pre_check">Covid Pre Check</a></li>
											<?php } ?>	  
											
											<?php if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN" || get_global_access() == '1') { ?>
												  <li class="menu-item"><a href="<?php echo base_url() . "mental_health"; ?>">Cognitive Check</a></li>
											<?php } ?>	
											
												  <li class="menu-item"><a href="<?php echo base_url(); ?>employee_feedback" title="Employee Perception Survey" >Survey</a></li>
											
											 <?php if (get_user_office_id() == "KOL" || get_global_access() == '1') { ?>
												  <li class="menu-item"><a href="<?php echo base_url(); ?>survey/cafeteria">Cafeteria Survey</a></li>
											 <?php } ?>
											
											<?php if ((get_role_dir() != 'agent' && get_dept_id() != '6') || get_global_access() == '1') { ?>
												  <li class="menu-item"><a href="<?php echo base_url(); ?>survey/copc">COPC Survey</a></li>
											<?php } ?>
											
											<?php if (get_user_office_id() == "CEB" || get_user_office_id() == "MAN") { ?>
												  <li class="menu-item"><a href="<?php echo base_url() ."survey/employee_pulse"; ?>">Pulse Survey</a></li>
											<?php } ?>
											
											<?php if(get_user_office_id()=="CEB" || get_user_office_id()=="MAN"){ ?>
											
												  <li class="menu-item"><a href="<?php echo base_url() ."survey/townhall"; ?>">Townhall Survey</a></li>
											<?php } ?>
											
											<?php if(is_access_clinic_portal()){ ?>
											
												  <li class="menu-item"><a href="<?php echo base_url() ."clinic_portal"; ?>">Total Rewards</a></li>
											<?php } ?>
																						
											<?php if(get_global_access() == 1 || isADLocation() || is_access_downtime_tracker()){ ?>
											
												  <li class="menu-item"><a href="<?php echo base_url() ."downtime/ameridial"; ?>">Downtime Tracker</a></li>
												  
											<?php } ?>
											
											<?php /*?><?php if(get_global_access() == 1 || isIndiaLocation() || get_user_office_id()=="CEB" || get_user_office_id()=="MAN"){ ?><?php */?>
												  <li class="menu-item"><a href="<?php echo base_url() ."survey/tna"; ?>">TNA</a></li>
											<?php /*?><?php } ?><?php */?>
											
											<?php if(get_user_office_id()=="CEB" || get_global_access()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url() ."survey/hr_audit"; ?>">HR Audit Survey</a></li>
											<?php } ?>
											
											<?php if (news_access_permission() == 1) { ?>
											
												  <li class="menu-item"><a href="<?php echo base_url() . "news/news_list"; ?>">News</a></li>
											<?php } ?>
											
											<?php
												if(isDisablePersonalInfo()==false){
											?>
												  <li class="menu-item"><a href="<?php echo base_url()."payslip";?>">Salary Slip</a></li>
												
												  <li class="menu-item"><a href="<?php echo base_url()."itdeclaration";?>">IT Declaration</a></li>
												  <li class="menu-item"><a href="<?php echo base_url() . "mediclaim"; ?>">Mediclaim Card</a></li>
												  
											<?php } ?>
											
											<?php 
												if(get_dept_folder()=="training" || is_access_trainer_module()==true || isAgentInTraining() || isAvilTrainingExam() >0 ){
													
													if(isAssignAsTrainer()>0) $linkurl=base_url()."training/crt_batch";
													else if((isAgentInTraining() && get_dept_folder()!="training") || isAvilTrainingExam() >0 ) $linkurl=base_url()."training/agent";
													else $linkurl=base_url()."training/crt_batch";
									
													//$linkurl=base_url()."uc";
											?>
												  <li class="menu-item"><a href="<?php echo $linkurl;?>">Training</a></li>
											<?php } ?>
											
												  <li class="menu-item"><a href="<?php echo base_url()."knowledge";?>">Knowledge Base</a></li>
												  
												  <li class="menu-item"><a href="<?php echo base_url(); ?>faq">FAQ</a></li>
												  
												  <li class="menu-item"><a href="<?php echo base_url(); ?>message">Shoutbox</a></li>
												  
												  <li class="menu-item"><a href="<?php echo base_url(); ?>course">Level Up</a></li>
												  
												  <li class="menu-item"><a href="<?php echo base_url(); ?>kat">Kat</a></li>
												  <li class="menu-item"><a href="<?php echo base_url(); ?>kat_admin">KAT 2.0</a></li>
												  
												  <?php if(is_access_ld_registration()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url(); ?>ld_courses">L&D Registration</a></li>
												  <?php } ?>
												  
												  <li class="menu-item"><a href="<?php echo base_url(); ?>ld_programs">L&D Progress</a></li>
												  
												  <li class="menu-item"><a href="<?php echo base_url(); ?>process_update">Process Updates</a></li>
												  <li class="menu-item"><a href="<?php echo base_url(); ?>pmetrix_v2">Performance Metrics</a></li>
												  
												  <li class="menu-item"><a href="<?php echo base_url(); ?>pip">PIP</a></li>
												  
											<?php if(isAccessMindfaqApps()==true){ ?>
												  
												  <?php if(is_access_jurys_inn_modules()==true){ ?>
													<li class="menu-item"><a href="<?php echo base_url() ."mindfaq_jurryinn"; ?>">JurysInn MindFAQ</a></li>
												  <?php } ?>
												  
												  <?php if(is_access_mpower_modules()==true){ ?>
													<li class="menu-item"><a href="<?php echo base_url() ."mindfaq_mpower"; ?>">Mpower MindFAQ</a></li>
												  <?php } ?>
												  <?php if(is_access_apphelp_modules()==true){ ?>
													<li class="menu-item"><a href="<?php echo base_url() ."mindfaq_apphelp"; ?>">AppHelp MindFAQ</a></li>
												  <?php } ?>
												  <?php if(is_access_affinity_modules()==true){ ?>
													<li class="menu-item"><a href="<?php echo base_url() ."mindfaq_affinity"; ?>">Affinity MindFAQ</a></li>
												  <?php } ?>
												  <?php if(is_access_meesho_modules()==true){ ?>
													<li class="menu-item"><a href="<?php echo base_url() ."mindfaq_meesho"; ?>">Meesho MindFAQ</a></li>
												  <?php } ?>
												
												<?php if(is_access_kabbage_modules()==true){ ?>
													<li class="menu-item"><a href="<?php echo base_url() ."mindfaq_kabbage"; ?>">Kabbage MindFAQ</a></li>
												<?php } ?>
												
												<?php /*?><?php if(is_access_brightway_modules()==true){ ?><?php */?>
													<!--<li class="menu-item"><a href="<?php /*?><?php echo base_url() ."mindfaq_brightway"; ?><?php */?>">Brightway MindFAQ</a></li>-->
												<?php /*?><?php } ?><?php */?>
												
												<?php if(is_access_snapdeal_modules()==true){ ?>
													<li class="menu-item"><a href="<?php echo base_url() ."mindfaq_snapdeal"; ?>">Snapdeal MindFAQ</a></li>
												<?php } ?>
												   
												<?php if(is_access_cars24_modules()==true){ ?> 
												  <li class="menu-item"><a href="<?php echo base_url() ."mindfaq_cars24"; ?>">Cars24 MindFAQ</a></li>
												<?php } ?>
												
												<?php /*?><?php if(is_access_awareness_modules()==true){ ?><?php */?>
												  <!--<li class="menu-item"><a href="<?php /*?><?php echo base_url() ."mindfaq_awareness"; ?><?php */?>">Awareness MindFAQ</a></li>-->
												<?php /*?><?php } ?><?php */?>
												
												<?php /*?><?php if(is_access_paynearby_modules()==true){ ?><?php */?> 
												  <!--<li class="menu-item"><a href="<?php /*?><?php echo base_url() ."mindfaq_paynearby"; ?><?php */?>">Pay Nearby MindFAQ</a></li>-->
												 <?php /*?><?php } ?><?php */?>
													
												<?php /*?><?php if(is_access_cci_modules()==true){ ?><?php */?>
												  <!--<li class="menu-item"><a href="<?php /*?><?php echo base_url() ."mindfaq_cci"; ?><?php */?>">CCI MindFAQ</a></li>-->
												<?php /*?><?php } ?><?php */?>
												
												<?php if(is_access_phs_modules()==true){ ?>
												  <li class="menu-item"><a href="<?php echo base_url() ."mindfaq_phs"; ?>">PHS MindFAQ </a></li>
												<?php } ?>
												
												<?php /*?><?php if(is_access_att_modules()==true){ ?><?php */?>
												  <!--<li class="menu-item"><a href="<?php /*?><?php echo base_url() ."mindfaq_att"; ?><?php */?>"> AT&T MindFAQ </a></li>-->
												<?php /*?><?php } ?><?php */?>
												
												
												<?php if(is_access_clio_modules()==true){ ?>
												  <li class="menu-item"><a href="<?php echo base_url() ."mindfaq_clio"; ?>"> CLIO MindFAQ </a></li>
												<?php } ?>
												
												
												
												
											<?php } ?>
											
											<?php if(is_access_jurys_inn_crm_report()==true || is_crm_readonly_access_mindfaq() || get_user_fusion_id()=="FALB000144"){ ?>
											
												  <li class="menu-item"><a href="<?php echo base_url() ."jurys_inn/"; ?>">JurysInn CRM</a></li>
											<?php } ?>
											<?php if(is_access_alpha_gas_modules()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url() ."alphagas"; ?>">Alpha Gas CRM</a></li>
											<?php } ?>
											<?php
												if( is_access_k2crm_modules()==true || is_crm_readonly_access_mindfaq()){
											?>
												  <li class="menu-item"><a href="<?php echo base_url(); ?>k2_claims_crm">K2 Claims CRM</a></li>
											<?php } ?>	  
											<?php
												if(is_access_mpower_voc_report()==true || is_crm_readonly_access_mindfaq()){
											?>
												  <li class="menu-item"><a href="<?php echo base_url() ."mpower"; ?>">Mpower VOC</a></li>
											<?php } ?>
											<?php if(is_access_meesho_modules() || is_access_meesho_search_modules()){ ?>
											
												  <li class="menu-item"><a href="<?php echo base_url()."meesho_bulk";?>">Meesho Search</a></li>
											<?php } ?>
											<?php if(is_access_t2_capabilities()==true){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."t2_capabilities";?>">Docusign Skills</a></li>
											<?php } ?>
											<?php if(get_user_fusion_id()!="FALB000144"){?>
												  <li class="menu-item"><a href="<?php echo base_url()."covid_case/form/";?>">Contact Tracing</a></li>
											<?php }?>
											<?php if(is_access_zovio_modules()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."contact_tracing_crm";?>">Zovio CRM</a></li>
											<?php } ?>
											
											
											<?php if(is_access_follett_modules()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."contact_tracing_follett";?>">Follett CRM</a></li>
											<?php } ?>
											
											<?php if(is_access_howard_modules()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."howard_training";?>">Howard System</a></li>
											<?php } ?>
											<?php if(is_access_mckinsey_modules()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."mck";?>">Mckinsey</a></li>
											<?php } ?>
											
											<?php if(is_access_kyt_modules()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."kyt";?>">KYT CRM</a></li>
											<?php } ?>
											<?php if(is_access_cj_crm_modules()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."emat_new/dashboard";?>">CJ CRM</a></li>
											<?php } ?>	  
											
											<?php
								   
												$url="home";
												 $admin_access_array = array('FKOL006288','FKOL005998','FKOL001961');
												 $f_id = get_user_fusion_id();
												 if(get_process_ids() == '536' || get_process_ids() == '537'){
													$url="qenglish/newCustomer";
												 }

												 if(in_array($f_id,$admin_access_array)){ 
													$this->session->set_userdata('qenglish_client', 'yes');
														$url="qenglish";
												 }

												if(get_client_ids() == '250' || in_array($f_id,$admin_access_array)){
													
											?>
												<li class="menu-item"><a href="<?php echo base_url().$url;?>">Queen's English CRM</a></li>
												
											<?php } ?>	
											
											<?php if(is_access_emat_crm()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."emat";?>">EMAT CRM</a></li>
											<?php } ?>
											
											<?php if(is_access_oyo_disposition()==true){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."oyo_disposition";?>">OYO Disposition</a></li>
											<?php } ?>
											<?php if(is_access_ma_platform()==true){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."ma_platform";?>">M&A Platform</a></li>
											<?php } ?>
											<?php if(is_access_harhith() || get_user_fusion_id()=="FCHA001874"){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."harhith";?>">Harhith CRM</a></li>
											<?php } ?>
											<?php if(is_access_client_voc()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."harhith";?>" >Client VOC</a></li>
											<?php } ?>
											
												  <li class="menu-item"><a href="<?php echo base_url() ."webpages/cci/index.html"; ?>" target="_blank" >CCI Health</a></li>
											
											<?php if( get_role_dir()!="agent" || isAccessReports()==true ){ ?>
											
													 <li class="menu-item"><a href="<?php echo base_url()."reports_hr";?>" target="_blank" >HR & Attendance</a></li>
													 
													 <li class="menu-item"><a href="<?php echo base_url()."reports_pm";?>" target="_blank" >Performance Report</a></li>
													 
													 <li class="menu-item"><a href="<?php echo base_url()."reports_misc/itAssessment";?>" target="_blank" >Miscellaneous</a></li>
													 
											<?php } ?>
											
											<?php if(isAccessMindfaqReports()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."mindfaq_analytics_skt";?>">Mindfaq</a></li>
											<?php } ?>
											
											<?php if(isAccessAvonReports()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."avon_chat_report/export";?>">AVON CHAT DATA</a></li>
											<?php } ?>
											
											
												  <li class="menu-item"><a href="<?php echo base_url()."report_center";?>">Report Hub</a></li>
											
											<?php if(is_access_reset_password()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."user_password_reset";?>">Reset Password</a></li>
											<?php } ?>
											
												<li class="menu-item"><a href="<?php echo base_url()."servicerequest";?>">Service Request</a></li>
												
												<li class="menu-item"><a href="<?php echo base_url()."album";?>">Photo Gallery</a></li>
											
												<?php if(is_access_master_entry()=='1'){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."master/role";?>">Master Entry</a></li>
												<?php } ?>
												
												<?php if(isAccessQuestionBank()){ ?>
												  <li class="menu-item"><a href="<?php echo base_url()."examination";?>">Question Bank</a></li>
												<?php } ?>
												
												<?php if(get_user_fusion_id()=="FKOL000001" || get_user_fusion_id()=="FKOL001800" || get_user_fusion_id()=="FKOL012753"){ ?>
													<li class="menu-item"><a href="<?php echo base_url() . "Qa_boomsourcing/boomsourcing"; ?>"> Boomsourcing </a></li>
												<?php } ?>
												
												<li class="menu-item"><a href="#"></a></li>
												</ul>
											</div>
																						
                                        </div>
                                    </div>
									<?php } if(is_ppbl_check()=='1'){?>
                                 <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-uielement">
                                    <div class="ps-2 p-lg-0">
                                       <div class="search-widget">
                                          <div class="input-group mb-3">
                                             <input type="text" class="form-control" id="appSearchInput" placeholder="Search Menu" autocomplete="off" aria-label="Search Menu" aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="mega-widget">
                                          <ul class="sub-menu topul">
                                             <li class="menu-item"><a href="<?php echo base_url() ?>profile">My Profile</a></li>
                                             <?php
                                                if (get_role_dir() != "agent" || get_site_admin() == '1' || get_global_access() == '1' || get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_dept_folder() == "rta") {
                                                    if (get_global_access() == '1')
                                                        $team_url = base_url() . "super/dashboard";
                                                    else if (get_dept_folder() == "hr")
                                                        $team_url = base_url() . 'hr/dashboard';
                                                    else if (get_dept_folder() == "wfm" || get_dept_folder() == "rta")
                                                        $team_url = base_url() . 'wfm/dashboard';
                                                    else if (get_site_admin() == "1")
                                                        $team_url = base_url() . 'admin/dashboard';
                                                    else
                                                        $team_url = base_url() . get_role_dir() . "/dashboard";
                                                    ?>
                                             <?php } ?>
                                             
                                             <?php if (get_user_office_id() != "ALT" && get_user_office_id() != "DRA") { ?>
                                             <li class="menu-item"><a id='viewModalAttendance' > My Time </a></li>
                                             <?php } ?>
                                             <?php
                                                $ac_class = "";
                                                if (in_array(get_user_office_id(), ["ALT", "JAM", "CEB", "MAN", "CAS", "ALB","KOS"]) || isIndiaLocation(get_user_office_id()) == true || get_global_access() == '1')
                                                    $linkurl = base_url() . "leave_ppbl/";
                                                else if (get_user_fusion_id() == 'FALT002231')
                                                    $linkurl = base_url() . "leave_ppbl/leave_approval";
                                                else
                                                    $linkurl = base_url() . "uc/";
                                                ?>  
                                             <li class="menu-item"><a href="<?php echo $linkurl; ?>"> Leave </a></li>
                                             <li class="menu-item"><a href="#"></a></li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 <?php }
									}else if(is_access_qa_boomsourcing()==True){
								 ?>
								<!--------------Boomsourcing---------------->
									<div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-uielement">
										<div class="ps-2 p-lg-0">
										   <div class="search-widget">
											  <div class="input-group mb-3">
												 <input type="text" class="form-control" id="appSearchInput" placeholder="Search Menu" autocomplete="off" aria-label="Search Menu" aria-describedby="basic-addon2">
												 <div class="input-group-append">
													<button class="btn btn-primary" type="button">
													<i class="fa fa-search" aria-hidden="true"></i>
													</button>
												 </div>
											  </div>
										   </div>
										   <div class="mega-widget">
												<ul class="sub-menu topul">
													<li class="menu-item"><a href="<?php echo base_url() . "Qa_boomsourcing/boomsourcing"; ?>"> Boomsourcing </a></li>
												</ul>
										   </div>
										</div>
									</div>
								  <?php } ?>
                                </li>                               
                            </ul>
							
                            
                            
                        </div>
                    </nav>
                    	</div>
						<?php if(is_ppbl_check()!='1'){?>
                    	<div class="col-sm-2">
                    		<div class="your-referral">
                                <div class="referral-left">
                                    <a class="nav-link less-gap dropdown-toggle arrow-none" href="#" data-bs-toggle="modal" data-bs-target="#addReferrals" style="color:#0000e6;font-weight:bold">
                                        <i class="fa fa-bandcamp" aria-hidden="true"></i><span data-key="t-components">Add Referral</span>
                                    </a>
									
                                </div>
                                <div class="referral-left">
								
									<?php if (count($get_references_user) > 0) { ?>
                                            <a data-bs-toggle="modal" data-bs-target="#reference" style="color:#0000e6;font-weight:bold; cursor:pointer;" >Your Referrals - <span style="font-weight:bold; cursor:pointer;"><?php echo count($get_references_user); ?></span></a>
                                        <?php } else { ?>
                                           <span style="font-weight:bold">No Referrals, Keep Referring</span>
                                        <?php } ?>
										
                                   
                                </div>                           
                            </div>
                    	</div>
						<?php }?>
                    	<div class="col-sm-2">
                    		<div class="time-right">
			                     <strong>EST Time : <span class="blue-color" id="txt"></span></strong>
			                 </div>
                    	</div>
                    	<div class="col-sm-2">
                    		<div class="time-right">
			                    <strong>Local Time : <span id="txt1" class="blue-color"></span></strong>
			                </div>
                    	</div>
                    	<div class="col-sm-2">
                    		<div class="time-right" style='float:right;'>
			                    <p><strong>Last Logged in today: <span class="blue-color">
								<?php echo ($dialer_logged_in_time != '' ? ConvServerToLocal($dialer_logged_in_time) : '') ?>
								</span></strong></p>
			                </div>
                    	</div>
                    </div>
                </div>
            </div>



            <div class="main-content">            	
                <div class="page-content">                	
                    <div class="container-fluid">

                    <div class="row">
							
						<div class="col-xl-9">


                        <!-- IT assets View section -->
                        <?php if($assets_assignement_details['status']==true) { $c=1; ?>
                        <div class="row">
                        <div class="col-xl-12">
                                <div class="card">                  
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-xl-8">
                                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                       <h4 class="mb-sm-0 font-size-18">YOUR ASSIGNED ASSETS DETAILS</h4>
                                    </div>
                                            </div>
                                        </div>
                              <div class="table-widget">
                                 <table class="table table-striped">
                                 <thead>
                                   <tr>
                                 <th>SL</th>
                                 <th>Assets Name</th>
                                 <th>Serial Number</th>
                                 <th>Model Number</th>
                                 <th>Brand</th>
                                 <th>Details</th>
                                 <th>Assigned By</th>
                                 <th>Assigned Date</th>
                                 <th style="width:200px;">Status</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                 <?php if($assets_assignement_details['inv']!=false)  {
                                       foreach ($assets_assignement_details['inv'] as $value) {
                                 ?>
                                    <tr>
                                       <td><?=$c?></td>
                                       <td><?=$value['assets_name']?></td>
                                       <td><?=$value['serial_number']?></td>
                                       <td><?=$value['model_number']?></td>
                                       <td><?=$value['brand_name']?></td>
                                       <td><?=$value['configuration']?></td>
                                       <td><?=$value['assigned_by']?></td>
                                       <td><?=$value['assign_date']?></td>
                                       <td style="text-align: center;">
                                      <?php if($value['is_user_acknowledge']==null || $value['is_user_acknowledge']=='') { $subm_id=$value['tab_his_id']; ?>

                                          <a onclick="return confirm('Are you sure?');" href="<?=base_url()?>dfr_it_assets/user_assets_acknowledge_update/<?=$subm_id?>/inv/accept" class="btn btn-sm-new btn-success asset-btn" style="float: left;">Accept</a>

                                          <div class="dropdown">
                                               <button type="button" class="btn btn-danger btn-sm-new dropdown-toggle" data-bs-toggle="dropdown" style="float: left;"> 
                                                 Decline <i class="fa fa-angle-down" aria-hidden="true"></i>
                                               </button>
                                               <ul class="dropdown-menu">
                                                <li>
                                                   <input type="text" class="form-control" id="myInput" placeholder="search" id="" />
                                                </li>
                                             <?php foreach($assets_assignement_details['decline_mst'] as $value) { ?>
                                                <div id="list_new">
                                                 <li><a class="dropdown-item" href="<?=base_url()?>dfr_it_assets/user_assets_acknowledge_update/<?=$subm_id?>/inv/decline/<?=$value['id']?>"><?=$value['name']?></a></li> 
                                             </div>
                                             <?php } ?>
                                               </ul>
                                            </div>

                                       <?php } else {?>

                                          <span style="color: green;">Done | <?=$value['acknowledge_date']?> </span>

                                       <?php } ?>
                                       </td>
                                    </tr>
                                 <?php $c++; } } ?>

                                 <?php if($assets_assignement_details['non_inv']!=false)  {
                                       foreach ($assets_assignement_details['non_inv'] as $value) {
                                 ?>
                                    <tr>
                                       <td><?=$c?></td>
                                       <td><?=$value['assets_name']?></td>
                                       <td>-</td>
                                       <td>-</td>
                                       <td>-</td>
                                       <td><?=$value['comments']?></td>
                                       <td><?=$value['assigned_by']?></td>
                                       <td><?=$value['raised_date']?></td>
                                       <td style="text-align: center;">
                                       <?php if($value['is_user_acknowledge']==null || $value['is_user_acknowledge']=='') { $subm_id=$value['id']; ?>

                                          <a onclick="return confirm('Are you sure?');" href="<?=base_url()?>dfr_it_assets/user_assets_acknowledge_update/<?=$subm_id?>/non_inv/accept" class="btn btn-sm-new btn-success asset-btn" style="float: left;">Accept</a>

                                          <div class="dropdown">
                                               <button type="button" class="btn btn-danger btn-sm-new dropdown-toggle" data-bs-toggle="dropdown" style="float: left;"> 
                                                 Decline <i class="fa fa-angle-down" aria-hidden="true"></i>
                                               </button>
                                               <ul class="dropdown-menu">
                                             <?php foreach($assets_assignement_details['decline_mst'] as $value) { ?>
                                                 <li><a class="dropdown-item" href="<?=base_url()?>dfr_it_assets/user_assets_acknowledge_update/<?=$subm_id?>/non_inv/decline/<?=$value['id']?>"><?=$value['name']?></a></li>
                                              <?php } ?>
                                               </ul>
                                            </div>

                                       <?php } else {?>

                                          <span style="color: green;">Done | <?=$value['acknowledge_date']?> </span>

                                       <?php } ?>
                                       </td>
                                    </tr>
                                 <?php $c++; } } ?>
                                 
                                 </tbody>
                                </table>
                              
                              </div>
               
                                    </div>                                    
                                </div>                                
                            </div>                            
        
                        </div>
                     <?php } ?>


						
						<?php if ( get_role_dir()=="agent" || get_role_dir()=="tl" || is_access_break_identifier() === true) { ?>
							<div class="row">
							 
                             <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-70">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <span class="text-muted mb-2 lh-1 d-block text-truncate">
													Lunch/Dinner break.
												</span>
                                                <h5 class="mb-2">
                                                    <span class="counter-value" id='lunch_timer' >0:00:00</span> Hours
                                                </h5>
                                            </div>
        
                                            <div class="col-3">
                                                <div class="body-widget justify-content-end">
													<label class="switch">
												<?php if ($break_on_ld === true) : ?>
													<input class='break_onoff' type="checkbox" typ='lunch' checked>
												<?php else : ?>
													<input class='break_onoff' type="checkbox" typ='lunch' <?php echo $ldDiasable; ?>>
												<?php endif; ?>
													  <span class="slider-toggle round"></span>
													</label>
												</div>
                                            </div>
                                        </div>
										<!--
                                        <div class="text-nowrap">
                                            <span class="badge bg-soft-success text-success" id='total_lunch' >45 min</span>
                                            <span class="ms-1 text-muted font-size-13">Since Today </span>
                                        </div>
										-->
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-h-70">         
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <span class="text-muted mb-2 lh-1 d-block text-truncate">
													Coaching  break.
												</span>
                                                <h5 class="mb-2">
												<span class="counter-value" id='coaching_timer' >0:00:00</span> Hours              
                                                </h5>
                                            </div>
                                            <div class="col-3">
                                                <div class="body-widget justify-content-end">
													<label class="switch">
													  													  
													  <?php if ($break_on_cb === true) : ?>
														<input class='break_onoff' type="checkbox" typ='coaching' checked>
													<?php else : ?>
														<input class='break_onoff' type="checkbox" typ='coaching' <?php echo $cbDiasable; ?>>
													<?php endif; ?>
												
													  <span class="slider-toggle round"></span>
													</label>
												</div>
                                            </div>
                                        </div>
										<!--
                                        <div class="text-nowrap">
                                            <span class="badge bg-soft-success text-success" id='total_coaching'>45 min</span>
                                            <span class="ms-1 text-muted font-size-13">Since Today</span>
                                        </div>
										-->
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-h-70">         
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <span class="text-muted mb-2 lh-1 d-block text-truncate">
													Others break.
												</span>
                                                <h5 class="mb-2">
                                                    <span class="counter-value" id='others_timer' >0:00:00</span> Hours
                                                </h5>
                                            </div>
        
                                            <div class="col-3">
                                                <div class="body-widget justify-content-end">
													<label class="switch">
													  
													  
													  <?php if ($break_on === true) : ?>
														<input type="checkbox" class='break_onoff' typ='others' checked>
                                                      <?php else : ?>
														<input type="checkbox" class='break_onoff' typ='others' <?php echo $diasable; ?>>
													  <?php endif; ?>
											
													  <span class="slider-toggle round"></span>
													</label>
												</div>
                                            </div>
                                        </div>
										<!--
                                        <div class="text-nowrap">
                                            <span class="badge bg-soft-success text-success" id='total_others'>45 min</span>
                                            <span class="ms-1 text-muted font-size-13">Since Today</span>
                                        </div>
										-->
                                    </div>
                                </div>
                            </div>
							
							<div class="col-xl-3 col-md-6">
                                <div class="card card-h-70">         
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <span class="text-muted mb-2 lh-1 d-block text-truncate">
													Downtime break.
												</span>
                                                <h5 class="mb-2">
                                                    <span class="counter-value" id='downtime_timer'>0:00:00</span> Hours
                                                </h5>
                                            </div>
        
                                            <div class="col-3">
                                                <div class="body-widget justify-content-end">
													<label class="switch">
													
													<?php if ($break_on_sd === true) : ?>
														<input type="checkbox" class='break_onoff' typ='downtime' checked>
                                                      <?php else : ?>
														<input type="checkbox" class='break_onoff' typ='downtime' <?php echo $sdDiasable; ?>>
													  <?php endif; ?>
													  
													  <span class="slider-toggle round"></span>
													</label>
												</div>
                                            </div>
                                        </div>
										<!--
                                        <div class="text-nowrap">
                                            <span class="badge bg-soft-success text-success" id='total_downtime' >45 min</span>
                                            <span class="ms-1 text-muted font-size-13">Since Today</span>
                                        </div>
										-->
                                    </div>
                                </div>
                              </div>
																					
							</div>
							
						<?php }  ?>	
													
						<?php if (count($curr_schedule) > 0) { ?>
							 
							<div class="row">
								<div class="col-xl-12">
                                <div class="card">                  
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-xl-4">
                                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
													<h4 class="mb-sm-0 font-size-18">Your Schedule</h4>
												</div>
                                            </div>
                                        </div>
										<div class="table-widget">
											<table class="table table-striped">
											<thead>
											  <tr>
												<th>Date</th>
												<th>Day</th>
												<th>In Time</th>
												<th>Break 1</th>
												<th>Lunch</th>
												<th>Break 2</th>
												<th>End Time</th>
												<th>Status</th>
											  </tr>
											</thead>
											<tbody>
											
											  <?php
                                                foreach ($curr_schedule as $user) {
                                                    if (strtotime($user['shdate']) == strtotime($currenDate) || strtotime($user['shdate']) == strtotime($tomoDate)) {

                                                        $shr_status = "Ok";
                                                        if ($user['is_accept'] == '2') {
                                                            $shr_status = "In Review";
                                                        }
                                                        if ($user['is_accept'] == '1') {
                                                            $shr_status = "Reviewed";
                                                        }
                                                        if ($user['is_accept'] == '1' && $user['agent_status'] != 'C') {
                                                            $shr_status = "Accepted";
                                                        }
                                                        if ($user['is_accept'] == '1' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && empty($user['wfm_status'])) {
                                                            $shr_status = "Reviewed by WFM";
                                                        }
                                                        if ($user['is_accept'] == '1' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && $user['wfm_status'] == 'C') {
                                                            $shr_status = "Updated by WFM";
                                                        }
                                                        if ($user['is_accept'] == '3') {
                                                            $shr_status = "Rejected";
                                                        }

                                                        $shr_remarks = "Accepted by Agent";
                                                        if ($user['is_accept'] == '2' && $user['agent_status'] == 'R') {
                                                            $shr_remarks = "Pending Review by Operations";
                                                        }
                                                        if ($user['is_accept'] == '2' && $user['agent_status'] == 'C' && $user['ops_status'] == 'R') {
                                                            $shr_remarks = "To be Reviewed by WFM";
                                                        }
                                                        if ($user['is_accept'] == '1' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && $user['wfm_status'] != 'C') {
                                                            $shr_remarks = $user['ops_review'];
                                                        }
                                                        if ($user['is_accept'] == '1' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && $user['wfm_status'] == 'C') {
                                                            $shr_remarks = $user['wfm_review'];
                                                        }
                                                        if ($user['is_accept'] == '3' && $user['agent_status'] == 'C' && $user['ops_status'] == 'C' && $user['wfm_status'] == 'X') {
                                                            $shr_remarks = $user['wfm_review'];
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
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
											 
											 
											</tbody>
										  </table>
										  <a class="explore-weekly" data-bs-toggle="modal" data-bs-target="#schedule" style="cursor:pointer;" >
											Explore Weekly
										  </a>
										</div>
										
										
                                    </div>                                    
                                </div>                                
                            </div>                            
        
                        </div>
						
						<?php } ?>

<?php
$current_data_set = $schedule_monthly[round($selected_month)]['counters'];
?>

						<div class="row">
							
							<div class="col-xl-6">             
                                <div class="card card-h-100">
                                    <div class="card-body">
									
                                        <div class="d-flex flex-wrap align-items-center mb-2">
                                            <div class="row">            
												<div class="col-sm-10">
													<h5 class="card-title ">
														<div class="icon-bg">
															<i class="fa fa-user" aria-hidden="true"></i>
														</div>
														Monthly Schedule Adherence - <?php echo $schedule_monthly[round($selected_month)]['month'] . " " . $schedule_monthly[round($selected_month)]['year']; ?>
													</h5>
												</div>
												
												
							
							
												<div class="col-sm-2">
													
													 <?php $adh_url_fix = "?select_month=" . $selected_month . "&select_year=" . $selected_year . "&select_fusion=" . $selected_fusion; ?>
													 
													<div class="right-more">
														<a href="<?php echo base_url() . "schedule_adherence/dashboard/all" . $adh_url_fix; ?>" target="_blank" class="read-more-link">
															More
														</a>
													</div>
												</div>
											</div>
                                        </div>
				
		<!-- "On Time", "Late", "Off", "Leave", "Absent" -->
		
		
                                       <div class="row align-items-center">
                                            <div class="col-sm-7">
												<div class="monthly-widget">
													<canvas id="ScheduleAdherenceChart" style="width:100%;max-width:600px"></canvas>
													<div class="legend-widget"></div>
												</div>
                                            </div>
                                            <div class="col-sm-5 align-self-center">
                                                <div class="mt-4 mt-sm-0">
                                                    <div>
                                                        <p class="mb-2">
															<i class="fa fa-circle text-success" aria-hidden="true"></i> 
															On Time
															<strong><?php echo $schedule_monthly[round($selected_month)]['counters']['ontime']; ?>,(<?php echo $schedule_monthly[round($selected_month)]['percent']['ontime']; ?>%)</strong>
														</p>                                                        
                                                    </div>
													
													<div class="mb-2">
                                                        <p class="mb-2">
															<i class="fa fa-circle yellow-bg" aria-hidden="true"></i> 
															Late
															<strong><?php echo $schedule_monthly[round($selected_month)]['counters']['latetime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['latetime']; ?>%)</strong>
														</p>                                                        
                                                    </div>
    
                                                    <div class="mb-2">
                                                        <p class="mb-2">
															<i class="fa fa-circle gray-bg" aria-hidden="true"></i> 
															Off
															<strong><?php echo $schedule_monthly[round($selected_month)]['counters']['offtime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['offtime']; ?>%)</strong>
														</p>                                                        
                                                    </div>
    
                                                    <div class="mb-2">
                                                        <p class="mb-2">
															<i class="fa fa-circle blue-fa-bg" aria-hidden="true"></i> 
															Leave
															<strong><?php echo $schedule_monthly[round($selected_month)]['counters']['leavetime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['leavetime']; ?>%)</strong>
														</p>                                                        
                                                    </div>
													<div class="mb-2">
                                                        <p class="mb-2">
															<i class="fa fa-circle text-danger" aria-hidden="true"></i> 
															Absent
															<strong><?php echo $schedule_monthly[round($selected_month)]['counters']['absenttime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['absenttime']; ?>%)</strong>
														</p>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										
										
                                    </div>
                                </div>                                
                            </div> 
							
							<div class="col-xl-6">
                                        <div class="card card-h-100">
                                            <div class="card-body">
                                                <div class="row">
													<div class="col-sm-6">
														<div class="small-widget">
															<div class="top-content">
																<strong>Present</strong>
															</div>
															<div class="mb-3">
																<canvas id="PresentChart" class="small-canvas"></canvas>
															</div>
															<div class="middle-content">
																<h3 class="content-title"><?php echo round($current_data_set['present']); ?></h3>
															</div>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="small-widget">
															<div class="top-content">
																<strong>Absent</strong>
															</div>
															<div class="mb-3">
																<canvas id="AbsentChart" class="small-canvas"></canvas>
															</div>
															<div class="middle-content">
																<h3 class="content-title"><?php echo $current_data_set['absent']; ?></h3>
															</div>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="small-widget">
															<div class="top-content">
																<strong>Adherence %</strong>
															</div>
															<div class="mb-3">
																<canvas id="AdherenceChartPer" class="small-canvas"></canvas>
															</div>
															<div class="middle-content">
																<h3 class="content-title"><?php echo round($current_data_set['adherence']); ?></h3>
															</div>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="small-widget">
															<div class="top-content">
																<strong>Shrinkage %</strong>
															</div>
															<div class="mb-3">
																<canvas id="ShrinkageChartPer" class="small-canvas"></canvas>
															</div>
															<div class="middle-content">
																<h3 class="content-title"><?php echo round($current_data_set['shrinkage']); ?></h3>
															</div>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>
                                    </div>                                    
						</div>
						
						
						
						<!--- -->
						<?php if(is_access_qa_boomsourcing()==False){
						if(is_ppbl_check()!='1'){?>
						<div class="row">
                            <div class="col-xl-12">              
                                <div class="card">                 
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-xl-4">
                                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
													<h4 class="mb-sm-0 font-size-18">All Apps</h4>
												</div>
                                            </div>                                           
                                        </div>
										
                                        <div class="tabs-widget">
    										<ul id="nav-tabs" class="nav nav-pills nav-fill" role="tablist">
                                                <li class="nav-item">
                                                  <a class="nav-link active" data-bs-toggle="pill" href="#panelhr">
                                                      Human Resource
                                                  </a>
                                                </li>   

												 <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_letter">
                                                      Letters
                                                  </a>
                                                </li>
												
												<?php if (isAccessAssetManagement() == true) { ?>
													<li class="nav-item">
													  <a class="nav-link" data-bs-toggle="pill" href="#panel_asset">
														  Asset Management
													  </a>
													</li>
												<?php } ?>
												
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_productivity">
                                                      Productivity
                                                  </a>
                                                </li>
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_quality">
                                                      Quality
                                                  </a>
                                                </li>
												
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_info">
                                                      Information
                                                  </a>
                                                </li>
												<?php if(isDisablePersonalInfo()==false){ ?>
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_financials">
                                                      Financials
                                                  </a>
                                                </li>
												<?php } ?>
												
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_learn">
                                                      Learn
                                                  </a>
                                                </li>
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_performance">
                                                      Performance
                                                  </a>
                                                </li>
												
												<?php if(isAccessMindfaqApps()==true){ ?>
												
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_transformation">
                                                      Transformation App
                                                  </a>
                                                </li>
												
												<?php } ?>
												
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_business">
                                                      Business App
                                                  </a>
                                                </li>
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_reporting">
                                                      Analytics & Reporting
                                                  </a>
                                                </li>
                                                <li class="nav-item">
                                                  <a class="nav-link" data-bs-toggle="pill" href="#panel_misc">
                                                      Miscellaneous
                                                  </a>
                                                </li>
                                              </ul>
                                        </div>  

                                        <div class="tab-content">
                                            <div id="panelhr" class="tab-pane active">
                                              <div class="common-top">
                                                   <div class="row">
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/profile-icon.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> My Profile
                                                                    </h2>
                                                                    <a href="<?= $profileURL ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
														
													<?php
											
														if (get_role_dir() != "agent" || get_site_admin() == '1' || get_global_access() == '1' || get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_dept_folder() == "rta")
														{
															
														if (get_global_access() == '1')
															$team_url = base_url() . "super/dashboard";
														else if (get_dept_folder() == "hr")
															$team_url = base_url() . 'hr/dashboard';
														else if (get_dept_folder() == "wfm" || get_dept_folder() == "rta")
															$team_url = base_url() . 'wfm/dashboard';
														else if (get_site_admin() == "1")
															$team_url = base_url() . 'admin/dashboard';
														else
															$team_url = base_url() . get_role_dir() . "/dashboard";
													?>
														
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/my-team-icon.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> My Team 
                                                                    </h2>
                                                                    <a href="<?php echo $team_url; ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
														
													<?php } ?>
													
													<?php
												
														if(is_enable_search() == true){
															
														$linkurl = base_url() . "search_candidate";
													?>	
														
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/search-employee.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> Search Employee
                                                                    </h2>
                                                                    <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
													<?php } ?>
													
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/policies.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> Policies
                                                                    </h2>
                                                                    <a href="<?php echo base_url() ?>policy" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
														
													<?php
														if ((isAssignInterview() > 0 || is_access_dfr_module() == true) && is_disable_module() == false) {

														$ac_class = "";
														$linkurl = base_url() . "dfr";
													?>
											
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/recruitment.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> Recruitment
                                                                    </h2>
                                                                    <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
													<?php } ?>

													<?php if(get_global_access()=='1' ||  get_dept_folder()=="hr" ){ ?>
													<!--bgv-->
													<div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/policies.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> Background Verification
                                                                    </h2>
                                                                    <a href="<?php echo base_url() ?>Bgv" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <!--bgv-->
                                                	<?php } ?>
													
                                                    <?php 
											  													
				                                    if(get_dept_folder() == "it" && it_assets_access()==false) $linkurl = base_url() . "dfr_it_assets/assets_stock_entry";
				                                    elseif (it_assets_access()==true) $linkurl = base_url() . "dfr_it_assets";

														if (it_assets_access()==true || get_dept_folder() == "it")
														{
                                        
													?>	
												        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/recruitment-assets.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> It Assets v1
                                                                    </h2>
                                                                    <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
													<?php } ?>
													
                                                    
												<?php
													if (isIndiaLocation(get_user_office_id()) == true && isAccessNaps() == true) {
												?>
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/naps.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> Naps
                                                                    </h2>
                                                                    <a href="<?php echo base_url() . "naps"; ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
													<?php } ?>
													
													<?php
														if (is_disable_module() == false) {
													?>
												 
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/progression.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> Progression
                                                                    </h2>
                                                                    <a href="<?php echo base_url(); ?>progression" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
													<?php } ?>
													
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/movement.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> Movement
                                                                    </h2>
                                                                    <a href="<?php echo base_url(); ?>uc" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
														
														<div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/movement.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> Separation
                                                                    </h2>
                                                                    <a href="<?php echo base_url() . "user_resign"; ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
														
														
													<?php
														if (isAccessFNF() == true || isAccessFNFHr() == true || isAccessFNFITSecurity() == true || isAccessFNFITHelpdesk() == true || isAccessFNFPayroll() == true || isAccessFNFAccounts() == true || isAccessFNFIT_Morocco() == true || isAccessFNFHR_Morocco() == true)
														{
													?>
												
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/f-f.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> F&F
                                                                    </h2>
                                                                    <a href="<?php echo base_url() . "fnf"; ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
													<?php } ?>
													
													<?php
														if (isIndiaLocation(get_user_office_id()) == true) {
													?>
											
                                                        <div class="col-sm-2">
                                                            <div class="body-widget text-center">
                                                                <div class="apps-bg-icon">
                                                                    <img src="<?php echo base_url() ?>assets_home_v2/images/id-card.png" class="icons-img" alt="">
                                                                    <h2 class="apps-title"> ID-Card
                                                                    </h2>
                                                                    <a href="<?php echo base_url() . "employee_id_card/card"; ?>" class="explore-more">
                                                                        Explore
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
														
													<?php } ?>
													
                                                   </div>
                                              </div>
                                            </div>
											

                                            <div id="panel_letter" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
													
													<?php
														if (isIndiaLocation(get_user_office_id()) == true) {
														if (get_role_dir() != "agent") {
													?>
											
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/efficency-x.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">Confirmation
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "letter/confirmation_list"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													
													<?php } ?>
													
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/course.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Warning
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "Warning_mail_employee/your_warning_letter"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/my-team-icon.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Appraisal / Revision
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "appraisal_employee/your_appraisal_letter"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														<?php } ?>
														 
                                                    </div>
                                               </div>
                                            </div>
											
											
																						
                                            <div id="panel_asset" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
													
														<?php if (isAccessAssetManagement() == true) { ?>
														
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/course.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Manage Asset
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "asset"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 <?php } ?>
														 
                                                    </div>
                                                </div>
                                            </div>
											
											 <div id="panel_productivity" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/efficency-x.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">EfficiencyX
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "egaze"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
													<?php
														if (get_role_dir() != "agent" || is_access_schedule_update() == true || is_access_schedule_upload() == true || get_dept_folder() == "wfm" || get_dept_folder() == "rta" || get_user_fusion_id() == "FELS004207" || get_user_fusion_id() == "FALB000079") {

														$ac_class = "";
														$linkurl = base_url() . "schedule";
													?>

														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/my-team-icon.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Schedule
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "schedule"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?> 
													 
													 <?php 
														if (get_user_office_id() != "ALT" && get_user_office_id() != "DRA") 
														{
													?>
													 
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/my-time.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> My Time
                                                                     </h2>
                                                                     <a class="explore-more viewModalAttendance"> Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													
													<?php
														$ac_class = "";
														if (in_array(get_user_office_id(), ["ALT", "JAM", "CEB", "MAN", "CAS", "ALB","KOS"]) || isIndiaLocation(get_user_office_id()) == true || get_global_access() == '1') 
															$linkurl = base_url() . "leave/";
														else if(get_user_fusion_id() == 'FALT002231') $linkurl=base_url()."leave/leave_approval";
														else
															$linkurl = base_url() . "uc/";
													?>	
											
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/leave.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Leave
                                                                     </h2>
                                                                     <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>

											<?php 
											if(get_global_access()=='1' || get_site_admin()=='1' ||  get_dept_folder()=="hr" || get_dept_folder() == "recruitment" || get_role_dir()=="super" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="tl" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || is_access_breakmon() == true ){
											?>	

														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/my-team-icon.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Break Monitor
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."break_monitor";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
											<?php } ?>
											
														 
                                                    </div>
                                                </div>
                                            </div>
											
											
											<div id="panel_quality" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
													
													<?php
																				
													if( is_access_qa_agent_module()==true || is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){
														$linkurl=base_url()."quality";
														$sr_linkurl=base_url()."qa_servicerequest";
														
													?>
													
													
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/audit.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">Audit
                                                                     </h2>
                                                                     <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 
													<?php } ?>	
													
													<?php /* if( get_user_office_id() == "CEB" || get_user_office_id() == "MAN"){
															if(get_dept_folder() == "operations" || get_user_fusion_id() == "FMAN000342" || get_user_fusion_id() == "FCEB004981"){
																
														$ac_class="";
														$linkurl=base_url()."qa_coaching"; */
														// echo get_dept_folder();
													?>
														<!--<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/report.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Coaching
                                                                     </h2>
                                                                     <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>-->
														 
													<?php //} 
													//} ?>	 
													
													<?php 
														if( get_role_dir()!="agent" || isAccessReports()==true ){
														$ac_class="";
														$linkurl=base_url()."reports_qa/dipcheck";
													?>	

														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/report.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Report
                                                                     </h2>
                                                                     <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													
													<?php if(get_user_fusion_id()=="FKOL000001" || get_user_fusion_id()=="FKOL001800" || get_user_fusion_id()=="FKOL012753"){ ?>
														<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/report.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Boomsourcing
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "Qa_boomsourcing/boomsourcing"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
														 
                                                    </div>
                                                </div>
                                            </div>
											  
											  
											  <div id="panel_info" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
													
													<?php if(isAccessAssetWFH()==true){ ?>	
													
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/course.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Assets
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."wfh_assets";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php  } ?>	 
                                                     
													<?php if(get_user_office_id()=="CEB" || get_user_office_id()=="MAN" || get_global_access()=='1'){ ?>

													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/vaccine.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Covid Pre Check
																 </h2>
																 <a href="<?php echo base_url(); ?>covid19_pre_check" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													<?php  } ?>	
													
													<?php if(get_user_office_id()=="CEB" || get_user_office_id()=="MAN" || get_global_access()=='1'){ ?>
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/vaccine1.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Cognitive Check
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mental_health"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php  } ?>	
												
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/survey.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Survey
																 </h2>
																 <a href="<?php echo base_url(); ?>employee_feedback" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
												<?php if(get_user_office_id()=="KOL" || get_global_access()=='1'){ ?>	 
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/cafeteria-survey.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Cafeteria Survey
																 </h2>
																 <a href="<?php echo base_url(); ?>survey/cafeteria" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
												<?php  } ?>
												<?php if((get_role_dir() != 'agent' && get_dept_id() != '6') ||  get_global_access()=='1'){ ?>
												
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/survey1.png" class="icons-img" alt="">
																 <h2 class="apps-title"> COPC Survey
																 </h2>
																 <a href="<?php echo base_url(); ?>survey/copc" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
												<?php  } ?>
												
												<?php if(get_user_office_id()=="CEB" || get_user_office_id()=="MAN"){ ?>
														
													<div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/reward.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Pulse Survey
																 </h2>
																 <a href="<?php echo base_url() ."survey/employee_pulse"; ?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
												<?php  } ?>
												<?php if(get_user_office_id()=="CEB" || get_user_office_id()=="MAN"){ ?>
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/reward.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Townhall Survey
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."survey/townhall"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
												<?php  } ?>
												<?php if(is_access_clinic_portal()){ ?>
												
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/reward.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Total Rewards
																 </h2>
																 <a href="<?php echo base_url() ."clinic_portal"; ?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
												<?php  } ?>
												<?php if(get_global_access() == 1 || isADLocation() || is_access_downtime_tracker()){ ?>
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/tracker.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Downtime Tracker
																 </h2>
																 <a href="<?php echo base_url() ."downtime/ameridial"; ?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
												<?php  } ?>
												<?php /*?><?php if(get_global_access() == 1 || isIndiaLocation() || get_user_office_id()=="CEB" || get_user_office_id()=="MAN"){ ?><?php */?>
												
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/tna.png" class="icons-img" alt="">
																 <h2 class="apps-title"> TNA
																 </h2>
																 <a href="<?php echo base_url() ."survey/tna"; ?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
												<?php /*?><?php  } ?><?php */?>
												<?php if(get_user_office_id()=="CEB" || get_global_access()){ ?>
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/hr-audit.png" class="icons-img" alt="">
																 <h2 class="apps-title"> HR Audit Survey
																 </h2>
																 <a href="<?php echo base_url() ."survey/hr_audit"; ?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
												<?php  } ?>
												
												<?php if (news_access_permission() == 1) { ?>
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/hr-audit.png" class="icons-img" alt="">
																 <h2 class="apps-title"> News
																 </h2>
																 <a href="<?php echo base_url() . "news/news_list"; ?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
												<?php  } ?>
												
												</div>
											</div>
										  </div>
										  
										  <?php
												if(isDisablePersonalInfo()==false){
										  ?>
							
										  <div id="panel_financials" class="tab-pane fade">
											<div class="common-top">
												<div class="row">
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/salary-slip.png" class="icons-img" alt="">
																 <h2 class="apps-title">Salary Slip
																 </h2>
																 <a href="<?php echo base_url()."payslip";?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/it-deduction.png" class="icons-img" alt="">
																 <h2 class="apps-title"> IT Declaration
																 </h2>
																 <a href="<?php echo base_url()."itdeclaration";?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/mediclaim.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Mediclaim Card
																 </h2>
																 <a href="<?php echo base_url() . "mediclaim"; ?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
														 
														 
														 
                                                    </div>
                                                </div>
                                            </div>
											
										<?php  } ?>
									
										<div id="panel_learn" class="tab-pane fade">
											<div class="common-top">
												<div class="row">
												
											<?php 
												if(get_dept_folder()=="training" || is_access_trainer_module()==true || isAgentInTraining() || isAvilTrainingExam() >0 ){
													
													if(isAssignAsTrainer()>0) $linkurl=base_url()."training/crt_batch";
													else if((isAgentInTraining() && get_dept_folder()!="training") || isAvilTrainingExam() >0 ) $linkurl=base_url()."training/agent";
													else $linkurl=base_url()."training/crt_batch";
													//$linkurl=base_url()."uc";
											?>
								
												
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/training.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Training
																 </h2>
																 <a href="<?php echo $linkurl;?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
											<?php } ?>

											
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/knowledge-base.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Knowledge Base
																 </h2>
																 <a href="<?php echo base_url()."knowledge";?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/question.png" class="icons-img" alt="">
																 <h2 class="apps-title"> FAQ
																 </h2>
																 <a href="<?php echo base_url(); ?>faq" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/shoutbox.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Shoutbox
																 </h2>
																 <a href="<?php echo base_url(); ?>message" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													 
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/levelup.png" class="icons-img" alt="">
																 <h2 class="apps-title"> LevelUp
																 </h2>
																 <a href="<?php echo base_url(); ?>course" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/kat.png" class="icons-img" alt="">
																 <h2 class="apps-title"> KAT
																 </h2>
																 <a href="<?php echo base_url(); ?>kat" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													  <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/kat1.png" class="icons-img" alt="">
																 <h2 class="apps-title"> KAT 2.0
																 </h2>
																 <a href="<?php echo base_url(); ?>kat_admin" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													  <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/l-d-registration.png" class="icons-img" alt="">
																 <h2 class="apps-title"> L&D Registration
																 </h2>
																 <a href="<?php echo base_url(); ?>ld_courses" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/l-d-program.png" class="icons-img" alt="">
																 <h2 class="apps-title"> L&D Programs
																 </h2>
																 <a href="<?php echo base_url(); ?>ld_programs" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													
													
												</div>
											</div>
										</div>
											
											 <div id="panel_performance" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/update.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">Updates
                                                                     </h2>
                                                                     <a href="<?php echo base_url(); ?>process_update" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/perfomance.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Performance
                                                                     </h2>
                                                                     <a href="<?php echo base_url(); ?>pmetrix_v2" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/pip.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> PIP
                                                                     </h2>
                                                                     <a href="<?php echo base_url(); ?>pip" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 
														 
                                                    </div>
                                                </div>
                                            </div>
											
										<?php if(isAccessMindfaqApps()==true){ ?>
											
											<div id="panel_transformation" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
													
														<?php if(is_access_jurys_inn_modules()==true){ ?>
														
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/jurysInn-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">JurysInn MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_jurryinn"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php if(is_access_mpower_modules()==true){ ?>
														
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/mpower-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Mpower MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_mpower"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php if(is_access_apphelp_modules()==true){ ?>	
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/appHelp-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> AppHelp MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_apphelp"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php if(is_access_affinity_modules()==true){ ?>
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/affinity-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Affinity MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_affinity"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php if(is_access_meesho_modules()==true){ ?>
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/meesho-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Meesho MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_meesho"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php if(is_access_kabbage_modules()==true){ ?>
										
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/kabbage-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Kabbage MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_kabbage"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
										
													<?php /*?><?php if(is_access_brightway_modules()==true){ ?><?php */?>
										
														  <!--<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php /*?><?php echo base_url() ?><?php */?>assets_home_v2/images/brightway-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Brightway MindFAQ
                                                                     </h2>
                                                                     <a href="<?php /*?><?php echo base_url() ."mindfaq_brightway"; ?><?php */?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>-->
														 
													<?php /*?><?php } ?><?php */?>
										
													<?php if(is_access_snapdeal_modules()==true){ ?>
										
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/snapdeal-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Snapdeal MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_snapdeal"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
													<?php } ?>		
										
													<?php if(is_access_cars24_modules()==true){ ?>
										
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/cars24-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Cars24 MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_cars24"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
										
													<?php /*?><?php if(is_access_awareness_modules()==true){ ?><?php */?>
										
														 <!--<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php /*?><?php echo base_url() ?><?php */?>assets_home_v2/images/awareness-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Awareness MindFAQ
                                                                     </h2>
                                                                     <a href="<?php /*?><?php echo base_url() ."mindfaq_awareness"; ?><?php */?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>-->
													
													<?php /*?><?php } ?><?php */?>
										
													<?php /*?><?php if(is_access_paynearby_modules()==true){ ?><?php */?>
										
														 <!--<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php /*?><?php echo base_url() ?><?php */?>assets_home_v2/images/pay-nearby-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Pay Nearby MindFAQ
                                                                     </h2>
                                                                     <a href="<?php /*?><?php echo base_url() ."mindfaq_paynearby"; ?><?php */?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>-->
													<?php /*?><?php } ?><?php */?>
                                        
													<?php /*?><?php if(is_access_cci_modules()==true){ ?><?php */?>	 
														 
														 <!--<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php /*?><?php echo base_url() ?><?php */?>assets_home_v2/images/cci-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> CCI MindFAQ
                                                                     </h2>
                                                                     <a href="<?php /*?><?php echo base_url() ."mindfaq_cci"; ?><?php */?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>-->
														 
													<?php /*?><?php } ?><?php */?>
										
													<?php if(is_access_phs_modules()==true){ ?>
														
														<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/cci-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> PHS MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_phs"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
													<?php } ?>
													
													<?php /*?><?php if(is_access_att_modules()==true){ ?><?php */?>
														
														<!--<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php /*?><?php echo base_url() ?><?php */?>assets_home_v2/images/cci-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> AT&T MindFAQ
                                                                     </h2>
                                                                     <a href="<?php /*?><?php echo base_url() ."mindfaq_att"; ?><?php */?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>-->
														 
													<?php /*?><?php } ?><?php */?>
													
													<?php if(is_access_clio_modules()==true){ ?>
														
														<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/cci-mindFAQ.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">CLIO MindFAQ
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mindfaq_clio"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
													<?php } ?>
													
													</div>
													</div>
												</div>
											<?php } ?>
														
												<div id="panel_business" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
													
													<?php if(is_access_jurys_inn_crm_report()==true || is_crm_readonly_access_mindfaq() || get_user_fusion_id()=="FALB000144"){ ?>
													
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/jurysInn-CRM.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">JurysInn CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."jurys_inn"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													
													<?php if(is_access_alpha_gas_modules()){ ?>
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/alpha-gas-crm.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Alpha Gas CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."alphagas"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													
													<?php
														if( is_access_k2crm_modules()==true || is_crm_readonly_access_mindfaq()){
													?>
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/k2-claim.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> K2 Claims CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url(); ?>k2_claims_crm" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
													<?php } ?>
													<?php
													if(is_access_mpower_voc_report()==true || is_crm_readonly_access_mindfaq()){
													?>
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/mpower.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Mpower VOC
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."mpower"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php if(is_access_meesho_modules() || is_access_meesho_search_modules()){ ?>
								
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/meesho-search.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Meesho Search
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."meesho_bulk";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
								
													<!-- ======== Business App > 5 Docusign Skills ============== -->	
													<?php if(is_access_t2_capabilities()==true){ ?>
								
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/skills.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Docusign Skills
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."t2_capabilities";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
								
								
												<!-- ======== Business App > 6 Contact Tracing ============== -->
												<!-- Restricting contact tracing application to Fusion ID FALB000144-->
												<?php if(get_user_fusion_id()!="FALB000144"){?>
								
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/contact-tracing.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Contact Tracing
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."covid_case/form";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
												<?php }?>
												<?php if(is_access_Cns_modules()){?>
								
														<div class="col-sm-2">
														<div class="body-widget text-center">
															<div class="apps-bg-icon">
																<img src="<?php echo base_url() ?>assets_home_v2/images/shoutbox.png" class="icons-img" alt="">
																<h2 class="apps-title"> Cns
																</h2>
																<a href="<?php echo base_url()."cns";?>" class="explore-more">
																Explore
																</a>
															</div>
														</div>
													</div>
											<?php }?>
												
												<?php if(is_access_zovio_modules()){ ?>
								
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/crm.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Zovio CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."contact_tracing_crm";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
												<?php } ?>	
												
												<?php if(is_access_follett_modules()){ ?>
														<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/crm3.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Follett CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."contact_tracing_follett";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
												<?php } ?>		 
												<?php if(is_access_howard_modules()){ ?>
												
												
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/tracing1.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Howard System
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."Howard_training";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
												<?php } ?>
												<?php if(is_access_mckinsey_modules()){ ?>

													<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/tracing2.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Mckinsy
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."mck";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php if(is_access_kyt_modules()){ ?>
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/crm4.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> KYT CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."kyt";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>	 
													<?php if (is_access_cj_crm_modules()) { ?>	 
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/crm5.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> CJ CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "emat_new/dashboard"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													
													<?php
								   
													 $url="home";
													 $admin_access_array = array('FKOL006288','FKOL005998','FKOL001961');
													 $f_id = get_user_fusion_id();
													 if(get_process_ids() == '536' || get_process_ids() == '537'){
														$url="qenglish/newCustomer";
													 }

													 if(in_array($f_id,$admin_access_array)){ 
														$this->session->set_userdata('qenglish_client', 'yes');
															$url="qenglish";
													 }

													if(get_client_ids() == '250' || in_array($f_id,$admin_access_array)){
												?>
													<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/oyo1.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Queen's English CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url().$url;?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
												

												<?php } ?>
												<?php if(is_access_emat_crm()){ ?>
														<div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/oyo1.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> EMAT CRM
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."emat";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
												<?php } ?>
												<?php if(is_access_oyo_disposition()==true){ ?>
												
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/oyo1.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> OYO Disposition
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."oyo_disposition";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
												<?php } ?>
												<?php if(is_access_ma_platform()){ ?>
												
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/crm6.png" class="icons-img" alt="">
																 <h2 class="apps-title"> M&A Platform
																 </h2>
																 <a href="<?php echo base_url()."ma_platform";?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
												<?php } ?>
												
												<?php if(is_access_harhith() || get_user_fusion_id()=="FCHA001874"){ ?>
												
													 <div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/crm6.png" class="icons-img" alt="">
																 <h2 class="apps-title"> Harhith CRM
																 </h2>
																 <a href="<?php echo base_url()."harhith";?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>
													 
												<?php } ?>
												
												<?php
													if(is_access_client_voc()){
													?>
												
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/client.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">Client VOC
                                                                     </h2>
                                                                     <a href="<?php echo base_url() ."clientvoc"; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													
													<div class="col-sm-2">
														 <div class="body-widget text-center">
															 <div class="apps-bg-icon">
																 <img src="<?php echo base_url() ?>assets_home_v2/images/client.png" class="icons-img" alt="">
																 <h2 class="apps-title"> CCI Health
																 </h2>
																 <a href="<?php echo base_url() ."webpages/cci/index.html"; ?>" class="explore-more">
																	 Explore
																 </a>
															 </div>
														 </div>
													 </div>

													 <?php
													  if (get_global_access()=='1' || is_access_aifi_crm() == '1'){
													 ?>
												
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/attendance.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">Aifi
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "aifi"; ?>" class="explore-more">
                                                                         AIFI CRM
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
                                                        
                                                    <?php
													  if (is_access_duns_crm() == '1'){
													 ?>
												
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/duns_crm.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">DUNS
                                                                     </h2>
                                                                     <a href="<?php echo base_url() . "duns_crm"; ?>" class="explore-more">
                                                                         DUNS CRM
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>





									 
														 
                                                    </div>
                                                </div>
                                            </div>
											
											
											<div id="panel_reporting" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
													
													<?php
													if( get_role_dir()!="agent" || isAccessReports()==true ){
													$linkurl=base_url()."reports_hr";
													?>
														
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/attendance.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">HR & Attendance
                                                                     </h2>
                                                                     <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/perfomance.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Performance
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."reports_pm";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/miscellaneous.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Miscellaneous
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."reports_misc/itAssessment";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
													<?php } ?>
													
													<?php
														if( isAccessMindfaqReports()==true ){
													?>
													
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/mindfaq.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Mindfaq
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."mindfaq_analytics_skt";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php
														if (isAccessAvonReports() == true) {
														$linkurl = base_url() . "avon_chat_report/export";
													?>
								
													
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/chat-data.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> AVON CHAT DATA
                                                                     </h2>
                                                                     <a href="<?php echo $linkurl; ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													
													<?php } ?>
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/report-hub.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Report Hub
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."report_center";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 
														 
                                                    </div>
                                                </div>
                                            </div>
											
											<div id="panel_misc" class="tab-pane fade">
                                                <div class="common-top">
                                                    <div class="row">
													
														<?php
														if( is_access_reset_password() == true){		
														?>
														
                                                         <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/password.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">Reset Password
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."user_password_reset";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/request.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Service Request
                                                                     </h2>
                                                                     <a href="<?php echo base_url()."servicerequest";?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 
														 <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/photo-gallery.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Photo Gallery
                                                                     </h2>
                                                                     <a href="<?php echo base_url(); ?>album" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
														 <?php
														if(is_access_master_entry()=='1'){
														?>
								
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/master-entry.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title"> Master Entry
                                                                     </h2>
                                                                     <a href="<?php echo base_url(); ?>master/role" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>
													<?php if( isAccessQuestionBank()==true ){ ?>
														
														  <div class="col-sm-2">
                                                             <div class="body-widget text-center">
                                                                 <div class="apps-bg-icon">
                                                                     <img src="<?php echo base_url() ?>assets_home_v2/images/question-bank.png" class="icons-img" alt="">
                                                                     <h2 class="apps-title">  Question Bank
                                                                     </h2>
                                                                     <a href="<?php echo base_url('examination'); ?>" class="explore-more">
                                                                         Explore
                                                                     </a>
                                                                 </div>
                                                             </div>
                                                         </div>
													<?php } ?>	 
														 
                                                    </div>
                                                </div>
                                            </div>
											
											  
                                        </div>  
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
						<?php }?>
						
					</div>
						
					<div class="col-xl-3">
							
							
							<?php
								//print_r($get_announcement_desc);
								if (count($get_announcement_desc) >= 0) {
							?>
								
								<div class="row">
                                    <div class="col-xl-12">
                                        <div class="card shadow-primary ">
										
                                            <div class="card-body p-0">
                                                <div id="carouselExampleCaptions" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        
														 <?php 
														 $i=1;
														 foreach ($get_announcement_desc as $announce) : 
															$activeCss="";
															if($i==1) $activeCss="active";
														  
														 ?>
                                                											
														<div class="carousel-item <?php echo $activeCss ?>">
                                                            <div class="text-center p-3">
                                                                <div class="avatar-md m-auto">
                                                                    <span class="avatar-title rounded-circle font-size-24">
                                                                        <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                                                    </span>
                                                                </div>
																
                                                                <p class="font-size-14">
														           <?php echo stripslashes($announce['description']); ?>
                                                                </p>                                                                
                                                            </div>
															
                                                        </div>
														
													<?php 
														$i++;
														endforeach;
													?>	
														
                                                    </div>
													
                                                    <!-- end carousel-inner -->
													
                                                    <div class="carousel-indicators carousel-indicators-rounded">
													
														 <?php 
														 $i=0;
														 foreach ($get_announcement_desc as $announce) : 
															$activeCss="";
															if($i==0) $activeCss=' class="active" aria-current="true" ';
														  
														 ?>
														 
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $i; ?>" aria-label="Slide <?php echo ++$i; ?> " <?php echo $activeCss ?> ></button>
														
														<?php 
														
															endforeach;
														?>	
														
                                                    </div>
                                                    <!-- end carousel-indicators -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>                          
                                </div> 
								
							<?php } ?>
								
							
							<?php
								if (isIndiaLocation(get_user_office_id()) == true) {
									$this->load->view('homev2/homev2_attendance_leave_row');
								}
							?>
							<?php if(is_ppbl_check()!='1'){?>		
							<div class="row">
                            <div class="col-xl-12">
									
							<div class="card">                  
                                <div class="card-body">
									
									<?php
										// PIP Conter for Raised By
										$this->load->view('home/home_sidebar_pip');
									?>
									
									<?php
										if (isIndiaLocation(get_user_office_id()) == true) {
											if (get_role_dir() != "agent") {
												$this->load->view('home/home_sidebar_confirmation');
											}
										}
									?>
									
									
									<?php
									if (isIndiaLocation(get_user_office_id()) == true) {
										?>

										<div class="row" style="margin-bottom:2px;">
											<div class="col-md-12">


												<?php
												$has_contest = 0;
												$curLocalDate = GetLocalTime();
												foreach ($iplcontest as $iplrow) :
													$has_contest = 1;
													$cid = $iplrow['id'];
													$team1_logo = $iplrow['team1_logo'];
													$team2_logo = $iplrow['team2_logo'];
													$team1_abbr = $iplrow['team1_abbr'];
													$team2_abbr = $iplrow['team2_abbr'];
													$contest_close_date = $iplrow['contest_close_date'];
													$contest_date = $iplrow['contest_date'];
													$ContestTime = abs(strtotime($contest_close_date) - strtotime($curLocalDate)) * 1000;
													?>
													<a href="<?php echo base_url() . 'ipl'; ?>" style="cursor:pointer;">
														<div class="contest-center-small">
															<div class="contest-white-small">

																<div class="contest-top">
																	<div class="row">
																		<div class="col-sm-3">
																			<div class="logo-bg">
																				<div class="contest-right">
																					<img src="<?php echo base_url("assets/ipl/images/team_logo/" . $team1_logo); ?>" class="contest-logo1-small" alt="<?php echo $team1_abbr; ?>">
																				</div>
																			</div>

																		</div>
																		<div class="col-sm-6">
																			<div class="body-widget text-center">
																				<b>Krazy for IPL </b>
																			</div>
																			<div class="body-widget text-center">
																				<div id="clock-c<?php echo $cid; ?>" class="countdown clock-small-title"></div>
																			</div>
																		</div>
																		<div class="col-sm-3">
																			<div class="logo-bg1">
																				<div class="contest-left">
																					<img src="<?php echo base_url("assets/ipl/images/team_logo/" . $team2_logo); ?>" class="contest-logo2-small" alt="<?php echo $team2_abbr; ?>">

																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</a>


													<script type="text/javascript">
														$(function () {
															function getTimeFromNow<?php echo $cid; ?>() {
																return new Date(new Date().valueOf() + <?php echo $ContestTime; ?>);
															}

															$('#clock-c<?php echo $cid; ?>').countdown(getTimeFromNow<?php echo $cid; ?>(), function (event) {
																var $this = $(this).html(event.strftime('' +
																		'%Hh' +
																		' %Mm' +
																		' %Ss <span class="">left</span>'));
															});

														});
													</script>

													<?php
												endforeach;
												if ($has_contest == 0) {
													?>


													<a href="<?php echo base_url() . 'ipl'; ?>" style="cursor:pointer;">
														<div class="widget block_link" >
																 Krazy for IPL
														</div>
													</a>


													<?php
												}
												$this->load->view('course/course_redirect_sidebar');
												?>
												
											</div>
										</div>


										<?php
									}
									?>
									
								
							    </div>                                    
                            </div> 
							
							</div>                          
                            </div>
								
							<!-- /////////////////////////////// -->
							
							<div class="row">
                            <div class="col-xl-12">
							
							<div class="card">                  
                                <div class="card-body">
                                      
									<?php
										// info_family
										if (isIndiaLocation(get_user_office_id()) == true) {

											$this->load->view('home/home_sidebar_info_family');

											$this->load->view('home/home_sidebar_info_vaccination');
										}
									?>	
																		
									<?php
										// LD PROGRAMS
										$this->load->view('home/home_sidebar_ld_programs');
									?>
									<div class="row" style="margin-bottom:5px;">
									<div class="col-md-12">
										<a href="<?php echo base_url() . 'fems_tutorial'; ?>" >
											<div class="widget block_link " >
												 MWP Tutorial
											</div>
										</a>
									</div>
									</div>
									
									
									<div class="row" style="margin-bottom:2px;">
										<div class="col-md-12">

											<a data-bs-toggle="modal" style="cursor:pointer;">
                                                
                                            <?php
                                                
                                                if(isPhilLocation() == true){
                                                    
                                            ?>
                                                
                                                <div class="widget" style="border-radius: 3px; cursor:pointer;">
													<img src="<?php echo base_url(); ?>assets/images/phil_employee_connect_text.jpg" width='100%' />
												</div>
                                                
                                            <?php
                                                    
                                                }
                                                
                                                else{
                                                    
                                            ?>

												<div class="widget" style="border-radius: 3px; cursor:pointer;">
													<img src="<?php echo base_url(); ?>assets/images/ind_employee_connect_text.jpg" width='100%' />
												</div>
                                                
                                            <?php
                                                    
                                                }
                                                
                                            ?>

											</a>

										</div>
									</div>
									<div class="row" style="margin-bottom:2px;">
										<div class="col-md-12">

											<a data-bs-toggle="modal"  style="cursor:pointer;">
                                                
                                            <?php
                                                
                                                if(isPhilLocation() == true){
                                                    
                                            ?>
                                                <div class="widget" style="border-radius: 3px; cursor:pointer;">
													<img src="<?php echo base_url(); ?>assets/images/support-helpdesk1-phil.jpg" width='100%' />
												</div>
                                                
                                            
                                            <?php
                                                    
                                                }
                                                
                                                else{
                                                    
                                            ?>   

												<div class="widget" style="border-radius: 3px; cursor:pointer;">
													<img src="<?php echo base_url(); ?>assets/images/support-helpdesk1.jpg" width='100%' />
												</div>
                                                
                                            <?php
                                                    
                                                }
                                                
                                            ?>

											</a>

										</div>
									</div>
									
									
									<div class="row" style="margin-bottom:2px;">
										<div class="col-md-12">

											<a data-bs-toggle="modal"  style="cursor:pointer;">
                                                
                                            <?php
                                                
                                                if(isPhilLocation() == true){
                                                    
                                            ?>
                                                <div class="widget" style="border-radius: 3px; cursor:pointer;">
													<img src="<?php echo base_url(); ?>assets/images/hr-employee-support1-phil.jpg" width='100%' />
												</div>
                                                
                                            <?php
                                                    
                                                }
                                                
                                                else{
                                                    
                                            ?>                                                
                                                
												<div class="widget" style="border-radius: 3px; cursor:pointer;">
													<img src="<?php echo base_url(); ?>assets/images/hr-employee-support1.jpg" width='100%' />
												</div>
                                                
                                            <?php
                                                    
                                                }
                                                
                                            ?>
												
											<?php
								
												if(get_user_office_id() == 'FLO' || get_user_office_id() == 'HIG' || get_user_office_id() == 'SPI' || get_user_fusion_id() == 'FKOL008610'){
													
											?>
													<div class="widget" style="border-radius: 3px; cursor:pointer;">
														<img src="<?php echo base_url(); ?>assets/flyers/flyer_FLO_HIG_SPI.png" width='100%' />
													</div>
											<?php
													
												}
								
											?>
                                                
                                                
											</a>

										</div>
									</div>
									
									
                                    </div>                                    
                                </div> 
							</div>                          
							</div>
							<?php }
							}else if(is_access_qa_boomsourcing()==True){
							?>
							<!---------Boomsourcing----------->
							<div class="row">
								<div class="col-xl-12">              
									<div class="card">                 
										<div class="card-body">
											<div class="row align-items-center">
												<div class="col-xl-4">
													<div class="page-title-box d-sm-flex align-items-center justify-content-between">
														<h4 class="mb-sm-0 font-size-18">All Apps</h4>
													</div>
												</div>                                           
											</div>
											<div class="tabs-widget">
												<ul id="nav-tabs" class="nav nav-pills nav-fill" role="tablist">
													<li class="nav-item">
														<a class="nav-link" data-bs-toggle="pill" href="#panel_quality">
															Quality
														</a>
													</li>
												</ul>
											</div>  
											<div class="tab-content">
												<div id="panel_quality" class="tab-pane fade">
													<div class="common-top">
														<div class="row">
															<div class="col-sm-2">
																<div class="body-widget text-center">
																	<div class="apps-bg-icon">
																		<img src="<?php echo base_url() ?>assets_home_v2/images/audit.png" class="icons-img" alt="">
																		<h2 class="apps-title"> Boomsourcing </h2>
																		<a href="<?php echo base_url().'Qa_boomsourcing/boomsourcing'; ?>" class="explore-more"> Explore </a>
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
							</div>
							
							<?php } ?>
							
							
							
							<!--////////////////////////NEWS FEEDS//////////////////////////////////-->
<?php  if (news_read_permission() == 1) { 
    
    ?>
                <!-- 27-04-2022 -->
                <div class="row" id="news_feeds_panel">
                    <div class="col-md-12">
                        <div class="widget news-feed ">
                            <header class="widget-header" style="background: rgb(0,212,255);background: linear-gradient(90deg, rgba(0,212,255,1) 0%, rgba(114,114,232,1) 49%, rgba(0,212,255,1) 100%);">
                                <h4 class="widget-title" style="text-align:center;color: #fff;"><b>News Feed</b></h4> </header>
                            <div class="widget-body clearfix scrl">
                                <div class="auto-s">
                                    <div class="col-md-12 news_feeds" id="news_feeds">
                                        <div class="row">
                                            <?php
                                            if (count($news_feed) > 0) {
                                                foreach ($news_feed as $feeds) {
                                                    $color = "#" . $feeds->priority;
                                                    ?>	
                                                    <div class="news_data">
                                                        <div class="news-title">
                                                            <h5><strong><?= $feeds->title ?></strong></h5>
                                                        </div>
                                                        <div class="pull-left news-massage" style="color:<?= $color ?>">
                                                            <?= $feeds->message ?>
                                                        </div>
                                                    </div>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    <!-- 27-04-2022 -->
                <?php
            }
            ?>	
						
						</div>
							
					</div>
					
                </div>

				
                	
                </div>                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
								<div class="body-widget text-center">
									<script>document.write(new Date().getFullYear())</script> © Omind Technologies.
								</div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>            
        </div> 

 
<?php 
if(is_access_neo_chatbot()==true){
		include_once 'neo_chat.php';
	} 
?>
 
<?php include_once 'application/views/homev2/homev2_all_popup.php' ?> 

<script src="<?php echo base_url() ?>assets_home_v2/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets_home_v2/slick/slick.min.js"></script>
<script src="<?php echo base_url() ?>assets_home_v2/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets_home_v2/js/chart.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.uploadfile.js"></script>
<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>

<script src="<?php echo base_url(); ?>assets/mwp-chatbot/js/botchat.js"></script>

	
<script type="text/javascript">	

	function googleTranslateElementInit(){
		
		var tlang=$.cookie('tlang');
		if(tlang=="") tlang="en";
		var lang =tlang;
		
		new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,fr' }, 'google_translate_element');
				
		var languageSelect = document.querySelector("select.goog-te-combo");
		languageSelect.value = lang; 
		languageSelect.dispatchEvent(new Event("change"));
	}

	var flags = document.getElementsByClassName('flag_link'); 
		
	Array.prototype.forEach.call(flags, function(e){
	  e.addEventListener('click', function(){
		var lang = e.getAttribute('data-lang'); 
		$.cookie('tlang', lang, { expires: 900, path: '/' });
		
		var languageSelect = document.querySelector("select.goog-te-combo");
		languageSelect.value = lang; 
		languageSelect.dispatchEvent(new Event("change"));
		
		
		
	  }); 
	});
	</script>
	
<?php 
	include_once 'jscripts.php';
?>	


	<?php
		if(isset($content_js) && !empty($content_js))
		{
			if(is_array($content_js))
			{
				foreach($content_js as $key=>$script_url)
				{
					if(!preg_match("/.php/", $script_url))
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



<script type="text/javascript">	

window.addEventListener('load', function () {
 loadScript("//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit");
});

function loadScript(src)
{
  return new Promise(function (resolve, reject) {
	if ($("script[src='" + src + "']").length === 0) {
		var script = document.createElement('script');
		script.onload = function () {
			resolve();
		};
		script.onerror = function () {
			reject();
		};
		script.src = src;
		document.body.appendChild(script);
	} else {
		resolve();
	}
});

}

</script>

<script type="text/javascript">	
$('.responsive').slick({
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 6,  
  slidesToScroll: 6,  
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }    
  ]
});
</script>	

<script type="text/javascript">	

var xValues = ["On Time", "Late", "Off", "Leave", "Absent"];
//var xValues = ["", "", "", "", ""];

var yValues = [<?php echo $schedule_monthly[round($selected_month)]['counters']['ontime']; ?>, <?php echo $schedule_monthly[round($selected_month)]['counters']['latetime']; ?>, <?php echo $schedule_monthly[round($selected_month)]['counters']['offtime']; ?>, <?php echo $schedule_monthly[round($selected_month)]['counters']['leavetime']; ?>, <?php echo $schedule_monthly[round($selected_month)]['counters']['absenttime']; ?>];

var barColors = [
  "#2ab57d",
  "#ffdf53",
  "#9ea2a3",
  "#18afe9",
  "#fd625e"
];

new Chart("ScheduleAdherenceChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: ""
    }
  }
});
</script>



<script type="text/javascript">	

var xValues = ["", ""];
var yValues = [<?php echo round($current_data_set['present']); ?>, <?php echo $current_data_set['absent']; ?>];
var barColors = [
  "#5156be",
  "#b1cbff"
];
new Chart("PresentChart", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: ""
    }
  }
});



</script>

<script type="text/javascript">	


var xValues = ["", ""];
var yValues = [<?php echo $current_data_set['absent']; ?>,<?php echo round($current_data_set['present']); ?>];
var barColors = [
  "#5156be",
  "#b1cbff"
];
new Chart("AbsentChart", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: ""
    }
  }
});


</script>

<script type="text/javascript">	

var xValues = ["", ""];
var yValues = [<?php echo round($current_data_set['adherence']); ?>, <?php echo (100-round($current_data_set['adherence'])) ;?> ];

var barColors = [
  "#5156be",
  "#b1cbff"
];

new Chart("AdherenceChartPer", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: ""
    }
  }
});
</script>

<script type="text/javascript">	
var xValues = ["", ""];
var yValues = [<?php echo round($current_data_set['shrinkage']); ?>, <?php echo (100-round($current_data_set['shrinkage'])) ;?>];
var barColors = [
  "#5156be",
  "#b1cbff"
];
new Chart("ShrinkageChartPer", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: ""
    }
  }
});
</script>

<script type="text/javascript">	
     $(document).ready(function(){
        $(".box").hide();
        $(".slide-toggle").click(function(){
            $(".box").animate({
                width: "toggle"
            });
        });
        $(".close-btn").click(function(){
            $(".box").hide();
        });
    });
</script>

<script type="text/javascript">

	localStorage.setItem("brand", "<?php echo get_brand(); ?>");
	
     $(document).ready(function(){
        $(".box1").hide();
        $(".slide-notification").click(function(){
            $(".box1").animate({
                width: "toggle"
            });
        });
        $(".close-btn").click(function(){
            $(".box1").hide();
        });
    });
</script>


<?php include_once 'application/views/homev2/homev2_additional_js.php';  ?>



<?php 
	if(is_access_neo_chatbot()==true){
		include_once 'neo_chat_js.php';
	} 
?>

<!--start tabs one line -->
    <script>       
        document.querySelector("#nav-tabs").BsNavPaginator(5, "nav-link");
        document.querySelector("#nav-pills").BsNavPaginator(5, "nav-link");		
    </script>
	
	<script>
		$(".nav-paginator-next").attr("href", "javascript:void(0);");
		$(".nav-paginator-prev").attr("href", "javascript:void(0);");
	</script>	
<!--end tabs one line-->

<script>
	$(document).ready(function() {
	// Users can skip the loading process if they want.
	$('.skip').click(function() {
		$('.overlay, body').addClass('loaded');
	})
	
	// Will wait for everything on the page to load.
	$(window).bind('load', function() {
		$('.overlay, body').addClass('loaded');
		setTimeout(function() {
			$('.overlay').css({'display':'none'})
		}, 2000)
	});
	
	// Will remove overlay after 1min for users cannnot load properly.
	setTimeout(function() {
		$('.overlay, body').addClass('loaded');
	}, 20000);
})
</script>

<script>

$("#leave_form").submit(function () {
    $("#sub_but").attr("disabled", true);
    return true;
});	

</script>


</body>

</html>
