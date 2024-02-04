<script>
	<?php
		if($exam_info->exam_start_time == '')
		{
	?>
			var start = new Date();
			var end   = new Date();
			end.setMinutes(<?php echo $exam_info->allotted_time; ?> );
	<?php
		}
		else
		{
			$minutes_to_add = $exam_info->allotted_time;
			$time = new DateTime($exam_info->exam_start_time);
			
			$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

			$stamp = $time->format('Y-m-d H:i:s');
	?>
			var start = new Date();
			
			var end   = new Date('<?php echo $stamp; ?>');
	<?php
		}
	?>
	console.log(end);
	var timer;

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
		var request_url = "<?php echo base_url('course/submit_exam'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				window.location.href = "<?php echo base_url('course'); ?>";
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
	$(document).ready(function()
	{
		var question_id = $('[data-question_id][not_ans="true"]').attr('data-question_id');
		if (typeof question_id === "undefined") {
			var question_id = $('[data-question_id][review="true"]').attr('data-question_id');
			if (typeof question_id === "undefined") {
				var question_id = $('[data-question_id][select="true"]').attr('data-question_id');
			}
		}
		var exam_schedule_id = $('#question_container').attr('data-exam_schedule_id');
		var datas = {'question_id':question_id,'exam_schedule_id':exam_schedule_id};
		var request_url = "<?php echo base_url('course/get_first_question'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#question_container').html(res.datas[0].title);
				$('#question_container').attr('data-current_question_id',res.datas[0].id);
				$('[data-question_id="'+res.datas[0].id+'"]').css({'border':'2px solid red'});
				var options = '';
				$.each(res.datas,function(index,element)
				{
					if(element.status == '1')
					{
						$('[data-question_id="'+res.datas[0].id+'"]').attr('select','true');
					}
					else if(element.status == '2')
					{
						$('[data-question_id="'+res.datas[0].id+'"]').attr('review','true');
					}
					else if(element.status == '0')
					{
						$('[data-question_id="'+res.datas[0].id+'"]').attr('not_ans','true');
					}
					if(element.ans_id == element.option_id)
					{
						options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'" checked="true"> '+element.text+'</li>';
					}
					else
					{
						if(element.text !== ''){
							options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'"> '+element.text+'</li>';
						}
					}
				});
				$('#option_container').html(options);
			}
		},request_url, datas, 'text');
	});
	
</script>
<script>
	$(document).on('click','#next',function()
	{
		var question_id = $('#question_container').attr('data-current_question_id');
		var next_question = $('[data-question_id="'+question_id+'"]').next().attr('data-question_id');
		if (typeof next_question === "undefined") {
			next_question = question_id;
			
		}
		var exam_schedule_id = $('#question_container').attr('data-exam_schedule_id');
		var option_id = $('[name="correct_option"]:checked').val();
		if (typeof option_id === "undefined") {
			option_id = '0';
		}
		else
		{
			$('[data-question_id="'+question_id+'"]').removeAttr('select');
			$('[data-question_id="'+question_id+'"]').removeAttr('review');
			$('[data-question_id="'+question_id+'"]').removeAttr('not_ans');
			$('[data-question_id="'+question_id+'"]').attr('select','true');
		}
		
		
		
		var datas = {'question_id':question_id,'option_id':option_id,'exam_schedule_id':exam_schedule_id};
		var request_url = "<?php echo base_url('course/submit_question'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				
				var datas = {'question_id':next_question,'exam_schedule_id':exam_schedule_id};
				var request_url = "<?php echo base_url('course/get_question'); ?>";
				process_ajax(function(response)
				{
					var res = JSON.parse(response);
					if(res.stat == true)
					{
						$('#question_container').html(res.datas[0].title);
						$('#question_container').attr('data-current_question_id',res.datas[0].id);
						$('[data-question_id]').removeAttr('style');
						$('[data-question_id="'+res.datas[0].id+'"]').css({'border':'2px solid red'});
						var options = '';
						$.each(res.datas,function(index,element)
						{
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('select');
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('review');
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('not_ans');
							if(element.status == '1')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('select','true');
							}
							else if(element.status == '2')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('review','true');
							}
							else if(element.status == '0')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('not_ans','true');
							}
							if(element.ans_id == element.option_id)
							{
								options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'" checked="true"> '+element.text+'</li>';
							}
							else
							{
								if(element.text !==''){
									options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'"> '+element.text+'</li>';
								}
							}
						});
						$('#option_container').html(options);
					}
				},request_url, datas, 'text');
			}
			else
			{
				var datas = {'question_id':next_question,'exam_schedule_id':exam_schedule_id};
				var request_url = "<?php echo base_url('course/get_question'); ?>";
				process_ajax(function(response)
				{
					var res = JSON.parse(response);
					if(res.stat == true)
					{
						$('#question_container').html(res.datas[0].title);
						$('#question_container').attr('data-current_question_id',res.datas[0].id);
						$('[data-question_id]').removeAttr('style');
						$('[data-question_id="'+res.datas[0].id+'"]').css({'border':'2px solid red'});
						var options = '';
						$.each(res.datas,function(index,element)
						{
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('select');
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('review');
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('not_ans');
							if(element.status == '1')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('select','true');
							}
							else if(element.status == '2')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('review','true');
							}
							else if(element.status == '0')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('not_ans','true');
							}
							if(element.ans_id == element.option_id)
							{
								options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'" checked="true"> '+element.text+'</li>';
							}
							else
							{
								if(element.text !==''){
									options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'"> '+element.text+'</li>';
								}
							}
						});
						$('#option_container').html(options);
					}
				},request_url, datas, 'text');
			}
		},request_url, datas, 'text');
	});
