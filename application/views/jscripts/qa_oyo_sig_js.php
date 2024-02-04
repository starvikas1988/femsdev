

<link href="<?php echo base_url(); ?>assets/css/chosen.min.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>assets/js/chosen.jquery.min.js"></script>

<script>
$(document).ready(function(){
	
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_date_time").datetimepicker();
	$("#chat_date").datepicker();
	$("#review_date").datepicker();
	$("#mgnt_review_date").datepicker();
	$("#feedback_date").datepicker();
	$("#coach_date").datepicker();
	$("#agent_review_date").datepicker();
	$('#duration_length').timepicker({ timeFormat: 'HH:mm:ss' });
	
	$("#agent_id").select2();
	$("#coach_name").select2();
		 
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
	
////////Call Opening//////	
	$('#co_opening5s').on('change', function() {
		if($(this).val()=='Fail'){
			$("#dd_co_opening5s").html('<option value="Did not open the call within 5 secs">Did not open the call within 5 secs</option>').prop('disabled',false);
		}else{
			$("#dd_co_opening5s").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#co_selfintro').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_co_selfintro = ('<option value="Self-Introduction missing">Self-Introduction missing</option>');
			dd_co_selfintro += ('<option value="Oyo Branding missing">Oyo Branding missing</option>');
			dd_co_selfintro += ('<option value="Brand name was not clear">Brand name was not clear</option>');
			dd_co_selfintro += ('<option value="Opening greetings missing/Incorrect greetings">Opening greetings missing/Incorrect greetings</option>');
			dd_co_selfintro += ('<option value="No Opening">No Opening</option>');
			dd_co_selfintro += ('<option value="No Opening given with guest/PM/ground (handled tranfered call)">No Opening given with guest/PM/ground (handled tranfered call)</option>');
			$("#dd_co_selfintro").html(dd_co_selfintro).prop('disabled',false);
		}else{
			$("#dd_co_selfintro").html('').prop('disabled',true);
		}
		overall_score();
	});	
	
////////Probing//////	
	$('#prob_effect').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_prob_effect = ('<option value="Unnecessary Probing">Unnecessary Probing</option>');
			dd_prob_effect += ('<option value="Incorrect Probing">Incorrect Probing</option>');
			dd_prob_effect += ('<option value="No probing done when required">No probing done when required</option>');
			$("#dd_prob_effect").html(dd_prob_effect).prop('disabled',false);
		}else{
			$("#dd_prob_effect").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#prob_indentify').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_prob_indentify = ('<option value="Issue not identified correctly">Issue not identified correctly</option>');
			dd_prob_indentify += ('<option value="Issue not paraphrased">Issue not paraphrased</option>');
			$("#dd_prob_indentify").html(dd_prob_indentify).prop('disabled',false);
		}else{
			$("#dd_prob_indentify").html('').prop('disabled',true);
		}
		overall_score();
	});
	
