<?php $wl_popup_data = get_wl_popup_data();
      if(!empty($wl_popup_data)){
            // echo '<pre>'; print_r($wl_popup_data);
            $employee = $wl_popup_data['employee'];
            $l2popup = $wl_popup_data['l2popup'];
            $hrpopup = $wl_popup_data['hrpopup'];
            $hrl2popup = $wl_popup_data['hrl2popup'];

            if(!empty($employee)){
                foreach($employee as $key_emp => $val_emp){ 
                    //echo '<pre>'; print_r($val_emp); 
                }  
            }

            if(!empty($l2popup)){
                foreach($l2popup as $key_l2 => $val_l2){ 
                    //echo '<pre>'; print_r($val_l2); 
                }  
            }

            if(!empty($hrpopup)){
                foreach($hrpopup as $key_hr => $val_hr){ 
                    //echo '<pre>'; print_r($val_hr); 
                } 
            }

            if(!empty($hrl2popup)){
                foreach($hrl2popup as $key_hrl2 => $val_hrl2){ 
                    //echo '<pre>'; print_r($val_hrl2); 
                } 
            }           
            
      }
      
?>
<?php
if(!empty($employee)){
    foreach($employee as $key_emp => $val_emp){ 
?>
<!-- Start Employee Popup -->

    <!-- Start Employee accept and Request for a meeting -->
<?php 
if($val_emp['wl_status']==4){ 
    foreach($val_emp['details'] as $key=>$rw){
?>
    <div class="modal fade" id="<?php echo $val_emp['popup_model_id'];?>" role="dialog">
        <div class="modal-dialog small_modal_new">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group employee_first_employee_accept_req_meeting text-center">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/warning_big.svg" />
                        <input type="hidden" name="user_id_<?php echo $rw['warn_id']; ?>" id="user_id_<?php echo $rw['warn_id']; ?>" value="<?php echo $rw['user_id']; ?>">
                        <input type="hidden" name="warn_id_<?php echo $rw['warn_id']; ?>" id="warn_id_<?php echo $rw['warn_id']; ?>" value="<?php echo $rw['warn_id']; ?>">
                        <input type="hidden" name="event_type_<?php echo $rw['warn_id']; ?>" id="event_type_<?php echo $rw['warn_id']; ?>" value="<?php echo $rw['last_event_type']; ?>">
                        <p>
                            <strong>Alert!</strong> Warning letter has been issued to you. <a
                                href="<?php echo base_url(); ?>Warning_letter_v2/my_warning_view_pdf?warn_id=<?php echo $rw['warn_id']; ?>&send_email='N'" target="_blank">Click here</a> to view the letter
                        </p>
                    </div>
                    <div id="after_reason_msg_<?php echo $rw['warn_id']; ?>" class="after_revoke_msg" style="display: none;">
                        <label for="">Reason</label>
                        <textarea name="reason" id="reason" class="textarea_big form-control"></textarea>
                    </div>
                    <!--Start after request meeting-->
                    <div id="after_request_meeting_<?php echo $rw['warn_id']; ?>" class="after_request_meeting_employee_accept_req_meeting text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                        <p>
                            Your meeting request has been submitted. Awaiting for <strong>HR discussion</strong>.
                        </p>
                    </div>
                    <!--End after request meeting-->

                    <!--Start after employee accpet-->
                    <div id="after_employee_accept_<?php echo $rw['warn_id']; ?>" class="after_employee_accept_employee_accept_req_meeting text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                        <p>
                            You have accepted the warning. <strong>Process Completed</strong>.
                        </p>
                    </div>
                    <!--End after employee accpet-->

                </div>
                <div class="modal-footer">
                    <div id="before_meeting_shedule_<?php echo $rw['warn_id']; ?>" class="before_meeting_shedule_employee_accept_req_meeting">
                        <button type="button" class="btn btn_padding filter_btn_blue save_common_btn" id="accept_employee_<?php echo $rw['warn_id']; ?>" onclick="emp_accept('<?php echo $rw['warn_id']; ?>');">Accept</button>
                        <?php if ($val_emp['wl_status'] == 4) { ?>
                        <button type="button" class="btn btn_padding filter_btn" id="request_meting_<?php echo $rw['warn_id']; ?>" onclick="open_reason('<?php echo $rw['warn_id']; ?>');">Request for a
                            meeting</button>
                            <button type="button" class="btn btn_padding filter_btn_blue" id="request_meting_<?php echo $rw['warn_id']; ?>_next" onclick="emp_request_meeting('<?php echo $rw['warn_id']; ?>','reason');" style="display: none;">save</button>    
                        <?php } ?>    
                    </div>                   
                </div>
            </div>
        </div>
    </div> 
     <!-- End Employee accept and Request for a meeting -->    
<?php 
        }
    } if($val_emp['wl_status']==8){ ?>
    <!-- Start Employee notification popup to notify meeting scheduled  -->
    <div class="modal fade" id="model_notify_emp_meeting_schedule" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group employee_first text-center" data-dismiss="modal">
                        <p>
                            Meeting has been scheduled to discuss on your Warning Letter. Please reach out to
                            <strong>HR</strong>.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn_blue" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Employee notification popup to notify meeting scheduled  -->

<!-- END Employee Popup -->
<?php 
        }
    }
}  
?>


