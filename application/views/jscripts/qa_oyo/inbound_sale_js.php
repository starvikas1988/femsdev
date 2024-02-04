<script>
	function do_calculation()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		var grade = '';
		$('.scoring').each(function(index,element)
		{
			var score_type = $(element).val();
			
			if(score_type == 'Pass')
			{
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).parent().parent().find('.weightage_value').text());
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
			else if(score_type == 'Fail')
			{
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).parent().parent().find('.weightage_value').text());
				scoreable = scoreable + weightage;
			}
			else if(score_type == 'N/A')
			{
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(1);
		console.log(score);
		console.log(scoreable);
		console.log(quality_score_percent);
		
		console.log(grade);
		if($('#infraction_stat').val() == 'Yes')
		{
			score = 0;
			quality_score_percent = 0;
			grade = grade_cal(quality_score_percent);
			$('#total_score').text(score);
			$('#total_scoreable').text(scoreable);
			$('#quality_score_percent').text(quality_score_percent+'%');
			$('#overall_score').text(quality_score_percent+'%');
			$('#grade').text(grade);
			$('#overall_result').text(grade);
			$('#pass_count').text(pass_count);
			$('#fail_count').text(fail_count);
			$('#na_count').text(na_count);
			$('#na_percent').text(((na_count*100)/(pass_count+fail_count)).toFixed(1)+'%');
		}
		else
		{
			grade = grade_cal(quality_score_percent);
			$('#total_score').text(score);
			$('#total_scoreable').text(scoreable);
			$('#quality_score_percent').text(quality_score_percent+'%');
			$('#overall_score').text(quality_score_percent+'%');
			$('#grade').text(grade);
			$('#overall_result').text(grade);
			$('#pass_count').text(pass_count);
			$('#fail_count').text(fail_count);
			$('#na_count').text(na_count);
			$('#na_percent').text(((na_count*100)/(pass_count+fail_count)).toFixed(1)+'%');
		}
	}
	function grade_cal(quality_score_percent)
	{
		if(quality_score_percent >= 100)
		{
			grade = 'A+';
		}
		else if(quality_score_percent >= 95 && quality_score_percent < 100)
		{
			grade = 'A';
		}
		else if(quality_score_percent >= 85 && quality_score_percent < 95)
		{
			grade = 'B';
		}
		else if(quality_score_percent >= 75 && quality_score_percent < 85)
		{
			grade = 'C';
		}
		else
		{
			grade = 'D';
		}
		return grade;
	}
	
	
	$(document).on('change','.scoring',function()
	{
		do_calculation();
	});
	$(document).on('change','#infraction_stat',function()
	{
		do_calculation();
	});
	do_calculation();
</script>
<script>
	$(document).on('blur','#record_date_time',function()
	{
		var agent_id = $('#agent_id').val();
		var record_date_time = $(this).val();
		if(agent_id != '')
		{
			var datas = {'record_date_time':record_date_time,'agent_id':agent_id};
			var request_url = "<?php echo base_url('qa_oyo/get_shift_timing'); ?>";
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				$('#shift_timeing').val(res.datas.in_time+'-'+res.datas.out_time);
			},request_url, datas, return_type = 'text');
		}
	});
</script>
<script>
	$(document).on('blur','#fusion_id',function()
	{
		var request_url = "<?php echo base_url('qa_oyo/get_agent_information'); ?>";
		var fusion_id = $(this).val();
		if(fusion_id.length > 9)
		{
			var datas = {'fusion_id':fusion_id};
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				$.each(res.datas,function(index,element)
				{
					if($('#'+index).prev().is("input"))
					{
						$('#'+index).val(element);
					}
					else
					{
						$('#'+index).text(element);
					}
					console.log(index+' - '+element);
				});
			},request_url, datas, return_type = 'text');
		}
	});
