<script type="text/javascript">	
$(document).ready(function(){ 
	
	$("#audit_date").datepicker();
	// $("#call_date").datepicker();
	$("#call_date").datepicker({  maxDate: new Date() });
	$("#review_date").datepicker();
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#sigment_duration").timepicker({timeFormat : 'HH:mm:ss' });

	$("#call_date_time").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	$(".agentName").select2();

	///////////////// Calibration - Auditor Type ///////////////////////
	$('#audit_type').each(function(){
		$valdet=$(this).val();
		if($valdet=="Calibration"){
			$('.auType_epi').show();
		}else{
			$('.auType_epi').hide();
		}
	});

	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType_epi').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			//alert(222);
			$('.auType_epi').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});

	
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

<script>
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
			 $(".esal-effect").attr("disabled",true);
			 $(".esal-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".esal-effect").attr("disabled",false);
			 $(".esal-effect").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".esal-effect").attr("disabled",true);
			 $(".esal-effect").css('cursor', 'no-drop');
		}
		else{
			 $(".esal-effect").attr("disabled",false);
			 $(".esal-effect").css('cursor', 'pointer');
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

<script>
	$('INPUT[type="file"]').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];
		switch (ext) {
			case 'avi':
			case 'mp4':
			case '3gp':
			case 'mpeg':
			case 'mpg':
			case 'mov':
			case 'mp3':
			case 'wav':
			case 'flv':
			case 'wmv':
			case 'm4a':
			case 'mkv':
			$('#qaformsubmit').attr('disabled', false);
			break;
		default:
			alert('This is not an allowed file type.');
			//$('#qaformsubmit').attr('disabled', true);
			this.value = '';
		}
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

<!--Use For Programing-->
<script>
//////////////// queens and english ///////////////////////
	function do_queens_english(){
		var score=0;

		var score = 0;
		var scoreable = 0;
		var na_count = 0;
		var quality_score_percent = 0;
		$('.queens').each(function(index,element){
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
		if($('#queensAF1').val()=='No' || $('#queensAF2').val()=='No' || $('#queensAF3').val()=='No' || $('#queensAF4').val()=='No' || $('#queensAF5').val()=='No' || $('#queensAF6').val()=='No' || $('#queensAF7').val()=='No'){
			$('.queensFatal').val(0.00+'%');
		}else{
			$('.queensFatal').val(score+'%');
		}
	}

	$(document).on('change','.queens',function(){
		do_queens_english();
	});
	do_queens_english();

	</script>

	<script>
//////////////// groupe and france ///////////////////////
	function do_group_france(){
		var score=0;
		$('.group_france_point').each(function(index,element){
			var group_france = parseFloat($(element).children("option:selected").attr('group_france_val'));
			score = score + group_france;
		});
		if(!isNaN(score)){
			$('#group_overallScore').val(score+'%');
		}

	}

	$(document).on('change','.group_france_point',function(){
		do_group_france();
	});
	do_group_france();

	</script>

	<script>
	////////////////////// AB Commercial ////////////////////
function do_ab_commercial_rp(){
	     //alert("Oooooo");
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.commercial_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('commercial_val'));
				score = score + weightage;
		  });

		$('#commercial_overoll_score').val(score);  
	}

    $(document).on('change','.commercial_point',function(){
		do_ab_commercial_rp();
    });
	do_ab_commercial_rp();	
	</script>

<script>
////////////////////// indiabulls ////////////////////
function do_indiabulls(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		$('.indiabulls_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('bull_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('bull_val'));
				scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);

         if(!isNaN(score)){
         	if(score==800){
			$('#indiabullScore').val(quality_score_percent+'%');
		    }else{
		    $('#indiabullScore').val('');	
		    }
		}

       //Fatal
       /*---------------*/
		if($('#indiabullFAt').val()=='No'){
			$('#indiabullScore').val(0);
		}else{
			if(score==800){
			$('#indiabullScore').val(quality_score_percent+'%');
		    }
		}

 }

 $(document).on('change','.indiabulls_point',function(){
		do_indiabulls();
	});
   do_indiabulls();
</script>

<script>
////////////////////// final PMO ////////////////////
var fatal_score = 0;
function do_final_pmo(){
		var score = 0;
		var scoreable = 0;
		var scoreable1 = 0;
		var na_count = 0;
		var fatal = 0;
		var quality_score_percent = 0;
		// var fatal_score = 0;
		$('.final_pmo_point').each(function(index,element){

			var score_type = $(element).val();
			// alert(score_type);
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				scoreable = scoreable + weightage;

			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});

		
		// console.log(fatal_score);
		quality_score_percent = ((score*100)/scoreable).toFixed(2) - fatal_score;

		// alert(quality_score_percent);
		// alert(score);
		// alert(scoreable);
         $('#final_pmo_earned_score').val(score);

         $('#final_pmo_earned_score_hidden').val(score);
		 $('#final_pmo_possible_score').val(scoreable);
         if(!isNaN(quality_score_percent)){
			$('#final_pmo_overall_score').val(quality_score_percent+'%'); 
		 }



///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	var riya = $('#final_pmo_overall_score').val();
	console.log(riya, String(riya).includes('-'));
		if(String(riya).includes('-')){
			// alert ('negative');
			$('.final_pmo_overall_score').val(0);
		}else{
			$('.final_pmo_overall_score').val(quality_score_percent+'%');
		}

	    // if ($('#fatal2').val() == 'No') {
     //    $('.final_pmo_overall_score').val(quality_score_percent-15);

	    // }else {
	    //     $(".final_pmo_overall_score").val(quality_score_percent + '%');

	    // }	

///////////////////////////// COPC Score //////////////////////////////////////
		var busi_score = 0;
		var busi_scoreable = 0;
		var busi_total = 0;
		$('.busiScore').each(function(index,element){
			var sc1 = $(element).val();
            if(sc1 =='Yes'){
				var w1 = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				busi_score = busi_score + w1;
				busi_scoreable = busi_scoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				busi_scoreable = busi_scoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				busi_score = busi_score + w1;
				busi_scoreable = busi_scoreable + w1;
			}
		});
		$('#businessEarnScore').val(busi_score); 
		$('#businessPossibleScore').val(busi_scoreable);
		busi_total = ((busi_score*100)/busi_scoreable).toFixed(2);
		if(!isNaN(busi_total)){
			$('#businessScore').val(busi_total+'%'); 
		}
		
		
		var cust_score = 0;
		var cust_scoreable = 0;
		var cust_total = 0;
		$('.custScore').each(function(index,element){
			var sc2 = $(element).val();
            if(sc2 =='Yes'){
				var w2 = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				cust_score = cust_score + w2;
				cust_scoreable = cust_scoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				cust_scoreable = cust_scoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseFloat($(element).children("option:selected").attr('final_pmo_val'));
				cust_score = cust_score + w2;
				cust_scoreable = cust_scoreable + w2;
			}
		});
		$('#customerEarnScore').val(cust_score); 
		$('#customerPossibleScore').val(cust_scoreable); 
		cust_total = ((cust_score*100)/cust_scoreable).toFixed(2);
		if(!isNaN(cust_total)){
			$('#customerScore').val(cust_total+'%'); 
		}

///////////////////////////////////////////////////////////////////////////////////////////

 }

