 <!--============================== Buc New Start======================= -->
<script>
function bucnew_calc() {

    var score = 0;
    var scoreable = 0;
    var scoreable2 = 0;
    var quality_score_percent = 0;
    var total_scoreable = 0;
    var total_score = 0;

    $('.bucnew_points').each(function(index, element) {
        var score_type = $(element).val();
        if (score_type == 'Yes') {
            var weightage = parseFloat($(element).children("option:selected").attr('bucnew_val'));
            score = score + weightage;
            scoreable = scoreable + weightage;
            total_yes = scoreable + weightage;
        } else if (score_type == 'No') {
            var weightage = parseFloat($(element).children("option:selected").attr('bucnew_val'));
            scoreable = scoreable + weightage;
            var weightage2 = parseFloat($(element).children("option:selected").attr('bucnew_val'));
            scoreable2 = scoreable2 + weightage2
            total_scoreable = scoreable2 + weightage2;
        } else if (score_type == 'N/A') {
            var weightage = parseFloat($(element).children("option:selected").attr('bucnew_val'));
            score = score + weightage;
            scoreable = scoreable + weightage;
        }
    });

    quality_score_percent = ((score * 100) / scoreable).toFixed(2);

    $('#bucnew_earned').val(score);
    $('#bucnew_possible').val(scoreable);
    if (!isNaN(quality_score_percent)) {
        $('#bucnew_overall_score').val(quality_score_percent + '%');
    } else {
        $('#bucnew_overall_score').val(100.00 + '%');
    }

    total_score = (100 - scoreable2);
    if (!isNaN(total_score)) {
        $('#bucnew_total_score').val(total_score);
    } else {
        $('#bucnew_total_score').val(100);
    }

}
$(document).on('change', '.bucnew_points', function() {
    bucnew_calc();
});
bucnew_calc();
</script>

