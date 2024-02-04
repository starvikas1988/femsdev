<script>
// SURVEY 5 CHECK
$("input[name='survey_5']").click(function(){
	currentSelection = $(this).val();
	if(currentSelection == 'N'){ 
		$('#survey_5_others').prop('required',true);
		$('#survey_5_others').show();
	
	} else {
		$('#survey_5_others').prop('required',false);
		$('#survey_5_others').val('');
		$('#survey_5_others').hide();
	}
});
</script>