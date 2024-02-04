<script type="text/javascript">

function phone_noFunction(phone_no){
	//alert(22222222);
	var phone_no=$("#phone_no").val();


 if((phone_no.length <10) || (phone_no.length >12)){
		$("#msg-phone_no").html("<div class='phone_no'><font color=red style='font-size:14px;'>Please enter in number format  at least 10-12 number  inside the Phone Number Text Box </font><div>");
		
		 $(".waves-effect").attr("disabled",true);
		 $(".waves-effect").css('cursor', 'no-drop');
		 
	} else{
		$("#msg-phone_no").html("");
		$(".waves-effect").attr("disabled",false);
		$(".waves-effect").css('cursor', 'pointer');
		
	}

  }


///////////////////////////////////








//////////////////////////////////////////
$(document).ready(function(){


$(document).on('change','.redeo',function(){ redeo_score(); });
$(document).on('change','.business',function(){ redeo_score(); });
$(document).on('change','.customer',function(){ redeo_score(); });
$(document).on('change','.compliance',function(){ redeo_score(); });


redeo_score();
///////////////// Date Time Picker ///////////////////////
	$("#audit_date").datepicker();
	





$("#call_time").timepicker({timeFormat:'HH:mm:ss' });

	
   $("#from_date").datepicker({  maxDate: new Date() });
	$("#to_date").datepicker({  maxDate: new Date() });
	

	$("#call_date").datepicker({  maxDate: new Date() });

	

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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









//$("#rebate option[value='"+rebate+"']").prop('selected' , true);  





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
	


//////////   validation for number 









jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
          
            return ((key == 8) || (key == 46) ||    (key == 189) || (key >= 48 && key <= 57)|| (key >= 96 && key <= 105)|| (key >= 65 && key <= 90));
        });
    });
};





$("#call_id").ForceNumericOnly();
$("#record_id").ForceNumericOnly();




$(function () {
   $('').keydown(function (e) {
        if (e.shiftKey || e.ctrlKey || e.altKey) {
           e.preventDefault();
        } 
        else {
            var key = e.keyCode;
            if (!((key >= 0 && key <= 31) ||  (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
               e.preventDefault();
            }
        }
    });
});



$("").on("input", function(evt) {
    var phone_no = $(this);
    phone_no.val(phone_no.val().replace(/\D/g, ""));
    if ((evt.which < 48 || evt.which > 57)) 
     {
	   evt.preventDefault();
     }
 });



$(document).ready(function () {    
    
	$('#phone_no').keypress(function (e) {    

		var charCode = (e.which) ? e.which : event.keyCode    

		if (String.fromCharCode(charCode).match(/[^0-9]/g))    

			return false;                        

	});    

});


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
	
		function redeo_score(){

		


			var score =0;
var scoreable = 0;
var overall_score=0;
$('.redeo').each(function(index,element){
	
	var score_type = $(element).val();
	if(score_type == 'Yes'){
		var w1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'No'){
		var w1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'N/A'){
		var w1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	else if(score_type == 'Pass'){
		var w1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	else if(score_type == 'Fail'){
		var w1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
});

totScore = ((score*100)/scoreable).toFixed(2);

score=(score.toFixed(2));
scoreable=(scoreable.toFixed(2));



if(!isNaN(score)){
	$('#earned_score').val(score);
	 }

	
	 if(!isNaN(scoreable)){
		$('#possible_score').val(scoreable);
	 }


		

		//alert(totScore);
		if(!isNaN(totScore)){
	 	$('#overall_score').val(totScore+'%');
	 }

	

/////////////////////////////////////////////////////////



//////////////// Customer/Business/Compliance //////////////////
var customerScore = 0;
var customerScoreable = 0;
var customerPercentage = 0;
//alert(12345678);

$('.customer').each(function(index,element){
	var sc1 = $(element).val();
	//alert(sc1);
	
	if(sc1 == 'Yes'){
		var cw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		customerScore = customerScore + cw1;
		customerScoreable = customerScoreable + cw2;
	}else if(sc1 == 'No'){
		var cw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		customerScore = customerScore + cw1;
		customerScoreable = customerScoreable + cw2;
	}else if(sc1 == 'N/A'){
		var cw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		customerScore = customerScore + cw1;
		customerScoreable = customerScoreable + cw2;
	}
});


customerScore=customerScore.toFixed(2);
customerScoreable=customerScoreable.toFixed(2);

$('#custAcmEarned').val(customerScore);
$('#custAcmPossible').val(customerScoreable);
customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
if(!isNaN(customerPercentage)){
	$('#custAcmScore').val(customerPercentage+'%');
}
////////////
var businessScore = 0;
var businessScoreable = 0;
var businessPercentage = 0;
$('.business').each(function(index,element){

	var sc2 = $(element).val();
	//alert(sc2);
	if(sc2 == 'Yes'){
		var bw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		businessScore = businessScore + bw1;
		businessScoreable = businessScoreable + bw2;
	}else if(sc2 == 'No'){
		var bw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		businessScore = businessScore + bw1;
		businessScoreable = businessScoreable + bw2;
	}else if(sc2 == 'N/A'){
		var bw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var bw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		businessScore = businessScore + bw1;
		businessScoreable = businessScoreable + bw2;
	}
});


businessScore=businessScore.toFixed(2);
businessScoreable=businessScoreable.toFixed(2);


$('#busiAcmEarned').val(businessScore);
$('#busiAcmPossible').val(businessScoreable);
businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
if(!isNaN(businessPercentage)){
	$('#busiAcmScore').val(businessPercentage+'%');
}
////////////
var complianceScore = 0;
var complianceScoreable = 0;
var compliancePercentage = 0;
$('.compliance').each(function(index,element){
	var sc3 = $(element).val();
	//alert(sc3);
	if(sc3 == 'Yes'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'No'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Fail'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Pass'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Excellent'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Good'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'Poor'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}else if(sc3 == 'N/A'){
		var cpw1 = parseFloat($(element).children("option:selected").attr('redeo_val'));
		var cpw2 = parseFloat($(element).children("option:selected").attr('redeo_max'));
		complianceScore = complianceScore + cpw1;
		complianceScoreable = complianceScoreable + cpw2;
	}
});







complianceScore=complianceScore.toFixed(2);
complianceScoreable=complianceScoreable.toFixed(2)







$('#complAcmEarned').val(complianceScore);
$('#complAcmPossible').val(complianceScoreable);
compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
if(!isNaN(compliancePercentage)){
	$('#complAcmScore').val(compliancePercentage+'%');
}













/////////////////////////////////////////////////////

}
//////////

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
			 $(".redeo-effect").attr("disabled",true);
			 $(".redeo-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".redeo-effect").attr("disabled",false);
			 $(".redeo-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".redeo-effect").attr("disabled",true);
			 $(".redeo-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".redeo-effect").attr("disabled",false);
			 $(".redeo-effect").css('cursor', 'pointer');
			}

		}
		
		
	}






























</script>