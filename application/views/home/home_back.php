<style>

.switch {
 position: relative;
 display: block;
 vertical-align: top;
 width: 200px;
 height: 60px;
 padding: 3px;
 margin: 0 10px 10px 0;
 background: linear-gradient(to bottom, #eeeeee, #FFFFFF 25px);
 background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF 25px);
 border-radius: 36px;
 box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
 cursor: pointer;
}

 .switch-input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
 }
 
 .switch-label {
  position: relative;
  display: block;
  height: inherit;
  font-size: 10px;
  text-transform: uppercase;
  background: #eceeef;
  border-radius: inherit;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
 }
 
 .switch-label:before, .switch-label:after {
  position: absolute;
  top: 50%;
  margin-top: -.5em;
  line-height: 1;
  -webkit-transition: inherit;
  -moz-transition: inherit;
  -o-transition: inherit;
  transition: inherit;
 }
 
 .switch-label:before {
  content: attr(data-off);
  right: 11px;
  color: #10c469;
  font-size:18px;
  font-weight:bold;
 }
 
 .switch-label:after {
  content: attr(data-on);
  left: 11px;
  font-size:18px;
  font-weight:bold;
  opacity: 0;
 }
 .switch-input:checked ~ .switch-label {
  background: #E1B42B;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
 }
 
 .switch-input:checked ~ .switch-label:before {
  opacity: 0;
 }
 
 .switch-input:checked ~ .switch-label:after {
  opacity: 1;
 }
 
 .switch-handle {
  position: absolute;
  top: 4px;
  left: 4px;
  width: 56px;
  height: 56px;
  background: linear-gradient(to bottom, #FFFFFF 40%, #f0f0f0);
  background-image: -webkit-linear-gradient(top, #FFFFFF 40%, #f0f0f0);
  border-radius: 100%;
  box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
 }
 
 .switch-handle:before {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -6px 0 0 -6px;
  width: 12px;
  height: 12px;
  background: linear-gradient(to bottom, #eeeeee, #FFFFFF);
  background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF);
  border-radius: 6px;
  box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
 }
 
 .switch-input:checked ~ .switch-handle {
  left: 74px;
  box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
 }
  
 /* Transition
 ========================== */
 .switch-label, .switch-handle {
  transition: All 0.3s ease;
  -webkit-transition: All 0.3s ease;
  -moz-transition: All 0.3s ease;
  -o-transition: All 0.3s ease;
 }
 /* Switch Flat
 ==========================*/
 .switch-flat {
  padding: 0;
  background: #FFF;
  background-image: none;
 }
 .switch-flat .switch-label {
  background: #FFF;
  border: solid 2px #dadada;
  box-shadow: none;
 }
 .switch-flat .switch-label:after {
  color: #000;
 }
 .switch-flat .switch-handle {
  top: 5px;
  left: 6px;
  background: #8d8a8a;
  width: 50px;
  height: 50px;
  box-shadow: none;
 }
 .switch-flat .switch-handle:before {
  background: #eceeef;
 }
 .switch-flat .switch-input:checked ~ .switch-label {
  background: #FFF;
  border-color: #10c469;
 }
 .switch-flat .switch-input:checked ~ .switch-handle {
  left: 144px;
  background: #10c469;
  box-shadow: none;
 }
 
 #attendance_model .modal-dialog{
	 
	 width: 1000px;
 }
 
 </style>
 
 
 <style>
 
html {
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, "Open Sans", sans-serif;
  line-height: 1.42857143;
  color: #36414c;
  background-color: #fff;
  margin: 0 auto;
}

#page-desktop {
  min-width: 100%;
  margin-top: 0px;
  border: 0px;
  position: absolute;
  top: 0;
  bottom: 0;
  overflow: hidden;
  margin: 0 auto;
}

.case-wrapper {
  margin: 0 auto;
  float: left;
  width: 100px;
  height: 110px;
  margin:4px;
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
  padding: 30px;
  display: inline-block;
  margin: auto;
  text-align: center;
  border-radius: 16px;
  cursor: pointer;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.15);
}

.app-icon .inner,
.app-icon i {
  font-size: 32px;
  min-width: 32px;
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

.simple-page-logo {
    text-align: center;
    font-size: 24px;
    margin-bottom: 10px;
}

.apps_grid{
	
	margin: 0 auto;
	display:block;
}

/*
.app-content{
	margin: 0 30px;
}
*/

.simple-page-logo{
	padding:20px;
	display:block;
}

.simple-page-logo a{
	color:darkblue;
	font-weight:bold;
	transition: 0.2s;
	-webkit-transition: 0.2s;
	text-shadow: -1px 1px 5px rgba(0, 0, 0, 0.40);
}

.waterMark{
	background-color: #FFFFFF;    
	opacity: 0.2;
}

.AppsOuterBox{
	display:inline-block;
	padding: 5px 5px 20px 5px;
	border:1px solid #a59797;
	float:left; 
	margin:3px 4px;
	border-radius:5px;

}

</style>


<style>
  #facebook_reviews
  {
	  height:82px;
	  overflow:hidden;
	  font-size: 15px;
	  margin-top: 10px;
  }
  
  .facebook_review
  {
	  height:82px;
	  background-color:#F0F0F0;
	  padding-top:5px;
  }
  
  #facebook_reviews .row {
		overflow-y: scroll;
		height: 100%;
		/*margin-right: -12%;
		padding-right: 12%;*/
		overflow:hidden;
	}
	
	.widget-separator {
		margin: -10px 15px;
	}

