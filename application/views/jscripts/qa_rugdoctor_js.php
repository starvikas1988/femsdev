<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
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
	
///////////////// Rugdoctor //////////////////

	$('#greeting_caller').on('change', function(){
		overall_score();
	});
	$('#verification_confirm').on('change', function(){
		overall_score();
	});
	$('#verification_request').on('change', function(){
		overall_score();
	});
	$('#discovery_identity').on('change', function(){
		overall_score();
	});
	$('#discovery_demo').on('change', function(){
		overall_score();
	});
	$('#customer_maintain').on('change', function(){
		overall_score();
	});
	$('#customer_word').on('change', function(){
		overall_score();
	});
	$('#customer_treat').on('change', function(){
		overall_score();
	});
	$('#customer_avoid').on('change', function(){
		overall_score();
	});
	$('#customer_follow').on('change', function(){
		overall_score();
	});
	$('#customer_accurate').on('change', function(){
		overall_score();
	});
	$('#skill_demo').on('change', function(){
		overall_score();
	});
	$('#resolution_provide').on('change', function(){
		overall_score();
	});
	$('#resolution_accurate').on('change', function(){
		overall_score();
	});
	$('#resolution_resolve').on('change', function(){
		overall_score();
	});
	$('#closing_offer').on('change', function(){
		overall_score();
	});
	$('#closing_summarize').on('change', function(){
		overall_score();
	});
	$('#closing_educate').on('change', function(){
		overall_score();
	});
	$('#closing_thank').on('change', function(){
		overall_score();
	});

////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_rugdoctor/getTLname';
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
	
	function overall_score(){	
		
		var a1 = parseInt($("#greeting_caller").val());
		var a2 = parseInt($("#verification_confirm").val());
		var a3 = parseInt($("#verification_request").val());
		var a4 = parseInt($("#discovery_identity").val());
		var a5 = parseInt($("#discovery_demo").val());
		var a6 = parseInt($("#customer_maintain").val());
		var a7 = parseInt($("#customer_word").val());
		var a8 = parseInt($("#customer_treat").val());
		var a9 = parseInt($("#customer_avoid").val());
		var a10 = parseInt($("#customer_follow").val());
		var a11 = parseInt($("#customer_accurate").val());
		var a12 = parseInt($("#skill_demo").val());
		var a13 = parseInt($("#resolution_provide").val());
		var a14 = parseInt($("#resolution_accurate").val());
		var a15 = parseInt($("#resolution_resolve").val());
		var a16 = parseInt($("#closing_offer").val());
		var a17 = parseInt($("#closing_summarize").val());
		var a18 = parseInt($("#closing_educate").val());
		var a19 = parseInt($("#closing_thank").val());
		
		es = a1+a2+a3+a4+a5+a6+a7+a8+a9+a10+a11+a12+a13+a14+a15+a16+a17+a18+a19;
		ps = 42;
		
		var rdCustomerErnd = a1+a5+a6+a7+a8+a9+a10+a11+a17+a19;
		var rdCustomerPsbl = 16;
		var rdBusinessErnd = a4+a13+a14+a15+a18;
		var rdBusinessPsbl = 19;
		var rdComplianceErnd = a2+a3+a12+a16;
		var rdCompliancePsbl = 7;
						
		if(!isNaN(ps) && !isNaN(es)){
			
			document.getElementById("possible_point").value= ps;
			document.getElementById("total_score").value= es;
			
			document.getElementById("rdCustomerErnd").value= rdCustomerErnd;
			document.getElementById("rdCustomerPsbl").value= rdCustomerPsbl;
			
			document.getElementById("rdBusinessErnd").value= rdBusinessErnd;
			document.getElementById("rdBusinessPsbl").value= rdBusinessPsbl;
			
			document.getElementById("rdComplianceErnd").value= rdComplianceErnd;
			document.getElementById("rdCompliancePsbl").value= rdCompliancePsbl;
			
		
			////////////Score % calculation...................
			if(!isNaN(es/ps)){
				document.getElementById("score_percentage").value=Math.round((es/ps)*100)+"%";
				document.getElementById("rdCustomerTotal").value=Math.round((rdCustomerErnd/rdCustomerPsbl)*100)+"%";
				document.getElementById("rdBusinessTotal").value=Math.round((rdBusinessErnd/rdBusinessPsbl)*100)+"%";
				document.getElementById("rdComplianceTotal").value=Math.round((rdComplianceErnd/rdCompliancePsbl)*100)+"%";
			}else{
				 document.getElementById("score_percentage").value="0%";			 
				 document.getElementById("rdCustomerTotal").value="0%";			 
				 document.getElementById("rdBusinessTotal").value="0%";			 
				 document.getElementById("rdComplianceTotal").value="0%";			 
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