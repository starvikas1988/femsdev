<script>
    $( "#add_button" ).click(function() {
       loc=$('#location_access').val();
       fusion_id=$('#fusion_id').val();
       $('#add_button').attr('disabled','true');
       if(loc!=''){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>/call_alert/add_location_access',
                data:'location='+loc+'&fusion_id='+fusion_id,
                success:function(res){
                    //alert(res);
                    if(res==1){
                        alert('Data added successfully');
                        location.reload();
                    }else{
                        alert('Sorry somthing want wrong');
                    }
                    $('#add_button').attr('disabled','false');
                }
            });
       }else{
           alert('Please enter location');
       }
      
    });
    $( "#edit_button" ).click(function() {
       loc=$('#location_edit').val();
       fusion_id=$('#fusion_id_edit').val();
       notify_date=$('#fusion_id_edit').val();
       $('#edit_button').attr('disabled','true');
       ids=$('#edit_id').val();
       if(loc!=''){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>/call_alert/edit_location_access',
                data:'location='+loc+'&id='+ids+'&fusion_id='+fusion_id,
                success:function(res){
                    //alert(res);
                    if(res==1){
                        alert('Data Updated Successfully');
                        location.reload();
                    }else{
                        alert('Sorry somthing want wrong');
                    }
                    $('#edit_button').attr('disabled','true');
                }
            });
       }else{
           alert('Please enter location');
       }
    });

    
    
    function delete_Call_alert_location_access(id){
        $('#id').val(id);
        ids=id;
        var result = confirm('Do you want to perform this action?');
        if(result){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/call_alert/delete_location_access',
                data:'id='+ids,
                success:function(res){
                    if(res==1){
                        alert('Data Deleted Successfully');
                    location.reload();
                    }
                }
            });
        }    
    }
</script>    