<!-- <script type="text/javascript">
var jscript_blcker=0;
$(document).ready(function(){
	
	jscript_blcker = $('input#jacript_blocker').val();
	console.log(jscript_blcker);
	
	$("#audit_date").datepicker();
	$("#contact_date").datepicker();
	$("#contact_duration").timepicker({ timeFormat : 'HH:mm:ss'  });
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#call_date").datepicker();
	$("#call_length").timepicker();
	$("#call_date_time").datetimepicker();
	
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
	
///////////////// ACPT ///////////////////////
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
	
/////////////////VRS(Right Party)//////////////////
	$('#opening_call').on('change', function(){
		opening_scr(x,y);
	});
	$('#opening_verbatim').on('change', function(){
		opening_scr(x,y);
	});
	$('#opening_vrs').on('change', function(){
		opening_scr(x,y);
	});
	$('#opening_rightparty').on('change', function(){
		opening_scr(x,y);
	});
	$('#opening_demographics').on('change', function(){
		opening_scr(x,y);
	});
	$('#opening_miranda').on('change', function(){
		opening_scr(x,y);
	});
	$('#opening_communication').on('change', function(){
		opening_scr(x,y);
	});
	$('#opening_communication').on('change', function(){
		opening_scr(x,y);
	});
/////////	
	$('#effort_balance').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_poe').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_income').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_rent').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_account').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_intension').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_payment').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_offer').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_lump').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_settlement').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_significant').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_good').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_recoment').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_advise').on('change', function(){
		effort_scr(x,y);
	});
	$('#effort_negotiate').on('change', function(){
		effort_scr(x,y);
	});
	
	$('#callcontrol_demo').on('change', function(){
		callcontrol_scr(x,y);
	});
	$('#callcontrol_anticipate').on('change', function(){
		callcontrol_scr(x,y);
	});
	$('#callcontrol_question').on('change', function(){
		callcontrol_scr(x,y);
	});
	$('#callcontrol_establist').on('change', function(){
		callcontrol_scr(x,y);
	});
	$('#callcontrol_timelines').on('change', function(){
		callcontrol_scr(x,y);
	});
	$('#callcontrol_task').on('change', function(){
		callcontrol_scr(x,y);
	});
	$('#callcontrol_company').on('change', function(){
		callcontrol_scr(x,y);
	});
	$('#callcontrol_escalate').on('change', function(){
		callcontrol_scr(x,y);
	});
	$('#callcontrol_escalate').on('change', function(){
		callcontrol_scr(x,y);
	});
	
	$('#compliance_mispresent').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_threaten').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_account').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_faulse').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_contact').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_communicate').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_consumer').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_policy').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_location').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_dialer').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_unfair').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_credit').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_disput').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_obtain').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_imply').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_legal').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_barred').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_fdcpa').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_consider').on('change', function(){
		compliance_scr(x,y);
	});
	$('#compliance_collector').on('change', function(){
		compliance_scr(x,y);
	});
	
	$('#closing_call').on('change', function(){
		closing_scr(x,y);
	});
	$('#closing_restate').on('change', function(){
		closing_scr(x,y);
	});
	$('#closing_educate').on('change', function(){
		closing_scr(x,y);
	});
	$('#closing_profession').on('change', function(){
		closing_scr(x,y);
	});
	
	$('#document_action').on('change', function(){
		docu_scr(x,y);
	});
	$('#document_result').on('change', function(){
		docu_scr(x,y);
	});
	$('#document_context').on('change', function(){
		docu_scr(x,y);
	});
	$('#document_remove').on('change', function(){
		docu_scr(x,y);
	});
	$('#document_update').on('change', function(){
		docu_scr(x,y);
	});
	$('#document_change').on('change', function(){
		docu_scr(x,y);
	});
	$('#document_escalate').on('change', function(){
		docu_scr(x,y);
	});
	
/////////////////VRS(Left Message)//////////////////

	$('#zortman_deviation').on('change', function(){
		lm_overall_score();
	});
	$('#leave_message').on('change', function(){
		lm_overall_score();
	});
	$('#vrs_deviation').on('change', function(){
		lm_overall_score();
	});
	$('#misprepresent_identity').on('change', function(){
		lm_overall_score();
	});
	$('#make_false').on('change', function(){
		lm_overall_score();
	});
	$('#make_attempt').on('change', function(){
		lm_overall_score();
	});
	$('#work_number').on('change', function(){
		lm_overall_score();
	});
	$('#learning_attorney').on('change', function(){
		lm_overall_score();
	});
	$('#adhere_policy').on('change', function(){
		lm_overall_score();
	});
	$('#dialer_disposition').on('change', function(){
		lm_overall_score();
	});
	$('#remove_number').on('change', function(){
		lm_overall_score();
	});
	$('#close_call').on('change', function(){
		lm_overall_score();
	});
	$('#action_code').on('change', function(){
		lm_overall_score();
	});
	$('#result_code').on('change', function(){
		lm_overall_score();
	});
	$('#docu_account').on('change', function(){
		lm_overall_score();
	});
	
