<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datetimepicker();
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	// $("#call_date_time").datetimepicker();
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
				console.log(json_obj);
				$('#tl_name').empty().append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				let tenure = json_obj[i].tenure
				let today = new Date()
				let live_date = new Date()
				live_date.setDate(today.getDate() - tenure)
				for (var i in json_obj) $('#live_date').append($('#live_date').val(`${("0"+live_date.getMonth()).slice(-2)}-${live_date.getDate()}-${live_date.getFullYear()}`));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));

					if (tenure>=0 && tenure<=30) {
						var tenure_bucket = "0-30";
					}else if(tenure>30 && tenure<=60){
						var tenure_bucket = "31-60";
					}else if(tenure>60 && tenure<=90){
						var tenure_bucket = "61-90";
					}else if(tenure>90){
						var tenure_bucket = "91 and Above";
					}
					$('#tenure_bucket').empty().append($('#tenure_bucket').val(tenure_bucket));

				// if($user['tenure']>='0' && $user['tenure']<='30'){
				// $tenure_bucket = "0-30";
				// }else if($user['tenure']>'30' && $user['tenure']<='60'){
				// 	$tenure_bucket = "31-60";
				// }else if($user['tenure']>'60' && $user['tenure']<='90'){
				// 	$tenure_bucket = "61-90";
				// }else if($user['tenure']>'90'){
				// 	$tenure_bucket = "91 and Above";
				// }




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
		var pro = 0;
		var cust = 0;
		var cru = 0;
		var defects = 0;
		var good = 0;
		var average = 0;
		var bad = 0;
		$('.pre_booking_point').each(function(index,element){
			var score_type = $(element).val();
			//alert(score_type);
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}

				// if ($(element).attr('identifier1')=="Crucial") {
				// 	cru +=1;
				// }

				
				// console.log(pro+' '+ cust)
				//alert(weightage);
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				scoreable = scoreable + weightage;

				if ($(element).attr('identifier1')=="Crucial") {
					cru +=1;
				}


				if ($(element).attr('identifier2')=="defects") {
					defects +=1;
				}
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = Math.round(((score*100)/scoreable));
		
		$('#crucial_score').val(parseInt(cru)>0 ? 'Yes' : 'No');

		$('#defects_score').val(defects);

		$('#cru_score').val(cru);

		$('#pre_earnedScore').val(score);
		$('#pre_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#pre_overallScore').val(quality_score_percent+'%');

		if (quality_score_percent >= 81) {
			$('#overall_result').val('Good');
		}else if (quality_score_percent >= 60.99 && quality_score_percent < 81) {
			$('#overall_result').val('Average');
		}else if(quality_score_percent <= 60){
			$('#overall_result').val('Bad');
		}



		}

// Manipulating Reason field's [required] property on Grade change
		$(document).on("change", ".pre_booking_point", function(){
			if($(this).val() == "Yes" || $(this).val() == "NA"){
				$(this).closest("td").siblings("td").find(".aoi").attr("required", false)
			}else{
				$(this).closest("td").siblings("td").find(".aoi").attr("required", true)
			}
		})
////////Analysis part change/////////////////////
		$(document).on("change", ".pre_booking_point", function(){
			if($(this).val() == "Yes"){
				$(this).closest("td").siblings("td").find(".11-1").val("Wow Call")
			}else if($(this).val() == "No"){
				$(this).closest("td").siblings("td").find(".11-1").val("Average Call")
			}else if($(this).val() == "NA") {
				$(this).closest("td").siblings("td").find(".11-1").val("Poor Call")
			}
		})

		$(document).on("change", ".tenure", function(){
			if($(this).val() == "0-30"){
				$(this).closest("td").find(".tenure_bucket").val("0-30")
			}else if($(this).val() == "31-60"){
				$(this).closest("td").find(".tenure_bucket").val("31-60")
			}else if($(this).val() == "61-90"){
				$(this).closest("td").find(".tenure_bucket").val("91 and Above")
			}
		})

