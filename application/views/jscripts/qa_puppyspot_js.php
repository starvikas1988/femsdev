<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#audit_time").timepicker({timeFormat : 'HH:mm:ss' });
	$("#caller_date").datepicker();
	$("#call_date").datepicker();
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
	
/////////////////PuppySpot PA//////////////////

	$('#correct_greeting_pa').on('change', function(){
		pa_overall_score();
	});
	$('#customer_greeting_pa').on('change', function(){
		pa_overall_score();
	});
	$('#rapport_greeting_pa').on('change', function(){
		pa_overall_score();
	});
	$('#website_greeting_pa').on('change', function(){
		pa_overall_score();
	});
	$('#puppy_greeting_pa').on('change', function(){
		pa_overall_score();
	});
	$('#excitement_sale_pa').on('change', function(){
		pa_overall_score();
	});
	$('#objection_sale_pa').on('change', function(){
		pa_overall_score();
	});
	$('#silence_sale_pa').on('change', function(){
		pa_overall_score();
	});
	$('#professional_sale_pa').on('change', function(){
		pa_overall_score();
	});
	$('#sound_sale_pa').on('change', function(){
		pa_overall_score();
	});
	$('#listening_sale_pa').on('change', function(){
		pa_overall_score();
	});
	$('#transfer_closing_pa').on('change', function(){
		pa_overall_score();
	});
	$('#cost_closing_pa').on('change', function(){
		pa_overall_score();
	});
	$('#sales_closing_pa').on('change', function(){
		pa_overall_score();
	});
	$('#travel_closing_pa').on('change', function(){
		pa_overall_score();
	});
	$('#screening_closing_pa').on('change', function(){
		pa_overall_score();
	});
	$('#step_closing_pa').on('change', function(){
		pa_overall_score();
	});
	$('#contact_notation_pa').on('change', function(){
		pa_overall_score();
	});
		
/////////////////////PuppySpot PC/////////////////////	
	
	$('#pc_correct_greeting').on('change', function(){
		pc_overall_score();
	});
	$('#pc_customer_greeting').on('change', function(){
		pc_overall_score();
	});
	$('#pc_reached_greeting').on('change', function(){
		pc_overall_score();
	});
	$('#pc_rapport_greeting').on('change', function(){
		pc_overall_score();
	});
	$('#pc_website_handle').on('change', function(){
		pc_overall_score();
	});
	$('#pc_choice_handle').on('change', function(){
		pc_overall_score();
	});
	$('#pc_excitement_sales').on('change', function(){
		pc_overall_score();
	});
	$('#pc_objection_sales').on('change', function(){
		pc_overall_score();
	});
	$('#pc_call_skill').on('change', function(){
		pc_overall_score();
	});
	$('#pc_professional_skill').on('change', function(){
		pc_overall_score();
	});
	$('#pc_clear_skill').on('change', function(){
		pc_overall_score();
	});
	$('#pc_listening_skill').on('change', function(){
		pc_overall_score();
	});
	$('#pc_sales_closing').on('change', function(){
		pc_overall_score();
	});
	$('#pc_cost_closing').on('change', function(){
		pc_overall_score();
	});
	$('#pc_travel_closing').on('change', function(){
		pc_overall_score();
	});
	$('#pc_screening_closing').on('change', function(){
		pc_overall_score();
	});
	$('#pc_pup_closing').on('change', function(){
		pc_overall_score();
	});
	$('#pc_vca_closing').on('change', function(){
		pc_overall_score();
	});
	$('#pc_pcdefine_closing').on('change', function(){
		pc_overall_score();
	});
	$('#pc_contact_notation').on('change', function(){
		pc_overall_score();
	});
	

////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_puppyspot/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty().append($('#tl_name').val(''));	
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
	
/////////////////PuppySpot PC//////////////////

	
	
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
///////////////PuppySpot PA////////////////////
	function pa_overall_score(){
		var a = parseInt($("#correct_greeting_pa").val());
		var b = parseInt($("#customer_greeting_pa").val());
		var c = parseInt($("#rapport_greeting_pa").val());
		var d = parseInt($("#website_greeting_pa").val());
		var e = parseInt($("#puppy_greeting_pa").val());
		var f = parseInt($("#excitement_sale_pa").val());
		var g = parseInt($("#objection_sale_pa").val());
		var h = parseInt($("#silence_sale_pa").val());
		var i = parseInt($("#professional_sale_pa").val());
		var j = parseInt($("#sound_sale_pa").val());
		var k = parseInt($("#listening_sale_pa").val());
		var l = parseInt($("#transfer_closing_pa").val());
		var m = parseInt($("#cost_closing_pa").val());
		var n = parseInt($("#sales_closing_pa").val());
		var o = parseInt($("#travel_closing_pa").val());
		var p = parseInt($("#screening_closing_pa").val());
		var q = parseInt($("#step_closing_pa").val());
		var r = parseInt($("#contact_notation_pa").val());
		
		var tot = a+b+c+d+e+f+g+h+i+j+k+l+m+n+o+p+q+r;
		
		if(!isNaN(tot)){
			document.getElementById("pa_total_score").value= tot+'%';
		}
		return tot;
	}
	
///////////////PuppySpot PC////////////////////
	function pc_overall_score(){
		var a = parseInt($("#pc_correct_greeting").val());
		var b = parseInt($("#pc_customer_greeting").val());
		var c = parseInt($("#pc_reached_greeting").val());
		var d = parseInt($("#pc_rapport_greeting").val());
		var e = parseInt($("#pc_website_handle").val());
		var f = parseInt($("#pc_choice_handle").val());
		var g = parseInt($("#pc_excitement_sales").val());
		var h = parseInt($("#pc_objection_sales").val());
		var i = parseInt($("#pc_call_skill").val());
		var j = parseInt($("#pc_professional_skill").val());
		var k = parseInt($("#pc_clear_skill").val());
		var l = parseInt($("#pc_listening_skill").val());
		var m = parseInt($("#pc_sales_closing").val());
		var n = parseInt($("#pc_cost_closing").val());
		var o = parseInt($("#pc_travel_closing").val());
		var p = parseInt($("#pc_screening_closing").val());
		var q = parseInt($("#pc_pup_closing").val());
		var r = parseInt($("#pc_vca_closing").val());
		var s = parseInt($("#pc_pcdefine_closing").val());
		var t = parseInt($("#pc_contact_notation").val());
		
		var tot = a+b+c+d+e+f+g+h+i+j+k+l+m+n+o+p+q+r+s+t;
		
		if(!isNaN(tot)){
			document.getElementById("pc_total_score").value= tot+'%';
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