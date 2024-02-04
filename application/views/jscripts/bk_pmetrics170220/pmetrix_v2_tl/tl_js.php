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
			var agent_list = $(this).parent().parent().next();
			var rows = '';
			$(agent_list).find('tbody tr td:nth-of-type(2)').each(function(index,element)
			{
				if($(element).text() == 'A')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('tbody tr td:nth-of-type(2)').each(function(index,element)
			{
				if($(element).text() == 'B')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('tbody tr td:nth-of-type(2)').each(function(index,element)
			{
				if($(element).text() == 'C')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('tbody').html(rows);
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
<script>
	$(document).ready(function()
	{
		$('#foffice_id').val('<?php echo $oValue; ?>').trigger("change");
		$('#performance_for_month').val('<?php echo date('m'); ?>').trigger("change");
		$('#performance_for_year').val('<?php echo  date('Y'); ?>').trigger("change");
		
	});
	
</script>
<script>
	$(document).on('change','#foffice_id',function()
	{
		var office_id = $(this).val();
		$.ajax({
		   type: 'POST',    
		   url:"<?php echo base_url('pmetrix_v2/get_clients');?>",
		   data:'office_id='+office_id,
		   success: function(response){
				var res = JSON.parse(response);
				console.log(res);
				var option = '<option value="">--Select--</option>';
				$.each(res, function(key,value)
				{
					option += '<option value="'+value.client_id+'" selected>'+value.shname+'</option>';
					
					/* $('#fclient_id option:not([value="'+value.client_id+'"])').attr('disabled','disabled');
					$('#fclient_id option[value="'+value.client_id+'"]').removeAttr('disabled'); */
				});
				$.when($('#fclient_id').html(option)).done(function()
				{
					$('#fclient_id').val('<?php echo $cValue; ?>').trigger("change");
				});
				
			}
			
		  });
	});
</script>
<script>
	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		populate_process_combo(client_id,'<?php echo $pValue; ?>','fprocess_id','Y');
		
	});
	
</script>
<script>
	
</script>

<script>
 $( function() {
		  $("#from").datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			maxDate: '+1M',
			onSelect: function(date){

				var selectedDate = new Date(date);
				var msecsInADay = 86400000;
				var endDate = new Date(selectedDate.getTime());

		var lastDay = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0);
			   //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
				$("#to").datepicker( "option", "minDate", endDate );
				$("#to").datepicker( "option", "maxDate", lastDay );

			}
		});

		$("#to").datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeMonth: false
		});
  } );
</script>