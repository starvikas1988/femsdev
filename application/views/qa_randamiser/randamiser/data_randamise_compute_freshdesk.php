<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<div class="wrap">
	<section class="app-content">
		
				<div class="widget">
					<div class="widget-body">
						<div class="compute-widget">
							<h4>Compute</h4>
							<hr class="widget-separator">
						</div>
						
						<div class="common-top">
							<h3 class="sub-title">Variation</h3>
						


							<div class="tab-content">
								<div id="enterprise" class="tab-pane fade in active">
									<form id="form_new_user" method="POST" action="<?php echo base_url('Qa_randamiser/data_randamise_compute_freshdesk'); ?>">
									<div class="filter-widget compute-widget">
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>Date Wise <span style="color:#FF0000;font-weight:14px;font-size:14px;">*</span></label>
													<input type="date" id="uploadDate" name="from_date" class="form-control" required>
													<input type="hidden" name="client_id" class="form-control" value=<?php echo $client_id;?>>
													<input type="hidden" name="pro_id" class="form-control" value=<?php echo $pro_id;?>>
												</div>
											</div> 
											<!--<div class="col-sm-3">
												<div class="form-group">
													<label>Location Wise </label>
													<select id="musltiselect1" class="multiple-select" name="office_id[]" multiple="multiple">
													<?php //foreach($location as $loc){ ?>
														<option value="<?php //echo $loc['abbr'] ?>"><?php //echo $loc['location'] ?></option>
													<?php //} ?>
													</select>
												</div>
											</div>-->
										
											
											<div class="col-sm-3">
												<div class="form-group">
													<label>Agent Wise</label>
													<select id="musltiselect5" class="multiple-select" name="fusion_id[]" multiple="multiple">
													<?php foreach($agent as $agnt){ ?>
														<option value="<?php echo $agnt['fusion_id'] ?>"><?php echo $agnt['agnt_name'] ?></option>
													<?php } ?>
													</select>
												</div>
											</div>
											
										</div>
										<hr>
										<div class="common-top">
											<div class="row">
												<div class="col-sm-3">
														<div class="form-group">
															<label>Queue Name</label>
															<select id="call_queue" class="multiple-select" name="call_queue[]" multiple="multiple">
																<?php foreach($queue_name as $queue){ ?>
																<option value="<?php echo $queue['call_queue']?>"><?php echo $queue['call_queue'];?></option>
																<?php }?>
															</select>
														</div>
												</div>
												
												<div class="col-sm-3">
													<div class="form-group">
														<label>AHT in Sec Wise</label>
														<select id="musltiselect14" class="multiple-select" name="call_duration[]" multiple="multiple">
															<option value="aht_sec Between 0 and 60">0-60</option>
															<option value="aht_sec Between 61 and 120">61-120</option>
															<option value="aht_sec Between 121 and 180">121-180</option>
															<option value="aht_sec Between 181 and 240">181-240</option>
															<option value="aht_sec Between 241 and 300">241-300</option>
															<option value="aht_sec > 300">Above 300</option>
														</select>
													</div>
												</div>
												
											</div>
											<div class="row">
												
												
												
												<!--<div class="col-sm-3">
														<div class="form-group">
															<label>Status</label>
															<select id="queue_name" class="multiple-select" name="status[]" multiple="multiple">
																<?php foreach($status as $status){ ?>
																<option value="<?php echo $status['status']?>"><?php echo $status['status'];?></option>
																<?php }?>
															</select>
														</div>
												</div>
												<div class="col-sm-3">
														<div class="form-group">
															<label>Sub Status</label>
															<select id="sub_status" class="multiple-select" name="sub_status[]" multiple="multiple">
																<?php foreach($sub_status as $sub){ ?>
																<option value="<?php echo $sub['sub_status']?>"><?php echo $sub['sub_status'];?></option>
																<?php }?>
															</select>
														</div>
												</div>-->
												
											</div>
											<div class="row">
											
												<div class="common-top">
													<div class="row">
														<div class="col-sm-2">
															<div class="form-group">
																<button type="submit" name="submit" value="Submit" id="compute_btn" class="submit-btn1">Compute</button>
															</div>
														</div>
													</div>
												</div>
										    </div>
								</form>
							</div>
							
						  </div>




							
						
						</div>
					</div>										
				</div>
			</div>
		</div>
		
	</section>
</div>

<div class="loader-bg">
	<div class="lds-roller">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
</div>