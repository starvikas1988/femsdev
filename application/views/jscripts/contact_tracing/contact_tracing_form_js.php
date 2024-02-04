<script>
$('#case_dob').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#case_investigation_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#case_investigation_complete').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#case_complete_date').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#lhj_notification_date').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_symptom_onset').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_diagnosis_date').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_clinical_info_8_onset').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_clinical_info_9_onset').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_clinical_testing_1_date').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_clinical_testing_2_date').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_clinical_testing_3_date').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_hospitalization_1_admission').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_hospitalization_1_discharge').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#c_hospitalization_4_death').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#t_treatment_start_date').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#t_treatment_end_date').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_setting_1_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_setting_2_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_setting_3_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_setting_1_end').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_setting_2_end').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_setting_3_end').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_risk_1_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_risk_1_end').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#r_risk_2_dob').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#af_setting_1_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#af_setting_2_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#af_setting_3_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#af_setting_4_start').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#af_setting_1_end').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#af_setting_2_end').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#af_setting_3_end').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#af_setting_4_end').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#inv_info_4').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$("#ca_info_4").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });

<?php if($this->uri->segment(4) == 'personal'){ ?>
$('#case_fname').val('<?php echo $crmdetails['fname']; ?>');
$('#case_lname').val('<?php echo $crmdetails['lname']; ?>');
$('#case_dob').val('<?php echo date('m/d/Y',strtotime($crmdetails['p_dob'])); ?>');
$('#case_alt').val('<?php echo $crmdetails['p_alt_name']; ?>');
$('#case_phone').val('<?php echo $crmdetails['p_phone']; ?>');
$('#case_email').val('<?php echo $crmdetails['p_email']; ?>');
$('#case_address').val('<?php echo $crmdetails['p_address']; ?>');
$('#case_city').val('<?php echo $crmdetails['p_city']; ?>');
$('#case_guardian').val('<?php echo $crmdetails['p_guardian_name']; ?>');
$('#case_residence').val('<?php echo $crmdetails['p_residence_type']; ?>');
$('#wa_resident').val('<?php echo $crmdetails['p_is_wa_resident']; ?>');

$('#case_country').val('<?php echo $crmdetails['p_country']; ?>');
cid = $('#case_country').find('option:selected').attr('cid'); get_states(cid);
$('#case_state').val('<?php echo $crmdetails['p_state']; ?>');

$("input[name='case_addresstype'][value='<?php echo $crmdetails['p_address_type']; ?>']").prop("checked",true);
$("input[name='case_gender'][value='<?php echo $crmdetails['p_gender']; ?>']").prop("checked",true);
$("input[name='wa_resident'][value='<?php echo $crmdetails['p_is_wa_resident']; ?>']").prop("checked",true);
<?php } ?>


<?php if($this->uri->segment(4) == 'administrative'){ ?>
$('#case_investigator').val('<?php echo $crmdetails['a_investigator']; ?>');
$('#lhj_case_id').val('<?php echo $crmdetails['a_lhj_case_id']; ?>');
$('#lhj_notification_date').val('<?php if(!empty($crmdetails['a_lhj_notification_date'])){ echo date('m/d/Y',strtotime($crmdetails['a_lhj_notification_date'])); } ?>');
$('#case_reason').val('<?php echo $crmdetails['a_case_reason']; ?>');
$('#case_investigation_start').val('<?php if(!empty($crmdetails['a_investigation_start_date'])){ echo date('m/d/Y',strtotime($crmdetails['a_investigation_start_date'])); } ?>');
$('#case_investigation_complete').val('<?php if(!empty($crmdetails['a_investigation_complete_date'])){ echo date('m/d/Y',strtotime($crmdetails['a_investigation_complete_date'])); } ?>');
$('#case_complete_date').val('<?php if(!empty($crmdetails['a_case_complete_date'])){ echo date('m/d/Y',strtotime($crmdetails['a_case_complete_date'])); } ?>');
$('#lhj_cluster').val('<?php echo $crmdetails['a_cluster_name']; ?>');
$('#case_cluster_name').val('<?php echo $crmdetails['a_cluster_name']; ?>');

$("input[name='case_outbreak'][value='<?php echo $crmdetails['a_is_outbreak_related']; ?>']").prop("checked",true);
$("input[name='case_classification'][value='<?php echo $crmdetails['a_classification']; ?>']").prop("checked",true);
$("input[name='case_investigation_status'][value='<?php echo $crmdetails['a_investigation_status']; ?>']").prop("checked",true);

//======== VALIDATIONS
case_outbreak_validator($("input[name='case_outbreak']:checked"));
function case_outbreak_validator(eput){
	case_outbreak = $(eput).val();
	if(case_outbreak == 'Y'){ 
		$('#lhj_cluster,#case_cluster_name').prop('required',true);
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
	} else {
		$('#lhj_cluster,#case_cluster_name').prop('required',false);
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
	}
}


<?php } ?>


