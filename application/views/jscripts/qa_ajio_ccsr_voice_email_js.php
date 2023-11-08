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

<script type="text/javascript">
	$('#follow_OB_call').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Opening script not followed as per Process">Opening script not followed as per Process</option>';
			sub_infractions += '<option value="Seek permission to continue">Seek permission to continue</option>';
			sub_infractions += '<option value="Self intro & Branding">Self intro & Branding</option>';
			sub_infractions += '<option value="Personalization">Personalization</option>';
			sub_infractions += '<option value="Opening script not followed">Opening script not followed</option>';
			$("#follow_OB_call_l1").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#follow_OB_call_l1").html(sub_infractions);
		}
		else{
			$("#follow_OB_call_l1").html('');
		}
	});

	$('#ajioAF1_ccsr').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Champ did not make all 3 valid attempts">Champ did not make all 3 valid attempts</option>';
			sub_infractions += '<option value="Champ did not send closure email in case of unsuccessful attempt">Champ did not send closure email in case of unsuccessful attempt</option>';
			sub_infractions += '<option value="OB attempts not done as per interval guidelines">OB attempts not done as per interval guidelines</option>';
			sub_infractions += '<option value="Incomplete call if call disconnected : OB call not made">Incomplete call if call disconnected : OB call not made</option>';
			$("#three_strike_rule_l2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#three_strike_rule_l2").html(sub_infractions);
		}
		else{
			$("#three_strike_rule_l2").html('');
		}
	});

	$('#further_assistance').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Closing script not allowed">Closing script not allowed</option>';
			sub_infractions += '<option value="FA missing">FA missing</option>';
			sub_infractions += '<option value="Out call not done">Out call not done</option>';
			$("#further_assistance_l3").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#further_assistance_l3").html(sub_infractions);
		}
		else{
			$("#further_assistance_l3").html('');
		}
	});

	$('#polite').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Apology used but misplaced">Apology used but misplaced</option>';
			sub_infractions += '<option value="Did not provide effective assurance">Did not provide effective assurance</option>';
			sub_infractions += '<option value="Did not acknowledge/apologize when required">Did not acknowledge/apologize when required</option>';
			sub_infractions += '<option value="Lack of pleasantries">Lack of pleasantries</option>';
			$("#polite_l4").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#polite_l4").html(sub_infractions);
		}
		else{
			$("#polite_l4").html('');
		}
	});

	$('#comprehend_articulate').on('change', function(){
		if($(this).val()=='No'){

			var sub_infractions = '<option value="Not able to comprehend the issue & failed to communicate as per stake holder resolution">Not able to comprehend the issue & failed to communicate as per stake holder resolution</option>';
			sub_infractions += '<option value="Asked unnecessary/irrelevant questions">Asked unnecessary/irrelevant questions</option>';
			sub_infractions += '<option value="Asked details already available">Asked details already available</option>';
			sub_infractions += '<option value="Unable to comprehend">Unable to comprehend</option>';
			sub_infractions += '<option value="Failed to paraphrase to ensure understanding">Failed to paraphrase to ensure understanding</option>';
			sub_infractions += '<option value="Proactive language switch">Proactive language switch</option>';
			sub_infractions += '<option value="Poor sentence construction">Poor sentence construction</option>';
			sub_infractions += '<option value="Incorrect Font Size/Color/Style">Incorrect Font Size/Color/Style</option>';
			sub_infractions += '<option value="Champ mentions date in mm-dd-yyyy">Champ mentions date in mm-dd-yyyy</option>';
			sub_infractions += '<option value="Prefix is not aligned ">Prefix is not aligned </option>';
			sub_infractions += '<option value="Champ change the subject line as its not allowed">Champ change the subject line as its not allowed</option>';
			sub_infractions += '<option value="Champ used alternative template">Champ used alternative template</option>';
			sub_infractions += '<option value="Champ used his own template">Champ used his own template</option>';
			sub_infractions += '<option value="Champ used Complicated language/statements">Champ used Complicated language/statements</option>';
			sub_infractions += '<option value="Champ used jargons">Champ used jargons</option>';
			sub_infractions += '<option value="Capitalization error">Capitalization error</option>';
			sub_infractions += '<option value="Punctuation error">Punctuation error</option>';
			sub_infractions += '<option value="Spacing issue">Spacing issue</option>';
			sub_infractions += '<option value="Grammatical  errors">Grammatical  errors</option>';
			sub_infractions += '<option value="Spelling mistakes">Spelling mistakes</option>';
			sub_infractions += '<option value="Used multiple statements/Repetitive words ">Used multiple statements/Repetitive words </option>';
			sub_infractions += '<option value="Specification of comma is not used properly">Specification of comma is not used properly</option>';
			$("#comprehend_articulate_l5").html(sub_infractions);
		}else if($(this).val()=='Autofail'){
			sub_infractions = '<option value="Addition of template is missing when required ">Addition of template is missing when required </option>';
			sub_infractions += '<option value="Customization not done as per customer VOC">Customization not done as per customer VOC</option>';
			$("#comprehend_articulate_l5").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#comprehend_articulate_l5").html(sub_infractions);
		}
		else{
			$("#comprehend_articulate_l5").html('');
		}
	});

	$('#active_listening').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Made customer repeat when clearly audible">Made customer repeat when clearly audible</option>';
			sub_infractions += '<option value="Did not allow the customer to speak - Multiple interruption">Did not allow the customer to speak - Multiple interruption</option>';
			sub_infractions += '<option value="Rushing on call/High ROS">Rushing on call/High ROS</option>';
			$("#active_listening_l6").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#active_listening_l6").html(sub_infractions);
		}
		else{
			$("#active_listening_l6").html('');
		}
	});

	$('#handle_objections').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Did not handle objection handling script">Did not handle objection handling script</option>';
			sub_infractions += '<option value="Alternative option not provided if required">Alternative option not provided if required</option>';
			$("#handle_objections_l7").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#handle_objections_l7").html(sub_infractions);
		}
		else{
			$("#handle_objections_l7").html('');
		}
	});

	$('#enable_resolution').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Cockpit navigation issue">Cockpit navigation issue</option>';
			sub_infractions += '<option value="KM not referred">KM not referred</option>';
			sub_infractions += '<option value="PL portal not referred">PL portal not referred</option>';
			sub_infractions += '<option value="CCSR SOP not adhere">CCSR SOP not adhere</option>';
			$("#enable_resolution_l8").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#enable_resolution_l8").html(sub_infractions);
		}
		else{
			$("#enable_resolution_l8").html('');
		}
	});

		$('#ajioAF2_ccsr').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Previous interaction not checked">Previous interaction not checked</option>';
			sub_infractions += '<option value="Duplicate Ticket raised">Duplicate Ticket raised</option>';
			sub_infractions += '<option value="Previous Complaint not checked">Previous Complaint not checked</option>';
			sub_infractions += '<option value="Duplicate Ticket Raised">Duplicate Ticket Raised</option>';
			$("#complaint_history_l9").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#complaint_history_l9").html(sub_infractions);
		}
		else{
			$("#complaint_history_l9").html('');
		}
	});

	$('#ajioAF3_ccsr').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Add Course correction not done when it was required (New Ticket raised/assigning)">Add Course correction not done when it was required (New Ticket raised/assigning)</option>';
				sub_infractions += '<option value="Complaint  Re open without mentioning reason of dispute">Complaint  Re open without mentioning reason of dispute</option>';
				sub_infractions += '<option value="Compliant did not Re-open when  required">Compliant did not Re-open when  required</option>';
				sub_infractions += '<option value="Complaint re open when not required">Complaint re open when not required</option>';
				sub_infractions += '<option value="Wrongly Reassign Ticket">Wrongly Reassign Ticket</option>';
				sub_infractions += '<option value="Incomplete/Incorrect Remarks">Incomplete/Incorrect Remarks</option>';
				sub_infractions += '<option value="Ticket not closed when required">Ticket not closed when required</option>';
				sub_infractions += '<option value="Ticket not Open when required">Ticket not Open when required</option>';
				sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
				sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
				sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
				sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
				sub_infractions += '<option value="Action not taken">Action not taken</option>';
				sub_infractions += '<option value="NA">NA</option>';
			$("#reopen_complaint_l10").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#reopen_complaint_l10").html(sub_infractions);
		}
		else{
			$("#reopen_complaint_l10").html('');
		}
	});

	$('#addressed_proactively').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Open issue against any order ID of the a/c not addressed">Open issue against any order ID of the a/c not addressed</option>';
			$("#addressed_proactively_l11").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#addressed_proactively_l11").html(sub_infractions);
		}
		else{
			$("#addressed_proactively_l11").html('');
		}
	});

	$('#ajioAF4_ccsr').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Without customer consent closing Ticket">Without customer consent closing Ticket</option>';
			sub_infractions += '<option value="Incomplete Information">Incomplete Information</option>';
			sub_infractions += '<option value="Inaccurate Information">Inaccurate Information</option>';
			sub_infractions += '<option value="Wrong Action Taken">Wrong Action Taken</option>';
			sub_infractions += '<option value="No Action Taken">No Action Taken</option>';
			sub_infractions += '<option value="False Assurance">False Assurance</option>';
			$("#answered_properly_l12").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#answered_properly_l12").html(sub_infractions);
		}
		else{
			$("#answered_properly_l12").html('');
		}
	});

	$('#ajioAF5_ccsr').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="OB tagging not done">OB tagging not done</option>';
			sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Tagging not done">Tagging not done</option>';
			sub_infractions += '<option value="Documented on incorrect account">Documented on incorrect account</option>';
			sub_infractions += '<option value="All queries not documented">All queries not documented</option>';
			sub_infractions += '<option value="QT Not Tagged ">QT Not Tagged </option>';
			$("#tagging_guidelines_l13").html(sub_infractions);
		}else if($(this).val()=='No'){
			sub_infractions = '<option value="CAM rule not adhered to.">CAM rule not adhered to.</option>';
			$("#tagging_guidelines_l13").html(sub_infractions);
		}else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#tagging_guidelines_l13").html(sub_infractions);
		}
		
		else{
			$("#tagging_guidelines_l13").html('');
		}
	});

	$('#ajioAF6_ccsr').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Call Avoidance">Call Avoidance</option>';
			sub_infractions += '<option value="Call disconnection">Call disconnection</option>';
			sub_infractions += '<option value="Abusive behaviour">Abusive behaviour</option>';
			sub_infractions += '<option value="Mocking the customer">Mocking the customer</option>';
			sub_infractions += '<option value="Rude behaviour on call">Rude behaviour on call</option>';
			sub_infractions += '<option value="Dialed personal number">Dialed personal number</option>';
			$("#ztp_guidelines_l14").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ztp_guidelines_l14").html(sub_infractions);
		}
		else{
			$("#ztp_guidelines_l14").html('');
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

