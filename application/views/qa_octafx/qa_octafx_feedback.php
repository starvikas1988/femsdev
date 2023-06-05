
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Feedback</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_octafx'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date"  name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (MM/DD/YYYY)</label>
										<input type="text" id="to_date" name="to_date" onchange="date_validation(this.value,'E')"  value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div> 
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="office_id">Select an Agent</label>
										<select class="form-control" name="agent_id">
											<option value=''>ALL</option>
											<?php foreach($agentName as $an){ 
												$sCss="";
												if($an['id']==$agent_id) $sCss="selected";
											?>
											<option value="<?php echo $an['id']; ?>" <?php echo $sCss;?>><?php echo $an['name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>Qa_octafx" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
				
	<!--------------------------------------------------->	
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">OctaFX</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){ 
									$oc_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>qa_octafx/add_edit_octafx/<?php echo $oc_id; ?>">Add Audit</a>
									</div>	
									<?php } ?>
								</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($octafx as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td>
											<?php if($row['attach_file']!=''){
												$attach_file = explode(",",$row['attach_file']);
												foreach($attach_file as $af){ ?>
													<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/octafx/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/octafx/<?php echo $af; ?>" type="audio/mpeg">
													</audio>
											<?php } 
											} ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_octafx/add_edit_octafx/<?php echo $rpid; ?>" style="margin-left:5px; font-size:10px;">Edit/Review Audit</a>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-------------------------------------->	
	<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">OctaFX - OUTBOUND</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){ 
									$oc_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>qa_octafx/add_edit_octafx_outbound/<?php echo $oc_id; ?>">Add Audit</a>
									</div>	
									<?php } ?>
								</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($octafx_outbound as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td>
											<?php if($row['attach_file']!=''){
												$attach_file = explode(",",$row['attach_file']);
												foreach($attach_file as $af){ ?>
													<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/octafx/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/octafx/<?php echo $af; ?>" type="audio/mpeg">
													</audio>
											<?php } 
											} ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_octafx/add_edit_octafx_outbound/<?php echo $rpid; ?>" style="margin-left:5px; font-size:10px;">Edit/Review Audit</a>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-------------------------------------->
		
	</section>
</div>