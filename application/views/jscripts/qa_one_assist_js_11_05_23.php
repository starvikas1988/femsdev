
<script type="text/javascript">
/////////////////////////// One Assist [Riya - 20/01/2022] ////////////////////////////
	function one_assist_calc(){
		var score = 0;
		var scoreable = 0; 
		var quality_score_percent = 0;
		
		$('.one_assist_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('one_assist_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('one_assist_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('one_assist_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#one_assist_earned').val(score);
		$('#one_assist_possible').val(scoreable);
		
		
	////////////////////
		if($('#fatal1').val()=='No' || $('#fatal2').val()=='No' || $('#fatal3').val()=='No' || $('#fatal4').val()=='No' || $('#fatal5').val()=='No' ){
			$('#one_assist_overall_score').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#one_assist_overall_score').val(quality_score_percent+'%');
			}
		}
		
	}
		
//////////////////////////////////////////////////////////////
		
	$(document).on('change','.one_assist_point',function(){ 
		one_assist_calc();

    });
	one_assist_calc();


</script>
<script type="text/javascript">
	function mckinsey_calc(){
		var score = 0;
		var scoreable = 0; 
		var quality_score_percent = 0;
		
		$('.mckinsey_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Effective'){
			    var weightage = parseFloat($(element).children("option:selected").attr('mckinsey_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'Unacceptable'){
			    var weightage = parseFloat($(element).children("option:selected").attr('mckinsey_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('mckinsey_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#mckinsey_earned').val(score);
		$('#mckinsey_possible').val(scoreable);
		
		
	////////////////////
		if($('#fatal1').val()=='No' || $('#fatal2').val()=='No' || $('#fatal3').val()=='No' || $('#fatal4').val()=='No' || $('#fatal5').val()=='No' ){
			$('#mckinsey_overall_score').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#mckinsey_overall_score').val(quality_score_percent+'%');
			}
		}
		
	}
		
//////////////////////////////////////////////////////////////
		
	$(document).on('change','.mckinsey_point',function(){ 
		mckinsey_calc();

    });
	mckinsey_calc();


</script>


<script type="text/javascript">
	function credit_pro_calc(){
		var score = 0;
		var scoreable = 0; 
		var quality_score_percent = 0;
		
		$('.credit_pro_point').each(function(index,element){
			var score_type = $(element).val();
			if(score_type == 'Yes'){
			    var weightage = parseFloat($(element).children("option:selected").attr('credit_pro_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
			    var weightage = parseFloat($(element).children("option:selected").attr('credit_pro_val'));
			    scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
			    var weightage = parseFloat($(element).children("option:selected").attr('credit_pro_val'));
			    score = score + weightage;
			    scoreable = scoreable + weightage;
			}
		});
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#credit_pro_earned').val(score);
		$('#credit_pro_possible').val(scoreable);
		
		
	////////////////////
		if($('.fatal1').val()=='Yes'){
			$('#credit_pro_overall_score').val(0);
		}else{
			if(!isNaN(quality_score_percent)){
				$('#credit_pro_overall_score').val(quality_score_percent+'%');
			}
		}
		
	}
		
//////////////////////////////////////////////////////////////
		
	$(document).on('change','.credit_pro_point',function(){ 
		credit_pro_calc();

    });
	credit_pro_calc();


</script>


<script>
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#booking_date").datepicker();
	$("#video_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	$("#go_live_date").datepicker();
	
	
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
	
	///////////////////////From date & To Date Validation////////////
	$('#to_date').on('change', function(){
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		if(from_date>to_date){
			alert("To date cannot be earlier than from date.");
			$('#to_date').val('');
		}
		
	});	
	
	/////////////////////////////////////////////////////////////////

///////////////// Agent and TL names ///////////////////////
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_ameridial/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));	
				for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#office_id').append($('#office_id').val(json_obj[i].office_id));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
//////////////// After Submit Form Disabled //////////////////////
	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});	

	
//////////////////////////	
	$("button[type = 'submit']").click(function(event) {
		var $fileUpload = $("input[type='file']");
		if (parseInt($fileUpload.get(0).files.length) > 10) {
			alert("You are only allowed to upload a maximum of 10 files");
			event.preventDefault();
		}
	});
	
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
