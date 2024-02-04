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
    
    function change_status(id,cnsid,status){
        $('#cns_id').val(cnsid);
        $('#id').val(id);
        $('#status').val(status);
        $('#approve_status_form').modal('show');
    }
    $(document).ready(function (e) {
    $("#frmdoc").on('submit',(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    
        $.ajax({
            url: '<?php echo base_url(); ?>cns/approve_status',
            type: 'POST',
            data:  data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res)
            {
                if(res=='failed'){
                    alert('Failed');
                }else{
                //$('#doc').val('');
                $('#comments').val('');
                alert('Successfully Done');
                location.reload();
                }
            }
        });   
       
    }));
});
</script>    