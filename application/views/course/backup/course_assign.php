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
		padding:2px;
	}
	.lbl_chk_all{
		padding:0px 5px;
		background-color:#ddd;
	}
	
	.lbl_chk{
		padding:0px 5px;
	}
	
	.updateRows{
		background-color:#ADEBAD;
	}
	
</style>

	<div class="wrap">
	<section class="app-content">
	
	<div class="row">
		<div class="col-md-12">
		<div class="widget">

		<header class="widget-header">
			<h4 class="widget-title">Select a View</h4>
		</header>
		
		<hr class="widget-separator"/>
		<div class="widget-body clearfix">
					
	
	
	<?php echo form_open('',array('method' => 'get')) ?>
	
		<div class="row">
		
		<div class="col-md-2">
			
			<div class="form-group" >
				<label for="office_id">Select a Location</label>
				<select class="form-control" name="office_id" id="foffice_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($location_list as $loc): ?>
						<?php
						$sCss="";
						if($loc['abbr']==$oValue) $sCss="selected";
						?>
					<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
			
		<!-- .form-group -->
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
				<label for="dept_id">Select a Department</label>
				<select class="form-control" name="dept_id" id="dept_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($department_list as $dept): ?>
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
		
		<div class="col-md-3">
			<div class="form-group">
				<label for="sub_dept_id">Select a Sub Department</label>
				<select class="form-control" name="sub_dept_id" id="sub_dept_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($sub_department_list as $sub_dept): ?>
						<?php
						$sCss="";
						if($sub_dept['id']==$sdValue) $sCss="selected";
						?>
						<option value="<?php echo $sub_dept['id']; ?>" <?php echo $sCss;?>><?php echo $sub_dept['name']; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
						
		<!-- .form-group -->
		</div>
		
		<div class="col-md-3">
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
		<!-- .form-group -->
		</div>
		
		</div>
		
		<div class="row">
		
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
		<!-- .form-group -->
		</div>
		
		<div class="col-md-2" style='display:none'>
			<div class="form-group">
			<label for="sub_process_id">Select a sub process</label>
			<select class="form-control" name="sub_process_id" id="fsub_process_id" >
				<option value='ALL'>ALL</option>
				<?php foreach($sub_process_list as $sub_process): ?>
					<?php
						$sCss="";
						if($sub_process->id==$spValue) $sCss="selected";
					?>
					<option value="<?php echo $sub_process->id; ?>" <?php echo $sCss;?> ><?php echo $sub_process->name; ?></option>
					
				<?php endforeach; ?>
				
			</select>
			</div>
		<!-- .form-group -->
		</div>
		
		<div class="col-md-3" id="" >
			<div class="form-group">
				<label for="role">Select TL/Trainer</label>
				<select class="form-control" name="assigned_to" id="assigned_to">
					<option value='ALL'>ALL</option>
					<?php foreach($tl_list as $tl): 
						$sCss="";
						if($tl->id==$aValue) $sCss="selected";
						
					?>
					<option value="<?php echo $tl->id ?>" <?php echo $sCss;?> ><?php echo $tl->tl_name ?></option>
					<?php endforeach; ?>
															
				</select>
			</div>
		<!-- .form-group -->
		</div>
		
		<div class="col-md-2">
			<div class="form-group">
				<label>Fusion ID</label>
				<input type="text" id="fusionid" name="fusionid" value="<?php echo $fusionid; ?>" class="form-control">
			</div>
		</div>
		
		
		<div class="col-md-2">
			<div class="form-group">
			<br>
			<input type="submit" class="btn btn-primary btn-md" style='margin-top:4px;' id='showReports' name='showReports' value="Show">
			</div>
		</div>
		
		
		</div><!-- .row -->
		
		</form>
		
		
		</div>
		</div>
		</div>
	</div><!-- .row -->
	
	
	

		
		<div class="row">
			
			<!--<div class="<?php echo $colClass;?>">
				<a  href="<?php echo base_url()?>super/dashboard/1?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $total_agent; ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Total Users</small>
					</footer>
				</div>
				</a>
			</div>-->
			
	</div><!-- .row -->
		
	
		
	<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<div class="row" style="padding-top:10px;">
					<div class="col-md-4">
					<header class="widget-header">
						<h4 class="widget-title">
						<?php
						$ofValue="";
						if($oValue!="ALL"){
							$ofValue=$oValue;
						}
						
							if($filter_id==1) echo "Total Users"." (".$ofValue.")";
							else if($filter_id==2) echo "Total Users Online"." (".$ofValue.")";
							else if($filter_id==3) echo "Total Users Offline"." (".$ofValue.")";
							else if($filter_id==4) echo "Total Users On Leave"." (".$ofValue.")";
							else if($filter_id==5) echo "Manage NCNS Termination"." (".$ofValue.")";
							else if($filter_id==6) echo "Manage Termination"." (".$ofValue.")";
							else if($filter_id==7) echo "Manage Suspended User"." (".$ofValue.")";
							else if($filter_id==8) echo "Total Scheduled Users on Today"." (".$ofValue.")";
							else if($filter_id==9) echo "Total Users on Break Now"." (".$ofValue.")";
							else echo "List Of MIA Users";
						?>
						
												
						</h4>
					</header><!-- .widget-header -->
					</div>
					
						<?php if($filter_id=="" && is_access_operations_module() ){ ?>
						
						
						<div style="float:right; margin-right:10px;" class="col-md-1" >
							<div class="form-group">
								<button type="button" class="btn btn-primary" >Assign</button>
							</div>
						<!-- .form-group -->
						</div> 
						
						<div style="float:right; " class="col-md-2" >
							<div class="form-group">
								<select id="" name=""  class="form-control">
									<?php foreach($course_detail as $course) :?>
										<option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						<!-- .form-group -->
						</div>
						
						<div style="float:right; " class="col-md-1" >
							<div class="form-group">
								<label for="" >Course List : </label>
							</div>
						<!-- .form-group -->
						</div>
						<?php } ?>
						
					</div>
					
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<?php if($filter_id=="" && is_access_operations_module() ){ ?>
										<th><label class="lbl_chk_all"><input type="checkbox" class="check_all"/></label></th>
										<?php } ?>
										
										<th>SL</th>
										<th>Fusion ID</th>
										<th>UserID/XPOID</th>
										<th>Agent</th>
										<th>Dept</th>
										<th>Client</th>
										<th>Office</th>
										<!-- <th>Site</th> -->
										<th>Designation</th>
										<th>Process</th>
										<th>Assigned To</th>
										<th>Action</th>
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										<?php if($filter_id=="" && is_access_operations_module()){ ?>
										<th><label class='lbl_chk_all'><input type="checkbox" class="check_all"/></label></th>
										<?php } ?>
										
										<th>SL</th>
										<th>Fusion ID</th>
										<th>UserID/XPOID</th>
										<th>Agent</th>
										<th>Dept</th>
										<th>Client</th>
										<th>Office</th>
										<!-- <th>Site</th> -->
										<th>Designation</th>
										<th>Process</th>
										<th>Assigned To</th>
										<th>Action</th>
									</tr>
								</tfoot>
	
								<tbody>
								
								<?php 
									$i=1;
									foreach($user_list as $user): 
									$user_id=$user['id'];
									
									if($user['office_id']=='KOL'){
										$omuid=$user['xpoid'];
									}else{
										$omuid=$user['omuid'];
									}
									
									
									if(isset($user['action_status'])) $action_status=$user['action_status'];
									else $action_status="";
								?>
									<tr>
										<?php if($filter_id=="" && is_access_operations_module()){ ?>
										<td>
										<label class='lbl_chk'><input type="checkbox" class="check_row" name='sel_uids' value="<?php echo $user_id;?>" /></label>
										</td>
										<?php } ?>
										
										<td><?php echo $i++; ?></td>
										<td><?php echo $user['fusion_id']; ?></td>
										<td><?php echo $omuid; ?></td>
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										<td><?php echo $user['dept_name']; ?></td>
										<td><?php echo $user['client_name']; ?></td>
										<td><?php echo $user['office_id']; ?></td>
										<!-- <td><?php //echo $user['site_name']; ?></td> -->
										<td><?php echo $user['role_name']; ?></td>
										<td><?php echo $user['process_name'] /*. " ".$user['sub_process_name']*/; ?></td>
												
										<?php 
										
											
												
													$client_id=$user['client_ids'];
													
													echo "<td>".$user['asign_tl']."</td>";
												
													$assigned_tl=$user['assigned_to'];
													
													$_role_id=$user['role_id'];
													$_is_logged_in=$user['is_logged_in'];
													$_status=$user['status'];
													
													
																								
													$disposition_id=$user['disposition_id'];
													$disp_name=$user['disp_name'];
													
													if($disposition_id==1) $bclass="label-default";
													else if( $disposition_id==2) $bclass="label-danger";
													else if($disposition_id==3 ) $bclass="label-warning";
													else if($disposition_id==4 ) $bclass="label-primary";
													else $bclass="label-info";
													
													 
																									
												echo '<td width="150px">';
												
													echo "<button uid='$user_id' cid = '$client_id' disp_id='$disposition_id' type='button' class='editDisposition btn btn-primary btn-xs'>Assign UserID/XPOID</button>&nbsp;";
														
															
													  $ufusion_id=$user['fusion_id'];
																
																 
																 
												echo '</td>';
												
											
											
											?>
										
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
	
	
	





	
	
	
</div><!-- .wrap -->