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

var input = document.getElementById("attach_file");
var selectedFile;

input.addEventListener('change', updateImageDisplay);

function updateImageDisplay() {
  if(input.files.length==0) {
    input.files = selectedFile;
    console.log(input.files);
  }
  else {
    selectedFile = input.files;
    console.log(typeof(input.files));
    console.log(selectedFile);
  }
    
}
</script>

<script>
	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
	//$("#call_date_time").datetimepicker({maxDate: new Date()}); //,format: 'DD-MM-YYYY hh:mm A'
	//$("#call_date").datepicker({ minDate: 0 });
	$("#call_date_time").datetimepicker({maxDate: new Date()});
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

<script type="text/javascript">
	$('#ajioAF1_social').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="C& R not raised when required">C& R not raised when required</option>';
			sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="Incomplete Information">Incomplete Information</option>';
			sub_infractions += '<option value="Incorrect information shared>Incorrect information shared</option>';
			sub_infractions += '<option value="Wrong  C& R raised>Wrong  C& R raised</option>';
			$("#customers_concern_l1").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#customers_concern_l1").html(sub_infractions);
		}
		else{
			$("#customers_concern_l1").html('');
		}
	});

	$('#ajioAF2_social').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Incorrect Redirection done">Incorrect Redirection done</option>';
			sub_infractions += '<option value="Redirection not done when required">Redirection not done when required</option>';
			sub_infractions += '<option value="Unnecessery Redirection">Unnecessery Redirection</option>';
			$("#customers_issue_l2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#customers_issue_l2").html(sub_infractions);
		}
		else{
			$("#customers_issue_l2").html('');
		}
	});

	$('#ajioAF3_social').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Champ failed to check all the previous intercations">Champ failed to check all the previous intercations</option>';
			sub_infractions += '<option value="Champ failed analysed the CS Cockpit status & Tickits">Champ failed analysed the CS Cockpit status & Tickits</option>';
			$("#previous_interaction_l3").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#previous_interaction_l3").html(sub_infractions);
		}
		else{
			$("#previous_interaction_l3").html('');
		}
	});

	$('#ajioAF4_social').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="CAM rule not adhered to. (No)">CAM rule not adhered to. (No)</option>';
			sub_infractions += '<option value="Documented on incorrect account">Documented on incorrect account</option>';
			sub_infractions += '<option value="All queries not documented">All queries not documented</option>';
			sub_infractions += '<option value="QT Not Tagget">QT Not Tagget</option>';
			sub_infractions += '<option value="Incorrect QT tagging done">Incorrect QT tagging done</option>';
			$("#documented_guidelines_l4").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#documented_guidelines_l4").html(sub_infractions);
		}
		else{
			$("#documented_guidelines_l4").html('');
		}
	});

	$('#customer_information').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Asking personal information-Non Financial">Asking personal information-Non Financial</option>';
			sub_infractions += '<option value="Information asked already availible">Information asked already availible</option>';
			sub_infractions += '<option value="Required probing not done">Required probing not done</option>';
			sub_infractions += '<option value="Unnecessary probing done">Unnecessary probing done</option>';
			sub_infractions += '<option value="User Specific information Shared">User Specific information Shared</option>';
			sub_infractions += '<option value="Authentication not done when required">Authentication not done when required/option>';
			sub_infractions += '<option value="Unnecessary authentication done">Unnecessary authentication done</option>';
			$("#customer_information_l5").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#customer_information_l5").html(sub_infractions);
		}
		else{
			$("#customer_information_l5").html('');
		}
	});

	$('#private_channel').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Did not ask the customer to move on Pvt.Channel when required ">Did not ask the customer to move on Pvt.Channel when required </option>';
			sub_infractions += '<option value="Asked the customer to move on Pvt.Channel when not required">Asked the customer to move on Pvt.Channel when not required</option>';
			$("#private_channel_l6").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#private_channel_l6").html(sub_infractions);
		}
		else{
			$("#private_channel_l6").html('');
		}
	});

	$('#probing_questions').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Didn’t ask for clarification of the issue">Didn’t ask for clarification of the issue</option>';
			sub_infractions += '<option value="Conversation was not crisp and clear to avoid repeat">Conversation was not crisp and clear to avoid repeat</option>';
			sub_infractions += '<option value="Didn’t offer to call back when required">Didn’t offer to call back when required</option>';
			sub_infractions += '<option value="Champ was unable understand objection">Champ was unable understand objection</option>';
			sub_infractions += '<option value="Did not use objection handling script/statement">Did not use objection handling script/statement</option>';
			sub_infractions += '<option value="Poor objection handling skill">Poor objection handling skill</option>';
			$("#probing_questions_l7").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#probing_questions_l7").html(sub_infractions);
		}
		else{
			$("#probing_questions_l7").html('');
		}
	});

	$('#relevant_hashtags').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Hashtag/Hyperlink/Images/Selfcare not shared when required">Hashtag/Hyperlink/Images/Selfcare not shared when required</option>';
			sub_infractions += '<option value="KM not adhered">KM not adhered</option>';
			$("#relevant_hashtags_l8").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#relevant_hashtags_l8").html(sub_infractions);
		}
		else{
			$("#relevant_hashtags_l8").html('');
		}
	});

		$('#friendly_tone').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Tone was not friendly">Tone was not friendly</option>';
			sub_infractions += '<option value="Brand building missing">Brand building missing</option>';
			sub_infractions += '<option value="Greeting & closing script not followed">Greeting & closing script not followed</option>';
			sub_infractions += '<option value="Empathy & appology missing">Empathy & appology missing</option>';
			sub_infractions += '<option value="AJIO’s contemporary writing style missing">AJIO’s contemporary writing style missing</option>';
			$("#friendly_tone_l9").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#friendly_tone_l9").html(sub_infractions);
		}
		else{
			$("#friendly_tone_l9").html('');
		}
	});

	$('#avoid_punctuation').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Incorrect sentence Structure">Incorrect sentence Structure</option>';
			sub_infractions += '<option value="Incorrect spacing">Incorrect spacing</option>';
			sub_infractions += '<option value="Grammatical error">Grammatical error</option>';
			sub_infractions += '<option value="Incorrect punctuation">Incorrect punctuation</option>';
			sub_infractions += '<option value="Spelling Errors">Spelling Errors</option>';
			sub_infractions += '<option value="Capitalization error">Capitalization error</option>';
			$("#avoid_punctuation_l10").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#avoid_punctuation_l10").html(sub_infractions);
		}
		else{
			$("#avoid_punctuation_l10").html('');
		}
	});

	$('#feel_heard').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Customer appreciation missing">Customer appreciation missing</option>';
			sub_infractions += '<option value="Thanking the customer is missing when required ">Thanking the customer is missing when required </option>';
			$("#feel_heard_l11").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#feel_heard_l11").html(sub_infractions);
		}
		else{
			$("#feel_heard_l11").html('');
		}
	});

	$('#ajioAF5_social').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Task avoidence">Task avoidence</option>';
			sub_infractions += '<option value="Misbehave with customer">Misbehave with customer</option>';
			sub_infractions += '<option value="Closing chat without replying">Closing chat without replying</option>';
			sub_infractions += '<option value="Chairman esclation">Chairman esclation</option>';
			sub_infractions += '<option value="Asking Personal information">Asking Personal information</option>';
			sub_infractions += '<option value="Call drop/Call back not done">Call drop/Call back not done</option>';
			$("#ztp_guidelines_l12").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ztp_guidelines_l12").html(sub_infractions);
		}
		else{
			$("#ztp_guidelines_l12").html('');
		}
	});			

