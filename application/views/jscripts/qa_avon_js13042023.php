<!-- AVON SCRIPT -->
<!-- Score Counter Script-->
<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<script src="<?php echo base_url() ?>assets/css/search-filter/js/chart.js"></script>

<script>
//     $(document).ready(function(e){
//     $('#batch_code').select2(); 
    
// });
$(function() {
    $('#multiselect').multiselect();
    $('.multiple-select').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Search for something...'
    });
});
</script>
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

<script type="text/javascript">
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
<script type="text/javascript">
	// $(function () {
	// 	$( "#audit_type" ).on('change' , function() {
	// 		let val = $(this).val();
	// 		if(val == 'Calibration'){
	// 			$('#auditor_type').attr('required','required');
	// 		}else{
	// 			$('#auditor_type').attr('required', false);
	// 		}
	// 	});
	// });
</script>

<script type="text/javascript">
// 	function selectOption(index){ 
//   document.getElementById("select_id").options.selectedIndex = index;
// }
	$(function () {
		let status_points1 = $( "#status_points1" ).val();
		let status_points2 = $( "#status_points2" ).val();
		let status_points3 = $( "#status_points3" ).val();
		let status_points4 = $( "#status_points4" ).val();
		let status_points5 = $( "#status_points5" ).val();
		let status_points6 = $( "#status_points6" ).val();
		let status_points7 = $( "#status_points7" ).val();
		let status_points8 = $( "#status_points8" ).val();
		let status_points9 = $( "#status_points9" ).val();
		let status_points10 = $( "#status_points10" ).val();
		let status_points11 = $( "#status_points11" ).val();
		if(status_points1 == 'Fail'){
			$("#remarks1").multiselect("enable");
			//$('#remarks1').prop('required', 'required');
			//$('#remarks1').removeAttr('required');

			//$('#remarks1').attr('required', 'required');
			//$("#remarks1").prop('required',true);
		}
		if(status_points2 == 'Fail'){
			$("#remarks2").multiselect("enable");
		}
		if(status_points3 == 'Fail'){
			$("#remarks3").multiselect("enable");
		}
		if(status_points4 == 'Fail'){
			$("#remarks4").multiselect("enable");
		}
		if(status_points5 == 'Fail'){
			$("#remarks5").multiselect("enable");
		}
		if(status_points6 == 'Fail'){
			$("#remarks6").multiselect("enable");
		}
		if(status_points7 == 'Fail'){
			$("#remarks7").multiselect("enable");
		}
		if(status_points8 == 'Fail'){
			$("#remarks8").multiselect("enable");
		}
		if(status_points9 == 'Fail'){
			$("#remarks9").multiselect("enable");
		}
		if(status_points10 == 'Fail'){
			$("#remarks10").multiselect("enable");
		}
		if(status_points11 == 'Fail'){
			$("#remarks11").multiselect("enable");
		}
		$( "#status_points1" ).on('change' , function() {
			//var val = this.value;
			let val1 = $(this).val();
			console.log(val1);
			if(val1 == 'Pass'){
				
				//$("#remarks1").options.selectedIndex = 0;
				$("#remarks1").multiselect("clearSelection");

 				$("#remarks1").multiselect( 'refresh' );
				$("#remarks1").multiselect("disable");
				//$('#remarks1').attr('disabled','disabled');
			}else if(val1 == 'Fail'){
				 $("#remarks1").multiselect("enable");
				 $("#remarks1").attr('required',true);
				//$('#remarks1').attr('disabled', false);
				
			}
		});

		$("#status_points2").on('change' , function() {
			//var val = this.value;
			let val2 = $(this).val();
			console.log(val2);
			if(val2 == 'Pass'){
				$("#remarks2").multiselect("clearSelection");
 				$("#remarks2").multiselect( 'refresh' );
				$("#remarks2").multiselect("disable");
				//document.getElementById("remarks2").options.selectedIndex = 0;
				//$('#remarks2').attr('disabled','disabled');
			}else if(val2 == 'Fail'){
				 $("#remarks2").multiselect("enable");
				 $("#remarks2").attr('required',true);
				//$('#remarks2').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points3" ).on('change' , function() {
			//var val = this.value;
			let val3 = $(this).val();
			console.log(val3);
			if(val3 == 'Pass'){
				$("#remarks3").multiselect("clearSelection");
 				$("#remarks3").multiselect( 'refresh' );
				$("#remarks3").multiselect("disable");
				// document.getElementById("remarks3").options.selectedIndex = 0;
				// $('#remarks3').attr('disabled','disabled');
			}else if(val3 == 'Fail'){
				$("#remarks3").multiselect("enable");
				$("#remarks3").attr('required',true);
				//$('#remarks3').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points4" ).on('change' , function() {
			//var val = this.value;
			let val4 = $(this).val();
			console.log(val4);
			if(val4 == 'Pass'){
				$("#remarks4").multiselect("clearSelection");
 				$("#remarks4").multiselect( 'refresh' );
				$("#remarks4").multiselect("disable");
				//document.getElementById("remarks4").options.selectedIndex = 0;
				//$('#remarks4').attr('disabled','disabled');
			}else if(val4 == 'Fail'){
				$("#remarks4").multiselect("enable");
				$("#remarks4").attr('required',true);
				//$('#remarks4').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points5" ).on('change' , function() {
			//var val = this.value;
			let val5 = $(this).val();
			console.log(val5);
			if(val5 == 'Pass'){
				$("#remarks5").multiselect("clearSelection");
 				$("#remarks5").multiselect( 'refresh' );
				$("#remarks5").multiselect("disable");
				//document.getElementById("remarks5").options.selectedIndex = 0;
				//$('#remarks5').attr('disabled','disabled');
			}else if(val5 == 'Fail'){
				$("#remarks5").multiselect("enable");
				$("#remarks5").attr('required',true);
				//$('#remarks5').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points6" ).on('change' , function() {
			//var val = this.value;
			let val6 = $(this).val();
			console.log(val6);
			if(val6 == 'Pass'){
				$("#remarks6").multiselect("clearSelection");
 				$("#remarks6").multiselect( 'refresh' );
				$("#remarks6").multiselect("disable");
				//document.getElementById("remarks6").options.selectedIndex = 0;
				//$('#remarks6').attr('disabled','disabled');
			}else if(val6 == 'Fail'){
				$("#remarks6").multiselect("enable");
				$("#remarks6").attr('required',true);
				//$('#remarks6').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points7" ).on('change' , function() {
			//var val = this.value;
			let val7 = $(this).val();
			console.log(val7);
			if(val7 == 'Pass'){
				$("#remarks7").multiselect("clearSelection");
 				$("#remarks7").multiselect( 'refresh' );
				$("#remarks7").multiselect("disable");
				//document.getElementById("remarks7").options.selectedIndex = 0;
				//$('#remarks7').attr('disabled','disabled');
			}else if(val7 == 'Fail'){
				$("#remarks7").multiselect("enable");
				$("#remarks7").attr('required',true);
				//$('#remarks7').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points8" ).on('change' , function() {
			//var val = this.value;
			let val8 = $(this).val();
			console.log(val8);
			if(val8 == 'Pass'){
				$("#remarks8").multiselect("clearSelection");
 				$("#remarks8").multiselect( 'refresh' );
				$("#remarks8").multiselect("disable");
				//document.getElementById("remarks8").options.selectedIndex = 0;
				//$('#remarks8').attr('disabled','disabled');
			}else if(val8 == 'Fail'){
				$("#remarks8").multiselect("enable");
				$("#remarks8").attr('required',true);
				//$('#remarks8').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points9" ).on('change' , function() {
			//var val = this.value;
			let val9 = $(this).val();
			console.log(val9);
			if(val9 == 'Pass'){
				$("#remarks9").multiselect("clearSelection");
 				$("#remarks9").multiselect( 'refresh' );
				$("#remarks9").multiselect("disable");
				//document.getElementById("remarks9").options.selectedIndex = 0;
				//$('#remarks9').attr('disabled','disabled');
			}else if(val9 == 'Fail'){
				$("#remarks9").multiselect("enable");
				$("#remarks9").attr('required',true);
				//$('#remarks9').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points10" ).on('change' , function() {
			//var val = this.value;
			let val10 = $(this).val();
			console.log(val10);
			if(val10 == 'Pass'){
				$("#remarks10").multiselect("clearSelection");
 				$("#remarks10").multiselect( 'refresh' );
				$("#remarks10").multiselect("disable");
				//document.getElementById("remarks10").options.selectedIndex = 0;
				//$('#remarks10').attr('disabled','disabled');
			}else if(val10 == 'Fail'){
				$("#remarks10").multiselect("enable");
				$("#remarks10").attr('required',true);
				//$('#remarks10').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
			}
		});

		$( "#status_points11" ).on('change' , function() {
			//var val = this.value;
			let val11 = $(this).val();
			console.log(val11);
			if(val11 == 'Pass'){
				$("#remarks11").multiselect("clearSelection");
 				$("#remarks11").multiselect( 'refresh' );
				$("#remarks11").multiselect("disable");
				//document.getElementById("remarks11").options.selectedIndex = 0;
				//$('#remarks11').attr('disabled','disabled');
			}else if(val11 == 'Fail'){
				$("#remarks11").multiselect("enable");
				$("#remarks11").attr('required',true);
				//$('#remarks11').attr('disabled', false);
				//$('#remarks1').removeAttribute('disabled');
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

<script>
	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date() });
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });

	//  $(function () {
	// 	$('input[type=file]').change(function () {
	// 		var val = $(this).val().toLowerCase();
	// 			 regex = new RegExp("(.*?)\.(mp3|avi|mp4|wmv|wav)$");
	// 			//regex = new RegExp("(.*?)\.(avi|mp4|3gp|mpeg|mpg|mov|mp3|flv|wmv|mkv|wav)$");
				

	// 		if (!(regex.test(val))) {
	// 			$(this).val('');
	// 			alert('This is not an allowed file type. Please upload correct file format');
	// 			return false;
	// 		}
	// 	});
	// });

// function date_validation(val,type){ 
// 	// alert(val);
// 		$(".end_date_error").html("");
// 		$(".start_date_error").html("");
// 		if(type=='E'){
// 		var start_date=$("#from_date").val();
// 		//if(val<start_date)
// 		if(Date.parse(val) < Date.parse(start_date))
// 		{
// 			$(".end_date_error").html("To Date must be greater or equal to From Date");
// 			 $(".blains-effect").attr("disabled",true);
// 			 $(".blains-effect").css('cursor', 'no-drop');
// 			 $(':input[type="submit"]').prop('disabled', true);
// 		}
// 		else{
// 			 $(".blains-effect").attr("disabled",false);
// 			 $(".blains-effect").css('cursor', 'pointer');
// 			 $(':input[type="submit"]').prop('disabled', false);
// 			}
// 		}
// 		else{
// 			var end_date=$("#to_date").val();
// 		//if(val>end_date && end_date!='')
		
// 		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
// 		{
// 			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
// 			 $(".blains-effect").attr("disabled",true);
// 			 $(".blains-effect").css('cursor', 'no-drop');
// 			 $(':input[type="submit"]').prop('disabled', true);
			
// 		}
// 		else{
// 			 $(".blains-effect").attr("disabled",false);
// 			 $(".blains-effect").css('cursor', 'pointer');
// 			 $(':input[type="submit"]').prop('disabled', false);
// 			}

// 		}
		
		
// 	}

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
							//console.log(cust_earned);
							$("#customer_earned_score").val(cust_earned);
							$("#customer_possible_score").val(cust_possible);
							$("#customer_overall_score").val(parseFloat((cust_earned/cust_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("compliance")){
							comp_earned+=earned_weightage;
							comp_possible+=weightage;
							//console.log(comp_earned);
							$("#compliance_earned_score").val(comp_earned);
							$("#compliance_possible_score").val(comp_possible);
							$("#compliance_overall_score").val(parseFloat((comp_earned/comp_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("business")){
							business_earned+=earned_weightage;
							business_possible+=weightage;
							//console.log(business_earned);
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
	function hcci_core_calc(){
		var check_fatal=false;
			$(".hcci_point").each(function(){
				if($(this).hasClass("hcci_fatal") && ($(this).val()=="Fail") ){
					check_fatal=true;
					$("#hcci_overall_score").val("0.00%");
				}
			});
			if(!check_fatal){
				//var earned_score = 0, possible_score=0, overall_score="";
				var earned_score = 0, possible_score=0, overall_score="", cust_earned=0, cust_possible=0, cust_overall=0;
			    var comp_earned=0, comp_possible=0, comp_overall=0, business_earned=0, business_possible=0, business_overall=0;
				$(".hcci_point").each(function(index, element){
					if($(element).val()!="N/A" && $(element).val()!=""){
						var earned_weightage = parseFloat($(element).children("option:selected").attr('hcci_val'));
						earned_score += earned_weightage;
						var weightage = parseFloat($(element).children("[value='Pass']").attr('hcci_val'));
						possible_score += weightage;
						overall_score=parseFloat((earned_score/possible_score)*100);
						
						if($(this).hasClass("customer")){
							cust_earned+=earned_weightage;
							cust_possible+=weightage;
							//console.log(cust_earned);
							$("#customer_earned_score").val(cust_earned);
							$("#customer_possible_score").val(cust_possible);
							$("#customer_overall_score").val(parseFloat((cust_earned/cust_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("compliance")){
							comp_earned+=earned_weightage;
							comp_possible+=weightage;
							//console.log(comp_earned);
							$("#compliance_earned_score").val(comp_earned);
							$("#compliance_possible_score").val(comp_possible);
							$("#compliance_overall_score").val(parseFloat((comp_earned/comp_possible)*100).toFixed(2)+"%");
						}
						if($(this).hasClass("business")){
							business_earned+=earned_weightage;
							business_possible+=weightage;
							//console.log(business_earned);
							$("#business_earned_score").val(business_earned);
							$("#business_possible_score").val(business_possible);
							$("#business_overall_score").val(parseFloat((business_earned/business_possible)*100).toFixed(2)+"%");
						}

						$("#hcci_overall_score").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
						
					}
				});
			}
			if(!isNaN(earned_score)){
				$("#hcci_earned_score").val(earned_score);
			}
			if(!isNaN(possible_score)){
				$("#hcci_possible_score").val(possible_score);
			}
	}
</script>

<script type="text/javascript">
	$(document).on("change", ".avon_point", function(){
			avon_calc();
	});
	avon_calc();

	$(document).on("change", ".hcci_point", function(){
			hcci_core_calc();
	});
	hcci_core_calc();

	///////////////// Agent and TL names ///////////////////////
	$( "#agent_id" ).on('change' , function() {
		var aid = this.value;
		if(aid=="") //alert("Please Select Agent")
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