<!--============================== BUc New End======================= -->
<!--============================== Stratus Start======================= -->
<script type="text/javascript">
function stratus_calc() {

    var score = 0;
    var scoreable = 0;
    var quality_score_percent = 0;

    $('.stratus_point').each(function(index, element) {
        var score_type = $(element).val();
        if (score_type == 'Yes' || score_type == 'Pass') {
            var weightage = parseFloat($(element).children("option:selected").attr('stratus_val'));
            score = score + weightage;
            scoreable = scoreable + weightage;
        } else if (score_type == 'No' || score_type == 'Fail') {
            var weightage = parseFloat($(element).children("option:selected").attr('stratus_val'));
            scoreable = scoreable + weightage;
        } else if (score_type == 'N/A') {
            var weightage = parseFloat($(element).children("option:selected").attr('stratus_val'));
            score = score + weightage;
            scoreable = scoreable + weightage;
        }
    });
    quality_score_percent = ((score * 100) / scoreable).toFixed(2);

    $('#stratus_earned').val(score);
    $('#stratus_possible').val(scoreable);

    if (!isNaN(quality_score_percent)) {
        $('#stratus_overall_score').val(quality_score_percent + '%');
    }
    if($('#stratusAF1').val() == 'No'){
        $('#param1').text('Yes');
		}else{
			if(!isNaN(quality_score_percent)){
				$('#param1').text('No');
			}	
		}
    ////////////////Fatal  Score ///////////////////
    if ($('#stratusAF1').val() == 'No' || $('#stratusAF2').val() == 'No' || $('#stratusAF3').val() == 'Yes') {
        $('#stratus_overall_score').val(0);

    } else {
        $('#stratus_overall_score').val(quality_score_percent + '%');
       
    }

/////////////Monitoring Tech /////////////////////////
    if ($('#monitorinttectAF1').val() == 'No') {
        $('.monitorinttech_fatal').val(0);
        $("#param1").val('Yes');
    }else{
        $('.monitorinttech_fatal').val(quality_score_percent + '%');
        $("#param1").val('No');
    }

    /////////////Monitoring Tech V1 /////////////////////////
    if ($('#call_video_fatal').val() == 'Fail' || $('#call_OOR_fatal').val() == 'Fail') {
        $('.monitorinttech_fatal').val(0);
        $("#param1").val('Yes');
    }else{
        $('.monitorinttech_fatal').val(quality_score_percent + '%');
        $("#param1").val('No');
    }
    
    /////////////////////////////////
    // Autofail

    // if ($('#stratusAF').val() == 'Yes') {
    //     $('#stratus_overall_score').val(0);
    //     $('#stratusAF').css('color', 'red');
    // } else {
    //     $('#stratus_overall_score').val(quality_score_percent + '%');
    //     $('#stratusAF').css('color', 'green');
    // }

    // $('.stratusAuto').on('change', function()
	// 	{
	// 		if($(this).val()=='No'){
	// 			var custVoc1 = 'Yes';
	// 			$("#param1").val(custVoc1);
	// 		}else{
	// 			var custVoc2 = 'No';
	// 			$("#param1").val(custVoc2);
	// 		}
	// 	});

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
        var score_type1 = 0;
        var score_type2 = 0;
        var score_type3 = 0;
		
		$('.compliance').each(function(index,element){
			var score_type1 = $(element).val();
			
			if(score_type1 == 'Yes' || score_type1 == 'Pass'){
				var weightage1 = parseInt($(element).children("option:selected").attr('stratus_val'));
				compliancescore1 = compliancescore1 + weightage1;
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if(score_type1 == 'No' || score_type1 == 'Fail'){
				var weightage1 = parseInt($(element).children("option:selected").attr('stratus_val'));
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseInt($(element).children("option:selected").attr('stratus_val'));
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
			
			if(score_type2 == 'Yes' || score_type2 == 'Pass'){
				var weightage2 = parseInt($(element).children("option:selected").attr('stratus_val'));
				customerscore1 = customerscore1 + weightage2;
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if(score_type2 == 'No' || score_type2 == 'Fail'){
				var weightage2 = parseInt($(element).children("option:selected").attr('stratus_val'));
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseInt($(element).children("option:selected").attr('stratus_val'));
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
			
			if(score_type3 == 'Yes' || score_type3 == 'Pass'){
				var weightage3 = parseInt($(element).children("option:selected").attr('stratus_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if(score_type3 == 'No' || score_type3 == 'Fail'){
				var weightage3 = parseInt($(element).children("option:selected").attr('stratus_val'));
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseInt($(element).children("option:selected").attr('stratus_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}
		});
		business_score_percent = ((businessscore1*100)/businessscoreable1).toFixed(2);
		$('#businessscore1').val(businessscore1);
		$('#businessscoreable1').val(businessscoreable1);
		$('#business_score_percent1').val(business_score_percent+'%');

}

$(document).on('change', '.stratus_point', function() {
    stratus_calc();
});
// $(document).on('change', '.stratusAuto', function() {
//     stratus_calc();
// });

stratus_calc();
</script>
<!-- ===================================Stratus End===================== -->

<!--============================== Netmeds Start======================= -->
<script type="text/javascript">
function netmeds_calc() {
    var score = 0;

    $('.netmeds_point').each(function(index, element) {
        var weightage = parseFloat($(element).children("option:selected").attr('netmeds_val'));
        score = score + weightage;
    });

    if (!isNaN(score)) {
        $("#netmeds_overall_score").val(score);
    }


    //////Netmeds///////
    if ($('#netmedsAF1').val() == 'Fatal' || $('#netmedsAF2').val() == 'Fatal' || $('#netmedsAF3').val() == 'Fatal' ||
        $('#netmedsAF4').val() == 'Fatal' || $('#netmedsAF5').val() == 'Fatal' || $('#netmedsAF6').val() == 'Fatal' ||
        $('#netmedsAF7').val() == 'Fatal' || $('#netmedsAF8').val() == 'Fatal') {
        $('.netmedsFatal').val(0);
    } else {
        $('.netmedsFatal').val(score + '%');
    }
}

$(document).on('change', '.netmeds_point', function() {
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
function loanxm_calc() {
    var score = 0;
    var scoreable = 0;
    var quality_score_percent = 0;
    var pass_count = 0;
    var fail_count = 0;
    var na_count = 0;
    var total_score = 0;
    var total_score1 = 0;




    // $('.loanxm_point').each(function(index,element){
    // 	var score_type = $(element).val();
    // 	if(score_type == 'Yes'){
    // 		pass_count = pass_count + 1;
    // 	    var weightage = parseFloat($(element).children("option:selected").attr('loanxm_val'));
    // 	    score = score + weightage;
    // 	    scoreable = scoreable + weightage;
    // 	}else if(score_type == 'No'){
    // 		fail_count = fail_count + 1;
    // 	    var weightage = parseFloat($(element).children("option:selected").attr('loanxm_val'));
    // 	    scoreable = scoreable + weightage;
    // 	}else if(score_type == 'N/A'){
    // 		na_count = na_count + 1;
    // 	    var weightage = parseFloat($(element).children("option:selected").attr('loanxm_val'));
    // 	    score = score + weightage;
    // 	    scoreable = scoreable + weightage;
    // 	}
    // });
    // quality_score_percent = ((score*100)/scoreable).toFixed(2);


    // $('#loanxm_earnedScore').val(score);
    // $('#loanxm_possibleScore').val(scoreable);
    // $('#pass_count').val(pass_count);
    // $('#fail_count').val(fail_count);
    // $('#na_count').val(na_count);

    // if(!isNaN(quality_score_percent)){
    // 	$('#loanxmOverallScore').val(quality_score_percent+'%');
    // }

    $('.loanxm_point').each(function(index, element) {
        var score_type = $(element).val();
        if (score_type == 'Yes') {
            var weightage = parseFloat($(element).children("option:selected").attr('loanxm_val'));
            score = score + weightage;
            scoreable = scoreable + weightage;
        } else if (score_type == 'No' || score_type == 'Fatal') {
            var weightage = parseFloat($(element).children("option:selected").attr('loanxm_val'));
            scoreable = scoreable + weightage;
        } else if (score_type == 'N/A') {
            var weightage = parseFloat($(element).children("option:selected").attr('loanxm_val'));
            score = score + weightage;
            scoreable = scoreable + weightage;
        }
    });
    quality_score_percent = ((score * 100) / scoreable).toFixed(2);

    //$('#loanxm_earnedScore').val(score);
    $('#loanxm_possibleScore').val(scoreable);

    if (!isNaN(quality_score_percent)) {
        $('#loanxmOverallScore').val(quality_score_percent + '%');
    }
	
	///////////
	if (!isNaN(quality_score_percent)) {
        $('#tvsOverallScore').val(quality_score_percent + '%');
    }
	
	if($('#tvsAF1').val() == 'Fatal'){
        $('.tvsFatal').val(0);
        $('#loanxm_earnedScore').val(0);
    }else{
        $('#loanxm_earnedScore').val(score);
		$('.tvsFatal').val(quality_score_percent + '%');
	}


    //////////////// Customer/Business/Compliance //////////////////
    var customerScore = 0;
    var customerScoreable = 0;
    var customerPercentage = 0;
    $('.customer').each(function(index, element) {
        var sc1 = $(element).val();
        if (sc1 == 'Yes') {
            var w1 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            customerScore = customerScore + w1;
            customerScoreable = customerScoreable + w1;
        } else if (sc1 == 'No') {
            var w1 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            customerScoreable = customerScoreable + w1;
        } else if (sc1 == 'N/A') {
            var w1 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            customerScore = customerScore + w1;
            customerScoreable = customerScoreable + w1;
        }
    });
    $('#custJiCisEarned').text(customerScore);
    $('#custJiCisPossible').text(customerScoreable);
    customerPercentage = ((customerScore * 100) / customerScoreable).toFixed(2);
    if (!isNaN(customerPercentage)) {
        $('#custJiCisScore').val(customerPercentage + '%');
    }
    ////////////
    var businessScore = 0;
    var businessScoreable = 0;
    var businessPercentage = 0;
    $('.business').each(function(index, element) {
        var sc2 = $(element).val();
        if (sc2 == 'Yes') {
            var w2 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            businessScore = businessScore + w2;
            businessScoreable = businessScoreable + w2;
        } else if (sc2 == 'No') {
            var w2 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            businessScoreable = businessScoreable + w2;
        } else if (sc2 == 'N/A') {
            var w2 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            businessScore = businessScore + w2;
            businessScoreable = businessScoreable + w2;
        }
    });
    $('#busiJiCisEarned').text(businessScore);
    $('#busiJiCisPossible').text(businessScoreable);
    businessPercentage = ((businessScore * 100) / businessScoreable).toFixed(2);
    if (!isNaN(businessPercentage)) {
        $('#busiJiCisScore').val(businessPercentage + '%');
    }
    ////////////
    var complianceScore = 0;
    var complianceScoreable = 0;
    var compliancePercentage = 0;
    $('.compliance').each(function(index, element) {
        var sc3 = $(element).val();
        if (sc3 == 'Yes') {
            var w3 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            complianceScore = complianceScore + w3;
            complianceScoreable = complianceScoreable + w3;
        } else if (sc3 == 'No') {
            var w3 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            complianceScoreable = complianceScoreable + w3;
        } else if (sc3 == 'N/A') {
            var w3 = parseInt($(element).children("option:selected").attr('loanxm_val'));
            complianceScore = complianceScore + w3;
            complianceScoreable = complianceScoreable + w3;
        }
    });
    $('#complJiCisEarned').text(complianceScore);
    $('#complJiCisPossible').text(complianceScoreable);
    compliancePercentage = ((complianceScore * 100) / complianceScoreable).toFixed(2);
    
	if (!isNaN(compliancePercentage)) {
        $('#complJiCisScore').val(compliancePercentage + '%');
    }


    // if(!isNaN(score)){
    // 	$('#loanxmOverallScore').val(score+'%');
    // }

    if ($('#loanxmAF1').val() == 'No' || $('#loanxmAF2').val() == 'No' || $('#loanxmAF3').val() == 'Yes' || $('#loanxmAF4').val() == 'Fatal' || $('#loanxmAF5').val() == 'Fatal' || $('#loanxmAF6').val() == 'Fatal') {
        $('.loanxmFatal').val(0);
        // $('.loanxmFatal').val(score+'%');
        $('#loanxm_passfail').val('Fail').css('color', 'Red');

    } else {
        $('.loanxmFatal').val(0);

        if (score >= 85) {
            $('#loanxm_passfail').val('Pass').css('color', 'Green');
        } else {
            $('#loanxm_passfail').val('Fail').css('color', 'Red');
        }
    }

    if ($('#loanxmf').val() == 'Yes') {
        $('.loanxmFatal_ds').val(0);
        // $('#loanxmFatal').val(score+'%');

    } else {
        // $('.loanxmFatal').val(score+'%');
        $(".loanxmFatal_ds").val(quality_score_percent + '%');

    }

    // total_score = (quality_score_percent-20);
    // if($('#loanxms').val()=='No'){
    // 	$('.loanxmFatal_ds').val(total_score+'%');

    // }else{
    // 	$('.loanxmFatal_ds').val(total_score+'%');			
    // }
    total_score = (quality_score_percent - 20);
    if ($('#section5a').val() == 'No') {
        $('#loanxmOverallScore').val(total_score + '%');

    } else {
        $('#loanxmOverallScore').val(total_score + '%');

    }

    if ($('#loanb').val() == 'No') {
        $('#loanxmOverallScore').val(total_score + '%');

    } else {
        $('#loanxmOverallScore').val(quality_score_percent + '%');

    }

    // if($('#idfc_new_AF1').val()=='No' || $('#idfc_new_AF2').val()=='No'){
    // 	$('.loanxmFatal_ds').val(quality_score_percent-20);
    // }else{
    // 	$('.loanxmFatal_ds').val(quality_score_percent+'%');
    // }
}

/////////////////////////////////////////////////////////////////////

$(document).on('change', '.loanxm_point', function() {
    loanxm_calc();
	if($(this).hasClass("section5")){
		$(".section5").each((index, element)=>{
			if($(element).val() == "No"){
				$("#loanxmOverallScore").val(parseFloat($("#loanxmOverallScore").val()) - 20)
			}
		})
	}
});
loanxm_calc();
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
$(document).ready(function() {

    $("#audit_date").datepicker();
   // $("#call_date").datepicker();
    $("#call_date").datepicker({maxDate: new Date() });
    //$("#dob_date").datepicker();
    $("#dob_date").datepicker({maxDate: new Date() });
    $("#booking_date").datepicker();
    $("#video_duration").timepicker({
        timeFormat: 'HH:mm:ss'
    });
    $("#call_duration").timepicker({
        timeFormat: 'HH:mm:ss'
    });
    //$("#from_date").datepicker();
    //$("#to_date").datepicker();
    $("#from_date").datepicker({maxDate: new Date() });
    $("#to_date").datepicker({maxDate: new Date() });
    $("#go_live_date").datepicker();

    $(document).ready(function() {
    $("#call_date_time").datetimepicker({
        maxDate: new Date(),
        timeFormat: 'HH:mm:ss'
    });
});


    ///////////////// Calibration - Auditor Type ///////////////////////	
   // $('.auType').hide();

        if($("#audit_type").val() == "Calibration"){
        $('.auType').show();
        $('#auditor_type').attr('required',true);
        $('#auditor_type').prop('disabled',false);
    }
    
    $('#audit_type').each(function(){
        $valdet=$(this).val();
        console.log($valdet);
        if($valdet=="Calibration"){
            $('.auType').show();
            $('#auditor_type').attr('required',true);
            $('#auditor_type').prop('disabled',false);
        }else{
            $('.auType').hide();
            $('#auditor_type').attr('required',false);
            $('#auditor_type').prop('disabled',true);
        }
    });


    $('#audit_type').on('change', function() {
        if ($(this).val() == 'Calibration') {
            $('.auType').show();
            $('#auditor_type').attr('required', true);
            $('#auditor_type').prop('disabled', false);
        } else {
            $('.auType').hide();
            $('#auditor_type').attr('required', false);
            $('#auditor_type').prop('disabled', true);
        }
    });

    ///////////////// Agent and TL names ///////////////////////
    $("#agent_id").on('change', function() {
        var aid = this.value;
        if (aid == "") alert("Please Select Agent")
        var URL = '<?php echo base_url();?>qa_ameridial/getTLname';
        $('#sktPleaseWait').modal('show');
        $.ajax({
            type: 'POST',
            url: URL,
            data: 'aid=' + aid,
            success: function(aList) {
                var json_obj = $.parseJSON(aList);
                $('#tl_name').empty();
                $('#tl_name').append($('#tl_name').val(''));
                //for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));

                for (var i in json_obj){
                    if($('#tl_name').val(json_obj[i].tl_name)!=''){
                        console.log(json_obj[0].tl_name);
                        $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));

                    }else{
                        alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
                    }
                    
                } 
                
                for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i]
                    .assigned_to));
                for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[
                    i].fusion_id));
                for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i]
                    .process_name));
                for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[
                    i].office_id));
                $('#sktPleaseWait').modal('hide');
            },
            error: function() {
                alert('Fail!');
            }
        });
    });

    //////////////// After Submit Form Disabled //////////////////////
    $("#form_audit_user").submit(function(e) {
        $('#qaformsubmit').prop('disabled', true);
    });

    $("#form_agent_user").submit(function(e) {
        $('#btnagentSave').prop('disabled', true);
    });

    $("#form_mgnt_user").submit(function(e) {
        $('#btnmgntSave').prop('disabled', true);
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
function checkDec(el) {
    var ex = /^[0-9]+\.?[0-9]*$/;
    if (ex.test(el.value) == false) {
        el.value = el.value.substring(0, el.value.length - 1);
    }
}
</script>