</style>

<?php 
				
		$ldcdHide="";
		$cdHide="";
		$diasable="";
		$ldDiasable="";
		
		if($break_on_ld===false) $ldcdHide='style="display:none;"';
		else $diasable="disabled";
									
		if($break_on===false) $cdHide='style="display:none;"';
		else $ldDiasable="disabled";
	?>
	
<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-9">
			
				
				<?php if( count($curr_schedule)>0) { ?>
				
				<div class="row">
					
					<div class="col-md-12">
						<div class="widget stats-widget">
							
							<header class="widget-header">
								<h4 class="widget-title">Your Schedule <a data-toggle="modal" data-target="#schedule" style="cursor:pointer; float:right;">Weekly Schedule</a></h4>
							</header>
								<hr class="widget-separator">
					
							<div class="widget-body clearfix">
								
								
								<div class="table-responsive">
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
												
												
										</tr>
									</thead>
								
									<tbody>
								
										<?php
											foreach($curr_schedule as $user){
											if(strtotime($user['shdate']) == strtotime($currenDate) || strtotime($user['shdate']) == strtotime($tomoDate))
											{
										?>
										
										<tr>
											<td><?php echo $user['shdate']; ?></td>
											<td><?php echo $user['shday']; ?></td>
											<td><?php echo $user['in_time']; ?></td>
											<td><?php echo $user['break1']; ?></td>
											<td><?php echo $user['lunch']; ?></td>
											<td><?php echo $user['break2']; ?></td>
											<td><?php echo $user['out_time']; ?></td>
										
										</tr>
										<?php 
											}
										} ?>
									
									</tbody>
								</table>
							</div>
							
							
						</div>
					</div>
				</div>
			</div>
				
			<?php } ?>
	
	<!-- dialer -->
	

	