$(document).on('change','.final_pmo_point',function(){
	if($(this).hasClass("section5")){
		fatal_score=0;
		$(".section5").each((index, element)=>{

			if($(element).val() == "No"){
				fatal_score = parseInt(fatal_score) + 15;
				console.log(fatal_score);
				// $("#final_pmo_overall_score").val(parseFloat($("#final_pmo_overall_score").val()) - 15);
				// $('#final_pmo_earned_score_hidden').val(parseFloat($("#final_pmo_earned_score").val())-15);
			}
		})
	}
	do_final_pmo();
});

$(document).on('change','.busiScore',function(){ do_final_pmo(); });
$(document).on('change','.custScore',function(){ do_final_pmo(); });

do_final_pmo();
</script>

<script>
	////////////////////// Sentient Jet/ ////////////////////
function do_sentient_jet(){
	     //alert("Oooooo");
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.sentient_point').each(function(index,element){
			
				// var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
				// score = score + weightage;


				var score_type = $(element).val();
			// if(score_type == 'Yes'){
			//     var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
			//     score = score + weightage;
			//     scoreable = scoreable + weightage;
			// }else if(score_type == 'No'){
			//     var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
			//     scoreable = scoreable + weightage;
			// }else if(score_type == 'MidPoint'){
			//     var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
			//     scoreable = scoreable + weightage;
			// }else if(score_type == 'N/A'){
			//     var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
			//     score = score + weightage;
			//     scoreable = scoreable + weightage;
			// }

			
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
			    var max_wght = parseFloat($(element).children("option:selected").attr('sentient_val_max'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('sentient_val_max'));
				score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'MidPoint'){
			    var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('sentient_val_max'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('sentient_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('sentient_val_max'));
			    score = score + weightage;
			    scoreable = scoreable + max_wght;
			}
		});


		 if ($('#loanxmf').val() == 'Midpoint') {
        $('.sentient_jet_earnedScore').val(score-2.5);

	    } else {
	        $(".sentient_jet_earnedScore").val(totalscore + '%');

	    }

  		// totalscore = ((score*100)/129).toFixed(2);
		// $('#sentient_jet_overall_score').val(totalscore); 
		// if(totalscore>=85){
		// $('#final_result').val('Pass').css("color", "green");
		// } else {
		// $('#final_result').val('Fail').css("color", "red");
		// }


		totalscore = ((score*100)/scoreable).toFixed(2);
		
		$('#sentient_jet_earnedScore').val(score);
		$('#sentient_jet_possibleScore').val(scoreable);
		
		if(!isNaN(totalscore)){
			$('#sentient_jet_overall_score').val(totalscore+'%');
		}

		//////////////// Customer/Business/Compliance //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseInt($(element).children("option:selected").attr('sentient_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('sentient_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('sentient_val'));
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
				var w2 = parseInt($(element).children("option:selected").attr('sentient_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('sentient_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('sentient_val'));
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
				var w3 = parseInt($(element).children("option:selected").attr('sentient_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('sentient_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('sentient_val'));
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

    $(document).on('change','.sentient_point',function(){
		do_sentient_jet();
    });
	do_sentient_jet();



	$(document).on('change','#evaluated',function(){
		do_evaluated();
		function do_evaluated(){
        var number=document.getElementById("evaluated").value; 
        const dateObj = new Date(number);
		const monthNameLong = dateObj.toLocaleString("en-US", { month: "long" });
		$('#evaluated_date').val(monthNameLong); 
		//Use For Week
		const currentdate = new Date(number);
        const oneJan = new Date(currentdate.getFullYear(),0,1);
        const numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000));
        const result = Math.ceil(( currentdate.getDay() + 1 + numberOfDays) / 7);
       $('#week').val(result);

		}
    });	
	</script>

<script>
function grille_moreco(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		
		$('.grille_moreco_point').each(function(index,element){
			//alert("Ooooo");
			var score_type = $(element).val();
			if(score_type != "N/A"){
				var weightage = parseFloat($(element).children("option:selected").attr('grille_moreco_val'));
				score = score + parseFloat(weightage*(score_type/100));
				scoreable = scoreable + weightage;
			}
		});
        
		score = parseFloat(score);
		quality_score_percent = parseFloat(scoreable);
		
		var quality_score_percent=((score*100)/quality_score_percent).toFixed(2);
        
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}			
	
	}
	

$(document).on('change','.grille_moreco_point',function(){
	grille_moreco();
    });
	grille_moreco();
</script>

