<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker({maxDate: new Date()}); //datetimepicker
	$("#call_date_time").datetimepicker({maxDate: new Date()});
	//$("#call_date").datepicker({ minDate: 0 });
	$("#copy_received").datepicker();
	$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
	$("#from_date").datepicker({maxDate: new Date() });
	$("#to_date").datepicker({maxDate: new Date() });

	$("#mail_action_date").datepicker();
	$("#tat_replied_date").datepicker();
	$("#cycle_date").datepicker();
	$("#week_end_date").datepicker();

	$("#call_date_time").datetimepicker();
	
	
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
	// $('.auType').hide();
	
	// $('#audit_type').on('change', function(){
	// 	if($(this).val()=='Calibration'){
	// 		$('.auType').show();
	// 		$('#auditor_type').attr('required',true);
	// 		$('#auditor_type').prop('disabled',false);
	// 	}else{
	// 		$('.auType').hide();
	// 		$('#auditor_type').attr('required',false);
	// 		$('#auditor_type').prop('disabled',true);
	// 	}
	// });
});
</script>
<script>
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'mp4':
        case 'mp3':
		case 'wav':
		case 'm4a':
			$('#qaformsubmit').attr('disabled', false);
        break;
        default:
            alert('This is not an allowed file type. Please upload allowed file type like [m4a,mp4,mp3,wav]');
            this.value = '';
    }
});
</script>
<script type="text/javascript">
	///////////////// Calibration - Auditor Type ///////////////////////	
	//$('.auType').hide();
	
	if($("#audit_type").val() == "Calibration"){
		$('.auType').show();
		$('#auditor_type').attr('required',true);
		$('#auditor_type').prop('disabled',false);
	}
	
	$('#audit_type').each(function(){
		$valdet=$(this).val();
		console.log($valdet);
		if($valdet=="Calibration"){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});

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

	///////////////////hcci core/////////////////

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
			//alert(222);
			$('.auType_epi').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});
</script>
<script type="text/javascript">
	
	$('#tl_id').on('click', function(){
		alert("Can not Change TL");
		$("#tl_id").attr('disabled','disabled');
		return false;
	});
</script>

