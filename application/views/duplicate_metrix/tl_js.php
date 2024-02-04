<script>
	$(document).on('submit','#get_tl_list_form',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('Pmetrix_v2_management/prepare_tl_row'); ?>";
		process_ajax(function(response)
		{
			$('#available_users').html(response);
		},request_url, datas, 'text');
	});
</script>
<script>
	$(document).on('click','.open_agent_list',function()
	{
		if($(this).parent().parent().next().is(':hidden'))
		{
			$(this).parent().parent().next().show();
		}
		else
		{
			$(this).parent().parent().next().hide();
		}
	});
</script>

<script>
	function exportF(elem) {
		var table = document.getElementsByClassName("table");
		var html = '';
		for(var i=0;i<table.length;i++)
		{
			if(i < 2)
			{
				html += table[i].outerHTML+'<br>';
			}
			
		}
		var thead = document.getElementById("thead");
		html += '<table>';
		html += thead.outerHTML+'<tbody>';
		var data_row_array = document.getElementsByClassName('data_row');
		for(var j=0;j<data_row_array.length;j++)
		{
			html += data_row_array[j].outerHTML;
		}
		html += '</tbody></table>';
		var process_name = $('#fprocess_id option:selected').text();
		var month = $('#performance_for_month option:selected').text();
		var year = $('#performance_for_year option:selected').text();
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url
		$.ajax(
		{
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_management_view_process'); ?>",
			type:"POST",
			data:$('#get_tl_list_form').serializeArray(),
			success: function(result)
			{
				$("#div1").html(result);
			}
		});
		elem.setAttribute("href", url);
		elem.setAttribute("download", "PMetrix For Process "+process_name+" ("+year+"-"+month+") .xls"); // Choose the file name
		return false;
	}
	
	function exportF1(elem) {
		var table = $(elem).parent().parent().parent().parent();
		var fusion_id = $(elem).parent().parent().parent().parent().parent().parent().parent().prev().children('td[data-fusion_id]').attr('data-fusion_id');
		var html = '';
		for(var i=0;i<table.length;i++)
		{
			html += table[i].outerHTML+'<br>';
		}
		$.ajax(
		{
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_management_view_tl'); ?>",
			type:"POST",
			data:$('#get_tl_list_form').serializeArray(),
			success: function(result)
			{
				$("#div1").html(result);
			}
		});
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);
		elem.setAttribute("download", "PMetrix For TL "+fusion_id+".xls"); // Choose the file name
		return false;
	}
</script>