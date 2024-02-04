<script>
$('#employee_is_symptom').change(function(){
	checkVal = $(this).val();
	if(checkVal == 'Y'){ $('#covid_symtomp_found').removeClass('hide'); }
	else { $('#covid_symtomp_found').addClass('hide'); $('#employee_symptoms').val(''); }
});

$('#covid_start_date').datepicker({ dateFormat:'yy-mm-dd' });
$('#covid_end_date').datepicker({ dateFormat:'yy-mm-dd' });

</script>