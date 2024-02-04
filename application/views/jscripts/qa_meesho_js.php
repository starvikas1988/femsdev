<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#review_date").datepicker();
	$("#audit_date_time").datetimepicker();
	$("#call_date_time").datetimepicker();
	$("#call_date").datetimepicker();
	$("#email_date_time").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	
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
	
/////////////////Meesho Email///////////////////
	$('#oprning_personalization').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#oprning_personalization_comment").prop('disabled',false);
			$("#oprning_personalization_comment").attr('required',true);
		}else{
			$("#oprning_personalization_comment").prop('disabled',true);
			$("#oprning_personalization_comment").attr('required',false);
			$("#oprning_personalization_comment").val('');
		}
	});
	$('#validation_customer_info').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#validation_customer_info_comment").prop('disabled',false);
			$("#validation_customer_info_comment").attr('required',true);
		}else{
			$("#validation_customer_info_comment").prop('disabled',true);
			$("#validation_customer_info_comment").attr('required',false);
			$("#validation_customer_info_comment").val('');
		}
	});
	$('#acknowledge_align_assure').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#acknowledge_align_assure_comment").prop('disabled',false);
			$("#acknowledge_align_assure_comment").attr('required',true);
		}else{
			$("#acknowledge_align_assure_comment").prop('disabled',true);
			$("#acknowledge_align_assure_comment").attr('required',false);
			$("#acknowledge_align_assure_comment").val('');
		}
	});
	$('#effective_probing').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#effective_probing_comment").prop('disabled',false);
			$("#effective_probing_comment").attr('required',true);
		}else{
			$("#effective_probing_comment").prop('disabled',true);
			$("#effective_probing_comment").attr('required',false);
			$("#effective_probing_comment").val('');
		}
	});
	$('#accurate_resolution').on('change', function(){
		email_overall_score();
		if($(this).val()=='-1'){
			$("#accurate_resolution_comment").prop('disabled',false);
			$("#accurate_resolution_comment").attr('required',true);
		}else{
			$("#accurate_resolution_comment").prop('disabled',true);
			$("#accurate_resolution_comment").attr('required',false);
			$("#accurate_resolution_comment").val('');
		}
	});
	$('#manage_delay_grace').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#manage_delay_grace_comment").prop('disabled',false);
			$("#manage_delay_grace_comment").attr('required',true);
		}else{
			$("#manage_delay_grace_comment").prop('disabled',true);
			$("#manage_delay_grace_comment").attr('required',false);
			$("#manage_delay_grace_comment").val('');
		}
	});
	$('#provide_self_help').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#provide_self_help_comment").prop('disabled',false);
			$("#provide_self_help_comment").attr('required',true);
		}else{
			$("#provide_self_help_comment").prop('disabled',true);
			$("#provide_self_help_comment").attr('required',false);
			$("#provide_self_help_comment").val('');
		}
	});
	$('#used_template_correctly').on('change', function(){
		email_overall_score();
		if($(this).val()=='-1'){
			$("#used_template_correctly_comment").prop('disabled',false);
			$("#used_template_correctly_comment").attr('required',true);
		}else{
			$("#used_template_correctly_comment").prop('disabled',true);
			$("#used_template_correctly_comment").attr('required',false);
			$("#used_template_correctly_comment").val('');
		}
	});
	$('#used_necessary_custom').on('change', function(){
		email_overall_score();
		if($(this).val()=='-1'){
			$("#used_necessary_custom_comment").prop('disabled',false);
			$("#used_necessary_custom_comment").attr('required',true);
		}else{
			$("#used_necessary_custom_comment").prop('disabled',true);
			$("#used_necessary_custom_comment").attr('required',false);
			$("#used_necessary_custom_comment").val('');
		}
	});
	$('#used_correct_spelling').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#used_correct_spelling_comment").prop('disabled',false);
			$("#used_correct_spelling_comment").attr('required',true);
		}else{
			$("#used_correct_spelling_comment").prop('disabled',true);
			$("#used_correct_spelling_comment").attr('required',false);
			$("#used_correct_spelling_comment").val('');
		}
	});
	$('#crm_accuracy').on('change', function(){
		email_overall_score();
		if($(this).val()=='-1'){
			$("#crm_accuracy_comment").prop('disabled',false);
			$("#crm_accuracy_comment").attr('required',true);
		}else{
			$("#crm_accuracy_comment").prop('disabled',true);
			$("#crm_accuracy_comment").attr('required',false);
			$("#crm_accuracy_comment").val('');
		}
	});
	$('#closing_statement').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#closing_statement_comment").prop('disabled',false);
			$("#closing_statement_comment").attr('required',true);
		}else{
			$("#closing_statement_comment").prop('disabled',true);
			$("#closing_statement_comment").attr('required',false);
			$("#closing_statement_comment").val('');
		}
	});
	/* $('#agent_write_brand_voice').on('change', function(){
		email_overall_score();
		if($(this).val()=='0'){
			$("#agent_write_brand_voice_comment").prop('disabled',false);
			$("#agent_write_brand_voice_comment").attr('required',true);
		}else{
			$("#agent_write_brand_voice_comment").prop('disabled',true);
			$("#agent_write_brand_voice_comment").attr('required',false);
			$("#agent_write_brand_voice_comment").val('');
		}
	}); */

	
