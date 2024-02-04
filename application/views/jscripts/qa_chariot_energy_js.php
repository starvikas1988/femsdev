<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#call_date_time").datetimepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
	$(".agentName").select2();
	
///////////////////// SOP Library ////////////////////////////
	$(".addSOPLibrary").click(function(){
		$("#addSOPLibraryModel").modal('show');
	});
	
	$('#docu_upl').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'doc':
			case 'docx':
			case 'xls':
			case 'xlsx':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
/////////////////////////////////////////////////////////////	
	
	
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
});
</script>

<script type="text/javascript">
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function(){
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_metropolis/getTLname';
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
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
</script>

<script>

$( "#client_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Client ID")
		var URL='<?php echo base_url();?>Qa_agent_coaching/get_client';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){ 
				var json_obj = $.parseJSON(aList); 
				
					 $('#agent_id_process').empty();
				     $('#agent_id_process').append("<option value=''>--Select--</option>"); 
				for(i=0; i < json_obj.length;i++){
					 var newoption = '<option value='+ json_obj[i].id +'>'+ json_obj[i].name+' - '+json_obj[i].office_id +'</option>';
					 $('#agent_id_process').append(newoption);
				}
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
				$('#sktPleaseWait').modal('hide');
			}
		});
	});

	
	$( "#agent_id_process" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_metropolis/getTLname';
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
				for (var i in json_obj) $('#process_id').append($('#process_id').val(json_obj[i].process_id));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
				
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
</script>

<!--Use For Programing-->


	<script>
	function do_chariot(){
	    var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var parameter_count = 0;
		
		
		$('.chariot_point').each(function(index,element){
			var weightage1 = parseInt($(element).children("option:selected").attr('chariot_val'));
			var weightage2 = parseInt($(element).children("option:selected").attr('chariot_possible'));	
				
				score = score + weightage1;
				scoreable = scoreable + weightage2;
		});
		//alert(score);
		//alert(scoreable);
		quality_score_percent = ((score*100)/scoreable).toFixed(2);
		
		$('#chariotEarned').val(score);
		$('#chariotPossible').val(scoreable);
         if(!isNaN(quality_score_percent)){
				$('#chariot_energy_orlscore').val(quality_score_percent+'%');
			}

      if($('#auto_fail').val()=='Fail'){
			$('#chariot_energy_orlscore').val(0+'%');
		  }else{
			$('#chariot_energy_orlscore').val(quality_score_percent+'%');
		  }

 }

   $(document).on('change','.chariot_point',function(){
	   //alert("hi");
		do_chariot();
		myFunction();
   });	
   do_chariot();
	</script>

	<script type="text/javascript">
	//////////////////////score_grade////////////	
 
  function myFunction() {
  //var x = document.getElementById("chariot_energy_orlscore").value;
  var chariot_energy_orlscore = $("#chariot_energy_orlscore").val();
	
	console.log(chariot_energy_orlscore)

   if (chariot_energy_orlscore <= '100%' || chariot_energy_orlscore >='90%') {
    score_grade = "Excellent";
  } else if (chariot_energy_orlscore <= "89%" || chariot_energy_orlscore >= '80%') {
    score_grade = "Average";
  } else if (chariot_energy_orlscore <= "79%" || chariot_energy_orlscore >= '60%') {
    score_grade = "Needs Improvement";
  } else {
    score_grade = "Unsatisfactory";
  }
  $("#score_grade").val(score_grade);
}


	</script>

	<script>
//////////////// Freedom Service ///////////////////////
	function do_freedom_service(){
		var score=0;
		$('.freedom_point1').each(function(index,element){
			var freedom = parseFloat($(element).children("option:selected").attr('freedom_val'));
			score = score + freedom;
			//alert(score);
		});
		if(!isNaN(score)){
			$('#freedom_orlscore').val(score+'%');
		}
		if($('#freedomFA1').val()=='No' || $('#freedomFA2').val()=='No'){
			$('.ovrlFAT').val(0);
		}else{
			$('.ovrlFAT').val(quality_score_percent+'%');
		}

	}

	$(document).on('change','.freedom_point1',function(){
		do_freedom_service();
	});
	do_freedom_service();

	</script>