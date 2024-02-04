<script type="text/javascript">

function docusign_calc(){
		var score = 0;
		var scoreable = 200;
		var score_ssll=0;
		var quality_score_percent = 0;
		var score_type=0;
		var weightage=0;

		$('.serv').each(function(index,element){
			score_type = $(element).val();
			
			if(score_type == 'Fail' || score_type == 'Will issue' || score_type == 'Both-s+w'){
				score = score + 0;
			}else if(score_type == 'Skill Issue'){
				weightage = parseFloat($(element).children("option:selected").attr('valnum_epi'));
				score = score - weightage;
			}else if(score_type == 'Branding' || score_type == 'Self introduced'){
				weightage = parseFloat($(element).children("option:selected").attr('valnum_epi'));
				score = score - (weightage/2);
			}else{
				weightage = parseFloat($(element).children("option:selected").attr('valnum_epi'));
				score = score + weightage;
			}
		});

		$('.ssll').each(function(index,element){
			score_type = $(element).val();
			if(score_type == 'Fail' || score_type == 'Will issue' || score_type == 'Both-s+w'){
				score_ssll = score_ssll + 0;
			}else if(score_type == 'Skill Issue'){
				weightage = parseFloat($(element).children("option:selected").attr('valnum_epi'));
				score_ssll = score_ssll - weightage;
			}else if(score_type == 'Branding' || score_type == 'Self introduced'){
				weightage = parseFloat($(element).children("option:selected").attr('valnum_epi'));
				score_ssll = score_ssll - (weightage/2);
			}else{
				weightage = parseFloat($(element).children("option:selected").attr('valnum_epi'));
				score_ssll = score_ssll + weightage;
			}
		});

		var total_score=score+score_ssll;
		quality_score_percent = ((total_score*100)/scoreable).toFixed(2);
		
		$('#serviceScore').val(score);
		$('#softskillScore').val(score_ssll);

		if(quality_score_percent==100){
			$('#overallResult').val('A+');
		}else if(quality_score_percent<100 && quality_score_percent>95){
			$('#overallResult').val('A');
		}else if(quality_score_percent<=95 && quality_score_percent>85){
			$('#overallResult').val('B');
		}else if(quality_score_percent<=85 && quality_score_percent>75){
			$('#overallResult').val('C');
		}else if(quality_score_percent<=75 && quality_score_percent>=0){
			$('#overallResult').val('D');
		}

		// $('#earnedScore').val(total_score);
		// $('#possibleScore').val(scoreable);
		
		if(!isNaN(quality_score_percent)){
			$('#overallScore').val(quality_score_percent+'%');
		}
	
	
		if($('#o_fatal1').val()=='Yes'){
			$('.dsAutoFail').val(0);
		}else{
			$('.dsAutoFail').val(quality_score_percent+'%');
		}
	
	}
	
docusign_calc();
</script>
 
 <script>
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });

	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	
///////////////// Calibration - Auditor Type ///////////////////////	
	$('#audit_type').each(function(){
		$valdet=$(this).val();
		if($valdet=="Calibration"){
			$('.auType_epi').show();
		}else{
			$('.auType_epi').hide();
		}
	});

	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType_epi').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType_epi').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});	

	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});
	
	$(".points_epi").on("change",function(){
		docusign_calc();
	});

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
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
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
