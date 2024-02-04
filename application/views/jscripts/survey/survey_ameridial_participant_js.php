<script>
$('select[name="survey_1"]').on('change', function(){
	gotVal = $(this).val();
	if(gotVal == 'Yes'){
		$('.survey_2_div').hide();
		$('input[name="survey_2"]').removeAttr("required");
		$('textarea[name="survey_2_reason"]').removeAttr("required");
	} else {
		$('input[name="survey_2"]').attr("required", "required");
		$('.survey_2_div').show();
	}
});

$('input[name="survey_2"]').on('click', function(){
	gotVal = $(this).val();
	if(gotVal == 'OTHER'){
		$('.survey_2_reason_div').show();
		$('textarea[name="survey_2_reason"]').attr("required", "required");
	} else {
		$('.survey_2_reason_div').hide();
		$('textarea[name="survey_2_reason"]').removeAttr("required");
	}
});

$('input[name="survey_10"]').on('click', function(){
	gotVal = $(this).val();
	if(gotVal == 'OTHER'){
		$('.survey_10_reason_div').show();
		$('textarea[name="survey_10_reason"]').attr("required", "required");
	} else {
		$('.survey_10_reason_div').hide();
		$('textarea[name="survey_10_reason"]').removeAttr("required");
	}
});

$('input[name="survey_12[]"]').on('click', function(){
	gotVal = $('input[name="survey_12[]"]:checked');
	found = 0; selected = 0;
	$.each(gotVal, function(i, token){
		selected++;
		curVal = $(this).val();
		if(curVal == 'OTHER'){ found = 1; }
	});
	if(found == 1){
		$('.survey_12_reason_div').show();
		$('textarea[name="survey_12_reason"]').attr("required", "required");
	} else {
		$('.survey_12_reason_div').hide();
		$('textarea[name="survey_12_reason"]').removeAttr("required");
	}
	
	if(selected > 0){
		$('button[type="submit"]').prop('disabled', false);
	} else {
		$('button[type="submit"]').prop('disabled', true);
	}
});
</script>