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
<script>
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

<script>
		$('#standardization_ex').on('change', function(){
		if($(this).val()=='Yes'){
			$('#standardization_exsub').attr('required',true);
			$('#standardization_exsub').val('Star Call');
		
		}else{
		
			$('#standardization_exsub').attr('required',true);
			$('#standardization_exsub').val('Normal Call');
		
		}
	});	

	window.onload = function(){
		function tag_yes(){
			return ['1', '2', '3', '>=4']
		}
		function tag_no(){
			return ['NA']
		}
		function tag_select(){
			return['Select']
		}

		//Function to evaluate score
		const evaluate_score = () => {
			let total_score = 0
			document.querySelectorAll(".error_score").forEach( single => {
				//console.log(single.value)
				let error_score = single.value
				if(error_score != "" && error_score != NaN && error_score != null){
					total_score += parseInt(error_score)
				}
			})
			document.getElementById("pre_overallScore").value = parseFloat(total_score).toFixed(2)
		}
		document.getElementById("tag_error").addEventListener("change", (event) => {
			let tag_options = []
			if(event.target.value == "0"){
				tag_options = tag_select()
			}
			if(event.target.value == "Yes"){
				document.getElementById("tag_error_count").removeAttribute("disabled")
				tag_options = tag_yes()
				let options_text = `<option value="">SELECT</option>`
				for(let index = 0; index < tag_options.length; index++){
					let opt_value = 0
					if(event.target.value == "Yes"){
						if(index == 0){
							opt_value = 15
						}else if(index == 1){
							opt_value = 10
						}else if(index == 2){
							opt_value = 5
						}else{
							opt_value = 0
						}
					}
					options_text += `<option value="${opt_value}">${tag_options[index]}</option>`
				}
				document.getElementById("tag_error_count").innerHTML = options_text
			}else if(event.target.value == "No"){

				document.getElementById("tag_error_count").removeAttribute("disabled")
				tag_options = tag_no()
				let options_text = `<option value=30>NA</option>`
				document.getElementById("tag_error_count").innerHTML = options_text
				document.getElementById("tag_error_score").value = 30
			    evaluate_score()
			}else{
				document.getElementById("tag_error_count").setAttribute("disabled", true)
			}
		})
		document.getElementById("tag_error_count").addEventListener("change", (event) => {
			document.getElementById("tag_error_score").value = event.target.value
			evaluate_score()
		})

		/////////////////////////////////////////////////
		document.getElementById("probe_error").addEventListener("change", (eventProbe) => {
			let tag_optionsprobe = []
			if(event.target.value == "0"){
				tag_options = tag_select()
			}
			if(event.target.value == "Yes"){
				document.getElementById("probing_error_cnt").removeAttribute("disabled")
				tag_optionsprobe = tag_yes()
				let options_text_probe = `<option value="">SELECT</option>`
				for(let indexProbe = 0; indexProbe < tag_optionsprobe.length; indexProbe++){
					let opt_value = 0
					if(eventProbe.target.value == "Yes"){
						if(indexProbe == 0){
							opt_value = 15
						}else if(indexProbe == 1){
							opt_value = 10
						}else if(indexProbe == 2){
							opt_value = 5
						}else{
							opt_value = 0
						}
					}
					options_text_probe += `<option value="${opt_value}">${tag_optionsprobe[indexProbe]}</option>`
				}
				document.getElementById("probing_error_cnt").innerHTML = options_text_probe
			}else if(event.target.value == "No"){
				document.getElementById("probing_error_cnt").removeAttribute("disabled")
				tag_optionsprobe = tag_no()
				let options_text = `<option value=30>NA</option>`
				document.getElementById("probing_error_cnt").innerHTML = options_text
				document.getElementById("probe_error_score").value = 30
			    evaluate_score()
			}else{
				document.getElementById("probing_error_cnt").setAttribute("disabled", true)
			}
		})
		document.getElementById("probing_error_cnt").addEventListener("change", (eventProbe) => {
			document.getElementById("probe_error_score").value = eventProbe.target.value
			evaluate_score()
		})
	////////////////////////////////////////////////////////////////////////
	
		document.getElementById("other_error").addEventListener("change", (event) => {
			let tag_options = []
			if(event.target.value == "0"){
				tag_options = tag_select()
			}

			if(event.target.value == "Yes"){
				document.getElementById("any_other_error_cnt").removeAttribute("disabled")
				tag_options = tag_yes()
				let options_text = `<option value="">SELECT</option>`
				for(let index = 0; index < tag_options.length; index++){
					let opt_value = 0
					if(event.target.value == "Yes"){
						if(index == 0){
							opt_value = 20
						}else if(index == 1){
							opt_value = 15
						}else if(index == 2){
							opt_value = 10
						}else{
							opt_value = 0
						}
					}
					options_text += `<option value="${opt_value}">${tag_options[index]}</option>`
				}
				document.getElementById("any_other_error_cnt").innerHTML = options_text
			}else if(event.target.value == "No"){
				document.getElementById("any_other_error_cnt").removeAttribute("disabled")
				tag_options = tag_no()
				let options_text = `<option value=30>NA</option>`
				document.getElementById("any_other_error_cnt").innerHTML = options_text
				document.getElementById("any_other_error_score").value = 40
			    evaluate_score()
			}else{
				document.getElementById("any_other_error_cnt").setAttribute("disabled", true)
			}
		})
		document.getElementById("any_other_error_cnt").addEventListener("change", (event) => {
			document.getElementById("any_other_error_score").value = event.target.value
			evaluate_score()
		})
		document.getElementById("fallout_error").addEventListener("change", (event) => {
			if(event.target.value == "Yes"){
				document.getElementById("pre_overallScore").value = "0"
			}else if(event.target.value == "No"){
				evaluate_score()
			}
		})
	}

	
	
</script>