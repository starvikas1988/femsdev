<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Sentry</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="get" action="">
							<div class="row">
								<div class="col-md-3"> 
									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date"      name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
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
										<select class="form-control" name="agent" id="agent">
											<option value="">-Select-</option>
											<?php
											foreach($agent_list as $agentVal)
											{?>
												<option <?php echo $agent == $agentVal['id']?"selected":"";?> value="<?php echo $agentVal['id'];?>"><?php echo $agentVal['name'];?></option>
											<?php
											}
											?>
										</select>
									</div> 
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success blains-effect" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
	
		<!---------------------------vikas starts------------------------------>
		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Sentry Credit</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<!-- <a class="btn btn-primary" href="<?php //echo base_url();?>Qa_RPM_Sentry/sentry_dashboard/">Sentry Dashboard</a> -->
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_RPM_Sentry/add_edit_sentry_credit/0">Add Feedback</a>
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
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$i = 1;
								foreach($sentry_credit_data as $row)
								{?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['overall_score']; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<a class="btn btn-success" href="<?php echo base_url()."Qa_RPM_Sentry/add_edit_sentry_credit/".$row['id']."/";?>" title="Edit Sentry" style="margin-left:5px; font-size:10px;">Edit/Review</a>
										</td>
									</tr>
								<?
								}
								?>
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
		<!---------------------------------------------------------------------->
		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">Sentry</div>
									<?php if(is_access_qa_module()==true){ ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url();?>Qa_RPM_Sentry/sentry_dashboard/">Sentry Dashboard</a>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_RPM_Sentry/add_sentry/">Add Sentry</a>
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
										<th>Audit Date & Time</th>
										<th>Audit Time</th>
										<th>Agent Name</th>
										<th>Audit Result</th>										
										<th>Total Score</th>
										<th>Audit Type</th>
										<th>VOC</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$i = 1;
								foreach($sentry_data as $sentry)
								{?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo $sentry['auditor_name'];?></td>
										<td><?php echo $sentry['audit_date'];?></td>
										<td><?php echo $sentry['audit_time'];?></td>
										<td><?php echo $sentry['agent_name'];?></td>
										<td><?php echo $sentry['audit_result'] == "1"?"YES":"NO";?></td>
										<td><?php echo $sentry['total_score_count'];?></td>
										<td><?php echo $sentry['audit_type'];?></td>
										<td><?php echo $sentry['voc'];?></td>
										<td>
											<a class="btn btn-success" href="<?php echo base_url()."Qa_RPM_Sentry/edit_sentry/".$sentry['id']."/";?>" title="Edit Sentry" style="margin-left:5px; font-size:10px;">Edit Sentry</a>
										</td>
									</tr>
								<?
								}
								?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date & Time</th>
										<th>Audit Time</th>
										<th>Agent Name</th>
										<th>Audit Result</th>									
										<th>Total Score</th>
										<th>Audit Type</th>
										<th>VOC</th>
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
