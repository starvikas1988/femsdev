<script>
$("#search_nesting_summ #office_id").change(function(){
	baseURL = "<?php echo base_url(); ?>";
	var office_id = $(this).val();
	var rURL = baseURL + 'training_analytics/nesting_rag_performance?office_id=' + office_id;
	window.location = rURL;
});
	
function nestingBatchdetailsClick(a)
{
    $('#sktPleaseWait').modal('show');
    var batchid = $(a).attr('batchid');  
    //var trainer = $(a).attr('trainer');  
    var batchname = $(a).attr('batchname');
	
	$('#trainingDetailsModal .modal-title').html('Batch Details');
	$('#trainingDetailsModal .modal-body').html('<span class="text-danger"><b>--- Not Data Found ---</b></span>');
	
    baseURL = "<?php echo base_url(); ?>";
	request_url = baseURL + "/training_analytics/nesting_batch_details/" + batchid;
	dataParam = { 'batchid' : batchid };
	$.ajax({
		type: 'GET',
		url: request_url,
		data: dataParam,
		success: function(response) {
			//console.log(response);
			$('#trainingDetailsModal .modal-title').html('Batch ' + batchname);
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


function nestingBatchTargetClick(a)
{
    $('#sktPleaseWait').modal('show');
    var batchid = $(a).attr('batchid');  
    //var trainer = $(a).attr('trainer');  
    var batchname = $(a).attr('batchname');
	
	$('#trainingDetailsModal .modal-title').html('Batch Details');
	$('#trainingDetailsModal .modal-body').html('<span class="text-danger"><b>--- Not Data Found ---</b></span>');
	
    baseURL = "<?php echo base_url(); ?>";
	request_url = baseURL + "/training_analytics/nesting_batch_target_ajax/" + batchid;
	dataParam = { 'batchid' : batchid };
	$.ajax({
		type: 'GET',
		url: request_url,
		data: dataParam,
		success: function(response) {
			//console.log(response);
			$('#trainingDetailsModal .modal-title').html('Batch ' + batchname);
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

</script>