<script>
///////////////// KABBAGE Old /////////////////////
	function kbg_calculation(){
		var procedural_score = 0;
		var procedural_scoreable = 0;
		var procedural_overallscore = 0;
		var compliance_score = 0;
		var compliance_scoreable = 0;
		var compliance_overallscore = 0;
		var customerexp_score = 0;
		var customerexp_scoreable = 0;
		var customerexp_overallscore = 0;
		var kbg_overall_score = 0;

		$('.procedural').each(function(index,element){
			var score_type1 = $(element).val();
			if(score_type1=='True' || score_type1=='N/A'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('procedural_val'));
				procedural_score = procedural_score + weightage1;
				procedural_scoreable = procedural_scoreable + weightage1;
			}else if(score_type1=='False'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('procedural_val'));
				procedural_scoreable = procedural_scoreable + weightage1;
			}
		});
		procedural_overallscore = ((procedural_score*100)/procedural_scoreable).toFixed(2);
		$('#procedural_earned').val(procedural_score);
		$('#procedural_possible').val(procedural_scoreable);
		if(!isNaN(procedural_overallscore)){
			$('#procedural_score').val(procedural_overallscore+'%');
		}
	//////////
		$('.compliance').each(function(index,element){
			var score_type2 = $(element).val();
			if(score_type2=='True' || score_type2=='N/A'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('compliance_val'));
				compliance_score = compliance_score + weightage2;
				compliance_scoreable = compliance_scoreable + weightage2;
			}else if(score_type2=='False'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('compliance_val'));
				compliance_scoreable = compliance_scoreable + weightage2;
			}
		});
		compliance_overallscore = ((compliance_score*100)/compliance_scoreable).toFixed(2);
		$('#compliance_earned').val(compliance_score);
		$('#compliance_possible').val(compliance_scoreable);
		if(!isNaN(compliance_overallscore)){
			$('#compliance_score').val(compliance_overallscore+'%');
		}
	///////////
		$('.customerexp').each(function(index,element){
			var score_type3 = $(element).val();
			if(score_type3=='True' || score_type3=='N/A'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('customerexp_val'));
				customerexp_score = customerexp_score + weightage3;
				customerexp_scoreable = customerexp_scoreable + weightage3;
			}else if(score_type3=='False'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('customerexp_val'));
				customerexp_scoreable = customerexp_scoreable + weightage3;
			}
		});
		customerexp_overallscore = ((customerexp_score*100)/customerexp_scoreable).toFixed(2);
		$('#customerexp_earned').val(customerexp_score);
		$('#customerexp_possible').val(customerexp_scoreable);
		if(!isNaN(customerexp_overallscore)){
			$('#customerexp_score').val(customerexp_overallscore+'%');
		}
	///////////////
		kbg_overall_score = (((procedural_score+compliance_score+customerexp_score)*100)/(procedural_scoreable+compliance_scoreable+customerexp_scoreable)).toFixed(2);
		if(!isNaN(kbg_overall_score)){
			$('#kbgOverallScore').val(kbg_overall_score+'%');
		}

		if($('#kabbageAF').val()=='Yes'){
			$('.kabbage_AF').val(0);
		}else{
			$('.kabbage_AF').val(kbg_overall_score+'%');
		}

	}

//////////////////// KABBAGE New //////////////////////////
	function kabbage_calc(){
		var score = 0;
		var scoreable = 0;
		var connectScore = 0;
		var connectScoreable = 0;
		var connectOverall = 0;
		var resolveScore = 0;
		var resolveScoreable = 0;
		var resolveOverall = 0;
		var madeeasyScore = 0;
		var madeeasyScoreable = 0;
		var madeeasyOverall = 0;
		var kabbage_overall_score = 0;

		$('.connect').each(function(index,element){
			var score_type1 = $(element).val();
			if(score_type1=='Yes' || score_type1=='N/A'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('kbg_val'));
				connectScore = connectScore + weightage1;
				connectScoreable = connectScoreable + weightage1;
			}else if(score_type1=='No'){
				var weightage1 = parseFloat($(element).children("option:selected").attr('kbg_val'));
				connectScoreable = connectScoreable + weightage1;
			}
		});
		connectOverall = ((connectScore*100)/connectScoreable).toFixed(2);
		$('#connectScore').text(connectScore);
		$('#connectScoreable').text(connectScoreable);
		if(!isNaN(connectOverall)){
			$('#connectOverall').val(connectOverall+'%');
		}

		$('.resolve').each(function(index,element){
			var score_type2 = $(element).val();
			if(score_type2=='Yes' || score_type2=='N/A'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('kbg_val'));
				resolveScore = resolveScore + weightage2;
				resolveScoreable = resolveScoreable + weightage2;
			}else if(score_type2=='No'){
				var weightage2 = parseFloat($(element).children("option:selected").attr('kbg_val'));
				resolveScoreable = resolveScoreable + weightage2;
			}
		});
		resolveOverall = ((resolveScore*100)/resolveScoreable).toFixed(2);
		$('#resolveScore').text(resolveScore);
		$('#resolveScoreable').text(resolveScoreable);
		if(!isNaN(resolveOverall)){
			$('#resolveOverall').val(resolveOverall+'%');
		}

		$('.madeeasy').each(function(index,element){
			var score_type3 = $(element).val();
			if(score_type3=='Yes' || score_type3=='N/A'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('kbg_val'));
				madeeasyScore = madeeasyScore + weightage3;
				madeeasyScoreable = madeeasyScoreable + weightage3;
			}else if(score_type3=='No'){
				var weightage3 = parseFloat($(element).children("option:selected").attr('kbg_val'));
				madeeasyScoreable = madeeasyScoreable + weightage3;
			}
		});
		madeeasyOverall = ((madeeasyScore*100)/madeeasyScoreable).toFixed(2);
		$('#madeeasyScore').text(madeeasyScore);
		$('#madeeasyScoreable').text(madeeasyScoreable);
		if(!isNaN(madeeasyOverall)){
			$('#madeeasyOverall').val(madeeasyOverall+'%');
		}
	}


	////////////////////////////////////////////////////////


	function do_calculation(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.jurry_points').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('ji_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('ji_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#jurys_inn_earned_score').val(score);
		$('#jurys_inn_possible_score').val(scoreable);
		
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
				var w1 = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('ji_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custJiCisEarned').text(customerScore);
		$('#custJiCisPossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custJiCisScore').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('ji_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busiJiCisEarned').text(businessScore);
		$('#busiJiCisPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busiJiCisScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('ji_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complJiCisEarned').text(complianceScore);
		$('#complJiCisPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complJiCisScore').val(compliancePercentage+'%');
		}
	
	///////////////CIS///////////////
		if($('#recognise_gdpr').val() == 'No' || $('#overcome_terms').val() == 'No' || $('#closure_booking').val() == 'No'){
			$('#jurysinn_PF').css("color", "red").val('Fail');
			$('#jurys_inn_overall_score').val(0);
		}else{
			if(quality_score_percent <= 90){
				$('#jurysinn_PF').css("color", "red").val('Fail');
			}else{
				$('#jurysinn_PF').css("color", "green").val('Pass');
			}
			
			if(!isNaN(quality_score_percent)){
				$('#jurys_inn_overall_score').val(quality_score_percent+'%');
			}
		}
		
	/////////////CIS Email///////////////	
		if($('#agentusetemplate').val() == 'No' || $('#agentusesignature').val() == 'No' || $('#agentuseinformation').val() == 'No' || $('#duplicatereservation').val()=='No' || $('#bookingmade').val()=='No' || $('#incorrectbookingchange').val()=='No' || $('#escalationagainstemail').val()=='No'){
			$('#ji_email_PF').css("color", "red").val('Fail');
			$('.jiEmail').val(0);
		}else{
			if(quality_score_percent <= 90){
				$('#ji_email_PF').css("color", "red").val('Fail');
			}else{
				$('#ji_email_PF').css("color", "green").val('Pass');
			}
			
			if(!isNaN(quality_score_percent)){
				$('.jiEmail').val(quality_score_percent+'%');
			}
		}
		
	////////////Stag and Hen///////////////	
		if($('#stag_hen_AF1').val() == 'No' || $('#stag_hen_AF2').val() == 'No'){
			$('.stag_hen_fatal').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('.stag_hen_fatal').val(quality_score_percent+'%');
			}
		}
		
	////////////CIS GDS///////////////	
		if($('#cis_gds_AF1').val() == 'No' || $('#cis_gds_AF2').val() == 'No' || $('#cis_gds_AF3').val() == 'No' || $('#cis_gds_AF4').val() == 'No' || $('#cis_gds_AF5').val() == 'No'){
			$('.cis_gds_fatal').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('.cis_gds_fatal').val(quality_score_percent+'%');
			}
		}
		
	////////////GDS & Pre Arrival///////////////	
		if($('#gds_prearrival_AF1').val() == 'No' || $('#gds_prearrival_AF2').val() == 'No' || $('#gds_prearrival_AF3').val() == 'No' || $('#gds_prearrival_AF4').val() == 'No' || $('#gds_prearrival_AF5').val() == 'No' || $('#gds_prearrival_AF6').val() == 'No' || $('#gds_prearrival_AF7').val() == 'No' || $('#gds_prearrival_AF8').val() == 'No' || $('#gds_prearrival_AF9').val() == 'No' || $('#gds_prearrival_AF10').val() == 'No' || $('#gds_prearrival_AF11').val() == 'No' || $('#gds_prearrival_AF12').val() == 'No' || $('#gds_prearrival_AF13').val() == 'No' || $('#gds_prearrival_AF14').val() == 'No' || $('#gds_prearrival_AF15').val() == 'No'){
			$('.gds_prearrival_fatal').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('.gds_prearrival_fatal').val(quality_score_percent+'%');
			}
		}
	
	////////////////
	}


	//////////////////////////////////////////////////////

	//////////////////// KABBAGE New //////////////////////////
	function kabbage_new_calc(){
		var score = 0;
		var scoreable = 0;
		var kabbage_overall_score = 0;

	////////////////////

		$('.kabbageVal_new').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Yes' || score_type=='N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('kbg_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type=='No'){
				var weightage = parseFloat($(element).children("option:selected").attr('kbg_val'));
				scoreable = scoreable + weightage;
			}
		});



		kabbage_overall_score = ((score*100)/scoreable).toFixed(2);
		$('#kbgEarned_new').val(score);
		$('#kbgPossible_new').val(scoreable);

		var arr=['fatal_epi'];

		arr.forEach(function(entry) {
			$("."+entry).each(function(){
				valNum=$(this).val();
				if(valNum == "No"){
					kabbage_overall_score=0;
				}
			});
		});

		if(!isNaN(kabbage_overall_score)){
			$('#kabbage_overall_score_new').val(kabbage_overall_score+'%');
		}

		if($('#kabbageAutof_new').val()=='Yes'){
			$('.kbg_autofail_new').val(0);
		}else{
			$('.kbg_autofail_new').val(kabbage_overall_score+'%');
		}
	}

	kabbage_new_calc();

///////////////// Ship Your Car Now /////////////////////
	function sycn_calculation(){
		var customer_score = 0;
		var customer_scoreable = 0;
		var customer_overall = 0;
		var compliance_score = 0;
		var compliance_scoreable = 0;
		var compliance_overall = 0;
		var business_score = 0;
		var business_scoreable = 0;
		var business_overallscore = 0;
		var score = 0;
		var scoreable = 0;
		var sycn_score = 0;

		$('.sycn').each(function(index,element){
			var score_type1 = $(element).val();
			if(score_type1=='Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				score = score + w1;
				scoreable = scoreable + w1;
			}else if(score_type1=='No'){
				var w1 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				scoreable = scoreable + w1;
			}else if(score_type1=='N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				score = score + w1;
				scoreable = scoreable + w1;
			}
		});
		sycn_score = ((score*100)/scoreable).toFixed(2);
		$('#sycnEarnedScore').val(score);
		$('#sycnPossibleScore').val(scoreable);
		if(!isNaN(sycn_score)){
			$('#sycnScore').val(sycn_score+'%');
		}

		if($('#sycn_autofail').val()=="Yes"){
			$('.sycnFatal').val(0);
		}else{
			$('.sycnFatal').val(sycn_score+'%');
		}
	////////////
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1=='Yes'){
				var w2 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				customer_score = customer_score + w2;
				customer_scoreable = customer_scoreable + w2;
			}else if(sc1=='No'){
				var w2 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				customer_scoreable = customer_scoreable + w2;
			}else if(sc1=='N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				customer_score = customer_score + w2;
				customer_scoreable = customer_scoreable + w2;
			}
		});
		customer_overall = ((customer_score*100)/customer_scoreable).toFixed(2);
		$('#customerEarned').text(customer_score);
		$('#customerPossible').text(customer_scoreable);
		if(!isNaN(customer_overall)){
			$('#customerScore').val(customer_overall+'%');
		}
	///////////
		$('.business').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3=='Yes'){
				var w3 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				business_score = business_score + w3;
				business_scoreable = business_scoreable + w3;
			}else if(sc3=='No'){
				var w3 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				business_scoreable = business_scoreable + w3;
			}else if(sc3=='N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				business_score = business_score + w3;
				business_scoreable = business_scoreable + w3;
			}
		});
		business_overall = ((business_score*100)/business_scoreable).toFixed(2);
		$('#businessEarned').text(business_score);
		$('#businessPossible').text(business_scoreable);
		if(!isNaN(business_overall)){
			$('#businessScore').val(business_overall+'%');
		}
	//////////
		$('.compliance').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2=='Yes'){
				var w4 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				compliance_score = compliance_score + w4;
				compliance_scoreable = compliance_scoreable + w4;
			}else if(sc2=='No'){
				var w4 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				compliance_scoreable = compliance_scoreable + w4;
			}else if(sc2=='N/A'){
				var w4 = parseFloat($(element).children("option:selected").attr('sycn_val'));
				compliance_score = compliance_score + w4;
				compliance_scoreable = compliance_scoreable + w4;
			}
		});
		compliance_overall = ((compliance_score*100)/compliance_scoreable).toFixed(2);
		$('#complianceEarned').text(compliance_score);
		$('#compliancePossible').text(compliance_scoreable);
		if(!isNaN(compliance_overall)){
			$('#complianceScore').val(compliance_overall+'%');
		}

	}

