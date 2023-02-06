
<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_boomsourcing/agent_boomsourcing_feedback'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control">
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control">
									</div> 
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Campaign</label>
										<select class="form-control" name="campaign" required>
											<option value="">-Select-</option>
											<option <?php echo $campaign=='boomsourcing'?"selected":""; ?> value="boomsourcing">Boomsourcing</option>
										</select>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_boomsourcing/agent_boomsourcing_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
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
				
				<?php if($campaign!=""){ ?>
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title"></h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $tot_feedback; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $yet_rvw; ?></span>
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
										<th>Auditor Name</th>
										<th>Audit Date/Time</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Ticket ID</th>
										<th>Total Score</th>
										<th>Agent Reviewed</th>
										<th>Mgnt Reviewed By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($agent_rvw_list as $row): ?>
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
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
											<td><?php echo $row['ticket_id']; ?></td>
											<td><?php echo $row['overall_score'].'%'; ?></td>
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
											<td>
												<?php $ob_id=$row['id']; ?>
											
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_boomsourcing/agent_boomsourcing_rvw/<?php echo $ob_id; ?>/<?php echo $campaign; ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor Name</th>
										<th>Audit Date/Time</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Ticket ID</th>
										<th>Total Score</th>
										<th>Agent Reviewed</th>
										<th>Mgnt Reviewed By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					
				<?php } ?>
					
				</div>
			</div>
		</div>
	</section>
</div>
