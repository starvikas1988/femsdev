<script type="text/javascript">	
	function ukus_calculation(){
		var score = 0;
		$('.ukus_point').each(function(index,element){
			var weightage = parseFloat($(element).children("option:selected").attr('ukus_val'));
			score = score + weightage;
		});
		
		if(!isNaN(score)){
			$('#ukusScore').val(score+'%');
		}
		
		if($('#ukusAutof1').val()=='No' || $('#ukusAutof2').val()=='Yes' || $('#ukusAutof3').val()=='Yes' || $('#ukusAutof4').val()=='No' || $('#ukusAutof5').val()=='No' || $('#ukusAutof6').val()=='No' || $('#ukusnewAutof1').val()=='Yes' || $('#ukusnewAutof2').val()=='Yes' || $('#ukusnewAutof3').val()=='Yes'
		|| $('#ukusnewAutof4').val()=='Yes'	|| $('#ukusnewAutof5').val()=='Yes' || $('#ukusnewAutof6').val()=='Yes'){
			$('.ukusAutofail').val(0);
		}else{
			$('.ukusAutofail').val(score+'%');
		}
	}
/////////////////Wallet Recharge OYO Part ////////////////////////////////////

function walletrecharge_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.walletrecharge_points').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('walletrecharge_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Fatal'){
				var weightage = parseFloat($(element).children("option:selected").attr('walletrecharge_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('walletrecharge_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('walletrecharge_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		//$('#walletrecharge_earnedScore').val(score);
		$('#walletrecharge_possibleScore').val(scoreable);

		if(($('#walletrec1').val()=='Fatal' || $('#walletrec2').val()=='Fatal' || $('#walletrec3').val()=='Fatal')){
		$('#walletrecharge_overallScore').val(0);
		$('#walletrecharge_earnedScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#walletrecharge_earnedScore').val(score);
				$('#walletrecharge_overallScore').val(quality_score_percent+'%');
			}	
		}
	
	}
	
	$(document).on('change','.walletrecharge_points',function(){
		walletrecharge_calc();
	});
	walletrecharge_calc();
// function ukusnew_calculation(){
// 		var score = 0;
// 		$('.ukus_point').each(function(index,element){
// 			var weightage = parseFloat($(element).children("option:selected").attr('ukus_val'));
// 			score = score + weightage;
// 		});
		
// 		if(!isNaN(score)){
// 			$('#ukusScore').val(score+'%');
// 		}
		
// 		if($('#ukusnewAutof1').val()=='Yes' || $('#ukusnewAutof2').val()=='Yes' || $('#ukusnewAutof3').val()=='Yes' || $('#ukusnewAutof4').val()=='Yes' || $('#ukusnewAutof5').val()=='Yes' || $('#ukusnewAutof6').val()=='Yes'){
// 			$('.ukusnewAutof').val(0);
// 		}else{
// 			$('.ukusnewAutof').val(score+'%');
// 		}
// 	}
////////////////	
	function sig_calc(){
		var score = 0;
		$('.sig_point').each(function(index,element){
			var weightage = parseFloat($(element).children("option:selected").attr('sig_val'));
			score = score + weightage;
		});
		
		if(!isNaN(score)){
			$('#sigScore').val(score+'%'); 
		}
		
		if($('#legitimate_hold').val()=='No' || $('#correct_information').val()=='No' || $('#proper_followup').val()=='No' || $('#accurate_tagging').val()=='No' || $('#Gsat_survey_avoidance').val()=='No' || $('#handled_ethically').val()=='No' || $('#maintained_profanity').val()=='No' || $('#sounded_sarcastic').val()=='No' || $('#false_commitment').val()=='No' || $('#force_close_ticket').val()=='No' || $('#escalation_ticket').val()=='No' || $('#duplicate_tickets').val()=='No' || $('#escalation_matrix').val()=='No' || $('#misuse_hold_protocol').val()=='No'|| $('#warning_letter').val()=='No'|| $('#zero_tolerance').val()=='No'){
			$('.sigAutofail').val(0);
		}else{
			$('.sigAutofail').val(score+'%');
		}
	}
</script>

<script type="text/javascript">
	function sig_mohali_calc(){
		var check_fatal=false;
			$(".sig_mohali_point").each(function(){
				if($(this).hasClass("sig_mohali_fatal") && ($(this).val()=="Yes") ){
					check_fatal=true;
					$("#sig_mohali_overall_score").val("0.00%");
				}
			});
			if(!check_fatal){
				//var earned_score = 0, possible_score=0, overall_score="";
				var earned_score = 0, possible_score=0, overall_score="", cust_earned=0, cust_possible=0, cust_overall=0;
			    var comp_earned=0, comp_possible=0, comp_overall=0, business_earned=0, business_possible=0, business_overall=0;
				$(".sig_mohali_point").each(function(index, element){

					if($(element).val()!="NA" && $(element).val()!=""){
						var earned_weightage = parseFloat($(element).children("option:selected").attr('sig_val'));
						earned_score += earned_weightage;
						console.log(earned_score);
						console.log("okk1");
						var weightage = parseFloat($(element).children("[value='Yes']").attr('sig_val'));
						possible_score += weightage;
						console.log(possible_score);
						console.log("okk2");
						overall_score=parseFloat((earned_score/possible_score)*100);
						//console.log(overall_score);

						$("#sig_mohali_overall_score").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
						
					}
				});
			}
			if(!isNaN(earned_score)){
				$("#sig_mohali_earned_score").val(earned_score);
			}
			if(!isNaN(possible_score)){
				$("#sig_mohali_possible_score").val(possible_score);
			}
	}
</script>

<script>
	/////////////////Wallet Recharge OYO Part ////////////////////////////////////
/*----------------- Customer VOC & Sub VOC ------------------*/
		$('#cust_voc').on('change', function(){
			if($(this).val()=='Auto check in issue'){
				var custVoc1 = '<option value="">Select</option>';
				custVoc1 += '<option value="owner raised issue of forced check charges">owner raised issue of forced check charges</option>';
				custVoc1 += '<option value="Auto check in Marked by RM/AGM">Auto check in Marked by RM/AGM</option>';
				custVoc1 += '<option value="No Show marked but still Auto check in charges levied">No Show marked but still Auto check in charges levied</option>';
				custVoc1 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc1);
			}else if($(this).val()=='DA charges'){
				var custVoc2 = '<option value="">Select</option>';
				custVoc2 += '<option value="Digital audit charges levied but guest did not turn up">Digital audit charges levied but guest did not turn up</option>';
				custVoc2 += '<option value="Digital audit penalty charges levied unnecessary">Digital audit penalty charges levied unnecessary</option>';
				custVoc2 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc2);
			}else if($(this).val()=='Extra Amount deduction from secure wallet'){
				var custVoc3 = '<option value="">Select</option>';
				custVoc3 += '<option value="GST charges levied but owner provided GSt number">GST charges levied but owner provided GSt number</option>';
				custVoc3 += '<option value="Deduction from secure wallet even if all the bookings were prepaid">Deduction from secure wallet even if all the bookings were prepaid</option>';
				custVoc3 += '<option value="Negative Current balance">Negative Current balance</option>';
				custVoc3 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc3);
			}else if($(this).val()=='Bookings not received from OYO'){
				var custVoc4 = '<option value="">Select</option>';
				custVoc4 += '<option value="Owner not received bookings from OYO">Owner not received bookings from OYO</option>';
				custVoc4 += '<option value="Fake bookings and guest are not coming">Fake bookings and guest are not coming</option>';
				custVoc4 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc4);
			}else if($(this).val()=='Other issues'){
				var custVoc5 = '<option value="">Select</option>';
				custVoc5 += '<option value="Did not recharge due to funds issues">Did not recharge due to funds issues</option>';
				custVoc5 += '<option value="owner is out station">owner is out station</option>';
				custVoc5 += '<option value="health issue of owner and family member">health issue of owner and family member</option>';
				custVoc5 += '<option value="Quit from OYO">Quit from OYO</option>';
				custVoc5 += '<option value="Property under renovation">Property under renovation</option>';
				custVoc5 += '<option value="Ground team not responding for documentation as well as location not added">Ground team not responding for documentation as well as location not added</option>';
				custVoc5 += '<option value="Recharge amount not credited in account">Recharge amount not credited in account</option>';
				custVoc5 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc5);
			}else if($(this).val()=='Low tariff/Booking issues'){
				var custVoc6 = '<option value="">Select</option>';
				custVoc6 += '<option value="Low bookings price">Low bookings price</option>';
				custVoc6 += '<option value="Not able to bear minimum expenses in current tariff">Not able to bear minimum expenses in current tariff</option>';
				custVoc6 += '<option value="Not getting corporate bookings">Not getting corporate bookings</option>';
				custVoc6 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc6);
			}else if($(this).val()=='Reconciliation issues'){
				var custVoc7 = '<option value="">Select</option>';
				custVoc7 += '<option value="Hotel share was not provided ">Hotel share was not provided </option>';
				custVoc7 += '<option value="Incorrect reconciliation amount calculated ">Incorrect reconciliation amount calculated </option>';
				custVoc7 += '<option value="Recon statement not received">Recon statement not received</option>';
				custVoc7 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc7);
			}else if($(this).val()=='N/A'){
				var custVoc8 = '<option value="">Select</option>';
				custVoc8 += '<option value="N/A">N/A</option>';
				custVoc8 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc8);
			}else if($(this).val()=='Other'){
				var custVoc9 = '<option value="">Select</option>';
				custVoc9 += '<option value="Other">Other</option>';
				$("#cust_sub_voc").html(custVoc9);
			}
		});

