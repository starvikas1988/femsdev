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
		var fusion_id = "<?php echo $fusion_id ?>";
		var user_id = 0;
		var process_id = "<?php echo $pValue ?>";
		if(process_id == 30)
		{
			var performance_for_month = '';
			var performance_for_year = '';			
		}
		else
		{
			var performance_for_month = $('[name="performance_for_month"]').val();
			var performance_for_year = $('[name="performance_for_year"]').val();
			fusion_id = "<?php echo $fusion_id; ?>";
		}
		var post_period = $('#post_period').val();
		
		
		var others_team = <?php echo $tl_id; ?>;
		var view_type = 2;
		var datas = {'process_id':process_id,'fusion_id':fusion_id,'performance_for_month':performance_for_month,'performance_for_year':performance_for_year,'user_id':user_id,'others_team':others_team,'view_type':view_type,'post_period':post_period};
		if(process_id == 30)
		{
			var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
		}
		else
		{
			if(fusion_id == 1)
			{
				var request_url = "<?php echo base_url('Pmetrix_v2_tl/prepare_row/true'); ?>";
			}
			else
			{
				var request_url = "<?php echo base_url('Pmetrix_v2_agent/prepare_row/true'); ?>";
			}
		}
		process_ajax(function(response)
		{
			if(process_id != 30)
			{
				$("#search_metrix_container").empty().html(response);
				/*
				if(fusion_id == 1){
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
				else{
					$('#available_users').html(response)
				}
				*/
			}
			else
			{
				$('#search_metrix_container').html(response);
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
				$('#summary_header').text('Your Performance For '+$('#post_period').val()+" ("+$('#fusion_id').text()+")");
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
	$(document).on('click','#pay_period_1_btn,#pay_period_2_btn',function()
	{
		$('#vrs_bonous_form [name="pay_period"]').val($(this).val());
		var pay_period = $(this).val();
		var fusion_id = "<?php echo get_user_fusion_id(); ?>";
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
						$('#vrs_bonous_form textarea').attr('readonly','readonly');
						$(online_accept).parent().html('<b style="color:green">Collectors Bonus Accepted</b>');
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
				$('#vrs_bonous_form').modal('show');
			}
			else{
				alert('No Data Found');
			}
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click','#online_accept',function()
	{
		
		var pay_period = $(this).val();
		var fusion_id = "<?php echo get_user_fusion_id(); ?>";
		var post_period = $('#post_period').val();
		var datas = $('#vrs_bonous_form_form').serializeArray();
		datas.push({name: 'fusion_id', value: fusion_id});
		datas.push({name: 'post_period', value: post_period});
		
		var request_url = "<?php echo base_url('Pmetrix_v2_agent/process_bonus'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#vrs_bonous_form').modal('hide');
			}
			
		},request_url, datas, 'text');
	});
</script>