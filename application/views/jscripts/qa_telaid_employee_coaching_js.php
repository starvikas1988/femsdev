<!-- AVON SCRIPT -->
<!-- Score Counter Script-->
<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<script src="<?php echo base_url() ?>assets/css/search-filter/js/chart.js"></script>

<script>
//     $(document).ready(function(e){
//     $('#batch_code').select2(); 
    
// });
$(function() {
    $('#multiselect').multiselect();
    $('.multiple-select').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
		numberDisplayed: 0,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Search for something...'
    });
});

</script>
<script type="text/javascript">
		$(function() {
		$( "#agent_id" ).on('change' , function() {
		var aid = this.value;
		//alert(aid);
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_ameridial/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
			
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));
				$('#fusion_id').empty();
				$('#fusion_id').append($('#fusion_id').val(''));
				
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj){
					if($('#tl_name').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				}
				for (var i in json_obj){
					if($('#tl_names').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_names').append($('#tl_names').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				}  
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){
				alert('Fail!');
			}
		});
	});
});
</script>

<script>
        $(document).ready(function () {
            // Bind the change event to the select box
         
            $('#agent_id_ack').val($('#agent_id option:selected').text());
            $('#agent_id').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Set the selected value to the readonly text field
                //$('#agent_id_ack').val(selectedValue);
                var selectedText = $(this).find('option:selected').text();
                $('#agent_id_ack').val(selectedText);
            });
        });
