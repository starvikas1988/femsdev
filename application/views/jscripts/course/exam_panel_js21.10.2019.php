<script>
	var start = new Date('<?php echo $questions['current_server_time']; ?>');
	var end   = new Date('<?php echo $exam_info->exam_end_time; ?>');
	var timer;

	var compareDate = new Date();
	compareDate.setDate(compareDate.getDate() + 7); //just for this demo today + 7 days

	timer = setInterval(function() {
	start.setSeconds(start.getSeconds() + 1);
	  timeBetweenDates(start,end);
	}, 1000);

	function timeBetweenDates(start,end) {
	  var dateEntered = end;
	  var now = new Date(start);
	  var difference = dateEntered.getTime() - start.getTime();

	  if (difference <= 0) {

		// Timer done
		//clearInterval(timer);
		
		//if time over 
		//loop thorough all question ans marks as skip
		var datas = {'exam_schedule_id':<?php echo $exam_schedule_id; ?>};
		var request_url = "<?php echo base_url('examination/submit_examination'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				window.location.href = "<?php echo base_url('examination/examination_done_page'); ?>";
			}
			else
			{
				alert('Unable to Submit Examination. Server Error!');
			}
		},request_url, datas, 'text');
	  
	  } else {
		
		var seconds = Math.floor(difference / 1000);
		var minutes = Math.floor(seconds / 60);
		var hours = Math.floor(minutes / 60);
		var days = Math.floor(hours / 24);

		hours %= 24;
		minutes %= 60;
		seconds %= 60;

		$("#hours").text(hours);
		$("#minutes").text(minutes);
		$("#count_down").text(hours+':'+minutes+':'+seconds);
	  }
	}
</script>

<script>
	$(document).on('click','.option',function()
	{
		$('#option_selected').removeAttr('id');
		$(this).attr('id','option_selected');
	});
</script>

<script>
	$(document).on('click','#final_ans,#review_ans,#skip_ans',function()
	{
		var option_id = $('#option_selected').attr('data-option_id');
		var question_id = $('#question_container').attr('data-question_id');
		var exam_id = $('#question_container').attr('data-exam_id');
		var set_id = $('#question_container').attr('data-set_id');
		var no_of_ques = $('#question_container').attr('data-no_of_ques');
		if($(this).attr('id') == 'final_ans' || $(this).attr('id') == 'review_ans')
		{
			if(typeof option_id === "undefined")
			{
				alert('Please Select an Option');
				return false;
			}
		}
		if(typeof option_id === "undefined")
		{
			option_id = null;
		}
		
		var datas = {'option_id':option_id,'question_id':question_id,'exam_id':exam_id,'submit_type':$(this).attr('id'),'set_id':set_id,'no_of_ques':no_of_ques};
		if($(this).attr('data-review') == 'true')
		{
			var request_url = "<?php echo base_url('examination/submit_ans_revise'); ?>";
		}
		else
		{
			var request_url = "<?php echo base_url('examination/submit_ans'); ?>";
		}
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				var datas = {'option_id':option_id,'question_id':question_id,'exam_id':exam_id,'set_id':set_id,'no_of_ques':no_of_ques};
				var request_url = "<?php echo base_url('examination/get_question'); ?>";
				$('#option_selected').removeAttr('id');
				process_ajax(function(response)
				{
					var res = JSON.parse(response);
					if(res.stat == true)
					{
						$('#question_container').html(res.datas.question);
						$('#question_container').attr('data-question_id',res.datas.question_id);
						$('#question_container').attr('data-exam_id',exam_id);
						$('#question_container').attr('data-set_id',set_id);
						$('#question_container').attr('data-no_of_ques',no_of_ques);
						var options = res.datas.option.split('###');
						console.log(options);
						var option_ids = res.datas.option_id.split('###');
						$('.option1 div').html(options[0]);
						$('.option1').attr('data-option_id',option_ids[0]);
						
						
						$('.option2 div').html(options[1]);
						$('.option2').attr('data-option_id',option_ids[1]);
						
						
						$('.option3 div').html(options[2]);
						$('.option3').attr('data-option_id',option_ids[2]);
						
						
						$('.option4 div').html(options[3]);
						$('.option4').attr('data-option_id',option_ids[3]);
					}
					else if(res.stat == null)
					{
						var datas = {'option_id':option_id,'question_id':question_id,'exam_id':exam_id,'set_id':set_id,'no_of_ques':no_of_ques};
						var request_url = "<?php echo base_url('examination/get_review_question'); ?>";
						process_ajax(function(response)
						{
							var res = JSON.parse(response);
							if(res.stat == true)
							{
								var options = res.datas.option.split('###');
								var option_ids = res.datas.option_id.split('###');
								
								$('#question_container').html(res.datas.question);
								$('#question_container').attr('data-question_id',res.datas.question_id);
								$('#question_container').attr('data-exam_id',exam_id);
								$('#question_container').attr('data-set_id',set_id);
								$('#question_container').attr('data-no_of_ques',no_of_ques);
								$('.option1 div').html(options[0]);
								$('.option1').attr('data-option_id',option_ids[0]);
								
								
								$('.option2 div').html(options[1]);
								$('.option2').attr('data-option_id',option_ids[1]);
								
								
								$('.option3 div').html(options[2]);
								$('.option3').attr('data-option_id',option_ids[2]);
								
								
								$('.option4 div').html(options[3]);
								$('.option4').attr('data-option_id',option_ids[3]);
								
								$('#final_ans,#review_ans,#skip_ans').attr('data-review','true');
							}
							else if(res.stat == null)
							{
								
								var datas = {'option_id':option_id,'question_id':question_id,'exam_schedule_id':exam_id,'set_id':set_id,'no_of_ques':no_of_ques};
								
								var request_url = "<?php echo base_url('examination/submit_examination'); ?>";
								process_ajax(function(response)
								{
									var res = JSON.parse(response);
									if(res.stat == true)
									{
										window.location.href = "<?php echo base_url('examination/examination_done_page'); ?>";
									}
									else
									{
										alert('Unable to Submit Examination. Server Error!');
									}
								},request_url, datas, 'text');
							}
						},request_url, datas, 'text');
					}
				},request_url, datas, 'text');
			}
		},request_url, datas, 'text');
	});
</script>