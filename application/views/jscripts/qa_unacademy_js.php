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
	$("#call_end_date").datepicker({maxDate: new Date()}); //datetimepicker
	
	//$("#call_date_time").datetimepicker({maxDate: new Date()}); //,format: 'DD-MM-YYYY hh:mm A'
	//$("#call_date").datepicker({ minDate: 0 });
	$("#call_date_time").datetimepicker({maxDate: new Date()});
	$("#copy_received").datepicker();
	$("#time_call_duration").timepicker({timeFormat : 'HH:mm:ss' });
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
	$('#call_openning').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Greetings">Greetings</option>';
			sub_infractions += '<option value="BDE Name">BDE Name</option>';
			sub_infractions += '<option value="Brand Name">Brand Name</option>';
			sub_infractions += '<option value="Confirmed Learners name">Confirmed Learners name</option>';
			sub_infractions += '<option value="Asked for RPC (Right party contact, Incase learners name was not clear on leadsquared)">Asked for RPC (Right party contact, Incase learners name was not clear on leadsquared)</option>';
			sub_infractions += '<option value="Informed right designation when asked by learner/parent">Informed right designation when asked by learner/parent</option>';
			sub_infractions += '<option value="Stated Purpose of the call">Stated Purpose of the call</option>';
			sub_infractions += '<option value="Open the call within <3sec">Open the call within <3sec</option>';

			$("#call_openning_reason").html(sub_infractions);
			$("#call_openning_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#call_openning_reason").html(sub_infractions);
			//$("#call_openning_reason").css("width", "auto");
		}
		else{
			$("#call_openning_reason").html('');
			//$("#call_openning_reason").css("width", "auto");
		}
	});

	$('#effective_probing').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Effectively probed on Goal, Preparation status, Year of examination etc…">Effectively probed on Goal, Preparation status, Year of examination etc…</option>';
			sub_infractions += '<option value="Avoid unnecessary and incorrect probing. If the information goes wrong due to incorrect probing it should be a mark down.">Avoid unnecessary and incorrect probing. If the information goes wrong due to incorrect probing it should be a mark down.</option>';
			$("#effective_probing_reason").html(sub_infractions);
			$("#effective_probing_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#effective_probing_reason").html(sub_infractions);
			//$("#effective_probing_reason").css("width", "auto");
		}
		else{
			$("#effective_probing_reason").html('');
			//$("#effective_probing_reason").css("width", "auto");
		}
	});

	$('#features_benefits').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Effective Probing">Effective Probing</option>';
			sub_infractions += '<option value="Probed to profile the learner">Probed to profile the learner</option>';
			sub_infractions += '<option value="Check learners eligibility">Check learners eligibility</option>';
			$("#features_benefits_reason").html(sub_infractions);
			$("#features_benefits_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#features_benefits_reason").html(sub_infractions);
			//$("#features_benefits_reason").css("width", "auto");
		}
		else{
			$("#features_benefits_reason").html('');
			//$("#features_benefits_reason").css("width", "auto");
		}
	});

	$('#unacademyAF1').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Educator name with Subject">Educator name with Subject</option>';
			sub_infractions += '<option value="Brief introduction-Accomplishment and milestones achieved">Brief introduction-Accomplishment and milestones achieved</option>';
			sub_infractions += '<option value="Suggestion:-Refer Pitch Assist PAV2">Suggestion:-Refer Pitch Assist PAV2</option>';

			$("#educators_credibility_reason").html(sub_infractions);
			$("#educators_credibility_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#educators_credibility_reason").html(sub_infractions);
			//$("#educators_credibility_reason").css("width", "auto");
		}
		else{
			$("#educators_credibility_reason").html('');
			//$("#educators_credibility_reason").css("width", "auto");
		}
	});

	$('#objection_handling').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Any questions raised by the learner should be answered by BD">Any questions raised by the learner should be answered by BD</option>';
			sub_infractions += '<option value="Accurate & complete info">Accurate & complete info</option>';

			$("#objection_handling_reason").html(sub_infractions);
			$("#objection_handling_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#objection_handling_reason").html(sub_infractions);
			//$("#objection_handling_reason").css("width", "auto");
		}
		else{
			$("#objection_handling_reason").html('');
			//$("#objection_handling_reason").css("width", "auto");
		}
	});

	$('#rate_of_speech').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="1.Maintain proper tone">1.Maintain proper tone</option>';
			sub_infractions += '<option value="2.pitch, volume and pace throughout the call.">2.pitch, volume and pace throughout the call.</option>';
			$("#rate_of_speech_reason").html(sub_infractions);
			$("#rate_of_speech_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#rate_of_speech_reason").html(sub_infractions);
			//$("#rate_of_speech_reason").css("width", "auto");
		}
		else{
			$("#rate_of_speech_reason").html('');
			//$("#rate_of_speech_reason").css("width", "auto");
		}
	});

	$('#empathy').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Empathize, apologies & or appreciate as per call scenario.">Empathize, apologies & or appreciate as per call scenario.</option>';

			$("#empathy_reason").html(sub_infractions);
			$("#empathy_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#empathy_reason").html(sub_infractions);
			//$("#empathy_reason").css("width", "auto");
		}
		else{
			$("#empathy_reason").html('');
			//$("#empathy_reason").css("width", "auto");
		}
	});

	$('#dead_air').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="BDE needs to seek permission before placing on hold & thank after releasing the hold. Dead air to be considered as if there is no voice more than 10 Sec">BDE needs to seek permission before placing on hold & thank after releasing the hold. Dead air to be considered as if there is no voice more than 10 Sec</option>';
			
			$("#dead_air_reason").html(sub_infractions);
			$("#dead_air_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#dead_air_reason").html(sub_infractions);
			//$("#dead_air_reason").css("width", "auto");
		}
		else{
			$("#dead_air_reason").html('');
			//$("#dead_air_reason").css("width", "auto");
		}
	});

		$('#rapport').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="BDE needs to build rapport & sound enthusiastic throughout the call.">BDE needs to build rapport & sound enthusiastic throughout the call.</option>';
			sub_infractions += '<option value="Did the BDE showcase the benefits to suit the learner">Did the BDE showcase the benefits to suit the learner</option>';

			$("#rapport_reason").html(sub_infractions);
			$("#rapport_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#rapport_reason").html(sub_infractions);
			//$("#rapport_reason").css("width", "auto");
		}
		else{
			$("#rapport_reason").html('');
			//$("#rapport_reason").css("width", "auto");
		}
	});

	$('#active_listening').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Need active listening & understanding of learners requirement">Need active listening & understanding of learners requirement</option>';
			
			$("#active_listening_reason").html(sub_infractions);
			$("#active_listening_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#active_listening_reason").html(sub_infractions);
			//$("#active_listening_reason").css("width", "auto");
		}
		else{
			$("#active_listening_reason").html('');
			//$("#active_listening_reason").css("width", "auto");
		}
	});

	$('#switch_language').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Switch language as per the Learner convenience">Switch language as per the Learner convenience</option>';
			
			$("#switch_language_reason").html(sub_infractions);
			$("#switch_language_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#switch_language_reason").html(sub_infractions);
			//$("#switch_language_reason").css("width", "auto");
		}
		else{
			$("#switch_language_reason").html('');
			//$("#switch_language_reason").css("width", "auto");
		}
	});

	$('#used_Jargons').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Avoid LS">Avoid LS</option>';
			sub_infractions += '<option value="Avoid sales pitch">Avoid sales pitch</option>';
			sub_infractions += '<option value="Avoid Feedback,PA-V2">Avoid Feedback,PA-V2</option>';

			$("#used_Jargons_reason").html(sub_infractions);
			$("#used_Jargons_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#used_Jargons_reason").html(sub_infractions);
			//$("#used_Jargons_reason").css("width", "auto");
		}
		else{
			$("#used_Jargons_reason").html('');
			//$("#used_Jargons_reason").css("width", "auto");
		}
	});	

	$('#correct_notes').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Complete & accurate notes to be captured in notes">Complete & accurate notes to be captured in notes</option>';

			$("#correct_notes_reason").html(sub_infractions);
			$("#correct_notes_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#correct_notes_reason").html(sub_infractions);
			//$("#correct_notes_reason").css("width", "auto");
		}
		else{
			$("#correct_notes_reason").html('');
			//$("#correct_notes_reason").css("width", "auto");
		}
	});	

	$('#relevant_email').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Confirm email ID of learner before sending email">Confirm email ID of learner before sending email</option>';
			sub_infractions += '<option value="Email bounced cases - Reconfirmed with Learner">Email bounced cases - Reconfirmed with Learner</option>';

			$("#relevant_email_reason").html(sub_infractions);
			$("#relevant_email_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#relevant_email_reason").html(sub_infractions);
			//$("#relevant_email_reason").css("width", "auto");
		}
		else{
			$("#relevant_email_reason").html('');
			//$("#relevant_email_reason").css("width", "auto");
		}
	});

	$('#follow_up').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="While creating follow up in activity tab, select date (Call Back Date)">While creating follow up in activity tab, select date (Call Back Date)</option>';

			$("#follow_up_reason").html(sub_infractions);
			$("#follow_up_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#follow_up_reason").html(sub_infractions);
			//$("#follow_up_reason").css("width", "auto");
		}
		else{
			$("#follow_up_reason").html('');
			//$("#follow_up_reason").css("width", "auto");
		}
	});	

	$('#lead_stage').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Lead stage selection must be accurate basis call conversation">Lead stage selection must be accurate basis call conversation</option>';

			$("#lead_stage_reason").html(sub_infractions);
			$("#lead_stage_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#lead_stage_reason").html(sub_infractions);
			//$("#lead_stage_reason").css("width", "auto");
		}
		else{
			$("#lead_stage_reason").html('');
			//$("#lead_stage_reason").css("width", "auto");
		}
	});	

	$('#unacademyAF2').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="BDE forcing/begging on the call">BDE forcing/begging on the call</option>';

			$("#forcing_website_navigation_reason").html(sub_infractions);
			$("#forcing_website_navigation_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#forcing_website_navigation_reason").html(sub_infractions);
			//$("#forcing_website_navigation_reason").css("width", "auto");
		}
		else{
			$("#forcing_website_navigation_reason").html('');
			//$("#forcing_website_navigation_reason").css("width", "auto");
		}
	});	

	$('#unacademyAF3').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="BDE should not hang the call between the conversation. Appropriate call closure to be done.BD should not sound rude, sarcastic or be abusive on call">BDE should not hang the call between the conversation. Appropriate call closure to be done.BD should not sound rude, sarcastic or be abusive on call</option>';

			$("#call_hangup_reason").html(sub_infractions);
			$("#call_hangup_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#call_hangup_reason").html(sub_infractions);
			//$("#call_hangup_reason").css("width", "auto");
		}
		else{
			$("#call_hangup_reason").html('');
			//$("#call_hangup_reason").css("width", "auto");
		}
	});	

	$('#unacademyAF4').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="No personal numbers to be shared or asked">No personal numbers to be shared or asked</option>';

			$("#sharing_personal_number_reason").html(sub_infractions);
			$("#sharing_personal_number_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#sharing_personal_number_reason").html(sub_infractions);
			//$("#sharing_personal_number_reason").css("width", "auto");
		}
		else{
			$("#sharing_personal_number_reason").html('');
			//$("#sharing_personal_number_reason").css("width", "auto");
		}
	});	

	$('#unacademyAF5').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Filling up the profiling Form">Filling up the profiling Form</option>';

			$("#profiling_form_reason").html(sub_infractions);
			$("#profiling_form_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#profiling_form_reason").html(sub_infractions);
			//$("#profiling_form_reason").css("width", "auto");
		}
		else{
			$("#profiling_form_reason").html('');
			//$("#profiling_form_reason").css("width", "auto");
		}
	});	

	$('#unacademyAF6').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Approved email templates only to be used. Batch details only can be edited. Highlighted colors, bold nothing to be used.">Approved email templates only to be used. Batch details only can be edited. Highlighted colors, bold nothing to be used.</option>';

			$("#email_etiquette_reason").html(sub_infractions);
			$("#email_etiquette_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#email_etiquette_reason").html(sub_infractions);
			//$("#email_etiquette_reason").css("width", "auto");
		}
		else{
			$("#email_etiquette_reason").html('');
			//$("#email_etiquette_reason").css("width", "auto");
		}
	});	

	$('#unacademyAF7').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Talking bad about the Unacademy">Talking bad about the Unacademy</option>';

			$("#talking_ill_reason").html(sub_infractions);
			$("#talking_ill_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#talking_ill_reason").html(sub_infractions);
			//$("#talking_ill_reason").css("width", "auto");
		}
		else{
			$("#talking_ill_reason").html('');
			//$("#talking_ill_reason").css("width", "auto");
		}
	});	

	$('#unacademyAF8').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Not responding to the learner once the call is connected, resulted in call drop by learner / side-talking or speaking to someone while the learner is on the line.">Not responding to the learner once the call is connected, resulted in call drop by learner / side-talking or speaking to someone while the learner is on the line.</option>';

			$("#deliberate_malpractice_reason").html(sub_infractions);
			$("#deliberate_malpractice_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#deliberate_malpractice_reason").html(sub_infractions);
			//$("#deliberate_malpractice_reason").css("width", "auto");
		}
		else{
			$("#deliberate_malpractice_reason").html('');
			//$("#deliberate_malpractice_reason").css("width", "auto");
		}
	});

	$('#unacademyAF9').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="If the call connected and the BDE is not responding to the learner having side talk and resluted to call drop/ waiting of learner on call">If the call connected and the BDE is not responding to the learner having side talk and resluted to call drop/ waiting of learner on call</option>';

			$("#not_responding_reason").html(sub_infractions);
			$("#not_responding_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#not_responding_reason").html(sub_infractions);
			//$("#not_responding_reason").css("width", "auto");
		}
		else{
			$("#not_responding_reason").html('');
			//$("#not_responding_reason").css("width", "auto");
		}
	});

	$('#website_navigation').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Asking learners to come on the website/app to take through for navigations.1.Free classes 2.Mock and test Series 3.Combat">Asking learners to come on the website/app to take through for navigations.1.Free classes 2.Mock and test Series 3.Combat</option>';

			$("#website_navigation_reason").html(sub_infractions);
			$("#website_navigation_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#website_navigation_reason").html(sub_infractions);
			//$("#website_navigation_reason").css("width", "auto");
		}
		else{
			$("#website_navigation_reason").html('');
			//$("#website_navigation_reason").css("width", "auto");
		}
	});	

	$('#unacademyAF10').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Wrong Website navagation">Wrong Website navagation</option>';

			$("#wrong_website_navagation_reason").html(sub_infractions);
			$("#wrong_website_navagation_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#wrong_website_navagation_reason").html(sub_infractions);
			//$("#wrong_website_navagation_reason").css("width", "auto");
		}
		else{
			$("#wrong_website_navagation_reason").html('');
			//$("#wrong_website_navagation_reason").css("width", "auto");
		}
	});	

	$('#call_closing').on('change', function(){
		if($(this).val()=='Fail'){
			var sub_infractions = '<option value="Thanking and Greeting the leanrer BDE Name Brand Name Note- It is expected that the BDE has already sumarrized on the call, if its not done in this scenario Call Closing will be a merk down despte of having a Thanking and Greeting">Thanking and Greeting the leanrer BDE Name Brand Name Note- It is expected that the BDE has already sumarrized on the call, if its not done in this scenario Call Closing will be a merk down despte of having a Thanking and Greeting</option>';

			$("#call_closing_reason").html(sub_infractions);
			$("#call_closing_reason").css("width", "200px");
		}
		else if($(this).val()=='Pass' || $(this).val()=='NA'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#call_closing_reason").html(sub_infractions);
			//$("#call_closing_reason").css("width", "auto");
		}
		else{
			$("#call_closing_reason").html('');
			//$("#call_closing_reason").css("width", "auto");
		}
	});			