////////////////////////////////////////////////////////////////	
	$("#agent_id").on('change' , function(){	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_vrs/getTLname';
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
				for (var i in json_obj) $('#doj').append($('#doj').val(json_obj[i].doj));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
///////////////////// Upload File Condition ///////////////////////
	$('INPUT[type="file"]').change(function (){
		var ext = this.value.match(/\.(.+)$/)[1];
		switch (ext){
			case 'mp3':
			case 'mp4':
			case 'wav':
			case 'm4a':
			$('#qaformsubmit').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
	
	
//////////////////////////////////////

		$("#form_audit_user").submit(function (e) {
			$('#qaformsubmit').prop('disabled',true);
		});
		
		$("#form_agent_user").submit(function(e){
			$('#btnagentSave').prop('disabled',true);
		});
		
		$("#form_mgnt_user").submit(function(e){
			$('#btnmgntSave').prop('disabled',true);
		});
		
		
///////////////////////////
});
</script>


<script type="text/javascript">	
  ////// Possible and EarnScore calculation return value ////////
	function score_res(v){
		var x = 0;
		var y = 0;
		if(v == 10){ // YES
			x = +10;
			y = +10;
			return [x, y];
		}else if(v == 0){ // NO
			x = +10;
			y = -0;
			return [x, y];
		}else if(v == -10){ // FATAL
			x = +10;
			y = -0;
			return [x, y];
		}else if(v == -1){ // NA
			x = -0;
			y = -0;
			return [x, y];
		}else{
			var x=0;
			var y=0;
			return [x, y];
		}
	}
////////////////////////////////////////////////////	
	
/*-------------------VRS - Right Party---------------------*/	

	  $('select:not(.lm)').change(function(){
 
		var str = opening_scr().toString(); 
		var res = str.split(",");
		
		var str1 =  effort_scr().toString(); 
		var res1 = str1.split(",");
		
		var str2 =  callcontrol_scr().toString(); 
		var res2 = str2.split(",");
		
		var str3 =  compliance_scr().toString(); 
		var res3 = str3.split(",");
		
		var str4 =  closing_scr().toString(); 
		var res4 = str4.split(",");
		
		var str5 =  docu_scr().toString(); 
		var res5 = str5.split(",");
	
		
		$('#rp_total_score').val( (parseInt(res[0]) + parseInt(res1[0]) + parseInt(res2[0]) + parseInt(res3[0]) + parseInt(res4[0]) + parseInt(res5[0])) );
		
		$('#rp_possible_scr').val( (parseInt(res[1]) + parseInt(res1[1]) + parseInt(res2[1]) + parseInt(res3[1]) + parseInt(res4[1]) + parseInt(res5[1])) );
		
		$('#rp_total_per').val( (((parseInt(res[0]) + parseInt(res1[0]) + parseInt(res2[0]) + parseInt(res3[0]) + parseInt(res4[0]) + parseInt(res5[0])) * 100) / (parseInt(res[1]) + parseInt(res1[1]) + parseInt(res2[1]) + parseInt(res3[1]) + parseInt(res4[1]) + parseInt(res5[1]))).toFixed(2)+"%" );
	});  
	 
	function opening_scr(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#opening_call").val());
		var a2 = parseInt($("#opening_verbatim").val());
		var a3 = parseInt($("#opening_vrs").val());
		var a4 = parseInt($("#opening_rightparty").val());
		var a5 = parseInt($("#opening_demographics").val());
		var a6 = parseInt($("#opening_miranda").val());
		var a7 = parseInt($("#opening_communication").val());
		
		if(!isNaN(a1)) {
				var res = score_res(a1);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a2)) {
				var res = score_res(a2);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a3)) {
				var res = score_res(a3);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a4)) {
				var res = score_res(a4);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a5)) {
				var res = score_res(a5);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a6)) {
				var res = score_res(a6);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a7)) {
				var res = score_res(a7);
				ps = ps + res[0];
				es = es + res[1];
			}	
						
		if(!isNaN(ps) && !isNaN(es)){
			if(a1==-10 || a2==-10 || a3==-10 || a6==-10){
				document.getElementById("opening_score").value= 0;
				document.getElementById("opening_possible").value= ps;
				document.getElementById("opening_percentage").value="0%";
				var x = 0;
				var y = ps;
			}else{
				document.getElementById("opening_score").value= es;
				document.getElementById("opening_possible").value= ps;
				document.getElementById("opening_percentage").value=((es/ps)*100).toFixed(2)+"%";
				var x = es;
				var y = ps;
			}
			 
			return [x, y];
		}
	}
	
	function effort_scr(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#effort_balance").val());
		var a2 = parseInt($("#effort_poe").val());
		var a3 = parseInt($("#effort_income").val());
		var a4 = parseInt($("#effort_rent").val());
		var a5 = parseInt($("#effort_account").val());
		var a6 = parseInt($("#effort_intension").val());
		var a7 = parseInt($("#effort_payment").val());
		var a8 = parseInt($("#effort_offer").val());
		var a9 = parseInt($("#effort_lump").val());
		var a10 = parseInt($("#effort_settlement").val());
		var a11 = parseInt($("#effort_significant").val());
		var a12 = parseInt($("#effort_good").val());
		var a13 = parseInt($("#effort_recoment").val());
		var a14 = parseInt($("#effort_advise").val());
		var a15 = parseInt($("#effort_negotiate").val());
		
		if(!isNaN(a1)) {
				var res = score_res(a1);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a2)) {
				var res = score_res(a2);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a3)) {
				var res = score_res(a3);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a4)) {
				var res = score_res(a4);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a5)) {
				var res = score_res(a5);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a6)) {
				var res = score_res(a6);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a7)) {
				var res = score_res(a7);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a8)) {
				var res = score_res(a8);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a9)) {
				var res = score_res(a9);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a10)) {
				var res = score_res(a10);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a11)) {
				var res = score_res(a11);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a12)) {
				var res = score_res(a12);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a13)) {
				var res = score_res(a13);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a14)) {
				var res = score_res(a14);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a15)) {
				var res = score_res(a15);
				ps = ps + res[0];
				es = es + res[1];
			}
						
		
		if(!isNaN(ps) && !isNaN(es)){
			
			if(a14==-10){
				document.getElementById("effort_possible").value= ps;
				document.getElementById("effort_score").value= 0;
				document.getElementById("effort_percentage").value="0%";
				var x = 0;
				var y = ps;
			}else{
				document.getElementById("effort_possible").value= ps;
				document.getElementById("effort_score").value= es;	
				document.getElementById("effort_percentage").value=((es/ps)*100).toFixed(2)+"%";
				var x = es;
				var y = ps;
			} 
			return [x, y];
		}
	}
	
	function callcontrol_scr(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#callcontrol_demo").val());
		var a2 = parseInt($("#callcontrol_anticipate").val());
		var a3 = parseInt($("#callcontrol_question").val());
		var a4 = parseInt($("#callcontrol_establist").val());
		var a5 = parseInt($("#callcontrol_timelines").val());
		var a6 = parseInt($("#callcontrol_task").val());
		var a7 = parseInt($("#callcontrol_company").val());
		var a8 = parseInt($("#callcontrol_escalate").val());
		
		if(!isNaN(a1)) {
				var res = score_res(a1);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a2)) {
				var res = score_res(a2);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a3)) {
				var res = score_res(a3);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a4)) {
				var res = score_res(a4);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a5)) {
				var res = score_res(a5);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a6)) {
				var res = score_res(a6);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a7)) {
				var res = score_res(a7);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a8)) {
				var res = score_res(a8);
				ps = ps + res[0];
				es = es + res[1];
			}
						
		if(!isNaN(ps) && !isNaN(es)){
			document.getElementById("callcontrol_possible").value= ps;
			document.getElementById("callcontrol_score").value= es;
			document.getElementById("callcontrol_per").value=((es/ps)*100).toFixed(2)+"%";
			 
			var x = es;
			var y = ps;
			 
			return [x, y];
		}
	}
	
	function compliance_scr(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#compliance_mispresent").val());
		var a2 = parseInt($("#compliance_threaten").val());
		var a3 = parseInt($("#compliance_account").val());
		var a4 = parseInt($("#compliance_faulse").val());
		var a5 = parseInt($("#compliance_contact").val());
		var a6 = parseInt($("#compliance_communicate").val());
		var a7 = parseInt($("#compliance_consumer").val());
		var a8 = parseInt($("#compliance_policy").val());
		var a9 = parseInt($("#compliance_location").val());
		var a10 = parseInt($("#compliance_dialer").val());
		var a11 = parseInt($("#compliance_unfair").val());
		var a12 = parseInt($("#compliance_credit").val());
		var a13 = parseInt($("#compliance_disput").val());
		var a14 = parseInt($("#compliance_obtain").val());
		var a15 = parseInt($("#compliance_imply").val());
		var a16 = parseInt($("#compliance_legal").val());
		var a17 = parseInt($("#compliance_barred").val());
		var a18 = parseInt($("#compliance_fdcpa").val());
		var a19 = parseInt($("#compliance_consider").val());
		var a20 = parseInt($("#compliance_collector").val());
		
		if(!isNaN(a1)) {
				var res = score_res(a1);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a2)) {
				var res = score_res(a2);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a3)) {
				var res = score_res(a3);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a4)) {
				var res = score_res(a4);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a5)) {
				var res = score_res(a5);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a6)) {
				var res = score_res(a6);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a7)) {
				var res = score_res(a7);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a8)) {
				var res = score_res(a8);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a9)) {
				var res = score_res(a9);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a10)) {
				var res = score_res(a10);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a11)) {
				var res = score_res(a11);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a12)) {
				var res = score_res(a12);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a13)) {
				var res = score_res(a13);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a14)) {
				var res = score_res(a14);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a15)) {
				var res = score_res(a15);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a16)) {
				var res = score_res(a16);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a17)) {
				var res = score_res(a17);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a18)) {
				var res = score_res(a18);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a19)) {
				var res = score_res(a19);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a20)) {
				var res = score_res(a20);
				ps = ps + res[0];
				es = es + res[1];
			}
						
		if(!isNaN(ps) && !isNaN(es)){
			if(a1==-10 || a2==-10 || a3==-10 || a4==-10 || a5==-10 || a6==-10 || a7==-10 || a8==-10 || a9==-10 || a10==-10 || a11==-10 || a12==-10 || a13==-10 || a14==-10 || a15==-10 || a16==-10 || a17==-10 || a18==-10 || a19==-10 || a20==-10){
				document.getElementById("compliance_possible").value= ps;
				document.getElementById("compliance_score").value= 0;
				document.getElementById("compliance_per").value="0%";
				var x = 0;
				var y = ps;
			}else{
				document.getElementById("compliance_possible").value= ps;
				document.getElementById("compliance_score").value= es;
				document.getElementById("compliance_per").value=((es/ps)*100).toFixed(2)+"%";
				var x = es;
				var y = ps;
			} 
			return [x, y];
		}
	}
	
	function closing_scr(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#closing_call").val());
		var a2 = parseInt($("#closing_restate").val());
		var a3 = parseInt($("#closing_educate").val());
		var a4 = parseInt($("#closing_profession").val());
		
		if(!isNaN(a1)) {
				var res = score_res(a1);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a2)) {
				var res = score_res(a2);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a3)) {
				var res = score_res(a3);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a4)) {
				var res = score_res(a4);
				ps = ps + res[0];
				es = es + res[1];
			}
						
		if(!isNaN(ps) && !isNaN(es)){
			document.getElementById("closing_possible").value= ps;
			document.getElementById("closing_score").value= es;
			document.getElementById("closing_per").value=((es/ps)*100).toFixed(2)+"%";
			var x = es;
			var y = ps;
			 
			return [x, y];
		}
	}
	
	function docu_scr(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#document_action").val());
		var a2 = parseInt($("#document_result").val());
		var a3 = parseInt($("#document_context").val());
		var a4 = parseInt($("#document_remove").val());
		var a5 = parseInt($("#document_update").val());
		var a6 = parseInt($("#document_change").val());
		var a7 = parseInt($("#document_escalate").val());
			
		if(!isNaN(a1)) {
				var res = score_res(a1);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a2)) {
				var res = score_res(a2);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a3)) {
				var res = score_res(a3);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a4)) {
				var res = score_res(a4);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a5)) {
				var res = score_res(a5);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a6)) {
				var res = score_res(a6);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(a7)) {
				var res = score_res(a7);
				ps = ps + res[0];
				es = es + res[1];
			}		
						
		if(!isNaN(ps) && !isNaN(es)){
			if(a1==-10 || a2==-10 || a4==-10 || a5==-10 || a6==-10){
				document.getElementById("document_possible").value= ps;
				document.getElementById("document_score").value= 0;
				document.getElementById("document_per").value="0%";
				var x = 0;
				var y = ps;
			}else{
				document.getElementById("document_possible").value= ps;
				document.getElementById("document_score").value= es;
				document.getElementById("document_per").value=((es/ps)*100).toFixed(2)+"%";
				var x = es;
				var y = ps;
			} 
			return [x, y];
		}
	}




