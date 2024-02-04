

<link href="<?php echo base_url(); ?>assets/css/chosen.min.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>assets/js/chosen.jquery.min.js"></script>

<script>
$(document).ready(function(){
	
////////Call Opening//////	
	$('#cl_open_5_sec').on('change', function() {
		cl_open();
	});
	$('#cl_open_self_intro').on('change', function() {
		cl_open();
	});	
	
////////Probing//////	
	$('#probing_issue_indetify').on('change', function() {
		probing_issue();
	});
	$('#probing_responce_positively').on('change', function() {
		probing_issue();
	});
	$('#probing_effective').on('change', function() {
		probing_issue();
	});
	
////////Soft Skill & Communication//////
	$('#soft_skill_apology').on('change', function() {
		soft_skill();
	});
	$('#soft_skill_voice_intonation').on('change', function() {
		soft_skill();
	});
	$('#soft_skill_active_listening').on('change', function() {
		soft_skill();
	});
	$('#soft_skill_confidence').on('change', function() {
		soft_skill();
	});
	$('#soft_skill_politeness').on('change', function() {
		soft_skill();
	});
	$('#soft_skill_grammar').on('change', function() {
		soft_skill();
	});
	$('#soft_skill_acknowledgement').on('change', function() {
		soft_skill();
	});
	
///////Hold & Dead Air Procedure/////
	$('#hold_dead_ask_permission').on('change', function() {
		hold_dead();
	});
	$('#hold_dead_unhold_procedure').on('change', function() {
		hold_dead();
	});
	$('#hold_dead_took_guest_permission').on('change', function() {
		hold_dead();
	});
	$('#hold_dead_do_not_refresh').on('change', function() {
		hold_dead();
	});
	$('#hold_dead_avoid_dead_air').on('change', function() {
		hold_dead();
	});
	
////////Resolution Fatal////////
	$('#resolution_fatal_correct_booking').on('change', function() {
		resolution_fatal();
	});
	$('#resolution_fatal_correct_information').on('change', function() {
		resolution_fatal();
	});
	$('#resolution_fatal_correct_refund').on('change', function() {
		resolution_fatal();
	});
	$('#resolution_fatal_proper_follow_up').on('change', function() {
		resolution_fatal();
	});
	$('#resolution_fatal_recon_adjustment').on('change', function() {
		resolution_fatal();
	});
	
//////Resolution Non-Fatal//////
	$('#resolution_nonfatal_gnc_closure').on('change', function() {
		resolution_nonfatal();
	});
	$('#resolution_nonfatal_duplicate_ticket').on('change', function() {
		resolution_nonfatal();
	});
	$('#resolution_nonfatal_ccb_process').on('change', function() {
		resolution_nonfatal();
	});
	$('#resolution_nonfatal_case_library').on('change', function() {
		resolution_nonfatal();
	});
	$('#resolution_nonfatal_email_to_sent').on('change', function() {
		resolution_nonfatal();
	});
	
/////Fresh Desk Compliance & TAT Adherence- Fatal/////
	$('#fresh_desk_complete_notes').on('change', function() {
		fresh_desk();
	});
	$('#fresh_desk_tagging_issue').on('change', function() {
		fresh_desk();
	});
	$('#fresh_desk_incorrect_shifting').on('change', function() {
		fresh_desk();
	});
	$('#fresh_desk_correct_ticket_status').on('change', function() {
		fresh_desk();
	});
	$('#fresh_desk_did_agent_verify').on('change', function() {
		fresh_desk();
	});
	$('#fresh_desk_agent_meet_compliant').on('change', function() {
		fresh_desk();
	});
	
/////Closing/////
	$('#closing_further_assistance').on('change', function() {
		closing();
	});
	$('#closing_done_branding').on('change', function() {
		closing();
	});
	$('#closing_gsat_survey_pitched').on('change', function() {
		closing();
	});
	$('#closing_gsat_survey_avoidance').on('change', function() {
		closing();
	});
	
});
</script>