////////////////// DOCUSIGN ///////////////////////
	function docusign_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;

		$('.ds_point').each(function(index,element){
			var score_type = $(element).val();

			if(score_type == 'Yes' || score_type=='N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#ds_earnedScore').val(score);
		$('#ds_possibleScore').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#ds_overallScore').val(quality_score_percent+'%');
		}


		if($('#dsAutoF1').val()=='No' || $('#dsAutoF2').val()=='No' || $('#dsAutoF3').val()=='No' || $('#dsAutoF4').val()=='No' || $('#dsAutoF5').val()=='No' || $('#dsAutoF6').val()=='No' || $('#dsAutoF7').val()=='No' || $('#dsAutoF8').val()=='No' || $('#dsAutoF9').val()=='No' || $('#dsAutoF10').val()=='No' || $('#dsAutoF11').val()=='No' || $('#dsAutoF12').val()=='No' || $('#dsAutoF13').val()=='No'){
			$('.dsAutoFail').val(0);
		}else{
			$('.dsAutoFail').val(quality_score_percent+'%');
		}

	}

////////////////// Care.com ///////////////////////
	function care_calc(){
		var score = 0;
		$('.care_point').each(function(index,element){
			var weightage = parseFloat($(element).children("option:selected").attr('care_val'));
			score = score + weightage;
		});

		if(!isNaN(score)){
			$('#care_overall_score').val(score+'%');
		}
	}

	function care_member_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var scoreable2 = 0;
		var total_score2=0;

		$('.member_point').each(function(index,element){
			var score_type = $(element).val();

			if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('member_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('member_val'));
				scoreable = scoreable + weightage;
				var weightage2 = parseFloat($(element).children("option:selected").attr('member_val'));
				scoreable2 = scoreable2 + weightage2;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('member_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		$('#memberEarned').val(score);
		$('#memberPossible').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#memberOverall').val(quality_score_percent+'%');
		}

		total_score = (100-scoreable2);
		if(!isNaN(total_score)){
		$('#total_score').val(total_score);
	    }else{
	    $('#total_score').val(100);
	    }

	}

</script>

<script type="text/javascript">

	function docusign_calculation(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;

		$('.points_epi').each(function(index,element){
			var score_type = $(element).val();
			// console.log(score_type);
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				scoreable = scoreable + weightage;
			}
		});

		$('.fatal_epi').each(function(index1,element1){
			var score_type1 = $(element1).val();
			// console.log(score_type1);
			if(score_type1 == 'No'){
				var weightage1 = parseFloat($(element1).children("option:selected").attr('ds_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'Yes'){
				var weightage1 = parseFloat($(element1).children("option:selected").attr('ds_val'));
				scoreable1 = scoreable1 + weightage1;
			}

		});

		score=score+score1;
		scoreable=scoreable+scoreable1;

		$(".fatal_epi").each(function(){
		valNum=$(this).val();
		if(valNum == "Yes"){
		score=0;
		}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		// console.log(quality_score_percent);

		$('#epi_earnedScore').val(score);
		$('#epi_possibleScore').val(scoreable);

		if(!isNaN(quality_score_percent)){
			$('#epi_overallScore').val(quality_score_percent+'%');
		}

	}

docusign_calculation();

</script>

<script>
//////////////// Zoom Car ///////////////////////
	function zoomcar_calc(){
		var total_score = 0;
		var efficiency = 0;
		var callhandle = 0;
		var sentence = 0;
		var record = 0;
		var resolution = 0;
		var respect = 0;
		var desire = 0;
		var willing = 0;

		$('.zoomcar').each(function(index,element){
			var total_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			total_score = total_score + total_wg;
		});
		if(!isNaN(total_score)){
			$('#zoomcarScore').val(parseInt(total_score)+'%');
		}

		if($('#zcInbAF1').val()=='Fatal' || $('#zcInbAF2').val()=='Fatal' || $('#zcInbAF3').val()=='Fatal' || $('#zcInbAF4').val()=='Fatal' || $('#zcInbAF5').val()=='Fatal' || $('#zcInbAF6').val()=='Fatal' || $('#zcInbAF7').val()=='Fatal' || $('#zcInbAF8').val()=='Fatal' || $('#zcInbAF9').val()=='Fatal' || $('#zcInbAF10').val()=='Fatal' || $('#zcInbAF11').val()=='Fatal' || $('#zcInbAF12').val()=='Fatal' || $('#zcInbAF13').val()=='Fatal' || $('#zcInbAF14').val()=='Fatal' || $('#zcInbAF15').val()=='Fatal' || $('#zcInbAF16').val()=='Fatal' || $('#zcInbAF17').val()=='Fatal' || $('#zcInbAF18').val()=='Fatal' || $('#zcInbAF19').val()=='Fatal' || $('#zcInbAF20').val()=='Fatal' || $('#zcInbAF21').val()=='Fatal' || $('#zcInbAF22').val()=='Fatal' || $('#zcInbAF23').val()=='Fatal' || $('#zcInbAF24').val()=='Fatal' || $('#zcInbAF25').val()=='Fatal' || $('#zcInbAF26').val()=='Fatal' || $('#zcInbAF27').val()=='Fatal'){
			$(".zoomcarINBFatal").val(0);
		}else{
			$(".zoomcarINBFatal").val(parseInt(total_score)+'%');
		}

	////////////////////////////
		$('.efficiency').each(function(index,element){
			var efc_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			efficiency = efficiency + efc_wg;
		});
		if(!isNaN(efficiency)){
			$('#efficiency_score').val(efficiency.toFixed(2));
		}

		if($('#zcInbAF1').val()=='Fatal' || $('#zcInbAF2').val()=='Fatal'){
			$('.efficiencyAF').val(0);
		}else{
			$('.efficiencyAF').val(efficiency.toFixed(2));
		}
	//////////
		$('.callhandle').each(function(index,element){
			var ch_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			callhandle = callhandle + ch_wg;
		});
		if(!isNaN(callhandle)){
			$('#call_handling_score').val(callhandle.toFixed(2));
		}

		if($('#zcInbAF3').val()=='Fatal'){
			$('.callHandlingAF').val(0);
		}else{
			$('.callHandlingAF').val(callhandle.toFixed(2));
		}
	//////////
		$('.sentence').each(function(index,element){
			var st_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			sentence = sentence + st_wg;
		});
		if(!isNaN(sentence)){
			$('#sentence_construction_score').val(sentence.toFixed(2));
		}
	//////////
		$('.record').each(function(index,element){
			var rc_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			record = record + rc_wg;
		});
		if(!isNaN(record)){
			$('#record_accuracy_score').val(record.toFixed(2));
		}

		if($('#zcInbAF4').val()=='Fatal' || $('#zcInbAF5').val()=='Fatal' || $('#zcInbAF6').val()=='Fatal' || $('#zcInbAF7').val()=='Fatal' || $('#zcInbAF8').val()=='Fatal' || $('#zcInbAF9').val()=='Fatal' || $('#zcInbAF10').val()=='Fatal' || $('#zcInbAF11').val()=='Fatal'){
			$('.recordAF').val(0);
		}else{
			$('.recordAF').val(record.toFixed(2));
		}
	///////////
		$('.resolution').each(function(index,element){
			var rsl_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			resolution = resolution + rsl_wg;
		});
		if(!isNaN(record)){
			$('#appropiate_resolution_score').val(resolution.toFixed(2));
		}

		if($('#zcInbAF12').val()=='Fatal' || $('#zcInbAF13').val()=='Fatal' || $('#zcInbAF14').val()=='Fatal' || $('#zcInbAF15').val()=='Fatal' || $('#zcInbAF16').val()=='Fatal' || $('#zcInbAF17').val()=='Fatal' || $('#zcInbAF18').val()=='Fatal' || $('#zcInbAF19').val()=='Fatal' || $('#zcInbAF20').val()=='Fatal' || $('#zcInbAF21').val()=='Fatal'){
			$('.resolutionAF').val(0);
		}else{
			$('.resolutionAF').val(resolution.toFixed(2));
		}
	//////////
		$('.respect').each(function(index,element){
			var rsp_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			respect = respect + rsp_wg;
		});
		if(!isNaN(record)){
			$('#was_respectful_score').val(respect.toFixed(2));
		}

		if($('#zcInbAF22').val()=='Fatal' || $('#zcInbAF23').val()=='Fatal' || $('#zcInbAF24').val()=='Fatal' || $('#zcInbAF25').val()=='Fatal' || $('#zcInbAF26').val()=='Fatal' || $('#zcInbAF27').val()=='Fatal'){
			$('.respectAF').val(0);
		}else{
			$('.respectAF').val(respect.toFixed(2));
		}
	///////////
		$('.desire').each(function(index,element){
			var ds_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			desire = desire + ds_wg;
		});
		if(!isNaN(desire)){
			$('#demonstrate_desire_score').val(desire.toFixed(2));
		}
	///////////
		$('.willing').each(function(index,element){
			var wl_wg = parseFloat($(element).children("option:selected").attr('zc_val'));
			willing = willing + wl_wg;
		});
		if(!isNaN(willing)){
			$('#customer_help_score').val(willing.toFixed(2));
		}

	}

//////////////// HSDL ///////////////////////
	function hsdl_calc(){
		var total_score=0;
		var total_scoreable=0;
		var total_percentage=0;
		var salesScore=0;
		var salesScoreable=0;
		var complianceScore=0;
		var complianceScoreable=0;
		var businessScore=0;
		var businessScoreable=0;


		$('.hsdl').each(function(index,element){
			var total_wg = parseFloat($(element).children("option:selected").attr('hsdl_val'));
			total_score = total_score + total_wg;
			total_scoreable = 255;
		});
		$('#hsdlEarned').val(total_score.toFixed(2));
		$('#hsdlPossible').val(total_scoreable);
		total_percentage = ((total_score*100)/total_scoreable).toFixed(2);

		if(!isNaN(total_percentage)){
			$('#hsdlScore').val(total_percentage+'%');
		}
	///////////
		$('.sales').each(function(index,element){
			var sales_wg = parseFloat($(element).children("option:selected").attr('hsdl_val'));
			salesScore = salesScore + sales_wg;
			salesScoreable = 18;
		});
		var sales_score = ((salesScore*100)/salesScoreable).toFixed(2);
		$('#hsdlSales').val(sales_score+'%');
	///////////
		$('.compliance').each(function(index,element){
			var compliance_wg = parseFloat($(element).children("option:selected").attr('hsdl_val'));
			complianceScore = complianceScore + compliance_wg;
			complianceScoreable = 108;
		});
		var compliance_score = ((complianceScore*100)/complianceScoreable).toFixed(2);
		$('#hsdlCompliance').val(compliance_score+'%');
	///////////
		$('.business').each(function(index,element){
			var business_wg = parseFloat($(element).children("option:selected").attr('hsdl_val'));
			businessScore = businessScore + business_wg;
			businessScoreable = 129;
		});
		var business_score = ((businessScore*100)/businessScoreable).toFixed(2);
		$('#hsdlBusiness').val(business_score+'%');

	/*--- Tier Category Fatal --*/
		/* if($('#tier_cat1').val()=='Tier 3' || $('#tier_cat2').val()=='Tier 3' || $('#tier_cat3').val()=='Tier 3' || $('#tier_cat4').val()=='Tier 3' || $('#tier_cat5').val()=='Tier 3' || $('#tier_cat6').val()=='Tier 3' || $('#tier_cat7').val()=='Tier 3' || $('#tier_cat8').val()=='Tier 3' || $('#tier_cat9').val()=='Tier 3' || $('#tier_cat10').val()=='Tier 3' || $('#tier_ca11').val()=='Tier 3' || $('#tier_cat12').val()=='Tier 3' || $('#tier_cat13').val()=='Tier 3' || $('#tier_cat14').val()=='Tier 3' || $('#tier_cat15').val()=='Tier 3' || $('#tier_cat16').val()=='Tier 3' || $('#tier_cat17').val()=='Tier 3' || $('#tier_cat18').val()=='Tier 3' || $('#tier_cat19').val()=='Tier 3' || $('#tier_cat20').val()=='Tier 3' || $('#tier_cat21').val()=='Tier 3' || $('#tier_cat22').val()=='Tier 3' || $('#tier_cat23').val()=='Tier 3' || $('#tier_cat24').val()=='Tier 3' || $('#tier_cat25').val()=='Tier 3' || $('#tier_cat26').val()=='Tier 3' || $('#tier_cat27').val()=='Tier 3' || $('#tier_cat28').val()=='Tier 3' || $('#tier_cat29').val()=='Tier 3' || $('#tier_cat30').val()=='Tier 3' || $('#tier_cat31').val()=='Tier 3' || $('#tier_cat32').val()=='Tier 3' || $('#tier_cat33').val()=='Tier 3' || $('#tier_cat34').val()=='Tier 3' || $('#tier_cat35').val()=='Tier 3' || $('#tier_cat36').val()=='Tier 3' || $('#tier_cat37').val()=='Tier 3' || $('#tier_cat38').val()=='Tier 3' || $('#tier_cat39').val()=='Tier 3'){
			$('.tierCatAF').val(0);
		}else{
			$('.tierCatAF').val(total_percentage+'%');
		} */

	/*--- Auto Fail --*/
		if($('#hsdlAF1').val()=='AFD' || $('#hsdlAF2').val()=='AFD' || $('#hsdlAF3').val()=='AFD' || $('#hsdlAF4').val()=='AFD' || $('#hsdlAF5').val()=='AFD' || $('#hsdlAF6').val()=='AFD' || $('#hsdlAF7').val()=='AFD' || $('#hsdlAF8').val()=='AFD' || $('#hsdlAF9').val()=='AFD' || $('#hsdlAF10').val()=='AFD' || $('#hsdlAF11').val()=='AFD' || $('#hsdlAF12').val()=='AFD' || $('#hsdlAF13').val()=='AFD' || $('#hsdlAF14').val()=='AFD' || $('#hsdlAF15').val()=='AFD' || $('#hsdlAF16').val()=='AFD' || $('#hsdlAF17').val()=='AFD' || $('#hsdlAF18').val()=='AFD' || $('#hsdlAF19').val()=='AFD' || $('#hsdlAF20').val()=='AFD'){
			$('.hsdlFatal').val(0);
		}else{
			$('.hsdlFatal').val(total_percentage+'%');
		}

	}

//////////////// K2 Claims ///////////////////////
	function k2_claims_calc(){
		var score=0;

		$('.k2_claims').each(function(index,element){
			var total_wg = parseFloat($(element).children("option:selected").attr('k2_val'));
			score = score + total_wg;
		});
		if(!isNaN(score)){
			$('#k2ClaimsScore').val(score+'%');
		}

	}

//////////////// EDUTECH ///////////////////////
	

	function cuemath_script_calc(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.cuemath_script').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('cmth_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type==1){
				var weightage = parseFloat($(element).children("option:selected").attr('cmth_val'));
				score = score + 1;
				scoreable = scoreable + weightage;
			}else if(score_type==3){
				var weightage = parseFloat($(element).children("option:selected").attr('cmth_val'));
				score = score + 3;
				scoreable = scoreable + weightage;
			}else if(score_type==4){
				var weightage = parseFloat($(element).children("option:selected").attr('cmth_val'));
				score = score + 4;
				scoreable = scoreable + weightage;
			}else if(score_type==0){
				var weightage = parseFloat($(element).children("option:selected").attr('cmth_val'));
				scoreable = scoreable + weightage;
			}else{
				var weightage = parseFloat($(element).children("option:selected").attr('cmth_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		totalscore = ((score*100)/scoreable).toFixed(2);

		if(!isNaN(score)){
			$("#cuemath_scriptEarned").val(score);
		}

		if(!isNaN(scoreable)){
			$("#cuemath_scriptPossible").val(scoreable);
		}

		if(!isNaN(totalscore)){
			$('#cuemath_scriptScore').val(totalscore+'%');
		}

		if($('#cmthScriptAF1').val()==0 || $('#cmthScriptAF2').val()==0 || $('#cmthScriptAF3').val()==0 || $('#cmthScriptAF4').val()==0 || $('#cmthScriptAF5').val()==0 || $('#cmthScriptAF6').val()==0 || $('#cmthScriptAF7').val()==0){
			$('.cuemath_scriptScriptFatal').val(0);
		}else{
			$('.cuemath_scriptScriptFatal').val(totalscore+'%');
		}

	////////////
		if(parseInt(totalscore) == 100){
			$('#cuemath_script1_l1').show();
			$('#cuemath_script1_l1').val('N/A');
			$('#cuemath_script_l1').prop('disabled',true);
			$('#cuemath_script_l1').hide();

			$('#cuemath_script1_l2').show();
			$('#cuemath_script1_l2').val('N/A');
			$('#cuemath_script_l2').prop('disabled',true);
			$('#cuemath_script_l2').hide();
		}else{
			$('#cuemath_script1_l1').hide();
			$('#cuemath_script1_l1').val('');
			$('#cuemath_script_l1').prop('disabled',false);
			$('#cuemath_script_l1').show();

			$('#cuemath_script1_l2').hide();
			$('#cuemath_script1_l2').val('');
			$('#cuemath_script_l2').prop('disabled',false);
			$('#cuemath_script_l2').show();
		}

	}

 ///////////////New CueMath Nilkanta////////////////////////
	function cuemath_new_calc(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.cuemath_new').each(function(index,element){
			var score_type = $(element).val();

			if((score_type =='1') || (score_type =='2') || (score_type =='3') || (score_type =='4') || (score_type =='5') || (score_type == 'N/A')){
				var w1 = parseInt($(element).children("option:selected").attr('cuemath_val'));
				var w2 = parseInt($(element).children("option:selected").attr('cm_poss'));
				score = score + w1;
				scoreable = scoreable + w2;
			}
		});

		totalscore = ((score*100)/scoreable).toFixed(2);

		if(!isNaN(score)){
			$("#cuemath_newEarned").val(score);
		}

		if(!isNaN(scoreable)){
			$("#cuemath_newPossible").val(scoreable);
		}

		if(!isNaN(totalscore)){
			$('#cuemath_newScore').val(totalscore+'%');
		}

	}

/////////////////////// Huda | Stifel ///////////////////////////
	function huda_calc(){
		var score = 0;

		$('.huda_point').each(function(index,element){
			var weightage = parseFloat($(element).children("option:selected").attr('huda_val'));
			score = score + weightage;
		});
		if(!isNaN(score)){
			$("#huda_overall_score").val(score);
		}

	//////Huda///////
		if($('#hudaAF1').val()=='Fatal' || $('#hudaAF2').val()=='Fatal' || $('#hudaAF3').val()=='Yes'){
			$('.hudaFatal').val(0);
		}else{
			$('.hudaFatal').val(score+'%');
		}

	//////Stifel///////
		if($('#stifelAF1').val()=='No' || $('#stifelAF2').val()=='Yes' || $('#stifelAF3').val()=='No' || $('#stifelAF4').val()=='Yes'){
			$('.stifelFatal').val(0);
		}else{
			$('.stifelFatal').val(score+'%');
		}


	

	}






/////////////////////// FTPL ///////////////////////////
	function ftpl_calc(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.ftpl_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ftpl_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type=='No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ftpl_val'));
				scoreable = scoreable + weightage;
			}
		});
		totalscore = ((score*100)/scoreable).toFixed(2);

		$("#ftpl_earnedScore").val(score);
		$("#ftpl_possibleScore").val(scoreable);

		if(!isNaN(totalscore)){
			$('#ftpl_overallScore').val(totalscore+'%');
		}

		if($('#ftplAF1').val()=='Yes' || $('#ftplAF2').val()=='No' || $('#ftplAF3').val()=='No' || $('#ftplAF4').val()=='No' || $('#ftplAF5').val()=='No' || $('#ftplAF6').val()=='No' || $('#ftplAF7').val()=='No'){
			$('.ftpl_fatal').val(0);
		}else{
			$('.ftpl_fatal').val(totalscore+'%');
		}

	}

