<script>
$(document).on('click','.it_dashboard_tic_reject',function(){$('#reject_ticket #ticket_id').val($(this).attr('id'));$('#modal_reject').modal('show');$('#reject_ticket #reject_reason').val("");$('#modal_reject #action_ast_name').text($(this).attr('ast_name'));$('#modal_reject #user_name').text($(this).attr('user_name')); $('#modal_reject #tic_show_id').text($(this).attr('ticket_id')); });

$(document).on('submit','#reject_ticket',function(event){
    event.preventDefault();
    var ticket_id = $('#reject_ticket #ticket_id').val();
    var reason = $('#reject_ticket #reject_reason').val();
    var request_url = '<?php echo base_url('it_assets_support/tic_status_update/cancel'); ?>';
    var datas ={'ticket_id': ticket_id, 'reason': reason};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){location.reload();}
        else{alert('Something went wrong')}
    },request_url, datas, 'text');
});

$(document).on('click','.it_dashboard_tic_new_request',function(){
    var assets_id = $(this).attr('assets_id');
    var user_id = $(this).attr('user_id');
    var request_url = '<?php echo base_url('it_assets_support/check_user_assets_details'); ?>';
    var datas ={'assets_id': assets_id, 'user_id': user_id};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){
            if (res.assets_check==true) {
                alert('Something is wrong!');
                $('#model_tic_new_req_stat #tic_stat_new_req').hide();
            }
            else{
                $('#model_tic_new_req_stat #tic_stat_new_req').show();
            }
        }
        else{
            alert('Something is wrong!');
            $('#model_tic_new_req_stat #tic_stat_new_req').hide();
        }
    },request_url, datas, 'text');
    if ($(this).attr('curr_stat') == 4) { $("#model_tic_new_req_stat #action_type option:contains('On Hold/In-progress')").hide(); }
    else { $("#model_tic_new_req_stat #action_type option:contains('On Hold/In-progress')").show(); }
    $('#model_tic_new_req_stat #tic_show_id').text($(this).attr('ticket_id'));
    $('#model_tic_new_req_stat #tic_stat_new_req #ticket_id').val($(this).attr('id'));
    $('#model_tic_new_req_stat #action_ast_name').text($(this).attr('ast_name'));
    $('#model_tic_new_req_stat #user_name').text($(this).attr('user_name'));
    $('#model_tic_new_req_stat #tic_stat_new_req')[0].reset();
    $('#model_tic_new_req_stat').modal('show');
});

$(document).on('submit','#tic_stat_new_req',function(event){
    event.preventDefault();
    var ticket_id = $('#tic_stat_new_req #ticket_id').val();
    var action_type = $('#tic_stat_new_req #action_type').val();
    var reason = $('#tic_stat_new_req #reason').val();
    var request_url = '<?php echo base_url('it_assets_support/tic_status_update/for_new_request'); ?>';
    var datas ={'ticket_id': ticket_id, 'reason': reason, 'action_type': action_type};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){location.reload();}
        else{alert('Something went wrong')}
    },request_url, datas, 'text');
});