<!-- Start HR popups -->
<?php
if(!empty($hrpopup)){
    foreach($hrpopup as $key_hr => $val_hr){ ?>
    
<?php if($val_hr['wl_status'] == 7){ ?>
    <!-- Start HR popup to request for schedule meeting -->
    <div class="modal fade" id="model_hr_meeting_schedule" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                <div id="meeting_loader">
                </div>    
                <?php foreach($val_hr['details'] as $key=>$rw){ ?>
                    <div class="notification_widget">
                        <div class="row d_flex">
                            <div class="col-sm-6">
                                <p>
                                    <strong>(<?php echo $rw['fusion_id']; ?>"-" <span id="emp_name_<?php echo $rw['user_id']; ?>"><?php echo $rw['employee_name']; ?></span>) has requested to discuss on warning issued on <?php echo $rw['issued_date']; ?></strong>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <div class="right_side">
                                    <a href="#" class="btn btn_padding filter_btn" data-wle_id ="<?php echo $rw['warn_id']; ?>" data-user_id="<?php echo $rw['user_id']; ?>" id="meeting_now_btn">Meeting Now</a>
                                    <a href="#" class="btn btn_padding filter_btn">Set for later</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                    <!--Start after request meeting-->
                    <div class="after_request_meeting text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                        <p>
                            Your meeting request has been submitted. Awaiting for <strong>HR discussion</strong>.
                        </p>
                    </div>
                    <!--End after request meeting-->
                    <!--Start after click meeting now hr-->
                    <form id="hr_schedule_meeting">
                    <div class="meeting_now" style="display: none;">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Meeting Title <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control" id="" name="meeting_title" required />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Date <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control due_date-cal datepicker" id="meeting_date" name="meeting_date" required />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Participants <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control" id="participants" name="participants" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <!--End after click meeting now hr-->

                    <!--Start final submit-->
                    <div class="final_submit_widget text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                        <p>
                            Meeting has been scheduled with employee.
                        </p>
                    </div>
                    <!--End final submit-->
                </div>
                <div class="modal-footer">
                    <!--Start after click on meeting now btn-->
                    <div class="after_meeting_shedule" style="display: none;">
                        <button type="button" class="btn btn_padding filter_btn_blue save_common_btn"
                            id="final_submit">Submit</button>
                    </div>
                    <!--End after click on meeting now btn-->
                </div>
            </div>
        </div>
    </div>
    <!-- End HR popup to schedule meeting -->
<?php } if($val_hr['wl_status'] == 8){ ?>

    <!--Start HR notification to create mom  -->
    <div class="modal fade" id="model_notify_hr_create_mom" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    <?php foreach($val_hr['details'] as $key=>$rw){ ?>
                        <div class="notification_widget">
                            <div class="row d_flex">
                                <div class="col-sm-9">
                                    <p>
                                        Warning Letter Meeting sucessfully done with employee - <?php echo $rw['employee_name']; ?>
                                    </p>
                                    <p>
                                        <!-- <span class="red_bg">Note : 12 hrs Left</span> -->
                                    </p>
                                </div>
                                <div class="col-sm-3">
                                    <a href="#" class="btn btn_padding filter_btn" data-toggle="modal"
                                        data-target="#myModal_hr_create_mom">Create MOM</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn">Skip</button>
                </div>
            </div>

        </div>
    </div>
    <!-- END HR notification to create mom  -->
<?php } ?>

    <!-- Start Hr create MOM -->
    <div class="modal fade" id="myModal_hr_create_mom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!--Start Esclate area-->
                        <div class="before_esclate">
                            <label for="">HR Manager</label>
                            <textarea name="" id="" class="form-control textarea_big"></textarea>
                        </div>
                        <!--End Esclate area-->

                        <!--Start Esclate submit area-->
                        <div class="after_esclate text-center" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                            <p>
                                Escalation to <strong>HR Manager</strong>. Awaiting for further action
                            </p>                            
                        </div>
                        <!--End Esclate submit area-->

                        <!--Start Esclate submit area-->
                        <div class="reissue_esclate text-center" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                            <p>
                            <strong>MOM Submitted.</strong> Reissuing letter to employee.
                            </p>                            
                        </div>
                        <!--End Esclate submit area-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn_padding filter_btn" id="escalate_btn">Escalate</button>
                    <button class="btn btn_padding filter_btn_blue" id="reissue_btn">Reissue</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hr create MOM -->


    <!-- Start Hr Revoke Approve -->
<?php if($val_hr['wl_status'] == 2){ ?>
    <div class="modal fade" id="model_hr_review" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                <?php 
                    foreach($val_hr['details'] as $key=>$rw){ ?>
                    <div class="notification_widget">
                        <div class="row d_flex">
                            <div class="col-sm-6">
                                <p>
                                    <strong>Warning Letter Initiation Validate for (<?php echo $rw['fusion_id'] ."-". $rw['employee_name']; ?>)</strong>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <div class="right_side">
                                    <!-- <a href="#" data-toggle="modal" class="btn btn_padding filter_btn" id="hr_revoke_approve_now_btn" data-target="#myModal_hr_approve_revoke">Approve / Revoke</a> -->
                                    <a href="#" onclick="reviewModal('<?php echo $rw['warn_id']; ?>')" title="Review">Approve / Revoke</a>
                                    <a href="#" class="btn btn_padding filter_btn">Set for later</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>                
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal_hr_approve_revoke" role="dialog" style="display: none;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Warning Particulars</h4>
                </div>
                <div class="modal-body">
                    <div id="aprv_loader">
                    
                </div>
                <form id="hr_approve_form">
                    <div class="before_approve">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Warning Level <span class="red_bg">*</span></label>
                                    <select name="warning_letter_level_mas_id" id="warning_letter_level" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($warning_level_list as $key => $value) { ?>
                                            <option class="data-level" value="<?php echo $value['id']; ?>"><?php echo $value['levels']; ?></option>
                                        <?php } ?>
                                        <!-- <option value="">Warning 1</option>
                                        <option value="">Warning 2</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Initiate Date <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control" id="initiate_date" required readonly>
                                    <input type="hidden" name="warning_letter_employee_id" required id="warning_letter_employee_id">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Review Date <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control datepicker due_date-cal" required id="review_date" name="review_date">
                                </div>
                            </div>
                            <!-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Issue Date <span class="red_bg">*</span></label> -->
                                    <input type="hidden" class="form-control" id="issued_date" value="<?php echo date('Y-m-d'); ?>" name="issued_date" required readonly>
                                <!-- </div>
                            </div> -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Incident Date <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control date" id="incident_date" name="incident_date" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Policy Violated <span class="red_bg">*</span></label>
                                    <select name="warning_letter_reason_mas_id" id="warning_reason" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($get_warning_reason_list as $key => $value) { ?>
                                            <option class="data-reason" value="<?php echo $value['id']; ?>"><?php echo $value['reasons']; ?></option>
                                        <?php } ?>
                                        <!-- <option>Reason 1</option>
                                        <option>Reason 2</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Compliance <span class="red_bg">*</span></label>
                                    <select name="compliance" id="compliance" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option class="data-compliance" value="1">Yes</option>
                                        <option class="data-compliance" value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <!-- <label class="custom_checkbox">
                                    <span class="small_font">Customized Reason</span>
                                    <input type="checkbox" name="" value="" id="customize_area">
                                    <span class="checkmark"></span>
                                </label>
                                <div class="form-group" id="open_customize" style="display: none;">
                                    <textarea name="cust_reason" id="cust_reason" class="form-control textarea_big"></textarea>
                                </div> -->
                                <div class="form-group">
                                    <label for="">Description <span class="red_bg">*</span></label>
                                    <textarea name="cust_reason" id="cust_reason" class="form-control textarea_big" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <!--Start after submit btn-->
                    <div class="after_approve_msg_hr text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />                        
                        <p>
                            For HR Manager- Warning Letter Validated. Issuing Letter to Employee.
                        </p>
                    </div>
                    <!--End after submit btn-->
                    <!--Start revoke btn-->
                    <div class="after_revoke_msg_hr" style="display: none;">
                        <label for="">Revoke</label>
                        <textarea name="" id="" class="textarea_big form-control"></textarea>
                    </div>
                    <!--End revoke btn-->
                    <!--Start after_revoke_msg_display btn-->
                    <div class="after_revoke_msg_display_hr text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                        <p>
                            For HR Manager- Warning Letter Rejected. Process Revoked.
                        </p>
                    </div>
                    <!--End after_revoke_msg_display btn-->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn revok_next_hr">Revoke</button>
                    <button type="button" class="btn btn_padding filter_btn save_common_btn"
                        id="revoke_btn_l2" style="display: none;">Revoke</button>
                    <button type="button" class="btn btn_padding filter_btn_blue save_common_btn"
                        id="approve_btn_l2">Approve</button>
                </div>
            </div>

        </div>
    </div>

<?php   } } }  ?>


<!-- END HR popups -->



<!-- Start HR L2 Popups -->
<?php
if(!empty($hrl2popup)){
    foreach($hrl2popup as $key_hrl2 => $val_hrl2){ 
    if($val_hrl2['wl_status']==10 || $val_hrl2['wl_status']==16){    
?>
    <!-- Start HR L2 Meeting Schedule -->
    <div class="modal fade" id="<?php echo $val_hrl2['popup_model_id'];?>" role="dialog" style="display: none;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification 123</h4>
                </div>
                <div class="modal-body" id="request_details">
                <?php foreach($val_hrl2['details'] as $key=>$rw){ ?>  
                    <div class="notification_widget">
                        <div class="row d_flex">
                            <div class="col-sm-6">
                                <p>
                                    <strong>(<?php echo $rw['fusion_id']?> - <span id="empName_<?php echo $rw['user_id']?>"><?php echo $rw['employee_name']?></span>) Warning has been escalated to you. Awaiting Resolution</strong>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <div class="right_side">
                                    <a href="#" class="btn btn_padding filter_btn" data-wle_id = '<?php echo $rw['warn_id'];?>'  data-user_id = '<?php echo $rw['user_id'];?>' id="meeting_now_btn_l2">Meeting
                                        Now</a>
                                    <!--<a href="#" class="btn btn_padding filter_btn">Set for later</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>    
                    <!--Start after request meeting-->
                    <!--<div class="after_request_meeting_hr_l2 text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                        <p>
                            Your meeting request has been submitted. Awaiting for <strong>HR discussion</strong>.
                        </p>
                    </div>-->
                    <!--End after request meeting-->

                    <!--Start after click meeting now hr-->
                    <form id="hr_schedule_meeting">
                    <div class="meeting_now_hr_l2" style="display: none;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Meeting Title <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control" id="" name="meeting_title" required />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Date <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control due_date-cal datepicker" id="meeting_date" name="meeting_date" required />
                                </div>
                            </div>
                            <!--<div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Time</label>
                                    <input type="text" class="form-control due_date-cal" id="" />
                                </div>
                            </div>--->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Participants <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control" id="participants" name="participants" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    </form> 
                    <!--End after click meeting now hr-->

                    <!--Start final submit-->
                    <div class="final_submit_widget_hr_l2 text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                        <p>
                            Meeting has been scheduled with employee.
                        </p>
                    </div>
                    <!--End final submit-->
        
                </div>
                <div class="modal-footer">
                    <!--Start after click on meeting now btn-->
                    <div class="after_meeting_shedule_hr_l2" style="display: none;">
                        <button type="button" class="btn btn_padding filter_btn_blue save_common_btn"
                            id="final_submit_hr_l2">Submit</button>
                    </div>
                    <!--End after click on meeting now btn-->
                    <button class="btn btn_padding filter_btn" data-dismiss="modal" id="set_later">Set for later</button>
                </div>

            </div>

        </div>
    </div>
    <!-- End HR L2 Meeting Schedule -->

    <!--Start HR L2 notification to create mom  -->
    <div class="modal fade" id="model_notify_hrl2_create_mom" role="dialog" style="display: none;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="notification_widget">
                            <div class="row d_flex">
                                <div class="col-sm-9">
                                    <p>
                                        Warning Letter Meeting sucessfully done with employee - Sanchari
                                    </p>
                                    <p>
                                        <span class="red_bg">Note : 12 hrs Left</span>
                                    </p>
                                </div>
                                <div class="col-sm-3">
                                    <a href="#" class="btn btn_padding filter_btn" data-toggle="modal"
                                        data-target="#myModal_hrl2_create_mom">Create MOM</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="notification_widget">
                            <div class="row d_flex">
                                <div class="col-sm-9">
                                    <p>
                                        Warning Letter Meeting sucessfully done with employee - Manoj
                                    </p>
                                    <p>
                                        <span class="red_bg">Note : 12 hrs Left</span>
                                    </p>
                                </div>
                                <div class="col-sm-3">
                                    <a href="#" class="btn btn_padding filter_btn" data-toggle="modal"
                                        data-target="#myModal_hrl2_create_mom">Create MOM</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn">Skip</button>
                </div>
            </div>

        </div>
    </div>
    <!-- END HR L2 notification to create mom  -->

    <!-- Start Hr L2 create MOM -->
    <div class="modal fade" id="myModal_hr_create_mom" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!--Start Esclate area-->
                        <div class="before_esclate">
                            <label for="">HR Manager</label>
                            <textarea name="" id="" class="form-control textarea_big"></textarea>
                        </div>
                        <!--End Esclate area-->

                        <!--Start Esclate submit area-->
                        <div class="after_esclate text-center" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                            <p>
                                Escalation to <strong>HR Manager</strong>. Awaiting for further action
                            </p>                            
                        </div>
                        <!--End Esclate submit area-->

                        <!--Start Esclate submit area-->
                        <div class="reissue_esclate text-center" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                            <p>
                            <strong>MOM Submitted.</strong> Reissuing letter to employee.
                            </p>                            
                        </div>
                        <!--End Esclate submit area-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn_padding filter_btn" id="escalate_btn">Escalate</button>
                    <button class="btn btn_padding filter_btn_blue" id="reissue_btn">Reissue</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hr L2 create MOM -->
<?php 
    }
    }
}
?>
<!-- End HR L2 Popups -->




<!-- Start L2 Popup -->

    <!-- Start Approve or Revoke -->
    <div class="modal fade" id="model_l2_review" role="dialog" style="display: none;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    <div class="notification_widget">
                        <div class="row d_flex">
                            <div class="col-sm-6">
                                <p>
                                    <strong>Warning Letter Initiation Validate for (Employee ID - Name)</strong>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <div class="right_side">
                                    <a href="#" data-toggle="modal" class="btn btn_padding filter_btn" id="l2_revoke_approve_now_btn" data-target="#myModal_l2_approve_revoke">Approve / Revoke</a>
                                    <a href="#" class="btn btn_padding filter_btn">Set for later</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal_l2_approve_revoke" role="dialog" style="display: none;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal"></button>
                    <h4 class="modal-title">Warning Particulars</h4>
                </div>
                <div class="modal-body">
                    <div class="before_approve_l2">
                        <div class="row">
                            <div class="col-sm-4 padding_right">
                                <div class="form-group">
                                    <label for="">Warning Level</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">--Select--</option>
                                        <option value="">Warning 1</option>
                                        <option value="">Warning 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 padding_right">
                                <div class="form-group">
                                    <label for="">Initiate Date</label>
                                    <input type="text" class="form-control" placeholder="09/06/2023" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Issue Date</label>
                                    <input type="text" class="form-control" placeholder="09/06/2023" id="">
                                </div>
                            </div>
                            <div class="col-sm-4 padding_right">
                                <div class="form-group">
                                    <label for="">Review Date</label>
                                    <input type="text" class="form-control datepicker due_date-cal" id="">
                                </div>
                            </div>
                            <div class="col-sm-4 padding_right">
                                <div class="form-group">
                                    <label for="">Reason</label>
                                    <select name="" id="" class="form-control">
                                        <option>--Select--</option>
                                        <option>Reason 1</option>
                                        <option>Reason 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Compliance</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">--Select--</option>
                                        <option value="">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="custom_checkbox">
                                    <span class="small_font">Customized Reason</span>
                                    <input type="checkbox" name="" value="" id="customize_area">
                                    <span class="checkmark"></span>
                                </label>
                                <div class="form-group" id="open_customize" style="display: none;">
                                    <textarea name="" id="" class="form-control textarea_big"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Start after submit btn-->
                    <div class="after_approve_msg_l2 text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />                        
                        <p>
                            For L2 Manager- Warning Letter Initiation Validated. Proceeding to <strong>HR</strong> for Further Action
                        </p>
                    </div>
                    <!--End after submit btn-->
                    <!--Start revoke btn-->
                    <div class="after_revoke_msg_l2" style="display: none;">
                        <label for="">Revoke</label>
                        <textarea name="" id="" class="textarea_big form-control"></textarea>
                    </div>
                    <!--End revoke btn-->
                    <!--Start after_revoke_msg_display btn-->
                    <div class="after_revoke_msg_display_l2 text-center" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets_home_v3/images/success_msg.svg" />
                        <p>
                            For L2 manager- Warning Letter Rejected. Process Revoked.
                        </p>                        
                    </div>
                    <!--End after_revoke_msg_display btn-->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn revok_next_l2">Revoke</button>
                    <button type="button" class="btn btn_padding filter_btn save_common_btn"
                        id="revoke_btn_l2" style="display: none;">Revoke</button>
                    <button type="button" class="btn btn_padding filter_btn_blue save_common_btn"
                        id="approve_btn_l2">Approve</button>
                </div>
            </div>

        </div>
    </div>
    <!-- End Approve or Revoke -->
<!-- End L2 Popup -->



<script>

$(document).ready(function () {
    console.log("hello");
    <?php $wl_popup_data = get_wl_popup_data();?>
    //Start For employee popups
        <?php if(!empty($wl_popup_data)){
            $employee = $wl_popup_data['employee'];            
            if(!empty($employee)){
                foreach($employee as $key_emp => $val_emp){ 
                    $wl_status = $val_emp['wl_status'];
                    if($wl_status == '8'){
                        $val_emp['popup_model_id'] = 'model_notify_emp_meeting_schedule';
                    }
                 ?> 
                    var emp_popup_model_id = "<?php echo $val_emp['popup_model_id']?>";
                    $('#'+emp_popup_model_id).modal('show');
    <?php }  
        }             
    } ?> 
    //End For employee popups 
    
    //Start For L2 popups
    <?php if(!empty($wl_popup_data)){
            $l2popup = $wl_popup_data['l2popup'];
            if(!empty($l2popup)){
                foreach($l2popup as $key_l2 => $val_l2){ 
                 ?> 
                    var l2_popup_model_id = "<?php echo $val_l2['popup_model_id']?>";
                    $('#'+l2_popup_model_id).modal('show');
    <?php }  
        }             
    } ?> 
    //End For L2 popups

    //Start For HR popups
    <?php if(!empty($wl_popup_data)){
            $hrpopup = $wl_popup_data['hrpopup'];
            if(!empty($hrpopup)){
                foreach($hrpopup as $key_hr => $val_hr){ 
                    $wl_status = $val_hr['wl_status'];
                    $hr_popup_model_id = $val_hr['popup_model_id'];

                    

                 ?> 
                    var wl_status = '<?php echo $wl_status; ?>';
                    if (wl_status == '2') {
                        var hr_popup_model_id = 'model_hr_review';
                        $('#'+hr_popup_model_id).modal('show');

                    }
                    if (wl_status == '7') {
                        var hr_popup_model_id = 'model_hr_meeting_schedule';
                        $('#'+hr_popup_model_id).modal('show');

                    }
                    if (wl_status == '8') {
                        var hr_popup_model_id = 'model_notify_hr_create_mom';
                        $('#'+hr_popup_model_id).modal('show');

                    }
                    
                    console.log(hr_popup_model_id);
                    
    <?php }  
        }             
    } ?> 
    //End For HR popups

    //Start For HRL2 popups
    <?php if(!empty($wl_popup_data)){
            $hrl2popup = $wl_popup_data['hrl2popup'];
            if(!empty($hrl2popup)){
                foreach($hrl2popup as $key_hrl2 => $val_hrl2){ 
                 ?> 
                    var hrl2_popup_model_id = "<?php echo $val_hrl2['popup_model_id']?>";
                    $('#'+hrl2_popup_model_id).modal('show');
    <?php }  
        }             
    } ?> 
    //End For HRL2 popups
});


        /*$(document).ready(function () {
            $('#auto_popup_employee_accept_req_meeting').modal('show'); //employee accept and req for meeting 

            $("#request_meeting_employee_accept_req_meeting").click(function () {
                $(".after_request_meeting_employee_accept_req_meeting").slideToggle();
                $(".employee_first_employee_accept_req_meeting").hide();
                $(".before_meeting_shedule_employee_accept_req_meeting").hide();
            });
            $("#accept_employee_employee_accept_req_meeting").click(function() {
                $(".after_employee_accept_employee_accept_req_meeting").slideToggle();
                $(".employee_first_employee_accept_req_meeting").hide();
                $(".before_meeting_shedule_employee_accept_req_meeting").hide();
            });
           
        });

        $(document).ready(function () {
            //$('#auto_popup_employee_accept').modal('show'); //employee only accept

            $("#request_meeting_employee_accept").click(function () {
                $(".after_employee_accept_employee_accept").slideToggle();
                $(".employee_first_employee_accept").hide();
                $(".before_meeting_shedule_employee_accept").hide();
            });
            $("#accept_employee_employee_accept").click(function() {
                $(".after_employee_accept_employee_accept").slideToggle();
                $(".employee_first_employee_accept").hide();
                $(".before_meeting_shedule_employee_accept").hide();
            });
           
        });

        $(document).ready(function () {
            //$('#auto_popup_notify_emp_meeting_schedule').modal('show'); //employee notfification popup after meeting schedule        
        });


        $(document).ready(function () {
            $('#auto_popup_hr_schedule_meeting').modal('show'); //HR meeting schedule 
                        
            $("#meeting_now_btn").click(function () {
                $(".after_request_meeting").hide();
                $(".meeting_now").show();
                $(".after_meeting_shedule").show();
                $(".notification_widget").hide();
            });
            $("#final_submit").click(function () {
                $(this).hide();
                $(".final_submit_widget").show();
                $(".meeting_now").hide();                
            });
        });

        $(document).ready(function () {
            //$('#auto_popup_hr_notification_to_create_mom').modal('show'); //HR notification to create MOM
            $("#escalate_btn").click(function () {
                $(".after_esclate").slideToggle();
                $(".before_esclate").hide();
                $(".modal-footer").hide();
            });

            $("#reissue_btn").click(function () {
                $(".reissue_esclate").slideToggle();
                $(".before_esclate").hide();
                $(".modal-footer").hide();
            });
        });

        $(document).ready(function () {    
            //$('#auto_popup_hr_approve_revoke').modal('show'); //HR notification for Approve or revoke
        });

        $(document).ready(function () {
            $("#approve_btn_hr").click(function () {
                $(".after_approve_msg_hr").slideToggle();
                $(".before_approve_hr").hide();
                $(".modal-footer").hide();
            });
            $(".revok_next_hr").click(function () {
                $(this).hide();
                $(".after_revoke_msg_hr").slideToggle();
                $(".before_approve_hr").hide();
                $("#approve_btn_hr").hide();
                $("#revoke_btn_hr").show();
            });
            $("#revoke_btn_hr").click(function () {
                $(".after_revoke_msg_hr").hide();
                $(".after_revoke_msg_display_hr").slideToggle();                
                $(".modal-footer").hide();
            });
        });


        $(document).ready(function () {    
           // $('#auto_popup_hr_l2_schedule_meeting').modal('show'); //HR L2 meeting schedule
            
            $("#meeting_now_btn_hr_l2").click(function () {
                $(".after_request_meeting_hr_l2").hide();
                $(".meeting_now_hr_l2").show();
                $(".after_meeting_shedule_hr_l2").show();
                $(".notification_widget").hide();
            });
            $("#final_submit_hr_l2").click(function () {
                $(this).hide();
                $(".final_submit_widget_hr_l2").show();
                $(".meeting_now_hr_l2").hide();                
            });
        });


        $(document).ready(function () {    
            //$('#auto_popup_l2_approve_revoke').modal('show'); //L2 notification for Approve or revoke
        });

        $(document).ready(function () {
            $("#approve_btn_l2").click(function () {
                $(".after_approve_msg_l2").slideToggle();
                $(".before_approve_l2").hide();
                $(".modal-footer").hide();
            });
            $(".revok_next").click(function () {
                $(this).hide();
                $(".after_revoke_msg_l2").slideToggle();
                $(".before_approve_l2").hide();
                $("#approve_btn_l2").hide();
                $("#revoke_btn_l2").show();
            });
            $("#revoke_btn_l2").click(function () {
                $(".after_revoke_msg_l2").hide();
                $(".after_revoke_msg_display_l2").slideToggle();                
                $(".modal-footer").hide();
            });
        });*/
 /***************employee popup**********************/
    function open_reason(id){
        $('#request_meting_'+id).css('display','none');
        $('#accept_employee_'+id).css('display','none');
        $('#before_reason_msg').css('display','none');
        $('#after_reason_msg_'+id).css('display','');
        $('#request_meting_'+id+'_next').css('display','');
    }
    function emp_accept(id) {
        user_id = $('#user_id_' + id).val();
        warn_id = $('#warn_id_' + id).val();
        event_type = $('#event_type_' + id).val();
        str = "user_id=" + user_id + "&warn_id=" + warn_id + "&event_type=" + event_type;
        $('#employee_first_' + id).html('<div class="ajax_loader"><div class="loader"><div></div><div></div><div></div><div></div></div></div>');
        $('#before_meeting_shedule_' + id).hide();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>warning_letter_v2_sb/accept_warning_letter',
            data: str,
            dataType: 'text',
            success: function(response) {
                $("#after_employee_accept_" + id).slideToggle();
                $("#employee_first_" + id).hide();
                $("#before_meeting_shedule_" + id).hide();
                location.reload(true);
            }
        });
    }

    function emp_request_meeting(id,dt) {
        user_id = $('#user_id_' + id).val();
        warn_id = $('#warn_id_' + id).val();
        reason = $('#'+dt).val();
        if(reason!=''){
            event_type = $('#event_type_' + id).val();
            str = "user_id=" + user_id + "&warn_id=" + warn_id + "&event_type=" + event_type+"&reason="+reason;
            $('#employee_first_' + id).html('<div class="ajax_loader"><div class="loader"><div></div><div></div><div></div><div></div></div></div>');
            $('#before_meeting_shedule_' + id).hide();
            $('#after_reason_msg_'+id).css('display','none');
            $('#request_meting_'+id+'_next').css('display','none');
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>warning_letter_v2_sb/emp_request_meeting',
                data: str,
                dataType: 'text',
                success: function(response) {
                    $("#after_employee_accept_" + id).slideToggle();
                    $("#employee_first_" + id).hide();
                    $("#before_meeting_shedule_" + id).hide();
                    location.reload(true);
                }
            });
        }else{
            alert('please provide reason');
        } 
    }
   
 /***************************************************/       
