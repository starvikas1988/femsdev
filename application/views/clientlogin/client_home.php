<?php 

/*---------------------------------------------------------------------------------------

Check The current URL and moniter the links,

If the session is on then a user can jump between the three dashboards irrespective of the 
session he is logged in. In order to stop that the below is written, which will check the change 
in URL and and search for admin, agent and coach keywords present in the url. Then based on the 
keywords will assign a 404 error page. 

----------------------------------------------------------------------------------------*/

is_valid_session_url();



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo APP_TITLE;?></title>
	
	<?php
	header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
	header( 'Cache-Control: post-check=0, pre-check=0', false ); 
	header( 'Pragma: no-cache' ); 
	?>

	<meta name="description" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css ../assets/css/app.min.css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.min.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui-timepicker.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/app.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/uploadfile.css"/>
	
	<style>
	
	#global_notify_count {
		padding: 2px 5px 2px 5px;
		background: #cc0000;
		color: #ffffff;
		font-weight: bold;
		margin-left: 26px;
		border-radius: 9px;
		position: absolute;
		margin-top: -48px;
		font-size: 11px;
	}
	
	
.app-footer1 {
	padding: 24px 0;
	border-top: 1px solid #cccccc;
}
	
  .app-footer1 .copyright1 {
    font-weight: 400;
    color: #aaacae;
    letter-spacing: 1.5px; 
	text-align:center;
	}
	
</style>
	
<style>
.searchInput{
    width: 500px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    background-color: white;
    background-image: url('<?php echo base_url();?>assets/images/searchicon.png');
    background-position: 6px 6px; 
    background-repeat: no-repeat;
    padding: 6px 10px 6px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
	margin-top:12px;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";       /* IE 8 */
	filter: alpha(opacity=50);  /* IE 5-7 */
	-moz-opacity: 0.5;          /* Netscape */
	-khtml-opacity: 0.5;        /* Safari 1.x */
	opacity: 0.5;               /* Good browsers */
}
.searchInput:focus{
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";       /* IE 8 */
	filter: alpha(opacity=100);  /* IE 5-7 */
	-moz-opacity: 1;          /* Netscape */
	-khtml-opacity: 1;        /* Safari 1.x */
	opacity: 1;               /* Good browsers */
	width: 500px;
}

</style>


<style>
	
	#global_notify_count {
		padding: 2px 5px 2px 5px;
		background: #cc0000;
		color: #ffffff;
		font-weight: bold;
		margin-left: 26px;
		border-radius: 9px;
		position: absolute;
		margin-top: -48px;
		font-size: 11px;
	}
	
	.case-wrapper {
	  margin: 0 auto;
	  float: left;
	  width: 150px;
	  height: 170px;
	  margin:10px;
	  display:inline-block;
	}

	.case-label {
	  font-size: 12px;
	  font-weight: bold;
	  letter-spacing: 0.4px;
	  color: darkblue;
	  text-align: center;
	  margin-top: 5px;
	  transition: 0.2s;
	  -webkit-transition: 0.2s;
	  text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.5), 0px 1px 5px rgba(0, 0, 0, 0.5);
	}

	.app-icon {
	  padding: 40px;
	  display: inline-block;
	  margin: auto;
	  text-align: center;
	  border-radius: 16px;
	  cursor: pointer;
	  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.15);
	}

	.app-icon .inner,
	.app-icon i {
	  font-size: 60px;
	  min-width: 70px;
	  color: #fafbfc;
	  display: inline-block;
	  transition: 0.2s;
	  -webkit-transition: 0.2s;
	  text-shadow: -1px 1px 5px rgba(0, 0, 0, 0.15);
	}

	.app-icon .inner {
	  line-height: 32px;
	  font-weight: bold;
	}

	.app-icon svg,
	.app-icon img {
	  height: 32px;
	  width: 32px;
	}
	
	.app-icon path {
	  fill: #fafbfc;
	  transition: 0.2s;
	  -webkit-transition: 0.2s;
	}

	.circle {
	  position: absolute;
	  right: 20px;
	  top: -10px;
	  color: #fff;
	  background-color: #ff5858;
	  padding: 6px;
	  font-size: 12px;
	  line-height: 1;
	  border-radius: 25px;
	  min-width: 25px;
	  height: 25px;
	  text-align: center;
	  text-shadow: none;
	  letter-spacing: normal;
	  cursor: pointer;
	}
	
	.app-icon:hover path {
	  fill: #fff;
	}
	
	.app-icon:hover i,
	.app-icon:hover {
	  color: #fff;
	}
	
	.app-icon-small {
	  padding: 12px;
	}
	
	.app-icon-img.app-icon-small {
	  padding: 0px;
	  height: 54px;
	  width: 54px;
	}
	.app-icon-img {
	  padding: 0px;
	  height: 100px;
	  width: 100px;
	}
	
	.app-icon-img img {
	  width: 100%;
	  height: 100%;
	}

	.rtl {
	  direction: rtl;
	}
	
	.apps_grid{
		
		margin: 0 auto;
		display:block;
	}

	.waterMark{
		background-color: #FFFFFF;    
		opacity: 0.2;
	}
	
	.AppsOuterBox{
		display:inline-block;
		padding: 5px 5px 15px 5px;
		border:1px solid #a59797;
		float:left; 
		margin:3px 4px;
		border-radius:5px;
	}

	.outerBoxTitle{
	  font-size: 11px;
	  font-weight: bold;
	  transition: 0.2s;
	  -webkit-transition: 0.2s;
	  text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.5), 0px 1px 5px rgba(0, 0, 0, 0.5);
	  color: darkblue;
	}


