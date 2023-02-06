
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Feedback</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="get" action="">
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
										<label>Agent</label>
										<select class="form-control" name="agent" id="agent">
											<option value="">-Select-</option>
											<?php
											foreach($agent_list as $agentVal)
											{?>
												<option <?php echo $agent == $agentVal['id']?"selected":"";?> value="<?php echo $agentVal['id'];?>"><?php echo $agentVal['name'];?></option>
											<?php
											}
											?>
										</select>
									</div> 
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" type="submit" id='btnView' name='btnView' value="View">View</button>
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
									<div class="pull-left">RPM</div>
									<?php if(is_access_qa_module()==true){ ?>
									<!-- <div class="pull-right">
										<a class="btn btn-primary" href="<?php echo base_url();?>Qa_RPM_Sentry/rpm_dashboard/">Agent Dashboard</a>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_RPM_Sentry/add_rpm_form/">Add Feedback</a>
									</div> -->	
										<div class="col-sm-8">
									<div class="form-group">
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_philipines_raw/import_rpm_form_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<input class="upload-path" disabled />
												<label class="upload">
												<span>Upload Sample</span>
												<input type="hidden" name="star_time" value="<?php echo $stratAuditTimes;?>">
													<input type="file" id="upl_file2" name="file" required>  </label>
												<input type="submit" id="uploadsubmitdata2" name="submit" class="btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group pull-right" > <a href="<?php echo base_url();?>Qa_philipines_raw/sample_rpm_form_download" class="btn btn-success" title="Download Sample rpm_form Excel" download="Sample rpm_form Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url();?>Qa_RPM_Sentry/rpm_dashboard/">Agent Dashboard</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_RPM_Sentry/add_rpm_form/">Add Feedback</a>
								</div>
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
										<th>Audit Date & Time</th>
										<th>Audit Time</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>										
										<th>Total Score %</th>
										<th>Audit Type</th>
										<th>VOC</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$i = 1;
								foreach($rpm_data as $rk=>$rv)
								{
								?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo $rv['auditor_name'];?></td>
										<td><?php echo $rv['audit_date'];?></td>
										<td><?php echo $rv['audit_time'];?></td>
										<td><?php echo $rv['agent_name'];?></td>
										<td><?php echo $rv['l1_name'];?></td>
										<td><?php echo number_format($rv['overall_score'],2);?></td>
										<td><?php echo $rv['audit_type'];?></td>
										<td><?php echo $rv['voc'];?></td>
										<td><a class="btn btn-success" href="<?php echo base_url()."Qa_RPM_Sentry/edit_rpm/".$rv['id']."/"?>" title="Edit Call Feedback" style="margin-left:5px; font-size:10px;">Edit RPM</a></td>
									</tr>
								<?php
								}
								?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date & Time</th>
										<th>Audit Time</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>										
										<th>Total Score %</th>
										<th>Audit Type</th>
										<th>VOC</th>
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
