<script>
	
	$(document).ready(function(e){
		
		$('#process_id,#office_id').change(function()
		{
			
			if($('#process_id').val() != '' && $('#office_id').val() !='')
			{	
				var process_id = $('#process_id').val();
				var office_id = $('#office_id').val();
				if(process_id=="") process_id = $('#process_id').val();
				var datas = {"client_id":"<?php echo $client_id; ?>","process_id":process_id,"office_id":office_id,"current_user":"<?php echo get_user_id(); ?>"};
				
				if(process_id=='sig_dsat'){
					var request_url = "<?php echo base_url('qa_dashboard/get_rca_data'); ?>";
				}else if(process_id=='oyo_life'){
					var request_url = "<?php echo base_url('qa_dashboard/oyo_life_ibobfollow'); ?>";
				}else{
					var request_url = "<?php echo base_url('qa_dashboard/get_qa_scores'); ?>";
				}
				
				process_ajax(function(response)
				{
					var res = JSON.parse(response);
					if(res.stat == true)
					{
						$.each(res.datas,function(index,values)
						{
							if(values == null)
							{
								values = 0;
							}
							if(index== 'get_agent_fd_acpt'){
								$('#get_agent_fd_acpt').html(values);
							}
							else if(index== 'get_agent_fd_pnd'){
								$('#get_agent_fd_pnd').html(values);
							}
						/////////	
							else if(index=='control_dsat'){
								$('#control_dsat').html(values);
							}
							else if(index=='control_dsat_per'){
								$('#control_dsat_per').html(values);
							}
							else if(index=='uncontrol_dsat'){
								$('#uncontrol_dsat').html(values);
							}
							else if(index=='uncontrol_dsat_per'){
								$('#uncontrol_dsat_per').html(values);
							}
							else if(index=='tot_audit'){
								$('#tot_audit').html(values);
							}
							else if(index=='control_uncontrol_tot'){
								$('#control_uncontrol_tot').html(values);
							}
						////////	
							else if(index=='property_dsat'){
								$('#property_dsat').html(values);
							}
							else if(index=='property_dsat_per'){
								$('#property_dsat_per').html(values);
							}
							else if(index=='process_dsat'){
								$('#process_dsat').html(values);
							}
							else if(index=='process_dsat_per'){
								$('#process_dsat_per').html(values);
							}
							else if(index=='agent_dsat'){
								$('#agent_dsat').html(values);
							}
							else if(index=='agent_dsat_per'){
								$('#agent_dsat_per').html(values);
							}
							else if(index=='customer_dsat'){
								$('#customer_dsat').html(values);
							}
							else if(index=='customer_dsat_per'){
								$('#customer_dsat_per').html(values);
							}
							else if(index=='technology_dsat'){
								$('#technology_dsat').html(values);
							}
							else if(index=='technology_dsat_per'){
								$('#technology_dsat_per').html(values);
							}
							else if(index=='tot_dsat'){
								$('#tot_dsat').html(values);
							}
							else if(index=='acpt_tot_per'){
								$('#acpt_tot_per').html(values);
							}
						//////////	
							else if(index=='acpt_agent1'){
								$('#acpt_agent1').html(values);
							}
							else if(index=='acpt_agent2'){
								$('#acpt_agent2').html(values);
							}
							else if(index=='acpt_agent3'){
								$('#acpt_agent3').html(values);
							}
							else if(index=='acpt_agent4'){
								$('#acpt_agent4').html(values);
							}
							else if(index=='acpt_customer'){
								$('#acpt_customer').html(values);
							}
							else if(index=='acpt_process1'){
								$('#acpt_process1').html(values);
							}
							else if(index=='acpt_process2'){
								$('#acpt_process2').html(values);
							}
							else if(index=='acpt_process3'){
								$('#acpt_process3').html(values);
							}
							else if(index=='acpt_process4'){
								$('#acpt_process4').html(values);
							}
							else if(index=='acpt_process5'){
								$('#acpt_process5').html(values);
							}
							else if(index=='acpt_property1'){
								$('#acpt_property1').html(values);
							}
							else if(index=='acpt_property2'){
								$('#acpt_property2').html(values);
							}
							else if(index=='acpt_tech'){
								$('#acpt_tech').html(values);
							}
							else if(index=='grn_tot'){
								$('#grn_tot').html(values);
							}
							
							else if(index == 'oyo_life_booking')
							{
								var oyo_life_booking = '';
								$.each(values,function(ind,val)
								{
									oyo_life_booking += '<tr>';
									$.each(val,function(i,v)
									{
										oyo_life_booking += '<td>'+v+'</td>';
									});
									oyo_life_booking += '</tr>';
								});
								
								$('.oyo_life_booking').html(oyo_life_booking);
							}
						/////////
							else if(index == 'agent_record')
							{
								var agent_record = '';
								$.each(values,function(index,value)
								{
									agent_record += '<tr><td>'+value.agent_name.datas+'</td><td>'+value.own_mtd_no_of_audit.datas+'</td><td>'+parseFloat(value.own_mtd_score.datas).toFixed(2)+'</td><td>'+value.own_wtd_no_of_audit.datas+'</td><td>'+parseFloat(value.own_wtd_score.datas).toFixed(2)+'</td><td>'+value.own_ytd_no_of_audit.datas+'</td><td>'+parseFloat(value.own_ytd_score.datas).toFixed(2)+'</td></tr>';
								});
								$('#agent_record').html(agent_record);
							}
							else if(index == 'defects')
							{
								var defects_all = '';
								$.each(values.defects_all,function(index,value)
								{
									defects_all += '<tr><td>'+values.defect_column_names[index]+'</td><td>'+((parseInt(value)/parseInt(values.defects_all_count))*100).toFixed(2)+'%</td></tr>';
								});
								$('.defects_all').html(defects_all);
								
								var defects_all_accuracy = '';
								$.each(values.defects_all_accuracy,function(index,value)
								{
									defects_all_accuracy += '<tr><td>'+values.defect_column_names[index]+'</td><td>'+((parseInt(value)/parseInt(values.defects_all_count_accuracy))*100).toFixed(2)+'%</td></tr>';
								});
								$('.defects_all_accuracy').html(defects_all_accuracy);
							}
							else
							{
								if($('.'+index).attr('data-type')== 'int')
								{
									$('.'+index).text(parseInt(values));
								}
								else if($('.'+index).attr('data-type1')== 'float')
								{
									$('.'+index).text(parseFloat(values));
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
						alert('No Information Found');
					}
				},request_url, datas, 'text');
			}
		
		/////////////////	
			 if(process_id==153){
				 $('#qa_portal_view').show();
			 }else{
				 $('#qa_portal_view').hide();
			 }
			 
			 if(process_id==168){
				 $('#int_agnt').show();
			 }else{
				 $('#int_agnt').hide();
			 }
			 
			 if(process_id==19){
				$('#verso_ob').show();
				$('#voc_scorecard').hide();
			 }else{
				$('#verso_ob').hide();
				$('#voc_scorecard').show();
			 }
			 
			 if(process_id=="sig_dsat"){
				 $('#sigrca_dsat').show();
				 $('#dsat_sigrca').hide();
			 }else{
				 $('#sigrca_dsat').hide();
				 $('#dsat_sigrca').show();
			 }
			 
			 if(process_id=="oyo_life"){
				 $('#oyo_life').show();
				 $('#dsat_sigrca').hide();
			 }else{
				 $('#oyo_life').hide();
				 $('#dsat_sigrca').show();
			 }
			 
			 if(process_id==29 || process_id==213 || process_id==31){
				 $('#agent_score').show();
				 $('#user_tenure').hide();
			 }else{
				 $('#agent_score').hide();
				 $('#user_tenure').show();
			 }
			 
		///////////////	
		});
		
		
		var pValue = "<?php echo $pValue; ?>"
		$('#process_id').val(pValue);
		$('#process_id').trigger("change");
		
	});
</script>