<?php if($this->uri->segment(4) == 'demographics'){ ?>
$('#d_age_at_symptom_year').val('<?php echo $crmdetails['d_age_at_symptom_year']; ?>');
$('#d_age_at_symptom_month').val('<?php echo $crmdetails['d_age_at_symptom_month']; ?>');
$('#d_primary_language').val('<?php echo $crmdetails['d_primary_language']; ?>');
$('#d_occupation').val('<?php echo $crmdetails['d_occupation']; ?>');
$('#d_industry').val('<?php echo $crmdetails['d_industry']; ?>');
$('#d_employer').val('<?php echo $crmdetails['d_employer']; ?>');
$('#d_worksite').val('<?php echo $crmdetails['d_worksite']; ?>');
$('#d_city').val('<?php echo $crmdetails['d_city']; ?>');
$('#d_school_name').val('<?php echo $crmdetails['d_school_name']; ?>');
$('#d_school_address').val('<?php echo $crmdetails['d_school_address']; ?>');
$('#d_school_city').val('<?php echo $crmdetails['d_school_city']; ?>');
$('#d_school_zip').val('<?php echo $crmdetails['d_school_zip']; ?>');
$('#d_phone').val('<?php echo $crmdetails['d_phone']; ?>');
$('#d_teacher_name').val('<?php echo $crmdetails['d_teacher_name']; ?>');

$("input[name='d_race'][value='<?php echo $crmdetails['d_race']; ?>']").prop("checked",true);
$("input[name='d_is_interpreter_needed'][value='<?php echo $crmdetails['d_is_interpreter_needed']; ?>']").prop("checked",true);
$("input[name='d_ethinicity'][value='<?php echo $crmdetails['d_ethinicity']; ?>']").prop("checked",true);
$("input[name='d_is_employed'][value='<?php echo $crmdetails['d_is_employed']; ?>']").prop("checked",true);
$("input[name='d_is_student_care'][value='<?php echo $crmdetails['d_is_student_care']; ?>']").prop("checked",true);
$("input[name='d_type_of_school'][value='<?php echo $crmdetails['d_type_of_school']; ?>']").prop("checked",true);


//======== VALIDATIONS
d_is_employed_validator($("input[name='d_is_employed']:checked"));
function d_is_employed_validator(eput){
	d_is_employed = $(eput).val();
	if(d_is_employed == 'Y'){ 
		$('#d_occupation,#d_industry,#d_employer,#d_worksite').prop('required',true);
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').show();
	} else {
		$('#d_occupation,#d_industry,#d_employer,#d_worksite').prop('required',false);
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').hide();
	}
}

d_is_student_care_validator($("input[name='d_is_student_care']:checked"));
function d_is_student_care_validator(eput){
	d_is_student_care = $(eput).val();
	if(d_is_student_care == 'Y'){ 
		$('#d_school_name,#d_school_address,#d_school_city,#d_school_zip,#d_phone,#d_teacher_name').prop('required',true);
		$("input[name='d_type_of_school']").attr('required', 'required');
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').show();
	} else {
		$('#d_school_name,#d_school_address,#d_school_city,#d_school_zip,#d_phone,#d_teacher_name').prop('required',false);
		$("input[name='d_type_of_school']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').hide();
	}
}

<?php } ?>


<?php if($this->uri->segment(4) == 'clinical'){ ?>

$('#c_symptom_onset').val('<?php echo $crmdetails['c_symptom_onset']; ?>');
$('#c_diagnosis_date').val('<?php if(!empty($crmdetails['c_diagnosis_date'])){ echo date('m/d/Y',strtotime($crmdetails['c_diagnosis_date'])); } ?>');
$('#c_illness_duration').val('<?php echo $crmdetails['c_illness_duration']; ?>');
$('#c_clinincal_info_1_hightemp').val('<?php echo $crmdetails['c_clinincal_info_1_hightemp']; ?>');
$('#c_clinical_info_8_onset').val('<?php if(!empty($crmdetails['c_clinical_info_8_onset'])){ echo date('m/d/Y',strtotime($crmdetails['c_clinical_info_8_onset'])); } ?>');
$('#c_clinical_info_9_onset').val('<?php if(!empty($crmdetails['c_clinical_info_8_onset'])){ echo date('m/d/Y',strtotime($crmdetails['c_clinical_info_9_onset'])); } ?>');
$('#c_clinical_info_19_other').val('<?php echo $crmdetails['c_clinical_info_19_other']; ?>');
$('#c_predisposing_info_5_specify').val('<?php echo $crmdetails['c_predisposing_info_5_specify']; ?>');
$('#c_predisposing_info_7_specify').val('<?php echo $crmdetails['c_predisposing_info_7_specify']; ?>');
$('#c_predisposing_info_16_others').val('<?php echo $crmdetails['c_predisposing_info_16_others']; ?>');
$('#c_clinical_testing_1_date').val('<?php if(!empty($crmdetails['c_clinical_testing_1_date'])){ echo date('m/d/Y',strtotime($crmdetails['c_clinical_testing_1_date'])); } ?>');
$('#c_clinical_testing_2_date').val('<?php if(!empty($crmdetails['c_clinical_testing_2_date'])){ echo date('m/d/Y',strtotime($crmdetails['c_clinical_testing_2_date'])); } ?>');
$('#c_clinical_testing_3_date').val('<?php if(!empty($crmdetails['c_clinical_testing_3_date'])){ echo date('m/d/Y',strtotime($crmdetails['c_clinical_testing_3_date'])); } ?>');
$('#c_hospitalization_1_info').val('<?php echo $crmdetails['c_hospitalization_1_info']; ?>');
$('#c_hospitalization_1_admission').val('<?php if(!empty($crmdetails['c_hospitalization_1_admission'])){ echo date('m/d/Y',strtotime($crmdetails['c_hospitalization_1_admission'])); } ?>');
$('#c_hospitalization_1_discharge').val('<?php if(!empty($crmdetails['c_hospitalization_1_discharge'])){ echo date('m/d/Y',strtotime($crmdetails['c_hospitalization_1_discharge'])); } ?>');
$('#c_hospitalization_4_death').val('<?php if(!empty($crmdetails['c_hospitalization_4_death'])){ echo date('m/d/Y',strtotime($crmdetails['c_hospitalization_4_death'])); } ?>');

$("input[name='c_complainant_ill'][value='<?php echo $crmdetails['c_complainant_ill']; ?>']").prop("checked",true);
$("input[name='c_illness_duration_type'][value='<?php echo $crmdetails['c_illness_duration_type']; ?>']").prop("checked",true);
$("input[name='c_illness_ongoing'][value='<?php echo $crmdetails['c_illness_ongoing']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_1'][value='<?php echo $crmdetails['c_clinical_info_1']; ?>']").prop("checked",true);
$("input[name='c_clinincal_info_1_temp'][value='<?php echo $crmdetails['c_clinincal_info_1_temp']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_2'][value='<?php echo $crmdetails['c_clinical_info_2']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_3'][value='<?php echo $crmdetails['c_clinical_info_3']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_4'][value='<?php echo $crmdetails['c_clinical_info_4']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_5'][value='<?php echo $crmdetails['c_clinical_info_5']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_6'][value='<?php echo $crmdetails['c_clinical_info_6']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_7'][value='<?php echo $crmdetails['c_clinical_info_7']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_8'][value='<?php echo $crmdetails['c_clinical_info_8']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_9'][value='<?php echo $crmdetails['c_clinical_info_9']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_10'][value='<?php echo $crmdetails['c_clinical_info_10']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_11'][value='<?php echo $crmdetails['c_clinical_info_11']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_11_result'][value='<?php echo $crmdetails['c_clinical_info_11_result']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_12'][value='<?php echo $crmdetails['c_clinical_info_12']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_13'][value='<?php echo $crmdetails['c_clinical_info_13']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_14'][value='<?php echo $crmdetails['c_clinical_info_14']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_15'][value='<?php echo $crmdetails['c_clinical_info_15']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_16'][value='<?php echo $crmdetails['c_clinical_info_16']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_17'][value='<?php echo $crmdetails['c_clinical_info_17']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_18'][value='<?php echo $crmdetails['c_clinical_info_18']; ?>']").prop("checked",true);
$("input[name='c_clinical_info_19'][value='<?php echo $crmdetails['c_clinical_info_19']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_1'][value='<?php echo $crmdetails['c_predisposing_info_1']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_2'][value='<?php echo $crmdetails['c_predisposing_info_2']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_3'][value='<?php echo $crmdetails['c_predisposing_info_3']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_4'][value='<?php echo $crmdetails['c_predisposing_info_4']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_5'][value='<?php echo $crmdetails['c_predisposing_info_5']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_6'][value='<?php echo $crmdetails['c_predisposing_info_6']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_7'][value='<?php echo $crmdetails['c_predisposing_info_7']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_8'][value='<?php echo $crmdetails['c_predisposing_info_8']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_9'][value='<?php echo $crmdetails['c_predisposing_info_9']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_10'][value='<?php echo $crmdetails['c_predisposing_info_10']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_11'][value='<?php echo $crmdetails['c_predisposing_info_11']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_12'][value='<?php echo $crmdetails['c_predisposing_info_12']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_13'][value='<?php echo $crmdetails['c_predisposing_info_13']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_14'][value='<?php echo $crmdetails['c_predisposing_info_14']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_15'][value='<?php echo $crmdetails['c_predisposing_info_15']; ?>']").prop("checked",true);
$("input[name='c_predisposing_info_16'][value='<?php echo $crmdetails['c_predisposing_info_16']; ?>']").prop("checked",true);
$("input[name='c_clinical_testing_1'][value='<?php echo $crmdetails['c_clinical_testing_1']; ?>']").prop("checked",true);
$("input[name='c_clinical_testing_1_info'][value='<?php echo $crmdetails['c_clinical_testing_1_info']; ?>']").prop("checked",true);
$("input[name='c_clinical_testing_2'][value='<?php echo $crmdetails['c_clinical_testing_2']; ?>']").prop("checked",true);
$("input[name='c_clinical_testing_2_info'][value='<?php echo $crmdetails['c_clinical_testing_2_info']; ?>']").prop("checked",true);
$("input[name='c_clinical_testing_3_info'][value='<?php echo $crmdetails['c_clinical_testing_3_info']; ?>']").prop("checked",true);
$("input[name='c_hospitalization_1'][value='<?php echo $crmdetails['c_hospitalization_1']; ?>']").prop("checked",true);
$("input[name='c_hospitalization_2'][value='<?php echo $crmdetails['c_hospitalization_2']; ?>']").prop("checked",true);
$("input[name='c_hospitalization_3'][value='<?php echo $crmdetails['c_hospitalization_3']; ?>']").prop("checked",true);
$("input[name='c_hospitalization_4'][value='<?php echo $crmdetails['c_hospitalization_4']; ?>']").prop("checked",true);
$("input[name='c_hospitalization_5'][value='<?php echo $crmdetails['c_hospitalization_5']; ?>']").prop("checked",true);

if('<?php echo $crmdetails['c_derived']; ?>' == 1){ $("input[name='c_derived']").prop("checked",true); }

$('input[name="c_clinical_info_20_first[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['c_clinical_info_20_first']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});
$('input[name="c_clinical_info_20_pregnancy[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['c_clinical_info_20_pregnancy']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});
$('input[name="c_clinical_info_11_diagnosis[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['c_clinical_info_11_diagnosis']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});
$('input[name="c_clinical_info_12_diagnosis[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['c_clinical_info_12_diagnosis']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});


var Checkbox_1 = 'c_clinical_info_20_first[]';
var Checkbox_in_1 = $('input[name="'+Checkbox_1+'"]');
var Checkbox_cc_1 = $('input[name="'+Checkbox_1+'"]:checkbox[required]');
Checkbox_cc_1.change(function(){ checkCheckbox(Checkbox_cc_1); });
checkCheckbox(Checkbox_in_1);

var Checkbox_2 = 'c_clinical_info_20_pregnancy[]';
var Checkbox_in_2 = $('input[name="'+Checkbox_2+'"]');
var Checkbox_cc_2 = $('input[name="'+Checkbox_2+'"]:checkbox[required]');
Checkbox_cc_2.change(function(){ checkCheckbox(Checkbox_cc_2); });
checkCheckbox(Checkbox_in_2);

var Checkbox_3 = 'c_clinical_info_11_diagnosis[]';
var Checkbox_in_3 = $('input[name="'+Checkbox_3+'"]');
var Checkbox_cc_3 = $('input[name="'+Checkbox_3+'"]:checkbox[required]');
Checkbox_cc_3.change(function(){ checkCheckbox(Checkbox_cc_3); });
checkCheckbox(Checkbox_in_3);

var Checkbox_4 = 'c_clinical_info_12_diagnosis[]';
var Checkbox_in_4 = $('input[name="'+Checkbox_4+'"]');
var Checkbox_cc_4 = $('input[name="'+Checkbox_4+'"]:checkbox[required]');
Checkbox_cc_4.change(function(){ checkCheckbox(Checkbox_cc_4); });
checkCheckbox(Checkbox_in_4);


//======== VALIDATIONS
c_complainant_ill_validator($("input[name='c_complainant_ill']:checked"));
function c_complainant_ill_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$("input[name='c_symptom_onset']").attr('required', 'required');
		$("input[name='c_illness_duration']").attr('required', 'required');
		$("input[name='c_diagnosis_date']").attr('required', 'required');
		$("input[name='c_illness_duration_type']").attr('required', 'required');
	} else {
		$("input[name='c_symptom_onset']").removeAttr('required');
		$("input[name='c_illness_duration']").removeAttr('required');
		$("input[name='c_diagnosis_date']").removeAttr('required');
		$("input[name='c_illness_duration_type']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
	}
}



c_clinical_testing_1_info_validator($("input[name='c_clinical_testing_1_info']:checked"));
function c_clinical_testing_1_info_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'NOTDONE'){
		$(eput).closest('.row').next('.ioptions').hide();
		$("input[name='c_clinical_testing_1_date']").removeAttr('required');
	} else {
		$("input[name='c_clinical_testing_1_date']").attr('required', 'required');
		$(eput).closest('.row').next('.ioptions').show();
	}
}

c_clinical_testing_2_info_validator($("input[name='c_clinical_testing_2_info']:checked"));
function c_clinical_testing_2_info_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'NOTDONE'){
		$(eput).closest('.row').next('.ioptions').hide();
		$("input[name='c_clinical_testing_2_date']").removeAttr('required');
	} else {
		$("input[name='c_clinical_testing_2_date']").attr('required', 'required');
		$(eput).closest('.row').next('.ioptions').show();
	}
}

c_clinical_testing_3_info_validator($("input[name='c_clinical_testing_3_info']:checked"));
function c_clinical_testing_3_info_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'NOTDONE'){
		$(eput).closest('.row').next('.ioptions').hide();
		$("input[name='c_clinical_testing_3_date']").removeAttr('required');
	} else {
		$("input[name='c_clinical_testing_3_date']").attr('required', 'required');
		$(eput).closest('.row').next('.ioptions').show();
	}
}




