<script>

function get_agent_data(user_id, fusion_id){
	
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
	
	var datas = {'client_id':client_id,'office_id':foffice_id, 'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year,'process_id':process_id,'others_team':others_team,'view_type':view_type,'post_period':post_period};
	
	console.log(datas);
	
	$.post(request_url, datas, function(data){
		$("tr#data-viewer_"+user_id).find("div").empty().append(data);		
		$("tr#data-viewer_"+user_id).css("display","");
	});
}

</script>

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
			var process_id = '<?php echo $pValue; ?>';
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
					var option = '<option value="">--Select--</option>';
					if(process_id != 30)
					{
						option += '<option value="1" data-user_id="0">All Agent</option>';
					}
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
						var option = '<option value="">--Select--</option>';
						if(process_id != 30)
						{
							option += '<option value="1" data-user_id="0">All Agent</option>';
						}
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
		var process_id =$(this).val();
		var office_id =$('#foffice_id').val();
		var client_id =$('#fclient_id').val();
		if(process_id==null){
			process_id = '<?php echo $pValue; ?>';
		}
		$('#view_type').val('').trigger('change');
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
		var datas = {'process_id':process_id,'office_id':office_id,'client_id':client_id};
				
		var request_url = "<?php echo base_url('Pmetrix_v2_tl/get_process_tl'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var option = '<option value="">--Select--</option>';
				option += '<option value="0">--All TLs--</option>';
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
		var performance_for_month = $('[name="performance_for_month"]').val();
		var process_id = $('#fprocess_id').val();
		var performance_for_year = $('[name="performance_for_year"]').val();
		var others_team = $('#others_team').val();
		var view_type = $('#view_type').val();
		
		
		var post_period = $('#post_period').val();
		var datas = {'process_id':process_id,'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year,'user_id':user_id,'others_team':others_team,'view_type':view_type,'client_id':$('#fclient_id').val(),'office_id':$('#foffice_id').val(),'post_period':post_period};
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
				$.when($('#available_users').html(response)).then(function()
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
			if($('#fprocess_id').val() == 30)
			{
				$('#score_table').hide();
				$('.SUPName').each(function()
				{
					$('#supervisor').text($(this).text());
				});
				$('#fusion_id').text($('.fusion_id_header').text());
				$('.CollNum').each(function()
				{
					$('#erps_id').text($(this).text());
				});
				
				$('.GroupCode').each(function()
				{
					$('#unit').text($(this).text());
				});
				
				
				var currency = $('.FutChkAmt').attr('data-currency');
				$('#pd_cheque_amt').text(currency+find_max('.FutChkAmt')).attr('data-currency',currency);
				
				var currency = $('.FutChkFee').attr('data-currency');
				$('#pd_cheque_fees').text(currency+find_max('.FutChkFee')).attr('data-currency',currency);
				
				var currency = $('.FutCardAmt').attr('data-currency');
				$('#pd_card_amt').text(currency+find_max('.FutCardAmt')).attr('data-currency',currency);
				
				var currency = $('.FutCardAmt').attr('data-currency');
				$('#pd_card_fees').text(currency+find_max('.FutCardFee')).attr('data-currency',currency);
				
				
				var currency = $('.AcctWorked').attr('data-currency');
				$('#AcctWorked').text(currency+sum('.AcctWorked')).attr('data-currency',currency);
				
				var currency = $('.Contacts').attr('data-currency');
				$('#rpc').text(currency+sum('.Contacts')).attr('data-currency',currency);
				
				
				$('#rpc_percent').text(((sum('.Contacts')/sum('.AcctWorked')) * 100).toFixed(1)+"%");
				
				var currency = $('.CashCollAmt').attr('data-currency');
				$('#Collected').text(currency+sum('.CashCollAmt').toFixed(2)).attr('data-currency',currency).attr('data-value',sum('.CashCollAmt').toFixed(2));
				
				
				$('#nsf_percent').text(((sum('.NSF_Amount')/parseFloat($('#Collected').attr('data-value'))) * 100).toFixed(1)+"%");
				
				
				var currency = $('.CashCollFee').attr('data-currency');
				$('#fees').text(currency+sum('.CashCollFee').toFixed(2)).attr('data-currency',currency).attr('data-value',sum('.CashCollFee').toFixed(2));
				
				var currency = $('.FeeBudget').attr('data-currency');
				$('#fees_budget').text(currency+sum('.FeeBudget')).attr('data-currency',currency).attr('data-value',sum('.FeeBudget'));
				$('#Attainment').text(sum('.FeeBudget'));
				if(parseFloat($('#fees_budget').text()) == 0)
				{
					$('#Attainment').css({'color':'red'}).text('0%');
				}
				else
				{
					var value = ((parseFloat($('#fees').attr('data-value'))/parseFloat($('#fees_budget').attr('data-value'))) * 100);
					if(value >= 100)
					{
						$('#Attainment').css({'color':'green'}).text(value.toFixed(1)+'%');
					}
					else
					{
						$('#Attainment').css({'color':'red'}).text(value.toFixed(1)+'%');
					}
				}
				
				
				$('#summary_header').text($('#search_type option:selected').text()+', Your Performance For '+$('#post_period').val());
				
				$('td:not(.form)').each(function(index,element) 
				{
					if(!$(element).is(':visible'))
					{
						$(element).remove();
					}
				});
			}
		},request_url, datas, 'text');
	});
	function find_max(class_name,current=false,current_stat=false)
	{
		var max = 0;
		if(current_stat == true)
		{
			current.parent().parent().next().children().children().find(class_name).each(function()
			{
				  var value = parseFloat($(this).attr('data-value')).toFixed(2);
				  max = (value > max) ? value : max;
			});
		}
		else
		{
			$(class_name).each(function()
			{
				  var value = parseFloat($(this).attr('data-value')).toFixed(2);
				  max = (value > max) ? value : max;
			});
		}
		return max;
	}
	
	function sum(class_name,current=false,current_stat=false)
	{
		var sum = 0;
		if(current_stat == true)
		{
			current.parent().parent().next().children().children().find(class_name).each(function()
			{
				sum = sum + parseFloat($(this).attr('data-value'));
			});
		}
		else
		{
			$(class_name).each(function()
			{
				sum = sum + parseFloat($(this).attr('data-value'));
			});
		}
		return sum;
	}
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
		var performance_for_month = $('[name="performance_for_month"]').val();
		var performance_for_year = $('[name="performance_for_year"]').val();
		var process_id = $('#fprocess_id').val();
		var others_team = $('#others_team').val();
		var view_type = $('#view_type').val();
		var post_period = $('#post_period').val();
		
		var datas = {'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year,'process_id':process_id,'others_team':others_team,'view_type':view_type,'post_period':post_period};
		var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
		if(current.parent().parent().next().is(':hidden'))
		{
			process_ajax(function(response)
			{
				//console.log(current.parent().parent().next());
				current.parent().parent().next().show();
				
				current.parent().parent().next().children().children().html(response);
				current.parent().parent().next().children().children().find('#score_table').css({'width':($('.widget-header').width() - 70)});
				
				
				///////////////////////
				if(process_id == 30)
				{
					var child = current.parent().parent().next().children().children();
					child.find('.SUPName').each(function()
					{
						child.find('#supervisor').text($(this).text());
					});
					child.find('#fusion_id').text(child.find('.fusion_id_header').text());
					child.find('.CollNum').each(function()
					{
						child.find('#erps_id').text($(this).text());
					});
					
					child.find('.GroupCode').each(function()
					{
						child.find('#unit').text($(this).text());
					});
					
					
					var currency = child.find('.FutChkAmt').attr('data-currency');
					child.find('#pd_cheque_amt').text(currency+find_max('.FutChkAmt')).attr('data-currency',currency);
					
					var currency = child.find('.FutChkFee').attr('data-currency');
					child.find('#pd_cheque_fees').text(currency+find_max('.FutChkFee')).attr('data-currency',currency);
					
					var currency = child.find('.FutCardAmt').attr('data-currency');
					child.find('#pd_card_amt').text(currency+find_max('.FutCardAmt')).attr('data-currency',currency);
					
					var currency = child.find('.FutCardAmt').attr('data-currency');
					child.find('#pd_card_fees').text(currency+find_max('.FutCardFee')).attr('data-currency',currency);
					
					
					var currency = child.find('.AcctWorked').attr('data-currency');
					child.find('#AcctWorked').text(currency+sum('.AcctWorked')).attr('data-currency',currency);
					
					var currency = child.find('.Contacts').attr('data-currency');
					child.find('#rpc').text(currency+sum('.Contacts')).attr('data-currency',currency);
					
					
					child.find('#rpc_percent').text(((sum('.Contacts')/sum('.AcctWorked')) * 100).toFixed(1)+"%");
					
					var currency = child.find('.CashCollAmt').attr('data-currency');
					child.find('#Collected').text(currency+sum('.CashCollAmt').toFixed(2)).attr('data-currency',currency).attr('data-value',sum('.CashCollAmt').toFixed(2));
					
					
					child.find('#nsf_percent').text(((sum('.NSF_Amount')/parseFloat(child.find('#Collected').attr('data-value'))) * 100).toFixed(1)+"%");
					
					
					var currency = child.find('.CashCollFee').attr('data-currency');
					child.find('#fees').text(currency+sum('.CashCollFee').toFixed(2)).attr('data-currency',currency).attr('data-value',sum('.CashCollFee').toFixed(2));
					
					var currency = child.find('.FeeBudget').attr('data-currency');
					child.find('#fees_budget').text(currency+sum('.FeeBudget')).attr('data-currency',currency).attr('data-value',sum('.FeeBudget'));
					child.find('#Attainment').text(sum('.FeeBudget'));
					if(parseFloat(child.find('#fees_budget').text()) == 0)
					{
						child.find('#Attainment').css({'color':'red'}).text('0%');
					}
					else
					{
						var value = ((parseFloat(child.find('#fees').attr('data-value'))/parseFloat(child.find('#fees_budget').attr('data-value'))) * 100);
						if(value >= 100)
						{
							child.find('#Attainment').css({'color':'green'}).text(value.toFixed(1)+'%');
						}
						else
						{
							child.find('#Attainment').css({'color':'red'}).text(value.toFixed(1)+'%');
						}
					}
					
					
					child.find('#summary_header').text(current.parent().next().text()+', Your Performance For '+$('#post_period').val());
					$('td:not(.form)').each(function(index,element)
					{
						if(!$(element).is(':visible'))
						{
							$(element).remove();
						}
					});
					
				}
			},request_url, datas, 'text');
		}
		else
		{
			current.parent().parent().next().hide();
		}
	});
