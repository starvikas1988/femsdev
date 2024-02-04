<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmTransferSelectedCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                <input type="text" name="search_req" id="search_req" class="form-control" placeholder="Type Requisition Number">
                                <div id="searchList"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left:8px" id="req_details">

                    </div>

                    </br></br>

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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                </div>

            </form>

        </div>
    </div>

<!--<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmTransferSelectedCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Candidate Transfer</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" class="form-control">
                    <input type="hidden" id="c_id" name="c_id" class="form-control">
                    <input type="hidden" id="c_status" name="c_status" class="form-control">
                    <div class="filter-widget">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Select Location</label>
                                    <select id="transfer_location" class="select-box" name="office_id" autocomplete="off" placeholder="Select Location" width="100%">
                                        <option value="">Select Location</option>
                                        <?php
                                        ?>
                                        <?php foreach ($location_data as $loc) { ?>
                                            <?php
                                            $sCss = '';
                                            if (!empty($myoffice_id)) {
                                                if ($loc['abbr'] == $myoffice_id) {
                                                    $sCss = 'selected';
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Select Site</label>
                                    <select id="select_site" class="trans_candidate" name="site_id" autocomplete="off" placeholder="Select site" width="100%">
                                        <option value="">--Select Site--</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Select Department</label>
                                    <select id="select_department_pool" class="trans_candidate" name="department_id" autocomplete="off" placeholder="Select Department" width="100%">
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($department_data as $k => $dep) {
                                            $sCss = '';
                                            if (!empty($o_department_id)) {
                                                if (in_array($dep['id'], $o_department_id)) {
                                                    $sCss = 'selected';
                                                }
                                            } ?>
                                            <option value="<?php echo $dep['id']; ?>" <?php echo $sCss; ?>><?php echo $dep['shname']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>List of Requisition</label>
                                    <select class="select-box" id="req_id" name="req_id">
                                        <option value="">-Select-</option>
                                        <option value="0">Pool</option>
                                        <?php foreach ($getrequisition as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['req_desc']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="req_details"></div>
                                </div>
                            </div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="pop-danger-btn" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="submit-btn">Save</button>
                </div>



            </form>

        </div>
    </div>-->
    <script>
        $('.select-box').selectize({
            sortField: 'text'
        });
        $("#transfer_location").on('change', function() {
            var pid = this.value;
            var select_site = $("#select_site").val();
            var department = $("#select_department_pool").val();
            console.log(pid);
            // var interview_site = $("#interview_site").val();
            // var dept_id = $("#dept_id").val();

            // if(pid=="") alert("Please Select The Location")
            var URL = 'https://10.80.51.10/femsdev/dfr/getSiteListByLocation';
            $('#sktPleaseWait').modal('show');
            $.ajax({
                type: 'POST',
                url: URL,
                //    data:'pid='+pid+'&interview_site='+interview_site+'&dept_id='+dept_id,
                data: 'pid=' + pid,
                success: function(pList) {
                    //alert(pList);
                    var json_obj = $.parseJSON(pList); //parse JSON
                    // console.log(json_obj);
                    $('#select_site').empty();
                    $('#req_id').empty();
                    $('#req_details').empty();
                    $('#select_site').append($('<option value=""> </option>').val('').html(' Select Site '));
                    for (var i in json_obj)
                        $('#select_site').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name));
                    $('#sktPleaseWait').modal('hide');                    
                },
                error: function() {
                    alert('Fail!');
                }

            });
            dependent_requisition(pid, select_site, department);
        });

        $("#select_department_pool").on('change', function() {
            var pid = this.value;
            var transfer_location = $("#transfer_location").val();
            var select_site = $("#select_site").val();
            var URL = 'https://10.80.51.10/femsdev/dfr/getRequisitionByLocationAndSite';
            $('#sktPleaseWait').modal('show');
            $.ajax({
                type: 'POST',
                url: URL,
                data: 'did=' + pid + '&location=' + transfer_location + '&site_id=' + select_site,
                success: function(pList) {

                    var json_obj = $.parseJSON(pList); //parse JSON					
                    $('#req_id').empty();
                    $('#req_id').append($('<option></option>').val('').html(' Select Requisition '));
                    $('#req_id').append($('<option></option>').val('0').html('Pool'));
                    for (var i in json_obj)
                        $('#req_id').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].req_desc));
                    $('#sktPleaseWait').modal('hide');
                },
                error: function() {
                    alert('Fail!');
                }

            });
        });
    </script>