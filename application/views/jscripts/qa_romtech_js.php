<script type="text/javascript">
$(document).ready(function(){


$(document).on('change','.romtech',function(){ romtech_score(); });
$(document).on('change','.Initial',function(){ romtech_score(); });
$(document).on('change','.Sales',function(){ romtech_score(); });
$(document).on('change','.Skill',function(){ romtech_score(); });
$(document).on('change','.handling',function(){ romtech_score(); });
$(document).on('change','.compliance',function(){ romtech_score(); });
$(document).on('change','.business',function(){ romtech_score(); });
$(document).on('change','.customer',function(){ romtech_score(); });

romtech_score();
///////////////// Date Time Picker ///////////////////////

	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
	$("#call_date_time").datetimepicker({maxDate: new Date()});
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });


///////////////// Calibration - Auditor Type ///////////////////////

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

///////////////// Form Submit ///////////////////////
	$("#form_audit_user").submit(function (e) {

		$('#qaformsubmit').prop('disabled',true);

		//e.preventDefault();
		//$('.successMessage').show();
       // alert("Form submitted");
	});

	$("#form_agent_user").submit(function(e){
		//alert(12);
		$('.waves-effect').prop('disabled',true);
		//$('#agentstatusMessage').show();
	});

	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});

///////////////// Agent and TL names ///////////////////////
	// $( "#agent_id" ).on('change' , function() {
	// 	var aid = this.value;
	// 	//alert(aid);
	// 	if(aid=="") alert("Please Select Agent")
	// 	var URL='<?php echo base_url();?>qa_ameridial/getTLname';
	// 	$('#sktPleaseWait').modal('show');
	// 	$.ajax({
	// 		type: 'POST',
	// 		url:URL,
	// 		data:'aid='+aid,
	// 		success: function(aList){
	// 			var json_obj = $.parseJSON(aList);
	// 			$('#tl_name').empty();
	// 			$('#tl_name').append($('#tl_name').val(''));
	// 			for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
	// 			for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
	// 			for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
	// 			for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
	// 			for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
	// 			$('#sktPleaseWait').modal('hide');
	// 		},
	// 		error: function(){
	// 			alert('Fail!');
	// 		}
	// 	});
	// });


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
	// function checkDec(el){
	// 	alert(2);
	// 	var ex = /^[0-9]+\.?[0-9]*$/;
	// 	if(ex.test(el.value)==false){
	// 		el.value = el.value.substring(0,el.value.length - 1);
	// 	}
	// }



	function phone_noFunction(phone_no){
	var phone_no=$("#phone_no").val();
	//alert(2);
	
	var pattern =/^[0-9]+\.?[0-9]*$/;    

	if(!pattern.test(phone_no)){
		
		$("#msg-phone_no").html("<font color=red style='font-size:14px;'>This Phone No  is not valid </font>");
		 $(".waves-effect").attr("disabled",true);
		 $(".waves-effect").css('cursor', 'no-drop');
		
	} 
	else if((phone_no.length <10) || (phone_no.length >12)){
		$("#msg-phone_no").html("<font color=red style='font-size:14px;'>Please enter at least 10-12 characters inside the Text Box</font>");
		 $(".waves-effect").attr("disabled",true);
		 $(".waves-effect").css('cursor', 'no-drop');
		 
	} else{
		$("#msg-phone_no").html("");
		$(".waves-effect").attr("disabled",false);
		$(".waves-effect").css('cursor', 'pointer');
		
	}
  }




  function phone_no_keyup(phone_no) {
	$("#msg-phone_no").html("");
	
}