/////////////////Meesho Inbound///////////////////
	$('#call_opening').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#call_opening_comment").prop('disabled',false);
			$("#call_opening_comment").attr('required',true);
		}else{
			$("#call_opening_comment").prop('disabled',true);
			$("#call_opening_comment").attr('required',false);
			$("#call_opening_comment").val('');
		}
	});
	$('#identification').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#identification_comment").prop('disabled',false);
			$("#identification_comment").attr('required',true);
		}else{
			$("#identification_comment").prop('disabled',true);
			$("#identification_comment").attr('required',false);
			$("#identification_comment").val('');
		}
	});
	$('#security_check').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#security_check_comment").prop('disabled',false);
			$("#security_check_comment").attr('required',true);
		}else{
			$("#security_check_comment").prop('disabled',true);
			$("#security_check_comment").attr('required',false);
			$("#security_check_comment").val('');
		}
	});
	$('#hold_procedure').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#hold_procedure_comment").prop('disabled',false);
			$("#hold_procedure_comment").attr('required',true);
		}else{
			$("#hold_procedure_comment").prop('disabled',true);
			$("#hold_procedure_comment").attr('required',false);
			$("#hold_procedure_comment").val('');
		}
	});
	$('#closing_script').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#closing_script_comment").prop('disabled',false);
			$("#closing_script_comment").attr('required',true);
		}else{
			$("#closing_script_comment").prop('disabled',true);
			$("#closing_script_comment").attr('required',false);
			$("#closing_script_comment").val('');
		}
	});
	$('#active_listening').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#active_listening_comment").prop('disabled',false);
			$("#active_listening_comment").attr('required',true);
		}else{
			$("#active_listening_comment").prop('disabled',true);
			$("#active_listening_comment").attr('required',false);
			$("#active_listening_comment").val('');
		}
	});
	$('#effective_probing').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#effective_probing_comment").prop('disabled',false);
			$("#effective_probing_comment").attr('required',true);
		}else{
			$("#effective_probing_comment").prop('disabled',true);
			$("#effective_probing_comment").attr('required',false);
			$("#effective_probing_comment").val('');
		}
	});
	$('#accurate_resolution_process').on('change', function(){
		ib_overall_score();
		if($(this).val()=='-1'){
			$("#accurate_resolution_process_comment").prop('disabled',false);
			$("#accurate_resolution_process_comment").attr('required',true);
		}else{
			$("#accurate_resolution_process_comment").prop('disabled',true);
			$("#accurate_resolution_process_comment").attr('required',false);
			$("#accurate_resolution_process_comment").val('');
		}
	});
	$('#politeness_courtesy').on('change', function(){
		ib_overall_score();
		if($(this).val()=='-1'){
			$("#politeness_courtesy_comment").prop('disabled',false);
			$("#politeness_courtesy_comment").attr('required',true);
		}else{
			$("#politeness_courtesy_comment").prop('disabled',true);
			$("#politeness_courtesy_comment").attr('required',false);
			$("#politeness_courtesy_comment").val('');
		}
	});
	$('#apology_empathy').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#apology_empathy_comment").prop('disabled',false);
			$("#apology_empathy_comment").attr('required',true);
		}else{
			$("#apology_empathy_comment").prop('disabled',true);
			$("#apology_empathy_comment").attr('required',false);
			$("#apology_empathy_comment").val('');
		}
	});
	$('#enthusiasm').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#enthusiasm_comment").prop('disabled',false);
			$("#enthusiasm_comment").attr('required',true);
		}else{
			$("#enthusiasm_comment").prop('disabled',true);
			$("#enthusiasm_comment").attr('required',false);
			$("#enthusiasm_comment").val('');
		}
	});
	/* $('#fluency_structure').on('change', function(){
		ib_overall_score();
		if($(this).val()=='0'){
			$("#fluency_structure_comment").prop('disabled',false);
			$("#fluency_structure_comment").attr('required',true);
		}else{
			$("#fluency_structure_comment").prop('disabled',true);
			$("#fluency_structure_comment").attr('required',false);
			$("#fluency_structure_comment").val('');
		}
	});
	$('#mentorship_pitch').on('change', function(){
		ib_overall_score();
		if($(this).val()=='-1'){
			$("#mentorship_pitch_comment").prop('disabled',false);
			$("#mentorship_pitch_comment").attr('required',true);
		}else{
			$("#mentorship_pitch_comment").prop('disabled',true);
			$("#mentorship_pitch_comment").attr('required',false);
			$("#mentorship_pitch_comment").val('');
		}
	}); */
	$('#crm_accuracy_ib').on('change', function(){
		ib_overall_score();
		if($(this).val()=='-1'){
			$("#crm_accuracy_ib_comment").prop('disabled',false);
			$("#crm_accuracy_ib_comment").attr('required',true);
		}else{
			$("#crm_accuracy_ib_comment").prop('disabled',true);
			$("#crm_accuracy_ib_comment").attr('required',false);
			$("#crm_accuracy_ib_comment").val('');
		}
	});
	$('#addition_info').on('change', function(){
		ib_overall_score();
		if($(this).val()=='-1'){
			$("#addition_info_comment").prop('disabled',false);
			$("#addition_info_comment").attr('required',true);
		}else{
			$("#addition_info_comment").prop('disabled',true);
			$("#addition_info_comment").attr('required',false);
			$("#addition_info_comment").val('');
		}
	});

