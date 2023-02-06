<style>
	td{
		font-size:12px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	.lbl_chk_all{
		padding:0px 5px;
		background-color:#ddd;
	}
	
	.lbl_chk{
		padding:0px 5px;
	}
	
	.updateRows{
		background-color:#ADEBAD;
	}
	
</style>


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget row">
					<div class="widget-body table-responsive">
					  <form id="form_new_user" method="GET" action="<?php echo base_url('Qa_tni_dashboard_boomsourcing'); ?>">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Select Process</label>
									<select class="form-control" id="process_id" name="process_id" required>
										<option value="">--Select a Process--</option>
										<?php foreach($process_list as $pl){
											if($process_id == $pl['pro_id']) $pro_sel="selected";
											else $pro_sel="";
										?>
											<option <?php echo $pro_sel;?> value="<?php echo $pl['pro_id'];?>"><?php echo ucfirst(str_replace("_"," ",str_replace(array("qa_","_feedback"),"",$pl['process_name'])));?></option>
										
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Location</label>
									<select class="form-control" id="office_id" name="office_id[]" multiple="multiple">
										<option value="ALL">ALL</option>
										<?php foreach($location_list as $lc){
											$sel="";
											if($lc['abbr']==$office_id) $sel='selected';
										?>
											<option value="<?php echo $lc['abbr'] ?>" <?php echo $sel;?>><?php echo $lc['location'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>From Date (mm/dd/yyyy)</label>
									<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control">
								</div>
							</div>  
							<div class="col-md-2"> 
								<div class="form-group">
									<label>To Date (mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control">
								</div> 
							</div>
							<div class="col-md-12" style="margin-top:20px">
								<button class="btn btn-success waves-effect" style="width:150px" type="submit" id='btnView' name='btnView' value="View">View</button>
							</div>
						</div>
					  </form>
					  <?php if(!empty($tot_param)){ ?>
					  <form id="form_new_user" method="GET" action="<?php echo base_url('Qa_tni_dashboard_boomsourcing/download_TNI_rep'); ?>">
					  <div class="row">
						  <div class="col-md-8" style="margin-top:20px">
							<input type="hidden" name="get_process_id" id="get_process_id" value="<?php echo $process_id;?>">
							<input type="hidden" name="get_location_id" id="get_location_id" value="<?php echo implode(',',$office_id);?>">
							<input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date?>">
							<input type="hidden" name="to_date" id="to_date" value="<?php echo $to_date?>">
						  </div>
						  <div class="col-md-2 text-right" style="margin-top:20px">
								<button class="btn btn-success waves-effect" style="width:150px" type="submit" id='btnView' name='btnView' value="View">Export</button>
						  </div>
						  <!--<div class="col-md-2 text-right" style="margin-top:20px">
								<button class="btn btn-success waves-effect" style="width:150px" type="submit" id='btnEmail' name='btnEmail' value="Email">Send Email</button>
						  </div>-->
					  </div>
					  </form>
					  <?php }?>
					</div>
				</div>
			</div>
		</div>
		
		<?php if(!empty($tot_param)){ 
		$params_columns = explode(',',$tot_param);
		?>
		
		<div class="row">
			<div class="col-md-6">
				<div class="widget">
					<div class="widget-body table-responsive">
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
							<thead>
								<tr class="bg-info">
									<th class="text-center">##</th>
									<th class="text-center">Agent Count</th>
								</tr>
							</thead>
							<tbody style="text-align: center;">
								<tr><td>100%-95%</td><td><?php echo $ovr95_100['value'] ?></td></tr>
								<tr><td>95%-90%</td><td><?php echo $ovr90_95['value'] ?></td></tr>
								<tr><td>90%-85%</td><td><?php echo $ovr85_90['value'] ?></td></tr>
								<tr><td>Below 85%</td><td><?php echo $ovr84['value'] ?></td></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body table-responsive">
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
							<thead>
								<tr class="bg-info">
									<th rowspan=2 class="text-center">##</th>
									<th rowspan=2 class="text-center">Agent</th>
									<th rowspan=2 class="text-center">Total Audit</th>
									<th colspan=<?php echo count($params_columns);?> class="text-center">Parameter</th>
								</tr>
								<tr class="bg-info">
									<?php $params_columns = explode(',',$tot_param);
									foreach($params_columns as $prm){ ?>
										<th class="text-center"><?php echo ucwords(str_replace('_', ' ', $prm)); ?></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody style="text-align: center;">
								<?php $i=1;
								foreach($tot_audit as $ta){ ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo $ta['name']; ?></td>
									<td><?php echo $ta['tot_adt']; ?></td>
									<?php foreach($params_columns as $prm){?>
									<td><?php echo $ta[$prm]; ?></td>
									<?php }?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body table-responsive">
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
							<thead>
								<tr class="bg-info">
									<th rowspan=2 class="text-center">##</th>
									<th rowspan=2 class="text-center">Agent</th>
									<th rowspan=2 class="text-center">Total Audit</th>
									<th colspan=<?php echo count($params_columns);?> class="text-center">Parameter (%)</th>
								</tr>
								<tr class="bg-info">
									<?php $params_columns = explode(',',$tot_param);
									foreach($params_columns as $prm){ ?>
										<th class="text-center"><?php echo ucwords(str_replace('_', ' ', $prm));?></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody style="text-align: center;">
								<?php $i=1;
								foreach($tot_audit as $ta){ ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo $ta['name']; ?></td>
									<td><?php echo $ta['tot_adt']; ?></td>
									<?php foreach($params_columns as $prm){?>
									<td><?php echo round((($ta[$prm]/$ta['tot_adt'])*100), 2).'%'; ?></td>
									<?php }?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<?php } ?>
		
	</section>
</div>

