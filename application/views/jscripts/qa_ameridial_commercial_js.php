  
<script>
////////////////////// Ameridial - SAS,5-11 Tectical ////////////////////
	function overall_calc(){
		
	////////Overall//////////
		var score = 0;
		var scoreable = 0;
		var totScore = 0;
		
		$('.ameridial').each(function(index,element){
			var score_type1 = $(element).val();
            if(score_type1 =='Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}else if(score_type1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}else if(score_type1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}
		});
		totScore = ((score*100)/scoreable).toFixed(2);
		
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
        if(!isNaN(totScore)){
			$('#overallScore').val(totScore+'%');
		}
	////////Customer Critical//////////
		var custScore = 0;
		var custScoreable = 0;
		var custTotScore = 0;

		$('.customer').each(function(index,element){
			var score_type2 = $(element).val();
            if(score_type2 =='Yes'){
				var cw1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var cw2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				custScore = custScore + cw1;
				custScoreable = custScoreable + cw2;
			}else if(score_type2 == 'No'){
				var cw1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var cw2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				custScore = custScore + cw1;
				custScoreable = custScoreable + cw2;
			}else if(score_type2 == 'N/A'){
				var cw1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var cw2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				custScore = custScore + cw1;
				custScoreable = custScoreable + cw2;
			}
		});
		custTotScore = ((custScore*100)/custScoreable).toFixed(2);
		
		$('#custEarn').val(custScore);
		$('#custPossible').val(custScoreable);
        if(!isNaN(custTotScore)){
			$('#custScore').val(custTotScore+'%');
		}
	////////Business Critical//////////
		var bussScore = 0;
		var bussScoreable = 0;
		var bussTotScore = 0;

		$('.business').each(function(index,element){
			var score_type3 = $(element).val();
            if(score_type3 =='Yes'){
				var bw1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var bw2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				bussScore = bussScore + bw1;
				bussScoreable = bussScoreable + bw2;
			}else if(score_type3 == 'No'){
				var bw1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var bw2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				bussScore = bussScore + bw1;
				bussScoreable = bussScoreable + bw2;
			}else if(score_type3 == 'N/A'){
				var bw1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var bw2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				bussScore = bussScore + bw1;
				bussScoreable = bussScoreable + bw2;
			}
		});
		bussTotScore = ((bussScore*100)/bussScoreable).toFixed(2);
		
		$('#bussEarn').val(bussScore);
		$('#bussPossible').val(bussScoreable);
        if(!isNaN(bussTotScore)){
			$('#bussScore').val(bussTotScore+'%');
		}
	////////Compliance Critical//////////
		var compScore = 0;
		var compScoreable = 0;
		var compTotScore = 0;

		$('.compliance1').each(function(index,element){
			var score_type4 = $(element).val();
            if(score_type4 =='Yes'){
				var cow1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var cow2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				compScore = compScore + cow1;
				compScoreable = compScoreable + cow2;
			}else if(score_type4 == 'No'){
				var cow1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var cow2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				compScore = compScore + cow1;
				compScoreable = compScoreable + cow2;
			}else if(score_type4 == 'N/A'){
				var cow1 = parseFloat($(element).children("option:selected").attr('amd_val'));
				var cow2 = parseFloat($(element).children("option:selected").attr('amd_max'));
				compScore = compScore + cow1;
				compScoreable = compScoreable + cow2;
			}
		});
		compTotScore = ((compScore*100)/compScoreable).toFixed(2);
		
		$('#compEarn').val(compScore);
		$('#compPossible').val(compScoreable);
        if(!isNaN(compTotScore)){
			$('#compScore').val(compTotScore+'%');
		}

    ////////5-11 Tectical Fatal/////////
		if($('#tecticalAF1').val()=='No' || $('#tecticalAF2').val()=='Yes' || $('#tecticalAF3').val()=='Yes'){
		    $('.tecticalFatal').val(0+'%');
		}else{
			$('.tecticalFatal').val(totScore+'%');
		}
	////////SAS/////////
		if($('#sasAF1').val()=='Yes' || $('#sasAF2').val()=='Yes' || $('#sasAF3').val()=='Yes' || $('#sasAF4').val()=='Yes'){
		    $('.sasFatal').val(0+'%');
		}else{
			$('.sasFatal').val(totScore+'%');
		}

		 
	}

	
	$(document).ready(function(){
		$(document).on('change','.ameridial',function(){ overall_calc(); });
		$(document).on('change','.customer',function(){ overall_calc(); });
		$(document).on('change','.business',function(){ overall_calc(); });
		$(document).on('change','.compliance1',function(){ overall_calc(); });
		overall_calc();
	});
	 
</script>

<script>
$(document).ready(function(){

	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#agent_id").select2();

///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	if($("#audit_type").val() == "Calibration"){
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	
	$('#audit_type').on('change', function(){
		
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').val("")
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




