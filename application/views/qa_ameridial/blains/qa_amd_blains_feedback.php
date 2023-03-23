
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_ameridial/process/'.$page); ?>">
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
										<select class="form-control" name="agent_id">
											<option value="">All</option>
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
									<button class="btn btn-success blains-effect" a href="<?php echo base_url('Qa_ameridial/process/'.$page);?>" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
				
	<!--------------------------------------------------->	
		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left"><?php echo ucfirst($page) ?> Farm & Fleet QA</div>
									
									<?php 
									//$client_id =134;
									//$pro_id=271; ?>
									<div class="pull-right">
										<!--<?php //if(is_access_qa_module()==true || get_login_type()=="client" || is_access_randamiser()==true){ ?>
											<a class="btn btn-primary" target="_blank" href="<?php //echo base_url(); ?>qa_randamiser/data_upload_freshdesk/<?php //echo $client_id; ?>/<?php //echo $pro_id; ?>">Sampling/ Randamiser</a>
										<?php //}
										//if(is_access_agent_categorisation()==true){ ?>
											<a class="btn btn-primary" target="_blank" href="<?php //echo base_url(); ?>qa_agent_categorisation/index/<?php //echo $client_id; ?>/<?php //echo $pro_id; ?>">Agent Categorisation</a>
										<?php //} ?>-->
										<!-- ------------------------- -->
										<?php if(is_access_qa_module()==true){ ?>
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_ameridial/process/<?php echo $page ?>/add/<?php echo $stratEmailAuditTime; ?>">Add Feedback</a>
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
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									$loop=$page."_new_data";
									foreach($$loop as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/<?php $page="blains"; echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/<?php $page="blains"; echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_ameridial/process/<?php echo $page ?>/mgnt_rvw/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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
	<!-------------------------------------->	

	<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left"><?php echo ucfirst($page."_v2") ?> Farm & Fleet QA V2</div>
									
									<?php 
									$client_id =134;
									$pro_id=271; ?>
									<div class="pull-right">
										 <?php if(is_access_qa_module()==true || get_login_type()=="client" || is_access_randamiser()==true){ ?>
											<a class="btn btn-primary" target="_blank" href="<?php echo base_url(); ?>qa_randamiser/data_upload_freshdesk/<?php echo $client_id; ?>/<?php echo $pro_id; ?>">Sampling/ Randamiser</a>
										<?php }
										if(is_access_agent_categorisation()==true){ ?>
											<a class="btn btn-primary" target="_blank" href="<?php echo base_url(); ?>qa_agent_categorisation/index/<?php echo $client_id; ?>/<?php echo $pro_id; ?>">Agent Categorisation</a>
										<?php } ?> 
										<!-- ------------------------- -->
										<?php if(is_access_qa_module()==true){ ?>
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_ameridial/process/<?php echo $page."_v2" ?>/add/<?php echo $stratEmailAuditTime; ?>">Add Feedback</a>
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
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									$loop=$page."_v2_new_data";
									foreach($$loop as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
											<?php
												 if($row['attach_file']!=''){
												 $attach_file = explode(",",$row['attach_file']);
											 ?>
											 
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/<?php $page="blains_v2"; echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/<?php $page="blains_v2"; echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
												<!-- <a class="btn btn-success" href="<?php echo base_url(); ?>qa_ameridial/process/<?php echo $page ?>/mgnt_rvw/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a> -->
												<a class="btn btn-success" href="<?php echo base_url(); ?>qa_ameridial/process/<?php echo $page ?>/mgnt_rvw/<?php echo $rpid; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>

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
	<!-------------------------------------->	
		
	</section>
</div>