c_clinincal_info_1_temp_validator($("input[name='c_clinincal_info_1_temp']:checked"));
function c_clinincal_info_1_temp_validator(eput){
	checkValue = $(eput).val();
	optionNames = '#c_clinincal_info_1_hightemp';
	if(checkValue == 'Y'){ 
		$(optionNames).prop('required',true);
		$(eput).closest('.row').find('.ioptions').show();
	} else {
		$(optionNames).prop('required',false);		
		$(eput).closest('.row').find('.ioptions').hide();
	}
}

c_clinincal_info_8_temp_validator($("input[name='c_clinical_info_8']:checked"));
function c_clinincal_info_8_temp_validator(eput){
	checkValue = $(eput).val();
	optionNames = '#c_clinical_info_8_onset';
	if(checkValue == 'Y'){ 
		$(optionNames).prop('required',true);
		$(eput).closest('.row').find('.ioptions').show();
	} else {
		$(optionNames).prop('required',false);		
		$(eput).closest('.row').find('.ioptions').hide();
	}
}

c_clinincal_info_9_temp_validator($("input[name='c_clinical_info_9']:checked"));
function c_clinincal_info_9_temp_validator(eput){
	checkValue = $(eput).val();
	optionNames = '#c_clinical_info_9_onset';
	if(checkValue == 'Y'){ 
		$(optionNames).prop('required',true);
		$(eput).closest('.row').find('.ioptions').show();
	} else {
		$(optionNames).prop('required',false);		
		$(eput).closest('.row').find('.ioptions').hide();
	}
}

