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
						<form id="get_agent_list_form">
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
								<div class="col-md-3">
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
								<div class="col-md-3">
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
										<label for="view_type">View Type</label>
										<select class="form-control " name="view_type" id="view_type" required>
											<option value=''>--Select--</option>
											<option value="1">Own Team</option>
											<option value="2">Others Team</option>
										</select>
									</div>
								</div>
								<div class="col-md-2" id="others_team_container">
									<div class="form-group">
										<label for="others_team">Others Team</label>
										<select class="form-control " name="others_team" id="others_team" required disabled>
											<option value=''>--Select--</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
								
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label for="others_team">Month</label>
										<select name="performance_for_month" class="form-control" id="performance_for_month" required>
											<option value="">--Select Month--</option>
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
										<label for="others_team">Year</label>
										<select name="performance_for_year" class="form-control" id="performance_for_year" required>
											<option value="">--Select Year--</option>
											<?php
												$firstYear = (int)date('Y') - 1;
												$lastYear = $firstYear + 1;
												for($i=$firstYear;$i<=$lastYear;$i++)
												{
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="search_type">Search Type</label>
										<select name="search_type" class="form-control" id="search_type" required>
											<option value="">--Select Type--</option>
											<option value="1">All Agent</option>
											<option value="2">Individual Agent</option>
										</select>
									</div>
								</div>
								<div class='col-md-2' id="agent_container" >
									<div class="form-group">
										<label for="sch_range">Type Agent Fusion ID</label>
										<input type="text" class="form-control" id="agent_fusion_id" name="agent_fusion_id" required disabled>
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
					<hr class="widget-separator">
					<div class="widget-body clearfix" id="go_back_container">
						
					</div>
					<hr class="widget-separator">
					<div class="widget-body clearfix" id="available_users">
						
					</div>
				</div>
			</div>
		</div>
	</section>
</div>