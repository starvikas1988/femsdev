<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<h2 class="avail_title_heading">RTA Validation</h2>
					<hr class="sepration_border" />
					<div class="body-widget clearfix">
						<?php echo form_open('', array('method' => 'get')) ?>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="start_date">Start Date</label>
									<input type="text" class="form-control due_date-cal" id="start_date" value='' name="start_date" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="end_date">End Date</label>
									<input type="text" class="form-control due_date-cal" id="end_date" value='' name="end_date" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group" id="foffice_div">
									<label for="office_id">Location</label>
									<select class="form-control" name="office_id" id="foffice_id">
										<?php
										if (get_global_access() == 1) echo "<option value='ALL'>All</option>";
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
								<!-- .form-group -->
							</div>
							<?php
							//if(get_global_access()==1 || get_role_dir()=="admin" || get_role_dir()=="support" || get_dept_folder()=="mis" || get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm"){
							?>
							<div class="col-md-3">
								<div class="form-group">
									<label for="client_id">Department</label>
									<select class="form-control" name="dept_id" id="fdept_id">
										<?php
										if (get_global_access() == 1 || get_dept_folder() == "mis" || get_dept_folder() == "hr" || get_dept_folder() == "wfm" || get_dept_folder() == "rta" || get_user_id() == '42692') echo "<option value='ALL'>All</option>";
										?>
										<?php foreach ($department_list as $dept) : ?>
											<?php
											$sCss = "";
											if ($dept['id'] == $dept_id) $sCss = "selected";
											?>
											<option value="<?php echo $dept['id']; ?>" <?php echo $sCss; ?>><?php echo $dept['description']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-- .form-group -->
							</div>
							<?php
							//}
							?>
							<div class="col-md-3">
								<div class="form-group margin_all">
									<label for="client_id">Client</label>
									<select class="form-control" name="client_id" id="fclient_id">
										<option value='ALL'>All</option>
										<?php foreach ($client_list as $client) : ?>
											<?php
											$sCss = "";
											if ($client->id == $cValue) $sCss = "selected";
											?>
											<option value="<?php echo $client->id; ?>" <?php echo $sCss; ?>><?php echo $client->shname; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-- .form-group -->
							</div>
							<div class="col-md-3">
								<div class="form-group margin_all">
									<label for="filter_key">Criteria For Custom Report</label>
									<select class="form-control" name="filter_key" id="filter_key">
										<option value=''>--Select--</option>
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
										// if($filter_key=="Role"){
										// 	echo "<option value='Role' selected>Role</option>";
										// 	$rHide = "";
										// 	$rValue=$filter_value;
										// }else echo "<option value='Role'>Role</option>";
										// if($filter_key=="Disposition"){
										// 	echo "<option value='Disposition' selected>Disposition</option>";
										// 	$dHide="";
										// 	$dValue=$filter_value;
										// }else echo "<option value='Disposition'>Disposition</option>";
										// if($filter_key=="OfflineList"){
										// 	echo "<option value='OfflineList' selected>Only Offline Users</option>";
										// }else echo "<option value='OfflineList'>Only Offline Users</option>";
										if ($filter_key == "AOF") {
											echo "<option value='AOF' selected>Agents Of</option>";
											$afHide = "";
											$afReq = "required";
											$afValue = $filter_value;
										} else echo "<option value='AOF'>Agents Of</option>";
										?>
									</select>
								</div>
								<!-- .form-group -->
							</div>
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
										<option value="0">ALL</option>
										<?php
										foreach ($process_list as $process) : ?>
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
							<div class="col-md-3" id="aof_div" <?php echo $afHide; ?>>
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
									<input type="submit" class="btn btn_padding filter_btn save_common_btn btn-md" id='showReports' name='showReports' value="Export to Excel">
								</div>
							</div>
						</div>


						</form>
					</div>
				</div>
			</div>
		</div><!-- .row -->
		<!-- report -->