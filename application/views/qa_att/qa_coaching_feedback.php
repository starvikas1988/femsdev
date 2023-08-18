
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-8" style="float:left;padding-top: 20px">
							<header class="widget-header">
								<h4 class="widget-title">Your Team Feedback</h4>	
							</header>						
						</div>	
						<div class="col-md-4" style="float:right;padding-top: 30px">
							<span style="font-weight:bold; color:green">Evaluation :</span> <span class="badge" style="font-size:12px"><?php echo $tot_feedback; ?></span> 
							<span style="font-weight:bold; color:green">Acknowledged :</span> <span class="badge" style="font-size:12px"><?php echo ($tot_feedback-$pending_feedback); ?></span>
							<span style="font-weight:bold; color:green">Pending :</span> <span class="badge" style="font-size:12px"><?php echo $pending_feedback; ?></span>
						</div>
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_agent_coaching_new'); ?>">
							<div class="row">
								<div class="col-md-2">
									
									<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date"  name="from_date" onchange="date_validation(this.value,'S')" value="<?php $date= mysql2mmddyy($from_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
									</div>
								</div>  
								<div class="col-md-2"> 
									<div class="form-group">
										<label>To Date (MM/DD/YYYY)</label>
										<input type="text" id="to_date" name="to_date" onchange="date_validation(this.value,'E')"       value="<?php $date= mysql2mmddyy($to_date); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Process/Campaign</label>
										<select class="form-control" id="p_id" name="process_id">
											<option value="">ALL</option>
											<?php foreach($process as $p): 
												$sCss="";
												if($p['id']==$process_id) $sCss="selected";
												?>
												<option value="<?php echo $p['id']; ?>" <?php echo $sCss;?>><?php echo $p['name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-2"> 
									<div class="form-group">
										<label>Coaching Status</label>
										<select class="form-control" id="" name="agent_feedback">
											<option value="">All</option>
											<option <?php echo $agent_feedback=='Acknowledged'?"selected":""; ?> value="Acknowledged">Acknowledged</option>
											<option <?php echo $agent_feedback=='Pending'?"selected":""; ?> value="Pending">Pending</option>
										</select>
									</div> 
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Location</label>
										<select class="form-control" id="" name="office_id">
											<option value="">ALL</option>
											<?php foreach($off_loc as $loc): 
												$sCss="";
												if($loc['abbr']==$office_id) $sCss="selected";
												?>
												<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success blains-effect" a href="<?php echo base_url()?>Qa_agent_coaching_new" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									GBRM Agent Coaching Form
									<?php if(is_access_coach_module()==true || get_login_type() == "client"){ ?>
									<div class="pull-right">
										<a class="btn btn-primary waves-effect" href="<?php echo base_url(); ?>Qa_agent_coaching_new/add_edit_feedback/0" title="Add Evaluation">Add Feedback</a>
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
										<th>Agent Name</th>
										<th>TL</th>
										<th>Process</th>
										<th>Agent Feedback</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($qa_agent_coaching_new_data as $row){
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['agent_name']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['process_name']; ?></td>
										<td title="<?php echo $row['feedback']; ?>"><?php 
										$msg=strlen($row['feedback']);
										echo ($msg>40)?(substr($row['feedback'],0,40)."..."):($row['feedback']);
										 ?></td>
										<td>
											<?php $mpid=$row['id']; ?>
											
											<a class="btn btn-success" href="<?php echo base_url(); ?>Qa_agent_coaching_new/add_edit_feedback/<?php echo $mpid ?>" title="Edit Evaluation" style="margin-left:5px; font-size:10px;">Edit</a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Agent Name</th>
										<th>TL</th>
										<th>Process</th>
										<th>Agent Feedback</th>
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

<?php include ("qa_coaching_js.php"); ?>