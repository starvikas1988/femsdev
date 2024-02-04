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
 
 .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
	}
	
.table > thead > tr > th,.table > tfoot > tr > th{
		text-align:center;
}
	
 </style>
 
 


<div class="wrap">
	<section class="app-content">
		<div class="row">
		
			<div class="col-md-7">
				<div class="widget">
				<header class="widget-header">
						<h4 class="widget-title"> When you go to break, you must on the following timer.</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					
					<div class="widget-body row">
						<div class="col-xs-12" align="center">
							<label class="switch  switch-flat">
							<?php if($break_on===true): ?>
							<input class="switch-input" type="checkbox" id="break_check_button" checked>
							<?php else: ?>
							<input class="switch-input" type="checkbox" id="break_check_button">	
							<?php endif; ?>
							
							<span class="switch-label" data-on="Break Off" data-off="Break On"></span> 
							<span class="switch-handle"></span>
							
						   </label>
							  <div class="slider round"></div>
						   </label>
							
						</div>
						<div class="col-xs-12" align="center">
						<h2 class="fz-xl fw-400 m-0" data-plugin="counterUp">
						
						<?php if($break_on===true): ?>
						<span id="countdown"></span> 
						<?php endif; ?>
						<span id="countdown1"><br/></span>
						</h2>
						</div>
					</div> <!--widget-body -->
					
				</div><!-- .widget -->
			</div>
			
			<div class="col-md-5">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Current Time : <span id="txt"></span></h4>
						<h4 class="fz-xl fw-400 m-0" data-plugin="counterUp"  ></h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<div class="widget-body row">
						<div class="col-xs-12">
							<!--<div class="text-center">
								<h4 class="fz-xl fw-400 m-0" data-plugin="counterUp"  id="txt2"></h4>
							</div>-->
						</div><!-- END column -->
						<div class="col-xs-12">
							<div class="text-center p-h-md">
								<div style="font-weight:400; font-size:25px">Logged in today @ <br/> <span style="color:#10c469"><?php echo ($dialer_logged_in_time!='' ? $dialer_logged_in_time : '') ?></span></div>
							</div>
						</div><!-- END column -->
						
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
		</div>
		
		
		
		<!-- Schedule -->
	
	
	<?php if($sch_date_range!=""){ ?>
	
	<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Your Schedule From <?php echo $sch_date_range; ?></h4>
						<h4 style="margin-top:5px;" class="widget-title">Schedule Time is in EST </h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									
										<th rowspan='2'>SL</th>
										<th rowspan='2'>Fusion ID</th> 
									    <th rowspan='2'>OM ID</th>
										<th rowspan='2'>Agent Name</th>
										
										<th rowspan='2'>Process</th>
										<th colspan='2'>Monday</th>
										<th colspan='2'>Tuesday</th>
										<th colspan='2'>Wednesday</th>
										<th colspan='2'>Thursday</th>
										<th colspan='2'>Friday</th>
										<th colspan='2'>Saturday</th>
										<th colspan='2'>Sunday</th>
								</tr>
								<tr class='bg-info'>	
										<th>In</th>
										<th>Out</th>
										<th>In</th>
										<th>Out</th>
										<th>In</th>
										<th>Out</th>
										<th>In</th>
										<th>Out</th>
										<th>In</th>
										<th>Out</th>
										<th>In</th>
										<th>Out</th>
										<th>In</th>
										<th>Out</th>
										
									</tr>
								</thead>
									
								<tbody>
								
								<?php
									$i=1;
									$pDate=0;
									foreach($sch_list as $user):
																		
								?>
									
									<tr>
										
										<td><?php echo $i++; ?></td>
										<td><?php echo $user['fusion_id']; ?></td>
										<td><?php echo $user['omuid']; ?></td>
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										
										<td><?php echo $user['process_name']; ?></td>
										
										<td><?php echo $user['mon_in']; ?></td>
										<td><?php echo $user['mon_out']; ?></td>
										<td><?php echo $user['tue_in']; ?></td>
										<td><?php echo $user['tue_out']; ?></td>
										<td><?php echo $user['wed_in']; ?></td>
										<td><?php echo $user['wed_out']; ?></td>
										<td><?php echo $user['thu_in']; ?></td>
										<td><?php echo $user['thu_out']; ?></td>
										<td><?php echo $user['fri_in']; ?></td>
										<td><?php echo $user['fri_out']; ?></td>
										<td><?php echo $user['sat_in']; ?></td>
										<td><?php echo $user['sat_out']; ?></td>
										<td><?php echo $user['sun_in']; ?></td>
										<td><?php echo $user['sun_out']; ?></td>
									</tr>
									
											
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
			
			
		</div><!-- .row -->
		
		<?php } ?>
		
		<div class="row">
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Activities (Last 7 Days)</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									
										<th>Date</th>
									    <!--
										<th>Team Leader</th>
										<th>Login Date</th> -->
										<th>Login Time</th>
										<th>Logout Time</th>
										<th>Logged In Hours</th>
										<th>Break Time </th>
										<th>Disposition</th>
										
									</tr>
								</thead>
								
								<tfoot>
									<tr class='bg-info'>
										<th>Date</th>
									    <!--
										<th>Team Leader</th>
										<th>Login Date</th> -->
										<th>Login Time</th>
										<th>Logout Time</th>
										<th>Logged In Hours </th>
										<th>Break Time </th>
										<th>Disposition</th>
										
									</tr>
								</tfoot>
	
								<tbody>
								
								
								<?php
								
									$pDate=0;
									foreach($login_details as $user):
									
									$cDate=$user['rDate'];
									$logged_in_hours=$user['logged_in_hours'];
									$tBrkTime=$user['tBrkTime'];
									$disposition=$user['disposition'];
									
									
									
									if($pDate!=$cDate){
										
										//if($pDate!=0) echo "<tr class=''><td colspan='13' class='bg-sep'></td></tr>";
										$pDate=$cDate;
									}
									
								?>
									
									<tr>
									
										<td><?php echo $user['rDate']; ?></td>
										
										
										<!--
										<td><?php //echo $user['asign_tl']; ?></td>
										 <td><?php //echo $user['login_date']; ?></td> -->
										 
										<td><?php echo $user['login_time']; ?></td>
										<td><?php echo $user['logout_time']; ?></td>
																			
										<td><?php echo $logged_in_hours; ?></td>
										
										<td><?php echo $tBrkTime; ?></td>
										
										<td><center><?php 
											if($logged_in_hours!="0") echo "P"; 
											else if($disposition!="") echo $user['disposition']; 
											else echo "MIA"; 
										?></center></td>
										
										
										
									</tr>
									
											
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
					
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->
		</div>
	</section>
</div>