/////////////////Meesho Supplier Support///////////////////
	$(document).on('change','.ss_point',function(){
		supplier_support();
	});
	
	$(document).on('change','.fatalCount',function(){
		supplier_support();
	});
	
	
	$('#ss_acpt').on('change', function(){
		if($(this).val()=='Agent'){
			var l2_acpt_agent = '<option value="">Select</option>';
			l2_acpt_agent += '<option value="Incomplete Resolution">Incomplete Resolution</option>';
			l2_acpt_agent += '<option value="Incorrect Resolution">Incorrect Resolution</option>';
			l2_acpt_agent += '<option value="Inappropriate Action Taken">Inappropriate Action Taken</option>';
			l2_acpt_agent += '<option value="Action needed Not taken">Action needed Not taken</option>';
			l2_acpt_agent += '<option value="False Assurance">False Assurance</option>';
			l2_acpt_agent += '<option value="Soft skill Issue">Soft skill Issue</option>';
			$("#ss_l2_acpt").html(l2_acpt_agent);
		}else if($(this).val()=='Customer'){
			var l2_acpt_customer = '<option value="">Select</option>';
			l2_acpt_customer += '<option value="Lack of process knowledge">Lack of process knowledge</option>';
			l2_acpt_customer += '<option value="Supplier understanding">Supplier understanding</option>';
			$("#ss_l2_acpt").html(l2_acpt_customer);
		}else if($(this).val()=='Process'){
			var l2_acpt_process = '<option value="">Select</option>';
			l2_acpt_process += '<option value="Cataloge Issue">Cataloge Issue</option>';
			l2_acpt_process += '<option value="Claim issue">Claim issue</option>';
			l2_acpt_process += '<option value="Return issue">Return issue</option>';
			l2_acpt_process += '<option value="Logistic issue">Logistic issue</option>';
			l2_acpt_process += '<option value="Compensation Issue">Compensation Issue</option>';
			l2_acpt_process += '<option value="POD Issue">POD Issue</option>';
			l2_acpt_process += '<option value="Backend Issue">Backend Issue</option>';
			$("#ss_l2_acpt").html(l2_acpt_process);
		}else if($(this).val()=='Technology'){
			var l2_acpt_tech = '<option value="">Select</option>';
			l2_acpt_tech += '<option value="App Issue">App Issue</option>';
			$("#ss_l2_acpt").html(l2_acpt_tech);
		}	
	});
	
	$('#ss_l2_acpt').on('change', function(){
		if($(this).val()=='Incomplete Resolution'){
			var l3_acpt_IR = '<option value="">Select</option>';
			l3_acpt_IR += '<option value="TAT not informed">TAT not informed</option>';
			l3_acpt_IR += '<option value="Compensation request not sent when required">Compensation request not sent when required</option>';
			l3_acpt_IR += '<option value="Transaction/NEFT ID not shared">Transaction/NEFT ID not shared</option>';
			l3_acpt_IR += '<option value="Incomplete payment information shared">Incomplete payment information shared</option>';
			l3_acpt_IR += '<option value="All concerns not addressed (A particular ticket)">All concerns not addressed (A particular ticket)</option>';
			l3_acpt_IR += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_IR);
		}else if($(this).val()=='Incorrect Resolution'){
			var l3_acpt_ICR = '<option value="">Select</option>';
			l3_acpt_ICR += '<option value="Incorrect Information regarding compensation">Incorrect Information regarding compensation</option>';
			l3_acpt_ICR += '<option value="Incorrect TAT Informed">Incorrect TAT Informed</option>';
			l3_acpt_ICR += '<option value="Incorrect Tracking Information shared">Incorrect Tracking Information shared</option>';
			l3_acpt_ICR += '<option value="Incorrect Product details shared">Incorrect Product details shared</option>';
			l3_acpt_ICR += '<option value="Wrong Transaction/NEFT ID not shared">Wrong Transaction/NEFT ID not shared</option>';
			l3_acpt_ICR += '<option value="Incorrect POD details shared">Incorrect POD details shared</option>';
			l3_acpt_ICR += '<option value="Incorrect order status informed">Incorrect order status informed</option>';
			l3_acpt_ICR += '<option value="Resolution given without reffering Tracker">Resolution given without reffering Tracker</option>';
			l3_acpt_ICR += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_ICR);
		}else if($(this).val()=='Inappropriate Action Taken'){
			var l3_acpt_IAT = '<option value="">Select</option>';
			l3_acpt_IAT += '<option value="Incorrect Compensation request sent">Incorrect Compensation request sent</option>';
			l3_acpt_IAT += '<option value="Improper form filled">Improper form filled</option>';
			l3_acpt_IAT += '<option value="Incorrect Documentation Done">Incorrect Documentation Done</option>';
			l3_acpt_IAT += '<option value="Documentation not done">Documentation not done</option>';
			l3_acpt_IAT += '<option value="Incorrect ticket status selected ( Open/Solve/Hold/Pending)">Incorrect ticket status selected ( Open/Solve/Hold/Pending)</option>';
			l3_acpt_IAT += '<option value="Incorrect Tracking link/URL sent">Incorrect Tracking link/URL sent</option>';
			l3_acpt_IAT += '<option value="Email id not verified and gave solution">Email id not verified and gave solution</option>';
			l3_acpt_IAT += '<option value="Incorrect POD details shared">Incorrect POD details shared</option>';
			l3_acpt_IAT += '<option value="Order id not mentioned">Order id not mentioned</option>';
			l3_acpt_IAT += '<option value="Catalog id not mentioned">Catalog id not mentioned</option>';
			l3_acpt_IAT += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_IAT);
		}else if($(this).val()=='Action needed Not taken'){
			var l3_acpt_ANT = '<option value="">Select</option>';
			l3_acpt_ANT += '<option value="Form not filled">Form not filled</option>';
			l3_acpt_ANT += '<option value="Ticket was not escalated when required">Ticket was not escalated when required</option>';
			l3_acpt_ANT += '<option value="Tracking link/URL not sent when required">Tracking link/URL not sent when required</option>';
			l3_acpt_ANT += '<option value="OB Not done when required">OB Not done when required</option>';
			l3_acpt_ANT += '<option value="TT not raised when required">TT not raised when required</option>';
			l3_acpt_ANT += '<option value="FYI not processed">FYI not processed</option>';
			l3_acpt_ANT += '<option value="Proper bucket movement not done">Proper bucket movement not done</option>';
			l3_acpt_ANT += '<option value="Case history not checked">Case history not checked</option>';
			l3_acpt_ANT += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_ANT);
		}else if($(this).val()=='False Assurance'){
			var l3_acpt_FA = '<option value="">Select</option>';
			l3_acpt_FA += '<option value="Ob not done when promised">Ob not done when promised</option>';
			l3_acpt_FA += '<option value="False assurance made for escalating the issue">False assurance made for escalating the issue</option>';
			l3_acpt_FA += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_FA);
		}else if($(this).val()=='Soft skill Issue'){
			var l3_acpt_SSI = '<option value="">Select</option>';
			l3_acpt_SSI += '<option value="Rudeness">Rudeness</option>';
			l3_acpt_SSI += '<option value="Impolite">Impolite</option>';
			l3_acpt_SSI += '<option value="Impatience">Impatience</option>';
			l3_acpt_SSI += '<option value="Casual">Casual</option>';
			l3_acpt_SSI += '<option value="Sarcastic">Sarcastic</option>';
			l3_acpt_SSI += '<option value="Condescending">Condescending</option>';
			l3_acpt_SSI += '<option value="Grammar and punctuation Issue">Grammar and punctuation Issue</option>';
			l3_acpt_SSI += '<option value="Unable to Frame sentences">Unable to Frame sentences</option>';
			l3_acpt_SSI += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_SSI);
		}else if($(this).val()=='Cataloge Issue'){
			var l3_acpt_CI = '<option value="">Select</option>';
			l3_acpt_CI += '<option value="MRP Miss match">MRP Miss match</option>';
			l3_acpt_CI += '<option value="Specifications Mismatch">Specifications Mismatch</option>';
			l3_acpt_CI += '<option value="Proper Category/vertivcal not available in panel">Proper Category/vertivcal not available in panel</option>';
			l3_acpt_CI += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_CI);
		}else if($(this).val()=='Claim issue'){
			var l3_acpt_CLI = '<option value="">Select</option>';
			l3_acpt_CLI += '<option value="Unable to process the claim as per SOP">Unable to process the claim as per SOP</option>';
			l3_acpt_CLI += '<option value="Unable to inform claim % due to internal SOP">Unable to inform claim % due to internal SOP</option>';
			l3_acpt_CLI += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_CLI);
		}else if($(this).val()=='Return issue'){
			var l3_acpt_RI = '<option value="">Select</option>';
			l3_acpt_RI += '<option value="Return not received post TAT">Return not received post TAT</option>';
			l3_acpt_RI += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_RI);
		}else if($(this).val()=='Logistic issue'){
			var l3_acpt_LI = '<option value="">Select</option>';
			l3_acpt_LI += '<option value="Courier partner behaviour issue">Courier partner behaviour issue</option>';
			l3_acpt_LI += '<option value="Pickup not attempted by TAT">Pickup not attempted by TAT</option>';
			l3_acpt_LI += '<option value="Logistic partner asking to Pickup out of businee hour">Logistic partner asking to Pickup out of businee hour</option>';
			l3_acpt_LI += '<option value="Scanning machine not carried by logistic team">Scanning machine not carried by logistic team</option>';
			l3_acpt_LI += '<option value="Scanning not done while pickup">Scanning not done while pickup</option>';
			l3_acpt_LI += '<option value="Suplier was asked to handover shipment at warehouse">Suplier was asked to handover shipment at warehouse</option>';
			l3_acpt_LI += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_LI);
		}else if($(this).val()=='Compensation Issue'){
			var l3_acpt_CSI = '<option value="">Select</option>';
			l3_acpt_CSI += '<option value="Compensation not received by TAT">Compensation not received by TAT</option>';
			l3_acpt_CSI += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_CSI);
		}else if($(this).val()=='POD Issue'){
			var l3_acpt_PI = '<option value="">Select</option>';
			l3_acpt_PI += '<option value="POD Not shared by TAT">POD Not shared by TAT</option>';
			l3_acpt_PI += '<option value="Stamp not available on POD">Stamp not available on POD</option>';
			l3_acpt_PI += '<option value="Incorrect Stampping done on POD">Incorrect Stampping done on POD</option>';
			l3_acpt_PI += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_PI);
		}else if($(this).val()=='Backend Issue'){
			var l3_acpt_BI = '<option value="">Select</option>';
			l3_acpt_BI += '<option value="Catalog is not live even post backend confirmation">Catalog is not live even post backend confirmation</option>';
			l3_acpt_BI += '<option value="Catalog price not udpated even post backend confirmation">Catalog price not udpated even post backend confirmation</option>';
			l3_acpt_BI += '<option value="Pickup not done even post backend confirmation">Pickup not done even post backend confirmation</option>';
			l3_acpt_BI += '<option value="Others">Others</option>';
			$("#ss_l3_acpt").html(l3_acpt_BI);
		}else if($(this).val()=='Lack of process knowledge'){
			var l3_acpt_LPK = '<option value="">Select</option>';
			l3_acpt_LPK += '<option value="Lack of process knowledge">Lack of process knowledge</option>';
			$("#ss_l3_acpt").html(l3_acpt_LPK);
		}else if($(this).val()=='Supplier understanding'){
			var l3_acpt_SU = '<option value="">Select</option>';
			l3_acpt_SU += '<option value="Supplier understanding">Supplier understanding</option>';
			$("#ss_l3_acpt").html(l3_acpt_SU);
		}else if($(this).val()=='App Issue'){
			var l3_acpt_AI = '<option value="">Select</option>';
			l3_acpt_AI += '<option value="App Issue">App Issue</option>';
			$("#ss_l3_acpt").html(l3_acpt_AI);
		}
	});
	
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_meesho/getTLname';
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
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
	
	$( "#case_type" ).on('change' , function(){
		var pid = this.value;
		if(pid=="") alert("Please Select Sub Case type")
		var URL='<?php echo base_url();?>qa_meesho/getSubcasetype';
		$('#sktPleaseWait').modal('show');
		$.ajax({
		   type: 'POST',    
		   url:URL,
		   data:'pid='+pid,
		   success: function(pList){
				var json_obj = $.parseJSON(pList);
				$('#sub_case_type').empty();
				$('#sub_case_type').append($('<option></option>').val('').html('-- Select --'));		
				for (var i in json_obj) $('#sub_case_type').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].description));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		  });
	  });
