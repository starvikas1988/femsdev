
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_us_da'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control">
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control">
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
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_us_da" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
							
						</form>
						
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
									<div class="pull-left">US Directory Assistance</div>
									<?php if(is_access_qa_module()==true){ 
									 $da_id=0; ?>
									<!-- <div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_us_da/add_edit_usda/<?php echo $da_id ?>">Add Audit</a>
									</div> -->
										<div class="col-sm-8">
									<div class="form-group">
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_philipines_raw/import_usda_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
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
									<div class="form-group pull-right" > <a href="<?php echo base_url();?>Qa_philipines_raw/sample_usda_download" class="btn btn-success" title="Download Sample usda Excel" download="Sample usda Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_us_da/add_edit_usda/<?php echo $da_id ?>">Add Audit</a>
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
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Status</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($us_da as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php 
											if($row['entry_by']!=''){
												echo $row['auditor_name'];
											}else{
												echo $row['client_name'].' [Client]';
											}
										?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>	
											<audio controls="controls" controlsList="nodownload" style="width:120px; height:25px; background-color:#607F93"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_us_da/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_us_da/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }  
											}	?>
										</td>
										<td><?php echo $row['agent_fd_acpt']; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php echo $row['client_rvw_date']; ?></td>
										<td>
											<?php $chatid=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_us_da/add_edit_usda/<?php echo $chatid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit/Review</a>
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
		
	</section>
</div>
