<!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/> -->
<style>
    #req_qualification_container {
        display: none;
    }

    /*start custom design css here*/
    .red-btn {
        width: 100px;
        padding: 10px;
        background: #f00;
        color: #fff;
        font-size: 13px;
        letter-spacing: 0.5px;
        transition: all 0.5s ease-in-out 0s;
        border: none;
        border-radius: 5px;
    }

    .red-btn:hover {
        background: #af0606;
        color: #fff;
    }

    .candidate-area {
        width: 100%;
    }

    .candidate-area label {
        margin: 10px 0 0 0;
    }

    .cloumns-bg {
        background: #eee;
        padding: 10px;
    }

    .cloumns-bg1 {
        background: #f5f5f5;
        padding: 10px;
    }

    .no-padding {
        padding: 0;
        margin: 0;
    }

    .table-small {
        height: 400px;
        overflow: scroll;
    }

    /*end custom design css here*/
    .btn-mul .btn-group {
        width: 100%;
    }

    .filter-widget .multiselect-container {
        width: 100%;
    }

    /*start tbale height scroll*/
    .requisition_scroll {
        width: 100%;
        height: 500px;
        overflow-x: scroll;
        overflow-y: scroll;
    }

    .requisition_scroll .bg-info {
        position: sticky;
        top: 0;
    }

    .modal .filter-widget i {
        vertical-align: top;
    }

    /*end tbale height scroll*/
</style>

