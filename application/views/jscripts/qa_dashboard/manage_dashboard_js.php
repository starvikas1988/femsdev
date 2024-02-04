<script>
	$(document).on('submit','#form_new_user',function(e){
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('qa_dashboard/get_dashboard_data'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var full_element = res.datas;
				$.each(res.datas,function(index,element)
				{
					
					$.each(element,function(ind,ele)
					{
						if(ele.hasOwnProperty('qa_present_count'))
						{
							$('.qa_present_count[data-date="'+ele.audit_date+'"]').html(ele.qa_present_count);
						}
						else if(ele.hasOwnProperty('audit_performed'))
						{
							$('.audit_performed[data-date="'+ele.audit_date+'"]').html(ele.audit_performed);
						}
						else if(ele.hasOwnProperty('qa_score'))
						{
							$('.qa_score[data-date="'+ele.audit_date+'"]').html(parseFloat(ele.qa_score).toFixed(2)+'%');
						}
						else if(ele.hasOwnProperty('fatal_score'))
						{
							var audit_performed = parseInt($('.audit_performed[data-date="'+ele.audit_date+'"]').text());
							$('.fatal_score[data-date="'+ele.audit_date+'"]').html(((100/audit_performed)*ele.fatal_score).toFixed(2)+'%');
						}
						if(ind == 'audit_performed_90')
						{
							$('.audit_performed_90').html(ele);
						}
						else if(ind == 'qa_present_count_90')
						{
							var qa_present_count_90 = parseInt(ele);
						}
						else if(ind == 'qa_score_90')
						{
							$('.qa_score_90').html(parseFloat(ele).toFixed(2)+'%');
						}
						else if(ind == 'fatal_score_90')
						{
							$('.fatal_score_90').html(((100/full_element.audit_performed_90.audit_performed_90)*ele).toFixed(2)+'%');
						}
						
						
						if(ind == 'audit_performed_365')
						{
							$('.audit_performed_365').html(ele);
						}
						else if(ind == 'qa_present_count_365')
						{
							var qa_present_count_365 = parseInt(ele);
						}
						else if(ind == 'qa_score_365')
						{
							$('.qa_score_365').html(parseFloat(ele).toFixed(2)+'%');
						}
						else if(ind == 'fatal_score_365')
						{
							$('.fatal_score_365').html(((100/full_element.audit_performed_365.audit_performed_365)*ele).toFixed(2)+'%');
						}
						
						if(ind == 'qa_score_month')
						{
							$('.qa_score_month').html(parseFloat(ele).toFixed(2)+'%');
						}
						if(ind == 'week_qa_score')
						{
							$('.week_qa_score').html(parseFloat(ele).toFixed(2)+'%');
						}
						if(ind == 'audit_performed_month')
						{
							$('.audit_performed_month').html(ele);
						}
						if(ind == 'month_agent_covered')
						{
							$('.month_agent_covered').html(ele);
						}
					});
				});
			}
			else
			{
				alert('No Information Found');
			}
		},request_url, datas, 'text');
	});
	
</script>

<script>
	
	$(document).ready(function(e){
		var role = "<?php echo get_role_dir(); ?>";
		if(role == 'tl')
		{
			var datas = {};
			var request_url = "<?php echo base_url('qa_dashboard/get_dashboard_data'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					var full_element = res.datas;
					$.each(res.datas,function(index,element)
					{
						
						$.each(element,function(ind,ele)
						{
							if(ele.hasOwnProperty('qa_present_count'))
							{
								$('.qa_present_count[data-date="'+ele.audit_date+'"]').html(ele.qa_present_count);
							}
							else if(ele.hasOwnProperty('audit_performed'))
							{
								$('.audit_performed[data-date="'+ele.audit_date+'"]').html(ele.audit_performed);
							}
							else if(ele.hasOwnProperty('qa_score'))
							{
								$('.qa_score[data-date="'+ele.audit_date+'"]').html(parseFloat(ele.qa_score).toFixed(2)+'%');
							}
							else if(ele.hasOwnProperty('fatal_score'))
							{
								var audit_performed = parseInt($('.audit_performed[data-date="'+ele.audit_date+'"]').text());
								$('.fatal_score[data-date="'+ele.audit_date+'"]').html(((100/audit_performed)*ele.fatal_score).toFixed(2)+'%');
							}
							if(ind == 'audit_performed_90')
							{
								$('.audit_performed_90').html(ele);
							}
							else if(ind == 'qa_present_count_90')
							{
								var qa_present_count_90 = parseInt(ele);
							}
							else if(ind == 'qa_score_90')
							{
								$('.qa_score_90').html(parseFloat(ele).toFixed(2)+'%');
							}
							else if(ind == 'fatal_score_90')
							{
								$('.fatal_score_90').html(((100/full_element.audit_performed_90.audit_performed_90)*ele).toFixed(2)+'%');
							}
							
							
							if(ind == 'audit_performed_365')
							{
								$('.audit_performed_365').html(ele);
							}
							else if(ind == 'qa_present_count_365')
							{
								var qa_present_count_365 = parseInt(ele);
							}
							else if(ind == 'qa_score_365')
							{
								$('.qa_score_365').html(parseFloat(ele).toFixed(2)+'%');
							}
							else if(ind == 'fatal_score_365')
							{
								$('.fatal_score_365').html(((100/full_element.audit_performed_365.audit_performed_365)*ele).toFixed(2)+'%');
							}
							
							if(ind == 'qa_score_month')
							{
								$('.qa_score_month').html(parseFloat(ele).toFixed(2)+'%');
							}
							if(ind == 'week_qa_score')
							{
								$('.week_qa_score').html(parseFloat(ele).toFixed(2)+'%');
							}
							if(ind == 'audit_performed_month')
							{
								$('.audit_performed_month').html(ele);
							}
							if(ind == 'month_agent_covered')
							{
								$('.month_agent_covered').html(ele);
							}
						});
					});
				}
				else
				{
					alert('No Information Found');
				}
			},request_url, datas, 'text');
		}
	});
</script>