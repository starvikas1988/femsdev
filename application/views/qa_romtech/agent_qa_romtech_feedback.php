
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title"> RomTech Form Agent Feedback</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<form id="form_new_user" method="GET" action="<?php echo base_url('qa_romtech/agent_romtech_feedback'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date" name="from_date"   onchange="date_validation(this.value,'S')"    value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>To Date (MM/DD/YYYY)</label>
										<input type="text" id="to_date" name="to_date"   onchange="date_validation(this.value,'E')"   value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
									<label>Select Campaign</label>
									<select class="form-control" id="" name="campaign" required>
											<option value="">--Select--</option>
											<option <?php echo $campaign=='romtech'?"selected":""; ?> value="romtech">RomTech</option>
											<option <?php echo $campaign=='romtech_csat'?"selected":""; ?> value="romtech_csat">RomTech CSAT</option>
											<option <?php echo $campaign=='romtech_intro'?"selected":""; ?> value="romtech_intro">RomTech Intro</option>
											<option <?php echo $campaign=='romtech_inbound'?"selected":""; ?> value="romtech_inbound">RomTech Inbound</option>
										</select>
									</div>
								</div>

								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success romtech-effect" a href="<?php echo base_url()?>qa_romtech/agent_romtech_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
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
								<div class="col-md-6"><h4 class="widget-title"><?php echo strtoupper($campaign); ?></h4></div>
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
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($qa_romtech as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
										<?php $mpid=$row['id']; 
										if ($campaign=='romtech') {
											?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_romtech/agent_romtech_feedback_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
										
											<?php
										}else if ($campaign=='romtech_csat'){
											?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_romtech/agent_romtech_csat_feedback_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php
										
										}else if ($campaign=='romtech_intro'){
											?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_romtech/agent_romtech_intro_feedback_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php
										
										}else if ($campaign=='romtech_inbound'){
											?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_romtech/agent_romtech_inbound_feedback_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php
										
										}
										?>
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
		<?php } ?>


	</section>
</div>