</style>

<script src="<?php echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script>

</head>
	
<body>
<!--============= start main area -->

<?php //include_once $aside_template; 

?>


<!-- APP NAVBAR ==========-->
<nav id="app-navbar" class="app-navbar p-l-lg p-r-md primary">

	
	<div id="navbar-header" class="pull-left">
		<a href="" >
			<div class="pull-left"><img src="<?php echo base_url(); ?>assets/images/profile.png" style="height: 50px; margin-right:15px"/></div>
		</a>
		<a href="<?php echo base_url()?>profile" >
		<h5 id="page-title" class="visible-md-inline-block visible-lg-inline-block m-l-md">
			
			<?php
				echo get_username()." - (".get_clients_client_name().")";
			?>
		</h5>
		</a>
		
	</div>
	
	<div>
		<ul id="top-nav" class="pull-right">
						
			<li class="nav-item dropdown">
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-hc-2x zmdi-settings"></i></a>
				<ul class="dropdown-menu animated flipInY">
					<li><a href="<?php echo base_url(); ?>clientlogin/changePasswd"><i class="zmdi m-r-md zmdi-hc-lg zmdi-account-box"></i>Change Password</a></li>
					<li><a href="<?php echo base_url();?>clientlogin/client_logout"><i class="zmdi m-r-md zmdi-hc-lg zmdi-sign-in"></i>Logout</a></li>
				</ul>
			</li>

		</ul>
	</div>	
	
	<?php
		$global_notify_count=get_notify_count();
		if($global_notify_count>0){
	?>
	
	<div>
		<ul id="top-nav" class="pull-right">
			<li class="nav-item dropdown">
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-exclamation-triangle"></i></a>
				
				<ul id='global_notify_div' class="dropdown-menu animated flipInY">
					
					<?php
						//echo get_notify_html();
					?>
				</ul>
				
				<span id="global_notify_count"><?php echo $global_notify_count;?></span>
				
			</li>
		</ul>
	</div>
	
	<?php } ?>
	
	
	<!--<div>
		<ul id="top-nav" class="pull-right">
						
			<li class="nav-item dropdown">
				<a href="<?php //echo base_url();?>home" class="dropdown-toggle" role="button" aria-haspopup="false" aria-expanded="false"><i class="zmdi zmdi-hc-2x zmdi-home"></i></a> 
			</li>

		</ul>
	</div>-->
	
	
</nav>
<!--========== END app navbar -->