</script>

<script>
	$(document).on('click','#previous',function()
	{
		var question_id = $('#question_container').attr('data-current_question_id');
		var prev_question = $('[data-question_id="'+question_id+'"]').prev().attr('data-question_id');
		if (typeof prev_question === "undefined") {
			prev_question = question_id;
			
		}
		var exam_schedule_id = $('#question_container').attr('data-exam_schedule_id');
		var option_id = $('[name="correct_option"]:checked').val();
		if (typeof option_id === "undefined") {
			option_id = '0';
		}
		else
		{
			$('[data-question_id="'+question_id+'"]').removeAttr('select');
			$('[data-question_id="'+question_id+'"]').removeAttr('review');
			$('[data-question_id="'+question_id+'"]').removeAttr('not_ans');
			$('[data-question_id="'+question_id+'"]').attr('select','true');
		}
		
		var datas = {'question_id':question_id,'option_id':option_id,'exam_schedule_id':exam_schedule_id};
		var request_url = "<?php echo base_url('course/submit_question'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				
				var datas = {'question_id':prev_question,'exam_schedule_id':exam_schedule_id};
				var request_url = "<?php echo base_url('course/get_question'); ?>";
				process_ajax(function(response)
				{
					var res = JSON.parse(response);
					if(res.stat == true)
					{
						$('#question_container').html(res.datas[0].title);
						$('#question_container').attr('data-current_question_id',res.datas[0].id);
						$('[data-question_id]').removeAttr('style');
						$('[data-question_id="'+res.datas[0].id+'"]').css({'border':'2px solid red'});
						var options = '';
						$.each(res.datas,function(index,element)
						{
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('select');
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('review');
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('not_ans');
							if(element.status == '1')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('select','true');
							}
							else if(element.status == '2')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('review','true');
							}
							else if(element.status == '0')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('not_ans','true');
							}
							if(element.ans_id == element.option_id)
							{
								options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'" checked="true"> '+element.text+'</li>';
							}
							else
							{
								if(element.text !==''){
									options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'"> '+element.text+'</li>';
								}
							}
						});
						$('#option_container').html(options);
					}
				},request_url, datas, 'text');
			}
			else
			{
				var datas = {'question_id':prev_question,'exam_schedule_id':exam_schedule_id};
				var request_url = "<?php echo base_url('course/get_question'); ?>";
				process_ajax(function(response)
				{
					var res = JSON.parse(response);
					if(res.stat == true)
					{
						$('#question_container').html(res.datas[0].title);
						$('#question_container').attr('data-current_question_id',res.datas[0].id);
						$('[data-question_id]').removeAttr('style');
						$('[data-question_id="'+res.datas[0].id+'"]').css({'border':'2px solid red'});
						var options = '';
						$.each(res.datas,function(index,element)
						{
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('select');
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('review');
							$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('not_ans');
							if(element.status == '1')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('select','true');
							}
							else if(element.status == '2')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('review','true');
							}
							else if(element.status == '0')
							{
								$('[data-question_id="'+res.datas[0].id+'"]').attr('not_ans','true');
							}
							if(element.ans_id == element.option_id)
							{
								options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'" checked="true"> '+element.text+'</li>';
							}
							else
							{
								if(element.text !==''){
									options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'"> '+element.text+'</li>';
								}
							}
						});
						$('#option_container').html(options);
					}
				},request_url, datas, 'text');
			}
		},request_url, datas, 'text');
	});
</script>

