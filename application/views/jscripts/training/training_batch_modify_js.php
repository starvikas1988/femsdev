<script>
// INITIALIZE SCRIPT
$('#training_type').val('<?php echo $batch_type; ?>');
$('#training_type').select2();

$('#trainer_id').select2();
$('#trainee_id').select2();

// PROCESS --> CLIENT FILTER
$("#b_client_id").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'','b_process_id','N');
});

$("#survey_client_id").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'','b_process_id','Y');
});


// APPEND ALTER
$("#traineeAdd").click(function(){
	// alert('pppp');
	var selectedName = $('#trainee_id').find(":selected").text();
	var selectedValue = $('#trainee_id').val();

	// alert(selectedValue);
	if(selectedValue!=''){
	$('#spantrainingdiv').hide();
	var addDivTrainee = `<div class="row check_row" id="${selectedValue}_remove"><div class="col-md-6"><div class="form-group"><select class="form-control" name="trainee_id_select[]" id="trainee_id_select[]"><option value="${selectedValue}">${selectedName}</option></select></div></div><div class="col-md-2"><div class="form-group"><button type="button"  class="btn btn-danger btn-md" onclick="remove_traineeAdd('#${selectedValue}_remove')"><i class="fa fa-times"></i> Remove</button></div></div></div>`;
	var htmlappend = $('#traineeAddDivFinal').append(addDivTrainee);
	$("#trainee_list_check").val("1");
	$("#select_trainee_error").html("");



	}
	else{
		alert('Please select item in the trainee list');
		$("#trainee_list_check").val("0");

	}
	
});

function remove_traineeAdd(get_id)
{
	$(get_id).remove();
	if($(".check_row")[0]){ $('#spantrainingdiv').hide(); }
	else { $('#spantrainingdiv').show(); }
}

// $(".append_id").click(function(){

// 	if($('.append_id').Exists()){
// 		$('#spantrainingdiv').show();
// 	}else{
// 		$('#spantrainingdiv').hide();
// 	}
	
	
// });




</script>