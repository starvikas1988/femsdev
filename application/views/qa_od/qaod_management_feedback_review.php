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
								<h4 class="widget-title">Search OD Feedback Reviews</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('qa_od/qaod_management_sorting_feedback'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date" name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (MM/DD/YYYY)</label>
										<input type="text" id="to_date" name="to_date" onchange="date_validation(this.value,'E')"       value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div> 
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Agent</label>
										<select class="form-control" id="agent_id" name="agent_id">
											<option value="">Select</option>
											<?php foreach($get_agent_id_list as $agent){ 
												$sCss='';
												if($agent->id==$agent_id) $sCss='Selected';
											?>
												<option value="<?php echo $agent->id ?>" <?php echo $sCss; ?>><?php echo $agent->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-1"  style="margin-top:22px;">
									<button class="btn btn-success esal-effect" a href="<?php echo base_url()?>qa_od/qaod_management_sorting_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
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
								<h4 class="widget-title">Old Chat Audit Sheet</h4>
								<h4 class="widget-title">
								<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){ ?>
									<div class="pull-right">
										<!-- <a class="btn btn-primary" href="<?php //echo base_url(); ?>qa_od/qaod_management_feedback_entry" title="Add OD Feedback">
											Add Feedback
										</a> -->
									</div>
								<?php } ?>
								</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body table-parent">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>QA</th> 
										<th>Chat Date</th> 
										<th>Chat Audit Date</th> 
										<th>Agent Name</th>
										<th>Customer ID</th>
										<th>Session ID/ANI</th>
										<th>Call Pass / Fail</th>
										<th>Audit Type</th>
										<th>Overall Score</th>
										<th>Agent Review Status</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review Date</th>
										<th>Audio</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1;
										foreach($get_management_review_list as $mgrl): 
										
										if($mgrl->call_pass_fail=='Pass') $pfColor='Style="color:green"';
										else $pfColor='Style="color:red"';
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $mgrl->qa_name; ?></td>
										<td><?php echo $mgrl->chat_date; ?></td>
										<td><?php echo $mgrl->audit_date; ?></td>
										<td><?php echo $mgrl->agent_name; ?></td>
										<td><?php echo $mgrl->customer_id; ?></td>
										<td><?php echo $mgrl->ani; ?></td>
										<td <?php echo $pfColor ?>><?php echo $mgrl->call_pass_fail; ?></td>
										<td><?php echo $mgrl->audit_type; ?></td>
										<td><?php echo $mgrl->overall_score; ?></td>
										<td><?php echo $mgrl->agent_fd_acpt; ?></td>
										<td><?php echo $mgrl->agent_review_date; ?></td>
										<td><?php echo $mgrl->mgnt_review_date; ?></td>
										<td>
										<?php if($mgrl->attach_file!=''){ ?>
											<audio controls='' style="width:120px;"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mgrl->attach_file; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mgrl->attach_file; ?>" type="audio/mpeg">
											</audio>
										<?php } ?>
										</td>
										
										
										<td>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/qaod_management_status_form/<?php echo $mgrl->id; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
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
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<header class="widget-header">
						<h4 class="widget-title">
						<div class="row">
										<div class="col-sm-12">
									<div class="pull-left">Voice</div>
						</div>
						
								<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){ ?>
									<!-- <div class="pull-right " style="margin:5px 8px;">
										<a class="btn btn-primary " href="<?php echo base_url(); ?>qa_od/add_edit_od_voice/0" title="Add OD Voice Feedback">
											Add Feedback
										</a>
									</div> -->
									<div class="col-sm-8">
									<div class="form-group">
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_philipines_raw/import_od_voice_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<!-- <input class="upload-path" disabled /> -->
												<label class="upload">
												<span>Upload Sample</span>
												<input type="hidden" name="star_time" value="<?php echo $stratAuditTimes;?>">
													<input type="file" id="upl_file2" name="file" class="upload-path new-top" required>  </label>
												<input type="submit" id="uploadsubmitdata2" name="submit" class="btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group pull-right" style="margin-top: 10px"> <a href="<?php echo base_url();?>Qa_philipines_raw/sample_od_voice_download" class="btn btn-success" title="Download Sample od_voice Excel" download="Sample od_voice Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary " href="<?php echo base_url(); ?>qa_od/add_edit_od_voice/0" title="Add OD Voice Feedback">
											Add Feedback
										</a>
								</div>
								</div>
								<?php } ?>
						</div>
						</h4>
							</header>
						<!-- <hr class="widget-separator"> -->
					</div>
					
					<div class="widget-body table-parent">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>QA</th> 
										<th>Voice Date</th> 
										<th>Voice Audit Date</th> 
										<th>Agent Name</th>
										<th>Customer ID</th>
										<th>Session ID/ANI</th>
										<th>Call Pass / Fail</th>
										<th>Audit Type</th>
										<th>Overall Score</th>
										<th>Agent Review Status</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review Date</th>
										<th>Audio</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1;
										foreach($od_voice_list as $row): 
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php 
											if($row->entry_by!=''){
												echo $row->auditor_name;
											}else{
												echo $row->client_name;
											}
										?></td>
										<td><?php echo $row->call_date; ?></td>
										<td><?php echo $row->audit_date; ?></td>
										<td><?php echo $row->fname." ".$row->lname; ?></td>
										<td><?php echo $row->customer_id; ?></td>
										<td><?php echo $row->session_id; ?></td>
										<td><?php echo $row->division_status; ?></td>
										<td><?php echo $row->audit_type; ?></td>
										<td><?php echo $row->overall_score; ?></td>
										<td><?php echo $row->agnt_fd_acpt; ?></td>
										<td><?php echo $row->agent_rvw_date; ?></td>
										<td><?php echo $row->mgnt_rvw_date; ?></td>
										
										<td>
										<?php if($row->attach_file!=''){ ?>
											<audio controls='' style="width:120px;"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row->attach_file; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row->attach_file; ?>" type="audio/mpeg">
											</audio>
										<?php } ?>
										</td>
										
										<td>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/add_edit_od_voice/<?php echo $row->id; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
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
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-6">
							<header class="widget-header">
								<h4 class="widget-title">E-commerce</h4>
								</header>
						</div>
						<div class="col-md-6">
								<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){ ?>
									<div class="pull-right " style="margin:5px 8px;">
										<a class="btn btn-primary " href="<?php echo base_url(); ?>qa_od/add_edit_od_ecommerce/0" title="Add OD Ecommerce Feedback">
											Add Feedback
										</a>
									</div>
								<?php } ?>
						</div>
						<!-- <hr class="widget-separator"> -->
					</div>
					
					<div class="widget-body table-parent">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>QA</th> 
										<th>Voice Date</th> 
										<th>Voice Audit Date</th> 
										<th>Agent Name</th>
										<th>Customer ID</th>
										<th>Session ID/ANI</th>
										<th>Call Pass / Fail</th>
										<th>Audit Type</th>
										<th>Overall Score</th>
										<th>Agent Review Status</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review Date</th>
										<th>Audio</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1;
										foreach($od_ecommerce_list as $row): 
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php 
											if($row->entry_by!=''){
												echo $row->auditor_name;
											}else{
												echo $row->client_name;
											}
										?></td>
										<td><?php echo $row->call_date; ?></td>
										<td><?php echo $row->audit_date; ?></td>
										<td><?php echo $row->fname." ".$row->lname; ?></td>
										<td><?php echo $row->customer_id; ?></td>
										<td><?php echo $row->session_id; ?></td>
										<td><?php echo $row->division_status; ?></td>
										<td><?php echo $row->audit_type; ?></td>
										<td><?php echo $row->overall_score; ?></td>
										<td><?php echo $row->agnt_fd_acpt; ?></td>
										<td><?php echo $row->agent_rvw_date; ?></td>
										<td><?php echo $row->mgnt_rvw_date; ?></td>
										
										<td>
										<?php if($row->attach_file!=''){ ?>
											<audio controls='' style="width:120px;"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row->attach_file; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row->attach_file; ?>" type="audio/mpeg">
											</audio>
										<?php } ?>
										</td>
										
										<td>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/add_edit_od_ecommerce/<?php echo $row->id; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
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
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-6">
							<header class="widget-header">
								<h4 class="widget-title">Chat</h4>
							</header>
							</div>
								<div class="col-md-6">
								<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){ ?>
									<div class="pull-right" style="margin:5px 8px;">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>qa_od/add_edit_od_chat/0" title="Add OD Chat Feedback">
											Add Feedback
										</a>
									</div>
								<?php } ?>
						</div>
						<!-- <hr class="widget-separator"> -->
					</div>
					
					<div class="widget-body table-parent">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>QA</th> 
										<th>Voice Date</th> 
										<th>Voice Audit Date</th> 
										<th>Agent Name</th>
										<th>Customer ID</th>
										<th>Session ID/ANI</th>
										<th>Call Pass / Fail</th>
										<th>Audit Type</th>
										<th>Overall Score</th>
										<th>Agent Review Status</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review Date</th>
										<th>Audio</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1;
										foreach($od_chat_list as $row): 

										//if($mgrl->call_pass_fail=='Pass') $pfColor='Style="color:green"';
										//else $pfColor='Style="color:red"';
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php 
											if($row->entry_by!=''){
												echo $row->auditor_name;
											}else{
												echo $row->client_name;
											}
										?></td>
										<td><?php echo $row->call_date; ?></td>
										<td><?php echo $row->audit_date; ?></td>
										<td><?php echo $row->fname." ".$row->lname; ?></td>
										<td><?php echo $row->customer_id; ?></td>
										<td><?php echo $row->session_id; ?></td>
										<td><?php echo $row->division_status; ?></td>
										<td><?php echo $row->audit_type; ?></td>
										<td><?php echo $row->overall_score; ?></td>
										<td><?php echo $row->agnt_fd_acpt; ?></td>
										<td><?php echo $row->agent_rvw_date; ?></td>
										<td><?php echo $row->mgnt_rvw_date; ?></td>
										
										<td>
										<?php if($row->attach_file!=''){ ?>
											<audio controls='' style="width:120px;"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row->attach_file; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row->attach_file; ?>" type="audio/mpeg">
											</audio>
										<?php } ?>
										</td>
										
										
										<td>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/add_edit_od_chat/<?php echo $row->id; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
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
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-6">
							<header class="widget-header">
								<h4 class="widget-title">Business Direct</h4>
							</header>
							</div>
								<div class="col-md-6">
								<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){ ?>
									<div class="pull-right" style="margin:5px 8px;">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>qa_od/add_edit_od_business_direct/0" title="Add OD Business Direct Feedback">
											Add Feedback
										</a>
									</div>
								<?php } ?>
						</div>
						<!-- <hr class="widget-separator"> -->
					</div>
					
					<div class="widget-body table-parent">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>QA</th> 
										<th>Voice Date</th> 
										<th>Voice Audit Date</th> 
										<th>Agent Name</th>
										<th>Customer ID</th>
										<th>Session ID/ANI</th>
										<th>Call Pass / Fail</th>
										<th>Audit Type</th>
										<th>Overall Score</th>
										<th>Agent Review Status</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review Date</th>
										<th>Audio</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1;
										foreach($od_business_direct_list as $row): 
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php 
											if($row->entry_by!=''){
												echo $row->auditor_name;
											}else{
												echo $row->client_name;
											}
										?></td>
										<td><?php echo $row->call_date; ?></td>
										<td><?php echo $row->audit_date; ?></td>
										<td><?php echo $row->fname." ".$row->lname; ?></td>
										<td><?php echo $row->customer_id; ?></td>
										<td><?php echo $row->session_id; ?></td>
										<td><?php echo $row->division_status; ?></td>
										<td><?php echo $row->audit_type; ?></td>
										<td><?php echo $row->overall_score; ?></td>
										<td><?php echo $row->agnt_fd_acpt; ?></td>
										<td><?php echo $row->agent_rvw_date; ?></td>
										<td><?php echo $row->mgnt_rvw_date; ?></td>
										
										<td>
										<?php if($row->attach_file!=''){ ?>
											<audio controls='' style="width:120px;"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row->attach_file; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $row->attach_file; ?>" type="audio/mpeg">
											</audio>
										<?php } ?>
										</td>
										
										
										<td>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_od/add_edit_od_business_direct/<?php echo $row->id; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
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

