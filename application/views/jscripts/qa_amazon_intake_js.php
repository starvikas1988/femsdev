<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
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
	
///////////////////	
	$('#call_probing').on('change', function(){
		call_handling(x,y);
	});
	$('#call_solve').on('change', function(){
		call_handling(x,y);
	});
	$('#call_question').on('change', function(){
		call_handling(x,y);
	});
	$('#call_address').on('change', function(){
		call_handling(x,y);
	});
	$('#call_proactive').on('change', function(){
		call_handling(x,y);
	});
	$('#call_inform').on('change', function(){
		call_handling(x,y);
	});
	$('#call_csr').on('change', function(){
		call_handling(x,y);
	});
	$('#call_hold').on('change', function(){
		call_handling(x,y);
	});
	$('#call_permission').on('change', function(){
		call_handling(x,y);
	});
	$('#call_twice').on('change', function(){
		call_handling(x,y);
	});
	$('#call_listen').on('change', function(){
		call_handling(x,y);
	});
	$('#call_task').on('change', function(){
		call_handling(x,y);
	});
	$('#call_email').on('change', function(){
		call_handling(x,y);
	});
	$('#call_outbound').on('change', function(){
		call_handling(x,y);
	});
	
	$('#personal_tone').on('change', function(){
		personal_service(x,y);
	});
	$('#personal_exhibit').on('change', function(){
		personal_service(x,y);
	});
	$('#personal_conversion').on('change', function(){
		personal_service(x,y);
	});
	$('#personal_refrain').on('change', function(){
		personal_service(x,y);
	});
	$('#personal_coherent').on('change', function(){
		personal_service(x,y);
	});
	$('#personal_avoid').on('change', function(){
		personal_service(x,y);
	});
	
	$('#knowledge_ask').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_anticipate').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_focus').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_care').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_handle').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_holistic').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_item').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_confirm').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_security').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_promote').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_script').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_question').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_caller').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_survey').on('change', function(){
		knowledge(x,y);
	});
	$('#knowledge_claim').on('change', function(){
		knowledge(x,y);
	});
	
	$('#ia_eligibility').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_contact').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_clinical').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_amz').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_emergency').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_interview').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_rtw').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_call').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_provider').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_work').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_leave').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_note').on('change', function(){
		ia_specific(x,y);
	});
	$('#ia_documentation').on('change', function(){
		ia_specific(x,y);
	});

////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_amazon_intake/getTLname';
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
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
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
		if(v == 1){ // PASS
			x = +1;
			y = +1;
			return [x, y];
		}
		else if(v == 0){ // NO
			x = +1;
			y = -0;
			return [x, y];
		}
		else{
			var x=0;
			var y=0;
			return [x, y];
		}
	}
////////////////////////////////////////////////////	
	