<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">

	<div id='main_page_content'>
		<?php //include_once $content_template; ?>
		
		
		<!--========== Wrap class start -->

			<div class="wrap">
				<section class="app-content">
				
				
				
					
				<div class="row">
							
				<div class="col-md-12">
				<div class="widget">					
					<header class="widget-header">
						<h4 class="widget-title">Apps Link</h4>
					</header> 
					<hr class="widget-separator">
					<div class="widget-body clearfix">
								
						<div class='apps_grid'>
						
							<?php 
								if($client_info['allow_process_update'] == 1){ 
									$linkurl1=base_url()."process_update";
								?>
									<div class="case-wrapper" title="Process Update">
										<a  href="<?php echo $linkurl1; ?>" >
											<div class="app-icon" style="background-color: #7FA6F9" title="Process Update">
											<i class="fa fa-newspaper-o" title="Process Update" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">Process Updates</span>
											</div>
										</a>
									</div>
								<?php } ?>

								
									
								<?php
								if($client_info['allow_qa_module'] == 1){ 
									//$linkurl=base_url()."client_qa_dashboard";
									//$linkurl=base_url()."client_qa_graph/manager_level";
									$linkurl=base_url()."client_qa_graph";
								?>
																
									<div class="case-wrapper" title="QA feedback">
										<a  href="<?php echo $linkurl; ?>" >
											<div class="app-icon" style="background-color: #0c2660" title="QA feedback">
												<i class="fa fa-file-sound-o" title="QA feedback" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Quality
												</span>
											</div>
										</a>
									</div>
								<?php } ?>	
								
								
								<?php
								if($client_info['allow_qa_report'] == 1 && get_client_qa_report_link()!=""){ 
									
									$linkurl=base_url()."".get_client_qa_report_link();
								?>
																
									<div class="case-wrapper" title="QA feedback">
										<a  href="<?php echo $linkurl; ?>" >
											<div class="app-icon" style="background-color: #0c2660" title="QA feedback">
												<i class="fa fa-file-sound-o" title="QA feedback" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Quality Report
												</span>
											</div>
										</a>
									</div>
								<?php } ?>	
								
									
									
								<?php
								if($client_info['allow_ba_module'] == 1){
									$linkurl=base_url()."Pmetrix_v2_client";
								?>
									
									<div class="case-wrapper" title="Performance Metrics V2">
										<a  href="<?php echo $linkurl; ?>" >
											<div class="app-icon" style="background-color: #285C53" title="Performance Metrics">
											<i class="fa fa-hourglass-start" title="Performance Metrics" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">Performance Metrics</span>
											</div>
										</a>
										
									</div>
								<?php } ?>
								
							
							
							
									
								<?php
								if($client_info['allow_knowledge'] == 1){ 
								?>
									<div class="case-wrapper" title="Fusion Business Intelligence">
										<a  href="<?php echo base_url()."client_knowledge";?>" >
											<div class="app-icon" style="background-color: #ead100 " title="Fusion Business Intelligence">
												<i class="fa fa-book" title="Fusion Business Intelligence" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Knowledge Base
												</span>
											</div>
										</a>
									</div>
								<?php } ?>
								
								
								<?php
								if($client_info['allow_dfr_interview'] == 1 || $client_info['allow_dfr_report'] == 1){
								?>
									<div class="case-wrapper" title="Delivary Fullfilment Ratio">
										<a  href="<?php echo base_url()."client_dfr";?>" >
											<div class="app-icon" style="background-color: #8B08D1 " title="Delivary Fullfilment Ratio">
												<i class="fa fa-user-plus" title="Delivary Fullfilment Ratio" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Recruitment
												</span>
											</div>
										</a>
									</div>
								<?php } ?>
								
								
								<?php
								if($client_info['allow_mind_faq'] == 1){
								?>
								
									<div class="case-wrapper" title="Mind FAQ">
										<a  href="<?php echo base_url().$mind_faq_url;?>" >
											<div class="app-icon" style="background-color: #9e0c05 " title="Mind FAQ">
												<i class="fa fa-user-plus" title="Mind FAQ" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Mind FAQ
												</span>
											</div>
										</a>
									</div>
									
									<?php
										if(get_user_id()== 319){
									?>
								
									
									<div class="case-wrapper" title="Mind FAQ">
										<a  href="<?php echo base_url() . "mindfaq_mpower"; ?>" >
											<div class="app-icon" style="background-color: #1F51FF " title="Mind FAQ">
												<i class="fa fa-user-plus" title=" Mpower Mind FAQ" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Mpower Mind FAQ
												</span>
											</div>
										</a>
									</div>
									
									
									<div class="case-wrapper" title="Mind FAQ">
										<a  href="<?php echo base_url() . "mindfaq_cars24"; ?>" >
											<div class="app-icon" style="background-color: #088F8F " title="Mind FAQ">
												<i class="fa fa-user-plus" title=" Cars24 Mind FAQ" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Cars24 Mind FAQ
												</span>
											</div>
										</a>
									</div>
									
									
									<div class="case-wrapper" title="Mind FAQ">
										<a  href="<?php echo base_url() . "mindfaq_snapdeal"; ?>" >
											<div class="app-icon" style="background-color: #A7C7E7 " title="Mind FAQ">
												<i class="fa fa-user-plus" title=" Snapdeal Mind FAQ" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Snapdeal Mind FAQ
												</span>
											</div>
										</a>
									</div>
													
										
									
									<div class="case-wrapper" title="Mind FAQ">
										<a  href="<?php echo base_url() . "mindfaq_meesho"; ?>" >
											<div class="app-icon" style="background-color: #00A36C " title="Mind FAQ">
												<i class="fa fa-user-plus" title=" Meesho Mind FAQ" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Meesho Mind FAQ
												</span>
											</div>
										</a>
									</div>
									
									
									<?php
										}
									?>
									
										
									
									<div class="case-wrapper" title="Mind FAQ Analytics">
										<a  href="<?php echo base_url();?>mindfaq_analytics_skt" >
											<div class="app-icon" style="background-color: #9e0c05 " title="Mind FAQ Analytics">
												<i class="fa fa-user-plus" title="Mind FAQ Analytics" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Mind FAQ Analytics
												</span>
											</div>
										</a>
									</div>
									
									
									
									
								<?php } ?>
								
								<?php
								if($client_info['client_id'] == 142 || $client_info['allow_k2claims'] == 1){
 								?>
								
								<div class="case-wrapper" title="K2 CRM">
									<a href="<?php echo base_url();?>k2_claims_crm">
										<div class="app-icon" style="background-color: #78286e;" title="K2 Claims CRM">
											<i class="fa fa-gg-circle" title="K2 Claims CRM" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												K2 CRM
											</span>
										</div>
									</a>
								</div>
								
								<?php } ?>
								
								<?php
								if($client_info['allow_follett'] == 1){
 								?>
								
								<div class="case-wrapper" title="Contact Tracing Follett">
									<a  href="<?php echo base_url()."contact_tracing_follett";?>" >
										<div class="app-icon" style="background-color: #0e199d" title="Contact Tracing Follett">
											<i class="fa fa-medkit" title="Contact Tracing Follett" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Follett CRM
											</span>
										</div>
									</a>
								</div>
								
								<?php } ?>
								
								<?php
								if($client_info['allow_zovio'] == 1){
 								?>
								
								<div class="case-wrapper" title="Contact Tracing Zovio">
									<a  href="<?php echo base_url()."contact_tracing_crm";?>" >
										<div class="app-icon" style="background-color: #e1820c" title="Contact Tracing Zovio">
											<i class="fa fa-medkit" title="Contact Tracing Zovio" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Zovio CRM
											</span>
										</div>
									</a>
								</div>
								
								<?php } ?>

								<?php
								if($client_info['allow_mckinsey'] == 1){
 								?>
								
								<div class="case-wrapper" title="Mckinsey CRM">
									<a  href="<?php echo base_url()."mck";?>" >
										<div class="app-icon" style="background-color: #e1820c" title="Mckinsey CRM">
											<i class="fa fa-medkit" title="Mckinsey CRM" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Mckinsey CRM
											</span>
										</div>
									</a>
								</div>
								
								<?php } ?>
							
								<?php
								if($client_info['allow_sentient'] == 1){
 								?>
								
								<div class="case-wrapper" title="CJ CRM">
									<a  href="<?php echo base_url()."emat_new/dashboard";?>" >
										<div class="app-icon" style="background-color: #682fa7" title="CJ CRM">
											<i class="fa fa-medkit" title="CJ CRM" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												CJ CRM
											</span>
										</div>
									</a>
								</div>
								
								<?php } ?>
								
								<?php
								if($client_info['allow_mpower_voc'] == 1){
 								?>
								
								<div class="case-wrapper" title="Mpower VOC">
									<a  href="<?php echo base_url()."mpower";?>" >
										<div class="app-icon" style="background-color: #605081" title="Mpower VOC">
											<i class="fa fa-gg-circle" title="Mpower VOC" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Mpower VOC
											</span>
										</div>
									</a>
								</div>
								
								<?php } ?>

								<?php
								if($client_info['allow_consultant_report'] == 1){
 								?>
								
								<div class="case-wrapper" title="Consultant Report">
									<a  href="<?php echo base_url()."reports_consultant/fems_master_database";?>" >
										<div class="app-icon" style="background-color: #605081" title="Consultant Report">
											<i class="fa fa-gg-circle" title="Consultant Report" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Consultant Report
											</span>
										</div>
									</a>
								</div>
								
								<?php } ?>
								
								
								<?php
								//if($client_info['allow_kyt'] == 1){
								if($client_info['allow_diy'] == 1){
 								?>
																
								<!--<div class="case-wrapper" title="KYT Academy">
									<a  href="<?php echo base_url()."kyt";?>" >
										<div class="app-icon" style="background-color: #78286e;" title="KYT Academy">
											<img style="width:100px;height: 60px;" src="<?php echo base_url(); ?>assets/images/kyt_logo.png" border="0" alt="KYT CRM">
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												KYT Scheduler
											</span>
										</div>
									</a>
								</div>-->
								
								<?php if($client_info['role'] == 'client'){ ?>
								
								<?php $team_url = base_url("user/manage_client/diy"); ?>
								<div class="case-wrapper" title="Manage My Team">
									<a  href="<?php echo $team_url;?>" >
									<div class="app-icon" style="background-color: #3498db" title="Manage My Team">
									<i class="fa fa-users" title="Manage My Team" aria-hidden="true" style=""></i>
									
									</div> 
									<div class="case-label ellipsis">
										<span class="case-label-text">
										<?php echo "Manage Teachers"; ?>
										</span>
									</div>
									</a>
								</div>
								<?php } ?>
								
									<div class="case-wrapper" title="DIY Academy">
									<a  href="<?php echo base_url()."diy";?>" >
										<div class="app-icon" style="background-color: #fff;border:1px solid black;" title="DIY Academy" >
											<img style="width:100px;height: 60px;" src="<?php echo base_url(); ?>assets/images/diy_logo.jpg" border="0" alt="DIY CRM">
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												DIY Scheduler
											</span>
										</div>
									</a>
								</div>
							<?php } ?>
								
								<?php
								if($client_info['allow_naps'] == 1){
 								?>
																
								<div class="case-wrapper" title="NAPS">
									<a  href="<?php echo base_url()."naps/new_candidates";?>" >
										<div class="app-icon" style="background-color: #78286e;" title="NAPS">
											<!--<img style="width:100px;height: 60px;" src="<?php echo base_url(); ?>assets/images/kyt_logo.png" border="0" alt="NAPS">-->
											<i class="fa fa-list" title="NAPS" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												NAPS 
											</span>
										</div>
									</a>
								</div>
								<?php } 
								
								if($client_info['allow_qenglish'] == 1){
 								?>
																
								<div class="case-wrapper" title="QEnglish">
									<a  href="<?php echo base_url()."Qenglish";?>" >
										<div class="app-icon" style="background-color: #78286e;" title="Queen English">
											<!--<img style="width:100px;height: 60px;" src="<?php echo base_url(); ?>assets/images/kyt_logo.png" border="0" alt="NAPS">-->
											<i class="fa fa-list" title="Queen English" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Queen English 
											</span>
										</div>
									</a>
								</div>
								<?php if($client_info['role'] == 'client'){ ?>
								
								<?php $team_url = base_url("user/manage_client"); ?>
								<div class="case-wrapper" title="Manage My Team">
									<a  href="<?php echo $team_url;?>" >
									<div class="app-icon" style="background-color: #3498db" title="Manage My Team">
									<i class="fa fa-users" title="Manage My Team" aria-hidden="true" style=""></i>
									
									</div> 
									<div class="case-label ellipsis">
										<span class="case-label-text">
										<?php echo "Manage Teachers"; ?>
										</span>
									</div>
									</a>
								</div>
								<?php } ?>
								<?php } ?>
								
								
								<?php
								if($client_info['allow_emat'] == 1){
 								?>
																
								<div class="case-wrapper" title="EMAT">
									<a  href="<?php echo base_url()."emat";?>" >
										<div class="app-icon" style="background-color: #78286e;" title="EMAT">
											<!--<img style="width:100px;height: 60px;" src="<?php echo base_url(); ?>assets/images/kyt_logo.png" border="0" alt="NAPS">-->
											<i class="fa fa-envelope" title="EMAT" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												EMAT CRM 
											</span>
										</div>
									</a>
								</div>
								<?php } ?>
								
								
								<?php
								if($client_info['allow_harhith'] == 1){
 								?>
																
								<div class="case-wrapper" title="Harhith">
									<a  href="<?php echo base_url()."harhith";?>" >
										<div class="app-icon" style="background-color: #78286e;" title="Harhith">
											<!--<img style="width:100px;height: 60px;" src="<?php echo base_url(); ?>assets/images/kyt_logo.png" border="0" alt="NAPS">-->
											<i class="fa fa-globe" title="Harhith" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Harhith CRM 
											</span>
										</div>
									</a>
								</div>
								<?php } ?>
								
								
								<?php
								if($client_info['allow_downtime'] == 1){
 								?>
																
								<div class="case-wrapper" title="Downtime Reports">
									<a  href="<?php echo base_url()."downtime/ameridial_reports";?>" >
										<div class="app-icon" style="background-color: #78286e;" title="Downtime Reports">
											<!--<img style="width:100px;height: 60px;" src="<?php echo base_url(); ?>assets/images/kyt_logo.png" border="0" alt="NAPS">-->
											<i class="fa fa-line-chart" title="Downtime Reports" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Downtime Report
											</span>
										</div>
									</a>
								</div>
								<?php } ?>
								
								<?php
								if($client_info['allow_avon_report'] == 1){
									
 								?>
																
								<div class="case-wrapper" title="Avon Chat Reports">
									<a  href="<?php echo base_url()."avon_chat_report/export";?>" >
										<div class="app-icon" style="background-color: #78286e;" title="Avon Chat Report">
											<i class="fa fa-line-chart" title="Avon Chat Report" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Avon Chat Report
											</span>
										</div>
									</a>
								</div>
								<?php } ?>
								
						</div>
				</div>
				
				</div>					
									
			    </div>
				</div>
					
					
				</section>
			</div>

		<!--========== Wrap class end -->
		
		
	<div>
	
	<!-- APP FOOTER -->
	<div class="wrap p-t-0">
		<footer class="app-footer1">
			<div class="copyright1">&copy; <?php echo date("Y");?> Omind Technologies Private Limited</div>
		</footer>
	</div>
	<!-- /#app-footer -->
	
	
	<!-- Modal Start here-->
