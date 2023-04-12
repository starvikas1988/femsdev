<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	font-weight:bold;
	font-size:18px;
	background-color:#85C1E9;
}

.pcare{
	width:80px;
	text-align:center;
	font-weight:bold;
}

.redText{
	background-color:red;
}
</style>


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">QA Calibration Parameter Variance</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-data_audittable" data_audit-plugin="Data_auditTable" class="table table-striped skt-table center" cellspacing="0" width="100%" >
								<thead>
									<tr class="bg-info">
										<th></th>
										<th>Audit Date</th>
										<th>Auditor</th>
										<th>Agent</th>
										<th>Call Date</th>
										<th>Ticket ID</th>
										<th>Overall Score (%)</th>
										
										<?php if(count($paramArr)>0){
											foreach($paramArr as $param){
												
										?>
										<th><?php //echo $param;
										echo $string = ucwords(str_replace('_', ' ', $param));
										?></th>
										<?php
											}
											
										}?>
										<th>Overall Score Variance</th>
									</tr>
								</thead>
								<tbody>
									
									
								
									<tr>
										<td style="font-weight:bold">Master Audit</td>
										<td><?php echo $ata_audit['audit_date'] ?></td>
										<td><?php echo $ata_audit['auditor_name'] ?></td>
										<td><?php echo $ata_audit['agent_name'] ?></td>
										<td><?php echo $ata_audit['call_date'] ?></td>
										<td><?php echo $ata_audit['ticket_id'] ?></td>
										<td><?php echo $ata_audit['overall_score'] ?></td>
										
										<?php if(count($paramArr)>0){
											$i=0;
											foreach($paramArr as $param){
												if($ata_audit[$param]!=$qa_audit[$param]) $styl='style="color:red"'; 
												else $styl='';
										?>
										<td <?php echo $styl;?>><?php echo $ata_audit[$param]; ?></td>
										<?php
											}
											$i++;
											
										}?>
										<td rowspan=2><?php echo ($ata_audit['overall_score'] - $qa_audit['overall_score']) ?></td>
									</tr>
									<tr>
										<td style="font-weight:bold">Regular Audit</td>
										<td><?php echo $qa_audit['audit_date'] ?></td>
										<td><?php echo $qa_audit['auditor_name'] ?></td>
										<td><?php echo $qa_audit['agent_name'] ?></td>
										<td><?php echo $qa_audit['call_date'] ?></td>
										<td><?php echo $qa_audit['ticket_id'] ?></td>
										<td><?php echo $qa_audit['overall_score'] ?></td>
										
										<?php if(count($paramArr)>0){
											foreach($paramArr as $param){
												if($ata_audit[$param]!=$qa_audit[$param]) $styl='style="color:red"'; 
												else $styl='';
										?>
										<td <?php echo $styl;?>><?php echo $qa_audit[$param] ?></td>
										<?php
											}
											
										}?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>
