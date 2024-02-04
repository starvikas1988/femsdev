<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<style >
.filter-widget .multiselect-container {
  height: 200px;
  overflow-y: scroll;
  width: 100%;
}
</style>
<div class="wrap">
	<section class="app-content">
        <div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title" style="display:inline-block; line-height:30px">Leave Availability</h4>
                        
                        <?php if($leave_accessible) :?>
                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#myModal">Apply Leave</button>
							
							<?php if($active_ptl == 1): ?>
								<button class="btn btn-success btn-sm pull-right" style="margin-right:10px;" data-toggle="modal" data-target="#myPTLModal">Upload PTL Documents</button>
							<?php endif; ?>
							
                        <?php else: ?>
                            <button class="btn btn-primary btn-sm pull-right" disabled data-toggle="modal" data-target="#myModal">Apply Leave</button>
                        <?php endif; ?>
                    </header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
                        <table class="table table-responsive table-bordered">
                        <tr> 
                            <td class="bg-primary">Leave Types</td>
                            <?php foreach($leaves_available as $leave): ?>
                                <?php if($leave["leave_details"]["show_in_dashboard"] != 0 && $leave["leave_details"]["leave_allowed"] != 0): ?>
                                    <td class="text-center"><?php echo $leave["leave_type"] ?></td>
                                <?php endif; ?>                                
                            <?php endforeach; ?>    
                        </tr>
                        <tr> 
                            <td class="bg-primary">Available</td>
                            <?php foreach($leaves_available as $leave): ?>
								
                                <?php if($leave["leave_details"]["show_in_dashboard"] != 0 && $leave["leave_details"]["leave_allowed"]): ?>
                                <?php 
                                   
                                    // if($handover_date!='')
                                    // {
                                    //     $_date_join = date_create($handover_date);
                                    // }
                                    // else
                                    // {
                                    //     $_date_join = date_create($date_of_joining);
                                    // }
									$_date_join = date_create($date_of_joining);
									//print $_date_join;
									
                                    $diff = date_diff(date_create(date('Y-m-d')), $_date_join);
									
									//print_r($diff); 
									
                                    if( (int)$diff->format("%a") >= $leave["leave_details"]["show_after_days"]): 
                                ?>  
                                    <td class="text-center">
                                        <?php 
                                            $leave_bal = $leave["leave_details"]["leave_present"];
											
											if($user_office_id == 'JAM'){
												//if($leave_bal < 1) echo floor($leave_bal);
												//else echo round($leave_bal);
												
												$n = $leave_bal - (int)$leave_bal;
																								
												if($n == 0.96){
													echo round($leave_bal);
												}else{
													if((int)$leave_bal < 1){ 
														echo floor($leave_bal);
													}else{
														echo round($leave_bal);
													}
												}
											}elseif($user_office_id == 'CEB'){
												echo $leave_bal;
											}else{
												//echo round($leave_bal);
                                                //Leave applied type for CL SL PL CO IND Location
                                                echo number_format($leave_bal, 1);
											}
                                        ?>
                                    </td>
                                <?php else: ?>
                                <td class="text-center">0</td>
                                <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>    
                        </tr>                    
                        </table>
                    </div>
                </div>
            </div>
        </div> 

        <div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Leave History</h4>
					</header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
						<div class="row">
                            <table class="table table-responsive table-bordered">
                            <thead>
                                <tr class="text-center bg-primary">
                                    <th width="50px" style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Leave Type</th>
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">From</th>
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">To</th>
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">No. Of Day(s)</th>
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Applied For</th>    
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Applied On</th>  
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Status</th> 
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Reason To Reject</th>
									<?php if(in_array($user_office_id, array('KOL', 'HWH', 'BLR', 'NOI', 'CHE'))): ?>
										<th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Cancel</th>
									<?php endif; ?>
									
									<?php if(get_assigned_to() == '8' || get_assigned_to() == '9'): ?>
										<th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Action</th>
									<?php endif; ?>
									
                                </tr>
                            </thead>
                            <?php foreach($leaves_applied as $leave): ?>
                                <tr style="font-size:85%">
                                    <td style="font-size:80%">
                                        <?php 
                                            echo $leave->abbr;
                                            if($leave->additional_lt != null) echo " + ".$leave->additional_lt;
                                        ?>
                                    </td>
                                    <td style="font-size:80%"><?php echo $leave->from_dt ?></td>
                                    <td style="font-size:80%">
                                        <?php 
                                            if($leave->no_of_additional_leaves != null){
                                                echo date('Y-m-d', strtotime($leave->to_dt. ' + '.$leave->no_of_additional_leaves.' days'));
                                            } else{
                                                echo $leave->to_dt;
                                            }
                                            
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        if (get_user_office_id()=="CAS") {
                                            if($leave->status == '1') echo number_format($leave->no_of_leave_approve, 1). " Day(s)";
                                            else echo number_format($leave->no_of_leave,1). " Day(s)";
                                        }
                                        else {
                                            if ($leave->applied_type == 1) {
                                                $_from_date = strtotime($leave->from_dt);
                                                $_to_date = strtotime($leave->to_dt);
                                                
                                                if($_from_date == $_to_date) $diff = 1;
                                                else $diff = 1 + round(($_to_date - $_from_date)/60/60/24);
                                                
                                                echo $diff." Day(s)";

                                                if($leave->no_of_additional_leaves != null) echo " + ".$leave->no_of_additional_leaves." Days";
                                            }
                                            else {
                                                echo "0.5 Day(s)";
                                            }
                                        }
                                        ?>
                                    </td>  
                                    <td> 
                                        <?php
                                        if ($leave->applied_type == 1) echo "Full Day";
                                        else echo "Half Day";
                                        ?>
                                    </td> 
                                    <td style="font-size:80%"><?php echo $leave->apply_date ?></td>  
                                    <td style="font-size:100%" class="text-center">
                                        <?php 
                                            if($leave->status == '1') echo "<span class='label label-success'>Approved</span>";
                                            else if($leave->status == '2') echo "<span class='label label-danger'>Rejected</span>"; 
											else if($leave->status == '3') echo "<span class='label label-danger'>Cancelled</span>";
                                            else echo "<span class='label label-primary'>Pending</span>"; 
                                        ?> 
                                    </td>
									<td style="font-size:80%"><?php
                                        if ($leave->reject_reason != "") echo $leave->reject_reason;
                                        else echo "-";
                                    ?></td>
									<td style="font-size:80%; text-align:center">
										<?php if($leave->status == '0' && in_array($user_office_id, array('KOL', 'HWH', 'BLR', 'NOI', 'CHE'))): ?>
											<button type="button" class="btn btn-danger btn-xs" style="font-size:9px; width:55px" onclick="cancel_leave(<?php echo $leave->id; ?>)">Cancel</button>
										<?php endif; ?>
									</td>    
									<?php if(get_assigned_to() == '8' || get_assigned_to() == '9'): ?>
										<td style="font-size:80%">
											<?php if($leave->status != '1'): ?>
												<button type="button" class="btn btn-success btn-xs" style="font-size:9px; width:55px" onclick="approve_leave(<?php echo $leave->id; ?>)">Approve</button>
											<?php endif; ?>
										</td>
									<?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            <tfoot>
                                <tr class="text-center bg-primary">
                                    <th style="font-size:85%" class="text-center">Leave Type</th>
                                    <th style="font-size:85%" class="text-center">From</th>
                                    <th style="font-size:85%" class="text-center">To</th>
                                    <th style="font-size:85%" class="text-center">No. Of Day(s)</th> 
                                    <!-- Leave applied type for CL SL PL CO IND Location -->
                                    <th style="font-size:85%" class="text-center">Applied For</th> 
                                    <th style="font-size:85%" class="text-center">Applied On</th>  
                                    <th style="font-size:85%" class="text-center">Status</th>
                                    <th style="font-size:85%;" class="text-center">Reason To Reject</th> 
									<?php if(in_array($user_office_id, array('KOL', 'HWH', 'BLR', 'NOI', 'CHE'))): ?>
										<th style="font-size:85%;" class="text-center">Cancel</th>
									<?php endif; ?>
									<?php if(get_assigned_to() == '8' || get_assigned_to() == '9'): ?>
										<th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Action</th>
									<?php endif; ?>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
