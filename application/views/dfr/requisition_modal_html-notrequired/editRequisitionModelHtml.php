<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="frmEditRequisition" action="<?php echo base_url(); ?>dfr/edit_requisition" data-toggle="validator" method='POST'>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Requisition</h4>
            </div>
            <div class="modal-body filter-widget">
                <input type="hidden" id="r_id" name="r_id" value="">
                <input type="hidden" id="requisition_id" name="requisition_id" value="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Location</label>
                            <select class="form-control" id="location" name="location" required>
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
                            <select class="form-control" id="department_id" name="department_id" required>
                                <option value="">--Select--</option>
                                <?php foreach ($get_department_data as $department) { ?>
                                    <option value="<?php echo $department['id']; ?>"><?php echo $department['shname']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Requisition Type</label>
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
                                <label>Due Date</label>
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
                            <label>Company Brand</label>
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
                            <label>Position</label>
                            <select class="form-control" id="role_id" name="role_id" required>
                                <option value="">--Select--</option>
                                <?php foreach ($role_data as $role) { ?>
                                    <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Client</label>
                            <select class="form-control" id="fedclient_id" name="client_id" required>
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
                            <select class="form-control" id="fedprocess_id" name="process_id" required>
                                <option value="">--Select--</option>
                                <?php foreach ($process_list as $process) { ?>
                                    <option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Required no of Position</label>
                            <input type="number" class="form-control" id="req_no_position" name="req_no_position" value="" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Required Skill</label>
                            <input type="text" class="form-control" id="req_skill" name="req_skill" value="" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Batch No</label>
                            <input type="text" class="form-control" id="job_title" name="job_title" value="" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Is Asset Required?</label>
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
                            <label>Work Type</label>
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
                    <!--<div class="col-md-4">
                        <div class="form-group">
                            <label>Required Qualification</label>
                            <input type="text" class="form-control" id="req_qualification" name="req_qualification" value="" required>
                        </div>	
                    </div>-->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Qualification</label>
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
                            <label>Required Experience Range</label>
                            <input type="text" class="form-control" id="req_exp_range" name="req_exp_range" value="" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Job Description</label>
                            <textarea class="form-control" id="job_desc" name="job_desc"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" id='editRequisition' class="btn btn-primary">Save</button>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $("#fedclient_id").change(function() {
            var client_id = $(this).val();
            populate_process_simple(client_id, '', 'fedprocess_id', 'N');
        });

        function populate_process_simple(cid, def = '', objid = 'process_id', isAll = 'N') {
            $('#sktPleaseWait').modal('show');
            var URL = '<?php echo base_url(); ?>dfr/getProcessList';
            //alert(URL+"?cid="+cid);
            $.ajax({
                type: 'POST',
                url: URL,
                data: 'cid=' + cid,
                success: function(pList) {
                    $('#sktPleaseWait').modal('hide');
                    //alert(pList);

                    var json_obj = $.parseJSON(pList); //parse JSON
                    $('#' + objid).empty();
                    $('#' + objid).append($('#' + objid).val(''));
                    $('#' + objid).append($('<option></option>').val('').html('--Select--'));
                    for (var i in json_obj) {
                        $('#' + objid).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name + '-' + json_obj[i].fusion_id + '-' + json_obj[i].dept_name + '-' + json_obj[i].role_name));
                    }

                },
                error: function() {
                    alert('Fail!');
                }
            });
        }
    });
</script>