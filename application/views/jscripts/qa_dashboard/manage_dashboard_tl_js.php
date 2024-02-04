<script>
	
	$(document).ready(function(e){
		var role = "<?php echo get_role_dir(); ?>";
		if(role == 'tl')
		{
			var datas = {"client_id":"<?php echo $client_id; ?>","process_id":"<?php echo $process_id; ?>","current_user":"<?php echo get_user_id(); ?>"};
			var request_url = "<?php echo base_url('qa_dashboard/get_tl_scores'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					$.each(res.datas,function(index,values)
					{
						if(values == null)
						{
							values = 0;
						}
						if(index == 'agent_record')
						{
							var agent_record = '';
							$.each(values,function(index,value)
							{
								agent_record += '<tr><td>'+value.agent_name.datas+'</td><td>'+value.own_mtd_no_of_audit.datas+'</td><td>'+parseFloat(value.own_mtd_score.datas).toFixed(2)+'</td><td>'+value.own_wtd_no_of_audit.datas+'</td><td>'+parseFloat(value.own_wtd_score.datas).toFixed(2)+'</td><td>'+value.own_ytd_no_of_audit.datas+'</td><td>'+parseFloat(value.own_ytd_score.datas).toFixed(2)+'</td></tr>';
							});
							$('#agent_record').html(agent_record);
						}
						else if(index == 'defects')
						{
							var defects_all = '';
							$.each(values.defects_all,function(index,value)
							{
								defects_all += '<tr><td>'+values.defect_column_names[index]+'</td><td>'+((parseInt(value)/parseInt(values.defects_all_count))*100).toFixed(2)+'%</td></tr>';
							});
							$('.defects_all').html(defects_all);
							
							var defects_all_accuracy = '';
							$.each(values.defects_all_accuracy,function(index,value)
							{
								defects_all_accuracy += '<tr><td>'+values.defect_column_names[index]+'</td><td>'+((parseInt(value)/parseInt(values.defects_all_count_accuracy))*100).toFixed(2)+'%</td></tr>';
							});
							$('.defects_all_accuracy').html(defects_all_accuracy);
						}
						else
						{
							if($('.'+index).attr('data-type')== 'int')
							{
								$('.'+index).text(parseInt(values));
							}
							else if($('.'+index).attr('data-type')== 'float')
							{
								$('.'+index).text(parseFloat(values).toFixed(2));
							}
						}
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