</script>
<script type="text/javascript">
	$(function () {
		$('#record_date_time').datetimepicker({
			dateFormat: 'yy-mm-dd', 
			timeFormat: 'HH:mm:ss',
			onSelect: function(dateText) {
					var agent_id = $('#agent_id').text();
					var record_date_time = dateText;
					if(agent_id != '')
					{
						var datas = {'record_date_time':record_date_time,'agent_id':agent_id};
						var request_url = "<?php echo base_url('qa_oyo/get_shift_timing'); ?>";
						process_ajax(function(response)
						{
							var res = JSON.parse(response);
							if(res.stat == true)
							{
								if(res.datas.in_time != 'OFF')
								{
									$('#shift_timeing').text(hours_am_pm(res.datas.in_time)+' '+hours_am_pm(res.datas.out_time));
								}
								else
								{
									$('#shift_timeing').text('');
									//alert('No Shift Timing Found');
								}
							}
							else
							{
								$('#shift_timeing').text('');
								alert('No Shift Timing Found');
							}
						},request_url, datas, return_type = 'text');
					}
			}
		});
	});
	/* $(function () {
		$('#audit_date').datepicker({
			dateFormat: 'yy-mm-dd'
		});
	}); */
	$(function () {
		$('#call_duration').timepicker({
			timeFormat: 'HH:mm:ss',
		});
	});
	$(function () {
		$('#from_date').datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
	$(function () {
		$('#to_date').datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
</script>

<script>
	function hours_am_pm(time) {
		if(isNaN(time[1]))
		{
			time = '0'+time;
		}
        var hours = time[0] + time[1];
        var min = time[2] + time[3];
        if (hours < 12) {
            return hours + ':' + min + ' AM';
        } else {
            hours=hours - 12;
            hours=(hours.length < 10) ? '0'+hours:hours;
            return hours+ ':' + min + ' PM';
        }
	}
</script>
 
<script>
	$(document).on('click','#submit',function(e)
	{
		e.preventDefault();
		var datas = new FormData();
		var fusion_id = $('#fusion_id').val();
		var record_date_time = $('#record_date_time').val();
		var call_type = $('#call_type').val();
		var audit_type = $('#audit_type').val();
		var voc = $('#voc').val();
		if(fusion_id != '' && record_date_time != '' && call_type != '' && audit_type !='' && voc !='')
		{
			$('.database_value').each(function(index,element)
			{
				var id = $(element).attr('id');
				if($(element).is("input"))
				{
					//console.log(id+' - '+$('#'+id).val());
					//datas[id] = $('#'+id).val();
					datas.append( id, $('#'+id).val());
				}
				else if($(element).is("select"))
				{
					if($(element).hasClass('scoring'))
					{
						//console.log(id+' - '+$('#'+id).val()+' - '+$('#'+id).parent().prev().text());
						if($('#'+id).val() == "Pass")
						{
							//datas[id] = $('#'+id).parent().prev().text();
							datas.append( id, $('#'+id).parent().prev().text());
						}
						else if($('#'+id).val() == "Fail")
						{
							//datas[id] = 0;
							datas.append( id, 0);
						}
					}
					else
					{
						//console.log(id+' - '+$('#'+id).val());
						//datas[id] = $('#'+id).val();
						datas.append( id, $('#'+id).val());
					}
				}
				else if($(element).is("textarea"))
				{
					//console.log(id+' - '+$('#'+id).val());
					//datas[id] = $('#'+id).val();
					datas.append( id, $('#'+id).val());
				}
				else
				{
					//console.log(id+' - '+$('#'+id).text());
					//datas[id] = $('#'+id).text();
					datas.append( id, $('#'+id).text());
				}
			});
			//console.log(datas);
			if(typeof($('#inputGroupFile01')[0].files[0]) !== 'undefined')
			{
				datas.append( 'attach_file', $('#inputGroupFile01')[0].files[0]);
			}
			var url = "<?php echo base_url('qa_oyo/process_inbound_sales'); ?>";
			
			//alert(url + "?"+ $('form.frmEditProcess').serialize());
			
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					alert('Information Saved');
					
					$('.database_value').each(function(index,element)
					{
						if($(element).attr('id') == 'audit_date')
						{
							return;
						}
						else if($(element).attr('id') == 'auditor_name')
						{
							return;
						}
						if($(element).is("input"))
						{
							$(element).val('');
						}
						else if($(element).is("select"))
						{
							if($(element).hasClass('scoring'))
							{
								$(element).val('Pass');
							}
							else
							{
								$(element).val('');
							}
						}
						else if($(element).is("textarea"))
						{
							$(element).val('');
						}
						else
						{
							$(element).text('');
						}
					});
					$('#team_leader_name,#manager_name').text('');
					$('#infraction_stat').val('No');
					do_calculation();
					$('#inputGroupFile01').val('');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#audit_date').val('<?php echo date('Y-m-d'); ?>');
				}
				else
				{
					alert('Try After Some Time');
				}
			},url,datas, 'text','POST','file');
		}
		else
		{
			alert('Fusion ID, Record Date & Time & Call Type is Required');
		}
		
	});
</script>

<script>
///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	
	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});	
</script>


