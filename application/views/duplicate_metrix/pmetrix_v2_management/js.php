<script>
	$(document).on('change','#view_type',function(e)
	{
		var view_type = $(this).val();
		$('#others_team_container').hide();
		$('#others_team_container #others_team').attr('disabled','disabled');
		$('#others_team').val('');
		if(view_type == 2)
		{
			$('#others_team_container').show();
			$('#others_team_container #others_team').removeAttr('disabled');
		}
		else
		{
			var process_id = $('#fprocess_id').val();
			var office_id = $('#foffice_id').val();
			var view_type = $(this).val();
			var others_team = $('#others_team').val();
			var datas = {'process_id':process_id,'office_id':office_id,'view_type':view_type};
			var request_url = "<?php echo base_url('Pmetrix_v2_tl/get_agent_list'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					var option = '<option value="">--Select--</option><option value="1" data-user_id="0">All Agent</option>';
					$.each(res.datas,function(index,element)
					{
						option += '<option value="'+element.fusion_id+'" data-user_id="'+element.id+'">'+element.fname+' '+element.lname+'</option>'
					});
					$('#search_type').html(option);
				}
			},request_url, datas, 'text');
		}
	});
	
	$(document).on('change','#others_team',function(e)
	{
		var process_id = $('#fprocess_id').val();
			var office_id = $('#foffice_id').val();
			var view_type = $('#view_type').val();
			var others_team = $('#others_team').val();
			var datas = {'process_id':process_id,'office_id':office_id,'view_type':view_type,'others_team':others_team};
			var request_url = "<?php echo base_url('Pmetrix_v2_tl/get_agent_list'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					if(res.datas.length > 0)
					{
						var option = '<option value="">--Select--</option><option value="1" data-user_id="0">All Agent</option>';
						$.each(res.datas,function(index,element)
						{
							option += '<option value="'+element.fusion_id+'" data-user_id="'+element.id+'">'+element.fname+' '+element.lname+'</option>'
						});
						$('#search_type').html(option);
					}
					else
					{
						$('#search_type').html('<option value="">--No Agent Available--</option>');
					}
				}
			},request_url, datas, 'text');
	});
	
	$(document).on('change','#fprocess_id',function(e)
	{
		var view_type = $(this).val();
		$('#others_team_container').hide();
		var datas = {'process_id':$(this).val()};
		var request_url = "<?php echo base_url('Pmetrix_v2_tl/get_process_tl'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var option = '<option value="">--Select--</option>';
				$.each(res.datas,function(index,element)
				{
					option += '<option value="'+element.id+'">'+element.fname+' '+element.lname+'</option>'
				});
				$('#others_team').html(option);
			}
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('submit','#get_agent_list_form',function(e)
	{
		e.preventDefault();
		var fusion_id = $('#search_type').val();
		var user_id = $('#search_type').find(":selected").attr('data-user_id');
		var performance_for_month = $('#performance_for_month').val();
		var process_id = $('#fprocess_id').val();
		var performance_for_year = $('#performance_for_year').val();
		var others_team = $('#others_team').val();
		var view_type = $('#view_type').val();
		var datas = {'process_id':process_id,'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year,'user_id':user_id,'others_team':others_team,'view_type':view_type};
		var request_url = "<?php echo base_url('Pmetrix_v2_tl/prepare_row/true'); ?>";
		process_ajax(function(response)
		{
			$('#available_users').html(response);
		},request_url, datas, 'text');
	});
</script>
<script>
	$('#search_type').on('change',function()
	{
		$('#agent_container').hide();
		$('#agent_fusion_id').attr('disabled','disabled');
	});
</script>
<script>
	$(document).on('click','.get_indv_user_daily_data',function(e)
	{
		e.preventDefault();
		/* $('.indv_user_daily_data_container').hide(); */
		var current = $(this);
		var fusion_id = $(this).attr('data-fusion_id');
		var performance_for_month = $('#performance_for_month').val();
		var performance_for_year = $('#performance_for_year').val();
		var process_id = $('#fprocess_id').val();
		var others_team = $('#others_team').val();
		var view_type = $('#view_type').val();
		var datas = {'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year,'process_id':process_id,'others_team':others_team,'view_type':view_type};
		var request_url = "<?php echo base_url('Pmetrix_v2_tl/indv_prepare_row'); ?>";
		if(current.parent().parent().next().is(':hidden'))
		{
			process_ajax(function(response)
			{
				//console.log(current.parent().parent().next());
				current.parent().parent().next().show();
				
				current.parent().parent().next().children().children().html(response);
			},request_url, datas, 'text');
		}
		else
		{
			current.parent().parent().next().hide();
		}
	});
</script>