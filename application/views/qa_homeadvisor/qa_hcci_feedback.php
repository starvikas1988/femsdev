<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css" />
<style>
input[type=submit] {
	background-color: #4c7aaf;
	border: none;
	color: white;
	padding: 10px 20px;
	text-decoration: none;
	margin: 4px 2px;
}

.upload-path {
	display: inline-block;
	padding: 8px;
	min-width: 250px;
	max-width: 100%;
	font-style: italic;
	border: 1px solid #eee;
	transition: all 0.5s ease-in-out 0s;
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
}

.new-audit .pull-left {
	margin-bottom: 34px;
}

.new-audit .btn {
	width: 100px;
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_homeadvisor/hcci'); ?>">
							<div class="row">
								<!-- <div class="col-md-2">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control">
									</div>
								</div>  -->

								<div class="col-md-2">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" onchange="date_validation(this.value,'S')" name="from_date" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly><span class="start_date_error" style="color:red"></span>
									</div>
								</div> 

								<div class="col-md-2"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date"  onchange="date_validation(this.value,'E')" value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly><span class="end_date_error" style="color:red"></span>
									</div> 
								</div>

								<!-- <div class="col-md-2"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control">
									</div> 
								</div> -->
								<div class="col-md-2">
									<div class="form-group" id="foffice_div">
										<label for="office_id">Select a Location</label>
										<select class="form-control" name="office_id" id="foffice_id" required>
											<option value="All" selected="selected">ALL</option>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if($loc['abbr']==$office_id) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
																					
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Agent</label>
										<select class="form-control" id="" name="agent_id">
											<option value="">ALL</option>
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
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>Qa_homeadvisor/hcci" type="submit" id='btnView' name='btnView' value="View">View</button>
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
										<div class="col-sm-12">
									<div class="pull-left">HCCI [CORE]</div>
									</div>
									
									<?php if(is_access_qa_module()==true){ ?>
									<!-- <div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $page ?>">Add Feedback</a>
									</div> -->
									<div class="col-sm-8">
									<div class="form-group">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_philipines_raw/import_hcci_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<!-- <input class="upload-path" disabled /> -->
												<label class="upload">
												<span>Upload Sample</span>
												<input type="hidden" name="star_time" value="<?php echo $stratAuditTimes;?>">
													<input type="file" id="upl_file2" name="file" class="upload-path new-top" required>  </label>
												<input type="submit" id="uploadsubmitdata2" name="submit" class="btn btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group pull-right"  style="margin-top: 10px"> <a href="<?php echo base_url();?>Qa_philipines_raw/sample_hcci_download" class="btn btn-success" title="Download Sample hcci Excel" download="Sample hcci Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<?php if(is_access_qa_module()==true || get_login_type()=="client"){ 
											?>
										
											<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_homeadvisor/add_hcci_feedback">Add Audit</a>
										
									<?php } ?>
								</div>
								</div>	
									<?php } ?>
									</div>
								</h4>
							</header>
								
				
					<div class="col-sm-12">
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
										<th>SR NO</th>
										<th>Score</th>
										<th>VOC</th>
										<th>Audio</th>
										<th>Agent Review Date/Time</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($hcci_data as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['sr_no']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td><?php echo $row['voc']; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/mgnt_hcci_feedback/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Audit/Feedback</a>
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
										<th>SR NO</th>
										<th>Score</th>
										<th>VOC</th>
										<th>Audio</th>
										<th>Agent Review Date/Time</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
							</h4>
							<!-- </header> -->
						</div>
						<hr class="widget-separator">
					</div>
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
									<div class="pull-left">HCCI [CORE -V2]</div>
									<?php if(is_access_qa_module()==true || get_login_type()=="client"){
									$hcci_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_homeadvisor/add_edit_hcci_core/<?php echo $hcci_id ?>">Add Audit</a>
									</div>
									<?php } ?>
								</h4>
							</header>
								
				
					<div class="col-sm-12">
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
										<th>SR NO</th>
										<th>Score</th>
										<th>VOC</th>
										<th>Audio</th>
										<th>Agent Review Date/Time</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date/Time</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($hcci_core as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['sr_no']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td><?php echo $row['voc']; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/add_edit_hcci_core/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Audit/Feedback</a>
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
										<th>SR NO</th>
										<th>Score</th>
										<th>VOC</th>
										<th>Audio</th>
										<th>Agent Review Date/Time</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date/Time</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
							</h4>
							<!-- </header> -->
						</div>
						<hr class="widget-separator">
					</div>
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
									<div class="row">
										<div class="col-sm-12">
									<div class="pull-left">HCCI [CX]</div>
									</div>
									
									<?php if(is_access_qa_module()==true){ ?>
									<!-- <div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $page ?>">Add Feedback</a>
									</div> -->
									<div class="col-sm-8">
									<div class="form-group">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_philipines_raw/import_hcci_cx_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<!-- <input class="upload-path" disabled /> -->
												<label class="upload">
												<span>Upload Sample</span>
												<input type="hidden" name="star_time" value="<?php echo $stratAuditTimes;?>">
													<input type="file" id="upl_file2" name="file" class="upload-path new-top" required>  </label>
												<input type="submit" id="uploadsubmitdata2" name="submit" class="btn btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group pull-right"  style="margin-top: 10px"> <a href="<?php echo base_url();?>Qa_philipines_raw/sample_hcci_cx_download" class="btn btn-success" title="Download Sample hcci_CX Excel" download="Sample hcci_CX Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<?php if(is_access_qa_module()==true ){ 
											 ?>
										
											<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_homeadvisor/add_hcci_feedback_new">Add Audit</a>
										
									<?php } ?>
								</div>
								</div>	
									<?php } ?>
									</div>
								</h4>
							</header>

								
					<div class="col-sm-12">
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
										<th>SR NO</th>
										<th>Score</th>
										<th>VOC</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($hcci_data_new as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['sr_no']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td><?php echo $row['voc']; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/mgnt_hcci_feedback_new/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Audit/Feedback</a>
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
										<th>SR NO</th>
										<th>Score</th>
										<th>VOC</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
							</h4>
							<!-- </header> -->
						</div>
						<hr class="widget-separator">
					</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	<!-------------------------------------->	
		
	</section>
</div>