<?php if ( get_role_dir()=="agent" || get_role_dir()=="tl" ) { ?>

<?php //if ( get_role_dir() !="super" && get_global_access()=='0') { ?>

		<div class="row">
			
			<div class="col-md-4">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Timer for Lunch/Dinner break.</h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body row">
						<div class="col-xs-12" align="center">
							<label class="switch  switch-flat">
							<?php if($break_on_ld===true): ?>
							<input class="switch-input" type="checkbox" id="break_check_button_ld" checked>
							<?php else: ?>
							<input class="switch-input" type="checkbox" id="break_check_button_ld" <?php echo $ldDiasable;?>>	
							<?php endif; ?>
							
							<span class="switch-label" data-on="Break Off" data-off="Break On"></span> 
							<span class="switch-handle"></span>
							
						   </label>
							  <div class="slider round"></div>
						   </label>
						</div>
						
						<div class="col-xs-12" align="center">
						<h3 class="fz-xl fw-400 m-0" data-plugin="counterUp">
						
							<span id="countdown_ld" <?php echo $ldcdHide; ?>></span> 
						
							<span id="countdown2"><br/></span>
						</h3>
						</div>
					</div>
					
				</div>
			</div>
		
			<div class="col-md-4">
				<div class="widget">
				<header class="widget-header">
						<h4 class="widget-title">Timer for Others break</h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body row">
						<div class="col-xs-12" align="center">
							<label class="switch  switch-flat">
							<?php if($break_on===true): ?>
							<input class="switch-input" type="checkbox" id="break_check_button" checked>
							<?php else: ?>
							<input class="switch-input" type="checkbox" id="break_check_button" <?php echo $diasable;?>>	
							<?php endif; ?>
							
							<span class="switch-label" data-on="Break Off" data-off="Break On"></span> 
							<span class="switch-handle"></span>
							
						   </label>
							  <div class="slider round"></div>
						   </label>
						</div>
						
						<div class="col-xs-12" align="center">
						<h3 class="fz-xl fw-400 m-0" data-plugin="counterUp">
							<span id="countdown" <?php echo $cdHide; ?>></span> 
							<span id="countdown1"><br/></span>
						</h3>
						</div>
					</div> 
					
				</div>
			</div>
			
			
			<div class="col-md-4">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Current Time : <span id="txt"></span></h4>
						<h4 class="widget-title" style='padding-left:20px;'>Local Time : <span id="txt1"></span></h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body row">
						<div class="col-xs-12">
							<div class="text-center">
								<h4 class="fz-xl fw-400 m-0" data-plugin="counterUp"  id="txt2"></h4>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="text-center p-h-md">
								<div style="font-weight:400; font-size:19px">Last Logged in today @ <br/> <span style="color:#10c469"><?php echo ($dialer_logged_in_time!='' ? ConvServerToLocal($dialer_logged_in_time) : '') ?></span></div>
								
							</div>
						</div>
						
					</div>
				</div>
			</div>
			
		</div>
		
	
	
	<?php } ?>
	
	
	<!---------------------------------->
			
	<?php 
		//print_r($get_announcement_desc);
	if( count($get_announcement_desc)>0) { ?>
			
				<div class="row">
					<div class="col-md-12">
						<div class="widget">					
							<header class="widget-header">
								<h4 class="widget-title">Anouncements</h4>
							</header> 
							<hr class="widget-separator">
							
							<div class="widget-body clearfix">
							
								<div class="col-md-12" id="facebook_reviews" style="">
									<div class="row">
										<?php foreach($get_announcement_desc as $announce): ?>
											<div class="col-12 facebook_review">
												<?php echo stripslashes($announce['description']); ?>
											</div>
										<?php endforeach; ?>
									</div>
								</div>	
							</div>
							
						</div>
					</div>
				</div>
		
		<?php } ?>
		
	<!-------------------------------------->
		<?php if(get_role_dir()!="super") { ?>
		
				<div class="row">
					<div class="col-md-12">
						<div class="widget">					
							
							<div class="widget-body clearfix">
								
								<div class="row">
								
									<div class="col-md-6">
										<?php if( count($get_references_user)>0) { ?>
											<h4 class="widget-title"><a data-toggle="modal" data-target="#reference" style="cursor:pointer;">Your Referrals - <span style="font-size:20px; font-weight:bold"><?php echo count($get_references_user); ?></span></a></h4>
										<?php }else{ ?>
											<h4 class="widget-title"> <span style="font-size:20px; color:#0000FF; font-weight:bold"> No Referrals, Keep Referring </span> </h4>
										<?php } ?>
									</div>
									
									<div class="col-md-6">
										<h4 class="widget-title"><a data-toggle="modal" data-target="#addReferrals" style="cursor:pointer; float:right; color:green; font-size:20px"><i class="fa fa-plus-square">Add Referrals</i></a></h4>
									</div>
									
								</div>
							</div>
							
						</div>
					</div>
				</div>
		
		<?php } ?>
		
			
	<!-------------------------------------->

			<div class="row">
							
				<div class="col-md-12">
				<div class="widget">					
					<header class="widget-header">
						<h4 class="widget-title">Apps Link</h4>
					</header> 
					<hr class="widget-separator">
					<div class="widget-body clearfix">
								
						<div class='apps_grid'>
						
								<div class='AppsOuterBox' >
									<h5><strong>Human Resource</strong></h5>
												<?php
													
													if(get_role_dir()!="agent" || get_site_admin()=='1' || get_global_access()=='1' || get_dept_folder()=="hr" || get_dept_folder()=="wfm"  ){
					
														if(get_global_access()=='1') $team_url = base_url()."super/dashboard/1";
														else if(get_dept_folder()=="hr") $team_url=base_url().'hr/dashboard/1';
														else if(get_dept_folder()=="wfm") $team_url=base_url().'wfm/dashboard/1';
														else if(get_site_admin()=="1") $team_url=base_url().'admin/dashboard/1';
														else $team_url = base_url().get_role_dir()."/dashboard";
												?>
												
												
												
												
												<div class="case-wrapper" title="Manage Your Team">
													<a  href="<?php echo $team_url;?>" >
													<div class="app-icon" style="background-color: #3498db" title="Manage Your Team">
													<i class="fa fa-users" title="Manage Your Team" aria-hidden="true" style=""></i>
													
													</div> 
													<div class="case-label ellipsis"> 
														<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
														<span class="case-label-text">
														<?php 
															echo "Your Team";
														?>
														</span>
													</div>
													</a>
												</div>
												
												<?php
													}
												?>
												
												<div class="case-wrapper"  title="Profile">
													<a href="<?php echo base_url()?>profile" >
													<div class="app-icon" style="background-color: #1abc9c" title="Profile">
														<i class="fa fa-user" title="Profile" aria-hidden="true" style=""></i>
														</div> 
													<div class="case-label ellipsis"> 
														<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
														<span class="case-label-text">Your Profile</span>
													</div>
													</a>
												</div>
									
												<?php
													$linkurl=base_url()."policy";
												?>
												<div class="case-wrapper" title="Fusion Policy">
													<a  href="<?php echo $linkurl; ?>" >
														<div class="app-icon" style="background-color: #669999" title="Fusion Policy">
														<i class="fa fa-files-o" title="Fusion Policy" style=""></i>
														</div> 
														<div class="case-label ellipsis"> 
															<span class="case-label-text">Fusion Policy</span>
														</div>
													</a>
												</div>
												
												
											<div class="case-wrapper" title="Employee Exit">
												<a  href="<?php echo base_url()."user_resign";?>" >
												<div class="app-icon" style="background-color: #DF7401" title="Employee Exit">
												<i class="fa fa-user-times" title="Employee Exit" aria-hidden="true" style=""></i>
												
												</div> 
												<div class="case-label ellipsis"> 
													<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
													<span class="case-label-text">
														Employee Exit
													</span>
												</div>
												</a>
											</div>
																								
								
										<?php
											if(get_global_access()=='1' || get_site_admin()=='1' ||  get_dept_folder()=="hr" || get_role_dir()=="super" || get_role_dir()=="manager" || get_dept_folder()=="wfm"  || isAssignInterview()>0 || is_access_dfr_module() ==1){
												
												$ac_class="";
												$linkurl=base_url()."dfr";
										?>
										
																	
										<div class="case-wrapper <?php echo $ac_class; ?>" title="Delivary Fullfilment Ratio">
											<a  href="<?php echo $linkurl;?>" >
											<div class="app-icon" style="background-color: #FF8C00" title="Delivary Fullfilment Ratio">
											<i class="fa fa-user-plus" title="Delivary Fullfilment Ratio" aria-hidden="true" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">
													Recruitment
												</span>
											</div>
											</a>
										</div>
										
										<div class="case-wrapper <?php echo $ac_class; ?>" title="DFR Employee Movement">
											<a  href="<?php echo base_url(); ?>employee_movement" >
											<div class="app-icon" style="background-color: #8B08D1" title="DFR Employee Movement">
											<i class="fa fa-exchange" title="DFR Employee Movement" aria-hidden="true" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Employee Movement
												</span>
											</div>
											</a>
										</div>
																					
										<?php
											}
										?>
								</div>
								
								
								<div class='AppsOuterBox'>
								<h5><strong>Productivity</strong></h5>
								<div class="case-wrapper " title="Attendance">
									<a data-toggle='modal' data-target='#attendance_model'>
										<div class="app-icon" style="background-color: #0a8cec" title="Attendance">
										<i class="fa fa-camera" title="Attendance" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">Attendance</span>
										</div>
									</a>
								</div>
								
								
								<?php
								if( get_role_dir()!="agent" || is_access_schedule_upload() == true){
									
									$ac_class="";
									$linkurl=base_url()."schedule";
								
								?>
								
								
								
								<div class="case-wrapper" title="Schedule">
									<a  href="<?php echo base_url()."schedule";?>" >
										<div class="app-icon" style="background-color: #E898E9" title="Salary Slip">
										<i class="fa fa-calendar-o" title="Salary Slip" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Schedule</span>
										</div>
									</a>
								</div>
								<?php } ?>
								</div>
								

								
								
								<div class='AppsOuterBox' >
								<h5><strong>Analytics</strong></h5>
								<?php
								if( get_role_dir()!="agent" || get_site_admin()=='1' ||  get_global_access()=='1' ||  get_dept_folder()=="hr" ||  get_dept_folder()=="mis" ||  get_dept_folder()=="wfm" ||  get_dept_folder()=="rta" ){
									
									$ac_class="";
									$linkurl=base_url()."reports";
								
								?>
													
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Reports">
									<a  href="<?php echo $linkurl; ?>" >
										<div class="app-icon" style="background-color: #7578f6" title="Reports">
										<i class="fa fa-wpforms" title="Reports" style=""></i>
										
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Reporting</span>
										</div>
									</a>
								</div>
								
								<?php
									}
								?>
								
								
								<?php
									
									$linkurl=base_url()."report_center";
								?>
								
								<div class="case-wrapper" title="Report Center">
									<a  href="<?php echo $linkurl;?>" >
									<div class="app-icon" style="background-color: #b3b300" title="Report Center">
									<i class="fa fa-bar-chart custom" title="Report Center" aria-hidden="true" style=""></i>
									
									</div> 
									<div class="case-label ellipsis"> 
										<span class="case-label-text">
											Report Center
										</span>
									</div>
									</a>
								</div>
								
								</div>
								
								
								
								<div class='AppsOuterBox' >
								<h5><strong>Financials</strong></h5>
								<div class="case-wrapper" title="Salary Slip">
									<a  href="<?php echo base_url()."payslip";?>" >
										<div class="app-icon" style="background-color: #285C53" title="Salary Slip">
										<i class="fa fa-money" title="Salary Slip" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Salary Slip</span>
										</div>
									</a>
								</div>
								</div>

								
								<div class='AppsOuterBox' >
								<h5><strong>Leave</strong></h5>
								<?php
								
								$ac_class = "";
								
								if(get_user_office_id()=="KOL") $linkurl="/ilp/";
								else if(get_user_office_id()=="JAM") $linkurl="/jam.leave/";
								else $linkurl=base_url()."uc";
								
								?>
												
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Leave">
									<a  target='_blank' href="<?php echo $linkurl; ?>" >
									<div class="app-icon" style="background-color: #EF4DB6" title="Leave">
									<i class="fa fa-glass" title="Leave" style=""></i>
									</div> 
									<div class="case-label ellipsis"> 
										<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
										<span class="case-label-text">Leave</span>
									</div>
									</a>
								</div>
								</div>
								
								
								<div class='AppsOuterBox' >
								<h5><strong>Service Request</strong></h5>
								<div class="case-wrapper" title="Service Request">
									<a  href="<?php echo base_url()."Servicerequest";?>" >
										<div class="app-icon" style="background-color: #78BF3A" title="Service Request">
											<i class="fa fa-upload" title="Service Request" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Service Request
											</span>
										</div>
									</a>
								</div>
								</div>
								
								
								<div class='AppsOuterBox'>
								<h5><strong>Engagement</strong></h5>
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Gallery">
									<a href="<?php echo base_url(); ?>album">
										<div class="app-icon" style="background-color: #0a8cec" title="Gallery">
										<i class="fa fa-camera" title="Gallery" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Photo Gallery</span>
										</div>
									</a>
								</div>
								</div>
								
								
								<?php if(get_global_access()=='1' || get_site_admin()=='1' ||  get_dept_folder()=="hr" || get_role_dir()=="super" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="tl" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" ){ ?>
								
								
								<div class='AppsOuterBox' >
								<h5><strong>Break</strong></h5>	
								
								<div class="case-wrapper" title="Break Monitoring">
									<a  href="<?php echo base_url()."break_monitor";?>" >
										<div class="app-icon" style="background-color: #FF616A" title="Break Monitoring">
										<i class="fa fa-desktop" title="Break Monitoring" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Break Monitoring </span>
										</div>
									</a>
								</div>
								
								</div>
								
								<?php } ?>
								
								
								<?php if( get_global_access()=='1' || isOpenFemsCertification()>0 ){ ?>
								
								<div class='AppsOuterBox'>
								<h5><strong>Fems Cerification</strong></h5>
								<div class="case-wrapper" title="Fems Cerification">
									<a href="<?php echo base_url(); ?>fems_certification">
										<div class="app-icon" style="background-color: #5680C5" title="Fems Cerification">
										<i class="fa fa-edit" title="Fems Cerification" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Fems Cerification</span>
										</div>
									</a>
								</div>
								</div>
								
								<?php } ?>
								
								
								<div class='AppsOuterBox' >
								<h5><strong>My Performance</strong></h5>
								<div class="case-wrapper" title="Performance Improvement Plan">
									<a  href="<?php echo base_url()."uc";?>" >
									<div class="app-icon" style="background-color: #b3b300" title="Performance Improvement Plan">
									<i class="fa fa-line-chart custom" title="Performance Improvement Plan" aria-hidden="true" style=""></i>
									
									</div> 
									<div class="case-label ellipsis"> 
										<span class="case-label-text">
											PIP
										</span>
									</div>
									</a>
								</div>
								
								
								<?php
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
								
									<?php									
										$linkurl=base_url()."pmetrix";
									?>
									
									<div class="case-wrapper" title="Performance Metrics">
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
										
									<?php									
										$linkurl=base_url()."quality";
										//$linkurl=base_url()."uc";
									?>
									
							
									<div class="case-wrapper" title="QA feedback">
										<a  href="<?php echo $linkurl; ?>" >
										<div class="app-icon" style="background-color: #669999" title="QA feedback">
										<i class="fa fa-file-sound-o" title="QA feedback" aria-hidden="true" style=""></i>
										
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Quality
											</span>
										</div>
										</a>
									</div>
									
								</div>
								
								
								
								
							<?php if( get_global_access()=='1' || get_user_office_id()=='CEB'){ ?>
							
								<div class='AppsOuterBox'>
								<h5><strong>Feedback</strong></h5>
								<div class="case-wrapper" title="Employee Feedback">
									<a href="<?php echo base_url(); ?>employee_feedback">
										<div class="app-icon" style="background-color: #605081" title="Employee Feedback">
										<i class="fa fa-keyboard-o" title="Employee Feedback" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Feedback</span>
										</div>
									</a>
								</div>
								</div>
								
							<?php } ?>
							
							
							
								
								
								<div class='AppsOuterBox' >
								<h5><strong>Process FAQ</strong></h5>
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Frequently Asked Questions">
									<a  href="<?php echo base_url(); ?>faq" >
										<div class="app-icon" style="background-color: #FF00A2" title="Frequently Asked Questions">
										<i class="fa fa-user" title="Frequently Asked Questions" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">FAQ</span>
										</div>
									</a>
								</div>
								</div>
								
								
								
							<?php
								if(get_global_access()=='1' || get_site_admin()=='1' ){
									$ac_class="";
									$linkurl=base_url()."master/role";
								
							?>
								
								<div class='AppsOuterBox' >
								<h5><strong>Settings</strong></h5>
								
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Master Entry">
									<a  href="<?php echo $linkurl; ?>" >
										<div class="app-icon" style="background-color: #4aa3df" title="Master Entry">
										<i class="fa fa-sun-o" title="Master Entry" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Master Entry</span>
										</div>
									</a>
								</div>
								
								</div>
								
								<?php
									}
								?>
								
								
								
								<div class='AppsOuterBox' >
								<h5><strong>Shout Box</strong></h5>
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Shout Box">
									<a  href="<?php echo base_url(); ?>message" >
										<div class="app-icon" style="background-color: #00FFFB;position:relative;" title="Shout Box">
										<i class="fa fa-envelope-o" title="Shout Box" style=""></i>
										<?php
												if(isset($unread) && $unread != 0)
												{
													echo '<span style="background: red;color: white;width: 20px;display: inline-block;height: 20px;border-radius: 50%;text-align: center;position: absolute;top: 6px;right: 6px;">'.$unread.'</span>';
												}
											?>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Shout Box</span>
										</div>
									</a>
								</div>
								</div>
								
								
								<div class='AppsOuterBox' >
								<h5><strong>Leadership</strong></h5>
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Leadership">
									<a data-toggle="modal" data-target="#leadership">
										<div class="app-icon" style="background-color: #b37959" title="Leadership">
										<i class="fa fa-user" title="Leadership" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Leadership</span>
										</div>
									</a>
								</div>
								</div>								


						</div>	
							
					</div>
				</div>
				</div>					
									
			</div>
			
			
	<!------->		
			
		<!--	<div class="row">
						
					<div class="col-md-12">
						
						<div class="widget">					
							<header class="widget-header">
								<h4 class="widget-title"> Fusion Leadership </h4>
							</header> 
							<hr class="widget-separator">
							
							<div class="widget-body clearfix">
											
							<div class="col-md-4">
								<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
									<div class="widget">
										<div class="widget-body clearfix" style="padding:1px;">
											<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/pankaj.jpg" style="height: 70px; margin-right:15px"/></div>
											<div class="" style="padding:1rem;">
												<h4 class="widget-title text-primary"><span class="counter">Pankaj Dhanuka</span></h4>
												<span style="font-size:12px">Co-Founder, Director & CEO</span>
											</div>
										</div>
									</div>
								</a>
							</div>
						
							<div class="col-md-4">
								<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
									<div class="widget">
										<div class="widget-body clearfix" style="padding:1px;">
											<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/kishore.jpg" style="height: 70px; margin-right:15px"/></div>
											<div class="" style="padding:1rem;">
												<h4 class="widget-title text-primary"><span class="counter">Kishore Saraogi</span></h4>
												<span style="font-size:12px">Co-Founder, Director & COO</span>
											</div>
										</div>
									</div>
								</a>
							</div>
						
							<div class="col-md-4">
								<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
									<div class="widget ">
										<div class="widget-body clearfix" style="padding:1px;">
											<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/michael.jpg" style="height: 70px; margin-right:15px"/></div>
											<div class="" style="padding:1rem;">
												<h4 class="widget-title text-primary"><span class="counter">Michael O'neil</span></h4>
												<span style="font-size:12px">Executive Vice President</span>
											</div>
										</div>
									</div>
								</a>
							</div>
						
							<div class="col-md-4">
								<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
									<div class="widget stats-widget">
										<div class="widget-body clearfix" style="padding:1px;">
											<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/ritesh.jpg" style="height: 70px; margin-right:15px"/></div>
											<div class="" style="padding:1rem;">
												<h4 class="widget-title text-primary"><span class="counter">Ritesh Chakraborty</span></h4>
												<span style="font-size:12px">Vice President- Operations</span>
											</div>
										</div>
									</div>
								</a>
							</div>
							
							
							<div class="col-md-4">
								<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
									<div class="widget stats-widget">
										<div class="widget-body clearfix" style="padding:1px;">
											<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/rajan.jpg" style="height: 70px; margin-right:15px"/></div>
											<div class="" style="padding:1rem;">
												<h4 class="widget-title text-primary"><span class="counter">Rajan Kumar Singh</span></h4>
												<span style="font-size:12px">Chief Technology Officer</span>
											</div>
										</div>
									</div>
								</a>
							</div>
													
							<div class="col-md-4">
								<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
									<div class="widget stats-widget">
										<div class="widget-body clearfix" style="padding:1px;">
											<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/lalita.jpg" style="height: 70px; margin-right:15px"/></div>
											<div class="" style="padding:1rem;">
												<h4 class="widget-title text-primary"><span class="counter">Lalita Sinha</span></h4>
												<span style="font-size:12px">Director- Human Resources</span>
											</div>
										</div>
									</div>
								</a>
							</div>
							
								
						</div>
							
						</div>	
					</div>
				</div>	-->
				
	</div>	
	<!------    -->
		
		<div class="col-md-3">  <!-- start of right side box -->
				
					
				<div class="row">
						
					<div class="col-md-12">
						
						<div class="widget">					
							<header class="widget-header">
								<h4 class="widget-title" style="text-align:center"><b>Today's Birthday</b></h4>
							</header> 
							<hr class="widget-separator">
							
							<div class="widget-body clearfix" id="notif_scroll">
								
								<?php foreach($org_news_notification as $org_noti): ?>								
								<div class="col-md-12">
									<div class="widget">
										<div class="widget-body clearfix" style="background-color:#FFA03A;">
											<span><?php echo $org_noti['title']; ?></span>
										</div>
									</div>
								</div>
								<?php endforeach; ?>	
								
								<?php
									
									foreach($user_today_dob as $row){
										$fusion_id=$row['fusion_id'];
										$dept_name=$row['dept_name'];
										$office_id=$row['office_id'];
										$ppic_url=$user_today_dob_ppic[$fusion_id];
									
								?>
								
								<div class="col-md-12">
									<div class="widget">
										<div class="widget-body clearfix" style="background-color:#FFA03A; padding: 2px;">
										<div class="pull-left"><img src="<?php echo $ppic_url; ?>" style="height: 40px; margin-right:10px"/></div>
										<div style="margin-top:9px" ><?php echo $row['fname'] . " ". $row['lname'] . " (" . $dept_name . ", ". $office_id . ")" ; ?> </div>
										</div>	
									</div>
								</div>
								<?php 
									}
								?>
							
							</div>
							
						</div>	
					</div>
				</div>
				
				
				<?php if (count($get_org_news) >0 ){ ?>
				<div class="row">	
					<div class="col-md-12">
						<div class="widget">					
							<header class="widget-header">
								<h4 class="widget-title" style="text-align:center"><b>Organizational News</b></h4>
							</header> 
							<hr class="widget-separator">
							
							<div class="widget-body clearfix" id="org_scroll">
								<?php foreach($get_org_news as $org_news): ?>
									<div class="col-md-12">
										<div class="widget">
											<div class="widget-body clearfix" style="background-color:#EFF5C0">
												<span><?php echo $org_news['title']; ?> - <?php echo $org_news['publishDate']; ?></span>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							
						</div>	
					</div>
				</div>
			
				<?php } ?>
				
		</div> <!-- end of right side box -->
			
	</div>
			
	</section>
