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
	}
	
	.modal-dialog{
		width:750px;
	}
	
</style>


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Evaluate Job Performance Evaluation Form</h4>
					</header>
					<hr class="widget-separator"/>
					
					<div class="widget-body clearfix">
					
						
						<?php //echo form_open('') ?>
						<?php 
							echo form_open('',array('method' => 'get'));
							
							$year = date("Y");
							$previousyear = $year -1;
							$cmonth=date('m');

						?>
						
						<div class="row">
							
							<div class="col-md-4">
							<div class="form-group">
								<label for="evaluation_period">Select Evaluation Period</label>
								<select class="form-control" name="evaluation_period" id="evaluation_period" >
									<option value='ALL'>ALL</option>
									<?php foreach($period_list as $period): ?>
										<?php
										$sCss="";
										if($period['value']==$epValue) $sCss="selected";
										?>
										<option value="<?php echo $period['value']; ?>" <?php echo $sCss;?>><?php echo $period['text']; ?></option>
										
									<?php endforeach; ?>
																			
								</select>
							</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="status_id">Select Status</label>
									<select class="form-control" name="status_id" id="status_id" >
										<option value='ALL'>ALL</option>
										<?php 
											if($sidValue==1) echo "<option value='1' selected >Not Evaluated</option>";
											else  echo "<option value='1'>Not Evaluated</option>";
											if($sidValue==2) echo "<option value='2' selected >Evaluated</option>";
											else  echo "<option value='2'>Evaluated</option>";											
											if($sidValue==3) echo "<option value='3' selected >Reviewed</option>";
											else  echo "<option value='3'>Reviewed</option>";
										?>
										
									</select>
								</div>
							</div>
								
						</div>
						
						<div class="row">
												
						
							<div class="col-md-3">
							<div class="form-group">
								<label for="dept_id">Select a Department</label>
								<select class="form-control" name="dept_id" id="fdept_id" >
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
							</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label for="sub_dept_id">Select a Sub Department</label>
								<select class="form-control" name="sub_dept_id" id="fsub_dept_id" >
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
								<label for="role">Select a Designation</label>
										<select class="form-control" name="role_id" required>
											<option value='ALL'>ALL</option>
											<?php foreach($role_list as $roll): ?>
												<?php
													$sCss="";
													if($roll->id==$rValue) $sCss="selected";
												?>
												<option value="<?php echo $roll->id; ?>" <?php echo $sCss;?> ><?php echo $roll->name; ?></option>
												
											<?php endforeach; ?>
											
										</select>
								</div>
							</div>
														
								<div class="col-md-2">
								<div class="form-group">
								<br>
								<input type="submit" class="btn btn-primary btn-md" id='showReports' name='showReports' value="Show">
								</div>
							</div>
						
							
					</div><!-- .row -->
					</form>
						
						
						<div class="row">
						
						<div class="table-responsive">
						
						<?php
							if(empty($perform_list)){
									echo '<div class="alert alert-info"> <b>No Record Found. </b></div>';	
							}else{
						?>
						
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Date</th>
										<th>Period</th>
										<th>Fusion ID</th>
										<th>Name</th>
										<th>Office</th>
										<th>Site</th>
										<th>Dept</th>
										<th>Sub Dept</th>
										<th>Role</th>
										<th>Process</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										<th>Date</th>
										<th>Period</th>
										<th>Fusion ID</th>
										<th>Name</th>
										<th>Office</th>
										<th>Site</th>
										<th>Dept</th>
										<th>Sub Dept</th>
										<th>Role</th>
										<th>Process</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</tfoot>
								<tbody>
								
								<?php 
									foreach($perform_list as $row): 
									
									$user_id=$row['user_id'];
									$eid=base64_encode($row['id']);
									
									$evaluated_by=$row['evaluated_by'];
									$review_by=$row['review_by'];
									$evaluation_period=$row['evaluation_period'];
									
								?>
									<tr>
										<td><?php echo $row['evaluation_date']; ?></td>
										<td><?php echo $row['evaluation_period']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname'] . " ". $row['lname']; ?></td>
										<td><?php echo $row['office_id']; ?></td>
										<td><?php echo $row['site_name']; ?></td>
										<td><?php echo $row['dept_name']; ?></td>
										<td><?php echo $row['sub_dept_name']; ?></td>
										<td><?php echo $row['role_name']; ?></td>
										<td><?php echo $row['process_name']." ".$row['sub_process_name']; ?></td>
										
										<td>
										<?php
											
											if($review_by!="") echo '<span class="label label-success">Reviewed</span>'; 
											else if($evaluated_by!="") echo '<span class="label label-primary">Evaluated</span>';
											else echo '<span class="label label-danger">Not Evaluated</span>';
											
										?>
										</td>
										<td width='100px;'>
																						
											<button title="View Evaluation Form" eid="<?php echo $eid;?>" type='button' class='viewEvaluation btn btn-info btn-xs'><i class='fa fa-eye' aria-hidden='true'></i></button>&nbsp;
											
											<?php
												if($evaluated_by=="")
													echo "<button title='Evaluate Job Performance Evaluation Form' eid='$eid' type='button' class='evaluateEvaluation btn btn-primary btn-xs'><i class='fa fa-file-text-o' aria-hidden='true'></i></button>&nbsp;";
													
												else if($review_by=="" && (get_role_dir()=="manager" || get_role_dir()=="admin" || get_role_dir()=="super" ))
													echo "<button title='review Job Performance Evaluation Form' eid='$eid' type='button' class='reviewEvaluation btn btn-success btn-xs'><i class='fa fa-file-text' aria-hidden='true'></i></button>&nbsp;";
													
											?>
											
										</td>
									</tr>
									
											
								<?php endforeach; ?>
										
								</tbody>
							</table>
							
							<?php
							}
							?>
						
						</div>
												
						</div>
						
					</div>
				</div>
			</div>
		</div><!-- .row -->
	</section>

</div><!-- .wrap -->