$(document).on('click','.it_dashboard_tic_existing_assets',function(){
    var assets_id = $(this).attr('assets_id');
    var user_id = $(this).attr('user_id');
    var request_url = '<?php echo base_url('it_assets_support/check_user_assets_details'); ?>';
    var datas ={'assets_id': assets_id, 'user_id': user_id};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){
            if (res.assets_check==true) {
                if (res.is_inv == true) {
                    $('#tic_stat_existing_assets_req #assets_details_user').html('<div class="col-sm-12"><p style="font-size: medium;font-weight: bold;">User Assets Details: '+res.datas[0].assets_name+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Reference ID:</span> '+res.datas[0].reference_id+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Serial Number:</span> '+res.datas[0].serial_number+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Model Number:</span> '+res.datas[0].model_number+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Assets Details:</span> '+res.datas[0].configuration+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Remarks:</span> '+res.datas[0].reamrks+'</p></div>');
                    $('#tic_stat_existing_assets_req #action_id').html('<option value="" selected>Select a option</option><option value="on_hold">On Hold/In-progress</option><option value="close">Close</option><option value="1">Repair</option><option value="2">Replace</option><option value="3">Return</option><option value="4">Customization (Need HOD Approval)</option>');
                    $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req #is_inv').val(1);
                }
                else {
                    $('#tic_stat_existing_assets_req #assets_details_user').html('<div class="col-sm-12"><p style="font-size: medium;font-weight: bold;">User Assets Name: '+res.datas[0].assets_name+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Assets Details:</span> '+res.datas[0].comments+'</p></div>');
                    $('#tic_stat_existing_assets_req #action_id').html('<option value="" selected>Select a option</option><option value="on_hold">On Hold/In-progress</option><option value="close">Close</option><option value="2">Replace or Change</option><option value="3">Return or close assets</option>');
                    $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req #is_inv').val(2);
                }
                $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req').show();
            }
            else{
                alert('Something is wrong!');
                $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req').hide();
            }
        }
        else{
            alert('Something is wrong!');
            $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req').hide();
        }
    },request_url, datas, 'text');
    if ($(this).attr('curr_stat') == 4) { $("#model_tic_existing_assets_req_stat #action_id option:contains('On Hold/In-progress')").hide(); }
    else { $("#model_tic_existing_assets_req_stat #action_id option:contains('On Hold/In-progress')").show(); }
    $('#model_tic_existing_assets_req_stat #tic_show_id').text($(this).attr('ticket_id'));
    $('#model_tic_existing_assets_req_stat #new_assets_details_replace_action').html('');
    $('#model_tic_existing_assets_req_stat #assets_action_type_check').html('');
    $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req #ticket_id').val($(this).attr('id'));
    $('#model_tic_existing_assets_req_stat #action_ast_name').text($(this).attr('ast_name'));
    $('#model_tic_existing_assets_req_stat #user_name').text($(this).attr('user_name'));   
    $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req')[0].reset();
    $('#model_tic_existing_assets_req_stat').modal('show');
});

$(document).on('submit','#tic_stat_existing_assets_req',function(event){
    event.preventDefault();
    var ticket_id = $('#tic_stat_existing_assets_req #ticket_id').val();
    var action_type = $('#tic_stat_existing_assets_req #action_id').val();
    var reason = $('#tic_stat_existing_assets_req #reason').val();
    var assets_serial_number = $('#tic_stat_existing_assets_req #assets_serial_number').val();
    var request_url = '<?php echo base_url('it_assets_support/tic_status_update/for_existing_assets_request'); ?>';
    var datas ={'ticket_id': ticket_id, 'reason': reason, 'action_type': action_type, 'stock_id': assets_serial_number};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){location.reload();}
        else{alert('Something went wrong')}
    },request_url, datas, 'text');
});

$(document).on('change','#tic_stat_existing_assets_req #action_id',function(){
    var action_id = $(this).val();
    var ticket_id = $('#tic_stat_existing_assets_req #ticket_id').val();
    if (action_id != '' && ticket_id != '') {
        if (action_id==2) {
            var inv_check = $('#tic_stat_existing_assets_req #is_inv').val();
            if (inv_check == 1) {
                var request_url = '<?php echo base_url('it_assets_support/get_inv_assets_stock_details'); ?>';
                datas ={'ticket_id': ticket_id}
                process_ajax(function(response)
                {
                    var options = '<option value="" selected>Select a option</option>';
                    var res = JSON.parse(response);
                    if (res.stat==true){
                        $.each(res.datas,function(index,element) {
                            options += '<option value="'+element.id+'">'+element.serial_number+' ('+element.reference_id+')</option>';
                        });
                    }
                    else{alert('No Stock Found');}
                    $('#model_tic_existing_assets_req_stat #assets_action_type_check').html('<div class="form-group"><label>Assets Serial Number<span style="color: red;">*</span></label><select id="assets_serial_number" class="form-control" name="assets_serial_number" required>'+options+'</select></div>');
                },request_url, datas, 'text');
            }
            else if(inv_check == 2){ alert('Non Inventory Asset. Please Put Replace Details in Reason Box.') }
            else { alert('Something is wrong'); $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req').hide();}
        }
        else {
            $('#model_tic_existing_assets_req_stat #assets_action_type_check').html('');
        }
    }
    else {
        alert('Something is wrong!');
        $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req').hide(); 
    }
});

$(document).on('change','#tic_stat_existing_assets_req #assets_serial_number',function(){
    var stock_id = $(this).val();
    var request_url = '<?php echo base_url('it_assets_support/get_stock_id_details'); ?>';
    var datas = {'stock_id': stock_id};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){
            $('#tic_stat_existing_assets_req #new_assets_details_replace_action').html('<div class="col-sm-12"><p style="font-size: medium;font-weight: bold;">New Assets Details: '+res.datas[0].assets_name+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Reference ID:</span> '+res.datas[0].reference_id+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Serial Number:</span> '+res.datas[0].serial_number+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Model Number:</span> '+res.datas[0].model_number+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Assets Details:</span> '+res.datas[0].configuration+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Remarks:</span> '+res.datas[0].reamrks+'</p></div>');
        }
        else{
            alert('Something is wrong');
            $('#model_tic_existing_assets_req_stat #tic_stat_existing_assets_req').hide();
        }
    },request_url, datas, 'text');
});