/*---------------------------------------*/	
	$('select:not(.lm)').change(function(){
		var str1 =  call_handling().toString(); 
		var res1 = str1.split(",");
		
		var str2 =  personal_service().toString(); 
		var res2 = str2.split(",");
		
		var str3 =  knowledge().toString(); 
		var res3 = str3.split(",");
		
		var str4 =  ia_specific().toString(); 
		var res4 = str4.split(",");
	
		
		$('#earned_score').val( (parseInt(res1[0]) + parseInt(res2[0]) + parseInt(res3[0]) + parseInt(res4[0])) );
		$('#possible_score').val( (parseInt(res1[1]) + parseInt(res2[1]) + parseInt(res3[1]) + parseInt(res4[1])) );
		var overall_score	=	(((parseInt(res1[0]) + parseInt(res2[0]) + parseInt(res3[0]) + parseInt(res4[0])) * 100) / (parseInt(res1[1]) + parseInt(res2[1]) + parseInt(res3[1]) + parseInt(res4[1])));
		if(isNaN(overall_score))
		{
			overall_score	=	0;
		}
		$('#overall_score').val(overall_score.toFixed(2)+"%" );
		
	});
	
	
	function call_handling(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#call_probing").val());
		var a2 = parseInt($("#call_solve").val());
		var a3 = parseInt($("#call_question").val());
		var a4 = parseInt($("#call_address").val());
		var a5 = parseInt($("#call_proactive").val());
		var a6 = parseInt($("#call_inform").val());
		var a7 = parseInt($("#call_csr").val());
		var a8 = parseInt($("#call_hold").val());
		var a9 = parseInt($("#call_permission").val());
		var a10 = parseInt($("#call_twice").val());
		var a11 = parseInt($("#call_listen").val());
		var a12 = parseInt($("#call_task").val());
		var a13 = parseInt($("#call_email").val());
		var a14 = parseInt($("#call_outbound").val());
		
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
						
		if(!isNaN(ps) && !isNaN(es)){
			document.getElementById("call_possible_score").value= ps;
			document.getElementById("call_earned_score").value= es;
			////////////Score % calculation...................
			 if(!isNaN(es/ps)){
				document.getElementById("call_handle_score").value=((es/ps)*100).toFixed(2)+"%";
			 }
			 else{
				 document.getElementById("call_handle_score").value="0%";			 
			 }
			  var x = es;
			  var y = ps;
			 
			 return [x, y];
		}
	}
	
	function personal_service(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#personal_tone").val());
		var a2 = parseInt($("#personal_exhibit").val());
		var a3 = parseInt($("#effort_income").val());
		var a4 = parseInt($("#personal_conversion").val());
		var a5 = parseInt($("#personal_refrain").val());
		var a6 = parseInt($("#personal_coherent").val());
		var a7 = parseInt($("#effort_payment").val());
		var a8 = parseInt($("#personal_avoid").val());
		
		
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
			document.getElementById("personal_possible_score").value= ps;
			document.getElementById("personal_earned_score").value= es;
			////////////Score % calculation...................
			 if(!isNaN(es/ps)){
				document.getElementById("personal_service_score").value=((es/ps)*100).toFixed(2)+"%";
			 }
			 else{
				 document.getElementById("personal_service_score").value="0%";			 
			 }
			var x = es;
			var y = ps;
			 
			return [x, y];
		}
	}
	
	function knowledge(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#knowledge_ask").val());
		var a2 = parseInt($("#knowledge_anticipate").val());
		var a3 = parseInt($("#knowledge_focus").val());
		var a4 = parseInt($("#knowledge_care").val());
		var a5 = parseInt($("#knowledge_handle").val());
		var a6 = parseInt($("#knowledge_holistic").val());
		var a7 = parseInt($("#knowledge_item").val());
		var a8 = parseInt($("#knowledge_confirm").val());
		var a9 = parseInt($("#knowledge_security").val());
		var a10 = parseInt($("#knowledge_promote").val());
		var a11 = parseInt($("#knowledge_script").val());
		var a12 = parseInt($("#knowledge_question").val());
		var a13 = parseInt($("#knowledge_caller").val());
		var a14 = parseInt($("#knowledge_survey").val());
		var a15 = parseInt($("#knowledge_claim").val());
		
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
			document.getElementById("knowledge_possible_score").value= ps;
			document.getElementById("knowledge_earned_score").value= es;
			////////////Score % calculation...................
			 if(!isNaN(es/ps)){
				document.getElementById("knowledge_score").value=((es/ps)*100).toFixed(2)+"%";
			 }
			 else{
				 document.getElementById("knowledge_score").value="0%";			 
			 }
			var x = es;
			var y = ps;
			 
			return [x, y];
		}
	}
	
	function ia_specific(x=0,y=0){
		var ps = 0; // possible_score
		var es = 0; // overall_score
		
		var a1 = parseInt($("#ia_eligibility").val());
		var a2 = parseInt($("#ia_contact").val());
		var a3 = parseInt($("#ia_clinical").val());
		var a4 = parseInt($("#ia_amz").val());
		var a5 = parseInt($("#ia_emergency").val());
		var a6 = parseInt($("#ia_interview").val());
		var a7 = parseInt($("#ia_rtw").val());
		var a8 = parseInt($("#ia_call").val());
		var a9 = parseInt($("#ia_provider").val());
		var a10 = parseInt($("#ia_work").val());
		var a11 = parseInt($("#ia_leave").val());
		var a12 = parseInt($("#ia_note").val());
		var a13 = parseInt($("#ia_documentation").val());
		
		
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
						
		if(!isNaN(ps) && !isNaN(es)){
			document.getElementById("ia_specific_earned_score").value= ps;
			document.getElementById("ia_specific_possible_score").value= es;
			////////////Score % calculation...................
			 if(!isNaN(es/ps)){
				document.getElementById("ia_specific_score").value=((es/ps)*100).toFixed(2)+"%";
			 }
			 else{
				 document.getElementById("ia_specific_score").value="0%";			 
			 } 
			var x = es;
			var y = ps;
			 
			return [x, y];
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