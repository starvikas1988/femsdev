<style>
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	
	
</style>

<div class="wrap">
	<section class="app-content">
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					
					<div class="widget-body">
					<?php echo form_open('',array('method' => 'get')) ?>
					
						<div class="row">
							
							<div class="col-md-3">
								<div class="form-group" id="foffice_div">
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<?php
											if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
										?>
										<?php foreach($location_list as $loc): ?>
											<?php
											$sCss="";
											if($loc['abbr']==$oValue) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
							</div>
							
							<div class="col-md-3">
							<div class="form-group">
								<label for="dept_id">Select a Department</label>
								<select class="form-control" name="dept_id" id="fdept_id" >
									<?php if(count($department_list) > 1) { ?>
									<option value='ALL'>ALL</option>
									<?php } foreach($department_list as $dept): ?>
										<?php
										$sCss="";
										if($dept['id']==$dValue) $sCss="selected";
										?>
										<option value="<?php echo $dept['id']; ?>" <?php echo $sCss;?>><?php echo $dept['description']; ?></option>
										
									<?php endforeach; ?>
																			
								</select>
							</div>
										
						<!-- .form-group -->
						</div>
						
							<div class="col-md-2">
								<div class="form-group">
									<label for="client_id">Select a Client</label>
									<select class="form-control" name="client_id" id="fclient_id" >
										<option value='ALL'>ALL</option>
										<?php foreach($client_list as $client): ?>
											<?php
											$sCss="";
											if($client->id==$cValue) $sCss="selected";
											?>
											<option value="<?php echo $client->id; ?>" <?php echo $sCss;?>><?php echo $client->shname; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="process_id">Select a process</label>
									<select class="form-control" name="process_id" id="fprocess_id" >
										<option value='ALL'>ALL</option>
										<?php foreach($process_list as $process): ?>
											<?php
												$sCss="";
												if($process->id==$pValue) $sCss="selected";
											?>
											<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
								<br>
								<input type="submit" class="btn btn-primary btn-md" style='margin-top:4px;' id='showReports' name='showReports' value="Show">
								</div>
							</div>
							
						</div>
					</div>
					</form>
					
				</div>
			</div>	
		</div>
		
	
		<div class="row">
		
			<div class="col-sm-3">
				<a  href="<?php echo base_url()?>break_monitor/1?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<footer class="widget-footer" style="background-color:#713E41">
						<small>Users ON Break</small>
						<small class="pull-right"><b><?php echo $total_onbreak; ?></b></small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>
		
			<div class="col-sm-3">
				<a  href="<?php echo base_url()?>break_monitor/2?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<footer class="widget-footer bg-success">
						<small>Total Users Online</small>
						<small class="pull-right"><b><?php echo $total_online ?></b></small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>
			
			<div class="col-sm-3">
				<a  href="<?php echo base_url()?>break_monitor/3?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<footer class="widget-footer bg-danger">
						<small>Total Users Offline</small>
						<small class="pull-right"><b><?php echo $total_offline ?></b></small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>
			
			<div class="col-sm-3">
				<a  href="<?php echo base_url()?>break_monitor/4?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<footer class="widget-footer bg-primary">
						<small>Total Users</small>
						<small class="pull-right"><b><?php echo $total_agent; ?></b></small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>
			
		</div>
	
	
		<div class="row">
		
			<!-- DataTable -->
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">
							<?php 
								if($filter_id==1) echo "List of Users On Break"."  "."[".date('Y-m-d')."]";
								else if($filter_id==2) echo "List of Users Online"."  "."[".date('Y-m-d')."]";
								else if($filter_id==3) echo "List of Users Offline"."  "."[".date('Y-m-d')."]";
								else if($filter_id==4) echo "List of Total Users"."  "."[".date('Y-m-d')."]";
								else echo "List of Users On Break"."  "."[".date('Y-m-d')."]";
							?>
						</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
				
					<!--	<div style='float:right; margin-top:-35px; margin-right:10px;' class="col-md-4">
							<div class="form-group" style='float:right;'>
							<span style="cursor:pointer;padding:10px;" id='add_role' class="label label-primary"></span>
							</div>
						</div>	-->
													
					<div class="widget-body">
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th rowspan="2">SL</th>
										<th rowspan="2">Name</th>
										<th rowspan="2">Fusion ID</th>
										<!--<th rowspan="2">Location</th>-->
										<th rowspan="2">Client</th>
										<th rowspan="2">Process</th>
										<th rowspan="2">Assigned To</th>
										
										<?php if($filter_id!=3){ ?>
											<th rowspan="2">Logged IN</th>
											<th rowspan="2">Staff Time</th>
										<?php } ?>
										
										<th colspan="4">Other Break</th>
										<th colspan="4">Lunch/Dinner Break</th>
									</tr>
									<tr class="bg-info">
										<th>Break Start</th>
										<th>Break End</th>
										<th>Total Break</th>
										<th>Duration</th>
										
										<th>Break Start</th>
										<th>Break End</th>
										<th>Total Break</th>
										<th>Duration</th>
									</tr>
								</thead>
								
								
								<tbody>
									
									<?php $curr_datetime=date('Y-m-d h:i:sa');
									$i=1;
									foreach($user_list as $row):
									
										$office_id  = $row['office_id'];
										
										$oth_uid=$row['oth_uid'];
										$ld_uid=$row['ld_uid'];
										$last_logged_date=$row['last_logged_date'];
										
										if($row['is_logged_in']==1 && ($row['is_break_on']==1 || $row['is_break_on_ld']==1)){
											$text_color='color:#713E41; font-weight:bold';
											
											$logintime=strtotime($curr_datetime) - strtotime($last_logged_date);
											
											$loggedHour=gmdate("H:i:s", $logintime);
											
										}else if($row['is_logged_in']==1){
											$text_color='color:Green';
											
											$logintime=strtotime($curr_datetime) - strtotime($last_logged_date);
											
											$loggedHour=gmdate("H:i:s", $logintime);
											
										}else{
											$text_color='color:Red';
											$loggedHour="Offline";
										}
										
										$cnt_oth_uid=$row['cnt_oth_uid'];
										$cnt_oth_uid_org=$row['cnt_oth_uid'];
										
										if($row['is_break_on']==1){
											$last_break_oth_out_time=$row['last_break_oth'];
											$last_break_oth_in_time='On Break';
											$xy_oth="<i class='fa fa-plus'></i>";
											$text_cl1='color:#713E41; font-weight:bold';
											
											$oth_diff=strtotime($curr_datetime) - strtotime($last_break_oth_out_time);
											
											$total_oth_diff=gmdate("H:i:s", $oth_diff);
											$cnt_oth_uid++;
										}else{
											
											$last_break_oth_out_time=$row['oth_outtime'];
											$last_break_oth_in_time=$row['oth_intime'];
											
											$xy_oth="";
											$text_cl1='';
											$oth_diff=$row['total_oth_diff'];
											
											$total_oth_diff=gmdate("H:i:s", $oth_diff);
											
											if($total_oth_diff=="00:00:00"){
												$total_oth_diff="";
											}else{
												$total_oth_diff=$total_oth_diff;
											}
											
										}
										
										$cnt_ld_uid=$row['cnt_ld_uid'];
										$cnt_ld_uid_org=$row['cnt_ld_uid'];
										
										
										if($row['is_break_on_ld']==1){
											$last_break_ld_out_time=$row['last_break_ld'];
											$last_break_ld_in_time='On Break';
											$xy_ld="<i class='fa fa-plus'></i>";
											$text_cl='color:#713E41; font-weight:bold';
											$ld_diff=strtotime($curr_datetime) - strtotime($last_break_ld_out_time);
											$total_ld_diff=gmdate("H:i:s", $ld_diff);
											$cnt_ld_uid++;
										}else{
											$last_break_ld_out_time=$row['ld_outtime'];
											$last_break_ld_in_time=$row['ld_intime'];
											$xy_ld="";
											$text_cl='';
											$ld_diff=$row['total_ld_diff'];
											$total_ld_diff=gmdate("H:i:s", $ld_diff);
											
											if($total_ld_diff=="00:00:00"){
												$total_ld_diff="";
											}else{
												$total_ld_diff=$total_ld_diff;
											}
											
										}
																												
										$todayStaffTime = gmdate("H:i:s", $row['todayStaffTime']);
										$todayLoginTime = ConvServerToLocalAny($row['todayLoginTime'], $office_id);
										
										if($todayStaffTime=="00:00:00"){
											$todayStaffTime="";
											$todayLoginTime="";
											$cnt_ld_uid=0;
											$cnt_ld_uid_org="";
											$cnt_oth_uid=0;
											$cnt_oth_uid_org="";
											$last_break_oth_out_time="";
											$last_break_oth_in_time="";
											$total_oth_diff="";
											$last_break_ld_out_time="";
											$last_break_ld_in_time="";
											$total_ld_diff="";
										}
										
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td width="120px"><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<!--<td><?php //echo $row['office_id']; ?></td>-->
										<td><?php echo $row['client_name']; ?></td>
										<td width="100px"><?php echo $row['process_name']; ?></td>
										<td width="120px"><?php echo $row['assigned_name']; ?></td>
										
										<?php if($filter_id!=3){ ?>
											<td style="<?php echo $text_color; ?>" ><?php echo $todayLoginTime ; ?></td>
											<td style="<?php echo $text_color; ?>" ><?php echo $todayStaffTime; ?></td>
										<?php } ?>
										
										<td><?php echo $last_break_oth_out_time; ?></td>
										<td style="<?php echo $text_cl1; ?>"><?php echo $last_break_oth_in_time; ?></td>
										
										<?php if($cnt_oth_uid>1){ ?>
											<td><button title='Other Break Details' oth_uid='<?php echo $oth_uid; ?>' type='button' class='othUserId btn btn-default btn-xs'><?php echo $row['cnt_oth_uid']." ".$xy_oth ; ?></button></td>
										<?php }else{ ?>	
											<td style="font-size:13px"><?php echo $cnt_oth_uid_org; ?></td>
										<?php } ?>	
										
										<td><?php echo $total_oth_diff; ?></td>
										
										<td><?php echo $last_break_ld_out_time; ?></td>
										<td style="<?php echo $text_cl; ?>"><?php echo $last_break_ld_in_time; ?></td>
										
										<?php if($cnt_ld_uid>1){ ?>
											<td><button title='LD Break Details' ld_uid='<?php echo $ld_uid; ?>' type='button' class='ldUserId btn btn-default btn-xs'><?php echo $row['cnt_ld_uid']." ".$xy_ld ; ?></button></td>
										<?php }else{ ?>
											<td style="font-size:13px"><?php echo $cnt_ld_uid_org; ?></td>
										<?php } ?>
										
										<td><?php echo $total_ld_diff; ?></td>
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
	
	
		
		
		
		
		
	</section>
	
</div><!-- .wrap -->

<!------------------------------------------------------------------------------------------->

<div class="modal fade" id="modalOthUserBreak" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
		
		<form class="frmOthUserBreak" method='POST' onsubmit="return false" >
			
			<div class="modal-header">
				<h4 class="modal-title" id="addRoleLabel">Other Break Details <?php echo "(".date('Y-m-d').")"; ?></h4>
			</div>
			
			<div class="modal-body">
				<input type="hidden" id="oth_uid" name="oth_uid">
				
				<div class="table-responsive" id="othBrk">	</div>
				
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			
		</form>	
	</div>
   </div>
</div>


<div class="modal fade" id="modalLDUserBreak" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
		<form class="frmLDUserBreak" method='POST' onsubmit="return false" >
			
			<div class="modal-header">
				<h4 class="modal-title" id="addRoleLabel">Lunch/Dinner Break Details <?php echo "(".date('Y-m-d').")"; ?></h4>
			</div>
			
			<div class="modal-body">
				<input type="hidden" id="ld_uid" name="ld_uid">
				
				<div class="table-responsive" id="ldBrk">	</div>
				
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			
		</form>	
	</div>
   </div>
</div>

