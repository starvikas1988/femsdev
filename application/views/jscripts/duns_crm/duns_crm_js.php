<!--
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
-->

<!--start new js library-->
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.colVis.min.js"></script>

<script>
	$(document).ready(function() {
    var table = $('#table_list').DataTable( {
        lengthChange: false,
        buttons: [ '', 'excel', '', '' ]
    } );
 
    table.buttons().container()
        .appendTo( '#table_list_wrapper .col-sm-6:eq(0)' );
});
</script>

<!--end new js library-->

<script>

    $('.oldDatePick').datepicker({dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString()});
    $('.qcDatePick').datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString()});
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
        c_idd = $(this).attr('c_idd');
        $('#sktPleaseWait').modal('show');
        $.ajax({
            url: "<?php echo duns_url('reassign_data_agent_modal'); ?>",
            type: "GET",
            data: {record_id: sid, client_id: c_idd},
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
        $('.modal-title').html('Add Data');
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
        $('.modal-title').html('View Data');
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
        var request_url = "<?= base_url() ?>duns_crm/get_assign_agent";
        var datas = { client_id: client_id };
        process_ajax(function(response)
        {
            var res = JSON.parse(response);
            $("#assign_to").html(res);
                            
        },request_url, datas, 'text');



        
        // $('#sktPleaseWait').modal('show');
        // $.post("<?= base_url() ?>Duns_crm/get_assign_agent", {client_id: client_id}).done(function (data) {
        //     $('#sktPleaseWait').modal('hide');
        //     if (data != '') {
        //         var dat = JSON.parse(data);
        //         console.log(dat);
        //         //$('#default_datatable').DataTable().clear().destroy();
                
        //     }

        // });
        // $.post("<?= base_url() ?>Duns_crm/get_client_agent_input", {client_id: client_id}).done(function(dat){
        //    var dt=JSON.parse(dat);
        //    var header='<tr>\
        //                 <th>SL</th>\
        //                 <th>Client Name</th>\
        //                 <th>Upload Date</th>\
        //                 <th>Assigned To</th>\
        //                 <th>Assigned Date</th>';
        //   header+=dt;
        //   header+='</tr>';
        //   $("#dat_header").html(header);          
        // });
    
    });


    $(document).on('change', '#reassignList', function () {
        sid = $(this).val();
        record_id = $("#record_id").val();
        client_id_hidden = $("#client_id_hidden").val();
        // alert(client_id_hidden); exit;

        $.ajax({
            url: "<?php echo duns_url('reassign_data_agent_modal'); ?>",
            type: "GET",
            data: {assigned_to: sid, record_id: record_id, client_id: client_id_hidden},
            dataType: "text",
            // success: function (jsonData) {
            //     var alrt = JSON.parse(jsonData);
            //     var j = 1;
            //     $('#tableBody').empty();
            //    //  $('#table_data').empty();

            //    // $('#table_data').append('<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%" style="margin-bottom:0px;"><thead><tr class="bg-info"><th class="text-center"><input type="checkbox" id="selectAllChekcbox" name="selectAllChekcbox" class="selectAllChekcbox reassign"value="1"></th><th class="text-center">Sl</th><th class="text-center">Fusion ID</th><th>Agent Name</th><th>Department</th><th>Action</th></tr></thead><tbody id="tableBody"></tbody></table>');

            //     for (var i in alrt.agent_list){
            //         $('#tableBody').append('<tr class="tableHead"><td class="text-center"><input type="checkbox" name="select_agent[]" class="selectUserChekcbox" value="'+alrt.agent_list[i].id+'"></td><td class="text-center">'+j+'</td><td class="text-center">'+alrt.agent_list[i].fusion_id+'</td><td>'+alrt.agent_list[i].fullname+'</td><td>'+alrt.agent_list[i].department_name+'</td></tr>');
            //         j=j+1;
            //     }
            //     for (var k in alrt.assignedAgentCnt){
            //         $('#assignedAgentCnt').val(alrt.assignedAgentCnt[k].assignedAgentCnt);
            //     }
            // }

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



    //  $('.reassignDataList').click(function () {
    //     sid = $(this).attr('sid');
    //     $('#sktPleaseWait').modal('show');
    //     $.ajax({
    //         url: "<?php echo duns_url('reassign_data_agent_modal'); ?>",
    //         type: "GET",
    //         data: {record_id: sid},
    //         dataType: "text",
    //         success: function (jsonData) {
    //             $('#editModal_reassing_record .modal-body').html(jsonData);
    //             datatable_refresh('#editModal_reassing_record #default-datatable');
    //             $('#editModal_reassing_record').modal('show');
    //             $('#sktPleaseWait').modal('hide');
    //         },
    //         error: function (jsonData) {
    //             $('#sktPleaseWait').modal('hide');
    //             alert('Something Went Wrong!');
    //         }
    //     });
    // });



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