
<style>

.rebuttal {
  font-weight:bold;
  text-decoration: none;
  color: rgba(255, 255, 255, 0.8);
  background: rgb(145, 92, 182);
  padding: 15px 40px;
  border-radius: 4px;
  font-weight: normal;
  text-transform: uppercase;
  transition: all 0.2s ease-in-out;
}

.rebuttal_body:hover {
  color: rgba(255, 255, 255, 1);
  box-shadow: 0 5px 15px rgba(145, 92, 182, .4);
}
	
</style>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-9">
							<header class="widget-header">
								<h4 class="widget-title">Search Audit [<?php echo $p_name ?>]</h4>
							</header>
						</div>
						<!-- <div class="col-md-3">
							<header class="widget-header">
								<h4 class="widget-title">
									
								</h4>
							</header>
						</div> -->
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<form id="form_new_user" method="GET" action="<?php echo base_url('qa_audit_dyn/audit/'.$qa_defect_id); ?>">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control" readonly>
									</div>
								</div>  
								<div class="col-md-2"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control" readonly>
									</div> 
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Agent</label>
										<!-- audit-search-agent-id -->
										<select class="form-control" name="agent_id">
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
								<div class="col-md-3">
									<div class="form-group">
										<label>Auditor</label>
										<select class="form-control" name="qa_id">
											<option value="">-Select-</option>
											<?php foreach($qaName as $row):
												$sCss='';
												if($row['entry_by']==$qa_id) $sCss='Selected';
											?>
												<option value="<?php echo $row['entry_by']; ?>" <?php echo $sCss; ?>><?php echo $row['auditor_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>qa_audit_dyn/posp/<?php echo $qa_defect_id ?>" type="submit" id='btnView' name='btnView' value="View">View</button>
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
						<!-- <div class="col-md-6">
							<header class="widget-header">
								<h4 class="widget-title">
										
								</h4>
							</header>
						</div> -->
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">
										<?php if(get_dept_folder()=="qa" || get_global_access()=='1'){ ?>
										<a href="<?php echo base_url(); ?>Qa_audit_dyn/qa_audit_rebuttal/<?php echo $qa_defect_id ?>" class="btn btn-success" target="_blank">Rebuttal Raised: <?php echo $rebuttal ?></a>
									<?php } ?>
									</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true || is_access_qa_operations_module()==true){ 
									$ss_id=0; ?>
										<div class="pull-right">											
											<a class="btn btn-primary" href="<?php echo base_url(); ?>qa_audit_dyn/add_edit_audit/<?php echo $ss_id; ?>/<?php echo $qa_defect_id; ?>">Add Audit</a>
										</div>	
									<?php } ?>
								</h4>
							</header>
						</div>
						
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style="white-space: nowrap !important;">
								<thead>
									<tr class="bg-info">
										<?php if(get_user_fusion_id()=="FBLR000001" || get_user_fusion_id()=="FBLR000008"){ ?>
											<th>--</th>
										<?php } ?>
										<th>SL</th>
										<th>Auditor Name</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>Process</th>
										<th>L1 Supervisor</th>
										<th>Ticket ID</th>
										<th>Audit Type</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Status</th>
										<th>Agent Reviewed</th>
										<th>Mgnt Reviewed By</th>
										<th>Mgnt Reviewed</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($audit_data as $row): ?>
										
										<?php //print_r($row);?>
										<tr>
											<?php if(get_user_fusion_id()=="FBLR000001" || get_user_fusion_id()=="FBLR000008"){ ?>
												<td>
													<?php
													$sid=$row['id'];
													echo "<button title='Delete Audit and ATA Audit' pid='$sid' type='button' table='$table' class='auditDelete btn btn-danger btn-xs'><i class='fa fa-trash' aria-hidden='true'></i></button>"; ?>
												</td>
											<?php } ?>
											
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo ConvServerToLocal($row['entry_date']); ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php if($row['process']!='') {echo getProcessName($row['process']);} ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['ticket_id']; ?></td>
											<td><?php echo $row['audit_type']; ?></td>
											<td><?php echo $row['overall_score'].'%'; ?></td>
											<td>
												<?php if($row['attach_file']!=''){
													$attach_file = explode(",",$row['attach_file']);
													foreach($attach_file as $cf){ ?>
														<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/<?php echo $p_name;?>/<?php echo $cf; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/<?php echo $p_name;?>/<?php echo $cf; ?>" type="audio/mpeg">
														</audio>
												<?php } 
												} ?>
											 </td>
											 <td><?php echo $row['agnt_fd_acpt']; ?></td>
											 <td><?php 
												if($row['agent_rvw_date']!=''){
													echo ConvServerToLocal($row['agent_rvw_date']); 
												}else{
													echo '';
												} 
											 ?></td>
											 <td><?php echo $row['mgnt_rvw_name']; ?></td>
											 <td><?php 
												if($row['mgnt_rvw_date']!=''){
													echo ConvServerToLocal($row['mgnt_rvw_date']); 
												}else{
													echo '';
												} 
											 ?></td>
											 <td width="400px">
												<?php $ss_id=$row['id'];
													$ata_edit=$row['ata_edit'];
													$cashify_tbl=$table;
													
													if($ata_edit==0){
														$title='Add ATA Audit';
													}else if($ata_edit==1){
														$title='Edit ATA Audit';
													}
													
													
													echo '<a href="'.base_url().'qa_audit_dyn/add_edit_audit/'.$ss_id.'/'.$qa_defect_id.'" style="margin-left:5px; font-size:10px;" class="btn btn-info" >Edit/Review Feedback</a>';
													
													if(is_access_qa_ata_access()==true){
														echo '<a href="'.base_url().'qa_audit_dyn/add_edit_audit_client/'.$ss_id.'/'.$ata_edit.'/'.$qa_defect_id.'" style="margin-left:5px; font-size:10px;" class="btn btn-warning">'.$title.'</a>';	
													}
												?>
												
												<?php if($row['tl_id']==get_user_id() && $row['overall_score']==0){ 
													if($row['agnt_fatal_tl_fd']!=""){
														$btn_danger='btn btn-warning';
													}else{
														$btn_danger='btn btn-danger';
													}
												?>
													<a class="<?php echo $btn_danger ?> addQaFeedback" ss_id="<?php echo $ss_id ?>" cashify_tbl="<?php echo $cashify_tbl ?>" title="Click to Feedback" style="margin-left:5px; font-size:10px;"><i class="fa fa-commenting" aria-hidden="true"></i></a>
												<?php } ?>
												
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


<!----------------------------------------------------------------------------------------------------------------------------->
<div class="modal fade modal-design" id="addQaFeedbackModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmAddQaFeedbackModel" action="<?php echo base_url(); ?>qa_audit_dyn/tl_fatal_feedback" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Your Feedback</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" id="ss_id" name="ss_id">
			<input type="hidden" id="cashify_tbl" name="cashify_tbl">
			
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Feedback Type</label>
						<td>
							<select class="form-control" name="agnt_fatal_tl_fd" required>
								<option value="">Select</option>
								<option value='Accepted'>Accepted</option>
								<option value='Not Accepted'>Not Accepted</option>
							</select>
						</td>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment/Remarks</label>
						<textarea class="form-control" name="agnt_fatal_tl_note" required></textarea>
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