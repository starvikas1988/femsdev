<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<style>
	.table-small thead{
		position: sticky;
		top: 0;
		left: 0;
	}
	.modal-new .modal-dialog {
  margin: 120px auto!important;
}
	.modal-new .col-md-6{
		width: 100%;
	}
	.modal-new  textarea{
		width: 100%;
		max-width: 100%;
		height:100px!important;
	}
	.modal-new input {
		margin-top: 5px;
 width: 100%;
  height: 40px;
  border-radius: 4px;
  border: 1px solid #ccc;
  padding: 10px;
	}
	.modal-new  .col-md-1{
		margin-top: 0px!important;
	}
.new-row input {
	margin-bottom: 5px;
}
</style>
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
							<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_randamiser_vikas/data_distribute_freshdesk'); ?>">
						
							<div class="row new-row">		
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
											
												<a class="btn btn-warning waves-effect" style="width:150px; margin-top: -4px; padding: 10px;"  href="<?php echo base_url()?>Qa_randamiser_vikas/download_distributed_data?<?php echo $_SERVER['QUERY_STRING'];?>"><i style="font-size: initial;" class="fa fa-file-excel-o" aria-hidden="true"></i>&emsp;Download Report</a>
											
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
						 <form id="qa_assign" method="GET" action="<?php echo base_url('Qa_randamiser_vikas/data_distribute_freshdesk'); ?>">
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
											<!--<th>Date of Creation</th>-->
											<?php if(($client_id!=134 && $pro_id!=753) && ($client_id!=345 && $pro_id!=719) && ($client_id!=266 && $pro_id!=554) && ($client_id!=37 && $pro_id!=49) && ($client_id!=133 && $pro_id!=706)){?>
											<th>Recording Track ID</th>
											<?php }?>
											<th>Assign QA</th>
											
											<th>Non Auditable Action</th>
											<th>Action Compute</th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1;
										
											foreach($sampling_data as $row){ 
											if($client_id==288 && $pro_id==614) 
												{
													if(!empty($row['audit_sheet'])){
														if(strtoupper($row['audit_sheet'])=='IB'){
															$audit_url ="qa_bsnl/add_edit_bsnl/0"; 
														}
														if(strtoupper($row['audit_sheet'])=='OB'){
															$audit_url ="qa_bsnl/add_edit_bsnl_outbound/0"; 
														}
													}else{
														$audit_url ="qa_bsnl/add_edit_bsnl/0"; 
													}
												}
											if($client_id==314 && $pro_id==663) $audit_url ="qa_nurture/add_edit_nurture_booking/0"; 
											if($client_id==246 && $pro_id==529) $audit_url ="qa_cars24/add_edit_cars_pre_booking_new/0"; 
											if($client_id==134 && $pro_id==753) $audit_url ="qa_ameridial/add_tf_new"; 
											$stratAuditTime = date('Y-m-d H:i:s:');
											if($client_id==134 && $pro_id==271) $audit_url ="qa_ameridial/process/blains/add/".$stratAuditTime; 

											//VIKAS START//
											//Mobikwik
											if($client_id==345 && $pro_id==719) $audit_url ="Qa_mobikwik/add_edit_mobikwik/0"; 

											//Cholamandalam
											if($client_id==266 && $pro_id==554) $audit_url ="qa_cholamandlam/add_edit_cholamandlam_collection/0"; 

											//Debt Solution 123
											if($client_id==37 && $pro_id==49) $audit_url ="qa_loanxm/add_edit_loanxm/0"; 
											//Condulent
											if($client_id==133 && $pro_id==706) $audit_url ="Qa_ameridial/add_edit_conduent/0"; 
											
											//VIKAS ENDS//
											
										?>
										<tr>
											<td><?php echo $i++ ?> </td>
											<td><?php echo $row['agent_name'] ?></td>
											<td><?php echo $row['fusion_id'] ?></td>
											<!--<td><?php //echo $row['agent_id'] ?></td>-->
											<!--<td><?php //echo $row['upload_date'] ?></td>-->
											<?php if(!empty($row['recording_track_id'])){?>
											<td><?php echo $row['recording_track_id'] ?></td>
											<?php }?>
											<td><?php echo $row['qa_name'] ?></td>
											<td><a href="javascript:void(0);" randID="<?php echo $row['id']; ?>" cid="<?php echo $client_id;?>" pid="<?php echo $pro_id;?>" disDate="<?php echo date('Y-m-d',strtotime($row['upload_date']));?>" data-toggle="modal" data-target="#nonAuditableModal" class="nonAuditableModal">Non Auditable</a></td>
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

<!-- Non Auditable modal-->

<div class="modal fade modal-new" id="nonAuditableModal" tabindex="-1" role="dialog" aria-labelledby="nonAuditableModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="nonAuditable">Add Non Auditable Reason</h4>
      </div>
      <div class="modal-body">
	  
		
      </div>	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>