<script type="text/javascript">

//////////////////// Ibuumerang OLD /////////////////////////////
	function docusign_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.points_epi').each(function(index,element){
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

		$(".fatal_epi").each(function(){
		valNum=$(this).val();
		if(valNum == "Yes"){
		score=0;
		}	
		});

		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#earnedScore').val(score);
		$('#possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}		
	
	}
	
	docusign_calc();

//////////////////////// Ibuumerang NEW ////////////////////////////
	function ibumerang_calc(){
		var ibmn_score = 0;
		var ibmn_scoreable = 0;
		var ibmn_score_percent = 0;
		
		$('.ibumerang').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ibmn_val'));
				ibmn_score = ibmn_score + weightage;
				ibmn_scoreable = ibmn_scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ibmn_val'));
				ibmn_scoreable = ibmn_scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('ibmn_val'));
				ibmn_score = ibmn_score + weightage;
				ibmn_scoreable = ibmn_scoreable + weightage;
			}
		});
		ibmn_score_percent = ((ibmn_score*100)/ibmn_scoreable).toFixed(2);
		var ern_score =ibmn_score.toFixed(0);
		var posible_score =ibmn_scoreable.toFixed(0);
		$('#earnedIbmn').val(ern_score);
		$('#possibleIbmn').val(posible_score);
		
		if(!isNaN(ibmn_score_percent)){
			$('#IbmnScore').val(ibmn_score_percent+'%');
		}
	//////////
		if($('#ibumerangAF1').val()=="Yes" || $('#ibumerangAF2').val()=="Yes" || $('#ibumerangAF3').val()=="Yes" || $('#ibumerangAF4').val()=="Yes" || $('#ibumerangAF5').val()=="Yes" || $('#ibumerangAF6').val()=="Yes" || $('#ibumerangAF7').val()=="Yes" || $('#ibumerangAF8').val()=="Yes"){
			$('.ibmnFatal').val(0);
		}else{
			$('.ibmnFatal').val(ibmn_score_percent+'%');
		}
		
	}
	

</script>
 
											
<script>
function do_email(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.email_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('email_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });

		$('#email_overall').val(grade1);
	}

    $(document).on('change','.email_grade',function(){
		do_email();
    });
	do_email();

</script>
<script>
function do_softskill(){
		var grade2 = 0;
		var scoreable2 = 0;
		var totalgrade2 = 0;
		var na_count = 0;
		
		$('.softskill_grade').each(function(index,element){
				var weightage2 = parseFloat($(element).children("option:selected").attr('softskill_val'));
				grade2 = grade2 + weightage2;
				// alert(weightage1);
		  });

		$('#softskill_overall').val(grade2);
	}

    $(document).on('change','.softskill_grade',function(){
		do_softskill();
    });
	do_softskill();

</script>
<script>
function do_backoffice(){
		var grade3 = 0;
		var scoreable3 = 0;
		var totalgrade3 = 0;
		var na_count = 0;
		
		$('.backoffice_grade').each(function(index,element){
				var weightage3 = parseFloat($(element).children("option:selected").attr('backoffice_val'));
				grade3 = grade3 + weightage3;
				// alert(weightage1);
		  });

		$('#backoffice_overall').val(grade3);
	}

    $(document).on('change','.backoffice_grade',function(){
		do_backoffice();
    });
	do_backoffice();

</script>								

<script>
function do_uses_please(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.uses_please_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('uses_please_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal').val()=='No' ){
			$('#uses_please_overall').val(0+'%');
		}else{
				$('#uses_please_overall').val(grade1+'%');
			}
		
		// $('#uses_please_overall').val(grade1+'%');
	}

    $(document).on('change','.uses_please_grade',function(){
		do_uses_please();
    });
	do_uses_please();

</script>
<script>
function do_apologized_when(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.apologized_when_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('apologized_when_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal1').val()=='No' ){
			$('#apologized_when_overall').val(0+'%');
		}else{
				$('#apologized_when_overall').val(grade1+'%');
			}
		
		// $('#apologized_when_overall').val(grade1+'%');
	}

    $(document).on('change','.apologized_when_grade',function(){
		do_apologized_when();
    });
	do_apologized_when();

