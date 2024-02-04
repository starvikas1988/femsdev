<!-- report -->

<div class="wrap">

<section class="app-content">
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Attendance Adherence</h4>
<center><h5 class="widget-title"><?php echo $error ?></h5></center>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">

<?php echo form_open('',array('method' => 'get')) ?>

<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label for="start_date">Start Date</label>
		<input type="text" class="form-control" id="gstart_date" value='<?php echo $start_date; ?>' name="start_date" required autocomplete="off">
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label for="end_date">End Date</label>
		<input type="text" class="form-control" id="gend_date" value='<?php echo $end_date; ?>' name="end_date" required autocomplete="off">
		</div>
	</div>
		
	<div class="col-md-3">
		<div class="form-group" id="foffice_div" >
			<label for="office_id">Select a Location</label>
			<select class="form-control" name="office_id" id="foffice_id" >
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
			<label for="client_id">Select a Department</label>
			<select class="form-control" name="dept_id" id="fdept_id" >
								
				<?php
				if(get_global_access()==1 || get_dept_folder()=="mis" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" ) echo "<option value='ALL'>ALL</option>";
				?>
				
				<?php foreach($department_list as $dept): ?>
					<?php
					$sCss="";
					if($dept['id']==$dept_id) $sCss="selected";
					?>
					<option value="<?php echo $dept['id']; ?>" <?php echo $sCss;?>><?php echo $dept['description']; ?></option>
					
				<?php endforeach; ?>
														
			</select>
		</div>
	</div>
	
</div>	

	
<div class="row">	

	<!--<div class="col-md-2">	
		<div class="form-group">
		<input type="submit" style='margin-top:4px;' class="btn btn-success btn-md" id='exportReports' name='exportReports' value="Export As Excel">
		</div>
	</div>-->
	
	<div class="col-md-1">
		<div class="form-group">
		<input type="submit" style='margin-top:2px;' class="btn btn-primary btn-md" id='showReports' name='showReports' value="View">
		</div>
	</div>
	
</div>

</form>

</div>
</div>
</div>
</div>







<?php if($dataViewType != "off"){ ?>

<div class="row">


<div class="col-md-12">
	<div class="widget">
		<header class="widget-header">
			<h4 class="widget-title">Adherence Report</h4>
		</header>
		<hr class="widget-separator">

		<div class="widget-body">
		
		<ul class="nav nav-tabs">
		  <li class="<?php if($showtype == 1){ echo "active"; } ?>"><a href="<?php echo base_url() .'attendance/adherence?' .$urlform; ?>&showtype=1">Login Adherence</a></li>
		  <li class="<?php if($showtype == 2){ echo "active"; } ?>"><a href="<?php echo base_url() .'attendance/adherence?' .$urlform; ?>&showtype=2">Auto-Loguot Count</a></li>
		  <li class="<?php if($showtype == 3){ echo "active"; } ?>"><a href="<?php echo base_url() .'attendance/adherence?' .$urlform; ?>&showtype=3">Staffed Time</a></li>
		</ul>
		
		
		<?php if($showtype==1){ ?>
		
			<div class="table-responsive">
				<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
					<thead>
						<tr class='bg-info'>
							<th>#</th>
							<th>Fusion ID</th>
							<th>Name</th>
							<th>Site</th>
							<th>Dept</th>
							<?php
							$date1 = new DateTime($start_date);
							$date2 = new DateTime($end_date);
							$days  = $date2->diff($date1)->format('%a');
							$hdate = new DateTime($start_date);
							for($i=1; $i<=$days+1; $i++){
							?>
							   <th>Roastered Login Time</th>
							   <th>Actual Login Time</th>
							   <th><?php echo $hdate->format('d-M-Y'); ?></th>
							<?php
								$hdate->modify('+1 day');
							}
							?>
							<th>Late Login Count</th>
						</tr>
					</thead>
					
					<tfoot>
						<tr class='bg-info'>
							<th>#</th>
							<th>Fusion ID</th>
							<th>Name</th>
							<th>Site</th>
							<th>Dept</th>
							<?php
							$date1 = new DateTime($start_date);
							$date2 = new DateTime($end_date);
							$days  = $date2->diff($date1)->format('%a');
							$hdate = new DateTime($start_date);
							for($i=1; $i<=$days+1; $i++){
							?>
							   <th>Roastered Login Time</th>
							   <th>Actual Login Time</th>
							   <th><?php echo $hdate->format('d-M-Y'); ?></th>
							<?php
							$hdate->modify('+1 day');
							}
							?>
							<th>Late Login Count</th>
						</tr>
					</tfoot>

					<tbody>
					<?php
					$ir = 0;
					$startdate = date('Y-m-d', strtotime($start_date));
					foreach($dayreport[$startdate] as $token){
						$sl++;
					?>
					<tr>
					<td><?php echo $sl; ?></td>
					<td><?php echo $token['fusion_id']; ?></td>
					<td><?php echo $token['fullname']; ?></td>
					<td><?php echo $token['office_id']; ?></td>
					<td><?php echo $token['department_name']; ?></td>
					<?php
					$latecount = 0;
					$bdate = new DateTime($start_date);	
					for($i=1; $i<=$days+1; $i++){
						
						//$search_row = array_search($token['user_id'], array_column($dayreport[$bdate->format('Y-m-d')],'user_id'));
						$set_user_array = $dayreport[$bdate->format('Y-m-d')][$ir];
						$interval = ""; $extrasign = ""; $colorclass = "";
						if(strlen($set_user_array['scheduled_login']) > 5)
						{
							//$d1= date_create($set_user_array['scheduled_login']); 
							//$d2= date_create($set_user_array['login_time_local']);
							/*$d1_date = new DateTime($set_user_array['scheduled_login']);
							$ds_start = $d1_date->diff(new DateTime($set_user_array['login_time_local']);
							echo $since_start->days.' days total<br>';
							echo $since_start->y.' years<br>';
							echo $since_start->m.' months<br>';
							echo $since_start->d.' days<br>';
							echo $since_start->h.' hours<br>';
							echo $since_start->i.' minutes<br>';
							echo $since_start->s.' seconds<br>';*/

							$t1 = strtotime( $set_user_array['scheduled_login'] );
							$t2 = strtotime( $set_user_array['login_time_local'] );
							
							if($t2 > $t1){
								$diff = abs($t2 - $t1);  
								$hours = floor($diff / (60*60));
								$minutes = floor(($diff - $hours*60*60)/ 60);
								$seconds = floor(($diff - $hours*60*60 - $minutes*60));
								$colorclass = "text-danger"; $extrasign = "-";
								$latecount++;
							}
							if($t1 > $t2){
								$diff = abs($t1 - $t2);  
								$hours = floor($diff / (60*60));
								$minutes = floor(($diff - $hours*60*60)/ 60);
								$seconds = floor(($diff - $hours*60*60 - $minutes*60));
							}
							
							
							if($hours > 0){ $s_Hour =  floor($hours); } else { $s_Hour =  "00"; }
							if($minutes > 0){ $s_Minutes =  floor($minutes); } else { $s_Minutes =  "00"; }
							if($seconds > 0){ $s_Seconds =  floor($seconds); } else { $s_Seconds =  "00"; }
							
							$interval = $extrasign .sprintf('%02d', $s_Hour) .":" .sprintf('%02d', $s_Minutes) .":" .sprintf('%02d',$s_Seconds);
						}
					
					?>
					<td><?php echo $set_user_array['scheduled_login']; ?></td>
					<td><?php echo $set_user_array['login_time_local']; ?></td>
					<td class="<?php echo $colorclass; ?>"><?php echo $interval; ?></td>
					<?php 
						$bdate->modify('+1 day');
					} 
					?>
					<td><?php echo $latecount; ?></td>
					<?php 
					$ir++;
					} 
					?>	
					</tbody>
				</table>
			</div>
			
		<?php } ?>	
			
			
		<?php if($showtype==2){ ?>	
			
			
			<div class="table-responsive">
				<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
					<thead>
						<tr class='bg-info'>
							<th>#</th>
							<th>Fusion ID</th>
							<th>Name</th>
							<th>Site</th>
							<th>Dept</th>
							<?php
							$date1 = new DateTime($start_date);
							$date2 = new DateTime($end_date);
							$days  = $date2->diff($date1)->format('%a');
							$hdate = new DateTime($start_date);
							for($i=1; $i<=$days+1; $i++){
							?>
							   <th><?php echo $hdate->format('d-M-Y'); ?></th>
							<?php
								$hdate->modify('+1 day');
							}
							?>
							<th>System Logout Count</th>
						</tr>
					</thead>
					
					<tfoot>
						<tr class='bg-info'>
							<th>#</th>
							<th>Fusion ID</th>
							<th>Name</th>
							<th>Site</th>
							<th>Dept</th>
							<?php
							$date1 = new DateTime($start_date);
							$date2 = new DateTime($end_date);
							$days  = $date2->diff($date1)->format('%a');
							$hdate = new DateTime($start_date);
							for($i=1; $i<=$days+1; $i++){
							?>
							   <th><?php echo $hdate->format('d-M-Y'); ?></th>
							<?php
								$hdate->modify('+1 day');
							}
							?>
							<th>System Logout Count</th>
						</tr>
					</tfoot>

					<tbody>
					<?php
					$ir = 0;
					$startdate = date('Y-m-d', strtotime($start_date));
					foreach($dayreport[$startdate] as $token){
						$sl++;
					?>
					<tr>
					<td><?php echo $sl; ?></td>
					<td><?php echo $token['fusion_id']; ?></td>
					<td><?php echo $token['fullname']; ?></td>
					<td><?php echo $token['office_id']; ?></td>
					<td><?php echo $token['department_name']; ?></td>
					<?php
					$logoutcount = 0; $showsystem = "";
					$bdate = new DateTime($start_date);	
					for($i=1; $i<=$days+1; $i++){
						$showsystem = "";
						//$search_row = array_search($token['user_id'], array_column($dayreport[$bdate->format('Y-m-d')],'user_id'));
						$set_user_array = $dayreport[$bdate->format('Y-m-d')][$ir];
						if($set_user_array['logout_by'] == 0){ $logoutcount++; $showsystem = "System Logout"; }
					?>
					<td><?php echo $showsystem; ?></td>
					<?php 
						$bdate->modify('+1 day');
					} 
					?>
					<td><?php echo $logoutcount; ?></td>
					<?php 
					$ir++;
					} ?>	
					</tbody>
				</table>
			</div>
			
			
			
			
		<?php } ?>
		
		
		
		<?php if($showtype==3){ ?>	
			
			
			<div class="table-responsive">
				<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
					<thead>
						<tr class='bg-info'>
							<th>#</th>
							<th>Fusion ID</th>
							<th>Name</th>
							<th>Site</th>
							<th>Dept</th>
							<?php
							$date1 = new DateTime($start_date);
							$date2 = new DateTime($end_date);
							$days  = $date2->diff($date1)->format('%a');
							$hdate = new DateTime($start_date);
							for($i=1; $i<=$days+1; $i++){
							?>
							   <th><?php echo $hdate->format('d-M-Y'); ?></th>
							<?php
								$hdate->modify('+1 day');
							}
							?>
							<th>Shortage Count</th>
						</tr>
					</thead>
					
					<tfoot>
						<tr class='bg-info'>
							<th>#</th>
							<th>Fusion ID</th>
							<th>Name</th>
							<th>Site</th>
							<th>Dept</th>
							<?php
							$date1 = new DateTime($start_date);
							$date2 = new DateTime($end_date);
							$days  = $date2->diff($date1)->format('%a');
							$hdate = new DateTime($start_date);
							for($i=1; $i<=$days+1; $i++){
							?>
							   <th><?php echo $hdate->format('d-M-Y'); ?></th>
							<?php
								$hdate->modify('+1 day');
							}
							?>
							<th>Shortage Count</th>
						</tr>
					</tfoot>

					<tbody>
					<?php
					$ir = 0;
					$startdate = date('Y-m-d', strtotime($start_date));
					foreach($dayreport[$startdate] as $token){
						$sl++;
					?>
					<tr>
					<td><?php echo $sl; ?></td>
					<td><?php echo $token['fusion_id']; ?></td>
					<td><?php echo $token['fullname']; ?></td>
					<td><?php echo $token['office_id']; ?></td>
					<td><?php echo $token['department_name']; ?></td>
					<?php
					$interval = ""; $shortagecount = 0;
					$bdate = new DateTime($start_date);	
					for($i=1; $i<=$days+1; $i++){
						//$search_row = array_search($token['user_id'], array_column($dayreport[$bdate->format('Y-m-d')],'user_id'));
						$set_user_array = $dayreport[$bdate->format('Y-m-d')][$ir];
						if((strlen($set_user_array['scheduled_login']) > 5) && (!empty($set_user_array['totaltime'])))
						{
							if($set_user_array['myinterval'] > $set_user_array['totaltime']){ $shortagecount++; }
						}
						//if($set_user_array['logout_by'] == 0){ $logoutcount++; $showsystem = "System Logout"; }
					?>
					<td><?php echo $set_user_array['totaltime']; ?></td>
					<?php 
						$bdate->modify('+1 day');
					} 
					?>
					<td><?php echo $shortagecount; ?></td>
					<?php 
					$ir++;
					} ?>	
					</tbody>
				</table>
			</div>
			
			
			
			
		<?php } ?>
			
		</div>
		
	</div>
</div>

	
</div>
<?php } ?>




		
</section>

</div>
