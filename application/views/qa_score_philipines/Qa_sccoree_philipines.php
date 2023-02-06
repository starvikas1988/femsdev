<style>
td{font-size:12px;}#default-datatable th{font-size:12px;}#default-datatable th{font-size:12px;}.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {padding:2px;text-align: center;}.lbl_chk_all{padding:0px 5px;background-color:#ddd;}.lbl_chk{padding:0px 5px;}.updateRows{background-color:#ADEBAD;}
</style>

<div class="wrap">
	<section class="app-content">
		
		<!-- Sourav 25-08-2022 -->
		<div class="row" style="display:block;">
			<div class="col-md-12">
				<div class="widget row">
					<div class="widget-body table-responsive">
					  <form id="form_new_user" method="GET" action="<?php echo base_url('Qa_sccoree_philipines'); ?>">
							<div class="row">
								<div class="col-md-3 monthInfo" <?php echo $report_type == "date" ? 'style="display:none"' : ''; ?>>
								<div class="form-group" style="padding:2px 10px 2px 0px">
									<label for="ssdate">Search Month</label>
									<select class="form-control" name="select_month" id="select_month">								
										<?php
										for($i=1;$i<=12;$i++){
											$selectin = "";
											if($selected_month == $i){ $selectin = "selected"; }					
										?>
										<option value="<?php echo sprintf('%02d', $i); ?>" <?php echo $selectin; ?>>
										<?php echo date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01')); ?>
										</option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="col-md-3 monthInfo" <?php echo $report_type == "date" ? 'style="display:none"' : ''; ?>>
								<div class="form-group" style="padding:2px 10px 2px 0px">
									<label for="ssdate">Search Year</label>
									<select class="form-control" name="select_year" id="select_year">								
										<?php
										$current_y = date('Y');
										$last_y = $current_y - 5;
										for($j=$current_y;$j>=$last_y;$j--){
											$selectiny = "";
											if($selected_year == $j){ $selectiny = "selected"; }
										?>
										<option value="<?php echo $j; ?>" <?php echo $selectiny; ?>>
										<?php echo $j; ?>
										</option>
										<?php } ?>
									</select>
								</div>
							</div>
								 
								<div class="col-md-2" style="margin-top:20px">
									<button class="btn btn-success waves-effect" style="width:150px" a href="<?php echo base_url()?>Qa_sccoree_philipines" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>

							</div>
						</div>
					  </form>
					</div>
					 
				</div>
			</div>
		</div>
		<!-- Sourav 25-08-2022 -->
		<div class="widget">
		    <hr class="widget-separator" />
		    <div class="widget-head clearfix" style="background-color: #f1f2f3; padding: 10px; color: #a70000;">
		        <div class="row">
		            <div class="col-md-4">
		                <h4 style="padding-left: 10px;"><i class="fa fa-bar-chart"></i>Score DASHBOARD:</h4>
		            </div>
		        </div>
		    </div>
		    <div class="widget-body clearfix">
		        <div class="row">
		            <div class="col-md-12">
		                <div class="table-responsive">
		                    <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
								<thead>
									<tr class="bg-info">
										<th class="text-center">SL No</th>
										<th class="text-center">Campaign / Client</th>
										<th class="text-center">LOB / Process</th>
										<th class="text-center">Site</th>
										<th class="text-center">MTD QA Score</th>
										
										<th class="text-center">Customer Critical-MTD</th>
										<th class="text-center">Business Critical -MTD</th>
										<th class="text-center">Compliance Critical -MTD</th>
										
										
										<th class="text-center">Count of Auto Fail / Auto Zero</th>
									</tr>
								</thead>
								<tbody style="text-align: center;">
									<?php $i=1;

									if($resultData){
										// echo"<pre>";
										// print_r($resultData);
										// echo"</pre>";
										$customer_cnt = 0;
										$business_cnt = 0;
										$compliance_cnt = 0;
										foreach($resultData as $ad){
											if($ad['clientName']!=''){
												?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $ad['clientName']; ?></td>
											<td><?php echo $ad['processName']; ?></td>
											<td><?php echo $ad['qa_location']; ?></td>
											<td><?php echo $ad['cq_score']; ?></td>
											
											<?php
											if($ad['customer_score']!=null)
											{
												if($ad['customer_cnt'] == 0){

													$customer_cnt = 1;

												}
												else{
													$customer_cnt = $ad['customer_cnt'];
												}
												// echo $ad['customer_score'];
												// echo"<br>";echo"<br>";
												// echo $ad['customer_cnt'];
												// echo"<br>";echo"<br>";
												?>
												<td><?php echo is_nan($ad['customer_score']) ? "-" : number_format(($ad['customer_score']/$customer_cnt),2);?></td>
												<?php
											}else{
												?>
												<td><?php echo"-"; ?></td>
												<?php
											}	
											 ?>

											 <?php
											if($ad['business_score']!=null)
											{
												if($ad['business_cnt'] == 0){

													$business_cnt = 1;

												}
												else{
													$business_cnt = $ad['business_cnt'];
												}
												?>
												<td><?php echo is_nan($ad['business_score']) ? "-" : number_format(($ad['business_score']/$business_cnt),2);?></td>
												<?php
											}else{
												?>
												<td><?php echo"-"; ?></td>
												<?php
											}	
											 ?>

											 <?php
											if($ad['complience_score']!=null)
											{
												if($ad['compliance_cnt'] == 0){

													$compliance_cnt = 1;

												}
												else{
													$compliance_cnt = $ad['compliance_cnt'];
												}
												?>
												<td><?php echo is_nan($ad['complience_score']) ? "-" : number_format(($ad['complience_score']/$compliance_cnt),2);?></td>
												<?php
											}else{
												?>
												<td><?php echo"-"; ?></td>
												<?php
											}	
											 ?>
											<td><?php echo $ad['autoFail']; ?></td>
										</tr>
												<?php

											}
										?>
									<?php } 
									}
									 
									?>
									
								</tbody>
							</table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>	
	</section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>