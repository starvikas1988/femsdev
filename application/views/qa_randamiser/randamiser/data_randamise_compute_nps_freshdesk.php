<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<div class="compute-widget">
							<h4>Compute</h4>
							<hr class="widget-separator">
						</div>
						
						<div class="common-top">
							<h3 class="sub-title">Variation</h3>
							<div class="tabs-widget">								
								<!-- <ul class="nav nav-pills">
									<li class="active"><a data-toggle="pill" href="#enterprise">Enterprise</a></li>
									<li><a data-toggle="pill" href="#manual">Manual</a></li>
								</ul> -->

								<ul class="nav nav-pills">
									<li><a href="<?php echo base_url('qa_sop_library/data_randamise_compute_freshdesk') ?>">CDR</a></li>
									<li class="active"><a href="<?php echo base_url('qa_sop_library/data_randamise_nps_compute_freshdesk') ?>">NPS</a></li>
  								</ul>


							</div>


							<div class="tab-content">
								<div id="manual" class="tab-pane fade in active">
									<form id="form_new_user" method="POST" action="<?php echo base_url('Qa_sop_library/data_randamise_nps_compute_freshdesk'); ?>">
									<div class="filter-widget compute-widget">
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Date Wise</label>
														<input type="date" id="uploadDate" name="from_date" class="form-control" required>
													</div>
												</div> 
												<div class="col-sm-3">
													<div class="form-group">
														<label>Location Wise</label>
														<select id="musltiselect1" class="multiple-select" name="office_id[]" multiple="multiple">
														<?php foreach($location as $loc){ ?>
															<option value="<?php echo $loc['abbr'] ?>"><?php echo $loc['location'] ?></option>
														<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Agent Wise</label>
														<select id="musltiselect5" class="multiple-select" name="agent_id[]" multiple="multiple">
														<?php foreach($nps_agent as $agnt){ ?>
															<option value="<?php echo $agnt['xpoid'] ?>"><?php echo $agnt['agnt_name'] ?></option>
														<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>QA Wise</label>
														<select id="musltiselect7" class="multiple-select" name="qa[]" multiple="multiple">
														<?php foreach($qa as $q){ ?>
															<option value="<?php echo $q['id'] ?>"><?php echo $q['name'] ?></option>
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
															<label>NPS Rating Wise</label>
															<select id="musltiselect8" class="multiple-select" name="nps_rating[]" multiple="multiple">
																<?php foreach($nps_rating as $n1){ ?>
																	<option value="<?php echo $n1['nps_rating'] ?>"><?php echo $n1['nps_rating'] ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="form-group">
															<label>QA Score Wise</label>
															<select id="musltiselect14" class="multiple-select" name="qa_score[]" multiple="multiple">
																<option value="cq_score Between 0 and 55">Below 55</option>
																<option value="cq_score Between 56 and 65">56-65</option>
																<option value="cq_score Between 66 and 75">66-75</option>
																<option value="cq_score Between 76 and 85">76-85</option>
																<option value="cq_score Between 86 and 95">86-95</option>
																<option value="cq_score > 95">95 Above</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-2">
													<div class="form-group">
														<button type="submit" name="submit" value="Submit" id="compute_btn" class="submit-btn1">Compute</button>
													</div>
												</div>
											</div>										
										</div>														
									</form>
								</div>
								
							</div>




							
							<div class="tab-content" style="display:none;">
							
							 
							
								<div id="enterprise" class="tab-pane fade in active">
									<div class="filter-widget compute-widget">
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>Date Wise</label>
													<input type="date" id="uploadDate" name="from_date" class="form-control" required>
												</div>
											</div> 
											<div class="col-sm-3">
												<div class="form-group">
													<label>Vendor Wise</label>
													<select id="musltiselect1" class="multiple-select" name="office_id[]" multiple="multiple">
													<?php foreach($location as $loc){ ?>
														<option value="<?php echo $loc['abbr'] ?>"><?php echo $loc['location'] ?></option>
													<?php } ?>
													</select>
												</div>
											</div>
											<!--<div class="col-sm-3">
												<div class="form-group">
													<label>Manager Wise</label>
													<select id="musltiselect2" class="multiple-select" name="manager_id[]" multiple="multiple">
													<?php foreach($manager as $mgnt){ ?>
														<option value="<?php echo $mgnt['xpoid'] ?>"><?php echo $mgnt['mng_name'] ?></option>
													<?php } ?>
													</select>
												</div>
											</div>-->
											<!--<div class="col-sm-3">
												<div class="form-group">
													<label>AM Wise</label>
													<select id="musltiselect3" class="multiple-select" multiple="multiple">
														<option value="India">India</option>
														<option value="Australia">Australia</option>
														<option value="United State">United State</option>
														<option value="Canada">Canada</option>
														<option value="Taiwan">Taiwan</option>
														<option value="Romania">Romania</option>
													</select>
												</div>
											</div>-->
											<!--<div class="col-sm-3">
												<div class="form-group">
													<label>TL Wise</label>
													<select id="musltiselect4" class="multiple-select" name="tl_id[]" multiple="multiple">
													<?php foreach($tl as $t){ ?>
														<option value="<?php echo $t['xpoid'] ?>"><?php echo $t['tl_name'] ?></option>
													<?php } ?>
													</select>
												</div>
											</div>-->
											<div class="col-sm-3">
												<div class="form-group">
													<label>Agent Wise</label>
													<select id="musltiselect5" class="multiple-select" name="agent_id[]" multiple="multiple">
													<?php foreach($agent as $agnt){ ?>
														<option value="<?php echo $agnt['xpoid'] ?>"><?php echo $agnt['agnt_name'] ?></option>
													<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label>QA Wise</label>
													<select id="musltiselect7" class="multiple-select" name="qa[]" multiple="multiple">
													<?php foreach($qa as $q){ ?>
														<option value="<?php echo $q['id'] ?>"><?php echo $q['name'] ?></option>
													<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<hr>
										<div class="common-top">
											
											<div class="row">
												<!--<div class="col-sm-2">
													<div class="form-group">
														<label>AON Wise</label>
														<select id="musltiselect6" class="multiple-select" name="aon[]" multiple="multiple">
															<option value="30">0-30</option>
															<option value="60">31-60</option>
															<option value="90">61-90</option>
															<option value="120">91-120</option>
															<option value="150">Above 120</option>
														</select>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="wise-widget">
														<div class="form-group">
															<label></label>
															<input type="text" class="form-control" placeholder="Enter Number" name="aon_percentage" value="100">
														</div>
													</div>
												</div>
												
												<div class="col-sm-2">
													<div class="wise-widget">
														<div class="form-group">
															<label></label>
															<input type="text" class="form-control" placeholder="Enter Number" name="qa_percentage" value="100">
														</div>
													</div>
												</div>-->
												<div class="col-sm-2">
													<div class="form-group">
														<label>Call Type Wise</label>
														<select id="musltiselect8" class="multiple-select" name="call_type[]" multiple="multiple">
															<?php foreach($call_type as $r1){ ?>
																<option value="<?php echo $r1['call_type'] ?>"><?php echo $r1['call_type'] ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="wise-widget">
														<div class="form-group">
															<label></label>
															<input type="text" class="form-control" placeholder="Enter Number" name="call_type_percentage" value="100">
														</div>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="form-group">
														<label>Disposition Wise</label>
														<select id="musltiselect9" class="multiple-select" name="disposition[]" multiple="multiple">
															<?php foreach($disposition as $r2){ ?>
																<option value="<?php echo $r2['disposition'] ?>"><?php echo $r2['disposition'] ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="wise-widget">
														<div class="form-group">
															<label></label>
															<input type="text" class="form-control" placeholder="Enter Number" name="disposition_percentage" value="100">
														</div>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="form-group">
														<label>Orientation Type Wise</label>
														<select id="musltiselect10" class="multiple-select" name="orientation_type[]" multiple="multiple">
															<?php foreach($orientation_type as $r3){ ?>
																<option value="<?php echo $r3['orientation_type'] ?>"><?php echo $r3['orientation_type'] ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="wise-widget">
														<div class="form-group">
															<label></label>
															<input type="text" class="form-control" placeholder="Enter Number" name="orientation_type_percentage" value="100">
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-2">
													<div class="form-group">
														<label>Call Status Wise</label>
														<select id="musltiselect11" class="multiple-select" name="call_status[]" multiple="multiple">
															<?php foreach($call_status as $r4){ ?>
																<option value="<?php echo $r4['call_status'] ?>"><?php echo $r4['call_status'] ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="wise-widget">
														<div class="form-group">
															<label></label>
															<input type="text" class="form-control" placeholder="Enter Number" name="call_status_percentage" value="100">
														</div>
													</div>
												</div>
												<!--<div class="col-sm-2">
													<div class="form-group">
														<label>NPS Rating Wise</label>
														<select id="musltiselect11" class="multiple-select" name="nps_rating[]" multiple="multiple">
															<?php foreach($nps_rating as $r5){ ?>
																<option value="<?php echo $r5['nps_rating'] ?>"><?php echo $r5['nps_rating'] ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="wise-widget">
														<div class="form-group">
															<label></label>
															<input type="text" class="form-control" placeholder="Enter Number" name="nps_rating_percentage" value="100">
														</div>
													</div>
												</div>-->
												<div class="col-sm-2">
													<div class="form-group">
														<label>QA Score Wise</label>
														<select id="musltiselect14" class="multiple-select" name="qa_score[]" multiple="multiple">
															<option value="cq_score Between 0 and 55">Below 55</option>
															<option value="cq_score Between 56 and 65">56-65</option>
															<option value="cq_score Between 66 and 75">66-75</option>
															<option value="cq_score Between 76 and 85">76-85</option>
															<option value="cq_score Between 86 and 95">86-95</option>
															<option value="cq_score > 95">95 Above</option>
														</select>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="wise-widget">
														<div class="form-group">
															<label></label>
															<input type="text" class="form-control" placeholder="Enter Number" name="qa_score_percentage" value="100">
														</div>
													</div>
												</div>
											</div>
										</div>
										
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
								</div>
								
								
							<!-----------Manual------------->
								
									<div id="manual" class="tab-pane fade">
										<div class="filter-widget compute-widget">
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Date Wise</label>
														<input type="date" id="uploadDate" name="from_date" class="form-control" required>
													</div>
												</div> 
												<div class="col-sm-3">
													<div class="form-group">
														<label>Vendor Wise</label>
														<select id="musltiselect1" class="multiple-select" name="office_id[]" multiple="multiple">
														<?php foreach($location as $loc){ ?>
															<option value="<?php echo $loc['abbr'] ?>"><?php echo $loc['location'] ?></option>
														<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Agent Wise</label>
														<select id="musltiselect5" class="multiple-select" name="agent_id[]" multiple="multiple">
														<?php foreach($agent as $agnt){ ?>
															<option value="<?php echo $agnt['xpoid'] ?>"><?php echo $agnt['agnt_name'] ?></option>
														<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>QA Wise</label>
														<select id="musltiselect7" class="multiple-select" name="qa[]" multiple="multiple">
														<?php foreach($qa as $q){ ?>
															<option value="<?php echo $q['id'] ?>"><?php echo $q['name'] ?></option>
														<?php } ?>
														</select>
													</div>
												</div>
											</div>
											<hr>
											<div class="common-top">
												<div class="row">
													<div class="col-sm-2">
														<div class="form-group">
															<label>NPS Rating Wise</label>
															<select id="musltiselect8" class="multiple-select" name="nps_rating[]" multiple="multiple">
																<?php foreach($nps_rating as $n1){ ?>
																	<option value="<?php echo $n1['nps_rating'] ?>"><?php echo $n1['nps_rating'] ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="wise-widget">
															<div class="form-group">
																<label></label>
																<input type="text" class="form-control" placeholder="Enter Number" name="nps_rating_percentage" value="100">
															</div>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="form-group">
															<label>QA Score Wise</label>
															<select id="musltiselect14" class="multiple-select" name="qa_score[]" multiple="multiple">
																<option value="cq_score Between 0 and 55">Below 55</option>
																<option value="cq_score Between 56 and 65">56-65</option>
																<option value="cq_score Between 66 and 75">66-75</option>
																<option value="cq_score Between 76 and 85">76-85</option>
																<option value="cq_score Between 86 and 95">86-95</option>
																<option value="cq_score > 95">95 Above</option>
															</select>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="wise-widget">
															<div class="form-group">
																<label></label>
																<input type="text" class="form-control" placeholder="Enter Number" name="qa_score_percentage" value="100">
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-2">
													<div class="form-group">
														<button type="submit" id="compute_btn" class="submit-btn1">Compute</button>
													</div>
												</div>
											</div>										
										</div>
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