</script>

<script>
$(document).ready(function(){

	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_date_time").datetimepicker();
	$("#booking_date").datepicker();
	$("#video_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#hold_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#verification_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#go_live_date").datepicker();

	$(".agentName").select2();


///////////////// Calibration - Auditor Type ///////////////////////
	// $('.auType').hide();

	// $('#audit_type').on('change', function(){
	// 	if($(this).val()=='Calibration'){
	// 		$('.auType').show();
	// 		$('#auditor_type').attr('required',true);
	// 		$('#auditor_type').prop('disabled',false);
	// 	}else{
	// 		$('.auType').hide();
	// 		$('#auditor_type').attr('required',false);
	// 		$('#auditor_type').prop('disabled',true);
	// 	}
	// });

	///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	if($("#audit_type").val() == "Calibration")
	{
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	//console.log(`OnLoad -> ${$("#auditor_type").val()}`)
	$('#audit_type').on('change', function()
	{
		
		if($(this).val()=='Calibration')
		{
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);

		} else
		{
			$('.auType').hide();
			$('#auditor_type').val("")
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
			// $('#auditor_type').val('');
		}
	//	console.log(`OnChange -> ${$("#auditor_type").val()}`)
	});	

	///////////////// Detractor Audit, Passive Audit, Promoter Audit - (Customer Voice, KM Utilization, Article, Fatal/Non-Fatal, Detractor ACPT, Detractor L1, Detractor L2, TCD, Voice modulation, Assurance given) ///////////////////////
	
	$('.cust_voc').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.cust_voc').show();
		$('#voice_cust').attr('required',true);
		$('#voice_cust').prop('disabled',false);
	}
	$('.utiliza').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.utiliza').show();
		$('#utilization').attr('required',true);
		$('#utilization').prop('disabled',false);
	}
	$('.arti').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.arti').show();
		$('#article').attr('required',true);
		$('#article').prop('disabled',false);
	}
	
	$('.fatal_nonfatal').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.fatal_nonfatal').show();
		$('#fatal_non_fatal').attr('required',true);
		$('#fatal_non_fatal').prop('disabled',false);
	}
	$('.acpt').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.acpt').show();
		$('#detractor_acpt').attr('required',true);
		$('#detractor_acpt').prop('disabled',false);
	}
	$('.detrac_l1').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.detrac_l1').show();
		$('#detractor_l1').attr('required',true);
		$('#detractor_l1').prop('disabled',false);
	}
	$('.detrac_l2').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.detrac_l2').show();
		$('#detractor_l2').attr('required',true);
		$('#detractor_l2').prop('disabled',false);
	}
	$('.tcd').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.tcd').show();
		$('#tcd').attr('required',true);
		$('#tcd').prop('disabled',false);
	}
	$('.modulation').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.modulation').show();
		$('#voice_modulation').attr('required',true);
		$('#voice_modulation').prop('disabled',false);
	}
	$('.assurance').hide();
	if(($("#type_of_audit").val() == "Detractor Audit") || ($("#type_of_audit").val() == "Passive Audit") || ($("#type_of_audit").val() == "Promoter Audit"))
	{
		$('.assurance').show();
		$('#assurance_given').attr('required',true);
		$('#assurance_given').prop('disabled',false);
	}
	
	$('#type_of_audit').on('change', function(){
		if(($(this).val()=='Detractor Audit') || ($(this).val()=='Passive Audit') || ($(this).val()=='Promoter Audit')){
			$('.cust_voc').show();
			$('#voice_cust').attr('required',true);
			$('#voice_cust').prop('disabled',false);
			$('.utiliza').show();
			$('#utilization').attr('required',true);
	 		$('#utilization').prop('disabled',false);
			$('.arti').show();
	 		$('#article').attr('required',true);
			$('#article').prop('disabled',false);
			$('.fatal_nonfatal').show();
	 		$('#fatal_non_fatal').attr('required',true);
			$('#fatal_non_fatal').prop('disabled',false);
			$('.acpt').show();
	 		$('#detractor_acpt').attr('required',true);
			$('#detractor_acpt').prop('disabled',false);
			$('.detrac_l1').show();
	 		$('#detractor_l1').attr('required',true);
			$('#detractor_l1').prop('disabled',false);
			$('.detrac_l2').show();
	 		$('#detractor_l2').attr('required',true);
			$('#detractor_l2').prop('disabled',false);
			$('.tcd').show();
	 		$('#tcd').attr('required',true);
			$('#tcd').prop('disabled',false);
			$('.modulation').show();
	 		$('#voice_modulation').attr('required',true);
			$('#voice_modulation').prop('disabled',false);
			$('.assurance').show();
	 		$('#assurance_given').attr('required',true);
			$('#assurance_given').prop('disabled',false);
		}else if(($(this).val()=='High AHT Audit') || ($(this).val()=='Random Audit') || ($(this).val()=='A2A') || ($(this).val()=='Calibration') || ($(this).val()=='WOW Call')){
			$('.cust_voc').hide();
			$('#voice_cust').val("");
			$('#voice_cust').attr('required',false);
			$('#voice_cust').prop('disabled',true);
			$('.utiliza').hide();
			$('#utilization').val("");
	 		$('#utilization').attr('required',false);
	 		$('#utilization').prop('disabled',true);
			$('.arti').hide();
			$('#article').val("");
	 		$('#article').attr('required',false);
	 		$('#article').prop('disabled',true);
			$('.fatal_nonfatal').hide();
			$('#fatal_non_fatal').val("");
	 		$('#fatal_non_fatal').attr('required',false);
	 		$('#fatal_non_fatal').prop('disabled',true);
			$('.acpt').hide();
			$('#detractor_acpt').val("");
	 		$('#detractor_acpt').attr('required',false);
	 		$('#detractor_acpt').prop('disabled',true);
			$('.detrac_l1').hide();
			$('#detractor_l1').val("");
	 		$('#detractor_l1').attr('required',false);
	 		$('#detractor_l1').prop('disabled',true);
			$('.detrac_l2').hide();
			$('#detractor_l2').val("");
	 		$('#detractor_l2').attr('required',false);
	 		$('#detractor_l2').prop('disabled',true);
			$('.tcd').hide();
			$('#tcd').val("");
	 		$('#tcd').attr('required',false);
	 		$('#tcd').prop('disabled',true);
			$('.modulation').hide();
			$('#voice_modulation').val("");
	 		$('#voice_modulation').attr('required',false);
	 		$('#voice_modulation').prop('disabled',true);
			$('.assurance').hide();
			$('#assurance_given').val("");
	 		$('#assurance_given').attr('required',false);
	 		$('#assurance_given').prop('disabled',true);
		 }
		//else ($(this).val()==''){
		// 	$('.cust_voc').hide();
		// 	$('.utiliza').hide();
		// 	$('.arti').hide();
		// 	$('.fatal_nonfatal').hide();
		// 	$('.acpt').hide();
		// 	$('.detrac_l1').hide();
		// 	$('.detrac_l2').hide();
		// 	$('.tcd').hide();
		// 	$('.modulation').hide();
		// 	$('.assurance').hide();
		// }
	
	});

	// $('.utiliza').hide();

	// $('#type_of_audit').on('change', function(){
	// 	if($(this).val()=='Passive Audit'){
	// 		$('.utiliza').show();
	// 		$('#utilization').attr('required',true);
	// 		$('#utilization').prop('disabled',false);
	// 	}else{
	// 		$('.utiliza').hide();
	// 		$('#utilization').attr('required',false);
	// 		$('#utilization').prop('disabled',true);
	// 	}
	// });

	// $('.arti').hide();

	// $('#type_of_audit').on('change', function(){
	// 	if($(this).val()=='Promoter Audit'){
	// 		$('.arti').show();
	// 		$('#article').attr('required',true);
	// 		$('#article').prop('disabled',false);
	// 	}else{
	// 		$('.arti').hide();
	// 		$('#article').attr('required',false);
	// 		$('#article').prop('disabled',true);
	// 	}
	// });

//////////////// Invalid for -Status (Nilkanta) ///////////////////////
	$('.reasonType').hide();

	$('#status_type').on('change', function(){
		if($(this).val()=='Invalid'){
			$('.reasonType').show();
			$('#reason_type').attr('required',true);
			$('#reason_type').prop('disabled',false);
		}else{
			$('.reasonType').hide();
			$('#reason_type').attr('required',false);
			$('#reason_type').prop('disabled',true);
		}
	});
///////////////////////////////////////////////////

	$(document).on('change','.kabbageVal',function(){
		kabbage_calc();
	});

	$(document).on('change','.kabbageVal_new',function(){
		kabbage_new_calc();
	});
		kabbage_new_calc();


	$(document).on('change','.connect',function(){ kabbage_calc(); });
	$(document).on('change','.resolve',function(){ kabbage_calc(); });
	$(document).on('change','.madeeasy',function(){ kabbage_calc(); });
	kabbage_calc();

//////////////
	$(document).on('change','.procedural',function(){ kbg_calculation(); });
	$(document).on('change','.compliance',function(){ kbg_calculation(); });
	$(document).on('change','.customerexp',function(){ kbg_calculation(); });
	kbg_calculation();

/////////////
	$(document).on('change','.ds_point',function(){
		docusign_calc();
	});

	$(".points_epi").on("change",function(){
		docusign_calculation();
	});

	$(".fatal_epi").on("change",function(){
		docusign_calculation();
	});

	docusign_calc();


///////////////// Zoom Car ////////////////////
	$(document).on('change','.zoomcar',function(){
		zoomcar_calc();
	});
	$(document).on('change','.efficiency',function(){
		zoomcar_calc();
	});
	$(document).on('change','.callhandle',function(){
		zoomcar_calc();
	});
	$(document).on('change','.sentence',function(){
		zoomcar_calc();
	});
	$(document).on('change','.record',function(){
		zoomcar_calc();
	});
	$(document).on('change','.resolution',function(){
		zoomcar_calc();
	});
	$(document).on('change','.respect',function(){
		zoomcar_calc();
	});
	$(document).on('change','.desire',function(){
		zoomcar_calc();
	});
	$(document).on('change','.willing',function(){
		zoomcar_calc();
	});
	zoomcar_calc();

