<script type="text/javascript">

/////////////////////////////////////////////////////////////////////////////////////////////////////
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



//////////////////////////////////////////
$(document).ready(function(){


$(document).on('change','.ash_maples',function(){ ash_maples_score(); });



ash_maples_score();
///////////////// Date Time Picker ///////////////////////
	$("#audit_date").datepicker();
	
	$("#call_date").datepicker({  maxDate: new Date() });
	

	



	$('#call_time').timepicker({
		timeFormat: "HH:mm:ss",
		"showButtonPanel":  false
});


	
   $("#from_date").datepicker({  maxDate: new Date() });
	$("#to_date").datepicker({  maxDate: new Date() });
	

	//$("#call_date").datetimepicker({  format:'MM/DD/YYYY HH:mm:ss',  defaultDate: new Date(), maxDate: moment().add(1, "hours").toDate() });

	

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
		if(aid=="") {
			alert("Please Select Agent");
			
			$('#fusion_id').val("");
			$('#tl_id').val("");

		}



		var URL='<?php echo base_url();?>qa_ash_maples/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));
				for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
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





$("#agent_disposition").ForceNumericOnly();
$("#actual_disposition").ForceNumericOnly();




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
	
		function ash_maples_score(){

		


			var score =0;
var scoreable = 0;
var overall_score=0;
$('.ash_maples').each(function(index,element){
	
	var score_type = $(element).val();
	if(score_type == '100'){
		var w1 = parseFloat($(element).children("option:selected").attr('ash_maples_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('ash_maples_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == '0'){
		var w1 = parseFloat($(element).children("option:selected").attr('ash_maples_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('ash_maples_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}else if(score_type == 'N/A'){
		var w1 = parseFloat($(element).children("option:selected").attr('ash_maples_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('ash_maples_max'));
		score = score + w1;
		scoreable = scoreable + w2;
	}
	else if(score_type == '50'){
		var w1 = parseFloat($(element).children("option:selected").attr('ash_maples_val'));
		var w2 = parseFloat($(element).children("option:selected").attr('ash_maples_max'));
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


		






		
	

	 if($('#ztp').val()=='0'){
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
			 $(".ash_maples-effect").attr("disabled",true);
			 $(".ash_maples-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".ash_maples-effect").attr("disabled",false);
			 $(".ash_maples-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".ash_maples-effect").attr("disabled",true);
			 $(".ash_maples-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".ash_maples-effect").attr("disabled",false);
			 $(".ash_maples-effect").css('cursor', 'pointer');
			}

		}
		
		
	}





	









</script>


