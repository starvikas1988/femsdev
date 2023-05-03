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
<script type="text/javascript">

	function bsnl_calc(){
		var score = 0;
		var scoreable = 0; 
		var quality_score_percent = 0;
		
		$('.bsnl_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('bsnl_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('bsnl_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'Pass'){
			    var weightage = parseFloat($(element).children("option:selected").attr('bsnl_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'Fail'){
			    var weightage = parseFloat($(element).children("option:selected").attr('bsnl_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('bsnl_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#bsnl_earned_score').val(score);
		$('#bsnl_possible_score').val(scoreable);
		

       if($('#bsnl_AF1').val()=='No' || $('#bsnl_AF2').val()=='No' || $('#bsnl_AF3').val()=='No' || $('#bsnl_AF4').val()=='No' || $('#bsnl_AF5').val()=='No' || $('#bsnl_AF6').val()=='No' || $('#bsnl_AF7').val()=='Fail' || $('#bsnl_AF8').val()=='Fail' || $('#bsnl_AF9').val()=='Fail' ){
			$('#bsnl_overall_score').val(0+'%');
       }else{
			if(!isNaN(quality_score_percent)){
				$('#bsnl_overall_score').val(quality_score_percent+'%');
			}
		}

		
	}
		
//////////////////////////////////////////////////////////////
		
	$(document).on('change','.bsnl_point',function(){ 
		bsnl_calc();
    });
	bsnl_calc();

</script>
<script>
	 //   function mobile_noFunction(mobile_no){
		// 	var mobile_no=$("#mobile_no").val();


		// if((mobile_no.length <10) || (mobile_no.length >12)){
		// 		$("#msg-mobile_no").html("<font color=red style='font-size:14px;'>Please enter the correct format</font>");
			
		// 		$(".waves-effect").attr("disabled",true);
		// 		$(".waves-effect").css('cursor', 'no-drop');
				
		// 	} else{
		// 		$("#msg-mobile_no").html("");
		// 		$(".waves-effect").attr("disabled",false);
		// 		$(".waves-effect").css('cursor', 'pointer');
				
		// 	}
  // }	

  
//   function mobile_no_keyup(mobile_no) {
// 	$("#msg-mobile_no").html("");
	
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



	function mobile_noFunction(mobile_no){
	var mobile_no=$("#mobile_no").val();
	//alert(2);
	
	var pattern =/^[0-9]+\.?[0-9]*$/;    

	if(!pattern.test(mobile_no)){
		
		$("#msg-mobile_no").html("<font color=red style='font-size:14px;'>This Phone No  is not valid </font>");
		 $(".waves-effect").attr("disabled",true);
		 $(".waves-effect").css('cursor', 'no-drop');
		
	} 
	else if((mobile_no.length <10) || (mobile_no.length >12)){
		$("#msg-mobile_no").html("<font color=red style='font-size:14px;'>Please enter at least 10-12 characters inside the Text Box . Including 91 or 0   </font>");
		 $(".waves-effect").attr("disabled",true);
		 $(".waves-effect").css('cursor', 'no-drop');
		 
	} else{
		$("#msg-mobile_no").html("");
		$(".waves-effect").attr("disabled",false);
		$(".waves-effect").css('cursor', 'pointer');
		
	}
  }




  function mobile_no_keyup(mobile_no) {
	$("#msg-mobile_no").html("");
	
}



$("#call_id").ForceNumericOnly();

$("#reference").ForceNumericOnly();



$(function () {
   $('#mobile_no').keydown(function (e) {
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

<script type="text/javascript">
////////////////////////////// Smartflats [1/8/2022] //////////////////////////////////////
	function smartflat_calc(){
		
		var score = 0;
		var scoreable = 0; 
		var tot_score = 0;
		
		$('.smart_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == '100'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == '50'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == '0'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == 'N/A'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}
		});
		tot_score = ((score*100)/scoreable).toFixed(2);
		
		$('#smartEarned').val(score);
		$('#smartPossible').val(scoreable);
		if(!isNaN(tot_score)){
			$('#smartOverall').val(tot_score+'%');
		}
		
	/////////////////////////////////
	
		var cust_score = 0;
		var cust_scoreable = 0; 
		var cust_tot_score = 0;
		
		$('.customer').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == '100'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    cust_score = cust_score + w1;
			    cust_scoreable = cust_scoreable + w2;
			}else if(score_type == '50'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    cust_score = cust_score + w1;
			    cust_scoreable = cust_scoreable + w2;
			}else if(score_type == '0'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    cust_score = cust_score + w1;
			    cust_scoreable = cust_scoreable + w2;
			}else if(score_type == 'N/A'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    cust_score = cust_score + w1;
			    cust_scoreable = cust_scoreable + w2;
			}
		});
		cust_tot_score = ((cust_score*100)/cust_scoreable).toFixed(2);
		
		if(!isNaN(cust_tot_score)){
			$('#custScore').val(cust_tot_score+'%');
		}
		
	////////////////////
	
		var comp_score = 0;
		var comp_scoreable = 0; 
		var comp_tot_score = 0;
		
		$('.compliance').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == '100'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    comp_score = comp_score + w1;
			    comp_scoreable = comp_scoreable + w2;
			}else if(score_type == '50'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    comp_score = comp_score + w1;
			    comp_scoreable = comp_scoreable + w2;
			}else if(score_type == '0'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    comp_score = comp_score + w1;
			    comp_scoreable = comp_scoreable + w2;
			}else if(score_type == 'N/A'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    comp_score = comp_score + w1;
			    comp_scoreable = comp_scoreable + w2;
			}
		});
		comp_tot_score = ((comp_score*100)/comp_scoreable).toFixed(2);
		
		if(!isNaN(comp_tot_score)){
			$('#compScore').val(comp_tot_score+'%');
		}

	////////////////////
	
		var buss_score = 0;
		var buss_scoreable = 0; 
		var buss_tot_score = 0;
		
		$('.business').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == '100'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    buss_score = buss_score + w1;
			    buss_scoreable = buss_scoreable + w2;
			}else if(score_type == '50'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    buss_score = buss_score + w1;
			    buss_scoreable = buss_scoreable + w2;
			}else if(score_type == '0'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    buss_score = buss_score + w1;
			    buss_scoreable = buss_scoreable + w2;
			}else if(score_type == 'N/A'){
			    var w1 = parseFloat($(element).children("option:selected").attr('min_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('max_val'));
			    buss_score = buss_score + w1;
			    buss_scoreable = buss_scoreable + w2;
			}
		});
		buss_tot_score = ((buss_score*100)/buss_scoreable).toFixed(2);
		
		if(!isNaN(buss_tot_score)){
			$('#busiScore').val(buss_tot_score+'%');
		}

		
	}
		
//////////////////////////////////////////////////////////////
		
	$(document).on('change','.smart_point',function(){ smartflat_calc(); });
	$(document).on('change','.customer',function(){ smartflat_calc(); });
	$(document).on('change','.compliance',function(){ smartflat_calc(); });
	$(document).on('change','.business',function(){ smartflat_calc(); });
	smartflat_calc();

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
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	// $("#call_date").datepicker();
	$("#call_date").datepicker({ maxDate: new Date() });
	$("#booking_date").datepicker();
	$("#video_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_duration").timepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#go_live_date").datepicker();
	
	
///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	if($("#audit_type").val() == "Calibration"){
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	//console.log(`OnLoad -> ${$("#auditor_type").val()}`)
	$('#audit_type').on('change', function(){
		
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);

		} else{
			$('.auType').hide();
			$('#auditor_type').val("")
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
			// $('#auditor_type').val('');
		}
	//	console.log(`OnChange -> ${$("#auditor_type").val()}`)
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
				for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
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
	
//////////////// After Submit Form Disabled //////////////////////
	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});	

	
//////////////////////////	
	$("button[type = 'submit']").click(function(event) {
		var $fileUpload = $("input[type='file']");
		if (parseInt($fileUpload.get(0).files.length) > 10) {
			alert("You are only allowed to upload a maximum of 10 files");
			event.preventDefault();
		}
	});
	
});
</script>

<script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
</script>