<script type="text/javascript">
////////////////////// Icario ///////////////////////////////////	
	function icario_calculation(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var na_count = 0;
		
		$('.icario_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('icario_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('icario_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('icario_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#fb_earnedScore1').val(score);
		$('#fb_possibleScore1').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#icario_overallScore').val(quality_score_percent+'%');
			if($('#autoF6').val()=='Yes'){
		     var ppp = parseFloat(quality_score_percent)+parseFloat(5);
             $('.bonusAutofail').val(ppp+'%');
		     }
		}
	
	    if($('#autoF1').val()=='No' || $('#autoF2').val()=='Yes' || $('#autoF3').val()=='Yes' || $('#autoF4').val()=='Yes' || $('#autoF5').val()=='Yes'){
			$('.icarioAutofail').val(0);
			$('.bonusAutofail').val(0);
		}else{
			$('.icarioAutofail').val(quality_score_percent+'%');
		}

		if($('#icarioF1').val()=='Yes' || $('#icarioF2').val()=='Yes' || $('#icarioF3').val()=='Yes' || $('#icarioF4').val()=='Yes' || $('#icarioF5').val()=='Yes'){
			$('.icarioAutofail').val(0);
			$('.bonusAutofail').val(0);
		}else{
			$('.icarioAutofail').val(quality_score_percent+'%');
		}

		if($('#icaF1').val()=='No' || $('#icaF2').val()=='No' || $('#icaF3').val()=='No' || $('#icaF4').val()=='No' || $('#icaF5').val()=='No' || $('#icaF6').val()=='No'){
			$('.icaAutofail').val(0);
		}else{
			$('.icaAutofail').val(quality_score_percent+'%');
		}
		
		/////////////////////////////////Critical score////////////////////////////////////////


		var compliancescore1 = 0;
		var compliancescoreable1 = 0;
		var compliance_score_percent1 = 0;
		var customerscore1 = 0;
		var customerscoreable1 = 0;
		var customer_score_percent1 = 0;
		var businessscore1 = 0;
		var businessscoreable1 = 0;
		var business_score_percent1 = 0;
		
		$('.comp').each(function(index,element){
			var score_type1 = $(element).val();
			
			if(score_type1 == 'Yes'){
				var weightage1 = parseInt($(element).children("option:selected").attr('icario_val'));
				compliancescore1 = compliancescore1 + weightage1;
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseInt($(element).children("option:selected").attr('icario_val'));
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseInt($(element).children("option:selected").attr('icario_val'));
				compliancescore1 = compliancescore1 + weightage1;
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}
		});
		compliance_score_percent = ((compliancescore1*100)/compliancescoreable1).toFixed(2);
		$('#comp_score').val(compliancescore1);
		$('#comp_scoreable').val(compliancescoreable1);
		$('#comp_score_percent').val(compliance_score_percent+'%');
	//////////////
		$('.cust').each(function(index,element){
			var score_type2 = $(element).val();
			
			if(score_type2 == 'Yes'){
				var weightage2 = parseInt($(element).children("option:selected").attr('icario_val'));
				customerscore1 = customerscore1 + weightage2;
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseInt($(element).children("option:selected").attr('icario_val'));
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseInt($(element).children("option:selected").attr('icario_val'));
				customerscore1 = customerscore1 + weightage2;
				customerscoreable1 = customerscoreable1 + weightage2;
			}
		});
		customer_score_percent = ((customerscore1*100)/customerscoreable1).toFixed(2);
		$('#cust_score').val(customerscore1);
		$('#cust_scoreable').val(customerscoreable1);
		$('#cust_score_percent').val(customer_score_percent+'%');
	//////////////
		$('.busi').each(function(index,element){
			var score_type3 = $(element).val();
			
			if(score_type3 == 'Yes'){
				var weightage3 = parseInt($(element).children("option:selected").attr('icario_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseInt($(element).children("option:selected").attr('icario_val'));
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseInt($(element).children("option:selected").attr('icario_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}
		});
		business_score_percent = ((businessscore1*100)/businessscoreable1).toFixed(2);
		$('#busi_score').val(businessscore1);
		$('#busi_scoreable').val(businessscoreable1);
		$('#busi_score_percent').val(business_score_percent+'%');


		///////////////////////////////////////////////////////////////////////////////////////
        
        //Mechanics
        var score22 = 0;
		var scoreable22 = 0;
		var quality_score_percent22 = 0;
		var weightage22=0;
		
		$('.mechanic').each(function(index,element){
			var score_type22 = $(element).val();
			
			if(score_type22 == 'Yes'){
				weightage22 = parseFloat($(element).children("option:selected").attr('icario_val'));
				score22 = score22 + weightage22;
				scoreable22 = scoreable22 + weightage22;
			}else if(score_type22 == 'No'){
			    weightage22 = parseFloat($(element).children("option:selected").attr('icario_val'));
				scoreable22 = scoreable22 + weightage22;
			}else if(score_type22 == 'N/A'){
				weightage22 = parseFloat($(element).children("option:selected").attr('icario_val'));
				score22 = score22 + weightage22;
				scoreable22 = scoreable22 + weightage22;
			}
		});

		quality_score_percent22 = ((score22*100)/scoreable22).toFixed(2);
		$('#fb_earnedScore2').val(score22);
		$('#fb_possibleScore2').val(scoreable22);
		
		if(!isNaN(quality_score_percent22)){
			$('#icario_overallScore2').val(quality_score_percent22+'%');
		}
              
         // Soft Skills
         var score33 = 0;
		 var scoreable33 = 0;
		 var quality_score_percent33 = 0;
         $('.soft_skill').each(function(index,element){
			var score_type33 = $(element).val();
			
			if(score_type33 == 'Yes'){
				var weightage33 = parseFloat($(element).children("option:selected").attr('icario_val'));
				score33 = score33 + weightage33;
				scoreable33 = scoreable33 + weightage33;
			}else if(score_type33 == 'No'){
				var weightage33 = parseFloat($(element).children("option:selected").attr('icario_val'));
				scoreable33 = scoreable33 + weightage33;
			}else if(score_type33 == 'N/A'){
				var weightage33 = parseFloat($(element).children("option:selected").attr('icario_val'));
				score33 = score33 + weightage33;
				scoreable33 = scoreable33 + weightage33;
			}
		});

		quality_score_percent33 = ((score33*100)/scoreable33).toFixed(2);
		$('#fb_earnedScore3').val(score33);
		$('#fb_possibleScore3').val(scoreable33);
		
		if(!isNaN(quality_score_percent33)){
			$('#icario_overallScore3').val(quality_score_percent33+'%');
		}

	}

	$(document).on('change','.icario_point',function(){
		icario_calculation();
	});
	icario_calculation();

</script>

<script>
	////////////////////// LM New ////////////////////
function do_lm_new_vrs(){
	     //alert("Oooooo");
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;

		$('.lm_new_point').each(function(index,element){
				var weightage = parseFloat($(element).children("option:selected").attr('lm_val'));
				score = score + weightage;
		  });

		$('#lm_overoll_score').val(score);

        if($('#lm_FAT1').val()=='No' || $('#lm_FAT2').val()=='No' || $('#lm_FAT3').val()=='No' || $('#lm_FAT4').val()=='No' || $('#lm_FAT5').val()=='No' || $('#lm_FAT6').val()=='No' || $('#lm_FAT7').val()=='No' || $('#lm_FAT8').val()=='Yes' || $('#lm_FAT9').val()=='Yes' || $('#lm_FAT10').val()=='Yes' || $('#lm_FAT11').val()=='No' || $('#lm_FAT12').val()=='No'){
			$('.lm_fatal').val(0);
		}else{
			$('.lm_fatal').val(score+'%');
		}

	}

    $(document).on('change','.lm_new_point',function(){
		do_lm_new_vrs();
    });
	do_lm_new_vrs();	
	</script>

<script>
////////////////////// Phone Inbound ///////////////////////
	function do_phone_inbound(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;
		var na_count = 0;
		
		$('.phone_inbound').each(function(index,element){
			console.dir(element);
			var score_type = $(element).val();
			var weightage = parseFloat($(element).children("option:selected").attr('phone_inbound_val'));
			var weightage_scoreable = parseFloat($(element).children("option:selected").attr('phone_inbound_max_val'));
            if(score_type =='Yes'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == 'NA'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == 'No'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '0'){
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '1'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '2'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '3'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '4'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}
		});
        totalscore = ((score*100)/scoreable).toFixed(2);
		$('#phone_earnedScore').val(score);
		$('#phone_possibleScore').val(scoreable);
        
		if(!isNaN(totalscore)){
			$('#phone_overallScore').val(totalscore+'%');
		};
		
		if($('#phone_FAT1').val()=='Yes' || $('#phone_FAT2').val()=='Yes'){
			$('.phoneInbAutofail').val(0);
		}else{
			$('.phoneInbAutofail').val(totalscore+'%');
		}

	}


    $(document).on('change','.phone_inbound',function(){
		do_phone_inbound();
    });
	 do_phone_inbound();

</script>

<script>
////////////////////// Processing QA //////////////////////
	function do_processing(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;
		var na_count = 0;
		$('.processing').each(function(index,element){
			console.dir(element);
			var score_type = $(element).val();
			var weightage = parseFloat($(element).children("option:selected").attr('processing_val'));
			var weightage_scoreable = parseFloat($(element).children("option:selected").attr('processing_max_val'));
            if(score_type =='Yes'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == 'NA'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '0'){
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '1'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '2'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '3'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}else if(score_type == '4'){
				score = score + weightage;
				scoreable = scoreable + weightage_scoreable;
			}
		});
         // totalscore = ((score*100)/47).toFixed(2);
         totalscore = ((score*100)/scoreable).toFixed(2);
		$('#processing_earnedScore').val(score);
		$('#processing_possibleScore').val(scoreable);
        
		if(!isNaN(totalscore)){
			$('#processing_overallScore').val(totalscore+'%');
		};
		if($('#processing_FAT1').val()=='Yes' || $('#processing_FAT2').val()=='Yes'){
			$('.processingAutofail').val(0);
		}else{
			$('.processingAutofail').val(totalscore+'%');
		}



	}

    $(document).on('change','.processing',function(){
		do_processing();
    });
	 do_processing();

</script>

									<!-- Riya -->
<script>
function do_authentication(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.authentication_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('authentication_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });

		$('#authentication_overall').val(grade1);
	}

    $(document).on('change','.authentication_grade',function(){
		do_authentication();
    });
	do_authentication();

</script>
<script>
function do_professionalism(){
		var grade2 = 0;
		var scoreable2 = 0;
		var totalgrade2 = 0;
		var na_count = 0;
		
		$('.professionalism_grade').each(function(index,element){
				var weightage2 = parseFloat($(element).children("option:selected").attr('professionalism_val'));
				grade2 = grade2 + weightage2;
				// alert(weightage1);
		  });

		$('#professionalism_overall').val(grade2);
	}

    $(document).on('change','.professionalism_grade',function(){
		do_professionalism();
    });
	do_professionalism();

</script>
<script>
function do_call_handling_skills(){
		var grade3 = 0;
		var scoreable3 = 0;
		var totalgrade3 = 0;
		var na_count = 0;
		
		$('.call_handling_skills_grade').each(function(index,element){
				var weightage3 = parseFloat($(element).children("option:selected").attr('call_handling_skills_val'));
				grade3 = grade3 + weightage3;
				// alert(weightage1);
		  });

		$('#call_handling_skills_overall').val(grade3);
	}

    $(document).on('change','.call_handling_skills_grade',function(){
		do_call_handling_skills();
    });
	do_call_handling_skills();

</script>
<script>
function do_brightway_knowledge(){
		var grade4 = 0;
		var scoreable4 = 0;
		var totalgrade4 = 0;
		var na_count = 0;
		
		$('.brightway_knowledge_grade').each(function(index,element){
				var weightage4 = parseFloat($(element).children("option:selected").attr('brightway_knowledge_val'));
				grade4 = grade4 + weightage4;
				// alert(weightage1);
		  });

		$('#brightway_knowledge_overall').val(grade4);
	}

    $(document).on('change','.brightway_knowledge_grade',function(){
		do_brightway_knowledge();
    });
	do_brightway_knowledge();

</script>

<script>
function do_documentation(){
		var grade5 = 0;
		var scoreable5 = 0;
		var totalgrade5 = 0;
		var na_count = 0;
		
		$('.documentation_grade').each(function(index,element){
				var weightage5 = parseFloat($(element).children("option:selected").attr('documentation_val'));
				grade5 = grade5 + weightage5;
				// alert(weightage1);
		  });

		$('#documentation_overall').val(grade5);
	}

    $(document).on('change','.documentation_grade',function(){
		do_documentation();
    });
	do_documentation();

</script>

<script>
function do_contact_resolution(){
		var grade6 = 0;
		var scoreable6 = 0;
		var totalgrade6 = 0;
		var na_count = 0;
		
		$('.contact_resolution_grade').each(function(index,element){
				var weightage6 = parseFloat($(element).children("option:selected").attr('contact_resolution_val'));
				grade6 = grade6 + weightage6;
				// alert(weightage1);
		  });

		$('#contact_resolution_overall').val(grade6);
	}

    $(document).on('change','.contact_resolution_grade',function(){
		do_contact_resolution();
    });
	do_contact_resolution();

</script>
<script>
function do_bonus_questions(){
		var grade7 = 0;
		var scoreable7 = 0;
		var totalgrade7 = 0;
		var na_count = 0;
		
		$('.bonus_questions_grade').each(function(index,element){
				var weightage7 = parseFloat($(element).children("option:selected").attr('bonus_questions_val'));
				grade7 = grade7 + weightage7;
				// alert(weightage1);
		  });

		$('#bonus_questions_overall').val(grade7);
	}

    $(document).on('change','.bonus_questions_grade',function(){
		do_bonus_questions();
    });
	do_bonus_questions();

</script>
<script>
function do_penalty_questions(){
		var grade8 = 0;
		var scoreable8 = 0;
		var totalgrade8 = 0;
		var na_count = 0;
		
		$('.penalty_questions_grade').each(function(index,element){
				var weightage8 = parseFloat($(element).children("option:selected").attr('penalty_questions_val'));
				grade8 = grade8 + weightage8;
				// alert(weightage1);
		  });

		$('#penalty_questions_overall').val(grade8);
	}

    $(document).on('change','.penalty_questions_grade',function(){
		do_penalty_questions();
    });
	do_penalty_questions();

</script>


<!-- <script>
	////////////////////// Processing/ ////////////////////
function do_processing(){
		var score = 0;
		var scoreable = 0;
		var totalscore = 0;
		var na_count = 0;
		$('.processing_point').each(function(index,element){
			
				var weightage = parseFloat($(element).children("option:selected").attr('processing_val'));
				score = score + weightage;
			
		  });
        totalscore = ((score*100)/54).toFixed(2);
		if(!isNaN(totalscore)){
			$('#processing_overallScore').val(totalscore+'%');
		};
		if($('#processing_FAT1').val()=='Yes' || $('#processing_FAT2').val()=='Yes'){
			$('.processingAutofail').val(0);
		}else{
			$('.processingAutofail').val(totalscore+'%');
		} 
	}

    $(document).on('change','.processing_point',function(){
		do_processing();
    });
	do_processing();

</script> -->
<script>
////////////////////// Od Voice(Parfect)////////////////////
function do_od_voice(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var na_count=0;
		$('.od_voice_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('od_voice_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('od_voice_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});

		 quality_score_percent = parseInt(((score*100)/scoreable));
		 $('#od_voice_earned_score').val(score);
		 $('#od_voice_possible_score').val(scoreable);
         if(!isNaN(quality_score_percent)){
			$('#od_voice_overall_score').val(quality_score_percent+'%');
		    }else{
		    $('#od_voice_overall_score').val('');	
		    }

		if($('#voice_FA').val()=='No'){
			$('.voice_fatal').val(0+'%');
		}else{
			$('.voice_fatal').val(quality_score_percent+'%');
		}
       //Pass fail
		if(quality_score_percent>=90){
		$('#voice_score').val('Pass');
		$('#voice_score').css('background-color', '#00FF00');
		}else{
		$('#voice_score').val('Fail');   
		$('#voice_score').css('background-color', '#e01507');
		}


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
			
			if(score_type1 == 'Yes'){
				var weightage1 = parseInt($(element).children("option:selected").attr('od_voice_val'));
				compliancescore1 = compliancescore1 + weightage1;
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseInt($(element).children("option:selected").attr('od_voice_val'));
				compliancescoreable1 = compliancescoreable1 + weightage1;
			}else if(score_type1 == 'N/A'){
				var weightage1 = parseInt($(element).children("option:selected").attr('od_voice_val'));
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
			
			if(score_type2 == 'Yes'){
				var weightage2 = parseInt($(element).children("option:selected").attr('od_voice_val'));
				customerscore1 = customerscore1 + weightage2;
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if(score_type2 == 'No'){
				var weightage2 = parseInt($(element).children("option:selected").attr('od_voice_val'));
				customerscoreable1 = customerscoreable1 + weightage2;
			}else if(score_type2 == 'N/A'){
				var weightage2 = parseInt($(element).children("option:selected").attr('od_voice_val'));
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
			
			if(score_type3 == 'Yes'){
				var weightage3 = parseInt($(element).children("option:selected").attr('od_voice_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if(score_type3 == 'No'){
				var weightage3 = parseInt($(element).children("option:selected").attr('od_voice_val'));
				businessscoreable1 = businessscoreable1 + weightage3;
			}else if(score_type3 == 'N/A'){
				var weightage3 = parseInt($(element).children("option:selected").attr('od_voice_val'));
				businessscore1 = businessscore1 + weightage3;
				businessscoreable1 = businessscoreable1 + weightage3;
			}
		});
		business_score_percent = ((businessscore1*100)/businessscoreable1).toFixed(2);
		$('#businessscore1').val(businessscore1);
		$('#businessscoreable1').val(businessscoreable1);
		$('#business_score_percent1').val(business_score_percent+'%');
	
	
		

 }

 $(document).on('change','.od_voice_point',function(){
		do_od_voice();
	});
   do_od_voice();

   ////////////////////// Od Ecommerce(Parfect)////////////////////
function do_od_ecommerce(){

var score = 0;
var scoreable = 0;
var quality_score_percent = 0;
var na_count=0;
$('.od_ecommerce_point').each(function(index,element){
	var score_type = $(element).val();
	if(score_type =='Yes'){
		var weightage = parseFloat($(element).children("option:selected").attr('od_ecommerce_val'));
		score = score + weightage;
		scoreable = scoreable + weightage;
	}else if(score_type == 'No'){
		var weightage = parseFloat($(element).children("option:selected").attr('od_ecommerce_val'));
		scoreable = scoreable + weightage;
	}else if(score_type == 'N/A'){
		na_count = na_count + 1;
	}
});

 quality_score_percent = parseInt(((score*100)/scoreable));
 $('#od_ecommerce_earned_score').val(score);
 $('#od_ecommerce_possible_score').val(scoreable);
 if(!isNaN(quality_score_percent)){
	$('#od_ecommerce_overall_score').val(quality_score_percent+'%');
	}else{
	$('#od_ecommerce_overall_score').val('');	
	}

if($('#ecommerce_FA').val()=='No'){
	$('.ecommerce_fatal').val(0+'%');
}else{
	$('.ecommerce_fatal').val(quality_score_percent+'%');
}
//Pass fail
if(quality_score_percent>=90){
$('#ecommerce_score').val('Pass');
$('#ecommerce_score').css('background-color', '#00FF00');
}else{
$('#ecommerce_score').val('Fail');   
$('#ecommerce_score').css('background-color', '#e01507');
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
		var weightage1 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
		compliancescore2 = compliancescore2 + weightage1;
		compliancescoreable2 = compliancescoreable2 + weightage1;
	}else if(score_type1 == 'No'){
		var weightage1 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
		compliancescoreable2 = compliancescoreable2 + weightage1;
	}else if(score_type1 == 'N/A'){
		var weightage1 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
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
		var weightage2 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
		customerscore2 = customerscore2 + weightage2;
		customerscoreable2 = customerscoreable2 + weightage2;
	}else if(score_type2 == 'No'){
		var weightage2 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
		customerscoreable2 = customerscoreable2 + weightage2;
	}else if(score_type2 == 'N/A'){
		var weightage2 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
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
		var weightage3 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
		businessscore2 = businessscore2 + weightage3;
		businessscoreable2 = businessscoreable2 + weightage3;
	}else if(score_type3 == 'No'){
		var weightage3 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
		businessscoreable2 = businessscoreable2 + weightage3;
	}else if(score_type3 == 'N/A'){
		var weightage3 = parseInt($(element).children("option:selected").attr('od_ecommerce_val'));
		businessscore2 = businessscore2 + weightage3;
		businessscoreable2 = businessscoreable2 + weightage3;
	}
});
business_score_percent = ((businessscore2*100)/businessscoreable2).toFixed(2);
$('#businessscore2').val(businessscore2);
$('#businessscoreable2').val(businessscoreable2);
$('#business_score_percent2').val(business_score_percent+'%');

}

$(document).on('change','.od_ecommerce_point',function(){
do_od_ecommerce();
});
do_od_ecommerce();
</script>

<script>
////////////////////// Od Chat(Parfect)////////////////////
function do_od_chat(){

		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var na_count=0;
		$('.od_chat_point').each(function(index,element){
			var score_type = $(element).val();
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('od_chat_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('od_chat_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});

		 quality_score_percent = parseInt(((score*100)/scoreable));
		 $('#od_chat_earned_score').val(score);
		 $('#od_chat_possible_score').val(scoreable);
         if(!isNaN(quality_score_percent)){
			$('#od_chat_overall_score').val(quality_score_percent+'%');
		    }else{
		    $('#od_chat_overall_score').val('');	
		    }
		
		if($('#chat_FA').val()=='No'){
			$('.od_fatal').val(0+'%');
		}else{
			$('.od_fatal').val(quality_score_percent+'%');
		}
       //Pass fail
		if(quality_score_percent>=90){
		$('#division_score').val('Pass');
		$('#division_score').css('background-color', '#00FF00');
		}else{
		$('#division_score').val('Fail');   
		$('#division_score').css('background-color', '#e01507');
		}
		

 }

 $(document).on('change','.od_chat_point',function(){
		do_od_chat();
	});
   do_od_chat();
</script>


<script>
////////////////////// LTFS New ////////////////////
function do_itfs(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.itfs_point').each(function(index,element){
			var score_type = $(element).val();

			if((score_type =='Hit the Mark') || (score_type =='Needs Work')|| (score_type =='Yes')){
				parameter_count = parameter_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('itfs_val'));
				score = score + weightage;
				scoreable = scoreable + parseInt($(element).children("option:selected").attr('itfs_max'));
			}else if(score_type == 'No'){
				var weightage = parseInt($(element).children("option:selected").attr('itfs_val'));
				scoreable = scoreable + parseInt($(element).children("option:selected").attr('itfs_max'));
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#itfs_earnedScore').val(score);
		$('#itfs_possibleScore').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#itfs_overallScore').val(quality_score_percent+'%');
			}

		 if($('#auto_fail1').val()=='No' || $('#auto_fail2').val()=='No' || $('#auto_fail3').val()=='No' || $('#auto_fail4').val()=='No'){
		        $(".itfs_FA").val(0);
		  }else{
			    $(".itfs_FA").val(quality_score_percent+'%');
		  }

 }

     $(document).on('change','.itfs_point',function(){
		do_itfs();
	});
     
</script>


<script>
////////////////////// Iead ////////////////////
function do_lead(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		var na_count = 0;
		$('.lead_point').each(function(index,element){
			var score_type = $(element).val();

			if(score_type =='Yes'){
				parameter_count = parameter_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('lead_val'));
				score = score + weightage;
				scoreable = scoreable + parseInt($(element).children("option:selected").attr('lead_max'));
			}else if(score_type == 'No'){
				var weightage = parseInt($(element).children("option:selected").attr('lead_val'));
				scoreable = scoreable + parseInt($(element).children("option:selected").attr('lead_max'));
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		$('#lead_earnedScore').val(score);
		$('#lead_possibleScore').val(scoreable);


         if(!isNaN(quality_score_percent)){
				$('#lead_overallScore').val(quality_score_percent+'%');
			}

		 if($('#fatal1').val()=='No' || $('#fatal2').val()=='No' || $('#fatal3').val()=='No' || $('#fatal4').val()=='No'|| $('#fatal5').val()=='No' || $('#fatal6').val()=='No' || $('#fatal7').val()=='No'){
		        $(".lead_FA").val(0);
		  }else{
			    $(".lead_FA").val(quality_score_percent+'%');
		  }

 }

     $(document).on('change','.lead_point',function(){
		do_lead();
	});
     do_lead();
     
</script>

<script>
/*----------------- Customer VOC & Sub VOC ------------------*/
$('#dis_cate').on('change', function()
		{
			if($(this).val()=='Blank'){
				var disCate1 = '<option value="N/A">N/A</option>';
				$("#dis_sub_cate").html(disCate1);
			}else if($(this).val()=='Billing'){
				var disCate2 = '<option value="N/A">N/A</option>';
				$("#dis_sub_cate").html(disCate2);
			}else if($(this).val()=='Cancel'){
				var disCate3 = '<option value="">Select</option>';
				disCate3 += '<option value="Cancel Order">Cancel Order</option>';
				disCate3 += '<option value="Cancel Subscription">Cancel Subscription</option>';
				$("#dis_sub_cate").html(disCate3);
			}else if($(this).val()=='Order Status'){
				var disCate4 = '<option value="">Select</option>';
				disCate4 += '<option value="Carrier Complaint">Carrier Complaint</option>';
				disCate4 += '<option value="Order Inquiry - Late">Order Inquiry - Late</option>';
				disCate4 += '<option value="Back order ETA">Back order ETA</option>';
				disCate4 += '<option value="Order Inquiry - Not Late">Order Inquiry - Not Late</option>';
				disCate4 += '<option value="Order Status Other">Order Status Other</option>';
				$("#dis_sub_cate").html(disCate4);
			}else if($(this).val()=='Other'){
				var disCate5 = '<option value="">Select</option>';
				disCate5 += '<option value="BSD Requests">BSD Requests</option>';
				disCate5 += '<option value="ODP Business Re-Brand">ODP Business Re-Brand</option>';
				disCate5 += '<option value="Business Select">Business Select</option>';
				disCate5 += '<option value="No Call/Disconnect">No Call/Disconnect</option>';
				disCate5 += '<option value="Other">Other</option>';
				disCate5 += '<option value="Supervisor Escalation">Supervisor Escalation</option>';
				disCate5 += '<option value="Transfer">Transfer</option>';
				$("#dis_sub_cate").html(disCate5);
			}else if($(this).val()=='Place Order'){
				var disCate6 = '<option value="N/A">N/A</option>';
				$("#dis_sub_cate").html(disCate6);
			}else if($(this).val()=='Product'){
				var disCate7 = '<option value="">Select</option>';
				disCate7 += '<option value="Check Pricing">Check Pricing</option>';
				disCate7 += '<option value="Product Info">Product Info</option>';
				disCate7 += '<option value="Product Other">Product Other</option>';
				disCate7 += '<option value="Product Subscriptions">Product Subscriptions</option>';
				$("#dis_sub_cate").html(disCate7);
			}else if($(this).val()=='Payment Issues'){
				var disCate8 = '<option value="N/A">N/A</option>';
				$("#dis_sub_cate").html(disCate8);
			}else if($(this).val()=='Returns & Credits'){
				var disCate9 = '<option value="">Select</option>';
				disCate9 += '<option value="Damaged / Defective">Damaged / Defective</option>';
				disCate9 += '<option value="Missing Item">Missing Item</option>';
				disCate9 += '<option value="Return/Credit Other">Return/Credit Other</option>';
				disCate9 += '<option value="Return Not Picked Up">Return Not Picked Up</option>';
				disCate9 += '<option value="Return Request">Return Request</option>';
				$("#dis_sub_cate").html(disCate9);
			}else if($(this).val()=='Rewards'){
				var disCate10 = '<option value="N/A">N/A</option>';
				$("#dis_sub_cate").html(disCate10);
			}else if($(this).val()=='Services'){
				var disCate11 = '<option value="N/A">N/A</option>';
				$("#dis_sub_cate").html(disCate11);
			}else if($(this).val()=='Store'){
				var disCate12 = '<option value="">Select</option>';
				disCate12 += '<option value="Store Customer Concern">Store Customer Concern</option>';
				disCate12 += '<option value="Store Receipt">Store Receipt</option>';
				disCate12 += '<option value="Store Locator">Store Locator</option>';
				disCate12 += '<option value="Store Pick Up Issue">Store Pick Up Issue</option>';
				$("#dis_sub_cate").html(disCate12);
			}else if($(this).val()=='Websupport'){
				var disCate13 = '<option value="N/A">N/A</option>';
				$("#dis_sub_cate").html(disCate13);
			}
		});	

		/*Param_1----------------- RCA Level 1/2 ------------------*/
$('#ackno_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#ackno_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#ackno_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#ackno_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#ackno_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#ackno_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#ackno_rcal2").html(rca6);
			}
		});	
	/*Param_1----------------- RCA Level 2/3 ------------------*/
		$('#ackno_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#ackno_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#ackno_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#ackno_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#ackno_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#ackno_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#ackno_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#ackno_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#ackno_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#ackno_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#ackno_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#ackno_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#ackno_rcal3").html(rca12);
			}
		});	

		/*param_2----------------- RCA Level 1/2 ------------------*/
$('#custo_rca').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#custo_rca2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#custo_rca2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#custo_rca2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#custo_rca2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#custo_rca2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#custo_rca2").html(rca6);
			}
		});	

		/*Param_2----------------- RCA Level 2/3 ------------------*/
		$('#custo_rca2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#custo_rca3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#custo_rca3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#custo_rca3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#custo_rca3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#custo_rca3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#custo_rca3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#custo_rca3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#custo_rca3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#custo_rca3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#custo_rca3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#custo_rca3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#custo_rca3").html(rca12);
			}
		});	

		/*param_3----------------- RCA Level 1/2 ------------------*/
$('#appro_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#appro_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#appro_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#appro_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#appro_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#appro_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#appro_rcal2").html(rca6);
			}
		});	

		/*Param_3----------------- RCA Level 2/3 ------------------*/
		$('#appro_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#appro_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#appro_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#appro_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#appro_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#appro_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#appro_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#appro_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#appro_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#appro_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#appro_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#appro_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#appro_rcal3").html(rca12);
			}
		});	
		/*param_4----------------- RCA Level 1/2 ------------------*/
