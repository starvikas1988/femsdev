<script>
$('#cl_disposition').closest('div .col-md-6').hide();

// STOPWATCH TIMER
startDateTimer = new Date();
startTimer();
function startTimer(){
	var total_seconds = (new Date() - startDateTimer) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timeWatch").html(result);
	$("#time_interval").val(result);
	setTimeout(function(){startTimer()}, 1000);
}

// DATEPICKER
$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });


// CASE DETAILS
<?php if($urlSection == 'case'){ ?>
$('#p_is_incident').val('<?php echo $crmdetails['p_is_incident']; ?>');
$('#p_type_of_case').val('<?php echo $crmdetails['p_type_of_case']; ?>');
$('#p_is_diagonised').val('<?php echo $crmdetails['p_is_diagonised']; ?>');
<?php } ?>


<?php if($urlSection == 'exposure'){ ?>
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
	var e_date = $('#e_date_0').val() + ' 00:00:00';
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


<?php if($urlSection == 'final'){ ?>
$('#f_individuals').val('<?php echo $crmdetails['f_individuals']; ?>');
$('#f_other_individual').val('<?php echo $crmdetails['f_other_individual']; ?>');
$('#f_is_positive_working').val('<?php echo $crmdetails['f_is_positive_working']; ?>');
$('#f_is_third_party').val('<?php echo $crmdetails['f_is_third_party']; ?>');
<?php } ?>


<?php if($urlSection == 'condition'){ ?>

<?php if(!empty($crmdetails['s_symptoms'])){ ?>
$('#s_symptoms').val(['<?php echo implode("','", explode(',', $crmdetails['s_symptoms'])); ?>']);
<?php } ?>
$('#s_symptoms').select2();
$('#s_exposure_event').val('<?php echo $crmdetails['s_exposure_event']; ?>');

//$('#s_is_face_covered').val('<?php echo $crmdetails['s_is_face_covered']; ?>');
//$('#s_is_social_distance').val('<?php echo $crmdetails['s_is_social_distance']; ?>');
//$('#s_is_high_cleaning').val('<?php echo $crmdetails['s_is_high_cleaning']; ?>');
//$('#s_is_daily_certification').val('<?php echo $crmdetails['s_is_daily_certification']; ?>');
//$('#s_is_thermometer').val('<?php echo $crmdetails['s_is_thermometer']; ?>');

$('#s_is_symptom').val('<?php echo $crmdetails['s_is_symptom']; ?>');
$('#s_protocol_followed').val('<?php echo $crmdetails['s_protocol_followed']; ?>');
$('#s_cleaning').val('<?php echo $crmdetails['s_cleaning']; ?>');
$('#s_any_contact').val('<?php echo $crmdetails['s_any_contact']; ?>');
$('#s_work_status').val('<?php echo $crmdetails['s_work_status']; ?>');
$('#s_feeling').val('<?php echo $crmdetails['s_feeling']; ?>');
$('#s_department').val('<?php echo $crmdetails['s_department']; ?>');
$('#s_shift').val('<?php echo $crmdetails['s_shift']; ?>');
$('#s_reside').val('<?php echo $crmdetails['s_reside']; ?>');
<?php } ?>

</script>