/*-------------------VRS - Left Message-----------------------*/	
	function lm_overall_score(){		
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#zortman_deviation").val());
		var a2 = parseInt($("#leave_message").val());
		var a3 = parseInt($("#vrs_deviation").val());
		var a4 = parseInt($("#misprepresent_identity").val());
		var a5 = parseInt($("#make_false").val());
		var a6 = parseInt($("#make_attempt").val());
		var a7 = parseInt($("#work_number").val());
		var a8 = parseInt($("#learning_attorney").val());
		var a9 = parseInt($("#adhere_policy").val());
		var a10 = parseInt($("#dialer_disposition").val());
		var a11 = parseInt($("#remove_number").val());
		var a12 = parseInt($("#close_call").val());
		var a13 = parseInt($("#action_code").val());
		var a14 = parseInt($("#result_code").val());
		var a15 = parseInt($("#docu_account").val());
		
		if(a1==0||a2==0||a3==0||a4==0||a5==0||a6==0||a7==0||a8==0||a9==0||a10==0||a11==0||a12==0||a13==0||a14==0||a15==0){
			ps = 0;
			es = 0;
		}else{
			
			if(!isNaN(a1)) {
					var res = score_res(a1);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a2)) {
					var res = score_res(a2);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a3)) {
					var res = score_res(a3);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a4)) {
					var res = score_res(a4);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a5)) {
					var res = score_res(a5);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a6)) {
					var res = score_res(a6);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a7)) {
					var res = score_res(a7);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a8)) {
					var res = score_res(a8);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a9)) {
					var res = score_res(a9);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a10)) {
					var res = score_res(a10);
					ps = ps + res[0];
					es = es + res[1];
				}	
			if(!isNaN(a11)) {
					var res = score_res(a11);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a12)) {
					var res = score_res(a12);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a13)) {
					var res = score_res(a13);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a14)) {
					var res = score_res(a14);
					ps = ps + res[0];
					es = es + res[1];
				}
			if(!isNaN(a15)) {
					var res = score_res(a15);
					ps = ps + res[0];
					es = es + res[1];
				}	
		
		}
						
		if(!isNaN(ps) && !isNaN(es)){
			document.getElementById("lm_form_possible").value= ps;
			document.getElementById("lm_total_score").value= es;
		
			////////////Score % calculation...................
			 if(!isNaN(es/ps)){
				document.getElementById("lm_form_percent").value=Math.round((es/ps)*100)+"%";
			 }
			 else{
				 document.getElementById("lm_form_percent").value="0%";			 
			 }
			 
		}
		
		 
	} 
