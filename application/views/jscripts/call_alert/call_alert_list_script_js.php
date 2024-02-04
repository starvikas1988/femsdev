<script>
   function make_pending(id,status){
       // alert(id+'====='+status);
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>Call_alert/update_status',
            data:'id='+id+'&status='+status,
            success:function(res){
                if(res==1){
                    alert('Data Updated Successfully');
                    location.reload();
                }
            }

        });
        
    }
    
    function change_data(id){
        //alert(id);
        $('#call_alert_id').val(id);
        $('#upload_doc_form').modal('show');
    }
    $(document).ready(function (e) {
    $("#frmdoc").on('submit',(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    
        $.ajax({
            url: '<?php echo base_url(); ?>Call_alert/upload_docs_file',
            type: 'POST',
            data:  data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res)
            {
                if(res=='failed'){
                    $('#msg_rest').html('Failed');
                }else{
                $('#doc').val('');
                $('#comments').val('');
                alert('Successfully Done');
                location.reload();
                }
            }
        });   
       
    }));
});
function check_size(id){
	dt=$(id).val();
	var size = id.files[0].size;
        if(size>2000000){
            alert('File should not be greater than 2 MB ');
            $(id).val('');
        }
}
function close_all(typ){
    //alert(typ);
    $('.all_check').each(function(){  
        checkboxes = $('input[name="call_alert_id[]"]');  
        $checked = checkboxes.filter(":checked"),
        checkedValues = $checked.map(function () {
        return this.value;
        }).get();
    });
    data='typ='+typ+'&call_alert_ids='+checkedValues

    $.ajax({
            url: '<?php echo base_url(); ?>Call_alert/close_multi',
            type: 'get',
            data:  data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res)
            {
                if(res=='failed'){
                    alert('Oops,somthing went wrong');
                    //location.reload();
                }else{
                alert('Successfully Done');
                location.reload();
                }
            }
    });
    
    //alert(checkedValues);
}
function delete_data(id){
    data='id='+id;
    var result = confirm('Do you want to perform this action?');
    if(result){
        $.ajax({
            url: '<?php echo base_url(); ?>Call_alert/delete_Call_alert',
            type: 'get',
            data:  data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res)
            {
                if(res=='failed'){
                    alert('Oops,somthing went wrong');
                    //location.reload();
                }else{
                alert('Successfully Done');
                location.reload();
                }
            }
        });
    }       
}
function close_data(id){
    data='call_alert_id='+id;
    var result = confirm('Do you want to perform this action?');
    if(result){
        $.ajax({
            url: '<?php echo base_url(); ?>Call_alert/call_alert_close',
            type: 'get',
            data:  data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res)
            {
                if(res=='failed'){
                    alert('Oops,somthing went wrong');
                    //location.reload();
                }else{
                alert('Successfully Done');
                location.reload();
                }
            }
        });
    }       
}
</script>    