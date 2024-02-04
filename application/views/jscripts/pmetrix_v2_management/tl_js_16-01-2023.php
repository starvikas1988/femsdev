<script>

function get_agent_data(user_id, fusion_id, rank = ""){
	
	$("tr.data-viewer-tr").css("display","none");
	
	var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
	
	var performance_for_month = $('[name="performance_for_month"]').val();
	var performance_for_year = $('[name="performance_for_year"]').val();
	var process_id = $('#fprocess_id').val();
	var others_team = $('#others_team').val();
	var view_type = $('#view_type').val();
	var post_period = $('#post_period').val();
	var client_id = $('#fclient_id').val();
	var foffice_id = $('#foffice_id').val();
	
	var datas = {'client_id':client_id,'office_id':foffice_id, 'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year,'process_id':process_id,'others_team':others_team,'view_type':view_type,'post_period':post_period,'rank':rank};
	
	console.log(datas);
	
	$.post(request_url, datas, function(data){
		$("tr#data-viewer_"+user_id).find("div").empty().append(data);		
		$("tr#data-viewer_"+user_id).css("display","");
	});
}

</script>

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
			var agent_list = $(this).parent().parent().next();
			var rows = '';
			$(agent_list).find('tbody tr td:nth-of-type(4)').each(function(index,element)
			{
				if($(element).text() == 'A')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('tbody tr td:nth-of-type(5)').each(function(index,element)
			{
				if($(element).text() == 'B')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('tbody tr td:nth-of-type(6)').each(function(index,element)
			{
				if($(element).text() == 'C')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('tbody').html(rows);
			
			/* console.log($(agent_list).find('tbody tr td:nth-of-type(3)')); */
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
		populate_process_combo(client_id,'<?php echo $pValue; ?>','fprocess_id','N');
		var process_id = '<?php echo $pValue; ?>';
		if(process_id == 30)
		{
			$('#from_main').hide();
			$('#from_main input').attr('disabled','disabled');
			
			
			$('#to_main').hide();
			$('#to_main input').attr('disabled','disabled');
			
			
			$('#post_period_main').show();
			$('#post_period_main select').removeAttr('disabled');
			
		}
	});
	
</script>

<script>
var today = new Date();
var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
 $( function() {
		  $("#from").datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			maxDate: today,
			onSelect: function(date){

				var selectedDate = new Date(date);
				var msecsInADay = 86400000;
				var endDate = new Date(selectedDate.getTime());
				

		var lastDay = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0);
			   //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
				//$("#to").datepicker( "option", "maxDate", endDate );
				//$("#to").datepicker( "option", "maxDate", lastDay );

			}
		});

		$("#to").datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeMonth: false,
			maxDate: today
		});
  } );
</script>

<script>
	$(document).on('change','#fprocess_id',function(e)
	{
		var process_id =$(this).val();
		if(process_id==null){
			process_id = '<?php echo $pValue; ?>';
		}
		if(process_id == 30)
		{
			$('#from_main').hide();
			$('#from_main input').attr('disabled','disabled');
			
			
			$('#to_main').hide();
			$('#to_main input').attr('disabled','disabled');
			
			
			$('#post_period_main').show();
			$('#post_period_main select').removeAttr('disabled');
			
		}
		else
		{
			$('#from_main').show();
			$('#from_main input').removeAttr('disabled');
			
			$('#to_main').show();
			$('#to_main input').removeAttr('disabled');
			
			$('#post_period_main').hide();
			$('#post_period_main select').attr('disabled','disabled');
			
		}
	});
</script>

<script>
	$(document).on('click','.tl_id',function(e)
	{
		var tl_id = $(this).text().trim();
		var datas = $('#get_tl_list_form').serializeArray();
		datas.push({name: 'tl_id', value: tl_id})
		console.log(datas);
		var request_url = "<?php echo base_url('Pmetrix_v2_tl/prepare_tl_row'); ?>";
		process_ajax(function(response)
		{
			$('#single_tl_modal').modal('hide');
			$('#single_tl_modal').modal('show');
			$('#single_tl_modal .modal-body').html(response);
			
			/*  */
		},request_url, datas, 'text');
	});
	function sum(class_name)
	{
		var sum = 0;
		$(class_name).each(function()
		{
			sum = sum + parseFloat($(this).attr('data-value'));
		});
		return sum.toFixed(2);
	}
	function onlyUnique(value, index, self) { 
		return self.indexOf(value) === index;
	}
</script>


<script>

function get_tls(manager_id){
	$('#sktPleaseWait').modal('show');
	
	design_id = $("#design_id").val();
	start_date = $("#from").val();
	end_date = $("#to").val();
	
	$("tr.tls_tr").hide();
	
	$.post("<?php echo base_url() ?>Pmetrix_test_management/prepare_tl_row", {'design_id':design_id, 'start_date':start_date, 'end_date':end_date, 'manager_id':manager_id}, function(data){
		$('#sktPleaseWait').modal('hide');
		$("tr#tr-"+manager_id).show();
		$("tr#tr-"+manager_id).find('td').empty().html(data);
	});
	
}


function call_agents(tl_id){
	$("tr.tls_tr-tl").hide();
	$('#sktPleaseWait').modal('show');
	
	design_id = $("#design_id").val();
	
	$.post("<?php echo base_url()?>Pmetrix_test_tl/call_agents", 
		{"tl_id":tl_id, "design" : design_id, "year": $("#year").val(), "month":$("#month").val(), "start_date":$("#from").val(), "end_date":$("#to").val()}, 
		function(data){
			$('#sktPleaseWait').modal('hide');
			$("tr#tr-tl-"+tl_id).show();
			$("tr#tr-tl-"+tl_id).find("td").html(data);
	});
}

</script>