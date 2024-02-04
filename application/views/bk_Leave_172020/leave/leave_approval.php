<style>
.ActiveBtn{
	border: 3px solid #167ccb;
	/*border-color: #167ccb;*/
	
}

</style>

<div class="wrap">
	<section class="app-content">
        <div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
                        <h4 class="widget-title" style="display:inline-block; line-height:30px">Leaves</h4>
                        <!--
                        <?php 
							if($status=="1") $sCss='<h4 class="widget-title" style="display:inline-block; line-height:30px">Approve Leave</h4>';
							else if($status=="2") $sCss='<h4 class="widget-title" style="display:inline-block; line-height:30px">Rejected Leave</h4>';
							else if($status=="0") $sCss='<h4 class="widget-title" style="display:inline-block; line-height:30px">Pending Leave</h4>';
							else $sCss='<h4 class="widget-title" style="display:inline-block; line-height:30px">Leave Details</h4>';
							
							echo $sCss;
						?>
						
						<?php 
							$sCss="";
							if($status=="1") $sCss="ActiveBtn";
						?>
										
                        <a href="?status=1" class="btn btn-xs btn-success pull-right <?php echo $sCss;?>" type="button" style="margin-top: 6px">Approved</a>
						<?php 
							$sCss="";
							if($status=="2") $sCss="ActiveBtn";
						?>
						
                        <a href="?status=2" class="btn btn-xs btn-danger pull-right <?php echo $sCss;?>" type="button" style="margin-top: 6px; margin-right:5px;">Rejected</a>
						<?php 
							$sCss="";
							if($status=="0") $sCss="ActiveBtn";
						?>
                        <a href="?status=0" class="btn btn-xs btn-warning pull-right <?php echo $sCss;?>" type="button" style="margin-top: 6px; margin-right:5px;">Pending</a>
                        -->
                        <hr/>
                        <form method="get" action="">
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="0" <?php if($status == 0) echo "selected"?>>Pending</option>
                                        <option value="1" <?php if($status == 1) echo "selected"?>>Approved</option>
                                        <option value="2" <?php if($status == 2) echo "selected"?>>Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Location</label>
                                    <select class="form-control" name="office_id" id="location_id">
                                        <option value="">--select--</option>
                                        <?php foreach($location_list as $location): ?>
                                            <?php
                                                $sCss="";
                                                if($location['abbr']==$office_id) $sCss="selected";
											?>
                                            <option value="<?php print $location["abbr"] ?>" <?php echo $sCss;?>><?php print $location["abbr"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
								
								<?php if (is_access_all_leave_approve()==true || specific_location_leave_approve()==true){ ?>
                                <div class="col-md-2">
                                    <label>Department</label>
                                    <select class="form-control" name="dept_id" id="dept_id">
                                        <option value="">--select--</option>
										
										<?php foreach($department_list as $dept): ?>
											<?php
											$sCss="";
											if($dept['id']==$dept_id) $sCss="selected";
											?>
											<option value="<?php echo $dept['id']; ?>" <?php echo $sCss;?>><?php echo $dept['description']; ?></option>
										<?php endforeach; ?>
                                    </select>
                                </div>
								
								<?php } ?>
								
                                <div class="col-md-2">
                                    <label>Employee Name</label>
                                    <select class="form-control" name="emp_name" id="emp_name">
                                        <option value="">-- Select --</option>
                                        <?php foreach($employee_list as $_emp): 
											$sCss="";
											if($_emp->id==$emp_name) $sCss="selected";
										?>
                                            <option value="<?php echo $_emp->id ?>" <?php echo $sCss;?> >
                                                <?php echo $_emp->emp_name . " (". $_emp->dept_name .  " - ". $_emp->office_id .")"; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label>Fusion ID/XPOID</label>
                                    <input class="form-control" type="text" value="<?php echo $fusion_id; ?>" placeholder="Search By Fusion ID" name="fusion_id">
                                </div>
                                <div class="col-md-2">
                                    <label>Applied Date</label>
                                    <input class="form-control" type="text"  value="<?php echo $applied_date; ?>" autocomplete="off" name="applied_date" id="applied_date">
                                </div>
								<div class="col-md-2">
                                    <button class="btn btn-sm btn-primary" type="submit" style="margin-top: 20px; margin-left:5px;">Submit</button>
                                </div>
								
                            </div>
                            
                        </form>
                    </header>
					<hr class="widget-separator"/>
					 
					 
					<div class="widget-body clearfix">
						<button onclick="approve_all()" class="btn btn-sm btn-success pull-left" type="button" style="margin: 2px;">Approve Selected </button>
						
                        <form action="" id="approve_selected_form" method="post">
                            <table class="table table-responsive table-bordered">
                                <thead class="bg-primary">
                                    <th  class="text-center"><input type="checkbox" id="select_all" /></th>
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center" width="50px">Leave Type</th>
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center" width="50px">Leaves Balance</th>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center">Applied By</th>									                               
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center">From Date</th>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center">To Date</th>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center" width="50px">No. of Days</th>  
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center">Applied On</th>  
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center">Reason</th>  
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center">Contact</th>  
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center" width="50px">Status</th>                                    
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center">Approved / Rejected On</th>                                    
                                    <th style="border: 1px solid #ddd;border-bottom-width: 0px;font-size:85%" class="text-center">Action</th>
                                </thead>         
                                <tbody>
                                <?php foreach($my_team_leaves as $leave): ?>
                                    <tr>
                                        <td style="text-align:center"><input name="leave_ids[]" type="checkbox" class="checkbox" value="<?php echo $leave->id ?>"/></td>
                                        <td style="font-size:80%">
                                            <?php 
                                                echo $leave->abbr;
                                                if($leave->additional_lt != null) echo " + ".$leave->additional_lt; 
                                            ?>
                                        </td>
                                        <td style="font-size:80%"><?php echo round($leave->leaves_present) ?></td>
                                        <td style="font-size:80%"><?php echo $leave->applied_by_name ?></td>
										 										
                                        <td style="font-size:80%"><?php echo $leave->from_dt ?></td>
                                        <td style="font-size:80%">
                                            <?php 
                                                //echo $leave->to_dt 
                                                if($leave->no_of_additional_leaves != null){
                                                    echo date('Y-m-d', strtotime($leave->to_dt. ' + '.$leave->no_of_additional_leaves.' days'));
                                                }else{
                                                    echo $leave->to_dt;
                                                } 
                                            ?>
                                        </td>
                                        <td style="font-size:80%">
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
                                        <td style="font-size:80%">
                                            <?php if($leave->reason!="") echo $leave->reason ?>
                                            <?php if($leave->reject_reason!="") echo $leave->reject_reason ?>
                                        </td>                                    
                                        <td style="font-size:80%"><?php echo $leave->contact_details ?></td>
                                        <td style="font-size:80%" class="leave_approval_status"  params="<?php echo $leave->id; ?>"> 
                                            <?php 
                                                if($leave->status == '1') echo "<span class='label label-success' style='padding: 0.4em .6em .3em;'>Approved</span>";
                                                else if($leave->status == '2') echo "<span class='label label-danger' style='padding: 0.4em .6em .3em;'>Rejected</span>"; 
                                                else echo "<span class='label label-primary' style='padding: 0.4em .6em .3em;'>Pending</span>"; 
                                            ?> 
                                        </td>  
                                        <td style="font-size:80%">
                                            <?php 
                                                if($leave->approved_on!="") echo $leave->approved_on;
                                                if($leave->rejected_on!="") echo $leave->rejected_on;
                                            ?>
                                        </td>  
                                        <td class="text-center">
                                            <?php if($leave->status == '0'){ ?>
                                                <?php if($leave_accessible) :?> 
                                                    <button type="button" class="btn btn-success btn-xs" style="font-size:9px; width:55px" onclick="approve_leave(<?php echo $leave->id ?>)">Approve</button>
                                                    <button type="button" class="btn btn-danger btn-xs" style="font-size:9px; width:55px" onclick="reject_leave(<?php echo $leave->id ?>)">Reject</button>
                                                <?php endif ?>
                                            <?php }else if($leave->status == '1'){ ?>
                                                <button type="button" class="btn btn-danger btn-xs" style="font-size:9px; width:55px" onclick="reject_leave(<?php echo $leave->id ?>)">Reject</button>
                                            <?php } ?>
                                        </td>                                   
                                    </tr>       
                                <?php endforeach; ?>    
                                </tbody>
                                <tfoot class="bg-primary">
                                    <th class="text-center"><input type="checkbox" id="select_all_2" /></th>
                                    <th style="font-size:85%" class="text-center" width="50px">Leave Type</th>
                                    <th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center" width="50px">No Of Leaves Left</th>
                                    <th style="font-size:85%" class="text-center">Applied By</th> 
                                    <th style="font-size:85%" class="text-center">From Date</th>
                                    <th style="font-size:85%" class="text-center">To Date</th>
                                    <th style="font-size:85%" class="text-center" width="50px">No. of Days</th>  
                                    <th style="font-size:85%" class="text-center">Applied On</th>  
                                    <th style="font-size:85%" class="text-center">Reason</th>  
                                    <th style="font-size:85%" class="text-center">Contact</th>  
                                    <th style="font-size:85%" class="text-center" width="50px">Status</th>  
                                    <th style="font-size:85%" class="text-center">Approved / Rejected On</th>
                                    <th style="font-size:85%" class="text-center">Action</th>  
                                </tfoot>   
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </section>
</div>

<div class="modal fade" role="dialog" id="rejectLeaveModal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="rejectForm" action="" method="post">
                <input type="hidden" id="reject_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        Rejection Letter for Leave Request
                    </h4>
                </div>
                <div class="modal-body">
                    <p>We regret to inform you that management has rejected your leave application for the given period.</p>
                    <div class="form-group">
                        <label style="margin:10px 0px;">Reason for rejection</label>
                        <textarea class="form-control" id="reject_reason"></textarea>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-xs" onclick="save_reject()">Submit</button>
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>