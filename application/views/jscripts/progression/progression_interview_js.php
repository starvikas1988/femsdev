<script>
	$('#take_interview_form').submit(function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		$('#interview_form #user_id').val(datas[0].value);
		$('#interview_form #requisition_id').val($('option:selected', this).attr('data-requisition_id'));
		$('#interview_form_container').show();
	});
</script>

<script>
	$('#interview_form').submit(function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('progression/update_interview_score'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#interview_form_container').hide();
				$('#take_interview_form [name="select_user"] option:selected').remove();
			}
			else
			{
				alert('Try After Some Time.');
			}
		},request_url, datas, 'text');
	});
</script>