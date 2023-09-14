
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

						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_paynearby/agent_paynearby_feedback'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date"  name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
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
										<label>Select Campaign</label>
										<select class="form-control" id="" name="campaign" required>
											<option value="">--Select--</option>
											<optgroup label="Old">
												<option <?php echo $campaign=='inbound'?"selected":""; ?> value="inbound">Inbound</option>
												<option <?php echo $campaign=='inbound_new'?"selected":""; ?> value="inbound_new">Inbound(New)</option>
												<option <?php echo $campaign=='ob_sales'?"selected":""; ?> value="ob_sales">Outbound [Sales]</option>
												<option <?php echo $campaign=='ob_service'?"selected":""; ?> value="ob_service">Outbound [Service]</option>
												<option <?php echo $campaign=='pnb_outbound_new'?"selected":""; ?> value="pnb_outbound_new">Outbound [New]</option>
												<option <?php echo $campaign=='pnb_email'?"selected":""; ?> value="pnb_email">PNB Email</option>
												<option <?php echo $campaign=='email'?"selected":""; ?> value="email">Email(Old)</option>
												<option <?php echo $campaign=='closeloop'?"selected":""; ?> value="closeloop">Close Loop</option>
											</optgroup>
											<optgroup label="New">
												<option <?php echo $campaign=='new_inb'?"selected":""; ?> value="new_inb">Inbound</option>
												<option <?php echo $campaign=='new_kyc_inb'?"selected":""; ?> value="new_kyc_inb">KYC Inbound</option>
												<option <?php echo $campaign=='new_outbound'?"selected":""; ?> value="new_outbound">Outbound</option>
												<option <?php echo $campaign=='pnb_ob_sales_v1'?"selected":""; ?> value="pnb_ob_sales_v1">PNB OUTBOUND Sales V1</option>
												<option <?php echo $campaign=='new_one_outbound'?"selected":""; ?> value="new_one_outbound">Retention VRM</option>
												<option <?php echo $campaign=='new_email'?"selected":""; ?> value="new_email">Email</option>
												<option <?php echo $campaign=='new_social'?"selected":""; ?> value="new_social">Social Media</option>
											</optgroup>
										</select>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>Qa_paynearby/agent_paynearby_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>

						</form>

					</div>
				</div>

			</div>
		</div>

		<?php if($campaign!=''){ ?>

		<div class="row">
			<div class="col-12">
				<div class="widget">

					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
								<?php
									if($campaign=='inbound'){
										$pnb_hdr='Inbound';
									}else if($campaign=='inbound_new'){
										$pnb_hdr='Inbound[New]';
									}else if($campaign=='ob_sales'){
										$pnb_hdr=' Outbound [Sales]';
									}else if($campaign=='ob_service'){
										$pnb_hdr=' Outbound [Service]';
									}else if($campaign=='pnb_outbound_new'){
										$pnb_hdr=' Outbound [New]';
									}else if($campaign=='pnb_email'){
										$pnb_hdr='PNB Email';
									}else if($campaign=='email'){
										$pnb_hdr=' Email(Old)';
									}else if($campaign=='closeloop'){
										$pnb_hdr=' Close Loop';
									}else if($campaign=="new_inb"){
										$pnb_hdr="Inbound";
									}else if($campaign=="new_kyc_inb"){
										$pnb_hdr="KYC Inbound";
									}else if($campaign=="new_outbound"){
										$pnb_hdr="Outbound";
									}else if($campaign=="pnb_ob_sales_v1"){
										$pnb_hdr="PNB OUTBOUND Sales V1";
									}else if($campaign=="new_one_outbound"){
										$pnb_hdr="Retention VRM";
									}else if($campaign=="new_email"){
										$pnb_hdr="Email";
									}else if($campaign=="new_social"){
										$pnb_hdr="Social Media";
									}
								?>
									<h4 class="widget-title"><?php echo 'PAYNEARBY '.$pnb_hdr ?></h4>
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
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<?php if($campaign!='email'){ ?>
											<th>Call Duration</th>
										<?php } ?>
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($agent_rvw_list as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<?php if($campaign!='email'){ ?>
											<td><?php echo $row['call_duration']; ?></td>
										<?php } ?>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $mpid=$row['id'];
												if($campaign=='inbound'){
											?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_rvw/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
											<?php }else if($campaign=="new_inb"){?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_rvw_new/inb/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
											<?php }else if($campaign=="new_kyc_inb"){?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_rvw_new/kyc/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
											<?php }else if($campaign=="new_outbound"){?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_rvw_new/outbound/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
											<?php }else if($campaign=="pnb_ob_sales_v1"){?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_rvw_new/pnb_ob_sales_v1/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
											<?php }else if($campaign=="new_one_outbound"){?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_rvw_new/new_one_outbound/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
											<?php }else if($campaign=="new_email"){?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_rvw_new/email/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
											<?php }else if($campaign=="new_social"){?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_rvw_new/social/<?php echo $mpid ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
											<?php }else if($campaign=='closeloop'){ ?>
												<a class="btn btn-success agentFeedback" href="<?php echo base_url(); ?>Qa_paynearby/process/agnt_feedback/<?php echo $mpid ?>/<?php echo $campaign ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View/Review</a>
											<?php }else{ ?>
												<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_paynearby/agent_paynearby_ob_rvw/<?php echo $mpid ?>/<?php echo $campaign ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View / Review</a>
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
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<?php if($campaign!='email'){ ?>
											<th>Call Duration</th>
										<?php } ?>
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

		<?php } ?>

	</section>
</div>