</script>

<script type="text/javascript">
	function ajio_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.ajio').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('ajio_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('ajio_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == 'No'){
			    var w1 = parseFloat($(element).children("option:selected").attr('ajio_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('ajio_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == 'N/A'){
			    var w1 = parseFloat($(element).children("option:selected").attr('ajio_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('ajio_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else{
			    var w1 = parseFloat($(element).children("option:selected").attr('ajio_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('ajio_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}

		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}
	///////////////////////////
		var fatal_count=0;
		$('.fatal').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Autofail'){
				fatal_count=fatal_count+1;
			}
		});
		$('#fatalcount').val(fatal_count);
		
		if(!isNaN(quality_score_percent)){
			$('#prefatal').val(quality_score_percent);
		}
	////////////////
		
		if($('.ajioAF1').val()=='Autofail' || $('.ajioAF2').val()=='Autofail' || $('.ajioAF3').val()=='Autofail' || $('.ajioAF4').val()=='Autofail' || $('.ajioAF5').val()=='Autofail' || $('.ajioAF6').val()=='Autofail' || $('.ajioAF7').val()=='Autofail' || $('.ajioAF8').val()=='Autofail' || $('.ajioAF9').val()=='Autofail'){
			$('.ajio_social_Fatal').val(0+'%');
		}else{
			$('.ajio_social_Fatal').val(quality_score_percent+'%');
		}
	}

	$(document).on('change','.ajio',function(){
		ajio_calc();
	});
	ajio_calc();
</script>

////////////////vikas//////////////////////////////


<!--  <script type="text/javascript">
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
			
			if(score_type_park == 'Yes'){
				pass_count_park = pass_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('sea_world_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('sea_world_max'));
				
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;

			}else if(score_type_park == 'No'){
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

		if($('#parkAF1').val()=='Fail' || $('#parkAF2').val()=='Fail' || $('#parkAF3').val()=='Fail' || $('#parkAF4').val()=='Fail' || $('#parkAF5').val()=='Fail' || $('#parkAF6').val()=='Fail' || $('#parkAF7').val()=='Fail' || $('#parkAF8').val()=='Fail' || $('#parkAF9').val()=='Fail'  || $('#parkAF10').val()=='Fail' || $('#parkAF11').val()=='Fail' || $('#parkAF12').val()=='Fail' || $('#parkAF13').val()=='Fail' || $('#parkAF14').val()=='Fail' || $('#parkAF15').val()=='Fail' || $('#parkAF16').val()=='Fail' || $('#parkAF17').val()=='Fail' || $('#parkAF18').val()=='Fail' || $('#parkAF19').val()=='Fail' || $('#parkAF20').val()=='Fail' || $('#parkAF21').val()=='Fail' || $('#parkAF22').val()=='Fail' || $('#parkAF23').val()=='Fail' || $('#parkAF24').val()=='Fail' || $('#parkAF25').val()=='Fail' || $('#parkAF26').val()=='Fail' || $('#parkAF27').val()=='Fail' || $('#parkAF28').val()=='Fail' || $('#parkAF29').val()=='Fail'){
			console.log($('#parkAF1').val());

			quality_score_percent_park = (0.00).toFixed(2);
			$('.parkFatal').val(quality_score_percent_park+'%');
		}else{
			$('#sea_world_overall_score').val(quality_score_percent_park+'%');
		}
	}
	
	$(document).on('change','.sea_world_point',function(){
		sea_world_calc();
	});
	sea_world_calc();
</script> -->


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