////////Soft Skill & Communication//////
	$('#ss_empathy').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_ss_empathy = ('<option value="Timely apology not done">Timely apology not done</option>');
			dd_ss_empathy += ('<option value="Apology/empathy not done">Apology/empathy not done</option>');
			dd_ss_empathy += ('<option value="Apology/empathy sounded scripted">Apology/empathy sounded scripted</option>');
			$("#dd_ss_empathy").html(dd_ss_empathy).prop('disabled',false);
		}else{
			$("#dd_ss_empathy").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#ss_intonation').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_ss_intonation = ('<option value="High rate of speech">High rate of speech</option>');
			dd_ss_intonation += ('<option value="Sounding robotic & Scripted">Sounding robotic & Scripted</option>');
			dd_ss_intonation += ('<option value="Repetition by Executive">Repetition by Executive</option>');
			dd_ss_intonation += ('<option value="Lack of clarity/Explanation">Lack of clarity/Explanation</option>');
			$("#dd_ss_intonation").html(dd_ss_intonation).prop('disabled',false);
		}else{
			$("#dd_ss_intonation").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#ss_interrupt').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_ss_interrupt = ('<option value="Too many Interruptions">Too many Interruptions</option>');
			dd_ss_interrupt += ('<option value="Made the customer to repeat">Made the customer to repeat</option>');
			$("#dd_ss_interrupt").html(dd_ss_interrupt).prop('disabled',false);
		}else{
			$("#dd_ss_interrupt").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#ss_enthu').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_ss_enthu = ('<option value="Fumbling on call">Fumbling on call</option>');
			dd_ss_enthu += ('<option value="Lack of confidence">Lack of confidence</option>');
			dd_ss_enthu += ('<option value="Fillers used">Fillers used</option>');
			dd_ss_enthu += ('<option value="Less energetic on call">Less energetic on call</option>');
			$("#dd_ss_enthu").html(dd_ss_enthu).prop('disabled',false);
		}else{
			$("#dd_ss_enthu").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#ss_polite').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_ss_polite = ('<option value="Did not use power words (Please, Thank You, Perfect, Appreciate your patience, etc)">Did not use power words (Please, Thank You, Perfect, Appreciate your patience, etc)</option>');
			dd_ss_polite += ('<option value="Did not display willingness to help">Did not display willingness to help</option>');
			dd_ss_polite += ('<option value="Sounding casual on call">Sounding casual on call</option>');
			dd_ss_polite += ('<option value="Agent was  blunt/ authoritative/aggressive">Agent was  blunt/ authoritative/aggressive</option>');
			dd_ss_polite += ('<option value="Agent was Yawning on call">Agent was Yawning on call</option>');
			$("#dd_ss_polite").html(dd_ss_polite).prop('disabled',false);
		}else{
			$("#dd_ss_polite").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#ss_grammar').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_ss_grammar = ('<option value="Incorrect sentence formation/Choice of words">Incorrect sentence formation/Choice of words</option>');
			dd_ss_grammar += ('<option value="Incomplete sentence used">Incomplete sentence used</option>');
			dd_ss_grammar += ('<option value="Grammatical error on call">Grammatical error on call</option>');
			$("#dd_ss_grammar").html(dd_ss_grammar).prop('disabled',false);
		}else{
			$("#dd_ss_grammar").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#ss_guest').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_ss_guest = ('<option value="Did not acknowledge">Did not acknowledge</option>');
			dd_ss_guest += ('<option value="Delayed acknowledgment (>=5 sec)">Delayed acknowledgment (>=5 sec)</option>');
			dd_ss_guest += ('<option value="Assurance not done">Assurance not done</option>');
			$("#dd_ss_guest").html(dd_ss_guest).prop('disabled',false);
		}else{
			$("#dd_ss_guest").html('').prop('disabled',true);
		}
		overall_score();
	});
	
