<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_date_time").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	$(".agentName").select2();
	
///////////////////// SOP Library ////////////////////////////
	$(".addSOPLibrary").click(function(){
		$("#addSOPLibraryModel").modal('show');
	});
	
	$('#docu_upl').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'doc':
			case 'docx':
			case 'xls':
			case 'xlsx':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
/////////////////////////////////////////////////////////////	
	
	
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
});
</script>

<script type="text/javascript">
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function(){
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_metropolis/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
</script>

<script>

$( "#client_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Client ID")
		var URL='<?php echo base_url();?>Qa_agent_coaching/get_client';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){ 
				var json_obj = $.parseJSON(aList); 
				
					 $('#agent_id_process').empty();
				     $('#agent_id_process').append("<option value=''>--Select--</option>"); 
				for(i=0; i < json_obj.length;i++){
					 var newoption = '<option value='+ json_obj[i].id +'>'+ json_obj[i].name+' - '+json_obj[i].office_id +'</option>';
					 $('#agent_id_process').append(newoption);
				}
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		});
	});

	
	$( "#agent_id_process" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_metropolis/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#process_id').append($('#process_id').val(json_obj[i].process_id));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
</script>

<script>
////////////////////// Pre Booking ////////////////////
function do_pre_booking(){
	
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
		
		$('.pre_booking_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = Math.round(((score*100)/scoreable));
		
		$('#pre_earnedScore').val(score);
		$('#pre_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#pre_overallScore').val(quality_score_percent+'%');
		}

          // For Fatal
		if($('.all_fatal1').val()=='No' || $('.all_fatal2').val()=='No' || $('.all_fatal3').val()=='No' || $('.all_fatal4').val()=='No' || $('.all_fatal5').val()=='No' || $('.all_fatal6').val()=='No' || $('.all_fatal7').val()=='No' || $('.all_fatal8').val()=='No' || $('.all_fatal9').val()=='No'){
		    $('#pre_overallScore').val(0+'%');
		  }else{
			$('#pre_overallScore').val(quality_score_percent+'%');
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
 	 do_pre_booking();
     $(document).on('change','.pre_booking_point',function(){
		do_pre_booking();
	});
     

</script>


<script>
$(document).ready(function(){
	
	$('.audioFile').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'wav':
			case 'wmv':
			case 'mp3':
			case 'mp4':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
	
});	
</script>