<script>
$(document).ready(function(){

    $(".query_str").val(window.location.search);

    $("#department").change(function(){
        if($(this).val() !=""){

            $.post("<?php echo base_url()?>master/get_sub_department_list",{id:$(this).val()}, function(data){
                $("#sub-department").empty().html('<option value=""></option>').append(data);
            });
        }        
    }); 


    // add multiple select / deselect functionality
    $("#select_all").change(function(){  //"select all" change 
        $(".inverted_checkboxes").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
    });

	//".checkbox" change 
    $('.inverted_checkboxes').change(function(){ 
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(false == $(this).prop("checked")){ //if this item is unchecked
            $("#select_all").prop('checked', false); //change "select all" checked status to false
        }
        //check "select all" if all checkbox items are checked
        if ($('.inverted_checkboxes:checked').length == $('.inverted_checkboxes').length ){
            $("#select_all").prop('checked', true);
        }
    });


});


function grant_leave_access(user_id, username){
    $.post("<?php echo base_url()?>master/get_grant_leave_access_details", {user_id:user_id}, function(data){
        
        $("#leave-user_id").val(user_id);
        $(".query_str").val(window.location.search);

        data = $.parseJSON(data);
        
        $.each(data, function(i,v){
            lc_id = data[i].leave_criteria_id;
            $("select#id_"+lc_id).val(data[i].leave_access_allowed);
            $("#record_"+lc_id).val(data[i].id);
        });

        $("#leave-user-assignment").find("h5#user-name").empty().text(username);
        $("#leave-user-assignment").modal('show');
    });
}

function operation_t(t_id){
    $("#operation_type").val(t_id);
    $("form#operation_leave_access_to_selected").submit();
}




</script>