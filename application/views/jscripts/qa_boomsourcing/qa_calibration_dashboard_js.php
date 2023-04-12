<script>	
$(document).ready(function(e){
	
	// $('#from_date').datepicker();
	// $('#to_date').datepicker();
	$("#from_date, #to_date").datepicker({
	    dateFormat: "yy-mm-dd",
	});
		
	$('#office_id').select2();
	$('#ticket_id').select2();
	// $('#process_id').select2();
		
	/*Ticket id population depending on process_id */
	$("#process_id").change(function(){

		let processId = $("#process_id").val();
		let from_date = $("#from_date").val();
		let to_date = $("#to_date").val();
		let root_path = "<?php echo base_url(); ?>";
		let path = root_path+"qa_calibration/get_ticket";
		$.ajax({
			type: "POST",
			url: path,
			data:{process:processId,from_date:from_date,to_date:to_date},
			
			success: function(data){
			
				$("#ticket_id").html(data);
				
			}
		});
	});
	/* end */
});
</script>