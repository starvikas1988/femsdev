<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Upload Metrix Target</h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body clearfix">
						<form id="metrix_target_form">
							<div class="row">
								<div class="col-md-3">
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
								<div class="col-md-3">
									<input type="submit" class="btn btn-success btn-block" value="Search" style="margin-top:20px;">
								</div>
							</div>
						</form>
					</div>
					<hr class="widget-separator">
					<div class="widget-body clearfix" id="available_metrix_design">
						
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<!--Update Due Date-->
<div class="modal fade" id="add_target_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Grade</h4>
			</div>
			<form id="add_target_form" method='POST'>
				<div class="modal-body">
					<input type="hidden" id="did" name="did" value="" required>
					<input type="hidden" id="process_id" name="process_id" value="" required>
					<div class="row">
						<div class="col-md-6 form-group">
							<label>Month</label>
							<select name="target_month" class="form-control" id="target_month" required="">
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
						<div class="col-md-6 form-group">
							<label>Year</label>
							<select name="target_year" class="form-control" id="target_year" required>
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
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
									<thead>
										<tr class="bg-info">
											<td>Grade</td>
											<td>Grade Start</td>
											<td>Grade End</td>
										</tr>
									</thead>
									<tbody id="target_table">
										<tr>
											<td>A<input type="hidden" name="grade[]" value="A"></td>
											<td><input type="text" name="grade_start[]" class="form-control" value=">=" readonly></td>
											<td><input type="text" name="grade_end[]" class="form-control" required></td>
										</tr>
										<tr>
											<td>B<input type="hidden" name="grade[]" value="B"></td>
											<td><input type="text" name="grade_start[]" class="form-control" value=">=" readonly></td>
											<td><input type="text" name="grade_end[]" class="form-control" required></td>
										</tr>
										<tr>
											<td>C<input type="hidden" name="grade[]" value="C"></td>
											<td><input type="text" name="grade_start[]" class="form-control" value="<" readonly></td>
											<td><input type="text" name="grade_end[]" class="form-control" required></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>