c_clinincal_info_11_temp_validator($("input[name='c_clinical_info_11']:checked"));
function c_clinincal_info_11_temp_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		checkCheckbox($("input[name='c_clinical_info_11_diagnosis[]']:checked[required]"));
		$("input[name='c_clinical_info_11_result']").attr('required', 'required');
	} else {
		$("input[name='c_clinical_info_11_diagnosis[]']").removeAttr('required');
		$("input[name='c_clinical_info_11_result']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
	}
}

c_clinincal_info_12_temp_validator($("input[name='c_clinical_info_12']:checked"));
function c_clinincal_info_12_temp_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		checkCheckbox($("input[name='c_clinical_info_12_diagnosis[]']:checked[required]"));
	} else {
		$("input[name='c_clinical_info_12_diagnosis[]']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
	}
}

c_clinincal_info_19_temp_validator($("input[name='c_clinical_info_19']:checked"));
function c_clinincal_info_19_temp_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$("input[name='c_clinical_info_19_other']").attr('required', 'required');
	} else {
		$("input[name='c_clinical_info_19_other']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
	}
}

c_predisposing_info_5_validator($("input[name='c_predisposing_info_5']:checked"));
function c_predisposing_info_5_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$("input[name='c_predisposing_info_5_specify']").attr('required', 'required');
	} else {
		$("input[name='c_predisposing_info_5_specify']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
	}
}


c_predisposing_info_7_validator($("input[name='c_predisposing_info_7']:checked"));
function c_predisposing_info_7_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$("input[name='c_predisposing_info_7_specify']").attr('required', 'required');
	} else {
		$("input[name='c_predisposing_info_7_specify']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
	}
}

c_predisposing_info_16_temp_validator($("input[name='c_predisposing_info_16']:checked"));
function c_predisposing_info_16_temp_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$("input[name='c_predisposing_info_16_others']").attr('required', 'required');
	} else {
		$("input[name='c_predisposing_info_16_others']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
	}
}

c_clinical_testing_1_validator($("input[name='c_clinical_testing_1']:checked"));
function c_clinical_testing_1_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$("input[name='c_clinical_testing_1_info']").attr('required', 'required');
		$("input[name='c_clinical_testing_1_date']").attr('required', 'required');
	} else {
		$("input[name='c_clinical_testing_1_date']").removeAttr('required');
		$("input[name='c_clinical_testing_1_info']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
	}
}


c_clinical_testing_2_validator($("input[name='c_clinical_testing_2']:checked"));
function c_clinical_testing_2_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$("input[name='c_clinical_testing_2_info']").attr('required', 'required');
		$("input[name='c_clinical_testing_2_date']").attr('required', 'required');
	} else {
		$("input[name='c_clinical_testing_2_date']").removeAttr('required');
		$("input[name='c_clinical_testing_2_info']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
	}
}

c_hospitalization_1_validator($("input[name='c_hospitalization_1']:checked"));
function c_hospitalization_1_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$("input[name='c_hospitalization_1_info']").attr('required', 'required');
		$("input[name='c_hospitalization_1_admission']").attr('required', 'required');
		$("input[name='c_hospitalization_1_discharge']").attr('required', 'required');
	} else {
		$("input[name='c_hospitalization_1_info']").removeAttr('required');
		$("input[name='c_hospitalization_1_admission']").removeAttr('required');
		$("input[name='c_hospitalization_1_discharge']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
	}
}


c_hospitalization_4_validator($("input[name='c_hospitalization_4_death']:checked"));
function c_hospitalization_4_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$("input[name='c_hospitalization_4_death']").attr('required', 'required');
	} else {
		$("input[name='c_hospitalization_4_death']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
	}
}
<?php } ?>


