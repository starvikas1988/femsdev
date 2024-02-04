n<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#sale_date").datepicker();
	$("#shift_date").datepicker();
	$('#call_duration').timepicker({ timeFormat: 'HH:mm:ss' });
	$('#call_time').timepicker({ timeFormat: 'HH:mm:ss' });
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
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#shift_date").datepicker();
	$("#sale_date").datepicker();
	$('#call_duration').timepicker({ timeFormat: 'HH:mm:ss' });
	$('#call_time').timepicker({ timeFormat: 'HH:mm:ss' });
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
			
			if(score_type == 'Yes'){
				var weightage = parseInt($(element).children("option:selected").attr('flex_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
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
 </script>n<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#sale_date").datepicker();
	$('#call_duration').timepicker({ timeFormat: 'HH:mm:ss' });
	$('#call_time').timepicker({ timeFormat: 'HH:mm:ss' });
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
			
			if(score_type1 == 'Pass'){
				var weightage1 = parseInt($(element).children("option:selected").attr('flex_val'));
				compliancescore1 = compliancescore1 + weightage1;
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if(score_type1 == 'Fail'){
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
			
			if(score_type2 == 'Pass'){
				var weightage2 = parseInt($(element).children("option:selected").attr('flex_val'));
				customerscore1 = customerscore1 + weightage2;
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if(score_type2 == 'Fail'){
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
			
			if(score_type3 == 'Pass'){
				var weightage3 = parseInt($(element).children("option:selected").attr('flex_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if(score_type3 == 'Fail'){
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