</div>


<!---------------------------------------------------------------------------- 
<div class="modal fade" id="myUpdatePswdModal" role="dialog">
    <div class="modal-dialog">
    
     
      <div class="modal-content">
		<form class="frmPolicyAccept" method='POST' action="<?php echo base_url() ?>home/" data-toggle="validator">
		
        <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Update Password</h4>
        </div>
		
        <div class="modal-body">
			<input type="text" id="user_id" name="user_id" value="<?php echo get_user_id(); ?>">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Old Password</label>
						<input type="text" id="old_password" name="old_password" class="form-control" required>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>New Password</label>
						<input type="text" id="new_password" name="new_password" class="form-control" required>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Re-type Password</label>
						<input type="text" id="re_password" name="re_password" class="form-control" required>
					</div>	
				</div>
			</div>
			
        </div>
		
        <div class="modal-footer">
			<button type="submit" id='btnPolicyAccept' class="btn btn-primary">I Agree</button>
        </div>
		
		</form>
      </div>
      
    </div>
  </div>
-->


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
									<h4 class="widget-title"> Fusion Leadership </h4>
								</header> 
								<hr class="widget-separator">
								
								<div class="widget-body clearfix">
												
								<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
										<div class="widget">
											<div class="widget-body clearfix" style="padding:1px;">
												<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/pankaj.jpg" style="height: 70px; margin-right:15px"/></div>
												<div class="" style="padding:1rem;">
													<h4 class="widget-title text-primary"><span class="counter">Pankaj Dhanuka</span></h4>
													<span style="font-size:12px">Co-Founder, Director & CEO</span>
												</div>
											</div>
										</div>
									</a>
								</div>
							
								<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
										<div class="widget">
											<div class="widget-body clearfix" style="padding:1px;">
												<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/kishore.jpg" style="height: 70px; margin-right:15px"/></div>
												<div class="" style="padding:1rem;">
													<h4 class="widget-title text-primary"><span class="counter">Kishore Saraogi</span></h4>
													<span style="font-size:12px">Co-Founder, Director & COO</span>
												</div>
											</div>
										</div>
									</a>
								</div>
							
								<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
										<div class="widget ">
											<div class="widget-body clearfix" style="padding:1px;">
												<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/michael.jpg" style="height: 70px; margin-right:15px"/></div>
												<div class="" style="padding:1rem;">
													<h4 class="widget-title text-primary"><span class="counter">Michael O'neil</span></h4>
													<span style="font-size:12px">Executive Vice President</span>
												</div>
											</div>
										</div>
									</a>
								</div>
							
								<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
										<div class="widget stats-widget">
											<div class="widget-body clearfix" style="padding:1px;">
												<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/ritesh.jpg" style="height: 70px; margin-right:15px"/></div>
												<div class="" style="padding:1rem;">
													<h4 class="widget-title text-primary"><span class="counter">Ritesh Chakraborty</span></h4>
													<span style="font-size:12px">Vice President- Operations</span>
												</div>
											</div>
										</div>
									</a>
								</div>
								
								
								<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
										<div class="widget stats-widget">
											<div class="widget-body clearfix" style="padding:1px;">
												<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/rajan.jpg" style="height: 70px; margin-right:15px"/></div>
												<div class="" style="padding:1rem;">
													<h4 class="widget-title text-primary"><span class="counter">Rajan Kumar Singh</span></h4>
													<span style="font-size:12px">Chief Technology Officer</span>
												</div>
											</div>
										</div>
									</a>
								</div>
														
								<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
										<div class="widget stats-widget">
											<div class="widget-body clearfix" style="padding:1px;">
												<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/lalita.jpg" style="height: 70px; margin-right:15px"/></div>
												<div class="" style="padding:1rem;">
													<h4 class="widget-title text-primary"><span class="counter">Lalita Sinha</span></h4>
													<span style="font-size:12px">Director- Human Resources</span>
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
								
								
						</tr>
						</thead>
						<tbody>
							<?php
											foreach($curr_schedule as $user){
										?>
										
										<tr>
											<td><?php echo $user['shdate']; ?></td>
											<td><?php echo $user['shday']; ?></td>
											<td><?php echo $user['in_time']; ?></td>
											<td><?php echo $user['break1']; ?></td>
											<td><?php echo $user['lunch']; ?></td>
											<td><?php echo $user['break2']; ?></td>
											<td><?php echo $user['out_time']; ?></td>
										
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

<!-------------------------User References----------------------- ---->
<div id="reference" class="modal fade">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
	<div class="modal-content">      
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style='margin-bottom:0px;'>
						<thead>
							<tr class='bg-info'>
								<th>SL</th>
								<th>Name</th>
								<th>Fusion ID</th>
								<th>XPOID</th>
								<th>DOJ</th>
								<th>Client</th>
								<th>Process</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1;
								foreach($get_references_user as $row){
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $row['fname']." ".$row['lname']; ?></td>
								<td><?php echo $row['fusion_id']; ?></td>
								<td><?php echo $row['xpoid']; ?></td>
								<td><?php echo $row['doj']; ?></td>
								<td><?php echo $row['client_name']; ?></td>
								<td><?php echo $row['process_name']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>


<!-------------------------Add References----------------------- ---->
<div id="addReferrals" class="modal fade">
  <div class="modal-dialog">
	<div class="modal-content">      
		
			<form class="frmAddReferrals" action="<?php echo base_url(); ?>home/addreferral" data-toggle="validator" method='POST'>
		
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Referral </h4>
			  </div>
			  <div class="modal-body">
				
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Full Name</label>
								<input type="text" id="name" name="name" class="form-control" autocomplete="off" required>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Phone</label>
								<input type="number" id="phone" name="phone" class="form-control" onfocusout="checkphone()" required>
								<span id="phone_status" style="color:red"></span>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Email</label>
								<input type="text" id="email" name="email" class="form-control" onfocusout="checkemail();" required>
								<span id="email_status" style="color:red"></span>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Comment</label>
								<textarea id="comment" name="comment" class="form-control" required></textarea>
							</div>
						</div>
					</div>
					
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" name="submit" id='lol' class="btn btn-primary" value="Save">
			  </div>
			  
			 </form>
		
		</div>
	</div>
</div>


<!-------------------------User Attendance------------------ --------->
<div id="attendance_model" class="modal fade">
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
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									
										<th>Date</th>
																				
										<th>Login Time (EST)</th>
										<th>Login Time(Local)</th>
										<th>Logout Time (EST)</th>
										<th>Logout Time (Local)</th>
										<th>Logged In Hours</th>
										<th>Other Break Time </th>
										<th>Lunch/Dinner<br>Break Time </th>
										<th>Disposition</th>
										<th>Comments</th>
									</tr>
								</thead>
								
								<tfoot>
									<tr class='bg-info'>
										<th>Date</th>
																				
										<th>Login Time (EST)</th>
										<th>Login Time(Local)</th>
										<th>Logout Time (EST)</th>
										<th>Logout Time (Local)</th>
										<th>Logged In Hours</th>
										<th>Other Break Time </th>
										<th>Lunch/Dinner<br>Break Time </th>
										<th>Disposition</th>
										<th>Comments</th>
									</tr>
								</tfoot>
	
								<tbody>
								
								
								<?php
								
									$pDate=0;
									foreach($attan_dtl as $user):
									
									$cDate=$user['rDate'];
									$logged_in_hours=$user['logged_in_hours'];
									$office_id = $user['office_id'];
									
									$tBrkTime=$user['tBrkTime'];
									$ldBrkTime=$user['ldBrkTime'];
									
									$disposition=$user['disposition'];
									
									$work_time=$logged_in_hours;
									
									$todayLoginTime=$user['todayLoginTime'];
									$is_logged_in = $user['is_logged_in'];
									
									$flogin_time=$user['flogin_time'];
									$flogin_time_local=$user['flogin_time_local'];
									
									$logout_time=$user['logout_time'];
									$logout_time_local = $user['logout_time_local'];
									
									$total_break=$tBrkTime+$ldBrkTime;
									
									$comments = $user['comments'];
									
									////////// For System Logout /////////////////////
									if($user['logout_by']=='0'){
										//$work_time=0;
										//$logout_time="";
										$comments = "System Logout";
									}
									
																		
									
									if($work_time == 0){
										$net_work_time="";
										$total_break = "";
										$tBrkTime = "";
										$ldBrkTime = "";
									
									}else{
										
										$net_work_time=gmdate('H:i:s',$work_time);
										$total_break = gmdate('H:i:s',$total_break);
										$tBrkTime = gmdate('H:i:s',$tBrkTime);
										$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
									}
			
									
									if($is_logged_in == '1'){
										
										$todayLoginArray = explode(" ",$todayLoginTime);
										if($cDate == $todayLoginArray[0]){
											
											$flogin_time = $todayLoginTime;
											$flogin_time_local = ConvServerToLocalAny($todayLoginTime,$office_id);
											
											$disposition="online";
											$ldBrkTime="";
											$tBrkTime= "";
											$total_break=="";
											$net_work_time="";
											$logout_time="";
											$logout_time_local="";
										}
									}
									
									
									
									
								?>
									
									<tr>
									
										<td><?php echo $user['rDate']; ?></td>
																				
										<td><?php echo $flogin_time; ?></td>
										<td><?php echo $flogin_time_local; ?></td>
										<td><?php echo $logout_time; ?></td>
										<td><?php echo $logout_time_local; ?></td>
										
										<td><?php echo $net_work_time; ?></td>
										
										<td><?php echo $tBrkTime; ?></td>
										<td><?php echo $ldBrkTime; ?></td>
										
										<td><center><?php 
											if($logged_in_hours!="0"){
												if($user['user_disp_id']=="8") echo $disposition ." & P ";
												else echo "P";
												
											}else if($disposition!="") echo $disposition; 
											else echo "Absent"; 
										?></center></td>
																				
										<td><?php echo $comments ; ?></td>
										
									</tr>
									
											
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
					
				</div><!-- .widget -->
			</div>
			
			
		</div><!-- .row -->
		 
			
		</div>
	</div>
	</div>
</div>


<?php 
	if ( $is_OpenPayPopup == "Y" ) {
?>

<!-- Pay bank modal -->
<div class="modal fade" id="acceptPayInfoModal" tabindex="-1" role="dialog1" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Bank Details</h4>
			</div>
			<div class="modal-body">
			
				<form class="frmPayBankInfo" action="<?php echo base_url(); ?>profile/payVarify" data-toggle="validator" method='POST'>
				
			
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<div class="widget-body clearfix">
									

									
									<div class="row">
										<div class="col-md-12">
											
										<input type="hidden" class="form-control" id="id" value='<?echo $bank_row['id']; ?>' name="id" >
										<input type="hidden" class="form-control" id="user_id" value='<?echo $bank_row['user_id']; ?>' name="user_id" >
											
											
											<span>
											<b>
											This is to verify your salary account mentioned in FEMS is correct.<br>Re 1 had been transferred to your account. <br> <br>
											Please check your bank account and verify selecting the correct option.
											<b>
											</span>
											<br>
											<br>
											<br>
											
																						  
											  <input type="radio" value='Y' name="pay_varify" required>
											  <b>I certify that I have recieved Re 1 in my account.</b>
											
											<br>
											<br>
											  <input type="radio" value='N' name="pay_varify" required>
											  I did not recieved Re 1 in my account.
																						
										</div>
										
									</div>	
									
								</div>
						  </div>
						</div>
					</div>
					
					<div class="modal-footer">
						<button type="button" id='btnPayBankInfo' class="btn btn-info" data-dismiss="modal">Need time to check my account</button>
						<button type="submit" id='btnPayBankInfo' class="btn btn-primary">Confirm & Verified</button>
					</div>
			
				</form>
			</div>
		</div>
	</div>
</div>	

<?php 
	}
?>
