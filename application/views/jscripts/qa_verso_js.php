<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#review_date").datepicker();
	$("#audit_date_time").datetimepicker();
	$("#call_date").datepicker();
	$("#call_date_time").datetimepicker();
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
	
/////////////////Verso Inbound//////////////////

	$('#call_opening').on('change', function(){
		ib_overall_score();
	});
	$('#apology_empathy').on('change', function(){
		ib_overall_score();
	});
	$('#enthusiasm').on('change', function(){
		ib_overall_score();
	});
	$('#politeness_courtesy').on('change', function(){
		ib_overall_score();
	});
	$('#fluency').on('change', function(){
		ib_overall_score();
	});
	$('#accurate_resolution').on('change', function(){
		ib_overall_score();
	});
	$('#crm_accuracy').on('change', function(){
		ib_overall_score();
	});
	$('#closing').on('change', function(){
		ib_overall_score();
	});
	$('#active_listening').on('change', function(){
		ib_overall_score();
	});
	$('#hold_protocol').on('change', function(){
		ib_overall_score();
	});	
	$('#effective_probing').on('change', function(){
		ib_overall_score();
	});	
	

////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_verso/getTLname';
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
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
/////////////////Verso Outbound (Full Call Audit)//////////////////

	$('#tag_error').on('change', function(){
		fca_overall_score();
		if($(this).val()!='0'){
			$("#tag_error_comment").prop('disabled',false);
			$("#tag_error_comment").attr('required',true);
		}else{
			$("#tag_error_comment").prop('disabled',true);
			$("#tag_error_comment").attr('required',false);
			$("#tag_error_comment").val('');
		}
	});

	$('#probing_error').on('change', function(){
		fca_overall_score();
		if($(this).val()!='0'){
			$("#probing_error_comment").prop('disabled',false);
			$("#probing_error_comment").attr('required',true);
		}else{
			$("#probing_error_comment").prop('disabled',true);
			$("#probing_error_comment").attr('required',false);
			$("#probing_error_comment").val('');
		}
	});
	$('#other_error').on('change', function(){
		fca_overall_score();
		if($(this).val()!='0'){
			$("#other_error_comment").prop('disabled',false);
			$("#other_error_comment").attr('required',true);
		}else{
			$("#other_error_comment").prop('disabled',true);
			$("#other_error_comment").attr('required',false);
			$("#other_error_comment").val('');
		}
	});

	$('#fallout').on('change', function(){
		fca_overall_score();
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
///////////////Inbound////////////////////
	function ib_overall_score(){
		var a = parseInt($("#call_opening").val());
		var b = parseInt($("#apology_empathy").val());
		var c = parseInt($("#enthusiasm").val());
		var d = parseInt($("#politeness_courtesy").val());
		var e = parseInt($("#fluency").val());
		var f = parseInt($("#accurate_resolution").val());
		var g = parseInt($("#crm_accuracy").val());
		var h = parseInt($("#closing").val());
		var i = parseInt($("#active_listening").val());
		var j = parseInt($("#hold_protocol").val());
		var k = parseInt($("#effective_probing").val());
		
		if(a==-1 || b==-1 || c==-1 || d==-1 || e==-1 || f==-1 || g==-1 || h==-1){
			var tot = 0;
		}else{
			var tot = a+b+c+d+e+f+g+h+i+j+k;
		}
		if(!isNaN(tot)){
			document.getElementById("ib_total_score").value= tot+'%';
		}
		return tot;
	}
	
///////////////Outbound(Full Call Audit)////////////////////
	function fca_overall_score(){
		//alert("oooooo");
		var a = parseInt($("#tag_error").val());
		var b = parseInt($("#probing_error").val());
		var c = parseInt($("#other_error").val());
		var d = $("#fallout").val();
		
		var e=0;
		var f=0;
		var g=0; 

		var e = parseInt($("#tag_error_comment").val());
		var f = parseInt($("#probing_error_comment").val());
		var g = parseInt($("#other_error_comment").val());
		
		if(d=='Yes'){
			var p=e+f+g;
			if(p=='NaN'){
			p=0;
			}
			var tot = (a+b+c)-p;
		}else{
			var tot = 0;
		}
		
		if(!isNaN(tot)){
			document.getElementById("fca_total_score").value= tot;
		}
		return tot;
	}	
	

	$('#tag_error_comment').on('change', function(){
		fca_overall_score();
	});
	$('#probing_error_comment').on('change', function(){
		fca_overall_score();
	});
	$('#other_error_comment').on('change', function(){
		fca_overall_score();
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