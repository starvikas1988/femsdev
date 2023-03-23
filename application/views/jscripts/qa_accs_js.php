<script type="text/javascript">
$(document).ready(function(){


$(document).on('change','.accs',function(){ accs_score(); });
$(document).on('change','.Initial',function(){ accs_score(); });
$(document).on('change','.Sales',function(){ accs_score(); });
$(document).on('change','.Skill',function(){ accs_score(); });
$(document).on('change','.handling',function(){ accs_score(); });

accs_score();
///////////////// Date Time Picker ///////////////////////
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_date_time").datepicker();

	$("#call_duration").timepicker();
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
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj){
					if($('#tl_name').val(json_obj[i].tl_name)!=''){
						$('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));

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
			 $(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
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
	// 	var ex = /^[0-9]+\.?[0-9]*$/;
	// 	if(ex.test(el.value)==false){
	// 		el.value = el.value.substring(0,el.value.length - 1);
	// 	}
	// }

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
	function acg_calc(){
		var check_fatal=false;
			$(".acg_point").each(function(){
				if($(this).hasClass("acg_fatal") && ($(this).val()=="Fail") ){
					check_fatal=true;
					$("#acg_overall_score").val("0.00%");
				}
			});
			if(!check_fatal){
				//var earned_score = 0, possible_score=0, overall_score="";
				var earned_score = 0, possible_score=0, overall_score="", cust_earned=0, cust_possible=0, cust_overall=0;
			    var comp_earned=0, comp_possible=0, comp_overall=0, business_earned=0, business_possible=0, business_overall=0;
				$(".acg_point").each(function(index, element){
					if($(element).val()!="N/A" && $(element).val()!=""){
						var earned_weightage = parseFloat($(element).children("option:selected").attr('acg_val'));
						earned_score += earned_weightage;
						var weightage = parseFloat($(element).children("[value='Pass']").attr('acg_val'));
						possible_score += weightage;
						overall_score=parseFloat((earned_score/possible_score)*100);
						
						if($(this).hasClass("customer")){
							cust_earned+=earned_weightage;
							cust_possible+=weightage;
							console.log(cust_earned);
							$("#customer_earned_score").val(cust_earned);
							$("#customer_possible_score").val(cust_possible);
							$("#customer_overall_score").val(parseFloat((cust_earned/cust_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("compliance")){
							comp_earned+=earned_weightage;
							comp_possible+=weightage;
							console.log(comp_earned);
							$("#compliance_earned_score").val(comp_earned);
							$("#compliance_possible_score").val(comp_possible);
							$("#compliance_overall_score").val(parseFloat((comp_earned/comp_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("business")){
							business_earned+=earned_weightage;
							business_possible+=weightage;
							console.log(business_earned);
							$("#business_earned_score").val(business_earned);
							$("#business_possible_score").val(business_possible);
							$("#business_overall_score").val(parseFloat((business_earned/business_possible)*100).toFixed(2)+"%");
						}

						$("#acg_overall_score").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
						
					}
				});
			}
			if(!isNaN(earned_score)){
				$("#acg_earned_score").val(earned_score);
			}
			if(!isNaN(possible_score)){
				$("#acg_possible_score").val(possible_score);
			}
	}

	$(document).on("change", ".acg_point", function(){
			acg_calc();
	});
	acg_calc();
</script>




<script>
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
</script>

<script>
		function accs_score(){

var score = 0;
var scoreable = 0;
var overall_score=0;
$('.accs').each(function(index,element){
	var score_type = $(element).val();
	if(score_type == 'Yes'){
		var w1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'No'){
		var w1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'N/A'){
		var w1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	else if(score_type == 'Pass'){
		var w1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	else if(score_type == 'Fail'){
		var w1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
});

totScore = ((score*100)/scoreable).toFixed(2);


	$('#earned_score').val(score);
		$('#possible_score').val(scoreable);

		//alert(totScore);

		if($('#form_submits').val()=='Yes' || $('#prompt').val()=='Fail'){
	        $("#overall_score").val(0);
	 }else{
		if(!isNaN(totScore)){
		$('#overall_score').val(totScore);
	  }
	  }


//////////////// Initial/Sales/Skill //////////////////
var InitialScore = 0;
var InitialScoreable = 0;
var InitialPercentage = 0;
//alert(12345678);

$('.Initial').each(function(index,element){
	var sc1 = $(element).val();


	if(sc1 == 'Yes'){
		var cw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		InitialScore = InitialScore + cw1;
		InitialScoreable = InitialScoreable + cw2;
	}else if(sc1 == 'No'){
		var cw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		InitialScore = InitialScore + cw1;
		InitialScoreable = InitialScoreable + cw2;
	}else if(sc1 == 'N/A'){
		var cw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
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
////////////
var SalesScore = 0;
var SalesScoreable = 0;
var SalesPercentage = 0;
$('.Sales').each(function(index,element){

	var sc2 = $(element).val();
	//alert(sc2);
	if(sc2 == 'Yes'){
		var bw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		SalesScore = SalesScore + bw1;
		SalesScoreable = SalesScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		SalesScore = SalesScore + bw1;
		SalesScoreable = SalesScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
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
		var cpw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		SkillScore = SkillScore + cpw1;
		SkillScoreable = SkillScoreable + cpw2;
	}else if(sc3 == 'No'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		SkillScore = SkillScore + cpw1;
		SkillScoreable = SkillScoreable + cpw2;
	}else if(sc3 == 'N/A'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
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
		var bw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		handlingScore = handlingScore + bw1;
		handlingScoreable = handlingScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
		handlingScore = handlingScore + bw1;
		handlingScoreable = handlingScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('accs_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('accs_max'));
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