$('#under_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#under_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#under_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#under_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#under_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#under_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#under_rcal2").html(rca6);
			}
		});	

		/*Param_4----------------- RCA Level 2/3 ------------------*/
		$('#under_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#under_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#under_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#under_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#under_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#under_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#under_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#under_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#under_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#under_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#under_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#under_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#under_rcal3").html(rca12);
			}
		});	
		/*param_5----------------- RCA Level 1/2 ------------------*/
$('#recog_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#recog_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#recog_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#recog_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#recog_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#recog_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#recog_rcal2").html(rca6);
			}
		});	

		/*Param_5----------------- RCA Level 2/3 ------------------*/
		$('#recog_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#recog_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#recog_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#recog_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#recog_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#recog_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#recog_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#recog_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#recog_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#recog_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#recog_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#recog_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#recog_rcal3").html(rca12);
			}
		});	
		/*param_6----------------- RCA Level 1/2 ------------------*/
$('#verified_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#verified_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#verified_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#verified_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#verified_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#verified_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#verified_rcal2").html(rca6);
			}
		});	

		/*Param_6----------------- RCA Level 2/3 ------------------*/
		$('#verified_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#verified_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#verified_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#verified_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#verified_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#verified_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#verified_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#verified_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#verified_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#verified_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#verified_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#verified_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#verified_rcal3").html(rca12);
			}
		});	
		/*param_7----------------- RCA Level 1/2 ------------------*/
