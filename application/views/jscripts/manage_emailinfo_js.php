<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
	
	$(".editSchedule").click(function(){

		var sid=$(this).attr("sid");
		
		var params=$(this).attr("params");		
		var arrPrans = params.split("#"); 
		
		$('#sid').val(sid);
		$('#sch_for').val(arrPrans[0]);
		$('#email_id').val(arrPrans[1]);
		$('#email_subject').val(arrPrans[2]);
		$('#email_body').val(arrPrans[3]);
		
		$('#sktModal').modal('show');
		
		//alert("UID="+uid + " atl:"+atl);
		
	});
	
	
	
	$("#updateSchedule").click(function(){
	
		var id=$('#sid').val();
		//alert($('form.editUser').serialize());
		
		$('#sktModal').modal('hide');
		
		$.ajax({
		   type: 'POST',    
		   url:baseURL+'emailinfo/update',
		   data:$('form.editSch').serialize(),
		   success: function(msg){
					location.reload();
			}
			/*,
			error: function(){
				alert('Fail!');
			}
			*/
		  });
	});
	
});
    
</script>