/*-------------------VRS - Cavalry-----------------------*/	
	$(".cav").on("change",function(){
		var ps = 0;
		var es = 0;
		$(".cav").each(function(){
			var val		=	$(this).val();
			if(!isNaN(val)) {
					var res = score_res(val);
					ps = ps + res[0];
					es = es + res[1];
				}
		});
		if(!isNaN(ps) && !isNaN(es)){
			document.getElementById("cav_form_possible").value= ps;
			document.getElementById("cav_total_score").value= es;
		
			////////////Score % calculation...................
			 if(!isNaN(es/ps)){
				document.getElementById("cav_form_percent").value=Math.round((es/ps)*100)+"%";
			 }
			 else{
				 document.getElementById("cav_form_percent").value="0%";			 
			 }
			 
		}
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
 
 
 
<script>
 //**************************************** vrs jrpa script ****************************************//
		var calculated_value=0;
		var d =0;
		var e =0;
 
		// For openig section //
		
		
		
	function data_type(type,value){
		 
		 if(type == 'F'){
			return parseFloat(value);
		 }else if(type == 'I'){
			return parseInt(value);
		 }
		 
	 }
 
	$(".class_opening").on("change",function(){
		
		selected_elementID = $(this).attr("id");

		var a1 = $('#opening_1').val() == '-1' || '' ? 0: $('#opening_1').val();
		var a2 = $('#opening_2').val() == '-1' || '' ? 0:$('#opening_2').val();
		var a3 = $('#opening_3').val() == '-1' || '' ? 0:$('#opening_3').val();
		var a4 = $('#opening_4').val() == '-1' || '' ? 0:$('#opening_4').val();
		var a5 = $('#opening_5').val() == '-1' || '' ? 0:$('#opening_5').val();
		var a6 = $('#opening_6').val() == '-1' || '' ? 0:$('#opening_6').val();
		var a7 = $('#opening_7').val() == '-1' || '' ? 0:$('#opening_7').val();
		var a8 = $('#opening_8').val() == '-1' || '' ? 0:$('#opening_8').val();


		var b1 = $('#opening_1').find(':selected').data('demo');
		var b2 = $('#opening_2').find(':selected').data('demo');
		var b3 = $('#opening_3').find(':selected').data('demo');
		var b4 = $('#opening_4').find(':selected').data('demo');
		var b5 = $('#opening_5').find(':selected').data('demo');
		var b6 = $('#opening_6').find(':selected').data('demo');
		var b7 = $('#opening_7').find(':selected').data('demo');
		var b8 = $('#opening_8').find(':selected').data('demo');

		var f1 = $('#opening_1').find(':selected').data('fatal');
		var f2 = $('#opening_2').find(':selected').data('fatal');
		var f3 = $('#opening_3').find(':selected').data('fatal');
		var f4 = $('#opening_4').find(':selected').data('fatal');
		var f5 = $('#opening_5').find(':selected').data('fatal');
		var f6 = $('#opening_6').find(':selected').data('fatal');
		var f7 = $('#opening_7').find(':selected').data('fatal');
		var f8 = $('#opening_8').find(':selected').data('fatal');
		 
		
		a1 = isNaN(parseFloat(a1)) ? 0 : parseFloat(a1);
		a2 = isNaN(parseFloat(a2)) ? 0 : parseFloat(a2);
		a3 = isNaN(parseFloat(a3)) ? 0 : parseFloat(a3);
		a4 = isNaN(parseFloat(a4)) ? 0 : parseFloat(a4);
		a5 = isNaN(parseFloat(a5)) ? 0 : parseFloat(a5);
		a6 = isNaN(parseFloat(a6)) ? 0 : parseFloat(a6);
		a7 = isNaN(parseFloat(a7)) ? 0 : parseFloat(a7);
		a8 = isNaN(parseFloat(a8)) ? 0 : parseFloat(a8);
		
		 b1 =  isNaN(parseFloat(b1)) ? 0 : parseFloat(b1);
		 b2 =  isNaN(parseFloat(b2)) ? 0 : parseFloat(b2);
		 b3 =  isNaN(parseFloat(b3)) ? 0 : parseFloat(b3);
		 b4 =  isNaN(parseFloat(b4)) ? 0 : parseFloat(b4);
		 b5 =  isNaN(parseFloat(b5)) ? 0 : parseFloat(b5);
		 b6 =  isNaN(parseFloat(b6)) ? 0 : parseFloat(b6);;
		 b7 =  isNaN(parseFloat(b7)) ? 0 : parseFloat(b7);
		 b8 =  isNaN(parseFloat(b8)) ? 0 : parseFloat(b8);

		var c = $("#"+selected_elementID).val();
		
		if(f1==true || f2==true || f3==true || f4== true || f5 == true || f6 == true || f7 == true || f8 == true){
			d=0;
			e = calculation(b1,b2,b3,b4,b5,b6,b7,b8);
			calculation_total('1.25',d,e);	 
						  
		}else{
				if(c =='-1'){ 
					  alert(c);
					  d = calculation(a1,a2,a3,a4,a5,a6,a7,a8);
					   alert(d);   
					   
					  e = calculation(b1,b2,b3,b4,b5,b6,b7,b8);
					  
					  calculation_total(c,d,e);
					 
				}else if(c =='0'){
					
					  d = calculation(a1,a2,a3,a4,a5,a6,a7,a8);
					  e = calculation(b1,b2,b3,b4,b5,b6,b7,b8);
					  calculation_total(c,d,e);	  
				  
					
				}else if(c =='1.25'){
				 
						d = calculation(a1,a2,a3,a4,a5,a6,a7,a8);
						e = calculation(b1,b2,b3,b4,b5,b6,b7,b8);
						
						calculation_total(c,d,e);	 
						  
				
				}else{
					
					   d = calculation(a1,a2,a3,a4,a5,a6,a7,a8);
							$('#opening_score').val(d); 
					   d = calculation(b1,b2,b3,b4,b5,b6,b7,b8);
							$('#opening_possible').val(d);  
					
				}
		}
		
		//$('#opening_score').val(Math.round(c));  
		
	});
	
	function calculation(a1,a2,a3,a4,a5,a6,a7,a8){ 
			return calculated_value = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8;
	}
	
	
	
	
	function calculation_total(dropdown_type,d,e){
		
			if(dropdown_type == '-1'){
				 
				$('#opening_score').val(d);
				$('#opening_possible').val(e);
				 
					
			}else if(dropdown_type == '0'){
				
				 $('#opening_score').val(d);
				 $('#opening_possible').val(e);
				 
			}else if(dropdown_type == '1.25'){
				
				$('#opening_score').val(d);  
				$('#opening_possible').val(e); 
				
			}else{
				alert();
				$('#opening_score').val(d);  
				$('#opening_possible').val(e); 
				
			}
				
		}
		
		
		
	 ////*******************************************************************************//
	 //// FOR EFFORT SECTION //
	 ////*******************************************************************************//
	
	$(".class_effort").on("change",function(){
					selected_elementID = $(this).attr("id");
					
					 
					var i1 = $('#effort_1').val() == '-1' || '' ? 0: $('#effort_1').val();
					var i2 = $('#effort_2').val() == '-1' || '' ? 0: $('#effort_2').val();
					var i3 = $('#effort_3').val() == '-1' || '' ? 0: $('#effort_3').val();
					var i4 = $('#effort_4').val() == '-1' || '' ? 0: $('#effort_4').val();
					var i5 = $('#effort_5').val() == '-1' || '' ? 0: $('#effort_5').val();
					
					var j1 = $('#effort_1').find(':selected').data('demo');
					var j2 = $('#effort_2').find(':selected').data('demo');
					var j3 = $('#effort_3').find(':selected').data('demo');
					var j4 = $('#effort_4').find(':selected').data('demo');
					var j5 = $('#effort_5').find(':selected').data('demo');
					
					var f1 = $('#effort_1').find(':selected').data('fatal');
					var f2 = $('#effort_2').find(':selected').data('fatal');
					var f3 = $('#effort_3').find(':selected').data('fatal');
					var f4 = $('#effort_4').find(':selected').data('fatal');
					var f5 = $('#effort_5').find(':selected').data('fatal');
					
				  
					i1 = isNaN(parseFloat(i1)) ? 0 : parseFloat(i1);
					i2 = isNaN(parseFloat(i2)) ? 0 : parseFloat(i2);
					i3 = isNaN(parseFloat(i3)) ? 0 : parseFloat(i3);
					i4 = isNaN(parseFloat(i4)) ? 0 : parseFloat(i4);
					i5 = isNaN(parseFloat(i5)) ? 0 : parseFloat(i5);
 
					j1 =  isNaN(parseFloat(j1)) ? 0 : parseFloat(j1);
					j2 =  isNaN(parseFloat(j2)) ? 0 : parseFloat(j2);
					j3 =  isNaN(parseFloat(j3)) ? 0 : parseFloat(j3);
					j4 =  isNaN(parseFloat(j4)) ? 0 : parseFloat(j4);
					j5 =  isNaN(parseFloat(j5)) ? 0 : parseFloat(j5);

					
					 
					var c = $("#"+selected_elementID).val();
					 
						if(c =='-1'){ 
							  
							  f = calculation_2(i1,i2,i3,i4,i5);
							  g = calculation_2(j1,j2,j3,j4,j5);
							  
							  calculation_effort('-1',f,g);
							 
						}else if(c =='0'){
							
						 
							  f = calculation_2(i1,i2,i3,i4,i5);
							  g = calculation_2(j1,j2,j3,j4,j5);
							  
							  calculation_effort('0',f,g); 	
							
						}else if(c =='5'){
							  f = calculation_2(i1,i2,i3,i4,i5);
							  g = calculation_2(j1,j2,j3,j4,j5);
							  
							  calculation_effort(c,f,g); 				  
						
						}else{
							 d = calculation_2(i1,i2,i3,i4,i5);
								 $('#effort_score').val(d); 
							 d = calculation_2(j1,j2,j3,j4,j5);
								 $('#effort_possible').val(d);  
						}
					 
		});

		function calculation_2(a1,a2,a3,a4,a5){ 
			return calculated_value = a1 + a2 + a3 + a4 + a5 ;
		}
	
		
		
		function calculation_effort(dropdown_type,f,g){

			if(dropdown_type == '-1'){
			
				 $('#effort_score').val(f);  
				 $('#effort_possible').val(g); 
				  
					
			}else if(dropdown_type == '0'){
				
				 $('#effort_score').val(f);
				 $('#effort_possible').val(g);
				 
			}else if(dropdown_type == '5'){
				
				$('#effort_score').val(f);  
				$('#effort_possible').val(g); 
				
			}else{
				
				$('#effort_score').val(f);  
				$('#effort_possible').val(g); 
				
			}
				
		}
 
     ////*******************************************************************************//
	 //// FOR NEGOTIATION SECTION //
	 ////*******************************************************************************//
		
		$(".class_negotiation").on("change",function(){
					selected_elementID = $(this).attr("id");
 
					var l1 = $('#Negotiation_1').val() == '-1' || '' ? 0: $('#Negotiation_1').val();
					var l2 = $('#Negotiation_2').val() == '-1' || '' ? 0: $('#Negotiation_2').val();
					var l3 = $('#Negotiation_3').val() == '-1' || '' ? 0: $('#Negotiation_3').val();
					var l4 = $('#Negotiation_4').val() == '-1' || '' ? 0: $('#Negotiation_4').val(); 
					
					var m1 = $('#Negotiation_1').find(':selected').data('demo');
					var m2 = $('#Negotiation_2').find(':selected').data('demo');
					var m3 = $('#Negotiation_3').find(':selected').data('demo');
					var m4 = $('#Negotiation_4').find(':selected').data('demo'); 

					l1 = isNaN(parseFloat(l1)) ? 0 : parseFloat(l1);
					l2 = isNaN(parseFloat(l2)) ? 0 : parseInt(l2);
					l3 = isNaN(parseFloat(l3)) ? 0 : parseFloat(l3);
					l4 = isNaN(parseFloat(l4)) ? 0 : parseFloat(l4); 

					m1 =  isNaN(parseFloat(m1)) ? 0 : parseFloat(m1);
					m2 =  isNaN(parseFloat(m2)) ? 0 : parseFloat(m2);
					m3 =  isNaN(parseFloat(m3)) ? 0 : parseFloat(m3);
					m4 =  isNaN(parseFloat(m4)) ? 0 : parseFloat(m4); 

					var c = $("#"+selected_elementID).val();
					
					
					if(c =='-1'){ 
						  
						  f = calculation_3(l1,l2,l3,l4);
						  g = calculation_3(m1,m2,m3,m4);
						  
						  calculation_negotiation(c,f,g);
						 
					}else if(c =='0'){
						
						  f = calculation_3(l1,l2,l3,l4);
						  g = calculation_3(m1,m2,m3,m4);
						  
						  calculation_negotiation(c,f,g); 	
						
					}else if(c =='5'){
						  f = calculation_3(l1,l2,l3,l4);
						  g = calculation_3(m1,m2,m3,m4);
						  
						  calculation_negotiation(c,f,g); 				  
					
					}else{
						  d = calculation_3(l1,l2,l3,l4);
								$('#callcontrol_score').val(d); 
						  d = calculation_3(m1,m2,m3,m4);
								$('#callcontrol_possible').val(d);  
						
					}
					
		
		});

		function calculation_3(a1,a2,a3,a4){ 
			return calculated_value = a1 + a2 + a3 + a4 ;
		}
	
		
		
		function calculation_negotiation(dropdown_type,f,g){

			if(dropdown_type == '-1'){
				 $('#callcontrol_score').val(f);  
				 $('#callcontrol_possible').val(g); 
					
			}else if(dropdown_type == '0'){
				 $('#callcontrol_score').val(f);
				 $('#callcontrol_possible').val(g);
				 
			}else if(dropdown_type == '5'){
				$('#callcontrol_score').val(f);  
				$('#callcontrol_possible').val(g); 
				
			}else{
				console.log('error');
				$('#callcontrol_score').val(f);  
				$('#callcontrol_possible').val(g); 
				
			}
				
		}
		
	
//*******************************************************************************//
// FOR COMPLIANCE SECTION //
//*******************************************************************************//
		
		$(".class_compliance").on("change",function(){
			
				selected_elementID = $(this).attr("id");

				var o1 = $('#compliance_1').val() == '-1' || '' ? 0: $('#compliance_1').val();
				var o2 = $('#compliance_2').val() == '-1' || '' ? 0: $('#compliance_2').val();
				var o3 = $('#compliance_3').val() == '-1' || '' ? 0: $('#compliance_3').val();
				var o4 = $('#compliance_4').val() == '-1' || '' ? 0: $('#compliance_4').val();
				var o5 = $('#compliance_5').val() == '-1' || '' ? 0: $('#compliance_5').val();
				var o6 = $('#compliance_6').val() == '-1' || '' ? 0: $('#compliance_6').val();
				var o7 = $('#compliance_7').val() == '-1' || '' ? 0: $('#compliance_7').val();
				var o8 = $('#compliance_8').val() == '-1' || '' ? 0: $('#compliance_8').val();
				var o9 = $('#compliance_9').val() == '-1' || '' ? 0: $('#compliance_9').val();
				var o10 = $('#compliance_10').val() == '-1' || '' ? 0: $('#compliance_10').val();
				var o11 = $('#compliance_11').val() == '-1' || '' ? 0: $('#compliance_11').val();
				var o12 = $('#compliance_12').val() == '-1' || '' ? 0: $('#compliance_12').val();
				var o13 = $('#compliance_13').val() == '-1' || '' ? 0: $('#compliance_13').val();
				var o14 = $('#compliance_14').val() == '-1' || '' ? 0: $('#compliance_14').val();
				var o15 = $('#compliance_15').val() == '-1' || '' ? 0: $('#compliance_15').val();
				var o16 = $('#compliance_16').val() == '-1' || '' ? 0: $('#compliance_16').val();
				var o17 = $('#compliance_17').val() == '-1' || '' ? 0: $('#compliance_17').val();
				var o18 = $('#compliance_18').val() == '-1' || '' ? 0: $('#compliance_18').val();
				var o19 = $('#compliance_19').val() == '-1' || '' ? 0: $('#compliance_19').val();
				
				
				var p1 = $('#compliance_1').find(':selected').data('demo');
				var p2 = $('#compliance_2').find(':selected').data('demo');
				var p3 = $('#compliance_3').find(':selected').data('demo');
				var p4 = $('#compliance_4').find(':selected').data('demo'); 
				var p5 = $('#compliance_5').find(':selected').data('demo');
				var p6 = $('#compliance_6').find(':selected').data('demo');
				var p7 = $('#compliance_7').find(':selected').data('demo');
				var p8 = $('#compliance_8').find(':selected').data('demo'); 
				var p9 = $('#compliance_9').find(':selected').data('demo');
				var p10 = $('#compliance_10').find(':selected').data('demo');
				var p11 = $('#compliance_11').find(':selected').data('demo'); 
				var p12 = $('#compliance_12').find(':selected').data('demo');
				var p13 = $('#compliance_13').find(':selected').data('demo');
				var p14 = $('#compliance_14').find(':selected').data('demo');
				var p15 = $('#compliance_15').find(':selected').data('demo'); 
				var p16 = $('#compliance_16').find(':selected').data('demo');
				var p17 = $('#compliance_17').find(':selected').data('demo');
				var p18 = $('#compliance_18').find(':selected').data('demo');
				var p19 = $('#compliance_19').find(':selected').data('demo'); 
					
				var f1 = $('#compliance_1').find(':selected').data('fatal');
				var f2 = $('#compliance_2').find(':selected').data('fatal');
				var f3 = $('#compliance_3').find(':selected').data('fatal');
				var f4 = $('#compliance_4').find(':selected').data('fatal');
				var f5 = $('#compliance_5').find(':selected').data('fatal');
				var f6 = $('#compliance_6').find(':selected').data('fatal');
				var f7 = $('#compliance_7').find(':selected').data('fatal');
				var f8 = $('#compliance_8').find(':selected').data('fatal');
				var f9 = $('#compliance_9').find(':selected').data('fatal');
				var f10 = $('#compliance_10').find(':selected').data('fatal');
				var f11 = $('#compliance_11').find(':selected').data('fatal');
				var f12 = $('#compliance_12').find(':selected').data('fatal');
				var f13 = $('#compliance_13').find(':selected').data('fatal');
				var f14 = $('#compliance_14').find(':selected').data('fatal');
				var f15 = $('#compliance_15').find(':selected').data('fatal');
				var f16 = $('#compliance_16').find(':selected').data('fatal');
				var f17 = $('#compliance_17').find(':selected').data('fatal');
				var f18 = $('#compliance_18').find(':selected').data('fatal');
				var f19 = $('#compliance_19').find(':selected').data('fatal');
				
					 
					
				o1 = isNaN(parseFloat(o1)) ? 0 : parseFloat(o1);
				o2 = isNaN(parseFloat(o2)) ? 0 : parseFloat(o2);
				o3 = isNaN(parseFloat(o3)) ? 0 : parseFloat(o3);
				o4 = isNaN(parseFloat(o4)) ? 0 : parseFloat(o4); 
				o5 = isNaN(parseFloat(o5)) ? 0 : parseFloat(o5);
				o6 = isNaN(parseFloat(o6)) ? 0 : parseFloat(o6);
				o7 = isNaN(parseFloat(o7)) ? 0 : parseFloat(o7);
				o8 = isNaN(parseFloat(o8)) ? 0 : parseFloat(o8); 
				o9 = isNaN(parseFloat(o9)) ? 0 : parseFloat(o9);
				o10 = isNaN(parseFloat(o10)) ? 0 : parseFloat(o10);
				o11 = isNaN(parseFloat(o11)) ? 0 : parseFloat(o11);
				o12 = isNaN(parseFloat(o12)) ? 0 : parseFloat(o12); 
				o13 = isNaN(parseFloat(o13)) ? 0 : parseFloat(o13);
				o14 = isNaN(parseFloat(o14)) ? 0 : parseFloat(o14);
				o15 = isNaN(parseFloat(o15)) ? 0 : parseFloat(o15);
				o16 = isNaN(parseFloat(o16)) ? 0 : parseFloat(o16); 
				o17 = isNaN(parseFloat(o17)) ? 0 : parseFloat(o17);
				o18 = isNaN(parseFloat(o18)) ? 0 : parseFloat(o18);
				o19 = isNaN(parseFloat(o19)) ? 0 : parseFloat(o19); 
				
				 
				p1 = isNaN(parseFloat(p1)) ? 0 : parseFloat(p1);
				p2 = isNaN(parseFloat(p2)) ? 0 : parseFloat(p2);
				p3 = isNaN(parseFloat(p3)) ? 0 : parseFloat(p3);
				p4 = isNaN(parseFloat(p4)) ? 0 : parseFloat(p4); 
				p5 = isNaN(parseFloat(p5)) ? 0 : parseFloat(p5);
				p6 = isNaN(parseFloat(p6)) ? 0 : parseFloat(p6);
				p7 = isNaN(parseFloat(p7)) ? 0 : parseFloat(p7);
				p8 = isNaN(parseFloat(p8)) ? 0 : parseFloat(p8); 
				p9 = isNaN(parseFloat(p9)) ? 0 : parseFloat(p9);
				p10 = isNaN(parseFloat(p10)) ? 0 : parseFloat(p10);
				p11 = isNaN(parseFloat(p11)) ? 0 : parseFloat(p11);
				p12 = isNaN(parseFloat(p12)) ? 0 : parseFloat(p12); 
				p13 = isNaN(parseFloat(p13)) ? 0 : parseFloat(p13);
				p14 = isNaN(parseFloat(p14)) ? 0 : parseFloat(p14);
				p15 = isNaN(parseFloat(p15)) ? 0 : parseFloat(p15);
				p16 = isNaN(parseFloat(p16)) ? 0 : parseFloat(p16); 
				p17 = isNaN(parseFloat(p17)) ? 0 : parseFloat(p17);
				p18 = isNaN(parseFloat(p18)) ? 0 : parseFloat(p18);
				p19 = isNaN(parseFloat(p19)) ? 0 : parseFloat(p19); 
					
				  
				var c = $("#"+selected_elementID).val();
		 
		 
				if(f1==true || f2==true || f3==true || f4==true || f5==true || f6==true || f7==true || f8==true || f9==true || f10==true || f11==true || f12==true || f13==true || f14==true || f15==true || f16==true || f17==true || f18==true || f19==true){
					
						  f = 0;
						  g = calculation_4(p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19);
						  
						  calculation_compliance(0,f,g); 	
					
				}else{
					
					if(c =='-1'){ 
						  
						  f = calculation_4(o1,o2,o3,o4,o5,o6,o7,o8,o9,o10,o11,o12,o13,o14,o15,o16,o17,o18,o19);
						  g = calculation_4(p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19);
						  
						  calculation_compliance(c,f,g);
						 
					}else if(c =='0'){
						
					 
						  f = calculation_4(o1,o2,o3,o4,o5,o6,o7,o8,o9,o10,o11,o12,o13,o14,o15,o16,o17,o18,o19);
						  g = calculation_4(p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19);
						  
						  calculation_compliance('0',f,g); 	
						
					}else if(c =='0.52'){
						  f = calculation_4(o1,o2,o3,o4,o5,o6,o7,o8,o9,o10,o11,o12,o13,o14,o15,o16,o17,o18,o19);
						  g = calculation_4(p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19);
						  
						  calculation_compliance('0.52',f,g); 				  
					
					}else{
						   f = calculation_4(o1,o2,o3,o4,o5,o6,o7,o8,o9,o10,o11,o12,o13,o14,o15,o16,o17,o18,o19);
								$('#compliance_score').val(f); 
						   g = calculation_4(p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19);
								$('#compliance_possible	').val(g);  
						
					}
					
				}
					
		
		});

		function calculation_4(a1,a2,a3,a4,a5,a6,a7,a8,a9,a10,a11,a12,a13,a14,a15,a16,a17,a18,a19){ 
			return calculated_value = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 + a9 + a10 + a11 + a12 + a13 + a14 + a15 + a16 + a17 + a18 + a19;
		}
	
		
		
		function calculation_compliance(dropdown_type,f,g){

			if(dropdown_type == '-1'){
				 $('#compliance_score').val(f);  
				 $('#compliance_possible').val(g); 
					
			}else if(dropdown_type == '0'){
				 $('#compliance_score').val(f);
				 $('#compliance_possible').val(g);
				 
			}else if(dropdown_type == '0.52'){
				$('#compliance_score').val(f);  
				$('#compliance_possible').val(g); 
				
			}else{
				$('#compliance_score').val(f);  
				$('#compliance_possible').val(g); 
				
			}
				
		}
		
		//*******************************************************************************//
		// PAYMENT SCRIPT SECTION //
		//*******************************************************************************//
			
	
	$(".class_payment_script").on("change",function(){
					
					selected_elementID = $(this).attr("id");

					var r1 = $('#payment_script_1').val() == '-1' || '' ? 0: $('#payment_script_1').val();
					var r2 = $('#payment_script_2').val() == '-1' || '' ? 0: $('#payment_script_2').val();
					var r3 = $('#payment_script_3').val() == '-1' || '' ? 0: $('#payment_script_3').val();
					var r4 = $('#payment_script_4').val() == '-1' || '' ? 0: $('#payment_script_4').val();
					var r5 = $('#payment_script_5').val() == '-1' || '' ? 0: $('#payment_script_5').val();
				 
					
					var s1 = $('#payment_script_1').find(':selected').data('demo');
					var s2 = $('#payment_script_2').find(':selected').data('demo');
					var s3 = $('#payment_script_3').find(':selected').data('demo');
					var s4 = $('#payment_script_4').find(':selected').data('demo');
					var s5 = $('#payment_script_5').find(':selected').data('demo');
					
					
					r1 = isNaN(parseFloat(r1)) ? 0 : parseFloat(r1);
					r2 = isNaN(parseFloat(r2)) ? 0 : parseFloat(r2);
					r3 = isNaN(parseFloat(r3)) ? 0 : parseFloat(r3);
					r4 = isNaN(parseFloat(r4)) ? 0 : parseFloat(r4);
					r5 = isNaN(parseFloat(r5)) ? 0 : parseFloat(r5);

					
					 s1 =  isNaN(parseFloat(s1)) ? 0 : parseFloat(s1);
					 s2 =  isNaN(parseFloat(s2)) ? 0 : parseFloat(s2);
					 s3 =  isNaN(parseFloat(s3)) ? 0 : parseFloat(s3);
					 s4 =  isNaN(parseFloat(s4)) ? 0 : parseFloat(s4);
					 s5 =  isNaN(parseFloat(s5)) ? 0 : parseFloat(s5);

				
					var c = $("#"+selected_elementID).val();
					
					
					if(c =='-1'){ 
						  
						  f = calculation_5(r1,r2,r3,r4,r5);
						  g = calculation_5(s1,s2,s3,s4,s5);
						  
						  calculation_payment_script(c,f,g);
						 
					}else if(c =='0'){
						 
						  f = calculation_5(r1,r2,r3,r4,r5);
						  g = calculation_5(s1,s2,s3,s4,s5);
						  
						  calculation_payment_script(c,f,g); 	
						
					}else if(c =='2'){
						  f = calculation_5(r1,r2,r3,r4,r5);
						  g = calculation_5(s1,s2,s3,s4,s5);
						  
						  calculation_payment_script(c,f,g); 				  
					
					}else{
						 f = calculation_5(r1,r2,r3,r4,r5);
								$('#payment_script_score').val(f); 
				         g = calculation_5(s1,s2,s3,s4,s5);
								$('#payment_script_possible').val(g); 
					}
					
		});

		function calculation_5(a1,a2,a3,a4,a5){ 
			return calculated_value = a1 + a2 + a3 + a4 + a5 ;
		}
	
		
		
		function calculation_payment_script(dropdown_type,f,g){

		 
			if(dropdown_type == '-1'){
				 console.log('entered');
				 $('#payment_script_score').val(f);  
				 $('#payment_script_possible').val(g); 
					
			}else if(dropdown_type == '0'){
				
				 $('#payment_script_score').val(f);
				 $('#payment_script_possible').val(g);
				 
			}else if(dropdown_type == '2'){
				
				$('#payment_script_score').val(f);  
				$('#payment_script_possible').val(g); 
				
			} 
				
		}
		
		
		
		
		
 	//*******************************************************************************//
		// CALL CONTROLL SECTION //
		//*******************************************************************************//
			
	
	$(".class_call_control").on("change",function(){
					selected_elementID = $(this).attr("id");

					var u1 = $('#call_control_1').val() == '-1' || '' ? 0: $('#call_control_1').val();
					var u2 = $('#call_control_2').val() == '-1' || '' ? 0: $('#call_control_2').val();
					
					var v1 = $('#call_control_1').find(':selected').data('demo');
					var v2 = $('#call_control_2').find(':selected').data('demo');
					
					
					u1 = isNaN(parseFloat(u1)) ? 0 : parseFloat(u1);
					u2 = isNaN(parseFloat(u2)) ? 0 : parseFloat(u2);

					 v1 =  isNaN(parseFloat(v1)) ? 0 : parseFloat(v1);
					 v2 =  isNaN(parseFloat(v2)) ? 0 : parseFloat(v2);
 
					var c = $("#"+selected_elementID).val();
 
					if(c =='-1'){ 
						  
						  f = calculation_6(u1,u1);
						  g = calculation_6(v1,v2);
						  
						  calculation_call_control(c,f,g);
						 
					}else if(c =='0'){
						  f = calculation_6(u1,u2);
						  g = calculation_6(v1,v2);
						  
						  calculation_call_control(c,f,g); 	
						
					}else if(c =='2.5'){
						  f = calculation_6(u1,u2);
						  g = calculation_6(v1,v2);
						  
						  calculation_call_control(c,f,g); 				  
					
					}else{
						  f = calculation_6(u1,u2);
								$('#call_control_score').val(f); 
						  g = calculation_6(v1,v2);
								$('#call_control_possible').val(g); 
						
					}
					
		
		});

		function calculation_6(a1,a2,a3,a4,a5){ 
			return calculated_value = a1 + a2;
		}
	
		
		
		function calculation_call_control(dropdown_type,f,g){

			if(dropdown_type == '-1'){
				  
				 $('#call_control_score').val(f);  
				 $('#call_control_possible').val(g); 
					
			}else if(dropdown_type == '0'){
				
				 $('#call_control_score').val(f);
				 $('#call_control_possible').val(g);
				 
			}else if(dropdown_type == '2.5'){
				
				$('#call_control_score').val(f);  
				$('#call_control_possible').val(g); 
				
			} 
				
		}
 
 
 
 		//*******************************************************************************//
		// CLOSING SECTION //
		//*******************************************************************************//
			
	
	$(".class_closing").on("change",function(){
					selected_elementID = $(this).attr("id");

					var x1 = $('#closing_1').val() == '-1' || '' ? 0: $('#closing_1').val();
					var x2 = $('#closing_2').val() == '-1' || '' ? 0: $('#closing_2').val();
					var x3 = $('#closing_3').val() == '-1' || '' ? 0: $('#closing_3').val();
					var x4 = $('#closing_4').val() == '-1' || '' ? 0: $('#closing_4').val();
				 
					
					var y1 = $('#closing_1').find(':selected').data('demo');
					var y2 = $('#closing_2').find(':selected').data('demo');
					var y3 = $('#closing_3').find(':selected').data('demo');
					var y4 = $('#closing_4').find(':selected').data('demo'); 
					
					
					x1 = isNaN(parseFloat(x1)) ? 0 : parseFloat(x1);
					x2 = isNaN(parseFloat(x2)) ? 0 : parseFloat(x2);
					x3 = isNaN(parseFloat(x3)) ? 0 : parseFloat(x3);
					x4 = isNaN(parseFloat(x4)) ? 0 : parseFloat(x4); 

					
					 y1 =  isNaN(parseFloat(y1)) ? 0 : parseFloat(y1);
					 y2 =  isNaN(parseFloat(y2)) ? 0 : parseFloat(y2);
					 y3 =  isNaN(parseFloat(y3)) ? 0 : parseFloat(y3);
					 y4 =  isNaN(parseFloat(y4)) ? 0 : parseFloat(y4); 
					 
					var c = $("#"+selected_elementID).val();
					
				 				
					if(c =='-1'){ 
						  
						  f = calculation_7(x1,x2,x3,x4);
						  g = calculation_7(y1,y2,y3,y4);
						  
						  calculation_close(c,f,g);
						 
					}else if(c =='0'){
						
					 
						  f = calculation_7(x1,x2,x3,x4);
						  g = calculation_7(y1,y2,y3,y4);
						  
						  calculation_close(c,f,g); 	
						
					}else if(c =='1.25'){
						  f = calculation_7(x1,x2,x3,x4);
						  g = calculation_7(y1,y2,y3,y4);
						  
						  calculation_close(c,f,g); 				  
					
					}else{
						 f = calculation_7(x1,x2,x3,x4);
							 $('#closing_score').val(f);  
						 g = calculation_7(y1,y2,y3,y4);
							 $('#closing_possible').val(g); 
					}
					
		
		});

		function calculation_7(a1,a2,a3,a4){ 
			return calculated_value = a1 + a2 + a3 + a4;
		}
	
		
		
		function calculation_close(dropdown_type,f,g){
 
			if(dropdown_type == '-1'){
				 
				 $('#closing_score').val(f);  
				 $('#closing_possible').val(g); 
					
			}else if(dropdown_type == '0'){
				
				 $('#closing_score').val(f);
				 $('#closing_possible').val(g);
				 
			}else if(dropdown_type == '1.25'){
				
				$('#closing_score').val(f);  
				$('#closing_possible').val(g); 
				
			} 
				
		}
		
		
		
		//*******************************************************************************//
		// DOCUMENT SECTION //
		//*******************************************************************************//
			
	
	$(".class_document").on("change",function(){
					selected_elementID = $(this).attr("id");

					var xx1 = $('#document_1').val() == '-1' || '' ? 0: $('#document_1').val();
					var xx2 = $('#document_2').val() == '-1' || '' ? 0: $('#document_2').val();
					var xx3 = $('#document_3').val() == '-1' || '' ? 0: $('#document_3').val();
					var xx4 = $('#document_4').val() == '-1' || '' ? 0: $('#document_4').val();
					var xx5 = $('#document_5').val() == '-1' || '' ? 0: $('#document_5').val();
					var xx6 = $('#document_6').val() == '-1' || '' ? 0: $('#document_6').val();
					var xx7 = $('#document_7').val() == '-1' || '' ? 0: $('#document_7').val();
				 
					
					var yy1 = $('#document_1').find(':selected').data('demo');
					var yy2 = $('#document_2').find(':selected').data('demo');
					var yy3 = $('#document_3').find(':selected').data('demo');
					var yy4 = $('#document_4').find(':selected').data('demo'); 
					var yy5 = $('#document_5').find(':selected').data('demo'); 
					var yy6 = $('#document_6').find(':selected').data('demo'); 
					var yy7 = $('#document_7').find(':selected').data('demo'); 
					
					var zz1 = $('#document_1').find(':selected').data('fatal');
					var zz2 = $('#document_2').find(':selected').data('fatal');
					var zz3 = $('#document_3').find(':selected').data('fatal');
					var zz4 = $('#document_4').find(':selected').data('fatal'); 
					var zz5 = $('#document_5').find(':selected').data('fatal'); 
					var zz6 = $('#document_6').find(':selected').data('fatal'); 
					var zz7 = $('#document_7').find(':selected').data('fatal'); 
					
				
					xx1 = isNaN(parseFloat(xx1)) ? 0 : parseFloat(xx1);
					xx2 = isNaN(parseFloat(xx2)) ? 0 : parseFloat(xx2);
					xx3 = isNaN(parseFloat(xx3)) ? 0 : parseFloat(xx3);
					xx4 = isNaN(parseFloat(xx4)) ? 0 : parseFloat(xx4); 
					xx5 = isNaN(parseFloat(xx5)) ? 0 : parseFloat(xx5);
					xx6 = isNaN(parseFloat(xx6)) ? 0 : parseFloat(xx6);
					xx7 = isNaN(parseFloat(xx7)) ? 0 : parseFloat(xx7); 
					
					 yy1 =  isNaN(parseFloat(yy1)) ? 0 : parseFloat(yy1);
					 yy2 =  isNaN(parseFloat(yy2)) ? 0 : parseFloat(yy2);
					 yy3 =  isNaN(parseFloat(yy3)) ? 0 : parseFloat(yy3);
					 yy4 =  isNaN(parseFloat(yy4)) ? 0 : parseFloat(yy4); 
					 yy5 =  isNaN(parseFloat(yy5)) ? 0 : parseFloat(yy5);
					 yy6 =  isNaN(parseFloat(yy6)) ? 0 : parseFloat(yy6);
					 yy7 =  isNaN(parseFloat(yy7)) ? 0 : parseFloat(yy7); 
					 
					 
					var c = $("#"+selected_elementID).val();
					
				 	if(zz1 == true || zz2== true || zz3 == true || zz4 == true || zz5 == true || zz6==true || zz7 == true){	
							d=0;
							e = calculation_8(yy1,yy2,yy3,yy4,yy5,yy6,yy7);
							calculation_document(c,d,e);	 

					}else{					
							if(c =='-1'){ 
								  
								 f = calculation_8(xx1,xx2,xx3,xx4,xx5,xx6,xx7);
								 g = calculation_8(yy1,yy2,yy3,yy4,yy5,yy6,yy7);
								  
								  calculation_document(c,f,g); 	
								  
								 
							}else if(c =='0'){
								
							 
								 f = calculation_8(xx1,xx2,xx3,xx4,xx5,xx6,xx7);
								 g = calculation_8(yy1,yy2,yy3,yy4,yy5,yy6,yy7);
								  
								  calculation_document(c,f,g); 	
								
							}else if(c =='1.42'){
								  f = calculation_8(xx1,xx2,xx3,xx4,xx5,xx6,xx7);
								  g = calculation_8(yy1,yy2,yy3,yy4,yy5,yy6,yy7);
								  
								  calculation_document(c,f,g); 				  
							
							}else{
								  f = calculation_8(xx1,xx2,xx3,xx4,xx5,xx6,xx7);
									$('#document_score').val(f); 
								  g = calculation_8(yy1,yy2,yy3,yy4,yy5,yy6,yy7);
									$('#document_possible').val(g);  
							}
					}
		
		});

		function calculation_8(a1,a2,a3,a4,a5,a6,a7){ 
			return calculated_value = a1 + a2 + a3 + a4 + a5 + a6 + a7;
		}
	
		
		
		function calculation_document(dropdown_type,f,g){

			if(dropdown_type == '-1'){
				 console.log('entered');
				 $('#document_score').val(f);  
				 $('#document_possible').val(g); 
					
			}else if(dropdown_type == '0'){
				
				 $('#document_score').val(f);
				 $('#document_possible').val(g);
				 
			}else if(dropdown_type == '1.42'){
				
				$('#document_score').val(f);  
				$('#document_possible').val(g); 
				
			}
				
		}
		
 
 
 </script>> -->