</script>

<script>
	function exportF3(elem) {
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
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_tl_agent_process_view'); ?>",
			type:"POST",
			data:$('#get_agent_list_form').serializeArray(),
			success: function(result)
			{
				$("#div1").html(result);
			}
		});
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);
		elem.setAttribute("download", "PMetrix For "+process_name+" ("+view_type+").xls"); // Choose the file name
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
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_tl_agent_view'); ?>",
			type:"POST",
			data:$('#get_agent_list_form').serializeArray(),
			success: function(result)
			{
				$("#div1").html(result);
			}
		});
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);
		elem.setAttribute("download", "PMetrix For Agent "+fusion_id+".xls"); // Choose the file name
		return false;
	}
	function exportF2(elem) {
		var table = document.getElementsByClassName("table");
		var html = '';
		for(var i=0;i<table.length;i++)
		{
			html += table[i].outerHTML+'<br>';
		}
		$.ajax(
		{
			url: "<?php echo base_url('pmetrix_v2_management/log_record/true/pm_tl_agent_view_detail'); ?>",
			type:"POST",
			data:$('#get_agent_list_form').serializeArray(),
			success: function(result)
			{
				$("#div1").html(result);
			}
		});
		var fusion_id = $('#search_type option:selected').val();
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);
		elem.setAttribute("download", "PMetrix Agent View "+fusion_id+".xls"); // Choose the file name
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
		$.when(populate_process_combo(client_id,'<?php echo $pValue; ?>','fprocess_id','N')).done(function()
		{
			$('#view_type').val('').trigger('change');
			//alert('');
			$('#fprocess_id').val('<?php echo $pValue; ?>').trigger('change');
			var process_id = "<?php echo $pValue; ?>";
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
	$(document).on('click','#pay_period_1_btn,#pay_period_2_btn',function()
	{
		$('#online_accept').hide();
		var pay_period = $(this).val();
		var fusion_id = $('#search_type').val();
		var post_period = $('#post_period').val();
		var datas = {'pay_period':pay_period,'fusion_id':fusion_id,'post_period':post_period};
		var request_url = "<?php echo base_url('Pmetrix_v2_agent/get_bouns_info'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(!jQuery.isEmptyObject(res.datas[0]))
			{
				$.each(res.datas[0],function(index,element)
				{
					var online_accept = $('#online_accept');
					if(index == 'accepted_status' && element == 1)
					{
						$(online_accept).parent().html('<b style="color:green">Collectors Bonus Accepted</b>');
						$(online_accept).hide();
					}
					else if(index == 'accepted_status' && element == 0)
					{
						$(online_accept).parent().html('<b style="color:red">Collectors Bonus Not Accepted</b>');
						$(online_accept).hide();
					}
					if($('#vrs_bonous_form').find('#'+index).attr('data-percent'))
					{
						element = (parseFloat(element) * 100).toFixed(2)+'%';
					}
					else
					{
						if(isNaN(element) || element == '')
						{
							element = element;
						}
						else
						{
							element = parseFloat(element).toFixed(2);
						}
					}
					$('#vrs_bonous_form').find('#'+index).text($('#vrs_bonous_form').find('#'+index).attr('data-currency')+''+element);
				});
				$('#vrs_bonous_form textarea').attr('readonly','readonly');
				$('#vrs_bonous_form').modal('show');
			}
			else{
				alert('No Data Found');
			}
		},request_url, datas, 'text');
	});
</script>