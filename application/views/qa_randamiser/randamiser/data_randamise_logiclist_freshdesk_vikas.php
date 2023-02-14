<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<style>
.new-modal .modal-dialog {
  width: 1000px!important;

}
.mTop{
	margin-top: 23px!important;
}
</style>
<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<div class="compute-widget">
							<h4>Logistic</h4>
							<hr class="widget-separator">
						</div>
					</div>
				
					<div class="widget-body">
						<div class="filter-widget compute-widget">
						<FORM action="<?php echo base_url('Qa_randamiser/data_randamise_logiclist_freshdesk'); ?>" method="get">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">										
										<label>From Date</label>
										<input type="date" id="uploadDate" name="from_date" class="form-control" value="<?php echo mysql2mmddyy($from_date);?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">										
										<label>To Date</label>
										<input type="date" id="uploadDateTo" name="to_date" class="form-control" value="<?php echo mysql2mmddyy($to_date);?>" required>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<button type="submit" value="Submit" class="green-btn1 mTop"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
									</div>
								</div>
							</div>
						</FORM>
						</div>
					</div>
				</div>
				
				<div class="common-top">
					<div class="widget">
						<div class="widget-body no-padding">
							<div class="table-small table-bg">
								<table class="table table-bordered table-responsive table-striped">
									<thead>
										<tr>
											<th>Sl</th>
											<th>Compute Date</th>
											<th>Status</th>
											<th>Action Compute</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if(!empty($logicList)){
										$i=1;
										foreach($logicList as $list){?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $list['from_date']; ?></td>
											<td>
											<?php if($list['status']==1) $computeStatus='Active';
													else $computeStatus='In Active';
												echo $computeStatus; 
											?>
											</td>
											<td>
												<a href="<?php echo base_url('Qa_randamiser/compute_logiclist_delete/'); ?>/<?php echo $list['id'];?>/<?php echo $client_id;?>/<?php echo $pro_id;?>" class="edit-btn">
													<i class="fa fa-trash" aria-hidden="true"></i>
												</a>
												<!--<a href="<?php echo base_url('Qa_randamiser/compute_again_logiclist/'); ?>/" title="Compute Again" class="edit-btn">
													<i class="fa fa-clone" aria-hidden="true"></i>
												</a>-->
												<a href="javascript:void(0);" bid="<?php echo $list['id']; ?>" data-toggle="modal" data-target="#computeAgainModal" class="computeAgainModal edit-btn" style=" margin-left:15px;">
													<i class="fa fa-clone" aria-hidden="true"></i>
												</a>
												<a href="javascript:void(0);" bid="<?php echo $list['id']; ?>" cid="<?php echo $client_id; ?>" pid="<?php echo $pro_id; ?>" data-toggle="modal" data-target="#computeDetailsModal" class="computeDetailsModal edit-btn" style=" margin-left:15px;">
													<i class="fa fa-eye" aria-hidden="true"></i>
												</a>
											</td>
										</tr>
										<?php 
										$i++;
										}
										}else{
											?>
										<tr>
											<td colspan=4 align="center">
												No Record Found.
											</td>
											
										</tr>	
										<?php 
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
	</section>
</div>


<!---- Modal open ------>

<div class="modal fade" id="computeAgainModal" tabindex="-1" role="dialog" aria-labelledby="computeAgainModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="createBucketTitle">Compute Again</h4>
      </div>
      <div class="modal-body">
	  
		
      </div>	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- -->


<!--        End    ----->


<!---- Modal open for Compute Details------>

<div class="modal fade new-modal" id="computeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="computeDetailsModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="createBucketTitle">Compute Conditions</h4>
      </div>
      <div class="modal-body">
	  
		
      </div>	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- -->