///////Hold & Dead Air Procedure/////
	$('#hd_permission').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_hd_permission = ('<option value="Did not seek permission">Did not seek permission</option>');
			dd_hd_permission += ('<option value="Did not mention hold duration">Did not mention hold duration</option>');
			dd_hd_permission += ('<option value="Did not mention reason">Did not mention reason</option>');
			dd_hd_permission += ('<option value="Hold procedure was applicable and agent did not use it">Hold procedure was applicable and agent did not use it</option>');
			$("#dd_hd_permission").html(dd_hd_permission).prop('disabled',false);
		}else{
			$("#dd_hd_permission").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#hd_unhold').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_hd_unhold = ('<option value="Did not thank the customer after returning from hold">Did not thank the customer after returning from hold</option>');
			dd_hd_unhold += ('<option value="Apology missing for long hold">Apology missing for long hold</option>');
			$("#dd_hd_unhold").html(dd_hd_unhold).prop('disabled',false);
		}else{
			$("#dd_hd_unhold").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#hd_took').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_hd_took = ('<option value="Did not put customer on hold post hold permission">Did not put customer on hold post hold permission</option>');
			$("#dd_hd_took").html(dd_hd_took).prop('disabled',false);
		}else{
			$("#dd_hd_took").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#hd_refresh').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_hd_refresh = ('<option value="Did not refresh Hold as per the committed time (Few min = 3 min)">Did not refresh Hold as per the committed time (Few min = 3 min)</option>');
			$("#dd_hd_refresh").html(dd_hd_refresh).prop('disabled',false);
		}else{
			$("#dd_hd_refresh").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#hd_avoid').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_hd_avoid = ('<option value="Dead Air observed more than 10 seconds">Dead Air observed more than 10 seconds');
			dd_hd_avoid += ('<option value="Dead Air observed more than 20 seconds">Dead Air observed more than 20 seconds');
			dd_hd_avoid += ('<option value="Dead Air observed more than 40 seconds">Dead Air observed more than 40 seconds');
			dd_hd_avoid += ('<option value="Dead Air observed more than 60 seconds">Dead Air observed more than 60 seconds');
			$("#dd_hd_avoid").html(dd_hd_avoid).prop('disabled',false);
		}else{
			$("#dd_hd_avoid").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#hd_legit').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_hd_legit = ('<option value="Unnecessary Hold observed more than 1 Minute">Unnecessary Hold observed more than 1 Minute</option>');
			dd_hd_legit += ('<option value="Unnecessary Hold observed more than 2 Minute">Unnecessary Hold observed more than 2 Minute</option>');
			dd_hd_legit += ('<option value="Unnecessary Hold observed more than 3 Minute">Unnecessary Hold observed more than 3 Minute</option>');
			dd_hd_legit += ('<option value="Unnecessary Hold observed more than 5 Minute">Unnecessary Hold observed more than 5 Minute</option>');
			dd_hd_legit += ('<option value="Unnecessary Hold observed more than 10 Minute">Unnecessary Hold observed more than 10 Minute</option>');
			dd_hd_legit += ('<option value="Unnecessary Hold observed more than 15 Minute">Unnecessary Hold observed more than 15 Minute</option>');
			dd_hd_legit += ('<option value="Unnecessary Hold observed more than 20 Minute">Unnecessary Hold observed more than 20 Minute</option>');
			$("#dd_hd_legit").html(dd_hd_legit).prop('disabled',false);
		}else{
			$("#dd_hd_legit").html('').prop('disabled',true);
		}
		overall_score();
	});
	
////////Resolution Fatal////////
	$('#rf_book').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rf_book = ('<option value="Incorrect Modification done">Incorrect Modification done</option>');
			dd_rf_book += ('<option value="Incomplete Modification done">Incomplete Modification done</option>');
			dd_rf_book += ('<option value="Modification done without customer consent">Modification done without customer consent</option>');
			$("#dd_rf_book").html(dd_rf_book).prop('disabled',false);
		}else{
			$("#dd_rf_book").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#rf_info').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rf_info = ('<option value="Incorrect information shared">Incorrect information shared</option>');
			dd_rf_info += ('<option value="Incomplete Information shared">Incomplete Information shared</option>');
			dd_rf_info += ('<option value="TAT not informed">TAT not informed</option>');
			dd_rf_info += ('<option value="Incorrect TAT informed">Incorrect TAT informed</option>');
			$("#dd_rf_info").html(dd_rf_info).prop('disabled',false);
		}else{
			$("#dd_rf_info").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#rf_refund').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rf_refund = ('<option value="Did not raise refund in OREO">Did not raise refund in OREO</option>');
			dd_rf_refund += ('<option value="Raised OREO with incorrect tagging">Raised OREO with incorrect tagging</option>');
			dd_rf_refund += ('<option value="Did not remove cancellation charges">Did not remove cancellation charges</option>');
			dd_rf_refund += ('<option value="Unnecessary refund/complimentary processed">Unnecessary refund/complimentary processed</option>');
			dd_rf_refund += ('<option value="Incorrect complimentary added">Incorrect complimentary added</option>');
			dd_rf_refund += ('<option value="Did not add complimentary">Did not add complimentary</option>');
			dd_rf_refund += ('<option value="Did not mark an email to concern department">Did not mark an email to concern department</option>');
			$("#dd_rf_refund").html(dd_rf_refund).prop('disabled',false);
		}else{
			$("#dd_rf_refund").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#rf_follow').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rf_follow = ('<option value="Did not do Proper follow up with PM/CM/OPS Head/Hub Head">Did not do Proper follow up with PM/CM/OPS Head/Hub Head</option>');
			dd_rf_follow += ('<option value="Did not call">Did not call</option>');
			dd_rf_follow += ('<option value="Did not call">Did not call</option>');
			$("#dd_rf_follow").html(dd_rf_follow).prop('disabled',false);
		}else{
			$("#dd_rf_follow").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#rf_czent').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rf_czent = ('<option value="Tagging not done on Czentrix">Tagging not done on Czentrix</option>');
			dd_rf_czent += ('<option value="Incorrect tagging done on Czentrix">Incorrect tagging done on Czentrix</option>');
			dd_rf_czent += ('<option value="Did not close the call within 20 sec">Did not close the call within 20 sec</option>');
			$("#dd_rf_czent").html(dd_rf_czent).prop('disabled',false);
		}else{
			$("#dd_rf_czent").html('').prop('disabled',true);
		}
		overall_score();
	});
	
