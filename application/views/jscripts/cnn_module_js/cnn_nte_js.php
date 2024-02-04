
<script>
//start the JS Script
	
$(document).on('click','.location_search_nte_initiate',function(){

	let type = $(this).attr("value")
	$("#initiate_nte_search").attr('value',type);

	locations_ids = [];
	$('#location_id :selected').map(function(idx, elem) {
		locations_ids[idx] = $(elem).val();
	});

	if (locations_ids.length === 0) {
		alert("Please select location");

		if (type=="separate_nte") {
			$('#separate_nte #user_id_nte_issue').selectize()[0].selectize.destroy();
			$("#separate_nte #user_id_nte_issue").html(`<option value="">--Select a user--</option>`);
			$('#separate_nte #user_id_nte_issue').selectize()[0].selectize.refresh();
		}
		else {
			$("#"+type).html("No data found!");
		}
	}
	else {
		const datas = {
			"location_id": locations_ids,
			"type": type
		};

		const request_url = "<?php echo base_url('cnn_module/get_nte_initiate_details'); ?>";
		process_ajax(function(response)
		{
			if (type=="separate_nte") {
				const res = JSON.parse(response);
				let html_options = `<option value="">--Select a user--</option>`;

				$('#separate_nte #user_id_nte_issue').selectize()[0].selectize.destroy();

				$.each(res.data,function(index,element)
				{	
					html_options += `<option value="${element.id}">${element.user_name}</option>`;
				});

				$("#separate_nte #user_id_nte_issue").html(html_options);
				$('#separate_nte #user_id_nte_issue').selectize()[0].selectize;
			}
			else {
				$("#"+type).html(response);
			}
			
		},request_url, datas, 'text');
	}

});

$(document).on('click','.model_open_initiate_nte',function(){

	let type = $(this).attr("type_check");

	$("#initiate_seperate_nte").prop('disabled', false);

	if (type=="no_response") {

		$("#model_initiate_nte #user_id").val($(this).attr("user_id"));
		$("#model_initiate_nte #caf_id").val($(this).attr("caf_id"));
		$("#model_initiate_nte #type").val(type);

		$("#model_initiate_nte #main_violation option:selected, #model_initiate_nte #additional_violation option:selected").prop("selected", false);
		$('#model_initiate_nte #main_violation, #model_initiate_nte #additional_violation').multiselect('refresh');

		$("#model_initiate_nte #date_of_incident, #model_initiate_nte #comment").val("");

		$("#model_initiate_nte .before_acpt").show();
		$("#model_initiate_nte .modal-footer").show();
		$("#model_initiate_nte .after_acpt_msg").hide();
		$('#model_initiate_nte').modal('show');

	}
	else {

		let user_id = $('#separate_nte #user_id_nte_issue').find(":selected").val();
		$("#model_initiate_nte #type").val(type);

		if (user_id!="") {
			$("#model_initiate_nte #user_id").val(user_id);

			$("#model_initiate_nte #main_violation option:selected, #model_initiate_nte #additional_violation option:selected").prop("selected", false);
			$('#model_initiate_nte #main_violation, #model_initiate_nte #additional_violation').multiselect('refresh');

			$("#model_initiate_nte #date_of_incident, #model_initiate_nte #comment").val("");

			$("#model_initiate_nte .before_acpt").show();
			$("#model_initiate_nte .modal-footer").show();
			$("#model_initiate_nte .after_acpt_msg").hide();
			$('#model_initiate_nte').modal('show');
		}
		else {
			alert("Please select a user!");
		}
	}

});

$(document).on('click','.model_open_nte_initiate_cancel',function(){

	let caf_id = $(this).attr("caf_id");
	let user_id = $(this).attr("user_id");

	if (caf_id!="" && user_id!="") {
		$("#model_nte_initiate_cancel #user_id").val(user_id);
		$("#model_nte_initiate_cancel #caf_id").val(caf_id);

		$('#model_nte_initiate_cancel').modal('show');
	}
	else {
		alert("Something is wrong");
	}

});

