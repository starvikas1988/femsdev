
<div class="wrap">
	<section class="app-content">
		
		
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title"><div class="pull-left"><?php echo ucwords(str_replace('_',' ',$p_name)) ?> [Rebuttal Raised]</div></h4>
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
										<th>Auditor Name</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Ticket ID</th>
										<th>Total Score</th>
										<th>Agent Status</th>
										<th>QA Rebuttal</th>
										<th>QA Manager/TL Rebuttal</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($rebuttal_details as $row){ ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo ConvServerToLocal($row['entry_date']); ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['ticket_id']; ?></td>
											<td><?php echo $row['overall_score'].'%'; ?></td>
											<td><?php echo $row['agnt_fd_acpt']; ?></td>
											<td><?php echo $row['qa_rebuttal']; ?></td>
											<td><?php echo $row['qa_mgnt_rebuttal']; ?></td>
											<td><?php 
												$ss_id=$row['id'];
												echo '<a href="'.base_url().'Qa_audit_dyn/add_edit_audit/'.$ss_id.'/'.$qa_defect_id.'" style="margin-left:5px; font-size:10px;" class="btn btn-info">Edit/Review Feedback</a>';
											?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
	</section>
</div>