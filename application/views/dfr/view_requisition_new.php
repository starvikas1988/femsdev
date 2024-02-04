<script src="<?php echo base_url(); ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css-js/font-awesome.min.css" />

<link href="<?php echo base_url(); ?>assets/css-js/summernote.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/css-js/summernote.min.js"></script>

<?php $requesation_no = $this->uri->segment(3); ?>

<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->

<!-- include summernote css/js 
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>-->

<style>
    td {
        font-size: 11px;
    }

    #default-datatable th {
        font-size: 11px;
    }

    #default-datatable th {
        font-size: 11px;
    }

    .modal {
        background: rgba(0, 0, 0, 0.4);
    }

    .employee_assets_model_dfr .modal-dialog {
        width: 1000px;
        max-width: 100%;
    }

    .table>thead>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>th,
    .table>tbody>tr>td,
    .table>tfoot>tr>th,
    .table>tfoot>tr>td {
        padding: 3px;
    }

    .table {
        margin-bottom: 8px;
    }

    .skt-table td {
        padding: 2px;
    }

    .skt-table th {
        padding: 2px;
    }

    .body-widget {
        width: 100%;
        float: left;
    }

    /*start custom design css here*/
    .small-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        padding: 0;
        margin: 0 2px 0 2px;
        line-height: 19px;
    }

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

    .candt-btn {
        margin: 0 10px 0 0;
    }

    .filter-widget .multiselect-container {
        width: 100%;
    }

    .btn-mul .btn-group {
        width: 100%;
    }

    .no_assets {
        margin: 0px 0px 10px 134px;
    }

    .assets {
        width: 100%;
        margin: 0px 0px 10px 10px;
    }

    /*end custom design css here*/

    /*start custom 28.04.2022*/
    .filter-widget .btn-group,
    .btn-group-vertical {
        width: 100%;
    }

    .btn-group,
    .btn-group-vertical {
        width: auto;
    }

    .modal-dialog {
        width: 950px;
    }

    /*end custom 28.04.2022*/
</style>

