<?php 
//$campaign = '';
//echo $campaign;
?>
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('qa_att/agent_att_feedback'); ?>">
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
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Campaign</label>
										<select class="form-control" id="" name="campaign" required>
											<option value="">All</option>
											<option <?php echo $campaign=='att'?"selected":""; ?> value="att">AT&T </option>
											<option <?php echo $campaign=='fiberconnect'?"selected":""; ?> value="fiberconnect">Fiberconnect</option>
											<option <?php echo $campaign=='acc'?"selected":""; ?> value="acc">ACC</option>
											<option <?php echo $campaign=='att_collection_gbrm'?"selected":""; ?> value="att_collection_gbrm">Collection GBRM</option>
											<option <?php echo $campaign=='att_fiberconnect_whitespace'?"selected":""; ?> value="att_fiberconnect_whitespace">Fibeconnect Whitespace</option>
											<!-- <option <?php //echo $campaign=='agent_coaching'?"selected":""; ?> value="agent_coaching">Agent Coaching</option> -->
											<!--
											<option <?php //echo $campaign=='att_verint'?"selected":""; ?> value="att_verint">AT&T Verint</option>
											<option <?php //echo $campaign=='att_florida'?"selected":""; ?> value="att_florida">AT&T Florida</option>
											<option <?php //echo $campaign=='att_compliance'?"selected":""; ?> value="att_compliance">AT&T Compliance</option>
											-->
										</select>
									</div>
								</div>
										
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>qa_att/agent_att_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
	
		
	<?php if($campaign!=""){ ?>
		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title">AT&T </h4>
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
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Duration</th>
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Client Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($att_list as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_duration']; ?></td>
										
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php echo $row['client_rvw_date']; ?></td>
										<td>
											<?php $mpid=$row['id']; ?>
										
											<?php if ($campaign=='att'){ ?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>qa_att/agent_att_feedback_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php }else if($campaign=='fiberconnect'){ ?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>qa_att/agent_fiberconnect_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php //}else if($campaign=='att_verint'){ ?>
												<!--<a class="btn btn-success" href="<?php echo base_url(); ?>qa_attverint/agent_attverint_feedback_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>-->
											<?php }else if($campaign=='acc'){ ?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>qa_att/agent_acc_feedback_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php }else if($campaign=='att_compliance'){ ?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>qa_att/agent_compliance_feedback_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php }else if($campaign=='att_collection_gbrm'){ ?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>qa_att/agent_gbrm_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php } else if($campaign=='att_fiberconnect_whitespace'){ ?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>qa_att/agent_whitespace_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php } ?>
											
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Duration</th>
										<th>Total Score</th>
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
	<?php } ?>
		
	</section>
</div>
