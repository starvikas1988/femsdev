
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_checkpoint'); ?>">
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
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_checkpoint" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									<div class="pull-left">Check Point Chat</div>
									<?php if(is_access_qa_module()==true){ ?>
									<!-- <div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_checkpoint/add_checkpoint_feedback">Add Feedback</a>
									</div>	 -->

									<div class="col-sm-8">
									<div class="form-group">
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_checkpoint/import_chekpoint_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
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
									<div class="form-group pull-right" > <a href="<?php echo base_url();?>Qa_checkpoint/sample_chekpoint_download" class="btn btn-success" title="Download Sample chekpoint Excel" download="Sample chekpoint Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_checkpoint/add_checkpoint_feedback">Add Audit</a>
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
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($qa_checkpoint_data as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['overall_score']; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											  <?php if(strstr($row['attach_file'], 'docx') || strstr($row['attach_file'], 'doc')){
												 
												foreach($attach_file as $af){ ?>
													<a href="<?php echo base_url(); ?>qa_files/qa_checkpoint/checkpoint/<?php echo $af; ?>" style="font-size:15px"><?php echo $af; ?></a> </br>
											 <?php }
												
											  }else{ ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_checkpoint/checkpoint/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_checkpoint/checkpoint/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php }
											  }	?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $paid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_checkpoint/mgnt_checkpoint_feedback_rvw/<?php echo $paid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		<!-- <div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">PuppySpot PC</div>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php //echo base_url(); ?>Qa_puppyspot/add_pc_feedback">Add Feedback</a>
									</div>	
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
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php /* $i=1; 
										foreach($qa_puppyspot_pc_data as $row): */
									?>
									<tr>
										<td><?php //echo $i++; ?></td>
										<td><?php //echo $row['auditor_name']; ?></td>
										<td><?php //echo $row['audit_date']; ?></td>
										<td><?php //echo $row['fusion_id']; ?></td>
										<td><?php //echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php //echo $row['tl_name']; ?></td>
										<td><?php //echo $row['call_date']; ?></td>
										<td><?php //echo $row['overall_score']; ?></td>
										<td>
											<?php
												 /* if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']); */
											 ?>
											 
											 <?php //foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php //echo base_url(); ?>qa_files/qa_puppyspot/puppyspot_pc/<?php //echo $af; ?>" type="audio/ogg">
												  <source src="<?php //echo base_url(); ?>qa_files/qa_puppyspot/puppyspot_pc/<?php //echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php //} ?>
											 
										<?php //} ?>
										</td>
										<td><?php //echo $row['agent_rvw_date']; ?></td>
										<td><?php //echo $row['mgnt_name']; ?></td>
										<td><?php //echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php //$pcid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php //echo base_url(); ?>Qa_puppyspot/mgnt_puppysopt_pc_feedback_rvw/<?php //echo $pcid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php //endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div> -->
		
	</section>
</div>
