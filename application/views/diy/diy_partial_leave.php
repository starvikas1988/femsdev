<div class="wrap">
	<section class="app-content">
        <div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title" style="display:inline-block; line-height:30px">
                        <span style="color: red;">Partial Leave is used when the leave is applied for one or more specific hours on a selected day.</span>                  
                        </h4> 
                                             
                        <?php if(get_login_type() == "client" && get_role()=='teacher'){ ?>
                        <!-- <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#myModal">Apply Partical Leave</button> -->
                        <?php } ?>
                        <a  href="<?php echo base_url()?>diy/partical_leave_form" target="_blank">
                            <button class="btn btn-primary btn-sm pull-right" >Apply Partial Leave</button>
                        </a>
                    </header>
					<hr class="widget-separator"/>
					
					<div class="widget-body clearfix">
                    <?php 
                     /*$userid = get_user_id();
                     if((get_login_type() == "client" && get_role() != 'teacher') || get_global_access()){
                     ?>    
                     <a href="<?php echo base_url();?>/diy/leave_master_csv">Download</a>
                    <?php } else { ?>
                     <a href="<?php echo base_url();?>/diy/leave_master_csv?id=<?php echo $userid; ?>">Download</a>
                     <?php }*/ ?>
                    </div>
					
                </div>
            </div>
        </div> 

        <div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Partial Leave History</h4>
					</header>
					<hr class="widget-separator"/>
                    <form id="form_new_user" method="GET">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" id="search_from_date" name="date_from" value="<?php echo !empty($search_from) ? $search_from : ""; ?>" class="form-control" required autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" id="search_to_date" name="date_to" value="<?php echo !empty($search_to) ? $search_to : ""; ?>" class="form-control" required autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-md-1" style='margin-top:22px;'>
                            <div class="form-group">
                                <button class="btn btn-primary waves-effect" type="submit" id='show' name='show' value="Show">SHOW</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-1" style='margin-top:22px;'>
                        <div class="form-group">
                            <?php 
                                $userid = get_user_id();
                                if((get_login_type() == "client" && get_role() != 'teacher') || get_global_access()){
                                    $search_from= trim($search_from," ");
                                  $search_from_date = ($search_from) ?"?search_from='$search_from'" : "";
                                  $search_to_date = ($search_to) ?" &search_to='$search_to'" : "";
                                ?>    
                                <a href="<?php echo base_url();?>/diy/partial_leave_master_csv<?php echo $search_from_date.$search_to_date;?>"><button class="btn btn-primary waves-effect" type="button" >DOWNLOAD</button></a>
                                <?php } else { 
                                     $search_from_date = ($search_from) ?"and search_from='$search_from'" : "";
                                     $search_to_date = ($search_to) ?" and search_to='$search_to'" : "";
                                    ?>
                                <a href="<?php echo base_url();?>/diy/partial_leave_master_csv?id=<?php echo $userid; ?><?php echo $search_from_date.$search_to_date;?>"><button class="btn btn-primary waves-effect" type="button" >DOWNLOAD</button></a>
                            <?php } ?>
                        </div>
                    </div>
					<div class="widget-body clearfix">
						<div class="row">
                            <table class="table table-responsive table-bordered">
                            <thead>
                                <tr class="text-center bg-primary">
                                    <th width="140px" style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Teachers Name</th>
                                    <th width="140px" style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Teachers Email</th>
                                    
                                    <th width="140px" style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Apply Date</th>
                                    <th width="100px" style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Time Slot(s)</th>  
                                    <th width="140px" style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Contact Details</th>  
                                    <th width="140px" style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Status</th> 								
									<!-- <?php if((get_login_type() == "client" && get_role() != 'teacher') || get_global_access()){ ?>
										<th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Action</th>
									<?php } ?> -->
									
                                </tr>
                            </thead>
							
                            <?php 
                            foreach($leave_master as $key=>$leave): ?>
                                <tr style="font-size:85%">
                                    <td style="font-size:80%;" class="text-center"><?php echo $leave['teacher_name']; ?></td>  
                                    <td style="font-size:80%;" class="text-center"><?php echo $leave['email_id']; ?></td>  
                                    <td style="font-size:80%;" class="text-center"><?php echo $leave['apply_date']; ?></td>  
                                    
                                    <td style="font-size:80%" class="text-center">
									<?php echo $leave['start_time'].' - '.$leave['end_time'];?>
                                    </td>
                                    <td class="text-center"><?php echo $leave['contact_details']; ?></td>  
                                    <?php if(get_role()== 'teacher'){ ?>
                                    <td style="font-size:80%">
                                        <?php 
                                        if($leave['status']=='I'){ echo 'Applied';}
                                        else if($leave['status']=='A'){ echo 'Approved';}
                                        else { echo "Unapproved";}
                                         ?>
                                        </td>  
                                    <?php } ?>       
									<?php if((get_login_type() == "client" && get_role()!= 'teacher') || get_global_access()){ ?>
										<td style="font-size:80%" class="text-center">
                                            <select name="leave_status" id="leave_status<?php echo $leave['id'];?>" onchange="change_Partical_leavestatus('<?php echo $leave['id'];?>',this)">
                                                <option value="I" <?php ($leave['status']=='I')?"selected='selected'":"";?> >Applied</option>
                                                <option value="A" <?php ($leave['status']=='A')?"selected='selected'":"";?>>Approved</option>
                                                <option value="D" <?php ($leave['status']=='D')?"selected='selected'":"";?>>Rejected</option>
                                            </select>
										</td>
									<?php } ?>
                                </tr>
                            <?php endforeach; ?>
							
                            <tfoot>
                                <tr class="text-center bg-primary">
                                    <th style="font-size:85%" class="text-center">Teachers Name</th>
                                    <th style="font-size:85%" class="text-center">Teachers Email</th>
                                    <th style="font-size:85%" class="text-center">Apply Date</th>
                                    <th style="font-size:85%" class="text-center">Time Solt</th>  
                                    <th style="font-size:85%" class="text-center">Contact Details</th>  
                                    <th style="font-size:85%" class="text-center">Status</th> 
									<!-- <?php if((get_login_type() == "client" && get_role() != 'teacher') || get_global_access()){ ?>
										<th style="font-size:85%;border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Action</th>
									<?php } ?> -->
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
            <form method="post" action="leave_applied" id="leave_form" onsubmit="submit_data();" autocomplete="off">
                <div class="modal-header" style="padding:8px 15px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Leave Application</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">Employee Name</label>
                            <div class="col-md-8"><?php echo get_username(); ?></div>
                            <input type="hidden" name="emp_id" id="emp_id" value="<?php echo get_user_id(); ?>" >
                        </div>
                    </div>
					
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">From Date</label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" name="firstDate" class="form-control" id="firstDate" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">To Date</label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" name="secondDate" class="form-control" id="secondDate" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:5px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">No. of Day(s)</label>
                            <div class="col-md-8" id="no_of_day">
                                <input type="text" name="no_of_days" id="no_of_days" value="" class="form-control" required> 
                            </div>
                        </div>
                    </div>
                               
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4">Reason</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="reason" id="reason" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Contact Details</label>
                            <div class="col-md-8">
                                <input type="tel" name="contact_details" class="form-control" pattern="[0-9]{5}[0-9]{2}[0-9]{3}" placeholder ="1234567890" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding:8px 15px;">
                    <button id="sub_but" type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