$('#idepot_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#idepot_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#idepot_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#idepot_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#idepot_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#idepot_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#idepot_rcal2").html(rca6);
			}
		});	

		/*Param_7----------------- RCA Level 2/3 ------------------*/
		$('#idepot_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#idepot_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#idepot_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#idepot_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#idepot_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#idepot_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#idepot_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#idepot_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#idepot_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#idepot_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#idepot_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#idepot_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#idepot_rcal3").html(rca12);
			}
		});	
		/*param_8----------------- RCA Level 1/2 ------------------*/
$('#appropriat_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#appropriat_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#appropriat_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#appropriat_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#appropriat_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#appropriat_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#appropriat_rcal2").html(rca6);
			}
		});	

		/*Param_8----------------- RCA Level 2/3 ------------------*/
		$('#appropriat_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#appropriat_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#appropriat_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#appropriat_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#appropriat_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#appropriat_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#appropriat_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#appropriat_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#appropriat_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#appropriat_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#appropriat_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#appropriat_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#appropriat_rcal3").html(rca12);
			}
		});	
/*param_9----------------- RCA Level 1/2 ------------------*/
$('#parap_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#parap_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#parap_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#parap_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#parap_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#parap_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#parap_rcal2").html(rca6);
			}
		});	

		/*Param_9----------------- RCA Level 2/3 ------------------*/
		$('#parap_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#parap_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#parap_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#parap_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#parap_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#parap_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#parap_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#parap_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#parap_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#parap_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#parap_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#parap_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#parap_rcal3").html(rca12);
			}
		});	
		/*param_10----------------- RCA Level 1/2 ------------------*/