</script>

<script type="text/javascript">
	function unacademy_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.unacademy').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Pass'){
				var w1 = parseFloat($(element).children("option:selected").attr('unacademy_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('unacademy_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == 'Fail'){
			    var w1 = parseFloat($(element).children("option:selected").attr('unacademy_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('unacademy_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == 'NA'){
			    var w1 = parseFloat($(element).children("option:selected").attr('unacademy_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('unacademy_max'));
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
		// var fatal_count=0;
		// $('.fatal').each(function(index,element){
		// 	var score_type = $(element).val();
		// 	if(score_type=='Fail'){
		// 		fatal_count=fatal_count+1;
		// 	}
		// });
		// $('#fatalcount').val(fatal_count);
		
		// if(!isNaN(quality_score_percent)){
		// 	$('#prefatal').val(quality_score_percent);
		// }
	////////////////
		
		if($('#unacademyAF1').val()=='Fail' || $('#unacademyAF2').val()=='Fail' || $('#unacademyAF3').val()=='Fail' || $('#unacademyAF4').val()=='Fail' || $('#unacademyAF5').val()=='Fail' || $('#unacademyAF6').val()=='Fail' || $('#unacademyAF7').val()=='Fail' || $('#unacademyAF8').val()=='Fail' || $('#unacademyAF9').val()=='Fail' || $('#unacademyAF10').val()=='Fail'){
			$('.unacademy_Fatal').val(0+'%');
		}else{
			$('.unacademy_Fatal').val(quality_score_percent+'%');
		}
	}

	$(document).on('change','.unacademy',function(){
		unacademy_calc();
	});
	unacademy_calc();
</script>

////////////////vikas//////////////////////////////



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

