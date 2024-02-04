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

	$('#greetings_closing').on('change', function(){
		checkpoint_overall_score();
	});
	$('#identify_reason_chatting').on('change', function(){
		checkpoint_overall_score();
	});
	$('#made_customer_feel').on('change', function(){
		checkpoint_overall_score();
	});
	$('#customers_multiple_concerns').on('change', function(){
		checkpoint_overall_score();
	});
	$('#customer_more_concern').on('change', function(){
		checkpoint_overall_score();
	});
	$('#dead_air').on('change', function(){
		checkpoint_overall_score();
	});
	$('#correct_information').on('change', function(){
		checkpoint_overall_score();
	});
	$('#probing_assist').on('change', function(){
		checkpoint_overall_score();
	});
	$('#probing_tag').on('change', function(){
		checkpoint_overall_score();
	});
	$('#appropriate_instruction').on('change', function(){
		checkpoint_overall_score();
	});
	$('#documents_chat').on('change', function(){
		checkpoint_overall_score();
	});
	$('#tags_zendesk').on('change', function(){
		checkpoint_overall_score();
	});
	/* $('#help_customer').on('change', function(){
		checkpoint_overall_score();
	}); */
	$('#further_assistance').on('change', function(){
		checkpoint_overall_score();
	});

	function docusign_calc(){

		// alert("hi");

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
		var URL='<?php echo base_url();?>qa_checkpoint/getTLname';
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
		var a = parseInt($("#greetings_closing").val());
		var b = parseInt($("#identify_reason_chatting").val());
		var c = parseInt($("#made_customer_feel").val());
		var d = parseInt($("#customers_multiple_concerns").val());
		if($("#customer_more_concern").val() == '1.1')
		{
			var e = parseInt(0);
		}
		else
		{
			var e = parseInt($("#customer_more_concern").val());
		}
		var f = parseInt($("#dead_air").val());
		var g = parseInt($("#correct_information").val());
		var h = parseInt($("#probing_assist").val());
		var i = parseInt($("#probing_tag").val());
		var j = parseInt($("#appropriate_instruction").val());
		var k = parseInt($("#documents_chat").val());
		var l = parseInt($("#tags_zendesk").val());
		//var m = parseInt($("#help_customer").val());
		var n = parseInt($("#further_assistance").val());
		
		var tot = a+b+c+d+e+f+g+h+i+j+k+l+n;
		
		if(!isNaN(tot)){
			if($("#customer_more_concern").val() == '1.1'){
				document.getElementById("checkpoint_total_score").value= ((tot/28)*100).toFixed(2)+'%';
			}else{
				document.getElementById("checkpoint_total_score").value= ((tot/29)*100).toFixed(2)+'%';
			}
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