</script>

<script>
$(document).on('click','.tic_existing_assets_customization',function(){
    var assets_id = $(this).attr('assets_id');
    var user_id = $(this).attr('user_id');
    var request_url = '<?php echo base_url('it_assets_support/check_user_assets_details'); ?>';
    var datas ={'assets_id': assets_id, 'user_id': user_id};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){
            if (res.assets_check==true) {
                $('#model_tic_existing_assets_customization #tic_existing_assets_customization').show();
                var request_url = '<?php echo base_url('it_assets_support/get_assets_master_data'); ?>';
                process_ajax(function(response)
                {
                    var options_storage = '<option value="">Select a Option</option>'; 
                    var options_os = '<option value="">Select a Option</option>'; 
                    var options_ram = '<option value="">Select a Option</option>'; 
                    var sel_ssd =''; 
                    var sel_hdd ='';

                    var res2 = JSON.parse(response);

                    $.each(res2.datas_storage,function(index,element) {
                        if(res.datas[0].storage_device_id == element.id) { var sel = "selected"; }
                        else { var sel = ""; }
                        options_storage += '<option value="'+element.id+'" '+sel+'>'+element.size+'</option>';
                    });
                    $.each(res2.datas_os,function(index,element) {
                        if(res.datas[0].os_id == element.id) { var sel = "selected"; }
                        else { var sel = ""; }
                        options_os += '<option value="'+element.id+'" '+sel+'>'+element.os_name+'</option>';
                    });
                    $.each(res2.datas_ram,function(index,element) {
                        if(res.datas[0].ram_id == element.id) { var sel = "selected"; }
                        else { var sel = ""; }
                        options_ram += '<option value="'+element.id+'" '+sel+'>'+element.size+'</option>';
                    });

                   $('#tic_existing_assets_customization #stock_storage').html(options_storage);
                   $('#tic_existing_assets_customization #stock_os').html(options_os);
                   $('#tic_existing_assets_customization #stock_ram').html(options_ram);

                   if (res.datas[0].storage_device_type ==1) { var sel_ssd = 'selected'; }
                   else if (res.datas[0].storage_device_type ==2) { var sel_hdd = 'selected'; }
                   $('#tic_existing_assets_customization #stock_storage_type').html('<option value="">Select a Option</option><option value="1" '+sel_ssd+'>SSD</option><option value="2" '+sel_hdd+'>HDD</option>');
                   $('#tic_existing_assets_customization #stock_conf_details').html('<input type="text" class="form-control" maxlength="1000" id="stock_conf_val" name="stock_conf_details" value="'+res.datas[0].configuration+'">');

                   $('#tic_existing_assets_customization #assets_id').val(res.datas[0].assets_id);
                   $('#tic_existing_assets_customization #old_stock_id').val(res.datas[0].id);

                },request_url, datas, 'text');
            }
            else{
                alert('Something is wrong!');
                $('#model_tic_existing_assets_customization #tic_existing_assets_customization').hide();
            }
        }
        else{
            alert('Something is wrong!');
            $('#model_tic_existing_assets_customization #tic_existing_assets_customization').hide();
        }
    },request_url, datas, 'text');
    $('#model_tic_existing_assets_customization #tic_show_id').text($(this).attr('ticket_id'));
    $('#model_tic_existing_assets_customization #tic_existing_assets_customization #ticket_id').val($(this).attr('id'));
    $('#model_tic_existing_assets_customization #action_ast_name').text($(this).attr('ast_name'));
    $('#model_tic_existing_assets_customization #user_name').text($(this).attr('user_name'));
    $('#model_tic_existing_assets_customization #tic_existing_assets_customization')[0].reset();
    $('#model_tic_existing_assets_customization').modal('show');
});