<script type="text/javascript">
	$(document).ready(function () {
	 // console.log("Hello World!");
	  var start_date	=	$("#from_date").val();
	  var end_date		=	$("#to_date").val();
	  if(start_date == '' && end_date == ''){
		  	$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	  if(end_date == ''){
	  		$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	  if(start_date == ''){
	  		$(".blains-effect").attr("disabled",true);
			$(".blains-effect").css('cursor', 'no-drop');
	  }
	});
</script>

<script type="text/javascript">
	
	function date_validation(val,type){
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		
		if(type=='E'){
		var start_date=$("#from_date").val();
		//if(val<start_date)
		if(start_date!=''){
			if(Date.parse(val) < Date.parse(start_date))
			{
				$(".end_date_error").html("To Date must be greater or equal to From Date");
				 $(".blains-effect").attr("disabled",true);
				 $(".blains-effect").css('cursor', 'no-drop');
			}
			else{
				 $(".blains-effect").attr("disabled",false);
				 $(".blains-effect").css('cursor', 'pointer');
				}

		}else{
				 $(".blains-effect").attr("disabled",true);
				 $(".blains-effect").css('cursor', 'no-drop');
		}
		
		}
		else{
			var end_date=$("#to_date").val();
		//if(val>end_date && end_date!='')
		
		if(end_date!=''){
			if(Date.parse(val) > Date.parse(end_date) && end_date!='')
		{
			$(".start_date_error").html("From  Date  must be less or equal to  To Date");
			 $(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
			
		}
		else{
			 $(".blains-effect").attr("disabled",false);
			 $(".blains-effect").css('cursor', 'pointer');
			}
		}else{
			$(".blains-effect").attr("disabled",true);
			 $(".blains-effect").css('cursor', 'no-drop');
		}
		

		}
	}
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
				
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				for (var i in json_obj) $('#site').append($('#site').val(json_obj[i].office_id));
				for (var i in json_obj) $('#tenure').append($('#tenure').val(json_obj[i].tenure+' Days'));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj){
					if($('#tl_name').val(json_obj[i].tl_name)!=''){
						console.log(json_obj[0].tl_name);
						$('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));

					}else{
						alert("Agent is not assigned any TL.Please assign one from manage user section or contact your HR/Manager");
					}
					
				}
				
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

 <script type="text/javascript">
 		function revive_rx_inbound_calc(){
		let score_park = 0;
		let scoreable_park = 0;
		let quality_score_percent_park = 0.00;
		let pass_count_park = 0;
		let fail_count_park = 0;
		let na_count_park = 0;
		let score_revive_rx_inbound_final = 0;
		let scoreable_revive_rx_inbound_final = 0;

		$('.revive_rx_inbound_point').each(function(index,element){
			let score_type_park = $(element).val();
			
			if(score_type_park == 'Pass'){
				pass_count_park = pass_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('revive_rx_inbound_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('revive_rx_inbound_max'));
				
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;

			}else if(score_type_park == 'Fail'){
				fail_count_park = fail_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('revive_rx_inbound_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('revive_rx_inbound_max'));

				//score = score + w1;
				scoreable_park = scoreable_park + w2_park;
				//scoreable = scoreable + weightage;
			}else if(score_type_park == 'NA'){
				na_count_park = na_count_park + 1;
				let w1_park = parseFloat($(element).children("option:selected").attr('revive_rx_inbound_val'));
				let w2_park = parseFloat($(element).children("option:selected").attr('revive_rx_inbound_max'));
				score_park = score_park + w1_park;
				scoreable_park = scoreable_park + w2_park;
			}
		});

		console.log(score_park);
		quality_score_percent_park = Math.round((score_park*100)/scoreable_park);

		if(quality_score_percent_park == "NaN"){
			quality_score_percent_park = (0.00).toFixed(2);
		}else{
			quality_score_percent_park = quality_score_percent_park;
		}
		
      score_revive_rx_inbound_final     = Math.round(score_park);
      scoreable_revive_rx_inbound_final = Math.round(scoreable_park);

		$('#revive_rx_inbound_earned_score').val(score_revive_rx_inbound_final);
		$('#revive_rx_inbound_possible_score').val(scoreable_revive_rx_inbound_final);
		
		if(!isNaN(quality_score_percent_park)){
			$('#revive_rx_inbound_overall_score').val(quality_score_percent_park+'%');
		}

		if($('#inbound_fatal1').val()=='Fail' || $('#inbound_fatal2').val()=='Fail'){
			//console.log($('#inbound_fatal1').val());

			quality_score_percent_park = (0.00).toFixed(2);
			$('.inboundFatal').val(quality_score_percent_park+'%');
		}else{
			$('#revive_rx_inbound_overall_score').val(quality_score_percent_park+'%');
		}
	}
	
	$(document).on('change','.revive_rx_inbound_point',function(){
		revive_rx_inbound_calc();
	});
	revive_rx_inbound_calc();
</script>

<script>
////////do_revive_rx////////////// Revive Rx ////////////////////
function do_revive_rx(){
	
		var score = 0;
		var scoreable = 0;
		var quality_score_percent = 0;
		var quality_earnedScore_percent = 0;
		var quality_possibleScore_percent = 0;
		
		$('.revive_rx_point').each(function(index,element){
			var score_type = $(element).val();
			//alert(score_type);
            if(score_type =='Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('revive_rx_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
				//alert(weightage);
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('revive_rx_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('revive_rx_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}
		});
		quality_score_percent 			= Math.round(((score*100)/scoreable));
		quality_earnedScore_percent 	= Math.round(score);
		quality_possibleScore_percent 	= Math.round(scoreable);
		
		// $('#pre_earnedScore').val(score);
		// $('#pre_possibleScore').val(scoreable);

         if(!isNaN(quality_score_percent)){
			$('#pre_overallScore').val(quality_score_percent+'%');
		}
		if(!isNaN(quality_earnedScore_percent)){
			$('#pre_earnedScore').val(quality_earnedScore_percent);
		}
		if(!isNaN(quality_possibleScore_percent)){
			$('#pre_possibleScore').val(quality_possibleScore_percent);
		}

          // For Fatal
		if($('.all_fatal1').val()=='No' || $('.all_fatal2').val()=='No'){
		    $('#pre_overallScore').val(0+'%');
		  }else{
			$('#pre_overallScore').val(quality_score_percent+'%');
		  }
 }
  
 $(document).on('change','.revive_rx_point',function(){
	do_revive_rx();
});
 do_revive_rx();

	$('#standardization_ex').on('change', function(){
	if($(this).val()=='Yes'){
		$('#standardization_exsub').attr('required',true);
		$('#standardization_exsub').val('Star Call');
	
	}else{
	
		$('#standardization_exsub').attr('required',true);
		$('#standardization_exsub').val('Normal Call');
	
	}
});	

</script>