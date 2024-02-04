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
	var selectedName = $('#trainee_id').find(":selected").text();
	var selectedValue = $('#trainee_id').val();
	$('#spantrainingdiv').hide();
	var addDivTrainee = '<div class="row"><div class="col-md-6"><div class="form-group"><select class="form-control" name="trainee_id_select[]" id="trainee_id_select[]"><option value="' + selectedValue + '">' + selectedName + '</option></select></div></div><div class="col-md-2"><div class="form-group"><button type="button" class="btn btn-danger btn-md" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-times"></i> Remove</button></div></div></div>';
	var htmlappend = $('#traineeAddDivFinal').append(addDivTrainee);
	
});

</script>