<script>
	$(document).on('submit','#get_tl_list_form',function(e)
	{
		e.preventDefault();
		var datas = $(this).serializeArray();
		var request_url = "<?php echo base_url('Pmetrix_test_tl/prepare_tl_row'); ?>";
		if($('#fprocess_id').val() == 30)
		{
			$('#external_export').hide();
			$('#external_export_30').show();
		}
		else
		{
			$('#external_export').show();
			$('#external_export_30').hide();
		}
		process_ajax(function(response)
		{
			$('#available_users').html(response);
			if($('#fprocess_id').val() == 30)
			{
				//console.log($('.SUP_Name[data-value!="<?php echo get_username(); ?>"]').parent());
				$('.Sup_FEMS_ID[data-value!="<?php echo get_user_fusion_id(); ?>"]').parent().remove();
				$('.open_agent_list').click();
			}
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
			$(agent_list).find('#main_data_container tr td:nth-of-type(2)').each(function(index,element)
			{
				if($(element).text() == 'A')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('#main_data_container tr td:nth-of-type(2)').each(function(index,element)
			{
				if($(element).text() == 'B')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('#main_data_container tr td:nth-of-type(2)').each(function(index,element)
			{
				if($(element).text() == 'C')
				{
					rows += '<tr style="background:#a0f2a0;">'+$(element).parent().html()+'</tr>';
				}
			});
			$(agent_list).find('#main_data_container').html(rows);
			
			//
			if($('#fprocess_id').val() == 30 && $('.unit_summary:eq(0)').text() == '')
			{
				var group_code = [];
				var unique;
				$('#main_data_container tr').each(function(index,element)
				{
					group_code[index] = $(element).find('.GroupCode').attr('data-value');
				});
				unique = group_code.filter( onlyUnique );
				for (i = 0; i < unique.length - 1; i++) {
					$('.summary_body:nth-of-type(1)').clone().appendTo("#score_table_vrs").append('<br>');
				}
				$('.summary_body:nth-of-type(1)').after('<br>');
				for (i = 0; i < unique.length; i++) {
					$('.unit_summary:eq('+i+')').text(unique[i]);
					
					$('.total_collector_summary:eq('+i+')').text($('#main_data_container tr td[data-value="'+unique[i]+'"]').length);
					
					var budget_attained = 0;
					$('#main_data_container tr td.attainment_percent[data-unit="'+unique[i]+'"]').each(function(index,element)
					{
						if(parseInt($(element).attr('data-value')) >= 100)
						{
							budget_attained++;
						}
					});
					$('.budget_attained_summary:eq('+i+')').text(budget_attained);
					
					$('.pd_cheque_amt_summary:eq('+i+')').text('$'+sum('#main_data_container tr td.FutChkAmt[data-unit="'+unique[i]+'"]'));
					$('.pd_cheque_fees_summary:eq('+i+')').text('$'+sum('#main_data_container tr td.FutChkFee[data-unit="'+unique[i]+'"]'));
					$('.pd_card_amt_summary:eq('+i+')').text(sum('#main_data_container tr td.FutCardAmt[data-unit="'+unique[i]+'"]'));
					$('.pd_card_fees_summary:eq('+i+')').text(sum('#main_data_container tr td.FutCardFee[data-unit="'+unique[i]+'"]'));
					
					var acctworked = sum('#main_data_container tr td.AcctWorked[data-unit="'+unique[i]+'"]');
					$('.AcctWorked_summary:eq('+i+')').text(acctworked);
					
					var rpc = sum('#main_data_container tr td.Contacts[data-unit="'+unique[i]+'"]');
					$('.rpc_summary:eq('+i+')').text(rpc);
					
					
					
					$('.rpc_percent_summary:eq('+i+')').text(  ((parseFloat(rpc)/parseFloat(acctworked)) * 100).toFixed(2)+'%');
					
					var collected = sum('#main_data_container tr td.CashCollAmt[data-unit="'+unique[i]+'"]');
					$('.Collected_summary:eq('+i+')').text('$'+collected);
					
					var nsf = sum('#main_data_container tr td.NSF_Amount[data-unit="'+unique[i]+'"]');
					$('.nsf_percent_summary:eq('+i+')').text((( nsf / collected )*100).toFixed(2)+"%");
					
					var fees = sum('#main_data_container tr td.CashCollFee[data-unit="'+unique[i]+'"]');
					$('.fees_summary:eq('+i+')').text('$'+fees);
					
					var fees_budget = sum('#main_data_container tr td.FeeBudget[data-unit="'+unique[i]+'"]');
					$('.fees_budget_summary:eq('+i+')').text('$'+fees_budget);
					
					
					
					if(fees_budget == 0)
					{
						$('.Attainment_summary:eq('+i+')').css({'color':'red'}).text('0%');
					}
					else
					{
						var atain_percent = (( fees / fees_budget )*100).toFixed(2);
						if(atain_percent >= 100)
						{
							$('.Attainment_summary:eq('+i+')').css({'color':'green'}).text(atain_percent+'%');
						}
						else
						{
							$('.Attainment_summary:eq('+i+')').css({'color':'red'}).text(atain_percent+'%');
						}
					}
				}
				
				$('#summary_header').text($('#summary_header').text()+' '+$('#post_period').val());
				
				$('td:not(.form),th:not(.form)').each(function(index,element) 
				{
					if(!$(element).is(':visible'))
					{
						$(element).remove();
					}
				});
			}
		}
		else
		{
			$(this).parent().parent().next().hide();
		}
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
	
	function exportF30(elem)
	{
		$('#main_data_container tr').removeAttr('style').css({'background':'#edf0f5'});
		var table = $(".agent_list table");
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
		elem.setAttribute("download", $('#summary_header').text()+".xls"); // Choose the file name
	}
	
	function exportF3(elem) {
		
		if($('#fprocess_id').val() == 30)
		{
			
			var table = $("#single_agent_modal table");
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
			elem.setAttribute("download", $('#single_agent_modal #summary_header').text()+".xls"); // Choose the file name
		}
		else
		{
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
		}
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
	$(document).on('click','.agent_name',function(e)
	{
		var fusion_id = $(this).attr('data-fusion_id');
		$('#single_agent_modal').modal('show');
		var datas = $('#get_tl_list_form').serializeArray();
		var supervisor_name = $(this).text();
		
		
		datas.push({name: 'fusion_id', value: fusion_id},{name: 'view_type', value: 1},{name: 'others_team	', value: ''},{name: 'performance_for_month	', value: ''},{name: 'performance_for_year	', value: ''});
		
		var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
		process_ajax(function(response)
		{
			$('#single_agent_modal .modal-body').html(response);
			
			var child = $('#single_agent_modal');
			
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
			child.find('#pd_cheque_amt').text(currency+find_max('#single_agent_modal .FutChkAmt')).attr('data-currency',currency);
			
			var currency = child.find('.FutChkFee').attr('data-currency');
			child.find('#pd_cheque_fees').text(currency+find_max('#single_agent_modal .FutChkFee')).attr('data-currency',currency);
			
			var currency = child.find('.FutCardAmt').attr('data-currency');
			child.find('#pd_card_amt').text(currency+find_max('#single_agent_modal .FutCardAmt')).attr('data-currency',currency);
			
			var currency = child.find('.FutCardAmt').attr('data-currency');
			child.find('#pd_card_fees').text(currency+find_max('#single_agent_modal .FutCardFee')).attr('data-currency',currency);
			
			
			var currency = child.find('.AcctWorked').attr('data-currency');
			child.find('#AcctWorked').text(currency+sum_new('#single_agent_modal .AcctWorked')).attr('data-currency',currency);
			
			var currency = child.find('.Contacts').attr('data-currency');
			child.find('#rpc').text(currency+sum_new('#single_agent_modal .Contacts')).attr('data-currency',currency);
			
			
			child.find('#rpc_percent').text(((sum_new('#single_agent_modal .Contacts')/sum_new('#single_agent_modal .AcctWorked')) * 100).toFixed(1)+"%");
			
			var currency = child.find('.CashCollAmt').attr('data-currency');
			child.find('#Collected').text(currency+sum_new('#single_agent_modal .CashCollAmt').toFixed(2)).attr('data-currency',currency).attr('data-value',sum_new('#single_agent_modal .CashCollAmt').toFixed(2));
			
			
			child.find('#nsf_percent').text(((sum_new('#single_agent_modal .NSF_Amount')/parseFloat(child.find('#Collected').attr('data-value'))) * 100).toFixed(1)+"%");
			
			
			var currency = child.find('.CashCollFee').attr('data-currency');
			child.find('#fees').text(currency+sum_new('#single_agent_modal .CashCollFee').toFixed(2)).attr('data-currency',currency).attr('data-value',sum_new('#single_agent_modal .CashCollFee').toFixed(2));
			
			var currency = child.find('.FeeBudget').attr('data-currency');
			child.find('#fees_budget').text(currency+sum_new('#single_agent_modal .FeeBudget')).attr('data-currency',currency).attr('data-value',sum_new('#single_agent_modal .FeeBudget'));
			child.find('#Attainment').text(sum_new('#single_agent_modal .FeeBudget'));
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
			
			
			child.find('#summary_header').text(supervisor_name+', Your Performance For '+$('#post_period').val());
			$('td:not(.form)').each(function(index,element)
			{
				if(!$(element).is(':visible'))
				{
					$(element).remove();
				}
			});
		},request_url, datas, 'text');
	});
</script>

<script>
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
	
	function sum_new(class_name,current=false,current_stat=false)
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
	$(document).on('click','#pay_period_1_btn,#pay_period_2_btn',function()
	{
		$('#online_accept').hide();
		var pay_period = $(this).val();
		var fusion_id = $('#final_summary #fusion_id').text();
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