///////////////// HSDL ////////////////////
	$(document).on('change','.hsdl',function(){
		hsdl_calc();
	});
	$(document).on('change','.sales',function(){
		hsdl_calc();
	});
	$(document).on('change','.compliance',function(){
		hsdl_calc();
	});
	$(document).on('change','.business',function(){
		hsdl_calc();
	});
	/*$(document).on('change','.tier_cat',function(){
		hsdl_calc();
	});*/
	hsdl_calc();

//////////////// Care.com ///////////////////
	$(document).on('change','.care_point',function(){
		care_calc();
	});
	care_calc();

	$(document).on('change','.member_point',function(){
		care_member_calc();
	});
	care_member_calc();


///////////////// K2 Claims ////////////////////
	$(document).on('change','.k2_claims',function(){
		k2_claims_calc();
	});
	k2_claims_calc();

///////////////// Huda | Stifel ////////////////////
	$(document).on('change','.huda_point',function(){
		huda_calc();
	});
	huda_calc();

///////////////// FTPL ////////////////////
	$(document).on('change','.ftpl_point',function(){
		ftpl_calc();
	});
	ftpl_calc();

///////////////// SYCN ////////////////////
	$(document).on('change','.sycn',function(){ sycn_calculation(); });
	$(document).on('change','.customer',function(){ sycn_calculation(); });
	$(document).on('change','.business',function(){ sycn_calculation(); });
	$(document).on('change','.compliance',function(){ sycn_calculation(); });
	sycn_calculation();

///////////////// EDUTECH ////////////////////
    //Lido
    function edutech_calc(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;
        var parameter_count = 0;
		$('.edutech').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('edu_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('edu_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('edu_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		})

		totalscore = ((score/scoreable)*100).toFixed(2);
		$('#ernscoo').val(score);
		$('#posiooo').val(scoreable);

         if(!isNaN(totalscore)){
			$('#edutechScore').val(totalscore+'%');
		}

		/*---------------*/
		if($('#edutechAF1').val()=='No' || $('#edutechAF2').val()=='No' || $('#edutechAF3').val()=='No' || $('#edutechAF4').val()=='No' || $('#edutechAF5').val()=='No' || $('#edutechAF6').val()=='No' || $('#edutechAF7').val()=='No'){
			$('.edutechFatal').val(0);
		}else{
			$('.edutechFatal').val(score+'%');
		}
	/*---------------*/
		if($('#cuemathNewAF1').val()=='No' || $('#cuemathNewAF2').val()=='No' || $('#cuemathNewAF3').val()=='No' || $('#cuemathNewAF4').val()=='No'){
			$('.cuemathNewFatal').val(0);
		}else{
			$('.cuemathNewFatal').val(score+'%');
		}

	/*-------Beyondskool--------*/
		if($('#beyondskoolAF1').val()=='No' || $('#beyondskoolAF2').val()=='No' || $('#beyondskoolAF3').val()=='No' || $('#beyondskoolAF4').val()=='No' || $('#beyondskoolAF5').val()=='No'){
			$('.beyondskoolFatal').val(0);
		}else{
			$('.beyondskoolFatal').val(score+'%');
		}

	}
	$(document).on('change','.edutech',function(){
		edutech_calc();
	});
	edutech_calc();

	$(document).on('change','.cuemath_script',function(){
		cuemath_script_calc();
	});
	$(document).on('change','.cuemath_script1',function(){
		cuemath_script_calc();
	});
	cuemath_script_calc();

	$(document).on('change','.cuemath_new',function(){
		cuemath_new_calc();
	});
	cuemath_new_calc();

	/*--------- CUEMATH ---------*/

		$('#cuemath_demo_status').on('change', function(){
			if($(this).val()=='Invalid'){
				$('#cuemath_invalid_reason').prop('disabled',false);
				$('#cuemath_invalid_reason').attr('required',true);
				$('.demoStatusACPT1').prop('disabled',false);
				$('.demoStatusACPT1').attr('required',true);
				$('.demoStatusACPT2').prop('disabled',false);
				$('.demoStatusACPT2').attr('required',true);
			}else{
				$('#cuemath_invalid_reason').prop('disabled',true);
				$('#cuemath_invalid_reason').attr('required',false);
				$('.demoStatusACPT1').prop('disabled',true);
				$('.demoStatusACPT1').attr('required',false);
				$('.demoStatusACPT2').prop('disabled',true);
				$('.demoStatusACPT2').attr('required',false);
			}
		});

		$('#cuemath_new_l1').on('change', function(){
			if($(this).val()=='Professionalism'){
				var cuemath1_l2 = '<option value="Call Disposition">Call Disposition</option>';
				cuemath1_l2 += '<option value="Personal information">Personal information</option>';
				cuemath1_l2 += '<option value="Behaviour Issue">Behaviour Issue</option>';
				cuemath1_l2 += '<option value="False Information">False Information</option>';
				$("#cuemath_new_l2").html(cuemath1_l2);
			}else if($(this).val()=='Data Capturing'){
				var cuemath2_l2 = '<option value="Parents Name">Parents Name</option>';
				cuemath2_l2 += '<option value="Student Name">Student Name</option>';
				cuemath2_l2 += '<option value="Grade">Grade</option>';
				cuemath2_l2 += '<option value="Curriculum">Curriculum</option>';
				cuemath2_l2 += '<option value="Phone Number">Phone Number</option>';
				cuemath2_l2 += '<option value="Alternate Phone Number">Alternate Phone Number</option>';
				cuemath2_l2 += '<option value="Demo Date & Time">Demo Date & Time</option>';
				cuemath2_l2 += '<option value="Email">Email</option>';
				cuemath2_l2 += '<option value="Technical Information">Technical Information</option>';
				cuemath2_l2 += '<option value="1 hour Demo Session">1 hour Demo Session</option>';
				cuemath2_l2 += '<option value="10min Prior Login">10min Prior Login</option>';
				cuemath2_l2 += '<option value="Reference or Sibling">Reference or Sibling</option>';
				$("#cuemath_new_l2").html(cuemath2_l2);
			}else if($(this).val()=='Summarization'){
				var cuemath4_l2 = '<option value="Demo Date & Time">Demo Date & Time</option>';
				cuemath4_l2 += '<option value="Email">Email</option>';
				$("#cuemath_new_l2").html(cuemath4_l2);
			}else if($(this).val()=='Dispositon'){
				var cuemath3_l2 = '<option value="Incorrect Disposition">Incorrect Disposition</option>';
				cuemath3_l2 += '<option value="No Disposition">No Disposition</option>';
				$("#cuemath_new_l2").html(cuemath3_l2);
			}else if($(this).val()=='N/A'){
				$("#cuemath_new_l2").html('<option value="N/A">N/A</option>');
			}else{
				$("#cuemath_new_l2").html('');
			}
		});

		$('#cuemath_script_l1').on('change', function(){
			if($(this).val()=='Call Openning'){
				var cmth1_l2 = '<option value="Greeting and Self Introduction">Greeting and Self Introduction</option>';
				cmth1_l2 += '<option value="Branding and Probing">Branding and Probing</option>';
				cmth1_l2 += '<option value="Hook Line">Hook Line</option>';
				$("#cuemath_script_l2").html(cmth1_l2);
			}else if($(this).val()=='Call Handeling Skill'){
				var cmth2_l2 = '<option value="Natural Accents">Natural Accents</option>';
				cmth2_l2 += '<option value="Mirror Match">Mirror Match</option>';
				$("#cuemath_script_l2").html(cmth2_l2);
			}else if($(this).val()=='Data Capturing'){
				var cmth3_l2 = '<option value="City/State, Phone Number, Time Zone, Parent Availibility">City/State, Phone Number, Time Zone, Parent Availibility</option>';
				cmth3_l2 += '<option value="Date & time, Curriculum">Date & time, Curriculum</option>';
				cmth3_l2 += '<option value="Student Name, Grade, Email ID, Alternate Number">Student Name, Grade, Email ID, Alternate Number</option>';
				$("#cuemath_script_l2").html(cmth3_l2);
			}else if($(this).val()=='Correct and Complete Information'){
				var cmth7_l2 = '<option value="Session Brief">Session Brief</option>';
				cmth7_l2 += '<option value="Incorrect information shared">Incorrect information shared</option>';
				$("#cuemath_script_l2").html(cmth7_l2);
			}else if($(this).val()=='Mandatory Information'){
				var cmth4_l2 = '<option value="Mandatory Information(Tech Detail)">Mandatory Information(Tech Detail)</option>';
				cmth4_l2 += '<option value="Summarization">Summarization</option>';
				cmth4_l2 += '<option value="Take Aways of the Session">Take Aways of the Session</option>';
				cmth4_l2 += '<option value="Opt in to be confirmed">Opt in to be confirmed</option>';
				$("#cuemath_script_l2").html(cmth4_l2);
			}else if($(this).val()=='Selling Skill'){
				var cmth5_l2 = '<option value="Convincing Skills / Creating need">Convincing Skills / Creating need</option>';
				cmth5_l2 += '<option value="Objection Handling & Effective  rebuttals">Objection Handling & Effective  rebuttals</option>';
				$("#cuemath_script_l2").html(cmth5_l2);
			}else if($(this).val()=='Closing'){
				var cmth6_l2 = '<option value="Proper Closing">Proper Closing</option>';
				cmth6_l2 += '<option value="Proper Closing of Nls">Proper Closing of Nls</option>';
				cmth6_l2 += '<option value="Disposition">Disposition</option>';
				$("#cuemath_script_l2").html(cmth6_l2);
			}
		});


		$(".niAudit").on('change', function(){
			var ni_acpt1 = '<option value="">Select</option>';
			ni_acpt1 += '<option value="Agent">Agent</option>';
			ni_acpt1 += '<option value="Customer">Customer</option>';
			ni_acpt1 += '<option value="Process">Process</option>';
			ni_acpt1 += '<option value="Technology">Technology</option>';
			$(".demoStatusACPT1").html(ni_acpt1);

			$(".demoStatusACPT2").html('<option value="">Select</option>');
		});

		$('#cuemath_script_acpt').on('change', function(){
			if($(this).val()=='Agent'){
				if($(".niAudit").val()=="NI Audit"){
					var cmth_acpt1 = '<option value="Convincing Skill & Probing Missing">Convincing Skill & Probing Missing</option>';
					cmth_acpt1 += '<option value="Lack Of Confidence">Lack Of Confidence</option>';
					cmth_acpt1 += '<option value="Customer did not want to listen">Customer did not want to listen</option>';
					cmth_acpt1 += '<option value="Incorrect Disposition">Incorrect Disposition</option>';
					cmth_acpt1 += '<option value="Re-attempt_Fails to arrange the call back">Re-attempt_Fails to arrange the call back</option>';
					cmth_acpt1 += '<option value="Rebuttal not shared">Rebuttal not shared</option>';
					cmth_acpt1 += '<option value="Casual approach on call">Casual approach on call</option>';
				}else{
					var cmth_acpt1 = '<option value="Did not state pupose of the call">Did not state pupose of the call</option>';
					cmth_acpt1 += '<option value="Convincing Skill & Probing Missing">Convincing Skill & Probing Missing</option>';
					cmth_acpt1 += '<option value="Lack Of Confidence">Lack Of Confidence</option>';
					cmth_acpt1 += '<option value="Customer did not want to listen">Customer did not want to listen</option>';
					cmth_acpt1 += '<option value="Customer Hang up the call (Agent Opportunity)">Customer Hang up the call (Agent Opportunity)</option>';
					cmth_acpt1 += '<option value="Customer is not aware about the registration">Customer is not aware about the registration</option>';
					cmth_acpt1 += '<option value="Incorrect Disposition">Incorrect Disposition</option>';
					cmth_acpt1 += '<option value="Re-attempt_Fails to arrange the call back">Re-attempt_Fails to arrange the call back</option>';
					cmth_acpt1 += '<option value="Force selling">Force selling</option>';
					cmth_acpt1 += '<option value="Incorrect/Incomplete information captured">Incorrect/Incomplete information captured</option>';
					cmth_acpt1 += '<option value="Incorrect/Incomplete information Shared">Incorrect/Incomplete information Shared</option>';
				}
				$("#cuemath_script_acpt_reason").html(cmth_acpt1);
			}else if($(this).val()=='Process'){
				if($(".niAudit").val()=="NI Audit"){
					var cmth_acpt2 = '<option value="Grade wise not eligible">Grade wise not eligible</option>';
					cmth_acpt2 += '<option value="Wrong Number">Wrong Number</option>';
					cmth_acpt2 += '<option value="Language barrier">Language barrier</option>';
					cmth_acpt2 += '<option value="Technical requisitions is not available with customer">Technical requisitions is not available with customer</option>';
					cmth_acpt2 += '<option value="Time slot limitation">Time slot limitation</option>';
					cmth_acpt2 += '<option value="Not interested due to previous poor service experience">Not interested due to previous poor service experience</option>';
				}else{
					var cmth_acpt2 = '<option value="Registered by Mistake">Registered by Mistake</option>';
					cmth_acpt2 += '<option value="Customer Did not have computer">Customer Did not have computer</option>';
					cmth_acpt2 += '<option value="Grade wise not eligible">Grade wise not eligible</option>';
					cmth_acpt2 += '<option value="Wrong Number">Wrong Number</option>';
					cmth_acpt2 += '<option value="Language barrier">Language barrier</option>';
				}
				$("#cuemath_script_acpt_reason").html(cmth_acpt2);
			}else if($(this).val()=='Customer'){
				if($(".niAudit").val()=="NI Audit"){
					var cmth_acpt3 = '<option value="Already done demo or enrolled">Already done demo or enrolled</option>';
					cmth_acpt3 += '<option value="Customer Hang up the call (No VOC)">Customer Hang up the call (No VOC)</option>';
					cmth_acpt3 += '<option value="Customer does not have a child">Customer does not have a child</option>';
					cmth_acpt3 += '<option value="Customer is absolutely not interested">Customer is absolutely not interested</option>';
					cmth_acpt3 += '<option value="Customer already enrolled into something else">Customer already enrolled into something else</option>';
					cmth_acpt3 += '<option value="Does not want to enroll now">Does not want to enroll now</option>';
					cmth_acpt3 += '<option value="Customer wants the Service  for Free">Customer wants the Service  for Free</option>';
					cmth_acpt3 += '<option value="Someone Tested Positive For Covid 19">Someone Tested Positive For Covid 19</option>';
					cmth_acpt3 += '<option value="Customer is busy right now">Customer is busy right now</option>';
					cmth_acpt3 += '<option value="Interested in other competitors">Interested in other competitors</option>';
					cmth_acpt3 += '<option value="Guardian not available">Guardian not available</option>';
					cmth_acpt3 += '<option value="Children above class 9">Children above class 9</option>';
				}else{
					var cmth_acpt3 = '<option value="Already done demo or enrolled">Already done demo or enrolled</option>';
					cmth_acpt3 += '<option value="Customer Hang up the call (No VOC)">Customer Hang up the call (No VOC)</option>';
					cmth_acpt3 += '<option value="Customer does not have a child">Customer does not have a child</option>';
					cmth_acpt3 += '<option value="Customer is absolutely not interested">Customer is absolutely not interested</option>';
					cmth_acpt3 += '<option value="Customer already enrolled into something else">Customer already enrolled into something else</option>';
					cmth_acpt3 += '<option value="Does not want to enroll now">Does not want to enroll now</option>';
					cmth_acpt3 += '<option value="Job_Applied for faculity">Job_Applied for faculity</option>';
					cmth_acpt3 += '<option value="Customer want the Service  for Free">Customer want the Service  for Free</option>';
					cmth_acpt3 += '<option value="Someone Tested Positive For Covid 19">Someone Tested Positive For Covid 19</option>';
				}
				$("#cuemath_script_acpt_reason").html(cmth_acpt3);
			}else if($(this).val()=='Technology'){
				if($(".niAudit").val()=="NI Audit"){
					var cmth_acpt4 = '<option value="System Issue">System Issue</option>';
					cmth_acpt4 += '<option value="Bad Connection">Bad Connection</option>';
				}else{
					var cmth_acpt4 = '<option value="Call Drop">Call Drop</option>';
					cmth_acpt4 += '<option value="Bad Connection">Bad Connection</option>';
				}
				$("#cuemath_script_acpt_reason").html(cmth_acpt4);
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
				for (var i in json_obj){
					if($('#tl_names').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_names').append($('#tl_names').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				}  
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
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'mp4':
        case 'mp3':
		case 'wav':
		case 'm4a':
			$('#qaformsubmit').attr('disabled', false);
        break;
        default:
            alert('This is not an allowed file type. Please upload allowed file type like [m4a,mp4,mp3,wav]');
            this.value = '';
    }
});
</script>

<script type="text/javascript">
	
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
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
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
			
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			}

		}
	}
</script>

<script>
	// function checkDec(el){
	// 	var ex = /^[0-9]+\.?[0-9]*$/;
	// 	if(ex.test(el.value)==false){
	// 		el.value = el.value.substring(0,el.value.length - 1);
	// 	}
	// }

	function checkDec(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$("#qaformsubmit").attr("disabled", "disabled");
				$('#phone').val("");
				return false;
			}
			if(el.value.length >10){
       			//alert("required 10 digits, match requested format!");
       			$("#start_phone").html("Required 10 digits, match requested format!");
       			$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }else if(el.value.length <10){
		    	$("#start_phone").html("Phone number can not be less than 10 digits!");
		    	$("#qaformsubmit").attr("disabled", "disabled");
       			return false;
		    }
		    else if(el.value.length == 10){
		    	$("#start_phone").html("");
		    	 $("#qaformsubmit").removeAttr("disabled");
       			return false;
		    }
		    // else{
		    // 	$("#start_phone").html("");
		    // 	 $("#qaformsubmit").removeAttr("disabled");
		    // }
			console.log(el.value);
		}