<script>
	$(document).on('click','#submit_edit',function(e)
	{
		e.preventDefault();
		var datas = new FormData();
		var fusion_id = $('#fusion_id').val();
		var record_date_time = $('#record_date_time').val();
		var call_type = $('#call_type').val();
		var audit_type = $('#audit_type').val();
		var voc = $('#voc').val();
		if(fusion_id != '' && record_date_time != '' && call_type != '' && audit_type !='' && voc !='')
		{
			$('.database_value').each(function(index,element)
			{
				var id = $(element).attr('id');
				if($(element).is("input"))
				{
					//console.log(id+' - '+$('#'+id).val());
					//datas[id] = $('#'+id).val();
					datas.append( id, $('#'+id).val());
				}
				else if($(element).is("select"))
				{
					if($(element).hasClass('scoring'))
					{
						//console.log(id+' - '+$('#'+id).val()+' - '+$('#'+id).parent().prev().text());
						if($('#'+id).val() == "Pass")
						{
							//datas[id] = $('#'+id).parent().prev().text();
							datas.append( id, $('#'+id).parent().prev().text());
						}
						else if($('#'+id).val() == "Fail")
						{
							//datas[id] = 0;
							datas.append( id, 0);
						}
					}
					else
					{
						//console.log(id+' - '+$('#'+id).val());
						//datas[id] = $('#'+id).val();
						datas.append( id, $('#'+id).val());
					}
				}
				else if($(element).is("textarea"))
				{
					//console.log(id+' - '+$('#'+id).val());
					//datas[id] = $('#'+id).val();
					datas.append( id, $('#'+id).val());
				}
				else
				{
					//console.log(id+' - '+$('#'+id).text());
					//datas[id] = $('#'+id).text();
					datas.append( id, $('#'+id).text());
				}
			});
			
			var url = "<?php echo base_url('qa_oyo/process_inbound_sales_edit'); ?>";
			
			//alert(url + "?"+ $('form.frmEditProcess').serialize());
			
			process_ajax(function(response)
			{
				var res = JSON.parse(response);
				if(res.stat == true)
				{
					alert('Information Saved');
					
					window.location = "<?php echo base_url('qa_oyo'); ?>";
				}
				else
				{
					alert('Try After Some Time');
				}
			},url,datas, 'text','POST','file');
		}
		else
		{
			alert('Fusion ID, Record Date & Time & Call Type is Required');
		}
		
	});
</script>


<script>
	$('#activate_get_fusion_id').click(function()
	{
		$('#get_fusion_id').modal('show');
	});
</script>

<script>

	$("#fetch_agents_qa").click(function(){
  
		var URL='<?php echo base_url();?>user/getAgentList';
		
		var aname=$('#aname').val();
		
		var aomuid=$('#aomuid').val();
		
		//alert(URL+"?aname="+aname+"&aomuid"+aomuid);
		
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'aname='+aname+'&aomuid='+aomuid,
		   success: function(aList){
					
				//alert(aList);
					
				var json_obj = $.parseJSON(aList);//parse JSON
				
				var html = '<table id="tbXXX" border="1" class="table table-striped" cellspacing="0" width="100%" >';
				
					html += '</head>';
					html += '<tr>';
					html += '<th>Fusion ID</th>';
					html += '<th>First Name</th>';
					html += '<th>Last Name</th>';
					html += '<th>OM-ID</th>';
					html += '<th>Process</th>';
					html += '</tr>';
					html += '</head>';
					html += '<tbody>';
				
				
				for (var i in json_obj) 
				{
					html += '<tr class="agent_row" id="'+json_obj[i].fusion_id+'" aname="'+json_obj[i].fname+" "+json_obj[i].lname+'" >';
					html += '<TD>'+json_obj[i].fusion_id+'</TD>';
					html += '<TD>'+json_obj[i].fname+'</TD>';
					html += '<TD>'+json_obj[i].lname+'</TD>';
					html += '<TD>'+json_obj[i].omuid+'</TD>';
					html += '<TD>'+json_obj[i].process_names+'</TD>';
					html += '</tr>';
				}
				html += '</tbody>';
				
				html += '</table>';
				$("#search_agent_rec").html(html);
			
			},
			error: function(){	
				alert('Fail!');
			}
		  });
		  
	});
	$(document).on('click', '.agent_row', function(){
		var fid=$(this).attr("id");
		var aname=$(this).attr("aname");
		//$("#agent_name").val(aname);
		$("#fusion_id").val(fid);
		$("#fusion_id").focus();
		
		$('#get_fusion_id').modal("hide");		
	});
</script>

	