<script>
	/*$(document).on('click','#finish',function()
	{
		console.log('testcheck');
		var lt_exam_categories_id   =  $('#lt_exam_categories_id').val();
		var lt_exam_course_id       =  $('#lt_exam_course_id').val();
		var lt_exam_course_title_id =  $('#lt_course_title_id').val();

		console.log(lt_exam_categories_id);
		console.log(lt_exam_course_id);
		console.log(lt_exam_course_title_id);
		
		var exam_schedule_id = $('#question_container').attr('data-exam_schedule_id');
		$('[data-question_id]').each(function(index,element)
		{
			if($(element).get(0).hasAttribute('select'))
			{
				if(confirm("Are you sure, You want to submit?"))
				{
					var datas = {'exam_schedule_id':exam_schedule_id};
					var request_url = "<?php echo base_url('course/submit_exam'); ?>";
					process_ajax(function(response)
					{
						var res = JSON.parse(response);
						if(res.stat == true)
						{
							alert('Thank you for your participation');
							// Simulate a mouse click:
							window.location.href = "<?php echo base_url('course/get_exam_score'); ?>?cid="+lt_exam_categories_id+"&c_id="+lt_exam_course_id+"&tid="+lt_exam_course_title_id;
						}
						else
						{
							alert('Unable to Save Exam');
						}
						
					},request_url, datas, 'text');
					return false;
				}
				else
				{
					return false;
				}
			}
		});
	});*/

	$(document).ready(function() {
    // Attach click event handler to the 'finish' button
    $(document).on('click', '#finish', function() {       
        
        // Get values from input fields
        var lt_exam_categories_id = $('#lt_exam_categories_id').val();
        var lt_exam_course_id = $('#lt_exam_course_id').val();
        var lt_exam_course_title_id = $('#lt_course_title_id').val();    
        
        // Get the exam schedule ID from the data attribute
        var exam_schedule_id = $('#question_container').data('exam_schedule_id');
        
        // Flag to track if at least one question is selected
        var isAnyQuestionSelected = false;
        
        // Loop through elements with 'data-question_id' attribute
        $('[data-question_id]').each(function(index, element) {
            // Check if the element has the 'select' attribute
            if ($(element).attr('select')) {
                isAnyQuestionSelected = true;
                return false; // Exit the loop if at least one question is selected
            }
        });

        if (isAnyQuestionSelected) {
            // Open the custom confirmation modal
            $('#confirmationModal').modal('show');
            
            // Handle the click event for the confirmation button
            $('#confirmSubmit').on('click', function() {
                // Close the modal
                $('#confirmationModal').modal('hide');
                
                // Perform the submission
                var datas = {'exam_schedule_id': exam_schedule_id};
                var request_url = "<?php echo base_url('course/submit_exam'); ?>";
                
                // Send an AJAX request
                process_ajax(function(response) {
                    try {
                        var res = JSON.parse(response);
                        if (res.stat === true) {
                            // Use SweetAlert2 to show a success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Thank you for your participation',
                            }).then((result) => {
                                // Redirect to the exam score page
                                if (result.isConfirmed) {
                                    window.location.href = "<?php echo base_url('course/get_exam_score'); ?>?cid=" + lt_exam_categories_id + "&c_id=" + lt_exam_course_id + "&tid=" + lt_exam_course_title_id;
                                }
                            });
                        } else {
                            // Use SweetAlert2 to show an error message
                            console.error('Unable to Save Exam');
                        }
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                        // Use SweetAlert2 to show a generic error message                        
                    }
                }, request_url, datas, 'text');
            });
        } else {
            // Use SweetAlert2 to show a warning message
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select at least one question before submitting.',
            });
        }
    });
});



</script>

<script>
	$(document).on('click','#question_no_container [data-question_id]',function()
	{
		var question_id = $(this).attr('data-question_id');
		var exam_schedule_id = $('#question_container').attr('data-exam_schedule_id');
		var datas = {'question_id':question_id,'exam_schedule_id':exam_schedule_id};
		var request_url = "<?php echo base_url('course/get_question'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if(res.stat == true)
			{
				$('#question_container').html(res.datas[0].title);
				$('#question_container').attr('data-current_question_id',res.datas[0].id);
				$('[data-question_id]').removeAttr('style');
				$('[data-question_id="'+res.datas[0].id+'"]').css({'border':'2px solid red'});
				var options = '';
				$.each(res.datas,function(index,element)
				{
					$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('select');
					$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('review');
					$('[data-question_id="'+res.datas[0].id+'"]').removeAttr('not_ans');
					if(element.status == '1')
					{
						$('[data-question_id="'+res.datas[0].id+'"]').attr('select','true');
					}
					else if(element.status == '2')
					{
						$('[data-question_id="'+res.datas[0].id+'"]').attr('review','true');
					}
					else if(element.status == '0')
					{
						$('[data-question_id="'+res.datas[0].id+'"]').attr('not_ans','true');
					}
					if(element.ans_id == element.option_id)
					{
						options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'" checked="true"> '+element.text+'</li>';
					}
					else
					{
						if(element.text !==''){
							options += '<li class="correct_option_container"><input type="radio" name="correct_option" value="'+element.option_id+'"> '+element.text+'</li>';
						}
					}
				});
				$('#option_container').html(options);
			}
		},request_url, datas, 'text');
	});
</script>