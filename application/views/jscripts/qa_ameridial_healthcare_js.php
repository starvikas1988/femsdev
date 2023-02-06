<script type="text/javascript">
		function checkDec(el) {
			var ex = /^[0-9]+\.?[0-9]*$/;

			if (ex.test(el.value) == false) {
				//console.log(el.value);
				el.value = el.value.substring(0, el.value.length - 1);
				alert("Number format required!");
				$('#phone').val("");
				return false;
			}
			// if(el.value.length >10){
   //     			alert("required 10 digits, match requested format!");
   //     			return false;
		 //    }
			//console.log(el.value);
		}
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
		
		$('.affinity_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'Partial'){
				var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('affinity_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		// quality_score_percent = Math.round(((score*100)/scoreable));
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#pre_earnedScore').val(score);
		$('#pre_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#pre_overallScore').val(quality_score_percent+'%');
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



		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custlockEarned').val(customerScore);
		$('#custlockPossible').val(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custlockScore').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busilockEarned').val(businessScore);
		$('#busilockPossible').val(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busilockScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseFloat($(element).children("option:selected").attr('affinity_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#compllockEarned').val(complianceScore);
		$('#compllockPossible').val(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#compllockScore').val(compliancePercentage+'%');
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

      $(document).on('change','.customer',function(){
		do_affinity();
	});
	$(document).on('change','.business',function(){
		do_affinity();
	});
	$(document).on('change','.compliance',function(){
		do_affinity();
	});
     do_affinity()
</script>

 <script>
 	$(function () {
    $('#attach_file').change(function () {
        var val = $(this).val().toLowerCase(),
            regex = new RegExp("(.*?)\.(mp3|avi|mp4|wmv|wav)$");

        if (!(regex.test(val))) {
            $(this).val('');
            alert('Please select correct file format');
            return false;
        }
    });
});

   $('#btnViewAgent').click(function(){

    if($.trim($('#from_date').val()) == ''){
      alert('From Date can not be left blank');
      $('#tl_id').focus();
      return false;
   }
   	
   if($.trim($('#to_date').val()) == ''){
      alert('To Date can not be left blank');
      $('#tl_id').focus();
      return false;
   }

});    
</script>

<script type="text/javascript">
	
	function calculation(){
		// var sensioScore=0;
		// $('.sensioVal').each(function(index,element){
		// 	var score_type = parseFloat($(element).children("option:selected").attr('sen_val'));
		// 	sensioScore = score_type+sensioScore;
		// });
		
		// if(!isNaN(sensioScore)){
		// 	$('#sensioOverallScore').val(sensioScore+'%');
		// }

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.amd_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Effective'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('amd_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Unacceptable'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('amd_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#jurys_inn_earned_score').val(score);
		$('#jurys_inn_possible_score').val(scoreable);

		if(!isNaN(quality_score_percent)){
				$('#jurys_inn_overall_score').val(quality_score_percent+'%');
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
			if(sc1 == 'Effective'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'Unacceptable'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('amd_val'));
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
			if(sc2 == 'Effective'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'Unacceptable'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('amd_val'));
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
			if(sc3 == 'Effective'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'Unacceptable'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('amd_val'));
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
	}



	

     $(document).on('change','.amd_point',function(){
		calculation();
	});
     $(document).on('change','.customer',function(){
		calculation();
	});
	$(document).on('change','.business',function(){
		calculation();
	});
	$(document).on('change','.compliance',function(){
		calculation();
	});
     calculation()



</script>

<script type="text/javascript">
	
	/////////////////////ACM///////////////////////////////
	function acm_score(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent_acm = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
	// 	$('.acm_points').each(function(index,element){
	// 		var weightage = parseInt($(element).children("option:selected").attr('acm_val'));
	// 		score_acm = score_acm + weightage;
	// 		 var score_type = $(element).val();
	// 		if(score_type == 'Yes'){
	// 			pass_count = pass_count + 1;
	// 			var weightage = parseInt($(element).children("option:selected").attr('acm_val'));
	// 			score_acm = score_acm + weightage;
	// 			scoreable_acm = scoreable_acm + weightage;
	// 		}else if(score_type == 'No'){
	// 			fail_count = fail_count + 1;
	// 			var weightage = parseInt($(element).children("option:selected").attr('acm_val'));
	// 			scoreable_acm = scoreable_acm + weightage;
	// 		}else if(score_type == 'Meets'){
	// 			fail_count = fail_count + 1;
	// 			var weightage = parseInt($(element).children("option:selected").attr('acm_val'));
	// 			scoreable_acm = scoreable_acm + weightage;
	// 		}else if(score_type == 'Coaching'){
	// 			fail_count = fail_count + 1;
	// 			var weightage = parseInt($(element).children("option:selected").attr('acm_val'));
	// 			scoreable_acm = scoreable_acm + weightage;
	// 		}else if(score_type == 'N/A'){
	// 			na_count = na_count + 1;
	// 		} 
	// 	});
	// 	quality_score_percent_acm = ((score_acm*100)/scoreable_acm).toFixed(2);


	// 	$('#acm_earn_score').val(score_acm);
	// 	$('#acm_possible_score').val(scoreable_acm);

	// 	if(!isNaN(quality_score_percent_acm)){
	// 		$('#acm_overall_score').val(quality_score_percent_acm+'%');
	// 	}


	$('.acm_points').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
			    var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Meets'){
			    var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
				score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Coaching'){
			    var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'Fail'){
			    var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}
		});

		quality_score_percent_acm = ((score*100)/scoreable).toFixed(2);

		$('#acm_earn_score').val(score);
		$('#acm_possible_score').val(scoreable);

		if(!isNaN(quality_score_percent_acm)){
			$('#acm_overall_score').val(quality_score_percent_acm+'%');
			
		}


		if($('#acm01').val()=='Yes' || $('#acm02').val()=='Yes' ){
			$('.acmFatal').val(0);
		}else{
			$('.acmFatal').val(quality_score_percent_acm+'%');
		}

		////////////// Customer/Business/Compliance //////////////////
		var customerScore_acm = 0;
		var customerScoreable_acm = 0;
		var customerPercentage_acm = 0;
		$('.customer_acm').each(function(index,element){
			
			var sc1 = $(element).val();
			if(sc1 == 'Meets'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
				customerScore_acm = customerScore_acm + w1;
				customerScoreable_acm = customerScoreable_acm + max_wght;
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
				customerScore_acm = customerScore_acm + w1;
				customerScoreable_acm = customerScoreable_acm + max_wght;
			}else if(sc1 == 'Yes'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
				customerScore_acm = customerScore_acm + w1;
				customerScoreable_acm = customerScoreable_acm + max_wght;
			}else if(sc1 == 'Coaching'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
				customerScore_acm = customerScore_acm + w1;
				customerScoreable_acm = customerScoreable_acm + max_wght;
			}else if(sc1 == 'Fail'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
				customerScore_acm = customerScore_acm + w1;
				customerScoreable_acm = customerScoreable_acm + max_wght;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('acm_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('acm_max'));
				customerScore_acm = customerScore_acm + w1;
				customerScoreable_acm = customerScoreable_acm + max_wght;
			}
			console.log(customerScore_acm);
		});

		$('#custAcmEarned').text(customerScore_acm);
		$('#custAcmPossible').text(customerScoreable_acm);
		customerPercentage_acm = ((customerScore_acm*100)/customerScoreable_acm).toFixed(2);
		if(!isNaN(customerPercentage_acm)){
			$('#custAcmScore').val(customerPercentage_acm+'%');
		}


	////////////
		var businessScore_acm = 0;
		var businessScoreable_acm = 0;
		var businessPercentage_acm = 0;
		$('.business_acm').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('acm_val'));
				businessScore_acm = businessScore_acm + w2;
				businessScoreable_acm = businessScoreable_acm + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('acm_val'));
				businessScoreable_acm = businessScoreable_acm + w2;
			}else if(sc2 == 'Meets'){
				var w2 = parseInt($(element).children("option:selected").attr('acm_val'));
				businessScoreable_acm = businessScoreable_acm + w2;
			}else if(sc2 == 'Coaching'){
				var w2 = parseInt($(element).children("option:selected").attr('acm_val'));
				businessScoreable_acm = businessScoreable_acm + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('acm_val'));
				businessScore_acm = businessScore_acm + w2;
				businessScoreable_acm = businessScoreable_acm + w2;
			}
		});
		$('#busiAcmEarned').text(businessScore_acm);
		$('#busiAcmPossible').text(businessScoreable_acm);
		businessPercentage_acm = ((businessScore_acm*100)/businessScoreable_acm).toFixed(2);
		if(!isNaN(businessPercentage_acm)){
			$('#busiAcmScore').val(businessPercentage_acm+'%');
		}
	////////////
		var complianceScore_acm = 0;
		var complianceScoreable_acm = 0;
		var compliancePercentage_acm = 0;
		$('.compliance_acm').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('acm_val'));
				complianceScore_acm = complianceScore_acm + w3;
				complianceScoreable_acm = complianceScoreable_acm + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('acm_val'));
				complianceScoreable_acm = complianceScoreable_acm + w3;
			}else if(sc3 == 'Meets'){
				var w3 = parseInt($(element).children("option:selected").attr('acm_val'));
				complianceScoreable_acm = complianceScoreable_acm + w3;
			}else if(sc3 == 'Coaching'){
				var w3 = parseInt($(element).children("option:selected").attr('acm_val'));
				complianceScoreable_acm = complianceScoreable_acm + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('acm_val'));
				complianceScore_acm = complianceScore_acm + w3;
				complianceScoreable_acm = complianceScoreable_acm + w3;
			}
		});
		$('#complAcmEarned').text(complianceScore_acm);
		$('#complAcmPossible').text(complianceScoreable_acm);
		compliancePercentage_acm = ((complianceScore_acm*100)/complianceScoreable_acm).toFixed(2);
		if(!isNaN(compliancePercentage_acm)){
			$('#complAcmScore').val(compliancePercentage_acm+'%');
		}
	
	}
