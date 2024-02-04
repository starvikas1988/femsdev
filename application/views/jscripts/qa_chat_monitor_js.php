
<!--============================== Buc New Start======================= -->
<script>

	function bucnew_calc(){
		
		var score = 0;
		var scoreable = 0; 
		var scoreable2 = 0;
		var quality_score_percent = 0;
		var total_scoreable = 0;
		var total_score=0;
		
		$('.bucnew_points').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('bucnew_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			    total_yes = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('bucnew_val'));
			    scoreable = scoreable + weightage;
			    var weightage2 = parseFloat($(element).children("option:selected").attr('bucnew_val'));
			    scoreable2 = scoreable2 + weightage2
			    total_scoreable = scoreable2 + weightage2;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('bucnew_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}
		});
		
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#bucnew_earned').val(score);
		$('#bucnew_possible').val(scoreable);
		if(!isNaN(quality_score_percent)){
			$('#bucnew_overall_score').val(quality_score_percent+'%');
		}else {
		$('#bucnew_overall_score').val(100.00+'%');	
		}
        
		total_score = (100-scoreable2);
		if(!isNaN(total_score)){
		$('#bucnew_total_score').val(total_score);
	    }else{
	    $('#bucnew_total_score').val(100);	
	    }

	} 
	$(document).on('change','.bucnew_points',function(){ 
		bucnew_calc();
    });
	bucnew_calc();
</script>

<!--============================== BUc New End======================= -->
<!--============================== Stratus Start======================= -->
<script type="text/javascript">
	function stratus_calc(){
		
		var score = 0;
		var scoreable = 0; 
		var quality_score_percent = 0;
		
		$('.stratus_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('stratus_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('stratus_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('stratus_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#stratus_earned').val(score);
		$('#stratus_possible').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#stratus_overall_score').val(quality_score_percent+'%');
		}
		//Autofail
		
		if($('#stratusAF1').val()=='Yes'){
			$('#stratus_overall_score').val(0);
			$('#stratusAF1').css('color','red');
		}else{
			$('#stratus_overall_score').val(quality_score_percent+'%');
			$('#stratusAF1').css('color','green');
		}
		
	}
	
		
	

			
$(document).on('change','.stratus_point',function(){ 
		stratus_calc();
    });
	stratus_calc();

</script>
<!-- ===================================Stratus End===================== -->

<!--============================== Netmeds Start======================= -->
<script type="text/javascript">
	function netmeds_calc(){
		var score = 0;
		
		$('.netmeds_point').each(function(index,element){
			var weightage = parseFloat($(element).children("option:selected").attr('netmeds_val'));
			score = score + weightage;
		});
	   
		if(!isNaN(score)){
			$("#netmeds_overall_score").val(score);
		}

		
	//////Netmeds///////
		if($('#netmedsAF1').val()=='Fatal' || $('#netmedsAF2').val()=='Fatal' || $('#netmedsAF3').val()=='Fatal' || 
			$('#netmedsAF4').val()=='Fatal' || $('#netmedsAF5').val()=='Fatal' || $('#netmedsAF6').val()=='Fatal' || 
			$('#netmedsAF7').val()=='Fatal'){
			$('.netmedsFatal').val(0);
		}else{
			$('.netmedsFatal').val(score+'%');
		}
	}
	
	$(document).on('change','.netmeds_point',function(){ 
		netmeds_calc();
    });
	netmeds_calc();
</script>
<!-- =====================================Netmeds End============================ -->
<script>

	/* function loanxm_calc(){
		
		var score = 0;
		var scoreable = 0; 
		var quality_score_percent = 0;
		
		$('.loanxm_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('care_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('care_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('care_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#fb_earnedScore').val(score);
		$('#fb_possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#buc_overall_score').val(quality_score_percent+'%');
		}

	} */
</script>


<script type="text/javascript">
///////////////// LOANXM ///////////////////////
	function loanxm_calc(){
		var score = 0;
		$('.loanxm_point').each(function(index,element){
			var weightage = parseFloat($(element).children("option:selected").attr('loanxm_val'));
			score = score + weightage;
		});
		
		if(!isNaN(score)){
			$('#loanxmOverallScore').val(score+'%');
		}
		
		if($('#loanxmAF1').val()=='No' || $('#loanxmAF2').val()=='No'){
			$('.loanxmFatal').val(0);
			$('#loanxm_passfail').val('Fail').css('color','Red');
		}else{
			$('.loanxmFatal').val(score+'%');
			
			if(score>=85){
				$('#loanxm_passfail').val('Pass').css('color','Green');
			}else{
				$('#loanxm_passfail').val('Fail').css('color','Red');
			}
		}
		
		
		
	}

/////////////////////////////////////////////////////////////////////

	$(document).on('change','.loanxm_point',function(){ 
		loanxm_calc(); 
	});
	loanxm_calc();	

	
</script>


<script>
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#booking_date").datepicker();
	$("#video_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#go_live_date").datepicker();
	
	
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
