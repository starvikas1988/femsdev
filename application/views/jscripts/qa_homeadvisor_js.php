<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#sale_date").datepicker({maxDate: new Date() });
	$("#call_date").datepicker({maxDate: new Date() });
	$("#shift_date").datepicker({maxDate: new Date() });
	$("#new_sr_date").datepicker({maxDate: new Date() });
	$("#sale_date").datepicker({maxDate: new Date() });
	$('#call_duration').timepicker({timeFormat: 'HH:mm:ss', now:false});
	$('#call_time').timepicker({timeFormat: 'HH:mm:ss'});
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });
	
	
///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	
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
	
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_homeadvisor/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_id').empty();
				$('#tl_id').append($('#tl_id').val(''));	
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
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
	
	
	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
///////////////////////////
	
///////////////// Home Advisor //////////////////
	$('#product_communicate').on('change', function(){
		overall_score();
	});
	$('#product_explain').on('change', function(){
		overall_score();
	});
	$('#product_money').on('change', function(){
		overall_score();
	});
	$('#product_lead').on('change', function(){
		overall_score();
	});
	$('#product_background').on('change', function(){
		overall_score();
	});
	$('#product_look').on('change', function(){
		overall_score();
	});
	$('#product_rating').on('change', function(){
		overall_score();
	});
	$('#product_email').on('change', function(){
		overall_score();
	});
	$('#product_reinforce').on('change', function(){
		overall_score();
	});
	$('#product_tool').on('change', function(){
		overall_score();
	});
	$('#product_download').on('change', function(){
		overall_score();
	});
	
	$(document).on('change','.auto_pass_fail',function(){
		var afail = this.value;
		if(afail=="Pass"){
			$("#call_pass_fail").val('Pass');
			$("#call_pass_fail").css("color", "green");
		}else{
			$("#call_pass_fail").val('Fail');
			$("#call_pass_fail").css("color", "red");
		}
		overall_score();
	});
	
	
////////////// HCCO ///////////////////	
	$(document).on('change','.hcco_point',function(){
		hcco_calc();
	});
	$(document).on('change','.stella_survey',function(){
		hcco_calc();
	});
	// $(document).on('change','.compliance',function(){
	// 	hcco_calc();
	// });
	// $(document).on('change','.customer',function(){
	// 	hcco_calc();
	// });
	// $(document).on('change','.business',function(){
	// 	hcco_calc();
	// });
	hcco_calc();
	
	
	$(document).on('change','.flex_point',function(){
		hcco_flex();
	});
	hcco_flex();

});
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
				$("#msg-phone_no").html("<font color=red style='font-size:14px;'>Please enter the correct  10-12 Digit format</font>");
			
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

<script>
 $('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
		case 'mp3':
		case 'mp4':
		case 'wav':
		case 'm4a':
        /* case 'avi':
		case 'mp4':
		case '3gp':
		case 'mpeg':
		case 'mpg':
		case 'mov':
        case 'flv':
        case 'wmv':
		case 'mkv': */
            $('#qaformsubmit').attr('disabled', false);
            break;
		default:
        alert('This is not an allowed file type.');
		//$('#qaformsubmit').attr('disabled', true);
        this.value = '';
    }
}); 
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
			// if(el.value.length >10){
   //     			alert("required 10 digits, match requested format!");
   //     			return false;
		 //    }
			//console.log(el.value);
		}
</script> 

<script>
	/*  $(function () {
		$('input[type=file]').change(function () {
			var val = $(this).val().toLowerCase(),
				regex = new RegExp("(.*?)\.(mp3|avi|mp4|wmv|wav)$");

			if (!(regex.test(val))) {
				$(this).val('');
				alert('This is not an allowed file type. Please upload correct file format');
				return false;
			}
		});
	}); */

   $('#btnViewAgent').click(function(){

    if($.trim($('#from_date').val()) == ''){
      alert('From Date can not be left blank');
      $('#tl_id').focus();
      return false;
   }
   	
   if($.trim($('#to_date').val()) == ''){
      alert('To Date can not be left blank');
      $('#tl_id').focus();
      return false;
   }

});

// $(document).ready(function(){
//     $("#qaformsubmit").on('submit',function(e){
//     	e.preventDefault();
//         if($.trim($('#tl_id').val()) == ''){
//       alert('L1 Supervisor can not be left blank');
//       $('#tl_id').focus();
//       return false;
//    }

//     });
// });     
</script>

<script type="text/javascript">

////////////////// Home Advisor ////////////////////
	function overall_score(){
		var tot=0;
		var a1 = parseInt($("#product_communicate").val());
		var a2 = parseInt($("#product_explain").val());
		var a3 = parseInt($("#product_money").val());
		var a4 = parseInt($("#product_lead").val());
		var a5 = parseInt($("#product_background").val());
		var a6 = parseInt($("#product_look").val());
		var a7 = parseInt($("#product_rating").val());
		var a8 = parseInt($("#product_email").val());
		var a9 = parseInt($("#product_reinforce").val());
		var a10 = parseInt($("#product_tool").val());
		var a11 = parseInt($("#product_download").val());
		
		tot=a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+a11;
		
		$('.auto_pass_fail').each(function(index,element){
			val=true;
			if($(element).val()=="Fail"){
				val=false;
				tot=0;
			}
		});
		
		if(!isNaN(tot)){
			$("#score_percentage").val(tot);
		}
	}
	