$(document).on('submit','#tic_existing_assets_customization',function(event){
    event.preventDefault();
    var ticket_id = $('#tic_existing_assets_customization #ticket_id').val();
    var assets_id = $('#tic_existing_assets_customization #assets_id').val();
    var stock_id = $('#tic_existing_assets_customization #old_stock_id').val();
    var stock_ram = $('#tic_existing_assets_customization #stock_ram').val();
    var stock_storage_type = $('#tic_existing_assets_customization #stock_storage_type').val();
    var stock_storage = $('#tic_existing_assets_customization #stock_storage').val();
    var stock_os = $('#tic_existing_assets_customization #stock_os').val();
    var stock_conf_details = $('#tic_existing_assets_customization #stock_conf_val').val();
    var reason = $('#tic_existing_assets_customization #reason').val();
    var request_url = '<?php echo base_url('it_assets_support/tic_customization_stock_update'); ?>';
    var datas ={'ticket_id': ticket_id, 'assets_id': assets_id, 'stock_id': stock_id, 'stock_ram': stock_ram, 'stock_storage_type': stock_storage_type, 'stock_storage': stock_storage, 'stock_os': stock_os, 'stock_conf_details': stock_conf_details, 'reason': reason};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){location.reload();}
        else{alert('Something went wrong')}
    },request_url, datas, 'text');
});

</script>

<script>
$(document).on('click','.tic_new_assets_assign',function(){
    var assets_id = $(this).attr('assets_id');
    var user_id = $(this).attr('user_id');
    var tic_id = $(this).attr('id');
    var request_url = '<?php echo base_url('it_assets_support/check_user_assets_details'); ?>';
    var datas = {'assets_id': assets_id, 'user_id': user_id};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){
            if (res.assets_check==true) {
                alert('Something is wrong!');
                $('#model_tic_new_assets_assign #tic_new_assets_assign_form').hide();
            }
            else{
                $('#model_tic_new_assets_assign #tic_new_assets_assign_form').show();
                if (res.is_inv==true) {
                    var datas2 = {'ticket_id': tic_id};
                    var request_url = '<?php echo base_url('it_assets_support/get_inv_assets_stock_details'); ?>';
                    process_ajax(function(response)
                    {
                        var res2 = JSON.parse(response);
                        var options = '<option value="" selected>Select a Option</option>';
                        if (res2.stat==true){
                            $.each(res2.datas,function(index,element) {
                                options += '<option value="'+element.id+'">'+element.serial_number+' ('+element.reference_id+')</option>';
                            });
                            $('#tic_new_assets_assign_form #assign_assets_details_input').html('<div class="col-sm-6"><div class="form-group"><label>Select a new assets</label><select class="form-control" name="stock_id" id="stock_id" required>'+options+'</select></div></div>');
                        }
                        else{
                            alert('Out Of Stock');
                            $('#model_tic_new_assets_assign #tic_new_assets_assign_form').hide();
                        }
                    },request_url, datas2, 'text');
                }
                else if(res.is_inv==false){
                    $('#tic_new_assets_assign_form #assign_assets_details_input').html('<div class="col-sm-6"><div class="form-group"><label>Enter Assets Details</label><input class="form-control" name="assets_detail" id="assets_detail" placeholder="Enter assets Details" required></div></div>');
                }
                else {
                    alert('Something is wrong!');
                    $('#model_tic_new_assets_assign #tic_new_assets_assign_form').hide();
                }
            }
        }
        else{
            alert('Something is wrong!');
            $('#model_tic_new_assets_assign #tic_new_assets_assign_form').hide();
        }
    },request_url, datas, 'text');
    $("#model_tic_new_assets_assign #Stock_details_new_assets").html('');
    $('#model_tic_new_assets_assign #tic_show_id').text($(this).attr('ticket_id'));
    $('#model_tic_new_assets_assign #tic_new_assets_assign_form #ticket_id').val($(this).attr('id'));
    $('#model_tic_new_assets_assign #action_ast_name').text($(this).attr('ast_name'));
    $('#model_tic_new_assets_assign #user_name').text($(this).attr('user_name'));
    $('#model_tic_new_assets_assign #tic_new_assets_assign_form')[0].reset();
    $('#model_tic_new_assets_assign').modal('show');
});

