<script>
    $( "#add_button" ).click(function() {
       loc=$('#location').val();
       email1=$('#email1').val();
       notify_date=$('#notify_date').val();
       super_email=$('#super_email').val();
       notify_date2=$('#notify_date2').val();
       if(loc!=''){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/cns/add_location',
                data:'location='+loc+'&email1='+email1+'&notify_date='+notify_date+'&super_email='+super_email+'&notify_date2='+notify_date2,
                success:function(res){
                    //alert(res);
                    if(res==1){
                        alert('Data added successfully');
                        location.reload();
                    }
                    if(res==2){
                        alert('Duplicate Entry Not Allowed');
                    }
                    if((res!=1)&&(res!=2)){
                        alert('Sorry somthing want wrong');
                    }
                }
            });
       }else{
           alert('Please enter location');
       }
    });
    $( "#edit_button" ).click(function() {
       loc=$('#edit_location').val();
       email1=$('#edit_email1').val();
       notify_date=$('#edit_notify_date').val();
       super_email=$('#edit_super_email').val();
       notify_date2=$('#edit_notify_date2').val();
       ids=$('#edit_id').val();
       if(loc!=''){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/cns/edit_location',
                data:'location='+loc+'&id='+ids+'&email1='+email1+'&notify_date='+notify_date+'&super_email='+super_email+'&notify_date2='+notify_date2,
                success:function(res){
                    //alert(res);
                    if(res==1){
                        alert('Data Updated Successfully');
                        location.reload();
                    }if(res==2){
                        alert('Duplicate Entry Not Allowed');
                    }if((res!=1)&&(res!=2)){
                        alert('Sorry somthing want wrong');
                    }
                }
            });
       }else{
           alert('Please enter location');
       }
    });

    function get_cns_location_data(id,name,email1,notify1,email2,notify2){
        $('#edit_id').val(id);
        $('#edit_location').val(name);
        $('#edit_email1').val(email1);
        $('#edit_notify_date').val(notify1);
        $('#edit_super_email').val(email2);
        $('#edit_notify_date2').val(notify2);
    }

    function delete_cns_location(id,name,status){
        //$('#id').val(id);
        //$('#location').val(name);
        
        ids=id;
        var result = confirm('Do you want to perform this action?');
        if(result){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/cns/delete_location',
                data:'id='+ids+'&status='+status,
                success:function(res){
                    if(res==1){
                        alert('Status Updated Successfully');
                    location.reload();
                    }
                }
            });
        }    
    }
</script>    