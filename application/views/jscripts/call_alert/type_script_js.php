<script>
    $( "#add_button" ).click(function() {
       typ=encodeURIComponent($('#type').val());
       if(typ!=''){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/Call_alert/add_type',
                data:'type='+typ,
                success:function(res){
                    //alert(res);
                    if(res==1){
                        alert('Data added successfully');
                        location.reload();
                    }
                    if(res==2){
                        alert('Duplicate Entry Not Allowed');
                    }if((res!=1)&&(res!=2)){
                        alert('Sorry somthing went wrong');
                    }
                }
            });
       }else{
           alert('Please enter type');
       }
    });
    $( "#edit_button" ).click(function() {
       typ=encodeURIComponent($('#edit_type').val());
       ids=$('#edit_id').val();
      
       if(typ!=''){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/Call_alert/edit_type',
                data:'type='+typ+'&id='+ids,
                dataType: 'text',
                success:function(res){
                    //alert(res);
                    if(res==1){
                        alert('Data Updated Successfully');
                        location.reload();
                    }if(res==2){
                        alert('Duplicate Entry Not Allowed');
                    }if((res!=1)&&(res!=2)){
                        alert('Sorry somthing went wrong');
                    }
                }
            });
       }else{
           alert('Please enter type');
       }
    });
    function get_Call_alert_type_data(id,name){
        
        $('#edit_id').val(id);
        $('#edit_type').val(name);
    }
    function delete_Call_alert_type(id,status){
        ids=id;
        var result = confirm('Do you want to perform this action?');
        if(result){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/Call_alert/delete_type',
                data:'id='+ids+'&status='+status,
                dataType: 'text',
                success:function(res){
                    if(res==1){
                        alert('Status Change Successfully');
                    location.reload();
                    }
                }
            });
        }    
    }
</script>    