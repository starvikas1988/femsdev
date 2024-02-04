<style>


.d-block {
    display: block !important;
}

.rating-panel .smiley-panel .smiley-group a {
    width: 20%;
    height: 100%;
    float: left;
    text-align: center;
    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -ms-transition: all .3s ease;
    -o-transition: all .3s ease;
    transition: all .3s ease;
}

.panel {
   margin-bottom: 2px; 
}

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
 
 .alert-asset {background-color: #ff9800; color:#FFFFFF;}
 
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
  width: 62px;
  height: 75px;
  margin:4px;
  display:inline-block;
  position:relative;
}

.case-label {
  font-size: 10px;
  font-weight: bold;
  letter-spacing: 0.4px;
  color: darkblue;
  text-align: center;
  margin-top: 2px;
  transition: 0.2s;
  -webkit-transition: 0.2s;
  text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.5), 0px 1px 5px rgba(0, 0, 0, 0.5);
}

.app-icon {
  padding: 14px;
  display: inline-block;
  margin: auto;
  text-align: center;
  border-radius: 10px;
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
.widget-person{
	height : 80px;
	width  : 103%;
}
</style>


<style>
  #facebook_reviews
  {
	  height:82px;
	  overflow:hidden;
	  font-size: 15px;
	  margin-top: 10px;
	  background-color:aliceblue;
  }
  
  .facebook_review
  {
	  height:82px;
	  background-color:aliceblue;
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

table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
	padding-left: 8px;
    vertical-align: middle;
}

.custom-progress-bar {
    background: #e5405e;
    background: linear-gradient(to right, #e5405e 0%, #ffdb3a 40%, #3fffa2 100%);
    background-color: rgba(0, 0, 0, 0);
    background-size: auto;
    background-size: 700px 20px;
}

.businessApp .case-wrapper{
	height:86px!important;
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
			
			
					
					<div class="row">
						<div class="col-md-12">
							<div class="widget">					
								
								<div style="padding:2px 15px;" class="clearfix">
									
									<div class="row">
									
										<div class="col-md-6">
											<?php if( count($get_references_user)>0) { ?>
												<h4><a data-toggle="modal" data-target="#reference" style="cursor:pointer;">Your Referrals - <span style="font-size:20px;font-weight:bold"><?php echo count($get_references_user); ?></span></a></h4>
											<?php }else{ ?>
												<h4> <span style="font-size:20px; color:#0000e6;font-weight:bold">No Referrals, Keep Referring</span></h4>
											<?php } ?>
										</div>
										
										<div class="col-md-6">
											<h4><a data-toggle="modal" data-target="#addReferrals" style="cursor:pointer; float:right;color:#0000e6;font-size:20px; font-weight:bold;"><img src ="<?php echo base_url(); ?>assets/images/new.gif"/> <i class="fa fa-plus-square"></i> Add Referrals</a></h4>
										</div>
										
									</div>
								</div>
								
							</div>
						</div>
					</div>
			
					<?php if($office_asset['fusion_id'] !="") { ?>
					
					<div class="row">
							<div class="col-md-12">
								<div class="widget">					
									
									<div style="padding:2px 15px;" class="clearfix">
										
										<div class="row">
										
											 <div style="padding:6px;margin-bottom:1px;" class="alert alert-info" role="alert">
												<div class="row">
													<div style="display:inline;" class="col-1 alert-icon-col">
														<span style="font-size:20px;color:white" class="fa fa-info-circle"></span>
													</div>
													<div style="display:inline; font-size:14px;" class="col">
														<strong>You Have Following Office Assets.</strong>
													</div>
													
													<div class="table-responsive" style="margin-left:26px;margin-right:10px;">
													<table id="default-datatable" data-plugin="DataTable" class="table table-striped " cellspacing="0" width="100%" style='margin-bottom:0px;'>
														<thead>
															<tr >
																<th>Office Desktop/Laptop</th>
																<th>Office Headset</th>
																<th>Office Dongle</th>
																<th>Specifications</th>
														</tr>
													</thead>
								
													<tbody>
													<tr>
													<?php
														echo "<td>".$office_asset['office_assets']."</td>";
														echo "<td>".$office_asset['office_headset']."</td>";
														echo "<td>".$office_asset['office_dongle']."</td>";
														echo "<td>".$office_asset['specifications']."</td>";
													?>
													</tr>
													</tbody>
													</table>
													</div>
							
												</div>
											</div>
	
											
										</div>
									</div>
									
								</div>
							</div>
						</div>
					<?php }  ?>
					
				<!-------------------------------------->
				<?php if(isUSLocation()== true ) { ?>
				
						<div class="row">
							<div class="col-md-12">
								<div class="widget">					
									
									<div style="padding:2px 15px;" class="clearfix">
										
										<div class="row">
										
											 <div style="padding:6px;margin-bottom:1px;" class="alert alert-asset" role="alert">
												<div class="row">
													<div style="display:inline;" class="col-1 alert-icon-col">
														<span style="font-size:20px;color:white" class="fa fa-info-circle"></span>
													</div>
													<div style="display:inline; font-size:14px;" class="col">
														<strong>Do not refer to attendance module in MWP. Attendance module is not applicable for US Region.</strong>
													</div>
												</div>
											</div>
	
											
										</div>
									</div>
									
								</div>
							</div>
						</div>
				
				<?php  } ?>
				
			
				
				
				
		
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
												<th>Status</th>
												
												
										</tr>
									</thead>
								
									<tbody>
								
										<?php
										foreach($curr_schedule as $user){
											if(strtotime($user['shdate']) == strtotime($currenDate) || strtotime($user['shdate']) == strtotime($tomoDate))
											{
												
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
	
		
		<div class="panel panel-default">
		  <div class="panel-heading"><b><i class="fa fa-user"></i> <?php echo get_username(); ?></b>
		  <div style="float:right;margin-top: -6px;">
			<div class="row">
				<div class="form-group" style="width:150px;display:inline-block">
					<select class="form-control" name="adh_select_month" id="adh_select_month">
						<?php
						for($im=1;$im<=12;$im++){
							$selectin = ""; if($selected_month == $im){ $selectin = "selected"; }
						?>
						<option value="<?php echo sprintf('%02d', $im); ?>" <?php echo $selectin; ?>><?php echo date('F', strtotime('2019-'.sprintf('%02d', $im) .'-01')); ?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="form-group" style="width:150px;display:inline-block">
					<select class="form-control" name="adh_select_year" id="adh_select_year">
						<?php
						$current_y = date('Y'); $last_y = $current_y - 5;
						for($j=$current_y;$j>=$last_y;$j--){
							$selectiny = ""; if($selected_year == $j){ $selectiny = "selected"; }
						?>
						<option value="<?php echo $j; ?>" <?php echo $selectiny; ?>><?php echo $j; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		  </div>
		  </div>
		  <div class="panel-body" style="background-image: linear-gradient(to right top, #194992, #006cab, #008996, #009e60, #7faa1e);">
		  <div class="row" style="background-image: linear-gradient(to right top, #0d2d5e, #004975, #00616b, #007546, #618118);">
			
		  <div class="col-md-6">
		   <?php if(!empty($schedule_monthly[round($selected_month)]['counters']['total'])){ ?>
		    <div id="agent_3dpie_adherence" style="width:100%; padding:5px 0px"> </div>
		   <?php } else { ?>
		   <div class="text-center text-white" style="padding:30px 10px;"><b>Monthly Schedule Adherence - <?php echo $schedule_monthly[round($selected_month)]['month'] ." " . $schedule_monthly[round($selected_month)]['year']; ?> <br/>  <span class="text-danger">-- No Schedule Found --</span></b></div>
		   <?php } ?>		   
		  </div>
		  
		  <div class="col-md-5">
		  <div class="row">
		   <div class="col-md-3">
		   <div style="width:100%; padding:5px 0px">
			<canvas id="agent_2dpie_present"></canvas>
		   </div>
		   </div>
		   
		   <div class="col-md-3">
			<div style="width:100%; padding:5px 0px">
			<canvas id="agent_2dpie_absent"></canvas>
		   </div>
		   </div>
		   
		   <div class="col-md-3">
		   <div style="width:100%; padding:5px 0px">
			<canvas id="agent_2dpie_adherence"></canvas>
		   </div>
		   </div>
		   
		   <div class="col-md-3">
		   <div style="width:100%; padding:5px 0px">
			<canvas id="agent_2dpie_shrinkage"></canvas>
		   </div>
		   </div>
		  </div>
		  </div>
		  
		  <div class="col-md-1 text-center">
		  <?php $adh_url_fix = "?select_month=".$selected_month ."&select_year=" .$selected_year ."&select_fusion=" .$selected_fusion;  ?>
		  <a href="<?php echo base_url()."schedule_adherence/dashboard/all" .$adh_url_fix; ?>" target="_blank" class="btn btn-danger" style="margin-top: 85px;padding: 2px 5px;font-size: 11px;">More..</a>
		  </div>
		  
		  </div>
		  		  
		</div>
		</div>
		
		
		<div class="row">
							
				<div class="col-md-12">
				<div class="widget">					
					<header class="widget-header">
						<h4 class="widget-title">Apps Link</h4>
					</header> 
					<hr class="widget-separator">
					<div class="widget-body clearfix" style="padding: .8rem 0.6rem;">
								
						<div class='apps_grid'>
						
								<div class='AppsOuterBox' style="padding: 5px 5px 15px 10px;">
									<div class='outerBoxTitle'>Human Resource</div>
									
										<!-- ======== Human Resources > 1 MY PROFILE ============== -->
										<div class="case-wrapper"  title="My Profile">
											<a href="<?php echo base_url()?>profile" >
											<div class="app-icon" style="background-color: #1abc9c" title="Profile">
												<i class="fa fa-user" title="My Profile" aria-hidden="true" style=""></i>
												</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">My Profile</span>
											</div>
											</a>
										</div>
										
										
										<!-- ======== Human Resources > 2 MY TEAM ============== -->
										<?php
											
											if(get_role_dir()!="agent" || get_site_admin()=='1' || get_global_access()=='1' || get_dept_folder()=="hr" || get_dept_folder()=="wfm"  || get_dept_folder()=="rta" || is_access_cspl_my_team()  ){
			
												if(get_global_access()=='1') $team_url = base_url()."super/dashboard";
												else if(get_dept_folder()=="hr") $team_url=base_url().'hr/dashboard';
												else if(get_dept_folder()=="wfm" || get_dept_folder()=="rta") $team_url=base_url().'wfm/dashboard';
												else if(get_site_admin()=="1") $team_url=base_url().'admin/dashboard';
												else if(is_access_cspl_my_team()) $team_url=base_url().'wfm/dashboard';
												else $team_url = base_url().get_role_dir()."/dashboard";
										?>
										<div class="case-wrapper" title="Manage My Team">
											<a  href="<?php echo $team_url;?>" >
											<div class="app-icon" style="background-color: #3498db" title="Manage My Team">
											<i class="fa fa-users" title="Manage My Team" aria-hidden="true" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">
												<?php 
													echo "My Team";
												?>
												</span>
											</div>
											</a>
										</div>
										
										<?php 
											}
											if(get_global_access()=='1' ||  get_site_admin()=='1' || get_dept_folder()=="hr" || get_dept_folder()=="wfm"  || get_dept_folder()=="rta"   ){
											$linkurl=base_url()."search_candidate";
										?>
										
										<div class="case-wrapper" title="Search Employee">
											<a  href="<?php echo $linkurl; ?>" >
												<div class="app-icon" style="background-color: #8b08d1" title="Search Employee">
												<i class="fa fa-search" title="Search Employee" style=""></i>
												</div> 
												<div class="case-label ellipsis"> 
													<span class="case-label-text">Search Employee</span>
												</div>
											</a>
										</div>
										
										
										<?php 
											}
											
											$linkurl=base_url()."policy";
											
										?>

										<div class="case-wrapper" title="Fusion Policy">
											<a  href="<?php echo $linkurl; ?>" >
												<div class="app-icon" style="background-color: #0c2660" title="Fusion Policy">
												<i class="fa fa-files-o" title="Fusion Policy" style=""></i>
												</div> 
												<div class="case-label ellipsis"> 
													<span class="case-label-text">Policies</span>
												</div>
											</a>
										</div>
										<!-- ======== Human Resources > 4 RECRUITMENT ============== -->										
										<?php
										//&& is_disable_module()==false
										if(isAssignInterview()>0 || is_access_dfr_module()==true){
												
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
										<?php } ?>
										
																				
										<!-- ======== Human Resources > 5 PROGRESSION ============== -->
																				
										<div class="case-wrapper" title="Internal Job Post">
											<a  href="<?php echo base_url(); ?>progression" >
											<div class="app-icon" style="background-color: #2F9353" title="Internal Job Post">
											
											<i class="fa fa-group" title="Internal Job Post" aria-hidden="true" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Progression
												</span>
											</div>
											</a>
											<?php if($get_ijp_avail >0 ){ ?>
											<span id="avail_progression" style="background: red;color: white;width: 20px;display: inline-block;height: 20px;border-radius: 50%;text-align: center;position: absolute;top: 0px;right: 1px;"> <?php echo $get_ijp_avail; ?> </span>
											<?php } ?>
										</div>
										
										
										
										<!-- ======== Human Resources > 6 MOVEMENT ============== -->
										<div class="case-wrapper" title="Employee Movement">
											<a  href="<?php echo base_url(); ?>uc" >
											<div class="app-icon" style="background-color: #8B08D1" title="Employee Movement">
											<i class="fa fa-exchange" title="Employee Movement" aria-hidden="true" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Movement
												</span>
											</div>
											</a>
										</div>
																						
																				
										<!-- ======== Human Resources > 6 SEPARATION ============== -->
										<div class="case-wrapper" title="Employee Exit">
											<a  href="<?php echo base_url()."user_resign";?>" >
											<div class="app-icon" style="background-color: #B32C2C" title="Employee Exit">
											<i class="fa fa-user-times" title="Employee Exit" aria-hidden="true" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">
													Separation
												</span>
											</div>
											</a>
										</div>
										<!-- ======== Human Resources > 6 F&F ============== -->
										<?php
										if( isAccessFNFHr()==true || isAccessFNFITSecurity()==true || isAccessFNFITHelpdesk()==true || isAccessFNFPayroll()==true || isAccessFNFAccounts()==true ){
										?>
										
										<div class="case-wrapper" title="FNF Checklist">
											<a  href="<?php echo base_url()."fnf";?>" >
											<div class="app-icon" style="background-color: #EF4DB6" title="FNF Checklist">
											<i class="fa fa-check-circle" title="FNF Checklist" aria-hidden="true" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">
													F&F
												</span>
											</div>
											</a>
										</div>
										<?php } ?>
										
																			
										
																																				
								</div>
								
								
								
								
								<div class='AppsOuterBox' style="padding: 5px 5px 8px 5px;">								
								<div class='outerBoxTitle'>Letters</div>
								
									<!-- ======== Human Resources > 7 Confirmation ============== -->
										<?php
										if(get_role_dir() !="agent" ){
										?>
										<div class="case-wrapper" title="User Confirmation">
											<a  href="<?php echo base_url()."letter/confirmation_list";?>" >
											<div class="app-icon" style="background-color: green" title="Confirmation List">
											<i class="fa fa-group" title="Confirmation" aria-hidden="true" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">
													Confirmation
												</span>
											</div>
											</a>
										</div>
										<?php 
										}
										?>
										
										<div class="case-wrapper" title="Warning Letter">
											<a  href="<?php echo base_url()."Warning_mail_employee/your_warning_letter";?>" >
											<div class="app-icon" style="background-color: #B32C2C" title="Warning Letter">
											<i class="fa fa-envelope" aria-hidden="true"></i>

											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">
													Warning 
												</span>
											</div>
											</a>
										</div>


										<div class="case-wrapper" title="Appraisal Letter">
											<a  href="<?php echo base_url()."appraisal_employee/your_appraisal_letter";?>" >
											<div class="app-icon" style="background-color: #1abc9c" title="Appraisal Letter">
											<i class="fa fa-envelope" aria-hidden="true"></i>

											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">
													Appraisal 
												</span>
											</div>
											</a>
										</div>

										
								</div>
								
								
								<div class='AppsOuterBox' style="padding: 5px 8px 15px 10px;">
									<div class='outerBoxTitle'>Productivity</div>
									
									
									<!-- ======== Productivity > 1 EfficiencyX ============== -->
									<?php 
										$linkurl=base_url()."egaze";
										$ac_class="";
									?>
									<div class="case-wrapper <?php echo $ac_class; ?>" title="EfficiencyX">
										<a  href="<?php echo $linkurl; ?>" >
											<div class="app-icon" style="background-color: #0c2660" title="EfficiencyX">
											<i class="fa fa-bar-chart" title="EfficiencyX" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">EfficiencyX</span>
											</div>
										</a>
									</div>
									
																		
									<!-- ======== Productivity > 2 Schedule ============== -->
									<?php
									if( get_role_dir()!="agent" || is_access_schedule_update() == true || is_access_schedule_upload() == true || get_dept_folder()=="wfm" || get_dept_folder()=="rta"  ){
										
										$ac_class="";
										$linkurl=base_url()."schedule";
									
									?>
									<div class="case-wrapper" title="Schedule">
										<a  href="<?php echo base_url()."schedule";?>" >
											<div class="app-icon" style="background-color: #E898E9" title="Schedule">
											<i class="fa fa-calendar-o" title="Schedule" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">Schedule</span>
											</div>
										</a>
									</div>
									<?php } ?>
									
									
																											
									<!-- ======== Productivity > 3 My Time ============== -->
									<?php if(get_user_office_id()!="ALT" && get_user_office_id()!="DRA") { ?>									
									<div class="case-wrapper " title="Attendance">
										<a data-toggle='modal' id='viewModalAttendance'>
											<div class="app-icon" style="background-color: #0a8cec" title="Attendance">
											<i class="fa fa-camera" title="Attendance" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">My Time</span>
											</div>
										</a>
									</div>
									<?php } ?>
									
																	
									
									<!-- ======== Productivity > 5 BreakMon ============== -->
									<?php if(get_global_access()=='1' || get_site_admin()=='1' ||  get_dept_folder()=="hr" || get_role_dir()=="super" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="tl" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" ){ ?>
									<div class="case-wrapper" title="Break Monitoring">
										<a  href="<?php echo base_url()."break_monitor";?>" >
											<div class="app-icon" style="background-color: #FF616A" title="Break Monitoring">
											<i class="fa fa-desktop" title="Break Monitoring" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">BreakMon</span>
											</div>
										</a>
									</div>
									<?php } ?>
									
									
								</div>
								
																	
								<div class='AppsOuterBox' style="padding: 5px 2px 15px 5px;">
								<div class='outerBoxTitle'>Learn</div>
								
										<!-- ======== Learn > 1 Training ============== -->
										<?php 
										if(get_dept_folder()=="training" || get_dept_folder()=="hr" || is_access_trainer_module()==true || isAgentInTraining() || isAvilTrainingExam() >0 ){
											
											if(isAssignAsTrainer()>0) $linkurl=base_url()."training/crt_batch";
											else if((isAgentInTraining() && get_dept_folder()!="training") || isAvilTrainingExam() >0 ) $linkurl=base_url()."training/agent";
											else $linkurl=base_url()."training/crt_batch";
											//$linkurl=base_url()."uc";
											
											//echo is_access_trainer_module();
										?>
											<div class="case-wrapper" title="Training">
												<a  href="<?php echo $linkurl;?>" >
													<div class="app-icon" style="background-color: #209253" title="Training">
													<i class="fa fa-tasks" title="Training" style=""></i>
													</div> 
													<div class="case-label ellipsis">
														<span class="case-label-text">Training</span>
													</div>
												</a>
												
											<?php if($isAvilTrainingExam >0 ){ ?>
												<span id="avail_training" style="background: red;color: white;width: 20px;display: inline-block;height: 20px;border-radius: 50%;text-align: center;position: absolute;top: 0px;right: 1px;"> <?php echo $isAvilTrainingExam; ?> </span>
											<?php } ?>
											
											</div>
										<?php } ?>
											
											
										<!-- ======== Learn > 2 Knowledge Base ============== -->	
										<div class="case-wrapper" title="CSPL Business Intelligence">
											<a  href="<?php echo base_url()."knowledge";?>" >
												<div class="app-icon" style="background-color: #ead100 " title="CSPL Business Intelligence">
													<i class="fa fa-book" title="CSPL Business Intelligence" aria-hidden="true" style=""></i>
												</div> 
												<div class="case-label ellipsis"> 
													<span class="case-label-text">
														Knowledge Base
													</span>
												</div>
											</a>
										</div>
											
											
										<!-- ======== Learn > 3 FAQ ============== -->	
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
																		
										<div class="case-wrapper" title="Knowledge assessment test">
											<a href="<?php echo base_url(); ?>kat">
												<div class="app-icon" style="background-color: #0c2660;padding-right: 8px;" title="Knowledge assessment test">
												<i class="fa fa-graduation-cap" title="Knowledge assessment test" style=""></i>
												</div> 
												<div class="case-label ellipsis"> 
													<span class="case-label-text">KAT</span>
												</div>
											</a>
											<?php if($isAvilKatExam >0 ){ ?>
													<span style="background: red;color: white;width: 20px;display: inline-block;height: 20px;border-radius: 50%;text-align: center;position: absolute;top: 0px;right: 1px;"> <?php echo $isAvilKatExam; ?> </span>
											<?php } ?>
										</div>
										
																
								</div>
								
							
								<?php
								//	if(isDisablePersonalInfo()==false){
								?>
								
								<div class='AppsOuterBox' style="padding: 5px 4px 15px 5px;">								
								<div class='outerBoxTitle'>Financials</div>
								
								<!-- ======== Financials > 1 Salary Slip ============== -->
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
								
								<!-- ======== Financials > 2 IT Declaration ============== -->
								<div class="case-wrapper" title="IT Declaration">
									<a  href="<?php echo base_url()."itdeclaration";?>" >
										<div class="app-icon" style="background-color: #3498db" title="IT Declaration">
										<i class="fa fa-percent" title="IT Declaration" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text" style="font-size: 8px;">IT Declaration</span>
										</div>
									</a>
								</div>
								
								</div>

								<?php //} ?>
								
								
								<div class='AppsOuterBox' style="padding: 5px 5px 15px 5px;">
									<div class='outerBoxTitle'>Performance</div>
									
									
									<!-- ======== Performance > 1 Updates ============== -->
									<?php
									$linkurl1=base_url()."process_update";
									?>
									<div class="case-wrapper" title="Process Update">
										<a  href="<?php echo $linkurl1; ?>" >
											<div class="app-icon" style="background-color: #7FA6F9" title="Process Update">
											<i class="fa fa-newspaper-o" title="Process Update" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">Updates</span>
											</div>
										</a>
									</div>
									
									<!-- ======== Performance > 2 Performance ============== -->
									<?php									
										$linkurl=base_url()."pmetrix_v2";
									?>
									
									<div class="case-wrapper" title="Performance Metrics V2">
										<a  href="<?php echo $linkurl; ?>" >
											<div class="app-icon" style="background-color: #285C53" title="Performance Metrics V2">
											<i class="fa fa-hourglass-start" title="Performance Metrics V2" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">Performance</span>
											</div>
										</a>
										
									</div>
									
									
									<!-- ======== Performance > 3 Quality ============== -->									
									<?php
																				
										if( is_access_qa_agent_module()==true || is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){
											$linkurl=base_url()."quality";
											$sr_linkurl=base_url()."qa_servicerequest";
											//$linkurl=base_url()."uc";
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
										<?php if($isAvilDipCheck >0 ){ ?>
											<span style="background: red;color: white;width: 20px;display: inline-block;height: 20px;border-radius: 50%;text-align: center;position: absolute;top: 0px;right: 1px;"> <?php echo $isAvilDipCheck; ?> </span>
										<?php } ?>
									</div>
									
																		
									<?php } ?>
									
									
									<!-- ======== Performance > 4 PIP ============== -->
									<div class="case-wrapper" title="Performance Improvement Plan">
										<a  href="<?php echo base_url()."pip";?>" >
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
									
									
									
							</div>
							
							
							
									
						<?php if(isAccessMindfaqApps()==true){ ?>
								
								
								
								<div class='AppsOuterBox' style="padding: 5px 5px 8px 5px;">
									<div class='outerBoxTitle'>Transformation App </div>
								
									<?php if(is_access_snapdeal_modules()==true){ ?>
									
									
									<div class="case-wrapper" title="Snapdeal Mind FAQ">
										<a href="<?php echo base_url() ."mindfaq_snapdeal"; ?>">
											<div class="app-icon" style="background-color: #e40046 ;" title="Snapdeal Mind FAQ">
												<i class="fa fa-comments-o" title="Snapdeal Mind FAQ" aria-hidden="true" style=""></i>
											</div> 
											<div class="case-label ellipsis"> 
												<span class="case-label-text">
													Snapdeal MindFAQ
												</span>
											</div>
										</a>
									</div>
									
									<?php } ?>
								
																
									
								</div>
								
							<?php } ?>
							
								
							
							<div class='AppsOuterBox ' style="">
								<div class='outerBoxTitle'>Business App</div>
																
								<?php if(is_access_harhith()){ ?>
								<div class="case-wrapper" title="Harhith CRM">
									<a  href="<?php echo base_url()."harhith";?>" >
										<div class="app-icon" style="background-color: #FF8C00" title="Harhith CRM">
											<i class="fa fa-globe" title="Harhith CRM" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">Harhith CRM</span>
										</div>
									</a>
								</div>
								<?php } ?>
								
							</div>
							
																
							<div class='AppsOuterBox'>
								
								<div class='outerBoxTitle'>Analytics & Reporting</div>
								
								<!-- ======== Analytics > 1 Reporting ============== -->
								<?php
								if( get_role_dir()!="agent" || isAccessReports()==true ){
									
								$ac_class="";
								$linkurl=base_url()."reports";
								?>	
								<!--
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Reports">
									<a  href="<?php //echo $linkurl; ?>" >
										<div class="app-icon" style="background-color: #7578f6" title="Reports">
										<i class="fa fa-wpforms" title="Reports" style=""></i>
										
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">Reporting</span>
										</div>
									</a>
								</div>
								-->
								
								
								<?php
								$ac_class="";
								$linkurl=base_url()."reports_hr";
								?>								
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Reports">
									<a  href="<?php echo $linkurl; ?>" >
										<div class="app-icon" style="background-color: #757996" title="Reports">
										<i class="fa fa-users" title="Reports" style=""></i>

										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">HR & Attendance</span>
										</div>
									</a>
								</div>
								
								<?php 
								$ac_class="";
								$linkurl=base_url()."reports_qa/dipcheck";
								?>								
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Reports">
									<a  href="<?php echo $linkurl; ?>" >
										<div class="app-icon" style="background-color: #75782C" title="Reports">
										<i class="fa fa-file-sound-o" title="Reports" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">Quality </span>
										</div>
									</a>
								</div>
								<?php
								$linkurl=base_url()."reports_pm";
								?>								
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Reports">
									<a  href="<?php echo $linkurl; ?>" >
										<div class="app-icon" style="background-color: #757A79" title="Reports">
										<i class="fa fa-hourglass-start" title="Reports" style=""></i>
										
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">Performance </span>
										</div>
									</a>
								</div>
								
								
								
								<?php
								$ac_class="";
								$linkurl=base_url()."reports_misc/itAssessment";
								?>								
								<div class="case-wrapper <?php echo $ac_class; ?>" title="Reports">
									<a  href="<?php echo $linkurl; ?>" >
										<div class="app-icon" style="background-color: #7578BA" title="Reports">
										<i class="fa fa-wpforms" title="Reports" style=""></i>
										
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">Miscellaneous </span>
										</div>
									</a>
								</div>
								
								<?php } ?>
								
								
								<?php
								if( isAccessMindfaqReports()==true ){
									
									$ac_class="";
									$linkurl=base_url()."mindfaq_analytics";
									?>								
									<div class="case-wrapper <?php echo $ac_class; ?>" title="Mindfaq">
										<a  href="<?php echo $linkurl; ?>" >
											<div class="app-icon" style="background-color: #0c2660" title="Mindfaq">
											<i class="fa fa-comments-o" title="Mindfaq" style=""></i>
											
											</div> 
											<div class="case-label ellipsis"> 
												<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
												<span class="case-label-text">Mindfaq</span>
											</div>
										</a>
									</div>
								<?php } ?>
								
									
								
							</div>
								
								
								
								
							<div class='AppsOuterBox'>
								<div class='outerBoxTitle'>Miscellaneous</div>
								
								<!-- ======== Miscellaneous > 1 Reset Password ============== -->
								<?php
								if( is_access_reset_password() == true || get_user_fusion_id() == "FCHA003134"){		
								?>
								<div class="case-wrapper" title="Reset Password">
									<a  href="<?php echo base_url()."user_password_reset";?>" >
										<div class="app-icon" style="background-color: #9e0c05" title="Reset Password">
										<i class="fa fa-unlock" title="Reset Password" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<!-- <div class="circle module-count-list-project" data-doctype="Project" style=""> <span class="circle-text">1</span></div>  -->
											<span class="case-label-text">Reset Password</span>
										</div>
									</a>
								</div>
								<?php } ?>
								
								<!-- ======== Miscellaneous > 2 Service Request ============== -->
								<div class="case-wrapper" title="Service Request">
									<a  href="<?php echo base_url()."Servicerequest";?>" >
										<div class="app-icon" style="background-color: #506617" title="Service Request">
											<i class="fa fa-upload" title="Service Request" aria-hidden="true" style=""></i>
										</div> 
										<div class="case-label ellipsis"> 
											<span class="case-label-text">
												Service Request
											</span>
										</div>
									</a>
								</div>
								
								<!-- ======== Miscellaneous > 4 Master Entry ============== -->
								<?php
								if(get_global_access()=='1'){
										$ac_class="";
										$linkurl=base_url()."master/role";
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
								<?php } ?>
														
								
							</div>
								
							
								
						</div>
					</div>
				</div>
				</div>					
									
			</div>
		
	
		<!------->
		
				
	</div>	
	<!------    -->
		
		
							
		<div class="col-md-3">  
												
						<!-- start of right side box -->
						
						<a href="<?php echo base_url().'fems_tutorial'; ?>" style="cursor:pointer;">
						<div class="widget" style="border-radius: 3px; background:#ADEFF7; cursor:pointer;">
							<header class="widget-header">
								<div class="widget-title" style="color:darkblue; font-size:16px; text-align:center;" > MWP Tutorial </div>
							</header>
						</div>
						</a>
						
										
						<div class="row" style="margin-bottom:5px;" >
							<div class="col-md-12">
							
							<a data-toggle="modal" data-target="#EGazeDownModel" style="cursor:pointer;">
							<div class="widget" style="border-radius: 3px;background: aliceblue; cursor:pointer;">
								<header class="widget-header">
									<div class="widget-title" style="font-size:17px; text-align:center;" >
									<i class="fa fa-bar-chart"></i> Download EfficiencyX(1.0.1.4)</div>
								</header>
							</div>
							</a>
							
							</div>
						</div>
						
						<div class="row" style="margin-bottom:5px;" >
							<div class="col-md-12">
							
							<a href="<?php echo base_url(); ?>assets/egaze/EfficiencyX_manual_mwp.pdf" target="_blank" style="cursor:pointer;">
							<div class="widget" style="border-radius: 3px;background: aliceblue; cursor:pointer;">
								<header class="widget-header">
									<div class="widget-title" style="font-size:13px; text-align:center;" ><i class="fa fa-bar-chart"></i> EfficiencyX Installation and User Guide</div>
								</header>
							</div>
							</a>
							
							</div>
						</div>
						<!--
						<div class="row" style="margin-bottom:5px;" >
							<div class="col-md-12">
							
							<a href="<?php echo base_url(); ?>assets/helpdesk/Fusion_Technical_Helpdesk_Escalation_MatrixV1_2.pdf" target="_blank" style="cursor:pointer;">
							<div class="widget" style="border-radius: 3px;background: aliceblue; cursor:pointer;">
								<header class="widget-header">
									<div class="widget-title" style="font-size:13px; text-align:center;" ><i class="fa fa-bar-chart"></i> Fusion Technical Helpdesk Escalation</div>
								</header>
							</div>
							</a>
							
							</div>
						</div>
						-->
						
						<div class="row" style="margin-bottom:5px;" >
							<div class="col-md-12">
							
							<a href="<?php echo base_url(); ?>assets/helpdesk/Global_Technical_Helpdesk_SLA_for_all_the_Mediums_V1_2.pdf" target="_blank" style="cursor:pointer;">
							<div class="widget" style="border-radius: 3px;background: aliceblue; cursor:pointer;">
								<header class="widget-header">
									<div class="widget-title" style="font-size:13px; text-align:center;" ><i class="fa fa-bar-chart"></i> Global Technical Helpdesk SLA</div>
								</header>
							</div>
							</a>
							
							</div>
						</div>
						
						
						<div class="row" style="margin-bottom:5px;" >
							<div class="col-md-12">
							
							<a href="<?php echo base_url(); ?>assets/egaze/dotnet_framework_4.6.1.exe" target="_blank" style="cursor:pointer;">
							<div class="widget" style="border-radius: 3px;background: aliceblue; cursor:pointer;">
								<header class="widget-header">
									<div class="widget-title" style="font-size:16px; text-align:center;" >Download .NET Framework 4.6.1</div>
								</header>
							</div>
							</a>
							
							</div>
						</div>
						
												
					<?php if(isADLocation()==true){ ?>
						<div class="row">
							<div class="col-md-12">
							<a href="<?php echo base_url(); ?>assets/docs_master/ad_vdi_install_doc.pdf" target="_blank" style="cursor:pointer;">
								<img width="100%" src ="<?php echo base_url(); ?>assets/images/ad_vdi_install.png" />
							</a>
							
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
							<a href="<?php echo base_url(); ?>assets/docs_master/ad_troubleshooting.pdf" target="_blank" style="cursor:pointer;">
								<img width="100%" src ="<?php echo base_url(); ?>assets/images/ad_troubleshooting.png" />
							</a>
							
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
							<a href="<?php echo base_url(); ?>assets/docs_master/ad_logoff_from_vm_v1.3.pdf" target="_blank" style="cursor:pointer;">
								<img width="100%" src ="<?php echo base_url(); ?>assets/images/ad_logoff_from_vm.png" />
							</a>
							
							</div>
						</div>
					
					<?php } ?>
					
					
									
				
				<?php if (count($user_today_dob) >0 ){ ?>
				
				<div class="row">
						
					<div class="col-md-12">
						
						<div class="widget">					
							<header class="widget-header">
								<h4 class="widget-title" style="text-align:center"><b>Today's Birthday</b></h4>
							</header> 
							<hr class="widget-separator">
							
							<div class="widget-body clearfix" id="notif_scroll">
								
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
				<?php } ?>
				
				
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
								
							<!-- 	<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/management-team.html" target="_blank">
										<div class="widget widget-person">
											<div class="widget-body clearfix" style="padding:1px;">
												<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/jyotendra.jpg" style="height: 70px; margin-right:15px"/></div>
												<div class="" style="padding:1rem;">
													<h4 class="widget-title text-primary"><span class="counter">Jyotendra Thokchom</span></h4>
													<span style="font-size:12px">Global Head - Sales and Marketing</span>
												</div>
											</div>
										</div>
									</a>
								</div> -->
								
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
												
								<!--<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
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
								</div>-->
								
								<!-- <div class="col-md-4">
									<a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
										<div class="widget widget-person">
											<div class="widget-body clearfix" style="padding:1px;">
												<div class="pull-left"><img src="<?php echo base_url(); ?>pimgs/imgmt/michael.jpg" style="height: 70px; margin-right:15px"/></div>
												<div class="" style="padding:1rem;">
													<h4 class="widget-title text-primary"><span class="counter">Michael O Neil</span></h4>
													<span style="font-size:12px">Executive Vice President</span>
												</div>
											</div>
										</div>
									</a>
								</div> -->
								
								<!--<div class="col-md-4">
									<a href="http://www.fusionbposervices.com/executive-team.html" target="_blank">
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
								</div>-->
								
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
								<th>MWP ID</th>
								<th>XPOID</th>
								<th>DOJ</th>
								<th>Status</th>
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
								<td><?php 
								
									$status = $row['status'];
									$terms_date = $row['terms_date'];
									$lwd = $row['lwd'];
									
									if($status==1) echo '<span class="label label-info">Active</span>'; 
									else if($status==0) echo '<span class="label label-danger">Terms (LWD : '.$lwd.', Term Date: '.$terms_date.' )</span>';
									else if($status==2) echo '<span class="label label-warning">Pre-Terms (LWD : '.$lwd.', Term Date: '.$terms_date.' )</span>';
									else if($status==4) echo '<span class="label label-primary">Active New</span>';
									else echo '<span class="label label-default">Deactive</span>';
								?></td>
								
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
		
			<form id="frmAddReferrals" class="frmAddReferrals" action="" onsubmit="return false;" data-toggle="validator" method='POST' enctype="multipart/form-data">
		
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Referral </h4>
			  </div>
			  <div class="modal-body">
				
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Full Name</label>
								<input type="text" id="name" name="name" class="form-control" autocomplete="off" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 32">
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
								<input type="email" id="email" name="email" class="form-control" onfocusout="checkemail();" required>
								<span id="email_status" style="color:red"></span>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Position Referring For</label>
								<select id="position" name="position" class="form-control" required>
									<option value="">-- Select Position --</option>
									<option value="agent">CCE</option>
									<option value="tl">TL</option>
									<option value="qa">QA</option>
									<option value="manager">MANAGER</option>
									<option value="am">AM</option>
									<option value="trainer">TRAINER</option>
									<option value="support">OTHER SUPPORT</option>
								</select>
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
					
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Attach CV
								</label>
								<input type="file" class="form-control" name="userfile" id="r_cv_attach" accept=".pdf" >
							</div>
						</div>
					</div>
					
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" name="submit" id='addReferal' class="btn btn-primary" value="Save">
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

<!-------------------------Holiday List--------------------------->
<div id="holidayListModel" class="modal fade">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content"> 
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<header class="widget-header">
								<h4 class="widget-title">Holiday List 2020</h4>
							</header>
							<hr class="widget-separator">
							
							<div class="widget-body">
								<div class="table-responsive" id="holidayList">
					
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!------------------------------------------------------------------->

<?php 
	if ( $is_OpenPayPopup == "Y" ) {
?>

<!-- Pay bank modal -->
<div class="modal fade" id="acceptPayInfoModal" role="dialog1" aria-labelledby="myModalLabel1" aria-hidden="true">
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
											This is to verify your salary account mentioned in MWP is correct.<br>Re 1 had been transferred to your account. <br> <br>
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
						<button type="button" id='btnPayBankInfoClose' class="btn btn-info" data-dismiss="modal">Need time to check my account</button>
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




<!-------------------------User Attendance------------------ --------->
<div id="referral_model" class="modal fade">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
	<div class="modal-content">
	
		<div class="modal-body">
			
			<div class="row">
					
					<div class="col-md-12">
						<div class="widget stats-widget">
							
							<header class="widget-header">
								<h4 class="widget-title">OYO Referral Bonus Scheme-Total Amount 18k (Referee 9K + Referred 9K), w.e.f. 1st Aug</h4>
							</header>
								<hr class="widget-separator">
					
							<div class="widget-body clearfix">
								
								
								<div class="table-responsive">
								
									<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style='margin-bottom:0px;'>
										<thead>
										
										<tr class='bg-info'>
											<td style='font-size:12px;'>
												<b>Pay Period</b>
											</td>
											<td style='font-size:12px;'>
												<b>Referee Employee</b>
											</td>
											<td style='font-size:12px;'>
												<b>Referred Employee</b>
											</td>
											
										</tr>
										</thead>
										<tbody>
										<tr>
											<td>
												End of 3 months from DOJ of Referred Employee provided both Referee and Referred employee are active
											</td>
											<td style='text-align:center;'>
												Rs. 3000
											</td>
											<td style='text-align:center;'>
												Rs. 3000
											</td>
											
										</tr>

										<tr>
											<td>
												End of 6 months from DOJ of Referred Employee provided both Referee and Referred employee are active
											</td>
											<td style='text-align:center;'>
												Rs. 1500
											</td>
											<td style='text-align:center;'>
												Rs. 1500
											</td>
										</tr>
										<tr>
											<td>
												End of 9 months from DOJ of Referred Employee provided both Referee and Referred employee are active
											</td>
											<td style='text-align:center;'>
												Rs. 3000
											</td>
											<td style='text-align:center;'>
												Rs. 3000
											</td>
										</tr>
										<tr>
											<td>
												End of 12 months from DOJ of Referred Employee provided both Referee and Referred employee are active
											</td>
											<td style='text-align:center;'>
												Rs. 1500
											</td>
											<td style='text-align:center;'>
												Rs. 1500
											</td>
										</tr>
										<tr>
											<td style='font-size:12px;'>
												<b>Total Referral Bonus</b>
											</td>
											<td style='font-size:12px; text-align:center;'>
												<b>Rs. 9000</b>
											</td>
											<td style='font-size:12px; text-align:center;'>
												<b>Rs. 9000</b>
											</td>
										</tr>
										</tbody>
									</table>
							</div>
							
							
						</div>
					</div>
				</div>
			</div>
		 
			
		</div>
	</div>
	</div>
</div>



<!-------------------------IJP Popup------------------ --------->
<div id="applnIjpImgModel-xx" class="modal fade">
  <div class="modal-dialog" style = 'width:60%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a id="applnIjpModelBtn" style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/ijpkol4.jpg"/>
			</a>
		</div>
	</div>
	</div>
</div>


<!-------------------------Add IJP Appln----------------------- ---->
<div id="applnIjpFrmModel" class="modal fade">
  <div class="modal-dialog">
	<div class="modal-content">      
		
			<form class="frmApplnIJP" action="" onsubmit="return false;" data-toggle="validator" method='POST'>
		
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Application for Internal Job </h4>
			  </div>
			  <div class="modal-body">
				
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Location</label>
									<select class="form-control" id="ijp_location" name="location" required>
									<option value="">-Select-</option>
									<option value="KOL">Kolkata (Y9)</option>
									<option value="HWH">Howrah</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
						
							<div class="form-group">
								<label>Post Applying For</label>
									<select class="form-control" id="app_post" name="app_post" required>
									<option value="">-Select-</option>
									<option value="SME">SME</option>
									<option value="Quality">Quality</option>
									<option value="Team Leader">Team Leader</option>
									<option value="MIS">MIS</option>
									<option value="HR">HR</option>
								</select>
							</div>
						</div>
					</div>
											
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Phone</label>
								<input type="number" id="phone" name="phone" class="form-control" required>
								
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Email</label>
								<input type="email" id="email_id" name="email_id" class="form-control" required>
								
							</div>	
						</div>
					</div>
					
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" name="submit" id='saveApplnIjpBtn' class="btn btn-primary" value="Save">
			  </div>
			  
			 </form>
		
		</div>
	</div>
</div>



<style>
.item img {
    width: 100%;
    height: auto;
}
</style>



<!-------------------------Home Popup Esl------------------ --------->
<div id="homeImgModelEsl" class="modal fade">
  <div class="modal-dialog" style = 'width:45%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
		
			<div id="ElsCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
				<li data-target="#ElsCarousel" data-slide-to="0" class="active"></li>
				<!--
				<li data-target="#ElsCarousel" data-slide-to="1"></li>
				<li data-target="#ElsCarousel" data-slide-to="2"></li>
				
				<li data-target="#ElsCarousel" data-slide-to="3"></li>
				<!--
				<li data-target="#ElsCarousel" data-slide-to="4"></li>
				<li data-target="#ElsCarousel" data-slide-to="5"></li>
				<li data-target="#ElsCarousel" data-slide-to="6"></li>
				<li data-target="#ElsCarousel" data-slide-to="7"></li>
				<li data-target="#ElsCarousel" data-slide-to="8"></li>
				-->
			  </ol>

	
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
			  								
				<div class="item active">
				  <img src="<?php echo base_url(); ?>assets/images/esal_referral_post.jpg" alt="">
				</div>
				
				<!--
				<div class="item active">
				  <img src="<?php echo base_url(); ?>assets/images/els_healthy_winner.png" alt="">
				</div>
				
				<div class="item ">
				  <img src="<?php echo base_url(); ?>assets/images/els_popup8.png" alt="">
				</div>
				<div class="item">
				  <img src="<?php echo base_url(); ?>assets/images/els_popup6.png" alt="">
				</div>
				<div class="item ">
				  <img src="<?php echo base_url(); ?>assets/images/els_popup7.png" alt="">
				</div>
								
				<div class="item ">
				  <img src="<?php //echo base_url(); ?>assets/images/els_popup4.png" alt="">
				</div>
				<div class="item ">
				  <img src="<?php //echo base_url(); ?>assets/images/els_popup5.png" alt="">
				</div>
				
				<div class="item ">
				  <img src="<?php //echo base_url(); ?>assets/images/els_referral_bonus.png" alt="">
				</div>

				<div class="item">
				  <img src="<?php //echo base_url(); ?>assets/images/els_popup1.png" alt="">
				</div>

				<div class="item">
				  <img src="<?php //echo base_url(); ?>assets/images/els_popup2.png" alt="">
				</div>
				
				<div class="item">
				  <img src="<?php //echo base_url(); ?>assets/images/els_popup3.png" alt="">
				</div>
				-->
				
			  </div>
			</div>
			
		</div>
	</div>
	</div>
</div>


<!-------------------------Add Home Appln----------------------- ---->

<div id="frmHomeImgModelKol" class="modal fade">
  <div class="modal-dialog">
	<div class="modal-content">      
		
			<form class="frmHomeKolSeed" action="" onsubmit="return false;" data-toggle="validator" method='POST'>
		
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Application for Leadership Workshop (SEED)</h4>
			  </div>
			  <div class="modal-body">
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Location</label>
									<select class="form-control" id="location_id" name="location_id" required readonly>
									<option value="KOL">Kolkata (Y9)</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Your MWP ID</label>
								<input type="text" id="fusion_id" name="fusion_id" value="<?php echo get_user_fusion_id();?>" class="form-control" required readonly>	
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Your Name</label>
								<input type="text" id="appln_name" name="appln_name" value="<?php echo get_username();?>" class="form-control" required readonly>	
							</div>
						</div>
					</div>
											
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Phone</label>
								<input type="number" id="phone" name="phone" value="<?php echo $personal_row['phone'];?>" class="form-control" required>
								
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Email</label>
							<input type="email" id="email_id" name="email_id" value="<?php echo $personal_row['email_id_per'];?>" class="form-control" required>
								
							</div>	
						</div>
					</div>
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" name="submit" id='saveApplnSeedBtn' class="btn btn-primary" value="Save">
			  </div>
			  
			 </form>
		
		</div>
	</div>
</div>



<div id="refIndLeftModel" class="modal fade">
  <div class="modal-dialog" style = 'width:50%;'>
	<div class="modal-content">
		<div class="modal-body">
			<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/ind_employee_connect.jpg"/>
		</div>
	</div>
	</div>
</div>


<div id="IndLeftModel2" class="modal fade">
  <div class="modal-dialog" style = 'width:50%;'>
	<div class="modal-content">
		<div class="modal-body">
			<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/ind_calender_feb_2021.jpg?<?php echo time(); ?>"/>
		</div>
	</div>
	</div>
</div>

<!-- ----------- -------->

<div id="refKolBangkokModel" class="modal fade">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
	<div class="modal-content">
	
		<div class="modal-body">
			
			<div class="row">
					
					<div class="col-md-12">
						<div class="widget stats-widget">
							
							<header class="widget-header">
								<h4 class="widget-title">Referral Competition From September to December</h4>
							</header>
								<hr class="widget-separator">
					
							<div class="widget-body clearfix">
								
							
									<div class="panel panel-info">
									  <div class="panel-heading">Rules</div>
									  <div class="panel-body">
									  
										•	Minimum referral is 5 per month per employee (20 referrals in 4 months) <br>
										•	Each referral will get 50 points<br>
										•	Each drop out inside 90 days from joining, 50 points would be debited<br>
										•	By end of Feb the reconciliation would be done for the 3 grand prizes<br>
										•	Scheme is effective from 1st September
									  </div>
									</div>
									<div class="panel panel-primary">
									  <div class="panel-heading">Monthly Award</div>
									  <div class="panel-body">
										•	Top referrer (joined) for the month will get to choose his shift timing/OFF day<br>
										•	At the end of February, total points would be tallied 
									  </div>
									</div>
									<div class="panel panel-success">
									  <div class="panel-heading">Grand Prize</div>
									  <div class="panel-body">
										•	Paid trip for ONE person to either BANGKOK - GOA – North EAST – ANDAMAN (4/6 days)<br>
										•	Mobile Phone worth 15000<br>
										•	Alexa Dot
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

<style>
#refCebuAddRefModelBtn:hover{
	background-image: url("<?php echo base_url(); ?>assets/images/cebu_ref_btn.png");	
	
   background-position: center; /* Center the image */
   background-repeat: no-repeat; /* Do not repeat the image */
   background-size: cover; /* Resize the background image to cover the entire container */
  
}

#refCebuModelBtn:hover{
   background-image: url("<?php echo base_url(); ?>assets/images/cebu_know.png");
   background-position: center; /* Center the image */
   background-repeat: no-repeat; /* Do not repeat the image */
   background-size: cover; /* Resize the background image to cover the entire container */
}
</style>

<!-------------------------Ref cebu Popup------------------ --------->
<!--
<div id="refCebuImgModel" class="modal fade">
  <div class="modal-dialog" style = 'width:700px;'>
	<div class="modal-content">
		<div class="modal-body">	
			<div id='refCebuAddRefModelBtn' style="position:absolute; margin-top:245px; margin-left:10px;  cursor:pointer; border: 0px solid blue; height:55px; width:410px;"></div>
			<div id='refCebuModelBtn' style="position:absolute; margin-top:385px; margin-left:464px; cursor:pointer; border: 0px solid darkblue; height:40px; width:200px;"></div>
		
			<img style= 'width:700px;' src ="<?php //echo base_url(); ?>assets/images/ref_cebu1.jpg"/>
		</div>
	</div>
	</div>
</div>
-->

<div id="refCebuImgModel" class="modal fade" style="z-index:9999">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
						
			<div id="CebCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
				<li data-target="#CebCarousel" data-slide-to="0" class="active"></li>
				<!--
				<li data-target="#CebCarousel" data-slide-to="1"></li>
				<li data-target="#CebCarousel" data-slide-to="2"></li>
				<li data-target="#CebCarousel" data-slide-to="3"></li>
				-->
			  </ol>
			  
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
								
				<div class="item active">
				  <img src="<?php echo base_url(); ?>assets/images/ceb_erp_internal.jpg" alt="">
				</div>
				<!--
				<div class="item">
				  <img src="<?php //echo base_url(); ?>assets/images/ceb_progression.jpg" alt="">
				</div>
				<div class="item ">
				  <img src="<?php //echo base_url(); ?>assets/images/phi_trans_coord2.jpg" alt="">
				</div>
				<div class="item">
				  <img src="<?php //echo base_url(); ?>assets/images/ceb_referral.jpg" alt="">
				</div>
				-->
			  </div>
			</div>
			
			<!--
			<a id="refCebuAddRefModelBtnXX" style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php //echo base_url(); ?>assets/images/ceb_workathome.png"/>
			</a>
			-->
						
		</div>
	</div>
	</div>
</div>

<div id="refManImgModel" class="modal fade">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			
			<div id="ManCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
				<li data-target="#ManCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#ManCarousel" data-slide-to="1"></li>
			  </ol>
			  
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
				
				<div class="item active">
				  <img src="<?php echo base_url(); ?>assets/images/cebu_hr_ijp.jpg" alt="">
				</div>
				<div class="item">
				  <img src="<?php echo base_url(); ?>assets/images/ceb_progression.jpg" alt="">
				</div>
			  </div>
			</div>
			
			
			<!--
			<a id="refManAddRefModelBtn" style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php //echo base_url(); ?>assets/images/ceb_man_a9.jpg"/>
			</a>
			-->
		</div>
	</div>
	</div>
</div>


<div id="PhilImgModel" class="modal fade">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			
			
			<div id="philCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
				<li data-target="#philCarousel" data-slide-to="0" class="active"></li>
			  </ol>
			  
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">			
								
				<div class="item active">
				  <img src="<?php echo base_url(); ?>assets/images/APE_2021_phillipines.jpg" alt="">
				</div>			
				
				<!--<div class="item">
				  <img src="<?php echo base_url(); ?>assets/images/Black_Out_Poetry.jpg" alt="">
				</div>-->
				
			  </div>
			</div>
			
			<!--
			<a style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/phil_speaker1.jpg"/>
			</a>
			-->
			
		</div>
	</div>
	</div>
</div>



<div id="refCebuFrmModel" class="modal fade">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
	<div class="modal-content">
	
		<div class="modal-body">
			
			<div class="row">
					
					<div class="col-md-12">
						<div class="widget stats-widget">
							
							<header class="widget-header">
								<h4 class="widget-title">Php 2,000.00 referral bonus, this is for every successful referral, w.e.f. 11th September, 2019</h4>
							</header>
								<hr class="widget-separator">
					
							<div class="widget-body clearfix">
							
									<div class="panel panel-info">
									  <div class="panel-heading">Terms and Conditions:</div>
									  <div class="panel-body">
										•	The referred employee has to be active. 
									  </div>
									</div>
									<div class="panel panel-primary">
									  <div class="panel-heading">Pay Period</div>
									  <div class="panel-body">
										•	Php 1,000.00 will be given on the first month of the referral <br>
										•	Php 500.00 will be given on the third month of the referral <br>
										•	Php 500.00 will be given on the 6th month of the referral <br>
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


<div id="infoPayrollFrmModel" class="modal fade">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
	<div class="modal-content">
	
		<div class="modal-body">
			
			<div class="row">
					
					<div class="col-md-12">
						<div class="widget stats-widget">
							
							<header class="widget-header">
								<h4 class="widget-title"></h4>
							</header>
							<hr class="widget-separator">
					
							<div class="widget-body clearfix">
															
									<div class="panel panel-info">
									  <div class="panel-heading">Payroll Information</div>
									  <div class="panel-body">
									  
										This communication is to inform you all concerned employees from SIG who joined prior to August'19, there has been a computation error in Payroll and hence impacting your pay. We  apologize for this error but please expect a quick resolution for the same. <br> <br> 

										We would like to reassure you through this memo that the payroll team is coming back to the concerned at the earliest. <br> <br> 

										Please feel free to reach Oindrila Banerjee from HR, she is available from 12:00 am to 9:00 pm,<br> 
										or <br> 
										Manik Pradhan from Business Analytics & Payroll, he is available from 7:00 pm to 4:00 am.<br> 
										<br> <br> 
										-	Payroll Team.
										<br> 

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


<!-------------------IT Assessment (09/03/2020)-------------------->
<?php //if($itAssessment['uid'] <= 0){ ?>
<!-- <div id="homeImgModelItAssessment" class="modal fade">
  <div class="modal-dialog" style = 'width:60%;'>
	<div class="modal-content">
		<div class="modal-body">
			<a data-toggle="modal" data-target="#itAssessment" style="cursor:pointer">
				<img style= 'width:100%;' src ="<?php //echo base_url(); ?>assets/images/it_assessment.jpg"/>
			</a>	
		</div>
	</div>
	</div>
</div> -->
<?php //} ?>


<!-------------------------IT Assessment----------------------- ---->
<?php if($itAssessment['uid'] <= 0){ ?>

<div id="itAssessment" class="modal fade">
  <div class="modal-dialog">
	<div class="modal-content">      
		
			<form class="frmItAssessment" action="" onsubmit="return false;" data-toggle="validator" method='POST'>
		
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">IT Assessment Management</h4>
			  </div>
			  <div class="modal-body">
				
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Do you have Desktop or Laptop at Home</label>
								<select class="form-control" id="dekstop_laptop" name="dekstop_laptop" required>
									<option value="">Select</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>What Kind of Laptop/ Desktop you Have Make / Model </label></br>
								<label>CPU:</label><input type="text" name="what_kind_dl_cpu" class="form-control itast" disabled>
								<label>RAM:</label> <input type="text" name="what_kind_dl_ram" class="form-control itast" disabled>
								<label>HDD:</label> <input type="text" name="what_kind_dl_hdd" class="form-control itast" disabled>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>What Internet Connection do you have?</label>
								<input type="text" name="what_internet_conn" class="form-control itast" disabled>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>What is the Bandwith?</label>
								<input type="text" name="what_bandwith" class="form-control itast" disabled>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Do you have Headset?</label>
								<input type="text" name="have_headset" class="form-control itast" disabled>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Do you any kind of Power Back up?</label>
								<input type="text" name="kind_power_backup" class="form-control itast" disabled>
							</div>
						</div>
					</div>
					
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" name="submit" id='addItAssessment' class="btn btn-primary" value="Save">
			  </div>
			  
			 </form>
		
		</div>
	</div>
</div>
<?php } ?>


<!-------------------------ALT Popup------------------ --------->
<div id="USDisclaimerModel" class="modal fade">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
	<div class="modal-content">	
		<div class="modal-body">
			<div class="row">
					
					<div class="col-md-12">
						<div class="widget stats-widget">
							
							<header class="widget-header">
								<h4 class="widget-title">
								</h4>
							</header>
								<hr class="widget-separator">
					
							<div class="widget-body clearfix">
							
									 <center>
										 <span class='alert-asset' style="font-size:20px;">
										 <img style= 'height:20px;' src ="<?php echo base_url(); ?>assets/images/disclaimer2.png"/>
										 <b>Do not refer to attendance module in MWP. Attendance module is not applicable for US Region.<b>
										</span>	
									</center>									
									  
								
							
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>

<!------------------------IT Declaration POPUP (16/03/2020)------------------- --------->
<div id="homeITDeclarationIndLoc_notreq" class="modal fade">
  <div class="modal-dialog" style = 'width:60%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a id=""  style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/itdeclarationpopup.jpg"/>
			</a>
		</div>
	</div>
	</div>
</div>




<div id="homeImgModelAllLocation_notreq" class="modal fade" style="z-index:99999!important">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a id=""  style="cursor:pointer;">		
				<!-- <img style= 'width:100%;' src ="<?php //echo base_url(); ?>assets/images/covid_all_loc.jpg"/> -->
				<!--<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/fusion_happy_env_day1.jpg"/>-->
				<!--<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/all_fusion_bpo_certificate_best_tool_cp.jpg"/>-->
				<!--<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/all_itel_announcement1.jpg"/>-->
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/LEAP_February_Register_2.png"/>
			</a>
		</div>
	</div>
	</div>
</div>

<div id="homeImgModelAllLocation2_notreq" class="modal fade" style="z-index:99999!important">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a id=""  style="cursor:pointer;">
				<!--<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/Security_Awareness.jpg"/> -->
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/fems_ad_award.jpg"/>
			</a>
		</div>
	</div>
	</div>
</div>

<div id="homeImgModelAllLocation3_notreq" class="modal fade" style="z-index:99999!important">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a id=""  style="cursor:pointer;">
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/FEMS_Payroll_copy_1.jpg"/>
			</a>
		</div>
	</div>
	</div>
</div>

<!-------------------------Home ALL Popup LINK ------------------ --------->
<div id="homeImgModelAllLocationLink_notreq" class="modal fade" style="z-index:9999!important">
  <div class="modal-dialog" style = 'width:60%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSd8Ur4wVh0ERr9GmRllLAyX9ka23b3YrkSr48rZfDAAEMRIYA/viewform">
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/popup_google_form_coaching.jpg"/>
			</a>
		</div>
	</div>
	</div>
</div>

<!-------------------------Process Wise Popup------------------ --------->
<?php
$img_process_id = (!empty(get_process_ids())) ? get_process_ids() : "0";
$img_process = array();
if(in_array('405',explode(',',$img_process_id)) || get_global_access()){ $img_process[] = "Cuemath_Incentive_Domestic.jpg";}
if(in_array('406',explode(',',$img_process_id)) || get_global_access()){ $img_process[] = "CeuMath_International.png"; }
if(!empty($img_process)){
?>
<div id="homeImgModelProcessLocation" class="modal fade" style="z-index:99999!important">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">			
			<div id="ProcessCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			  <?php $sl=0; foreach($img_process as $tokenpp){  $sl++; $activeClass=""; if($sl == 1){ $activeClass = "active"; } ?>
				<li data-target="#ProcessCarousel" data-slide-to="<?php echo $sl-1; ?>" class="<?php echo $activeClass; ?>"></li>
			  <?php } ?>
			  </ol>
			  
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">	
				<?php $sl=0;foreach($img_process as $tokenpp){  $sl++; $activeClass="";  if($sl == 1){ $activeClass = "active"; } ?>
				<div class="item <?php echo $activeClass; ?>">
				  <img src="<?php echo base_url(); ?>assets/images/<?php echo $tokenpp; ?>" alt="">
				</div>
			    <?php } ?>
			  </div>
			</div>			
		</div>
	</div>
	</div>
</div>
<?php } ?>

<div id="homeImgModelALT" class="modal fade">
  <div class="modal-dialog" style = 'width:60%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a id=""  style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/alt_paycom1.jpg"/>
			</a>
		</div>
	</div>
	</div>
</div>

<div id="homeImgModelCAS" class="modal fade">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a id="" style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/english_to_french.png"/>
			</a>
		</div>
	</div>
	</div>
</div>

<!-------------------------Home KOL Popup now disable ------------------ --------->
<div id="homeImgModelKol_notreq" class="modal fade">
  <div class="modal-dialog" style = 'width:60%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<a id="homeImgModelKolBtn" isApply="<?php echo $isApplySeed;?>" style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/leadership_workshop.jpg"/>
			</a>
		</div>
	</div>
	</div>
</div>


<!-------------------------Home IND Popup------------------ --------->
<div id="homeImgModelInd_notreq" class="modal fade" style="z-index:9999!important">
  <div class="modal-dialog" style = 'width:55%;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			
			<!--<div id="IndCarousel" class="carousel slide" data-ride="carousel">			  
			  <ol class="carousel-indicators">
				<li data-target="#IndCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#IndCarousel" data-slide-to="1"></li>
				<li data-target="#IndCarousel" data-slide-to="2"></li>
			  </ol>
			  
			  <div class="carousel-inner">
				
				<div class="item active">
				  <img src="<?php echo base_url(); ?>assets/images/ind_banner_six.jpg" alt="">
				</div>
				<div class="item ">
				  <img src="<?php echo base_url(); ?>assets/images/ind_img_1701.png" alt="">
				</div>
				<div class="item">
				  <img src="<?php echo base_url(); ?>assets/images/ind_img_1702.png" alt="">
				</div>
			  </div>
			</div>-->
			
			<a id=""  style="cursor:pointer;">		
				<!--<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/ind_banner_six.jpg"/>-->
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/FEMS_Payroll_copy_1.jpg"/>
			</a>
		</div>
	</div>
	</div>
</div>


<!-------------------------User References----------------------- ---->
<div id="messageFromBOD" class="modal fade">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
	<div class="modal-content">
			<div class="modal-body">
				<a id=""  style="cursor:pointer;">		
				<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/MessageFromBOD.jpg"/>
				</a>
			</div>
			
		</div>
		  
	</div>
</div>

<div id="EGazeDownModel" class="modal fade">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
	<div class="modal-content">      
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
				
					<div style="background: aliceblue;box-shadow: 0 1px 2px #ccc">
						Please note that CSPL will be capturing your system data, while you are logged into EfficiencyX  and MWP during Official duty. This is to ensure compliance monitoring is in place for the business. Application will not store any customer sensitive information or key logs. please ensure you are logged into EfficiencyX when you are in shift and logout from MWP while your shift is over.
					</div>
								
					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				<input type="submit" name="submit" id='accepteGaze' class="btn btn-primary" value="Accept & Download ">
			</div>
		
		</div>
		  
	</div>
</div>
	



<!------------------------- SURVEY WORK FROM HOME  ----------------------- ---->
<?php if($survey_workhome['isdonesurvey'] <= 0){ ?>

<div id="SurveyWorkHome" class="modal fade">
  <div class="modal-dialog">
	<div class="modal-content">      
		
			<form class="frmSurveyWorkHome" action="" onsubmit="return false;" data-toggle="validator" method='POST'>
		
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Survey for Work From Home</h4>
			  </div>
			  <div class="modal-body">
				
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Are you doing Work from Home?</label>
								<select class="form-control" id="is_work_home" name="is_work_home" required>
									<option value="">Select</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</div>	
						</div>
					</div>
				
				<div id="to_show_wah">
				
					<?php
										
						if(get_user_office_id()=="CHA") $compName=" CSPL ";
						else $compName=" Fusion BPO ";
											
					?>
										
					<hr/>
				
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Are you happy that <?php echo $compName; ?> has shifted to a WAH setup to address business continuity and employees' safety at this time of global health crisis?</label>
								<select class="form-control" id="is_shifted_happy" name="is_shifted_happy" required>
									<option value="">Select</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Are you happy with how <?php echo $compName; ?> has handled the WAH deployment (ie: Wifi Provisions, Sending desktop units home, etc. ?</label>
								<select class="form-control" id="how_shifted_happy" name="how_shifted_happy" required>
									<option value="">Select</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</div>	
						</div>
					</div>
					
					<?php
										
						if(get_user_office_id()=="CHA"){	
					?>
						
						<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Choose a hashtag we all can use globally to talk about CSPL's initiative/COVID-19 Response plans that we can use as a soundboard for testimonials.</label>
								<select class="form-control" id="wfh_hashtag" name="wfh_hashtag" required>
									<option value="">Select</option>
									<option value="CSPLUnited">#CSPLUnited</option>
									<option value="CSPLCares">#CSPLCares</option>
									<option value="CSPLWorkLifeBalance">#CSPLWorkLifeBalance</option>
								</select>
							</div>	
						</div>
					</div>
					
					<?php
						}else{
					?>
						
						<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Choose a hashtag we all can use globally to talk about Fusion's initiative/COVID-19 Response plans that we can use as a soundboard for testimonials.</label>
								<select class="form-control" id="wfh_hashtag" name="wfh_hashtag" required>
									<option value="">Select</option>
									<option value="FusionUnited">#FusionUnited</option>
									<option value="FusionCares">#FusionCares</option>
									<option value="FusionWorkLifeBalance">#FusionWorkLifeBalance</option>
								</select>
							</div>	
						</div>
					</div>
					
					<?php			
						}			
					?>
					
					
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Comments/Suggestions/Feedback:</label>
								<textarea type="text" name="wfh_comments" id="wfh_comments" class="form-control" required></textarea>
							</div>	
						</div>
					</div>
				
				</div>
					
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" name="submit" id='addItAssessment' class="btn btn-primary" value="Save">
			  </div>
			  
			 </form>
		
		</div>
	</div>
</div>

<?php } ?>




<div id="homeYourMoodAllLoc" class="modal fade" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<div class="row">
			
			<div class="card card-shadow mb-4">
					<div class="card-body ">
						<div class="rating-panel text-center">
							<h3 class="mb-4 text-capitalize"><b>How is your mood today?</b></h3>
							
							<div style="height: 15px; margin: 20px;"> </div>
							<!--
							<div class="progress mb-5" style="height: 15px; margin: 20px;">
								
								<div class="progress-bar custom-progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
								
							</div>
							-->
							
							<div class="smiley-panel" style="padding-bottom: 20px;">
								<div class="smiley-group">
									<a href="#" txt='Distressed' class="YourMood text-dark text-capitalize">
										<img class="img-fluid" src="assets/images/emojis/cry_40x40.gif">
										<span class="d-block">Distressed</span>
									</a>
									<a href="#" txt='Sad' class="YourMood text-dark text-capitalize">
										<img class="img-fluid" src="assets/images/emojis/sad_40x40_1.gif">
										<span class="d-block">Sad</span>
									</a>
									<a href="#" txt='Satisfied' class="YourMood text-dark text-capitalize">
										<img class="" src="assets/images/emojis/smile_40x40.gif">
										<span class="d-block">Satisfied</span>
									</a>
									<a href="#" txt='Joyful' class="YourMood text-dark text-capitalize">
										<img class="" src="assets/images/emojis/wink_40x40.gif">
										<span class="d-block">Joyful</span>
									</a>
									<a href="#" txt='Enthusiastic' class="YourMood text-dark text-capitalize active">
										<img class="" src="assets/images/emojis/laugh_40x40.gif">
										<span class="d-block">Enthusiastic</span>
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
</div>



<div id="femsSecurityPhishing" class="modal fade" data-backdrop="static" data-keyboard="false" style="z-index:99999999999!important">
  <div class="modal-dialog" style="width:60%; margin-top:15px;" >
	<div class="modal-content">      
		
			<form class="femsSecurityPhishingAckForm"  action="<?php echo base_url('notification_home/acknowledge_security_phishing'); ?>" method='POST'>
		
			  <div class="modal-body">					
					<div class="row">
						<div class="col-md-12">
							<img style="width:100%" src="<?php echo base_url() ."assets/images/Phishing.jpg"; ?>">
						</div>
						
						<div class="col-md-12" style="margin-top:10px;">
							<div class="form-group">
								<input type="checkbox" id="fems_ack_security_phising" name="fems_ack_security_phising" value="1" required> &nbsp; &nbsp;<b>I acknowledge that I have read the above content</b>
							</div>	
						</div>
					</div>
			  </div>				
			 
			  <div class="modal-footer">
				<button style="float:left" type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Read</button>
				<?php /*if($is_show_ack_ransomware_skip_status < 1){ ?>
				<a class="btn btn-primary pull-right" href="<?php echo base_url('notification_home/acknowledge_security_ransomware_skip'); ?>"><i class="fa fa-clock-o"></i> Skip Now </a>
				<?php }*/ ?>
			  </div>
			  
			 </form>
		
		</div>
	</div>
</div>




<div id="homeImageNewBrandAllLoc_notreq" class="modal fade" role="dialog" aria-hidden="true" style="z-index:999999!important"> >
  <div class="modal-dialog" style='width:600px; margin-top: 10px;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/fems_brand_relaunch.jpg"/>
							
		</div>
	</div>
	</div>
</div>

<div id="homeVideoNewBrandAllLoc_notreq" class="modal fade" role="dialog" aria-hidden="true"  style="z-index:999999!important"> >
  <div class="modal-dialog" style='width:790px;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<div id='audioOn' style="z-index:9; position:fixed; right:25px; font-size:48px;color:red; cursor:pointer;" >
				<i class="fa fa-volume-down" title="Unmute" style=""></i>
			</div>
			
			<video  width="760" id='femsHomeVideo' controls autoplay preload loop muted >
			<!--  <source src="./assets/video/fems_canada.webm" type="video/webm"> -->
			<!-- <source src="./assets/video/fems_php_vid.webm" type="video/webm">  --> 
			<source src="./assets/video/alt_vital.mp4" type="video/mp4"> 
			  
			  Your browser does not support HTML video.
			</video>

			
		</div>
	</div>
	</div>
</div>

<div id="homeImageNewBrandAdLocation_notreq" class="modal fade" role="dialog" aria-hidden="true" style="z-index:999999!important"> >
  <div class="modal-dialog" style='width:600px; margin-top: 10px;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<img style= 'width:100%;' src ="<?php echo base_url(); ?>assets/images/ad_fems_post2.gif"/>
							
		</div>
	</div>
	</div>
</div>

<div id="homeVideoNewBrandAdLocation_notreq" class="modal fade" role="dialog" aria-hidden="true"  style="z-index:999999!important"> >
  <div class="modal-dialog" style='width:790px;'>
    <!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			<div id='audioOnAd' style="z-index:9; position:fixed; right:25px; font-size:48px;color:red; cursor:pointer;" >
				<i class="fa fa-volume-down" title="Unmute" style=""></i>
			</div>
			
			<video  width="760" id='femsHomeVideoAd' controls autoplay preload loop muted >
			<!--  <source src="./assets/video/fems_canada.webm" type="video/webm"> -->
			<!-- <source src="./assets/video/fems_php_vid.webm" type="video/webm">  --> 
			<source src="./assets/video/ameridial_vd.mp4" type="video/mp4"> 
			  
			  Your browser does not support HTML video.
			</video>

			
		</div>
	</div>
	</div>
</div>


<!---------------------DynamicPopUp-------------------------->
<?php 
if (isset($UserHomePopup)) {
	
	foreach ($UserHomePopup as $key=>$value) {
	?>
		<div id="myDynamicPopUp<?php echo $value['id'] ?>" class="modal fade">
		<div class="modal-dialog" style='wigth:60%;'>
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<a href="<?php if(isset($value['img_link'])){echo $value['img_link'];}else{echo "#";};?>" target="_blank" id="" style="cursor:pointer;">		
						<img style= 'width:100%;' src ="<?php echo base_url(); ?>uploads/dynamic_pop_up/<?php echo $value['image_path'];?>"/>
					</a>
				</div>
			</div>
			</div>
		</div>
	<script type="text/javascript">
		$(window).on('load', function() {
			$('#myDynamicPopUp<?php echo $value["id"] ?>').modal('show');
		});
	</script>
	<?php 
	}
}
?>


<?php 
	if($is_added_vaccination==0){
?>

		
		
<div id="addedVaccinationModal" class="modal fade" data-backdrop="static"  role="dialog" aria-hidden="true" >
  <div class="modal-dialog" style=''>
    <!-- Modal content-->
	<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Please Share Your vaccination information</h4>
			  </div>

						
			<div class="modal-body" style="padding:10px;">				
					<div class="row">
						<div class="col-md-12" style="margin-top:30px; margin-bottom:35px;">
							<center>
							
							<a class="btn btn-primary" href="<?php echo base_url('profile/vaccine/'.$prof_fid); ?>"><i class="fa fa-clock-o"></i>  Click Here To Update Your vaccination information </a>
							
							</center>
						</div>
					</div>
			</div>
			</form>
	</div>
	</div>
	</div>

	
	
<script type="text/javascript">

$(document).ready(function(){
	$("#addedVaccinationModal").modal('show');
		<?php if(!empty($is_show_ack_phishing) && $is_show_ack_phishing == true){ ?>
	   $('#femsSecurityPhishing').modal('show');
	<?php } ?>
});

</script>

<?php 
}
?>





