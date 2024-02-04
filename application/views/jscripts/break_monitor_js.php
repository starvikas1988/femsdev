
<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
	
	
	$(".othUserId").click(function(){
		var oth_uid=$(this).attr("oth_uid");
		$('.frmOthUserBreak #oth_uid').val(oth_uid);
		
		var oth_uid=$('#oth_uid').val().trim();
		
		if(oth_uid!=""){
			$.ajax({
			   type: 'POST',    
			   url:baseURL+'Break_monitor/othBrkDetails',
			   data:$('form.frmOthUserBreak').serialize(),
			   success: function(data){
				   $('.modal-body #othBrk').html(data);
				}
			});
		}
		
		$('#modalOthUserBreak').modal('show');
	});	
	
	
	
	$(".ldUserId").click(function(){
		var ld_uid=$(this).attr("ld_uid");
		$('.frmLDUserBreak #ld_uid').val(ld_uid);
		
		var ld_uid=$('#ld_uid').val().trim();
		
		if(ld_uid!=""){
			$.ajax({
				type: 'POST',
				url: baseURL+'Break_monitor/ldBrkDetails',
				data:$('form.frmLDUserBreak').serialize(),
				success: function(data){
				   $('.modal-body #ldBrk').html(data);
				}
			});	
		}	
		
		$('#modalLDUserBreak').modal('show');
	});	
	
/////////////////////////////////////////////////////////

	$("#fclient_id").change(function(){
		var client_id=$(this).val();
		
		populate_process_combo(client_id,'','fprocess_id','Y');
	});
	
	
});

</script>	