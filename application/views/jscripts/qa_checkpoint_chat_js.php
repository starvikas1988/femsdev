<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
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

	$('#opening_spiel').on('change', function(){
		checkpoint_overall_score();
	});
	$('#offered_assistance').on('change', function(){
		checkpoint_overall_score();
	});
	$('#empathy').on('change', function(){
		checkpoint_overall_score();
	});
	$('#being_polite').on('change', function(){
		checkpoint_overall_score();
	});
	$('#peta').on('change', function(){
		checkpoint_overall_score();
	});
	$('#reduced_response_time').on('change', function(){
		checkpoint_overall_score();
	});
	$('#chat_flow').on('change', function(){
		checkpoint_overall_score();
	});
	$('#understanding_issue').on('change', function(){
		checkpoint_overall_score();
	});
	$('#proper_probing').on('change', function(){
		checkpoint_overall_score();
	});
	$('#accuracy').on('change', function(){
		checkpoint_overall_score();
	});
	$('#product_service_info').on('change', function(){
		checkpoint_overall_score();
	});
	$('#technical_procedures').on('change', function(){
		checkpoint_overall_score();
	});
	$('#case_logs').on('change', function(){
		checkpoint_overall_score();
	});
	$('#actions_taken').on('change', function(){
		checkpoint_overall_score();
	});
	$('#correct_grammar').on('change', function(){
		checkpoint_overall_score();
	});
	$('#proper_use_msg').on('change', function(){
		checkpoint_overall_score();
	});
	$('#cust_satisfaction').on('change', function(){
		checkpoint_overall_score();
	});
		
    function docusign_calc(){

		 alert("hi");

		var cust_score = 0;
		var busi_score = 0;
		var comp_score = 0;
		var scoreable = 0;
		var cust_scoreable = 0;
		var busi_scoreable = 0;
		var comp_scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		
		

		$('.cust_score').each(function(index,element){
			var cust_score_type = $(element).children("option:selected").attr('ds_val');
			
			if(cust_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				cust_score = cust_score + weightage;
				cust_scoreable = cust_scoreable + weightage;
			}else if(cust_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				cust_scoreable = cust_scoreable + weightage;
			}else if(cust_score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				cust_score = cust_score + weightage;
				cust_scoreable = cust_scoreable + weightage;
			}
		});

		$('.busi_score').each(function(index,element){
			var busi_score_type = $(element).children("option:selected").attr('ds_val');
			
			if(busi_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				busi_score = busi_score + weightage;
				busi_scoreable = busi_scoreable + weightage;
			}else if(busi_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				busi_scoreable = busi_scoreable + weightage;
			}else if(busi_score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				busi_score = busi_score + weightage;
				busi_scoreable = busi_scoreable + weightage;
			}
		});

		$('.comp_score').each(function(index,element){
			var comp_score_type = $(element).children("option:selected").attr('ds_val');
			
			if(comp_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				comp_score = comp_score + weightage;
				comp_scoreable = comp_scoreable + weightage;
			}else if(comp_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				comp_scoreable = comp_scoreable + weightage;
			}else if(comp_score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				comp_score = comp_score + weightage;
				comp_scoreable = comp_scoreable + weightage;
			}
		});

		var cust_quality_score_percent = ((cust_score*100)/cust_scoreable).toFixed(2);
		var busi_quality_score_percent = ((busi_score*100)/busi_scoreable).toFixed(2);
		var comp_quality_score_percent = ((comp_score*100)/comp_scoreable).toFixed(2);

		if(!isNaN(cust_quality_score_percent)){
			$('#custScore').val(cust_quality_score_percent+'%');
		}

		if(!isNaN(busi_quality_score_percent)){
			$('#busiScore').val(busi_quality_score_percent+'%');
		}

		if(!isNaN(comp_quality_score_percent)){
			$('#compScore').val(comp_quality_score_percent+'%');
		}			
	
	}
	
    docusign_calc();

    $(".cust_score").on("change",function(){
		docusign_calc();
	});

	$(".busi_score").on("change",function(){
		docusign_calc();
	});

	$(".comp_score").on("change",function(){
		docusign_calc();
	});

	docusign_calc();

////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_checkpoint_chat/getTLname';
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
				//alert("s1");
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
	function checkpoint_overall_score(){
		var a = parseInt($("#opening_spiel").val());
		var b = parseInt($("#offered_assistance").val());
		var c = parseInt($("#empathy").val());
		var d = parseInt($("#being_polite").val());
		var e = parseInt($("#peta").val());
		var f = parseInt($("#reduced_response_time").val());
		var g = parseInt($("#chat_flow").val());
		var h = parseInt($("#understanding_issue").val());
		var i = parseInt($("#proper_probing").val());
		var j = parseInt($("#accuracy").val());
		var k = parseInt($("#product_service_info").val());
		var l = parseInt($("#technical_procedures").val());
		var m = parseInt($("#case_logs").val());
		var n = parseInt($("#actions_taken").val());
		var o = parseInt($("#correct_grammar").val());
		var p = parseInt($("#proper_use_msg").val());
		var q = parseInt($("#cust_satisfaction").val());
		
		var tot = a+b+c+d+e+f+g+h+i+j+k+l+m+n+o+p+q;
		
		if(!isNaN(tot)){
			document.getElementById("checkpoint_total_score").value= ((tot/100)*100).toFixed(2)+'%';
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