</script>


<script>
/*------------ Nilkanta (05/07/2021) --------------*/
	function demo_script_calc(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.edutech').each(function(index,element){
			var score_type = $(element).val();
			//alert(score_type);
			if(score_type=='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('edu_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type=='No'){
				var weightage = parseFloat($(element).children("option:selected").attr('edu_val'));
				scoreable = scoreable + weightage;
			}else if(score_type=='NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('edu_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type=='Fatal'){
				$('#cuemath_scriptScore1').val('0'+'%');
			}
		});

		totalscore = ((score*100)/scoreable).toFixed(2);

		if($('#cmthScriptAF10').val()=='Fatal'|| $('#cmthScriptAF14').val()=='Fatal' || $('#cmthScriptAF15').val()=='Fatal' || $('#cmthScriptAF19').val()=='Fatal' || $('#cmthScriptAF21').val()=='Fatal'){
			$('#cuemath_scriptScore1').val('0'+'%');
		     }else{
				if(!isNaN(totalscore)){
				if(!isNaN(score)){
			   	$("#cuemath_scriptEarned1").val(score);
			    }

			   if(!isNaN(scoreable)){
				$("#cuemath_scriptPossible1").val(scoreable);
			    }
			    $('#cuemath_scriptScore1').val(totalscore+'%');
			    }

		     }

	}

    $(document).on('change','.edutech',function(){
		demo_script_calc();
    });
	demo_script_calc();
</script>

<script>
/*------------ Nilkanta (12/07/2021) Use for Score card --------------*/
	function scorecard_script_calc(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.amd_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Effective'){
				var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type=='Unacceptable'){
				var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
				scoreable = scoreable + weightage;
			}else if(score_type=='N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('amd_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type=='Fatal'){
				$('#cuemath_scriptScore1').val('0'+'%');
			}
		});

		totalscore = ((score*100)/scoreable).toFixed(2);

		if($('#foodsaverAF1').val()=='Fatal'|| $('#foodsaverAF2').val()=='Fatal' || $('#foodsaverAF3').val()=='Fatal' || $('#foodsaverAF4').val()=='Fatal'){
			    $('#fb_overallScore').val('0'+'%');
		     }else{
				if(!isNaN(totalscore)){

				if(!isNaN(score)){
			   	//$("#fb_earnedScore").val(score);
			    }

			   if(!isNaN(scoreable)){
				//$("#fb_possibleScore").val(scoreable);
			    }
			    $('#fb_overallScore').val(totalscore+'%');

			    }

		     }

	}

	$(document).on('change','.amd_point',function(){
		scorecard_script_calc();
    });
	//scorecard_script_calc();
</script>
<script>
/*------------ Amir (05/07/2021) --------------*/
///////////////// BUC ///////////////////////
	function buc_calc(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.care_point').each(function(index,element){
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
			}else if(score_type == '3' || score_type == '2' || score_type == '1' || score_type == '0'){
			    var weightage = parseFloat($(element).children("option:selected").attr('care_val'));
			    score = score + weightage;
			    scoreable = scoreable + 3;
			}

		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#fb_earnedScore').val(score);
		$('#fb_possibleScore').val(scoreable);
		if(!isNaN(quality_score_percent)){
			$('#buc_overall_score').val(quality_score_percent+'%');

		}

	}

	$(document).on('change','.care_point',function(){
		buc_calc();
	});
	buc_calc();

</script>