$(document).on('click','#nte_cancel_caf',function(){

	let caf_id = $("#model_nte_initiate_cancel #caf_id").val();
	let user_id = $("#model_nte_initiate_cancel #user_id").val();

	if (caf_id!="" && user_id!="") {

		const datas = {"caf_id": caf_id, "user_id" : user_id}

		const request_url = "<?php echo base_url('cnn_module/cancel_caf_nte_initiate'); ?>";
		process_ajax(function(response)
		{
			const res = JSON.parse(response);

			if (res.error==false) {
				$('.location_search_nte_initiate').first().trigger('click');
			}
			else {
				alert("Something is wrong!");
			}
				
		},request_url, datas, 'text');

		$('#model_nte_initiate_cancel').modal('hide');
		
	}
	else {
		alert("Something is wrong");
	}

});

$(document).on('click','#model_initiate_nte #initiate_seperate_nte',function(){
	let user_id = $("#model_initiate_nte #user_id").val();
	let type = $("#model_initiate_nte #type").val();

	$("#initiate_seperate_nte").prop('disabled', true);

	if (user_id!="") {

		let date_of_incident = $("#model_initiate_nte #date_of_incident").val();
		let comment = $("#model_initiate_nte #comment").val();

		let main_violation_ids = [];
		$('#model_initiate_nte #main_violation').map(function(idx, elem) { 
			main_violation_ids[idx] = $(elem).val();
		});

		let additional_violation_ids = [];

		$('#model_initiate_nte #additional_violation').map(function(idx, elem) { 
			additional_violation_ids[idx] = $(elem).val();
		});

		if (main_violation_ids[0].length===0 || additional_violation_ids[0].length===0 || comment=="" || date_of_incident=="") {
			alert("All fields are required!");
		}
		else {

			const datas = {
				"user_id" : user_id,
				"main_violation_ids" : main_violation_ids[0],
				"additional_violation_ids" : additional_violation_ids[0],
				"date_of_incident" : date_of_incident,
				"comment" : comment,
				"type": type
			}

			if (type=="no_response") datas.caf_id = $("#model_initiate_nte #caf_id").val();

			console.log(datas);

			const request_url = "<?php echo base_url('cnn_module/submit_initiate_nte'); ?>";
			process_ajax(function(response)
			{
				const res = JSON.parse(response);

				if (res.error==false) {
					if (type=="no_response") {
				        ///Auto event tigger on html load
				        $('#model_initiate_nte').modal('hide');
				        $('.location_search_nte_initiate').first().trigger('click');
					}
					else {
			            $("#model_initiate_nte .before_acpt").hide();
			            $("#model_initiate_nte .after_acpt_msg").show();
			            $("#model_initiate_nte .modal-footer").hide();
			            $('#model_initiate_nte').modal('hide');
					}
				}
				else {
					alert("Something is wrong!");
				}
				
			},request_url, datas, 'text');
		}

	}
	else {
		alert("User ID is not selected!");
	}
});

$(document).on('click','.open_model_nte_review',function(){

	const datas = {'nte_id': $(this).attr('nte_id') }

	const request_url = "<?php echo base_url('cnn_module/nte_review_details'); ?>";
	process_ajax(function(response)
	{
		const res = JSON.parse(response);
		if (res.error==false) {

			$("#nte_review_model .modal-title").text(res.nte_data[0].user_name);

			$("#nte_review_model #nte_id").val(res.nte_data[0].id);
			$("#nte_review_model #user_id").val(res.nte_data[0].user_id);

			let main_violation_list = "";
			let additional_violation_list = "";

			let main_violation_id = res.nte_data[0].main_violation_id.split(",");
			let adl_violation_id = res.nte_data[0].adl_violation_id.split(",");
			let sel = "";

			$.each(res.mst_violation_list,function(index,element) {
				if(main_violation_id.includes(element.id)) sel = "selected";
				main_violation_list += '<option value="'+element.id+'" '+sel+'>'+element.name+'</option>';
				sel = "";
			});

			$.each(res.mst_violation_list,function(index,element) {
				if(adl_violation_id.includes(element.id)) sel = "selected";
				additional_violation_list += '<option value="'+element.id+'" '+sel+'>'+element.name+'</option>';
				sel = "";
			});

			$("#nte_review_model #date_of_incident").val(res.nte_data[0].incident_date);
			$("#nte_review_model #comment").text(res.nte_data[0].report_received_comment);

			$('#nte_review_model #main_violation, #nte_review_model #additional_violation').multiselect('clearSelection');
			$('#nte_review_model #main_violation, #nte_review_model #additional_violation').multiselect('refresh');

			$("#nte_review_model #main_violation").html(main_violation_list);
			$("#nte_review_model #additional_violation").html(additional_violation_list);

			$('#nte_review_model #main_violation, #nte_review_model #additional_violation').multiselect('rebuild');
		}
		else {

			alert("Something is wrong!");
		}
				
	},request_url, datas, 'text');

	$('#nte_review_model').modal('show');
});

