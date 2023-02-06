<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<div class="compute-widget">
							<h4>Distribution</h4>
							<hr class="widget-separator">
						</div>
					</div>
					<div class="widget-body">
						<div class="filter-widget1">
						
							<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_randamiser/data_distribute_freshdesk'); ?>">
						
							<div class="row">		
								<div class="col-sm-4">
									<div class="form-group">
										<label>Date Wise </label>
										<input type="date" name="from_date" value="<?php echo $from_date;?>" class="form-control" required>
										<input type="hidden" name="client_id" class="form-control" value=<?php echo $client_id;?>>
										<input type="hidden" name="pro_id" class="form-control" value=<?php echo $pro_id;?>>
									</div>
								</div>
								
													
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" name="submit" value="Submit" class="submit-btn">											
											Submit
										</button>
										
										<?php if(!empty($_SERVER['QUERY_STRING'])): ?>
											
												<a class="btn btn-warning waves-effect" style="width:150px; margin-top: -4px; padding: 10px;"  href="<?php echo base_url()?>Qa_randamiser/download_distributed_data?<?php echo $_SERVER['QUERY_STRING'];?>"><i style="font-size: initial;" class="fa fa-file-excel-o" aria-hidden="true"></i>&emsp;Download Report</a>
											
										<?php endif;?>
									</div>
								</div>
							</div>
							
							</form>
						
						</div>
					</div>
				</div>
				
				<div class="common-top">
					<div class="widget">
						<div class="widget-body no-padding">
						 <form id="qa_assign" method="GET" action="<?php echo base_url('Qa_randamiser/data_distribute_freshdesk'); ?>">
						 <?php //if(get_global_access()==1){?>
							<!--<div class="widget-body">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Assign QA</label>
											<select class="form-control" id="qa_id" name="qa_id" required>
												<option value="">-Select-</option>
												<?php //foreach($qa as $list): ?>
													<option value="<?php //echo $list['id']; ?>"><?php //echo $list['name']; ?></option>
												<?php //endforeach; ?>
											</select>
										</div>
									</div>
									<div class="sol-md-1">
										
									</div>
								</div>
								<div class="row">
									<div class="form-group">
											<input type="hidden" name="from_date" value="<?php //echo $from_date;?>">
											<input class="btn btn-success waves-effect" id="button1" type="submit" name="assign" value="Assign To">
									</div>
								</div>
							</div>-->
						 <?php //}?>
							<div class="table-small table-bg">
								<table class="table table-bordered table-responsive table-striped">
									<thead>
										<tr>
											<th>SL No</th>
											<th>Name</th>
											<th>Fusion ID</th>
											<!--<th>Dialer ID</th>-->
											<th>Date of Creation</th>
											<th>Recording Track ID</th>
											<th>Assign QA</th>
											<th>Action Compute</th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1;
										echo "Client_id : ".$client_id;
										echo "   pro_id : ".$pro_id;
											foreach($sampling_data as $row){ 
											if($client_id==288 && $pro_id==614) $audit_url ="qa_bsnl/add_edit_bsnl/0"; 
										?>
										<tr>
											<td><?php echo $i++ ?> </td>
											<td><?php echo $row['agent_name'] ?></td>
											<td><?php echo $row['fusion_id'] ?></td>
											<!--<td><?php //echo $row['agent_id'] ?></td>-->
											<td><?php echo $row['upload_date'] ?></td>
											<td><?php echo $row['recording_track_id'] ?></td>
											<td><?php echo $row['qa_name'] ?></td>
											<td>
												<?php $ss_id=0; ?>
												
												
												<a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?><?php echo $audit_url;?>/<?php echo $row['id'] ?>" title="Click to View Type of Contact Audit Dasboard" style="font-size:12px; background-color:#800080;">Audit Here</a>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							
						</form>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
	</section>
</div>
