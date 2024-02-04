<script type="text/javascript">
    
$(document).ready(function(){

});


function access_open(abbr, id){
    var x_url = '<?php echo base_url();?>/leave/location_access_status_change';
    $.post(x_url, {"abbr": abbr,"id":id}, function(data){
        location.reload()
    });
}


</script>