</script>

<script>
    $(document).on('click', '#meeting_now_btn', function() {
        var form = document.getElementById("hr_schedule_meeting");
        // Reset the form
        form.reset();

        // $(".after_request_meeting").hide();
        var wlei_id = $(this).data("wle_id");
        var user_id = $(this).data("user_id");
        var empNameValue = document.getElementById("emp_name_"+user_id).textContent;
        $("#participants").val(empNameValue);
        


        console.log(user_id);
        var wle_filed = '<input type="hidden" name="wle_id" value="' + wlei_id + '" id="wle_id">';

        $("#hr_schedule_meeting").append(wle_filed);
        $(".meeting_now").show();
        $(".after_meeting_shedule").show();
        $(".notification_widget").hide();
        $("#set_later").hide();
    });

    $(document).on('click', '#final_submit', function() {
        // validation
        var form = document.getElementById("hr_schedule_meeting");
        var formIsValid = true;

        var requiredElements = form.querySelectorAll('[required]');

        requiredElements.forEach(function(element) {
            if (element instanceof HTMLInputElement || element instanceof HTMLSelectElement || element instanceof HTMLTextAreaElement) {
                if (!element.value) {
                    formIsValid = false;
                    element.style.border = "1px solid red";
                    // alert("Please fill in all required fields.");
                    event.preventDefault();
                    return;                 
                }else{
                    element.style.border = "";
                }
            }
        });


        // validation end
        if (formIsValid) {
            
            $("#hr_schedule_meeting").hide();
            $(".modal-footer").hide();
            $("#meeting_loader").html('<div class="ajax_loader"><div class="loader"><div></div><div></div><div></div><div></div></div></div>');                    
            var formData = $("#hr_schedule_meeting").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("Warning_letter_v2/meeting_schedule_from_hr"); ?>',
                data: formData,
                success: function(response) {
                    var responsedata = JSON.parse(response);
                    if (responsedata.status === 'success') {
                        $("#meeting_loader").html('');
                        $(".final_submit_widget").show();
                        $(".meeting_now").hide();
                        $(".modal-footer").hide();                    
                        $('#after_meeting_shedule').hide();
                        window.location.reload();

                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
        
    });

    function reviewModal(warn_id) {
        
        alert(warn_id);
        
        $("#myModal_hr_approve_revoke").modal("show");
    }
</script>
<script>
/*****************************HR L2***************************/
$(document).on('click', '#meeting_now_btn_l2', function() {
        var form = document.getElementById("hr_schedule_meeting");
        // Reset the form
        form.reset();

        // $(".after_request_meeting").hide();
        var wlei_id = $(this).data("wle_id");
        var user_id = $(this).data("user_id");
        var empNameValue = document.getElementById("empName_"+user_id).textContent;
        $("#participants").val(empNameValue);

        console.log(user_id);
        var wle_filed = '<input type="hidden" name="wle_id" value="' + wlei_id + '" id="wle_id">';

        $("#hr_schedule_meeting").append(wle_filed);
        $(".meeting_now_hr_l2").show();
        $(".after_meeting_shedule_hr_l2").show();
        $(".notification_widget").hide();
        $("#set_later").hide();
    });

    $(document).on('click', '#final_submit', function() {
        // validation
        var form = document.getElementById("hr_schedule_meeting");
        var formIsValid = true;

        var requiredElements = form.querySelectorAll('[required]');

        requiredElements.forEach(function(element) {
            if (element instanceof HTMLInputElement || element instanceof HTMLSelectElement || element instanceof HTMLTextAreaElement) {
                if (!element.value) {
                    formIsValid = false;
                    element.style.border = "1px solid red";
                    // alert("Please fill in all required fields.");
                    event.preventDefault();
                    return;                 
                }else{
                    element.style.border = "";
                }
            }
        });


        // validation end
        if (formIsValid) {
            var formData = $("#hr_schedule_meeting").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("Warning_letter_v2/meeting_schedule_from_hr"); ?>',
                data: formData,
                success: function(response) {
                    var responsedata = JSON.parse(response);
                    if (responsedata.status === 'success') {
                        console.log(responsedata);
                        $(".final_submit_widget").show();
                        $(".meeting_now").hide();
                        $(".modal-footer").hide();                    
                        $('#after_meeting_shedule').hide();
                        window.location.reload();

                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
        
    });
/***********************************************************/
</script>