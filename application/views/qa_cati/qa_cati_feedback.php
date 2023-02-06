
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_'.$page); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control" autocomplete="off">
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control" autocomplete="off">
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
									<button class="btn btn-success waves-effect" a href="<?php echo base_url('Qa_'.$page);?>" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
				

	<!-------------------------------------->	

	<!--------------------------------------------------->	
	<?php 
		$processnmCnt=count($processName);
		foreach ($processName as $key => $value) { 
			if($processnmCnt<=1){
				$loop=$page."_new_data";
			}else{
				$loop=$page."_".$value."_new_data";
			}

		foreach ($processName as $key => $value) { 
			if($processnmCnt<=1){
				$loopSopriam_APV=$pageSopriam_APV."_new_data";
			}else{
				$loopSopriam_APV=$pageSopriam_APV."_".$value."_new_data";
			}

		foreach ($processName as $key => $value) { 
			if($processnmCnt<=1){
				$loopSopriam_VN=$pageSopriam_VN."_new_data";
			}else{
				$loopSopriam_VN=$pageSopriam_VN."_".$value."_new_data";
			}

		foreach ($processName as $key => $value) { 
			if($processnmCnt<=1){
				$loopSopriam_SAV=$pageSopriam_SAV."_new_data";
			}else{
				$loopSopriam_SAV=$pageSopriam_SAV."_".$value."_new_data";
			}
			
		foreach ($processName as $key => $value) { 
			if($processnmCnt<=1){
				$loopSopriam_SALE=$pageSopriam_SALE."_new_data";
			}else{
				$loopSopriam_SALE=$pageSopriam_SALE."_".$value."_new_data";
			}
			
		foreach ($processName as $key => $value) { 
			if($processnmCnt<=1){
				$loopSopriam_VO=$pageSopriam_VO."_new_data";
			}else{
				$loopSopriam_VO=$pageSopriam_VO."_".$value."_new_data";
			}
			
		foreach ($processName as $key => $value) { 
			if($processnmCnt<=1){
				$loopSopriam_IPSOS=$pageSopriam_IPSOS."_new_data";
			}else{
				$loopSopriam_IPSOS=$pageSopriam_IPSOS."_".$value."_new_data";
			}

		foreach ($processName as $key => $value) { 
			if($processnmCnt<=1){
				$loopSopriam_Toyota_RC = $pageSopriam_Toyota_RC."_new_data";
			}else{
				$loopSopriam_Toyota_RC = $pageSopriam_Toyota_RC."_".$value."_new_data";
			}							

	?>

		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucwords('CATI') ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $value ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
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
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>/<?=$value?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; 
								// }
									?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
<?php } ?>
		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucwords('Sopriam APV') ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $pageSopriam_APV ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
									foreach($$loopSopriam_APV as $row): ?>
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
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>/<?=$pageSopriam_APV?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; 
								// }
									?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucwords('Sopriam VN') ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $pageSopriam_VN ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
									foreach($$loopSopriam_VN as $row): ?>
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
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>/<?=$pageSopriam_VN?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; 
								// }
									?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucwords('Sopriam SAV') ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $pageSopriam_SAV ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
									foreach($$loopSopriam_SAV as $row): ?>
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
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>/<?=$pageSopriam_SAV?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; 
								// }
									?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucwords('Toyota sondage sale') ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $pageSopriam_SALE ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
									foreach($$loopSopriam_SALE as $row): ?>
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
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>/<?=$pageSopriam_SALE?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; 
								// }
									?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucwords('Toyota sondage VO') ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $pageSopriam_VO ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
									foreach($$loopSopriam_VO as $row): ?>
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
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>/<?=$pageSopriam_VO?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; 
								// }
									?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucwords('IPSOS') ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $pageSopriam_IPSOS ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
									foreach($$loopSopriam_IPSOS as $row): ?>
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
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $value ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>/<?=$pageSopriam_IPSOS?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; 
								// }
									?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Qa <?php echo ucwords('Toyota RC') ?> Audit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $pageSopriam_Toyota_RC ?>">Add Feedback</a>
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
										<th>Score</th>
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
									foreach($$loopSopriam_Toyota_RC as $row): ?>
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
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $pageSopriam_Toyota_RC ?>/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $pageSopriam_Toyota_RC ?>/<?php echo $af; ?>" type="audio/mpeg">

												  <!-- 	<source src="<?php //echo base_url(); ?>qa_files/qa_<?php //echo $page ?>/qa_<?php //echo $pageSopriam_Toyota_RC ?>/<?php //echo $value ?>/<?php //echo $af; ?>" type="audio/mpeg"> -->
												</audio>
											 <?php } ?>
											 
										<?php } ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $rpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/mgnt_rvw/<?php echo $rpid; ?>/<?=$pageSopriam_Toyota_RC?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										</td>
									</tr>
									<?php endforeach; 
								// }
									?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
	</div>
	<?php } ?>
	<!-------------------------------------->
		
	</section>
</div>