//////////////////////////////////////

		$("#form_audit_user").submit(function (e) {
			$('#qaformsubmit').prop('disabled',true);
		});
		
		$("#form_mgnt_user").submit(function (e) {
			$('#btnmgntSave').prop('disabled',true);
		});
		
		$("#form_agent_user").submit(function (e) {
			$('#btnagentSave').prop('disabled',true);
		});
		
///////////////////////////
});
</script>


<script type="text/javascript">

////////////////////Meesho Email/////////////////////
	function email_overall_score(){
		var a = parseInt($("#oprning_personalization").val());
		var b = parseInt($("#validation_customer_info").val());
		var c = parseInt($("#acknowledge_align_assure").val());
		var d = parseInt($("#effective_probing").val());
		var e = parseInt($("#accurate_resolution").val());
		var f = parseInt($("#manage_delay_grace").val());
		var g = parseInt($("#provide_self_help").val());
		var h = parseInt($("#used_template_correctly").val());
		var i = parseInt($("#used_necessary_custom").val());
		var j = parseInt($("#used_correct_spelling").val());
		var k = parseInt($("#crm_accuracy").val());
		var l = parseInt($("#closing_statement").val());
		//var m = parseInt($("#agent_write_brand_voice").val());
		
		if(e==-1 || h==-1 || i==-1 || k==-1){
			var tot = 0;
		}else{
			var tot = a+b+c+d+e+f+g+h+i+j+k+l;
		}
		if(!isNaN(tot)){
			document.getElementById("total_score").value= tot;
		}
		return tot;
	}
	
