<script>
	$(document).ready(function() {
		get_progression_count();
	});
	
	function get_progression_count()
	{
		var datas = {};
		var request_url = "<?php echo base_url('progression/get_apply_ijp'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.available_requisition == '0')
			{
				$('#avail_progression').hide();
			}
			else
			{
				$('#avail_progression').text(res.available_requisition);
			}
		},request_url, datas, 'text');
	}
</script>