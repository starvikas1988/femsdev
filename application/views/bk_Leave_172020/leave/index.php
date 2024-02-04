<div class="wrap">
	<section class="app-content">
        <div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title" style="display:inline-block; line-height:30px">Leave Availability</h4>
                        
                        <?php if($leave_accessible) :?>
                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#myModal">Apply Leave</button>
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
                                    $_date_join = date_create($date_of_joining);
                                    $diff = date_diff(date_create(date('Y-m-d')), $_date_join);
                                    if( (int)$diff->format("%a") >= $leave["leave_details"]["show_after_days"]): 
                                ?>  
                                    <td class="text-center">
                                        <?php 
                                            $leave_bal = $leave["leave_details"]["leave_present"];

                                            echo round($leave_bal);
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
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Applied On</th>  
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Status</th> 
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Reason To Reject</th> 
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
                                            $_from_date = strtotime($leave->from_dt);
                                            $_to_date = strtotime($leave->to_dt);
                                            
                                            if($_from_date == $_to_date) $diff = 1;
				                            else $diff = 1 + round(($_to_date - $_from_date)/60/60/24);
                                            
                                            echo $diff." Day(s)";

                                            if($leave->no_of_additional_leaves != null) echo " + ".$leave->no_of_additional_leaves." Days";
                                        ?>
                                    </td>  
                                    <td style="font-size:80%"><?php echo $leave->apply_date ?></td>  
                                    <td style="font-size:100%" class="text-center">
                                        <?php 
                                            if($leave->status == '1') echo "<span class='label label-success'>Approved</span>";
                                            else if($leave->status == '2') echo "<span class='label label-danger'>Rejected</span>"; 
                                            else echo "<span class='label label-primary'>Pending</span>"; 
                                        ?> 
                                    </td>
                                    <td style="font-size:80%"><?php echo $leave->reject_reason ?></td>     
                                </tr>
                            <?php endforeach; ?>
                            <tfoot>
                                <tr class="text-center bg-primary">
                                    <th style="font-size:85%" class="text-center">Leave Type</th>
                                    <th style="font-size:85%" class="text-center">From</th>
                                    <th style="font-size:85%" class="text-center">To</th>
                                    <th style="font-size:85%" class="text-center">No. Of Day(s)</th>  
                                    <th style="font-size:85%" class="text-center">Applied On</th>  
                                    <th style="font-size:85%" class="text-center">Status</th>
                                    <th style="font-size:85%;" class="text-center">Reason To Reject</th> 
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
            <form method="post" action="" id="leave_form">
                <div class="modal-header" style="padding:8px 15px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Leave Application</h4>
                </div>
                <div class="modal-body">
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
                            <label class="col-md-4" style="line-height:37px;">Leave Type</label>
                            <div class="col-md-8">
                                <?php 
                                    $_date_join = date_create($date_of_joining);
                                    $diff = date_diff(date_create(date('Y-m-d')), $_date_join);
                                ?>
                                <select class="form-control" id="form-leave_type" name="leave_criteria_id" required>
                                    <option value="">Select</option>
                                    <?php foreach($leave_structure as $leave): ?>
                                        <?php if($leave->leave_access_allowed == 1): ?>
                                            <?php                                                 
                                                if( (int)$diff->format("%a") >= $leave->show_after_days): 
                                            ?>
                                                <option value="<?php echo $leave->leave_criteria_id; ?>">
                                                    <?php echo $leave->description; ?>
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
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">From Date</label>
                            <div class="col-md-8">
                                <input disabled autocomplete="off" type="text" name="from_date" class="form-control" id="from_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">To Date</label>
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
                            <label class="col-md-4">Reason</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="reason" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Contact Details</label>
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

<script>
    var leaves_available = <?php echo $var_js; ?>;
    
    <?php if($error=""):?>alert('<?php echo $error ?>')<?php endif; ?>

</script>


