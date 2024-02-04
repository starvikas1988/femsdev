<style>
	#others_team_container,#agent_container
	{
		display:none;
	}
	#get_metrix {
		display: inline-block;
		width: 200px;
		text-align: center;
		padding: 20px 5px;
		border: 1px dashed 
		#666;
		margin: 4px;
		border-radius: 4px;
		cursor: pointer;
	}
</style>
<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Search Metrix</h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body clearfix">
						<form id="get_tl_list_form">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group" id="foffice_div">
										<label for="office_id">Select a Location</label>
										<select class="form-control" name="office_id" id="foffice_id" required>
											<option value=''>-Select-</option>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if($loc['abbr']==$oValue) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="client_id">Select a Client</label>
										<select class="form-control" name="client_id" id="fclient_id" required>
										
											<?php foreach($client_list as $client): ?>
												
												<?php
												
														$sCss="";
														if($client['id']==$cValue) $sCss="selected";
														
													?>
														<option value="<?php echo $client['id']; ?>" <?php echo $sCss;?>><?php echo $client['shname']; ?></option>
													<?php
												
												?>
												
												<?php endforeach; ?>
																					
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="process_id">Select a process</label>
										<select class="form-control onProcessAction" name="process_id" id="fprocess_id" required>
											<option value=''>ALL Process</option>
											<?php foreach($process_list as $process): ?>
												<?php
													if($process->id ==0 ) continue;
													$sCss="";
													if($process->id==$pValue) $sCss="selected";
												?>
												<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
												
											<?php endforeach; ?>
											
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="others_team">From</label>
										<select name="performance_for_month" class="form-control" id="performance_for_month" required>
											<option value="">--Select Type--</option>
											<option value="01">Jan</option>
											<option value="02">Feb</option>
											<option value="03">Mar</option>
											<option value="04">Apr</option>
											<option value="05">May</option>
											<option value="06">June</option>
											<option value="07">July</option>
											<option value="08">Aug</option>
											<option value="09">Sept</option>
											<option value="10">Oct</option>
											<option value="11">Nov</option>
											<option value="12">Dec</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="others_team">To</label>
										<select name="performance_for_year" class="form-control" id="performance_for_year" required>
											<option value="">--Select Type--</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="others_team">Search</label>
										<input type="submit" class="btn btn-success btn-block" value="Search">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<hr class="widget-separator">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">View Metrix <a onclick="exportF3(this)"><button class="btn btn-xs btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></a></h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body clearfix">
						<div class="table-responsive" id="available_users">
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>