</div>

<!-- Modal -->

<style>
label{ font-size:100%; font-weight:bold; }
</style>

<div id="myModal" class="modal fade" role="dialog" style="font-size:90%; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" id="leave_form" enctype="multipart/form-data">
                <div class="modal-header" style="padding:8px 15px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Leave Application</h4>
                </div>
                <div class="modal-body filter-widget">
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">Employee Name</label>
                            <div class="col-md-8"><?php echo get_username(); ?></div>
                        </div>
                    </div>
                    <!--
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">Employee Code</label>
                            <div class="col-md-8"><?php echo get_user_fusion_id(); ?></div>
                        </div>
                    </div>
                    -->
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Leave Type <i class="fa fa-asterisk" style="font-size:6px; color:red; vertical-align:super;"></i></label>
                            <div class="col-md-8">
                                <?php 
                                    // if($handover_date!='')
                                    // {
                                    //     $_date_join = date_create($handover_date);
                                    // }
                                    // else
                                    // {
                                    //     $_date_join = date_create($date_of_joining);
                                    // }
                                    $_date_join = date_create($date_of_joining);
                                    $diff = date_diff(date_create(date('Y-m-d')), $_date_join);
                                    
                                ?>
                                <select class="form-control" id="form-leave_type" name="leave_criteria_id" required>
                                    <option value="">Select</option>
                                    <?php foreach($leave_structure as $leave): ?>
                                        <?php if($leave["leave_access_allowed"] == 1): ?>
                                            <?php                                                 
                                                if( (int)$diff->format("%a") >= $leave["show_after_days"]): 
                                            ?>
                                                <option value="<?php echo $leave["leave_criteria_id"]; ?>">
                                                    <?php echo $leave["description"]; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="leave_type_id" id="leave_type_id">
                            </div>
                        </div>
                    </div>

                    <!-- IF HAS SUBSECTIONS -->
                        <div class="row sub_sections" style="padding:3px 0px; display:none;">
                            <div class="form-group">
                                <label class="col-md-4" style="line-height:37px;">Leave Sub Sections</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="sub_sections" id="sub_select_select">
                                    </select>
                                </div>
                            </div>
                        </div>
                    <!-- END SUB SECTIONS -->

                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">Available Balance</label>
                            <div class="col-md-8" id="leave-balance"></div>
                        </div>
                    </div>
					
					<!-- PTL ACCESS INDIA -->
					<div class="row" id="ptl_div_india" style="display:none; padding:3px 5px;">
						<div class="row" style="padding:3px 0px;">
							<div class="form-group">
								<label class="col-md-4" style="line-height:37px;">Delivery Date</label>
								<div class="col-md-8">
									<input type="date" name="delivery_date" class="form-control" id="delivery_date">
								</div>
							</div>
						</div>
						<div class="row" style="padding:3px 0px;">
							<div class="form-group">
								<label class="col-md-4" style="line-height:37px;">Child's first name</label>
								<div class="col-md-8">
									<input type="text" name="child_first_name" class="form-control" id="child_first_name">
								</div>
							</div>
						</div>
						<div class="row" style="padding:3px 0px;">
							<div class="form-group">
								<label class="col-md-4" style="line-height:37px;">Child's last name</label>
								<div class="col-md-8">
									<input type="text" name="child_last_name" class="form-control" id="child_last_name">
								</div>
							</div>
						</div>
						<div class="row" style="padding:3px 0px;">
							<div class="form-group">
								<label class="col-md-4" style="line-height:37px;">Upload Document <span style="color: red;">(**Only PDF file is allowed, Max file size: 5MB)</span></label>
								<div class="col-md-8">
									<input type="file" name="discharge_report" class="form-control" id="discharge_report">
								</div>
							</div>
						</div>
					</div>
					<!-- -->
                    <!-- MOROCO WEDDING LEAVE -->
                    <div class="row" id="wedding_div_moroco" style="display:none; padding:3px 5px;">
                        <div class="row" style="padding:3px 0px;">
                            <div class="form-group">
                                <label class="col-md-4" style="line-height:37px;">Wedding Date</label>
                                <div class="col-md-8">
                                    <input type="date" name="wedding_date" class="form-control" id="wedding_date">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding:3px 0px;">
                            <div class="form-group">
                                <label class="col-md-4" style="line-height:37px;">Wedding </label>
                                <div class="col-md-8">
                                    <input type="file" name="wedding_doc" class="form-control" id="wedding_doc">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- -->
                    <!-- MOROCO DEATH -->
                    <div class="row" id="death_div_moroco" style="display:none; padding:3px 5px;">
                        <div class="row" style="padding:3px 0px;">
                            <div class="form-group">
                                <label class="col-md-4" style="line-height:37px;">Death Date</label>
                                <div class="col-md-8">
                                    <input type="date" name="death_date" class="form-control" id="death_date">
                                </div>
                            </div>
                        </div>
                       
                        <div class="row" style="padding:3px 0px;">
                            <div class="form-group">
                                <label class="col-md-4" style="line-height:37px;">Death </label>
                                <div class="col-md-8">
                                    <input type="file" name="death_doc" class="form-control" id="death_doc">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- -->
                    <!-- MOROCO SURGERY LEAVE -->
                    <div class="row" id="surgery_div_moroco" style="display:none; padding:3px 5px;">
                        <div class="row" style="padding:3px 0px;">
                            <div class="form-group">
                                <label class="col-md-4" style="line-height:37px;">Surgery Date</label>
                                <div class="col-md-8">
                                    <input type="date" name="surgery_date" class="form-control" id="surgery_date">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="padding:3px 0px;">
                            <div class="form-group">
                                <label class="col-md-4" style="line-height:37px;">Wedding </label>
                                <div class="col-md-8">
                                    <input type="file" name="surgery_doc" class="form-control" id="surgery_doc">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- -->
                     <!-- Applicable for Holiday  -->
                    <div class="row holiday_dates_div" style="padding:3px 0px; display: none" >
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Select Dates <i class="fa fa-asterisk" style="font-size:6px; color:red; vertical-align:super;"></i></label>
                            <div class="col-md-8">
                                <select id="apply_holiday_date" name="apply_holiday_date[]" autocomplete="off" placeholder="Select Dates" multiple required>
                                    <?php foreach ($holiday_mst as $value) {
                                        $date_value_r = $value['holiday_date'];
                                        $date_value_h = date("m/d/Y", strtotime($date_value_r));
                                        $current_year = date("Y", strtotime($date_value_r));
                                        if($current_year == date('Y'))
                                        {

                                        if($date_of_joining > $value['holiday_date']) $btn_disabled = "disabled";
                                        else $btn_disabled = "";
                                    ?>
                                    <option <?=$btn_disabled?> value="<?=$date_value_h?>"><?=$value['holiday_date']?> (<?=$value['description']?>)</option>
                                    <?php } } ?>    
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- -->    
                    <div class="row" id="ml_file_upload" style="padding:3px 0px; display: none;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Select a file (**Only PDF file allowed, <span style="color: red">Max file size: 5MB</span>.)<span style="color: red;">*</span></label>
                            <div class="col-md-8">
                                <input type="file" id="file_upload_ml" name="ml_file_upload" class="form-control">
                            </div>
                        </div>
                    </div> 
                    <!-- Leave applied type for CL SL PL CO IND Location -->
                    <div id="leave_applied_type_full_half" style="padding:3px 0px;">
                    </div>   

                    <div class="row from_date_h" style="padding:3px 0px;">
                        <div class="col-md-12" style="padding:0;">
                        <div class="form-group">
                            <label class="col-md-4"  style="line-height:37px;">From Date <i class="fa fa-asterisk" style="font-size:6px; color:red; vertical-align:super;"></i></label>
                           <div class="col-md-8">
                         <input disabled autocomplete="off" type="text" name="from_date" class="form-control" id="from_date" required>
                     </div>
                        </div>
                        </div>
                    </div>
                    <!-- up the code from date section -->


                    <div class="row to_date_h" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">To Date <i class="fa fa-asterisk" style="font-size:6px; color:red; vertical-align:super;"></i></label>
                            <div class="col-md-8">
                                <input disabled autocomplete="off" type="text" name="to_date" class="form-control" id="to_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" style="padding:5px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">No. of Day(s)</label>
                            <div class="col-md-8" id="no_of_days"></div>
                        </div>
                    </div>
                    
                    <!-- FOR JAM -->
                    <div class="row" id="additional_section_JAM" style="padding:13px 0px;display:none;">
                        <div class="form-group">
                            <label class="col-md-4">Apply From Other Leaves</label>
                            <div class="col-md-8" id="no_of_days">
                                <input type="checkbox" value="1" name="apply_additional_leaves" id="apply_from_vl">
                            </div>
                        </div>                           
                    </div>                    

                    <div class="row additional_section_JAM" style="padding:3px 0px;display:none;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">No. of Additional Leaves</label>
                            <div class="col-md-8">
                                <select class="form-control" name="no_of_additional_leaves" id="additional_leaves_select">
                                </select>
                            </div>
                        </div>                           
                    </div>

                    <!-- JAM CLOSED -->

                    <div class="row" style="padding:13px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">Reporting Head</label>
                            <div class="col-md-8" id="reporting-head"><?php echo get_assigned_to_name() ?></div>
                        </div>
                    </div>
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">Reason <i class="fa fa-asterisk" style="font-size:6px; color:red; vertical-align:super;"></i></label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="reason" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Contact Details <i class="fa fa-asterisk" style="font-size:6px; color:red; vertical-align:super;"></i></label>
                            <div class="col-md-8">
                                <input type="text" name="contact_details" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding:8px 15px;">
                    <button disabled id="sub_but" type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div id="myPTLModal" class="modal fade" role="dialog" style="font-size:90%; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" id="leave_form" enctype="multipart/form-data">
                <div class="modal-header" style="padding:8px 15px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload Paternity Leave Documents</h4>
                </div>
                <div class="modal-body">
					<div class="row" style="padding:3px 0px;">
						<div class="form-group">
							<label class="col-md-4" style="line-height:37px;">Discharge Report</label>
							<div class="col-md-8">
								<input type="file" name="discharge_report" class="form-control" id="discharge_report">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer" style="padding:8px 15px;">
                    <button disabled id="sub_but" type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
			</form>
		</div>
	</div>