<div class="modal fade bs-example-modal-sm" id="sktPleaseWait" tabindex="-2" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
					<i class="fa fa-refresh fa-spin" style="font-size:16px"></i>&nbsp;&nbsp;  Processing...
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

</main>

<!--========== END app main -->
	
	<!-- build:js ../assets/js/core.min.js -->
	
	<script src="<?php echo base_url() ?>libs/bower/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/superfish/dist/js/hoverIntent.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/superfish/dist/js/superfish.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/PACE/pace.min.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/select2.full.min.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.maskedinput.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-number-input.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap.validator.min.js"></script>
	
	<!-- endbuild -->

	<!-- build:js ../assets/js/app.min.js -->
	<script src="<?php echo base_url() ?>assets/js/library.js"></script>
	<script src="<?php echo base_url() ?>assets/js/plugins.js"></script>
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>
	<!-- endbuild -->
			
	<script src="<?php echo base_url() ?>libs/bower/moment/moment.js"></script>	
	<script src="<?php echo base_url() ?>assets/js/fullcalendar.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.uploadfile.js"></script>
	<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>
	
	<?php //include_once 'jscripts.php' ?>
		
<!-------------------------------------------------------------------------------->

<script>
	$(document).ready(function(){
		var baseURL="<?php echo base_url(); ?>";
		
		$(".cancelSchedule").click(function(){
			var r_id=$(this).attr("r_id");
			var c_id=$(this).attr("c_id");
			var sch_id=$(this).attr("sch_id");
			$('.frmCancelScheduleCandidate #r_id').val(r_id);
			$('.frmCancelScheduleCandidate #c_id').val(c_id);
			$('.frmCancelScheduleCandidate #sch_id').val(sch_id);
			$("#cancelScheduleCandidate").modal('show');
		});
		
		
		$(function(){
		   $("#scheduled_date").datetimepicker({minDate:0});
		 });

		 
		$(".candidateAddInterview").click(function(){
			var r_id=$(this).attr("r_id");
			var c_id=$(this).attr("c_id");
			var sch_id=$(this).attr("sch_id");
			var sch_date=$(this).attr("sch_date");
			var sh_status=$(this).attr("sh_status");
			
			
			$('.frmaddCandidateInterview #r_id').val(r_id);
			$('.frmaddCandidateInterview #c_id').val(c_id);
			$('.frmaddCandidateInterview #sch_id').val(sch_id);
			$('.frmaddCandidateInterview #sh_status').val(sh_status);
			$('.frmaddCandidateInterview #scheduled_date').val(sch_date);
			
			$("#addCandidateInterview").modal('show');
		});
		
		
		$(".editInterview").click(function(){
			var params2=$(this).attr("params2");
			var r_id=$(this).attr("r_id");
			var c_id=$(this).attr("c_id");
			var sch_id=$(this).attr("sch_id");
			var arrPrams2 = params2.split("#"); 
			
			$('.frmeditCandidateInterview #r_id').val(r_id);
			$('.frmeditCandidateInterview #c_id').val(c_id);
			$('.frmeditCandidateInterview #sch_id').val(sch_id);
			$('.frmeditCandidateInterview #interviewer_id').val(arrPrams2[0]);
			$('.frmeditCandidateInterview #result').val(arrPrams2[1]);
			$('.frmeditCandidateInterview #ededucationtraining_param').val(arrPrams2[2]);
			$('.frmeditCandidateInterview #edjobknowledge_param').val(arrPrams2[3]);
			$('.frmeditCandidateInterview #edworkexperience_param').val(arrPrams2[4]);
			$('.frmeditCandidateInterview #edanalyticalskills_param').val(arrPrams2[5]);
			$('.frmeditCandidateInterview #edtechnicalskills_param').val(arrPrams2[6]);
			$('.frmeditCandidateInterview #edgeneralawareness_param').val(arrPrams2[7]);
			$('.frmeditCandidateInterview #edbodylanguage_param').val(arrPrams2[8]);
			$('.frmeditCandidateInterview #edenglishcomfortable_param').val(arrPrams2[9]);
			$('.frmeditCandidateInterview #edmti_param').val(arrPrams2[10]);
			$('.frmeditCandidateInterview #edenthusiasm_param').val(arrPrams2[11]);
			$('.frmeditCandidateInterview #edleadershipskills_param').val(arrPrams2[12]);
			$('.frmeditCandidateInterview #edcustomerimportance_param').val(arrPrams2[13]);
			$('.frmeditCandidateInterview #edjobmotivation_param').val(arrPrams2[14]);
			$('.frmeditCandidateInterview #edresultoriented_param').val(arrPrams2[15]);
			$('.frmeditCandidateInterview #edlogicpower_param').val(arrPrams2[16]);
			$('.frmeditCandidateInterview #edinitiative_param').val(arrPrams2[17]);
			$('.frmeditCandidateInterview #edassertiveness_param').val(arrPrams2[18]);
			$('.frmeditCandidateInterview #eddecisionmaking_param').val(arrPrams2[19]);
			$('.frmeditCandidateInterview #edoverall_assessment').val(arrPrams2[20]);
			$('.frmeditCandidateInterview #edinterview_remarks').val(arrPrams2[21]);
			$('.frmeditCandidateInterview #edinterview_status').val(arrPrams2[22]);
			
			$("#editCandidateInterview").modal('show');
			
		});	
		
	});	