$(document).on('change','#model_tic_new_assets_assign #tic_new_assets_assign_form #stock_id',function(){
    var stock_id = $(this).val();
    var request_url = '<?php echo base_url('it_assets_support/get_stock_id_details'); ?>';
    var datas = {'stock_id': stock_id};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){
            $('#tic_new_assets_assign_form #Stock_details_new_assets').html('<div class="col-sm-12"><p style="font-size: medium;font-weight: bold;">New Assets Details: '+res.datas[0].assets_name+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Reference ID:</span> '+res.datas[0].reference_id+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Serial Number:</span> '+res.datas[0].serial_number+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Model Number:</span> '+res.datas[0].model_number+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Assets Details:</span> '+res.datas[0].configuration+'</p></div><div class="col-sm-6"><p><span style="font-weight:bold;">Remarks:</span> '+res.datas[0].reamrks+'</p></div>');
        }
        else{
            alert('Something is wrong');
            $('#model_tic_new_assets_assign #tic_new_assets_assign_form').hide();
        }
    },request_url, datas, 'text');
});

$(document).on('submit','#tic_new_assets_assign_form',function(event){
    event.preventDefault();
    var ticket_id = $('#tic_new_assets_assign_form #ticket_id').val();
    var reason = $('#tic_new_assets_assign_form #reason').val();
    var assets_detail = $('#tic_new_assets_assign_form #assets_detail').val();
    var stock_id = $('#tic_new_assets_assign_form #stock_id').val();
    var request_url = '<?php echo base_url('it_assets_support/tic_new_assets_assign'); ?>';
    var datas ={'ticket_id': ticket_id, 'assets_detail': assets_detail, 'stock_id': stock_id, 'reason' : reason};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        if (res.stat==true){location.reload();}
        else{alert('Something went wrong')}
    },request_url, datas, 'text');
});
    
</script>

<script>
$(document).on('click','.view_ticket_his',function(){
    var ticket_id = $(this).attr('id');
    var request_url = '<?php echo base_url('it_assets_support/tic_view_history'); ?>';
    var datas ={'ticket_id': ticket_id};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        var tracker = "";
        if (res.stat==true){

            $.each(res.datas,function(index,element) {
                if (element.status_id==1) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Pending</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }
                else if (element.status_id==4) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">On Hold / In-progress</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }
                else if (element.status_id==5 && element.hod_approval == null) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">IT Action</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }
                else if (element.status_id==8 && element.hod_approval == 1) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">HOD Approved</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>';
                }
                else if (element.status_id==6 && element.hod_approval == 2) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">HOD Approved Rejected</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }           
                else if(element.status_id == 7) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Closed</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }
                else if(element.status_id == 2) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Rejected</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>';
                }
                else if(element.status_id == 3) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Canceled</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>';
                }

            });
            if (res.datas[0].status == 1 || res.datas[0].status == 4) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">IT Action</div> </div>  ';
            }
            else if(res.datas[0].status == 5 && res.datas[0].hod_approval == null) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">HOD Approval Pending</div></div> ';
            }

            if (res.datas[0].status == 5 && res.datas[0].hod_approval == 1 && res.datas[0].req_type == 1) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">New Assets Assign Pending</div></div> ';
            }

            if (res.datas[0].status == 5 && res.datas[0].hod_approval == 1 && res.datas[0].req_type == 2 && res.datas[0].it_action == 4) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Customization Under Process</div></div> ';
            }            

            if(res.datas[0].status != 7 && res.datas[0].status != 2 && res.datas[0].status != 3) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Close</div></div> ';
            }

            $('#modal_track #tracker_view_his').html(tracker);
        }
        else{alert('Something went wrong')}
    },request_url, datas, 'text');
    $('#modal_track').modal('show');


});



$("#all_chk").click(function(){
   if ($("#all_chk").is(':checked')) 
        {
            $('#hod').css('display','block'); 
            $('#amc').css('display','block'); 
            $('#amc1').css('display','block');
            
            $("input[name=record1]").each(function () {
                $(this).prop("checked", true);
            });

        } 
        else 
        {
            $('#hod').css('display','none'); 
            $('#amc').css('display','none'); 
            $('#amc1').css('display','none');
            $("input[name=record1]").each(function () {
                $(this).prop("checked", false);
            });        
        }
});