<div class="wrap">



    <section class="app-content">

        <div class="row">
            <div class="col-md-12">
                <div class="white_widget padding_3">
                    <div class="row d_flex">
                        <div class="col-md-4">
                            <div class="avail_widget_br">
                                <?php
                                if ($req_status == 0) {
                                    $req_Status = 'Open';
                                } else if ($req_status == 1) {
                                    $req_Status = 'Closed';
                                } else if ($req_status == 3) {
                                    $req_Status = 'Pending';
                                } else {
                                    $req_Status = 'Cancel';
                                }
                                ?>
                                <h2 class="avail_title_heading">Manage <?php echo $req_Status; ?> Requisition</h2>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="right_side">
                                <a href='?req_status=0' class="btn btn_padding plan_btn btn_left <?php if ($req_status == 0) {
                                                                                                        echo 'active_req';
                                                                                                    } ?>">Open</a>
                                <a href='?req_status=3' class="btn btn_padding plan_btn btn_left <?php if ($req_status == 3) {
                                                                                                        echo 'active_req';
                                                                                                    } ?>">Pending</a>
                                <a href='?req_status=1' class="btn btn_padding plan_btn btn_left <?php if ($req_status == 1) {
                                                                                                        echo 'active_req';
                                                                                                    } ?>">Closed</a>
                                <a href='?req_status=2' class="btn btn_padding plan_btn btn_left <?php if ($req_status == 2) {
                                                                                                        echo 'active_req';
                                                                                                    } ?>">Cancel/Decline</a>
                            </div>
                        </div>
                    </div>
                    <hr class="sepration_border">

                    <div class="widget-body no_padding">

                        <!--<form id="form_new_user" method="GET" action="<?php //echo base_url('dfr');        
                                                                            ?>">-->
                        <?php echo form_open('', array('method' => 'get')) ?>

                        <input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>'>

                        <div class="body_widget">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" class="form-control due_date-cal" id="from_date" name="from_date" value="<?php echo $from_date; ?>" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" class="form-control due_date-cal" id="to_date" name="to_date" value="<?php echo $to_date; ?>" readonly autocomplete="off">
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
                                    <div class="form-group margin_all filter-widget">
                                        <label>Department</label>
                                        <select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
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
                                    <div class="form-group margin_all filter-widget">
                                        <label>Client</label>
                                        <select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="Select Client" multiple>
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
                                    <div class="form-group margin_all filter-widget">
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
                                        <select autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="Select Requisition" class="select-box">
                                            <option="">ALL</option>
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

                                <div class="col-sm-3">
                                    <div class="form-group margin_all">
                                        <label class="visiblity_hidden d_block">Search</label>
                                        <button type="submit" name="search" id="search" value="Search" class="btn btn_padding filter_btn_blue save_common_btn">
                                            Search
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <!--
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" name="search" id="search" value="Search" class="submit-btn">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
							-->
                        </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="common-top">
            <div class="row">
                <div class="col-md-12">
                    <div class="white_widget padding_3 dfr_table_widget">
                        <div class="widget-body no_padding gapping_less">
                            <div class="row">
                                <?php
                                if ((get_dept_folder() == "wfm" || get_global_access() == 1 || $is_role_dir == "admin" || $is_role_dir == "manager" || is_access_dfr_module() == true || is_approve_requisition() == true) && (get_user_fusion_id() != "FCHA002023" && get_user_fusion_id() != "FCHA003524" && get_user_fusion_id() != "FCHA002279" && get_user_fusion_id() != "FCHA005440")) {
                                ?>
                                    <div class="col-md-12">
                                        <div class="right_side manual_widget_new">
                                            <div class="form-group">
                                                <a class="btn btn_padding filter_btn addRequisition">Add Requisition</a>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>

                            </div>
                            <?php
                            //  print_r($get_requisition_list);die;
                            ?>
                            <div id="bg_table" class="common_table_widget report_hirarchy_new table_export new_fixed_widget1 manage_columns">
                                <table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table">
                                    <thead>
                                        <tr>
                                            <th>SL. No.</th>
                                            <th>Requisition Code</th>
                                            <th>Type</th>
                                            <th>Company Brand</th>
                                            <th>Department</th>
                                            <th>Due Date</th>
                                            <?php if ($oValue == 'CHA') { ?>
                                                <th>Proposed Date</th>
                                            <?php } ?>
                                            <th>Position</th>
                                            <th>Client</th>
                                            <th>Process</th>
                                            <th>Required Position</th>
                                            <th>Filled Position</th>
                                            <th>Total Candidate(count)</th>
                                            <th>Total Shortlisted(count)</th>
                                            <th>Batch No</th>
                                            <th>Raised By</th>
                                            <th>Raised Date</th>
                                            <th>Approved By</th>
                                            <th>Approved Date</th>
                                            <th>Trainer/L1 Supervisor</th>
                                            <th>Closed Date</th>
                                            <?php if ($req_status == 1) { ?>
                                                <th>Closed Comment</th>
                                            <?php } ?>
                                            <?php if ($req_status != 2) { ?>
                                                <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($get_requisition_list as $row) :

                                            $r_status = $row['requisition_status'];
                                            $id = $row['id'];

                                            $DueDate = $row['dueDate'];

                                            if ($req_status == 3) {
                                                $approved_name = "---";
                                            } else {
                                                $approved_name = $row['approved_name'];
                                            }

                                            $raised_by = $row['raised_by'];
                                            $approved_date = $row['approved_date'] != '' || $row['approved_date'] != null ? date_format(date_create($row['approved_date']), 'd/m/Y') : '';
                                        ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $row['requisition_id']; ?></td>
                                                <td><?php echo $row['req_type']; ?></td>
                                                <td><?php echo $row['company_brand_name']; ?></td>
                                                <td><?php echo $row['department_name']; ?></td>
                                                <td><?php echo $row['dueDate']; ?></td>
                                                <?php if ($oValue == 'CHA') { ?>
                                                    <td><?php echo $row['proposed_date']; ?></td>
                                                <?php } ?>
                                                <td><?php echo $row['role_name']; ?></td>
                                                <td><?php echo $row['client_name']; ?></td>
                                                <td><?php echo $row['process_name']; ?></td>
                                                <td><?php echo $row['req_no_position']; ?></td>
                                                <td><?php echo $row['count_canasempl']; ?></td> <!-- dynamic filled position count -->
                                                <td><?php echo $row['can_count']; ?></td>
                                                <td><?php echo $row['shortlisted_candidate']; ?></td>
                                                <td><?php echo $row['job_title']; ?></td>
                                                <td><?php echo $row['raised_name']; ?></td>
                                                <td><?php echo mysqlDt2mmddyyDate($row['raised_date']); ?></td>
                                                <td><?php echo $approved_name; ?></td>
                                                <td><?php echo $approved_date; ?></td>
                                                <td><?php echo $row['l1_supervisor']; ?></td>
                                                <td><?php echo $row['closed_date']; ?></td>
                                                <?php if ($req_status == 1) { ?>
                                                    <td><?php echo $row['closed_comment']; ?></td>
                                                <?php } ?>

                                                <?php if ($req_status != 2) { ?>
                                                    


                                                    <td class="table_width3">
                                                    <?php
                                                        $r_id = $row['id'];
                                                        $requisition_id = $row['requisition_id'];
                                                        $requisition_status = $row['requisition_status'];
                                                        $due_date = $row['due_date'];
                                                        $currDate = date('Y-m-d');

                                                        $dept_id = $row['department_id'];
                                                        $role_folder = $row['role_folder'];

                                                        //echo $row['count_canasempl'];
                                                        //$params=$row['location']."#".$row['dueDate']."#".$row['department_id']."#".$row['role_id']."#".$row['client_id']."#".$row['process_id']."#".$row['employee_status']."#".$row['req_qualification']."#".$row['req_exp_range']."#".$row['req_no_position']."#".$row['job_title']."#".$row['job_desc']."#".$row['req_skill']."#".$row['additional_info']."#".$row['raised_name']."#".$row['raised_date']."#".$row['requisition_status']."#".$row['req_type'];
                                                        //."#".$row['filled_no_position']

                                                        $params = $row['location'] . "#" . $row['dueDate'] . "#" . $row['department_id'] . "#" . $row['role_id'] . "#" . $row['client_id'] . "#" . $row['process_id'] . "#" . $row['employee_status'] . "#" . $row['req_qualification'] . "#" . $row['req_exp_range'] . "#" . $row['req_no_position'] . "#" . $row['job_title'] . "#" . $row['job_desc'] . "#" . $row['req_skill'] . "#" . $row['additional_info'] . "#" . $row['req_type'] . "#" . $row['proposed_date'] . "#" . $row['company_brand'] . "#" . $row['raised_name'] . "#" . $row['raised_date'] . "#" . $row['requisition_status'] . "#" . $row['site_id'] . "#" . "editme" . "#" . $row['work_type'] . "#" . $row['is_asset'] . "#" . @$row['assets_id'] . "#" . $row['filled_no_position'];

                                                        if ($r_status == 'P') {
                                                            $title = "View requisition";
                                                            $class = "btn action_btn_hover1 btn-xs";
                                                            $design = "view.svg";
                                                        } else if ($r_status == 'A' || $r_status == 'CL') {
                                                            $title = "Click to View & Manage Approved Requisition";
                                                            $class = "btn btn-xs action_btn_hover1 small-icon";
                                                            $design = "approved.svg";
                                                        } else if ($r_status == 'R') {
                                                            $title = "Click to View Decline requisition";
                                                            $class = "btn action_btn_hover1 btn-xs small-icon";
                                                            $design = "view.svg";
                                                        } else {
                                                            // echo "";
                                                        }

                                                        if (is_access_dfr_module() == 1 || is_approve_requisition() == true) {

                                                            if ($r_status != 'C') {

                                                                echo '<a class="' . $class . '" href="' . base_url() . 'dfr/view_requisition/' . $id . '" title="' . $title . '"><img src="' . base_url() . 'assets_home_v3/images/' . $design . '" alt=""></a>';
                                                            }
                                                        }
                                                        ?>
                                                    <div class="dropdown action_dropdown d_inline">
                                                            <button class="btn action_dropdown filter_btn dropdown-toggle" type="button" data-toggle="dropdown"
                                                                aria-expanded="true">
                                                                <img src="<?php echo base_url() ?>assets_home_v3/images/dot_menu.svg" alt="">
                                                            </button>
                                                            <ul class="dropdown-menu right_action_column" id="list_dropdown">

                                                            <?php
                                                        

                                                        if (get_dept_folder() == "wfm" || $is_role_dir == "super" || is_approve_requisition() == true) {

                                                            if ($row['can_count'] == 0) {

                                                                if ($r_status == 'A') {
                                                                    echo "<li><button title='Decline Requisition' type='button' r_id='$r_id' requisition_id='$requisition_id' requisition_status='$requisition_status' class='btn small-icon action_btn_hover1 btn-xs cancelRequisition' style='font-size:12px'><div class='action_img_width'><img src='" . base_url() . "assets_home_v3/images/cancel.svg' alt=''></div>Decline Requisition</button><li>";
                                                                } else if ($r_status == 'C') {
                                                                    //echo "<span class='label label-danger' style='font-size:10px; min-width:80px; display:inline-block;'>Cancel </span>";
                                                                } else {
                                                                    //echo '';
                                                                }


                                                                if ($r_status != 'C' && $r_status != 'CL') {

                                                                    echo "<li><button title='Edit Requisition' type='button' r_id='$r_id' requisition_id='$requisition_id' params='$params' class='btn small-icon action_btn_hover1 btn-xs editRequisition'><div class='action_img_width'><img src='" . base_url() . "assets_home_v3/images/edit_icon.svg' alt=''></div>Edit Requisition</button><li>";
                                                                }
                                                            }
                                                        }


                                                        //if( get_dept_folder()=="wfm" || $is_role_dir=="super"  || $is_role_dir=="manager"|| is_approve_requisition()==true ){	
                                                        //if(get_dept_folder()=="hr" || get_role_dir()=="super"){

                                                        if ($current_user == $raised_by || is_assign_trainer_dfr() == true) {

                                                            if ($r_status == 'A') { /* $row['count_canasempl'] > 0 &&  */

                                                                if ($row['department_id'] == 6 && $row['role_folder'] == 'agent') {
                                                                    echo "<li><button title='Assign Trainer' type='button' r_id='$r_id' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-xs small-icon action_btn_hover1  handoverRequisition'><div class='action_img_width'><img src='" . base_url() . "assets_home_v3/images/assign_user.svg' alt=''></div>Assign Trainer</button><li>";
                                                                } else {
                                                                    echo "<li><button title='Assign L1 Supervisor' type='button' r_id='$r_id' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-xs small-icon action_btn_hover1 assignTlRequisition'><div class='action_img_width'><img src='" . base_url() . "assets_home_v3/images/assign_l1.svg' alt=''></div>Assign L1 Supervisor</button></li>";
                                                                }
                                                            }
                                                        }


                                                        if (is_force_close_dfr_requisition() == true) {

                                                            if ($r_status != 'C' && $r_status != 'CL' && $r_status != 'P') {
                                                                echo "<li><button title='Force Close Requisition' type='button' rid='$r_id' raised_by='$raised_by' dept_id='$dept_id' role_folder='$role_folder' class='btn action_btn_hover1 btn-xs small-icon forceclosedRequisitionModel'><div class='action_img_width'><img src='" . base_url() . "assets_home_v3/images/cancel.svg' alt=''></div>Force Close Requisition</button></li>";
                                                            }
                                                        }

                                                        if (get_global_access() == true || is_approve_requisition() == true) {

                                                            if ($r_status == 'CL') {

                                                                echo "<li><button title='Reopen Requisition' type='button' r_id='$r_id' class='btn btn_left btn-xs reopenRequisition'><div class='action_img_width'><img src='" . base_url() . "assets_home_v3/images/open.svg' alt=''></div></button>Reopen Requisition</li>";
                                                            }
                                                        }
                                                        ?>









                                                                <!-- <li>
                                                                    <a href="#">
                                                                        <div class="action_img_width">
                                                                            <img src="<?php //echo base_url() ?>assets_home_v3/images/dot_menu.svg" alt="">
                                                                        </div> HTML
                                                                    </a>
                                                                </li> -->
                                                                
                                                               
                                                            </ul>
                                                        </div>
                                                        

                                                        <?php
                                                        if (get_dept_folder() == "wfm" || $is_role_dir == "super" || is_approve_requisition() == true) {
                                                            if ($row['can_count'] == 0) {
                                                                if ($r_status == 'A') {
                                                                    //--//
                                                                } else if ($r_status == 'C') {
                                                                    echo "<span class='action_msg'>Cancel</span>";
                                                                } else {
                                                                    //-//
                                                                }
                                                            }
                                                        }
                                                        ?>
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
        </div>

    </section>
</div>


<!---------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------->

<!----------- Add Requisition model ------------>
<div class="modal fade dfr_widget" id="addRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form class="frmAddRequisition" action="<?php echo base_url(); ?>dfr/add_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Add New Requisition</h4>
                </div>
                <div class="modal-body">
                    <div class="filter-widget">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Location <span class="red_bg">*</span></label>
                                    <select class="select-box location" name="location" id="location" required>
                                        <option value="">--Select--</option>
                                        <?php
                                        foreach ($location_list as $ld) : $abb = $ld['abbr'];
                                            if (get_user_fusion_id() == "FCHA000263") {
                                                if ($abb == "CHA") {
                                        ?>
                                                    <option value="<?php echo $ld['abbr']; ?>"><?php echo $ld['office_name']; ?></option>
                                                <?php
                                                } else {
                                                    echo "";
                                                }
                                            } else {
                                                ?><option value="<?php echo $ld['abbr']; ?>"><?php echo $ld['office_name']; ?></option><?php }
                                                                                                                                endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Department <span class="red_bg">*</span></label>
                                    <select class="select-box" id="department_id" name="department_id" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($department_data as $row) : ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['shname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Requisition Type <span class="red_bg">*</span></label>
                                    <select class="select-box" id="req_type" name="req_type" required>
                                        <option value="">--Select--</option>
                                        <option value="Growth">Growth</option>
                                        <option value="Attrition">Attrition</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Due Date</label>
                                    <input type="text" id="due_date" name="due_date" class="form-control due_date-cal" disabled>
                                </div>
                            </div>

                            <div class="col-md-3" id='proposed_date_add_col' style='display:none;'>
                                <div class="form-group">
                                    <label>Proposed New Date</label>
                                    <input type="text" id="proposed_date_add" name="proposed_date" class="form-control" readonly="readonly">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Company Brand <span class="red_bg">*</span></label>
                                    <select id="company_brand" name="company_brand" class="select-box brand" required>
                                        <option value="">-- Select Brand --</option>
                                        <?php
                                        foreach ($company_list as $key => $value) {
                                            if (get_user_fusion_id() == "FCHA000263") {
                                                if ($value['name'] == "CSPL") {
                                        ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                } else {
                                                    echo "";
                                                }
                                            } else {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Client <span class="red_bg">*</span></label>
                                    <select class="select-box" id="fdclient_id" name="client_id" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($client_list as $client) : ?>
                                            <option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Process <span class="red_bg">*</span></label>
                                    <select class="select-box" id="fdprocess_id" name="process_id" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($process_list as $process) : ?>
                                            <option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Position <span class="red_bg">*</span></label>
                                    <select class="select-box" id="role_id" name="role_id" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($role_data as $row1) : ?>
                                            <option value="<?php echo $row1->id; ?>"><?php echo $row1->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" id="job_description_div" style="display:none;">
                                <div class="form-group">
                                    <a href="#" id="job_description_title" class="view_job" data-toggle="modal" data-target="#job_discription_edit">View Job Description</a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Required no of Position <span class="red_bg">*</span></label>
                                    <input type="number" id="req_no_position" name="req_no_position" class="form-control" value="" placeholder="Enter Req. no of Position..." required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Batch No <span class="red_bg">*</span></label>
                                    <input type="text" id="job_title" name="job_title" class="form-control job_title" value="" placeholder="Enter Batch No..." readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Required Skill <span class="red_bg">*</span></label>
                                    <input type="text" id="req_skill" name="req_skill" class="form-control" value="" placeholder="Enter Required Skill..." required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Is Asset Required? <span class="red_bg">*</span></label>
                                    <select class="select-box" id="is_asset" name="is_asset" required>
                                        <option value="">--Select--</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 asset_required" style="display:none;">
                                <div class="form-group btn-mul">
                                    <label>Asset Requirements</label><br>
                                    <select id="asset_requisition" name="asset_requisition[]" autocomplete="off1" placeholder="Select Assets" multiple>
                                        <?php
                                        if (!empty($asset_list)) {
                                            foreach ($asset_list as $list) {
                                        ?>
                                                <option value="<?= $list['id'] ?>"><?= $list['name'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Work Type <span class="red_bg">*</span></label>
                                    <select class="select-box" id="work_type" name="work_type" required>
                                        <option value="">--Select--</option>
                                        <option value="1">WFO</option>
                                        <option value="2">WFH</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Employee Status</label>
                                    <select class="select-box" id="employee_status" name="employee_status">
                                        <option value="">--Select--</option>
                                        <option value="1">Part Time</option>
                                        <option value="2">Full Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Qualification <span class="red_bg">*</span></label>
                                    <select class="select-box" id="qualification_type" name="a" required>
                                        <option value="">--Select--</option>
                                        <option value="Xth">Xth</option>
                                        <option value="XII">XII</option>
                                        <option value="Graduation">Graduation</option>
                                        <option value="Masters">Masters</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" id="req_qualification_container">
                                <div class="form-group">
                                    <label>Required Qualification</label>
                                    <input type="text" id="req_qualification" name="req_qualification" class="form-control" value="" placeholder="Req. Qualification..." required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Required Experience (In Year) <span class="red_bg">*</span></label>
                                    <input type="number" maxlength="4" id="req_exp_range" name="req_exp_range" class="form-control" value="" placeholder="Enter Req. Exp. Range..." required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row assets_count" style="display:none;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="job_desc" name="job_desc" readonly />
                                    <label>Additional Information</label>
                                    <textarea class="form-control" id="additional_info" name="additional_info"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="site_cspl" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Site</label>
                                        <select name="site" class="form-control site">
                                            <option value="">--Select Site--</option>
                                            <?php foreach ($site_list as $site) : ?>
                                                <option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>

            </form>
            <div class="modal-footer modal_footer_right">
                <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                <button type="submit" id='addRequisition' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
            </div>

        </div>
    </div>
</div>


<!-------------------- Edit Requisition model ----------------------------->
<div class="modal fade dfr_widget" id="editRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form class="frmEditRequisition" action="<?php echo base_url(); ?>dfr/edit_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Update Requisition</h4>
                </div>
                <div class="modal-body filter-widget">

                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Location</label>
                                <select class="form-control edit_location" id="location" name="location" readonly style="pointer-events: none; cursor: default;">
                                    <option value="">--Select--</option>
                                    <?php foreach ($location_data as $row) { ?>
                                        <option value="<?php echo $row['abbr']; ?>"><?php echo $row['office_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" id="department_id" name="department_id" readonly style="pointer-events: none; cursor: default;">
                                    <option value="">--Select--</option>
                                    <?php foreach ($department_data as $department) { ?>
                                        <option value="<?php echo $department['id']; ?>"><?php echo $department['shname']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Requisition Type <span class="red_bg">*</span></label>
                                <select class="form-control" id="req_type" name="req_type" required>
                                    <option value="">--Select--</option>
                                    <option value="Growth">Growth</option>
                                    <option value="Attrition">Attrition</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">


                        <?php if (get_dept_folder() == 'wfm') { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Due Date <span class="red_bg">*</span></label>
                                    <input type="text" class="form-control" id="due_date1" name="due_date" required autocomplete="off">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Due Date</label>
                                    <input type="text" class="form-control" id="due_date_edit" name="due_date" value="" readonly>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-4" id='proposed_date_edit_col'>
                            <div class="form-group">
                                <label>Proposed New Date</label>
                                <input type="date" id="proposed_date_edit" name="proposed_date_edit" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Brand <span class="red_bg">*</span></label>
                                <select id="company_brand" name="company_brand" class="form-control" required>
                                    <option value="">-- Select Brand --</option>
                                    <?php foreach ($company_list as $key => $value) { ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">



                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="form-control" id="fedclient_id" name="client_id" readonly style="pointer-events: none; cursor: default;">
                                    <option value="">--Select--</option>
                                    <?php foreach ($client_list as $client) { ?>
                                        <option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Process</label>
                                <select class="form-control" id="fedprocess_id" name="process_id" readonly style="pointer-events: none; cursor: default;">
                                    <option value="">--Select--</option>
                                    <?php foreach ($process_list as $process) { ?>
                                        <option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Position <span class="red_bg">*</span></label>
                                <select class="form-control" id="role_id" name="role_id" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($role_data as $role) { ?>
                                        <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Required no of Position <span class="red_bg">*</span></label>
                                <input type="number" class="form-control" id="req_no_position" name="req_no_position" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Required Skill <span class="red_bg">*</span></label>
                                <input type="text" class="form-control" id="req_skill" name="req_skill" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Batch No</label>
                                <input type="text" class="form-control job_title" id="job_title" name="job_title" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Is Asset Required? <span class="red_bg">*</span></label>
                                <select class="form-control" id="is_asset" name="is_asset" required>
                                    <option value="">--Select--</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 asset_required" style="display:none;">
                            <div class="form-group btn-mul">
                                <label>Asset Requirements</label><br>
                                <select id="asset_requisition" name="asset_requisition[]" autocomplete="off1" placeholder="Select Assets" multiple>
                                    <?php
                                    if (!empty($asset_list)) {
                                        foreach ($asset_list as $list) {
                                    ?>
                                            <option value="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Work Type <span class="red_bg">*</span></label>
                                <select class="form-control" id="work_type" name="work_type" required>
                                    <option value="">--Select--</option>
                                    <option value="1">WFO</option>
                                    <option value="2">WFH</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row assets_count" style="display:none;"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Employee Status</label>
                                <select class="form-control" id="employee_status" name="employee_status">
                                    <option>--Select--</option>
                                    <option value="1">Part Time</option>
                                    <option value="2">Full Time</option>
                                </select>
                            </div>
                        </div>
                        <!--                        <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Required Qualification</label>
                                                        <input type="text" class="form-control" id="req_qualification" name="req_qualification" value="" required>
                                                    </div>	
                                                </div>-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Qualification <span class="red_bg">*</span></label>
                                <select class="form-control" id="req_qualification" name="req_qualification" required>
                                    <option value="">--Select--</option>
                                    <option value="Xth">Xth</option>
                                    <option value="XII">XII</option>
                                    <option value="Graduation">Graduation</option>
                                    <option value="Masters">Masters</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Required Experience Range <span class="red_bg">*</span></label>
                                <input type="text" class="form-control" id="req_exp_range" name="req_exp_range" value="" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" id="job_description_view_div">
                            <div class="form-group">
                                <a href="#" id="job_description_view_title" class="view_job" data-toggle="modal" data-target="#job_description_edit_view">View Job Description</a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Job Description</label>
                                <textarea class="form-control" id="job_desc" name="job_desc" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Additional Information</label>
                                <textarea class="form-control" id="additional_info" name="additional_info" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="site_cspl" style="display: none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Site</label>
                                    <select name="site" class="form-control site">
                                        <option value="">--Select Site--</option>
                                        <?php foreach ($site_list as $site) { ?>
                                            <option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                <button type="button" id='editRequisition' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
            </div>

        </div>
    </div>
</div>


<!-------------------- Cancel Requisition model ----------------------------->
<div class="modal fade modal-design" id="cancelRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmCancelRequisition" action="<?php echo base_url(); ?>dfr/cancelRequisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Cancel Requisition</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">
                    <input type="hidden" id="requisition_status" name="requisition_status" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Cancel Reason</label> <i class="fa fa-asterisk" style="font-size:6px; color:red"></i>
                                <textarea class="form-control" id="cancel_comment" name="cancel_comment" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                    <button type="submit" id='cancelRequisition' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-------------------- Assign TL Requisition model ----------------------------->
<div class="modal fade" id="handoverRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmhandoverRequisition" action="<?php echo base_url(); ?>dfr/assignTLRequisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Assign Trainer</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="dept_id" name="dept_id">
                    <input type="hidden" id="role_folder" name="role_folder">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Assign Trainer <span class="red_bg">*</span></label>
                                <select class="form-control" id="assign_trainer" name="assign_trainer" required>
                                    <option>Select</option>
                                    <?php foreach ($trainer_details as $row) : ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " - " . $row['fusion_id'] . " - " . $row['dept_name'] . " - " . $row['role_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="right_side">
                        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                        <button type="submit" id='closedRequisition' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
                    </div>
                </div>



            </form>

        </div>
    </div>
</div>


<div class="modal fade" id="assignTlRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmAssignTlRequisition" action="<?php echo base_url(); ?>dfr/assignTLRequisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Assign L1-Supervisor</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="dept_id" name="dept_id">
                    <input type="hidden" id="role_folder" name="role_folder">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>L1 Supervisor <span class="red_bg">*</span></label>
                                <select class="form-control" id="l1_supervisor" name="l1_supervisor" required>
                                    <option></option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="right_side">
                        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                        <button type="submit" id='assignTlRequisition' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-------------------- Re-Open Requisition model ----------------------------->
<div class="modal fade" id="reopenRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmReopenRequisition" action="<?php echo base_url(); ?>dfr/reopenRequisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Reopen Requisition</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reopen Reason <span class="red_bg">*</span></label>
                                <textarea class="form-control" id="reopen_comment" name="reopen_comment" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="right_side">
                        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                        <button type="submit" id='reopenRequisition' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-------------------- force closed Requisition Model ----------------------------->
<div class="modal fade" id="forceclosedRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmforceclosedRequisition" action="<?php echo base_url(); ?>dfr/handover_forced_closed_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Force Close Requisition</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="rid" name="rid">
                    <input type="hidden" id="dept_id" name="dept_id">
                    <input type="hidden" id="role_folder" name="role_folder">
                    <input type="hidden" id="raised_by" name="raised_by">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phase Type</label>
                                <select id="" name="phase_type" class="form-control">
                                    <option value="0">NA</option>
                                    <option value="2">Training</option>
                                    <option value="4">Production</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comment <span class="red_bg">*</span></label>
                                <textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="right_side">
                        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                        <button type="submit" id='closedRequisition' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- <script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script> -->
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
        $('#fdoffice_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            numberDisplayed: 2,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('.frmAddRequisition #asset_requisition').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            numberDisplayed: 2,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('.frmEditRequisition #asset_requisition').multiselect({
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
</script>
<script>
    $("#is_asset").change(function() {
        let asset = $("#is_asset").val();
        if (asset == '1') {
            $(".asset_required").css("display", "block");
            $("#asset_requisition").attr("required", true);
        } else {
            $("#asset_requisition").multiselect('clearSelection');
            $("#asset_requisition").multiselect('refresh');
            $("#asset_requisition").attr("required", false);
            $(".asset_required").css("display", "none");
            $(".assets_count").css('display', 'none');
            $(".assets_count").html('');
        }
    });
</script>
<script>
    $(".frmEditRequisition #is_asset").change(function() {
        let asset = $(".frmEditRequisition #is_asset").val();
        if (asset == '1') {
            $(".frmEditRequisition .asset_required").css("display", "block");
            $(".frmEditRequisition #asset_requisition").attr("required", true);
        } else {
            $(".frmEditRequisition #asset_requisition").multiselect('selectAll', true);
            $(".frmEditRequisition #asset_requisition").multiselect('clearSelection');
            $(".frmEditRequisition #asset_requisition").multiselect('refresh');
            $(".frmEditRequisition #asset_requisition").attr("required", false);
            $(".frmEditRequisition .asset_required").css("display", "none");
        }
    });
</script>
<script>
    $(".frmAddRequisition #asset_requisition").change(function() {
        var assets = $("#asset_requisition").val();
        if (assets != '') {
            let string = "";
            $.each(assets, function(i) {
                var option = $(".frmAddRequisition #asset_requisition option[value='" + assets[i] + "']").text();
                string += '<div class="col-md-3">\
                                <div class="form-group">\
                                    <label>' + option + ' Count</label>\
                                   <input type="number" id="ast_id_' + assets[i] + '" name="ast_id_' + assets[i] + '" class="form-control asset_id" value="" placeholder="Enter Req. ' + option + ' count..." min="1" required>\
                                </div>\
                            </div>';
            });
            $(".frmAddRequisition .assets_count").css('display', 'block');
            $(".frmAddRequisition .assets_count").html(string);
        } else {
            $(".frmAddRequisition .assets_count").css('display', 'none');
        }
    });
    /*$(".frmEditRequisition #asset_requisition").change(function() {

        var assets = $(".frmEditRequisition #asset_requisition").val();
        if (assets != '') {
            let string = "";
            $.each(assets, function(i) {
                var option = $(".frmEditRequisition #asset_requisition option[value='" + assets[i] + "']").text();
                string += '<div class="col-md-3">\
                                <div class="form-group">\
                                    <label>' + option + ' Count</label>\
                                   <input type="number" id="ast_id_' + assets[i] + '" name="ast_id_' + assets[i] + '" class="form-control asset_id" value="" placeholder="Enter Req. ' + option + ' count..." min="1" required>\
                                </div>\
                            </div>';
            });
            $(".frmEditRequisition .assets_count").css('display', 'block');
            $(".frmEditRequisition .assets_count").html(string);
        } else {
            $(".frmEditRequisition .assets_count").css('display', 'none');
        }
    });*/

    $(".frmEditRequisition #asset_requisition").change(function() {
        var assets = $(".frmEditRequisition #asset_requisition").val();
        //alert(assets);
        var r_id = $("#r_id").val();
        //alert(r_id);
        $.post("<?php echo base_url(); ?>Requisition/getRequisitionAssetsData", {
            sel: assets,
            r_id: r_id
        }).done(function(response) {
            //alert(response);
            if (response != '') {
                var dat_asset = JSON.parse(response);
                let string = "";
                $.each(dat_asset, function(r) {
                    var asset_req_count = dat_asset[r].assets_required != '' ? dat_asset[r].assets_required : '';
                    string += '<div class="col-md-4">\
                                <div class="form-group">\
                                    <label>' + dat_asset[r].name + ' Count</label>\
                                   <input type="number" id="ast_id_' + dat_asset[r].assets_id + '" name="ast_id_' + dat_asset[r].assets_id + '" class="form-control asset_id" value="' + asset_req_count + '" placeholder="Enter Req. ' + dat_asset[r].name + ' count..." required>\
                                </div>\
                            </div>';
                });
                $(".frmEditRequisition .assets_count").css('display', 'block');
                $(".frmEditRequisition .assets_count").html(string);
            } else {
                $(".frmEditRequisition .assets_count").css('display', 'none');
            }
        });


    });
</script>


<!--start job discription popup-->
<div class="modal fade dfr_widget" id="job_discription_edit" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Job Description</h4>
            </div>
            <div class="modal-body">
                <div class="job_widget">
                    <?php if (access_job_description() == true) { ?> <span class="noclick_view_job" id="jd_msg">Click Edit button to add/write the job description</span> <?php } else { ?> <span class="noclick_view_job" id="jd_msg"> In case the job description needs an update, then please contact your local HR/WFM manager</span><?php } ?>
                    <form class="frmjobdescription top_1" action="" data-toggle="validator" method='POST' enctype="multipart/form-data">
                        <input type="hidden" id="hidden_job_description_id" name="hidden_job_description_id">
                        <input type="hidden" id="hidden_location" name="hidden_location">
                        <input type="hidden" id="hidden_process_id" name="hidden_process_id">
                        <input type="hidden" id="hidden_client_id" name="hidden_client_id">
                        <input type="hidden" id="hidden_role_id" name="hidden_role_id">
                        <h3 id="job_description_modal_title"></h3>
                        <div id="jd_edit" style="display:none;">
                            <textarea name="job_description" id="job_description"></textarea>
                        </div>
                        <div id="jdview">
                        </div>
                    </form>
                </div>
            </div>
            <?php if (access_job_description() == true) { ?>

                <div class="modal-footer modal_footer_right">
                    <button type="button" id="edit-button" class="btn filter_btn save_common_btn btn_padding">Edit</button>
                    <button type="button" id="end-editing" class="btn filter_btn_blue save_common_btn btn_padding">Save</button>
                </div>

            <?php } else {  ?>

                <div class="modal-footer modal_footer_right">
                    <button type="button" id="end-viewing" class="btn filter_btn_blue save_common_btn btn_padding">Close</button>
                </div>

            <?php } ?>
        </div>
    </div>
</div>
<!--end job discription popup-->

<!--start job discription popup-->
<div class="modal fade dfr_widget" id="job_description_edit_view" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Job Description</h4>
            </div>
            <div class="modal-body">
                <div class="job_widget">
                    <?php if (access_job_description() == true) { ?> <span class="noclick_view_job" id="jd_view_msg">In case the job description needs an update, then please edit from master job description.</span> <?php } else { ?> <span class="noclick_view_job" id="jd_view_msg"> In case the job description needs an update, then please contact your local HR/WFM manager</span><?php } ?>
                    <h3 id="job_description_modal_view_title"></h3>
                    <div id="editreqjdview">
                    </div>
                </div>
            </div>


            <div class="modal-footer modal_footer_right">
                <button type="button" id="close_jd" class="btn filter_btn_blue save_common_btn btn_padding">Close</button>
            </div>


        </div>
    </div>
</div>
<!--end job discription popup-->

<!--<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>-->

<script>
    /*CKEDITOR.replace('editor1', {
        // Define the toolbar groups as it is a more accessible solution.
        toolbarGroups: [{
            "name": "basicstyles",
            "groups": ["basicstyles"]
        }],
        // Remove the redundant buttons from toolbar groups defined above.
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });*/



    $(document).on('keyup change', '#location, #role_id, #fdclient_id, #fdprocess_id', function() {
        var location = $('#location').val();
        var role_id = $('#role_id').val();
        var client_id = $('#fdclient_id').val();
        var process_id = $('#fdprocess_id').val();

        var location_txt = $("#location :selected").text();
        var role_txt = $("#role_id :selected").text();
        var client_txt = $("#fdclient_id :selected").text();
        var process_txt = $("#fdprocess_id :selected").text();

        if (location != '' && role_id != '' && client_id != '' && process_id != '') {
            $('#job_description_div').show();
            $('#job_description_modal_title').text(location_txt + ' - ' + client_txt + ' - ' + process_txt + ' - ' + role_txt);

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('dfr/get_job_description'); ?>",
                data: 'role_id=' + role_id + '&client_id=' + client_id + '&process_id=' + process_id + '&location=' + location,
                success: function(str) {
                    var jd_data = str.split("#@");
                    $('#hidden_job_description_id').val();
                    $('#hidden_location').val(location);
                    $('#hidden_process_id').val(process_id);
                    $('#hidden_client_id').val(client_id);
                    $('#hidden_role_id').val(role_id);

                    if (jd_data[0].trim() == '0') {
                        //alert('1');
                        <?php if (access_job_description() == true) { ?>
                            $('#job_description_title').text('Job description does not exist, click here to add');
                            $('#job_description_title').css('pointer-events', 'auto');
                            $('#job_description_title').removeClass("noclick_view_job");
                            $('#job_description_title').addClass("view_job");
                        <?php } else { ?>
                            $('#job_description_title').text('Job description does not exist, please contact your local HR/WFM manager');
                            $('#job_description_title').css('pointer-events', 'none');
                            $('#job_description_title').addClass("noclick_view_job");
                            $('#job_description_title').removeClass("view_job");
                        <?php } ?>

                        $('#jd_edit').show();
                        $('#jdview').hide();
                        $('#hidden_job_description_id').val('');
                        $('#jdview').html('');
                        $('#job_desc').val('');
                        $('#job_description').val('');
                        //CKEDITOR.instances['editor1'].setData('');
                        $('#edit-button').css("display", "none");
                        $('#jd_msg').css("display", "none");

                    } else {
                        //alert('2');
                        $('#job_description_title').text('View Job Description');
                        $('#job_description_title').css('pointer-events', 'auto');
                        $('#job_description_title').removeClass("noclick_view_job");
                        $('#job_description_title').addClass("view_job");
                        $('#jd_edit').hide();
                        $('#jdview').show();
                        $('#edit-button').show();
                        $('#jd_msg').show();
                        $('#hidden_job_description_id').val(jd_data[0].trim());

                        var textarea = jd_data[1].trim();
                        var find = ["\r\n", "\n", "\r"];
                        var replace = ["<br/>", "<br/>", "<br/>"];

                        textarea = textarea.replace(new RegExp("(" + find.map(function(i) {
                            return i.replace(/[.?*+^$[\]\\(){}|-]/g, "\\$&")
                        }).join("|") + ")", "g"), function(s) {
                            return replace[find.indexOf(s)]
                        });

                        $('#jdview').html(textarea);
                        $('#job_desc').val(jd_data[1].trim());
                        $('#job_description').val(jd_data[1].trim());
                        //CKEDITOR.instances['editor1'].setData(jd_data[1].trim());

                    }

                },
                error: function() {
                    alert('Something Went Wrong!');
                }
            });
        } else {
            $('#job_description_div').hide();
        }

    });

    $(document).on('click', '#edit-button', function() {
        $('#jd_edit').show();
        $('#jdview').hide();
    });

    $(document).on('click', '#end-viewing', function() {
        var job_description = $('#job_description').val();

        if (job_description != '') {
            $('#job_description_div').show();
            $('#job_description_title').text('View Job Description');
            $('#job_description_title').css('pointer-events', 'auto');
            $('#job_description_title').removeClass("noclick_view_job");
            $('#job_description_title').addClass("view_job");
            $('#jd_edit').hide();
            $('#jd_msg').show();
            $('#jdview').show();

            var textarea = job_description;
            var find = ["\r\n", "\n", "\r"];
            var replace = ["<br/>", "<br/>", "<br/>"];

            textarea = textarea.replace(new RegExp("(" + find.map(function(i) {
                return i.replace(/[.?*+^$[\]\\(){}|-]/g, "\\$&")
            }).join("|") + ")", "g"), function(s) {
                return replace[find.indexOf(s)]
            });

            $('#jdview').html(textarea);
            $('#job_desc').val(job_description);
            $('#job_description').val(job_description);
            $("#job_discription_edit").modal('hide');
        }

    });

    $(document).on('click', '#end-editing', function() {

        var job_description = $('#job_description').val(); //CKEDITOR.instances['editor1'].getData();
        //alert(job_description);

        if (job_description != '') {
            $('#job_description_div').show();
            $('#job_description_title').text('View Job Description');
            $('#job_description_title').css('pointer-events', 'auto');
            $('#job_description_title').removeClass("noclick_view_job");
            $('#job_description_title').addClass("view_job");
            var formData = $('.frmjobdescription').serialize();
            formData += '&job_description=' + encodeURIComponent(job_description);
            //alert(formData);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>dfr/updated_job_description',
                data: formData,
                success: function(str) {
                    //alert(str);                    
                    $('#end-editing').prop('disabled', false);
                    var jd_data = str.split("#@");
                    $('#hidden_job_description_id').val();
                    $('#jd_edit').hide();
                    $('#jdview').show();
                    $('#edit-button').show();
                    $('#jd_msg').show();
                    $('#hidden_job_description_id').val(jd_data[0].trim());

                    var textarea = jd_data[1].trim();
                    var find = ["\r\n", "\n", "\r"];
                    var replace = ["<br/>", "<br/>", "<br/>"];

                    textarea = textarea.replace(new RegExp("(" + find.map(function(i) {
                        return i.replace(/[.?*+^$[\]\\(){}|-]/g, "\\$&")
                    }).join("|") + ")", "g"), function(s) {
                        return replace[find.indexOf(s)]
                    });

                    $('#jdview').html(textarea);
                    $('#job_desc').val(jd_data[1].trim());
                    $('#job_description').val(jd_data[1].trim());
                    //CKEDITOR.instances['editor1'].setData(jd_data[1].trim());
                    $("#job_discription_edit").modal('hide');
                }
            });
            $('#end-editing').prop('disabled', true);
        } else {
            alert("Please add job description.");
        }

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
        }, ]
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