</script>
<script>
function do_did_representative(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.did_representative_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('did_representative_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal2').val()=='No' ){
			$('#did_representative_overall').val(0+'%');
		}else{
				$('#did_representative_overall').val(grade1+'%');
			}
		
		// $('#did_representative_overall').val(grade1+'%');
	}

    $(document).on('change','.did_representative_grade',function(){
		do_did_representative();
    });
	do_did_representative();

</script>
<script>
function do_provided_step(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.provided_step_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('provided_step_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal3').val()=='No' ){
			$('#provided_step_overall').val(0+'%');
		}else{
				$('#provided_step_overall').val(grade1+'%');
			}
		
		// $('#provided_step_overall').val(grade1+'%');
	}

    $(document).on('change','.provided_step_grade',function(){
		do_provided_step();
    });
	do_provided_step();

</script>
<script>
function do_used_appropriate(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.used_appropriate_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('used_appropriate_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal4').val()=='No' ){
			$('#used_appropriate_overall').val(0+'%');
		}else{
				$('#used_appropriate_overall').val(grade1+'%');
			}
		
		// $('#used_appropriate_overall').val(grade1+'%');
	}

    $(document).on('change','.used_appropriate_grade',function(){
		do_used_appropriate();
    });
	do_used_appropriate();

</script>
<script>
function do_used_proper(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.used_proper_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('used_proper_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal5').val()=='No' ){
			$('#used_proper_overall').val(0+'%');
		}else{
				$('#used_proper_overall').val(grade1+'%');
			}
		
		// $('#used_proper_overall').val(grade1+'%');
	}

    $(document).on('change','.used_proper_grade',function(){
		do_used_proper();
    });
	do_used_proper();

</script>
<script>
function do_did_representative_give_a_follow_up(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.did_representative_give_a_follow_up_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('did_representative_give_a_follow_up_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal6').val()=='No' ){
			$('#did_representative_give_a_follow_up_overall').val(0+'%');
		}else{
				$('#did_representative_give_a_follow_up_overall').val(grade1+'%');
			}
		
		// $('#did_representative_give_a_follow_up_overall').val(grade1+'%');
	}

    $(document).on('change','.did_representative_give_a_follow_up_grade',function(){
		do_did_representative_give_a_follow_up();
    });
	do_did_representative_give_a_follow_up();

</script>
<script>
function do_used_appropriate_verbiage(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.used_appropriate_verbiage_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('used_appropriate_verbiage_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal7').val()=='No' ){
			$('#used_appropriate_verbiage_overall').val(0+'%');
		}else{
				$('#used_appropriate_verbiage_overall').val(grade1+'%');
			}
		
		// $('#used_appropriate_verbiage_overall').val(grade1+'%');
	}

    $(document).on('change','.used_appropriate_verbiage_grade',function(){
		do_used_appropriate_verbiage();
    });
	do_used_appropriate_verbiage();

</script>
<script>
function do_offered_additional_alternate_resolution(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.offered_additional_alternate_resolution_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('offered_additional_alternate_resolution_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal8').val()=='No' ){
			$('#offered_additional_alternate_resolution_overall').val(0+'%');
		}else{
				$('#offered_additional_alternate_resolution_overall').val(grade1+'%');
			}
		
		// $('#offered_additional_alternate_resolution_overall').val(grade1+'%');
	}

    $(document).on('change','.offered_additional_alternate_resolution_grade',function(){
		do_offered_additional_alternate_resolution();
    });
	do_offered_additional_alternate_resolution();

</script>
<script>
function do_representative_leave_notes(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.representative_leave_notes_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('representative_leave_notes_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal9').val()=='No' ){
			$('#representative_leave_notes_overall').val(0+'%');
		}else{
				$('#representative_leave_notes_overall').val(grade1+'%');
			}
		
		// $('#representative_leave_notes_overall').val(grade1+'%');
	}

    $(document).on('change','.representative_leave_notes_grade',function(){
		do_representative_leave_notes();
    });
	do_representative_leave_notes();

