<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
    $('#course_id').select2();
	$('#office_id').select2();
    $('#dept_id').select2();
    $('.trainer').select2();
    $('.department').select2();
    $('.location').select2();
    $('#search_year').select2();

    $('#trainer_id').select2();
    $('#trainee_id').select2();
    $('#ld_office_id').select2();
    $('#ld_client_id').select2();
    $('#ld_process_id').select2();
    $('#ld_dept_id').select2();
    $('#ld_role_org_id').select2();
    $('.newDatePickFormat').datepicker({dateFormat: 'yy-mm-dd'});
    $('#schedule_start_time').datetimepicker({showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm:ss', });
    $('#schedule_end_time').datetimepicker({showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm:ss', });
    $('#e_schedule_start_time').datetimepicker({showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm:ss', });
    $('#e_schedule_end_time').datetimepicker({showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm:ss', });

    $("#exam_start_time").datetimepicker({
        dateFormat: "mm/dd/yy",
        timeFormat: "HH:mm",
        minDate: '-1D'
    }).datetimepicker("setDate", "<?php echo CurrDateTimeMDY(); ?>");

    $('input[name="date_range"]').daterangepicker({
        opens: 'left',
        locale: {
            "format": "DD/MM/YYYY",
            "separator": " - "
        }
    }, function (start, end, label) {
        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

// DATEPICKER
    $('.oldDatePick').datepicker({dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString()});
    $('.newDatePick').datepicker({dateFormat: 'mm/dd/yy'});
    $('.timeFormat').timepicker({timeFormat: 'HH:mm:ss', });

//============= LD REGISTRATION =======================//
    $('.ldRegBatch select[name="course_id"]').change(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).val();
        $('#sktPleaseWait').modal('show');
        $('.ldRegBatch select[name="batch_id"]').empty();
        $('.ldRegBatch select[name="batch_id"]').html('<option value="">-- No Batch Found --</option>');
        $('.ldRegBatch input[name="course_start_date"]').val('');
        $('.ldRegBatch input[name="course_schedule_time"]').val('');
        $.ajax({
            url: "<?php echo base_url('ld_programs/course_batch_list_av_ajax'); ?>",
            type: "GET",
            data: {cid: eidVal},
            dataType: "json",
            success: function (result) {
                $.each(result, function (i, token) {
                    $(".ldRegBatch select[name='batch_id']").append('<option value="' + token.id + '">' + token.batch_name + ' (' + token.trainer_name + ')</option>');
                });
                $('#sktPleaseWait').modal('hide');
            },
            error: function (result) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });

    $('.ldRegBatch select[name="batch_id"]').change(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).val();
        $('#sktPleaseWait').modal('show');
        $('.ldRegBatch input[name="course_start_date"]').val('');
        $('.ldRegBatch input[name="course_schedule_time"]').val('');
        $.ajax({
            url: "<?php echo base_url('ld_programs/course_batch_details_ajax'); ?>",
            type: "GET",
            data: {bid: eidVal},
            dataType: "json",
            success: function (result) {
                if (result.flag == '1') {
                    $('.ldRegBatch input[name="course_start_date"]').val(result.batch_start_date);
                    $('.ldRegBatch input[name="course_schedule_time"]').val(result.time_check);
                } else {
                    $('.ldRegBatch input[name="course_start_date"]').val('');
                    $('.ldRegBatch input[name="course_schedule_time"]').val('');
                }
                $('#sktPleaseWait').modal('hide');
            },
            error: function (result) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });


    $('.btnAssmntBatchAnalytics').click(function () {
        URL = $(this).attr('vd');
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: URL,
            type: "GET",
            dataType: "text",
            success: function (result) {
                $('#modalInfoAnalyticsAssmnt .modal-body').html(result);
                $('#modalInfoAnalyticsAssmnt').modal('show');
                $('#sktPleaseWait').modal('hide');
            },
            error: function (result) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });


// FILTER USER
    $(".ldOfficeBuffer").select2();
    $(".ldDepartmentBuffer").select2();
    $('.ldOfficeBuffer,.ldDepartmentBuffer,.ldRoleBuffer').change(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $('#traineeAddDiv .ldOfficeBuffer').val();
        deptVal = $('#traineeAddDiv .ldDepartmentBuffer').val();
        roleVal = $('#traineeAddDiv .ldRoleBuffer').val();
        if (deptVal != "" && eidVal != "" && roleVal != "") {
            $('#sktPleaseWait').modal('show');
            $('.ldUserBuffer').empty();
            $('.ldUserBuffer').html('<option value="">-- Select --</option>');
            if (eidVal != "ALL") {
                $.ajax({
                    url: "<?php echo base_url('ld_programs/office_employee_ajax'); ?>",
                    type: "GET",
                    data: {oid: eidVal, dept: deptVal, role: roleVal},
                    dataType: "json",
                    success: function (result) {
                        counter = 0;
                        $.each(result, function (i, token) {
                            counter++;
                            $(".ldUserBuffer").append('<option value="' + token.id + '">' + token.full_name + ' (' + token.fusion_id + ')' + ' (' + token.designation + ')' + '</option>');
                        });
                        if (counter < 1) {
                            $('.ldUserBuffer').html('<option value="">-- No Users Found --</option>');
                        }
                        $(".ldUserBuffer").select2();
                        $('#sktPleaseWait').modal('hide');
                    },
                    error: function (result) {
                        $('#sktPleaseWait').modal('hide');
                        alert('Something Went Wrong!');
                    }
                });
            } else {
                $('#sktPleaseWait').modal('hide');
            }
        }
    });

// APPEND ALTER
    $("#traineeAdd").click(function () {
        var selectedName = $('#trainee_id').find(":selected").text();
        var selectedValue = $('#trainee_id').val();
        $('#spantrainingdiv').hide();
        var addDivTrainee = '<div class="row"><div class="col-md-6"><div class="form-group"><select class="form-control" name="trainee_id_select[]" id="trainee_id_select[]"><option value="' + selectedValue + '">' + selectedName + '</option></select></div></div><div class="col-md-2"><div class="form-group"><button type="button" class="btn btn-danger btn-md" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-times"></i> Remove</button></div></div></div>';
        var htmlappend = $('#traineeAddDivFinal').append(addDivTrainee);

    });

    $('.newBatchTrainerRow').on('change', 'select[name="batch_external"]', function () {
        val = $(this).val();
        if (val == 1) {
            $('.newBatchTrainerRow .externalTrainerNameDiv').show();
            $('.newBatchTrainerRow input[name="external_trainer_name"]').val('');
            $('.newBatchTrainerRow input[name="external_trainer_name"]').attr('required', 'required');
        } else {
            $('.newBatchTrainerRow .externalTrainerNameDiv').hide();
            $('.newBatchTrainerRow input[name="external_trainer_name"]').val('');
            $('.newBatchTrainerRow input[name="external_trainer_name"]').removeAttr('required', 'required');
        }
    });

    CKEDITOR.replace('moreInfoEditor', {
        removePlugins: 'about',
    });


// COURSE CATEGORY INFO
    $('.courseCatEdit').click(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).attr('eid');

        $('#modalUpdateLDCategory .imageInfo').html();
        $('#modalUpdateLDCategory input[name="category_id"]').val('');
        $('#modalUpdateLDCategory input[name="category_name"]').val('');
        $('#modalUpdateLDCategory textarea[name="category_description"]').val('');

        $.ajax({
            url: "<?php echo base_url('ld_programs/course_category_info_ajax'); ?>",
            type: "GET",
            data: {eid: eidVal},
            dataType: "json",
            success: function (result) {
                $('#modalUpdateLDCategory input[name="category_id"]').val(eidVal);
                $('#modalUpdateLDCategory input[name="category_name"]').val(result.category_name);
                $('#modalUpdateLDCategory textarea[name="category_description"]').val(result.category_description);
                if (result.category_image != "" && result.category_image != "undefined" && result.category_image != null) {
                    $('#modalUpdateLDCategory .imageInfo').html('<img src="' + baseURL + 'uploads/ld_programs/' + result.category_image + '" style="width:100px;height:60px"></img>');
                }
                $('#modalUpdateLDCategory').modal('show');
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });
    });


// COURSE EDIT INFO
    $('.courseInfoEdit').click(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).attr('eid');
        $('#modalUpdateLDCourse .modal-body').html('<span class="text-danger">-- No Info Found --</span>');
        $.ajax({
            url: "<?php echo base_url('ld_programs/course_update_ajax'); ?>",
            type: "GET",
            data: {eid: eidVal},
            dataType: "text",
            success: function (result) {
                $('#modalUpdateLDCourse .modal-body').html(result);
                $('#modalUpdateLDCourse').modal('show');
                CKEDITOR.replace('moreInfoEditor', {
                    removePlugins: 'about',
                });
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });
    });




// COURSE ASSIGN INFO
    $('.courseProgramBody').on('click', '.courseAssignEdit', function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).attr('eid');
        $('#modalInfoLDCourseAssign #course_id').val(eidVal);

        $('#modalInfoLDCourseAssign select[name="office_id[]"]').val('');
        $('#modalInfoLDCourseAssign select[name="dept_id[]"]').val('');
        $('#modalInfoLDCourseAssign select[name="role_org_id[]"]').val('');
        $('#modalInfoLDCourseAssign select[name="client_id[]"]').val('');
        $('#modalInfoLDCourseAssign select[name="process_id[]"]').val('');
        $('#modalInfoLDCourseAssign select[name="is_notification"]').val('');

        $.ajax({
            url: "<?php echo base_url('ld_programs/course_assign_ajax'); ?>",
            type: "GET",
            data: {eid: eidVal},
            dataType: "json",
            success: function (result) {
                if (result.status == 1) {
                    $('#modalInfoLDCourseAssign').modal('show');
                    if (result.course_office != "") {
                        $('#modalInfoLDCourseAssign select[name="office_id[]"]').val(result.course_office.split(','));
                        $('#modalInfoLDCourseAssign select[name="dept_id[]"]').val(result.course_dept.split(','));
                        $('#modalInfoLDCourseAssign select[name="role_org_id[]"]').val(result.course_role_org.split(','));
                        $('#modalInfoLDCourseAssign select[name="client_id[]"]').val(result.course_client.split(','));
                        $('#modalInfoLDCourseAssign select[name="process_id[]"]').val(result.course_process.split(','));
                        $('#modalInfoLDCourseAssign select[name="process_id[]"]').val(result.course_process.split(','));
                        $('#modalInfoLDCourseAssign select[name="is_notification"]').val(result.is_assigned);

                        $('#ld_office_id').select2();
                        $('#ld_client_id').select2();
                        $('#ld_process_id').select2();
                        $('#ld_dept_id').select2();
                        $('#ld_role_org_id').select2();
                    }
                } else {
                    alert('Course Details Not Found!');
                }
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });


    });

    $('#modalInfoLDCourseAssign').on('change', 'select[name="client_id[]"]', function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).val();
        pidVal = $('#modalInfoLDCourseAssign select[name="process_id[]"]').val();
        $('#modalInfoLDCourseAssign select[name="process_id[]"]').html("<option vaue='ALL'>ALL</option>");
        $.ajax({
            url: "<?php echo base_url('ld_programs/course_get_process'); ?>",
            type: "POST",
            data: {eid: eidVal},
            dataType: "json",
            success: function (result) {
                optionVal = "<option vaue='ALL'>ALL</option>";
                $(result).each(function (key, token) {
                    optionVal += '<option value="' + token.id + '">' + token.name + '</option>';
                });
                $('#modalInfoLDCourseAssign select[name="process_id[]"]').html(optionVal);
                if (pidVal.length > 0) {
                    $('#modalInfoLDCourseAssign select[name="process_id[]"]').val(pidVal);
                }
                $('#ld_process_id').select2();
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });


    });

// POSITION FUSION ID FETCH



// COURSE VIEW INFO
    $('.courseInfoDetails').click(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).attr('eid');
        $('#modalInfoLDCourse .modal-body').html('<span class="text-danger">-- No Info Found --</span>');
        $.ajax({
            url: "<?php echo base_url('ld_programs/course_details_ajax'); ?>",
            type: "GET",
            data: {eid: eidVal},
            dataType: "text",
            success: function (result) {
                $('#modalInfoLDCourse .modal-body').html(result);
                $('#modalInfoLDCourse').modal('show');
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });
    });


// BATCH DETAILS
    function batchDetailsClick(a)
    {
        var batch_id = $(a).attr('bid');
        $('.batch_' + batch_id).toggleClass('inTable');
        $('.batch_' + batch_id).hide();
        if ($('.batch_' + batch_id).hasClass('inTable'))
        {
            $('.batch_' + batch_id).show();
            getassigned_batch_details(batch_id);
        }
    }

    function getassigned_batch_details(bid)
    {
        baseURL = "<?php echo base_url(); ?>";
        request_url = baseURL + "/ld_programs/batch_details_table/" + bid;
        datas = {'batch_id': bid};
        process_ajax(function (response)
        {
            $('#tr_' + bid).html(response);
        }, request_url, datas, 'text');
    }
// ++++++++++++++++++++++ archive batch Details ++++++++++++++++++++++++++++++++++++

function batchDetailsClick_archive(a)
    {
        var batch_id = $(a).attr('bid');
        $('.batch_' + batch_id).toggleClass('inTable');
        $('.batch_' + batch_id).hide();
        if ($('.batch_' + batch_id).hasClass('inTable'))
        {
            $('.batch_' + batch_id).show();
            getassigned_batch_details_archive(batch_id);
        }
    }

    function getassigned_batch_details_archive(bid)
    {
        baseURL = "<?php echo base_url(); ?>";
        request_url = baseURL + "/ld_programs/batch_details_table_archive/" + bid;
        datas = {'batch_id': bid};
        process_ajax(function (response)
        {
            $('#tr_' + bid).html(response);
        }, request_url, datas, 'text');
    }

    function batchAssesmentClick_archive(a)
    {
        var batch_id = $(a).attr('bid');
        $('.batch_' + batch_id).toggleClass('inTable');
        $('.batch_' + batch_id).hide();
        if ($('.batch_' + batch_id).hasClass('inTable'))
        {
            $('.batch_' + batch_id).show();
            getassigned_batch_asses_archive(batch_id);
        }
    }

    function getassigned_batch_asses_archive(bid)
    {
        baseURL = "<?php echo base_url(); ?>";
        request_url = baseURL + "/ld_programs/batch_assessment_archive/" + bid;
        datas = {'batch_id': bid};
        $('#tr_' + bid).html('');
        process_ajax(function (response)
        {
            $('#tr_' + bid).html(response);
        }, request_url, datas, 'text');
    }

// ++++++++++++++++++++++ end of archive batch details ++++++++++++++++++++++++++++++

///================================ remove batch ===================================////


// $(document).on('click', '.deleteBatch', function () {
    
//     let baseURL = "<?=base_url()?>";
//     var batchid = $(this).attr('batch_id');
//     var cid = $(this).attr('c_id');
//     //alert(batchid);
//     if(confirm('Are you sure to remove this trainee from this Batch ?'))
//     {
//         $.post(baseURL+"Ld_programs/delete_trainer", {user_id: cid, batch_id: batchid}).done(function (data) {
//             alert('Trainee has been Successfully Removed');
//             window.location.reload(baseURL+'ld_programs/batch_list');
//         });
//     }
    

// });

///=================================== end remove batch=========================///


///==============================UPLOAD MARKS=========================================////

    $(document).on('click', '.certificateusermarksUpdate', function () {
        var batchid = $(this).attr('batch_id');
        var cid = $(this).attr('c_id');
        $('#frm_CertificatemarksUpdate #batch_id').val(batchid);
        $('#frm_CertificatemarksUpdate #user_id').val(cid);
        $('#ta_CertificatemarksUpdate').modal('show');
    });
//==============================Update Training Time====================================//

    $(document).on('click', '.updateBatchTime', function () {
        var batchid = $(this).attr('batch_id');
        var cid = $(this).attr('c_id');
        $("#frm_update_training_time input").val('');
        $("#training_time").val('');
        $('#update_training_time #batch_id').val(batchid);
        $('#update_training_time #user_id').val(cid);
        $('.timeFormat').timepicker({timeFormat: 'HH:mm:ss', });
        $('#sktPleaseWait').modal('show');
        $.post("<?= base_url() ?>Ld_programs/total_traning_time", {user_id: cid, batch_id: batchid}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            var dat = JSON.parse(data);
            $(".elapsed_time").html(dat);
            $('#update_training_time').modal('show');
        });
    });



//------ NEW DESIGN KPI APPEND
    $(document).on("click", ".btnMore", function () {
        var text = $('.kpi_input_row_sample').html();
        $("#kpi_divs").append("<div class='col-md-12 kpi_input_row'>" + text + "</div>");
    });
    $(document).on("click", ".btnRemove", function () {
        $(this).parent().parent().remove();
    });



// UPLOAD PERFORMANCE EXCEL
    $('.uploadPerformBtn').click(function () {
        baseURL = "<?php echo base_url(); ?>";
        batch_id = $(this).attr('bid');
        design_id = $(this).attr('did');
        if (batch_id != "" && design_id != "") {
            downloadLink = baseURL + 'ld_programs/download_batch_performance_header?batch_id=' + batch_id + '&design_id=' + design_id;
            $('#uploadPerformanceModal #batch_id').val(batch_id);
            $('#uploadPerformanceModal #design_id').val(design_id);
            $('#uploadPerformanceModal .linkSampleUploadExcel').html('<span class="text-danger">-- No Design Found --</span>');
            $('#uploadPerformanceModal .linkSampleUploadExcel').html('<a target="_blank" style="cursor:pointer" href="' + downloadLink + '" class="btn btn-danger pull-right"><i class="fa fa-download"></i> Download Sample</a>');
            $('#uploadPerformanceModal').modal('show');
        } else {
            alert("No Design Available!");
        }
    });


// BATCH PERFORMANCE DETAILS
    function batchPerformanceDetailsClick(a)
    {
        var batch_id = $(a).attr('bid');
        $('.batch_' + batch_id).toggleClass('inTable');
        $('.batch_' + batch_id).hide();
        if ($('.batch_' + batch_id).hasClass('inTable'))
        {
            $('.batch_' + batch_id).show();
            getassigned_batch_performance_details(batch_id);
        }
    }

    function getassigned_batch_performance_details(bid)
    {
        baseURL = "<?php echo base_url(); ?>";
        request_url = baseURL + "/ld_programs/batch_performance_details_table/" + bid;
        datas = {'batch_id': bid};
        process_ajax(function (response)
        {
            $('#tr_' + bid).html(response);
        }, request_url, datas, 'text');
    }




// COURSE SCHEDULE INFO
    $('.courseScheduleEdit').click(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).attr('eid');

        $('#modalScheduleLD input[name="schedule_id"]').val('');
        $('#modalScheduleLD select[name="course_id"]').val('');
        $('#modalScheduleLD select[name="schedule_type"]').val('');
        $('#modalScheduleLD input[name="schedule_date"]').val('');
        $('#modalScheduleLD input[name="schedule_start_time"]').val('');
        $('#modalScheduleLD input[name="schedule_end_time"]').val('');
        $('#modalScheduleLD textarea[name="schedule_info"]').val('');

        $.ajax({
            url: "<?php echo base_url('ld_programs/course_schedule_info_ajax'); ?>",
            type: "GET",
            data: {eid: eidVal},
            dataType: "json",
            success: function (result) {
                $('#modalScheduleLD input[name="schedule_id"]').val(eidVal);
                $('#modalScheduleLD select[name="course_id"]').val(result.course_id);
                $('#modalScheduleLD select[name="schedule_type"]').val(result.schedule_type);
                $('#modalScheduleLD input[name="schedule_date"]').val(result.schedule_date);
                $('#modalScheduleLD input[name="schedule_start_time"]').val(result.start_time);
                $('#modalScheduleLD input[name="schedule_end_time"]').val(result.end_time);
                $('#modalScheduleLD textarea[name="schedule_info"]').val(result.schedule_info);

                $('#e_schedule_start_time').datetimepicker({showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss', });
                $('#e_schedule_end_time').datetimepicker({showSecond: false, dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss', });
                $('.newDatePickFormat').datepicker({dateFormat: 'yy-mm-dd'});

                $('#modalScheduleLD').modal('show');
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });
    });



// EDIT TRAINING BATCH
    $('.ta_btnBatchEdit').click(function () {
        var batchid = $(this).attr('batchid');
        var trainer = $(this).attr('trainer');
        var batchname = $(this).attr('batchname');

        $('#frmTrainingEditBatch #edit_batch_id').val(batchid);
        $('#frmTrainingEditBatch #e_batch_name').val(batchname);
        $('#ta_BatchEdit .modal-title').html('Trainer : ' + trainer + ' | Batch ' + batchname);
        $('#ta_BatchEdit').modal('show');

        $.ajax({
            url: "<?php echo base_url('ld_programs/batch_details_ajax'); ?>",
            type: "GET",
            data: {eid: batchid},
            dataType: "json",
            success: function (result) {
                $('#frmTrainingEditBatch input[name="batch_id"]').val(batchid);
                $('#frmTrainingEditBatch input[name="batch_name"]').val(result.batch_name);
                $('#frmTrainingEditBatch input[name="batch_start_date"]').val(result.batch_start_date);
                $('#frmTrainingEditBatch input[name="batch_end_date"]').val(result.batch_end_date);
                $('#frmTrainingEditBatch input[name="batch_start_time"]').val(result.batch_start_time);
                $('#frmTrainingEditBatch input[name="batch_end_time"]').val(result.batch_end_time);

                $('.newDatePick').datepicker({dateFormat: 'mm/dd/yy'});
                $('.timeFormat').timepicker({timeFormat: 'HH:mm:ss', });

                $('#ta_BatchEdit').modal('show');
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });
    });


    // BATCH TRAINER TRANSFER
    $('.trainer_transfer').click(function () {
            var batchid = $(this).attr('batchid');
            var trainer = $(this).attr('trainer');
            var batchname = $(this).attr('batchname');
            var trainer_id = $(this).attr('trainerid');
            var external = $(this).attr('external');
            var external_trainer = $(this).attr('external_trainer');
            $('#frmTrainerTransferTr .external').hide(); 
            if(external==1)
            {
                $('#frmTrainerTransferTr #external_trainer').val(external_trainer);
                $('#frmTrainerTransferTr .external').show();     
            }

            $('#frmTrainerTransferTr #transfer_batch_id').val(batchid);      
            $('#frmTrainerTransferTr #current_batch_trainer').val(trainer);   
            $('#modelTrainerTransfer #myModalLabel').html('Change Trainer | Batch ' + batchname);     
            $('#modelTrainerTransfer').modal('show');
        
    });

    // batch trainee delete
    $(".removetrainee").click(function()
    {
        baseURL = "<?php echo base_url(); ?>";
        var batch_id = $(this).attr("batch_id");
        
        var checkedVals = $('.trainee_'+batch_id+':checkbox:checked').map(function() {
            return this.value;
        }).get();
        var checked_users = checkedVals.join(",");
        if(checkedVals.length>0)
        {
            if(confirm('Are you sure to remove selected trainee from this Batch ?'))
            {
                $.post(baseURL+"Ld_programs/delete_trainer", {user_id: checked_users, batch_id: batch_id}).done(function (data) {
                    alert('Trainee has been Successfully Removed');
                    
                    window.location.reload(baseURL+'ld_programs/batch_list');
                });
            }
        }
        else{
            alert('Please select atleast one Batch Trainee');
        }
        
        
       
    });

// ADD NEW USER
    $(".newuserbatch").click(function () {
        baseURL = "<?php echo base_url(); ?>";
        var batch_id = $(this).attr("batch_id");
        var batchname = $(this).attr("bname");
        $('#modalNewUserBatch #add_trainee_batch_id').val(batch_id);
        $('#modalNewUserBatch #add_trainee_batch_name').val(batchname);
        $('#modalNewUserBatch').modal('show');
        var rURL = baseURL + 'ld_programs/fetch_Batch_TraineeList';
        $('#sktPleaseWait').modal('show');
        $('#modalNewUserBatch #AddNewUserContainer').html('');
        $.ajax({
            type: 'POST',
            url: rURL,
            data: 'batchid=' + batch_id,
            success: function (response) {
                var json_obj = JSON.parse(response);
                var html = '';
                for (var i in json_obj) {
                    html += '<tr><td><input type="checkbox" name="userCheckBox[]" value="' + json_obj[i].user_id + '"></td><td>' + json_obj[i].trainee_name + '</td><td>' + json_obj[i].roles + '</td><td>' + json_obj[i].fusion_id + '</td></tr>';
                }
                datatable_refresh('#modalNewUserBatch #default-datatable', 1);
                $('#modalNewUserBatch #AddNewUserContainer').html(html);
                datatable_refresh('#modalNewUserBatch #default-datatable');
                $('#sktPleaseWait').modal('hide');
            },
            error: function () {
                alert('Fail!');
                $('#sktPleaseWait').modal('hide');
            }
        });
    });

    function datatable_refresh(id, type = "")
    {
        if (type != '') {
            $(id).dataTable().fnClearTable();
            $(id).dataTable().fnDestroy();
        }
        if (type == '') {
            $(id).DataTable({
                paginate: false,
                bInfo: false
            });
    }
    }

    $(document).on('click', '.selectAllUserCheckBox', function () {
        if ($(this).is(':checked'))
        {
            $(this).closest('td').find('[name="userCheckBox[]"]').prop('checked', true);
        } else
        {
            $(this).closest('td').find('[name="userCheckBox[]"]').prop('checked', false);
        }
    });

    $(document).on('change', '.sorting_1 input[type="checkbox"]', function () {
    
        if($('.sorting_1 input:checked').length === $('.sorting_1 input').length)
        $('[name="selectAllUserCheckBox"]').prop('checked', true);
        else
        $('[name="selectAllUserCheckBox"]').prop('checked', false);
    });

    $(document).on('click', '.selectAllUserCheckBoxCertify', function () {
        if ($(this).is(':checked'))
        {
            $('[name="userCheckBoxCertify[]"]').prop('checked', true);
        } else
        {
            $('[name="userCheckBoxCertify[]"]').prop('checked', false);
        }
    });

    $(document).on('click', '.selectAllAgentCheckBox', function () {
        if ($(this).is(':checked'))
        {
            $('[name="agentCheckBox[]"]').prop('checked', true);
        } else
        {
            $('[name="agentCheckBox[]"]').prop('checked', false);
        }
    });


//========== LD EXAMINATION SCHEDULE ========================//

    function btnScheduleAssmnt_ajax(a)
    {
        var batch_id = $(a).attr("batch_id");
        var asmnt_id = $(a).attr("asmnt_id");
        var courseID = $(a).attr("course_id");
        $('#modalScheduleAssmnt input[name="batch_id"]').val(batch_id);
        $('#modalScheduleAssmnt input[name="assessment_id"]').val(asmnt_id);
        $('#modalScheduleAssmnt').modal('show');
        $('#scheduleAssmntListContainer').html("");
        var rURL = baseURL + 'ld_programs/fetchAssessmentUsers';
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: rURL,
            data: 'batch_id=' + batch_id + "&asmnt_id=" + asmnt_id + "&course_id=" + courseID,
            success: function (response) {
                var json_obj = JSON.parse(response);
                var html = '';
                for (var i in json_obj) {
                    html += '<tr><td><input type="checkbox" name="agentCheckBox[]" value="' + json_obj[i].user_id + '"></td><td>' + json_obj[i].fullname + '</td> <td>' + json_obj[i].fusion_id + '</td> <td>' + json_obj[i].designation + " (" + json_obj[i].department + ")" + '</td> </tr>';
                }
                $('#scheduleAssmntListContainer').html(html);
                $('#sktPleaseWait').modal('hide');
            },
            error: function () {
                alert('Fail!');
                $('#sktPleaseWait').modal('hide');
            }
        });

        var rURL = baseURL + 'ld_programs/fetchAssessmentExaminations';
        $.ajax({
            type: 'POST',
            url: rURL,
            data: 'batch_id=' + batch_id + "&asmnt_id=" + asmnt_id + "&course_id=" + courseID,
            success: function (response) {
                var json_obj = JSON.parse(response);
                var html = '<option value="">-- Select Exam --</option>';
                for (var i in json_obj) {
                    html += '<option value="' + json_obj[i].id + '">' + json_obj[i].title + ' (' + json_obj[i].course_code + ')' + '</option>';
                }
                $('#modalScheduleAssmnt select[name="exam_id"]').html(html);
            },
            error: function () {
                alert('Fail!');
            }
        });

    }


    $('#modalScheduleAssmnt select[name="exam_id"]').change(function () {
        baseURL = "<?php echo base_url(); ?>";
        exam_id = $(this).val();
        request_url = baseURL + "/ld_programs/fetchAssessmentExaminationInfo/";
        datas = {'exam_id': exam_id};
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: request_url,
            data: datas,
            dataType: "json",
            success: function (response) {
                $('#sktPleaseWait').modal('hide');
                var totSet = response.maxS;
                var totQues = response.maxQ;
                if (totSet == 0 || totQues == 0) {
                    alert("Please upload the questions in Exam ");
                    $('#modalScheduleAssmnt select[name="exam_id"]').val("");
                } else {
                    $('#modalScheduleAssmnt input[name="no_of_question"]').val(totQues);
                    $('#modalScheduleAssmnt input[name="no_of_question"]').prop('max', totQues);
                }
            },
            error: function () {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });


//========== LD EXAMINATION START ========================//

    $(document).on('click', ".btnStartExam", function (e) {
        var batch_id = $(this).attr("batch_id");
        var asmnt_id = $(this).attr("asmnt_id");
        $('#frmStartExam #batch_id').val(batch_id);
        $('#frmStartExam #assmnt_id').val(asmnt_id);
        $('#sktPleaseWait').modal('show');
        var rURL = "<?php echo base_url('ld_programs/fetchScheduleTimes'); ?>";
        $.ajax({
            type: 'POST',
            url: rURL,
            data: 'batch_id=' + batch_id + "&asmnt_id=" + asmnt_id,
            success: function (response) {
                var json_obj = JSON.parse(response);
                var options = '<option value="">--Select a Start Time--</option>';
                for (var i in json_obj) {
                    options += '<option value="' + json_obj[i].exam_start_time + '">' + json_obj[i].exam_start_time + '</option>';
                }
                $('#scheduledExamTime').html(options);
                $('#modelStartExam').modal('show');
                $('#sktPleaseWait').modal('hide');
            },
            error: function () {
                alert('Fail!');
                $('#sktPleaseWait').modal('hide');
            }
        });
    });

    $(document).on('change', "#scheduledExamTime", function (e) {
        var scheduled_exam_time = $(this).val();
        var batch_id = $('#frmStartExam #batch_id').val();
        var assmnt_id = $('#frmStartExam #assmnt_id').val();
        var datas = {'scheduled_exam_time': scheduled_exam_time, 'batch_id': batch_id, 'assmnt_id': assmnt_id};
        var request_url = "<?php echo base_url('ld_programs/getScheduledCandidates'); ?>";
        $('#startExamAgentListContainer').html("");
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: request_url,
            data: datas,
            success: function (response) {
                var res = JSON.parse(response);
                if (res.stat == true)
                {
                    var tr = '';
                    $.each(res.datas, function (index, element)
                    {
                        tr += '<tr><td><input type="checkbox" name="agentCheckBox[]" value="' + element.user_id + '"></td><td>' + element.candidate_name + '</td><td>' + element.fusion_id + '</td><td>' + element.role_name + '</td></tr>';
                    });
                    $('#startExamAgentListContainer').html(tr);
                } else
                {
                    tr = '<tr><td colspan="3" class="text-center">No Candidate Found</td></tr>';
                    $('#startExamAgentListContainer').html(tr);
                }
                $('#sktPleaseWait').modal('hide');
            },
            error: function () {
                alert('Fail!');
                $('#sktPleaseWait').modal('hide');
            }
        });
    });


    // OPEN VIEW MODAL
    $(".viewResultModal").click(function () {
        var clickid = $(this).attr("sourceid");
        var myarr = clickid.split("#");
        var baseURL = "<?php echo base_url(); ?>";
        var urlformed = baseURL + 'ld_programs/view_result_modal/' + myarr[0] + '/' + myarr[1] + '/' + myarr[2];
        $('#modalResultview').modal('show');
        $('#modalResultview .resultviewBody').html('');
        //alert(params);
        $.ajax({
            type: 'GET',
            url: urlformed,
            data: 'kid=1',
            success: function (data) {
                $('#modalResultview .resultviewBody').html(data);
            },
            error: function () {
                alert('Fail!');
            }
        });

    });




//========== LD EXAMINATION ========================//

    $('.createAssessmentBtn').click(function () {
        var batchid = $(this).attr('batch_id');
        $('#modelCreateAssmnt input[name="batch_id"]').val(batchid);
        $('#modelCreateAssmnt').modal('show');
    });

    $('.assessmentDetails').click(function () {
        baseURL = "<?php echo base_url(); ?>";
        bid = $(this).attr('batch_id');
        request_url = baseURL + "/ld_programs/viewAssessmentDetails/" + bid;
        datas = {'batch_id': bid};
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: request_url,
            data: datas,
            success: function (response) {
                $('#modelViewAssmnt .modal-body').html(response);
                $('#sktPleaseWait').modal('hide');
                $('#modelViewAssmnt').modal('show');
            },
            error: function () {
                $('#sktPleaseWait').modal('hide');
                alert('Fail!');
            }
        });
    });

    $('.createExamBtn ').click(function ()
    {
        $('#create_examination_modal').modal('show');
    });

    $(document).on('submit', '#create_examination_form', function (e)
    {
        e.preventDefault();
        var datas = $(this).serializeArray();
        var request_url = "<?php echo base_url('ld_programs/create_exam'); ?>";
        process_ajax(function (response)
        {
            var res = JSON.parse(response);
            if (res.stat == true)
            {
                $('#create_examination_modal').modal('hide');
                $("#create_examination_form").trigger("reset");
                alert('Examination Added Succesfully!');
            } else
            {
                alert('Something Went Wrong! Try After Some Time.');
            }
        }, request_url, datas, 'text');
    });


    $('#create_examination_modal').on('change', '#question_type', function () {
        curVal = $(this).val();
        if (curVal == "SCORE") {
            $('#create_examination_modal .optionDIVScore').show();
            $('#create_examination_modal .optionDIVScore').find(":input,select,textarea").val('');
            $('#create_examination_modal .optionDIVScore').find("input,select,textarea").attr('required', 'required');
        } else {
            $('#create_examination_modal .optionDIVScore').hide();
            $('#create_examination_modal .optionDIVScore').find(":input,select,textarea").val('');
            $('#create_examination_modal .optionDIVScore').find("input,select,textarea").removeAttr('required', 'required');
        }
    });


//=========== LD CERTIFICATION ======================================//
    $(".certificateuserbatch").click(function () {
        baseURL = "<?php echo base_url(); ?>";
        var batch_id = $(this).attr("batch_id");
        var batchname = $(this).attr("bname");
        $('#modalCertificateUserBatch #certify_batch_id').val(batch_id);
        $('#modalCertificateUserBatch #certify_batch_name').val(batchname);
        $('#modalCertificateUserBatch').modal('show');
        var rURL = baseURL + 'ld_programs/fetch_Batch_CertificateList';
        $('#sktPleaseWait').modal('show');
        $('#modalCertificateUserBatch #AddNewUserContainerCertify').html('');
        $.ajax({
            type: 'POST',
            url: rURL,
            data: 'batchid=' + batch_id,
            success: function (response) {
                var json_obj = JSON.parse(response);
                var html = '';
                for (var i in json_obj) {
                    isCertificate = json_obj[i].is_certificate_sent;
                    certCheck = "n/a";
                    if (isCertificate == 'Y') {
                        certCheck = "<i class='fa fa-check text-success'></i>";
                    }
                    html += '<tr><td><input type="checkbox" name="userCheckBoxCertify[]" value="' + json_obj[i].user_id + '"></td><td>' + json_obj[i].agent_name + '</td><td>' + json_obj[i].fusion_id + '</td><td>' + certCheck + '</td>' + '<td>' + json_obj[i].email_id_off + ',' + json_obj[i].email_id_per + '</td>' + '</tr>';
                }
                datatable_refresh('#modalCertificateUserBatch #default-datatable', 1);
                $('#modalCertificateUserBatch #AddNewUserContainerCertify').html(html);
                datatable_refresh('#modalCertificateUserBatch #default-datatable');
                $('#sktPleaseWait').modal('hide');
            },
            error: function () {
                alert('Fail!');
                $('#sktPleaseWait').modal('hide');
            }
        });
    });



// CERTIFICATE UPDATE DETAILS
    $('.certificateuserbatchUpdate').click(function () {
        var batchid = $(this).attr('batch_id');
        var batchname = $(this).attr('bname');
        var coursename = $(this).attr('cname');
        var position_f_id = $(this).attr('pfid');
        var position_s_id = $(this).attr('psid');
        var position_t_id = $(this).attr('ptid');
        var position_f_file = $(this).attr('pffl');
        var position_s_file = $(this).attr('psfl');
        var position_t_file = $(this).attr('ptfl');

        $('#frm_CertificateUpdate #edit_batch_id').val(batchid);
        $('#frm_CertificateUpdate #c_certification_name').val(coursename);
        $('#frm_CertificateUpdate input[name="certification_to"]').val('Team Leader/Supervisor');
        $('#frm_CertificateUpdate input[name="certification_days"]').val('5-days');
        $('#frm_CertificateUpdate input[name="certification_cc"]').val('ld@fusionbposervices.com');
        $('#frm_CertificateUpdate input[name="position_first_id"]').val(position_f_id);
        $('#frm_CertificateUpdate input[name="position_snd_id"]').val(position_s_id);
        $('#frm_CertificateUpdate input[name="position_thrd_id"]').val(position_t_id);
        // $('#frm_CertificateUpdate input[name="position_first_file"]').val("<?= base_url() . 'uploads/ld_programs/signature/' ?>"+position_f_file);
        // $('#frm_CertificateUpdate input[name="position_snd_file"]').val("<?= base_url() . 'uploads/ld_programs/signature/' ?>"+position_s_file);
        // $('#frm_CertificateUpdate input[name="position_thrd_file"]').val("<?= base_url() . 'uploads/ld_programs/signature/' ?>"+position_t_file);

        // if(position_f_file!=""){
        // 	$('#position_first_file').show();	
        // 	$('#position_first_file').text(position_f_file);
        // }else{
        // 	$('#position_first_file').hide();	
        // }
        // if(position_s_file!=""){
        // 	$('#position_snd_file').show();	
        // 	$('#position_snd_file').text(position_s_file);
        // }else{
        // 	$('#position_snd_file').hide();	
        // }
        // if(position_s_file!=""){
        // $('#position_thrd_file').show();	
        // $('#position_thrd_file').text(position_t_file);
        // }else{
        // $('#position_thrd_file').hide();	
        // }

        $('#ta_CertificateUpdate .modal-title').html('Batch ' + batchname);
        $('#ta_CertificateUpdate').modal('show');

        if (position_f_id != "") {
            checkID(position_f_id, "position_first_id");
            fetchSignature(position_f_id, "position_first_file");
        } else {
            $("#view_position_first_id").val('No Data Found');
        }

        if (position_s_id != "") {
            checkID(position_s_id, "position_snd_id");
            fetchSignature(position_s_id, "position_snd_file");
        } else {
            $("#view_position_snd_id").val('No Data Found');
        }

        if (position_t_id != "") {
            checkID(position_t_id, "position_thrd_id");
            fetchSignature(position_t_id, "position_thrd_file");
        } else {
            $("#view_position_thrd_id").val('No Data Found');

        }

        $.ajax({
            url: "<?php echo base_url('ld_programs/batch_details_ajax'); ?>",
            type: "GET",
            data: {eid: batchid},
            dataType: "json",
            success: function (result) {
                $('#frm_CertificateUpdate input[name="batch_id"]').val(batchid);
                if (result.certification_name != null && result.certification_name != "") {
                    $('#frm_CertificateUpdate input[name="certification_name"]').val(result.certification_name);
                }
                if (result.certification_to != null && result.certification_to != "") {
                    $('#frm_CertificateUpdate input[name="certification_to"]').val(result.certification_to);
                }
                if (result.certification_days != null && result.certification_days != "") {
                    $('#frm_CertificateUpdate input[name="certification_days"]').val(result.certification_days);
                }
                if (result.certification_cc != null && result.certification_cc != "") {
                    $('#frm_CertificateUpdate input[name="certification_cc"]').val(result.certification_cc);
                }
                $('#frm_CertificateUpdate input[name="batch_start_time"]').val(result.batch_start_time);

                $('.newDatePick').datepicker({dateFormat: 'mm/dd/yy'});
                $('.timeFormat').timepicker({timeFormat: 'HH:mm:ss', });

                $('#ta_CertificateUpdate').modal('show');
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });
    });


/////============================= FILE UPLOAD ====================================================///

    $('.courseProgramBody').on('click', '.courseAttachFile', function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).attr('eid');
        $('#modalUpdateLDAttachment input[name="course_id"]').val(eidVal);
        $('#modalUpdateLDAttachment').modal('show');
    });



/////============================= SURVEY ====================================================///

    $(document).on('click', '.selectAllSurveyUserCheckBox', function () {
        if ($(this).is(':checked'))
        {
            $('[name="userSurveyCheckBox[]"]').prop('checked', true);
        } else
        {
            $('[name="userSurveyCheckBox[]"]').prop('checked', false);
        }
    });

    $(".sruveyuserbatch").click(function () {
        baseURL = "<?php echo base_url(); ?>";
        var batch_id = $(this).attr("batch_id");
        var batchname = $(this).attr("bname");
        $('#modalEnableSurvey #survey_batch_id').val(batch_id);
        $('#modalEnableSurvey #survey_batch_name').val(batchname);
        $('#modalEnableSurvey').modal('show');
        var rURL = baseURL + 'ld_programs/fetch_Batch_CertificateList';
        $('#sktPleaseWait').modal('show');
        $('#modalEnableSurvey #surveyUserContainer').html('');
        $.ajax({
            type: 'POST',
            url: rURL,
            data: 'batchid=' + batch_id,
            success: function (response) {
                var json_obj = JSON.parse(response);
                var html = '';
                for (var i in json_obj) {
                    isSurvey = json_obj[i].trn_survey_status;
                    sruveyCheck = "n/a";
                    if (isSurvey == '1') {
                        sruveyCheck = "<i class='fa fa-check text-success'></i>";
                    }
                    html += '<tr><td><input type="checkbox" name="userSurveyCheckBox[]" value="' + json_obj[i].user_id + '"></td><td>' + json_obj[i].agent_name + '</td><td>' + json_obj[i].fusion_id + '</td><td>' + sruveyCheck + '</td></tr>';
                }
                datatable_refresh('#modalEnableSurvey #default-datatable', 1);
                $('#modalEnableSurvey #surveyUserContainer').html(html);
                datatable_refresh('#modalEnableSurvey #default-datatable');
                $('#sktPleaseWait').modal('hide');
            },
            error: function () {
                alert('Fail!');
                $('#sktPleaseWait').modal('hide');
            }
        });
    });




//======================= LD PROGRAMS EXTERNAL REGISTRATION ============================================//

    $('.ldOfficeExternal').change(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).val();
        $('#sktPleaseWait').modal('show');
        $('.ldAgentEmployee').empty();
        $('.ldAgentEmployee').html('<option value="">-- Select --</option>');
        if (eidVal != "ALL") {
            $.ajax({
                url: "<?php echo base_url('ld_programs/office_employee_ajax'); ?>",
                type: "GET",
                data: {oid: eidVal},
                dataType: "json",
                success: function (result) {
                    counter = 0;
                    $.each(result, function (i, token) {
                        counter++;
                        $(".ldAgentEmployee").append('<option value="' + token.id + '">' + token.full_name + ' (' + token.fusion_id + ')' + '</option>');
                    });
                    if (counter < 1) {
                        $('.ldAgentEmployee').html('<option value="">-- No Users Found --</option>');
                    }
                    $(".ldAgentEmployee").select2();
                    $('#sktPleaseWait').modal('hide');
                },
                error: function (result) {
                    $('#sktPleaseWait').modal('hide');
                    alert('Something Went Wrong!');
                }
            });
        } else {
            $('#sktPleaseWait').modal('hide');
        }
    });


    $(".ldAgentEmployee").select2();
    $('.ldAgentEmployee').change(function () {
        baseURL = "<?php echo base_url(); ?>";
        eidVal = $(this).val();
        $('.employee_details_row input[name="employee_id"]').val('');
        $('.employee_details_row input[name="employee_name"]').val('');
        $('.employee_details_row input[name="supervisor_name"]').val('');
        $('.employee_details_row input[name="supervisor_email"]').val('');
        $('.employee_details_row input[name="supervisor_id"]').val('');
        $('.employee_details_row input[name="employee_email"]').val('');
        $('.employee_details_row select[name="employee_designation"]').val('');
        $('.employee_details_row select[name="employee_department"]').val('');
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo base_url('ld_programs/employee_details_ajax'); ?>",
            type: "GET",
            data: {uid: eidVal},
            dataType: "json",
            success: function (result) {
                $('.employee_details_row input[name="employee_id"]').val(result.fusion_id);
                $('.employee_details_row input[name="employee_name"]').val(result.full_name);
                $('.employee_details_row input[name="supervisor_name"]').val(result.l1_supervisor);
                $('.employee_details_row input[name="supervisor_email"]').val(result.l1_email_id);
                $('.employee_details_row input[name="supervisor_id"]').val(result.assigned_to);
                $('.employee_details_row input[name="employee_email"]').val(result.email_id_off);
                $('.employee_details_row select[name="employee_designation"]').val(result.role_id);
                $('.employee_details_row select[name="employee_department"]').val(result.dept_id);
                $('#sktPleaseWait').modal('hide');
            },
            error: function (result) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });


