<script type="text/javascript">

$(document).ready(function(){
	
	
	$(".payslip").click(function(){
		
		var filename= $(this).attr("filename");
	
		//var filename=$(this).attr("filename");
		$('#filename').val(filename);
		$("#modalSendPaySlip").modal('show');
		
	});
	
	
	
	$('.frmSendPaySlip').submit(function(e) {
		
		//alert('OK');
		
		var email_to=$('.frmSendPaySlip #email_to').val();
		var filename=$('.frmSendPaySlip #filename').val();
				
		if(email_to!="" && filename!=""){
			
			//alert("<?php echo base_url();?>payslip/send?"+$('form.frmSendPaySlip').serialize());
			
			$('#sktPleaseWait').modal('show');
			
			$.ajax({
				type	:	'POST',
				url		:	'<?php echo base_url();?>payslip/send',
				data	:	$('form.frmSendPaySlip').serialize(),
				success	:	function(msg){
							$('#sktPleaseWait').modal('hide');
							$("#modalSendPaySlip").modal('hide');
							alert(msg);
						}
			});
		}else{
			alert('Fill the email id');
		}
	});
	
	
});	

 
</script>