//////Resolution Non-Fatal//////
	$('#rnf_closure').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rnf_closure = ('<option value="GNC call attempts within 2 hours">GNC call attempts within 2 hours</option>');
			dd_rnf_closure += ('<option value="Did not send GNC email/sms after call">Did not send GNC email/sms after call</option>');
			$("#dd_rnf_closure").html(dd_rnf_closure).prop('disabled',false);
		}else{
			$("#dd_rnf_closure").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#rnf_duplicate').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rnf_duplicate = ('<option value="Did not merge the existing tickets">Did not merge the existing tickets</option>');
			dd_rnf_duplicate += ('<option value="merged tickets with different issue category - Notes are contradictory">merged tickets with different issue category - Notes are contradictory</option>');
			$("#dd_rnf_duplicate").html(dd_rnf_duplicate).prop('disabled',false);
		}else{
			$("#dd_rnf_duplicate").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#rnf_library').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rnf_library = ('<option value="Incorrect Case library followed">Incorrect Case library followed</option>');
			dd_rnf_library += ('<option value="Did not follow Case library">Did not follow Case library</option>');
			dd_rnf_library += ('<option value="Did not fill the scenario with CL number">Did not fill the scenario with CL number</option>');
			$("#dd_rnf_library").html(dd_rnf_library).prop('disabled',false);
		}else{
			$("#dd_rnf_library").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#rnf_email').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_rnf_email = ('<option value="Did not send resolution Email to the guest">Did not send resolution Email to the guest</option>');
			dd_rnf_email += ('<option value="Incorrect/incomplete Resolution Email send to the guest">Incorrect/incomplete Resolution Email send to the guest</option>');
			dd_rnf_email += ('<option value="Grammar error in resolution email">Grammar error in resolution email</option>');
			dd_rnf_email += ('<option value="Unnecessary resolution email sent without providing the resolution">Unnecessary resolution email sent without providing the resolution</option>');
			dd_rnf_email += ('<option value="Did not send resolution email on guest ID (failed to confirm guest email ID)">Did not send resolution email on guest ID (failed to confirm guest email ID)</option>');
			$("#dd_rnf_email").html(dd_rnf_email).prop('disabled',false);
		}else{
			$("#dd_rnf_email").html('').prop('disabled',true);
		}
		overall_score();
	});
	
