
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_homeadvisor/agent_hcco_feedback'); ?>">
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
									<select class="form-control" name="campaign" required>
											<option value="">--Select--</option>
											<option <?php echo $campaign=='hcco'?"selected":""; ?> value="hcco">HCCO</option>
											<option <?php echo $campaign=='hcco_v2'?"selected":""; ?> value="hcco_v2">HCCO [VERSION 2] </option>
											<option <?php echo $campaign=='hcco_qa_form_v3'?"selected":""; ?> value="hcco_qa_form_v3">HCCO [VERSION 3] </option>
											<option <?php echo $campaign=='hcco_sr_v3'?"selected":""; ?> value="hcco_sr_v3">HCCO SR [VERSION 3] </option>
											<option <?php echo $campaign=='hcco_sr'?"selected":""; ?> value="hcco_sr">HCCO SR COMPLIANCE</option>
											<option <?php echo $campaign=='hcco_sr_v2'?"selected":""; ?> value="hcco_sr_v2">HCCO SR COMPLIANCE [VERSION 2] </option>
											<option <?php echo $campaign=='hcco_flex'?"selected":""; ?> value="hcco_flex">HCCO [FLEX] </option>
									</select>
								</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>Qa_homeadvisor/agent_hcco_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									<h4 class="widget-title"><?php echo $campaign;?></h4>
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
										<!-- <th>Audit Time</th> -->
										<th>Call Duration</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<!-- <th>Total Score</th> -->
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($agent_hcco_review_list as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<!-- <td><?php echo $row['call_time']; ?></td> -->
										<td><?php echo $row['call_duration']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<!-- <td><?php echo $row['overall_score']."%"; ?></td> -->
										<td>
											<?php if($row['attach_file']!=''){
												$attach_file = explode(",",$row['attach_file']);
												foreach($attach_file as $mp){ ?>
													<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93"> 
														<?php
														if($campaign == 'hcco_qa_form_v3'){
															?>
															<source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_qa_v3/<?php echo $mp; ?>" type="audio/ogg">
													  		<source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_qa_v3/<?php echo $mp; ?>" type="audio/mpeg">
															<?php

														}else{
															?>
															<source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_sr/<?php echo $mp; ?>" type="audio/ogg">
													  		<source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_sr/<?php echo $mp; ?>" type="audio/mpeg">
															<?php
														} 
														?>
													  
													</audio>
											<?php } 
											} ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $hcco_id=$row['id']; ?>
											<?php 
												if($campaign=="hcco"){
											?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_feedback_rvw/<?php echo $hcco_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View/Review</a>
											<?php }else if($campaign=="hcco_v2"){ ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_v2_rvw/<?php echo $hcco_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php }else if($campaign=="hcco_sr"){ ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_sr_rvw/<?php echo $hcco_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a>
											<?php }else if($campaign=="hcco_sr_v2"){ ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_sr_v2_rvw/<?php echo $hcco_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a> <?php }else if($campaign=="hcco_flex"){ ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_flex_rvw/<?php echo $hcco_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a> <?php }else if($campaign=="hcco_qa_form_v3"){ ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_v3_rvw/<?php echo $hcco_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a> <?php } else if($campaign=="hcco_sr_v3"){ ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_sr_v3_rvw/<?php echo $hcco_id ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">Edit Feedback</a> <?php } ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<!-- <th>Audit Time</th> -->
										<th>Call Duration</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<!-- <th>Total Score</th> -->
										<th>Audio</th>
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
	<!------------------------------------>
		
	<!-- <div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title">HCCO [SR COMPLIANCE]</h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $tot_sr; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $yet_sr; ?></span>
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
									
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($sr_agent_rvw as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
									
										<td>
											<?php if($row['attach_file']!=''){
												$attach_file = explode(",",$row['attach_file']);
												foreach($attach_file as $af){ ?>
													<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_sr/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_sr/<?php echo $af; ?>" type="audio/mpeg">
													</audio>
											 <?php } 
											} ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $hcco_sr_id=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_sr_rvw/<?php echo $hcco_sr_id ?>" style="margin-left:5px; font-size:10px;">Review Feedback</a>
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
									
										<th>Audio</th>
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
		</div>	 -->
	<!------------------------------------>
		
		<!-- <div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title">HCCO [FLEX]</h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $tot_flex; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $yet_flex; ?></span>
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
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($flex_agent_rvw as $row): ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td>
											<?php if($row['attach_file']!=''){
												$attach_file = explode(",",$row['attach_file']);
												foreach($attach_file as $af){ ?>
													<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_flex/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_flex/<?php echo $af; ?>" type="audio/mpeg">
													</audio>
											 <?php } 
											} ?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $flx_id=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_homeadvisor/agent_hcco_flex_rvw/<?php echo $flx_id ?>" style="margin-left:5px; font-size:10px;">Review Feedback</a>
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
										<th>Audio</th>
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