////////////////Meesho Inbound////////////////
	function ib_overall_score(){
		var a = parseInt($("#call_opening").val());
		var b = parseInt($("#identification").val());
		var c = parseInt($("#security_check").val());
		var d = parseInt($("#hold_procedure").val());
		var e = parseInt($("#closing_script").val());
		var f = parseInt($("#active_listening").val());
		var g = parseInt($("#effective_probing").val());
		var h = parseInt($("#accurate_resolution_process").val());
		var i = parseInt($("#politeness_courtesy").val());
		var j = parseInt($("#apology_empathy").val());
		var k = parseInt($("#enthusiasm").val());
		//var l = parseInt($("#fluency_structure").val());
		//var m = parseInt($("#mentorship_pitch").val());
		var n = parseInt($("#crm_accuracy_ib").val());
		var o = parseInt($("#addition_info").val());
		
		if(h==-1 || i==-1 || n==-1){
			var tot = 0;
		}else{
			var tot = a+b+c+d+e+f+g+h+i+j+k+n+o;
		}
		if(!isNaN(tot)){
			document.getElementById("ib_total_score").value= tot;
		}
		return tot;
	}
	
////////////////Meesho Outbound////////////////
	function supplier_support(){
		var score = 0;
		var tot_score = 0;
		var fatal_count = 0;
		
		$('.ss_point').each(function(index,element){
			var weightage = parseInt($(element).children("option:selected").attr('ss_val'));
			score = score + weightage;
		});
		tot_score = score;
		
		if(!isNaN(tot_score)){
			$('#ss_overallscore').val(tot_score+'%');
			$('#ss_prefatal').val(tot_score);
		}
		
		
		$('.fatalCount').each(function(index,element){
			var score_type = $(element).val();
			if(score_type=='No'){
				fatal_count=fatal_count+1;
			}
		});
		$('#ss_fatalcount').val(fatal_count);
	
	///////Supplier Support (new)///////////
		if($('#supplierAF1').val()=='No' || $('#supplierAF2').val()=='No' || $('#supplierAF3').val()=='No' || $('#supplierAF4').val()=='No'){
			$('.supplierAutoFail').val(0+'%');
		}else{
			if(!isNaN(tot_score)){
				$('.supplierAutoFail').val(tot_score+'%');
			}
		}	
		
	///////Supplier Support (old)///////////
		if($('#accurateresolution').val()=='No' || $('#leveragesystem').val()=='No' || $('#accurateowenship').val()=='No' || $('#crmaccuracy').val()=='No'){
			$('.ssAutoFail').val(0+'%');
		}else{
			if(!isNaN(tot_score)){
				$('.ssAutoFail').val(tot_score+'%');
			}
		}
		
	///////Supplier Support [CMB]///////////
		if($('#cmbAF1').val()=='No' || $('#cmbAF2').val()=='No' || $('#cmbAF3').val()=='No' || $('#cmbAF4').val()=='No' || $('#cmbAF5').val()=='No'){
			$('.ssCMBAutoFail').val(0+'%');
		}else{
			if(!isNaN(tot_score)){
				$('.ssCMBAutoFail').val(tot_score+'%');
			}
		}
	///////Supplier Support [Onboarding]///////////
		if($('#onbAF1').val()=='No' || $('#onbAF2').val()=='No' || $('#onbAF3').val()=='No' || $('#onbAF4').val()=='No'){
			$('.ssONBAutoFail').val(0+'%');
		}else{
			if(!isNaN(tot_score)){
				$('.ssONBAutoFail').val(tot_score+'%');
			}
		}
		
	///////Pop Shop INBOUND///////////
		if($('#popShopAF1').val()=='No' || $('#popShopAF2').val()=='No' || $('#popShopAF3').val()=='No'){
			$('.popShopFatal').val(0);
		}else{
			if(!isNaN(tot_score)){
				$('.popShopFatal').val(tot_score+'%');
			}
		}
		
	///////Pop Shop EMAIL///////////
		if($('#popShopEmailAF1').val()=='No' || $('#popShopEmailAF2').val()=='No' || $('#popShopEmailAF3').val()=='No' || $('#popShopEmailAF4').val()=='No'){
			$('.popShopEmailFatal').val(0);
		}else{
			if(!isNaN(tot_score)){
				$('.popShopEmailFatal').val(tot_score+'%');
			}
		}
		
		
	}

</script>
 
 <script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
 </script>