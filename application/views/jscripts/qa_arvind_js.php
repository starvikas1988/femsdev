<script type="text/javascript">





	$('#call_time').timepicker({
		
    timeFormat:  "hh:mm:ss",
		"showButtonPanel":  false
		

});




function validateEmail(mail) {

  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/; 


  if(!regex.test(mail.value)){
        
		

	


$("#msg-mail").html("<div class='mail'><font color=red style='font-size:12px;'>Please enter valid  Email ID inside Text Box </font><div>");
		
		$(".waves-effect").attr("disabled",true);
		$(".waves-effect").css('cursor', 'no-drop');



      } else{
		//alert(22222222);
		$("#msg-mail").html("");
               // $("#msg-mail").css("color:red");
		$(".waves-effect").attr("disabled",false);
		$(".waves-effect").css('cursor', 'pointer');
		
      }

}




/////////////////////////////////////////////////////////////////////////////////////////////////////
function phone_noFunction(phone_no){
	//alert(22222222);
	var phone_no=$("#phone_no").val();


 if((phone_no.length <10) || (phone_no.length >12)){
		$("#msg-phone_no").html("<div class='phone_no'><font color=red style='font-size:12px;'>Please enter in number format  at least 10-12 number  inside the Phone Number Text Box </font><div>");
		
		 $(".waves-effect").attr("disabled",true);
		 $(".waves-effect").css('cursor', 'no-drop');
		 
	} else{
		$("#msg-phone_no").html("");
 ///$("#msg-phone_no").css("color:red");
		$(".waves-effect").attr("disabled",false);
		$(".waves-effect").css('cursor', 'pointer');
		
	}

  }


///////////////////////////////////








//////////////////////////////////////////
$(document).ready(function(){


$(document).on('change','.arvind',function(){ arvind_score(); });



arvind_score();
///////////////// Date Time Picker ///////////////////////
	$("#audit_date").datepicker();
	
	
	
	$("#call_duration").timepicker({ timeFormat:'HH:mm:ss', showButtonPanel:false });


	
   $("#from_date").datepicker({  maxDate: new Date() });
	$("#to_date").datepicker({  maxDate: new Date() });
	






	$('#call_date').datetimepicker({
		dateFormat: "mm/dd/yy",
    timeFormat:  "hh:mm:ss",
		"showButtonPanel":  false,
		maxDate: new Date()

});

	

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
		if(aid=="") {
			alert("Please Select Associate Name");
			
			$('#fusion_id').val("");
			$('#tl_id').val("");

		}


		var URL='<?php echo base_url();?>qa_arvind/getTLname';
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
				for (var i in json_obj) $('#doj').append($('#doj').val(json_obj[i].doj));

				for (var i in json_obj) $('#agent_tenure').append($('#agent_tenure').val(json_obj[i].agent_tenure));

				
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
	




//$( "#agent_id").jQuery.fn.agent_tenure();



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





//$("#agent_disposition").ForceNumericOnly();
//$("#actual_disposition").ForceNumericOnly();




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
	
		function arvind_score(){

		


			var score =0;
var scoreable = 0;
var overall_score=0;
var pre_fatal_score=0;
$('.arvind').each(function(index,element){
	
	var score_type = $(element).val();
	if(score_type == 'Yes'){
		var w1 = parseFloat($(element).children("option:selected").attr('arvind_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('arvind_max'));
		score = score + w1;
		scoreable = scoreable + w2;
		pre_fatal_score= pre_fatal_score + w1;
	}else if(score_type == 'No'){
		var w1 = parseFloat($(element).children("option:selected").attr('arvind_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('arvind_max'));
		score = score + w1;
		scoreable = scoreable + w2;
		pre_fatal_score= pre_fatal_score + w1;
	}else if(score_type == 'N/A'){
		var w1 = parseFloat($(element).children("option:selected").attr('arvind_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('arvind_max'));
		score = score + w1;
		scoreable = scoreable + w2;
		pre_fatal_score= pre_fatal_score + w1;
	}
	else if(score_type == 'Pass'){
		var w1 = parseFloat($(element).children("option:selected").attr('arvind_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('arvind_max'));
		score = score + w1;
		scoreable = scoreable + w2;
		pre_fatal_score= pre_fatal_score + w1;
	}
	else if(score_type == 'Fail'){
		var w1 = parseFloat($(element).children("option:selected").attr('arvind_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('arvind_max'));
		score = score + w1;
		scoreable = scoreable + w2;
		
	}
});

totScore = ((score*100)/scoreable).toFixed(2);

score=(score.toFixed(2));
scoreable=(scoreable.toFixed(2));
pre_fatal_score= (pre_fatal_score.toFixed(2));
//alert(pre_fatal_score);

if(!isNaN(score)){
	$('#earned_score').val(score);

	 }

	
	 if(!isNaN(scoreable)){
		$('#possible_score').val(scoreable);
		
	 }

	 if(!isNaN(pre_fatal_score)){
	$('#pre_fatal_score').val(pre_fatal_score);

	 }



		






		
	

	 if($('#information').val()=='Fail' || $('#tagging').val()=='Fail'  || $('#authentication').val()=='Fail' || $('#advisor_provide').val()=='Fail' || $('#advisor_address').val()=='Fail' || $('#correct_tagging').val()=='Fail'){
			totScore=0;
	        $("#overall_score").val(totScore+'%');
			$('#overall_score').css('border-color', '#C71585');
			$('#overall_score').css('color', 'red');
	 }else{
		if(!isNaN(totScore)){
		$('#overall_score').val(totScore+'%');
		$('#overall_score').css('border-color', '');
			$('#overall_score').css('color', 'black');
	  }
	  }




/////////////////////////////////////////////////////////




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
			 $(".arvind-effect").attr("disabled",true);
			 $(".arvind-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".arvind-effect").attr("disabled",false);
			 $(".arvind-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".arvind-effect").attr("disabled",true);
			 $(".arvind-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".arvind-effect").attr("disabled",false);
			 $(".arvind-effect").css('cursor', 'pointer');
			}

		}
		
		
	}





	









</script>


