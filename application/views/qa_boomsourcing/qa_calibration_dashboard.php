<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
		font-size:12px;
	}
	
	table.center {
		margin-left:auto; 
		margin-right:auto;
	}
</style>
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_boomsourcing_data_analytics/qa_calibration'); ?>">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo $from_date; ?>" class="form-control">
									</div>
								</div>  
								<div class="col-md-2"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo $to_date; ?>" class="form-control">
									</div> 
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Select Process</label>
										<select class="form-control" name="process_id" id="process_id" required>

										<?php foreach($process_list as $process): ?>

											<option value="<?php echo $process['pro_id'] ?>" <?php echo $process_id == $process['pro_id'] ? 'selected' : '' ?>><?php echo $process['process_name'] ?></option>

											<?php endforeach; ?>								
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Search Ticket ID</label>
										<select class="form-control" id="ticket_id" name="ticket_id[]" multiple="multiple">
											<option value="ALL">ALL</option>
											<?php foreach($ticket as $tk){ ?>
												<option value="<?php echo $tk['ticket_id'] ?>" ><?php echo $tk['ticket_id'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>								
								<div class="col-md-2" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_calibration" type="submit" id='btnView' name='btnView' value="View">View</button>
									<?php if(!empty($_SERVER['QUERY_STRING']) && !empty($master_auditor)):?>
                                          <a class="btn btn-warning" href="<?php echo base_url('Qa_boomsourcing_data_analytics/qa_calibration?').$_SERVER['QUERY_STRING'].'&excel_report=true';?>">EXPORT REPORT</a>
                                    <?php endif;?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>		
		</div>
	
		
		<?php if(!empty($master_auditor)){ ?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table center" cellspacing="0" width="100%" style="width:60%">
								<thead>
									<tr class="bg-info">
										<th colspan=6 class="text-center">Master Auditor Score</th>
									</tr>
									<tr class="bg-default">
										<th>SL</th>
										<th>Auditor</th>
										<th>Location</th>
										<th>Audit Date</th>
										<th>Ticket ID</th>
										<th>Overall Score (%)</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; 
										foreach($master_auditor as $ma){ 
										$masterAudit = $ma['audit_date'];
										$masterScore = $ma['overall_score'];
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $ma['entry_name'] ?></td>
										<td><?php echo $ma['qa_location'] ?></td>
										<td><?php echo $ma['audit_date'] ?></td>
										<td style="font-weight:bold"><?php echo $ma['ticket_id'] ?></td>
										<td><?php echo $ma['overall_score'] ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table center" cellspacing="0" width="100%" style="width:80%">
								<thead>
									<tr class="bg-info">
										<th colspan=9 class="text-center">Regular Auditor Score</th>
									</tr>
									<tr class="bg-default">
										<th>SL</th>
										<th>Auditor</th>
										<th>Location</th>
										<th>Audit Date</th>
										<th>Ticket ID</th>
										<th>Overall Score (%)</th>
										<th>Variance</th>
										<th>Parameter Variance</th>
										<th>Parameter Variance (%)</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach($regular_auditor as $key => $ra){
										
										$varience = ( floatval($ra['ms_overScr']) - floatval($ra['overall_score']) );
										
										$regular_param_col = $ra['regular_param_col'];
										$original_param = $ra['original_param'];
										$param_col_count = $ra['param_col_count'];
										for($i=0;$i<count($regular_param_col);$i++){
											if($ra[$regular_param_col[$i]]!=$ra[$original_param[$i]]) $col[$i]=1;
											else $col[$i]=0;
										}
										$calibration_variance = array_sum($col);
									?>
									<tr>
										<td><?php echo $key + 1; ?></td>
										<td><?php echo $ra['entry_name'] ?></td>
										<td><?php echo $ra['qa_location'] ?></td>
										<td><?php echo $ra['audit_date'] ?></td>
										<td style="font-weight:bold"><?php echo $ra['regular_ticket'] ?></td>
										<td><?php echo $ra['overall_score'] ?></td>
										<td><?php echo $varience ?></td>
										<td>
											
											<?php echo $calibration_variance.'/'.$param_col_count; ?>&nbsp &nbsp
											<a class="btn btn-success btn-xs" href="<?php echo base_url() ?>Qa_boomsourcing_data_analytics/view_calibration_variance/<?php echo $ra["entry_by"] ?>/<?php echo $ra["regular_ticket"] ?>/<?php echo $ra['tableName'];?>" style="font-size:12px" target="_blank"><i class="fa fa-pencil-square-o"> Click Here</i></a>
										</td>
										<td>
											<?php echo Round(($calibration_variance/$param_col_count)*100,2) ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		<?php }else{ ?>
		
		<div class="row col-12">
			<div class="widget widget-body">
				<div class="row col-md-2">
					<div class="form-group"><label>No Master Auditor Data Found</label></div>
				</div>
			</div>
		</div>
		
		<?php } ?>
		
	</section>
</div>