//	});	//ready function end
</script>
<script>
function date_validation(val,type){ 
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		if(type=='E'){
		var start_date=$("#from_date").val();
		//if(val<start_date)
		if(Date.parse(val) < Date.parse(start_date))
		{
			$(".end_date_error").html("To Date must be greater or equal to From Date");
			 $(".esal-effect").attr("disabled",true);
			 $(".esal-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".esal-effect").attr("disabled",false);
			 $(".esal-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".esal-effect").attr("disabled",true);
			 $(".esal-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".esal-effect").attr("disabled",false);
			 $(".esal-effect").css('cursor', 'pointer');
			}

		}
		
		
	}

	// var todayDate = new Date();
    // var month = todayDate.getMonth();
    // var year = todayDate.getUTCFullYear() - 0;
    // var tdate = todayDate.getDate();
    // if (month < 10) {
    //     month = "0" + month
    // }
    // if (tdate < 10) {
    //     tdate = "0" + tdate;
    // }
    // var maxDate = year + "-" + month + "-" + tdate;
    // document.getElementById("call_date_time").setAttribute("min", maxDate);
   // console.log(maxDate);




</script>

<script>
	   function phone_noFunction(phone_no){
			var phone_no=$("#phone_no").val();


		if((phone_no.length <10) || (phone_no.length >12)){
				$("#msg-phone_no").html("<font color=red style='font-size:14px;'>Please enter the correct format</font>");
			
				$(".waves-effect").attr("disabled",true);
				$(".waves-effect").css('cursor', 'no-drop');
				
			} else{
				$("#msg-phone_no").html("");
				$(".waves-effect").attr("disabled",false);
				$(".waves-effect").css('cursor', 'pointer');
				
			}
  }	

  
//   function phone_no_keyup(phone_no) {
// 	$("#msg-phone_no").html("");
	
// }




jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
          
            return ((key == 8) || (key == 37) || (key == 39) || (key == 46) ||    (key == 189) || (key >= 48 && key <= 57)|| (key >= 96 && key <= 105)|| (key >= 65 && key <= 90));
        });
    });
};



