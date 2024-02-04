<script>
baseURL = "<?php echo base_url(); ?>";

$('.oldDatePick').datepicker({ maxDate: '0', dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });

function getAge(dateString) 
{
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) 
    {
        age--;
    }
    return age;
}

$('.OverallChildDIV').on('change', 'input[name="child_dob[]"]', function(){
	curDate = $(this).val();
	gotAge = getAge(curDate);
	$(this).closest('.eachChildDIV').find('input[name="child_age[]"]').val(gotAge);
});

$('.OverallrelationFamilyDiv').on('change', 'input[name="e_dob[]"]', function(){
	curDate = $(this).val();
	gotAge = getAge(curDate);
	$(this).closest('.row').find('input[name="e_age[]"]').val(gotAge);
});

$('.OverallrelationFamilyDiv').on('click', '.removeVaccineAll2', function(){
	$(this).parent().parent().parent().remove();
});

$('.addMoreVaccineAll').click(function(){
	vaccineDIV = $('.relationFamilyDivCopy').html();
	$('.OverallrelationFamilyDiv').append('<div class="row relationFamilyDiv">' + vaccineDIV + '</div>');
	$('.OverallrelationFamilyDiv .oldDatePickCheck2').datepicker({ maxDate: '0', dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
});


$('.vaccineDIVData').on('click', '.removeVaccine', function(){
	$(this).parent().parent().parent().remove();
});

$('.addMoreVaccine').click(function(){
	vaccineDIV = $('.vaccineDIVCopy').html();
	$('.vaccineDIVData').append('<div class="row vaccineDIV">' + vaccineDIV + '</div><hr/>');
	$('.vaccineDIVData .oldDatePickCheck').datepicker({ maxDate: '0', dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
});


$('select[name="is_vaccine"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'Yes'){
		$('.OverallvaccineDIV').show();
		$('.proofDIV').show();
		$('.OverallvaccineDIV').find('input,textarea,select').val('');
		$('.OverallvaccineDIV').find('input,textarea,select').attr('required', 'required');
		$('.OverallvaccineDIV').find('input[name="vaccine_info_dose_1[]"]').removeAttr('required');
		$('.OverallvaccineDIV').find('input[name="vaccine_info_dose_2[]"]').removeAttr('required');
		$('.OverallvaccineDIV').find('input[name="vaccine_info_dose_2_date[]"]').removeAttr('required');
	} else {
		$('.OverallvaccineDIV').hide();
		$('.proofDIV').hide();
		$('.OverallvaccineDIV').find('input,textarea,select').val('');
		$('.OverallvaccineDIV').find('input,textarea,select').removeAttr('required');
	}
});

$('.vaccineDIVData').on('change', '.vaccineTypeDrop', function(){
	curVal = $(this).val();
	if(curVal == 'Other'){
		$(this).closest('.vaccineDIV').find('.vaccineInfoDiv').show();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info[]"]').val('');
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info[]"]').attr('required', 'required');
	} else {
		$(this).closest('.vaccineDIV').find('.vaccineInfoDiv').hide();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info[]"]').val('');
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info[]"]').removeAttr('required');
	}
});

$('.OverallrelationFamilyDiv').on('change', '.noVaccineInfo', function(){
	curVal = $(this).val();
	if(curVal == 'Yes'){
		$(this).closest('.relationFamilyDiv').find('input[name="e_aadhaar_no[]"]').removeAttr('readonly');
		$(this).closest('.relationFamilyDiv').find('input[name="e_aadhaar_no[]"]').attr('required', 'required');
		$(this).closest('.relationFamilyDiv').find('input[name="e_dob[]"]').removeAttr('readonly');
		$(this).closest('.relationFamilyDiv').find('input[name="e_dob[]"]').attr('required', 'required');
		$(this).closest('.relationFamilyDiv').find('input[name="e_age[]"]').attr('required', 'required');
	} else {
		$(this).closest('.relationFamilyDiv').find('input[name="e_aadhaar_no[]"]').attr('readonly', 'readonly');		
		$(this).closest('.relationFamilyDiv').find('input[name="e_aadhaar_no[]"]').removeAttr('required');
		$(this).closest('.relationFamilyDiv').find('input[name="e_dob[]"]').attr('readonly', 'readonly');		
		$(this).closest('.relationFamilyDiv').find('input[name="e_dob[]"]').removeAttr('required');
		$(this).closest('.relationFamilyDiv').find('input[name="e_age[]"]').removeAttr('required');
	}
});


$('.vaccineDIVData').on('change', '.vaccineDose', function(){
	curVal = $(this).val();
	if(curVal == '2'){
		$(this).closest('.vaccineDIV').find('.dose2Upload').show();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2[]"]').val('');
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2_date[]"]').val('');
		//$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2[]"]').attr('required', 'required');
	} else {
		$(this).closest('.vaccineDIV').find('.dose2Upload').hide();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2[]"]').val('');
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2[]"]').removeAttr('required');
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2_date[]"]').removeAttr('required');
	}
});





</script>