<style>
	#req_qualification_container {
		display: none;
	}
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<div class="row">
						<div class="col-md-4">
							<div class="avail_widget_br">
								<h4 class="avail_title_heading">Master Mis</h4>
							</div>
						</div>

					</div>
					<hr class="sepration_border">

					<div class="body-widget">
						<form id="form_new_user" method="POST" action="<?php echo base_url(); ?>dfr/master_mis_download">
							<?php //echo form_open('',array('method' => 'get')) 
							?>

							<input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>'>

							<!--<div class="filter-widget">
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start date</label>
											<input type="date" class="form-control" id="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End date</label>
											<input type="date" class="form-control" id="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Location</label>
											<select id="multiselectwithsearch" multiple="multiple">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Requisition</label>
											<select id="multiselectwithsearch" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Brand</label>
											<select id="brand" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Client</label>
											<select id="select-client" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Process</label>
											<select id="select-process" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Department</label>
											<select id="select-department" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" class="submit-btn">
												<i class="fa fa-search" aria-hidden="true"></i>
												Search
											</button>
										</div>
									</div>
								</div>
							</div>-->

							<!--start old backup php code-->
							<div class="row">

								<div class="col-md-3">
									<div class="form-group margin_all">
										<label>Location</label>
										<select class="form-control" name="office_id" id="fdoffice_id">
											<?php
											/*if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";*/
											?>
											<?php foreach ($location_data as $loc) : ?>
												<?php
												$sCss = "";
												if ($loc['abbr'] == $oValue) $sCss = "selected";
												?>
												<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

											<?php endforeach; ?>

										</select>
									</div>
								</div>

								<!--<div class="col-md-3">
									<div class="form-group">
										<label>From Date</label>
										<input type="text" name="from_date" id="from_date" class="form-control">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>To Date</label>
										<input type="text" name="to_date" id="to_date" class="form-control">
									</div>
								</div>---->

								<div class="col-md-3">
									<div class="form-group margin_all">
										<label>Select Client</label>
										<select class="form-control" id="fclient_id" name="client_id">
											<option value='ALL'>ALL</option>
											<?php foreach ($client_list as $client) :
												$cScc = '';
												if ($client->id == $client_id) $cScc = 'Selected';
											?>
												<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?>><?php echo $client->shname; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group margin_all">
										<label>Select Process</label>
										<select class="form-control" id="fprocess_id" name="process_id">
											<option value="">--Select--</option>
											<?php foreach ($process_list as $process) :
												$cScc = '';
												if ($process->id == $process_id) $cScc = 'Selected';
											?>
												<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?>><?php echo $process->name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group margin_all">
										<label class="visiblity_hidden d_block">Export</label>
										<button class="btn btn_padding filter_btn_blue save_common_btn waves-effect" a href="<?php echo base_url() ?>dfr/master_mis_download" type="submit" id='btnView' name='btnView' value="View">Export</button>
									</div>
								</div>
							</div>
							<!--end old backup php code-->


						</form>

					</div>
				</div>
			</div>
		</div>


	</section>
</div>

<script>
	$(document).ready(function() {
		$('.select-box').selectize({
			sortField: 'text'
		});
	});
</script>
<script>
	$(function() {
		$('#multiselect').multiselect();

		$('#multiselectwithsearch').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});
	});
</script>