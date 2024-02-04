
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	
	#show{
		margin-top:5px;
	}
	
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
		padding:3px;
	}
	
	.modal-dialog{
		width:800px;
	}
</style>

<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Employee</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="" autocomplete="off">
							<div class="row">

								<div class="col-md-4"> 
									<div class="form-group">
										<label>Location</label>
										
										<select class="form-control" name="location" id="location" required>
											<?php foreach ($location_data as $key => $value) { ?>
												<option <?php if($location == $value['abbr']) echo 'selected'; ?> value="<?php echo $value['abbr']; ?>"><?php echo $value['office_name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-md-4"> 
									<div class="form-group">
										<label for="dept_id">Select Department</label>
											<select class="form-control" name="dept_id" id="dept_id" required>
												<option value='all'>All</option>
												<?php  foreach($department_list as $dept):
													echo "<option value='".$dept['id']."'>".$dept['description']."</option>";
												endforeach; ?>											
											</select>
									</div>
								</div>


								<div class="col-md-4"> 
									<div class="form-group">
										<label>From Date</label>
										
										<input class="form-control" type="text" name="from_date" id="issu_date" value="<?php echo $from_date ?>">
									</div>
								</div>
								<div class="col-md-4"> 
									<div class="form-group">
										<label>To Date</label>
										
										<input class="form-control" type="text" name="to_date" id="review_date" value="<?php echo $to_date ?>">
									</div>
								</div>	

								
								
								<div class="col-md-12" style="margin-top:20px">
									<input name="search" class="btn btn-success waves-effect" type="submit" value="Search">
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
		<?php if(isset($searched)){ if(!empty($details)){ ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Search Details</h4>
						<?php if($download_link != ""){ ?>
							<a href="<?php echo $download_link ?>" class="btn btn-warning waves-effect" style="float: right;">Download Full Report</a>
						<?php } ?>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">


							<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>Name</th>
										<th>Fusion ID</th>
										<th>Designation</th>	
										<th>Department</th>
										<th>Process</th>
										<th>Location</th>
										<th>L1 Supervisor</th>
										<th>Gross Pay</th>
										<th>Effected From</th>
										<th>Appraisal Letter</th>
									</tr>
								</thead>
								<tbody>
								<?php 

								// print_r($details);
								foreach($details as $key => $token){ 								
								?>
								<tr>

									<td><?php echo $token['fullname']; ?></td>
									<td><?php echo $token['fusion_id']; ?></td>	
									<td><?php echo $token['role']; ?></td>							
									<td><?php echo $token['department']; ?></td>	
									<td><?php echo $token['process_name']; ?></td>
									<td><?php echo $token['office_name']; ?></td>	
									<td><?php echo $token['l1_super']; ?></td>
									<td><?php echo $token['gross_pay']; ?></td>	
									<td><?php echo $token['affected_from']; ?></td>
									<td>
										<?php 
											$appr_id =$token['id'];
											// $warned_user_id =$token['warned_id'];
											// $warn_levl =$token['warning_level'];
											// $directory_check = "hr_letters";
											// $file_url = base_url() ."/temp_files/" .$directory_check ."/" .$token['filename'];
											// $icon_url = getIconUrl($token['filename'], $directory_check);
											// $now = date_create(date("Y-m-d H:i:s")); 
											// $replydue = new DateTime($token['added_date']);
											// $timetoreply = date_diff($replydue, $now);

											// echo $timetoreply_hours = $timetoreply->days * 24 + $timetoreply->h;
											// $timetoreply_hours.':'.$timetoreply->format('%I');
											// $date1 = $token['added_date'];
											// $date2 = date("Y-m-d H:i:s");
											// $timestamp1 = strtotime($date1);
											// $timestamp2 = strtotime($date2);
											// $hour = abs($timestamp2 - $timestamp1)/(60*60);
											 ?>
								  		
											<a href='<?php echo base_url()."appraisal_employee/send_mail/Y/$appr_id/Y" ?>' title='Download Appraisal Letter' class='btn btn-primary btn-xs'><i class='fa fa-download' aria-hidden='true'></i>
											</a>
											<!-- <?php if($hour <=24) { ?>
											<a href='<?php echo base_url()."warning_mail_employee/edit_warning/$warned_user_id" ?>' title='Edit' class='btn btn-success btn-xs'><i class='fa fa-pencil' aria-hidden='true'></i>
											</a>
										<?php } ?> -->
								  	</td>	
								</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<tr class='bg-info'>
										<th>Name</th>
										<th>Fusion ID</th>
										<th>Designation</th>	
										<th>Department</th>
										<th>Process</th>
										<th>Location</th>
										<th>L1 Supervisor</th>	
										<th>Gross Pay</th>
										<th>Effected From</th>
										<th>Appraisal Letter</th>							
									</tr>
									</tr>
								</tfoot>
							</table>
						
						</div>
					</div>
				</div>
			</div>
		</div>




<?php }else{ ?>
							<div class="col-md-12 text-center">
								<br><br>
								<h4 class="heading-white-title"><span class="text-danger">No Data Found</span></h4>
							<br>
							</div>
						<?php } } ?>
		
	</section>
</div>


<!-- 
<div class="modal fade" id="viewdocsmodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:800px;">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="show_docs">
						
					</div>
				</div>
			</div>
			<div class="row" style="margin-left:8px" id="req_details">
				
			</div>
			
			</br></br>
			
      </div>
    </div>
  </div>
</div> -->