$(function () {
   $('#call_id').keydown(function (e) {
        if (e.shiftKey || e.ctrlKey || e.altKey) {
           e.preventDefault();
        } 
        else {
            var key = e.keyCode;
            if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
               e.preventDefault();
            }
        }
    });
});




	$('#form_submits').each(function(){
		$valdet=$(this).val();
		if($valdet=="Yes"){
			$('.auType_epis').show();
		}else{
			$('.auType_epis').hide();
		}
	});

	$('#form_submits').on('change', function(){
		if($(this).val()=='Yes'){
			$('.auType_epis').show();
			$('#extra').attr('required',true);
			$('#extra').prop('disabled',false);
		}else{
			//alert(222);
			$('.auType_epis').hide();
			$('#extra').attr('required',false);
			$('#extra').prop('disabled',true);
		}
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
 function qa_romtech_inbound_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0.00;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.romtech_inbound_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Meets'){
				pass_count = pass_count + 1;
				var w1 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				score = score + w1;
				scoreable = scoreable + w2;

			}else if(score_type == 'Needs Improvement'){
				pass_count = pass_count + 1;
				var w1 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}
			else if(score_type == 'Failed'){
				fail_count = fail_count + 1;
				var w1 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				//score = score + w1;
				scoreable = scoreable + w2;
				//scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		if(quality_score_percent == "NaN"){
			quality_score_percent = (0.00).toFixed(2);
		}else{
			quality_score_percent = quality_score_percent;
		}
		
		$('#romtech_inbound_earned_score').val(score);
		$('#romtech_inbound_possible_score').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#romtech_inbound_overall_score').val(quality_score_percent+'%');
		}

		if($('#romtech_inbound_Fatal1').val()=='Failed' || $('#romtech_inbound_Fatal2').val()=='Failed' || $('#romtech_inbound_Fatal3').val()=='Failed' || $('#romtech_inbound_Fatal4').val()=='Failed'){
			quality_score_percent = (0.00).toFixed(2);
			$('.romtech_inboundFatal').val(quality_score_percent+'%');
			//$('.phs_chatemail_v2Fatal').val(0.00).toFixed(2);
		}else{
			$('.romtech_inbound_overall_score').val(quality_score_percent+'%');
		}
	
		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Meets'){
				var w1 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Failed'){
				var w1 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Needs Improvement'){
				var w1 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				var w11 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w11;
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
			if(sc2 == 'Meets'){
				var w2 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Failed'){
				var w2 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Needs Improvement'){
				var w2 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				var w22 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w22;
			}
		});
		$('#business_earned_score').val(businessScore);
		$('#business_possible_score').val(businessScoreable);
		console.log(businessScore);
		console.log(businessScoreable);
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
			if(sc3 == 'Meets'){
				var w3 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
			else if(sc3 == 'Failed'){
				var w3 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Needs Improvement'){
				var w3 = parseFloat($(element).children("option:selected").attr('romtech_inbound_val'));
				var w33 = parseFloat($(element).children("option:selected").attr('romtech_inbound_max'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w33;
			}
		});
		$('#compliance_earned_score').val(complianceScore);
		$('#compliance_possible_score').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#compliance_overall_score').val(compliancePercentage+'%');
		}
	}
	
	$(document).on('change','.romtech_inbound_point',function(){
		qa_romtech_inbound_calc();
	});
	qa_romtech_inbound_calc();
</script>