$(document).on('click','.model_open_nte_user_response',function(){

	const datas = {'nte_id': $(this).attr('nte_id') }

	const request_url = "<?php echo base_url('cnn_module/nte_review_details'); ?>";
	process_ajax(function(response)
	{
		const res = JSON.parse(response);
		if (res.error==false) {

			$("#model_nte_user_response #nte_id").val(res.nte_data[0].id);
			$("#model_nte_user_response #user_id").val(res.nte_data[0].user_id);

			let main_violation_list = "";
			let additional_violation_list = "";

			let main_violation_id = res.nte_data[0].main_violation_id.split(",");
			let adl_violation_id = res.nte_data[0].adl_violation_id.split(",");
			let sel = "";

			$.each(res.mst_violation_list,function(index,element) {
				if(main_violation_id.includes(element.id)) main_violation_list += sel+element.name;
				sel = ", ";
			});

			$.each(res.mst_violation_list,function(index,element) {
				if(adl_violation_id.includes(element.id)) additional_violation_list += sel+element.name;
				sel = ", ";
			});

			$("#model_nte_user_response #main_violation").attr({placeholder: main_violation_list});
			$("#model_nte_user_response #additional_violation").attr({placeholder: additional_violation_list});

			$("#model_nte_user_response #date_of_incident").val(res.nte_data[0].incident_date);
			$("#model_nte_user_response #comment").text(res.nte_data[0].report_received_comment);
			$("#model_nte_user_response #reviewer_comment").text(res.nte_data[0].review_commnet);
		}
		else {

			alert("Something is wrong!");
		}
				
	},request_url, datas, 'text');

	$('#model_nte_user_response').modal('show');
});

$(document).on('click','.nte_hr_acknowledgement_model_open',function(){

	const datas = {'nte_id': $(this).attr('nte_id') }

	const request_url = "<?php echo base_url('cnn_module/nte_review_details'); ?>";
	process_ajax(function(response)
	{
		const res = JSON.parse(response);
		if (res.error==false) {

			$("#model_nte_hr_acknowledgement #nte_id").val(res.nte_data[0].id);
			$("#model_nte_hr_acknowledgement #user_id").val(res.nte_data[0].user_id);

			let main_violation_list = "";
			let additional_violation_list = "";

			let main_violation_id = res.nte_data[0].main_violation_id.split(",");
			let adl_violation_id = res.nte_data[0].adl_violation_id.split(",");
			let sel = "";

			$.each(res.mst_violation_list,function(index,element) {
				if(main_violation_id.includes(element.id)) main_violation_list += sel+element.name;
				sel = ", ";
			});

			$.each(res.mst_violation_list,function(index,element) {
				if(adl_violation_id.includes(element.id)) additional_violation_list += sel+element.name;
				sel = ", ";
			});

			$("#model_nte_hr_acknowledgement #main_violation").attr({placeholder: main_violation_list});
			$("#model_nte_hr_acknowledgement #additional_violation").attr({placeholder: additional_violation_list});

			$("#model_nte_hr_acknowledgement #date_of_incident").val(res.nte_data[0].incident_date);
			$("#model_nte_hr_acknowledgement #comment").text(res.nte_data[0].report_received_comment);
			$("#model_nte_hr_acknowledgement #reviewer_comment").text(res.nte_data[0].review_commnet);
			$("#model_nte_hr_acknowledgement #user_explanation").text(res.nte_data[0].nte_response_comment);

		}
		else {

			alert("Something is wrong!");
		}
				
	},request_url, datas, 'text');

	$('#model_nte_hr_acknowledgement').modal('show');
});



</script>