////////////////// HCCO /////////////////////
	/* function hcco_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
	
		$('.hcco_point').each(function(index,element){
				
				var score_type = $(element).val();
				var weightage = parseInt($(element).children("option:selected").attr('hcco_val'));

				if(score_type == 'Yes'){
					score=score+weightage;
					scoreable = scoreable + weightage;
			    }else if(score_type == 'No'){
					scoreable = scoreable + weightage;			    	
			    }
			
		});

		$('.stella_survey').each(function(index,element){
			var score_type = $(element).val();
			var weightage = parseInt($(element).children("option:selected").attr('hcco_val'));
			
			if(score_type == 'Yes'){
				score= score + weightage;
				scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#earned_hcco').val(score);
		$('#possible_hcco').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#hcco_score_percentage').val(quality_score_percent+'%');
		}
		
	}
	

	function hcco_flex(){
		var score=0;
		var scoreable=0;
		var overall_score_percent=0;
		
		$('.flex_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Pass'){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Fail'){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		overall_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#hcco_flexEarned').val(score);
		$('#hcco_flexPossible').val(scoreable);
		
		if(!isNaN(overall_score_percent)){
			$('#hcco_flexScore').val(overall_score_percent+'%');
		}
		
	} */
		
</script>

<script>
////////////// HCCI /////////////////
	function totalcal(){
		var score=0;
		var scoreable=0;
		var overall_score_percent=0;
		var score4=0;
		var scoreable4=0;
		var overall_score_percent1=0;
		
		$('.points').each(function(index,element)
		{
			var score_type = $(element).val();

			//alert($('#demonstrate').val());

			if($('#demonstrate').val()=='No'){
				var weightage = parseInt($(element).children("option:selected").attr('data-valnum'));
				var score4 = 0;
			}else{ 
				var score4 = 1;
			}
			

			if(score_type == 'Yes'){
				if($('#demonstrate').val()=='No')
				var xyz = 0;
				}else{ 
					var xyz = 1;
				}n<script type="text/javascript">
		})
	}
	
$(document).ready(function(){
	
	
///////////////// Home Advisor //////////////////
	$('#product_communicate').on('change', function(){
		overall_score();
	});
	$('#product_explain').on('change', function(){
		overall_score();
	});
	$('#product_money').on('change', function(){
		overall_score();
	});
	$('#product_lead').on('change', function(){
		overall_score();
	});
	$('#product_background').on('change', function(){
		overall_score();
	});
	$('#product_look').on('change', function(){
		overall_score();
	});
	$('#product_rating').on('change', function(){
		overall_score();
	});
	$('#product_email').on('change', function(){
		overall_score();
	});
	$('#product_reinforce').on('change', function(){
		overall_score();
	});
	$('#product_tool').on('change', function(){
		overall_score();
	});
	$('#product_download').on('change', function(){
		overall_score();
	});
	
	$(document).on('change','.auto_pass_fail',function(){
		var afail = this.value;
		if(afail=="Pass"){
			$("#call_pass_fail").val('Pass');
			$("#call_pass_fail").css("color", "green");
		}else{
			$("#call_pass_fail").val('Fail');
			$("#call_pass_fail").css("color", "red");
		}
		overall_score();
	});
	
	
////////////// HCCO ///////////////////	
	$(document).on('change','.hcco_point',function(){
		hcco_calc();
	});
	$(document).on('change','.stella_survey',function(){
		hcco_calc();
	});
	// $(document).on('change','.compliance',function(){
	// 	hcco_calc();
	// });
	// $(document).on('change','.customer',function(){
	// 	hcco_calc();
	// });
	// $(document).on('change','.business',function(){
	// 	hcco_calc();
	// });
	hcco_calc();
	
	
	$(document).on('change','.flex_point',function(){
		hcco_flex();
	});
	hcco_flex();

});
</script>


<script type="text/javascript">
////////////////// Home Advisor ////////////////////
	function overall_score(){
		var tot=0;
		var a1 = parseInt($("#product_communicate").val());
		var a2 = parseInt($("#product_explain").val());
		var a3 = parseInt($("#product_money").val());
		var a4 = parseInt($("#product_lead").val());
		var a5 = parseInt($("#product_background").val());
		var a6 = parseInt($("#product_look").val());
		var a7 = parseInt($("#product_rating").val());
		var a8 = parseInt($("#product_email").val());
		var a9 = parseInt($("#product_reinforce").val());
		var a10 = parseInt($("#product_tool").val());
		var a11 = parseInt($("#product_download").val());
		
		tot=a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+a11;
		
		$('.auto_pass_fail').each(function(index,element){
			val=true;
			if($(element).val()=="Fail"){
				val=false;
				tot=0;
			}
		});
		
		if(!isNaN(tot)){
			$("#score_percentage").val(tot);
		}
	}
	
</script>