<script>
function romtech_score(){

var score = 0;
var scoreable = 0;
var overall_score=0;
$('.romtech').each(function(index,element){
	var score_type = $(element).val();
	if(score_type == 'Yes'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'No'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'N/A'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'Pass'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'Fail'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'Needs Improvement'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == '3'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == '2'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == '1'){
		var w1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
});

var totScore = ((score*100)/scoreable).toFixed(2);

$('#earned_score').val(score);
$('#possible_score').val(scoreable);

if($('#form_submits').val()=='Yes' || $('#prompt').val()=='Fail'){
	$("#overall_score").val(0+'%');
}else{
	if(!isNaN(totScore)){
		$('#overall_score').val(totScore+'%');
	}
}

/////////////Romtech Intro Fatal////////////////
	if($('#romtechIntroAF1').val()=='Fail' || $('#romtechIntroAF2').val()=='Fail' || $('#romtechIntroAF3').val()=='Fail' || $('#romtechIntroAF4').val()=='Fail' || $('#romtechIntroAF5').val()=='Fail'){
		$(".romtechIntroFatal").val(0+'%');
	}else{
		$('.romtechIntroFatal').val(totScore+'%');
	}


///////////////////////// Customer-Business-Compliance /////////////////////////////////
	var compliance_score = 0;
	var compliance_scoreable = 0;
	var compliance_score_percent = 0;
	$('.compliance').each(function(index,element){
		var compw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var compw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		compliance_score = compliance_score + compw1;
		compliance_scoreable = compliance_scoreable + compw2;
	});
	compliance_score_percent = ((compliance_score*100)/compliance_scoreable).toFixed(2);
	$('#compscrRomtIntr').val(compliance_score);
	$('#compscrablRomtIntr').val(compliance_scoreable);
	if(!isNaN(compliance_score_percent)){
		$('#compRomtIntr').val(compliance_score_percent+'%');
	}
	
	var business_score = 0;
	var business_scoreable = 0;
	var business_score_percent = 0;
	$('.business').each(function(index,element){
		var busiw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var busiw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		business_score = business_score + busiw1;
		business_scoreable = business_scoreable + busiw2;
	});
	business_score_percent = ((business_score*100)/business_scoreable).toFixed(2);
	$('#busiscrRomtIntr').val(business_score);
	$('#busiscrablRomtIntr').val(business_scoreable);
	if(!isNaN(business_score_percent)){
		$('#busiRomtIntr').val(business_score_percent+'%');
	}
	
	var customer_score = 0;
	var customer_scoreable = 0;
	var customer_score_percent = 0;
	$('.customer').each(function(index,element){
		var custw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var custw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		customer_score = customer_score + custw1;
		customer_scoreable = customer_scoreable + custw2;
	});
	customer_score_percent = ((customer_score*100)/customer_scoreable).toFixed(2);
	$('#custscrRomtIntr').val(customer_score);
	$('#custscrablRomtIntr').val(customer_scoreable);
	if(!isNaN(customer_score_percent)){
		$('#custRomtIntr').val(customer_score_percent+'%');
	}



//////////////// Initial/Sales/Skill //////////////////
var InitialScore = 0;
var InitialScoreable = 0;
var InitialPercentage = 0;

$('.Initial').each(function(index,element){
	var sc1 = $(element).val();


	if(sc1 == 'Yes'){
		var cw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		InitialScore = InitialScore + cw1;
		InitialScoreable = InitialScoreable + cw2;
	}else if(sc1 == 'No'){
		var cw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		InitialScore = InitialScore + cw1;
		InitialScoreable = InitialScoreable + cw2;
	}else if(sc1 == 'N/A'){
		var cw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		InitialScore = InitialScore + cw1;
		InitialScoreable = InitialScoreable + cw2;
	}
});

$('#InitialAcmEarned').val(InitialScore);
$('#InitialAcmPossible').val(InitialScoreable);
InitialPercentage = ((InitialScore*100)/InitialScoreable).toFixed(2);
if(!isNaN(InitialPercentage)){
	$('#InitialAcmScore').val(InitialPercentage+'%');
}

////////////////////////////////////////////////////////////////
var SalesScore = 0;
var SalesScoreable = 0;
var SalesPercentage = 0;
$('.Sales').each(function(index,element){

	var sc2 = $(element).val();
	//alert(sc2);
	if(sc2 == 'Yes'){
		var bw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		SalesScore = SalesScore + bw1;
		SalesScoreable = SalesScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		SalesScore = SalesScore + bw1;
		SalesScoreable = SalesScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		SalesScore = SalesScore + bw1;
		SalesScoreable = SalesScoreable + bw2;
	}
});

$('#SalesAcmEarned').val(SalesScore);
$('#SalesAcmPossible').val(SalesScoreable);
SalesPercentage = ((SalesScore*100)/SalesScoreable).toFixed(2);
if(!isNaN(SalesPercentage)){
	$('#SalesAcmScore').val(SalesPercentage+'%');
}
////////////
var SkillScore = 0;
var SkillScoreable = 0;
var SkillPercentage = 0;
$('.Skill').each(function(index,element){
	var sc3 = $(element).val();
	//alert(sc3);
	if(sc3 == 'Yes'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		SkillScore = SkillScore + cpw1;
		SkillScoreable = SkillScoreable + cpw2;
	}else if(sc3 == 'No'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		SkillScore = SkillScore + cpw1;
		SkillScoreable = SkillScoreable + cpw2;
	}else if(sc3 == 'N/A'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		SkillScore = SkillScore + cpw1;
		SkillScoreable = SkillScoreable + cpw2;
	}
});

$('#SkillAcmEarned').val(SkillScore);
$('#SkillAcmPossible').val(SkillScoreable);
SkillPercentage = ((SkillScore*100)/SkillScoreable).toFixed(2);
if(!isNaN(SkillPercentage)){
	$('#SkillAcmScore').val(SkillPercentage+'%');
}

}
//////////////////////////////////
var handlingScore = 0;
var handlingScoreable = 0;
var handlingPercentage = 0;
$('.handling').each(function(index,element){

	var sc2 = $(element).val();
	//alert(sc2);
	if(sc2 == 'Yes'){
		var bw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		handlingScore = handlingScore + bw1;
		handlingScoreable = handlingScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		handlingScore = handlingScore + bw1;
		handlingScoreable = handlingScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('romtech_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('romtech_max'));
		handlingScore = handlingScore + bw1;
		handlingScoreable = handlingScoreable + bw2;
	}
});

$('#handlingAcmEarned').val(handlingScore);
$('#handlingAcmPossible').val(handlingScoreable);
handlingPercentage = ((handlingScore*100)/handlingScoreable).toFixed(2);
if(!isNaN(handlingPercentage)){
	$('#handlingAcmScore').val(handlingPercentage+'%');
}
//////////

</script>

<script>
	// function date_validation(val,type){ 
	// // alert(val);
	// 	$(".end_date_error").html("");
	// 	$(".start_date_error").html("");
	// 	if(type=='E'){
	// 	var start_date=$("#from_date").val();
	// 	//if(val<start_date)
	// 	if(Date.parse(val) < Date.parse(start_date))
	// 	{
	// 		$(".end_date_error").html("To Date must be greater or equal to From Date");
	// 		 $(".romtech-effect").attr("disabled",true);
	// 		 $(".romtech-effect").css('cursor', 'no-drop');
	// 	}
	// 	else{
	// 		 $(".romtech-effect").attr("disabled",false);
	// 		 $(".romtech-effect").css('cursor', 'pointer');
	// 		}
	// 	}
	// 	else{
	// 		var end_date=$("#to_date").val();
	// 	//if(val>end_date && end_date!='')
		
	// 	if(Date.parse(val) > Date.parse(end_date) && end_date!='')
	// 	{
	// 		$(".start_date_error").html("From  Date  must be less or equal to  To Date");
	// 		 $(".romtech-effect").attr("disabled",true);
	// 		 $(".romtech-effect").css('cursor', 'no-drop');
	// 	}
	// 	else{
	// 		 $(".romtech-effect").attr("disabled",false);
	// 		 $(".romtech-effect").css('cursor', 'pointer');
	// 		}

	// 	}
		
		
	// }
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