/////Fresh Desk Compliance & TAT Adherence- Fatal/////
	$('#fd_note').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_fd_note = ('<option value="Did not capture notes">Did not capture notes</option>');
			dd_fd_note += ('<option value="Incomplete notes captured">Incomplete notes captured</option>');
			dd_fd_note += ('<option value="Incorrect notes captured">Incorrect notes captured</option>');
			$("#dd_fd_note").html(dd_fd_note).prop('disabled',false);
		}else{
			$("#dd_fd_note").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#fd_tagging').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_fd_tagging = ('<option value="Did not work on existing ticket">Did not work on existing ticket</option>');
			dd_fd_tagging += ('<option value="Incorrect Category selected">Incorrect Category selected</option>');
			dd_fd_tagging += ('<option value="Incorrect sub category selected">Incorrect sub category selected</option>');
			dd_fd_tagging += ('<option value="Incorrect sub sub category selected">Incorrect sub sub category selected</option>');
			$("#dd_fd_tagging").html(dd_fd_tagging).prop('disabled',false);
		}else{
			$("#dd_fd_tagging").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#fd_shift').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_fd_shift = ('<option value="Proactively proposed for cancellation">Proactively proposed for cancellation</option>');
			dd_fd_shift += ('<option value="Cancelled the booking instead of shifting">Cancelled the booking instead of shifting</option>');
			dd_fd_shift += ('<option value="Cancelled CID booking without PM validation">Cancelled CID booking without PM validation</option>');
			$("#dd_fd_shift").html(dd_fd_shift).prop('disabled',false);
		}else{
			$("#dd_fd_shift").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#fd_ticket').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_fd_ticket = ('<option value="Did not update remaining fields">Did not update remaining fields</option>');
			dd_fd_ticket += ('<option value="Remaining fields Incorrectly updated">Remaining fields Incorrectly updated</option>');
			dd_fd_ticket += ('<option value="Incorrect Ticket status selected except resolved">Incorrect Ticket status selected except resolved</option>');
			$("#dd_fd_ticket").html(dd_fd_ticket).prop('disabled',false);
		}else{
			$("#dd_fd_ticket").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#fd_verify').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_fd_verify = ('<option value="Incorrect Authentication process followed">Incorrect Authentication process followed</option>');
			dd_fd_verify += ('<option value="Authentication process not followed">Authentication process not followed</option>');
			$("#dd_fd_verify").html(dd_fd_verify).prop('disabled',false);
		}else{
			$("#dd_fd_verify").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#fd_tat').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_fd_tat = ('<option value="No Call Back done">No Call Back done</option>');
			dd_fd_tat += ('<option value="Call back done beyond TAT">Call back done beyond TAT</option>');
			dd_fd_tat += ('<option value="Call back not scheduled in FD">Call back not scheduled in FD</option>');
			$("#dd_fd_tat").html(dd_fd_tat).prop('disabled',false);
		}else{
			$("#dd_fd_tat").html('').prop('disabled',true);
		}
		overall_score();
	});
	
