<!-- <script>
	$(document).on('submit','#newJoinersForm',function(e)
	{    
	    // event.preventDefault()
		//$('button[type="submit"]').attr('disabled','disabled');
		var datas = $(this).serializeArray();
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url('new_joiners_feedback_form/process_form'); ?>',
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			dataType: "html",
			success	:	function(result){
				
			}
		});
	});
</script> -->
<!-- <script>
	$(document).on('submit','#newJoinersFormii',function(e)
	{    
	    // event.preventDefault()
		//$('button[type="submit"]').attr('disabled','disabled');
		var datas = $(this).serializeArray();
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url('new_joiners_feedback_form/process_form_ii'); ?>',
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			dataType: "html",
			success	:	function(result){
					}
			
		});
	});
</script> -->