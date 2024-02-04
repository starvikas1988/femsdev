<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#audit_date").datepicker();
	$("#date_of_evaluation").datepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
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
	
	
	var getTLname = function(aid){
		var URL='<?php echo base_url();?>Qa_novasom/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	}
	$("#agent_id").on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		else{getTLname(aid);}
	});	
	if($("#agent_id").val()!="") getTLname($("#agent_id").val());

/////////////////Novasom//////////////////
	$(".points").on("change",function(){
		var val	=	0;
		var psVal = 0;
		$(".points").each(function(){
			if(isNaN(parseInt($(this).val())))
			{
				val	+= 0;
			}
			else
			{
				val +=	parseInt($(this).val());
				psVal +=	parseInt($(this).data("ps"));
			}
		});
		$("#earned_score").val(val);
		$("#possible_score").val(psVal);
		var percentage	=	(val/psVal)*100;
		$("#overall_score").val(percentage.toFixed(2));
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
	
});
 </script>
 
 <script>
	function bioserenity_calculation(){
		var score = 0;
		var customerscore = 0;
		var businessscore = 0;
		var compliancescore = 0;
		var scoreable = 0;
		var customerscoreable = 0;
		var businessscoreable = 0;
		var compliancescoreable = 0;
		var quality_score_percent = 0;
		var customer_score_percent = 0;
		var business_score_percent = 0;
		var compliance_score_percent = 0;
		
		$('.bio_points').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('bio_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('bio_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('bio_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#bio_earnedScore').val(score);
		$('#bio_possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#bio_overallScore').val(quality_score_percent+'%');
		}
		
		if(quality_score_percent<90){
			$("#bioPassFail").val("Fail").css("background-color","#EC7063");
		}else{
			$("#bioPassFail").val("Pass").css("background-color","#A3E4D7");
		}
	//////////
		if($('#bio_fatal1').val()=='No' || $('#bio_fatal2').val()=='No'){
			$('.bioserenityAF').val(0);
		}else{
			$('.bioserenityAF').val(quality_score_percent+'%');
		}
		
	/////////// Customer ////////////////////
		$('.customer').each(function(index,element){
			var score_type1 = $(element).val();
			
			if(score_type1 == 'Yes'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('bio_val'));
				customerscore = customerscore + weightage1;
				customerscoreable = customerscoreable + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('bio_val'));
				customerscoreable = customerscoreable + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('bio_val'));
				customerscore = customerscore + weightage1;
				customerscoreable = customerscoreable + weightage1;
			}
		});
		customer_score_percent = ((customerscore*100)/customerscoreable).toFixed(2);
		
		$('#customerErnd').val(customerscore);
		$('#customerPsbl').val(customerscoreable);
		$('#customerTotal').val(customer_score_percent+'%');
	/////////// Business ////////////////////
		$('.business').each(function(index,element){
			var score_type2 = $(element).val();
			
			if(score_type2 == 'Yes'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('bio_val'));
				businessscore = businessscore + weightage2;
				businessscoreable = businessscoreable + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('bio_val'));
				businessscoreable = businessscoreable + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('bio_val'));
				businessscore = businessscore + weightage2;
				businessscoreable = businessscoreable + weightage2;
			}
		});
		business_score_percent = ((businessscore*100)/businessscoreable).toFixed(2);
		
		$('#businessErnd').val(businessscore);
		$('#businessPsbl').val(businessscoreable);
		$('#businessTotal').val(business_score_percent+'%');
	/////////// Compliance ////////////////////
		$('.compliance').each(function(index,element){
			var score_type3 = $(element).val();
			
			if(score_type3 == 'Yes'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('bio_val'));
				compliancescore = compliancescore + weightage3;
				compliancescoreable = compliancescoreable + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('bio_val'));
				compliancescoreable = compliancescoreable + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('bio_val'));
				compliancescore = compliancescore + weightage3;
				compliancescoreable = compliancescoreable + weightage3;
			}
		});
		compliance_score_percent = ((compliancescore*100)/compliancescoreable).toFixed(2);
		
		$('#complianceErnd').val(compliancescore);
		$('#compliancePsbl').val(compliancescoreable);
		$('#complianceTotal').val(compliance_score_percent+'%');
		
	}
	
	$(document).ready(function(){
		$(document).on('change','.bio_points',function(){
			bioserenity_calculation();
		});
		
		$(document).on('change','.customer',function(){
			bioserenity_calculation();
		});
		$(document).on('change','.business',function(){
			bioserenity_calculation();
		});
		$(document).on('change','.compliance',function(){
			bioserenity_calculation();
		});
		bioserenity_calculation();
	});
 </script>