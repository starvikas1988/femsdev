<script type="text/javascript">

function docusign_calc()
{
		let score = 0;
		let scoreable = 0;
		let quality_score_percent = 0;

		$('.points_epi').each(function(index,element)
		{
			
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('fiberconnect'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('fiberconnect'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('fiberconnect'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#earned_score').val(score);
		$('#possible_score').val(scoreable);
		

       if($('#fiberconnect_AF1').val()=='No' || $('#fiberconnect_AF2').val()=='No' || $('#fiberconnect_AF3').val()=='No' || $('#fiberconnect_AF4').val()=='No' || $('#fiberconnect_AF5').val()=='No' || $('#fiberconnect_AF6').val()=='No' ){
       $('#overall_score').val(0);
       }else{
       			 if(!isNaN(quality_score_percent))
				{
      				 $('#overall_score').val(quality_score_percent+'%');
				}
			}


		
		
		
}
		
//////////////////////////////////////////////////////////////
		
	$(document).on('change','.points_epi',function(){ 
		docusign_calc();
    });
	docusign_calc();
		
</script>
 
<script>
$(document).ready(function(){

	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
	$("#call_date_time").datetimepicker({maxDate: new Date()});
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });
	
	
  ///////////////// Calibration - Auditor Type ///////////////////////	
	// $('#audit_type').each(function(){
	// 	$valdet=$(this).val();
	// 	if($valdet=="Calibration"){
	// 		$('.auType_epi').show();
	// 	}else{
	// 		$('.auType_epi').hide();
	// 	}
	// });

	// $('#audit_type').on('change', function(){
	// 	if($(this).val()=='Calibration'){
	// 		$('.auType_epi').show();
	// 		$('#auditor_type').attr('required',true);
	// 		$('#auditor_type').prop('disabled',false);
	// 	}else{
	// 		$('.auType_epi').hide();
	// 		$('#auditor_type').attr('required',false);
	// 		$('#auditor_type').prop('disabled',true);
	// 	}
	// });	

	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
	
  /////////////

	$(".points_epi").on("change",function(){
		docusign_calc();
	});

	docusign_calc();

	/////////////////////ACPT///////////////////////////////////

	$('.acptoth').hide();
	
	$('#acpt').on('change', function(){
		if($(this).val()=='Agent'){
			let agentAcpt = `<option value="">Select</option>
			<option value="No probing">No probing</option>
			<option value="No Urgency">No Urgency</option>
			<option value="No good faith payment">No good faith payment</option>
			<option value="No Negotiation">No Negotiation</option>
			<option value="No PDC">No PDC</option>
			<option value="No follow up">No follow up</option>
			<option value="Others">Others</option>`
			$("#acpt_option").html(agentAcpt);
		}else if($(this).val()=='Customer'){
			let customerAcpt = `<option value="">Select</option>
			<option value="Verbal Dispute">Verbal Dispute</option>
			<option value="Refused to pay">Refused to pay</option>
			<option value="Bankruptcy">Bankruptcy</option>
			<option value="Attorney handling">Attorney handling</option>
			<option value="CONSUMER CREDIT COUNSELING">CONSUMER CREDIT COUNSELING</option>
			<option value="DOCUMENTS VALIDATE THE DEBT">DOCUMENTS VALIDATE THE DEBT</option>
			<option value="Refused to pay  processing fees">Refused to pay  processing fees</option>
			<option value="Refused to make the payment over the phone">Refused to make the payment over the phone</option>
			<option value="RP driving">RP driving</option>
			<option value="RP at POE">RP at POE</option>
			<option value="CEASE ALL COMMUNICATION">CEASE ALL COMMUNICATION</option>
			<option value="Does not speak english">Does not speak english</option>
			<option value="DECEASED PENDING VERIFICATION">DECEASED PENDING VERIFICATION</option>
			<option value="DO NOT CALL">DO NOT CALL</option>
			<option value="FRAUD INVESTIGATION">FRAUD INVESTIGATION</option>
			<option value="Identity theft">Identity theft</option>
			<option value="ACTIVE ACCOUNT">ACTIVE ACCOUNT</option>
			<option value="RETURNED CHECK">RETURNED CHECK</option>
			<option value="Others">Others</option>`
			$("#acpt_option").html(customerAcpt);
		}else if($(this).val()=='Process'){
			let processAcpt = `<option value="">Select</option>
				<option value="Dealership">Dealership</option>
				<option value="Letter sent to different address">Letter sent to different address</option>
				<option value="Waiver">Waiver</option>
				<option value="Others">Others</option>`
							$("#acpt_option").html(processAcpt);
						}else if($(this).val()=='Technology'){
							let techAcpt = `<option value="">Select</option>
				<option value="call disconnected">call disconnected</option>
				<option value="connection barred">connection barred</option>
				<option value="Others">Others</option>`
			$("#acpt_option").html(techAcpt);
		}else if($(this).val()==''){
			$("#acpt_option").html('<option value="">Select</option>');
		}
	});
	
	$('#acpt_option').on('change', function(){
		if($(this).val()=='Others'){
			$('.acptoth').show();
			$('#acpt_other').attr('required',true).attr("placeholder", "Type here");
		}else{
			$('.acptoth').hide();
			$('#acpt_other').attr('required',false);
			$('#acpt_other').val('');
		}
	});

	  ///////////////// Agent and TL names ///////////////////////
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
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
				
				$('#tl_names').empty();
				$('#tl_names').append($('#tl_names').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));

				for (var i in json_obj){
					if($('#tl_names').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_names').append($('#tl_names').val(json_obj[i].tl_name));

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
	
	$('#tl_id').on('click', function(){
		alert("Can not Change TL");
		$("#tl_id").attr('disabled','disabled');
		return false;
	});
</script>
 <script type="text/javascript">
 		function fiber_connect_whitespace_v1_calc(){
		let score_whitespace_v1 = 0;
		let scoreable_whitespace_v1 = 0;
		let quality_score_percent_whitespace_v1 = 0.00;
		let pass_count_whitespace_v1 = 0;
		let fail_count_whitespace_v1 = 0;
		let na_count_whitespace_v1 = 0;
		let score_fiber_connect_whitespace_v1_final = 0;
		let scoreable_fiber_connect_whitespace_v1_final = 0;

		$('.fiber_connect_whitespace_v1_point').each(function(index,element){
			let score_type_park = $(element).val();
			
			if(score_type_park == 'Pass'){
				pass_count_whitespace_v1 = pass_count_whitespace_v1 + 1;
				let w1_whitespace_v1 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				let w2_whitespace_v1 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				
				score_whitespace_v1 = score_whitespace_v1 + w1_whitespace_v1;
				scoreable_whitespace_v1 = scoreable_whitespace_v1 + w2_whitespace_v1;

			}else if(score_type_park == 'Fail'){
				fail_count_whitespace_v1 = fail_count_whitespace_v1 + 1;
				let w1_whitespace_v1 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				let w2_whitespace_v1 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));

				//score = score + w1;
				scoreable_whitespace_v1 = scoreable_whitespace_v1 + w2_whitespace_v1;
				//scoreable = scoreable + weightage;
			}else if(score_type_park == 'N/A'){
				na_count_whitespace_v1 = na_count_whitespace_v1 + 1;
				let w1_whitespace_v1 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				let w2_whitespace_v1 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				score_whitespace_v1 = score_whitespace_v1 + w1_whitespace_v1;
				scoreable_whitespace_v1 = scoreable_whitespace_v1 + w2_whitespace_v1;
			}
		});
		quality_score_percent_whitespace_v1 = ((score_whitespace_v1*100)/scoreable_whitespace_v1).toFixed(2);

		if(quality_score_percent_whitespace_v1 == "NaN"){
			quality_score_percent_whitespace_v1 = (0.00).toFixed(2);
		}else{
			quality_score_percent_whitespace_v1 = quality_score_percent_whitespace_v1;
		}
		
      score_fiber_connect_whitespace_v1_final     = (score_whitespace_v1).toFixed(2);
      scoreable_fiber_connect_whitespace_v1_final = (scoreable_whitespace_v1).toFixed(2);

		$('#fiber_connect_whitespace_v1_earned_score').val(score_fiber_connect_whitespace_v1_final);
		$('#fiber_connect_whitespace_v1_possible_score').val(scoreable_fiber_connect_whitespace_v1_final);
		
		if(!isNaN(quality_score_percent_whitespace_v1)){
			$('#fiber_connect_whitespace_v1_overallscore').val(quality_score_percent_whitespace_v1+'%');
		}

		if($('#whitespace_v1AF1').val()=='Fail' || $('#whitespace_v1AF2').val()=='Fail' || $('#whitespace_v1AF3').val()=='Fail'|| $('#whitespace_v1AF4').val()=='Fail'|| $('#whitespace_v1AF5').val()=='Fail'|| $('#whitespace_v1AF6').val()=='Fail'|| $('#whitespace_v1AF7').val()=='Fail'|| $('#whitespace_v1AF8').val()=='Fail'|| $('#whitespace_v1AF9').val()=='Fail'){
			console.log($('#whitespace_v1AF1').val());

			quality_score_percent_whitespace_v1 = (0.00).toFixed(2);
			$('.fiber_connect_whitespaceFatal').val(quality_score_percent_whitespace_v1+'%');
		}else{
			$('#fiber_connect_whitespace_v1_overallscore').val(quality_score_percent_whitespace_v1+'%');
		}

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Pass'){
				var w1 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Fail'){
				var w1 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#customer_earned_score').val(customerScore);
		$('#customer_possible_score').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#customer_overall_score').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Pass'){
				var w2 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Fail'){
				var w2 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#business_earned_score').val(businessScore);
		$('#business_possible_score').val(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#business_overall_score').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Pass'){
				var w3 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Fail'){
				var w3 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#compliance_earned_score').val(complianceScore);
		$('#compliance_possible_score').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#compliance_overall_score').val(compliancePercentage+'%');
		}
	}
	
	$(document).on('change','.fiber_connect_whitespace_v1_point',function(){
		fiber_connect_whitespace_v1_calc();
	});
	fiber_connect_whitespace_v1_calc();
</script>

 <script type="text/javascript">
 		function fiber_connect_greenspace_calc(){
		let score_greenspace = 0;
		let scoreable_greenspace = 0;
		let quality_score_percent_greenspace = 0.00;
		let pass_count_greenspace = 0;
		let fail_count_greenspace = 0;
		let na_count_greenspace = 0;
		let score_fiber_connect_greenspace_final = 0;
		let scoreable_fiber_connect_greenspace_final = 0;

		$('.fiber_connect_greenspace_point').each(function(index,element){
			let score_type_park = $(element).val();
			
			if(score_type_park == 'Pass'){
				pass_count_greenspace = pass_count_greenspace + 1;
				let w1_greenspace = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				let w2_greenspace = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				
				score_greenspace = score_greenspace + w1_greenspace;
				scoreable_greenspace = scoreable_greenspace + w2_greenspace;

			}else if(score_type_park == 'Fail'){
				fail_count_greenspace = fail_count_greenspace + 1;
				let w1_greenspace = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				let w2_greenspace = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));

				//score = score + w1;
				scoreable_greenspace = scoreable_greenspace + w2_greenspace;
				//scoreable = scoreable + weightage;
			}else if(score_type_park == 'N/A'){
				na_count_greenspace = na_count_greenspace + 1;
				let w1_greenspace = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				let w2_greenspace = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				score_greenspace = score_greenspace + w1_greenspace;
				scoreable_greenspace = scoreable_greenspace + w2_greenspace;
			}
		});
		quality_score_percent_greenspace = ((score_greenspace*100)/scoreable_greenspace).toFixed(2);

		if(quality_score_percent_greenspace == "NaN"){
			quality_score_percent_greenspace = (0.00).toFixed(2);
		}else{
			quality_score_percent_greenspace = quality_score_percent_greenspace;
		}
		
      score_fiber_connect_greenspace_final     = (score_greenspace).toFixed(2);
      scoreable_fiber_connect_greenspace_final = (scoreable_greenspace).toFixed(2);

		$('#fiber_connect_greenspace_earned_score').val(score_fiber_connect_greenspace_final);
		$('#fiber_connect_greenspace_possible_score').val(scoreable_fiber_connect_greenspace_final);
		
		if(!isNaN(quality_score_percent_greenspace)){
			$('#fiber_connect_greenspace_overallscore').val(quality_score_percent_greenspace+'%');
		}

		if($('#greenspaceAF1').val()=='Fail' || $('#greenspaceAF2').val()=='Fail'){
			console.log($('#greenspaceAF1').val());

			quality_score_percent_greenspace = (0.00).toFixed(2);
			$('.greenspaceFatal').val(quality_score_percent_greenspace+'%');
		}else{
			$('#fiber_connect_greenspace_overallscore').val(quality_score_percent_greenspace+'%');
		}

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Pass'){
				var w1 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Fail'){
				var w1 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#customer_earned_score').val(customerScore);
		$('#customer_possible_score').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#customer_overall_score').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Pass'){
				var w2 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Fail'){
				var w2 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#business_earned_score').val(businessScore);
		$('#business_possible_score').val(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#business_overall_score').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Pass'){
				var w3 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Fail'){
				var w3 = parseFloat($(element).children("option:selected").attr('fiber_connect_max'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('fiber_connect_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#compliance_earned_score').val(complianceScore);
		$('#compliance_possible_score').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#compliance_overall_score').val(compliancePercentage+'%');
		}
	}
	
	$(document).on('change','.fiber_connect_greenspace_point',function(){
		fiber_connect_greenspace_calc();
	});
	fiber_connect_greenspace_calc();
</script>
 <script>
	// function checkDec(el){
	// 	var ex = /^[0-9]+\.?[0-9]*$/;
	// 	if(ex.test(el.value)==false){
	// 		el.value = el.value.substring(0,el.value.length - 1);
	// 	}
	// }
 </script>
