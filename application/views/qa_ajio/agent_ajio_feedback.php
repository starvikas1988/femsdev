
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
						<form id="form_new_user" method="GET" action="<?php echo base_url('qa_ajio/agent_ajio_feedback'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date_agent"  name="from_date" onchange="agent_date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (MM/DD/YYYY)</label>
										<input type="text" id="to_date_agent" name="to_date" onchange="agent_date_validation(this.value,'E')"  value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div> 
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Campaign</label>
										<select class="form-control" name="campaign" required>
											<option value="">--Select--</option>
											<option <?php echo $campaign=='inbound'?"selected":""; ?> value="inbound">Voice</option>
											<option <?php echo $campaign=='inb_hygiene'?"selected":""; ?> value="inb_hygiene">Voice [Hygiene]</option>
											<option <?php echo $campaign=='email'?"selected":""; ?> value="email">Email</option>
											<option <?php echo $campaign=='email_v2'?"selected":""; ?> value="email_v2">Email [Version 2]</option>
											<option <?php echo $campaign=='chat'?"selected":""; ?> value="chat">Chat</option>
											<option <?php echo $campaign=='chat_v2'?"selected":""; ?> value="chat_v2">Chat [Version2]</option>
											<option <?php echo $campaign=='inbound_v2'?"selected":""; ?> value="inbound_v2">VOICE [Version 2]</option>
											<option <?php echo $campaign=='ccsr_voice'?"selected":""; ?> value="ccsr_voice">CCSR [Voice]</option>
											<option <?php echo $campaign=='ccsr_nonvoice'?"selected":""; ?> value="ccsr_nonvoice">CCSR [Non-Voice]</option>
										</select>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>qa_ajio/agent_ajio_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
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
								<div class="col-md-6"><h4 class="widget-title">AJIO <?php
								if($campaign == 'email_v2'){
									echo "Email [Version 2]";
								}else{
									echo $campaign;
									
								}
								  ?></h4></div>
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
										<th>Audio</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
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
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td oncontextmenu="return false;">
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											if($campaign == 'email_v2' || $campaign == 'email'){
												foreach($attach_file as $mp){
													?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/email/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/email/<?php echo $mp; ?>" type="audio/mpeg">
												</audio>
													<?php
												}

											}else if($campaign == 'ccsr_nonvoice'){
												foreach($attach_file as $mp){
													?>
												<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/ccsr/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/ccsr/<?php echo $mp; ?>" type="audio/mpeg">
												</audio>
													<?php
												}
											}
											else{
													foreach($attach_file as $mp){
															?>
													<audio controls='' style="width:120px; height:25px; background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
													</audio>
														<?php
													}
												}  
											}	?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td><?php echo $row['client_rvw_date']; ?></td>
										<td>
											<?php $mpid=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_ajio/agent_ajio_rvw/<?php echo $mpid ?>/<?php echo $campaign ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View/Feedback</a>
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
										<th>Audio</th>
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
