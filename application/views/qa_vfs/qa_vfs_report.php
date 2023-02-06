<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">QA VFS Report</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('qa_vfs/qa_vfs_report'); ?>">	
						  <?php echo form_open('',array('method' => 'get')) ?>
						  
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Audit Date From - (mm/dd/yyyy)</label>
									<input type="text" id="from_date" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Search Audit Date To - (mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-2">
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
							<div class="col-md-2"> 
								<div class="form-group">
									<label>Campaign</label>
									<select class="form-control" id="" name="campaign" required>
										<option value="">--Select--</option>
										<option <?php echo $campaign=='chat'?"selected":""; ?> value="chat">Chat</option>
										<option <?php echo $campaign=='call'?"selected":""; ?> value="call">Call</option>
										<option <?php echo $campaign=='email'?"selected":""; ?> value="email">Email</option>
									</select>
								</div>
							</div>
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>qa_vfs/qa_vfs_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:22px;' class="col-md-1">
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
										<th><?php echo ucfirst($campaign) ?> Date</th>
										<th><?php echo ucfirst($campaign) ?> Duration</th>
										<th>Total Score</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($qa_vfs_list as $row){ ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php 
											if($row['entry_by']!=''){
												echo $row['auditor_name'];
											}else{
												echo $row['client_name'];
											}
										?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['call_duration']; ?></td>
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