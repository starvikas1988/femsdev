
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
								<h4 class="widget-title">Search Audit</h4>
							</header>
						</div>
						<div class="col-md-3">
							<header class="widget-header">
								<h4 class="widget-title">
									<?php if(get_dept_folder()=="qa" || get_global_access()=='1'){ ?>
										<a href="<?php echo base_url(); ?>Qa_boomsourcing/qa_boomsourcing_rebuttal" class="rebuttal rebuttal_body" target="_blank">Rebuttal Raised: <?php echo $rebuttal ?></a>
									<?php } ?>
								</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_boomsourcing/boomsourcing'); ?>">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control">
									</div>
								</div>  
								<div class="col-md-2"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control">
									</div> 
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Agent</label>
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
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_boomsourcing/boomsourcing" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									<div class="pull-left">Boomsourcing</div>
									<?php if(is_access_qa_module()==true || is_quality_access_trainer()==true || is_access_qa_operations_module()==true){ 
										$ss_id=0; 
										$rand_id=0; 
										$cdr_nps=''; 
									?>
										<div class="pull-right">
											<?php //if(get_dept_folder()=="qa" || get_global_access()=='1'){ ?>
												<!--<a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>Qa_meesho/ss_new_contact_audit_dasboard" target="_blank" title="Click to View Type of Contact Audit Dasboard" style="font-size:12px; background-color:#800080;"><i class="fa fa-file-pdf-o"></i></a>--> 
											<?php //} ?>
											
											<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_boomsourcing/add_edit_boomsourcing/<?php echo $ss_id; ?>">Add Audit</a>
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
										<?php if(get_user_fusion_id()=="FCHA000001"){ ?>
											<th>--</th>
										<?php } ?>
										<th>SL</th>
										<th>Auditor Name</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Ticket ID</th>
										<th>Audit Type</th>
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Status</th>
										<th>Agent Reviewed</th>
										<th>Mgnt Reviewed By</th>
										<th>Mgnt Reviewed</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($boomsourcing_list as $row): ?>
										<tr>
											<?php if(get_user_fusion_id()=="FCHA000001"){ ?>
												<td>
													<?php $table="qa_boomsourcing_feedback";
													$sid=$row['id'];
													echo "<button title='Delete Audit and ATA Audit' pid='$sid' type='button' table='$table' class='auditDelete btn btn-danger btn-xs'><i class='fa fa-trash' aria-hidden='true'></i></button>"; ?>
												</td>
											<?php } ?>
											
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo ConvServerToLocal($row['entry_date']); ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['ticket_id']; ?></td>
											<td><?php echo $row['audit_type']; ?></td>
											<td><?php echo $row['overall_score'].'%'; ?></td>
											<td>
												<?php if($row['attach_file']!=''){
													$attach_file = explode(",",$row['attach_file']);
													foreach($attach_file as $cf){ ?>
														<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/Qa_boomsourcing/<?php echo $cf; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/Qa_boomsourcing/<?php echo $cf; ?>" type="audio/mpeg">
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
											 <td><?php 
												if($row['client_rvw_date']!=''){
													echo ConvServerToLocal($row['client_rvw_date']); 
												}else{
													echo '';
												} 
											 ?></td>
											 <td width="250px">
												<?php $rand_id=0;
													$cdr_nps='';
													$ss_id=$row['id'];
													$ata_edit=$row['ata_edit'];
													
													if($ata_edit==0){
														$title='Add ATA Audit';
													}else if($ata_edit==1){
														$title='Edit ATA Audit';
													}
													
													echo '<a href="'.base_url().'Qa_boomsourcing/add_edit_boomsourcing/'.$ss_id.'" style="margin-left:5px; font-size:10px;" class="btn btn-info">Edit/Review Feedback</a>';
													
													if(get_global_access()== '1'){
														echo '<a href="'.base_url().'Qa_boomsourcing/add_edit_boomsourcing_client/'.$ss_id.'/'.$ata_edit.'" style="margin-left:5px; font-size:10px;" class="btn btn-warning">'.$title.'</a>';	
													}
												?>
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