////////////////////////////////////////////////////////////////////////
		$(document).on('change','.aoi',function(){
			let aoi_val='';
			let concat = '';
			$('.aoi').each(function(index,element){
				// var score_type = $(element).val();
				if ($(element).val()!=null) {
					aoi_val = aoi_val+concat+$(element).val();
				concat =',';
				// console.log(aoi_val);
				}
				$('#aoi_val').val(aoi_val);
			});

		});
		
		$(document).on('change','.remarks',function(){
			let remarks_val='';
			let concat = '';
			$('.remarks').each(function(index,element){
				// var score_type = $(element).val();
				if ($(element).val()!=null) {
					remarks_val = remarks_val+concat+$(element).val();
				concat =',';
				// console.log(remarks_val);
				}
				$('#remarks_val').val(remarks_val);
			});
			
		});
		



		// $('.pre_booking_point1').each(function(index,element){
		// 	var score_type = $(element).val();
		// 	//alert(score_type);
		// 	console.log(score_type);
  //           if(score_type == 'Good'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
		// 		var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
		// 		score1 = score1 + weightage;
		// 		scoreable1 = scoreable1 + max_wght;
		// 	}else if(score_type == 'Bad'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
		// 		var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
		// 		score1 = score1 + weightage;
		// 		scoreable1 = scoreable1 + max_wght;
		// 	}else if(score_type == 'Average'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
		// 		var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
		// 		score1 = score1 + weightage;
		// 		scoreable1 = scoreable1 + max_wght;
		// 	}else if(score_type == 'NA'){
		// 		var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
		// 		var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
		// 		score1 = score1 + weightage;
		// 		scoreable1 = scoreable1 + weightage;
		// 	}
		// });
		// quality_score_percent1 = Math.round(((score*100)/scoreable1));
		
		

		$('#parameter_earnedScore').val(score1);
		$('#parameter_possibleScore').val(scoreable1);

         if(!isNaN(quality_score_percent1)){
			$('#parameter_overallScore').val(quality_score_percent1+'%');
		}




          // For Fatal
		if($('.all_fatal1').val()=='No' || $('.all_fatal2').val()=='No' || $('.all_fatal3').val()=='No' || $('.all_fatal4').val()=='No' || $('.all_fatal5').val()=='No' || $('.all_fatal6').val()=='No' || $('.all_fatal7').val()=='No' || $('.all_fatal8').val()=='No'){
		    $('#pre_overallScore').val(0+'%');
		  }else{
			$('#pre_overallScore').val(quality_score_percent+'%');
		  }


		  						//////////////// Customer/Process/Compliance(Riya) //////////////////
		var customerScore = 0;
		var customerScoreable = 0;
		var customerPercentage = 0;
		var pro = 0;
		var cust = 0;
		var no_count = 0;
		var pro_count = 0;
		var propossible = 0;
		var custpossible = 0;
		var postpossible = 0;


		$('.customer').each(function(index,element){
			var sc1 = $(element).val();
			if(sc1 == 'Yes'){
				var w1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}

				// custpossible = 3 - cust;
				
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				customerScoreable = customerScoreable + w1;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}

				if ($(element).attr('identifier_no')=="no_count") {
					no_count+=1;
				}else {
					0;
				}
				

				
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
				
			}
		});
		$('#customerEarned').val(cust);		
		$('#customerPossible').val(custpossible);
		$('#customerno_count').val(no_count);

		$('#custJiCisEarned').text(customerScore);		
		$('#custJiCisPossible').text(customerScoreable);

		customerPercentage = ((customerScore*100)/customerScoreable).toFixed(2);
		if(!isNaN(customerPercentage)){
			$('#custJiCisScore').val(customerPercentage+'%');
		}

		var processScore = 0;
		var processScoreable = 0;
		var processPercentage = 0;

		$('.process').each(function(index,element){
			var sc2 = $(element).val();
			if(sc2 == 'Yes'){
				var w2 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				processScore = processScore + w2;
				processScoreable = processScoreable + w2;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}

				

				propossible = 17 - pro;
				postpossible = 20 - pro;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				processScoreable = processScoreable + w2;
				if ($(element).attr('identifier')=="process") {
					pro+=1;
				}else if ($(element).attr('identifier')=="customer"){
					cust+=1;
				}


				if ($(element).attr('identifier_pro')=="pro_count") {
					pro_count+=1;
				}else {
					0;
				}
				
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				processScore = processScore + w2;
				processScoreable = processScoreable + w2;
				
			}
		});
		$('#processJiCisEarned').text(processScore);
		$('#processJiCisPossible').text(processScoreable);
		

		$('#processEarned').val(pro);
		$('#processPossible').val(propossible);
		$('#postnewPossible').val(postpossible);
		$('#process_count').val(pro_count);
		// console.log('pro')

		processPercentage = ((processScore*100)/processScoreable).toFixed(2);
		if(!isNaN(processPercentage)){
			$('#processJiCisScore').val(processPercentage+'%');
		}
	////////////
		var complianceScore = 0;
		var complianceScoreable = 0;
		var compliancePercentage = 0;
		$('.compliance').each(function(index,element){
			var sc3 = $(element).val();
			if(sc3 == 'Yes'){
				var w3 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
				
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
				complianceScoreable = complianceScoreable + w3;
				
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('pre_booking_val'));
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

		///////////////////////////////////////////////////////////////////////////////////////////////////
 }

 $(document).on('change','.pre_booking_point',function(){
	do_pre_booking();
});
 do_pre_booking();

	$('#standardization_ex').on('change', function(){
	if($(this).val()=='Yes'){
		$('#standardization_exsub').attr('required',true);
		$('#standardization_exsub').val('Star Call');
	
	}else{
	
		$('#standardization_exsub').attr('required',true);
		$('#standardization_exsub').val('Normal Call');
	
	}
});	

</script>


<script type="text/javascript">
	
// 	function calculation(){
		
// 		var score1 = 0;
// 		var scoreable1 = 0;
// 		var quality_score_percent1 = 0;
// 		var pass_count = 0;
// 		var fail_count = 0;
// 		var na_count = 0;
		
// 		$('.pre_booking_point1').each(function(index,element){
// 			var score_type = $(element).val();
// 			//alert(score_type);
			
//             if(score_type == 'Good'){
// 				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
// 				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
// 				score1 = score1 + weightage;
// 				scoreable1 = scoreable1 + max_wght;

// 			}else if(score_type == 'Bad'){
// 				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
// 				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
// 				score1 = score1 + weightage;
// 				scoreable1 = scoreable1 + max_wght;
				
// 			}else if(score_type == 'Average'){
// 				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
// 				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
// 				score1 = score1 + weightage;
// 				scoreable1 = scoreable1 + max_wght;
// 			}else if(score_type == 'NA'){
// 				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
// 				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
// 				score1 = score1 + weightage;
// 				scoreable1 = scoreable1 + weightage;

// 			}
// 		});
// 		quality_score_percent1 = Math.round(((score1*100)/scoreable1));



// 		$('#cars_earnedScore').val(score1);
// 		$('#cars_possibleScore').val(scoreable1);

//          if(!isNaN(quality_score_percent1)){
// 			$('#cars_overallScore').val(quality_score_percent1+'%');
// }
 //     $(document).on('change','.pre_booking_point1',function(){
	// 	calculation();
	// });

     // calculation()

   $(document).on('change','.pre_booking_point1',function(){

   		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		
		$('.pre_booking_point1').each(function(index,element){
			var score_type = $(element).val();
			//alert(score_type);
			
            if(score_type == 'Good'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
				score1 = score1 + weightage;
				scoreable1 = scoreable1 + max_wght;

			}else if(score_type == 'Bad'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
				score1 = score1 + weightage;
				scoreable1 = scoreable1 + max_wght;
				
			}else if(score_type == 'Average'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
				score1 = score1 + weightage;
				scoreable1 = scoreable1 + max_wght;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('pre_booking_val'));
				var max_wght = parseFloat($(element).children("option:selected").attr('pre_booking_max_val'));
				score1 = score1 + weightage;
				scoreable1 = scoreable1 + weightage;

			}
		});
		quality_score_percent1 = Math.round(((score1*100)/scoreable1));



		$('#cars_earnedScore').val(score1);
		$('#cars_possibleScore').val(scoreable1);

         if(!isNaN(quality_score_percent1)){
			$('#cars_overallScore').val(quality_score_percent1+'%');
		}

		if (quality_score_percent1 >= 81) {
			$('#overall_result1').val('Good');
		}else if (quality_score_percent1 >= 60.99 && quality_score_percent1 < 81) {
			$('#overall_result1').val('Average');
		}else if(quality_score_percent1 <= 60){
			$('#overall_result1').val('Bad');
		}
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