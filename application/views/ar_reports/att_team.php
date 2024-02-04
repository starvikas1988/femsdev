<!-- <link rel="stylesheet" href="<?php //echo base_url() 
									?>assets/css/search-filter/css/custom-femsdev.css" /> -->
<!-- report -->
<?php echo form_open('', array('id' => 'report_dwn', 'method' => 'post')) ?>
<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<h2 class="avail_title_heading d_inline">Attendance</h2>
					<span class="small_font d_inline red_bg btn_left"><?php echo $error ?></span>
					<hr class="sepration_border" />
					<div class="body-widget clearfix">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group margin_all">
									<label for="start_date">Start Date</label>
									<input type="text" class="form-control due_date-cal" id="start_date" onselect="check_date();" value='' name="start_date" required autocomplete="off" >
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group margin_all">
									<label for="end_date">End Date</label>
									<input type="text" class="form-control due_date-cal" id="end_date" value='' name="end_date" required autocomplete="off" >
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group margin_all" id="foffice_div">
									<label for="office_id">Location</label>
									<select class="form-control" name="office_id" id="foffice_id">
										<?php
										//if(get_global_access()==1) echo "<option value='ALL'>ALL</option>";
										?>
										<?php foreach ($location_list as $loc) : ?>
											<?php
											$sCss = "";
											if ($loc['abbr'] == $oValue) $sCss = "selected";
											?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>


							<!--	
	<?php
	$sHide = "style='display:none'";
	$sValue = "";
	$aHide = "style='display:none'";
	$aValue = "";
	$pHide = "style='display:none'";
	$pValue = "";
	$dHide = "style='display:none'";
	$dValue = "";
	$rHide = "style='display:none'";
	$rValue = "";
	$afHide = "style='display:none'";
	$afValue = "";
	$afReq = "";
	if ($filter_key == "Agent") {
		echo "<option value='Agent' selected>Agent</option>";
		$aHide = "";
		$aValue = $filter_value;
	} else echo "<option value='Agent'>Agent</option>";
	if ($filter_key == "AOF") {
		echo "<option value='AOF' selected>Agents Of</option>";
		$afHide = "";
		$afReq = "required";
		$afValue = $filter_value;
	} else echo "<option value='AOF'>Agents Of</option>";
	?>
</select>-->
							<input type="hidden" id="exp_dwn" name="exp_dwn" value="0">
							<input type="hidden" name="filter_key" value="AOF">
							<input type="hidden" name="assign_id" value="<?php echo get_user_id(); ?>">

							<!-- .form-group -->

							<div class="col-md-3" id="agent_div" <?php echo $aHide; ?>>
								<div class="form-group margin_all">
									<label for="filter_key">Enter Agent Fusion-ID/OM-ID</label>
									<input type='text' id='agent_id' name='agent_id' value='<?php echo $aValue; ?>' class="form-control" placeholder="Agent Fusion-ID/OM-ID" />
								</div>
								<!-- .form-group -->
							</div>
							<div class="col-md-3" id="process_div" <?php echo $pHide; ?>>
								<div class="form-group margin_all">
									<label for="process_id">Process</label>
									<select class="form-control" name="process_id" id="fprocess_id">
										<option value=''>--Select--</option>
										<?php foreach ($process_list as $process) : ?>
											<?php
											$sCss = "";
											if ($process->id == $pValue) $sCss = "selected";
											?>
											<option value="<?php echo $process->id; ?>" <?php echo $sCss; ?>><?php echo $process->name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-- .form-group -->
							</div>
							<div class="col-md-3" id="disp_div" <?php echo $dHide; ?>>
								<div class="form-group margin_all">
									<label for="disp_id">Disposition</label>
									<select class="form-control" name="disp_id" id="disp_id">
										<option value=''>--Select--</option>
										<?php foreach ($disp_list as $disp) : ?>
											<?php //if($disp->id==1) continue; 
											?>
											<?php
											$sCss = "";
											if ($disp->id == $dValue) $sCss = "selected";
											?>
											<option value="<?php echo $disp->id; ?>" <?php echo $sCss; ?>><?php echo $disp->description; ?></option>
										<?php endforeach; ?>
										<?php if ($filter_value == "2,3,4") echo '<option value="2,3,4" selected>All Absent</option>';
										else echo '<option value="2,3,4">All Absent</option>';
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3" id="role_div" <?php echo $rHide; ?>>
								<div class="form-group margin_all">
									<label for="process_id">Role</label>
									<select class="form-control" name="role_id" id="role_id">
										<option value=''>--Select--</option>
										<?php foreach ($role_list as $role) : ?>
											<?php
											$sCss = "";
											if ($role->id == $rValue) $sCss = "selected";
											?>
											<option value="<?php echo $role->id; ?>" <?php echo $sCss; ?>><?php echo $role->name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-- .form-group -->
							</div>
							<div class="col-md-3" id="aof_div" <?php echo $afHide; ?> style="display:none;">
								<div class="form-group margin_all">
									<label for="process_id">TL/Supervisor/Trainer</label>
									<select class="form-control" name="assign_id" id="assign_id" <?php echo $afReq; ?>>
										<option value=''>--Select--</option>
										<?php foreach ($assign_list as $list) : ?>
											<?php
											$sCss = "";
											if ($list->id == $afValue) $sCss = "selected";
											?>
											<option value="<?php echo $list->id; ?>" <?php echo $sCss; ?>><?php echo $list->tl_name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-- .form-group -->
							</div>
							<div class="col-md-3">
								<div class="form-group margin_all">
									<label class="visiblity_hidden d_block">Export to Excel</label>
									<input type="button" onclick="check_date();" class="btn btn_padding filter_btn save_common_btn btn-md btn-up1" id='exportReports' name='exportReports' value="Export to Excel">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
</div><!-- .row -->
<!-- report -->
<div class="row">
</div><!-- .row -->
</section>
</form>
</div><!-- .wrap -->

<script>
	function check_date() {
		st = $('#start_date').val();
		ed = $('#end_date').val();
		$('#exp_dwn').val(1);
		if(st != ''){
			if(ed != ''){
				if (new Date(ed) < new Date(st)) {
					alert("end date never less then start date ");
					$('#end_date').val('');
					} else {
						$('#report_dwn').submit();
					}
			}else{
				alert("End date are blank ");
			}
			
	}else{
		alert("start date are blank ");
	}
		/*if (new Date(ed) < new Date(st)) {
			alert("end date never less then start date ");
			$('#end_date').val('');
		} else {
			$('#report_dwn').submit();
		}*/
	}
</script>