
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	
	#show{
		margin-top:5px;
	}
	
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
	.modal-dialog{
		width:800px;
	}
</style>

<div class="wrap">
	<section class="app-content">
	

<div class="widget">
<header class="widget-header">
	<h4 class="widget-title">Zovio Case Search</h4>
</header>
<div class="widget-body">
<form method="GET" enctype="multipart/form-data" action="" autocomplete="off">

<div class="row">
	<div class="col-md-8">
    <div class="form-group">
      <label for="startdate">Enter CRM ID / Name / Phone No</label>
      <input type="text" class="form-control" id="search_keyword" value="<?php echo $search_keyword; ?>" name="search_keyword" required>
    </div>
	</div>
	
	<div class="col-md-4">
    <div class="form-group">
         <label for="type">Select Type</label>
		  <select class="form-control" name="main_type">
			<option value="">ALL</option>
			<?php 			
			foreach($caseTypes as $key=>$val){ 
				$selected="";
				if($key == $currReportType){ $selected="selected"; }
			?>
			<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $val; ?></option>
			<?php } ?>
		  </select>
    </div>
    </div>
		
	<div class="col-md-3">
    <div class="form-group">
		<button name="reportSubmission" type="submit" class="btn btn-success"><i class="fa fa-search"></i> Filter</button>
	</div>
	</div>
</div>
	
</form>
</div>
</div>

<?php if((!empty($totaldata)) && ($totaldata > 0)){ ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Zovio Case Found</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>CRM ID</th>
										<th>Case Name</th>
										<th>Case Type</th>
										<th>Case Status</th>
										<th>Opened By</th>
										<th>Date Added</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								foreach($case_list as $token){ 								
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['crm_id']; ?></td>
									<td><?php echo $token['fname'] ." " .$token['lname']; ?></td>
									<td><?php 
									echo !empty($caseTypes[$token['p_type_of_case']]) ? $caseTypes[$token['p_type_of_case']] : "-";	
									?>
									</td>
									<td>
									<?php
									if(!empty($token['case_status']))
									{
										if($token['case_status'] == 'C')
										{
											echo "<span class='text-success'><b>Closed</b></span>";
										}
										if($token['case_status'] == 'P')
										{
											echo "<span class='text-danger'><b>Open</b></span>";
										}
									} else {
										echo "<span class='text-warning'><b>Open</b></span>";
									}
									?></td>
									<td><?php echo $token['added_by_name'];//ucwords($token['case_source']); ?></td>
									<td><?php echo date('d M, Y', strtotime($token['date_added'])); ?></td>
									<td>
									<a title='View Case' href="<?php echo base_url()."contact_tracing_crm/form/" .$token['crm_id']."/personal/"; ?>" class='btn btn-success btn-xs' style='font-size:12px'>
									<i class='fa fa-eye'></i> View</a>		
									<?php if(get_login_type() != "client" || (get_login_type() != "client" && !is_access_zovio_report())){ ?>
									<?php if($token['case_status'] != 'C'){ ?>
									<a title='Close Case' onclick="return confirm('Are you sure, you want to close this case ?')" href="<?php echo base_url()."contact_tracing_follett/update_case_status/" .$token['crm_id']; ?>" class='btn btn-danger btn-xs' style='font-size:12px'>
									<i class='fa fa-clock-o'></i></a>									
									<?php } ?>
									<?php } ?>
									<a title='View Logs' target="_blank" href="<?php echo base_url()."contact_tracing_crm/check_logs/" .$token['crm_id']."/"; ?>" class='btn btn-primary btn-xs' style='font-size:12px'><i class='fa fa-calendar'></i></a>
									
									<a title='Download Case' target="_blank" href="<?php echo base_url()."contact_tracing_crm/generate_crm_report_pdf/" .$token['crm_id']."/download"; ?>" class='btn btn-primary btn-xs' style='font-size:12px'><i class='fa fa-download'></i></a>
									
									<a title="Send Mail" c_name="<?php echo $token['fname'] ." " .$token['lname']; ?>" c_crmid="<?php echo $token['crm_id']; ?>" c_mail="" class="btn btn-primary btn-xs sendMailCase" style="font-size:12px"><i class='fa fa-envelope'></i></a>
									</td>
								</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<th>SL</th>
										<th>CRM ID</th>
										<th>Case Name</th>
										<th>Case Type</th>
										<th>Case Status</th>
										<th>Opened By</th>
										<th>Date Added</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php } else {  ?>
<div class="row">
<div class="col-md-12">
	<div class="widget">					
		<div class="widget-body">
		<span class="text-danger"><b><?php if(!empty($search_keyword)){ echo "No Cases Found!"; } else { echo "Please Enter Keyword to Search!"; } ?></b></span>
		</div>
	</div>
</div>
</div>
<?php } ?>


		
	</section>
</div>


<div id="myEmailSendModal" class="largeModal modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
	
	<!--<form action="<?php echo base_url(); ?>contact_tracing_crm/send_email" method="POST" autocomplete="off">-->
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Case Details - ZOVIO</h4>
      </div>
      <div class="modal-body">
        <div class="row">
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">CRM ID</label>
			  <input type="text" class="form-control" id="form_crm_id" placeholder="" value="<?php echo $crmid; ?>" name="form_crm_id" required readonly>
			  <input type="hidden" class="form-control" id="form_send_type" placeholder="" value="1" name="form_send_type" required readonly>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">Case Name</label>
			  <input type="text" class="form-control" id="form_case_name" placeholder="" value="<?php echo $form_case_name; ?>" name="form_case_name" required readonly>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">E-Mail ID</label>
			  <input type="text" class="form-control" id="form_email_id" placeholder="" value="" name="form_email_id" required>
			</div>
		</div>
		</div>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-success sendMailSubmission" onclick="return confirm('Are you sure you want send this case details to mail?');" name="crmFormSubmission">Send</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  
	 <!--</form> -->
    </div>

  </div>
</div>