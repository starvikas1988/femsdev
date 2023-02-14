<style>
.new-btn{
		margin: 10px;
	}
	.new-btn .btn{
		padding: 6px!important;
	}
	.padding_top{
		padding-top: 0;
	}
	.btn-section .btn{
		padding:10px;
	}
</style>
<div class="wrap">
	<section class="app-content">
	
	<!-- ------BSNL Randamiser and Agent Categorisation ----------------->
	<!-- <div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								
								<?php $rand ="bsnl";
									$client_id =288;
									$pro_id=614;
									?>
									<div class="pull-right">
										<a class="btn btn-primary" target="_blank" href="<?php echo base_url(); ?>qa_randamiser/data_upload_freshdesk/<?php echo $client_id; ?>/<?php echo $pro_id; ?>">Sampling/ Randamiser</a>
									</div>	
									<?php $rand ="bsnl";
									$client_id =288;
									$pro_id=614;
									?>
									<div class="pull-right margin_right">
										<a class="btn btn-primary" target="_blank" href="<?php echo base_url(); ?>qa_agent_categorisation/index/<?php echo $client_id; ?>/<?php echo $pro_id; ?>">Agent Categorisation</a>
									</div> 
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						
						
					</div>
				</div>

			</div>		
		</div> -->
	<!-- -----------BSNL Randamiser and Agent Categorisation------------->

		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-6">
							<header class="widget-header">
								<h4 class="widget-title">Search Feedback</h4>
							</header>
						</div>
						
						
						<div class="col-md-6">
							<?php $rand ="bsnl";
							$client_id =288;
							$pro_id=614; ?>
							<div class="pull-right new-btn">
								<?php if(is_access_qa_module()==true || get_login_type()=="client" || is_access_randamiser()==true){ ?>
									<a class="btn btn-primary" target="_blank" href="<?php echo base_url(); ?>qa_randamiser/data_upload_freshdesk/<?php echo $client_id; ?>/<?php echo $pro_id; ?>">Sampling/ Randamiser</a>
								<?php }
								if(is_access_agent_categorisation()==true){ ?>
									<a class="btn btn-primary" target="_blank" href="<?php echo base_url(); ?>qa_agent_categorisation/index/<?php echo $client_id; ?>/<?php echo $pro_id; ?>">Agent Categorisation</a>
								<?php } ?>
							</div>
						</div>
						
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body padding_top">
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('qa_bsnl'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date"  onchange="date_validation(this.value,'S')" name="from_date" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly><span class="start_date_error" style="color:red"></span>
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date"  onchange="date_validation(this.value,'E')" value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly><span class="end_date_error" style="color:red"></span>
									</div> 
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Agent</label>
										<select class="form-control" id="" name="agent_id">
											<option value="">-All-</option>
											<?php foreach($agentName as $row):
												$sCss='';
												if($row['id']==$agent_id) $sCss='Selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-1 btn-section" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>qa_bsnl/" type="submit" id='btnView' name='btnView' value="View">View</button>
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
						<div class="col-md-6">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">BSNL</div>
								
								</h4>
							</header>
						</div>
						<div class="col-md-6">
								<?php if(is_access_qa_module()==true || get_login_type()=="client"){ 
									$gds_id=0; ?>
									<div class="pull-right new-btn">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>qa_bsnl/add_edit_bsnl/<?php echo $gds_id ?>">Add Audit</a>
									</div>
								<?php }?>									
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
										foreach($gds_prearrival as $row):
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
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){ 
										?>	
											<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_bsnl/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_bsnl/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }  
											}	?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php echo $row['client_rvw_date']; ?></td>
										<td>
											<?php $mpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_bsnl/add_edit_bsnl/<?php echo $mpid ?>" style="margin-left:5px; font-size:10px;">Edit/Review Feedback</a>
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
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</tfoot>
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
						<div class="col-md-6">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">BSNL Outbound</div>
								
								</h4>
							</header>
						</div>
						<div class="col-md-6">
								<?php if(is_access_qa_module()==true || get_login_type()=="client"){ 
									$gds_id=0; ?>
									<div class="pull-right new-btn">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>qa_bsnl/add_edit_bsnl_outbound/<?php echo $gds_id ?>">Add Audit</a>
									</div>
								<?php }?>									
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
										foreach($bsnl_new as $row):
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
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){ 
										?>	
											<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
											  <source src="<?php echo base_url(); ?>qa_files/qa_bsnl/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_bsnl/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }  
											}	?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php echo $row['client_rvw_date']; ?></td>
										<td>
											<?php $mpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_bsnl/add_edit_bsnl_outbound/<?php echo $mpid ?>" style="margin-left:5px; font-size:10px;">Edit/Review Feedback</a>
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
										<th>Total Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
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
