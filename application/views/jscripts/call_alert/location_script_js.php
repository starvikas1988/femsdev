<script>
    $( "#add_button" ).click(function() {
       loc=$('#location').val();
       email1=$('#email1').val();
       notify_date=$('#notify_date').val();
       notify_time=$('#notify_time').val();
       super_email=$('#super_email').val();
       notify_date2=$('#notify_date2').val();
       super_notify_time=$('#super_notify_time').val();
       duration=$('#duration').val();
       duration_type=$('#duration_type').val();
       if(loc!=''){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/Call_alert/add_location',
                data:'location='+loc+'&email1='+email1+'&notify_date='+notify_date+'&super_email='+super_email+'&notify_date2='+notify_date2+'&notify_time='+notify_time+'&super_notify_time='+super_notify_time+'&duration='+duration+'&duration_type='+duration_type,
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
       edit_notify_time=$('#edit_notify_time').val();
       edit_notify_time2=$('#edit_notify_time2').val();
       duration_edit=$('#duration_edit').val();
       duration_type_edit=$('#duration_type_edit').val();
       ids=$('#edit_id').val();
       if(loc!=''){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/Call_alert/edit_location',
                data:'location='+loc+'&id='+ids+'&email1='+email1+'&notify_date='+notify_date+'&super_email='+super_email+'&notify_date2='+notify_date2+'&edit_notify_time='+edit_notify_time+'&edit_notify_time2='+edit_notify_time2+'&duration_edit='+duration_edit+'&duration_type_edit='+duration_type_edit,
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

    function get_Call_alert_location_data(id,name,email1,notify1,email2,notify2,notification_time,super_notify_time,duration,type){
        $('#edit_id').val(id);
        $('#edit_location').val(name);
        $('#edit_email1').val(email1);
        $('#edit_notify_date').val(notify1);
        $('#edit_super_email').val(email2);
        $('#edit_notify_date2').val(notify2);
        $('#edit_notify_time').val(notification_time);
        $('#edit_notify_time2').val(super_notify_time);
        $('#duration_edit').val(duration);
        $('#duration_type_edit').val(type);
    }

    function delete_Call_alert_location(id,name,status){
        //$('#id').val(id);
        //$('#location').val(name);
        
        ids=id;
        var result = confirm('Do you want to perform this action?');
        if(result){
            $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/Call_alert/delete_location',
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