$("#call_id").ForceNumericOnly();

$("#reference").ForceNumericOnly();



$(function () {
   $('#phone_no').keydown(function (e) {
        if (e.shiftKey || e.ctrlKey || e.altKey) {
           e.preventDefault();
        } 
        else {
            var key = e.keyCode;
            if (!((key == 8) || (key == 37) || (key == 39) || (key == 46) || (key ==16) ||  (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
               e.preventDefault();
            }
        }
    });
});
</script>

<!-- <script>
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'avi':
			case 'mp4':
				case '3gp':
					case 'mpeg':
						case 'mpg':
							case 'mov':
								case 'mp3':
								case 'wav':
        case 'flv':
        case 'wmv':
			case'mkv':
            $('#qaformsubmit').attr('disabled', false);
            break;
        default:
            alert('This is not an allowed file type.');
			//$('#qaformsubmit').attr('disabled', true);
            this.value = '';
    }
});
</script> -->

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
		function check_numberDec(el) {
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
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datetimepicker({ maxDate: new Date() });
	$("#call_date2").datetimepicker({ maxDate: new Date() });
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({  maxDate: new Date() });
	$("#to_date").datepicker({  maxDate: new Date() });
	
	
///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	if($("#audit_type").val() == "Calibration"){
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').val("")
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});	
	
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
	
//////////////// After Submit Form Disabled //////////////////////
	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	/* $("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});	 */
	
