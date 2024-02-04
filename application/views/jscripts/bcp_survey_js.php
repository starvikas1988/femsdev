<script>
	
$(document).ready(function(){
	
	var baseURL = "<?php echo base_url(); ?>";
	var location = "<?php echo get_user_office_id(); ?>";
	
	
	$("#callback_datetime").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	
	$(".addBcpSurvey").click(function(){
		$("#addBCPSurveyModal").modal('show');
	});
	
	$("#Bcp_survey").click(function(){
		var customer_name=$('.frmBCPSurveyModal #customer_name').val().trim();
		var customer_phone=$('.frmBCPSurveyModal #customer_phone').val().trim();
		var callback_datetime=$('.frmBCPSurveyModal #callback_datetime').val().trim();
		
		if(customer_name!="" && customer_phone!="" && callback_datetime!=""){
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type	: 	'POST',    
				url		:	baseURL+'bcp_survey/add_feedback',
				data	:	$('form.frmBCPSurveyModal').serialize(),
				success	:	function(msg){
								$('#sktPleaseWait').modal('hide');
								$('#addBCPSurveyModal').modal('hide');
								window.location.reload();
							}
			});
		}else{
			alert("One or More field's are blank");
		}	
	});	
	
});	

function checkDec(el){
	var ex = /^[0-9]+\.?[0-9]*$/;
	if(ex.test(el.value)==false){
		el.value = el.value.substring(0,el.value.length - 1);
	}
}
</script>
