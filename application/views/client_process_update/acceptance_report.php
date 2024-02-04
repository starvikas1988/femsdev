
<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Process Update Acceptance By Users</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">

					 <form id="form_new_user" method="GET" action="<?php echo base_url('client_process_update/process_update_acceptance_report_list'); ?>">	
					 <?php echo form_open('',array('method' => 'get')) ?>
					
						<div class="row">
							<div class="col-md-3" >
								<div class="form-group" id="foffice_div">
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<?php
											if(get_global_access()==1) echo "<option value=''>ALL</option>";
										?>
										<?php foreach($location_list as $loc): ?>
											<?php
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
							</div>
							
							<!-- <div class="col-md-3">
								<div class="form-group">
									<label for="client_id">Select a Client</label>
									<select class="form-control" name="client_id" id="fclient_id" >
										<option value='ALL'>ALL</option>
										<?php foreach($client_list as $client): ?>
											<?php
											$sCss="";
											if($client['id']==$cValue) $sCss="selected";
											?>
											<option value="<?php echo $client['id']; ?>" <?php echo $sCss;?> ><?php echo $client['shname']; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
							</div> -->



														<div class="col-md-3">
								<div class="form-group">
									<label for="client_id">Select a Process</label>
									<select class="form-control" name="process_id" id="fprocess_id" >
										<option value=''>--Select-</option>
										<?php foreach($process_list as $process): ?>
											<?php
											$sCss="";
											if($process['id']==$cValue) $sCss="selected";
											?>
											<option value="<?php echo $process['id']; ?>" <?php echo $sCss;?> ><?php echo $process['shname']; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
							</div>
						</div>
					
					
						<div class="row">
						 	<input type="hidden" id="user_id" name="user_id" class="form-control" value="<?php echo get_user_id(); ?>">
						 
							<div class="col-md-8">
								<div class="form-group">
									<label>Process Update Title:</label>
									<select class="form-control" id="process_update_id" name="process_update_id" required>
										
										<?php /* foreach($get_process_update_title as $row):
										 
											$sCss="";
											$ia="";
											
											if($row['id']==$process_update_id) $sCss="selected";
											if($row['is_active']==0) $ia="[In-Active]"; */
										?>
											<!--<option value="<?php //echo $row['id']; ?>"  <?php //echo $sCss; ?> ><?php //echo $row['title']." - ".$row['off_loc']." - ".$row['client']; ?> <?php //echo $ia; ?></option>-->
										<?php //endforeach; ?>
									</select>
								</div>
							</div>
							
							<div class="col-md-2" style='margin-top:20px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>client_process_update/process_update_acceptance_report_list" type="submit" id='show' name='show' value="Show">Search</button>
								</div>
							</div>
							
							 <?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:35px;' class="col-md-2">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span> </a>		
									</div>
								</div>
							 <?php } ?>
							
						</div>
						
						</form>
						
						<?php if($process_update_id!=""){ ?>
							<div class="row">
								<span class='label label-default' style='font-size:12px;'>Following Users are accepted '<b style="font-size:16px"><?php echo $pu_title[0]['title']; ?></b>' Process Update</span>
							</div>
						<?php } ?>
						</br>
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Acceptance By</th>
										<th>Fusion ID</th>
										<th>EMPID/XPOID</th>
										<th>Office Location</th>
										<th>Designation</th>
										<th>Client</th>
										<th>Process</th>
										<th>Acceptance Date</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i=1;
										foreach($process_update_acceptance_list as $user):
										
										if($user['office_id']=='KOL'){
											$omuid=$user['xpoid'];
										}else{
											$omuid=$user['omuid'];
										}
									?>
									<tr>
												
										<td><?php echo $i++; ?></td>
										
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										<td><?php echo $user['fusion_id']; ?></td>
										<td><?php echo $omuid; ?></td>
										<td><?php echo $user['office_id']; ?></td>
										<td><?php echo $user['userRoleName']; ?></td>
										<td><?php echo $user['client_name']; ?></td>
										<td><?php echo $user['process_name']; ?></td>
										<td><?php echo $user['accptdate']; ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>