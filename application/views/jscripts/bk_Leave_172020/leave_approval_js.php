<script>

$(document).ready(function(){

    $("#applied_date").datepicker();

    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;                
            });
            $('#select_all_2').prop('checked', true);
        }else{
             $('.checkbox').each(function(){
                this.checked = false;                
            });
            $('#select_all_2').prop('checked', false);
        }
    });

    $('#select_all_2').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
            $('#select_all').prop('checked', true);
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
            $('#select_all').prop('checked', false);
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all, #select_all_2').prop('checked',true);
        }else{
            $('#select_all, #select_all_2').prop('checked',false);
        }
    });

    get_employee_list($("#dept_id").val());

    $("#dept_id").change(function(){
        get_employee_list($(this).val())
    });

});


function get_employee_list(id){
    if(id!=""){
        $.post("<?php echo base_url()?>leave/get_emlployee_list_based_on_dept", {'id' : id, 'office_id' : $("#location_id").val()}, function(data){
            data = $.parseJSON(data);

            var htm = '<option value="">-- Select --</option>';

            var selected_emp = <?php echo $emp_name; ?>

            $.each(data, function(i,v){  
                sCss = "";
                if(data[i]["id"]==selected_emp) sCss="selected";    
                
                htm += '<option value="'+ data[i]["id"] +'" '+sCss+'>'+ data[i]["fullname"] +'</option>';
            });

            $("#emp_name").empty().append(htm);
        });
    }else{
        var htm = '<option value="">-- Select --</option>';
        <?php foreach($employee_list as $_emp): 
            $sCss="";
            if($_emp->id==$emp_name) $sCss="selected";
        ?>
        htm += '<option value="<?php echo $_emp->id ?>" <?php echo $sCss;?> ><?php echo addslashes($_emp->emp_name) . " (". $_emp->dept_name . ")"; ?></option>';
        <?php endforeach; ?>
        $("#emp_name").empty().append(htm);
    } 
}


function approve_leave(id){
    $.post("<?php echo base_url()?>/leave/set_leave_status",{"id":id, "status_id": 1}, function(){
        location.reload();
    });
}


function reject_leave(id){
    $("#reject_id").val(id);
    $("#rejectLeaveModal").modal('show');
}

function save_reject(){
    reason = $("#reject_reason").val();
    id = $("#reject_id").val();

    if(reason.trim()!=''){
        $.post("<?php echo base_url()?>/leave/set_leave_status",
            {"id":id, "status_id": 2, "reject_reason":reason}, 
            function(){
                location.reload();
            });
    }else{
        alert('Reason for rejection is a required field');
    }
}

function approve_all(){

    form_data = $("form#approve_selected_form").serializeArray();
    var form_datas = {};

    if(form_data.length == 0){
        alert("Please Select Records");
        return false;
    }

    for (var i = 0; i < form_data.length; i++) {     
        if (form_data[i]['name'].endsWith('[]')) {         
            var name = form_data[i]['name'];         
            name = name.substring(0, name.length - 2);         
            if (!(name in form_datas)) {             
                form_datas[name] = [];         
            }         
            
            form_datas[name].push(form_data[i]['value']);     
        } 
        else {         
            form_datas[form_data[i]['name']] = form_data[i]['value'];     
        } 
    }

    $.post("<?php echo base_url() ?>leave/approve_all",form_datas,function(data){
        location.reload();
    });
}







</script>