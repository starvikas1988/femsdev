<script>
	$(document).on('submit','#search_metrix',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
		process_ajax(function(response)
		{
			$('#search_metrix_container').html(response);
		},request_url, datas, 'text');
	});
	function exportF(elem) {
		var table = document.getElementsByClassName("table");
		var html = '';
		for(var i=0;i<table.length;i++)
		{
			html += table[i].outerHTML+'<br>';
		}
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
</script>