/////////////////////////////// UK US ////////////////////////////////////
	$('#type_audit').on('change', function(){
		if($(this).val()=='Cancellation'){
			var ta_option = '<option value="Booking created by mistake">Booking created by mistake</option>';
			ta_option += '<option value="Cancelled by mistake">Cancelled by mistake</option>';
			ta_option += '<option value="Card Charge Failure">Card Charge Failure</option>';
			ta_option += '<option value="Change in plan">Change in plan</option>';
			ta_option += '<option value="Checked-In">Checked-In</option>';
			ta_option += '<option value="Checkin Denied - Invalid ID">Checkin Denied - Invalid ID</option>';
			ta_option += '<option value="Checkin Denied - Low Tariff Issue">Checkin Denied - Low Tariff Issue</option>';
			ta_option += '<option value="Checkin Denied - OTA overbooking">Checkin Denied - OTA overbooking</option>';
			ta_option += '<option value="Checkin Denied - Overbooking">Checkin Denied - Overbooking</option>';
			ta_option += '<option value="Checkin Denied - Owner Booking">Checkin Denied - Owner Booking</option>';
			ta_option += '<option value="Checkin Denied - Property Blocked/Closed">Checkin Denied - Property Blocked/Closed</option>';
			ta_option += '<option value="Checkin Denied - Rooms under maintenance">Checkin Denied - Rooms under maintenance</option>';
			ta_option += '<option value="Confirm Booking">Confirm Booking</option>';
			ta_option += '<option value="Could not locate hotel">Could not locate hotel</option>';
			ta_option += '<option value="COVID-19 lockdown">COVID-19 lockdown</option>';
			ta_option += '<option value="Denied Checkin - Others">Denied Checkin - Others</option>';
			ta_option += '<option value="Found a better deal">Found a better deal</option>';
			ta_option += '<option value="Guest asked to cancel">Guest asked to cancel</option>';
			ta_option += '<option value="Guest below 21 years of age">Guest below 21 years of age</option>';
			ta_option += '<option value="Guest did not have government ID">Guest did not have government ID</option>';
			ta_option += '<option value="Guest did not like the room">Guest did not like the room</option>';
			ta_option += '<option value="Guest was intoxicated">Guest was intoxicated</option>';
			ta_option += '<option value="Guest was rude or misbehaved">Guest was rude or misbehaved</option>';
			ta_option += '<option value="Guest was unwilling/incapable to pay security deposit">Guest was unwilling/incapable to pay security deposit</option>';
			ta_option += '<option value="Hotel asked me to cancel">Hotel asked me to cancel</option>';
			ta_option += '<option value="Hotel restrictions issue">Hotel restrictions issue</option>';
			ta_option += '<option value="Hotel was overbooked">Hotel was overbooked</option>';
			ta_option += '<option value="I made booking on a wrong date">I made booking on a wrong date</option>';
			ta_option += '<option value="I made this booking by mistake">I made this booking by mistake</option>';
			ta_option += '<option value="Invalid Card">Invalid Card</option>';
			ta_option += '<option value="IVR">IVR</option>';
			ta_option += '<option value="No Show">No Show</option>';
			ta_option += '<option value="Property/Service not good">Property/Service not good</option>';
			ta_option += '<option value="Saved booking">Saved booking</option>';
			ta_option += '<option value="Special Requirements not met">Special Requirements not met</option>';
			ta_option += '<option value="Unsuccessful Shifting">Unsuccessful Shifting</option>';
			ta_option += '<option value="Others">Others</option>';
			$("#cancel_sub_audit_type").html(ta_option);
		}else{
			$("#cancel_sub_audit_type").html('<option value="NA">NA</option>');
		}	
	});

	///////////////////////////SIG MOHALI//////////////////////////////

	$('#call_opening_5sec_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks1").html('<option value="">Select</option><option value="Did not open the call within 5 secs">Did not open the call within 5 secs</option><option value="Self Introduction missing/clear">Self Introduction missing/clear</option><option value="OYO Branding missing">OYO Branding missing</option><option value="Brand name was not clear">Brand name was not clear</option><option value="Opening greetings missing/Incorrect greetings">Opening greetings missing/Incorrect greetings</option><option value="No Opening">No Opening</option><option value="No Opening given with guest/PM/stock team (handled transferred call)">No Opening given with guest/PM/stock team (handled transferred call)</option>');
			}else{
			$("#sig_mohaliremarks1").html('<option value="NA">NA</option>');
		}
	});


	$('#probing_done_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks2").html('<option value="">Select</option><option value="Unnecessary Probing">Unnecessary Probing</option><option value="Incorrect Probing ">Incorrect Probing </option><option value="No probing done when required">No probing done when required</option>');
			}else{
			$("#sig_mohaliremarks2").html('<option value="NA">NA</option>');
		}
		
	});

	$('#issue_identified_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks3").html('<option value="">Select</option><option value="Issue not identified correctly">Issue not identified correctly</option><option value="Issue not paraphrased">Issue not paraphrased</option><option value="Paraphrasing was not done completely">Paraphrasing was not done completely</option>');
		}else{
			$("#sig_mohaliremarks3").html('<option value="NA">NA</option>');
		}
	});

	$('#apology_empathy_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks4").html('<option value="">Select</option><option value="Timely apology not done">Timely apology not done</option><option value="Apology/empathy not done">Apology/empathy not done</option><option value="Apology/empathy sounded scripted">Apology/empathy sounded scripted</option>');
			}else{
			$("#sig_mohaliremarks4").html('<option value="NA">NA</option>');
		}
		
	});

	$('#voice_intonation_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks5").html('<option value="">Select</option><option value="High rate of speech">High rate of speech</option><option value="Sounding robotic & Scripted">Sounding robotic & Scripted</option><option value="Voice clarity issues">Voice clarity issues</option>');
		}else{
			$("#sig_mohaliremarks5").html('<option value="NA">NA</option>');
		}
	});

	$('#active_listening_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks6").html('<option value="">Select</option><option value="Too many Interruptions > 1 instance">Too many Interruptions > 1 instance</option><option value="Made the customer repeat > 1 instance">Made the customer repeat > 1 instance</option>');
		}else{
			$("#sig_mohaliremarks6").html('<option value="NA">NA</option>');
		}
	});

	$('#confidence_and_enthusiasm_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks7").html('<option value="">Select</option><option value="Fumbling on call >5 instances">Fumbling on call >5 instances</option><option value="Lack of Confidence (tone)">Lack of Confidence (tone)</option><option value="Fillers used >5 instances">Fillers used >5 instances</option><option value="Not energetic on call">Not energetic on call</option');
		}else{
			$("#sig_mohaliremarks7").html('<option value="NA">NA</option>');
		}
	});

	$('#politeness_professionalism_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks8").html('<option value="">Select</option><option value="Did not use power words">Did not use power words</option><option value="Did not display willingness to help">Did not display willingness to help</option><option value="Sounding casual on call">Sounding casual on call</option><option value="Agent was blunt/ authoritative/aggressive">Agent was blunt/ authoritative/aggressive</option><option value="Agent was Yawning on call">Agent was Yawning on call</option>');
		}else{
			$("#sig_mohaliremarks8").html('<option value="NA">NA</option>');
		}
	});

	$('#grammar_sentence_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks9").html('<option value="">Select</option><option value="Incorrect sentence formation/Choice of words">Incorrect sentence formation/Choice of words</option><option value="Incomplete sentence used">Incomplete sentence used</option><option value="Grammatical error on call">Grammatical error on call</option><option value="Language mismatch">Language mismatch</option>');
		}else{
			$("#sig_mohaliremarks9").html('<option value="NA">NA</option>');
		}
	});

	$('#acknowledgement_guest_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks10").html('<option value="">Select</option><option value="Did not acknowledge">Did not acknowledge</option><option value="Delayed acknowledgment (>=5 sec)">Delayed acknowledgment (>=5 sec)</option><option value="Assurance not offered">Assurance not offered</option>');
		}else{
			$("#sig_mohaliremarks10").html('<option value="NA">NA</option>');
		}
	});

	$('#agent_adhere_hold_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks11").html('<option value="">Select</option><option value="Did not seek permission">Did not seek permission</option><option value="Did not mention hold duration">Did not mention hold duration</option><option value="Did not mention hold reason">Did not mention hold reason</option><option value="Hold procedure was applicable and agent did not use it">Hold procedure was applicable and agent did not use it</option><option value="Did not thank the customer after returning from hold">Did not thank the customer after returning from hold</option><option value="Apology missing for long hold">Apology missing for long hold</option><option value="Did not put customer on hold post hold permission">Did not put customer on hold post hold permission</option><option value="Did not refresh Hold as per the committed time (Few min = 3 min)">Did not refresh Hold as per the committed time (Few min = 3 min)</option>');
		}else{
			$("#sig_mohaliremarks11").html('<option value="NA">NA</option>');
		}
	});

	$('#agent_adhere_dead_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks12").html('<option value="">Select</option><option value="Dead Air observed more than 20 seconds">Dead Air observed more than 20 seconds</option>');
		}else{
			$("#sig_mohaliremarks12").html('<option value="NA">NA</option>');
		}
	});

	$('#legitimate_hold_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks13").html('<option value="">Select</option><option value="Unnecessary Hold observed less than 5 minutesUnnecessary Hold observed  5 to 10 minutes">Unnecessary Hold observed less than 5 minutesUnnecessary Hold observed  5 to 10 minutes</option><option value="Unnecessary Hold observed  5 to 10 minutes">Unnecessary Hold observed  5 to 10 minutes</option><option value="Unnecessary Hold observed  10 to 15 minutes">Unnecessary Hold observed  10 to 15 minutes</option><option value="Unnecessary Hold observed  greater than 15 minutes">Unnecessary Hold observed  greater than 15 minutes</option>');
		}else{
			$("#sig_mohaliremarks13").html('<option value="NA">NA</option>');
		}
	});

	$('#resolution_provided_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks14").html('<option value="">Select</option><option value="Incorrect information shared">Incorrect information shared</option><option value="Incomplete Information shared">Incomplete Information shared</option><option value="Proactively proposed for cancellation">Proactively proposed for cancellation</option><option value="Cancelled the booking instead of shifting">Cancelled the booking instead of shifting</option><option value="Cancelled CID booking without PM validation">Cancelled CID booking without PM validation</option><option value="Incorrect Modification done">Incorrect Modification done</option><option value="Incomplete Modification done">Incomplete Modification done</option><option value="Modification/cancellation done without customer consent">Modification/cancellation done without customer consent</option><option value="TAT not informed">TAT not informed</option><option value="Incorrect TAT informed">Incorrect TAT informed</option><option value="No Resolution given">No Resolution given</option><option value="Incorrect Process followed">Incorrect Process followed</option>');
		}else{
			$("#sig_mohaliremarks14").html('<option value="NA">NA</option>');
		}
	});

	$('#correct_refund_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks15").html('<option value="">Select</option><option value="Did not raise refund in OREO">Did not raise refund in OREO</option><option value="Raised OREO with incorrect tagging">Raised OREO with incorrect tagging</option><option value="Refund/complimentary processed outside the SOP">Refund/complimentary processed outside the SOP</option><option value="Incorrect complimentary added">Incorrect complimentary added</option><option value="Did not add complimentary">Did not add complimentary</option><option value="Did not mark an email to concerned department">Did not mark an email to concerned department</option>');
		}else{
			$("#sig_mohaliremarks15").html('<option value="NA">NA</option>');
		}
	});

	$('#follow_up_with_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks16").html('<option value="">Select</option><option value="Proper follow up with PM/Stock Team not done">Proper follow up with PM/Stock Team not done</option><option value="Did not call">Did not call</option><option value="Did not email">Did not email</option><option value="Appropriate validation not done">Appropriate validation not done</option>');
		}else{
			$("#sig_mohaliremarks16").html('<option value="NA">NA</option>');
		}
	});

	$('#closure_procedure_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks17").html('<option value="">Select</option><option value="Time breach in GNC call attempts">Time breach in GNC call attempts</option><option value="GNC procedure not followed">GNC procedure not followed</option><option value="Did not send GNC email/sms after call">Did not send GNC email/sms after call</option>');
		}else{
			$("#sig_mohaliremarks17").html('<option value="NA">NA</option>');
		}
	});


	$('#back_as_promised_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks18").html('<option value="">Select</option><option value="No Call Back done">No Call Back done</option><option value="Call back done after TAT Expiry">Call back done after TAT Expiry</option><option value="Call back not scheduled in OD">Call back not scheduled in OD</option>');
		}else{
			$("#sig_mohaliremarks18").html('<option value="NA">NA</option>');
		}
	});

	$('#send_correct_resolution_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks19").html('<option value="">Select</option><option value="Did not send resolution Email">Did not send resolution Email</option><option value="Incorrect/incomplete Resolution Email">Incorrect/incomplete Resolution Email</option><option value="Grammatically incorrect resolution email">Grammatically incorrect resolution email</option><option value="Resolution email sent without providing resolution">Resolution email sent without providing resolution</option><option value="Failed to confirm guest email ID (where applicable)">Failed to confirm guest email ID (where applicable)</option>');
		}else{
			$("#sig_mohaliremarks19").html('<option value="NA">NA</option>');
		}
	});
  $('#complete_and_correct_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks20").html('<option value="">Select</option><option value="Did not capture notes">Did not capture notes</option><option value="Incomplete notes captured">Incomplete notes captured</option><option value="Incorrect notes captured">Incorrect notes captured</option>');
		}else{
			$("#sig_mohaliremarks20").html('<option value="NA">NA</option>');
		}
	});

  $('#accurate_tagging_off_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks21").html('<option value="">Select</option><option value="Incorrect Issue selected">Incorrect Issue selected</option><option value="Incorrect Category selected">Incorrect Category selected</option><option value="Incorrect sub sub category selected">Incorrect sub sub category selected</option><option value="Did not work on existing ticket ">Did not work on existing ticket </option>');
		}else{
			$("#sig_mohaliremarks21").html('<option value="NA">NA</option>');
		}
	});

  $('#disposed_accurately_mohali').on('change', function(){
	    if($(this).val()=='No'){
			$("#sig_mohaliremarks22").html('<option value="">Select</option><option value="Tagging not done on Czentrix">Tagging not done on Czentrix</option><option value="Incorrect tagging done on Czentrix">Incorrect tagging done on Czentrix</option><option value="Did not close the call within 20 sec">Did not close the call within 20 sec</option>');
		}else{
			$("#sig_mohaliremarks22").html('<option value="NA">NA</option>');
		}
	});

  $('#ticket_status_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks23").html('<option value="">Select</option><option value="Did not select the correct Ticket Type">Did not select the correct Ticket Type</option><option value="Did not mention PNR number in case of OTA">Did not mention PNR number in case of OTA</option><option value="Incorrect Ticket status selected except resolved">Incorrect Ticket status selected except resolved</option><option value="Did not select OTA Desk in OTA Group ticket">Did not select OTA Desk in OTA Group ticket</option><option value="Did not capture the booking ID in Resource column">Did not capture the booking ID in Resource column</option><option value="Advisor did not mark case as “STUCK”">Advisor did not mark case as “STUCK”</option><option value="Speling error of “STUCK” was observed">Speling error of “STUCK” was observed</option><option value="Incorrectly updated PM/ Stock connectivity status">Incorrectly updated PM/ Stock connectivity status</option>');
		}else{
			$("#sig_mohaliremarks23").html('<option value="NA">NA</option>');
		}
	});

  $('#pitched_need_help_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks24").html('<option value="">Select</option><option value="Need Help(Yo) not Pitched">Need Help(Yo) not Pitched</option><option value="Not effectively Pitched">Not effectively Pitched</option>');
		}else{
			$("#sig_mohaliremarks24").html('<option value="NA">NA</option>');
		}
	});

  $('#further_assistance_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks25").html('<option value="">Select</option><option value="Did not ask the customer for further assistance">Did not ask the customer for further assistance</option><option value="Did not wait for customer response/acknowledgement">Did not wait for customer response/acknowledgement</option><option value="No pause after FA statement (2 seconds)">No pause after FA statement (2 seconds)</option>');
		}else{
			$("#sig_mohaliremarks25").html('<option value="NA">NA</option>');
		}
	});
 $('#survey_effectively_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks26").html('<option value="">Select</option><option value="G-Sat Survey not pitched effectively">G-Sat Survey not pitched effectively</option><option value="G-Sat  Survey not pitched">G-Sat  Survey not pitched</option><option value="G-Sat Solicitation done">G-Sat Solicitation done</option><option value="G-sat unnecessarily pitched when not required on the call">G-sat unnecessarily pitched when not required on the call</option>');
		}else{
			$("#sig_mohaliremarks26").html('<option value="NA">NA</option>');
		}
	});

  $('#survey_avoidance_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks27").html('<option value="">Select</option><option value="Agent changed ticket status to Closed instead of Resolved">Agent changed ticket status to Closed instead of Resolved</option>');
		}else{
			$("#sig_mohaliremarks27").html('<option value="NA">NA</option>');
		}
	});

   $('#closing_done_with_mohali').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_mohaliremarks28").html('<option value="">Select</option><option value="Agent failed to thank the caller">Agent failed to thank the caller</option><option value="Oyo Branding missing">Oyo Branding missing</option><option value="Brand name was not clear">Brand name was not clear</option>');
		}else{
			$("#sig_mohaliremarks28").html('<option value="NA">NA</option>');
		}
	});

   $('#back_ground_noise_mohali').on('change', function(){
		if($(this).val()=='Yes'){
			$("#sig_mohaliremarks29").html('<option value="">Select</option><option value="Back ground noise observed on call">Back ground noise observed on call</option>');
		}else{
			$("#sig_mohaliremarks29").html('<option value="NA">NA</option>');
		}
	});

   $('#zero_tolerance_mohali').on('change', function(){
		if($(this).val()=='Yes'){
			$("#sig_mohaliremarks30").html('<option value="">Select</option><option value="Transaction was handled ethically - Call was not disconnected">Transaction was handled ethically - Call was not disconnected</option><option value="Agent maintained profanity on the call">Agent maintained profanity on the call</option><option value="Agent did not sounded sarcastic /degraded customer">Agent did not sounded sarcastic /degraded customer</option>');
		}else{
			$("#sig_mohaliremarks30").html('<option value="NA">NA</option>');
		}
	});

   $('#warning_letter_mohali').on('change', function(){
		if($(this).val()=='Yes'){
			$("#sig_mohaliremarks31").html('<option value="">Select</option><option value="Agent did not make False commitment to guest >> financial loss >>3000 INR">Agent did not make False commitment to guest >> financial loss >>3000 INR</option><option value="Agent did not Force Close ticket (No work done and case closed directly)">Agent did not Force Close ticket (No work done and case closed directly)</option><option value="Agent raised escalation ticket on IB call">Agent raised escalation ticket on IB call</option><option value="Agent raised duplicate tickets for the same category less than 14 days">Agent raised duplicate tickets for the same category less than 14 days</option><option value="Agent adhered to Escalation matrix /Did not refuse next level escalation">Agent adhered to Escalation matrix /Did not refuse next level escalation</option><option value="Agent did not misuse hold protocol">Agent did not misuse hold protocol</option>');
		}else{
			$("#sig_mohaliremarks31").html('<option value="NA">NA</option>');
		}
	});
	