$('#inform_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#inform_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#inform_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#inform_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#inform_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#inform_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#inform_rcal2").html(rca6);
			}
		});	

		/*Param_10----------------- RCA Level 2/3 ------------------*/
		$('#inform_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#inform_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#inform_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#inform_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#inform_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#inform_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#inform_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#inform_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#inform_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#inform_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#inform_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#inform_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#inform_rcal3").html(rca12);
			}
		});	
		/*param_11----------------- RCA Level 1/2 ------------------*/
$('#submit_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#submit_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#submit_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#submit_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#submit_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#submit_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#submit_rcal2").html(rca6);
			}
		});	

		/*Param_11----------------- RCA Level 2/3 ------------------*/
		$('#submit_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#submit_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#submit_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#submit_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#submit_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#submit_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#submit_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#submit_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#submit_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#submit_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#submit_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#submit_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#submit_rcal3").html(rca12);
			}
		});	
		/*param_12----------------- RCA Level 1/2 ------------------*/
$('#dispo_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#dispo_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#dispo_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#dispo_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#dispo_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#dispo_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#dispo_rcal2").html(rca6);
			}
		});	

		/*Param_12----------------- RCA Level 2/3 ------------------*/
		$('#dispo_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#dispo_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#dispo_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#dispo_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#dispo_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#dispo_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#dispo_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#dispo_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#dispo_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#dispo_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#dispo_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#dispo_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#dispo_rcal3").html(rca12);
			}
		});	

			/*param_13----------------- RCA Level 1/2 ------------------*/