<?php if($this->uri->segment(4) == 'treatment'){ ?>
//$('#t_treatment_1_info').val('<?php echo $crmdetails['t_treatment_1_info']; ?>');
$('#t_treatment_days').val('<?php echo $crmdetails['t_treatment_days']; ?>');
$('#t_treatment_start_date').val('<?php if(!empty($crmdetails['t_treatment_start_date'])){ echo date('m/d/Y',strtotime($crmdetails['t_treatment_start_date'])); } ?>');
$('#t_treatment_end_date').val('<?php if(!empty($crmdetails['t_treatment_start_date'])){ echo date('m/d/Y',strtotime($crmdetails['t_treatment_end_date'])); } ?>');
//$('#t_treatment_prescribed').val('<?php echo $crmdetails['t_treatment_prescribed']; ?>');
$('#t_treatment_duration').val('<?php echo $crmdetails['t_treatment_duration']; ?>');
$('#t_treatment_indication_other').val('<?php echo $crmdetails['t_treatment_indication_other']; ?>');
$('#t_treatment_2_medication_info').val('<?php echo $crmdetails['t_treatment_2_medication_info']; ?>');
$('#t_treatment_prescribing').val('<?php echo $crmdetails['t_treatment_prescribing']; ?>');

$("input[name='t_treatment_1'][value='<?php echo $crmdetails['t_treatment_1']; ?>']").prop("checked",true);
//$("input[name='t_treatment_prescribed_unit'][value='<?php echo $crmdetails['t_treatment_prescribed_unit']; ?>']").prop("checked",true);
$("input[name='t_treatment_duration_type'][value='<?php echo $crmdetails['t_treatment_duration_type']; ?>']").prop("checked",true);
$("input[name='t_treatment_2_medication'][value='<?php echo $crmdetails['t_treatment_2_medication']; ?>']").prop("checked",true);

$('input[name="t_treatment_1_medication[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['t_treatment_1_medication']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});
$('input[name="t_treatment_indication[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['t_treatment_indication']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});

<?php
$t_dose = 0;
if(!empty($crmdetails['t_treatment_1_info'])){ 
foreach($t_treatment_1_info_ar as $token){
$t_dose++;
?>
$("input[name='t_treatment_prescribed_unit_dose_<?php echo $t_dose; ?>'][value='<?php echo $t_treatment_1_unit_ar[$t_dose-1]; ?>']").prop("checked",true);
<?php } } ?>


var Checkbox_1 = 't_treatment_1_medication[]';
var Checkbox_in_1 = $('input[name="'+Checkbox_1+'"]');
var Checkbox_cc_1 = $('input[name="'+Checkbox_1+'"]:checkbox[required]');
Checkbox_cc_1.change(function(){ checkCheckbox(Checkbox_cc_1); });
checkCheckbox(Checkbox_in_1);

var Checkbox_2 = 't_treatment_indication[]';
var Checkbox_in_2 = $('input[name="'+Checkbox_2+'"]');
var Checkbox_cc_2 = $('input[name="'+Checkbox_2+'"]:checkbox[required]');
Checkbox_cc_2.change(function(){ checkCheckbox(Checkbox_cc_2); });
checkCheckbox(Checkbox_in_2);


t_treatment_2_medication_validator($("input[name='t_treatment_2_medication']:checked"));
function t_treatment_2_medication_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$("input[name='t_treatment_2_medication_info']").removeAttr('required');
		$("input[name='t_treatment_prescribing']").attr('required', 'required');
		$("input[name='t_treatment_2_medication_info']").hide();
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
	} else {
		$("input[name='t_treatment_2_medication_info']").removeAttr('required');
		$("input[name='t_treatment_prescribing']").removeAttr('required');
		$("input[name='t_treatment_2_medication_info']").hide();
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();		
		if(checkValue == 'N'){
			$("input[name='t_treatment_2_medication_info']").attr('required', 'required');
			$("input[name='t_treatment_2_medication_info']").show();
			$(eput).closest('.row').next('.ioptions').hide();	
		}
		
	}
}


t_treatment_1_validator($("input[name='t_treatment_1']:checked"));
function t_treatment_1_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		//$("input[name='t_treatment_1_info']").attr('required', 'required');
		checkCheckbox($("input[name='t_treatment_1_medication[]']:checked[required]"));
		$("input[name='t_treatment_days']").attr('required', 'required');
		$("input[name='t_treatment_start_date']").attr('required', 'required');
		$("input[name='t_treatment_end_date']").attr('required', 'required');
		$("input[name='t_treatment_duration']").attr('required', 'required');
		$("input[name='t_treatment_duration_type']").attr('required', 'required');
		//$("input[name='t_treatment_prescribed']").attr('required', 'required');
		//$("input[name='t_treatment_prescribed_unit']").attr('required', 'required');
		checkCheckbox($("input[name='t_treatment_indication[]']:checked[required]"));
		$("input[name='t_treatment_2_medication']").attr('required','required');
		$("input[name='t_treatment_prescribing']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').show();
	} else {
		//$("input[name='t_treatment_1_info']").removeAttr('required');
		$("input[name='t_treatment_1_medication[]']").removeAttr('required');
		$("input[name='t_treatment_days']").removeAttr('required');
		$("input[name='t_treatment_start_date']").removeAttr('required');
		$("input[name='t_treatment_end_date']").removeAttr('required');
		$("input[name='t_treatment_duration']").removeAttr('required');
		$("input[name='t_treatment_duration_type']").removeAttr('required');
		//$("input[name='t_treatment_prescribed']").removeAttr('required');
		//$("input[name='t_treatment_prescribed_unit']").removeAttr('required');
		$("input[name='t_treatment_indication[]']").removeAttr('required');
		$("input[name='t_treatment_2_medication']").removeAttr('required');
		$("input[name='t_treatment_prescribing']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').hide();		
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').hide();
	}
}


tAddMore = '<?php echo $t_dose>0?$t_dose:'1'; ?>';
$(document).on('click','#t_addMore', function(){
	tAddMore = Number(tAddMore) + 1;
	tableData = $('#medicationPrescribedRow .medicationPrescribedDiv').html();
	$('#medicationPrescribedRow .medicationPrescribedDiv').each(function(){
		$(this).find('.t_removeMore').addClass('hide');
	});
	$('#medicationPrescribedRow').append('<div class="medicationPrescribedDiv">'+tableData.replace("hide", "")+'</div>');
	$('#medicationPrescribedRow .medicationPrescribedDiv:last-child').find("input[type='text']").val('');
	$('#medicationPrescribedRow .medicationPrescribedDiv:last-child').find('.checklist').find('input').attr("name","t_treatment_prescribed_unit_dose_"+tAddMore);
});

$(document).on('click','.t_removeMore', function(){
	tAddMore = Number(tAddMore) - 1;
	$(this).closest('.medicationPrescribedDiv').remove();
	$('#medicationPrescribedRow .medicationPrescribedDiv:last-child').find('.t_removeMore').removeClass('hide');
});

<?php } ?>


<?php if($this->uri->segment(4) == 'notes'){ ?>
$('#case_notes').val('<?php echo $crmdetails['case_notes']; ?>');
$("input[name='case_permission'][value='<?php echo $crmdetails['case_permission']; ?>']").prop("checked",true);
<?php } ?>