$(document).on('click','.all_chk',function()

    {
        var chk=0;
        $(".all_chk").each(function() {
            if($(this).prop('checked') == true){
                
                chk=1;
                
            }
        });
        if(chk==1){
            $('#hod').css('display','block'); 
            $('#amc').css('display','block'); 
            $('#amc1').css('display','block');

        }else{
            $('#hod').css('display','none'); 
            $('#amc').css('display','none'); 
            $('#amc1').css('display','none');
            
        }

    });

$("#all_chk1").click(function(){
   if ($("#all_chk1").is(':checked')) 
        {
            $('#amc').css('display','block'); 
            $('#amc1').css('display','block'); 
            $("input[name=record1]").each(function () {
                $(this).prop("checked", true);
            });

        } 
        else 
        {
            $('#amc').css('display','none'); 
            $('#amc1').css('display','none'); 
            $("input[name=record1]").each(function () {
                $(this).prop("checked", false);
            });        
        }
});

</script>

<script type="text/javascript">

       function change_sts_active(val)
        {
           
            var pro_ids =[];
            $.each($("input[name='record1']:checked"), function()
            {            
                pro_ids.push($(this).val());
                console.log('1');
            });
            var base_url='<?php echo base_url(); ?>';
            if(pro_ids.length>0)
            {

                $.ajax({
              
                url:base_url+'index.php/It_assets_support/amc_update_value',
                data:{pid:pro_ids},
                dataType: "json",
                type: "POST",
                success: function(data){
                    //console.log(data);
                var perform= data.changedone;
                    if(perform==1)
                    {
                        swal("Item Has been send  "," Succfully","success");
                        //$("#amc_portion").load(location.href + "#amc_portion");
                        location.reload();
                    }
                
                  }
                });
            }
            else
            {
                alert('Sorry!! please select any records');
            }
        }

    </script>

<script type="text/javascript">

function change_approve_active(val)
 {
     var pro_ids =[];
     $.each($("input[name='record1']:checked"), function()
     {            
         pro_ids.push($(this).val());
         //console.log('1');
     });
     var base_url='<?php echo base_url(); ?>';
     if(pro_ids.length>0)
     {

         $.ajax({
       
         url:base_url+'index.php/It_assets_support/amc_update_active',
         data:{pid:pro_ids},
         dataType: "json",
         type: "POST",
         success: function(data){
            console.log(data);
         var perform= data.changedone;
             if(perform==1)
             {
                 swal("Item Has been send  "," Succfully","success");
                 //$("#hod_portion").load(location.href + " #hod_portion");
                 location.reload();
             }
         
           }
         });
     }
     else
     {
         alert('Sorry!! please select any records');
     }
 }
 function change_reject_active(val)
 {
     var pro_ids =[];
     $.each($("input[name='record1']:checked"), function()
     {            
         pro_ids.push($(this).val());
         //console.log('1');
     });
     var base_url='<?php echo base_url(); ?>';
     if(pro_ids.length>0)
     {

         $.ajax({
       
         url:base_url+'index.php/It_assets_support/amc_update_reject',
         data:{pid:pro_ids},
         dataType: "json",
         type: "POST",
         success: function(data){
            
         var perform= data.changedone;
             if(perform==1)
             {
                 swal("Status has been submited  "," Succfully","error");
                 //$("#hod_portion").load(location.href + " #hod_portion");
                 location.reload();
             }
         
           }
         });
     }
     else
     {
         alert('Sorry!! please select any records');
     }
 }

 function myFunction(val)
 {
    $('#amc_val').val(val);
   
    $('#myModal-newt').modal('show');


    


 }
 $("#submit").click(function(){

    var str_date = $('#start_date').val();
    var amc_val = $('#amc_val').val();
   
    var base_url='<?php echo base_url(); ?>';
    $.ajax({
       
       url:base_url+'index.php/It_assets_support/amc_update_date',
       data:{pid:amc_val,str_date:str_date},
       dataType: "json",
       type: "POST",
       success: function(data){
      //alert(data);   
       var perform= data.changedone;
           if(perform==1)
           {
               swal("AMC Date Has been submited  "," Succfully","success");
               $("#hod_portion").load(location.href + " #hod_portion");
               $('#myModal-newt').modal('hide');
           }
       
         }
       });

 });
</script>