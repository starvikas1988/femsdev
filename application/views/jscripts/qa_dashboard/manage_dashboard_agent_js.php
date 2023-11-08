<script>
	
	$(document).ready(function(e){
		var role = "<?php echo get_role_dir(); ?>";
		if(role == 'agent')
		{
			var datas = {"client_id":"<?php echo $client_id; ?>","process_id":"<?php echo $process_id; ?>","current_user":"<?php echo get_user_id(); ?>"};
			var request_url = "<?php echo base_url('qa_dashboard/get_agent_scores'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					$.each(res.datas,function(index,values)
					{
						if(index == 'defects')
						{
							var own_defects = '';
							$.each(values.own_defects,function(index,value)
							{
								own_defects += '<tr><td>'+values.defect_column_names[index]+'</td><td>'+((parseInt(value)/parseInt(values.own_defects_count))*100).toFixed(2)+'%</td></tr>';
							});
							$('.own_defects').html(own_defects);
							
							var defects_all = '';
							$.each(values.defects_all,function(index,value)
							{
								defects_all += '<tr><td>'+values.defect_column_names[index]+'</td><td>'+((parseInt(value)/parseInt(values.defects_all_count))*100).toFixed(2)+'%</td></tr>';
							});
							$('.defects_all').html(defects_all);
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
					//alert('No Information Found');
				}
			},request_url, datas, 'text');
		}
	});
</script>
<!-- Notification Banner JS -->
<!-- Edited By Samrat 11-Aug-22 -->
<script>
	//$("#banner_notify").modal("show")
</script>