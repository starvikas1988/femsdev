<script>
	/* $(document).on('submit','#search_metrix',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
		process_ajax(function(response)
		{
			$('#search_metrix_container').html(response);
		},request_url, datas, 'text');
	}); */
	function exportF3(elem) {
		var first_table = $(elem).parent().parent().parent().parent().parent().parent().next().next().find('table');
		var second_table = $(elem).parent().parent().parent().parent().parent().parent().next().next().next().next().find('table');
		console.log(first_table[0]);
		console.log(first_table[0].outerHTML);
		var html = first_table[0].outerHTML+''+second_table[0].outerHTML;
		
		$.ajax(
		{
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_agent_view'); ?>",
			type:"POST",
			data:$('#search_metrix').serializeArray(),
			success: function(result)
			{
				$("#div1").html(result);
			}
		});
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);
		elem.setAttribute("download", "PMetrix Agent View <?php echo $fusion_id; ?>.xls"); // Choose the file name
		return false;
	}
	
	$(document).on('submit','#search_metrix',function(e)
	{
		e.preventDefault();
		var fusion_id = 1;
		var user_id = 0;
		var performance_for_month = $('#performance_for_month').val();
		var process_id = "<?php echo $pValue ?>";
		var performance_for_year = $('#performance_for_year').val();
		var others_team = <?php echo $tl_id; ?>;
		var view_type = 2;
		var datas = {'process_id':process_id,'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year,'user_id':user_id,'others_team':others_team,'view_type':view_type};
		if(fusion_id == 1)
		{
			var request_url = "<?php echo base_url('Pmetrix_v2_tl/prepare_row/true'); ?>";
		}
		else
		{
			var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
		}
		process_ajax(function(response)
		{
			if(fusion_id == 1)
			{
				$.when($('#search_metrix_container').html(response)).then(function()
				{
					var rows = '';
					$('.data_row > td:nth-of-type(4)').each(function(index,element)
					 {
						
						if($(element).text() == 'A')
						{
							rows += '<tr class="data_row">'+$(element).parent().html()+'</tr><tr class="indv_user_daily_data_container">'+$(element).parent().next().html()+'</tr>';
						}
					});
					$('.data_row > td:nth-of-type(4)').each(function(index,element)
					 {
						if($(element).text() == 'B')
						{
							rows += '<tr class="data_row">'+$(element).parent().html()+'</tr><tr class="indv_user_daily_data_container">'+$(element).parent().next().html()+'</tr></tr>';
						}
					});
					$('.data_row > td:nth-of-type(4)').each(function(index,element)
					 {
						if($(element).text() == 'C')
						{
							rows += '<tr class="data_row">'+$(element).parent().html()+'</tr><tr class="indv_user_daily_data_container">'+$(element).parent().next().html()+'</tr></tr>';
						}
					});
					
					$('#default-datatable tbody').html(rows);
				});
			}
			else
			{
				$('#available_users').html(response)
			}
			
		},request_url, datas, 'text');
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
		var datas = {'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year};
		var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
		if(current.parent().parent().next().is(':hidden'))
		{
			process_ajax(function(response)
			{
				//console.log(current.parent().parent().next());
				current.parent().parent().next().show();
				
				current.parent().parent().next().children().children().html(response);
				//$('#score_table').css({'width':($('.widget-header').width() - 70)});
				current.parent().parent().next().children().children().find('#score_table').css({'width':($('#search_metrix').width() - 70)});
			},request_url, datas, 'text');
		}
		else
		{
			current.parent().parent().next().hide();
		}
	});
	function exportF(elem) {
		var thead = document.getElementById("thead").outerHTML;
		var data_row = document.getElementsByClassName("data_row");
		var html = '<table>'+thead+'<tbody>';
		for(var i=0;i<data_row.length;i++)
		{
			html += data_row[i].outerHTML
		}
		html += '</tbody></table>';
		var process_name = $('#fprocess_id option:selected').text();
		var view_type = $('#view_type option:selected').text();
		$.ajax(
		{
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_agent_own_team_view'); ?>",
			type:"POST",
			data:$('#get_agent_list_form').serializeArray(),
			success: function(result)
			{
				$("#div1").html(result);
			}
		});
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);
		elem.setAttribute("download", "PMetrix Own Team View.xls"); // Choose the file name
		return false;
	}
</script>