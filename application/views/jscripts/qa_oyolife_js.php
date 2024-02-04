<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date_time").datetimepicker();
	$("#call_date_time").datetimepicker();
	$("#email_date_time").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$('#call_duration').timepicker({ timeFormat: 'HH:mm:ss' });
	
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
	
	
/////////////////OYO LIFE Inbound & Outbound///////////////////

	$('#welcome_customer').on('change', function(){
		if($(this).val()=='5'){
			$('#wc_reason').val('N/A');
			$('#wc_reason').prop("disabled", true);
		}else{
			$('#wc_reason').val('');
			$('#wc_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#know_customer').on('change', function(){
		if($(this).val()=='5'){
			$('#kyc_reason').val('N/A');
			$('#kyc_reason').prop("disabled", true);
		}else{
			$('#kyc_reason').val('');
			$('#kyc_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#effective_communication').on('change', function(){
		if($(this).val()=='10'){
			$('#ec_reason').val('N/A');
			$('#ec_reason').prop("disabled", true);
		}else{
			$('#ec_reason').val('');
			$('#ec_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#building_rapport').on('change', function(){
		if($(this).val()=='15'){
			$('#br_reason').val('N/A');
			$('#br_reason').prop("disabled", true);
		}else{
			$('#br_reason').val('');
			$('#br_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#maintain_courtesy').on('change', function(){
		if($(this).val()=='10'){
			$('#mc_reason').val('N/A');
			$('#mc_reason').prop("disabled", true);
		}else{
			$('#mc_reason').val('');
			$('#mc_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#probing_assistance').on('change', function(){
		if($(this).val()=='10'){
			$('#pa_reason').val('N/A');
			$('#pa_reason').prop("disabled", true);
		}else{
			$('#pa_reason').val('');
			$('#pa_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#significance_info').on('change', function(){
		if($(this).val()=='20'){
			$('#si_reason').val('N/A');
			$('#si_reason').prop("disabled", true);
		}else{
			$('#si_reason').val('');
			$('#si_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#action_solution').on('change', function(){
		if($(this).val()=='15'){
			$('#as_reason').val('N/A');
			$('#as_reason').prop("disabled", true);
		}else{
			$('#as_reason').val('');
			$('#as_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#proper_docu').on('change', function(){
		if($(this).val()=='10'){
			$('#pd_reason').val('N/A');
			$('#pd_reason').prop("disabled", true);
		}else{
			$('#pd_reason').val('');
			$('#pd_reason').prop("disabled", false);
		}
		overall_score();
	});
	$('#zero_tolerance,#fu_zero_tolerance').on('change', function(){
		if($(this).val()=='N/A'){
			$('#ztp_reason').val('N/A');
			$('#ztp_reason').prop("disabled", true);
		}else{
			$('#ztp_reason').val('');
			$('#ztp_reason').prop("disabled", false);
		}
		overall_score();
	});
	
	
/////////////////OYO LIFE Follow Up///////////////////

	$('#opening').on('change', function(){
		if($(this).val()=='15'){
			$('#opening_reason').val('N/A');
			$('#opening_reason').prop("disabled", true);
		}else{
			$('#opening_reason').val('');
			$('#opening_reason').prop("disabled", false);
		}
		followup_overall_score();
	});
	$('#product').on('change', function(){
		if($(this).val()=='15'){
			$('#product_reason').val('N/A');
			$('#product_reason').prop("disabled", true);
		}else{
			$('#product_reason').val('');
			$('#product_reason').prop("disabled", false);
		}
		followup_overall_score();
	});
	$('#rebuttals').on('change', function(){
		if($(this).val()=='25'){
			$('#rebuttals_reason').val('N/A');
			$('#rebuttals_reason').prop("disabled", true);
		}else{
			$('#rebuttals_reason').val('');
			$('#rebuttals_reason').prop("disabled", false);
		}
		followup_overall_score();
	});
	$('#sales_effort').on('change', function(){
		if($(this).val()=='20'){
			$('#sales_effort_reason').val('N/A');
			$('#sales_effort_reason').prop("disabled", true);
		}else{
			$('#sales_effort_reason').val('');
			$('#sales_effort_reason').prop("disabled", false);
		}
		followup_overall_score();
	});
	$('#closing').on('change', function(){
		if($(this).val()=='10'){
			$('#closing_reason').val('N/A');
			$('#closing_reason').prop("disabled", true);
		}else{
			$('#closing_reason').val('');
			$('#closing_reason').prop("disabled", false);
		}
		followup_overall_score();
	});
	$('#compliance').on('change', function(){
		if($(this).val()=='15'){
			$('#compliance_reason').val('N/A');
			$('#compliance_reason').prop("disabled", true);
		}else{
			$('#compliance_reason').val('');
			$('#compliance_reason').prop("disabled", false);
		}
		followup_overall_score();
	});
	$('#fu_zero_tolerance').on('change', function(){
		followup_overall_score();
	});
	
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_oyo_life/getTLname';
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

		$("#form_audit_user").submit(function(e){
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
///////////////Inbound/Outbound////////////////////
	function overall_score(){
		var a = parseInt($("#welcome_customer").val());
		var b = parseInt($("#know_customer").val());
		var c = parseInt($("#effective_communication").val());
		var d = parseInt($("#building_rapport").val());
		var e = parseInt($("#maintain_courtesy").val());
		var f = parseInt($("#probing_assistance").val());
		var g = parseInt($("#significance_info").val());
		var h = parseInt($("#action_solution").val());
		var i = parseInt($("#proper_docu").val());
		var j = $("#zero_tolerance").val();
		
		if(f==-1 || g==-1 || h==-1 || j=='ZTP'){
			var tot = 0;
		}else{
			var tot = a+b+c+d+e+f+g+h+i;
		}
		if(!isNaN(tot)){
			document.getElementById("total_score").value= tot+'%';
		}
		return tot;
	}
	
///////////////Follow Up////////////////////
	function followup_overall_score(){
		var a = parseInt($("#opening").val());
		var b = parseInt($("#product").val());
		var c = parseInt($("#rebuttals").val());
		var d = parseInt($("#sales_effort").val());
		var e = parseInt($("#closing").val());
		var f = parseInt($("#compliance").val());
		var j = $("#fu_zero_tolerance").val();
		
		if(b==-1 || c==-1 || d==-1 || j=='ZTP'){
			var tot = 0;
		}else{
			var tot = a+b+c+d+e+f;
		}
		if(!isNaN(tot)){
			document.getElementById("fu_total_score").value= tot+'%';
		}
		return tot;
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