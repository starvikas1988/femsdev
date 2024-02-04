<div class="wrap">
    <section class="app-content">
        <div class="row">
            <!-- DataTable -->
            <div class="col-md-12">
                <div class="white_widget padding_3">
                    <div class="avail_widget_br">
                        <h2 class="avail_title_heading">Shortlisted Candidate List</h2>
                    </div>
                    <hr class="sepration_border">

                    <div class="body_widget">

                        <?php echo form_open('', array('method' => 'get')) ?>

                        <input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>'>

                        <div class="body-widget">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" class="form-control due_date-cal" id="from_date" name="from_date" value="<?php echo $from_date; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" class="form-control due_date-cal" id="to_date" name="to_date" value="<?php echo $to_date; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group filter-widget">
                                        <label>Brand</label>
                                        <select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>

                                            <?php
                                            foreach ($company_list as $key => $value) {
                                                $bss = "";
                                                if (in_array($value['id'], $brand))
                                                    $bss = "selected";
                                            ?>
                                                <option value="<?php echo $value['id']; ?>" <?php echo $bss; ?>><?php echo $value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group filter-widget">
                                        <label>Location</label>
                                        <select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>

                                            <?php
                                            //if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
                                            ?>
                                            <?php foreach ($location_list as $loc) : ?>
                                                <?php
                                                $sCss = "";
                                                if (in_array($loc['abbr'], $oValue))
                                                    $sCss = "selected";
                                                ?>
                                                <option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group filter-widget">
                                        <label>Department</label>
                                        <select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="--Select--" multiple>
                                            <?php
                                            foreach ($department_list as $k => $dep) {
                                                $sCss = "";
                                                if (in_array($dep['id'], $o_department_id))
                                                    $sCss = "selected";
                                            ?>
                                                <option value="<?php echo $dep['id']; ?>" <?php echo $sCss; ?>><?php echo $dep['shname']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group filter-widget">
                                        <label>Client</label>
                                        <select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="--Select--" multiple>
                                            <?php
                                            foreach ($client_list as $client) :
                                                $cScc = '';
                                                if (in_array($client->id, $client_id))
                                                    $cScc = 'Selected';
                                            ?>
                                                <option value="<?php echo $client->id; ?>" <?php echo $cScc; ?>><?php echo $client->shname; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group filter-widget">
                                        <label>Process</label>
                                        <select id="fprocess_id" name="process_id" autocomplete="off" placeholder="--Select--" class="select-box">
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($process_list as $process) :
                                                $cScc = '';
                                                if ($process->id == $process_id)
                                                    $cScc = 'Selected';
                                            ?>
                                                <option value="<?php echo $process->id; ?>" <?php echo $cScc; ?>><?php echo $process->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3" id="requisation_div" style="display:none;">
                                    <div class="form-group filter-widget">
                                        <label>Requisition</label>
                                        <select autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="--Select--" class="select-box">
                                            <option="">All</option>
                                                <?php /* foreach($get_requisition as $gr): ?>
  <?php
  $sRss="";
  if($gr['requisition_id']==$requisition_id) $sRss="selected";
  ?>
  <option value="<?php echo $gr['requisition_id']; ?>" <?php echo $sRss; ?>><?php echo $gr['requisition_id']; ?></option>
  <?php endforeach; */ ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group margin_all">
                                        <button type="submit" name="search" id="search" value="Search" class="btn btn_padding filter_btn_blue save_common_btn">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        </form>
                    </div>
                </div><!-- .widget -->
            </div>
            <!-- END DataTable -->
        </div><!-- .row -->

        <div class="common-top">
            <div class="row">
                <div class="col-sm-12">
                    <div class="white_widget padding_3">
                        <div class="common_table_widget new_table_chan table_export new_fixed_widget">
                            <table id="default-datatable" data-plugin="DataTable" class="table table-bordered skt-table">
                                <thead>
                                    <tr>
                                        <th>SL. No.</th>
                                        <th>Requision Code</th>
                                        <th>Last Qualification</th>
                                        <th>Onboarding Type</th>
                                        <th>Candidate Name</th>
                                        <th>Gender</th>
                                        <th>Mobile</th>
                                        <th>Skill Set</th>
                                        <th>Total Exp.</th>
                                        <th>Attachment</th>
                                        <th>Status</th>
                                        <?php if (is_access_dfr_module() == 1) {  ////ACCESS PART 
                                        ?>
                                            <th>Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $k = 1;
                                    $m = 1;
                                    // print_r($candidate_shortlisted);
                                    foreach ($candidate_shortlisted as $cd) :

                                        $r_id = $cd['r_id'];
                                        $c_id = $cd['can_id'];
                                        $c_status = $cd['candidate_status'];

                                        if ($c_status == 'P')
                                            $cstatus = "Pending";
                                        else if ($c_status == 'IP')
                                            $cstatus = "In Progress";
                                        else if ($c_status == 'SL')
                                            $cstatus = "Shortlisted";
                                        else if ($c_status == 'CS')
                                            $cstatus = "Selected";
                                        else if ($c_status == 'E')
                                            $cstatus = "Selected as Employee";
                                        else if ($c_status == 'R')
                                            $cstatus = "Rejected";

                                        if ($cd['requisition_status'] == 'CL') {
                                            $bold = "style='font-weight:bold; color:red'";
                                        } else {
                                            $bold = "";
                                        }

                                        if ($cd['attachment'] != '')
                                            $viewResume = 'View Resume';
                                        else
                                            $viewResume = '';
                                    ?>
                                        <tr>

                                            <td><?php echo $k++; ?></td>

                                            <td <?= $bold; ?>><?php echo $cd['requisition_id']; ?></td>
                                            <td><?php echo $cd['last_qualification']; ?></td>
                                            <td><?php echo $cd['onboarding_type']; ?></td>
                                            <td><?php echo $cd['fname'] . " " . $cd['lname']; ?></td>
                                            <td><?php echo $cd['gender']; ?></td>
                                            <td><?php echo $cd['phone']; ?></td>
                                            <td><?php echo $cd['skill_set']; ?></td>
                                            <td><?php echo $cd['total_work_exp']; ?></td>
                                            <td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>"><?php echo $viewResume; ?></a></td>
                                            <td width="110px"><?php echo $cstatus; ?>

                                            <?php
                                                $filled_no_position = $cd['filled_no_position'];
                                                $req_no_position = $cd['req_no_position'];
                                                if (is_access_dfr_module() == 1) {
                                                    if ($c_id != "") {
                                                        if ($c_status == 'SL') {                                                            
                                                            if(get_dept_folder()=="hr" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="super" || get_global_access()==1){
                                                                if ($cd['requisition_status'] != 'CL') {
                                                                    if ($req_no_position > $filled_no_position) {
                                                                        //--//
                                                                    } else {
                                                                        echo "<br><span class='action_msg'>Filled Position</span>";
                                                                    }
                                                            }
                                                            }
                                                        }                                                      
                                                    }
                                                }
                                            ?>
                                        
                                            </td>

                                            <?php if (is_access_dfr_module() == 1) {  ////ACCESS PART 
                                            ?>
                                                <td class="table_width1">
                                                    <?php

                                                    $sch_id = $cd['sch_id'];
                                                    $interview_type = $cd['interview_type'];
                                                    $interview_site = $cd['location']; //echo $interview_site;
                                                    $requisition_id = $cd['requisition_id'];                                                    
                                                    $department_id = $cd['department_id'];
                                                    $role_id = $cd['role_id'];
                                                    $sh_status = $cd['sh_status'];

                                                    if ($cd['department_id'] == 6) {
                                                        $req_no_position = ceil($req_no_position + (($req_no_position * 15) / 100));
                                                    } else {
                                                        $req_no_position = $req_no_position;
                                                    }

                                                    $params = $cd['requisition_id'] . "#" . $cd['fname'] . "#" . $cd['lname'] . "#" . $cd['hiring_source'] . "#" . $cd['d_o_b'] . "#" . $cd['email'] . "#" . $cd['phone'] . "#" . $cd['last_qualification'] . "#" . $cd['skill_set'] . "#" . $cd['total_work_exp'] . "#" . $cd['country'] . "#" . $cd['state'] . "#" . $cd['city'] . "#" . $cd['postcode'] . "#" . $cd['address'] . "#" . $cd['summary'] . "#" . $cd['attachment'] . "#" . $cd['gender'];

                                                    $cparams = $cd['fname'] . "#" . $cd['lname'] . "#" . $cd['hiring_source'] . "#" . $cd['d_o_b'] . "#" . $cd['email'] . "#" . $cd['phone'] . "#" . $cd['department_id'] . "#" . $cd['role_id'] . "#" . $cd['d_o_j'] . "#" . $cd['gender'] . "#" . $cd['location'] . "#" . $cd['requisition_id'] . "#" . $cd['address'] . "#" . $cd['country'] . "#" . $cd['state'] . "#" . $cd['city'] . "#" . $cd['postcode'];

                                                    if ($c_id != "") {

                                                        echo '<a class="btn btn-xs viewCandidate" href="' . base_url() . 'dfr/view_candidate_details/' . $c_id . '" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Details" ><img src="' . base_url() . 'assets_home_v3/images/view.svg" alt=""></a>';
                                                        
                                                        if ($c_status == 'SL') {
                                                            if(get_dept_folder()=="hr" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="super" || get_global_access()==1){
                                                                
                                                                if ($cd['requisition_status'] != 'CL') {

                                                                    if ($req_no_position > $filled_no_position) {
                                                                         // CHECK OFFICE ACCESS
                                                                         $pay_lock = 1;
                                                                         if (isDisablePayrollInfo($cd['location']) == false) {
                                                                             $pay_lock = 0;
                                                                         }  

                                                                        echo '<a class="btn btn-xs candidateApproval" p_access="' . $pay_lock . '" r_id="' . $r_id . '" c_id="' . $c_id . '" req_id="' . $requisition_id . '" c_status="' . $c_status . '" org_role="' . $cd['org_role'] . '" role_id="' . $cd['role_id'] . '"dept_id="' . $department_id . '" gender="' . $cd['gender'] . '"  location_id="' . $cd['location'] . '" brand_id="' . $cd['company'] . '" title="Approval to Final Selection"><img src="'.base_url().'assets_home_v3/images/approved.svg" alt=""></a>';
                                                                    } else {
                                                                        //echo "<span class='label label-info' style='font-size:12px; display:inline-block;'>Filled Position</span>";
                                                                    }
                                                                }

                                                            }
                                                        }
                                                    }
                                                    ?>

                                                    <div class="dropdown action_dropdown d_inline btn_left">
                                                        <button class="btn action_dropdown filter_btn dropdown-toggle" type="button" data-toggle="dropdown"
                                                            aria-expanded="true">
                                                            <img src="<?php echo base_url() ?>assets_home_v3/images/dot_menu.svg" alt="">
                                                        </button>
                                                        <ul class="dropdown-menu right_action_column" id="list_dropdown">
                                                            <?php 
                                                                if ($c_id != "") {
            
                                                                    //if($cd['requisition_status']!='CL'){
                                                                    if ($c_status == 'SL') {
                                                                        if ((isIndiaLocation($cd['location']) == true) and ($cd['org_role'] == 13) and ($department_id == 6) and ($cd['location'] != 'CHA')) {
                                                                           // echo '<li><a class="btn btn-default btn-xs letter_of_intent" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Letter of intent" style="font-size:12px" >LOI</a></li>';
                                                                        }
                                                                        if(get_dept_folder()=="hr" || get_role_dir()=="admin" || get_role_dir()=="manager" || get_role_dir()=="super" || get_global_access()==1){
                                                                           /* if ($cd['location'] == 'CHA') {
                                                                                echo '<li><a class="btn btn-xs viewOfferLetter" href="' . base_url() . 'dfr/candidate_offer_pdf/' . $c_id . '/Y" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Offer Letter "><img src="' . base_url() . 'assets_home_v3/images/view_offer_letter.svg" alt=""> View Offer Letter</a></li>';
                                                                            }*/

                                                                            if ($cd['requisition_status'] != 'CL') {                
                                                                                if ($req_no_position > $filled_no_position) {                
                                                                                    // CHECK OFFICE ACCESS
                                                                                    $pay_lock = 1;
                                                                                    if (isDisablePayrollInfo($cd['location']) == false) {
                                                                                        $pay_lock = 0;
                                                                                    }                                                                                     
                                                                                    echo '<li><a class="btn btn-xs candidateDecline" r_id="' . $r_id . '"  c_id="' . $c_id . '" c_status="' . $c_status . '" title="Cancel Shortlisted"><img src="'.base_url().'assets_home_v3/images/cancel.svg" alt=""> Cancel Shortlisted</a></li>';
                                                                                }
                                                                            }
            
                                                                        }
                                                                    } 

                                                                    if ($c_status != 'P') {            
                                                                        echo '<li><a class="btn btn-xs candidateInterviewReport" href="' . base_url() . 'dfr/view_candidate_interview/' . $c_id . '"  target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Interview Report"><img src="' . base_url() . 'assets_home_v3/images/report_black.svg" alt=""> Candidate Interview Report</a></li>';
                                                                    } 
                                                                        echo '<li><a class="btn btn-xs shorlistedCandidateTransfer" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Transfer Candidate"><img src="' . base_url() . 'assets_home_v3/images/transfer.svg" alt=""> Transfer Candidate</a></li>';
                                                                                
                                                                    if ($cd['location'] == 'CHA') {
                                                                        if ($cd['joining_kit'] == '') {
                                                                            echo '<li><a class="btn btn-xs " href="' . base_url() . 'dfr/download_joining_kit?c_id=' . $c_id . '&r_id=' . $r_id . '" title="Click to Download Joining Kit"><img src="' . base_url() . 'assets_home_v3/images/download_action.svg" alt=""> Download Joining Kit</a></li>';
 
                                                                            // href="'.base_url().'dfr/upload_joining_kit?c_id='.$c_id.'&r_id='.$r_id.'"
                                                                            echo '<li><a class="btn btn-xs upload_joining"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to Upload Joining Kit"><img src="' . base_url() . 'assets_home_v3/images/upload_icon.svg" alt=""> Upload Joining Kit</a></li>';
                                                                                       
                                                                        } else {
                                                                            echo '<li><a class="btn btn-xs " href="' . base_url() . 'uploads/joining_kit/' . $cd['joining_kit'] . '" title="Click to Download Joining Kit" target="_blank"><img src="' . base_url() . 'assets_home_v3/images/download_action.svg" alt=""> Download Joining Kit</a></li>';
                                                                        }
                                                                    }
                                                                    
                                                                }                                                            
                                                            ?>
                                                        </ul>
                                                    </div>                                                    
                                                </td>
                                            <?php } ?>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div><!-- .wrap -->
<!---------------------------------Letter of Intent---------------------------------->

<div class="modal fade" id="letter_of_intent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">

            <form class="frmLetterOfIntent" action="<?php echo base_url(); ?>dfr/loi_send" onsubmit="return finalselection()" method='POST'>

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Letter of Intent</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="c_id" name="c_id">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <select id="onboarding_typ" name="onboarding_typ" class="form-control">
                                    <option value="">-- Select type --</option>
                                    <option value="Regular">Regular</option>
                                    <option value="NAPS">NAPS</option>
                                    <option value="Stipend">Stipend</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name</label>                                
                                <input type="text" name="lname" id="lname" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>                                
                                <input type="text" name="email" id="email" class="form-control" value="" readonly>
                            </div>
                        </div> -->
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="lname" id="lname" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Training Start Date</label>
                                <input type="text" name="training_start_date" id="training_start_date" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stipend Amount</label>
                                <input type="text" name="stipend_amount" id="stipend_amount" class="form-control number-only-no-minus-also">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CTC Amount</label>
                                <input type="text" name="ctc_amount" id="ctc_amount" class="form-control number-only-no-minus-also">
                            </div>
                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <span style="float: left;">
                        <label>Candidate History: </label>
                        <span id="user_history">

                        </span>
                    </span>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id='send_loi_button' class="btn btn-primary" value="Save & Send">
                </div>

            </form>

        </div>
    </div>
</div>
<!----------------------------------Candidate Final Approval------------------------------->

<div class="modal fade" id="approvalFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmApprovalFinalSelect" id="candidateSelectionForm" action="<?php echo base_url(); ?>dfr/candidate_final_approval" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Final Candidate Approval</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="location_id" name="location_id" value="">
                    <input type="hidden" id="c_status" name="c_status" value="">
                    <input type="hidden" id="org_role" name="org_role" value="">
                    <input type="hidden" id="gender" name="gender" value="">
                    <input type="hidden" id="brand_id" name="brand_id" value="">
                    <input type="hidden" id="role_id" name="role_id" value="">
                    <input type="hidden" id="payroll_chek" name="payroll_chek" value="">

                    <div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
                        <div class="col-md-12" style="border:1px solid; border-color:#a94442;" id="prevUserInfoContent">

                        </div>
                    </div>
                    <!-- <hr> -->


                    <div class="row">

                        <div class="col-md-4 loi_check" style="display: none;">
                            <div class="form-group">
                                <input type="checkbox" name="is_loi" id="is_loi" value=""><label>&nbsp;&nbsp;Is Stipned Candidate?</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group loi_check_lbl">
                                <?php
                                if (isIndiaLocation(get_user_office_id()) == true) {
                                    echo '<label class="loi_lbl">Date of Joining (dd/mm/yyyy) <span class="red_bg">*</span></label>';
                                } else {
                                    echo '<label class="loi_lbl">Date of Joining (mm/dd/yyyy) <span class="red_bg">*</span></label>';
                                }
                                ?>
                                <input type="text" id="doj" name="doj" class="form-control due_date-cal" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Approval Comment <span class="red_bg">*</span></label>
                                <textarea class="form-control" id="approved_comment" name="approved_comment" required style="min-height:40px;"></textarea>
                            </div>
                        </div>

                    </div>
                    <div id="check_payroll">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Pay Type</label>
                                    <select class="form-control" id="pay_type" name="pay_type" required>
                                        <option value="">-Select-</option>
                                        <?php foreach ($paytype as $tokenpay) { ?>
                                            <option value="<?php echo $tokenpay['id']; ?>"><?php echo $tokenpay['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select class="form-control" id="pay_currency" name="pay_currency" required>
                                        <option value="">-Select-</option>
                                        <?php
                                        foreach ($mastercurrency as $mcr) {

                                            $getcr = "";
                                            $abbr_currency = $mcr['abbr'];
                                            if (in_array($myoffice_id, $setcurrency[$abbr_currency])) {
                                                $getcr = "selected";
                                            }
                                        ?>
                                            <option value="<?php echo $mcr['abbr']; ?>" <?php echo $getcr; ?>><?php echo $mcr['description']; ?> (<?php echo $mcr['abbr']; ?>)</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Employment type</label>
                                    <select class="form-control" id="emp_type" name="emp_type" required>
                                        <!-- value are enter from master_emp_status Table -->
                                        <option value="">-Select-</option>

                                        <?php foreach ($empstatus as $tokenEmp) { ?>
                                            <option value="<?php echo $tokenEmp['id']; ?>"><?php echo $tokenEmp['name']; ?></option>
                                        <?php } ?>


                                    </select>
                                </div>
                            </div>
							
							<div class="col-md-3">
                                <div class="form-group">
                                    <label>Contract duration</label>
                                    <select class="form-control" id="contract_dur_days" name="contract_dur_days" readonly>
											<option value="">-Select-</option>
                                            <option value="30">30 days</option>
											<option value="45">45 days</option>
											<option value="60">60 days</option>
											<option value="90">90 days</option>
											<option value="120">120 days</option>
											<option value="150">150 days</option>
											<option value="180">180 days</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Incentive Period</label>
                                    <select class="form-control" id="incentive_period" name="incentive_period">
                                        <option value="">-Select-</option>
                                        <option value="Monthly">Monthly</option>
                                        <!--<option value="Yearly">Yearly</option>-->
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Incentive Amount</label>
                                    <input type="text" min="0" id="incentive_amt" name="incentive_amt" onkeydown="return ( event.ctrlKey || event.altKey  || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)  || (event.keyCode==8) || (event.keyCode==9))" class="form-control" autocomplete="off" value='0'>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Joining Bonus</label>
                                    <input type="text" min="0" id="joining_bonus" name="joining_bonus" onkeydown="return ( event.ctrlKey || event.altKey  || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)  || (event.keyCode==8) || (event.keyCode==9))" class="form-control" autocomplete="off" value='0'>
                                </div>
                            </div>


                            <div class="col-md-3 indlocation">
                                <div class="form-group">
                                    <label>Variable Pay</label>
                                    <input type="text" min="0" step="0.01" id="variable_pay" onkeydown="return ( event.ctrlKey || event.altKey  || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)  || (event.keyCode==8) || (event.keyCode==9))" name="variable_pay" class="form-control" autocomplete="off" value='0'>
                                </div>
                            </div>
                            <div class="col-md-4 indlocation"></div>
                            <div class="col-md-4 indlocation"></div>

                            <!--Not needed as per current salary stucture of chandighar 19-04-2023 id='csplBonus'-->
                            <div class="col-md-6" style="display:none;">
                                <div class="form-group">
                                    <label>Skill Set for Bonus</label>
                                    <select class="form-control" id="skill_set_slab" name="skill_set_slab">
                                        <option value="0">-Select-</option>
                                        <?php /*?><?php foreach ($skillset_list as $skillse) { ?>
                                            <option value="<?php echo $skillse['amount']; ?>"><?php echo $skillse['skill_name']; ?></option>
                                        <?php } ?><?php */ ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" class='cspl_notreq' style="display:none;">
                                <div class="form-group">
                                    <label>Training Fees (per day)</label>
                                    <input type="text" id="training_fees" name="training_fees" class="form-control" onkeydown="return ( event.ctrlKey || event.altKey  || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)  || (event.keyCode==8) || (event.keyCode==9))" autocomplete="off" value='0'>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="grossid">
                                    <label>Monthly Total Earning (Gross Pay)</label>
                                    <input type="text" id="gross_amount" name="gross_amount" class="form-control" onkeydown="return ( event.ctrlKey || event.altKey  || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)  || (event.keyCode==8) || (event.keyCode==9))" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group perday" id="" style="display: none;">
                                    <label id="perday_lbl"></label>
                                    <input type="text" id="training_ctc" class="form-control" onkeydown="return ( event.ctrlKey || event.altKey  || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)  || (event.keyCode==8) || (event.keyCode==9))" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group perday" style="display: none;">
                                    <label>Training Fees (per day)</label>
                                    <input type="text" id="training_fees_perday" class="form-control" onkeydown="return ( event.ctrlKey || event.altKey  || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)  || (event.keyCode==8) || (event.keyCode==9))" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="stop_payroll" style="display:none;">
                        <input name="pay_type" value="0" type="hidden">
                        <input name="pay_currency" value="" type="hidden">
                        <input name="gross_amount" value="0" type="hidden">
                    </div>


                    <div id='calcKOL' style="display:none">

                        <table cellpadding='2' cellspacing="0" border='1' style='font-size:12px; text-align:center; width:100%'>
                            <tr bgcolor="#A9A9A9">
                                <th><strong>Salary Components</strong></th>
                                <th><strong>Monthly</strong></th>
                                <th><strong>Yearly</strong></th>
                            </tr>
                            <tr>
                                <td>Basic</td>
                                <td><input type="text" id="basic" name="basic" class="form-control" readonly>
                                <td><input type="text" id="basicyr" name="basicyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>HRA</td>
                                <td><input type="text" id="hra" name="hra" class="form-control" readonly>
                                <td><input type="text" id="hrayr" name="hrayr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Conveyance</td>
                                <td><input type="text" id="conveyance" name="conveyance" class="form-control" readonly>
                                <td><input type="text" id="conveyanceyr" name="conveyanceyr" class="form-control" readonly></td>
                            </tr>

                            <tr class='ind_oth'>
                                <td>Other Allowance</td>
                                <td><input type="text" id="allowance" name="allowance" class="form-control" readonly>
                                <td><input type="text" id="allowanceyr" name="allowanceyr" class="form-control" readonly></td>
                            </tr>

                            <tr class='cspl'>
                                <td>Medical Allowance</td>
                                <td><input type="text" id="medical_amt" name="medical_amt" class="form-control" readonly>
                                <td><input type="text" id="medical_amtyr" name="medical_amtyr" class="form-control" readonly></td>
                            </tr>

                            <!--Not needed as per current salary stucture of chandighar 19-04-2023 class='cspl'-->
                            <!--<tr>
                                <td>Statutory Bonus</td>
                                <td><input type="text" id="bonus_amt" name="bonus_amt" class="form-control" readonly>
                                <td><input type="text" id="bonus_amtyr" name="bonus_amtyr" class="form-control" readonly></td>
                            </tr>-->

                            <tr bgcolor="#D3D3D3">
                                <td>TOTAL EARNING (Groos Pay)</td>
                                <td><input type="text" id="tot_earning" name="tot_earning" class="form-control" readonly>
                                <td><input type="text" id="tot_earningyr" name="tot_earningyr" class="form-control" readonly></td>
                            </tr>

                            <tr>
                                <td>PF (Employer's)</td>
                                <td><input type="text" id="pf_employers" name="pf_employers" class="form-control" readonly>
                                <td><input type="text" id="pf_employersyr" name="pf_employersyr" class="form-control" readonly></td>
                            </tr>

                            <tr>
                                <td>ESIC (Employer's)</td>
                                <td><input type="text" id="esi_employers" name="esi_employers" class="form-control" readonly>
                                <td><input type="text" id="esi_employersyr" name="esi_employersyr" class="form-control" readonly></td>
                            </tr>

                            <!--<tr>
                                <td>Gratuity</td>
                                <td><input type="text" id="gratuity_employers" name="gratuity_employers" class="form-control" readonly>
                                <td><input type="text" id="gratuity_employersyr" name="gratuity_employersyr" class="form-control" readonly></td>
                            </tr>-->
                            <tr>
                                <td>Employer Labour Welfare Fund</td>
                                <td><input type="text" id="lwf_employers" name="lwf_employers" class="form-control" readonly>
                                <td><input type="text" id="lwf_employersyr" name="lwf_employersyr" class="form-control" readonly></td>
                            </tr>

                            <?php if (isIndiaLocation(get_user_office_id()) == true || get_user_office_id() == "CHA") {  ?>
                                <!--PLI Component Added -->
                                <tr>
                                    <td>Performance Linked Incentive (PLI)</td>
                                    <td><input type="text" id="pli_employers" name="pli_employers" class="form-control" readonly>
                                    <td><input type="text" id="pli_employersyr" name="pli_employersyr" class="form-control" readonly></td>
                                </tr>
                                <!--PLI Component Added-->
                            <?php } ?>

                            <tr bgcolor="#D3D3D3">
                                <td>CTC</td>
                                <td><input type="text" id="ctc" name="ctc" class="form-control" readonly>
                                    <input type="hidden" id="ctcchecker" name="ctcchecker" class="form-control" readonly>
                                    <input type="hidden" id="grosschecker" name="grosschecker" class="form-control" readonly>
                                </td>
                                <td><input type="text" id="ctcyr" name="ctcyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>P.Tax</td>
                                <td><input type="text" id="ptax" name="ptax" class="form-control" readonly>
                                <td><input type="text" id="ptaxyr" name="ptaxyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>ESIC (Employee's)</td>
                                <td><input type="text" id="esi_employees" name="esi_employees" class="form-control" readonly>
                                <td><input type="text" id="esi_employeesyr" name="esi_employeesyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>PF (Employee's)</td>
                                <td><input type="text" id="pf_employees" name="pf_employees" class="form-control" readonly>
                                    <input type="hidden" id="pf_employees2" name="pf_employees2">
                                </td>
                                <td><input type="text" id="pf_employeesyr" name="pf_employeesyr" class="form-control" readonly></td>
                            </tr>

                            <tr>
                                <td>Employee- LWF</td>
                                <td><input type="text" id="lwf_employees" name="lwf_employees" class="form-control" readonly>
                                <td><input type="text" id="lwf_employeesyr" name="lwf_employeesyr" class="form-control" readonly></td>
                            </tr>

                            <tr bgcolor="#D3D3D3">
                                <td>Take Home</td>
                                <td><input type="text" id="tk_home" name="tk_home" class="form-control" readonly></td>
                                <td><input type="text" id="tk_homeyr" name="tk_homeyr" class="form-control" readonly></td>
                            </tr>

                        </table>
                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                    <input type="button" name="finalcheck" id='finalcheck' class="btn btn_padding filter_btn_blue save_common_btn" value="Save">
                    <!--<input type="submit" name="submit" id='finalApproval' class="btn btn-primary" value="Save">-->
                </div>

            </form>

        </div>
    </div>
</div>



<div class="modal fade" id="modalfinalchecknow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabelFinal">Final Confirmation</h4>
            </div>
            <div id="modalfinalchecknowbody" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                <button type="button" id="finalcheckedsubmit" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-------------------------------Candidate Final Approval For Phillipines Start---------->


<div class="modal fade" id="approvalFinalSelectModelPhp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmApprovalFinalSelectPhp" id="candidateSelectionFormPhp" action="<?php echo base_url(); ?>dfr/candidate_final_approval_php" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Final Candidate Approval</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="location_id" name="location_id" value="">
                    <input type="hidden" id="c_status" name="c_status" value="">
                    <input type="hidden" id="org_role" name="org_role" value="">
                    <input type="hidden" id="gender" name="gender" value="">
                    <input type="hidden" id="brand_id" name="brand_id" value="">

                    <div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
                        <div class="col-md-12" style="border:1px solid; border-color:#a94442;" id="prevUserInfoContent">

                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                if (isIndiaLocation(get_user_office_id()) == true) {
                                    echo '<label>Date of Joining (dd/mm/yyyy) <span class="red_bg">*</span></label>';
                                } else {
                                    echo '<label>Date of Joining (mm/dd/yyyy) <span class="red_bg">*</span></label>';
                                }
                                ?>
                                <input type="date" id="doj" name="doj" class="form-control due_date-cal" autocomplete="off" required>
                            </div>
                        </div>

                        <!--	<div class="col-md-12">
                                        <div class="form-group">
                                                <label>Approval Comment</label>
                                                <textarea class="form-control" id="approved_comment" name="approved_comment" required></textarea>
                                        </div>
                                </div>-->

                    </div>

                    <div class="row" id="">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Job Level <span class="red_bg">*</span></label>
                                <input type="text" id="job_level" name="job_level" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Division <span class="red_bg">*</span></label>
                                <input type="text" id="division" name="division" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Immediate Supervisor <span class="red_bg">*</span></i></label>
                                <input type="text" id="immediate_supervisor" name="immediate_supervisor" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coordinate with <span class="red_bg">*</span></label>
                                <input type="text" id="coordinate_with" name="coordinate_with" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Overseas <span class="red_bg">*</span></label>
                                <input type="text" id="overseas" name="overseas" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Currency <span class="red_bg">*</span></label>
                                <select class="form-control" id="pay_currency" name="pay_currency" disabled>
                                    <option value="SL">Philippine Peso (PHP)</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Deminimis <span class="red_bg">*</span></label>
                                <input type="number" min="0" step=".01" id="deminimis" name="deminimis" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Standard Incentive <span class="red_bg">*</span></label>
                                <input type="number" min="0" step=".01" id="standard_incentive" name="standard_incentive" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Account Premium <span class="red_bg">*</span></label>
                                <input type="number" min="0" step=".01" id="account_premium" name="account_premium" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Night Differential <span class="red_bg">*</span></label>
                                <input type="number" min="0" step=".01" id="night_differential" name="night_differential" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group" id="">
                                <label>Monthly Basic Salary <span class="red_bg">*</span></i></label>
                                <input type="number" min="0" step=".01" id="basic_salary" name="basic_salary" class="form-control" onblur="calculate_total();" onkeyup="checkDec(this);" autocomplete="off" value='0' required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" id="">
                                <label>Total <span class="red_bg">*</span></label>
                                <input type="number" min="0" step=".01" id="total_amount" name="total_amount" class="form-control" autocomplete="off" value='0' readonly>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Qualification <span class="red_bg">*</span></label>
                                <textarea class="form-control" id="qualification" name="qualification" class="form-control" autocomplete="off" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Job Summary <span class="red_bg">*</span></label>
                                <textarea class="form-control" id="job_summary" name="job_summary" class="form-control" autocomplete="off" required></textarea>
                            </div>
                        </div>

                        <div class="row" id="" style="display:none;">
                            <input name="pay_type" value="0" type="hidden">
                            <input name="pay_currency" value="" type="hidden">
                            <input name="gross_amount" value="0" type="hidden">
                        </div>


                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                        <input type="button" name="finalcheckphp" id='finalcheckphp' class="btn btn_padding filter_btn_blue save_common_btn" value="Save">
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>



<div class="modal fade" id="modalfinalchecknowphp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabelFinal">Final Confirmation</h4>
            </div>
            <div id="modalfinalchecknowbodyphp" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                <button type="button" id="finalcheckedsubmitphp" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-------------------------------Candidate Final Approval For Phillipines end------------>


<!----------------------------------Decline Approval------------------------------->

<div class="modal fade" id="declineFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmDeclineFinalSelect" action="<?php echo base_url(); ?>dfr/candidate_final_decline" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Cancel Shortlisted Candidate</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="c_status" name="c_status" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Cancel Comment</label>
                                <textarea class="form-control" id="approved_comment" name="approved_comment" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id='declineApproval' class="btn btn_padding filter_btn_blue save_common_btn" value="Save">
                </div>

            </form>

        </div>
    </div>
</div>


<!---------------Candidate Transfer-------------------->
<div class="modal fade" id="transferShortlistedCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmTransferShortlistedCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Candidate Transfer</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" class="form-control">
                    <input type="hidden" id="c_id" name="c_id" class="form-control">
                    <input type="hidden" id="c_status" name="c_status" class="form-control">
                    <input type="hidden" name="req_id" id="req_id" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>List of Requisition</label>
                                <!--<select class="form-control" id="req_id" name="req_id">
                                        <option value="">-Select-</option>
                                        <option value="0">Pool</option>
                                            <?php foreach ($getrequisition as $row) { ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['req_desc']; ?></option>
                                            <?php } ?>
                                </select>-->
                                <input type="text" name="search_req" id="search_req" class="form-control" placeholder="Type Requisition Number">
                                <div id="searchList"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-left:8px" id="req_details">

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Transfer Comment</label>
                                <textarea class="form-control" id="transfer_comment" name="transfer_comment"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" class="btn btn_padding filter_btn_blue save_common_btn" value="Save">
                </div>

            </form>

        </div>
    </div>
</div>
<!---------------Joining kit upload-------------------->
<div class="modal fade" id="upload_joining_kit_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmjoiningkit" id="frmjoiningkit" action="<?php echo base_url(); ?>base_url().'dfr/upload_joining_kit?" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Joining Kit Upload</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" class="form-control">
                    <input type="hidden" id="c_id" name="c_id" class="form-control">
                    <input type="hidden" id="c_status" name="c_status" class="form-control">



                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload Joining Kit</label>
                                <input type="file" name="joining_kit_pdf" id="joining_kit_pdf" class="form-control" accept=".pdf" required="required" onChange="check_size(this)">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" class="btn btn_padding filter_btn_blue save_common_btn" value="Save">
                </div>

            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
    document.querySelector("#req_no_position").addEventListener("keypress", function(evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });
</script>
<script>
    /*$(function() {  
     $('#multiselect').multiselect();
     
     $('#edurequisition_id').multiselect({
     includeSelectAllOption: true,
     enableFiltering: true,
     enableCaseInsensitiveFiltering: true,
     filterPlaceholder: 'Search for something...'
     }); 
     }); */
</script>
<script>
    $(function() {
        $('#multiselect').multiselect();

        $('#fdoffice_ids').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            numberDisplayed: 2,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>
<script>
    $(function() {
        $('#multiselect').multiselect();

        $('#select-brand').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            numberDisplayed: 2,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>

<script>
    $(function() {
        $('#multiselect').multiselect();

        $('#fclient_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            numberDisplayed: 2,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>
<script>
    /*$(function() {  
     $('#multiselect').multiselect();
     
     $('#fprocess_id').multiselect({
     includeSelectAllOption: true,
     enableFiltering: true,
     enableCaseInsensitiveFiltering: true,
     filterPlaceholder: 'Search for something...'
     }); 
     }); */
</script>
<script>
    $(function() {
        $("#training_start_date").datepicker();
        $('#multiselect').multiselect();

        $('#select-department').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            numberDisplayed: 2,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select-box').selectize({
            sortField: 'text'
        });
    });

    function calculate_total() {
        var v_doj = $('.frmApprovalFinalSelectPhp #doj').val();
        var v_deminimis = $('#deminimis').val();
        var v_standard_incentive = $('#standard_incentive').val();
        var v_account_premium = $('#account_premium').val();
        var v_night_differential = $('#night_differential').val();
        var v_basicsalary = $('#basic_salary').val();
        if (v_deminimis == '') {
            $('#deminimis').val(0);
            v_deminimis = 0;
        }
        if (v_standard_incentive == '') {
            $('#standard_incentive').val(0);
            v_standard_incentive = 0;
        }
        if (v_account_premium == '') {
            $('#account_premium').val(0);
            v_account_premium = 0;
        }
        if (v_night_differential == '') {
            $('#night_differential').val(0);
            v_night_differential = 0;
        }
        if (v_basicsalary == '') {
            $('#basic_salary').val(0);
            v_basicsalary = 0;
        }

        //console.log(v_basicsalary)
        var v_totalamount = parseFloat(v_deminimis) + parseFloat(v_standard_incentive) + parseFloat(v_account_premium) + parseFloat(v_night_differential) + parseFloat(v_basicsalary);
        console.log('v_total' + v_totalamount);
        tot = v_totalamount.toFixed(2);
        console.log('tot' + tot);
        $('#total_amount').val(v_totalamount.toFixed(2));
    }
</script>


<!--summer note editor-->
<script>
    $(document).ready(function() {
        // $('#qualification').summernote();
    });
    $(document).ready(function() {
        // $('#job_summary').summernote();
    });
</script>
<script>
    $(".candidateApproval").click(function(e) {
        $('#sktPleaseWait').modal('show');
        var location = $(this).attr('location_id');
        $.post("<?= base_url() ?>dfr/get_indlocation/" + location).done(function(dat) {
            $('#sktPleaseWait').modal('hide');
            if (dat == true) {
                $(".indlocation").css("display", 'block');
            } else {
                $(".indlocation").css("display", 'none');
            }
        });

    });

    //From date , to date restriction//
	$(document).ready(function(){
	///////////////////////
	var d = new Date();
	var monthNames = ["January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"];
	today = monthNames[d.getMonth()] + ' ' + d.getDate() + ' ' + d.getFullYear();


	$('#from_date').datepicker({
		defaultDate: "+1d",
		//minDate: 1,
		maxDate: new Date(), // Set maxDate to the current date
		dateFormat: 'yy-mm-dd',
		showOtherMonths: true,
		changeMonth: true,
		selectOtherMonths: true,
		required: true,
		showOn: "focus",
		numberOfMonths: 1,
	});

	$('#to_date').datepicker({
		defaultDate: "+1d",
		minDate: "<?php echo date('Y-m-d', strtotime(($from_date))); ?>", // Set maxDate to the current date
		maxDate: new Date(), // Set maxDate to the current date
		dateFormat: 'yy-mm-dd',
		showOtherMonths: true,
		changeMonth: true,
		selectOtherMonths: true,
		required: true,
		showOn: "focus",
		numberOfMonths: 1,
	});

	$('#from_date').change(function () {
		var from = $('#from_date').datepicker('getDate');
		var date_diff = Math.ceil((from.getTime() - Date.parse(today)) / 86400000);
		
		var maxDate_d = date_diff+6+'d';
		date_diff = date_diff + 'd';
		$('#to_date').val('').removeClass('hasDatepicker').datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: date_diff,
			maxDate: new Date(), // Set maxDate to the current date
		});
	});

	$('#to_date').keyup(function () {
		$(this).val('');
		alert('Please select date from Calendar');
	});
	$('#from_date').keyup(function () {
		$('#from_date,#to_date').val('');	
		alert('Please select date from Calendar');
	});
	});
</script>

<!--start datatable-->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script>
    var table = $('#default-datatable').DataTable({
        lengthChange: false,
        scrollX: true,
      scrollCollapse: true,
      fixedHeader: true,
        fixedColumns: {
            left: 0,
            right: 1
        },
    });
    new $.fn.dataTable.Buttons(table, {
        buttons: [{
            extend: 'excelHtml5',
            text: 'Export to Excel',
            exportOptions: {
                columns: ':not(:last-child)',
            }
        },]
    });
    table.buttons().container()
        .appendTo($('.col-sm-6:eq(0)', table.table().container()))
</script>
<!--end datatable-->

<!--start dropdown sticky-->
<script>
	var dropdownMenu;
	$(document).ready(function() {
		$(window).on('show.bs.dropdown', function(e) {
			dropdownMenu = $(e.target).find('#list_dropdown');
			$('body').append(dropdownMenu.detach());
			var eOffset = $(e.target).offset();
			dropdownMenu.css({
				'display': 'block',
				'top': eOffset.top + $(e.target).outerHeight(),
				'left': eOffset.left,
				'min-width': '80px'
			});
		});
		$(window).on('hide.bs.dropdown', function(e) {
			$(e.target).append(dropdownMenu.detach());
			dropdownMenu.hide();
		});
	});
</script>
<!--end dropdown sticky-->