<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css" />
<style>
	input[type=submit] {
	background-color: #4c7aaf;
	border: none;
	color: white;
	padding: 10px 20px!important;
	width: 120px;
	text-decoration: none;
	margin: 4px 2px;
}
</style>
<style type="text/css">
.upload-path {
	display: inline-block!important;
	padding: 8px;
	min-width: 250px;
	max-width: 100%;
	font-style: italic;
	border: 1px solid #ccc!important;
	border-radius: 5px!important;
	transition: all 0.5s ease-in-out 0s;
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
}

.new-audit .pull-left {
	margin-bottom: 15px;
}

.new-audit .btn {
	width: 120px;
	padding: 10px;
	border-radius: 4px;
	margin-top: 6px;
}
.new-row{
    padding: 0px 10px 10px 10px;
	 margin-top: -10px;
}
.btn-submit{
    width: 100px;
    padding: 12px!important;
    font-size: 12px;
    border-radius: 4px;
}
.view-btn-new {
    width: 100px;
    padding: 10px;
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
								<h4 class="widget-title">Search Feedback</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_vfs'); ?>">
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
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>Qa_vfs" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									<div class="row">
										<div class="col-md-12">
									<div class="pull-left">VFS [Chat]</div>
								</div>

									<?php if(is_access_qa_module()==true){ 
									 $chat_id=0; ?>
									<!-- <div class="pull-right">
										<a class="btn btn-primary" href="<?php //echo base_url(); ?>Qa_vfs/add_edit_vfs_chat/<?php echo $chat_id ?>">Add Audit</a>
									</div>  -->
									<div class="col-sm-8">
									<div class="form-group">
										<?= $this->session->flashdata('Success');?>
											<?= form_open( base_url('Qa_vfs/import_vfs_chat_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<!-- <input class="upload-path" disabled /> -->
												<label class="upload">
												<span>Upload Sample</span>
													<input type="file" id="upl_file" name="file" class="upload-path new-top" required>  </label>
												<input type="submit" id="uploadsubmitdata" name="submit" class="btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group pull-right" > <a href="<?php echo base_url();?>Qa_vfs/sample_vfs_chat_download" class="btn btn-success" title="Download Sample Chat Excel" download="Sample chat Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_vfs/add_edit_vfs_chat/<?php echo $chat_id ?>">Add Audit</a>
								</div>
								</div>	
									<?php } ?>
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
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Chat Date</th>
										<th>Mission</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($vfs_chat as $row):
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
										<td><?php echo $row['mission']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>	
											<audio controls="controls" controlsList="download" style="width:120px; height:25px; background-color:#607F93"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }  
											}	?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php echo $row['client_rvw_date']; ?></td>
										<td>
											<?php $chatid=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_vfs/add_edit_vfs_chat/<?php echo $chatid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit/Review</a>
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
								<!-- <h4 class="widget-title">
									<div class="pull-left">VFS [Call]</div>
									<?php if(is_access_qa_module()==true){ 
									 $call_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_vfs/add_edit_vfs_call/<?php echo $call_id ?>">Add Audit</a>
									</div>	
									<?php } ?>
								</h4> -->
								<h4 class="widget-title">
									<div class="row">
										<div class="col-md-12">
									<div class="pull-left">VFS [Call]</div>
								</div>

									<?php if(is_access_qa_module()==true){ 
									 $chat_id=0; ?>
									<!-- <div class="pull-right">
										<a class="btn btn-primary" href="<?php //echo base_url(); ?>Qa_vfs/add_edit_vfs_chat/<?php echo $chat_id ?>">Add Audit</a>
									</div>  -->
									<div class="col-sm-8">
									<div class="form-group">
										<?= $this->session->flashdata('Success');?>
											<?= form_open( base_url('Qa_vfs/import_vfs_call_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<!-- <input class="upload-path" disabled /> -->
												<label class="upload">
												<span>Upload Sample</span>
													<input type="file" id="upl_file1" name="file" class="upload-path new-top" required>  </label>
												<input type="submit" id="uploadsubmitdata1" name="submit" class="btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group pull-right" > <a href="<?php echo base_url();?>Qa_vfs/sample_vfs_call_download" class="btn btn-success" title="Download Sample Call Excel" download="Sample call Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_vfs/add_edit_vfs_call/<?php echo $chat_id ?>">Add Audit</a>
								</div>
								</div>	
									<?php } ?>
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
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<th>Mission</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($vfs_call as $row):
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
										<td><?php echo $row['mission']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>	
											<audio controls="controls" controlsList="download" style="width:120px; height:25px; background-color:#607F93"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/call/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/call/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }  
											}	?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php echo $row['client_rvw_date']; ?></td>
										<td>
											<?php $callid=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_vfs/add_edit_vfs_call/<?php echo $callid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit/Review</a>
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
								<!-- <h4 class="widget-title">
									<div class="pull-left">VFS [Email]</div>
									<?php if(is_access_qa_module()==true){ 
									 $email_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_vfs/add_edit_vfs_email/<?php echo $email_id ?>">Add Audit</a>
									</div>	
									<?php } ?>
								</h4> -->
								<h4 class="widget-title">
									<div class="row">
										<div class="col-md-12">
									<div class="pull-left">VFS [Email]</div>
								</div>

									<?php if(is_access_qa_module()==true){ 
									 $chat_id=0; ?>
									<!-- <div class="pull-right">
										<a class="btn btn-primary" href="<?php //echo base_url(); ?>Qa_vfs/add_edit_vfs_chat/<?php echo $chat_id ?>">Add Audit</a>
									</div>  -->
									<div class="col-sm-8">
									<div class="form-group">
										<?= $this->session->flashdata('Success');?>
											<?= form_open( base_url('Qa_vfs/import_vfs_email_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<!-- <input class="upload-path" disabled /> -->
												<label class="upload">
												<span>Upload Sample</span>
													<input type="file" id="upl_file2" name="file" class="upload-path new-top"required>  </label>
												<input type="submit" id="uploadsubmitdata2" name="submit" class="btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group pull-right" > <a href="<?php echo base_url();?>Qa_vfs/sample_vfs_email_download" class="btn btn-success" title="Download Sample Voicemail Excel" download="Sample voicemail Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_vfs/add_edit_vfs_email/<?php echo $chat_id ?>">Add Audit</a>
								</div>
								</div>	
									<?php } ?>
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
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Email Date</th>
										<th>Mission</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($vfs_email as $row):
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
										<td><?php echo $row['mission']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>	
											<audio controls="controls" controlsList="download" style="width:120px; height:25px; background-color:#607F93"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/email/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/email/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }  
											}	?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php echo $row['client_rvw_date']; ?></td>
										<td>
											<?php $emailid=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_vfs/add_edit_vfs_email/<?php echo $emailid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit/Review</a>
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
