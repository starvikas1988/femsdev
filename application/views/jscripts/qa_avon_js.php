<!-- AVON SCRIPT -->
<!-- Score Counter Script-->
<script type = "text/javascript">
   <!--
      // Form validation code will come here.
      function validate() {
      
         if( document.form_new_user.from_date.value == "" ) {
            alert( "Please provide From Date!" );
            document.form_new_user.from_date.focus() ;
            return false;
         }
         if( document.form_new_user.to_date.value == "" ) {
            alert( "Please provide To Date!" );
            document.form_new_user.to_date.focus() ;
            return false;
         }
         if( document.form_new_user.campaign.value == "" ) {
            alert( "Please provide LOB!" );
            document.form_new_user.campaign.focus() ;
            return false;
         }

         return( true );
      }
   //-->
</script>

<script>
	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date() });
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });

	 $(function () {
		$('input[type=file]').change(function () {
			var val = $(this).val().toLowerCase(),
				//regex = new RegExp("(.*?)\.(mp3|avi|mp4|wmv|wav)$");
				regex = new RegExp("(.*?)\.(avi|mp4|3gp|mpeg|mpg|mov|mp3|flv|wmv|mkv|wav)$");
				

			if (!(regex.test(val))) {
				$(this).val('');
				alert('This is not an allowed file type. Please upload correct file format');
				return false;
			}
		});
	});

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
			 $(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
			 $(':input[type="submit"]').prop('disabled', true);
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			 $(':input[type="submit"]').prop('disabled', false);
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
			 $(':input[type="submit"]').prop('disabled', true);
			
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			 $(':input[type="submit"]').prop('disabled', false);
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
<!-- <script type="text/javascript">
	//////////////////////Kenny-U-Pull////////////////////////////
	
	function kenny_u_pull_calc(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.kennyVal').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var weightage = parseFloat($(element).children("option:selected").attr('kenny_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#kennyEarnedScore').val(score);   
		$('#kennyPossibleScore').val(scoreable);

		// if(!isNaN(quality_score_percent)){
		// 	$('#sensioOverallScore').val(quality_score_percent+'%');
		// }

		if(($('#kenny_AF1').val()=='Yes') || $('#kenny_AF2').val()=='Yes' || $('#file_opening').val()=='No'){
		$('#kennyOverallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#kennyOverallScore').val(quality_score_percent+'%');
			}	
		}

		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);
		

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('kenny_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custSenEarned').text(customerScore);
		$('#custSenPossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		// if(!isNaN(customerPercentage)){
		// 	$('#custSenScore').val(customerPercentage+'%');
		// }
		if(($('#kenny_AF1').val()=='Yes') || $('#kenny_AF2').val()=='Yes' || $('#file_opening').val()=='No'){
		$('#custSenScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#custSenScore').val(quality_score_percent+'%');
			}	
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('kenny_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('kenny_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('kenny_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busiSenEarned').text(businessScore);
		$('#busiSenPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiSenScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('kenny_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('kenny_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('kenny_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complSenEarned').text(complianceScore);
		$('#complSenPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complSenScore').val(compliancePercentage+'%');
		}
	}


	/////////////////////////////////////////////////

	
	////////////////// Kenny-U-Pull /////////////////////
	$(document).on('change','.kennyVal',function(){ 
		kenny_u_pull_calc(); 
	});
	kenny_u_pull_calc();	
</script> -->
<script type="text/javascript">
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
</script>
<script type="text/javascript">
	
	$('#tl_id').on('click', function(){
		alert("Can not Change TL");
		$("#tl_id").attr('disabled','disabled');
		return false;
	});
</script>
<script type="text/javascript">
	function avon_calc(){
		var check_fatal=false;
			$(".avon_point").each(function(){
				if($(this).hasClass("avon_fatal") && ($(this).val()=="Fail") ){
					check_fatal=true;
					$("#avon_overall_score").val("0.00%");
				}
			});
			if(!check_fatal){
				//var earned_score = 0, possible_score=0, overall_score="";
				var earned_score = 0, possible_score=0, overall_score="", cust_earned=0, cust_possible=0, cust_overall=0;
			    var comp_earned=0, comp_possible=0, comp_overall=0, business_earned=0, business_possible=0, business_overall=0;
				$(".avon_point").each(function(index, element){
					if($(element).val()!="N/A" && $(element).val()!=""){
						var earned_weightage = parseFloat($(element).children("option:selected").attr('avon_val'));
						earned_score += earned_weightage;
						var weightage = parseFloat($(element).children("[value='Pass']").attr('avon_val'));
						possible_score += weightage;
						overall_score=parseFloat((earned_score/possible_score)*100);
						
						if($(this).hasClass("customer")){
							cust_earned+=earned_weightage;
							cust_possible+=weightage;
							console.log(cust_earned);
							$("#customer_earned_score").val(cust_earned);
							$("#customer_possible_score").val(cust_possible);
							$("#customer_overall_score").val(parseFloat((cust_earned/cust_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("compliance")){
							comp_earned+=earned_weightage;
							comp_possible+=weightage;
							console.log(comp_earned);
							$("#compliance_earned_score").val(comp_earned);
							$("#compliance_possible_score").val(comp_possible);
							$("#compliance_overall_score").val(parseFloat((comp_earned/comp_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("business")){
							business_earned+=earned_weightage;
							business_possible+=weightage;
							console.log(business_earned);
							$("#business_earned_score").val(business_earned);
							$("#business_possible_score").val(business_possible);
							$("#business_overall_score").val(parseFloat((business_earned/business_possible)*100).toFixed(2)+"%");
						}

						$("#avon_overall_score").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
						
					}
				});
			}
			if(!isNaN(earned_score)){
				$("#avon_earned_score").val(earned_score);
			}
			if(!isNaN(possible_score)){
				$("#avon_possible_score").val(possible_score);
			}
	}
</script>
<script type="text/javascript">
	$(document).on("change", ".avon_point", function(){
			avon_calc();
	});
	avon_calc();

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
				for (var i in json_obj){
					if($('#tl_name').val(json_obj[i].tl_name)!=''){
						$('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				} 
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

</script>
<script>
	//$( "#datepicker" ).datepicker({ minDate: 0});
//Edited By Samrat 30/9/21
	$(document).ready(function(){
		$("#from_date, #to_date, #call_date").datepicker();
		$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
		<?php if($this->uri->segment(2)=="qa_avon" && $this->uri->segment(4)=="0"){?>
			$("#avon_earned_score, #avon_possible_score").val("0");
		<?php }?>
		
		// $( "#agent_id" ).on('change' , function() {
		// 	var aid = this.value;
		// 	if(aid=="") alert("Please Select Agent")
		// 	var URL='<?php echo base_url();?>qa_avon/getTLname';
		// 	$('#sktPleaseWait').modal('show');
		// 	$.ajax({
		// 		type: 'POST',
		// 		url:URL,
		// 		data:'aid='+aid,
		// 		success: function(aList){
		// 			var json_obj = $.parseJSON(aList);
		// 			console.log(json_obj);
		// 			$('#tl_name').empty();
		// 			$('#tl_name').append($('#tl_name').val(''));
		// 			//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
		// 			for (var i in json_obj){
		// 				$('#tl_id').val(json_obj[i].assigned_to);//$('#tl_id').append();
		// 				$('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
		// 				$('#campaign').append($('#campaign').val(json_obj[i].process_name));
		// 				$('#office_id').append($('#office_id').val(json_obj[i].office_id));
		// 			}
		// 			$('#sktPleaseWait').modal('hide');
		// 		},
		// 		error: function(){
		// 			alert('Fail!');
		// 		}
		// });
	});
</script>

<!-- Associate Materials Script
Edited By Samrat 9/11/21 -->
<script>
	$(document).ready(function(){
		$(document).on("change", ".associate_mat_value", function(){
			var check_fatal=false;
			$(".associate_mat_value").each(function(){
				if($(this).hasClass("associateFatal") && $(this).val()=="No"){
					check_fatal=true;
					$("#overall_score").val("0.00%");
				}
			});
			var earned_score = 0, possible_score=0, overall_score="", cust_earned=0, cust_possible=0, cust_overall=0;
			var comp_earned=0, comp_possible=0, comp_overall=0, business_earned=0, business_possible=0, business_overall=0;
			$(".associate_mat_value").each(function(index, element){
				if($(element).val()!="N/A" && $(element).val()!=""){
					var earned_weightage = parseFloat($(element).children("option:selected").attr('assoc_mat'));
					earned_score += earned_weightage;
					var weightage = parseFloat($(element).children("[value='Yes']").attr('assoc_mat'));
					possible_score += weightage;
					overall_score=parseFloat((earned_score/possible_score)*100);
					if($(this).hasClass("customer")){
						cust_earned+=earned_weightage;
						cust_possible+=weightage;
						$("#customer_earned_score").val(cust_earned);
						$("#customer_possible_score").val(cust_possible);
						$("#customer_overall_score").val(parseFloat((cust_earned/cust_possible)*100).toFixed(2)+"%");
					}
					if($(this).hasClass("compliance")){
						comp_earned+=earned_weightage;
						comp_possible+=weightage;
						$("#compliance_earned_score").val(comp_earned);
						$("#compliance_possible_score").val(comp_possible);
						$("#compliance_overall_score").val(parseFloat((comp_earned/comp_possible)*100).toFixed(2)+"%");
					}
					if($(this).hasClass("business")){
						business_earned+=earned_weightage;
						business_possible+=weightage;
						$("#business_earned_score").val(business_earned);
						$("#business_possible_score").val(business_possible);
						$("#business_overall_score").val(parseFloat((business_earned/business_possible)*100).toFixed(2)+"%");
					}
					if(!check_fatal){
						$("#overall_score").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
					}
				}
				if(!isNaN(earned_score)){
					$("#earned_score").val(earned_score);
				}
				if(!isNaN(possible_score)){
					$("#possible_score").val(possible_score);
				}
			});
		});
	});
</script>

<!-- BCCI Script -->
<script>
	$(document).ready(function(){
		$(document).on("change", ".bcci_param", function(){
			var counter=0, yes_counter=0, bcci_fatal=false;
			$(".bcci_param").each(function(){
				if($(this).hasClass("bcci_fatal")){
					if($(this).val()==2){
						bcci_fatal=true;
					}else{
						if($(this).val()==1 || $(this).val()==2){
							++counter;
						}
						if($(this).val()==1){
							++yes_counter;
						}
					}
				}else{
					if($(this).val()==1 || $(this).val()==2){
						++counter;
					}
					if($(this).val()==1){
						++yes_counter;
					}
				}
			});
			if(bcci_fatal){
				$("#call_qa_score").val(parseFloat(0*100).toFixed(2)+"%");
			}else{
				$("#call_qa_score").val(parseFloat((yes_counter/counter)*100).toFixed(2)+"%");
			}
		});
	});
</script>

<!-- SA OB Script -->
<script>
////////////////////// telaidsaob ////////////////////
	$(document).ready(function(){
		$(document).on("change", ".sa_ob_param", function(){
			var value=$(this).children("option:selected").attr("sa_value");
			var score_earned=0, counter=0;

			$(".sa_ob_param").each(function(){
				if($(this).val()==1){
					++counter;
					++score_earned;
					$(this).closest("tr").find(".score").val($(this).children("option:selected").attr("sa_value"));
					$(this).closest("tr").find(".available").show();
				}else if($(this).val()==2){
					++counter;
					$(this).closest("tr").find(".score").val("0");
					$(this).closest("tr").find(".available").show();
				}else{
					$(this).closest("tr").find(".score").val("");
					$(this).closest("tr").find(".available").hide();
				}
			});
			
			$("#qa_score").val(parseFloat((score_earned/counter)*100).toFixed(2)+"%");
			
		});

		//Display points if scores already selected.
		$(".sa_ob_param").each(function(){
			if($(this).val()!="" && $(this).val()!="3"){
				$(this).closest("tr").find(".score").val($(this).children("option:selected").attr("sa_value"));
			}
		});
	});
</script>

<!-- QA Ameridial Empire -->
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on("change", ".amd_point", function(){
			var earnedScore=0, possibleScore=0, overallScore="";
			$(".amd_point").each(function(){
				if($(this).val()!="N/A" && $(this).val()!=""){
					var score = $(this).children("option:selected").attr("amd_val");
					earnedScore+=parseInt(score);
					possibleScore+=5;
				}else{
					earnedScore+=0;
					possibleScore+=0;
				}
			});
			$("#emp_earnedScore").val(earnedScore);
			$("#emp_possibleScore").val(possibleScore);
			$("#emp_overallScore").val(parseFloat((earnedScore/possibleScore)*100).toFixed(2)+"%");
		});
	});
</script>


<script>

		function empire_score(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.empire_points').each(function(index,element){

			var score_type = $(element).val();
			// var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
			// var w2 = parseInt($(element).children("option:selected").attr('amd_max'));
			// 		score = score + w1;
			// 		scoreable = scoreable + w2;	
			
			if (score_type == 1 ){
					var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
					var w2 = parseInt($(element).children("option:selected").attr('amd_max'));
					score = score + w1;
					scoreable = scoreable + w2;
				} else if (score_type == 3) {
					var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
					var w2 = parseInt($(element).children("option:selected").attr('amd_max'));
					score = score + w1;
					scoreable = scoreable + w2;
				} else if (score_type == 5) {
					var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
					var w2 = parseInt($(element).children("option:selected").attr('amd_max'));
					score = score + w1;
					scoreable = scoreable + w2;
				} else if (score_type == 'N/A') {
					var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
					var w2 = parseInt($(element).children("option:selected").attr('amd_max'));
					score = score + w1;
					scoreable = scoreable + w1;
				}
		});

				quality_score_percent = ((score*100)/scoreable).toFixed(2);

				$('#empire_earn_score').val(score);
				$('#empire_possible_score').val(scoreable);

				if(!isNaN(quality_score_percent)){
					$('#empire_overall_score').val(quality_score_percent+'%');
				}

				// if($('#condtAF1').val()=='No' || $('#condtAF2').val()=='Yes' || $('#condtAF3').val()=='No' || $('#condtAF4').val()=='No' || $('#condtAF5').val()=='NO' || $('#condtAF6').val()=='No' || $('#condtAF7').val()=='No' || $('#condtAF8').val()=='No'){
				// 	$('.conduentFatal').val(0);
				// }else{
				// 	$('.conduentFatal').val(quality_score_percent+'%');
				// }



			}


		$(document).ready(function(){
		$(document).on('change','.empire_points',function(){ empire_score(); });
		empire_score();
});

</script>
