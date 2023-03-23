
<script>
/*--------- Audit Sheet Calculation [AT&T NEW] 06/07/2022 -----------*/
	function att_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.att_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes' || score_type == 'Effective' || score_type == 'All key words used'){
				var weightage = parseInt($(element).children("option:selected").attr('att_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No' || score_type == 'Not effective' || score_type == 'NE-Reach you by phone' || score_type == 'NE-Reach you by text' || score_type == 'NE-With information' || score_type == 'NE-About your AT&T services' || score_type == 'NE-Multiple'){
				var weightage = parseInt($(element).children("option:selected").attr('att_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('att_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = parseFloat((score*100)/scoreable).toFixed(2);

		$('#attEarned').val(score);
		$('#attPossible').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#attOverall').val(quality_score_percent+'%');
		}

	////////////////////
		/* if($('#attAF1').val()=='Not effective' || ($('#attAF2').val()=='NE-Reach you by phone' || $('#attAF2').val()=='NE-Reach you by text' || $('#attAF2').val()=='NE-With information' || $('#attAF2').val()=='NE-About your AT&T services' || $('#attAF2').val()=='NE-Multiple') || $('#attAF3').val()=='Not effective' || $('#attAF4').val()=='Not effective' || $('#attAF5').val()=='Not effective'){
			$('.attFatal').val(0);
		}else{
			$('.attFatal').val(quality_score_percent+'%');
		} */

	}

	$(document).on('change','.att_point',function(){
		att_calc();
	});
	att_calc();

	/*--------- Audit Sheet Calculation [ACC] 03/11/2022 -----------*/
	function acc_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.acc_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseInt($(element).children("option:selected").attr('acc_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Pass'){
				var weightage = parseInt($(element).children("option:selected").attr('acc_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseInt($(element).children("option:selected").attr('acc_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'Fail'){
				var weightage = parseInt($(element).children("option:selected").attr('acc_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseInt($(element).children("option:selected").attr('acc_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = parseFloat((score*100)/scoreable).toFixed(2);

		$('#accEarned').val(score);
		$('#accPossible').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#accOverall').val(quality_score_percent+'%');
		}

	////////////////////
	if ($('.infrac').val() == 'Yes') {
        $('#accOverall').val(0);
    } else {
        $('#accOverall').val(quality_score_percent + '%');

    }


	if($('#acc_fail').val()=='Fail'){
			$('.accOverall_fatal').val(0.00+'%');
		}else{
			$('.accOverall_fatal').val(quality_score_percent+'%');
		}

	}

	$(document).on('change','.acc_point',function(){
		acc_calc();
	});
	acc_calc();


 $("#from_dates").datepicker();
 $("#to_dates").datepicker();

 $("#from_datesacg").datepicker({maxDate: new Date() });
 $("#to_datesacg").datepicker({maxDate: new Date() });

 $("#from_date").datepicker({maxDate: new Date() });
 $("#to_date").datepicker({maxDate: new Date() });


	function date_validation_acg(val,type){
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		if(type=='E'){
		var start_date=$("#from_datesacg").val();
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
			var end_date=$("#to_datesacg").val();
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



<script>
/*--------- Audit Sheet Calculation [AT&T Compliance] 14/07/2022 -----------*/
	function att_compliance_calc(){
		var score = 0;
		$('.attCompliance').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				score = 100;
			}else if(score_type=='Yes'){
				score = 0;
			}
		});

		if($('#attCompAF1').val()=='Yes' || $('#attCompAF2').val()=='Yes' || $('#attCompAF3').val()=='Yes' || $('#attCompAF4').val()=='Yes' || $('#attCompAF5').val()=='Yes' || $('#attCompAF6').val()=='Yes' || $('#attCompAF7').val()=='Yes' || $('#attCompAF8').val()=='Yes' || $('#attCompAF9').val()=='Yes' || $('#attCompAF10').val()=='Yes' || $('#attCompAF11').val()=='Yes' || $('#attCompAF12').val()=='Yes' || $('#attCompAF13').val()=='Yes' || $('#attCompAF14').val()=='Yes' || $('#attCompAF15').val()=='Yes' || $('#attCompAF16').val()=='Yes' || $('#attCompAF17').val()=='Yes' || $('#attCompAF18').val()=='Yes' || $('#attCompAF19').val()=='Yes' || $('#attCompAF20').val()=='Yes' || $('#attCompAF21').val()=='Yes' || $('#attCompAF22').val()=='Yes' || $('#attCompAF23').val()=='Yes' || $('#attCompAF24').val()=='Yes'){
			$('#attComplianceOverall').val(0);
		}else{
			$('#attComplianceOverall').val(score+'%');
		}

	}

	$(document).on('change','.attCompliance',function(){
		att_compliance_calc();
	});
	att_compliance_calc();
</script>


<script>
////////////////////// Affinity ////////////////////
function do_affinity(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		var score2 = 0;
		var scoreable2 = 0;
		var quality_score_percent2 = 0;
		var score3 = 0;
		var scoreable3 = 0;
		var quality_score_percent3 = 0;
		var score4 = 0;
		var scoreable4 = 0;
		var quality_score_percent4 = 0;
		var score5 = 0;
		var scoreable5 = 0;
		var quality_score_percent5 = 0;

		// $('.affinity_point').each(function(index,element){
		// 	var score_type = $(element).val();
  //           if(score_type =='Yes'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
		// 		score = score + weightage;
		// 		scoreable = scoreable + weightage;
		// 	}else if(score_type == 'No'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
		// 		scoreable = scoreable + weightage;
		// 	}else if(score_type == 'Partial'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
		// 		scoreable = scoreable + weightage;
		// 	}else if(score_type == 'NA'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
		// 		score = score + weightage;
		// 		scoreable = scoreable + weightage;
		// 	}
		// });


			$('.affinity_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
			    var max_wght = parseFloat($(element).children("option:selected").attr('affinity_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('affinity_max_val'));
				score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Partial'){
			    var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('affinity_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'NA'){max_wght
			    var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('affinity_max_val'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}
		});

		// quality_score_percent = Math.round(((score*100)/scoreable));
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#att_earnedScore').val(score);
		$('#att_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#att_overallScore').val(quality_score_percent+'%');
		}



          // For Fatal
		if($('.all_fatal1').val()=='No' || $('.all_fatal2').val()=='No' || $('.all_fatal3').val()=='No' || $('.all_fatal4').val()=='No' || $('.all_fatal5').val()=='No' || $('.all_fatal6').val()=='No' || $('.all_fatal7').val()=='No' || $('.all_fatal8').val()=='No' || $('.all_fatal9').val()=='No'){
		    $('#pre_overallScore').val(0.00+'%');
		  }else{
			$('#pre_overallScore').val(quality_score_percent+'%');
		  }

		  if($('#air_email_af1').val()=='No' || $('#air_email_af2').val()=='No' || $('#air_email_af3').val()=='No' || $('#air_email_af4').val()=='No'){
			$('.airmethod_email_fatal').val(0.00+'%');
		}else{
			$('.airmethod_email_fatal').val(quality_score_percent+'%');
		}

         // for standardization
		$('.standard').each(function(index,element){
			var score_type1 = $(element).val();

            if(score_type1 =='Yes'){
				var weightage1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'NA'){
				var weightage1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}
		});

		quality_score_percent1 = Math.round(((score1*100)/scoreable1));

		$('#standardization_score').val(score1);
		$('#standardization_rating').val(scoreable1);

		if(!isNaN(quality_score_percent1)){
			$('#standardization').val(quality_score_percent1+'%');
		}

		// for Sales & Pitch
		$('.sales_pitch').each(function(index,element){
			var score_type2 = $(element).val();

            if(score_type2 =='Yes'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score2 = score2 + weightage2;
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type2 == 'NA'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score2 = score2 + weightage2;
				scoreable2 = scoreable2 + weightage2;
			}
		});

		quality_score_percent2 = Math.round(((score2*100)/scoreable2));

		$('#product_earnedScore').val(score2);
		$('#product_possibleScore').val(scoreable2);

		if(!isNaN(quality_score_percent2)){
			$('#product_overallScore').val(quality_score_percent2+'%');
		}

		if($('#pitch_fatal1').val()=='No' || $('#pitch_fatal2').val()=='No' || $('#pitch_fatal3').val()=='No' || $('#pitch_fatal4').val()=='No'){
			$('#product_overallScore').val(0.00+'%');
		}else{
			$('#product_overallScore').val(quality_score_percent2+'%');
		}


		// for communication_soft_skills
		$('.communication').each(function(index,element){
			var score_type3 = $(element).val();

            if(score_type3 =='Yes'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score3 = score3 + weightage3;
				scoreable3 = scoreable3 + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable3 = scoreable3 + weightage3;
			}else if(score_type3 == 'NA'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score3 = score3 + weightage3;
				scoreable3 = scoreable3 + weightage3;
			}
		});

		quality_score_percent3 = Math.round(((score3*100)/scoreable3));
		$('#communication_earnedScore').val(score3);
		$('#communication_possibleScore').val(scoreable3);

		if(!isNaN(quality_score_percent3)){
			$('#communication_overallScore').val(quality_score_percent3+'%');
		}

		// for Critical Error & ZTP
		$('.error_ztp').each(function(index,element){
			var score_type4 = $(element).val();

            if(score_type4 =='Yes'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type4 == 'No'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable4 = scoreable4 + weightage4;
			}else if(score_type4 == 'NA'){
				var weightage4 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score4 = score4 + weightage4;
				scoreable4 = scoreable4 + weightage4;
			}
		});

		quality_score_percent4 = Math.round(((score4*100)/scoreable4));

		$('#critical_earnedScore').val(score4);
		$('#critical_possibleScore').val(scoreable4);

		if(!isNaN(quality_score_percent4)){
			$('#critical_overallScore').val(quality_score_percent4+'%');
		}

		if($('#critical_fatal1').val()=='No' || $('#critical_fatal2').val()=='No' || $('#critical_fatal3').val()=='No' || $('#critical_fatal4').val()=='No'){
			$('#critical_overallScore').val(0.00+'%');
		}else{
			//$('#critical_overallScore').val(quality_score_percent4+'%');
		}

		// for Tagging

		$('.tagging').each(function(index,element){
			var score_type5 = $(element).val();

            if(score_type5 =='Yes'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score5 = score5 + weightage5;
				scoreable5 = scoreable5 + weightage5;
			}else if(score_type5 == 'No'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable5 = scoreable5 + weightage5;
			}else if(score_type5 == 'NA'){
				var weightage5 = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score5 = score5 + weightage5;
				scoreable5 = scoreable5 + weightage5;
			}
		});

		quality_score_percent5 = Math.round(((score5*100)/scoreable5));


		$('#tagging_earnedScore').val(score5);
		$('#tagging_possibleScore').val(scoreable5);

		if(!isNaN(quality_score_percent5)){
			$('#tagging_overallScore').val(quality_score_percent5+'%');
		}

		if($('#tagging_fatal').val()=='No'){
			$('#tagging_overallScore').val(0.00+'%');
		}else{
			//$('#tagging_overallScore').val(quality_score_percent5+'%');
		}




 }

     $(document).on('change','.affinity_point',function(){
		do_affinity();
	});
     do_affinity()

	 	/*--------- Audit Sheet Calculation [AT&T Florida] -----------*/
	function florida_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.attflorida_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Effective' || score_type == 'All Key word Used'){
				var weightage = parseFloat($(element).children("option:selected").attr('attflorida_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Not Effective'){
				var weightage = parseFloat($(element).children("option:selected").attr('attflorida_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('attflorida_val'));
				// score = score + weightage;
				// scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#att_earnedScore').val(score);
		$('#att_possibleScore').val(scoreable);

		if($('#florida1').val()=='Not Effective' || $('#florida2').val()=='Not Effective' || $('#florida3').val()=='Not Effective' || $('#florida4').val()=='Not Effective'){
		$('#att_overallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#att_overallScore').val(quality_score_percent+'%');
			}
		}

	}

	$(document).on('change','.attflorida_point',function(){
		florida_calc();
	});
	florida_calc();


</script>

<script>
	/*--------- Audit Sheet Calculation [AT&T Verint] -----------*/
	function verint_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.attverint_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseInt($(element).children("option:selected").attr('attverint_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseInt($(element).children("option:selected").attr('attverint_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'NA'){
				var weightage = parseInt($(element).children("option:selected").attr('attverint_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = parseFloat((score*100)/scoreable).toFixed(2);

		$('#att_earnedScore').val(score);
		$('#att_possibleScore').val(scoreable);
		//$('#att_overallScore').val(quality_score_percent+'%');

		if($('#verint1').val()=='No' || $('#verint2').val()=='No' || $('#verint3').val()=='No' || $('#verint4').val()=='No'){
		$('#att_overallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#att_overallScore').val(quality_score_percent+'%');
			}
		}

	}

	$(document).on('change','.attverint_point',function(){
		verint_calc();
	});
	verint_calc();
</script>

<script>
$(document).ready(function(){

	$("#audit_date").datepicker();
	$("#call_date" ).datepicker({  maxDate: new Date() });
	$("#contact_date" ).datepicker({  maxDate: new Date() });
	//$("#call_date").datepicker();
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

	///////////////// Infraction - Reason.... ///////////////////////
	$('.reason').hide();

	$('#infraction').on('change', function(){
		if($(this).val()=='Yes'){
			$('.reason').show();
			$('#rsn').attr('required',true);
			$('#rsn').prop('disabled',false);
		}else{
			$('.reason').hide();
			$('#rsn').attr('required',false);
			$('#rsn').prop('disabled',true);
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
