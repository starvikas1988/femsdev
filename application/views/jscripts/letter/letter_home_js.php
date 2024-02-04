<script>

	$(document).ready(function(){
		
		/* $('#agent_id').on('change',function(){
			var agent_id = $('#agent_id option:selected').val();
			$('#selected_key').val( $('#agent_id option:selected').attr('data-index'));
			
			if(agent_id == '') exit();
			 $.ajax({
				url: '<?php echo base_url();?>Letter/get_agentdetail/'+agent_id, 
				type: 'POST',
					success	: function (data, status){
					
					    var returnedData = JSON.parse(data);
						
						$("#dept_id").val(returnedData[0].shname);
						$("#doj").val(returnedData[0].doj);						
						 
					},
					error: function (error) {
						 alert('error' + (error));
					}
				});  
		}); */
		
		
		$(document).on('click','.save',function(){
			var user_id   = $(this).attr('data-id');
			var user_name = $(this).attr('data-name');
			var doj       = $(this).attr('data-doj');
			var acpt_by       = $(this).attr('data-accepted_by');
			
			$('#user_id').val(user_id);
			$('#user_name').val(user_name);
			$('#doj').val(doj);
			$('#accepted_by').val(acpt_by);
			
			 $.ajax({
				url: '<?php echo base_url();?>Letter/get_agentdetail/'+user_id, 
				type: 'POST',
					success	: function (data, status){
					
					    var returnedData = JSON.parse(data);
						
						$("#score_1").val(returnedData[0].score_1);
						$("#score_2").val(returnedData[0].score_2);						
						$("#score_3").val(returnedData[0].score_3);			
						$("#score_4").val(returnedData[0].score_4);			
						$("#score_5").val(returnedData[0].score_5);			
						$("#score_6").val(returnedData[0].score_6);			
						$("#score_7").val(returnedData[0].score_7);			
						$("#score_8").val(returnedData[0].score_8);			
						$("#score_9").val(returnedData[0].score_9);			
						$("#score_10").val(returnedData[0].score_10);			
						$("#total_score").val(returnedData[0].total_score);			
						$("#user_remarks").text(returnedData[0].remarks);			
					},
					error: function (error) {
						 alert('error' + (error));
					}
				});  
			
		});
		
		
		
		
		var c =0;
		$('.input_text').on('keyup',function(){
			
			if($(this).val() > 10){
				$(this).val(0);
			}else{
			
				var s1 = parseInt($('#score_1').val()) == ''? 0 : parseInt($('#score_1').val());
				var s2 = parseInt($('#score_2').val()) == ''? 0 : parseInt($('#score_2').val());
				var s3 = parseInt($('#score_3').val()) == ''? 0 : parseInt($('#score_3').val()); 
				var s4 = parseInt($('#score_4').val()) == ''? 0 : parseInt($('#score_4').val()); 
				var s5 = parseInt($('#score_5').val()) == ''? 0 : parseInt($('#score_5').val()); 
				var s6 = parseInt($('#score_6').val()) == ''? 0 : parseInt($('#score_6').val()); 
				var s7 = parseInt($('#score_7').val()) == ''? 0 : parseInt($('#score_7').val()); 
				var s8 = parseInt($('#score_8').val()) == ''? 0 : parseInt($('#score_8').val()); 
				var s9 = parseInt($('#score_9').val()) == ''? 0 : parseInt($('#score_9').val()); 
				var s10 = parseInt($('#score_10').val()) == ''? 0 : parseInt($('#score_10').val());
					
				c = s1 + s2 + s3 + s4 + s5 + s6 + s7 + s8 + s9 + s10; 
				console.log(c);
				$('#total_score').val(c);
			}
		});
		


	function validate(evt) {
	  var theEvent = evt || window.event;

	  // Handle paste
	  if (theEvent.type === 'paste') {
		  key = event.clipboardData.getData('text/plain');
	  } else {
	  // Handle key press
		  var key = theEvent.keyCode || theEvent.which;
		  key = String.fromCharCode(key);
	  }
	  var regex = /[0-9]|\./;
	  if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	  }
	}		
		
		
		
		
	});

</script>