</script>		
		
	
</body>
</html>

<!--------------------------------------Cancel Interview Scheduled----------------------------------------------->
<div class="modal fade" id="cancelScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmCancelScheduleCandidate" action="<?php echo base_url(); ?>client/cancel_interviewSchedule" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Cancel Schedule Candidate</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="sch_id" name="sch_id" value="">
	  
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Reason</label>
						<textarea id="cancel_reason" name="cancel_reason" class="form-control" required></textarea>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Remarks</label>
						<textarea id="remarks" name="remarks" class="form-control"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='cancelCandidateSchedule' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>



<!--------------------------------------Candidate Add Interview Round's---------------------------------------------->
<div class="modal fade" id="addCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
	  
	<form class="frmaddCandidateInterview" action="<?php echo base_url(); ?>client/add_candidate_interview" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Candidate Interview</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="sch_id" name="sch_id" value="">
			<input type="hidden" id="sh_status" name="sh_status" value="">
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Interviewer Name</label>
						<select class="form-control" id="interviewer_id" name="interviewer_id" required>
							<option>--Select--</option>
							<?php 
								$sCss="";
								foreach($user_client as $tm): 
								if($tm['id']==get_user_id()){  $sCss="selected";  ?>
									<option value="<?php echo $tm['id']; ?>" <?php echo $sCss; ?>><?php echo $tm['name']; ?></option>
								<?php }else{?>
									<option value="<?php echo $tm['id']; ?>"><?php echo $tm['name']; ?></option>
								<?php } ?>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Date</label>
						<input type="text" id="scheduled_date" name="interview_date" class="form-control" required>
					</div>
				</div>	
			</div>
			
			</br>
			
			<div class="row">
				<!-- -->
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Education/Training:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="educationtraining_param" name="educationtraining_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Job Knowledge:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="jobknowledge_param" name="jobknowledge_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Work Experience:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="workexperience_param" name="workexperience_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Analytical Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="analyticalskills_param" name="analyticalskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Technical Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="technicalskills_param" name="technicalskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">General Awareness:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="generalawareness_param" name="generalawareness_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Body Language:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="bodylanguage_param" name="bodylanguage_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">English Comfortable:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="englishcomfortable_param" name="englishcomfortable_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">MTI:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="mti_param" name="mti_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Enthusiasm:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="enthusiasm_param" name="enthusiasm_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Leadership Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="leadershipskills_param" name="leadershipskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Customer Importance:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="customerimportance_param" name="customerimportance_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Job Motivation:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="jobmotivation_param" name="jobmotivation_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Target Oriented:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="resultoriented_param" name="resultoriented_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Convincing Power:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="logicpower_param" name="logicpower_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Initiative:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="initiative_param" name="initiative_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Assertiveness:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="assertiveness_param" name="assertiveness_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Decision Making:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="decisionmaking_param" name="decisionmaking_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<!-- -->
			</div>
			
			</br>
			
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Overall Interview Result</label>
						<select class="form-control" id="result" name="result" required>
							<option value="">-Select-</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Status</label>
						<select id="interview_status" name="interview_status" class="form-control" required>
							<option value="">--select--</option>
							<option value="C">Cleared Interview</option>
							<option value="N">Not Cleared Interview</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Overall Assessment</label>
						<textarea class="form-control" id="overall_assessment" name="overall_assessment" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Remarks</label>
						<textarea class="form-control" id="interview_remarks" name="interview_remarks"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='addCandidateInterview' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!---------------------------------Edit Interview part---------------------------------->