/////////////////////////////// SIG ////////////////////////////////////
	$('#call_opening_5sec').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks1").html('<option value="Did not open the call within 5 secs">Did not open the call within 5 secs</option><option value="Self Introduction missing/clear">Self Introduction missing/clear</option><option value="OYO Branding missing">OYO Branding missing</option><option value="Brand name was not clear">Brand name was not clear</option><option value="Opening greetings missing/Incorrect greetings">Opening greetings missing/Incorrect greetings</option><option value="No Opening">No Opening</option><option value="No Opening given with guest/PM/stock team (handled transferred call)">No Opening given with guest/PM/stock team (handled transferred call)</option>');
		}else{
			$("#sig_remarks1").html('<option value="NA">NA</option>');
		}
	});

	$('#probing_done').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks2").html('<option value="Unnecessary Probing">Unnecessary Probing</option><option value="Incorrect Probing ">Incorrect Probing </option><option value="No probing done when required">No probing done when required</option>');
		}else{
			$("#sig_remarks2").html('<option value="NA">NA</option>');
		}
	});

	$('#issue_identified').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks3").html('<option value="Issue not identified correctly">Issue not identified correctly</option><option value="Issue not paraphrased">Issue not paraphrased</option><option value="Paraphrasing was not done completely">Paraphrasing was not done completely</option>');
		}else{
			$("#sig_remarks3").html('<option value="NA">NA</option>');
		}
	});

	$('#apology_empathy').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks4").html('<option value="Timely apology not done">Timely apology not done</option><option value="Apology/empathy not done">Apology/empathy not done</option><option value="Apology/empathy sounded scripted">Apology/empathy sounded scripted</option>');
		}else{
			$("#sig_remarks4").html('<option value="NA">NA</option>');
		}
	});

	$('#voice_intonation').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks5").html('<option value="High rate of speech">High rate of speech</option><option value="Sounding robotic & Scripted">Sounding robotic & Scripted</option><option value="Voice clarity issues">Voice clarity issues</option>');
		}else{
			$("#sig_remarks5").html('<option value="NA">NA</option>');
		}
	});

	$('#active_listening').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks6").html('<option value="Too many Interruptions > 1 instance">Too many Interruptions > 1 instance</option><option value="Made the customer repeat > 1 instance">Made the customer repeat > 1 instance</option>');
		}else{
			$("#sig_remarks6").html('<option value="NA">NA</option>');
		}
	});

	$('#confidence_and_enthusiasm').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks7").html('<option value="Fumbling on call >5 instances">Fumbling on call >5 instances</option><option value="Lack of Confidence (tone)">Lack of Confidence (tone)</option><option value="Fillers used >5 instances">Fillers used >5 instances</option><option value="Not energetic on call">Not energetic on call</option');
		}else{
			$("#sig_remarks7").html('<option value="NA">NA</option>');
		}
	});

	$('#politeness_professionalism').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks8").html('<option value="Did not use power words">Did not use power words</option><option value="Did not display willingness to help">Did not display willingness to help</option><option value="Sounding casual on call">Sounding casual on call</option><option value="Agent was blunt/ authoritative/aggressive">Agent was blunt/ authoritative/aggressive</option><option value="Agent was Yawning on call">Agent was Yawning on call</option>');
		}else{
			$("#sig_remarks8").html('<option value="NA">NA</option>');
		}
	});

	$('#grammar_sentence').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks9").html('<option value="Incorrect sentence formation/Choice of words">Incorrect sentence formation/Choice of words</option><option value="Incomplete sentence used">Incomplete sentence used</option><option value="Grammatical error on call">Grammatical error on call</option><option value="Language mismatch">Language mismatch</option>');
		}else{
			$("#sig_remarks9").html('<option value="NA">NA</option>');
		}
	});

	$('#acknowledgement_guest').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks10").html('<option value="Did not acknowledge">Did not acknowledge</option><option value="Delayed acknowledgment (>=5 sec)">Delayed acknowledgment (>=5 sec)</option><option value="Assurance not offered">Assurance not offered</option>');
		}else{
			$("#sig_remarks10").html('<option value="NA">NA</option>');
		}
	});

	$('#agent_adhere_hold').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks11").html('<option value="Did not seek permission">Did not seek permission</option><option value="Did not mention hold duration">Did not mention hold duration</option><option value="Did not mention hold reason">Did not mention hold reason</option><option value="Hold procedure was applicable and agent did not use it">Hold procedure was applicable and agent did not use it</option><option value="Did not thank the customer after returning from hold">Did not thank the customer after returning from hold</option><option value="Apology missing for long hold">Apology missing for long hold</option><option value="Did not put customer on hold post hold permission">Did not put customer on hold post hold permission</option><option value="Did not refresh Hold as per the committed time (Few min = 3 min)">Did not refresh Hold as per the committed time (Few min = 3 min)</option>');
		}else{
			$("#sig_remarks11").html('<option value="NA">NA</option>');
		}
	});

	$('#agent_adhere_dead').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks12").html('<option value="Dead Air observed more than 20 seconds">Dead Air observed more than 20 seconds</option>');
		}else{
			$("#sig_remarks12").html('<option value="NA">NA</option>');
		}
	});

	$('#legitimate_hold').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks13").html('<option value="Unnecessary Hold observed less than 5 minutesUnnecessary Hold observed  5 to 10 minutes">Unnecessary Hold observed less than 5 minutesUnnecessary Hold observed  5 to 10 minutes</option><option value="Unnecessary Hold observed  5 to 10 minutes">Unnecessary Hold observed  5 to 10 minutes</option><option value="Unnecessary Hold observed  10 to 15 minutes">Unnecessary Hold observed  10 to 15 minutes</option><option value="Unnecessary Hold observed  greater than 15 minutes">Unnecessary Hold observed  greater than 15 minutes</option>');
		}else{
			$("#sig_remarks13").html('<option value="NA">NA</option>');
		}
	});

	$('#resolution_provided').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks14").html('<option value="Incorrect information shared">Incorrect information shared</option><option value="Incomplete Information shared">Incomplete Information shared</option><option value="Proactively proposed for cancellation">Proactively proposed for cancellation</option><option value="Cancelled the booking instead of shifting">Cancelled the booking instead of shifting</option><option value="Cancelled CID booking without PM validation">Cancelled CID booking without PM validation</option><option value="Incorrect Modification done">Incorrect Modification done</option><option value="Incomplete Modification done">Incomplete Modification done</option><option value="Modification/cancellation done without customer consent">Modification/cancellation done without customer consent</option><option value="TAT not informed">TAT not informed</option><option value="Incorrect TAT informed">Incorrect TAT informed</option><option value="No Resolution given">No Resolution given</option><option value="Incorrect Process followed">Incorrect Process followed</option>');
		}else{
			$("#sig_remarks14").html('<option value="NA">NA</option>');
		}
	});

	$('#correct_refund').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks15").html('<option value="Did not raise refund in OREO">Did not raise refund in OREO</option><option value="Raised OREO with incorrect tagging">Raised OREO with incorrect tagging</option><option value="Refund/complimentary processed outside the SOP">Refund/complimentary processed outside the SOP</option><option value="Incorrect complimentary added">Incorrect complimentary added</option><option value="Did not add complimentary">Did not add complimentary</option><option value="Did not mark an email to concerned department">Did not mark an email to concerned department</option>');
		}else{
			$("#sig_remarks15").html('<option value="NA">NA</option>');
		}
	});

	$('#follow_up_with').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks16").html('<option value="Proper follow up with PM/Stock Team not done">Proper follow up with PM/Stock Team not done</option><option value="Did not call">Did not call</option><option value="Did not email">Did not email</option><option value="Appropriate validation not done">Appropriate validation not done</option>');
		}else{
			$("#sig_remarks16").html('<option value="NA">NA</option>');
		}
	});

	$('#closure_procedure').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks17").html('<option value="Time breach in GNC call attempts">Time breach in GNC call attempts</option><option value="GNC procedure not followed">GNC procedure not followed</option><option value="Did not send GNC email/sms after call">Did not send GNC email/sms after call</option>');
		}else{
			$("#sig_remarks17").html('<option value="NA">NA</option>');
		}
	});


	$('#back_as_promised').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks18").html('<option value="No Call Back done">No Call Back done</option><option value="Call back done after TAT Expiry">Call back done after TAT Expiry</option><option value="Call back not scheduled in OD">Call back not scheduled in OD</option>');
		}else{
			$("#sig_remarks18").html('<option value="NA">NA</option>');
		}
	});

	$('#send_correct_resolution').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks19").html('<option value="Did not send resolution Email">Did not send resolution Email</option><option value="Incorrect/incomplete Resolution Email">Incorrect/incomplete Resolution Email</option><option value="Grammatically incorrect resolution email">Grammatically incorrect resolution email</option><option value="Resolution email sent without providing resolution">Resolution email sent without providing resolution</option><option value="Failed to confirm guest email ID (where applicable)">Failed to confirm guest email ID (where applicable)</option>');
		}else{
			$("#sig_remarks19").html('<option value="NA">NA</option>');
		}
	});
  $('#complete_and_correct').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks20").html('<option value="Did not capture notes">Did not capture notes</option><option value="Incomplete notes captured">Incomplete notes captured</option><option value="Incorrect notes captured">Incorrect notes captured</option>');
		}else{
			$("#sig_remarks20").html('<option value="NA">NA</option>');
		}
	});

  $('#accurate_tagging_off').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks21").html('<option value="Incorrect Issue selected">Incorrect Issue selected</option><option value="Incorrect Category selected">Incorrect Category selected</option><option value="Incorrect sub sub category selected">Incorrect sub sub category selected</option><option value="Did not work on existing ticket ">Did not work on existing ticket </option>');
		}else{
			$("#sig_remarks21").html('<option value="NA">NA</option>');
		}
	});

  $('#disposed_accurately').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks22").html('<option value="Tagging not done on Czentrix">Tagging not done on Czentrix</option><option value="Incorrect tagging done on Czentrix">Incorrect tagging done on Czentrix</option><option value="Did not close the call within 20 sec">Did not close the call within 20 sec</option>');
		}else{
			$("#sig_remarks22").html('<option value="NA">NA</option>');
		}
	});

  $('#ticket_status').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks23").html('<option value="Did not select the correct Ticket Type">Did not select the correct Ticket Type</option><option value="Did not mention PNR number in case of OTA">Did not mention PNR number in case of OTA</option><option value="Incorrect Ticket status selected except resolved">Incorrect Ticket status selected except resolved</option><option value="Did not select OTA Desk in OTA Group ticket">Did not select OTA Desk in OTA Group ticket</option><option value="Did not capture the booking ID in Resource column">Did not capture the booking ID in Resource column</option><option value="Advisor did not mark case as “STUCK”">Advisor did not mark case as “STUCK”</option><option value="Speling error of “STUCK” was observed">Speling error of “STUCK” was observed</option><option value="Incorrectly updated PM/ Stock connectivity status">Incorrectly updated PM/ Stock connectivity status</option>');
		}else{
			$("#sig_remarks23").html('<option value="NA">NA</option>');
		}
	});

  $('#pitched_need_help').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks24").html('<option value="Need Help(Yo) not Pitched">Need Help(Yo) not Pitched</option><option value="Not effectively Pitched">Not effectively Pitched</option>');
		}else{
			$("#sig_remarks24").html('<option value="NA">NA</option>');
		}
	});

  $('#further_assistance').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks25").html('<option value="Did not ask the customer for further assistance">Did not ask the customer for further assistance</option><option value="Did not wait for customer response/acknowledgement">Did not wait for customer response/acknowledgement</option><option value="No pause after FA statement (2 seconds)">No pause after FA statement (2 seconds)</option>');
		}else{
			$("#sig_remarks25").html('<option value="NA">NA</option>');
		}
	});
  $('#survey_effectively').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks26").html('<option value="G-Sat Survey not pitched effectively">G-Sat Survey not pitched effectively</option><option value="G-Sat  Survey not pitched">G-Sat  Survey not pitched</option><option value="G-Sat Solicitation done">G-Sat Solicitation done</option><option value="G-sat unnecessarily pitched when not required on the call">G-sat unnecessarily pitched when not required on the call</option>');
		}else{
			$("#sig_remarks26").html('<option value="NA">NA</option>');
		}
	});

  $('#survey_avoidance').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks27").html('<option value="Agent changed ticket status to Closed instead of Resolved">Agent changed ticket status to Closed instead of Resolved</option>');
		}else{
			$("#sig_remarks27").html('<option value="NA">NA</option>');
		}
	});

   $('#closing_done_with').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks28").html('<option value="Agent failed to thank the caller">Agent failed to thank the caller</option><option value="Oyo Branding missing">Oyo Branding missing</option><option value="Brand name was not clear">Brand name was not clear</option>');
		}else{
			$("#sig_remarks28").html('<option value="NA">NA</option>');
		}
	});

   $('#back_ground_noise').on('change', function(){
		if($(this).val()=='No'){
			$("#sig_remarks29").html('<option value="Back ground noise observed on call">Back ground noise observed on call</option>');
		}else{
			$("#sig_remarks29").html('<option value="NA">NA</option>');
		}
	});

///////////////////////// UK US ////////////////////////
	$(document).on('change','.ukus_point',function(){
		ukus_calculation();
	});
	ukus_calculation();

///////////////////////// SIG ////////////////////////	
	$(document).on('change','.sig_point',function(){
		sig_calc();
	});
	sig_calc();

	$(document).on('change','.sig_mohali_point',function(){
		sig_mohali_calc();
	});
	sig_mohali_calc();
	
});

//////////////////////////////////////

	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
</script>