$('#ple_rcal').on('change', function()
		{
			if($(this).val()=='System'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="System Limitation">System Limitation</option>';
				rca1 += '<option value="System Downtime">System Downtime</option>';
				$("#ple_rcal2").html(rca1);
			}else if($(this).val()=='Ability'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Knowledge Gap">Knowledge Gap</option>';
				rca2 += '<option value="Communication Gap">Communication Gap</option>';
				rca2 += '<option value="Skill">Skill</option>';
				$("#ple_rcal2").html(rca2);
			}else if($(this).val()=='Will'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Identified Outlier">Identified Outlier</option>';
				rca3 += '<option value="Behavorial Issue">Behavorial Issue</option>';
				rca3 += '<option value="Lack of Motivation">Lack of Motivation</option>';
				$("#ple_rcal2").html(rca3);
			}else if($(this).val()=='Health'){
				var rca4 = '<option value="---">---</option>';
				$("#ple_rcal2").html(rca4);
			}else if($(this).val()=='Capacity Issue'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Attendance Issue">Attendance Issue</option>';
				rca5 += '<option value="High Call Volume">High Call Volume</option>';
				$("#ple_rcal2").html(rca5);
			}else if($(this).val()=='Environment'){
				var rca6 = '<option value="">Select</option>';
				rca6 += '<option value="Background Noise">Background Noise</option>';
				rca6 += '<option value="Location">Location</option>';
				$("#ple_rcal2").html(rca6);
			}
		});	

		/*Param_13----------------- RCA Level 2/3 ------------------*/
		$('#ple_rcal2').on('change', function()
		{
			if($(this).val()=='System Limitation'){
				var rca1 = '<option value="">Select</option>';
				rca1 += '<option value="Override Access">Override Access</option>';
				rca1 += '<option value="Client Access Requirement">Client Access Requirement</option>';
				$("#ple_rcal3").html(rca1);
			}else if($(this).val()=='System Downtime'){
				var rca2 = '<option value="">Select</option>';
				rca2 += '<option value="Internet Issue">Internet Issue</option>';
				rca2 += '<option value="Hardware Issue">Hardware Issue</option>';
				rca2 += '<option value="Tool/Software Inaccessible">Tool/Software Inaccessible</option>';
				$("#ple_rcal3").html(rca2);
			}else if($(this).val()=='Knowledge Gap'){
				var rca3 = '<option value="">Select</option>';
				rca3 += '<option value="Ineffective Training">Ineffective Training</option>';
				rca3 += '<option value="Poor Retention">Poor Retention</option>';
				rca3 += '<option value="Poor Update Cascade">Poor Update Cascade</option>';
				$("#ple_rcal3").html(rca3);
			}else if($(this).val()=='Communication Gap'){
				var rca4 = '<option value="">Select</option>';
				rca4 += '<option value="Language Barrier">Language Barrier</option>';
				rca4 += '<option value="Poor comprehension">Poor comprehension</option>';
				$("#ple_rcal3").html(rca4);
			}else if($(this).val()=='Skill'){
				var rca5 = '<option value="">Select</option>';
				rca5 += '<option value="Poor Multi-tasking Skill">Poor Multi-tasking Skill</option>';
				$("#ple_rcal3").html(rca5);
			}else if($(this).val()=='Identified Outlier'){
				var rca6 = '<option value="---">---</option>';
				$("#ple_rcal3").html(rca6);
			}else if($(this).val()=='Behavorial Issue'){
				var rca7 = '<option value="---">---</option>';
				$("#ple_rcal3").html(rca7);
			}else if($(this).val()=='Lack of Motivation'){
				var rca8 = '<option value="">Select</option>';
				rca8 += '<option value="Compensation">Compensation</option>';
				$("#ple_rcal3").html(rca8);
			}else if($(this).val()=='Attendance Issue'){
				var rca9 = '<option value="">Select</option>';
				rca9 += '<option value="Lost Hours">Lost Hours</option>';
				rca9 += '<option value="Offset Hours">Offset Hours</option>';
				rca9 += '<option value="Attrition">Attrition</option>';
				$("#ple_rcal3").html(rca9);	
			}else if($(this).val()=='High Call Volume'){
				var rca10 = '<option value="---">---</option>';
				$("#ple_rcal3").html(rca10);
			}else if($(this).val()=='Background Noise'){
				var rca11 = '<option value="---">---</option>';
				$("#ple_rcal3").html(rca11);
			}else if($(this).val()=='Location'){
				var rca12 = '<option value="---">---</option>';
				$("#ple_rcal3").html(rca12);
			}
		});	
	
</script>12);
			}
		});	
	
</script>