</script>

  <script>
        $(document).ready(function () {
            // Bind the input event to the input text field
            $('#coach').on('input', function () {
                // Get the entered text
                var enteredText = $(this).val();
                
                // Set the entered text to the readonly text field
                $('#coach_ack').val(enteredText);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Bind the change event to the select box
            $('#poor_job_performance').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Check if the selected value is 'Severe'
                if (selectedValue === 'Severe') {
                    // Change the background color to red
                    $(this).css({
                        'background-color': 'red',
                        'color': 'white'
                    });
                } else {
                    // Reset the background color and text color to their defaults
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            $('#procedural_guidelines').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Check if the selected value is 'Severe'
                if (selectedValue === 'Severe') {
                    // Change the background color to red
                    $(this).css({
                        'background-color': 'red',
                        'color': 'white'
                    });
                } else {
                    // Reset the background color and text color to their defaults
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            $('#behavioral').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Check if the selected value is 'Severe'
                if (selectedValue === 'Severe') {
                    // Change the background color to red
                    $(this).css({
                        'background-color': 'red',
                        'color': 'white'
                    });
                } else {
                    // Reset the background color and text color to their defaults
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            $('#attendance_infraction').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Check if the selected value is 'Severe'
                if (selectedValue === 'Severe') {
                    // Change the background color to red
                    $(this).css({
                        'background-color': 'red',
                        'color': 'white'
                    });
                } else {
                    // Reset the background color and text color to their defaults
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            $('#work_scenario').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Check if the selected value is 'Severe'
                if (selectedValue === 'Severe') {
                    // Change the background color to red
                    $(this).css({
                        'background-color': 'red',
                        'color': 'white'
                    });
                } else {
                    // Reset the background color and text color to their defaults
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            $('#sleeping_shift').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Check if the selected value is 'Severe'
                if (selectedValue === 'Severe') {
                    // Change the background color to red
                    $(this).css({
                        'background-color': 'red',
                        'color': 'white'
                    });
                } else {
                    // Reset the background color and text color to their defaults
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            $('#none').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Check if the selected value is 'Severe'
                if (selectedValue === 'Severe') {
                    // Change the background color to red
                    $(this).css({
                        'background-color': 'red',
                        'color': 'white'
                    });
                } else {
                    // Reset the background color and text color to their defaults
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            $('#informed_consequences').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();
                
                // Check if the selected value is 'Severe'
                if (selectedValue === 'NO') {
                    // Change the background color to red
                    $(this).css({
                        'background-color': 'red',
                        'color': 'black'
                    });
                }else if(selectedValue === 'YES'){
                	$(this).css({
                        'background-color': 'green',
                        'color': 'black'
                    });
                }else if(selectedValue === 'NA'){
                	$(this).css({
                        'background-color': '#FFF1D7',
                        'color': 'black'
                    });
                } else {
                    // Reset the background color and text color to their defaults
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });
        });
    </script>


<script type="text/javascript">
	
		$(function() {
		$( "#agent_id" ).on('change' , function() {
		var aid = this.value;
		//alert(aid);
		//if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_epgi/getSiteLocation';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'agent_id='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
			
				$('#site').empty();
				$('#site').append($('#site').val(''));
				//console.log(json_obj);
				for (var i in json_obj){
					if($('#site').val(json_obj[i].office_id)!=''){
						//console.log(json_obj[0].office_id);
						$('#site').append($('#site').val(json_obj[i].office_id));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				} 
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){
				alert('Fail!');
			}
		});
	});
});
</script>

<script type = "text/javascript">
   <!--
      // Form validation code will come here.
      function validate() {
      
         if( document.form_new_user.from_date.value == "" ) {
            alert( "Please provide From Date!" );
            document.form_new_user.from_date.focus() ;
            return false;
         }
         if( document.form_new_user.to_date.value == "" ) {
            alert( "Please provide To Date!" );
            document.form_new_user.to_date.focus() ;
            return false;
         }
         if( document.form_new_user.campaign.value == "" ) {
            alert( "Please provide LOB!" );
            document.form_new_user.campaign.focus() ;
            return false;
         }

         return( true );
      }
   //-->
</script>

<script type="text/javascript">
		function checkDec(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#phone').val("");
				return false;
			}
			if(el.value.length >10){
       			//alert("required 10 digits, match requested format!");
       			$("#start_phone").html("Required 10 digits, match requested format!");
       			$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }else if(el.value.length <10){
		    	$("#start_phone").html("Phone number can not be less than 10 digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else if(el.value.length == 10){
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		    // else{
		    // 	$("#start_phone").html("");
		    // 	 $("#qaformsubmit").removeAttr("disabled");
		    // }
			console.log(el.value);
		}
</script> 
<script type="text/javascript">
	function checkDecConsumer(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#consumer_no').val("");
				return false;
			}
			// if(el.value.length >25){
   //     			//alert("required 10 digits, match requested format!");
   //     			$("#start_phone").html("Consumer number can not be more than 25 digits!");
   //     			$("#qaformsubmit").attr("disabled", "disabled");
   //     			return false;
		 //    }
		    if(el.value.length < 1){
		    	$("#start_phone").html("Consumer number can not be a negative digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else{
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		    // else{
		    // 	$("#start_phone").html("");
		    // 	 $("#qaformsubmit").removeAttr("disabled");
		    // }
			console.log(el.value);
		}
</script>

<script type="text/javascript">
	function checkDecCallNo(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#call_number').val("");
				return false;
			}
			
		    if(el.value.length < 1){
		    	$("#start_phone").html("Call number can not be a negative digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else{
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		   
			console.log(el.value);
		}
</script>

<script type="text/javascript">
	// $(function () {
	// 	$( "#audit_type" ).on('change' , function() {
	// 		let val = $(this).val();
	// 		if(val == 'Calibration'){
	// 			$('#auditor_type').attr('required','required');
	// 		}else{
	// 			$('#auditor_type').attr('required', false);
	// 		}
	// 	});
	// });
</script>



<script>
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'mp4':
        case 'mp3':
		case 'wav':
		case 'm4a':
			$('#qaformsubmit').attr('disabled', false);
        break;
        default:
            alert('This is not an allowed file type. Please upload allowed file type like [m4a,mp4,mp3,wav]');
            this.value = '';
    }
});
</script>

<script>
	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
	$("#call_date_time").datetimepicker({maxDate: new Date()});
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });

</script>

<script type="text/javascript">
	$(document).ready(function () {
	 // console.log("Hello World!");
	  var start_date	=	$("#from_date").val();
	  var end_date		=	$("#to_date").val();
	  if(start_date == '' && end_date == ''){
		  	$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	  if(end_date == ''){
	  		$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	  if(start_date == ''){
	  		$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	});
</script>

<script type="text/javascript">
	
	function date_validation(val,type){
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		
		if(type=='E'){
		var start_date=$("#from_date").val();
		//if(val<start_date)
		if(start_date!=''){
			if(Date.parse(val) < Date.parse(start_date))
			{
				$(".end_date_error").html("To Date must be greater or equal to From Date");
				 $(".blains-effect").attr("disabled",true);
				 $(".blains-effect").css('cursor', 'no-drop');
			}
			else{
				 $(".blains-effect").attr("disabled",false);
				 $(".blains-effect").css('cursor', 'pointer');
				}

		}else{
				 $(".blains-effect").attr("disabled",true);
				 $(".blains-effect").css('cursor', 'no-drop');
		}
		
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(end_date!=''){
			if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
			
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			}
		}else{
			$(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
		}
		

		}
	}
</script>

<script type="text/javascript">
	///////////////// Calibration - Auditor Type ///////////////////////	
	//$('.auType').hide();
	
	if($("#audit_type").val() == "Calibration"){
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	
	$('#audit_type').each(function(){
		$valdet=$(this).val();
		console.log($valdet);
		if($valdet=="Calibration"){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});

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

	///////////////////hcci core/////////////////

	$('#audit_type').each(function(){
		$valdet=$(this).val();
		if($valdet=="Calibration"){
			$('.auType_epi').show();
		}else{
			$('.auType_epi').hide();
		}
	});

	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType_epi').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			//alert(222);
			$('.auType_epi').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});
</script>
<script type="text/javascript">
	
	$('#tl_id').on('click', function(){
		alert("Can not Change TL");
		$("#tl_id").attr('disabled','disabled');
		return false;
	});
</script>


////////////////vikas//////////////////////////////


<script type="text/javascript">
 		function sea_world_calc(){
		let score_park = 0;
		let scoreable_park = 0;
		let quality_score_percent_park = 0.00;
		let pass_count_park = 0;
		let fail_count_park = 0;
		let na_count_park = 0;
		let score_sea_world_final = 0;
		let scoreable_sea_world_final = 0;

		$('.sea_world_point').each(function(index,element){
			let score_type_park = $(element).val();
			
			if(score_type_park == 'Yes' || score_type_park == 'Pass'){
				pass_count_park = pass_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sea_world_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sea_world_max'));
				
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;

			}else if(score_type_park == 'No' || score_type_park == 'Fail'){
				fail_count_park = fail_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sea_world_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sea_world_max'));

				//score = score + w1;
				scoreable_park = scoreable_park + w2_park;
				//scoreable = scoreable + weightage;
			}else if(score_type_park == 'N/A'){
				na_count_park = na_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sea_world_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sea_world_max'));
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;
			}
		});
		quality_score_percent_park = ((score_park*100)/scoreable_park).toFixed(2);

		if(quality_score_percent_park == "NaN"){
			quality_score_percent_park = (0.00).toFixed(2);
		}else{
			quality_score_percent_park = quality_score_percent_park;
		}
		
      score_sea_world_final     = (score_park).toFixed(2);
      scoreable_sea_world_final = (scoreable_park).toFixed(2);

		$('#sea_world_earned_score').val(score_sea_world_final);
		$('#sea_world_possible_score').val(scoreable_sea_world_final);
		
		if(!isNaN(quality_score_percent_park)){
			$('#sea_world_overall_score').val(quality_score_percent_park+'%');
		}

		
		if($('#seaworldAF1').val()=='Fail' || $('#seaworldAF2').val()=='Fail' || $('#seaworldAF3').val()=='Fail' || $('#seaworldAF4').val()=='Fail' || $('#seaworldAF5').val()=='Fail' || $('#seaworldAF6').val()=='Fail'){
			$('.seaworldFatal').val(0+'%');
		}else{
			$('.seaworldFatal').val(quality_score_percent_park+'%');
		}
	}
	
	$(document).on('change','.sea_world_point',function(){
		sea_world_calc();
	});
	sea_world_calc();
</script>

<script type="text/javascript">
 		function sea_world_chat_calc(){
		let score_park = 0;
		let scoreable_park = 0;
		let quality_score_percent_park = 0.00;
		let pass_count_park = 0;
		let fail_count_park = 0;
		let na_count_park = 0;
		let score_sea_world_chat_final = 0;
		let scoreable_sea_world_chat_final = 0;

		$('.sea_world_chat_point').each(function(index,element){
			let score_type_park = $(element).val();
			
			if(score_type_park == 'Yes' || score_type_park == 'Pass'){
				pass_count_park = pass_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sea_world_chat_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sea_world_chat_max'));
				
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;

			}else if(score_type_park == 'No' || score_type_park == 'Fail'){
				fail_count_park = fail_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sea_world_chat_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sea_world_chat_max'));

				//score = score + w1;
				scoreable_park = scoreable_park + w2_park;
				//scoreable = scoreable + weightage;
			}else if(score_type_park == 'NA'){
				na_count_park = na_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sea_world_chat_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sea_world_chat_max'));
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;
			}
		});
		quality_score_percent_park = ((score_park*100)/scoreable_park).toFixed(2);

		if(quality_score_percent_park == "NaN"){
			quality_score_percent_park = (0.00).toFixed(2);
		}else{
			quality_score_percent_park = quality_score_percent_park;
		}
		
      score_sea_world_chat_final     = (score_park).toFixed(2);
      scoreable_sea_world_chat_final = (scoreable_park).toFixed(2);

		$('#sea_world_chat_earned_score').val(score_sea_world_chat_final);
		$('#sea_world_chat_possible_score').val(scoreable_sea_world_chat_final);
		
		if(!isNaN(quality_score_percent_park)){
			$('#sea_world_chat_overall_score').val(quality_score_percent_park+'%');
		}

		
		if($('#seaworldChatAF1').val()=='Fail' || $('#seaworldChatAF2').val()=='Fail' || $('#seaworldChatAF3').val()=='Fail' || $('#seaworldChatAF4').val()=='Fail' || $('#seaworldChatAF5').val()=='Fail' || $('#seaworldChatAF6').val()=='Fail'){
			$('.seaworldChatFatal').val(0+'%');
		}else{
			$('.seaworldChatFatal').val(quality_score_percent_park+'%');
		}
	}
	
	$(document).on('change','.sea_world_chat_point',function(){
		sea_world_chat_calc();
	});
	sea_world_chat_calc();
</script>

<script type="text/javascript">
 		function fc_escalation_calc(){
		let score_park = 0;
		let scoreable_park = 0;
		let quality_score_percent_park = 0.00;
		let pass_count_park = 0;
		let fail_count_park = 0;
		let na_count_park = 0;
		let score_fc_escalation_final = 0;
		let scoreable_fc_escalation_final = 0;

		$('.fc_escalation_point').each(function(index,element){
			let score_type_park = $(element).val();
			
			if(score_type_park == 'Yes'){
				pass_count_park = pass_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('fc_escalation_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('fc_escalation_max'));
				
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;

			}else if(score_type_park == 'No'){
				fail_count_park = fail_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('fc_escalation_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('fc_escalation_max'));

				//score = score + w1;
				scoreable_park = scoreable_park + w2_park;
				//scoreable = scoreable + weightage;
			}
		});
		quality_score_percent_park = ((score_park*100)/scoreable_park).toFixed(2);

		if(quality_score_percent_park == "NaN"){
			quality_score_percent_park = (0.00).toFixed(2);
		}else{
			quality_score_percent_park = quality_score_percent_park;
		}
		
      score_fc_escalation_final     = (score_park).toFixed(2);
      scoreable_fc_escalation_final = (scoreable_park).toFixed(2);

		$('#fc_escalation_earned_score').val(score_fc_escalation_final);
		$('#fc_escalation_possible_score').val(scoreable_fc_escalation_final);
		
		if(!isNaN(quality_score_percent_park)){
			$('#fc_escalation_overall_score').val(quality_score_percent_park+'%');
		}

		
		if($('#fc_fatal1').val()=='Fail' || $('#fc_fatal2').val()=='Fail' || $('#fc_fatal3').val()=='Fail' || $('#fc_fatal4').val()=='Fail'){
			$('.fc_escalationFatal').val(0+'%');
		}else{
			$('.fc_escalationFatal').val(quality_score_percent_park+'%');
		}
	}
	
	$(document).on('change','.fc_escalation_point',function(){
		fc_escalation_calc();
	});
	fc_escalation_calc();
</script>

<script type="text/javascript">
 		function fc_hotline_calc(){
		let score_park = 0;
		let scoreable_park = 0;
		let quality_score_percent_park = 0.00;
		let pass_count_park = 0;
		let fail_count_park = 0;
		let na_count_park = 0;
		let score_fc_hotline_final = 0;
		let scoreable_fc_hotline_final = 0;

		$('.fc_hotline_point').each(function(index,element){
			let score_type_park = $(element).val();
			
			if(score_type_park == 'Yes'){
				pass_count_park = pass_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('fc_hotline_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('fc_hotline_max'));
				
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;

			}else if(score_type_park == 'No'){
				fail_count_park = fail_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('fc_hotline_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('fc_hotline_max'));

				//score = score + w1;
				scoreable_park = scoreable_park + w2_park;
				//scoreable = scoreable + weightage;
			}
		});
		quality_score_percent_park = ((score_park*100)/scoreable_park).toFixed(2);

		if(quality_score_percent_park == "NaN"){
			quality_score_percent_park = (0.00).toFixed(2);
		}else{
			quality_score_percent_park = quality_score_percent_park;
		}
		
      score_fc_hotline_final     = (score_park).toFixed(2);
      scoreable_fc_hotline_final = (scoreable_park).toFixed(2);

		$('#fc_hotline_earned_score').val(score_fc_hotline_final);
		$('#fc_hotline_possible_score').val(scoreable_fc_hotline_final);
		
		if(!isNaN(quality_score_percent_park)){
			$('#fc_hotline_overall_score').val(quality_score_percent_park+'%');
		}

		
		if($('#fc_fatal1').val()=='Fail' || $('#fc_fatal2').val()=='Fail' || $('#fc_fatal3').val()=='Fail' || $('#fc_fatal4').val()=='Fail'){
			$('.fc_hotlineFatal').val(0+'%');
		}else{
			$('.fc_hotlineFatal').val(quality_score_percent_park+'%');
		}
	}
	
	$(document).on('change','.fc_hotline_point',function(){
		fc_hotline_calc();
	});
	fc_hotline_calc();
</script>


<script>
	//$( "#datepicker" ).datepicker({ minDate: 0});
//Edited By Samrat 30/9/21
	$(document).ready(function(){
		$("#from_date, #to_date, #call_date").datepicker();
		$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
		<?php if($this->uri->segment(2)=="Qa_sea_world" && $this->uri->segment(4)=="0"){?>
			//console.log("okk");
			//$("#epgi_earned_score, #epgi_possible_score").val("0");
		<?php }?>
	});
</script>

