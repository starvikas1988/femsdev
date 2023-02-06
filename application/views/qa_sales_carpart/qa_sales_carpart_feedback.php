
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_'.$page); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control" autocomplete="off">
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control" autocomplete="off">
									</div> 
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Agent</label>
										<select class="form-control" id="" name="agent_id">
											<option value="">-Select-</option>
											<?php foreach($agentName as $row):
												$sCss='';
												if($row['id']==$agent_id) $sCss='Selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url('Qa_'.$page);?>" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									<div class="pull-left">Qa <?php echo ucfirst($page) ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									$loop=$page."_new_data";
									foreach($$loop as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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



		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucfirst($page) ?> Inbound Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add_inbound/<?php echo $stratEmailAuditTime; ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									$loop=$page."_new_data_inbound";
									foreach($$loop as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw_inbound/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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


		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucfirst($page) ?> Inbound Audit (Version 2)</div>
									<?php if(is_access_qa_module()==true){ ?>
									<!-- <div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add_inbound2/<?php echo $stratEmailAuditTime; ?>">Add Feedback</a>
									</div> -->
								<div class="col-sm-8">
									<div class="form-group">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_philipines_raw/import_sales_carpart_inbound2_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<input class="upload-path" disabled />
												<label class="upload">
												<span>Upload Sample</span>
												<input type="hidden" name="star_time" value="<?php echo $stratAuditTimes;?>">
													<input type="file" id="upl_file2" name="file" required>  </label>
												<input type="submit" id="uploadsubmitdata2" name="submit" class="btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group pull-right" > <a href="<?php echo base_url();?>Qa_philipines_raw/sales_carpart_inbound2_data" class="btn btn-success" title="Download Sample sales_carpart_inbound2 Excel" download="Sample sales_carpart_inbound2 Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add_inbound2/<?php echo $stratEmailAuditTime; ?>">Add Feedback</a>
								</div>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									$loop=$page."_new_data_inbound2";
									foreach($$loop as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw_inbound2/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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