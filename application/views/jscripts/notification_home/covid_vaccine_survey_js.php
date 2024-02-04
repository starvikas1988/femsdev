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

$('select[name="marital_status"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'Unmarried'){
		$('.spouseDiv').hide();
		$('.spouseDiv').find('input,textarea,select').val('');
		$('.spouseDiv').find('input,textarea,select').removeAttr('required');
		$('.childrenDiv').hide();
		$('.childrenDiv').find('input,textarea,select').val('');
		$('.childrenDiv').find('input,textarea,select').removeAttr('required');
	} else {	
		$('.spouseDiv').show();
		$('.spouseDiv').find('input,textarea,select').attr('required', 'required');
		$('.childNoDiv').find('input,textarea,select').val('');
		$('.childNoDiv').find('input,textarea,select').removeAttr('required');
	}
});

$('select[name="have_children"]').on('change', function(){
	isChild = $(this).val();
	if(isChild == 'Yes'){
		$('.childNoDiv').show();
		$('.childNoDiv').find('input,textarea,select').val('1');		
		$('.childNoDiv').find('input,textarea,select').attr('required', 'required');		
		$('.childrenDiv').show();
		$('.childrenDiv').find('input,textarea,select').val('');
		$('.childrenDiv').find('input,textarea,select').attr('required', 'required');
	} else {
		$('.childNoDiv').hide();
		$('.childNoDiv').find('input,textarea,select').val('0');		
		$('.childNoDiv').find('input,textarea,select').removeAttr('required');		
		$('.childrenDiv').hide();
		$('.childrenDiv').find('input,textarea,select').val('');
		$('.childrenDiv').find('input,textarea,select').removeAttr('required');
	}
});


$('input[name="no_of_child"]').on('keyup', function(){
	isChild = $(this).val();
	childDiv = $('.eachChildDIVCopy').html();
	childDivContent = '<div class="row eachChildDIV">' + childDiv + '</div>';
	childDivContentTest = "";
	for(i=1;i<=isChild;i++){
		//childDivContent.replace('id="child_dob[]"', 'id="child_dob'+i+'[]');
		childDivContentTest += childDivContent;
	}
	$('.OverallChildDIV').html(childDivContentTest);
	$('.OverallChildDIV .oldDatePickCopy').datepicker({ maxDate: '0', dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
});

$('.vaccineDIVData').on('click', '.removeVaccine', function(){
	$(this).parent().parent().parent().remove();
});

$('.addMoreVaccine').click(function(){
	vaccineDIV = $('.vaccineDIVCopy').html();
	$('.vaccineDIVData').append('<div class="row vaccineDIV">' + vaccineDIV + '</div><hr/>');
});


$('select[name="is_vaccine"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'Yes'){
		$('.OverallvaccineDIV').show();
		$('.OverallvaccineDIV').find('input,textarea,select').val('');
		$('.OverallvaccineDIV').find('input,textarea,select').attr('required', 'required');
		$('.OverallvaccineDIV').find('input[name="vaccine_info_dose_1[]"]').removeAttr('required');
		$('.OverallvaccineDIV').find('input[name="vaccine_info_dose_2[]"]').removeAttr('required');
	} else {
		$('.OverallvaccineDIV').hide();
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

$('.vaccineDIVData').on('change', '.vaccineMember', function(){
	curVal = $(this).val();
	if(curVal == 'Myself'){
		myName = "<?php echo !empty($agent_details['fullname']) ? $agent_details['fullname'] : ""; ?>";
		$(this).closest('.vaccineDIV').find('input[name="vaccine_member_name[]"]').val(myName);
	}
	if(curVal == 'Mother'){
		myName = $('input[name="mother_name"]').val();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_member_name[]"]').val(myName);
	}
	if(curVal == 'Father'){
		myName = $('input[name="father_name"]').val();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_member_name[]"]').val(myName);
	}
	if(curVal == 'Spouse'){
		myName = $('input[name="spouse_name"]').val();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_member_name[]"]').val(myName);
	}
});


$('.vaccineDIVData').on('change', '.vaccineDose', function(){
	curVal = $(this).val();
	if(curVal == '2'){
		$(this).closest('.vaccineDIV').find('.dose2Upload').show();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2[]"]').val('');
		//$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2[]"]').attr('required', 'required');
	} else {
		$(this).closest('.vaccineDIV').find('.dose2Upload').hide();
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2[]"]').val('');
		$(this).closest('.vaccineDIV').find('input[name="vaccine_info_dose_2[]"]').removeAttr('required');
	}
});





$('.vaccineDIVData_reg').on('click', '.removeVaccine_reg', function(){
	$(this).parent().parent().parent().remove();
});

$('.addMoreVaccine_reg').click(function(){
	vaccineDIV = $('.vaccineDIVCopy_reg').html();
	$('.vaccineDIVData_reg').append('<div class="row vaccineDIV_reg">' + vaccineDIV + '</div>');
});


$('select[name="is_vaccine_reg"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'Yes'){
		$('.OverallvaccineDIV_reg').show();
		$('.OverallvaccineDIV_reg').find('input,textarea,select').val('');
		$('.OverallvaccineDIV_reg').find('input,textarea,select').attr('required', 'required');
	} else {
		$('.OverallvaccineDIV_reg').hide();
		$('.OverallvaccineDIV_reg').find('input,textarea,select').val('');
		$('.OverallvaccineDIV_reg').find('input,textarea,select').removeAttr('required');
	}
});

$('.vaccineDIVData_reg').on('change', '.vaccineMember_reg', function(){
	curVal = $(this).val();
	if(curVal == 'Myself'){
		myName = "<?php echo !empty($agent_details['fullname']) ? $agent_details['fullname'] : ""; ?>";
		$(this).closest('.vaccineDIV_reg').find('input[name="vaccine_member_name_reg[]"]').val(myName);
	}
	if(curVal == 'Mother'){
		myName = $('input[name="mother_name"]').val();
		$(this).closest('.vaccineDIV_reg').find('input[name="vaccine_member_name_reg[]"]').val(myName);
	}
	if(curVal == 'Father'){
		myName = $('input[name="father_name"]').val();
		$(this).closest('.vaccineDIV_reg').find('input[name="vaccine_member_name_reg[]"]').val(myName);
	}
	if(curVal == 'Spouse'){
		myName = $('input[name="spouse_name"]').val();
		$(this).closest('.vaccineDIV_reg').find('input[name="vaccine_member_name_reg[]"]').val(myName);
	}
});

</script>