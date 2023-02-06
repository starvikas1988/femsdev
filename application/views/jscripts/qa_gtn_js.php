<script type="text/javascript">

	function gtn_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.gtn_points').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('gtn_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'Fatal'){
				var weightage = parseFloat($(element).children("option:selected").attr('gtn_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('gtn_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('gtn_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#gtn_earnedScore').val(score);
		$('#gtn_possibleScore').val(scoreable);

		if(($('#cholamandlam_AF1').val()=='Fatal' || $('#cholamandlam_AF1').val()=='No') || ($('#cholamandlam_AF2').val()=='Fatal' || $('#cholamandlam_AF2').val()=='No') || ($('#cholamandlam_AF3').val()=='Fatal' || $('#cholamandlam_AF3').val()=='No') || ($('#cholamandlam_AF4').val()=='Fatal' || $('#cholamandlam_AF4').val()=='No' ) || ($('#cholamandlam_AF5').val()=='Fatal' || $('#cholamandlam_AF5').val()=='No' ) || ($('#cholamandlam_AF6').val()=='Fatal' || $('#cholamandlam_AF6').val()=='No' ) || $('#cholamandlam_AF7').val()=='Fatal' || $('#cholamandlam_AF8').val()=='Fatal' || $('#cholamandlam_AF9').val()=='Fatal' || $('#cholamandlam_AF10').val()=='Fatal' || $('#cholamandlam_AF11').val()=='Fatal' || $('#cholamandlam_AF12').val()=='Fatal' || $('#cholamandlam_AF13').val()=='Fatal'){
		$('#cholamandlam_overallScore').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#gtn_overallScore').val(quality_score_percent+'%');
			}	
		}
	
	}
	
	$(document).on('change','.gtn_points',function(){
		gtn_calc();
	});
	gtn_calc();
</script>
 
 <script>
$(document).ready(function()
{
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
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

	$("#form_audit_user").submit(function (e)
	 {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e)
	{
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e)
	{
		$('#btnmgntSave').prop('disabled',true);
	});
	
	

	/////////////////////ACPT///////////////////////////////////

	$('.acptoth').hide();
	
	$('#acpt').on('change', function()
	{
		if($(this).val()=='Agent')
		{
			var agentAcpt = '<option value="">Select</option>';
			agentAcpt += '<option value="No probing">No probing</option>';
			agentAcpt += '<option value="No Urgency">No Urgency</option>';
			agentAcpt += '<option value="No good faith payment">No good faith payment</option>';
			agentAcpt += '<option value="No Negotiation">No Negotiation</option>';
			agentAcpt += '<option value="No PDC">No PDC</option>';
			agentAcpt += '<option value="No follow up">No follow up</option>';
			agentAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(agentAcpt);
		}else if($(this).val()=='Customer')
		{
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
		}else if($(this).val()=='Process')
		{
			var processAcpt = '<option value="">Select</option>';
			processAcpt += '<option value="Dealership">Dealership</option>';
			processAcpt += '<option value="Letter sent to different address">Letter sent to different address</option>';
			processAcpt += '<option value="Waiver">Waiver</option>';
			processAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(processAcpt);
		}else if($(this).val()=='Technology')
		{
			var techAcpt = '<option value="">Select</option>';
			techAcpt += '<option value="call disconnected">call disconnected</option>';
			techAcpt += '<option value="connection barred">connection barred</option>';
			techAcpt += '<option value="Others">Others</option>';
			$("#acpt_option").html(techAcpt);
		}else if($(this).val()=='')
		{
			$("#acpt_option").html('<option value="">Select</option>');
		}
	});
	
	$('#acpt_option').on('change', function()
	{
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
			success: function(aList)
			{
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
