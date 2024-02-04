<script>
	$(document).on('click','.appliy_requisition',function(e)
	{
		e.preventDefault()
		$('.process_user_credential_form').trigger("reset");
		$(this).parent().parent().next().find('div').slideToggle(100);
	});
</script>

<script>
	$(document).on('submit','.process_user_credential_form',function(e)
	{
		e.preventDefault();
		var datas = new FormData(this);
		var request_url = "<?php echo base_url('progression/submit_user_application'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				get_requisition_result();
			}
			
		},request_url, datas, 'text','POST','file');
	});
	
</script>

<script>
$(document).ready(function() {
	get_requisition_result();
});

function get_requisition_result()
{
	var datas = {};
	var request_url = "<?php echo base_url('progression/get_apply_ijp'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if(res.stat == true)
		{
			$('#progression_search_container').html(res.datas);
		}
	},request_url, datas, 'text');
	
	var request_url = "<?php echo base_url('progression/applied_progression'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if(res.stat == true)
		{
			$('#progression_applied').html(res.datas);
		}
	},request_url, datas, 'text');
}
</script>
