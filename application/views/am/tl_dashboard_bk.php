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
	td{
		font-size:12px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
		vertical-align:middle;
	}
	.lbl_chk_all{
		padding:0px 5px;
		background-color:#ddd;
	}
	
	.lbl_chk{
		padding:0px 5px;
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
					</div> <!-- widget-body -->
					
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
			
			<div class="col-md-3">
				<a  href="<?php echo base_url()?>tl/dashboard/1?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $total_agent; ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Total Agents</small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>

			<div class="col-md-3">
				<a  href="<?php echo base_url()?>tl/dashboard/2?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo $total_online ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-success">
						<small>Total Agents Online</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			

			<div class="col-md-3">
				<a  href="<?php echo base_url()?>tl/dashboard/3?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo $total_offline ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-danger">
						<small>Total Agents Offline</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
						
			<div class="col-md-3">
				<a  href="<?php echo base_url()?>tl/dashboard/4?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo $total_leave ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-warning">
						<small>Total Agents On Leave</small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>
			
		</div><!-- .row -->
		
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
					
					<div class="widget">
				
					<div class="widget-body clearfix">
					
						<div class="row" style="padding-top:10px;">
						<div class="col-md-4">
							<h4 class="widget-title">
							
							<?php
							if($filter_id==1) echo "Total Agents";
							else if($filter_id==2) echo "Total Agents Online";
							else if($filter_id==3) echo "Total Agents Offline";
							else if($filter_id==4) echo "Total Agents On Leave";
							else echo "List Of Agents With MIA";
						?>
							</h4>
						</div>
						
						<?php if($filter_id==""){ ?>
						
						<div style="" class="col-md-4" >
							<div class="form-group">
							<select class="form-control" name="combo_disposition" id="combo_disposition" >
								<option value=''>Select a Disposition For Bulk Change</option>
								<?php foreach($disp_list as $disp): ?>
									<?php
										$sCss="";
										if($disp->id!=5 && $disp->id!=6) continue;
										//if($disp->id==$dValue) $sCss="selected";
									?>
									<option value="<?php echo $disp->id; ?>" <?php echo $sCss;?> ><?php echo $disp->description; ?></option>
									
								<?php endforeach; ?>
																		
							</select>
							</div>
						<!-- .form-group -->
						</div>
						<?php } ?>
						
						<div class="col-md-4" style="float:right;">
							<?php echo form_open('',array('method' => 'get')) ?>
							
							<div class="col-md-8" id="process_div" >
								<div class="form-group">
								<select class="form-control" name="process_id" id="process_id" >
									<option value='ALL'>--Select a Process--</option>
									<?php foreach($process_list as $process): ?>
										<?php
											$sCss="";
											if($process->id==$pValue) $sCss="selected";
										?>
										<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
										
									<?php endforeach; ?>
																			
								</select>
								</div>
							<!-- .form-group -->
							</div>
						
							<div class="col-md-1">
							<div class="form-group">
							<input type="submit" class="btn btn-primary btn-md" id='showReports' name='showReports' value="Show">
							</div>
							</div>
							</form>
						</div>
												
			        </div>
					
					<hr class="widget-separator">
					<div class="widget-body">
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<?php if($filter_id=="" && is_access_operations_module()){ ?>
										<th><label class="lbl_chk_all"><input type="checkbox" class="check_all"/></label></th>
										<?php } ?>									
									    <th>Fusion ID</th>
										<th>OM ID</th>
										<th>Agent</th>
										<th>Office</th>
										<th>Site</th>
										<th>Role</th>
										<th>Process</th>
										
										<?php if($filter_id==2 || $filter_id==3){ ?>
										<th>Logged In</th>
										<?php } ?>
										<?php if($filter_id!=2){ ?>
										<th>Status</th>
											<?php if($filter_id!=4){ ?>
											<th>Action</th>
											<?php } ?>
										<?php } ?>
										
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										<?php if($filter_id=="" && is_access_operations_module()){ ?>
										<th><label class="lbl_chk_all"><input type="checkbox" class="check_all"/></label></th>
										<?php } ?>
										<th>Fusion ID</th>
										<th>OM ID</th>
										<th>Agent</th>
										<th>Office</th>
										<th>Site</th>
										<th>Role</th>
										<th>Process</th>
										
										<?php if($filter_id==2 || $filter_id==3){ ?>
										<th>Logged In</th>
										<?php } ?>
										<?php if($filter_id!=2){ ?>
										<th>Status</th>
											<?php if($filter_id!=4){ ?>
											<th>Action</th>
											<?php } ?>
										<?php } ?>
										
									</tr>
								</tfoot>
	
								<tbody>
								
								<?php foreach($user_list as $user): 
								
									$user_id=$user['id'];
									
									if(isset($user['action_status'])) $action_status=$user['action_status'];
									else $action_status="";
									
								?>
								
									<tr>
										<?php if($filter_id=="" && is_access_operations_module()){ ?>
										<td>
										<label class='lbl_chk'><input type="checkbox" class="check_row" name='sel_uids' value="<?php echo $user_id;?>" /></label>
										</td>
										<?php } ?>
										
										<td><?php echo $user['fusion_id']; ?></td>
										<td><?php echo $user['omuid']; ?></td>
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										<td><?php echo $user['office_id']; ?></td>
										<td><?php echo $user['site_name']; ?></td>
										<td><?php echo $user['role_name']; ?></td>
										<td><?php echo $user['process_name']; ?></td>
																				
										<?php
										
											$_role_id=$user['role_id'];
											$_is_logged_in=$user['is_logged_in'];
											$_status=$user['status'];
											
											$_loggedHour=$user['loggedHour'];
											
											$disposition_id=$user['disposition_id'];
											$disp_name=$user['disp_name'];
											
											if($disposition_id==1) $bclass="label-default";
											else if( $disposition_id==2) $bclass="label-danger";
											else if($disposition_id==3 ) $bclass="label-warning";
											else if($disposition_id==4 ) $bclass="label-primary";
											else $bclass="label-info";
											
											$tLtime=$user['tLtime'];
											
											if($filter_id==2 || $filter_id==3){
												if($_is_logged_in==1) echo '<td><span class="label label-success">'.$_loggedHour.' Hrs.</span></td>';
												else if($tLtime!="") echo '<td><span class="label label-success">'.$tLtime.' Hrs.</span></td>';
												else echo '<td>-</td>';
											}
											
											if($filter_id!=2){
												if($_is_logged_in==1) echo '<td>-</td>';
												else if($_is_logged_in!=1 && $tLtime!="") echo '<td><span class="label label-success">P</span></td>';
												else{
													if($filter_id==4) echo '<td><span class="label '.$bclass.'">'.$disp_name. ' ('.$user['start_date']. '-'.$user['end_date'].') </span></td>';
													else echo '<td><span class="label '.$bclass.'">'.$disp_name.'</span></td>';
												}
											}
											
										?>
										
										<td>
											<?php
											
											if(is_access_operations_module()){
											
												if($disposition_id==1 && $tLtime==""){
													
													if($action_status=="P")
														echo "<button title='Disable For NCNS Term Request' type='button' class='btn btn-default btn-xs'>Edit Status</button>&nbsp;";
													else 
														echo "<button uid='$user_id' disp_id='$disposition_id' type='button' class='editDisposition btn btn-primary btn-xs'>Edit Status</button>&nbsp;";
													}
												
												//if($_is_logged_in==1 && $_loggedHour>9)  echo "<button uid='$user_id' type='button' class='btn btn-danger btn-xs'>Force Logout</button>";
											}
											
											?>
											
										</td>
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
						
	</section> <!-- #dash-content -->
	
<!-- Model bootstrap-->
<div class="modal fade" id="sktModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 
	  
	<form class="editDisp" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Status</h4>
      </div>
      <div class="modal-body">
					
			<input type="hidden" class="form-control" id="uid" name="uid" required>
			
			<div class="form-group">
			<label for="role">Select a Status</label>
				<select class="form-control" name="event_master_id" id="event_master_id" required>
					<option value=''>-- Select a Status --</option>
					<?php foreach($disp_list as $disp): ?>
						<option value="<?php echo $disp->id ?>"><?php echo $disp->description ?></option>
					<?php endforeach; ?>									
				</select>
			</div>
			
			<div class="form-group" id='div_kterms_date' style="display:none;">
					<label for="kterms_date">Termination Date:</label>
					<input type="text" class="form-control" id="kterms_date" placeholder="Enter Termination Date" name="kterms_date" required>
			</div>
			
			<div class="form-group" id='div_start_date' >
				<label id='lbl_start_date' for="name">Date (mm/dd/yyyy)</label>
				<input type="text" class="form-control" id="start_date" value='' name="start_date" required>
			</div>
			
						
			<div class="form-group" id='div_end_date'>
				<label for="name">End Date(mm/dd/yyyy)</label>
				<input type="text" class="form-control" id="end_date" value='' name="end_date" >
			</div>
			
			<div class="form-group" id='div_ticket_no'>
				<label for="ticket_no">Ticket No If Any:</label>
				<input type="text" class="form-control" placeholder="Enter Ticket No" name="ticket_no">
			</div>
			
			<div class="form-group">
			
				<label for="name">Comment</label>
				<input type="text" class="form-control" id="remarks" value='' name="remarks" >
				
			</div>
						
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='updateDisp' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>
	
</div><!-- .wrap -->