<?php if($this->uri->segment(4) == 'exposures'){ ?>
$('#e_date_14').datepicker({ 
dateFormat: 'yy-mm-dd',
onSelect: function() {
    dateChanger();
}
});
function dateChanger(){
	var e_date = $('#e_date_14').val();
	e_currDate = new Date(e_date);
	for(i=13;i>=0;i--)
	{
		e_addDate = e_currDate.getTime() +  (1 * 24 * 60 * 60 * 1000);
		e_currDate = new Date(e_addDate);
		$('#e_date_'+i).val(e_currDate.getFullYear()+'-'+('0' + (e_currDate.getMonth()+1)).slice(-2)+'-'+('0' + e_currDate.getDate()).slice(-2));
	}
}
<?php } ?>



<?php if($this->uri->segment(4) == 'risk'){ ?>
$('#r_patient_1_other').val('<?php echo $crmdetails['r_patient_1_other']; ?>');
$('#r_setting_1_city').val('<?php echo $crmdetails['r_setting_1_city']; ?>');
$('#r_setting_1_country').val('<?php echo $crmdetails['r_setting_1_country']; ?>');
cid = $('#r_setting_1_country').find('option:selected').attr('cid'); get_states_elemental(cid, 'r_setting_1_state', 'set' ,'<?php echo $crmdetails['r_setting_1_state']; ?>');

$('#r_setting_1_start').val('<?php if(!empty($crmdetails['r_setting_1_start'])){ echo date('m/d/Y', strtotime($crmdetails['r_setting_1_start'])); } ?>');
$('#r_setting_1_end').val('<?php if(!empty($crmdetails['r_setting_1_end'])){ echo date('m/d/Y', strtotime($crmdetails['r_setting_1_end'])); } ?>');
$('#r_setting_2_city').val('<?php echo $crmdetails['r_setting_2_city']; ?>');
$('#r_setting_2_country').val('<?php echo $crmdetails['r_setting_2_country']; ?>');
cid = $('#r_setting_2_country').find('option:selected').attr('cid'); get_states_elemental(cid, 'r_setting_2_state', 'set' ,'<?php echo $crmdetails['r_setting_2_state']; ?>');

$('#r_setting_2_start').val('<?php if(!empty($crmdetails['r_setting_2_start'])){ echo date('m/d/Y', strtotime($crmdetails['r_setting_2_start'])); } ?>');
$('#r_setting_2_end').val('<?php if(!empty($crmdetails['r_setting_2_end'])){ echo date('m/d/Y', strtotime($crmdetails['r_setting_2_end'])); } ?>');
$('#r_setting_3_city').val('<?php echo $crmdetails['r_setting_3_city']; ?>');
$('#r_setting_3_country').val('<?php echo $crmdetails['r_setting_3_country']; ?>');
cid = $('#r_setting_3_country').find('option:selected').attr('cid'); get_states_elemental(cid, 'r_setting_3_state', 'set' ,'<?php echo $crmdetails['r_setting_3_state']; ?>');

$('#r_setting_3_start').val('<?php if(!empty($crmdetails['r_setting_3_start'])){ echo date('m/d/Y', strtotime($crmdetails['r_setting_3_start'])); } ?>');
$('#r_setting_3_end').val('<?php if(!empty($crmdetails['r_setting_3_end'])){ echo date('m/d/Y', strtotime($crmdetails['r_setting_3_end'])); } ?>');
$('#r_risk_1_start').val('<?php if(!empty($crmdetails['r_risk_1_start'])){ echo date('m/d/Y', strtotime($crmdetails['r_risk_1_start'])); } ?>');
$('#r_risk_1_end').val('<?php if(!empty($crmdetails['r_risk_1_end'])){ echo date('m/d/Y', strtotime($crmdetails['r_risk_1_end'])); } ?>');
$('#r_risk_2_wdrs').val('<?php echo $crmdetails['r_risk_2_wdrs']; ?>');
$('#r_risk_2_name').val('<?php echo $crmdetails['r_risk_2_name']; ?>');
$('#r_risk_2_dob').val('<?php if(!empty($crmdetails['r_risk_2_dob'])){ echo date('m/d/Y', strtotime($crmdetails['r_risk_2_dob'])); } ?>');
$('#r_risk_3_other').val('<?php echo $crmdetails['r_risk_3_other']; ?>');
$('#r_risk_3_describe').val('<?php echo $crmdetails['r_risk_3_describe']; ?>');

//$('#r_setting_1_state').val('<?php echo $crmdetails['r_setting_1_state']; ?>');
//$('#r_setting_2_state').val('<?php echo $crmdetails['r_setting_2_state']; ?>');
//$('#r_setting_3_state').val('<?php echo $crmdetails['r_setting_3_state']; ?>');

$("input[name='r_risk_1'][value='<?php echo $crmdetails['r_risk_1']; ?>']").prop("checked",true);

$('input[name="r_patient_1[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['r_patient_1']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});
$('input[name="r_setting_1[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['r_setting_1']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});
$('input[name="r_setting_2[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['r_setting_2']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});
$('input[name="r_setting_3[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['r_setting_3']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});
$('input[name="r_risk_3[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['r_risk_3']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});



/*var Checkbox_1 = 'r_patient_1[]';
var Checkbox_in_1 = $('input[name="'+Checkbox_1+'"]');
var Checkbox_cc_1 = $('input[name="'+Checkbox_1+'"]:checkbox[required]');
Checkbox_cc_1.change(function(){ checkCheckbox(Checkbox_cc_1); });
checkCheckbox(Checkbox_in_1);

var Checkbox_2 = 'r_setting_1[]';
var Checkbox_in_2 = $('input[name="'+Checkbox_2+'"]');
var Checkbox_cc_2 = $('input[name="'+Checkbox_2+'"]:checkbox[required]');
Checkbox_cc_2.change(function(){ checkCheckbox(Checkbox_cc_2); });
checkCheckbox(Checkbox_in_2);

var Checkbox_3 = 'r_setting_2[]';
var Checkbox_in_3 = $('input[name="'+Checkbox_3+'"]');
var Checkbox_cc_3 = $('input[name="'+Checkbox_3+'"]:checkbox[required]');
Checkbox_cc_3.change(function(){ checkCheckbox(Checkbox_cc_3); });
checkCheckbox(Checkbox_in_3);

var Checkbox_4 = 'r_setting_3[]';
var Checkbox_in_4 = $('input[name="'+Checkbox_4+'"]');
var Checkbox_cc_4 = $('input[name="'+Checkbox_4+'"]:checkbox[required]');
Checkbox_cc_4.change(function(){ checkCheckbox(Checkbox_cc_4); });
checkCheckbox(Checkbox_in_4);
*/
var Checkbox_5 = 'r_risk_3[]';
var Checkbox_in_5 = $('input[name="'+Checkbox_5+'"]');
var Checkbox_cc_5 = $('input[name="'+Checkbox_5+'"]:checkbox[required]');
Checkbox_cc_5.change(function(){ checkCheckbox(Checkbox_cc_5); });
checkCheckbox(Checkbox_in_5);


r_risk_1_validator($("input[name='r_risk_1']:checked"));
function r_risk_1_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){
		$("input[name='r_risk_1_start']").attr('required', 'required');
		$("input[name='r_risk_1_end']").attr('required', 'required');
		$("input[name='r_risk_2_wdrs']").attr('required', 'required');
		$("input[name='r_risk_2_name']").attr('required', 'required');
		//$("input[name='r_risk_2_dob']").attr('required', 'required');		
		checkCheckbox($("input[name='r_risk_3[]']:checked[required]"));
		//$("input[name='r_risk_3_describe']").attr('required', 'required');
		$(eput).closest('.row').find('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').show();
	} else {
		$("input[name='r_risk_1_start']").removeAttr('required');
		$("input[name='r_risk_1_end']").removeAttr('required');
		$("input[name='r_risk_2_wdrs']").removeAttr('required');
		$("input[name='r_risk_2_name']").removeAttr('required');
		//$("input[name='r_risk_2_dob']").removeAttr('required');
		$("input[name='r_risk_3[]']").removeAttr('required');
		//$("input[name='r_risk_3_describe']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').hide();		
	}
}



// SELECT OPTIONS
$('#r_setting_1_country,#r_setting_2_country,#r_setting_3_country').select2();
$('#r_setting_1_state,#r_setting_2_state,#r_setting_3_state').select2();
//$('#case_city').select2();

$(document).on('change', '#r_setting_1_country', function(){
    cid = $('option:selected',this).attr('cid');
	get_states_elemental(cid, 'r_setting_1_state');
});
$(document).on('change', '#r_setting_2_country', function(){
    cid = $('option:selected',this).attr('cid');
	get_states_elemental(cid, 'r_setting_2_state');
});
$(document).on('change', '#r_setting_3_country', function(){
    cid = $('option:selected',this).attr('cid');
	get_states_elemental(cid, 'r_setting_3_state');
});

$(document).on('change', '#case_state', function(){
    sid = $('option:selected',this).attr('sid');
	//get_cities(sid);
});


//STATES AJAX
function get_states_elemental(cid, element, type='', value='')
{
	sUrl = '<?php echo base_url(); ?>' + 'covid_case/master_states/' + cid + '/data' ;
	$.ajax({
		url: sUrl,
		dataType: 'json',
		success: function(data) {
			htmlOptions = '';
			//htmlOptions += '<option value="">--- Select State -----</option>';
			$.each(data, function(i,token) {
			   htmlOptions += '<option value="' + token.name + '" sid="' + token.id + '">' + token.name + '</option>';
			});
			//alert(htmlOptions);
			$('#'+element).html(htmlOptions);
			if(type=='set'){ $('#'+element).val(value); }
			$('#'+element).select2();
		}
	});
}


<?php } ?>


<?php if($this->uri->segment(4) == 'exposure'){ ?>
$('#e_date_0').datepicker({ 
dateFormat: 'yy-mm-dd',
changeMonth: true, 
changeYear: true, 
yearRange: '1940:' + new Date().getFullYear().toString(),
onSelect: function() {
    dateChanger();
}
});
dateChanger();
function dateChanger(){
	var e_date = $('#e_date_0').val();
	e_currDate = new Date(e_date);
	n = 1;
	for(i=1;i<17;i++)
	{
		//e_addDate = e_currDate.getTime() +  (1 * 24 * 60 * 60 * 1000);
		//e_currDate = new Date(e_addDate);
		e_currDate.setDate(e_currDate.getDate() + n);
		$('#e_date_'+i).val(e_currDate.getFullYear()+'-'+('0' + (e_currDate.getMonth()+1)).slice(-2)+'-'+('0' + e_currDate.getDate()).slice(-2));
	}
}
<?php } ?>



<?php if($this->uri->segment(4) == 'aftercase'){ ?>
$('#af_setting_1_facility').val('<?php echo $crmdetails['af_setting_1_facility']; ?>');
$('#af_setting_2_facility').val('<?php echo $crmdetails['af_setting_2_facility']; ?>');
$('#af_setting_3_facility').val('<?php echo $crmdetails['af_setting_3_facility']; ?>');
$('#af_setting_4_facility').val('<?php echo $crmdetails['af_setting_4_facility']; ?>');
$('#af_setting_4_facility').val('<?php echo $crmdetails['af_setting_4_facility']; ?>');
$('#af_setting_4_facility').val('<?php echo $crmdetails['af_setting_4_facility']; ?>');
$('#af_setting_4_facility').val('<?php echo $crmdetails['af_setting_4_facility']; ?>');
$('#af_setting_1_start').val('<?php if(!empty($crmdetails['af_setting_1_start'])){ echo $crmdetails['af_setting_1_start']; } ?>');
$('#af_setting_3_start').val('<?php if(!empty($crmdetails['af_setting_3_start'])){ echo $crmdetails['af_setting_3_start']; } ?>');
$('#af_setting_2_start').val('<?php if(!empty($crmdetails['af_setting_2_start'])){ echo $crmdetails['af_setting_2_start']; } ?>');
$('#af_setting_4_start').val('<?php if(!empty($crmdetails['af_setting_4_start'])){ echo $crmdetails['af_setting_4_start']; } ?>');
$('#af_setting_1_end').val('<?php if(!empty($crmdetails['af_setting_1_end'])){ echo $crmdetails['af_setting_1_end']; } ?>');
$('#af_setting_3_end').val('<?php if(!empty($crmdetails['af_setting_3_end'])){ echo $crmdetails['af_setting_3_end']; } ?>');
$('#af_setting_2_end').val('<?php if(!empty($crmdetails['af_setting_2_end'])){ echo $crmdetails['af_setting_2_end']; } ?>');
$('#af_setting_4_end').val('<?php if(!empty($crmdetails['af_setting_4_end'])){ echo $crmdetails['af_setting_4_end']; } ?>');

$("input[name='af_1_visited'][value='<?php echo $crmdetails['af_1_visited']; ?>']").prop("checked",true);
$("input[name='af_setting_1_known'][value='<?php echo $crmdetails['af_setting_1_known']; ?>']").prop("checked",true);
$("input[name='af_setting_2_known'][value='<?php echo $crmdetails['af_setting_2_known']; ?>']").prop("checked",true);
$("input[name='af_setting_3_known'][value='<?php echo $crmdetails['af_setting_3_known']; ?>']").prop("checked",true);
$("input[name='af_setting_4_known'][value='<?php echo $crmdetails['af_setting_4_known']; ?>']").prop("checked",true);

$('input[name="af_1[]"]').each(function(){
	checkitems = "<?php echo $crmdetails['af_1']; ?>";
	checkArr = checkitems.split(',');
	if($.inArray($(this).val(), checkArr) != -1){  $(this).prop("checked",true); }
});


var Checkbox_1 = 'af_1[]';
var Checkbox_in_1 = $('input[name="'+Checkbox_1+'"]');
var Checkbox_cc_1 = $('input[name="'+Checkbox_1+'"]:checkbox[required]');
Checkbox_cc_1.change(function(){ checkCheckbox(Checkbox_cc_1); });
checkCheckbox(Checkbox_in_1);

af_1_visited_validator($("input[name='af_1_visited']:checked"));
function af_1_visited_validator(eput){
	checkValue = $(eput).val();
	if(checkValue == 'Y'){	
		//checkCheckbox($("input[name='af_1[]']:checked[required]"));
		$("input[name='af_1[]']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').show();
		//$(eput).closest('.row').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').show();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').show();
	} else {
		$("input[name='af_1[]']").removeAttr('required');
		$(eput).closest('.row').find('.ioptions').hide();
		//$(eput).closest('.row').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').hide();
		$(eput).closest('.row').next('.ioptions').next('.ioptions').next('.ioptions').next('.ioptions').hide();		
	}
}
<?php } ?>



<?php if($this->uri->segment(4) == 'investigation'){ ?>
invIDC = 0;
<?php foreach($crminvestigation as $token){ ?>
invIDC = Number(invIDC) + 1;
$("#inv_info_4_"+invIDC).datepicker({ dateFormat: 'yy-mm-dd' });
<?php } ?>

$('#invTable').on('click','#inv_addMore', function(){
	invIDC = Number(invIDC) + 1;
	tableData = $('#invTable table tbody tr:first-child').html();
	$('#invTable table tbody').append('<tr>'+tableData.replace("hide", "").replace('hasDatepicker', '') +'</tr>');
	$('#invTable').find(".invDate").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#invTable table tbody tr:last-child").children('td').eq(3).find('input').attr("id","inv_info_4_"+invIDC);
	$("#inv_info_4_"+invIDC).datepicker({ dateFormat: 'yy-mm-dd' });
	$('#invTable table tbody tr:last-child').find('textarea').val('');
	$('#invTable table tbody tr:last-child').find('input').val('');
});

$('#invTable').on('click','.inv_removeMore', function(){
	$(this).closest('tr').remove();
});
<?php } ?>


<?php if($this->uri->segment(4) == 'contacts'){ ?>
caIDC = 0;
<?php foreach($crmcontact as $token){ ?>
caIDC = Number(caIDC) + 1;
$("#ca_info_4_"+caIDC).datepicker({ dateFormat: 'yy-mm-dd' });
<?php } ?>

$('#contactTable').on('click','#ca_addMore', function(){
	caIDC = Number(caIDC) + 1;
	tableData = $('#contactTable table tbody tr:first-child').html();
	$('#contactTable table tbody').append('<tr>'+tableData.replace("hide", "").replace('hasDatepicker', '') +'</tr>');
	$("#contactTable table tbody tr:last-child").children('td').eq(3).find('input').attr("id","ca_info_4_"+caIDC);
	$("#ca_info_4_"+caIDC).datepicker({ dateFormat: 'yy-mm-dd' });
	$('#contactTable table tbody tr:last-child').find('textarea').val('');
	$('#contactTable table tbody tr:last-child').find('input').val('');
	
});

$('#contactTable').on('click','.ca_removeMore', function(){
	$(this).closest('tr').remove();
});
<?php } ?>



$('.number-only').keyup(function(e) {
	if(this.value!='-')
	  while(isNaN(this.value))
		this.value = this.value.split('').reverse().join('').replace(/[\D]/i,'')
							   .split('').reverse().join('');
})
.on("cut copy paste",function(e){
	e.preventDefault();
});


function checkCheckbox(requiredCheckboxes){
	if(requiredCheckboxes.is(':checked')) {
		requiredCheckboxes.removeAttr('required');
	} else {
		requiredCheckboxes.attr('required', 'required');
	}
}


$('#case_country').select2();
$('#case_state').select2();
//$('#case_city').select2();

$(document).on('change', '#case_country', function(){
    cid = $('option:selected',this).attr('cid');
	get_states(cid);
});

$(document).on('change', '#case_state', function(){
    sid = $('option:selected',this).attr('sid');
	//get_cities(sid);
});

//STATES AJAX
function get_states(cid)
{
	sUrl = '<?php echo base_url(); ?>' + 'covid_case/master_states/' + cid + '/data' ;
	$.ajax({
		url: sUrl,
		dataType: 'json',
		success: function(data) {
			htmlOptions = '';
			//htmlOptions += '<option value="">--- Select State -----</option>';
			$.each(data, function(i,token) {
			   htmlOptions += '<option value="' + token.name + '" sid="' + token.id + '">' + token.name + '</option>';
			});
			//alert(htmlOptions);
			$('#case_state').html(htmlOptions);
			$('#case_state').select2();
		}
	});
}

//CITIES AJAX
function get_cities(sid)
{
	sUrl = '<?php echo base_url(); ?>' + 'covid_case/master_cities/' + sid + '/data' ;
	console.log(sUrl);
	$.ajax({
		url: sUrl,
		dataType: 'json',
		success: function(data) {
			htmlOptions = '<label for="case">Select City : **</label><select class="form-control" id="case_city" name="case_city" required>'; i = 0;
			//htmlOptions += '<option value="">--- Select State -----</option>';
			$.each(data, function(i,token) {
			   i++;
			   htmlOptions += '<option value="' + token.name + '" ctid="' + token.id + '">' + token.name + '</option>';
			});
			htmlOptions += '</select>';
			//alert(htmlOptions);
			if(i < 1){ htmlOptions = '<label for="case">Select City : **</label><input class="form-control" name="case_city" id="case_city">'; $('#htmlCity').html(htmlOptions); }
			else {
			$('#htmlCity').html(htmlOptions);
			$('#case_city').select2();
			}
		}
	});
}


</script>