/////Closing/////
	$('#c_pitch').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_c_pitch = ('<option value="OYO Assist (Need Help) not Pitched">OYO Assist (Need Help) not Pitched</option>');
			dd_c_pitch += ('<option value="Not effectively Pitched">Not effectively Pitched</option>');
			$("#dd_c_pitch").html(dd_c_pitch).prop('disabled',false);
		}else{
			$("#dd_c_pitch").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#c_further').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_c_further = ('<option value="Did not ask the customer for further assistance">Did not ask the customer for further assistance</option>');
			dd_c_further += ('<option value="Did not wait for customer response/acknowledgement">Did not wait for customer response/acknowledgement</option>');
			dd_c_further += ('<option value="No pause after FA statement (2 seconds)">No pause after FA statement (2 seconds)</option>');
			$("#dd_c_further").html(dd_c_further).prop('disabled',false);
		}else{
			$("#dd_c_further").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#c_gsat').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_c_gsat = ('<option value="G-Sat Survey not pitched effectively">G-Sat Survey not pitched effectively</option>');
			dd_c_gsat += ('<option value="G-Sat  Survey not pitched">G-Sat  Survey not pitched</option>');
			dd_c_gsat += ('<option value="G-Sat Solicitation done">G-Sat Solicitation done</option>');
			$("#dd_c_gsat").html(dd_c_gsat).prop('disabled',false);
		}else{
			$("#dd_c_gsat").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#c_survey').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_c_survey = ('<option value="Agent Closed the case instead of resolving">Agent Closed the case instead of resolving</option>');
			$("#dd_c_survey").html(dd_c_survey).prop('disabled',false);
		}else{
			$("#dd_c_survey").html('').prop('disabled',true);
		}
		overall_score();
	});
	$('#c_oyo').on('change', function() {
		if($(this).val()=='Fail'){
			var dd_c_oyo = ('<option value="Agent failed to thank the caller">Agent failed to thank the caller</option>');
			dd_c_oyo += ('<option value="Oyo Branding missing">Oyo Branding missing</option>');
			dd_c_oyo += ('<option value="Brand name was not clear">Brand name was not clear</option>');
			$("#dd_c_oyo").html(dd_c_oyo).prop('disabled',false);
		}else{
			$("#dd_c_oyo").html('').prop('disabled',true);
		}
		overall_score();
	});
	
});
</script>

<script>
	function overall_score(){
		var a1 = parseInt($("#co_opening5s option:selected").attr("sig_val"));
		var a2 = parseInt($("#co_selfintro option:selected").attr("sig_val"));
		var a3 = parseInt($("#prob_effect option:selected").attr("sig_val"));
		var a4 = parseInt($("#prob_indentify option:selected").attr("sig_val"));
		var a5 = parseInt($("#ss_empathy option:selected").attr("sig_val"));
		var a6 = parseInt($("#ss_intonation option:selected").attr("sig_val"));
		var a7 = parseInt($("#ss_interrupt option:selected").attr("sig_val"));
		var a8 = parseInt($("#ss_enthu option:selected").attr("sig_val"));
		var a9 = parseInt($("#ss_polite option:selected").attr("sig_val"));
		var a10 = parseInt($("#ss_grammar option:selected").attr("sig_val"));
		var a11 = parseInt($("#ss_guest option:selected").attr("sig_val"));
		var a12 = parseInt($("#hd_permission option:selected").attr("sig_val"));
		var a13 = parseInt($("#hd_unhold option:selected").attr("sig_val"));
		var a14 = parseInt($("#hd_took option:selected").attr("sig_val"));
		var a15 = parseInt($("#hd_refresh option:selected").attr("sig_val"));
		var a16 = parseInt($("#hd_avoid option:selected").attr("sig_val"));
		var a17 = parseInt($("#hd_legit option:selected").attr("sig_val"));
		var a18 = parseInt($("#rf_book option:selected").attr("sig_val"));
		var a19 = parseInt($("#rf_info option:selected").attr("sig_val"));
		var a20 = parseInt($("#rf_refund option:selected").attr("sig_val"));
		var a21 = parseInt($("#rf_follow option:selected").attr("sig_val"));
		var a22 = parseInt($("#rf_czent option:selected").attr("sig_val"));
		var a23 = parseInt($("#rnf_closure option:selected").attr("sig_val"));
		var a24 = parseInt($("#rnf_duplicate option:selected").attr("sig_val"));
		var a25 = parseInt($("#rnf_library option:selected").attr("sig_val"));
		var a26 = parseInt($("#rnf_email option:selected").attr("sig_val"));
		var a27 = parseInt($("#fd_note option:selected").attr("sig_val"));
		var a28 = parseInt($("#fd_tagging option:selected").attr("sig_val"));
		var a29 = parseInt($("#fd_shift option:selected").attr("sig_val"));
		var a30 = parseInt($("#fd_ticket option:selected").attr("sig_val"));
		var a31 = parseInt($("#fd_verify option:selected").attr("sig_val"));
		var a32 = parseInt($("#fd_tat option:selected").attr("sig_val"));
		var a33 = parseInt($("#c_pitch option:selected").attr("sig_val"));
		var a34 = parseInt($("#c_further option:selected").attr("sig_val"));
		var a35 = parseInt($("#c_gsat option:selected").attr("sig_val"));
		var a36 = parseInt($("#c_survey option:selected").attr("sig_val"));
		var a37 = parseInt($("#c_oyo option:selected").attr("sig_val"));
		
		//a15==-1 || a16==-1 || 
		
		if(a1==0 ||  a15==0 || a17==0 || a18==0 || a19==0 || a20==0 || a21==0 || a22==0 || a28==0 || a29==0 || a31==0 || a32==0 || a36==0){
			var tot_overall_score = 0;
		}else{
			var tot_overall_score = (a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+a11+a12+a13+a14+a15+a16+a17+a18+a19+a20+a21+a22+a23+a24+a25+a26+a27+a28+a29+a30+a31+a32+a33+a34+a35+a36+a37);
		}
		
		if(!isNaN(tot_overall_score)){
			document.getElementById("overallscore").value= tot_overall_score+"%";
		}
		
		if(parseInt(tot_overall_score)==100){
			document.getElementById("overall_result").value='A+';
		}else if(parseInt(tot_overall_score)>=95){
			document.getElementById("overall_result").value='A';
		}else if(parseInt(tot_overall_score)>=85){
			document.getElementById("overall_result").value='B';
		}else if(parseInt(tot_overall_score)>=75){
			document.getElementById("overall_result").value='C';
		}else if(parseInt(tot_overall_score)<=74 && parseInt(tot_overall_score)>=0){
			document.getElementById("overall_result").value='D';
		}else{
			document.getElementById("overall_result").value='';
		}
	}
