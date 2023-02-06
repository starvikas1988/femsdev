<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function(){

	$("#audit_date").datepicker();
	$("#call_date").datetimepicker();
	$("#call_duration").timepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();

	$("#coaching_reason").select2();


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

	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});

	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});

	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});

	///////////////// Process Name ///////////////////////
	$( "#client_id" ).on('change' , function() {

		localStorage.setItem('client_id',this.value);
		console.log(localStorage.getItem('client_id'));
		var aid = this.value;
		if(aid=="") alert("Please Select Process")
		var URL='<?php echo base_url();?>qa_agent_coaching/processName';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#process_client').empty();
				$('#process_client').append($('#process_client').val());
				$('#process_client').append('<option value="">-Select-</option>');
				for (var i in json_obj) $('#process_client').append('<option value="'+json_obj[i].id+'">'+json_obj[i].name+'</option>');
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){
				alert('Fail!');
			}
		});
	});

	///////////////// Agent Name ///////////////////////
	$( "#process_client" ).on('change' , function() {
		var aid = this.value;
		var cid=localStorage.getItem('client_id');
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_agent_coaching/getAgentname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',
			url:URL,
			data:{aid:aid,
			cid:cid},
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#agent_id').empty();
				$('#agent_id').append($('#agent_id').val(''));
				$('#agent_id').append('<option value="">-Select-</option>');
				for (var i in json_obj) $('#agent_id').append('<option value="'+json_obj[i].id+'">'+json_obj[i].name+"-("+json_obj[i].fusion_id+")"+'</option>');
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){
				alert('Fail!');
			}
		});
	});


	///////////////// Agent and TL names ///////////////////////
	$( "#agent_id" ).on('change' , function() {
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_agent_coaching/getTlname';
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
				for (var i in json_obj) $('#dept_id').append($('#dept_id').val(json_obj[i].department_name));
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
<script>
	$(document).ready(function(){
		var len=0;
		var arr;
		var system_rca={"":"-- SELECT --","system_limitation":"System Limitation", "system_downtime":"System Downtime"};
		var ability_rca={"":"-- SELECT --","know_gap":"Knowledge Gap","comm_gap":"Communication Gap","skill":"Skill"};
		var will_rca={"":"-- SELECT --","identified_out":"Identified Outlier","behavorial_issue":"Behavorial Issue","lack_of_motive":"Lack of Motivation"};
		var health_rca={"":"-- SELECT --"};
		var cap_issue_rca={"":"-- SELECT --","attend_issue":"Attendance Issue","high_call_volume":"High Call Volume"};
		var environment_rca={"":"-- SELECT --","background_noise":"Background Noise","location":"Location"};

		var system_limit_rca={"":"-- SELECT --","override_access":"Override Access","client_acc_req":"Client Access Requirement"};
		var system_down_rca={"":"-- SELECT --","internet_issue":"Internet Issue","hard_issue":"Hardware Issue","soft_inaccess":"Tool/Software Inaccessible"};

		var ability_know_gap_rca={"":"-- SELECT --","ineffect_train":"Ineffective Training","poor_retention":"Poor Retention","poor_update_cascade":"Poor Update Cascade"};
		var ability_comm_gap_rca={"":"-- SELECT --","lang_barrier":"Language Barrier","poor_comprehension":"Poor Comprehension"};
		var ability_skill_rca={"":"-- SELECT --","poor_multi_task_sill":"Poor Multi-Tasking Skill"};

		var identified_out_rca={"":"-- SELECT --"};
		var behavorial_issue_rca={"":"-- SELECT --"};
		var lack_of_motive_rca={"":"-- SELECT --","compensation":"Compensation"};

		var attend_issue_rca={"":"-- SELECT --","lost_hours":"Lost Hours","attrition":"Attrition"};
		var high_call_volume_rca={"":"-- SELECT --"};

		var background_noise_rca={"":"-- SELECT --"};
		var location_rca={"":"-- SELECT --"};
		
		$(document).on("change", "#client_id", function(){
			if($(this).val()==42 || $(this).val()==257 || $(this).val()==124 || $(this).val()==211 || $(this).val()==40 || $(this).val()==54 || $(this).val()==221){
				$(".rca_fields").slideDown();
			}else{
				$(".rca_fields").slideUp();
			}
		});
		$(document).on("change", "#rca_level1", function(){
			if($(this).val()=="system"){
				arr=system_rca;
			}else if($(this).val()=="ability"){
				arr=ability_rca;
			}else if($(this).val()=="will"){
				arr=will_rca;
			}else if($(this).val()=="health"){
				arr=health_rca;
			}else if($(this).val()=="cap_issue"){
				arr=cap_issue_rca;
			}else if($(this).val()=="environment"){
				arr=environment_rca;
			}
			len=Object.size(arr);
			$("#rca_level2").html("");
			$("#rca_level3").html("");
			for (var key in arr) {
				var value = arr[key];
				$("#rca_level2").append("<option value='"+key+"'>"+value+"</option>");
			}
		});
		$(document).on("change", "#rca_level2", function(){
			if($(this).val()=="system_limitation"){
				arr=system_limit_rca;
			}else if($(this).val()=="system_downtime"){
				arr=system_down_rca;
			}else if($(this).val()=="know_gap"){
				arr=ability_know_gap_rca;
			}else if($(this).val()=="comm_gap"){
				arr=ability_comm_gap_rca;
			}else if($(this).val()=="skill"){
				arr=ability_skill_rca;
			}else if($(this).val()=="identified_out"){
				arr=identified_out_rca;
			}else if($(this).val()=="behavorial_issue"){
				arr=behavorial_issue_rca;
			}else if($(this).val()=="lack_of_motive"){
				arr=lack_of_motive_rca;
			}else if($(this).val()=="attend_issue"){
				arr=attend_issue_rca;
			}else if($(this).val()=="high_call_volume"){
				arr=high_call_volume_rca;
			}else if($(this).val()=="background_noise"){
				arr=background_noise_rca;
			}else if($(this).val()=="location"){
				arr=location_rca;
			}
			len=Object.size(arr);
			$("#rca_level3").html("");
			for (var key in arr) {
				var value = arr[key];
				$("#rca_level3").append("<option value='"+key+"'>"+value+"</option>");
			}
		});
		Object.size = function(arr) {
			var size = 0;
			for (var key in arr) {
				if (arr.hasOwnProperty(key)){
					size++;
				}
			}
			return size;
		};
	});
</script>
