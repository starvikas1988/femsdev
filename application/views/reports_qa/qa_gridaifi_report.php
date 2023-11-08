
<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">GRID AIFI </h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('reports_qa/qa_gridaifi_report'); ?>">	
						  <?php //echo form_open('',array('method' => 'get')) ?>
						  
							<div class="col-md-4">
								<div class="form-group">
									<label>Search Date From -(mm/dd/yyyy)</label>
									<input type="text" id="from_date" name="date_from" onchange="date_validation(this.value,'S')" onkeydown="return false;" value="<?php $date= mysql2mmddyy($date_from); echo str_replace('-', '/', $date); ?>" class="form-control">
										<span class="start_date_error" style="color:red"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Search Date To -(mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="date_to" onchange="date_validation(this.value,'E')"  onkeydown="return false;"  value="<?php $date= mysql2mmddyy($date_to); echo str_replace('-', '/', $date); ?>" class="form-control">
										<span class="end_date_error" style="color:red"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<option value='All'>ALL</option>
										<?php foreach($location_list as $loc): 
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>				
						</div>
						<div class="row">
							<div class="col-md-4"> 
									<div class="form-group">
										<label>Select Campaign</label>
										<select class="form-control" name="campaign" required>
										<option value="">--Select--</option>
										<option <?php echo $campaign =='grid_aifi'?"selected":""; ?> value="grid_aifi">Grid Aifi</option>
										<option <?php echo $campaign =='aifi'?"selected":""; ?> value="aifi">Aifi</option>
									</select>
									</div>
								</div> 
							<div class="col-md-4">
								<div class="form-group">
									<label>Select Audit Type</label>
									<select class="form-control" id="" name="audit_type">
										<option value='All'>ALL</option>
										<option <?php echo $audit_type=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
										<option <?php echo $audit_type=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
										<option <?php echo $audit_type=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
										<option <?php echo $audit_type=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
										<option <?php echo $audit_type=='Certification Audit'?"selected":""; ?> value="Certification Audit">Certification Audit</option>
										<?php if(get_login_type()!="client"){ ?>
											<option <?php echo $audit_type=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
											<option <?php echo $audit_type=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary blains-effect" a href="<?php echo base_url()?>reports_qa/qa_gridaifi_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:25px;' class="col-md-2">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
									</div>
								</div>
							<?php } ?>
							
						  </form>
						</div>
						
						
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Total Score</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($qa_gridaifi_list as $row){ ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	