<div class="modal fade" id="editCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px">
    <div class="modal-content">
	  
	<form class="frmeditCandidateInterview" action="<?php echo base_url(); ?>client/edit_interview" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Candidate Edit Interview</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="r_id" name="r_id" value="">
			<input type="hidden" id="c_id" name="c_id" value="">
			<input type="hidden" id="sch_id" name="sch_id" value="">
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Interviewer Name</label>
						<select class="form-control" id="interviewer_id" name="interviewer_id" required>
							<option>--Select--</option>
							<?php foreach($user_client as $tm): ?>
								<option value="<?php echo $tm['id']; ?>"><?php echo $tm['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Overall Interview Result</label>
						<select class="form-control" id="result" name="result" required>
							<option value="">-Select-</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
						</select>
					</div>
				</div>	
				<div class="col-md-4">
					<div class="form-group">
						<label>Interview Status</label>
						<select class="form-control" id="edinterview_status" name="interview_status" required>
							<option value="">--select--</option>
							<option value="C">Cleared Interview</option>
							<option value="N">Not Cleared Interview</option>
						</select>
					</div>
				</div>
			</div>
			
			</br>
			
			<div class="row">
				<!-- -->
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Education/Training:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="ededucationtraining_param" name="educationtraining_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Job Knowledge:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edjobknowledge_param" name="jobknowledge_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Work Experience:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edworkexperience_param" name="workexperience_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Analytical Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edanalyticalskills_param" name="analyticalskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Technical Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edtechnicalskills_param" name="technicalskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">General Awareness:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edgeneralawareness_param" name="generalawareness_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Body Language:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edbodylanguage_param" name="bodylanguage_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">English Comfortable:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edenglishcomfortable_param" name="englishcomfortable_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">MTI:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edmti_param" name="mti_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Enthusiasm:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edenthusiasm_param" name="enthusiasm_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Leadership Skills:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edleadershipskills_param" name="leadershipskills_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Customer Importance:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edcustomerimportance_param" name="customerimportance_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-4">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Job Motivation:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edjobmotivation_param" name="jobmotivation_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Target Oriented:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edresultoriented_param" name="resultoriented_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Convincing Power:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edlogicpower_param" name="logicpower_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Initiative:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edinitiative_param" name="initiative_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Assertiveness:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="edassertiveness_param" name="assertiveness_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label style="float:right">Decision Making:</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" id="eddecisionmaking_param" name="decisionmaking_param">
									<option value="">-Select-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<!-- -->
			</div>
			
			</br>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Overall Assessment</label>
						<textarea class="form-control" id="edoverall_assessment" name="overall_assessment" required></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Interview Remarks</label>
						<textarea class="form-control" id="edinterview_remarks" name="interview_remarks"></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" id='addCandidateInterview' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>