</div>



<script>
    var leaves_available = <?php echo $var_js; ?>;
    
    <?php if($error=""):?>alert('<?php echo $error ?>')<?php endif; ?>

</script>

<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#apply_holiday_date').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});
</script>

<script>
    $('#file_upload_ml').change(function () {
            //var ext = this.value.match(/\.(.+)$/)[1];
            var fileName = $(this).val();
            const fileSize = this.files[0].size / 1024 / 1024; // in MiB
            if (fileSize > 5) {
                alert('File size exceeds 5 MB');
                this.value = '';
            }
              else {
                var ext = fileName.substring(fileName.lastIndexOf(".") + 1, fileName.length);
                ext = ext.toLowerCase();
                switch (ext) {
                    case 'pdf':
                        break;
                    default:
                        alert('This is not an allowed file type.');
                        this.value = '';
                }
            }
        });
</script>

<script>
    $('#ptl_div_india #discharge_report').change(function () {
            //var ext = this.value.match(/\.(.+)$/)[1];
            var fileName = $(this).val();
            const fileSize = this.files[0].size / 1024 / 1024; // in MiB
            if (fileSize > 5) {
                alert('File size exceeds 5 MB');
                this.value = '';
            }
              else {
                var ext = fileName.substring(fileName.lastIndexOf(".") + 1, fileName.length);
                ext = ext.toLowerCase();
                switch (ext) {
                    case 'pdf':
                        break;
                    default:
                        alert('This is not an allowed file type.');
                        this.value = '';
                }
            }
        });
</script>

<script>
$("#leave_form").submit(function () {
    $("#sub_but").attr("disabled", true);
    return true;
});
</script>
