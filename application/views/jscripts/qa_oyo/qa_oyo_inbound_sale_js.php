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
				$('#shift_timeing').text(res.datas.shift_time);
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
									alert('No Shift Timing Found');
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
	$(function () {
		$('#audit_date').datepicker();
	});
	$(function () {
		$('#call_duration').timepicker({
			timeFormat: 'HH:mm:ss',
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
		$('.database_value').each(function(index,element)
		{
			var id = $(element).attr('id');
			if($(element).is("input"))
			{
				console.log(id+' - '+$('#'+id).val());
			}
			else if($(element).is("select"))
			{
				if($(element).hasClass('scoring'))
				{
					console.log(id+' - '+$('#'+id).val()+' - '+$('#'+id).parent().prev().text());
				}
				else
				{
					console.log(id+' - '+$('#'+id).val());
				}
			}
			else if($(element).is("textarea"))
			{
				console.log(id+' - '+$('#'+id).val());
			}
			else
			{
				console.log(id+' - '+$('#'+id).text());
			}
		});
	});
</script>