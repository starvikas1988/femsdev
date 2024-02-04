<script type="text/javascript">

	$(document).ready(function(){
		
		var baseURL="<?php echo base_url(); ?>";
		
	////////////////

		$(".employeeMovement").click(function(){
			var r_id=$(this).attr("r_id");
			$('#r_id').val(r_id);
			$('.frmEmployeeMovement #r_id').val(r_id);
			$("#employeeMovementModel").modal('show');
		});
	
	////////////////
		
	});

</script>	