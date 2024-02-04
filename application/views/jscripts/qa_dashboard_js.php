
<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
	
	$("#fclient_id").change(function(){
		var client_id=$(this).val();
		populate_process_combo(client_id,'','fprocess_id','Y');	
	});
	
	
///////////////////	
});

</script>