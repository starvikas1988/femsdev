<script>
	$(document).on('submit','#get_tl_list_form',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('Pmetrix_v2_tl/prepare_tl_row'); ?>";
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
	function exportF3(elem) {
		var thead = document.getElementById("thead").outerHTML;
		var data_row = document.getElementsByClassName("data_row");
		var html = '<table>'+thead+'<tbody>';
		for(var i=0;i<data_row.length;i++)
		{
			html += data_row[i].outerHTML
		}
		html += '</tbody></table>';
		var process_name = $('#fprocess_id option:selected').text();
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		$.ajax(
		{
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_tl_tl_view_process'); ?>",
			type:"POST",
			data:$('#get_tl_list_form').serializeArray(),
			success: function(result)
			{
				$("#div1").html(result);
			}
		});
		elem.setAttribute("href", url);
		elem.setAttribute("download", "PMetrix For "+process_name+".xls"); // Choose the file name
		return false;
	}
	function exportF(elem) {
		var table = $(elem).parent().parent().parent().parent();
		var fusion_id = $(elem).parent().parent().parent().parent().parent().parent().parent().prev().children('td[data-fusion_id]').attr('data-fusion_id');
		var html = '';
		for(var i=0;i<table.length;i++)
		{
			html += table[i].outerHTML+'<br>';
		}
		$.ajax(
		{
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_tl_tl_allagent_view'); ?>",
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