<div class="wrap">
    <section class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <header class="widget-header">
                        <h4 class="widget-title">
                            View Requisition 
                            <!-- dynamic filled position count -->
                        </h4>
                    </header>
                    <div style="float:right; margin-top:-35px; margin-right:20px">
                        <?php $url = htmlspecialchars(@$_SERVER['HTTP_REFERER']); ?>
                        <a class="btn btn-warning" href="<?php echo $url; ?>" title="" style=''>Back</a>
                    </div>
                    <hr class="widget-separator">
                    <div class="widget-body">
                        <?php
                        $requisition_id = '';
                        $dfr_location = '';
                        foreach ($view_reuisition as $row) {
                            $r_id = $row['id'];
                            $requisition_id = $row['requisition_id'];
                            $r_status = $row['requisition_status'];
                            $deptid = $row['department_id'];
                            $role_folder = $row['role_folder'];
                            $company_brand = $row['company_brand'];
                            $offc_location = $row['off_location'];
                            $required_pos = $row['req_no_position'];
                            $work_type = $row['work_type'];
                            $is_asset = $row['is_asset'];

                            if ($row['department_id'] == 6 && $role_folder == 'agent') {
                                $required_pos = ceil($required_pos + (($required_pos * 15) / 100));
                                $deptType = 'Buffer';
                            } else {
                                $required_pos = $required_pos;
                                $deptType = '';
                            }

                            if ($row['employee_status'] == 1) {
                                $emp_status = 'Part Time';
                            } else {
                                $emp_status = 'Full Time';
                            }
                            $dfr_location = $row['location'];
                            $site_id = '';
                            if (!empty($row['site_id'])) {
                                $site_id = $row['site_id'];
                            }
                            $params = $row['location'] . '#' . $row['dueDate'] . '#' . $row['department_id'] . '#' . $row['role_id'] . '#' . $row['client_id'] . '#' . $row['process_id'] . '#' . $row['employee_status'] . '#' . $row['req_qualification'] . '#' . $row['req_exp_range'] . '#' . $row['req_no_position'] . '#' . $row['job_title'] . '#' . $row['job_desc'] . '#' . $row['req_skill'] . '#' . $row['additional_info'] . '#' . $row['req_type'] . '#' . $row['proposed_date'] . '#' . $row['company_brand'] . '#' . $row['raised_name'] . '#' . $row['raised_date'] . '#' . $row['requisition_status'] . '#' . $row['site_id'] . '##' . $work_type . '#' . $is_asset . '#' . $row['assets_id'];

                            $asset = '';
                            $asset_re = '';
                            if (!empty($asset_approved)) {
                                foreach ($asset_approved->result() as $asg) {
                                    $asset .= $asg->name . ', ';
                                    $asset_re .= $asg->name . '(' . $asg->assets_required . '), ';
                                }
                                $asset = trim($asset);
                                $asset_requ = trim($asset_re);
                            }
                            ?>
                            <div class="table-responive table-bg">
                                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                                    <tr>
                                        <td class='bg-info'>Location</td>
                                        <td id="office_location"><?php echo $row['off_location']; ?></td>
                                        <td class='bg-info'>Company Brand</td>
                                        <td colspan="<?php echo $row['site_name'] == '' ? 5 : ''; ?>"><?php echo $row['company_brand_name']; ?></td>
                                        <?php if (!empty($row['site_name'])) { ?>
                                            <td class='bg-info'>Site Name</td>
                                            <td colspan="3"><?php echo $row['site_name']; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td class='bg-info'>Requisition Code</td>
                                        <td id="req_cod"><?php echo $row['requisition_id']; ?></td>
                                        <td class='bg-info'>Due Date</td>
                                        <td><?php echo $row['due_date']; ?></td>
                                        <td class='bg-info'>Raised By</td>
                                        <td><?php echo $row['raised_name']; ?></td>
                                        <td class='bg-info'>Raised Date</td>
                                        <td><?php echo date($row['raised_date']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class='bg-info'>Department</td>
                                        <td><?php echo $row['department_name']; ?></td>
                                        <td class='bg-info'>Position</td>
                                        <td><?php echo $row['role_name']; ?></td>
                                        <td class='bg-info'>Client</td>
                                        <td><?php echo $row['client_name']; ?></td>
                                        <td class='bg-info'>Employee Status</td>
                                        <td><?php echo $emp_status; ?></td>
                                    </tr>
                                    <tr>
                                        <td class='bg-info'>Req. Qualification</td>
                                        <td><?php echo $row['req_qualification']; ?></td>
                                        <td class='bg-info'>Req Exp Range</td>
                                        <td><?php echo $row['req_exp_range']; ?></td>
                                        <td class='bg-info'>Req no of Position</td>
                                        <td><?php echo $row['req_no_position']; ?></td>
                                        <td class='bg-info'>Filled no of Position</td>
                                        <td><?php echo $filled_pos; ?></td>
                                    </tr>
                                    <tr>
                                        <td class='bg-info'>Batch No</td>
                                        <td colspan=''><?php echo $row['job_title']; ?></td>
                                        <td class='bg-info'>Type</td>
                                        <td colspan=''><?php echo $row['req_type']; ?></td>
                                        <td class='bg-info'>Status</td>
                                        <td colspan='3'><?php echo $row['requisition_status']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class='bg-info'>Job Description</td>
                                        <td colspan=''><?php echo $row['job_desc']; ?></td>
                                        <td class='bg-info'>Work Type</td>
                                        <td colspan=''><?php echo $work_type == '1' ? 'WFO' : 'WFH'; ?></td>
                                        <td class='bg-info'>Assign Asset</td>
                                        <td colspan='3'><?php echo substr($asset_requ, 0, strlen($asset_requ) - 1); ?></td>
                                    </tr>
                                    <tr>
                                        <td class='bg-info'>Req Skill</td>
                                        <td colspan='7'><?php echo $row['req_skill']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class='bg-info'>Additional Info</td>
                                        <td colspan='7'><?php echo $row['additional_info']; ?></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <?php
                            $comp = $row['company_brand_name'];
                            if (is_approve_requisition() == true || get_user_id() == 1) {
                                ?>
                                <div class="row">
                                    <?php if ($r_status == 'P') { ?>
                                        <div class="col-md-6">
                                            <button title='' type='button' class='btn btn-primary approval_wfm_flag_html' r_id='<?php echo $r_id; ?>' deptid='<?php echo $deptid; ?>' raisedby='<?php echo $row['raised_by']; ?>' style='font-size:10px' onclick="getModelData('dfr_new','approvalWfmModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'approvalWfm','approval_wfm_flag_html');"
                                                data-approval_wfm_flag_html='0' >Approve Requisition</button>
                                            <button title='' type='button' class='btn btn-danger decline_wfm_flag_html' r_id='<?php echo $r_id; ?>' style='font-size:10px' onclick="getModelData('dfr_new','declineWfmModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'declineWfm','decline_wfm_flag_html');"
                                                data-decline_wfm_flag_html='0'>Decline Requisition</button>
                                        </div>
                                        <?php
                                    }
                                    if (count($get_candidate_details) <= 0) {
                                        ?>
                                        <div class="col-md-6">
                                            <button title='' type='button' class='btn btn-success edit_requisition_flag_html' r_id='<?php echo $r_id; ?>' params="<?php echo $params; ?>" requisition_id='<?php echo $requisition_id; ?>' style='font-size:10px' onclick="getModelData('dfr_new','editRequisitionModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'editRequisition','edit_requisition_flag_html');"
                                                data-edit_requisition_flag_html='0'>Edit Requisition</button>
                                        </div>
                                    <?php } else {
                                        ?>
                                        <div class="col-md-6">
                                            <button title="Edit Assets Count" type="button" class="btn btn-success assat_count_flag_html" r_id='<?php echo $r_id; ?>' params="<?php echo $params; ?>" requisition_id='<?php echo $requisition_id; ?>' style='font-size:10px' onclick="getModelData('dfr_new','editRequisitionAssetsCountModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'editAssetsCount','assat_count_flag_html');"
                                                data-assat_count_flag_html='0'>Edit Assets Count</button>
                                        </div>
                                    <?php }
                                    ?>
  
                                        
                                </div>
                                <?php
                            } elseif ($comp == 'CSPL') {
                                if (get_user_fusion_id() == 'FCHA000263' || get_user_fusion_id() == 'FCHA002093') {
                                    ?>
                                    <div class="row">
                                        <?php if ($r_status == 'P') { ?>
                                            <div class="col-md-6">
                                                <button title='' type='button' class='btn btn-primary approval_wfm_flag_html' r_id='<?php echo $r_id; ?>' deptid='<?php echo $deptid; ?>' raisedby='<?php echo $row['raised_by']; ?>' style='font-size:10px' onclick="getModelData('dfr_new','approvalWfmModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'approvalWfm','approval_wfm_flag_html');"
                                                data-approval_wfm_flag_html='0' >Approve Requisition</button>
                                                <button title='' type='button' class='btn btn-danger decline_wfm_flag_html' r_id='<?php echo $r_id; ?>' style='font-size:10px' onclick="getModelData('dfr_new','declineWfmModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'declineWfm','decline_wfm_flag_html');"
                                                data-decline_wfm_flag_html='0'>Decline Requisition</button>

                                            </div>
                                            <?php
                                        }
                                        if (count($get_candidate_details) <= 0) {
                                            ?>
                                            <div class="col-md-6">
                                                <button title='' type='button' class='btn btn-success edit_requisition_flag_html' r_id='<?php echo $r_id; ?>' params="<?php echo $params; ?>" requisition_id='<?php echo $requisition_id; ?>' style='font-size:10px' onclick="getModelData('dfr_new','editRequisitionModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'editRequisition','edit_requisition_flag_html');"
                                                data-edit_requisition_flag_html='0'>Edit Requisition</button>
                                            </div>
                                        <?php } else {
                                            ?>
                                            <div class="col-md-6">
                                                <button title="Edit Assets Count" type="button" class="btn btn-success assat_count_flag_html" r_id='<?php echo $r_id; ?>' params="<?php echo $params; ?>" requisition_id='<?php echo $requisition_id; ?>' style='font-size:10px' onclick="getModelData('dfr_new','editRequisitionAssetsCountModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'editAssetsCount','assat_count_flag_html');"
                                                data-assat_count_flag_html='0'>Edit Assets Count</button>
                                            </div>
                                        <?php }
                                        ?>
                                        
                                    </div>
                                    <?php
                                }
                            }
                            $r_status = $row['requisition_status'];
                            ?>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="common-top">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget">
                        <header class="widget-header">
                            <h4 class="widget-title">Candidate List</h4>
                        </header>
                        <hr class="widget-separator">
                        <div class="row" style="float:right; margin-top:-34px; margin-right:20px">
                            <div>
                                <?php
                                if ($r_status == 'A') {
                                    if (is_access_dfr_module() == 1 || get_dept_folder() == 'hr' || $is_global_access == 1) {
                                        if ($required_pos > $filled_pos) {
                                            if (is_block_add_candidate_requisition($requisition_id) == false) {
                                ?>
                                                <button title='' type='button' class='btn btn-primary candt-btn send_link_flag_html' offc_location='<?php echo $offc_location; ?>' r_id='<?php echo $r_id; ?>' requisition_id='<?php echo $requisition_id; ?>' company_brand='<?php echo  $company_brand;?>'  style='' onclick="getModelData('dfr_new','SendBasicLinkModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>/<?php echo $offc_location; ?>', $(this),'sendBasicLink','send_link_flag_html');"
                                                data-send_link_flag_html='0' >Send Link to Candidate </button>

                                                <button title='' type='button' class='btn btn-primary add_can_flag_html' r_id='<?php echo $r_id; ?>' requisition_id='<?php echo $requisition_id;?>' company_brand='<?php echo $company_brand;?>' style='' 
                                                onclick="getModelData('dfr_new','addCandidateModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'addCandidate','add_can_flag_html');"
                                                data-add_can_flag_html='0'>Add Candidate</button>
                                 <?php      } else { ?>
                                               <button type='button' class='btn btn-default send_link_flag_html' title='Disabled as per WFM request. For enable please contact WFM' style='font-size:10px' onclick="getModelData('dfr_new','SendBasicLinkModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>/<?php echo $offc_location; ?>', $(this),'sendBasicLink','send_link_flag_html');"
                                                data-send_link_flag_html='0'>Send Link to Candidate</button>

                                                <button type='button' class='btn btn-default add_can_flag_html' title='Disabled as per WFM request. For enable please contact WFM' style='font-size:10px' onclick="getModelData('dfr_new','addCandidateModel/<?php echo $requesation_no; ?>/<?php echo $dfr_location; ?>', $(this),'','add_can_flag_html');" data-add_can_flag_html='0'>Add Candidate</button>
                                <?php       }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="table-responsive table-bg table-small">
                                <table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class='bg-info'>
                                            <th></th>
                                            <th>SL</th>
                                            <!-- <th>Requision Code</th> -->
                                            <th>Candidate Name</th>
                                            <th>Last Qualification</th>
                                            <th>Gender</th>
                                            <th>Mobile</th>
                                            <th>Skill Set</th>
                                            <th>Total Exp.</th>
                                            <th>Attachment</th>
                                            <!--<th>Rehire</th>-->
                                            <!--<th>Comments</th>-->
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
                                        foreach ($get_candidate_details as $cd) {
                                            $r_id = $cd['r_id'];
                                            $c_id = $cd['can_id'];
                                            $c_status = $cd['candidate_status'];
                                            $gross_pay = $cd['gross_pay'];
                                            $bgv_verify_by_name = $cd['bgv_verify_by_name'];
                                            $bgv_date = $cd['bgv_date'] != '' && $cd['bgv_date'] != '0000-00-00' ? date_format(date_create($cd['bgv_date']), 'd-m-Y') : '';

                                            if ($c_status == 'P') {
                                                $cstatus = 'Pending';
                                            } elseif ($c_status == 'IP') {
                                                $cstatus = 'In Progress';
                                            } elseif ($c_status == 'SL') {
                                                $cstatus = 'Shortlisted';
                                            } elseif ($c_status == 'CS') {
                                                $cstatus = 'Selected';
                                                if ($filled_pos >= $required_pos) {
                                                    $cstatus = 'Selected - position filled';
                                                }
                                            } elseif ($c_status == 'E') {
                                                $cstatus = 'Selected as Employee';
                                            } elseif ($c_status == 'R') {
                                                $cstatus = 'Rejected';
                                            } elseif ($c_status == 'D') {
                                                $cstatus = 'Dropped';
                                            }

                                            if ($cd['attachment'] != '') {
                                                $viewResume = 'View Resume';
                                            } else {
                                                $viewResume = '';
                                            }

                                            if ($c_status == 'CS') {
                                                $bold = "style='font-weight:bold; color:#041ad3'";
                                            } elseif ($c_status == 'E') {
                                                $bold = "style='font-weight:bold; color:#013220'";
                                            } elseif ($c_status == 'R') {
                                                $bold = "style='font-weight:bold; color:red'";
                                            } else {
                                                $bold = '';
                                            }

                                            if ($r_status == 'CL') {
                                                $bold = "style='font-weight:bold; color:red'";
                                            } else {
                                                $bold = '';
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    //if($cid!=""){
                                                    $interview_evalution_form = $cd['interview_evalution_form'];
                                                    ?>
                                                    <button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#<?php echo $c_id; ?>" title="" onclick="get_user_data('<?php echo $c_id; ?>', '<?php echo $dfr_location; ?>', '<?php echo $r_status; ?>', '<?php echo $c_status; ?>', '<?php echo $required_pos; ?>', '<?php echo $filled_pos; ?>', '<?php echo $r_id; ?>', '<?php echo $interview_evalution_form; ?>')"><i class="fa fa-plus"></i></button>
                                                    <?php //}
                                                    ?>
                                                </td>
                                                <td><?php echo $k++; ?></td>
                                                <!-- <td <?php //echo $bold;    ?>><?php echo $cd['requisition_id']; ?></td> -->
                                                <td <?php echo $bold; ?>><?php echo $cd['fname'] . ' ' . $cd['lname']; ?></td>
                                                <td><?php echo $cd['last_qualification']; ?></td>
                                                <td><?php echo $cd['gender']; ?></td>
                                                <td><?php echo $cd['phone']; ?></td>
                                                <td><?php echo $cd['skill_set']; ?></td>
                                                <td><?php echo $cd['total_work_exp']; ?></td>
                                                <td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>"><?php echo $viewResume; ?></a></td>
                                                <!--<td><?php //echo $cd['rehire'] == 'Y' ? 'Yes' : '';
                                                    ?></td>-->
                                                <!--<td><?php //echo $cd['rehire'] == 'Y' ? $cd['comments'] : '';
                                                    ?></td>-->
                                                <td width="100px" <?php echo $bold; ?>><?php echo $cstatus; ?></td>
                                                <?php if (is_access_dfr_module() == 1) {  ////ACCESS PART
                                                    ?>
                                                    <td width="310px">
                                                        <?php
                                                        //$sch_id=$cd['sch_id'];
                                                        //$interview_type=$cd['interview_type'];
                                                        //$requisition_id=$cd['requisition_id'];
                                                        //$filled_no_position=$cd['filled_no_position'];

                                                        $interview_site = $cd['location']; //echo $interview_site;
                                                        $req_no_position = $cd['req_no_position'];
                                                        $department_id = $cd['department_id'];
                                                        $role_id = $cd['role_id'];
                                                        //$sh_status=$cd['sh_status'];

                                                        if (isIndiaLocation($cd['location']) == true) {
                                                            $dob = date('d/m/Y', strtotime($cd['dob']));
                                                            $doj = date('d/m/Y', strtotime($cd['doj']));
                                                            $married_date = date('d/m/Y', strtotime($cd['married_date']));
                                                        } else {
                                                            $dob = date('m/d/Y', strtotime($cd['dob']));
                                                            $doj = date('m/d/Y', strtotime($cd['doj']));
                                                            $married_date = date('m/d/Y', strtotime($cd['married_date']));
                                                        }

                                                        if (strtoupper($cd['married']) == 'YES') {
                                                            $married = 'Married';
                                                        } else {
                                                            $married = 'UnMarried';
                                                        }


                                                        $site_id = '';
                                                        if (!empty($cd['site_id'])) {
                                                            $site_id = $cd['site_id'];
                                                        }
                                                        $params = $cd['requisition_id'] . '#' . $cd['fname'] . '#' . $cd['lname'] . '#' . $cd['hiring_source'] . '#' . $dob . '#' . $cd['email'] . '#' . $cd['phone'] . '#' . $cd['last_qualification'] . '#' . $cd['skill_set'] . '#' . $cd['total_work_exp'] . '#' . $cd['country'] . '#' . $cd['state'] . '#' . $cd['city'] . '#' . $cd['postcode'] . '#' . $cd['address'] . '#' . $cd['summary'] . '#' . $cd['attachment'] . '#' . $cd['gender'] . '#' . $cd['ref_name'] . '#' . $cd['guardian_name'] . '#' . $cd['onboarding_type'] . '#' . $cd['company'] . '#' . $cd['relation_guardian'] . '#' . $cd['location'] . '#' . $cd['mother_name'] . $site_id;

                                                        // $cparams=$cd['fname']."(#)".$cd['lname']."(#)".$cd['hiring_source']."(#)".$dob."(#)".$cd['email']."(#)".$cd['phone']."(#)".$cd['department_id']."(#)".$cd['role_id']."(#)".$doj."(#)".$cd['gender']."(#)".$cd['location']."(#)".$cd['job_title']."(#)".$cd['address']."(#)".$cd['country']."(#)".$cd['state']."(#)".$cd['city']."(#)".$cd['postcode']."(#)".$cd['client_id']."(#)".$cd['process_id']."(#)".$cd['org_role']."(#)".$cd['gross_pay']."(#)".$cd['pay_type']."(#)".$cd['currency']."(#)".$cd['l1_supervisor']."(#)".$cd['adhar']."(#)".$cd['pan']."(#)".$cd['guardian_name']."(#)".$cd['relation_guardian']."(#)".$cd['caste']."(#)".$married."(#)".$married_date;
                                                        $cparams = $cd['fname'] . '(#)' . $cd['lname'] . '(#)' . $cd['hiring_source'] . '(#)' . $dob . '(#)' . $cd['email'] . '(#)' . $cd['phone'] . '(#)' . $cd['department_id'] . '(#)' . $cd['role_id'] . '(#)' . $doj . '(#)' . $cd['gender'] . '(#)' . $cd['location'] . '(#)' . $cd['job_title'] . '(#)' . str_replace('"', '', str_replace('\\', '', $cd['address'])) . '(#)' . $cd['country'] . '(#)' . $cd['state'] . '(#)' . $cd['city'] . '(#)' . $cd['postcode'] . '(#)' . $cd['client_id'] . '(#)' . $cd['process_id'] . '(#)' . $cd['org_role'] . '(#)' . $cd['gross_pay'] . '(#)' . $cd['pay_type'] . '(#)' . $cd['currency'] . '(#)' . $cd['l1_supervisor'] . '(#)' . $cd['adhar'] . '(#)' . $cd['pan'] . '(#)' . $cd['guardian_name'] . '(#)' . $cd['relation_guardian'] . '(#)' . $cd['caste'] . '(#)' . $married . '(#)' . $married_date . '(#)' . $cd['attachment_bank'] . '(#)' . $cd['bank_name'] . '(#)' . $cd['branch_name'] . '(#)' . $cd['bank_acc_no'] . '(#)' . $cd['ifsc_code'] . '(#)' . $cd['acc_type'];
                                                        // print_r($cd);
                                                        // exit;
                                                        //adhar, pan, guardian_name, relation_guardian , married, married_date

                                                        $doc_verify_name = $cd['doc_verify_name'];
                                                        $doc_verify_on = $cd['doc_verify_on'];
                                                        $is_verify_doc = $cd['is_verify_doc'];

                                                        ///////////
                                                        if ($c_id != '') {
                                                            echo '<a class="btn btn-success btn-xs small-icon viewCandidate" href="' . base_url() . 'dfr/view_candidate_details/' . $c_id . '" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Details" style="font-size:12px"><i class="fa fa-eye"></i></a>';

                                                            echo '';

                                                            if (is_block_add_candidate_requisition($requisition_id) == false) {
                                                                if ($c_status != 'E' && $r_status == 'A') {
                                                                    echo "<a class='btn btn-info small-icon btn-xs ' href='" . base_url() . 'dfr/resend_basic_link?r_id=' . $r_id . '&c_id=' . $c_id . "' title='Click to resend apply link'><i class='fa fa-envelope' aria-hidden='true'></i></a>";
                                                                    echo '';
                                                                }
                                                            }
                                                            if (($c_status == 'CS' || $c_status == 'SL') && ($filled_pos < $required_pos)) {
                                                                echo '<a class="btn btn-danger btn-xs small-icon selected_can_tran_flag_html" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Transfer Candidate" style="font-size:12px" onclick=getModelData("dfr_new","transferSelectedCandidateModel/'.$r_id.'/'.$dfr_location.'",$(this),"selectedCandidateTransfer","selected_can_tran_flag_html"); data-selected_can_tran_flag_html="0"><i class="fa fa-exchange"></i></a>';
                                                                //                                                                 echo '<a class="btn btn-warning small-icon btn-xs editCandidate" c_id="' . $c_id . '" r_id="' . $r_id . '" params="' . $params . '" title="Click to Edit Candidate" style="font-size:12px"><i class="fa fa-pencil-square-o"></i></a>';
                                                            }
                                                            if ($r_status == 'A' && $c_status != 'E') {
                                                                ////Approve Requisition & not Fusion Employee
                                                                //if ($c_status != 'R' && $c_status != 'CS') {
                                                                //if(is_access_dfr_module()==1){
                                                                // if ($required_pos > $filled_pos) {
                                                                // if ($c_status != 'E') {
                                                                echo '<a class="btn btn-warning small-icon btn-xs edit_can_flag_html" onclick=getModelData("dfr_new","editCandidateModel/'.$r_id.'/'.$dfr_location.'",$(this),"editCandidateDetails","edit_can_flag_html"); c_id="' . $c_id . '" r_id="' . $r_id . '" params="' . $params . '" title="Click to Edit Candidate" style="font-size:12px" data-edit_can_flag_html="0"><i class="fa fa-pencil-square-o"></i></a>';
                                                                echo '';
                                                                

                                                                echo '<a class="btn btn-primary small-icon btn-xs add_exp_flag_html" title="Add Candidate Experience"  r_id="' . $r_id . '"  c_id="' . $c_id . '"  style="font-size:12px" onclick=getModelData("dfr_new","addCandidateExpModel/'.$r_id.'/'.$dfr_location.'",$(this),"addExperience","add_exp_flag_html"); data-add_exp_flag_html="0"><i class="fa fa-industry"></i></a>';
                                                                echo '';
                                                                echo '<a class="btn btn-primary small-icon btn-xs add_quli_flag_html" title="Add Candidate Qualification"  r_id="' . $r_id . '"  c_id="' . $c_id . '" style="font-size:12px" onclick=getModelData("dfr_new","addCandidateQualModel/'.$r_id.'/'.$dfr_location.'",$(this),"addQualification","add_quli_flag_html"); data-add_quli_flag_html="0"><i class="fa fa-graduation-cap"></i></a>';
                                                                echo '';

                                                                if ($c_status == 'P' || $c_status == 'IP') {
                                                                    if ($required_pos > $filled_pos) {
                                                                        //if(is_access_dfr_module()==1){

                                                                        echo '<a class="btn btn-success small-icon btn-xs schedule_can_flag_html" title="Schedule Interview"  r_id="' . $r_id . '"  c_id="' . $c_id . '" hiring_department="' . $department_id . '" interview_site="' . $interview_site . '"  style="font-size:12px" onclick=getModelData("dfr_new","addScheduleCandidate/'.$r_id.'/'.$dfr_location.'",$(this),"scheduleCandidate","schedule_can_flag_html"); data-schedule_can_flag_html="0"><i class="fa fa-calendar-check-o"></i></a>';
                                                                        echo '';


                                                                        if ($c_status != 'P') {
                                                                            if (candidate_total_schedule($c_id) > 0 && candidate_has_pending_sch($c_id) == '0') {
                                                                                echo '<a class="btn btn-xs small-icon candidate_select_interview_flag_html" style="background-color:#EB952D" title="Candidate Final Status"  r_id="' . $r_id . '"  c_id="' . $c_id . '" style="font-size:12px" onclick=getModelData("dfr_new","candidateSelectInterview/'.$r_id.'/'.$dfr_location.'",$(this),"candidateSelectInterview","candidate_select_interview_flag_html"); data-candidate_select_interview_flag_html="0"><i class="fa fa-user-secret"></i></a>';
                                                                            } else {
                                                                                if (candidate_has_pending_sch($c_id) == '0') {
                                                                                    echo '<a class="btn btn-danger small-icon btn-xs candidate_not_select_interview_flag_html" r_id="' . $r_id . '"  c_id="' . $c_id . '" title="Reject Candidate" style="font-size:12px" onclick=getModelData("dfr_new","candidateNotSelectInterviewModel/'.$r_id.'/'.$dfr_location.'",$(this),"candidateNotSelectInterview","candidate_not_select_interview_flag_html"); data-candidate_not_select_interview_flag_html="0"><i class="fa fa-close"></i></a>';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                } elseif ($c_status == 'SL') {
                                                                    //if(is_access_dfr_module()==1){  /* $is_role_dir=="manager" */

                                                                    if ($required_pos > $filled_pos) {
                                                                        // CHECK OFFICE ACCESS
                                                                        $pay_lock = 1;
                                                                        if (isDisablePayrollInfo($cd['location']) == false) {
                                                                            $pay_lock = 0;
                                                                        }

                                                                        echo '<a class="btn btn-success btn-xs small-icon candidate_approval_flag_html" p_access="' . $pay_lock . '" r_id="' . $r_id . '" c_id="' . $c_id . '" req_id="' . $requisition_id . '"  c_status="' . $c_status . '" org_role="' . $cd['org_role'] . '" role_id="' . $cd['role_id'] . '"dept_id="' . $department_id . '"gender="' . $cd['gender'] . '" location_id="' . $cd['location'] . '" brand_id="' . $cd['company'] . '" title="Approval to Final Selection" style="font-size:12px" onclick=getModelData("dfr_new","approvalFinalSelectModel/'.$r_id.'/'.$dfr_location.'",$(this),"candidateApproval","candidate_approval_flag_html"); data-candidate_approval_flag_html="0"><i class="fa fa-check-square"></i></a>';
                                                                        echo '';
                                                                        echo '<a class="btn btn-danger small-icon btn-xs candidate_approval_decline_flag_html" r_id="' . $r_id . '"  c_id="' . $c_id . '" c_status="' . $c_status . '" title="Decline Approval" style="font-size:12px" onclick=getModelData("dfr_new","declineFinalSelectModel/'.$r_id.'/'.$dfr_location.'",$(this),"candidateDecline","candidate_approval_decline_flag_html"); data-candidate_approval_decline_flag_html="0"><i class="fa fa-close"></i></a>'; 
                                                                    }

                                                                    //}

                                                                    echo '';
                                                                    if ($cd['location'] == 'CHA') {
                                                                        if ($cd['joining_kit'] == '') {
                                                                            echo '<a class="btn btn-success small-icon btn-xs " href="' . base_url() . 'dfr/download_joining_kit?c_id=' . $c_id . '&r_id=' . $r_id . '" title="Click to Download Joining Kit" style="font-size:12px;background-color:yellow;"><i class="fa fa-download"></i></a>';

                                                                            echo '';
                                                                            // href="'.base_url().'dfr/upload_joining_kit?c_id='.$c_id.'&r_id='.$r_id.'"
                                                                            echo '<a class="btn btn-success small-icon btn-xs upload_joining_flag_html"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to Upload Joining Kit" style="font-size:12px;background-color:orange;" onclick=getModelData("dfr_new","upload_joining_kit_form/'.$r_id.'/'.$dfr_location.'",$(this),"upload_joining","upload_joining_flag_html"); data-upload_joining_flag_html="0"><i class="fa fa-upload"></i></a>';

                                                                            echo '';
                                                                        } else {
                                                                            echo '<a class="btn btn-success small-icon btn-xs " href="' . base_url() . 'uploads/joining_kit/' . $cd['joining_kit'] . '" title="Click to Download Joining Kit" style="font-size:12px;" target="_blank"><i class="fa fa-download"></i></a>';
                                                                        }
                                                                    }
                                                                } elseif ($c_status == 'CS') {
                                                                    if (get_dept_folder() == 'hr' || get_global_access() == 1) {
                                                                        echo '<a class="btn btn-success btn-xs small-icon viewOfferLetter" href="' . base_url() . 'dfr/candidate_offer_pdf/' . $c_id . '/Y" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Offer Letter " style="font-size:12px";background-color:#800080;"><i class="fa fa-file-pdf-o"></i></a>';

                                                                        echo '';

                                                                        echo '<a class="btn btn-success small-icon btn-xs " href="' . base_url() . 'dfr/resend_offer_letter?c_id=' . $c_id . '&r_id=' . $r_id . '" title="Click to Resend Offer Letter " style="font-size:12px"><i class="fa fa-envelope"></i></a>';

                                                                        echo '';
                                                                        echo '<a class="btn btn-primary small-icon btn-xs " href="' . base_url() . 'dfr/resend_doc_link?c_id=' . $c_id . '&requisition_id=' . $requisition_id . '&r_id=' . $r_id . '" title="Click to Resend Document Upload Link" style="font-size:12px"><i class="fa fa-envelope"></i></a>';

                                                                        echo '';
                                                                        if ($cd['location'] == 'CHA') {
                                                                            if ($cd['loi'] == '') {
                                                                                echo '<a class="btn small-icon btn-primary btn-xs " href="' . base_url() . 'dfr/download_loi?c_id=' . $c_id . '&requisition_id=' . $requisition_id . '&r_id=' . $r_id . '" title="Click to Download LOI" style="font-size:12px;background-color:#FFFF00;"><i class="fa fa-download"></i></a>';

                                                                                echo '';
                                                                                echo '<a class="btn btn-primary btn-xs loi_form_flag_html" r_id="' . $r_id . '"  c_id="' . $c_id . '" title="Click to  Upload LOI" style="font-size:12px;background-color:#eea236;" onclick=getModelData("dfr_new","loi_form/'.$r_id.'/'.$dfr_location.'",$(this),"upload_loi","loi_form_flag_html"); data-loi_form_flag_html="0"><i class="fa fa-upload"></i></a>'; 

                                                                                echo '';
                                                                            } else {
                                                                                echo '<a class="btn btn-primary small-icon btn-xs " href="' . base_url() . 'uploads/loifrom/' . $cd['loi'] . '" title="Click to Download LOI" target="_blank" style="font-size:12px"><i class="fa fa-download"></i></a>';
                                                                            }
                                                                        }
                                                                    }

                                                                    if ($cd['attachment_adhar'] != '') {
                                                                        if ($is_verify_doc == 0) {
                                                                            echo '<a class="btn btn-success small-icon btn-xs VerifyDocuments" href="' . base_url() . 'dfr/view_uploaded_docs?c_id=' . $c_id . '&requisition_id=' . $requisition_id . '" target="_blank"  is_verify="' . $is_verify_doc . '" c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Documents & Verify" style="font-size:12px"><i class="fa fa-info"></i></a>';
                                                                            echo '';
                                                                        } else {
                                                                            echo '<a class="btn btn-default small-icon btn-xs VerifyDocuments" href="' . base_url() . 'dfr/view_uploaded_docs?c_id=' . $c_id . '&requisition_id=' . $requisition_id . '" target="_blank"  is_verify="' . $is_verify_doc . '" c_id="' . $c_id . '" r_id="' . $r_id . '" title="Already Documents Verified by ' . $doc_verify_name . ' on ' . $doc_verify_on . '" style="font-size:12px"><i class="fa fa-info"></i></a>';

                                                                            echo '';
                                                                        }
                                                                    }

                                                                    if ($required_pos > $filled_pos) {
                                                                        $pay_lock = 1;
                                                                        if (isDisablePayrollInfo($cd['location']) == false) {
                                                                            $pay_lock = 0;
                                                                        }

                                                                        if (!empty($cd['l1_supervisor'])) {
                                                                            //echo '<a class="btn btn-primary btn-xs finalSelection" p_access="'.$pay_lock.'" r_id="'.$r_id.'" c_id="'.$c_id.'" cparams="'.$cparams.'" title="" style="font-size:12px" >Add as Employee</a>';
                                                                            //echo "&nbsp &nbsp";

                                                                            if (isIndiaLocation($dfr_location) == true) {
                                                                                if ($cd['attachment_adhar'] != '' && $cd['is_verify_doc'] == 1) {
                                                                                    echo '<a class="btn btn-primary btn-xs final_selection_flag_html" p_access="' . $pay_lock . '" r_id="' . $r_id . '" c_id="' . $c_id . '" cparams="' . $cparams . '" title="" style="font-size:12px" onclick=getModelData("dfr_new","finalSelectionModel/'.$r_id.'/'.$dfr_location.'",$(this),"finalSelection","final_selection_flag_html"); data-final_selection_flag_html="0">Add as Employee</a>';

                                                                                    echo '';
                                                                                } else {
                                                                                    echo '<a class="btn btn-default btn-xs final_selection_flag_html" p_access="' . $pay_lock . '" r_id="' . $r_id . '" c_id="' . $c_id . '" cparams="' . $cparams . '" title="Document Not Upload OR Verified"  style="font-size:12px" onclick=getModelData("dfr_new","finalSelectionModel/'.$r_id.'/'.$dfr_location.'",$(this),"finalSelection","final_selection_flag_html"); data-final_selection_flag_html="0">Add as Employee</a>';

                                                                                    echo '';
                                                                                }
                                                                            } else {
                                                                                echo '<a class="btn btn-primary small-icon btn-xs final_selection_flag_html" p_access="' . $pay_lock . '" r_id="' . $r_id . '" c_id="' . $c_id . '" cparams="' . $cparams . '" title="" style="font-size:12px" onclick=getModelData("dfr_new","finalSelectionModel/'.$r_id.'/'.$dfr_location.'",$(this),"finalSelection","final_selection_flag_html"); data-final_selection_flag_html="0">Add as Employee</a>';
                                                                                echo '';
                                                                            }
                                                                        } else {
                                                                            echo '<a class="btn btn-xs" onclick="alert(\'L1 Supervisor Not Assigned!\')" style="background-color:#ccc;color:#fff" title="Disabled" style="font-size:12px" >Add as Employee</a>';
                                                                            echo '';
                                                                        }
                                                                        echo '&nbsp;';
                                                                        echo '&nbsp;<a class="btn btn-success btn-xs viewbgv" bgv="' . $cd['is_bgv_verify'] . '" bgv_by="' . $bgv_verify_by_name . '" bgv_date="' . $bgv_date . '" c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to Update BGV " style="background: #fd8000;color: white;display: inline-block;text-align: center;">B</a>';
                                                                        //echo '<a class="btn btn-danger btn-xs candidateDecline" r_id="'.$r_id.'" c_id="'.$c_id.'" c_status="'.$c_status.'" title="Decline Adding Employee" style="font-size:12px" ><i class="fa fa-user-times"></i></a>';
                                                                    }
                                                                } else {
                                                                    echo '<span class="label label-danger" style="font-size:12px"><b>Rejected</b></span>';
                                                                    echo '&nbsp &nbsp';

                                                                    //echo '<a class="btn btn-warning btn-xs rescheduleCandidate" r_id="'.$r_id.'"  c_id="'.$c_id.'" c_status="'.$c_status.'" title="Re-Schedule Candidate" style="font-size:12px"><i class="fa fa-street-view"></i></a>';
                                                                }

                                                                echo '';

                                                                if ($c_status != 'P') {
                                                                    echo '<a class="btn small-icon btn-xs candidateInterviewReport" href="' . base_url() . 'dfr/view_candidate_interview/' . $c_id . '"  target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Interview Report" style="font-size:12px; background-color:#EE8CE4;"><i class="fa fa-desktop"></i></a>';
                                                                }

                                                                /////////Approve Requisition & Fusion Employee/////
                                                            } else {
                                                                if ($c_status == 'E') {
                                                                    echo "<span class='label label-info' style='font-size:12px; display:inline-block;'>Empolyee</span>";

                                                                    echo '<a class="btn btn-success small-icon btn-xs employee_assets_dfr_flag_html" c_id="' . $c_id . '" title="Empolyee Assets" style="font-size:12px" onclick=getModelData("dfr_new","employee_assets_model_dfr/'.$r_id.'/'.$dfr_location.'",$(this),"employee_assets_dfr","employee_assets_dfr_flag_html"); data-employee_assets_dfr_flag_html="0"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';

                                                                    if (get_dept_folder() == 'hr' || get_global_access() == 1) {
                                                                        if ($gross_pay > 0) {
                                                                            echo '<a class="btn btn-success btn-xs small-icon viewOfferLetter" href="' . base_url() . 'dfr/candidate_offer_pdf/' . $c_id . '/Y" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Offer Letter " style="font-size:12px";background-color:#800080;"><i class="fa fa-file-pdf-o"></i></a>';

                                                                            echo '';

                                                                            echo '<a class="btn btn-primary small-icon btn-xs " href="' . base_url() . 'dfr/resend_offer_letter?c_id=' . $c_id . '&r_id=' . $r_id . '" title="Click to Resend Offer Letter" style="font-size:12px"><i class="fa fa-envelope"></i></a>';

                                                                            echo '';
                                                                        }

                                                                        echo '<a class="btn btn-default small-icon btn-xs VerifyDocuments" href="' . base_url() . 'dfr/view_uploaded_docs?c_id=' . $c_id . '&requisition_id=' . $requisition_id . '" target="_blank"  is_verify="' . $is_verify_doc . '" c_id="' . $c_id . '" r_id="' . $r_id . '" title="Already Documents Verified by ' . $doc_verify_name . ' on ' . $doc_verify_on . '" style="font-size:12px"><i class="fa fa-info"></i></a>';

                                                                        echo '';

                                                                        //echo '<a class="btn btn-success btn-xs " href="'.base_url().'dfr/resend_doc_link?c_id='.$c_id.'&requisition_id='.$requisition_id.'&r_id='.$r_id.'" title="Click to Resend Document Upload Link" style="font-size:12px"><i class="fa fa-envelope"></i></a>';
                                                                    }
                                                                }
                                                            }

                                                            if (($filled_pos >= $required_pos) && $c_status != 'E') {
                                                                echo '';

                                                                echo '<a class="btn btn-danger btn-xs small-icon selected_can_tran_flag_html" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Transfer Candidate" style="font-size:12px" onclick=getModelData("dfr_new","transferSelectedCandidateModel/'.$r_id.'/'.$dfr_location.'",$(this),"selectedCandidateTransfer","selected_can_tran_flag_html"); data-selected_can_tran_flag_html="0"><i class="fa fa-exchange"></i></a>';
                                                            }
                                                            if ($c_status == 'SL') {
                                                                if ((isIndiaLocation($cd['location']) == true) and ($cd['org_role'] == 13) and ($department_id == 6) and ($cd['location'] != 'CHA')) {
                                                                    echo '<a class="btn btn-default btn-xs letter_of_intent_flag_html" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Letter of intent" style="font-size:12px" onclick=getModelData("dfr_new","letter_of_intent/'.$r_id.'/'.$dfr_location.'",$(this),"letter_of_intent","letter_of_intent_flag_html"); data-letter_of_intent_flag_html="0">LOI</a>';
                                                                    echo "&nbsp;";
                                                                }
                                                            }
                                                        }
                                                                                                          
                                                        ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                            <tr id="<?php echo $c_id; ?>" class="collapse">
                                                <td colspan="20" style="background-color:#EEE;text-align: center;">
                                                    <div style="text-align:center;font-size:18px;color:#000;">
                                                        Wait for Data
                                                    </div>
                                                </td>
                                            </tr>
                                            <!---end of code---->
                                        <?php }
                                        ?>
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
<!------------------------------------------------------------------------------------------------------------>
<!---------------------------------Letter of Intent---------------------------------->
<div class="modal fade" id="letter_of_intent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!-------------------- Edit Requisition model ----------------------------->
<div class="modal fade modal-design" id="editRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!-------------------- Edit Requisition Assets Count Data ----------------------------->
<div class="modal fade modal-design" id="editRequisitionAssetsCountModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!---------------WFM Approval part-------------------->
<div class="modal fade modal-design" id="approvalWfmModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!--------------WFM Decline part------------------>
<div class="modal fade modal-design" id="declineWfmModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmDeclineWfm" action="<?php echo base_url(); ?>dfr/decline_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Decline Requisition</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Decline Remarks</label>
                                <textarea class="form-control" id="approved_comment" name="approved_comment" placeholder="Remarks Here...." required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='wfmDecline' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>
<!------------------------------------------------------------------------------>
<div class="modal fade modal-design" id="SendBasicLinkModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!------------------ Candidate Adding -------------------------->
<div class="modal fade modal-design" id="addCandidateModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!-------------------------------view Candidate------------------------------------>
<div class="modal fade modal-design" id="viewCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false'></div>
<!---------------------------------------Edit Candidate details------------------------------------------------->
<div class="modal fade modal-design" id="editCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<input type="hidden" name="html_rander_flag" id="html_rander_flag" value="0">
<!-------------------------------------------Candidate Experience------------------------------------------------------->
<!---------------------------------Add Experience---------------------------------->
<div class="modal fade modal-design" id="addCandidateExpModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!---------------------------------Edit Experience---------------------------------->
<div class="modal fade modal-design" id="editCandidateExpModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!-------------------------------------------Candidate Qualification------------------------------------------------------->
<!---------------------------------Add Qualification---------------------------------->
<div class="modal fade modal-design" id="addCandidateQualModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!---------------------------------Edit Qualification---------------------------------->
<div class="modal fade modal-design" id="editCandidateQualModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!--------------------------------------------------------------------------------------------------------------->
<!-------------------------------------------Schedule Candidate & Interview------------------------------------------------------>
<!----------------------Candidate add Scheduled rounds-------------------------------->
<div class="modal fade modal-design" id="addScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!--------------------------------------Candidate edit Scheduled----------------------------------------------->
<div class="modal fade modal-design" id="editScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!--------------------------------------Cancel Interview Scheduled----------------------------------------------->
<div class="modal fade modal-design" id="cancelScheduleCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!--------------------------------------Candidate Add Interview Round's---------------------------------------------->
<div class="modal fade modal-design" id="addCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!---------------------------------Edit Interview part---------------------------------->
<div class="modal fade modal-design" id="editCandidateInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!----------------------------------------------Candidate Final Selection----------------------------------------------->
<div class="modal fade modal-design" id="candidateSelectInterview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade modal-design" id="candidateNotSelectInterviewModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="frmCandidateSelectInterviewModel" action="<?php echo base_url(); ?>dfr/candidate_final_interviewStatus" data-toggle="validator" method='POST'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Candidate Final Status</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="" name="candidate_status" value="R">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reason/Remarks</label>
                                <textarea class="form-control" id="final_status_remarks" name="final_status_remarks"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='selectInterviewCandidate' class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!---------------------------------------------------------------------------------------------------------->
<!----------------------------------Candidate Final Approval------------------------------->
<div class="modal fade modal-design" id="approvalFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade modal-design" id="modalfinalchecknow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!-------------------------------Candidate Final Approval For Phillipines Start---------->
<div class="modal fade" id="approvalFinalSelectModelPhp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    < 
</div>
<div class="modal fade" id="modalfinalchecknowphp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!-------------------------------Candidate Final Approval For Phillipines end------------>
<!----------------------------------Decline Approval------------------------------->
<div class="modal fade modal-design" id="declineFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!------------------------------------------------------------------------------------------------------------------->
<!---------------------------------Select candidate as employee---------------------------------->
<div class="modal fade modal-design" id="finalSelectionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!--------------------Update BGV--------------------------------->
<div class="modal fade" id="updateCandidateBGVModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmBGVCandidate" action="<?php echo base_url(); ?>dfr/updateBGV" data-toggle="validator" method='POST' enctype="mulipart/form-data">

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Candidate BGV</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" class="form-control" required>
                    <input type="hidden" id="c_id" name="c_id" class="form-control" required>

                    <div class="row" id="bgvdat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Is BGV?</label>
                                <select class="form-control" id="is_bgv_verify" name="is_bgv_verify">
                                    <option value="">-Select-</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        <!--				<div class="col-md-6">
					<div class="form-group">
						<label>Upload Document</label>
                                                <input type="file" class="form-control" id="bgv_document" name="bgv_document" >
					</div>
				</div>-->
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" class="btn btn-primary frmSaveButton" value="Save">
                </div>

            </form>

        </div>
    </div>
</div>
<!------------------------------ Re-Scheduled Candidate---------------------------------------->
<div class="modal fade modal-design" id="rescheduleCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!-------------------------------------------------------------------------------------------------------------------------->
<div class="modal fade modal-design" id="transferSelectedCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!--------------- DROP CANDIDATE -------------------->
<div class="modal fade modal-design" id="dropCandidateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!--------------- From Upload -------------------->
<div class="modal fade modal-design" id="InterviewEvalutionFrom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!--------------- Fro loi Upload -------------------->
<div class="modal fade modal-design" id="loi_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!--------------- Verify  CANDIDATE Documents-------------------->
<div class="modal fade modal-design" id="VerifyDocumentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form class="frmVerifyDocuments" action="<?php echo base_url(); ?>dfr/verifyDocuments" data-toggle="validator" method='POST'>
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Verify Document</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div id='VerifyDocumentsContent' class="col-md-12">
                  </div>
               </div>
               <div id="certify_documents_div" class="row">
                  <div class="col-md-12" style="color:darkgreen;font-weight:bold;">
                     <input type="hidden" id="r_id" name="r_id" class="form-control" required>
                     <input type="hidden" id="c_id" name="c_id" class="form-control" required>
                     <input type="checkbox" id="is_verify_doc" name="is_verify_doc" value='1' required>
                     I certify that the documents uploaded by candidate are valid and verified by me. .
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <input id="verify_submit_btn" type="submit" name="submit" class="btn btn-primary" value="Save">
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade modal-design employee_assets_model_dfr" id="employee_assets_model_dfr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!---------------Joining kit upload-------------------->
<div class="modal fade modal-design" id="upload_joining_kit_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>



<script type="text/javascript">
    document.querySelector("#req_no_position").addEventListener("keypress", function (evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });
</script>

<script>
    $(function () {
        $('#multiselect').multiselect();

        $('#select-brand').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('#asset_requisition').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>

<script>
    $(function () {
        $('#mother_name').keydown(function (e) {
            $("#mother_name_status").html("");
            if (e.shiftKey && (e.which == 48 || e.which == 49 || e.which == 50 || e.which == 51 || e.which == 52 || e.which == 53 || e.which == 54 || e.which == 55 || e.which == 56 || e.which == 57)) {
                e.preventDefault();
            } else {
                var key = e.keyCode;
                if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                    $("#mother_name_status").html("only Alphabate and space allowed");

                    e.preventDefault();
                }
            }
        });
    });
    $(function () {
        $('#edit_mother_name').keydown(function (e) {
            if (e.shiftKey || e.ctrlKey || e.altKey) {
                e.preventDefault();
            } else {
                var key = e.keyCode;
                if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                    $("#edit_mother_name_status").html("only Alphabate and space allowed");

                    e.preventDefault();
                }
            }
        });
    });

    $(function () {
        $('#multiselect').multiselect();

        $('#fclient_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.select-box').selectize({
            sortField: 'text'
        });
    });

    function get_user_data(cid, dfr_location, r_status, c_status, required_pos, filled_pos, r_id, interview_evalution_form) {
        $.ajax({
            Type: 'POST',
            url: '<?php echo base_url(); ?>/dfr/get_user_info',
            data: 'cid=' + cid + '&dfr_location=' + dfr_location + '&r_status=' + r_status + '&c_status=' + c_status + '&required_pos=' + required_pos + '&filled_pos=' + filled_pos + '&r_id=' + r_id + '&interview_evalution_form=' + interview_evalution_form,
            success: function (result) {
                $('#' + cid).html(result);
            }
        });
    }
</script>
<script>
    Filevalidation = () => {
        const fi = document.getElementById('inputGroupFile01');
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {

                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.10240
                if (file >= 1024) {
                    alert(
                            "File too Big, please select a file less than 1mb");
                    fi.value = "";
                }
                //                else if (file < 1024) {
                //                    alert(
                //                            "File too small, please select a file greater than 1mb");
                //                    fi.value = "";
                //                }
                else {
                    document.getElementById('size').innerHTML = '<b>' +
                            file + '</b> KB';
                }
            }
        }
    }
</script>
<script>
    Filevalidation = () => {
        const fi = document.getElementById('uploadFile');
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {

                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.10240
                if (file >= 1024) {
                    alert(
                            "File too Big, please select a file less than 1mb");
                    fi.value = "";
                }
                //                else if (file < 1024) {
                //                    alert(
                //                            "File too small, please select a file greater than 1mb");
                //                     fi.value = "";
                //                }
                else {
                    document.getElementById('size').innerHTML = '<b>' +
                            file + '</b> KB';
                }
            }
        }
    }
</script>
<script>
    $("#is_asset").change(function () {
        let asset = $("#is_asset").val();
        if (asset == '1') {
            $(".asset_required").css("display", "block");
            $("#asset_requisition").attr("required", true);

        } else {
            $("#asset_requisition").multiselect('selectAll', true);
            $("#asset_requisition").multiselect('clearSelection');
            $("#asset_requisition").multiselect('refresh');
            $("#asset_requisition").attr("required", false);
            $(".assets_count").css('display', 'none');
            $(".assets_count").html('');



            $(".asset_required").css("display", "none");
        }
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
    $(document).ready(function () {
        $('#qualification').summernote();
        $("#training_start_date").datepicker();
    });
    $(document).ready(function () {
        $('#job_summary').summernote();
    });
</script>
<script>
    $("#asset_requisition").change(function () {
        var assets = $("#asset_requisition").val();
        var r_id = $("#r_id").val();
        $.post("<?php echo base_url(); ?>" + "dfr/getRequisitionAssetsData", {
            sel: assets,
            r_id: r_id
        }).done(function (response) {
            if (response != '') {
                var dat_asset = JSON.parse(response);
                let string = "";
                $.each(dat_asset, function (r) {
                    var asset_req_count = dat_asset[r].assets_required != '' ? dat_asset[r].assets_required : '';
                    string += '<div class="col-md-4">\
                                <div class="form-group">\
                                    <label>' + dat_asset[r].name + ' Count</label>\
                                   <input type="number" id="ast_id_' + dat_asset[r].assets_id + '" name="ast_id_' + dat_asset[r].assets_id + '" class="form-control asset_id" value="' + asset_req_count + '" placeholder="Enter Req. ' + dat_asset[r].name + ' count..." required>\
                                </div>\
                            </div>';
                });
                $(".assets_count").css('display', 'block');
                $(".assets_count").html(string);
            } else {
                $(".assets_count").css('display', 'none');
            }
        });


    });
</script>
<script>
    $(".candidateApproval").click(function (e) {
        $('#sktPleaseWait').modal('show');
        var location = $(this).attr('location_id');
        $.post("<?php echo base_url(); ?>dfr/get_indlocation/" + location).done(function (dat) {
            $('#sktPleaseWait').modal('hide');
            if (dat == true) {
                $(".indlocation").css("display", 'block');
            } else {
                $(".indlocation").css("display", 'none');
            }
        });

    });
</script>


<script>
    // function getModelData(controller, method) {
    //     $.post("<?= base_url() ?>" + `${controller}/${method}`).done(function (data) {
            
    //         if (data) {
    //             console.log(data);
    //             let possition = method.split('/');
    //             console.log(possition);
    //             console.log(possition[0]);
    //             let possition_id = possition[0];
    //             $("#"+possition_id).html('');
    //             $("#"+possition_id).html(data);
    //         }
    //     });
    // }

   /* function getModelData(controller, method,elm,functionCall,htmlFlag) {
        var call_function_name = functionCall;
        var html_rander_flag = $('.'+htmlFlag).data(htmlFlag);
        if(html_rander_flag == 0){
                $('#sktPleaseWait').modal('show');
                $.ajax({
                type: 'get',
                url: "<?= base_url() ?>" + `${controller}/${method}`,
                dataType: 'html',
                success: function (data) {                     
                        let possition = method.split('/');
                        let possition_id = possition[0];
                        $("#"+possition_id).html(data);
                        $('.'+htmlFlag).data(htmlFlag,'1');
                        $('#sktPleaseWait').modal('hide');
                },
                complete: function(data) {
                    window[call_function_name](elm);
                },
            });
        } else {
            window[call_function_name](elm);
        }    
        
    } */

</script>