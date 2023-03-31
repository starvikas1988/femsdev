
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">

				<div class="widget">

					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title"> Search Updater </h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>

					<div class="widget-body">

						<form id="form_new_user" method="GET" action="<?php echo base_url('qa_acg'); ?>">
							<div class="row">
								<div class="col-md-4">

									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date"      name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>To Date (MM/DD/YYYY)</label>
										<input type="text" id="to_date" name="to_date" onchange="date_validation(this.value,'E')"       value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div>
								</div>





								<div class="col-md-3">
									<div class="form-group">
										<label>Agent</label>
										<select class="form-control" id="" name="agent_id">
											<option value="">-ALL-</option>
											<?php

											foreach($agentName as $row):
												$sCss='';
												if($row['id']==$agent_id) $sCss='Selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php $name=$row['name']; $name=strtolower($name);echo ucwords($name); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-10" style="margin-top:20px">
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>qa_acg" type="submit" id='btnView' name='btnView' value="View">View</button>
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
								<h4 class="widget-title">
									<div class="pull-left">UPDATER </div>
									<?php if(is_access_qa_module()==true || get_login_type()=="client"){
									$ajio_id=0; ?>
									<div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url(); ?>qa_acg/add_edit_qa_acg/<?php echo $ajio_id ?>">Add Audit</a>

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
										<th>Employee ID</th>
										<th>Agent Name</th>
										<th> OverAll  Score  </th>
										<th>L1 Supervisor</th>
										<th>Audio</th>
										<th>Agent Review Date/Time</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date/Time</th>

										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;


										foreach($qa_acg as $row):
									?>
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
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['overall_score']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td>
										<?php
											if($row['attach_file']!=''){
											$attach_file = explode(",",$row['attach_file']);
											foreach($attach_file as $mp){
										?>
											<audio controls='' style="width:120px; height:25px; background-color:#607F93">
											  <source src="<?php echo base_url(); ?>qa_files/qa_acg/<?php echo $mp; ?>" type="audio/ogg">
											  <source src="<?php echo base_url(); ?>qa_files/qa_acg/<?php echo $mp; ?>" type="audio/mpeg">
											</audio>
										<?php }
											}	?>
										</td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_rvw_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>

										<td>
											<?php $mpid=$row['id']; ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>qa_acg/add_edit_qa_acg/<?php echo $mpid ?>" style="margin-left:5px; font-size:10px;">Edit/Review Feedback</a>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
									<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Employee ID</th>
										<th>Agent Name</th>
										<th> OverAll  Score  </th>
										<th>L1 Supervisor</th>
										<th>Audio</th>
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

	</section>
</div>
