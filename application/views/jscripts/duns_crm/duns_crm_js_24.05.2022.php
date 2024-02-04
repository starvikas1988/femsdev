<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>

    $('.oldDatePick').datepicker({dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString()});
    $('.newDatePick').datepicker({dateFormat: 'mm/dd/yy'});

    $('.editMasterClient').click(function () {
        sid = $(this).attr('sid');
        $('#editModal_record input[name="edit_id"]').val(sid);
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo duns_url('master_client_ajax'); ?>",
            type: "GET",
            data: {eid: sid},
            dataType: "json",
            success: function (jsonData) {
                if (jsonData.response == "success") {
                    $('#editModal_record input[name="edit_id"]').val(jsonData.id);
                    $('#editModal_record input[name="client_name"]').val(jsonData.name);
                    $('#editModal_record textarea[name="client_description"]').val(jsonData.description);
                    $('#editModal_record select[name="client_status"]').val(jsonData.is_active);
                    $('#editModal_record').modal('show');
                } else {
                    alert("Somethign Went Wrong!");
                }
                $('#sktPleaseWait').modal('hide');
            },
            error: function (jsonData) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });


    $('.div_agentInputAddition').on('change', 'select[name="field_type"]', function () {
        curVal = $(this).val();
        if (curVal == "select") {
            $(this).closest('.div_agentInputAddition').find('.div_drodpdownOption').show();
            $(this).closest('.div_agentInputAddition').find('textarea[name="field_options"]').attr('required', 'required');
            $(this).closest('.div_agentInputAddition').find('textarea[name="field_options"]').val('');
        } else {
            $(this).closest('.div_agentInputAddition').find('.div_drodpdownOption').hide();
            $(this).closest('.div_agentInputAddition').find('textarea[name="field_options"]').removeAttr('required', 'required');
            $(this).closest('.div_agentInputAddition').find('textarea[name="field_options"]').val('');
        }
    });

    $('.div_agentColumnAddition').on('change', 'select[name="header_map[]"]', function () {
        curVal = $(this).val();
        if (curVal == "_add_column") {
            $(this).closest('.div_agentColumnAddition').find('.div_newColumnEntry').show();
            $(this).closest('.div_agentColumnAddition').find('input[name="header_new[]"]').attr('required', 'required');
        } else {
            $(this).closest('.div_agentColumnAddition').find('.div_newColumnEntry').hide();
            $(this).closest('.div_agentColumnAddition').find('input[name="header_new[]"]').removeAttr('required', 'required');
        }
    });

    $('.viewMasterDatList').click(function () {
        sid = $(this).attr('sid');
        $('#editModal_record input[name="edit_id"]').val(sid);
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo duns_url('master_client_ajax'); ?>",
            type: "GET",
            data: {eid: sid},
            dataType: "json",
            success: function (jsonData) {
                if (jsonData.response == "success") {
                    $('#editModal_record input[name="edit_id"]').val(jsonData.id);
                    $('#editModal_record input[name="client_name"]').val(jsonData.name);
                    $('#editModal_record textarea[name="client_description"]').val(jsonData.description);
                    $('#editModal_record select[name="client_status"]').val(jsonData.is_active);
                    $('#editModal_record').modal('show');
                } else {
                    alert("Somethign Went Wrong!");
                }
                $('#sktPleaseWait').modal('hide');
            },
            error: function (jsonData) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });


    $('.assignDataList').click(function () {
        sid = $(this).attr('sid');
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo duns_url('assign_data_agent_modal'); ?>",
            type: "GET",
            data: {record_id: sid},
            dataType: "text",
            success: function (jsonData) {
                $('#editModal_record .modal-body').html(jsonData);
                datatable_refresh('#editModal_record #default-datatable');
                $('#editModal_record').modal('show');
                $('#sktPleaseWait').modal('hide');
            },
            error: function (jsonData) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });


    $('.reassignDataList').click(function () {
        sid = $(this).attr('sid');
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo duns_url('reassign_data_agent_modal'); ?>",
            type: "GET",
            data: {record_id: sid},
            dataType: "text",
            success: function (jsonData) {
                $('#editModal_reassing_record .modal-body').html(jsonData);
                datatable_refresh('#editModal_reassing_record #default-datatable');
                $('#editModal_reassing_record').modal('show');
                $('#sktPleaseWait').modal('hide');
            },
            error: function (jsonData) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });


    $('.dataRemarksUpdate').click(function () {
        sid = $(this).attr('sid');
        did = $(this).attr('did');
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo duns_url('my_assign_list_data_modal'); ?>",
            type: "GET",
            data: {record_id: sid, data_id: did, view_type: 'update'},
            dataType: "text",
            success: function (jsonData) {
                startDateTimer = new Date();
                startTimer();
                $('#editModal_record .modal-body').html(jsonData);
                datatable_refresh('#editModal_record #default-datatable');
                $('#editModal_record').modal('show');
                $('#sktPleaseWait').modal('hide');
            },
            error: function (jsonData) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
            }
        });
    });

    $('.viewRemarksUpdate').click(function () {
        sid = $(this).attr('sid');
        did = $(this).attr('did');
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo duns_url('my_assign_list_data_modal'); ?>",
            type: "GET",
            data: {record_id: sid, data_id: did, view_type: 'view'},
            dataType: "text",
            success: function (jsonData) {
                startDateTimer = new Date();
                startTimer();
                $('#editModal_record .modal-body').html(jsonData);
                datatable_refresh('#editModal_record #default-datatable');
                $('#editModal_record').modal('show');
                $('#sktPleaseWait').modal('hide');
            },
            error: function (jsonData) {
                $('#sktPleaseWait').modal('hide');
                alert('Something Went Wrong!');
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

    $("#client_id").change(function () {
        var client_id = $("#client_id").val();
        $('#sktPleaseWait').modal('show');
        $.post("<?= base_url() ?>Duns_crm/get_assign_agent", {client_id: client_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data != '') {
                var dat = JSON.parse(data);
                $('#default_datatable').DataTable().clear().destroy();
                $("#assign_to").html(dat);
            }

        });
        $.post("<?= base_url() ?>Duns_crm/get_client_agent_input", {client_id: client_id}).done(function(dat){
           var dt=JSON.parse(dat);
           var header='<tr class="bg-primary text-white">\
                        <th scope="col" class="text-center">SL</th>\
                        <th class="text-center">Client Name</th>\
                        <th class="text-center">Upload Date</th>\
                        <th class="text-center">Assigned To</th>\
                        <th class="text-center">Assigned Date</th>';
          header+=dt;
          header+='</tr>';
          $("#dat_header").html(header);          
    });
    
    });

//    $(document).on('change','#assign_to',function(){
//
//        var user_id = $(this).val();
//        var client_id = $('#client_id').val();
//
//        var datas = { 'user_id': user_id, 'client_id': client_id }
//        var request_url = "<?php echo base_url('duns_crm/get_assign_wise_data_qc'); ?>";
//
//        process_ajax(function(response)
//        {
//            var res = JSON.parse(response);
//            var header = '<th class="text-center" data-name="client_name">SL</th>"\"';
//            var header_data = '';
//            var column_names = '';
//            if (res.stat == true) {
//                $.each(res.datas,function(index,element)
//                {
//                    header += '<th class="text-center" data-name="client_name">'+element.reference_name+'</th>"\"';
//                    column_names = element.column_name;
//                    alert(column_names);
//
//                    $.each(res.datas2,function(index2,element2)
//                    {
//                        header_data += '<td scope="row" class="text-center">'+element2.column_names+'</td>';
//                    });
//                });
//            }
//
//            $("#dat_header").html(header);
//            $("#dat_header_datas").html(header_data);
//
//        },request_url, datas, 'text');
//
//     //    var htm='<tr class="bg-primary text-white">\
//	     <th scope="col" class="text-center">#</th>\
//         <th class="text-center" data-name="client_name">Client Name<input type="text" class="tab_hed" name="client_name" placeholder="Search client name" /></th>\
//         <th class="text-center" data-name="upload_date">Upload Date<input type="text" class="tab_hed" name="client_name" placeholder="Search client name" /></th>\
//         <th class="text-center" data-name="assigned_to">Assigned To<input type="text" class="tab_hed" name="client_name" placeholder="Search client name" /></th>\
//         <th class="text-center" data-name="assigned_date">Assigned Date<input type="text" class="tab_hed" name="client_name" placeholder="Search client name" /></th>\
//     //  </tr>';
//    });
//=============== STOP WATCH TIMER START =================================================//

    function startTimer() {
        var total_seconds = (new Date() - startDateTimer) / 1000;
        var newTime = new Date(null);
        newTime.setSeconds(total_seconds);
        var result = newTime.toISOString().substr(11, 8);
        $("#editModal_record #timeWatch").html(result);
        $("#editModal_record #time_interval").val(result);
        $("#editModal_record #time_interval_close").val(result);
        setTimeout(function () {
            startTimer()
        }, 1000);
    }
</script>