<script>
///////////////// AJIO ///////////////////////
	function ajio_calc()
	{
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.ajio').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('ajio_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('ajio_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == 'No'){
			    var w1 = parseFloat($(element).children("option:selected").attr('ajio_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('ajio_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else if(score_type == 'N/A'){
			    var w1 = parseFloat($(element).children("option:selected").attr('ajio_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('ajio_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}else{
			    var w1 = parseFloat($(element).children("option:selected").attr('ajio_val'));
			    var w2 = parseFloat($(element).children("option:selected").attr('ajio_max'));
			    score = score + w1;
			    scoreable = scoreable + w2;
			}

		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}
	///////////////////////////
		var fatal_count=0;
		$('.fatal').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='Autofail'){
				fatal_count=fatal_count+1;
			}
		});
		$('#fatalcount').val(fatal_count);
		
		if(!isNaN(quality_score_percent)){
			$('#prefatal').val(quality_score_percent);
		}
	////////////////
		// if($('#ajioAF1').val()=='Autofail' || $('#ajioAF2').val()=='Autofail' || $('#ajioAF3').val()=='Autofail' || $('#ajioAF4').val()=='Autofail' || $('#ajioAF5').val()=='Autofail' || $('#ajioAF6').val()=='Autofail' || $('#ajioAF7').val()=='Autofail' || $('#ajioAF8').val()=='Autofail'){
		// 	$('.ajio_inb_v2Fatal').val(0);
		// }else{
		// 	$('.ajio_inb_v2Fatal').val(quality_score_percent+'%');
		// }
		if($('.ajioAF1').val()=='Autofail' || $('.ajioAF2').val()=='Autofail' || $('.ajioAF3').val()=='Autofail' || $('.ajioAF4').val()=='Autofail' || $('.ajioAF5').val()=='Autofail' || $('.ajioAF6').val()=='Autofail' || $('.ajioAF7').val()=='Autofail' || $('.ajioAF8').val()=='Autofail'){
			$('.ajio_inb_v2Fatal').val(0);
		}else{
			$('.ajio_inb_v2Fatal').val(quality_score_percent+'%');
		}
		if($('#ajioAF1').val()=='Autofail' || $('#ajioAF2').val()=='Autofail' || $('#ajioAF3').val()=='Autofail' || $('#ajioAF4').val()=='Autofail' || $('#ajioAF5').val()=='Autofail' || $('#ajioAF6').val()=='Autofail' || $('#ajioAF7').val()=='Autofail' || $('#ajioAF8').val()=='Autofail'){
			$('.ajio_email_v2Fatal').val(0);
		}else{
			$('.ajio_email_v2Fatal').val(quality_score_percent+'%');
		}
		if($('.ajioAF1').val()=='Autofail' || $('.ajioAF2').val()=='Autofail' || $('.ajioAF3').val()=='Autofail' || $('.ajioAF4').val()=='Autofail' || $('.ajioAF5').val()=='Autofail' || $('.ajioAF6').val()=='Autofail'){
			$('.ajio_chat_v2Fatal').val(0);
		}else{
			$('.ajio_chat_v2Fatal').val(quality_score_percent+'%');
		}
		if($('.ajioAF1').val()=='Autofail' || $('.ajioAF2').val()=='Autofail' || $('.ajioAF3').val()=='Autofail' || $('.ajioAF4').val()=='Autofail' || $('.ajioAF5').val()=='Autofail' || $('.ajioAF6').val()=='No'){
			$('.ajio_ccsrvoice_Fatal').val(0);
		}else{
			$('.ajio_ccsrvoice_Fatal').val(quality_score_percent+'%');
		}
		if($('.ajioAF1').val()=='Autofail' || $('.ajioAF2').val()=='Autofail' || $('.ajioAF3').val()=='Autofail' || $('.ajioAF4').val()=='Autofail' || $('.ajioAF5').val()=='Autofail' || $('.ajioAF6').val()=='Autofail'){
			$('.ajio_ccsr_nonvoice_Fatal').val(0);
		}else{
			$('.ajio_ccsr_nonvoice_Fatal').val(quality_score_percent+'%');
		}	

	}

	$(document).on('change','.ajio',function(){
		ajio_calc();
	});
	ajio_calc();

	/////////////////////////////////////////
	$('#appropriate_acknowledgements').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Failed to assure the customer when needed">Failed to assure the customer when needed</option>';
			sub_infractions += '<option value="Courtesy Statement missing">Courtesy Statement missing</option>';
			sub_infractions += '<option value="Apology statement missing">Apology statement missing</option>';
			sub_infractions += '<option value="Incorrect acknowledgement used">Incorrect acknowledgement used</option>';
			$("#appropriate").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#appropriate").html(sub_infractions);
		}
		else{
			$("#appropriate").html('');
		}
	});

	$('#address_customer_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Personalization not done">Personalization not done</option>';
			$("#address_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#address_inb_v2").html(sub_infractions);
		}
		else{
			$("#address_inb_v2").html('');
		}
	});

	$('#appropriate_acknowledgements_chat').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="FRT is >10 seconds">FRT is >10 seconds</option>';
			sub_infractions += '<option value="Opening script not followed">Opening script not followed</option>';
			$("#appropriate").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#appropriate").html(sub_infractions);
		}
		else{
			$("#appropriate").html('');
		}
	});

	$('#appropriate_acknowledgements_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Opening script not followed as per Process">Opening script not followed as per Process</option>';
			sub_infractions += '<option value="Seek permission to continue">Seek permission to continue</option>';
			sub_infractions += '<option value="Self intro & Branding">Self intro & Branding</option>';
			sub_infractions += '<option value="Personalization">Personalization</option>';
			sub_infractions += '<option value="Opening script not followed">Opening script not followed</option>';
			$("#appropriate_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#appropriate_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#appropriate_ccsrvoice").html('');
		}
	});

	$('#appropriate_acknowledgements_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Failed to assure the customer when needed">Failed to assure the customer when needed</option>';
			sub_infractions += '<option value="Courtesy Statement missing ">Courtesy Statement missing</option>';
			sub_infractions += '<option value="Apology statement missing ">Apology statement missing </option>';
			sub_infractions += '<option value="Incorrect acknowledgement used">Incorrect acknowledgement used</option>';
			$("#appropriat_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#appropriat_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#appropriat_ccsrnonvoice").html('');
		}
	});


	$('#font_size_formatting').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Incorrect Font Size">Incorrect Font Size</option>';
			sub_infractions += '<option value="Incorrect font Color">Incorrect font Color</option>';
			sub_infractions += '<option value="Incorrect font style">Incorrect font style</option>';
			sub_infractions += '<option value="Champ mentions date in mm-dd-yyyy">Champ mentions date in mm-dd-yyyy</option>';
			sub_infractions += '<option value="Prefix is not aligned">Prefix is not aligned</option>';
			sub_infractions += '<option value="Comma is missing after the month">Comma is missing after the month</option>';
			sub_infractions += '<option value="Champ change the subject line as its not allowed">Champ change the subject line as its not allowed</option>';
			sub_infractions += '<option value="Responded without trail">Responded without trail</option>';
			$("#font_size").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#font_size").html(sub_infractions);
		}
		else{
			$("#font_size").html('');
		}
	});
	
	$('#font_size_formatting_chat').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Failed to assure the customer when needed">Failed to assure the customer when needed</option>';
			sub_infractions += '<option value="Did not empathize when needed">Did not empathize when needed</option>';
			sub_infractions += '<option value="Incorrect acknowledgement used">Incorrect acknowledgement used</option>';
			$("#font_size").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#font_size").html(sub_infractions);
		}
		else{
			$("#font_size").html('');
		}
	});

	$('#font_size_formatting_cccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Incorrect Font Size">Incorrect Font Size</option>';
			sub_infractions += '<option value="Incorrect font Color">Incorrect font Color</option>';
			sub_infractions += '<option value="Incorrect font style">Incorrect font style</option>';
			sub_infractions += '<option value="Champ mentions date in mm-dd-yyyy">Champ mentions date in mm-dd-yyyy</option>';
			sub_infractions += '<option value="Prefix is not aligned ">Prefix is not aligned </option>';
			sub_infractions += '<option value="Comma is missing after the month">Comma is missing after the month</option>';
			sub_infractions += '<option value="Champ change the subject line as its not allowed">Champ change the subject line as its not allowed</option>';
			sub_infractions += '<option value="Responded without trail">Responded without trail</option>';
		$("#font_size_cccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#font_size_cccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#font_size_cccsrnonvoice").html('');
		}
	});

	$('#polite_appology_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Courtesy statement missing on call">Courtesy statement missing on call</option>';
			sub_infractions += '<option value="Courtesy statement used but misplaced">Courtesy statement used but misplaced</option>';
			sub_infractions += '<option value="Effective assurance missing on call">Effective assurance missing on call</option>';
			sub_infractions += '<option value="Pleasantries missing on call">Pleasantries missing on call</option>';
			$("#appology_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#appology_inb_v2").html(sub_infractions);
		}
		else{
			$("#appology_inb_v2").html('');
		}
	});
	
	$('#comprehend_concern_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Asked unnecessary/irrelevant questions">Asked unnecessary/irrelevant questions</option>';
			sub_infractions += '<option value="Asked details already available">Asked details already available</option>';
			sub_infractions += '<option value="Unable to comprehend">Unable to comprehend</option>';
			sub_infractions += '<option value="Failed to paraphrase to ensure understanding">Failed to paraphrase to ensure understanding</option>';
			sub_infractions += '<option value="Necessary probing not done">Necessary probing not done</option>';
			$("#comprehend_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#comprehend_inb_v2").html(sub_infractions);
		}
		else{
			$("#comprehend_inb_v2").html('');
		}
	});

	$('#listening_skill_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ made the customer repeat">Champ made the customer repeat</option>';
			sub_infractions += '<option value="Did not listen actively impacting the call">Did not listen actively impacting the call </option>';
			$("#skill_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#skill_inb_v2").html(sub_infractions);
		}
		else{
			$("#skill_inb_v2").html('');
		}
	});

	$('#handle_objection_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Poor objection handling">Poor objection handling</option>';
			$("#objection_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#objection_inb_v2").html(sub_infractions);
		}
		else{
			$("#objection_inb_v2").html('');
		}
	});
	
	$('#express_himself_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ was struggling to express himself">Champ was struggling to express himself</option>';
			sub_infractions += '<option value="Champ swtiched language to express himself">Champ swtiched language to express himself</option>';
			sub_infractions += '<option value="Customer expressed difficulty in understanding the champ">Customer expressed difficulty in understanding the champ</option>';
			sub_infractions += '<option value="Used fillers/Jargons">Used fillers/Jargons</option>';
			$("#himself_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#himself_inb_v2").html(sub_infractions);
		}
		else{
			$("#himself_inb_v2").html('');
		}
	});
	
	$('#releavnt_article_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="KM not adhered">KM not adhered</option>';
			sub_infractions += '<option value="KM followed but complete T2R/leg not followed">KM followed but complete T2R/leg not followed</option>';
			sub_infractions += '<option value="KM opened but not followed">KM opened but not followed</option>';
			$("#article_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#article_inb_v2").html(sub_infractions);
		}
		else{
			$("#article_inb_v2").html('');
		}
	});

	$('#different_application_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Not refer to available option on Cockpit (Cockpit Navigation not done properly)">Not refer to available option on Cockpit (Cockpit Navigation not done properly)</option>';
			sub_infractions += '<option value="Did not refer to 3PL portal">Did not refer to 3PL portal</option>';
			$("#application_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#application_inb_v2").html(sub_infractions);
		}
		else{
			$("#application_inb_v2").html('');
		}
	});
	
	$('#navigate_through_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="No navigation observed during hold">No navigation observed during hold</option>';
			sub_infractions += '<option value="Viewed application/s not relevent to the interaction - Impacted AHT">Viewed application/s not relevent to the interaction - Impacted AHT</option>';
			sub_infractions += '<option value="Didn\'t transfer the call to TNPS survey after pitching script - >2 seconds">Didn\'t transfer the call to TNPS survey after pitching script - >2 seconds</option>';
			$("#through_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#through_inb_v2").html(sub_infractions);
		}
		else{
			$("#through_inb_v2").html('');
		}
	});
	
	
	$('#email_response').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ use alternative template">Champ use alternative template</option>';
			sub_infractions += '<option value="Champ use his own tamplete">Champ use his own tamplete</option>';
			$("#email_res").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#email_res").html(sub_infractions);
		}
		else{
			$("#email_res").html('');
		}
	});

	$('#approved_template_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ use alternative template">Champ use alternative template</option>';
			sub_infractions += '<option value="Champ use his own tamplete">Champ use his own tamplete</option>';
			$("#approved_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#approved_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#approved_ccsrnonvoice").html('');
		}
	});

	$('#chat_response').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Hold was not released within the stipulated timeline (1 min)">Hold was not released within the stipulated timeline (1 min)</option>';
			sub_infractions += '<option value="Hold script/procedure not adhered">Hold script/procedure not adhered</option>';
			sub_infractions += '<option value="Dead Air (60secs)/ 120secs in entire chat">Dead Air (60secs)/ 120secs in entire chat</option>';
			$("#chat_res").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#chat_res").html(sub_infractions);
		}
		else{
			$("#chat_res").html('');
		}
	});

	$('#ajioAF1').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Customization not done as per customer VOC">Customization not done as per customer VOC</option>';
			sub_infractions += '<option value="Addition of template is missing when requierd">Addition of template is missing when requierd</option>';
			$("#ajioAFone").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ajioAFone").html(sub_infractions);
		}
		else{
			$("#ajioAFone").html('');
		}
	});

	$('#ajioAF1_inb_v2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Delayed opening breched 10sec">Delayed opening breched 10sec</option>';
			sub_infractions += '<option value="Delayed opening breched 4sec">Delayed opening breched 4sec</option>';
			sub_infractions += '<option value="Opening not given as per AJIO prescribe">Opening not given as per AJIO prescribe</option>';
			$("#AF1_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#AF1_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="Delayed opening breched 10sec">Delayed opening breched 10sec</option>';
			sub_infractions += '<option value="Delayed opening breched 4sec">Delayed opening breched 4sec</option>';
			sub_infractions += '<option value="Opening not given as per AJIO prescribe">Opening not given as per AJIO prescribe</option>';
			$("#AF1_inb_v2").html(sub_infractions);
		}
		else{
			$("#AF1_inb_v2").html('');
		}
	});

	$('#ajioAF2_inb_v2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Hold not refreshed within 1 min">Hold not refreshed within 1 min</option>';
			sub_infractions += '<option value="Dead air observed more then 10 sec">Dead air observed more then 10 sec</option>';
			sub_infractions += '<option value="Hold/Unhold script not followed">Hold/Unhold script not followed</option>';
			sub_infractions += '<option value="Uninformed hold">Uninformed hold</option>';
			sub_infractions += '<option value="Call dropped due to hold not refreshed within 1 min">Call dropped due to hold not refreshed within 1 min </option>';
			$("#AF2_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="Hold not refreshed within 1 min">Hold not refreshed within 1 min</option>';
			sub_infractions += '<option value="Dead air observed more then 10 sec">Dead air observed more then 10 sec</option>';
			sub_infractions += '<option value="Hold/Unhold script not followed">Hold/Unhold script not followed</option>';
			sub_infractions += '<option value="Uninformed hold">Uninformed hold</option>';
			sub_infractions += '<option value="Call dropped due to hold not refreshed within 1 min">Call dropped due to hold not refreshed within 1 min </option>';
			$("#AF2_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#AF2_inb_v2").html(sub_infractions);
		}
		else{
			$("#AF2_inb_v2").html('');
		}
	});

	$('#ajioAF3_inb_v2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Further assistance ot pitched">Further assistance ot pitched</option>';
			sub_infractions += '<option value="TNPS not pitched">TNPS not pitched</option>';
			sub_infractions += '<option value="Closing Script not followed">Closing Script not followed</option>';
			sub_infractions += '<option value="TNPS script not adhered as per AJIO guideline">TNPS script not adhered as per AJIO guideline</option>';
			sub_infractions += '<option value="Influenced for positive ratings">Influenced for positive ratings</option>';
			sub_infractions += '<option value="Took >2 seconds to disconnect the call after TNPS pitch">Took >2 seconds to disconnect the call after TNPS pitch</option>';
			sub_infractions += '<option value="Call disconnected from Genesys">Call disconnected from Genesys</option>';
			$("#AF3_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="Further assistance ot pitched">Further assistance ot pitched</option>';
			sub_infractions += '<option value="TNPS not pitched">TNPS not pitched</option>';
			sub_infractions += '<option value="Closing Script not followed">Closing Script not followed</option>';
			sub_infractions += '<option value="TNPS script not adhered as per AJIO guideline">TNPS script not adhered as per AJIO guideline</option>';
			sub_infractions += '<option value="Influenced for positive ratings">Influenced for positive ratings</option>';
			sub_infractions += '<option value="Took >2 seconds to disconnect the call after TNPS pitch">Took >2 seconds to disconnect the call after TNPS pitch</option>';
			sub_infractions += '<option value="Call disconnected from Genesys">Call disconnected from Genesys</option>';
			$("#AF3_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#AF3_inb_v2").html(sub_infractions);
		}
		else{
			$("#AF3_inb_v2").html('');
		}
	});

	$('#ajioAF4_inb_v2').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Authentication not done when required">Authentication not done when required</option>';
			sub_infractions += '<option value="Authentication done when not required">Authentication done when not required</option>';
			sub_infractions += '<option value="Information shared when authentication failed">Information shared when authentication failed</option>';
			sub_infractions += '<option value="Information denied even clearing authentication">Information denied even clearing authentication</option>';
			$("#AF4_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#AF4_inb_v2").html(sub_infractions);
		}
		else{
			$("#AF4_inb_v2").html('');
		}
	});

	$('#ajioAF5_inb_v2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Wrong Action Taken">Wrong Action Taken</option>';
			$("#AF5_inb_v2").html(sub_infractions);
		}else if($(this).val()=='No'){
			var sub_infractions = '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Wrong Action Taken">Wrong Action Taken</option>';
			$("#AF5_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#AF5_inb_v2").html(sub_infractions);
		}
		else{
			$("#AF5_inb_v2").html('');
		}
	});

	$('#ajioAF6_inb_v2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Incorrect information Shared">Incorrect information Shared</option>';
			sub_infractions += '<option value="Incomplete information Shared">Incomplete information Shared</option>';
			sub_infractions += '<option value="Wrong Action Taken">Wrong Action Taken</option>';
			$("#AF6_inb_v2").html(sub_infractions);
		}else if($(this).val()=='No'){
			var sub_infractions = '<option value="Incorrect information Shared">Incorrect information Shared</option>';
			sub_infractions += '<option value="Incomplete information Shared">Incomplete information Shared</option>';
			sub_infractions += '<option value="Wrong Action Taken">Wrong Action Taken</option>';
			$("#AF6_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#AF6_inb_v2").html(sub_infractions);
		}
		else{
			$("#AF6_inb_v2").html('');
		}
	});

	$('#ajioAF7_inb_v2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="CAM rule not adhered to.">CAM rule not adhered to.</option>';
			sub_infractions += '<option value="Issue not documented">Issue not documented</option>';
			sub_infractions += '<option value="Issue documented wrong">Issue documented wrong</option>';
			$("#AF7_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="CAM rule not adhered to.">CAM rule not adhered to.</option>';
			sub_infractions += '<option value="Issue not documented">Issue not documented</option>';
			sub_infractions += '<option value="Issue documented wrong">Issue documented wrong</option>';
			$("#AF7_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#AF7_inb_v2").html(sub_infractions);
		}
		else{
			$("#AF7_inb_v2").html('');
		}
	});


	$('#ajioAF8_inb_v2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Call Avoidance">Call Avoidance</option>';
			sub_infractions += '<option value="Call disconnection">Call disconnection</option>';
			sub_infractions += '<option value="Abusive behaviour">Abusive behaviour</option>';
			sub_infractions += '<option value="Mocking the coustomer">Mocking the coustomer</option>';
			sub_infractions += '<option value="Rude behaviour on call">Rude behaviour on call</option>';
			$("#AF8_inb_v2").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#AF8_inb_v2").html(sub_infractions);
		}
		else{
			$("#AF8_inb_v2").html('');
		}
	});

	$('#ajioAF1_ccsrvoice').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Champ did not make all 3 valid attempts">Champ did not make all 3 valid attempts</option>';
			sub_infractions += '<option value="Champ did not send closure email in case of unsuccessful attempt">Champ did not send closure email in case of unsuccessful attempt</option>';
			sub_infractions += '<option value="OB attempts not done as per interval guidelines">OB attempts not done as per interval guidelines</option>';
			sub_infractions += '<option value="Incomplete call if call disconnected : OB call not made">Incomplete call if call disconnected : OB call not made</option>';
			$("#font_size_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#font_size_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#font_size_ccsrvoice").html('');
		}
	});

	$('#use_appropriate_template_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Closing script not allowed">Closing script not allowed</option>';
			sub_infractions += '<option value="FA missing">FA missing</option>';
			$("#ccsrvoice_res").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ccsrvoice_res").html(sub_infractions);
		}
		else{
			$("#ccsrvoice_res").html('');
		}
	});

	$('#seamlessly_chat').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ was struggling to express himself">Champ was struggling to express himself</option>';
			sub_infractions += '<option value="Customer expressed difficulty in understanding the champ">Customer expressed difficulty in understanding the champ</option>';
			$("#seam_chat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#seam_chat").html(sub_infractions);
		}
		else{
			$("#seam_chat").html('');
		}
	});
	
	$('#seamlessly_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Apology used but misplaced">Apology used but misplaced</option>';
			sub_infractions += '<option value="Did not provide effective assurance">Did not provide effective assurance</option>';
			sub_infractions += '<option value="Did not acknowledge/apologize when required">Did not acknowledge/apologize when required</option>';
			sub_infractions += '<option value="Lack of pleasantries ">Lack of pleasantries </option>';
			$("#seam_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#seam_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#seam_ccsrvoice").html('');
		}
	});

	$('#seamlessly_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ used Complicated language/statements">Champ used Complicated language/statements</option>';
			sub_infractions += '<option value="Champ used jargons">Champ used jargons</option>';
			sub_infractions += '<option value="Poor sentence construction">Poor sentence construction</option>';
			sub_infractions += '<option value="Used multiple statements/Repetitive words">Used multiple statements/Repetitive words</option>';
			sub_infractions += '<option value="Spacing issue">Spacing issue</option>';
			sub_infractions += '<option value="Gramatical errors">Gramatical errors</option>';
			sub_infractions += '<option value="Spelling mistakes">Spelling mistakes</option>';
			sub_infractions += '<option value="Punctuation error">Punctuation error</option>';
			sub_infractions += '<option value="Specification of comma is not used properly">Specification of comma is not used properly</option>';
			sub_infractions += '<option value="Capitalization error">Capitalization error</option>';
			$("#seam_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#seam_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#seam_ccsrnonvoice").html('');
		}
	});

	$('#written_communication').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ used Complicated language/statements">Champ used Complicated language/statements</option>';
			sub_infractions += '<option value="Champ used jargons">Champ used jargons</option>';
			sub_infractions += '<option value="Poor sentence construction">Poor sentence construction</option>';
			sub_infractions += '<option value="Used multiple statements/Repetitive words">Used multiple statements/Repetitive words</option>';
			sub_infractions += '<option value="Spacing issue">Spacing issue</option>';
			sub_infractions += '<option value="AGramatical errors">Gramatical errors</option>';
			sub_infractions += '<option value="Spelling mistakes">Spelling mistakes</option>';
			sub_infractions += '<option value="Punctuation error">Punctuation error</option>';
			sub_infractions += '<option value="Specification of comma is not used properly">Specification of comma is not used properly</option>';
			$("#written_comm").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#written_comm").html(sub_infractions);
		}
		else{
			$("#written_comm").html('');
		}
	});

	$('#written_communication_chat').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Failed to offer further assistance">Failed to offer further assistance</option>';
			sub_infractions += '<option value="Did not pitch for Survey">Did not pitch for Survey</option>';
			sub_infractions += '<option value="Did not follow call closing script">Did not follow call closing script</option>';
			sub_infractions += '<option value="Did not follow call transfer guidelines">Did not follow call transfer guidelines</option>';
			sub_infractions += '<option value="Waiting for User timeline (90secs) not adhered">Waiting for User timeline (90secs) not adhered</option>';
			sub_infractions += '<option value="Delayed Closing">Delayed Closing</option>';
			sub_infractions += '<option value="N/A">N/A</option>';
			$("#written_comm").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#written_comm").html(sub_infractions);
		}
		else{
			$("#written_comm").html('');
		}
	});
	
	$('#written_communication_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Not able to comprehend the issue & failed to communicate as per stake holder resolution">Not able to comprehend the issue & failed to communicate as per stake holder resolution</option>';
			sub_infractions += '<option value="Asked unnecessary/irrelevant questions">Asked unnecessary/irrelevant questions</option>';
			sub_infractions += '<option value="Asked details already available">Asked details already available</option>';
			sub_infractions += '<option value="Unable to comprehend">Unable to comprehend</option>';
			sub_infractions += '<option value="Failed to paraphrase to ensure understanding">Failed to paraphrase to ensure understanding</option>';
			sub_infractions += '<option value="High rate of speech">High rate of speech</option>';
			sub_infractions += '<option value="Use of jargons">Use of jargons</option>';
			sub_infractions += '<option value="MTI">MTI</option>';
			$("#written_comm_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#written_comm_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#written_comm_ccsrvoice").html('');
		}
	});

	$('#written_communication_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ used Complicated language/statements">Champ used Complicated language/statements</option>';
			sub_infractions += '<option value="Champ used jargons">Champ used jargons</option>';
			sub_infractions += '<option value="Poor sentence construction">Poor sentence construction</option>';
			sub_infractions += '<option value="Used multiple statements/Repetitive words ">Used multiple statements/Repetitive words </option>';
			sub_infractions += '<option value="Spacing issue">Spacing issue</option>';
			sub_infractions += '<option value="Gramatical errors">Gramatical errors</option>';
			sub_infractions += '<option value="Spelling mistakes">Spelling mistakes</option>';
			sub_infractions += '<option value="Punctuation error">Punctuation error</option>';
			sub_infractions += '<option value="Specification of comma is not used properly">Specification of comma is not used properly</option>';
			sub_infractions += '<option value="Capitalization error">Capitalization error</option>';
			$("#written_comm_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#written_comm_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#written_comm_ccsrnonvoice").html('');
		}
	});

	$('#listening_skills_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="..................">....................</option>';
			$("#skills_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#skills_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#skills_ccsrvoice").html('');
		}
	});

	$('#ajioAF2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Champ failed to check all the previous mails">Champ failed to check all the previous mails</option>';
			sub_infractions += '<option value="Champ failed analysed the CS Cockpit status & Tickits">Champ failed analysed the CS Cockpit status & Tickits</option>';
			$("#relevant_previous").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#relevant_previous").html(sub_infractions);
		}
		else{
			$("#relevant_previous").html('');
		}
	});

	$('#ajioAF7').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Champ failed to check all the previous mails">Champ failed to check all the previous mails</option>';
			sub_infractions += '<option value="Champ failed analysed the CS Cockpit status & Tickits">Champ failed analysed the CS Cockpit status & Tickits</option>';
			$("#gather_information_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#gather_information_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#gather_information_ccsrnonvoice").html('');
		}
	});

	$('#ajioAF1_chat').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Self response  used instead of Haptik response">Self response  used instead of Haptik response</option>';
			sub_infractions += '<option value="Incorrect canned response used">Incorrect canned response used</option>';
			sub_infractions += '<option value="Free text not used when its required">Free text not used when its required</option>';
			$("#relevant_previous_chat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#relevant_previous_chat").html(sub_infractions);
		}
		else{
			$("#relevant_previous_chat").html('');
		}
	});

	$('#ajioAF1_ccsrnonvoice').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Customization not done as per customer VOC">Customization not done as per customer VOC</option>';
			sub_infractions += '<option value="Addition of template is missing when requierd">Addition of template is missing when requierd </option>';
			$("#appro_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#appro_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#appro_ccsrnonvoice").html('');
		}
	});

	$('#handle_objections').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Failed to address customers objection(s)/emotion(s)">Failed to address customers objection(s)/emotion(s)</option>';
			sub_infractions += '<option value="Brand building not done">Brand building not done</option>';
			sub_infractions += '<option value="Champ was unable understand objection">Champ was unable understand objection</option>';
			sub_infractions += '<option value="Did not use objection handling script/statement">Did not use objection handling script/statement</option>';
			sub_infractions += '<option value="Incorrect rebuttals Used">Incorrect rebuttals Used</option>';
			sub_infractions += '<option value="Incomplete rebuttals used">Incomplete rebuttals used</option>';
			$("#handle_obj").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#handle_obj").html(sub_infractions);
		}
		else{
			$("#handle_obj").html('');
		}
	});

	$('#offer_rebuttals_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Failed to address customers objection(s)/emotion(s)">Failed to address customers objection(s)/emotion(s)</option>';
			sub_infractions += '<option value="Brand building not done">Brand building not done</option>';
			sub_infractions += '<option value="Champ was unable understand objection">Champ was unable understand objection</option>';
			sub_infractions += '<option value="Did not use objection handling script/statement">Did not use objection handling script/statement</option>';
			sub_infractions += '<option value="Incorrect rebuttals Used">Incorrect rebuttals Used</option>';
			sub_infractions += '<option value="Incomplete rebuttals used">Incomplete rebuttals used</option>';
			$("#offer_rebu_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#offer_rebu_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#offer_rebu_ccsrnonvoice").html('');
		}
	});

	$('#communication_chat').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Incorrect sentence Structure">Incorrect sentence Structure</option>';
			sub_infractions += '<option value="incorrect spacing">incorrect spacing</option>';
			sub_infractions += '<option value="Grammatical error">Grammatical error</option>';
			sub_infractions += '<option value="Incorrect punctuation">Incorrect punctuation</option>';
			$("#commun_chat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#commun_chat").html(sub_infractions);
		}
		else{
			$("#commun_chat").html('');
		}
	});
	
	$('#communication_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Did not handle objection hadling script">Did not handle objection hadling script</option>';
			sub_infractions += '<option value="Alternative option not provided if required">Alternative option not provided if required</option>';
			$("#commun_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#commun_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#commun_ccsrvoice").html('');
		}
	});

	$('#communication_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Asked for information that was already available">Asked for information that was already available</option>';
			sub_infractions += '<option value="Did not use all means to enable resolution">Did not use all means to enable resolution</option>';
			sub_infractions += '<option value="Champ didn’t checked 3PL when requierd">Champ didn’t checked 3PL when requierd</option>';
			sub_infractions += '<option value="Champ didnt check different tabs of CS Cockpit">Champ didnt check different tabs of CS Cockpit</option>';
			sub_infractions += '<option value="Champ missed checking the basic pre checks before taking action">Champ missed checking the basic pre checks before taking action</option>';
			$("#commun_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#commun_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#commun_ccsrnonvoice").html('');
		}
	});

	$('#application_portals_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Asked for information that was already available">Asked for information that was already available</option>';
			sub_infractions += '<option value="Did not use all means to enable resolution">Did not use all means to enable resolution</option>';
			sub_infractions += '<option value="Champ didn’t checked 3PL when requierd">Champ didn’t checked 3PL when requierd</option>';
			sub_infractions += '<option value="Champ didnt check different tabs of CS Cockpit">Champ didnt check different tabs of CS Cockpit</option>';
			sub_infractions += '<option value="Champ missed checking the basic pre checks before taking action">Champ missed checking the basic pre checks before taking action</option>';
			$("#application_port_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#application_port_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#application_port_ccsrnonvoice").html('');
		}
	});

	$('#ajioAF2_chat').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Champ failed to check all the previous interactions">Champ failed to check all the previous interactions</option>';
			sub_infractions += '<option value="Champ failed to analyse CS-Cockpit and Tickets">Champ failed to analyse CS-Cockpit and Tickets</option>';
			$("#ajiochat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ajiochat").html(sub_infractions);
		}
		else{
			$("#ajiochat").html('');
		}
	});

	$('#ajioAF2_ccsrvoice').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Add Course correction not done when it was required New Ticket raised assigning">Add Course correction not done when it was required New Ticket raised assigning</option>';
			sub_infractions += '<option value="Complaint  Re open without mentioning reason of dispute">Complaint  Re open without mentioning reason of dispute</option>';
			sub_infractions += '<option value="Compliant did not Re-open when  required">Compliant did not Re-open when  required</option>';
			sub_infractions += '<option value="Complaint re open when not required">Complaint re open when not required</option>';
			sub_infractions += '<option value="Wrongly Reassign Ticket">Wrongly Reassign Ticket</option>';
			sub_infractions += '<option value="Incomplete/Inacorrect Remarks">Incomplete/Inacorrect Remarks</option>';
			sub_infractions += '<option value="Ticket not closed when required">Ticket not closed when required</option>';
			sub_infractions += '<option value="Ticket not Open when required">Ticket not Open when required</option>';
			sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			$("#ajio_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ajio_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#ajio_ccsrvoice").html('');
		}
	});

	$('#all_relevant_articles').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Incomplete Information Given as per KM">Incomplete Information Given as per KM</option>';
			sub_infractions += '<option value="Incorrect T2R Refferd">Incorrect T2R Refferd</option>';
			sub_infractions += '<option value="Wrong action was taken as per KM">Wrong action was taken as per KM</option>';
			sub_infractions += '<option value="Wrong tagging done">Wrong tagging done</option>';
			sub_infractions += '<option value="Incorrect Information">Incorrect Information</option>';
			$("#all_relevant").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#all_relevant").html(sub_infractions);
		}
		else{
			$("#all_relevant").html('');
		}
	});

	$('#releavnt_articles_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Cockpit navigation issue">Cockpit navigation issue</option>';
			sub_infractions += '<option value="KM not referred">KM not referred</option>';
			sub_infractions += '<option value="PL portal not referred">PL portal not referred</option>';
			sub_infractions += '<option value="CCSR SOP not adhere">CCSR SOP not adhere</option>';
			$("#articles_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#articles_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#articles_ccsrvoice").html('');
		}
	});

	$('#releavnt_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Incomplete Information Given as per KM">Incomplete Information Given as per KM</option>';
			sub_infractions += '<option value="Incorrect T2R Refferd ">Incorrect T2R Refferd </option>';
			sub_infractions += '<option value="Wrong action was taken as per KM">Wrong action was taken as per KM</option>';
			sub_infractions += '<option value="Wrong tagging done">Wrong tagging done</option>';
			sub_infractions += '<option value="Incorrect Information">Incorrect Information</option>';
			$("#rel_ccsr_nonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#rel_ccsr_nonvoice").html(sub_infractions);
		}
		else{
			$("#rel_ccsr_nonvoice").html('');
		}
	});

	$('#handle_objections_chat').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Failed to address customers objection(s)/emotion(s)">Failed to address customers objection(s)/emotion(s)</option>';
			sub_infractions += '<option value="Did not use objection handling script/statement">Did not use objection handling script/statement</option>';
			sub_infractions += '<option value="Inappropriate/Incorrect rebuttals provided">Inappropriate/Incorrect rebuttals provided</option>';
			$("#handle_obj_chat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#handle_obj_chat").html(sub_infractions);
		}
		else{
			$("#handle_obj_chat").html('');
		}
	});
	
	$('#handle_objections_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Previous interaction not checked">Previous interaction not checked </option>';
			sub_infractions += '<option value="Duplicate Ticket raised">Duplicate Ticket raised</option>';
			sub_infractions += '<option value="Previous Complaint not checked">Previous Complaint not checked</option>';
			sub_infractions += '<option value="Duplicate Ticket Raised">Duplicate Ticket Raised</option>';
			$("#handle_obj_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#handle_obj_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#handle_obj_ccsrvoice").html('');
		}
	});

	$('#handle_objections_ccsrnonvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Previous interaction not checked">Previous interaction not checked </option>';
			sub_infractions += '<option value="Duplicate Ticket Raised">Duplicate Ticket Raised</option>';
			$("#handle_obj_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#handle_obj_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#handle_obj_ccsrnonvoice").html('');
		}
	});

	$('#applications_portals').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Asked for information that was already available">Asked for information that was already available</option>';
			sub_infractions += '<option value="Did not use all means to enable resolution">Did not use all means to enable resolution</option>';
			sub_infractions += '<option value="Champ did not checked 3PL when requierd">Champ did not checked 3PL when requierd</option>';
			sub_infractions += '<option value="Champ did not check different tabs of CS Cockpit">Champ did not check different tabs of CS Cockpit</option>';
			sub_infractions += '<option value="Champ missed checking the basic pre checks before taking action">Champ missed checking the basic pre checks before taking action</option>';
			$("#applications_por").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#applications_por").html(sub_infractions);
		}
		else{
			$("#applications_por").html('');
		}
	});

	$('#releavnt_articles_chat').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Incomplete information given as per KM">Incomplete information given as per KM</option>';
			sub_infractions += '<option value="Incorrect T2R referred">Incorrect T2R referred</option>';
			sub_infractions += '<option value="Wrong action was taken as per KM">Wrong action was taken as per KM</option>';
			sub_infractions += '<option value="Wrong tagging done">Wrong tagging done</option>';
			sub_infractions += '<option value="Incorrect information">Incorrect information</option>';
			$("#all_relevantchat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#all_relevantchat").html(sub_infractions);
		}
		else{
			$("#all_relevantchat").html('');
		}
	});

	$('#ajio_ccsrnonvoiceAF2').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Add Course correction not done when it was required New Ticket raised assigning">Add Course correction not done when it was required New Ticket raised assigning</option>';
			sub_infractions += '<option value="Complaint  Re open without mentioning reason of dispute">Complaint  Re open without mentioning reason of dispute</option>';
			sub_infractions += '<option value="Compliant did not Re-open when  required">Compliant did not Re-open when  required</option>';
			sub_infractions += '<option value="Complaint re open when not required">Complaint re open when not required</option>';
			sub_infractions += '<option value="Wrongly Reassign Ticket">Wrongly Reassign Ticket</option>';
			sub_infractions += '<option value="Incomplete/Inacorrect Remarks">Incomplete/Inacorrect Remarks</option>';
			sub_infractions += '<option value="Ticket not closed when required">Ticket not closed when required</option>';
			sub_infractions += '<option value="Ticket not Open when required">Ticket not Open when required</option>';
			sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			$("#relevant_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#relevant_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#relevant_ccsrnonvoice").html('');
		}
	});
	
	$('#applications_portals_chat').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Asked for information that was already available">Asked for information that was already available</option>';
			sub_infractions += '<option value="Did not use all means to enable resolution">Did not use all means to enable resolution</option>';
			$("#applications_chat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#applications_chat").html(sub_infractions);
		}
		else{
			$("#applications_chat").html('');
		}
	});

	$('#applications_portals_ccsrvoice').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Open issue against any order ID of the a/c not addressed">Open issue against any order ID of the a/c not addressed</option>';
			$("#applications_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#applications_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#applications_ccsrvoice").html('');
		}
	});

	$('#ajioAF3').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Authenticated when not requierd">Authenticated when not requierd</option>';
			sub_infractions += '<option value="Incorrect authentication done">Incorrect authentication done</option>';
			sub_infractions += '<option value="Did not authenticate when requierd">Did not authenticate when requierd</option>';
			sub_infractions += '<option value="Details did not match">Details did not match</option>';
			sub_infractions += '<option value="Incomplete authentication">Incomplete authentication</option>';
			$("#email_interact").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#email_interact").html(sub_infractions);
		}else if($(this).val()=='N/A'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#email_interact").html(sub_infractions);
		}
		else{
			$("#email_interact").html('');
		}
	});

	$('#ajioAF8').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Authenticated when not requierd">Authenticated when not requierd</option>';
			sub_infractions += '<option value="Incorrect authentication done">Incorrect authentication done</option>';
			sub_infractions += '<option value="Did not authenticate when requierd">Did not authenticate when requierd</option>';
			sub_infractions += '<option value="Details did not match">Details did not match</option>';
			sub_infractions += '<option value="Incomplete authentication">Incomplete authentication</option>';
			$("#email_interact_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#email_interact_ccsrnonvoice").html(sub_infractions);
		}else if($(this).val()=='N/A'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#email_interact_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#email_interact_ccsrnonvoice").html('');
		}
	});

	$('#ajio_chatAF3').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="N/A">N/A</option>';
			$("#ensure_issue_chat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ensure_issue_chat").html(sub_infractions);
		}else if($(this).val()=='N/A'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ensure_issue_chat").html(sub_infractions);
		}
		else{
			$("#ensure_issue_chat").html('');
		}
	});

	$('#ajio_ccsrvoiceAF3').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Without customer consent closing Ticket">Without customer consent closing Ticket</option>';
			sub_infractions += '<option value="Incomplete Information">Incomplete Information</option>';
			sub_infractions += '<option value="Inaccurate Information">Inaccurate Information</option>';
			sub_infractions += '<option value="Wrong Action Taken">Wrong Action Taken</option>';
			sub_infractions += '<option value="No Action Taken">No Action Taken</option>';
			sub_infractions += '<option value="False Assurance">False Assurance</option>';
			$("#issue_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#issue_ccsrvoice").html(sub_infractions);
		}else if($(this).val()=='N/A'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#issue_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#issue_ccsrvoice").html('');
		}
	});

	$('#ajio_ccsrnonvoiceAF3').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Tagging not done">Tagging not done</option>';
			$("#issue_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#issue_ccsrnonvoice").html(sub_infractions);
		}else if($(this).val()=='N/A'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#issue_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#issue_ccsrnonvoice").html('');
		}
	});

	$('#ajioAF4').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Tagging not done">Tagging not done</option>';
			$("#ensure_issue_resol").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ensure_issue_resol").html(sub_infractions);
		}
		else{
			$("#ensure_issue_resol").html('');
		}
	});
	
	$('#ajio_ccsrvoiceAF4').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="C&R raised when not requiredC&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Tagging not done">Tagging not done</option>';
			$("#tagg_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#tagg_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="CAM rule not adhered to.">CAM rule not adhered to.</option>';
			sub_infractions += '<option value="Documented on incorrect account">Documented on incorrect account</option>';
			sub_infractions += '<option value="All queries not documented">All queries not documented</option>';
			sub_infractions += '<option value="QT Not Tagget">QT Not Tagget</option>';
			sub_infractions += '<option value="Incorrect Tagging done">Incorrect Tagging done</option>';
			$("#tagg_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#tagg_ccsrvoice").html('');
		}
	});

	$('#ajio_chatAF4').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Incorrect information Shared">Incorrect information Shared</option>';
			sub_infractions += '<option value="Incomplete information Shared">Incomplete information Shared</option>';
			$("#avoid_repeat_chat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#avoid_repeat_chat").html(sub_infractions);
		}
		else{
			$("#avoid_repeat_chat").html('');
		}
	});

	// $('#ajio_ccsrnonvoiceAF4').on('change', function(){
	// 	if($(this).val()=='Autofail'){
	// 		var sub_infractions = '<option value="Without customer consent closing Ticket">Without customer consent closing Ticket</option>';
	// 		sub_infractions += '<option value="Incomplete Information">Incomplete Information</option>';
	// 		sub_infractions += '<option value="Inaccurate Information">Inaccurate Information</option>';
	// 		sub_infractions += '<option value="Wrong Action Taken">Wrong Action Taken</option>';
	// 		$("#avoid_repeat_ccsrnonvoice").html(sub_infractions);
	// 	}
	// 	else if($(this).val()=='Yes'){
	// 		sub_infractions = '<option value="N/A">N/A</option>';
	// 		$("#avoid_repeat_ccsrnonvoice").html(sub_infractions);
	// 	}
	// 	else{
	// 		$("#avoid_repeat_ccsrnonvoice").html('');
	// 	}
	// });

	$('#ajio_ccsrnonvoiceAF4').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Incorrect information Shared">Incorrect information Shared</option>';
			sub_infractions += '<option value="Incomplete information Shared">Incomplete information Shared</option>';
			// sub_infractions += '<option value="Inaccurate Information">Inaccurate Information</option>';
			// sub_infractions += '<option value="Wrong Action Taken">Wrong Action Taken</option>';
			$("#avoid_repeat_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#avoid_repeat_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#avoid_repeat_ccsrnonvoice").html('');
		}
	});

	$('#ajioAF5').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Incorrect information Shared">Incorrect information Shared</option>';
			sub_infractions += '<option value="Incomplete information Shared">Incomplete information Shared</option>';
			$("#avoid_repeat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#avoid_repeat").html(sub_infractions);
		}
		else{
			$("#avoid_repeat").html('');
		}
	});

	$('#ajio_chatAF5').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="CAM rule not adhered to.">CAM rule not adhered to.</option>';
			sub_infractions += '<option value="Documented on incorrect account">Documented on incorrect account</option>';
			sub_infractions += '<option value="All queries not documented">All queries not documented</option>';
			sub_infractions += '<option value="QT Not Tagget ">QT Not Tagget</option>';
			sub_infractions += '<option value="Incorrect Tagging done">Incorrect Tagging done</option>';
			$("#tagging_guide_chat").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#tagging_guide_chat").html(sub_infractions);
		}else if($(this).val()=='Autofail'){
			sub_infractions = '<option value="Did the champ document the case correctly and adhered to tagging guidelines. Includes closing the complaint appropariately by selecting the correct ICR reason">Did the champ document the case correctly and adhered to tagging guidelines. Includes closing the complaint appropariately by selecting the correct ICR reason</option>';
			sub_infractions += '<option value="OB tagging not done">OB tagging not done</option>';
			sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Tagging not done">Tagging not done</option>';
			$("#tagging_guide_chat").html(sub_infractions);
		}
		else{
			$("#tagging_guide_chat").html('');
		}
	});

	$('#ajio_ccsrnonvoiceAF5').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="CAM rule not adhered to.">CAM rule not adhered to.</option>';
			sub_infractions += '<option value="Documented on incorrect account">Documented on incorrect account</option>';
			sub_infractions += '<option value="All queries not documented">All queries not documented</option>';
			sub_infractions += '<option value="QT Not Tagget ">QT Not Tagget</option>';
			sub_infractions += '<option value="Incorrect Tagging done">Incorrect Tagging done</option>';
			$("#tagging_guide_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#tagging_guide_ccsrnonvoice").html(sub_infractions);
		}else if($(this).val()=='Autofail'){
			sub_infractions = '<option value="Did the champ document the case correctly and adhered to tagging guidelines. Includes closing the complaint appropariately by selecting the correct ICR reason">Did the champ document the case correctly and adhered to tagging guidelines. Includes closing the complaint appropariately by selecting the correct ICR reason</option>';
			sub_infractions += '<option value="OB tagging not done">OB tagging not done</option>';
			sub_infractions += '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Tagging not done">Tagging not done</option>';
			$("#tagging_guide_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#tagging_guide_ccsrnonvoice").html('');
		}
	});

	$('#ajioAF6').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="C&R raised when not required">C&R raised when not required</option>';
			sub_infractions += '<option value="C&R not raised when required">C&R not raised when required</option>';
			sub_infractions += '<option value="Wrong C&R raised">Wrong C&R raised</option>';
			sub_infractions += '<option value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>';
			sub_infractions += '<option value="Action not taken">Action not taken</option>';
			sub_infractions += '<option value="Unnecessary redirection">Unnecessary redirection</option>';
			sub_infractions += '<option value="Tagging not done">Tagging not done</option>';
			$("#tagging_guide").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#tagging_guide").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="CAM rule not adhered to.">CAM rule not adhered to.</option>';
			sub_infractions += '<option value="Documented on incorrect account">Documented on incorrect account</option>';
			sub_infractions += '<option value="All queries not documented">All queries not documented</option>';
			sub_infractions += '<option value="QT Not Tagget">QT Not Tagget</option>';
			sub_infractions += '<option value="Incorrect Tagging done">Incorrect Tagging done</option>';
			$("#tagging_guide").html(sub_infractions);
		}
		else{
			$("#tagging_guide").html('');
		}
	});
	
	$('#ajio_chatAF6').on('change', function(){
		if($(this).val()=='Autofail'){
			sub_infractions = '<option value="Chat avoidence">Chat avoidence</option>';
			// sub_infractions += '<option value="Misbehave with customer">Misbehave with customer</option>';
			// sub_infractions += '<option value="Closing Chat without replying ">Closing Chat without replying </option>';
			// sub_infractions += '<option value="Chairman esclation">Chairman esclation</option>';
			sub_infractions += '<option value="Chat Disconnection">Chat Disconnection</option>';
			sub_infractions += '<option value="Closing Chat without replying">Closing Chat without replying</option>';
			sub_infractions += '<option value="Survey Solicitation/avoidanc">Survey Solicitation/avoidanc</option>';
			sub_infractions += '<option value="Misbehave with customer">Misbehave with customer</option>';
			sub_infractions += '<option value="Rude Behaviour/Mocking the customer">Rude Behaviour/Mocking the customer</option>';
			sub_infractions += '<option value="Flirting/Seeking personal details">Flirting/Seeking personal details</option>';
			sub_infractions += '<option value="Chairman escalation">Chairman escalation</option>';
			sub_infractions += '<option value="N/A">N/A</option>';
			$("#ztp_guide_chat").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="N/A">N/A</option>';
			// sub_infractions += '<option value="Documented on incorrect account">Documented on incorrect account</option>';
			// sub_infractions += '<option value="All queries not documented">All queries not documented</option>';
			// sub_infractions += '<option value="QT Not Tagget">QT Not Tagget</option>';
			// sub_infractions += '<option value="Incorrect Tagging done">Incorrect Tagging done</option>';
			$("#ztp_guide_chat").html(sub_infractions);
		}
		else{
			$("#ztp_guide_chat").html('');
		}
	});

	$('#ajio_ccsrvoiceAF6').on('change', function(){
		if($(this).val()=='Autofail'){
			sub_infractions = '<option value="...............">..................</option>';
			$("#ztp_guide_ccsrvoice").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="................">..................</option>';
			
			$("#ztp_guide_ccsrvoice").html(sub_infractions);
		}
		else{
			$("#ztp_guide_ccsrvoice").html('');
		}
	});

	$('#ajio_ccsrnonvoiceAF6').on('change', function(){
		if($(this).val()=='Autofail'){
			sub_infractions = '<option value="...............">..................</option>';
			$("#ztp_guide_ccsrnonvoice").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			var sub_infractions = '<option value="................">..................</option>';
			
			$("#ztp_guide_ccsrnonvoice").html(sub_infractions);
		}
		else{
			$("#ztp_guide_ccsrnonvoice").html('');
		}
	});

	$('#outcall_call_back').on('change', function(){
		if($(this).val()=='No'){
			var sub_infractions = '<option value="Champ didn’t outcall when required">Champ didn’t outcall when required</option>';
			sub_infractions += '<option value="Out call done bone wrong information done">Out call done bone wrong information done</option>';
			sub_infractions += '<option value="Call back request not initiated when required/Call back raised unneccersly ">Call back request not initiated when required/Call back raised unneccersly </option>';
			$("#outcall_call").html(sub_infractions);
		}
		else if($(this).val()=='Yes'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#outcall_call").html(sub_infractions);
		}else if($(this).val()=='N/A'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#outcall_call").html(sub_infractions);
		}
		else{
			$("#outcall_call").html('');
		}
	});

	$('#ajioAF7').on('change', function(){
		if($(this).val()=='Autofail'){
			var sub_infractions = '<option value="Email avoidence">Email avoidence</option>';
			sub_infractions += '<option value="Misbehave with customer">Misbehave with customer</option>';
			sub_infractions += '<option value="Closing email without replying">Closing email without replying</option>';
			sub_infractions += '<option value="Chairman esclation">Chairman esclation</option>';
			$("#ztp_guide").html(sub_infractions);
		}
		else if($(this).val()=='No'){
			sub_infractions = '<option value="N/A">N/A</option>';
			$("#ztp_guide").html(sub_infractions);
		}
		else{
			$("#ztp_guide").html('');
		}
	});

</script>