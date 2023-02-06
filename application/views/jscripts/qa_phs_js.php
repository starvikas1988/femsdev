<script type="text/javascript">

function docusign_calc(){
		var score = 0;
		var cust_score = 0;
		var busi_score = 0;
		var comp_score = 0;
		var scoreable = 0;
		var cust_scoreable = 0;
		var busi_scoreable = 0;
		var comp_scoreable = 0;
		var quality_score_percent = 0;

		$('.cust_score').each(function(index,element){
			var cust_score_type = $(element).val();
			
			if(cust_score_type == 'YES'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				cust_score = cust_score + weightage;
				score = score + weightage;		
				cust_scoreable = cust_scoreable + weightage;
				scoreable = scoreable + weightage;
			}else if(cust_score_type == 'NO'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				cust_scoreable = cust_scoreable + weightage;
				scoreable = scoreable + weightage;
			}else if(cust_score_type == 'N/A'){
				
			}
		});

		$('.busi_score').each(function(index,element){
			var busi_score_type = $(element).val();
			
			if(busi_score_type == 'YES'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				busi_score = busi_score + weightage;
				busi_scoreable = busi_scoreable + weightage;
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(busi_score_type == 'NO'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				busi_scoreable = busi_scoreable + weightage;
				scoreable = scoreable + weightage;

			}else if(busi_score_type == 'N/A'){
				
			}
		});

		$('.comp_score').each(function(index,element){
			var comp_score_type = $(element).val();
			
			if(comp_score_type == 'YES'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				comp_score = comp_score + weightage;
				comp_scoreable = comp_scoreable + weightage;
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(comp_score_type == 'NO'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				comp_scoreable = comp_scoreable + weightage;
				scoreable = scoreable + weightage;
			}else if(comp_score_type == 'N/A'){
				
			}
		});

		// $(".fatal_epi").each(function(){
		// 	valNum=$(this).val();
		// 	if(valNum == "YES"){
		// 		score=0;
		// 	}	
		// });

		$(".ztp").each(function(){
			valNum=$(this).val();
			if(valNum == "YES"){
				score=0;
			}	
		});

		score = parseFloat(score);
		scoreable = parseFloat(scoreable);
		
		quality_score_percent=((score*100)/scoreable).toFixed(2);
		var cust_quality_score_percent = ((cust_score*100)/cust_scoreable).toFixed(2);
		var busi_quality_score_percent = ((busi_score*100)/busi_scoreable).toFixed(2);
		var comp_quality_score_percent = ((comp_score*100)/comp_scoreable).toFixed(2);

		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}	
		if(!isNaN(cust_quality_score_percent)){
			$('#custScore').val(cust_quality_score_percent+'%');
		}

		if(!isNaN(busi_quality_score_percent)){
			$('#busiScore').val(busi_quality_score_percent+'%');
		}

		if(!isNaN(comp_quality_score_percent)){
			$('#compScore').val(comp_quality_score_percent+'%');
		}			
	
	}
	
docusign_calc();
</script>
 
 <script>
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_duration").timepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	
///////////////// Calibration - Auditor Type ///////////////////////	
	// $('#audit_type').each(function(){
	// 	$valdet=$(this).val();
	// 	if($valdet=="Calibration"){
	// 		$('.auType_epi').show();
	// 	}else{
	// 		$('.auType_epi').hide();
	// 	}
	// });

	// $('#audit_type').on('change', function(){
	// 	if($(this).val()=='Calibration'){
	// 		$('.auType_epi').show();
	// 		$('#auditor_type').attr('required',true);
	// 		$('#auditor_type').prop('disabled',false);
	// 	}else{
	// 		$('.auType_epi').hide();
	// 		$('#auditor_type').attr('required',false);
	// 		$('#auditor_type').prop('disabled',true);
	// 	}
	// });

	$('#audit_type').each(function(){
		$valdet=$(this).val();
		if($valdet=="Calibration"){
			$('.auType').show();
		}else{
			$('.auType').hide();
		}
	});

	//$('.auType').hide();

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

	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
	
/////////////
	$(".points_epi").on("change",function(){
		docusign_calc();
	});

	$(".points_pa").on("change",function(){
		docusign_calc();
	});

	$(".cust_score").on("change",function(){
		docusign_calc();
	});

	$(".busi_score").on("change",function(){
		docusign_calc();
	});

	$(".comp_score").on("change",function(){
		docusign_calc();
	});

	$(".fatal_epi").on("change",function(){
		docusign_calc();
	});

	$(".ztp").on("change",function(){
		docusign_calc();
	});

	docusign_calc();
	

/////////////////////ACPT///////////////////////////////////

	$('.acptoth').hide();
	
	$('#acpt').on('change', function(){
		if($(this).val()=='Agent'){
			var agentAcpt = '<option value="">Select</option>';
			agentAcpt += '<option value="No probing">No probing</option>';
			agentAcpt += '<option value="No Urgency">No Urgency</option>';
			agentAcpt += '<option value="No good faith payment">No good faith payment</option>';
			agentAcpt += '<option value="No Negotiation">No Negotiation</option>';
			agentAcpt += '<option value="No PDC">No PDC</option>';
			agentAcpt += '<option value="No follow up">No follow up</option>';
			agentAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(agentAcpt);
		}else if($(this).val()=='Customer'){
			var customerAcpt = '<option value="">Select</option>';
			customerAcpt += '<option value="Verbal Dispute">Verbal Dispute</option>';
			customerAcpt += '<option value="Refused to pay">Refused to pay</option>';
			customerAcpt += '<option value="Bankruptcy">Bankruptcy</option>';
			customerAcpt += '<option value="Attorney handling">Attorney handling</option>';
			customerAcpt += '<option value="CONSUMER CREDIT COUNSELING">CONSUMER CREDIT COUNSELING</option>';
			customerAcpt += '<option value="DOCUMENTS VALIDATE THE DEBT">DOCUMENTS VALIDATE THE DEBT</option>';
			customerAcpt += '<option value="Refused to pay  processing fees">Refused to pay  processing fees</option>';
			customerAcpt += '<option value="Refused to make the payment over the phone">Refused to make the payment over the phone</option>';
			customerAcpt += '<option value="RP driving">RP driving</option>';
			customerAcpt += '<option value="RP at POE">RP at POE</option>';
			customerAcpt += '<option value="CEASE ALL COMMUNICATION">CEASE ALL COMMUNICATION</option>';
			customerAcpt += '<option value="Does not speak english">Does not speak english</option>';
			customerAcpt += '<option value="DECEASED PENDING VERIFICATION">DECEASED PENDING VERIFICATION</option>';
			customerAcpt += '<option value="DO NOT CALL">DO NOT CALL</option>';
			customerAcpt += '<option value="FRAUD INVESTIGATION">FRAUD INVESTIGATION</option>';
			customerAcpt += '<option value="Identity theft">Identity theft</option>';
			customerAcpt += '<option value="ACTIVE ACCOUNT">ACTIVE ACCOUNT</option>';
			customerAcpt += '<option value="RETURNED CHECK">RETURNED CHECK</option>';
			customerAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(customerAcpt);
		}else if($(this).val()=='Process'){
			var processAcpt = '<option value="">Select</option>';
			processAcpt += '<option value="Dealership">Dealership</option>';
			processAcpt += '<option value="Letter sent to different address">Letter sent to different address</option>';
			processAcpt += '<option value="Waiver">Waiver</option>';
			processAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(processAcpt);
		}else if($(this).val()=='Technology'){
			var techAcpt = '<option value="">Select</option>';
			techAcpt += '<option value="call disconnected">call disconnected</option>';
			techAcpt += '<option value="connection barred">connection barred</option>';
			techAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(techAcpt);
		}else if($(this).val()==''){
			$("#acpt_option").html('<option value="">Select</option>');
		}
	});
	
	$('#acpt_option').on('change', function(){
		if($(this).val()=='Others'){
			$('.acptoth').show();
			$('#acpt_other').attr('required',true).attr("placeholder", "Type here");
		}else{
			$('.acptoth').hide();
			$('#acpt_other').attr('required',false);
			$('#acpt_other').val('');
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

 <script type="text/javascript">
//  	$("#attach_file").on('submit', function (e) {
//     //get your format file
//     var nameImage = $(".name-wav").val();
//     //cek format name with jpg or jpeg
//     if(nameImage.match(/mp3.*/)||nameImage.match(/avi.*/)|| nameImage.match(/mp4.*/)|| nameImage.match(/wmv.*/) || nameImage.match(/wav.*/)){
//         //if format is same run form
//     }else{
//         //if with e.preventDefault not run form
//         e.preventDefault();
//         //give alert format file is wrong
//         window.alert("file format is not appropriate");
//     }
// });

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

//  	$('#qaformsubmit').click(function(){
//    if($.trim($('#agent_id').val()) == ''){
//       alert('Agent can not be left blank');
//       $('#agent_id').focus();
//       return false;
//    }
// });
 	
//     $('#qaformsubmit').click(function(){
//    if($.trim($('#tl_id').val()) == ''){
//       alert('L1 Supervisor can not be left blank');
//       $('#tl_id').focus();
//       return false;
//    }
// });

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
 
 <script>
/*------------ Chat & Email -------------*/
	function phs_chatemail_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		//console.log("okk");
		$('.chatemail_pnt').each(function(index,element){
			var score_type = $(element).val();

			console.log(score_type);
			
			if(score_type == 'Yes'){
				pass_count = pass_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('phs_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				fail_count = fail_count + 1;
				var weightage = parseInt($(element).children("option:selected").attr('phs_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		
		$('#phs_chatemail_v_earned').val(score);
		$('#phs_chatemail_v_possible').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#phs_chatemail_v_overall').val(quality_score_percent+'%');
			console.log(quality_score_percent);
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
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
				customerScore = customerScore + w1;
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'No'){
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
				customerScoreable = customerScoreable + w1;
			}else if(sc1 == 'N/A'){
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
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
				var w2 = parseInt($(element).children("option:selected").attr('phs_val'));
				businessScore = businessScore + w2;
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'No'){
				var w2 = parseInt($(element).children("option:selected").attr('phs_val'));
				businessScoreable = businessScoreable + w2;
			}else if(sc2 == 'N/A'){
				var w2 = parseInt($(element).children("option:selected").attr('phs_val'));
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
				var w3 = parseInt($(element).children("option:selected").attr('phs_val'));
				complianceScore = complianceScore + w3;
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'No'){
				var w3 = parseInt($(element).children("option:selected").attr('phs_val'));
				complianceScoreable = complianceScoreable + w3;
			}else if(sc3 == 'N/A'){
				var w3 = parseInt($(element).children("option:selected").attr('phs_val'));
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
	
/////////////////////////////////////////
	$(document).on('change','.chatemail_pnt',function(){
		phs_chatemail_calc();
	});
	$(document).on('change','.customer',function(){
		phs_chatemail_calc();
	});
	$(document).on('change','.business',function(){
		phs_chatemail_calc();
	});
	$(document).on('change','.compliance',function(){
		phs_chatemail_calc();
	});
	phs_chatemail_calc();
	
 </script>

 <script type="text/javascript">
 		function phs_chatemail_v2_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0.00;
		var pass_count = 0;
		var fail_count = 0;
		var na_count = 0;
		$('.chatemail_pnt').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Completely'){
				pass_count = pass_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('phs_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}else if(score_type == 'Partially'){
				pass_count = pass_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('phs_max'));
				score = score + w1;
				scoreable = scoreable + w2;
			}else if(score_type == 'TBD'){
				fail_count = fail_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('phs_max'));
				score = score + w1;
				scoreable = scoreable + w2;
				//scoreable = scoreable + weightage;
			}else if(score_type == 'Not at all'){
				fail_count = fail_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('phs_max'));
				score = score + w1;
				scoreable = scoreable + w2;
				//scoreable = scoreable + weightage;
			}else if(score_type == 'Fatal'){
				fail_count = fail_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
				var w2 = parseFloat($(element).children("option:selected").attr('phs_max'));
				//score = score + w1;
				scoreable = scoreable + w2;
				//scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				na_count = na_count + 1;
				var w1 = parseInt($(element).children("option:selected").attr('phs_val'));
				//var w2 = parseFloat($(element).children("option:selected").attr('phs_max'));
				score = score + w1;
				//scoreable = scoreable + w2;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);

		if(quality_score_percent == "NaN"){
			quality_score_percent = (0.00).toFixed(2);
		}else{
			quality_score_percent = quality_score_percent;
		}
		
		$('#phs_chatemail_earned').val(score);
		$('#phs_chatemail_possible').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#phs_chatemail_overall').val(quality_score_percent+'%');
		}

		if($('#ajioAF1').val()=='Fatal' || $('#ajioAF2').val()=='Fatal' || $('#ajioAF3').val()=='Fatal' || $('#ajioAF4').val()=='Fatal' || $('#ajioAF5').val()=='Fatal' || $('#ajioAF6').val()=='Fatal' || $('#ajioAF7').val()=='Fatal'){
			quality_score_percent = (0.00).toFixed(2);
			$('.phs_chatemail_v2Fatal').val(quality_score_percent+'%');
			//$('.phs_chatemail_v2Fatal').val(0.00).toFixed(2);
		}else{
			$('.phs_chatemail_overall').val(quality_score_percent+'%');
		}
	

		// $('#pass_count').val(pass_count);
		// $('#fail_count').val(fail_count);
		// $('#na_count').val(na_count);
	}
	
/////////////////////////////////////////
	$(document).on('change','.chatemail_pnt',function(){
		phs_chatemail_v2_calc();
	});
	phs_chatemail_v2_calc();
	
	
 </script>
 </script>