<script>
////////////////// HCCO /////////////////////
	function hcco_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
	
		$('.hcco_point').each(function(index,element){
				
				var score_type = $(element).val();
				var weightage = parseInt($(element).children("option:selected").attr('hcco_val'));

				if(score_type == 'Yes'){
					score=score+weightage;
					scoreable = scoreable + weightage;
			    }else if(score_type == 'No'){
					scoreable = scoreable + weightage;			    	
			    }
			
		});

		$('.stella_survey').each(function(index,element){
			var score_type = $(element).val();
			var weightage = parseInt($(element).children("option:selected").attr('hcco_val'));
			
			if(score_type == 'Yes'){
				score= score + weightage;
				scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#earned_hcco').val(score);
		$('#possible_hcco').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#hcco_score_percentage').val(quality_score_percent+'%');
		}
		
	}
	
//////////////////// HCCO - FLEX /////////////////////
	function hcco_flex(){
		var score=0;
		var scoreable=0;
		var overall_score_percent=0;
		
		$('.flex_point').each(function(index,element){
			var score_type = $(element).val();
			
			if((score_type == 'Yes') || (score_type == 'Pass')){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if((score_type == 'No') || (score_type == 'Fail')){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		overall_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#hcco_flexEarned').val(score);
		$('#hcco_flexPossible').val(scoreable);
		
		if(!isNaN(overall_score_percent)){
			$('#hcco_flexScore').val(overall_score_percent+'%');
		}

		
		
	}

	// function hcco_v2(){
	// 	var score=0;
	// 	var scoreable=0;
	// 	var overall_score_percent=0;
		
	// 	$('.hccov2_point').each(function(index,element){
	// 		var score_type = $(element).val();
			
	// 		if((score_type == 'Yes') || (score_type == 'Pass')){
	// 			var weightage1 = parseInt($(element).children("option:selected").attr('hccov2_val'));
	// 			var weightage2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
	// 			score = score + weightage1;
	// 			scoreable = scoreable + weightage2;
	// 		}else if((score_type == 'No') || (score_type == 'Fail')){
	// 			var weightage1 = parseInt($(element).children("option:selected").attr('hccov2_val'));
	// 			var weightage2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
	// 			scoreable = scoreable + weightage1;
	// 		}else if(score_type == 'N/A'){
	// 			var weightage1 = parseInt($(element).children("option:selected").attr('hccov2_val'));
	// 			var weightage2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
	// 			score = score + weightage1;
	// 			scoreable = scoreable + weightage2;
	// 		}
	// 	});
	// 	overall_score_percent = ((score*100)/scoreable).toFixed(2);
	// 	$('#hcco_v2Earned').val(score);
	// 	$('#hcco_v2Possible').val(scoreable);
		
	// 	if(!isNaN(overall_score_percent)){
	// 		$('#hcco_v2Score').val(overall_score_percent+'%');
	// 	}

		
		
	// }
		
</script>

<script>
////////////// HCCI /////////////////
	function totalcal()
	{
		var score=0;
		var scoreable=0;
		var overall_score_percent=0;
		var score4=0;
		var scoreable4=0;
		var overall_score_percent1=0;
		
		$('.points').each(function(index,element)
		{
			var score_type = $(element).val();

			//alert($('#demonstrate').val());

			if($('#demonstrate').val()=='No'){
				var weightage = parseInt($(element).children("option:selected").attr('data-valnum'));
				var score4 = 0;
			}else{ 
				var score4 = 1;
			}
			

				if(score_type == 'Yes')
				{
				if($('#demonstrate').val()=='No')
				var xyz = 0;
				}else{ 
					var xyz = 1;
				}
				var weightage = parseInt($(element).children("option:selected").attr('data-valnum'));
				score = score + weightage+xyz;
				scoreable = scoreable + weightage;
		}else if(score_type == 'No'){
				var weightage = parseInt($(element).children("option:selected").attr('data-valnum'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('data-valnum'));
				score = score + weightage;
				scoreable = scoreable + weightage;
				});
			
		//});
		overall_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		$('#overallScore').val(overall_score_percent+'%');

		$('.hcci').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage4 = parseInt($(element).children("option:selected").attr('data-valnum'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type == 'No'){
				var weightage4 = parseInt($(element).children("option:selected").attr('data-valnum'));
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type == 'N/A'){
				var weightage4 = parseInt($(element).children("option:selected").attr('data-valnum'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}
		});
		overall_score_percent1 = ((score4*100)/scoreable4).toFixed(2);
		$('#earnedScore1').val(score4);
		$('#possibleScore1').val(scoreable4);
		$('#overallScore1').val(overall_score_percent1+'%');
		
		/*------------*/
		if($('#hcciAF1').val()=='No' || $('#hcciAF2').val()=='No'){
			$('.hcciFatal').val(0);
		}else{
			$('.hcciFatal').val(overall_score_percent+'%');
		}

		if($('#hcciAF3').val()=='No' || $('#hcciAF4').val()=='No' || $('#hcciAF5').val()=='No' || $('#hcciAF6').val()=='No'){
			$('.hccicall').val("No");
		}else{
			$('.hccicall').val("Yes");
		}


		
	//////////////////////////////
		var compliancescore = 0;
		var compliancescoreable = 0;
		var compliance_score_percent = 0;
		var customerscore = 0;
		var customerscoreable = 0;
		var customer_score_percent = 0;
		var businessscore = 0;
		var businessscoreable = 0;
		var business_score_percent = 0;
		
		$('.compliance').each(function(index,element){
			var score_type1 = $(element).val();
			
			if(score_type1 == 'Yes'){
				var weightage1 = parseInt($(element).children("option:selected").attr('data-valnum'));
				compliancescore = compliancescore + weightage1;
				compliancescoreable = compliancescoreable + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseInt($(element).children("option:selected").attr('data-valnum'));
				compliancescoreable = compliancescoreable + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseInt($(element).children("option:selected").attr('data-valnum'));
				compliancescore = compliancescore + weightage1;
				compliancescoreable = compliancescoreable + weightage1;
			}
		});
		compliance_score_percent = ((compliancescore*100)/compliancescoreable).toFixed(2);
		$('#compliancescore').val(compliancescore);
		$('#compliancescoreable').val(compliancescoreable);
		$('#compliance_score_percent').val(compliance_score_percent+'%');
	//////////////
		$('.customer').each(function(index,element){
			var score_type2 = $(element).val();
			
			if(score_type2 == 'Yes'){
				var weightage2 = parseInt($(element).children("option:selected").attr('data-valnum'));
				customerscore = customerscore + weightage2;
				customerscoreable = customerscoreable + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseInt($(element).children("option:selected").attr('data-valnum'));
				customerscoreable = customerscoreable + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseInt($(element).children("option:selected").attr('data-valnum'));
				customerscore = customerscore + weightage2;
				customerscoreable = customerscoreable + weightage2;
			}
		});
		customer_score_percent = ((customerscore*100)/customerscoreable).toFixed(2);
		$('#customerscore').val(customerscore);
		$('#customerscoreable').val(customerscoreable);
		$('#customer_score_percent').val(customer_score_percent+'%');
	//////////////
		$('.business').each(function(index,element){
			var score_type3 = $(element).val();
			
			if(score_type3 == 'Yes'){
				var weightage3 = parseInt($(element).children("option:selected").attr('data-valnum'));
				businessscore = businessscore + weightage3;
				businessscoreable = businessscoreable + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseInt($(element).children("option:selected").attr('data-valnum'));
				businessscoreable = businessscoreable + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseInt($(element).children("option:selected").attr('data-valnum'));
				businessscore = businessscore + weightage3;
				businessscoreable = businessscoreable + weightage3;
			}
		});
		business_score_percent = ((businessscore*100)/businessscoreable).toFixed(2);
		$('#businessscore').val(businessscore);
		$('#businessscoreable').val(businessscoreable);
		$('#business_score_percent').val(business_score_percent+'%');
	
	}

	totalcal();
	
</script>
<script>
$(document).ready(function(){
	
	$(".points").on("change",function(){
		totalcal();
	});	
	$(document).on('change','.hcci',function(){
		totalcal();
	});
	totalcal();
	$(document).on('change','.compliance',function(){
		totalcal();
	});
	$(document).on('change','.customer',function(){
		totalcal();
	});
	$(document).on('change','.business',function(){
		totalcal();
	});
	totalcal();

});	
</script>

<!--  <script>
//////////////// queens and english ///////////////////////
	function hcci(){
		var score=0;

		var score = 0;
		var scoreable = 0;
		var na_count = 0;
		var quality_score_percent = 0;
		$('.hcci').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('queens_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('queens_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
         
        $('#ernscoo').val(score);
        $('#posiooo').val(scoreable);

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		if(!isNaN(quality_score_percent)){
			$('#queensScore').val(quality_score_percent+'%');
		}

	   /*---------------*/
		if($('#hcciAF3').val()=='No' || $('#hcciAF4').val()=='No' || $('#hcciAF5').val()=='No'){
			$('.hccicall').val("No");
		}else{
			$('.hccicall').val("Yes");
		}
	}

	$(document).on('change','.hcci',function(){
		hcci();
	});
	hcci();

	</script> -->


 <script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
 </script>
 
 <script type="text/javascript">
$(document).ready(function(){
	
///////////////// Home Advisor //////////////////
	$('#product_communicate').on('change', function(){
		overall_score();
	});
	$('#product_explain').on('change', function(){
		overall_score();
	});
	$('#product_money').on('change', function(){
		overall_score();
	});
	$('#product_lead').on('change', function(){
		overall_score();
	});
	$('#product_background').on('change', function(){
		overall_score();
	});
	$('#product_look').on('change', function(){
		overall_score();
	});
	$('#product_rating').on('change', function(){
		overall_score();
	});
	$('#product_email').on('change', function(){
		overall_score();
	});
	$('#product_reinforce').on('change', function(){
		overall_score();
	});
	$('#product_tool').on('change', function(){
		overall_score();
	});
	$('#product_download').on('change', function(){
		overall_score();
	});
	
	$(document).on('change','.auto_pass_fail',function(){
		var afail = this.value;
		if(afail=="Pass"){
			$("#call_pass_fail").val('Pass');
			$("#call_pass_fail").css("color", "green");
		}else{
			$("#call_pass_fail").val('Fail');
			$("#call_pass_fail").css("color", "red");
		}
		overall_score();
	});
	
	
////////////// HCCO ///////////////////	
	$(document).on('change','.hcco_point',function(){
		hcco_calc();
	});
	$(document).on('change','.stella_survey',function(){
		hcco_calc();
	});
	// $(document).on('change','.compliance',function(){
	// 	hcco_calc();
	// });
	// $(document).on('change','.customer',function(){
	// 	hcco_calc();
	// });
	// $(document).on('change','.business',function(){
	// 	hcco_calc();
	// });
	hcco_calc();
	
	
	$(document).on('change','.flex_point',function(){
		hcco_flex();
	});
	hcco_flex();

});
</script>


<script type="text/javascript">

////////////////// Home Advisor ////////////////////
	function overall_score(){
		var tot=0;
		var a1 = parseInt($("#product_communicate").val());
		var a2 = parseInt($("#product_explain").val());
		var a3 = parseInt($("#product_money").val());
		var a4 = parseInt($("#product_lead").val());
		var a5 = parseInt($("#product_background").val());
		var a6 = parseInt($("#product_look").val());
		var a7 = parseInt($("#product_rating").val());
		var a8 = parseInt($("#product_email").val());
		var a9 = parseInt($("#product_reinforce").val());
		var a10 = parseInt($("#product_tool").val());
		var a11 = parseInt($("#product_download").val());
		
		tot=a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+a11;
		
		$('.auto_pass_fail').each(function(index,element){
			val=true;
			if($(element).val()=="Fail"){
				val=false;
				tot=0;
			}
		});
		
		if(!isNaN(tot)){
			$("#score_percentage").val(tot);
		}
	}
	
////////////////// HCCO /////////////////////
	function hcco_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
	
		$('.hcco_point').each(function(index,element){
				
				var score_type = $(element).val();
				var weightage = parseInt($(element).children("option:selected").attr('hcco_val'));

				if(score_type == 'Yes'){
					score=score+weightage;
					scoreable = scoreable + weightage;
			    }else if(score_type == 'No'){
					scoreable = scoreable + weightage;			    	
			    }
			
		});

		$('.stella_survey').each(function(index,element){
			var score_type = $(element).val();
			var weightage = parseInt($(element).children("option:selected").attr('hcco_val'));
			
			if(score_type == 'Yes'){
				score= score + weightage;
				scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#earned_hcco').val(score);
		$('#possible_hcco').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#hcco_score_percentage').val(quality_score_percent+'%');
		}
		
		//////////////////////////////
		var compliancescore2 = 0;
		var compliancescoreable2 = 0;
		var compliance_score_percent2 = 0;
		var customerscore2 = 0;
		var customerscoreable2 = 0;
		var customer_score_percent2 = 0;
		var businessscore2 = 0;
		var businessscoreable2 = 0;
		var business_score_percent2 = 0;
		
		$('.compliance').each(function(index,element){
			var score_type1 = $(element).val();
			
			if(score_type1 == 'Yes'){
				var weightage1 = parseInt($(element).children("option:selected").attr('hcco_val'));
				compliancescore2 = compliancescore2 + weightage1;
				compliancescoreable2 = compliancescoreable2 + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseInt($(element).children("option:selected").attr('hcco_val'));
				compliancescoreable2 = compliancescoreable2 + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseInt($(element).children("option:selected").attr('hcco_val'));
				compliancescore2 = compliancescore2 + weightage1;
				compliancescoreable2 = compliancescoreable2 + weightage1;
			}
		});
		compliance_score_percent = ((compliancescore2*100)/compliancescoreable2).toFixed(2);
		$('#compliancescore2').val(compliancescore2);
		$('#compliancescoreable2').val(compliancescoreable2);
		$('#compliance_score_percent2').val(compliance_score_percent+'%');
	//////////////
		$('.customer').each(function(index,element){
			var score_type2 = $(element).val();
			
			if(score_type2 == 'Yes'){
				var weightage2 = parseInt($(element).children("option:selected").attr('hcco_val'));
				customerscore2 = customerscore2 + weightage2;
				customerscoreable2 = customerscoreable2 + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseInt($(element).children("option:selected").attr('hcco_val'));
				customerscoreable2 = customerscoreable2 + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseInt($(element).children("option:selected").attr('hcco_val'));
				customerscore2 = customerscore2 + weightage2;
				customerscoreable2 = customerscoreable2 + weightage2;
			}
		});
		customer_score_percent = ((customerscore2*100)/customerscoreable2).toFixed(2);
		$('#customerscore2').val(customerscore2);
		$('#customerscoreable2').val(customerscoreable2);
		$('#customer_score_percent2').val(customer_score_percent+'%');
	//////////////
		$('.business').each(function(index,element){
			var score_type3 = $(element).val();
			
			if(score_type3 == 'Yes'){
				var weightage3 = parseInt($(element).children("option:selected").attr('hcco_val'));
				businessscore2 = businessscore2 + weightage3;
				businessscoreable2 = businessscoreable2 + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseInt($(element).children("option:selected").attr('hcco_val'));
				businessscoreable2 = businessscoreable2 + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseInt($(element).children("option:selected").attr('hcco_val'));
				businessscore2 = businessscore2 + weightage3;
				businessscoreable2 = businessscoreable2 + weightage3;
			}
		});
		business_score_percent = ((businessscore2*100)/businessscoreable2).toFixed(2);
		$('#businessscore2').val(businessscore2);
		$('#businessscoreable2').val(businessscoreable2);
		$('#business_score_percent2').val(business_score_percent+'%');
	
	}

	hcco_calc();
	
///////////////////////////////////////	
	function hcco_flex(){
		var score=0;
		var scoreable=0;
		var overall_score_percent=0;
		
		$('.flex_point').each(function(index,element){
			var score_type = $(element).val();
			
			if((score_type == 'Pass') || (score_type == 'Yes')){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if((score_type == 'Fail') || (score_type == 'No')){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		overall_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#hcco_flexEarned').val(score);
		$('#hcco_flexPossible').val(scoreable);
		$('#hcco_flexScore').val(overall_score_percent+'%');
		// if(!isNaN(overall_score_percent)){
		// 	$('#hcco_flexScore').val(overall_score_percent+'%');
		// }
		
	//////////////////////////////
		var compliancescore1 = 0;
		var compliancescoreable1 = 0;
		var compliance_score_percent1 = 0;
		var customerscore1 = 0;
		var customerscoreable1 = 0;
		var customer_score_percent1 = 0;
		var businessscore1 = 0;
		var businessscoreable1 = 0;
		var business_score_percent1 = 0;
		
		$('.compliance').each(function(index,element){
			var score_type1 = $(element).val();
			
			if((score_type1 == 'Pass') || (score_type1 == 'Yes')){
				var weightage1 = parseInt($(element).children("option:selected").attr('flex_val'));
				compliancescore1 = compliancescore1 + weightage1;
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if((score_type1 == 'Fail') || (score_type1 == 'No')){
				var weightage1 = parseInt($(element).children("option:selected").attr('flex_val'));
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseInt($(element).children("option:selected").attr('flex_val'));
				compliancescore1 = compliancescore1 + weightage1;
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}
		});
		compliance_score_percent = ((compliancescore1*100)/compliancescoreable1).toFixed(2);
		$('#compliancescore1').val(compliancescore1);
		$('#compliancescoreable1').val(compliancescoreable1);
		$('#compliance_score_percent1').val(compliance_score_percent+'%');
	//////////////
		$('.customer').each(function(index,element){
			var score_type2 = $(element).val();
			
			if((score_type2 == 'Pass') || (score_type2 == 'Yes')){
				var weightage2 = parseInt($(element).children("option:selected").attr('flex_val'));
				customerscore1 = customerscore1 + weightage2;
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if((score_type2 == 'Fail') || (score_type2 == 'No')){
				var weightage2 = parseInt($(element).children("option:selected").attr('flex_val'));
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseInt($(element).children("option:selected").attr('flex_val'));
				customerscore1 = customerscore1 + weightage2;
				customerscoreable1 = customerscoreable1 + weightage2;
			}
		});
		customer_score_percent = ((customerscore1*100)/customerscoreable1).toFixed(2);
		$('#customerscore1').val(customerscore1);
		$('#customerscoreable1').val(customerscoreable1);
		$('#customer_score_percent1').val(customer_score_percent+'%');
	//////////////
		$('.business').each(function(index,element){
			var score_type3 = $(element).val();
			
			if((score_type3 == 'Pass') || (score_type3 == 'Yes')){
				var weightage3 = parseInt($(element).children("option:selected").attr('flex_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if((score_type3 == 'Fail') || (score_type3 == 'No')){
				var weightage3 = parseInt($(element).children("option:selected").attr('flex_val'));
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseInt($(element).children("option:selected").attr('flex_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}
		});
		business_score_percent = ((businessscore1*100)/businessscoreable1).toFixed(2);
		$('#businessscore1').val(businessscore1);
		$('#businessscoreable1').val(businessscoreable1);
		$('#business_score_percent1').val(business_score_percent+'%');
	
	}

	hcco_flex();

	///////////////////////////////////////	
	function hcco_v2(){
		var score=0;
		var scoreable=0;
		var overall_score_percent=0;
		
		$('.hccov2_point').each(function(index,element){
			var weightage1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
			var weightage2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
			score = score + weightage1;
			scoreable = scoreable + weightage2;
			/* var score_type = $(element).val();
			if((score_type == 'Yes') || (score_type == 'Pass')){
				var weightage1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				score = score + weightage1;
				scoreable = scoreable + weightage2;
			}else if((score_type == 'No') || (score_type == 'Fail')){
				var weightage1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				score = score + weightage1;
				scoreable = scoreable + weightage2;
			}else if(score_type == 'N/A'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var weightage2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				score = score + weightage1;
				scoreable = scoreable + weightage2;
			} */
		});
		overall_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#hcco_v2Earned').val(score);
		$('#hcco_v2Possible').val(scoreable);
		$('#hcco_v2Score').val(overall_score_percent+'%');

		// if(!isNaN(overall_score_percent)){
		// 	$('#hcco_v2Score').val(overall_score_percent+'%');
		// }

		if($('#hcco_v2AFatal1').val()=='Fail' || $('#hcco_v2AFatal2').val()=='Fail' || $('#hcco_v2AFatal3').val()=='Fail' || $('#hcco_v2AFatal4').val()=='Fail'){
			$('#hcco_v2Score').val(0+'%');
		}else{
			$('#hcco_v2Score').val(overall_score_percent+'%');
		}
		
	//////////////////////////////
		var compliancescore_v2 = 0;
		var compliancescoreable_v2 = 0;
		var compliance_score_percent_v2 = 0;
		$('.compliance').each(function(index,element){
			var compw1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
			var compw2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
			compliancescore_v2 = compliancescore_v2 + compw1;
			compliancescoreable_v2 = compliancescoreable_v2 + compw2;
			/* var score_type1 = $(element).val();
			if((score_type1 == 'Pass') || (score_type1 == 'Yes')){
				var compw1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var compw2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				compliancescore_v2 = compliancescore_v2 + compw1;
				compliancescoreable_v2 = compliancescoreable_v2 + compw2;
			}else if((score_type1 == 'Fail') || (score_type1 == 'No')){
				var compw1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var compw2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				compliancescore_v2 = compliancescore_v2 + compw1;
				compliancescoreable_v2 = compliancescoreable_v2 + compw2;
			}else if(score_type1 == 'N/A'){
				var compw1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var compw2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				compliancescore_v2 = compliancescore_v2 + compw1;
				compliancescoreable_v2 = compliancescoreable_v2 + compw2;
			} */
		});
		compliance_score_percent_v2 = ((compliancescore_v2*100)/compliancescoreable_v2).toFixed(2);
		$('#compliancescore_v2').val(compliancescore_v2);
		$('#compliancescoreable_v2').val(compliancescoreable_v2);
		$('#compliance_score_percent_v2').val(compliance_score_percent_v2+'%');
	//////////////
		var customerscore_v2 = 0;
		var customerscoreable_v2 = 0;
		var customer_score_percent_v2 = 0;
		$('.customer').each(function(index,element){
			var w1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
			var w2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
			customerscore_v2 = customerscore_v2 + w1;
			customerscoreable_v2 = customerscoreable_v2 + w2;
			
			/*var score_type2 = $(element).val();
			if((score_type2 == 'Pass') || (score_type2 == 'Yes')){
				var w1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				customerscore_v2 = customerscore_v2 + w1;
				customerscoreable_v2 = customerscoreable_v2 + w2;
			}else if((score_type2 == 'Fail') || (score_type2 == 'No')){
				var w1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				customerscore_v2 = customerscore_v2 + w2;
				customerscoreable_v2 = customerscoreable_v2 + w2;
			}else if(score_type2 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				customerscore_v2 = customerscore_v2 + w1;
				customerscoreable_v2 = customerscoreable_v2 + w2;
			} */
		});
		customer_score_percent_v2 = ((customerscore_v2*100)/customerscoreable_v2).toFixed(2);
		$('#customerscore_v2').val(customerscore_v2);
		$('#customerscoreable_v2').val(customerscoreable_v2);
		$('#customer_score_percent_v2').val(customer_score_percent_v2+'%');
	//////////////
		var businessscore_v2 = 0;
		var businessscoreable_v2 = 0;
		var business_score_percent_v2 = 0;
		$('.business').each(function(index,element){
			var weig1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
			var weig2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
			businessscore_v2 = businessscore_v2 + weig1;
			businessscoreable_v2 = businessscoreable_v2 + weig2;
			
			/* var score_type3 = $(element).val();
			if((score_type3 == 'Pass') || (score_type3 == 'Yes')){
				var weig1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var weig2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				businessscore_v2 = businessscore_v2 + weig1;
				businessscoreable_v2 = businessscoreable_v2 + weig2;
			}else if((score_type3 == 'Fail') || (score_type3 == 'No')){
				var weig1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var weig2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				businessscore_v2 = businessscore_v2 + weig1;
				businessscoreable_v2 = businessscoreable_v2 + weig2;
			}else if(score_type3 == 'N/A'){
				var weig1 = parseFloat($(element).children("option:selected").attr('hccov2_val'));
				var weig2 = parseFloat($(element).children("option:selected").attr('hccov2_max'));
				businessscore_v2 = businessscore_v2 + weig1;
				businessscoreable_v2 = businessscoreable_v2 + weig2;
			} */
		});
		business_score_percent_v2 = ((businessscore_v2*100)/businessscoreable_v2).toFixed(2);
		$('#businessscore_v2').val(businessscore_v2);
		$('#businessscoreable_v2').val(businessscoreable_v2);
		$('#business_score_percent_v2').val(business_score_percent_v2+'%');
	
	}
	
	$(document).ready(function(){
		$(document).on('change','.hccov2_point',function(){ hcco_v2(); });
		$(document).on('change','.compliance',function(){ hcco_v2(); });
		$(document).on('change','.customer',function(){ hcco_v2(); });
		$(document).on('change','.business',function(){ hcco_v2(); });
		hcco_v2();
	});
		
</script>

<script>
////////////// HCCI /////////////////
	function totalcal(){
		var score=0;
		var scoreable=0;
		var overall_score_percent=0;
		var score4=0;
		var scoreable4=0;
		var overall_score_percent1=0;
		
		$('.points').each(function(index,element){
			var score_type = $(element).val();

			//alert($('#demonstrate').val
			if(score_type == 'Yes'){
				var weightage = parseInt($(element).children("option:selected").attr('data-valnum'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseInt($(element).children("option:selected").attr('data-valnum'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('data-valnum'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});	
				/* var xyz = 1;
				if($('#demonstrate').val()=='No'){
				var xyz = 0;
				}
				var x = score+xyz;
				var y = scoreable+1; */
				
		overall_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		$('#overallScore').val(overall_score_percent+'%');

		$('.hcci').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage4 = parseInt($(element).children("option:selected").attr('data-valnum'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type == 'No'){
				var weightage4 = parseInt($(element).children("option:selected").attr('data-valnum'));
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type == 'N/A'){
				var weightage4 = parseInt($(element).children("option:selected").attr('data-valnum'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}
		});
		overall_score_percent1 = ((score4*100)/scoreable4).toFixed(2);
		$('#earnedScore1').val(score4);
		$('#possibleScore1').val(scoreable4);
		$('#overallScore1').val(overall_score_percent1+'%');
		
	/*------CORE------*/
		if($('#hcciCoreAF1').val()=='No' || $('#hcciCoreAF2').val()=='No' || $('#hcciCoreAF3').val()=='No'){
			$('.hcciCoreFatal').val(0);
		}else{
			$('.hcciCoreFatal').val(overall_score_percent+'%');
		}

		if($('#hcciAF3').val()=='No' || $('#hcciAF4').val()=='No' || $('#hcciAF5').val()=='No' || $('#hcciAF6').val()=='No'){
			$('.hccicall').val("No");
		}else{
			$('.hccicall').val("Yes");
		}
		
	/*------CX------*/
		if($('#hcciCXAF1').val()=='No' || $('#hcciCXAF2').val()=='No'){
			$('.hcciCXFatal').val(0);
		}else{
			$('.hcciCXFatal').val(overall_score_percent+'%');
		}


		
	//////////////////////////////
		var compliancescore = 0;
		var compliancescoreable = 0;
		var compliance_score_percent = 0;
		var customerscore = 0;
		var customerscoreable = 0;
		var customer_score_percent = 0;
		var businessscore = 0;
		var businessscoreable = 0;
		var business_score_percent = 0;
		
		$('.compliance').each(function(index,element){
			var score_type1 = $(element).val();
			
			if(score_type1 == 'Yes'){
				var weightage1 = parseInt($(element).children("option:selected").attr('data-valnum'));
				compliancescore = compliancescore + weightage1;
				compliancescoreable = compliancescoreable + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseInt($(element).children("option:selected").attr('data-valnum'));
				compliancescoreable = compliancescoreable + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseInt($(element).children("option:selected").attr('data-valnum'));
				compliancescore = compliancescore + weightage1;
				compliancescoreable = compliancescoreable + weightage1;
			}
		});
		compliance_score_percent = ((compliancescore*100)/compliancescoreable).toFixed(2);
		$('#compliancescore').val(compliancescore);
		$('#compliancescoreable').val(compliancescoreable);
		$('#compliance_score_percent').val(compliance_score_percent+'%');
	//////////////
		$('.customer').each(function(index,element){
			var score_type2 = $(element).val();
			
			if(score_type2 == 'Yes'){
				var weightage2 = parseInt($(element).children("option:selected").attr('data-valnum'));
				customerscore = customerscore + weightage2;
				customerscoreable = customerscoreable + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseInt($(element).children("option:selected").attr('data-valnum'));
				customerscoreable = customerscoreable + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseInt($(element).children("option:selected").attr('data-valnum'));
				customerscore = customerscore + weightage2;
				customerscoreable = customerscoreable + weightage2;
			}
		});
		customer_score_percent = ((customerscore*100)/customerscoreable).toFixed(2);
		$('#customerscore').val(customerscore);
		$('#customerscoreable').val(customerscoreable);
		$('#customer_score_percent').val(customer_score_percent+'%');
	//////////////
		$('.business').each(function(index,element){
			var score_type3 = $(element).val();
			
			if(score_type3 == 'Yes'){
				var weightage3 = parseInt($(element).children("option:selected").attr('data-valnum'));
				businessscore = businessscore + weightage3;
				businessscoreable = businessscoreable + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseInt($(element).children("option:selected").attr('data-valnum'));
				businessscoreable = businessscoreable + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseInt($(element).children("option:selected").attr('data-valnum'));
				businessscore = businessscore + weightage3;
				businessscoreable = businessscoreable + weightage3;
			}
		});
		business_score_percent = ((businessscore*100)/businessscoreable).toFixed(2);
		$('#businessscore').val(businessscore);
		$('#businessscoreable').val(businessscoreable);
		$('#business_score_percent').val(business_score_percent+'%');
	
	}

	totalcal();
	
</script>
<script>
$(document).ready(function(){
	
	$(".points").on("change",function(){
		totalcal();
	});	
	$(document).on('change','.hcci',function(){
		totalcal();
	});
	totalcal();
	$(document).on('change','.compliance',function(){
		totalcal();
	});
	$(document).on('change','.customer',function(){
		totalcal();
	});
	$(document).on('change','.business',function(){
		totalcal();
	});
	totalcal();

});	
</script>

<!--  <script>
//////////////// queens and english ///////////////////////
	function hcci(){
		var score=0;

		var score = 0;
		var scoreable = 0;
		var na_count = 0;
		var quality_score_percent = 0;
		$('.hcci').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('queens_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('queens_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
         
        $('#ernscoo').val(score);
        $('#posiooo').val(scoreable);

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		if(!isNaN(quality_score_percent)){
			$('#queensScore').val(quality_score_percent+'%');
		}

	   /*---------------*/
		if($('#hcciAF3').val()=='No' || $('#hcciAF4').val()=='No' || $('#hcciAF5').val()=='No'){
			$('.hccicall').val("No");
		}else{
			$('.hccicall').val("Yes");
		}
	}

	$(document).on('change','.hcci',function(){
		hcci();
	});
	hcci();

	</script> -->


 <script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
 </script>
				
	
</script>
<script>
$(document).ready(function(){
	
	$(".points").on("change",function(){
		totalcal();
	});	
	$(document).on('change','.hcci',function(){
		totalcal();
	});
	totalcal();
	$(document).on('change','.compliance',function(){
		totalcal();
	});
	$(document).on('change','.customer',function(){
		totalcal();
	});
	$(document).on('change','.business',function(){
		totalcal();
	});
	totalcal();

});	
</script>

<!--  <script>
//////////////// queens and english ///////////////////////
	function hcci(){
		var score=0;

		var score = 0;
		var scoreable = 0;
		var na_count = 0;
		var quality_score_percent = 0;
		$('.hcci').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('queens_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('queens_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
         
        $('#ernscoo').val(score);
        $('#posiooo').val(scoreable);

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		if(!isNaN(quality_score_percent)){
			$('#queensScore').val(quality_score_percent+'%');
		}

	   /*---------------*/
		if($('#hcciAF3').val()=='No' || $('#hcciAF4').val()=='No' || $('#hcciAF5').val()=='No'){
			$('.hccicall').val("No");
		}else{
			$('.hccicall').val("Yes");
		}
	}

	$(document).on('change','.hcci',function(){
		hcci();
	});
	hcci();

	</script> -->


 <script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
 </script>