////////////////////////////////////////////////////////////////////////////////////////////////


	
     $(document).on('change','.acm_points',function(){
		acm_score();
	});
     $(document).on('change','.customer_acm',function(){
		acm_score();
	});
	$(document).on('change','.business_acm',function(){
		acm_score();
	});
	$(document).on('change','.compliance_acm',function(){
		acm_score();
	});
     acm_score()






</script>

<script type="text/javascript">
	
	function do_calculation(){
		
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.safe_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('safe_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('safe_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'Fatal'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('safe_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#safe_earned_score').val(score);
		$('#safe_possible_score').val(scoreable);

		if(!isNaN(quality_score_percent)){
				$('#safe_overall_score').val(quality_score_percent+'%');
				// $('#safe_earned_score').val(quality_score_percent);
				// $('#safe_earned_score').val(score);
		}
		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);

		 if ($('#netmedsAF1').val() == 'Yes' || $('#netmedsAF2').val() == 'Yes' || $('#netmedsAF3').val() == 'Yes' || $('#netmedsAF4').val() == 'Yes' || $('#netmedsAF5').val() == 'Fatal' || $('#netmedsAF6').val() == 'Fatal' || $('#netmedsAF7').val() == 'Fatal' || $('#tf1').val() == 'No' || $('#tf2').val() == 'No' || $('#tf3').val() == 'No' || $('#tf4').val() == 'No' ) {
            $('.Fatal').val(0);
			$('.Fatal_Earn').val(0);
		    } else {
				$('.Fatal_Earn').val(score);
		        $('.Fatal').val(quality_score_percent + '%');
				
		    }
		

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseInt($(element).children("option:selected").attr('safe_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('safe_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('safe_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#custsafeEarned').text(customerScore);
		$('#custsafePossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custsafeScore').val(customerPercentage+'%');
		}
	////////////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('safe_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('safe_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('safe_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#busisafeEarned').text(businessScore);
		$('#busisafePossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#busisafeScore').val(businessPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('safe_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('safe_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('safe_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#complsafeEarned').text(complianceScore);
		$('#complsafePossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#complsafeScore').val(compliancePercentage+'%');
		}

		
	}

     $(document).on('change','.safe_point',function(){
		do_calculation();
	});
     $(document).on('change','.customer',function(){
		do_calculation();
	});
	$(document).on('change','.business',function(){
		do_calculation();
	});
	$(document).on('change','.compliance',function(){
		do_calculation();
	});
     do_calculation()



</script>




<script>
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_date_time").datetimepicker();
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


<script type="text/javascript">
////////////////////////// Touchfuse /////////////////////////
	function touchfuse(){
		
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		
		$('.touchfuse_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'YES'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'NO'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				// na_count = na_count + 1;
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Pass'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Fail'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#touchfuse_earned_score').val(score);
		$('#touchfuse_possible_score').val(scoreable);

		if(!isNaN(quality_score_percent)){
				$('#touchfuse_overall_score').val(quality_score_percent+'%');
		}
		
		$('#pass_count').val(pass_count);
		$('#fail_count').val(fail_count);
		$('#na_count').val(na_count);

		///////////////////////
		if ($('#touchAF1').val()=='Fail' || $('#touchAF2').val()=='Fail' || $('#touchAF3').val()=='Fail' || $('#touchAF4').val()=='Fail') {
            $('.touchfuse_fatal').val(0 + '%');	
		}else{
			$('.touchfuse_fatal').val(quality_score_percent + '%');
		}
		

	//////////////// COPC score //////////////////
	//////// Customer /////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.touchfuse_customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}
		});
		$('#touchfuseEarned').text(customerScore);
		$('#touchfusePossible').text(customerScoreable);
		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#touchfuseScore').val(customerPercentage+'%');
		}
	////// Business //////
		var businessScore = 0;
		var businessScoreable = 0;
		var businessPercentage = 0;
		$('.touchfuse_business').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}
		});
		$('#touchfusebusEarned').text(businessScore);
		$('#touchfusebusPossible').text(businessScoreable);
		businessPercentage = ((businessScore*100)/businessScoreable).toFixed(2);
		if(!isNaN(businessPercentage)){
			$('#touchfusebusScore').val(businessPercentage+'%');
		}
	/////// Compliance ///////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.touchfuse_compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('touchfuse_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}
		});
		$('#touchfusecomEarned').text(complianceScore);
		$('#touchfusecomPossible').text(complianceScoreable);
		compliancePercentage = ((complianceScore*100)/complianceScoreable).toFixed(2);
		if(!isNaN(compliancePercentage)){
			$('#touchfusecomScore').val(compliancePercentage+'%');
		}
	}



	$(document).ready(function(){
		
		$(document).on('change','.touchfuse_point',function(){ touchfuse(); });
		$(document).on('change','.touchfuse_customer',function(){ touchfuse(); });
		$(document).on('change','.touchfuse_business',function(){ touchfuse(); });
		$(document).on('change','.touchfuse_compliance',function(){ touchfuse(); });
		touchfuse();
	
	});

</script>