</script>
<script>
function do_representative_due_diligence(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.representative_due_diligence_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('representative_due_diligence_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal10').val()=='No' ){
			$('#representative_due_diligence_overall').val(0+'%');
		}else{
				$('#representative_due_diligence_overall').val(grade1+'%');
			}
		
		// $('#representative_due_diligence_overall').val(grade1+'%');
	}

    $(document).on('change','.representative_due_diligence_grade',function(){
		do_representative_due_diligence();
    });
	do_representative_due_diligence();

</script>
<script>
function do_representative_fillout_property(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.representative_fillout_property_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('representative_fillout_property_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal11').val()=='No' ){
			$('#representative_fillout_property_overall').val(0+'%');
		}else{
				$('#representative_fillout_property_overall').val(grade1+'%');
			}
		
		// $('#representative_fillout_property_overall').val(grade1+'%');
	}

    $(document).on('change','.representative_fillout_property_grade',function(){
		do_representative_fillout_property();
    });
	do_representative_fillout_property();

</script>
<script>
function do_used_first_name(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.used_first_name_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('used_first_name_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal12').val()=='No' ){
			$('#used_first_name_overall').val(0+'%');
		}else{
				$('#used_first_name_overall').val(grade1+'%');
			}
		
		// $('#used_first_name_overall').val(grade1+'%');
	}

    $(document).on('change','.used_first_name_grade',function(){
		do_used_first_name();
    });
	do_used_first_name();

</script>
<script>
function do_use_correct_closing(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.use_correct_closing_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('use_correct_closing_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal13').val()=='No' ){
			$('#use_correct_closing_overall').val(0+'%');
		}else{
				$('#use_correct_closing_overall').val(grade1+'%');
			}
		
		// $('#use_correct_closing_overall').val(grade1+'%');
	}

    $(document).on('change','.use_correct_closing_grade',function(){
		do_use_correct_closing();
    });
	do_use_correct_closing();

</script>
<script>
function do_used_one_idea(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.used_one_idea_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('used_one_idea_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal14').val()=='No' ){
			$('#used_one_idea_overall').val(0+'%');
		}else{
				$('#used_one_idea_overall').val(grade1+'%');
			}
		
		// $('#used_one_idea_overall').val(grade1+'%');
	}

    $(document).on('change','.used_one_idea_grade',function(){
		do_used_one_idea();
    });
	do_used_one_idea();

</script>
<script>
function do_email_structure(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.email_structure_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('email_structure_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal15').val()=='No' ){
			$('#email_structure_overall').val(0+'%');
		}else{
				$('#email_structure_overall').val(grade1+'%');
			}
		
		// $('#email_structure_overall').val(grade1+'%');
	}

    $(document).on('change','.email_structure_grade',function(){
		do_email_structure();
    });
	do_email_structure();

</script>
<script>
function do_representative_responce_question(){
		var grade1 = 0;
		var scoreable1 = 0;
		var totalgrade1 = 0;
		var na_count = 0;
		
		$('.representative_responce_question_grade').each(function(index,element){
				var weightage1 = parseFloat($(element).children("option:selected").attr('representative_responce_question_val'));
				grade1 = grade1 + weightage1;
				// alert(weightage1);
		  });
		if($('#fatal16').val()=='No' ){
			$('#representative_responce_question_overall').val(0+'%');
		}else{
				$('#representative_responce_question_overall').val(grade1+'%');
			}
		
		// $('#representative_responce_question_overall').val(grade1+'%');
	}

    $(document).on('change','.representative_responce_question_grade',function(){
		do_representative_responce_question();
    });
	do_representative_responce_question();

</script>
											





 <script>
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	
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
			$('.auType_epi').hide();
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
	
	$(".points_epi").on("change",function(){
		docusign_calc();
	});
	
/////////////
	$(".ibumerang").on("change",function(){
		ibumerang_calc();
	});
	ibumerang_calc();

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