<script>
	function cl_open(){
		var a = parseInt($("#cl_open_5_sec").val());
		var b = parseInt($("#cl_open_self_intro").val());
		var tot = a + b;
		if(!isNaN(tot)){
			document.getElementById("cl_open_overall_score").value= tot;
		}
	}
	
	function probing_issue(){
		var a = parseInt($("#probing_issue_indetify").val());
		var b = parseInt($("#probing_responce_positively").val());
		var c = parseInt($("#probing_effective").val());
		var tot = a + b + c;
		if(!isNaN(tot)){
			document.getElementById("probing_overall_score").value= tot;
		}
	}
	
	function soft_skill(){
		var a = parseInt($("#soft_skill_apology").val());
		var b = parseInt($("#soft_skill_voice_intonation").val());
		var c = parseInt($("#soft_skill_active_listening").val());
		var d = parseInt($("#soft_skill_confidence").val());
		var e = parseInt($("#soft_skill_politeness").val());
		var f = parseInt($("#soft_skill_grammar").val());
		var g = parseInt($("#soft_skill_acknowledgement").val());
		var tot = a + b + c + d + e + f + g;
		if(!isNaN(tot)){
			document.getElementById("soft_skill_overall_score").value= tot;
		}
	}
	
	function hold_dead(){
		var a = parseInt($("#hold_dead_ask_permission").val());
		var b = parseInt($("#hold_dead_unhold_procedure").val());
		var c = parseInt($("#hold_dead_took_guest_permission").val());
		var d = parseInt($("#hold_dead_do_not_refresh").val());
		var e = parseInt($("#hold_dead_avoid_dead_air").val());
		if(c==-1 || d==-1){
			var tot = 0;
		}else{
			var tot = a + b + c + d + e;
		}
		if(!isNaN(tot)){
			document.getElementById("hold_dead_overall_score").value= tot;
		}
	}

	function resolution_fatal(){
		var a = parseInt($("#resolution_fatal_correct_booking").val());
		var b = parseInt($("#resolution_fatal_correct_information").val());
		var c = parseInt($("#resolution_fatal_correct_refund").val());
		var d = parseInt($("#resolution_fatal_proper_follow_up").val());
		var e = parseInt($("#resolution_fatal_recon_adjustment").val());
		if(a==-1 || b==-1 || c==-1 || d==-1 || e==-1){
			var tot = 0;
		}else{
			var tot = a + b + c + d + e;
		}
		if(!isNaN(tot)){
			document.getElementById("resolution_fatal_overall_score").value= tot;
		}
	}
	
	function resolution_nonfatal(){
		var a = parseInt($("#resolution_nonfatal_gnc_closure").val());
		var b = parseInt($("#resolution_nonfatal_duplicate_ticket").val());
		var c = parseInt($("#resolution_nonfatal_ccb_process").val());
		var d = parseInt($("#resolution_nonfatal_case_library").val());
		var e = parseInt($("#resolution_nonfatal_email_to_sent").val());
		var tot = a + b + c + d + e;
		if(!isNaN(tot)){
			document.getElementById("resolution_nonfatal_overall_score").value= tot;
		}
	}
	
	function fresh_desk(){
		var a = parseInt($("#fresh_desk_complete_notes").val());
		var b = parseInt($("#fresh_desk_tagging_issue").val());
		var c = parseInt($("#fresh_desk_incorrect_shifting").val());
		var d = parseInt($("#fresh_desk_correct_ticket_status").val());
		var e = parseInt($("#fresh_desk_did_agent_verify").val());
		var f = parseInt($("#fresh_desk_agent_meet_compliant").val());
		if(a==-1 || b==-1 || c==-1 || d==-1 || e==-1 || f==-1){
			var tot = 0;
		}else{
			var tot = a + b + c + d + e + f;
		}
		if(!isNaN(tot)){
			document.getElementById("fresh_desk_overall_score").value= tot;
		}
	}
	
	function closing(){
		var a = parseInt($("#closing_further_assistance").val());
		var b = parseInt($("#closing_done_branding").val());
		var c = parseInt($("#closing_gsat_survey_pitched").val());
		var d = parseInt($("#closing_gsat_survey_avoidance").val());
		if(a==-1 || b==-1 || c==-1 || d==-1){
			var tot = 0;
		}else{
			var tot = a + b + c + d;
		}
		if(!isNaN(tot)){
			document.getElementById("closing_overall_score").value= tot;
		}
	}
</script> 




<script>

 $(document).ready(function(){
  
   $( "#reason_for_chat" ).on('change' , function() {
	  
	var pid = this.value;
	if(pid=="") alert("Please Select Primary Reason for chat")
	var URL='<?php echo base_url();?>feedback/getSecondaryReasonList';
  
	//alert(URL+"?pid="+pid);
	
	$.ajax({
	   type: 'POST',    
	   url:URL,
	   data:'pid='+pid,
	   success: function(pList){
		   //alert(pList);
			var json_obj = $.parseJSON(pList);//parse JSON
			
			$('#reason_for_chat_s').empty();
			$('#reason_for_chat_s').append($('<option></option>').val('').html('-- Select --'));
					
			for (var i in json_obj) $('#reason_for_chat_s').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].description));
									
		},
		error: function(){	
			alert('Fail!');
		}
		
	  });
	  
  });
 
 });
 </script>
 
 <script>
	$(document).ready(function(){
		$( "#agent_id" ).on('change' , function() {
			
			var aid = this.value;
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>feedback/getTLname';
			
			//alert(URL+"?aid="+aid);
		
			$.ajax({
				type: 'POST',    
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					
				//alert(aList);
				
				var json_obj = $.parseJSON(aList);//parse JSON
			
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));
					
				for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				
				},
				error: function(){	
					alert('Fail!');
				}
			});
			
		});
	});	
 </script>
 
<script>
///////add feedback///////
	 $('#call_date_time').bootstrapMaterialDatePicker({ format : 'MM/DD/YYYY HH:mm:s' });

</script>