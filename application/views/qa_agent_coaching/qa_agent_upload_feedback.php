
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_agent_coaching_upload/qa_agent_upload_feedback'); ?>">
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
								<!-- <div class="col-md-3">
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
								</div> -->
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_sycn" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									<div class="pull-left">Agent Coaching Upload</div>
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ 
										$sycn_id=0;
									?>
									<!-- <div class="col-sm-8">
									<div class="form-group">
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_sycn/import_voice_inbound_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
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
									<div class="form-group pull-right" > <a href="<?php echo base_url();?>Qa_sycn/sample_voice_inbound_download" class="btn btn-success" title="Download Sample sycn voice_inbound Excel" download="Sample sycn voice_inbound Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_sycn/add_edit_sycn/<?php echo $sycn_id ?>">Add Audit</a>
								</div>
								</div> -->
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
										<th>MWP Id</th>
										
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<th>Session Id</th>
										<th>Queue Name</th>
										<th>Category1</th>
										<th>Sub Category</th>
										<th>Date of Creation</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($agent_upload as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['agent_name']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['call_id']; ?></td>
										<td><?php echo $row['queue_name']; ?></td>
										<td><?php echo $row['category1']; ?></td>
										<td><?php echo $row['sub_Category']; ?></td>
										<td><?php echo $row['entry_date']; ?></td>
										<!-- <td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>	
											<audio controls="controls" controlsList="nodownload" style="width:120px; height:25px; background-color:#607F93"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_agent_coaching/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_agent_coaching/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }  
											}	?>
										</td> -->
										<td>
											<?php $mpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_agent_coaching_upload/add_edit_agent_raw_upload/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Audit Here</a>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<th>Session Id</th>
										<th>Queue Name</th>
										<th>Category1</th>
										<th>Sub Category</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
