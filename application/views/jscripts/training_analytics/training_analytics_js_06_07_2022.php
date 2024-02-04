<script>	
	$("#search_trn_summ #office_id").change(function(){
		baseURL = "<?php echo base_url(); ?>";
		var office_id = $(this).val();
		var rURL = baseURL + 'training_analytics/training?office_id=' + office_id;
		window.location = rURL;
	});
	
	$("#search_upskill_summ #office_id").change(function(){
		baseURL = "<?php echo base_url(); ?>";
		var office_id = $(this).val();
		var rURL = baseURL + 'training_analytics/upskill?office_id=' + office_id;
		window.location = rURL;
	});
	
	$("#search_recursive_summ #office_id").change(function(){
		baseURL = "<?php echo base_url(); ?>";
		var office_id = $(this).val();
		var rURL = baseURL + 'training_analytics/recursive?office_id=' + office_id;
		window.location = rURL;
	});
	
	
function batchdetailsclick(a)
{
    $('#sktPleaseWait').modal('show');
    var batchid = $(a).attr('batchid');  
    var trainer = $(a).attr('trainer');  
    var batchname = $(a).attr('batchname');
	
	$('#trainingDetailsModal .modal-title').html('Batch Details');
	$('#trainingDetailsModal .modal-body').html('<span class="text-danger"><b>--- Not Data Found ---</b></span>');
	
    baseURL = "<?php echo base_url(); ?>";
	request_url = baseURL + "/training_analytics/training_batch_details/" + batchid;
	dataParam = { 'batchid' : batchid, 'trainer' : trainer };
	$.ajax({
		type: 'GET',
		url: request_url,
		data: dataParam,
		success: function(response) {
			console.log(response);
			$('#trainingDetailsModal .modal-title').html('Trainer : ' + trainer + ' | Batch ' + batchname);
			$('#trainingDetailsModal .modal-body').html(response);
			$('#trainingDetailsModal').modal('show');			
			$('#sktPleaseWait').modal('hide');
			/*$('#default-datatable-logs').DataTable({
				searching: true,
				info:false,
				pageLength:50,
				
			});*/
		},
	}); 
}


function certificateDetailsClick(batchid, userid, scoretype)
{
    $('#sktPleaseWait').modal('show');
	
	$('#trainingDetailsModalScore .modal-title').html('Score Details');
	$('#trainingDetailsModalScore .modal-body').html('<span class="text-danger"><b>--- Not Data Found ---</b></span>');
	
    baseURL = "<?php echo base_url(); ?>";
	request_url = baseURL + "/training_analytics/training_certificate_details/" + batchid;
	dataParam = { 'batchid' : batchid, 'userid' : userid, 'scoretype' : scoretype };
	$.ajax({
		type: 'GET',
		url: request_url,
		data: dataParam,
		success: function(response) {
			console.log(response);
			//$('#trainingDetailsModalScore .modal-title').html('Trainer : ' + trainer + ' | Batch ' + batchname);
			$('#trainingDetailsModalScore .modal-body').html(response);
			$('#trainingDetailsModalScore').modal('show');			
			$('#sktPleaseWait').modal('hide');
			/*$('#default-datatable-logs').DataTable({
				searching: true,
				info:false,
				pageLength:50,
				
			});*/
		},
	}); 
}


function ragDetailsClick(batchid, userid, scoretype)
{
    $('#sktPleaseWait').modal('show');
	
	$('#trainingDetailsModalScore .modal-title').html('Score Details');
	$('#trainingDetailsModalScore .modal-body').html('<span class="text-danger"><b>--- Not Data Found ---</b></span>');
	
    baseURL = "<?php echo base_url(); ?>";
	request_url = baseURL + "/training_analytics/training_rag_details/" + batchid;
	dataParam = { 'batchid' : batchid, 'userid' : userid, 'scoretype' : scoretype };
	$.ajax({
		type: 'GET',
		url: request_url,
		data: dataParam,
		success: function(response) {
			console.log(response);
			//$('#trainingDetailsModalScore .modal-title').html('Trainer : ' + trainer + ' | Batch ' + batchname);
			$('#trainingDetailsModalScore .modal-body').html(response);
			$('#trainingDetailsModalScore').modal('show');			
			$('#sktPleaseWait').modal('hide');
			/*$('#default-datatable-logs').DataTable({
				searching: true,
				info:false,
				pageLength:50,
				
			});*/
		},
	}); 
}


// EDIT TRAINING CLIENT PROCESS OPTION
$('.ta_btnBatchEdit').click(function(){
	var batchid = $(this).attr('batchid');  
    var trainer = $(this).attr('trainer');  
    var batchname = $(this).attr('batchname'); 
	
	$('#frmTrainingEditBatch #edit_batch_id').val(batchid);
	$('#frmTrainingEditBatch #e_batch_name').val(batchname);

	$('#ta_BatchEdit .modal-title').html('Trainer : ' + trainer + ' | Batch ' + batchname);
	$('#ta_BatchEdit').modal('show');
});



$(".trainingDetailsModalBody").on('click', ".btnInterviewRemarks", function()
{
	//alert('hi');
	baseURL = "<?php echo base_url(); ?>";
	var userID  = $(this).attr("uid");
	var batchID = $(this).attr("batch_id");

	var rURL=baseURL+'training_analytics/get_interview_details';

	$('#sktPleaseWait').modal('show');
	$('#modalInterviewRemarks .modal-body').html('');
	
	$.ajax({
	   type: 'GET',    
	   url:rURL,
	   data:'uid='+userID + '&batch=' +batchID,
	   success: function(response){
			$('#modalInterviewRemarks .modal-body').html(response);
			$('#modalInterviewRemarks').modal('show');
			$('#sktPleaseWait').modal('hide');
		},
		error: function(){	
			alert('Fail!');
			$('#sktPleaseWait').modal('hide');
		}
	  });
	  
	  
});


</script>