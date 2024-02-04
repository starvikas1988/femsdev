
<script>
//start the JS Script

$(document).on('click','.location_search_nod_initiate',function(){

	let type = $(this).attr("value")
	$("#initiate_nod_search").attr('value',type);

	locations_ids = [];
	$('#location_id :selected').map(function(idx, elem) {
		locations_ids[idx] = $(elem).val();
	});

	if (locations_ids.length === 0) {
		alert("Please select location");
	}
	else {
		const datas = {
			"location_id": locations_ids,
			"type": type
		};

		const request_url = "<?php echo base_url('cnn_module/get_nod_initiate_details'); ?>";
		process_ajax(function(response)
		{
			$("#"+type).html(response);
			
		},request_url, datas, 'text');
	}

});

$(document).on('click','.nod_resend_nte_model_open',function(){

	$("#open_model_nod_resend_nte #nte_id").val($(this).attr('nte_id'));
	$("#open_model_nod_resend_nte #user_id").val($(this).attr('user_id'));


	$('#open_model_nod_resend_nte').modal('show');
});

$(document).on('click','#open_model_nod_resend_nte #yes_btn',function(){

	const datas = {
		"user_id" : $("#open_model_nod_resend_nte #user_id").val(),
		"nte_id" : $("#open_model_nod_resend_nte #nte_id").val()
	}

	const request_url = "<?php echo base_url('cnn_module/resend_nod_nte_reponse'); ?>";
	process_ajax(function(response)
	{
		const res = JSON.parse(response);

		if (res.error==false) {

	        // $("#open_model_nod_resend_nte .before_acpt").hide();
	        // $("#open_model_nod_resend_nte .after_acpt_msg").show();
	        // $("#open_model_nod_resend_nte .modal-footer").hide();

	       	$('#open_model_nod_resend_nte').modal('hide');

	        ///Auto event tigger on html load
	        $('.location_search_nod_initiate').first().trigger('click');
		}
		else {
			alert("Something is wrong!");
		}
				
	},request_url, datas, 'text');

});

$(document).on('click','.nod_initiate_model_open',function(){

	const datas = {'nte_id': $(this).attr('nte_id') }

	const request_url = "<?php echo base_url('cnn_module/nte_review_details'); ?>";
	process_ajax(function(response)
	{
		const res = JSON.parse(response);
		if (res.error==false) {

			$("#nod_initiate_model #nte_id").val(res.nte_data[0].id);
			$("#nod_initiate_model #user_id").val(res.nte_data[0].user_id);

			$("#nod_initiate_model #date_of_incident").val(res.nte_data[0].incident_date);

			let objectDate = new Date(res.nte_data[0].created_date);
			let month = objectDate.getMonth()+1;
			let new_date_formate = objectDate.getFullYear()+"-"+month+'-'+objectDate.getDate();

			$("#nod_initiate_model #issue_date").val(new_date_formate);
			$("#nod_initiate_model #user_response_date").val(res.nte_data[0].nte_response_date);
			$("#nod_initiate_model #user_explanation").text(res.nte_data[0].nte_response_comment);

			$("#nod_initiate_model #nod_initiate_comment").val("");

			$('#nod_initiate_model #nte_btn').prop('disabled', false);
		}
		else {

			alert("Something is wrong!"); 
		}
				
	},request_url, datas, 'text');

	$('#nod_initiate_model').modal('show');
});

$(document).on('submit',"#nod_initiate_model #nod_initiate_submit",function(e){
	e.preventDefault();

	$('#nod_initiate_model #nte_btn').prop('disabled', true);

	const datas = $(this).serializeArray();
	const request_url = "<?php echo base_url('cnn_module/nod_initiate_submit'); ?>";

	process_ajax(function(response)
	{
		const res = JSON.parse(response);

		if(res.error == false)
		{
	    	// $(".before_acpt").hide();
	        // $(".after_acpt_msg").show();
	        // $(".modal-footer").hide();

	        $("#nod_initiate_model #nod_initiate_comment").text("");

	        $('#nod_initiate_model').modal('hide');

		    ///Auto event tigger on html load
		    $('.location_search_nod_initiate').first().trigger('click');
		}
					
	},request_url, datas, 'text');

});

$(document).on('click','.nod_review_model_open',function(){

	$("#nod_review_model #invest_result").val("");
	$("#nod_review_model #nod_review_comment").val("");

	const datas = {'nte_id': $(this).attr('nte_id') }

	const request_url = "<?php echo base_url('cnn_module/nte_review_details'); ?>";
	process_ajax(function(response)
	{
		const res = JSON.parse(response);
		if (res.error==false) {

			$("#nod_review_model .modal-title").text(res.nte_data[0].user_name);

			$("#nod_review_model #nte_id").val(res.nte_data[0].id);
			$("#nod_review_model #user_id").val(res.nte_data[0].user_id);

			$("#nod_review_model #date_of_incident").val(res.nte_data[0].incident_date);

			let objectDate = new Date(res.nte_data[0].created_date);
			let month = objectDate.getMonth()+1;
			let new_date_formate = objectDate.getFullYear()+"-"+month+'-'+objectDate.getDate();

			$("#nod_review_model #issue_date").val(new_date_formate);
			$("#nod_review_model #user_response_date").val(res.nte_data[0].nte_response_date);
			$("#nod_review_model #user_explanation").text(res.nte_data[0].nte_response_comment);

			$("#nod_review_model #invest_result").val(res.nte_data[0].nod_invest_result);

			$("#nod_review_model #nod_initiate_comment").text("");
		}
		else {

			alert("Something is wrong!");
		}
				
	},request_url, datas, 'text');

	$('#nod_review_model').modal('show');
});

$(document).on('click','.nod_user_respnose_open_model',function(){

	$("#nod_user_respnose_model #user_comments").val("");

	const datas = {'nte_id': $(this).attr('nte_id') }

	const request_url = "<?php echo base_url('cnn_module/nte_review_details'); ?>";
	process_ajax(function(response)
	{
		const res = JSON.parse(response);
		if (res.error==false) {

			$("#nod_user_respnose_model #nte_id").val(res.nte_data[0].id);
			$("#nod_user_respnose_model #user_id").val(res.nte_data[0].user_id);

			$("#nod_user_respnose_model #date_of_incident").val(res.nte_data[0].incident_date);

			let objectDate = new Date(res.nte_data[0].created_date);
			let month = objectDate.getMonth()+1;
			let new_date_formate = objectDate.getFullYear()+"-"+month+'-'+objectDate.getDate();

			$("#nod_user_respnose_model #issue_date").val(new_date_formate);
			$("#nod_user_respnose_model #user_response_date").val(res.nte_data[0].nte_response_date);
			$("#nod_user_respnose_model #user_explanation").text(res.nte_data[0].nte_response_comment);

			$("#nod_user_respnose_model #invest_result").val(res.nte_data[0].nod_invest_result);
			$("#nod_user_respnose_model #reviewer_comment").val(res.nte_data[0].nod_review_comment);

		}
		else {

			alert("Something is wrong!");
		}
				
	},request_url, datas, 'text');

	$('#nod_user_respnose_model').modal('show');
});


</script>