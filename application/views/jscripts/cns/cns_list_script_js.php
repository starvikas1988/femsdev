<script>
   function make_pending(id,status){
       // alert(id+'====='+status);
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>cns/update_status',
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
        $('#cns_id').val(id);
        $('#upload_doc_form').modal('show');
    }
    $(document).ready(function (e) {
    $("#frmdoc").on('submit',(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    
        $.ajax({
            url: '<?php echo base_url(); ?>cns/upload_docs_file',
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
function delete_data(id){
    data='id='+id;
    var result = confirm('Do you want to perform this action?');
    if(result){
        $.ajax({
            url: '<?php echo base_url(); ?>cns/delete_cns',
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