</script>

<script type="text/javascript">

    function checkID(fid, data) {

        $.ajax({
            url: "<?php echo base_url('ld_programs/position_name_ajax'); ?>",
            type: "POST",
            data: {fid: fid},
            dataType: "text",
            success: function (result) {
                console.log(result);
                $('#view_' + data).val(result);
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });
    }


    function checkIDd(fid, data) {

        var fuid = $('#edit_' + fid).val();

        if(fuid == ""){
            $('#view_' + fid).val('');
        }

        if(fuid.length > 0){
            $.ajax({
                url: "<?php echo base_url('ld_programs/position_name_ajax'); ?>",
                type: "POST",
                data: {fid: fuid},
                dataType: "text",
                success: function (result) {
                    if(result){ 
                        $('#view_' + fid).val(result);
                    }else{
                        alert('ID Not Found!');
                        $('#edit_' + fid).val('');
                        $('#view_' + fid).val('');
                        
                    }
                },
                error: function (result) {
                    alert('Something Went Wrong!');
                }
            });   
        }
    }



    $(document).on('focusout','#certification_cc',function()
    {
        var email = $(this).val();
        var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

        if(email.length > 0){
            if(email.includes(',')){
                var arr = email.split(',');
                var valid = "";

                for (var i = 0; i < arr.length; i++) {
                    if(arr[i].length > 0){
                        if(!arr[i].match(reEmail)) {
                          alert("Invalid email address");
                        }else{
                            valid += arr[i]+',';
                        }    
                    }
                }

                $(this).val(valid);

            }else{
               if(!email.match(reEmail)) {
                  alert("Invalid email address");
                  $(this).val("");
               }
            }   
        }
        
        
    });



    $(document).on('submit','.frm_CertificatemarksUpdate',function(e){
        e.preventDefault();

        baseURL = '<?php echo base_url(); ?>';
        let valid = true;
        $('.frmAddProd input:required').each(function() {
          if ($(this).is(':invalid') || !$(this).val()) valid = false;
        })
        if (!valid) alert("please fill all fields!");
        else{
                    $('#sktPleaseWait').modal('show');  
                    $.ajax({
                       type: 'POST',    
                       url:baseURL+'ld_programs/marks_update_info',
                       data:$('form.frm_CertificatemarksUpdate').serialize(),
                       success: function(msg){
                                var alrt = JSON.parse(msg);
                                $('#sktPleaseWait').modal('hide');
                                $('#ta_CertificatemarksUpdate').modal('hide');
                                if(alrt.status == "true"){
                                    alert('Updated Succesfully');
                                    $('#marks_update').val('')
                                }else{
                                    alert('Something Went Wrong!');
                                }
                        },
                        error: function (result) {
                            alert('Something Went Wrong!');
                        }
                      });
        }
        
        
        
    });



    function fetchSignature(fid, data) {
        $.ajax({
            url: "<?php echo base_url('ld_programs/fetchSignature'); ?>",
            type: "POST",
            data: {fid: fid},
            dataType: "text",
            success: function (result) {
                console.log(result);
                $('#img_' + data).text(result);
            },
            error: function (result) {
                alert('Something Went Wrong!');
            }
        });
    }


</script>