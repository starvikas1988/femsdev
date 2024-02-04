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
  width: 140px;
  height: 160px;
  margin:8px 15px;
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
  padding: 50px;
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
	padding-top: 20px;
	padding-bottom: 20px;
	width:520px;
	margin: 0 auto;
	display:block;
}

.app-content{
	margin: 0 30px;
}

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
	
		<?php if($update_pswd['is_update_pswd']=="Y"){ ?>
	
		<div class="simple-page-logo animated swing">
		<br>
			<a href="#">
				<span><?php echo APP_TITLE;?></span>
			</a>
		</br>
			
			
			
		</div><!-- logo -->
		
		<div><?php if($error!='') echo $error; ?></div>
		
		<div class="row">
			<!--
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
						<h2 class="fz-xl fw-400 m-0" data-plugin="counterUp">
						
							<span id="countdown_ld" <?php echo $ldcdHide; ?>></span> 
						
							<span id="countdown2"><br/></span>
						</h2>
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
						<h2 class="fz-xl fw-400 m-0" data-plugin="counterUp">
						<span id="countdown" <?php echo $cdHide; ?>></span> 
						
						<span id="countdown1"><br/></span>
						</h2>
						</div>
					</div> 
					
				</div>
			</div>
			
			
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Current Time : <span id="txt"></span></h4>
						<h4 class="fz-xl fw-400 m-0" data-plugin="counterUp"  ></h4>
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
								<div style="font-weight:400; font-size:25px">Logged in today @ <br/> <span style="color:#10c469"><?php echo ($dialer_logged_in_time!='' ? $dialer_logged_in_time : '') ?></span></div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		-->
	  			
		</div>
		
		<div class="row">
			<div class='apps_grid'>
					<?php
					if(get_role_dir()!="agent" || get_global_access()=='1'){
						$ac_class="";
						$linkurl=base_url()."users/manage";
					}else{
						$ac_class="waterMark";
						$linkurl="";
					}
					?>
					
					<!--<div class="case-wrapper <?php //echo $ac_class; ?>" title="Add User">
						<a  href="<?php //echo $linkurl; ?>" >
							<div class="app-icon" style="background-color: #8e44ad" title="Add User">
							
							<i class="fa fa-user-plus" title="Add User" aria-hidden="true" style=""></i>
							
							</div> 
							<div class="case-label ellipsis"> 
								<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
								<!--<span class="case-label-text">Users</span>
							</div>
						</a>
					</div>-->
					
					<?php
						if(get_global_access()=='1') $team_url = base_url()."super/dashboard/1";
						else if(get_dept_folder()=="hr") $team_url=base_url().'hr/dashboard/1';
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
								if(get_role_dir()=="agent" && get_global_access()!='1' && get_dept_folder()!="hr") echo "Your Dashboard";
								else echo "Manage Your Team";
							?>
							</span>
						</div>
						</a>
					</div>
					
					
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
										
					<div class="case-wrapper" title="Resignation">
						<a  href="<?php echo base_url()."user_resign";?>" >
						<div class="app-icon" style="background-color: #DF7401" title="Resignation">
						<i class="fa fa-user-times" title="Resignation" aria-hidden="true" style=""></i>
						
						</div> 
						<div class="case-label ellipsis"> 
							<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
							<span class="case-label-text">
								Resignation
							</span>
						</div>
						</a>
					</div>
					
					<?php
						if(get_global_access()=='1' || get_dept_folder()=="hr" || get_role_dir()=="super" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_dept_folder()=="rta"){
							
							$ac_class="";
							$linkurl=base_url()."dfr";
						}else{
							$ac_class="waterMark";
							$linkurl="";
						}
					?>
					
										
					<div class="case-wrapper <?php echo $ac_class; ?>" title="Delivary Fullfilment Ratio">
						<a  href="<?php echo $linkurl;?>" >
						<div class="app-icon" style="background-color: #FF8C00" title="Delivary Fullfilment Ratio">
						<i class="fa fa-user-plus" title="Delivary Fullfilment Ratio" aria-hidden="true" style=""></i>
						
						</div> 
						<div class="case-label ellipsis"> 
							<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
							<span class="case-label-text">
								DFR
							</span>
						</div>
						</a>
					</div>
					
					
					
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
					
					
					<!--
					<div class="case-wrapper" title="QA feedback">
						<a  href="<?php echo base_url()."uc";?>" >
						<div class="app-icon" style="background-color: #669999" title="QA feedback">
						<i class="fa fa-file-sound-o" title="QA feedback" aria-hidden="true" style=""></i>
						
						</div> 
						<div class="case-label ellipsis"> 
							<span class="case-label-text">
								QA Feedback
							</span>
						</div>
						</a>
					</div>
					-->
					
					
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
					
					
					
					
					<?php
					if(get_role_dir()!="agent" || get_global_access()=='1' ){
						$ac_class="";
						$linkurl=base_url()."reports";
					}else{
						$ac_class="waterMark";
						$linkurl="";
					}
					?>
										
					<div class="case-wrapper <?php echo $ac_class; ?>" title="Reports">
						<a  href="<?php echo $linkurl; ?>" >
							<div class="app-icon" style="background-color: #7578f6" title="Reports">
							<i class="fa fa-wpforms" title="Reports" style=""></i>
							
							</div> 
							<div class="case-label ellipsis"> 
								<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
								<span class="case-label-text">Reports</span>
							</div>
						</a>
					</div>
					
					
					<?php
					if(get_user_office_id()=="KOL"){
						$ac_class="";
						$linkurl="http://172.23.1.38/beta.fusion/";
					}else{
						$ac_class="";
						$linkurl=base_url()."uc";
					}
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
					
					
					<?php
						if(get_global_access()=='1' || get_dept_folder()=="hr" || get_role_dir()=="super"){
							$ac_class="";
							$linkurl=base_url()."master/role";
						}else{
							$ac_class="waterMark";
							$linkurl="";
						}
					?>
				
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
		</div>
		
		<?php }else{ ?>	
		
		
		<div class="simple-page-wrap">
			
			<div class="simple-page-form animated flipInY">
				<h4 class="form-title m-b-xl text-center">Change Password</h4>
				
				<?php if($error!='') echo $error; ?>
					
				<form id="f_user" action="<?php echo base_url(); ?>home/change_password" data-toggle="validator" method='POST'>
				
					<div class="form-group">
						<input id="old_password" type="password" class="form-control" placeholder="Type Your Old Password" name="old_password" required>
					</div>

					<div class="form-group">
						<input id="new_password" type="password" class="form-control" data-minlength="8" placeholder="Type New Password" name="new_password" required>
						<div class="help-block">Minimum of 8 characters</div>
					</div>
					
					<div class="form-group">
						<input id="re_password" type="password" class="form-control" placeholder="Re-type Password" data-match="#new_password" data-match-error="Whoops, password doesn't match" name="re_password" required>
						<div class="help-block with-errors"></div>
					</div>

					<input type="submit" class="btn btn-success" value="Save" name="submit" onclick="return Validate()">
				</form>
			</div>

		</div>
		
		<?php } ?>
	
</section> 
</div>
<br>

