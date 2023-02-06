
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

						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_paynearby/paynearby_outbound'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control" readonly>
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
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_paynearby/paynearby_outbound" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									<div class="pull-left">Paynearby Outbound</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){
									$sales_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_outbound/<?php echo $sales_id; ?>">Add Audit</a>
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
										<th>Call Duration</th>
										<th>Audit Type</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>QA Feedback</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($paynearby_outbound as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_duration']; ?></td>
										<td><?php echo $row['audit_type']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>
											<audio controls='' style="width:120px; height:25px; background-color:#607F93">
											  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }
											}	?>

										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php 
											if($row['qa_feedback_date']!=''){
												echo ConvServerToLocal($row['qa_feedback_date']); 
											}else{
												echo '';
											} 
										?></td>
										<td style="width:200px">
											<?php 
												$mpid=$row['id']; 
												$pnb_tbl='qa_paynearby_outbound_feedback';
											?>

											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_outbound/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											
											<?php if($row['entry_by']==get_user_id()){ ?>
												<a class="btn btn-danger addQaFeedback" mpid="<?php echo $mpid ?>" pnb_tbl="<?php echo $pnb_tbl ?>" title="Click to Feedback" style="margin-left:5px; font-size:10px;"><i class="fa fa-commenting" aria-hidden="true"></i></a>
											<?php } ?>
											
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
										<th>Call Duration</th>
										<th>Audit Type</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>QA Feedback</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php //////////////////////////////////////////////////////////////////?>
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Paynearby Retention VRM</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){
									$sales_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_outbound_new/<?php echo $sales_id; ?>">Add Audit</a>
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
										<th>Call Duration</th>
										<th>Audit Type</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>QA Feedback</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($paynearby_outbound_new as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_duration']; ?></td>
										<td><?php echo $row['audit_type']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>
											<audio controls='' style="width:120px; height:25px; background-color:#607F93">
											  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }
											}	?>

										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php 
											if($row['qa_feedback_date']!=''){
												echo ConvServerToLocal($row['qa_feedback_date']); 
											}else{
												echo '';
											} 
										?></td>
										<td style="width:200px">
											<?php 
												$mpid=$row['id']; 
												$pnb_tbl='qa_paynearby_outbound_new_feedback';
											?>

											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_outbound_new/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											
											<?php if($row['entry_by']==get_user_id()){ ?>
												<a class="btn btn-danger addQaFeedback" mpid="<?php echo $mpid ?>" pnb_tbl="<?php echo $pnb_tbl ?>" title="Click to Feedback" style="margin-left:5px; font-size:10px;"><i class="fa fa-commenting" aria-hidden="true"></i></a>
											<?php } ?>
											
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
										<th>Call Duration</th>
										<th>Audit Type</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>QA Feedback</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php //////////////////////////////////////////////////////////////////?>

		
		<!--
		<div class="row" style="display:none;">
			<div class="col-12">
				<div class="widget">

					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Sales</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){
									$sales_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_ob_sales/<?php echo $sales_id; ?>">Add Audit</a>
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
										<th>Call Duration</th>
										<th>Audit Type</th>
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
										foreach($paynearby_ob_sales as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_duration']; ?></td>
										<td><?php echo $row['audit_type']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>
											<audio controls='' style="width:120px; height:25px; background-color:#607F93">
											  <source src="<?php echo base_url(); ?>qa_files/qa_paynearby/outbound/sales/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_paynearby/outbound/sales/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }
											}	?>

										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $mpid=$row['id']; ?>

											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_ob_sales/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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
										<th>Call Duration</th>
										<th>Audit Type</th>
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


		<div class="row" style="display:none;">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Service</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){
									$service_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_ob_service/<?php echo $service_id ?>">Add Audit</a>
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
										<th>Call Duration</th>
										<th>Audit Type</th>
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
										foreach($paynearby_ob_service as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_duration']; ?></td>
										<td><?php echo $row['audit_type']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>
											<audio controls='' style="width:120px; height:25px; background-color:#607F93">
											  <source src="<?php echo base_url(); ?>qa_files/qa_paynearby/outbound/service/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_paynearby/outbound/service/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }
											}	?>

										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $mpid=$row['id']; ?>

											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_ob_service/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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
										<th>Call Duration</th>
										<th>Audit Type</th>
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

		<div class="row" style="display:none;">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
								<div class="pull-left">Outbound(New)</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true){
									$service_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_pnb_outbount/<?php echo $service_id ?>">Add Audit</a>
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
										<th>Call Duration</th>
										<th>Audit Type</th>
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
										foreach($paynearby_pnb_outbound as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_duration']; ?></td>
										<td><?php echo $row['audit_type']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>
											<audio controls='' style="width:120px; height:25px; background-color:#607F93">
											  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }
											}	?>

										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $mpid=$row['id']; ?>

											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/add_edit_pnb_outbount/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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
										<th>Call Duration</th>
										<th>Audit Type</th>
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
		-->

	</section>
</div>


<!----------------------------------------------------------------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------------->

<div class="modal fade modal-design" id="addQaFeedbackModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmAddQaFeedbackModel" action="<?php echo base_url(); ?>qa_paynearby/pnb_qa_feedback" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Your Feedback</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" id="mpid" name="mpid">
			<input type="hidden" id="pnb_tbl" name="pnb_tbl">
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment/Remarks</label>
						<textarea class="form-control" name="qa_feedback_note" required></textarea>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='selectInterviewCandidate' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>