</script>
 
 <script>
	$(document).ready(function(){
		
		$( "#agent_id" ).on('change' , function() {
			var aid = this.value;
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>qa_oyo_sig/getTLname';
			
			$.ajax({
				type: 'POST',    
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					var json_obj = $.parseJSON(aList);//parse JSON
					$('#tl_name').empty();
					$('#tl_name').append($('#tl_name').val(''));
						
					for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
					for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
					for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
					for (var i in json_obj) $('#tenurity').append($('#tenurity').val(json_obj[i].tenurity));
					for (var i in json_obj) $('#batch_code').append($('#batch_code').val(json_obj[i].batch_code));
					for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process));
				},
				error: function(){	
					alert('Fail!');
				}
			});
			
		});
		
		
		$("#form_audit_user").submit(function (e) {
			$('#oyosig_form_submit').prop('disabled',true);
		});
		
		
		$("#form_agent_review").submit(function (e){
			//alert();
			$('#btnAgentSave').prop('disabled',true);
		});
		
		$("#form_mgnt_user").submit(function (e){
			$('#btnMgntSave').prop('disabled',true);
		});
	
	});
	
 </script>
 
 <script>
	function sig_chat_calc(){
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		
		$('.chat_point').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('chat_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('chat_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				var weightage = parseFloat($(element).children("option:selected").attr('chat_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#srvErnScore').val(score);
		$('#srvPsblScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#chatServiceScore').val(quality_score_percent+'%');
		}
	
	/*----- Service -----*/
		if($('#srvFatal1').val()=='No'){
			$('.chatServiceAF').val(0);
		}else{
			$('.chatServiceAF').val(quality_score_percent+'%');
		}
	/*----- Escalation -----*/
		 if($('#esclFatal1').val()=='No' ){
		 	$('.chatEscalationAF').val(0);
		 }else{
			$('.chatEscalationAF').val(quality_score_percent+'%');
		}
		
	}
	
	$(document).ready(function(){
		$(document).on('change','.chat_point',function(){
			sig_chat_calc();
		});
		sig_chat_calc();
	});
 </script>

 