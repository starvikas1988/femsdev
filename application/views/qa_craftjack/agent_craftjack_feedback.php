
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Your Feedback</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_craftjack/agent_craftjack_feedback'); ?>">
							<div class="row">
								<div class="col-md-3">
									<!-- <div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control">
									</div> -->

									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date"      name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
									</div>
								</div>  
								<div class="col-md-3"> 
									<!-- <div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control">
									</div>  -->
									<div class="form-group">
										<label>To Date (MM/DD/YYYY)</label>
										<input type="text" id="to_date" name="to_date" onchange="date_validation(this.value,'E')"       value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>Qa_craftjack/agent_craftjack_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
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
								<div class="col-md-6">
									<h4 class="widget-title">Craftjack (MTL)</h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $tot_mtl_agent_feedback; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $tot_mtl_agent_yet_rvw; ?></span>
								</div>
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
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Agent Review Date/Time</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date/Time</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($agent_review_mtl_list as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['overall_score']; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $craftjack_id=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_craftjack/agent_craftjack_mtl_feedback_rvw/<?php echo $craftjack_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View/Review</a>
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
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Agent Review Date/Time</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date/Time</th>
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
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title">Craftjack (Jamaica)</h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $total_new_agent_feedback; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $total_new_agent_yet_rvw; ?></span>
								</div>
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
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($agent_review_new_list as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['overall_score']; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $craftjack_id=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_craftjack/agent_craftjack_new_feedback_rvw/<?php echo $craftjack_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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
										<th>Call Date</th>
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

	<!------------------------------------->

		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title">Craftjack Cebu</h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $tot_agent_cebu_feedback; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $tot_agent_cebu_yet_rvw; ?></span>
								</div>
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
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($agent_cebu_review_list as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['overall_score']; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $cjid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_craftjack/agent_craftjack_cebu_feedback_rvw/<?php echo $cjid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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
										<th>Call Date</th>
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

		<!-- <div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title">Old Craftjack</h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $tot_agent_feedback; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $tot_agent_yet_rvw; ?></span>
								</div>
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
										<th>Call Date</th>
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($agent_review_list as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['overall_score']; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $cjid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_craftjack/agent_craftjack_feedback_rvw/<?php echo $cjid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
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
										<th>Call Date</th>
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
		</div> -->


		
	</section>
</div>
